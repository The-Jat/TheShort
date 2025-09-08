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


use Core\Request;
use Core\Auth;
use Core\Helper;
use Core\DB;
use Core\View;
use Helpers\CDN;

class OAuth {
    
    /**
     * List OAuth Clients
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @return void
    */
    public function index() {

        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view OAuth settings.'));
        }

        View::set('title', 'OAuth Applications');

        CDN::load('clipboard');

        $clients = DB::oauth_clients()->orderByDesc('created_at')->paginate(15);

        return View::with('admin.oauth.index', compact('clients'))->extend('admin.layouts.main');
    }

    /**
     * Create OAuth Client
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @return void
    */
    public function create(Request $request) {

        if($request->isPost()) {
            
            if(!$request->name || !$request->redirect_uri) {
                return back()->with('danger', 'Please fill all required fields');
            }

            $client = DB::oauth_clients()->create();
            $client->user_id = Auth::user()->id;
            $client->name = clean($request->name);
            $client->client_id = Helper::rand(32);
            $client->client_secret = Helper::rand(64);
            $client->redirect_uri = clean($request->redirect_uri);
            $client->created_at = Helper::dtime();
            $client->save();

            return Helper::redirect()->to(route('admin.oauth'))->with('success', e('Application has been created successfully.'));
        }

        View::set('title', 'Create OAuth Application');
        
        return View::with('admin.oauth.create')->extend('admin.layouts.main');
    }

    /**
     * Delete OAuth Client
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @return void
    */
    public function delete(Request $request, int $id) {

        if(!$client = DB::oauth_clients()->where('id', $id)->first()) {
            return back()->with('danger', 'Application not found.');
        }

        $client->delete();
        
        return back()->with('success', e('Application has been deleted successfully.'));
    }

    /**
     * List OAuth Tokens for Client
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param integer $id
     * @return void
     */
    public function list(int $id){
        
        if(!$client = DB::oauth_clients()->where('id', $id)->first()){
            return Helper::redirect()->to(route('admin.oauth'))->with('danger', e('Client not found.'));
        }

        $tokens = DB::oauth_access_tokens()->where('client_id', $id)
                                         ->orderByDesc('created_at')
                                         ->paginate(15);

        View::set('title', e('OAuth Tokens for {name}', null, ['name' => $client->name]));

        return View::with('admin.oauth.list', compact('tokens', 'client'))->extend('admin.layouts.main');
    }

    /**
     * Delete OAuth Token
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param integer $id
     * @return void
     */
    public function deleteToken(Request $request, int $id){

        if(!$token = DB::oauth_access_tokens()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Token not found.'));
        }

        $token->delete();

        return Helper::redirect()->back()->with('success', e('Token has been deleted.'));
    }
}