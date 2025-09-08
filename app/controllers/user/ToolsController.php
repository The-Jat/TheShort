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

namespace User;

use \Core\Helper;
use \Core\View;
use \Core\DB;
use \Core\Auth;
use \Core\Request;

class Tools {
    /**
     * Tools
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.6.3
     * @return void
     */
    public function index(){
        
        View::set('title', e('Tools'));    

        return View::with('user.tools')->extend('layouts.dashboard');
    }    
    /**
     * Add to slack
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function slack(Request $request){

        $user = Auth::user();

        $slack = new \Helpers\Slack(config('slackclientid'), config('slacksecretid'), route('user.slack'));

        if($error = $slack->error()){
            return Helper::redirect()->to(route("integrations", ['slack']))->with("danger", $error);
        }    

        if($response = $slack->process()){
            $user->slackid = $response[0];
            $user->slackteamid = $response[1];
            $user->save();
            return Helper::redirect()->to(route("integrations", ['slack']))->with("success", e("The application has been installed on your Slack account. You can now use the command to shorten links directly from your conversations."));
        }

        if(empty($user->slackid)){
            return $slack->redirect();
        }

        return Helper::redirect()->to(route("integrations", ['slack']))->with("danger", e("An error occurred and slack has not been installed.")); 
    }    
    /**
     * Zapier
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function zapier(Request $request){

        $user = Auth::user();

        $user->zapurl = clean($request->zapurl);

        $user->zapview = clean($request->zapview);

        $user->save();

        return Helper::redirect()->to(route("integrations", ['zapier']))->with("success", e("Your Zapier URL has been updated."));        
    }
}