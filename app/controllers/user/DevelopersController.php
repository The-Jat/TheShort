<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com)
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */

namespace User;

use Core\Request;
use Core\Response;
use Core\DB;
use Core\Helper;
use Core\Auth;
use Core\View;

class Developers {
    /**
     * User
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     */
    public function __construct(){
        $user = Auth::user();
        if(!config('api') || !$user->has('api') || !$user->teamPermission('api.create')) stop(404);
    }
    
    /**
     * API Keys Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @return void
     */
    public function keys(){
        
        $user = Auth::user();

        $keys = DB::apikeys()->where('userid', $user->id)->orderByDesc('created_at')->find();

        $maskedkey = substr($user->api, 0, 8).str_repeat('*', 6).substr($user->api, -4);

        $apiConfig = appConfig('api');
        $endpoints = [];
        
        $endpoints['all'] = e('All');
        
        foreach($apiConfig as $id => $array){
            if($array['admin']) continue;
            $endpoints[$id] = $array['title'];
        }

        foreach($keys as $id => $key){
            $permissions = json_decode($key->permissions);
            $values = [];
    
            foreach ($permissions as $permission) {
                if (isset($endpoints[$permission])) {
                    $values[] = $endpoints[$permission];
                }
            }
            $keys[$id]->permissions = implode(',', $values);
        }

        View::set('title', e('API Keys'));

        return View::with('user.developers', compact('keys', 'user', 'maskedkey', 'endpoints'))->extend('layouts.dashboard');
    }

    /**
     * Create API Key
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function keyCreate(Request $request){
        
        $user = Auth::user();

        $keys = DB::apikeys()->where('userid', $user->id)->count();

        if($keys == 10) return back()->with('danger', e('You have reach the maximum limit for number of API keys allowed.'));
        
        $exists = false;
        
        do {
            $key = md5(Helper::rand(32).time().$user->id);
            $exists = DB::apikeys()->where('apikey', $key)->first();
        } while ($exists);

        $apiConfig = appConfig('api');

        $endpoints = [];
        
        $endpoints['all'] = e('All');
        
        foreach($apiConfig as $id => $array){
            if($array['admin']) continue;
            $endpoints[$id] = $array['title'];
        }

        if(in_array('all', $request->permissions)){
            $request->permissions = ['all'];
        }else {
            foreach($request->permissions as $id => $permission){
                if(!in_array($permission, $endpoints)) unset($request->permissions[$id]);
            }
        }

        $api = DB::apikeys()->create();
        $api->apikey = $key;
        $api->userid = $user->id;
        $api->description = Helper::truncate(clean($request->description), 191);
        $api->permissions = json_encode($request->permissions);
        $api->created_at = Helper::dtime();
        $api->save();

        return back()->with('success', e('API key has been created successfully.'));
    }

    /**
     * Revoke Key
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function keyRevoke(Request $request, int $id, string $nonce){

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'apikey.delete.'.$id)){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if($key = DB::apikeys()->where('id', $id)->where('userid', Auth::user()->id)->first()){
            $key->delete();
            return back()->with('success', e('API key has been revoked successfully.'));
        }
        return back()->with('danger', e('API key is invalid.'));
    }
}