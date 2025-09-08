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

class Notifications {
    /**
     * Notifications
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(Request $request){        
        
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view notifications.'));
        }

        View::set('title', e('Notifications'));
        
        $notifications = [];
        
        foreach(DB::appevents()->where('type', 'notification')->orderByDesc('id')->paginate(15) as $notification){
            $notification->data = json_decode($notification->data);
            $notification->data->target = '';
            if($notification->userid){
                $notification->data->target = 'User ID: ';
                $notification->data->target .= $notification->userid.' - ';
            }else {
                $notification->data->target .= 'All users';
            }

            $notification->data->target = trim($notification->data->target, ' - ');
            $notification->data->target .= '<br>';

            if($notification->planid){
                $notification->data->target = 'Plan ID: ';
                $notification->data->target .= $notification->planid.' - ';
            }else {
                $notification->data->target .= 'All plans';
            }
            $notification->data->target = trim($notification->data->target, ' - ');
            $notifications[] = $notification;
        }
        
        return View::with('admin.notifications.index', compact('notifications'))->extend('admin.layouts.main');
    }
    /**
     * Add Notification
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function new(Request $request){
        
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view notifications.'));
        }

        View::set('title', e('New Notification'));

        \Helpers\CDN::load('simpleeditor');
        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();  

        View::push("<script>
                        $('#content').summernote({
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline', 'clear', 'link']],
                              ],
                              height: 100                            
                        });                        
                    </script>", "custom")->toFooter();   
        CDN::load('datetimepicker');

        $plans = DB::plans()->select('id')->select('name')->select('free')->orderByAsc('id')->findMany();

        return View::with('admin.notifications.new', compact('plans'))->extend('admin.layouts.main');
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
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit notifications.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $request->save('title', clean($request->title));
        $request->save('content', clean($request->content));
        $request->save('users', clean($request->users));
        $request->save('plans', clean($request->plans));
        
        if(!$request->title) return Helper::redirect()->back()->with('danger', e('The title is required.'));
        if(!$request->content) return Helper::redirect()->back()->with('danger', e('The content is required.'));
        
        if($request->user && is_array($request->user) && in_array('all', $request->user)){

            if($request->plan && is_array($request->plan)){
                if(in_array('all', $request->plan)){
                    $notification = DB::appevents()->create();                    
                    $notification->type = 'notification';
                    $notification->data = json_encode(['title' => Helper::clean($request->title, 3, true), 'content' => $request->content]);
                    $notification->userid = null;
                    $notification->planid = null;
                    $notification->created_at = Helper::dtime();
                    $notification->expires_at = strtotime($request->expiry) ? date('Y-m-d H:i:s', strtotime($request->expiry)) : null;
                    $notification->save();
                } else {
                    foreach($request->plan as $plan){
                        $notification = DB::appevents()->create();                        
                        $notification->type = 'notification';
                        $notification->data = json_encode(['title' => Helper::clean($request->title, 3, true), 'content' => $request->content]);
                        $notification->userid = null;
                        $notification->planid = $plan;
                        $notification->created_at = Helper::dtime();
                        $notification->expires_at = strtotime($request->expiry) ? date('Y-m-d H:i:s', strtotime($request->expiry)) : null;
                        $notification->save();
                    }
                }
            }

        } else {
            foreach($request->user as $user){
                $notification = DB::appevents()->create();                
                $notification->type = 'notification';
                $notification->data = json_encode(['title' => Helper::clean($request->title, 3, true), 'content' => $request->content]);
                $notification->userid = $user;
                $notification->planid = null;
                $notification->created_at = Helper::dtime();
                $notification->expires_at = strtotime($request->expiry) ? date('Y-m-d H:i:s', strtotime($request->expiry)) : null;
                $notification->save();
            }
        }

        $request->clear();
        return Helper::redirect()->to(route('admin.notifications'))->with('success', e('Notifications have been sent to selected users/plans.'));
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
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete notifications.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'notification.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$notification = DB::appevents()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Notification not found. Please try again.'));
        }
        
        $notification->delete();
        return Helper::redirect()->back()->with('success', e('Notification has been deleted.'));
    }
}