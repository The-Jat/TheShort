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
Use Helpers\CDN;
use Models\User;

class Bio {
    
    use \Traits\Links;

    /**
     * Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public function index(Request $request){

        if(!user()->hasRolePermission('bio.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view bio pages.'));
        }

        $query = DB::profiles();

        $q = null;
        
        if($request->sort == "old") $query->orderByAsc('created_at');
        if(!$request->sort) $query->orderByDesc('created_at');

        if($request->userid){
            $query->where('userid', (int) $request->userid);
        }

        if($request->q){
            $q = clean($request->q);
            $query->whereAnyIs([
                ['alias' => "%{$q}%"],
                ['name' => "%{$q}%"],
            ], 'LIKE ');
        }

        $bios = [];
        foreach($query->paginate(is_numeric($request->perpage) ? $request->perpage : 15) as $bio){
            $bio->user = User::first($bio->userid);
            $bio->url = DB::url()->first($bio->urlid);
            if(!$bio->user || !$bio->url) continue;
            $bios[] = $bio;
        }

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        View::set('title', e('Bio Pages'));

        return View::with('admin.bio', compact('bios', 'q'))->extend('admin.layouts.main');
    }

     /**
     * Delete Profile
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    public function delete(int $id, string $nonce){

        if(!user()->hasRolePermission('bio.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete bio pages.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'bio.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$bio = DB::profiles()->where('id', $id)->first()){
            return back()->with('danger', e('Profile does not exist.'));
        }

        $bio->delete();

        if($url = DB::url()->where('profileid', $id)->first()){
            $this->deleteLink($url->id);
        }
        return back()->with('success', e('Profile has been successfully deleted.'));
    }
    /**
     * Toggle
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.4.2
     * @param string $type
     * @param integer $id
     * @return void
     */
    public function toggle(string $type, int $id){
        if(!$bio = DB::profiles()->where('id', $id)->first()){
            return back()->with('danger', e('Profile does not exist.'));
        }

        $type = in_array($type, ['enable', 'disable']) ? $type : 'enable';

        if($url = DB::url()->where('id', $bio->urlid)->first()){
            $url->status = $type == 'enable' ? '1' : '0';
            $url->save();            
        }
        return back()->with('success', e('Bio page status has been updated.'));    
    }
    /**
     * Reassign Bio
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function reassign(Request $request, int $id){

        if(!$request->accept) return back()->with('danger', e('Please check the checkbox to confirm action.'));

        if(!$bio = DB::profiles()->where('id', $id)->first()) return back()->with('danger', e('Bio Page does not exist.'));

        if(!$request->user || !$user = DB::user()->where('id', $request->user)->first()) return back()->with('danger', e('User does not exist.'));

        $bio->userid = $user->id;

        foreach(DB::url()->where('profileid', $bio->id)->find() as $url){
            $url->userid = $user->id;
            $url->save();
            DB::stats()->where('urlid', $url->id)->update(['urluserid' => $user->id]);
        }
        
        DB::tochannels()->where('type', 'bio')->where('itemid', $bio->id)->deleteMany();

        $bio->save();

        return back()->with('success', e('Bio Page has been reassigned to {u}.', null, ['u' => $user->email]));
    }
}