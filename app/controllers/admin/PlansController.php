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

class Plans {
    use \Traits\Payments;

    /**
     * All plans
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('plans.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view plans.'));
        }
        
        $plans = DB::plans()->orderByDesc('id')->paginate(15);

        View::set('title', e('Plans'));

        return View::with('admin.plans.index', compact('plans'))->extend('admin.layouts.main');
    }
    /**
     * Add Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.4.4
     * @return void
     */
    public function new(){
        if(!user()->hasRolePermission('plans.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create plans.'));
        }
        View::push(assets('frontend/libs/fontawesome/all.min.css'))->toHeader();
        View::push(assets('frontend/libs/fontawesome-picker/dist/css/fontawesome-iconpicker.min.css'))->toHeader();
        View::push(assets('frontend/libs/fontawesome-picker/dist/js/fontawesome-iconpicker.min.js'), 'script')->toFooter();
        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();    

        View::push("<script>
                        $('input[name=icon]').iconpicker();
                    </script>", "custom")->toFooter();
        
        View::set('title', e('New Plan'));

        return View::with('admin.plans.new')->extend('admin.layouts.main');
    }
    /**
     * Save plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        if(!user()->hasRolePermission('plans.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create plans.'));
        }
        \Gem::addMiddleware('DemoProtect');

        $request->save('name', clean($request->name));
        $request->save('description', $request->description);
        $request->save("numurls", clean($request->numurls));
        $request->save("numclicks", clean($request->numclicks));
        $request->save("retention", clean($request->retention));
        $request->save("icon", clean($request->icon));
        $request->save("custom", clean($request->permission['custom']));
        $request->save("price_monthly", clean($request->price_monthly));
        $request->save("price_yearly", clean($request->price_yearly));
        $request->save("price_lifetime", clean($request->price_lifetime));
        
        $error = '';

        if(!$request->name) {
            $error .= e("Please enter a valid name")."<br>";
        }        

        if($request->trial_days && !is_numeric($request->trial_days)){
            $error .= e("Trial days must be numerical. For example 14.")."<br>";
        }        
        $request->save("trial_days", $request->trial_days);
    
        if($request->numurls == "" || !is_numeric($request->numurls)){
            $error .= e("Please enter a valid number of links.")."<br>";
        }
        if($request->numclicks == "" || !is_numeric($request->numclicks)){
            $error .= e("Please enter a valid number of clicks.")."<br>";
        }
        if($request->retention == "" || !is_numeric($request->retention)){
            $error .= e("Please enter a valid number for retention.")."<br>";
        }

        if($request->free == "0" && (!is_numeric($request->price_monthly) && $request->price_monthly && !is_numeric($request->price_yearly) && !is_numeric($request->price_lifetime))){
            $error .= e("You need to have at least 1 price for the plan.")."<br>";
        }
    
        if($request->permission["splash"]["enabled"] && $request->permission["splash"]["count"] == "") {
            $error .= e("Please enter a number of splash plans allowed. For unlimited use 0.")."<br>";
        }
        $request->save("permission-splash", $request->permission["splash"]["count"]);
    
        if($request->permission["overlay"]["enabled"] && $request->permission["overlay"]["count"] == "") {
            $error .= e("Please enter a number of overlay plans allowed. For unlimited use 0.")."<br>";
        }      
        $request->save("permission-overlay", $request->permission["overlay"]["count"]);

        if($request->permission["pixels"]["enabled"] && $request->permission["pixels"]["count"] == "") {
            $error .= e("Please enter a number of pixels allowed. For unlimited use 0.")."<br>";
        }     
        $request->save("permission-pixels", $request->permission["pixels"]["count"]);
        
        if($request->permission["team"]["enabled"] && $request->permission["team"]["count"] == "") {
            $error .= e("Please enter a number of team member allowed. For unlimited use 0.")."<br>";
        }     
        $request->save("permission-team", $request->permission["team"]["count"]);

        if($request->permission["domain"]["enabled"] && $request->permission["domain"]["count"] == "") {
            $error .= e("Please enter a number of domains allowed. For unlimited use 0.")."<br>";
        }       
        $request->save("permission-domain", $request->permission["domain"]["count"]);

        if(DB::plans()->where('slug', str_replace("-","",Helper::slug(Helper::clean($request->name, 3, true))))->first()){
            return Helper::redirect()->back()->with("danger", e("Plan already exists, choose a unique name."));
        }

        if(!empty($error)) return Helper::redirect()->back()->with("danger", $error);
        

        $permissions = [];

        foreach($request->permission as $key => $permission){
            if(isset($permission['custom'])) $permission['custom'] = implode(',', $permission['custom']);
            $permissions[$key] = $permission;
        }

        $plan = DB::plans()->create();

        $plan->name = Helper::clean($request->name, 3, true);
        $plan->slug = Helper::slug(Helper::clean($request->name, 3, true), [], '');
        $plan->description = $request->description;
        $plan->icon = Helper::clean($request->icon, 3, true);
        $plan->free = Helper::clean($request->free, 3, true);
        $plan->counttype = $request->counttype == 'monthly' ? 'monthly' : 'total';
        $plan->qrcounttype = $request->qrcounttype == 'monthly' ? 'monthly' : 'total';
        $plan->trial_days = ($request->trial) ? Helper::clean($request->trial, 3, true) : "0";
        $plan->numurls = !$request->numurls ? "0" : Helper::clean($request->numurls, 3, true);
        $plan->numclicks = !$request->numclicks ? "0" : Helper::clean($request->numclicks, 3, true);
        $plan->retention = !$request->retention ? "0" : Helper::clean($request->retention, 3, true);
        $plan->price_monthly = $request->price_monthly ? Helper::clean($request->price_monthly, 3, true) : "0";
        $plan->price_yearly = $request->price_yearly ? Helper::clean($request->price_yearly, 3, true) : "0";
        $plan->price_lifetime = $request->price_lifetime ? Helper::clean($request->price_lifetime, 3, true) : "0";
        $plan->permission = json_encode($permissions);
        $plan->status = Helper::clean($request->status, 3, true);
        $plan->hidden = Helper::clean($request->hidden, 3, true);
        $plan->ispopular = Helper::clean($request->popular, 3, true);

        $processors = $this->processor();
        
        $data = [];

        foreach($processors as $name => $processor){
            if($plan->free || !config($name) || !config($name)->enabled || !$processor['createplan']) continue;
            $data[$name] = call_user_func($processor['createplan'], $plan);
        }

        $plan->data = json_encode($data);

        $plan->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.plans'))->with('success', e('Plan has been added successfully.'));
    }
    /**
     * Edit Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        if(!user()->hasRolePermission('plans.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit plans.'));
        }
        if(!$plan = DB::plans()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Plan does not exist.'));
        
        View::push(assets('frontend/libs/fontawesome/all.min.css'))->toHeader();
        View::push(assets('frontend/libs/fontawesome-picker/dist/css/fontawesome-iconpicker.min.css'))->toHeader();
        View::push(assets('frontend/libs/fontawesome-picker/dist/js/fontawesome-iconpicker.min.js'), 'script')->toFooter();
        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();    

        View::push("<script>
                        $('input[name=icon]').iconpicker();
                    </script>", "custom")->toFooter();
        

        View::set('title', e('Edit Plan')); 
        
        $plan->permission = json_decode($plan->permission);

        return View::with('admin.plans.edit', compact('plan'))->extend('admin.layouts.main');
    }
    /**
     * Update Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        if(!user()->hasRolePermission('plans.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit plans.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$plan = DB::plans()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Plan does not exist.'));

        $error = '';

        if(!$request->name) {
            $error .= e("Please enter a valid name")."<br>";
        }        

        if($request->trial_days && !is_numeric($request->trial_days)){
            $error .= e("Trial days must be numerical. For example 14.")."<br>";
        }                
    
        if($request->numurls == "" || !is_numeric($request->numurls)){
            $error .= e("Please enter a valid number of links.")."<br>";
        }
        if($request->numclicks == "" || !is_numeric($request->numclicks)){
            $error .= e("Please enter a valid number of clicks.")."<br>";
        }
        if($request->retention == "" || !is_numeric($request->retention)){
            $error .= e("Please enter a valid number for retention.")."<br>";
        }
        
        if($request->free == "0" && (!is_numeric($request->price_monthly) && $request->price_monthly && !is_numeric($request->price_yearly) && !is_numeric($request->price_lifetime))){
            $error .= e("You need to have at least 1 price for the plan.")."<br>";
        }
    
        if($request->permission["splash"]["enabled"] && $request->permission["splash"]["count"] == "") {
            $error .= e("Please enter a number of splash plans allowed. For unlimited use 0.")."<br>";
        }        
    
        if($request->permission["overlay"]["enabled"] && $request->permission["overlay"]["count"] == "") {
            $error .= e("Please enter a number of overlay plans allowed. For unlimited use 0.")."<br>";
        }              

        if($request->permission["pixels"]["enabled"] && $request->permission["pixels"]["count"] == "") {
            $error .= e("Please enter a number of pixels allowed. For unlimited use 0.")."<br>";
        }             
        
        if($request->permission["team"]["enabled"] && $request->permission["team"]["count"] == "") {
            $error .= e("Please enter a number of team member allowed. For unlimited use 0.")."<br>";
        }             

        if($request->permission["domain"]["enabled"] && $request->permission["domain"]["count"] == "") {
            $error .= e("Please enter a number of domains allowed. For unlimited use 0.")."<br>";
        }               

        if(!empty($error)) return Helper::redirect()->back()->with("danger", $error);

        $processors = $this->processor();
        $data = [];
        foreach($processors as $name => $processor){
            if($plan->free || !config($name) || !config($name)->enabled || !$processor['updateplan']) continue;
            $data[$name] = call_user_func_array($processor['updateplan'], [$request, $plan]);
        }

        $permissions = [];

        foreach($request->permission as $key => $permission){
            if(isset($permission['custom'])) $permission['custom'] = str_replace("\r\n", '', implode(',', $permission['custom']));
            $permissions[$key] = $permission;
        }        

        $plan->data = json_encode($data);
        $plan->name = Helper::clean($request->name, 3, true);
        $plan->description = $request->description;
        $plan->icon = Helper::clean($request->icon, 3, true);
        $plan->free = Helper::clean($request->free, 3, true);
        $plan->trial_days = ($request->trial) ? Helper::clean($request->trial, 3, true) : "0";
        $plan->counttype = $request->counttype == 'monthly' ? 'monthly' : 'total';
        $plan->qrcounttype = $request->qrcounttype == 'monthly' ? 'monthly' : 'total';
        $plan->numurls = !$request->numurls ? "0" : Helper::clean($request->numurls, 3, true);
        $plan->numclicks = !$request->numclicks ? "0" : Helper::clean($request->numclicks, 3, true);
        $plan->retention = !$request->retention ? "0" : Helper::clean($request->retention, 3, true);
        $plan->price_monthly = $request->price_monthly ? Helper::clean($request->price_monthly, 3, true) : "0";
        $plan->price_yearly = $request->price_yearly ? Helper::clean($request->price_yearly, 3, true) : "0";
        $plan->price_lifetime = $request->price_lifetime ? Helper::clean($request->price_lifetime, 3, true) : "0";
        $plan->permission = json_encode($permissions);
        $plan->status = Helper::clean($request->status, 3, true);
        $plan->hidden = Helper::clean($request->hidden, 3, true);
        $plan->ispopular = Helper::clean($request->popular, 3, true);
                
        $plan->save();

        return Helper::redirect()->back()->with('success', e('Plan has been updated successfully.'));
    }
    /**
     * Delete Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        if(!user()->hasRolePermission('plans.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete plans.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'plan.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$plan = DB::plans()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Custom plan not found. Please try again.'));
        }
        
        $plan->delete();
        return Helper::redirect()->back()->with('success', e('Plan has been deleted.'));
    }
    /**
     * Sync Plans
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function sync(){
        if(!user()->hasRolePermission('plans.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit plans.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!\Helpers\App::possible()) stop(404);

        foreach(DB::plans()->where('free', 0)->findMany() as $plan){
            
            $plan->data = json_decode($plan->data);

            $processors = $this->processor();
            
            $data = [];

            foreach($processors as $name => $processor){
                if($plan->free || !config($name) || !config($name)->enabled || !$processor['syncplan']) continue;
                $data[$name] = call_user_func_array($processor['syncplan'], [$plan]);
            }

            $plan->data = json_encode($data);
            $plan->save();
        }

        return Helper::redirect()->back()->with('success', e('Plans have been synced.'));
    }
    /**
     * Toggle Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.1.6
     * @param integer $id
     * @return void
     */
    public function toggle(int $id){
        if(!user()->hasRolePermission('plans.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit plans.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$plan = DB::plans()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Plan does not exist.'));

        $plan->status = $plan->status == '1' ? 0 : 1;
        $plan->save();
        return Helper::redirect()->back()->with('success', e('Plan has been toggled.'));
    }
}