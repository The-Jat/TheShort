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

class Domains {
    /**
     * Domains
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(Request $request){        
        
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view domains.'));
        }

        View::set('title', e('Domain Manager'));

        $domains = [];
        
        $query = DB::domains();

        if($request->userid && \is_numeric($request->userid)) {
            $query->where('userid', $request->userid);
            View::set('title', e('Domains for user'));
        }

        foreach($query->orderByDesc('id')->paginate(15) as $domain){
            if($user = DB::user()->where('id', $domain->userid)->first()){
                if(_STATE == "DEMO") $user->email="Hidden in demo to protect privacy";
                $domain->user = $user->email;
            }
            $domains[] = $domain;
        }
        

        return View::with('admin.domains.index', compact('domains'))->extend('admin.layouts.main');
    }
    /**
     * Add Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function new(){
        
        View::set('title', e('New Domain'));

        return View::with('admin.domains.new')->extend('admin.layouts.main');
    }
    /**
     * Save domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit domains.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $request->save('domain', clean($request->domain));
        $request->save('root', clean($request->root));
        $request->save('root404', clean($request->root404));
        
        if(!$request->domain) return Helper::redirect()->back()->with('danger', e('The domain name is required.'));
        
        $domain = DB::domains()->create();
        $domain->domain = Helper::clean($request->domain, 3, true);
        $domain->redirect = Helper::clean($request->root, 3);
        $domain->redirect404 = Helper::clean($request->root404, 3);
        $domain->status = $request->status;
        $domain->userid = $request->user;

        $domain->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.domains'))->with('success', e('Domain has been added successfully'));
    }
    /**
     * Edit Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        
        if(!$domain = DB::domains()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Domain does not exist.'));

        $user = DB::user()->where('id', $domain->userid)->first();

        return View::with('admin.domains.edit', compact('domain', 'user'))->extend('admin.layouts.main');
    }
    /**
     * Update Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit domains.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$domain = DB::domains()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Domain does not exist.'));
        
        if(!$request->domain) return Helper::redirect()->back()->with('danger', e('The domain name is required.'));
        
        $domain->domain = Helper::clean($request->domain, 3, true);
        $domain->redirect = Helper::clean($request->root, 3);
        $domain->redirect404 = Helper::clean($request->root404, 3);
        $domain->status = $request->status;
        $domain->userid = $request->user;

        $domain->save();

        return Helper::redirect()->back()->with('success', e('Domain has been updated successfully.'));
    }
    /**
     * Delete Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete domains.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'domain.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$domain = DB::domains()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }
        
        DB::url()->where("domain", $domain->domain)->update(['domain' => '']);
        $domain->delete();
        return Helper::redirect()->back()->with('success', e('Domain has been deleted.'));
    }
    /**
     * Disable Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function disable(int $id){
        if(!$domain = DB::domains()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }

        $domain->status = '0';
        $domain->save();
        return Helper::redirect()->back()->with('success', e('Domain has been disabled.'));
    }
    /**
     * Activate Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function activate(int $id){
        if(!$domain = DB::domains()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }

        $domain->status = '1';
        $domain->save();
        return Helper::redirect()->back()->with('success', e('Domain has been activated.'));
    }
     /**
     * Set to pending
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function pending(int $id){
        if(!$domain = DB::domains()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }

        $domain->status = '2';
        $domain->save();
        return Helper::redirect()->back()->with('success', e('Domain has been set to pending.'));
    }
}