<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact GemPixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com) 
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */

namespace Admin;

use Core\DB;
use Core\View;
use Core\Request;
use Core\Helper;
use Core\Response;
use Core\Auth;
Use Helpers\CDN;

class BioTemplates {
    
    /**
     * List Templates
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.7
     * @return void
     */
    public function index(Request $request){

        if(!user()->hasRolePermission('bio.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view bio templates.'));
        }

        $query = DB::biotemplates();

        if($request->q){
            $query->whereLike('name', '%'.clean($request->q).'%');
        }

        $templates = [];
        foreach($query->orderByDesc('id')->paginate(15) as $template){
            $template->planids = json_decode($template->planids ?? '[]', true);
            $template->profile = DB::profiles()->first($template->profileid);
            if($template->profile){
                $template->profile->data = json_decode($template->profile->data ?? '');
            }
            $templates[] = $template;
        }

        View::set('title', e('Bio Templates'));

        return View::with('admin.biotemplates.index', compact('templates'))->extend('admin.layouts.main');
    }

    /**
     * New Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.7
     * @return void
     */
    public function new(Request $request){

        if(!user()->hasRolePermission('bio.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create bio templates.'));
        }

        $profiles = [];
        foreach(DB::profiles()->where('userid', Auth::user()->rID())->orderByDesc('created_at')->find() as $profile){
            $profile->data = json_decode($profile->data ?? '');
            $profiles[] = $profile;
        }

        $plans = DB::plans()->where('status', 1)->orderByDesc('id')->find();

        View::set('title', e('New Bio Template'));

        return View::with('admin.biotemplates.new', compact('profiles', 'plans'))->extend('admin.layouts.main');
    }

    /**
     * Save Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.7
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){

        \Gem::addMiddleware('DemoProtect');

        if(!user()->hasRolePermission('bio.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create bio templates.'));
        }

        if(!$request->name) return back()->with('danger', e('Please enter a template name.'));
        if(!$request->profileid) return back()->with('danger', e('Please select a bio page.'));

        $profile = DB::profiles()->where('id', $request->profileid)->where('userid', Auth::user()->rID())->first();
        if(!$profile) return back()->with('danger', e('Bio page does not exist or you do not have permission to use it.'));

        // Get profile data structure
        $profileData = json_decode($profile->data, true);
        
        // Create empty blocks from the original bio page blocks
        $emptyBlocks = [];
        if(isset($profileData['links']) && is_array($profileData['links'])){
            foreach($profileData['links'] as $blockId => $block){
                // Create empty version of the block, keeping only structure
                $emptyBlock = [
                    'type' => $block['type'] ?? 'link',
                    'active' => isset($block['active']) ? $block['active'] : 1
                ];
                
                // Keep structural/configuration fields but clear content fields
                // Fields to potentially keep (configuration): iconmode, buttonstyle, animation, etc.
                // Fields to clear (content): text, link, urlid, image, title, description, etc.
                
                // Keep iconmode if exists (configuration)
                if(isset($block['iconmode'])){
                    $emptyBlock['iconmode'] = $block['iconmode'];
                }
                
                // Keep animation if exists (configuration)
                if(isset($block['animation'])){
                    $emptyBlock['animation'] = $block['animation'];
                }
                
                // Keep buttonstyle if exists (configuration)
                if(isset($block['buttonstyle'])){
                    $emptyBlock['buttonstyle'] = $block['buttonstyle'];
                }
                
                // Keep opennew if exists (configuration)
                if(isset($block['opennew'])){
                    $emptyBlock['opennew'] = $block['opennew'];
                }
                
                // Keep featured if exists (configuration)
                if(isset($block['featured'])){
                    $emptyBlock['featured'] = 0; // Reset featured
                }
                
                // Keep sensitive if exists (configuration)
                if(isset($block['sensitive'])){
                    $emptyBlock['sensitive'] = $block['sensitive'];
                }
                
                // Keep subscribe if exists (configuration)
                if(isset($block['subscribe'])){
                    $emptyBlock['subscribe'] = $block['subscribe'];
                }
                
                // Keep size if exists (for heading, text, etc.)
                if(isset($block['size'])){
                    $emptyBlock['size'] = $block['size'];
                }
                
                // Keep alignment if exists
                if(isset($block['align'])){
                    $emptyBlock['align'] = $block['align'];
                }
                
                // Keep country/language restrictions if exists
                if(isset($block['country'])){
                    $emptyBlock['country'] = $block['country'];
                }
                if(isset($block['language'])){
                    $emptyBlock['language'] = $block['language'];
                }
                
                // Keep schedule if exists
                if(isset($block['schedule'])){
                    $emptyBlock['schedule'] = $block['schedule'];
                }
                
                $emptyBlocks[$blockId] = $emptyBlock;
            }
        }
        
        // Build template data with empty blocks but preserve all style, settings, and other data
        $templateData = $profileData;
        $templateData['links'] = $emptyBlocks;
        
        // Clear any urlid references from blocks (user-specific data)
        foreach($templateData['links'] as $blockId => &$block){
            if(isset($block['urlid'])){
                unset($block['urlid']);
            }
        }

        $template = DB::biotemplates()->create();
        $template->profileid = $profile->id;
        $template->name = clean($request->name);
        $template->description = clean($request->description ?? '');
        $template->data = json_encode($templateData);
        $template->planids = json_encode($request->planids ?? []);

        // Handle preview image upload
        if($preview = $request->file('preview')){
            if(!$preview->mimematch || !in_array($preview->ext, ['jpg', 'jpeg', 'png'])) {
                return back()->with('danger', e('Preview image must be either a PNG or a JPEG.'));
            }
            if($preview->sizekb > 2048) {
                return back()->with('danger', e('Preview image must be less than 2MB.'));
            }
            $template->preview = $preview->name;
            $request->move($preview, appConfig('app.storage')['images']['path']);
        }

        $template->status = 1;
        $template->created_at = Helper::dtime();
        $template->save();

        return Helper::redirect()->to(route('admin.bio.templates'))->with('success', e('Template has been successfully created.'));
    }

    /**
     * Edit Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.7
     * @param integer $id
     * @return void
     */
    public function edit(int $id){

        if(!user()->hasRolePermission('bio.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit bio templates.'));
        }

        if(!$biotemplate = DB::biotemplates()->where('id', $id)->first()){
            return back()->with('danger', e('Template does not exist.'));
        }

        $biotemplate->planids = json_decode($biotemplate->planids ?? '[]', true);
        $biotemplate->profile = DB::profiles()->first($biotemplate->profileid);
        if($biotemplate->profile){
            $biotemplate->profile->data = json_decode($biotemplate->profile->data ?? '');
        }

        $profiles = [];
        foreach(DB::profiles()->where('userid', Auth::user()->rID())->orderByDesc('created_at')->find() as $profile){
            $profile->data = json_decode($profile->data ?? '');
            $profiles[] = $profile;
        }

        $plans = DB::plans()->where('status', 1)->orderByDesc('id')->find();

        View::set('title', e('Edit Bio Template'));

        return View::with('admin.biotemplates.edit', compact('biotemplate', 'profiles', 'plans'))->extend('admin.layouts.main');
    }

    /**
     * Update Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.7
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        \Gem::addMiddleware('DemoProtect');

        if(!user()->hasRolePermission('bio.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit bio templates.'));
        }

        if(!$template = DB::biotemplates()->where('id', $id)->first()){
            return back()->with('danger', e('Template does not exist.'));
        }

        if(!$request->name) return back()->with('danger', e('Please enter a template name.'));

        $template->name = clean($request->name);
        $template->description = clean($request->description ?? '');

        if($request->profileid && $request->profileid != $template->profileid){
            $profile = DB::profiles()->where('id', $request->profileid)->where('userid', Auth::user()->rID())->first();
            if($profile){
                $template->profileid = $profile->id;
                $template->data = $profile->data;
            }
        }

        // Handle preview image upload
        if($preview = $request->file('preview')){
            if(!$preview->mimematch || !in_array($preview->ext, ['jpg', 'jpeg', 'png'])) {
                return back()->with('danger', e('Preview image must be either a PNG or a JPEG.'));
            }
            if($preview->sizekb > 2048) {
                return back()->with('danger', e('Preview image must be less than 2MB.'));
            }
            
            // Delete old preview if exists
            if($template->preview) {
                \Helpers\App::delete(appConfig('app.storage')['images']['path'].'/'.$template->preview);
            }
            
            $template->preview = $preview->name;
            $request->move($preview, appConfig('app.storage')['images']['path']);
        }

        $template->planids = json_encode($request->planids ?? []);
        $template->save();

        return Helper::redirect()->to(route('admin.bio.templates'))->with('success', e('Template has been successfully updated.'));
    }

    /**
     * Delete Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.7
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){

        \Gem::addMiddleware('DemoProtect');

        if(!user()->hasRolePermission('bio.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete bio templates.'));
        }

        if(!Helper::validateNonce($nonce, 'bio.template.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$template = DB::biotemplates()->where('id', $id)->first()){
            return back()->with('danger', e('Template does not exist.'));
        }

        // Delete preview image if exists
        if($template->preview) {
            \Helpers\App::delete(appConfig('app.storage')['images']['path'].'/'.$template->preview);
        }

        $template->delete();

        return back()->with('success', e('Template has been successfully deleted.'));
    }

    /**
     * Toggle Template Status
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.7
     * @param integer $id
     * @return void
     */
    public function toggle(int $id){

        if(!$template = DB::biotemplates()->where('id', $id)->first()){
            return back()->with('danger', e('Template does not exist.'));
        }

        $template->status = $template->status == 1 ? 0 : 1;
        $template->save();

        return back()->with('success', e('Template status has been updated.'));
    }
}
