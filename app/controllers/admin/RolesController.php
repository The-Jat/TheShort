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
Use Helpers\CDN;
Use Models\Role;
Use Models\User;

class Roles {
    /**
     * Check if super admin
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     */
    public function __construct(){
        if(user()->admin != '1'){
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to access this page.'));
        }
    }
    /**
     * Roles Index
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @return void
     */
    public function index(Request $request){

        $roles = [];

        foreach(Role::orderByDesc('created_at')->paginate(15) as $role){
            $role->user_count = $role->getUserCount();
            $roles[] = $role;
        }

        View::set('title', e('Roles & Permissions'));

        return View::with('admin.roles.index', compact('roles'))->extend('admin.layouts.main');
    }

    /**
     * Create New Role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @return void
     */
    public function new(){
        
        $permissions = Role::getAvailablePermissions();

        View::set('title', e('Create Role'));

        return View::with('admin.roles.new', compact('permissions'))->extend('admin.layouts.main');
    }

    /**
     * Save Role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        \Gem::addMiddleware('DemoProtect');

        $request->save('name', clean($request->name));
        $request->save('description', clean($request->description));

        if(!$request->name) return Helper::redirect()->back()->with('danger', e('Role name is required.'));

        if(DB::roles()->where('name', $request->name)->first()) {
            return Helper::redirect()->back()->with('danger', e('A role with this name already exists.'));
        }

        $role = DB::roles()->create();
        $role->name = Helper::clean($request->name);
        $role->description = Helper::clean($request->description);
        $role->permissions = json_encode($request->permissions ?? []);
        $role->created_at = Helper::dtime();
        $role->save();

        $request->clear();
        return Helper::redirect()->to(route('admin.roles'))->with('success', e('Role has been created successfully'));
    }

    /**
     * Edit Role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        
        if(!$role = Role::where('id', $id)->first()) {
            return Helper::redirect()->back()->with('danger', e('Role does not exist.'));
        }

        $permissions = Role::getAvailablePermissions();
        $role->permissions = json_decode($role->permissions, true) ?: [];

        View::set('title', e('Edit Role'));

        return View::with('admin.roles.edit', compact('role', 'permissions'))->extend('admin.layouts.main');
    }

    /**
     * Update Role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        
        \Gem::addMiddleware('DemoProtect');

        if(!$role = DB::roles()->where('id', $id)->first()) {
            return Helper::redirect()->back()->with('danger', e('Role does not exist.'));
        }

        if(!$request->name) return Helper::redirect()->back()->with('danger', e('Role name is required.'));

        if(DB::roles()->where('name', $request->name)->whereNotEqual('id', $role->id)->first()) {
            return Helper::redirect()->back()->with('danger', e('A role with this name already exists.'));
        }

        $role->name = Helper::clean($request->name);
        $role->description = Helper::clean($request->description);
        $role->permissions = json_encode($request->permissions ?? []);
        $role->save();

        return Helper::redirect()->back()->with('success', e('Role has been updated successfully'));
    }

    /**
     * Delete Role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        
        \Gem::addMiddleware('DemoProtect');        

        if(!Helper::validateNonce($nonce, 'role.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if($id == '1') return Helper::redirect()->back()->with('danger', e('Super admin role cannot be deleted.'));

        if(!$role = DB::roles()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Role not found. Please try again.'));
        }

        // Remove role from all users
        DB::user()->where('admin', $id)->update(['admin' => 0]);

        $role->delete();
        return Helper::redirect()->back()->with('success', e('Role has been deleted.'));
    }

    /**
     * Assign Role to Users
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param \Core\Request $request
     * @return void
     */
    public function assign(Request $request){
        
        \Gem::addMiddleware('DemoProtect');

        $userIds = json_decode($request->userids);
        $roleId = $request->roleid;

        if(!$userIds || empty($userIds)) {
            return Helper::redirect()->back()->with('danger', e('No users were selected. Please try again.')); 
        }

        if(!$role = DB::roles()->where('id', $roleId)->first()) {
            return Helper::redirect()->back()->with('danger', e('Role not found. Please try again.')); 
        }

        foreach($userIds as $userId){
            if($user = DB::user()->where('id', $userId)->first()){
                $user->admin = $roleId;
                $user->save();
            }
        }
        
        return Helper::redirect()->back()->with('success', e('Role has been assigned to selected users.'));
    }

    /**
     * Remove Role from Users
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param \Core\Request $request
     * @return void
     */
    public function remove(Request $request){
        
        \Gem::addMiddleware('DemoProtect');

        $userIds = json_decode($request->userids);

        if(!$userIds || empty($userIds)) {
            return Helper::redirect()->back()->with('danger', e('No users were selected. Please try again.')); 
        }

        foreach($userIds as $userId){
            if($user = DB::user()->where('id', $userId)->first()){
                $user->admin = 0;
                $user->save();
            }
        }
        
        return Helper::redirect()->back()->with('success', e('Role has been removed from selected users.'));
    }

    /**
     * View Role Users
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param integer $id
     * @return void
     */
    public function users(int $id){
        
        if(!$role = DB::roles()->where('id', $id)->first()) {
            return Helper::redirect()->back()->with('danger', e('Role does not exist.'));
        }

        $users = [];

        foreach(User::where('admin', $id)->orderByDesc('date')->paginate(15) as $user){
            if(_STATE == "DEMO") $user->email="demo@demo.com";
            if(empty($user->email)) $user->email = ucfirst($user->auth)." User";   

            if($plan = DB::plans()->where('id', $user->planid)->first()){
                $user->planname = $plan->name;
            } else{
                $user->planname = "n\a";
            }

            $users[] = $user; 
        }

        View::set('title', e('Users with Role: {role}', null, ['role' => $role->name]));

        return View::with('admin.roles.users', compact('users', 'role'))->extend('admin.layouts.main');
    }

    /**
     * Role Permissions
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param integer $id
     * @return void
     */
    public function permissions(int $id){
        
        if(!$role = Role::where('id', $id)->first()) {
            return Helper::redirect()->back()->with('danger', e('Role does not exist.'));
        }

        $permissions = Role::getAvailablePermissions();
        $rolePermissions = json_decode($role->permissions, true) ?: [];

        View::set('title', e('Role Permissions: {role}', null, ['role' => $role->name]));

        return View::with('admin.roles.permissions', compact('role', 'permissions', 'rolePermissions'))->extend('admin.layouts.main');
    }
} 