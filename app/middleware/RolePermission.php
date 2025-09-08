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

namespace Middleware;

use Core\Helper;
use Core\Auth;

class RolePermission {
    
    /**
     * Handle Role Permission Check
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param string $permission
     * @return void
     */
    public function handle($permission = null){
        
        if(!Auth::check()) {
            return Helper::redirect()->to(route('login'))->with('danger', e('Please login to continue.'));
        }

        $user = Auth::user();

        // Super admin has all permissions
        if($user->admin) {
            return true;
        }

        // Check if user has role permission
        if($permission && !$user->hasRolePermission($permission)) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to access this page.'));
        }

        return true;
    }
} 