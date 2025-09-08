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

namespace Helpers;

use Core\Auth;

class Permissions {
    
    /**
     * Check if current user has permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param string $permission
     * @return boolean
     */
    public static function can($permission){
        
        if(!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        return $user->hasRolePermission($permission);
    }

    /**
     * Check if current user has any of the given permissions
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param array $permissions
     * @return boolean
     */
    public static function canAny($permissions){
        
        if(!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        
        foreach($permissions as $permission) {
            if($user->hasRolePermission($permission)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if current user has all of the given permissions
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param array $permissions
     * @return boolean
     */
    public static function canAll($permissions){
        
        if(!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        
        foreach($permissions as $permission) {
            if(!$user->hasRolePermission($permission)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get current user's role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @return Models\Role|null
     */
    public static function getRole(){
        
        if(!Auth::check()) {
            return null;
        }

        $user = Auth::user();
        return $user->getRole();
    }

    /**
     * Get current user's role name
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @return string
     */
    public static function getRoleName(){
        
        $role = self::getRole();
        return $role ? $role->name : e('No Role');
    }
} 