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

class Coupons {

    use \Traits\Payments;
    
    /**
     * Check License
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){
        if(!\Helpers\App::possible()){
            return Helper::redirect()->to(route('admin.settings.config', ['payments']))->with('danger', 'Please enter your extended purchase code to unlock coupons.');
        }
    }
    /**
     * Coupons
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(Request $request){

        if(!user()->hasRolePermission('plans.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view coupons.'));
        }

        $query = DB::coupons()->orderByDesc('id');
        
        $q = null;
        
        if($request->q) {
            $q = clean($request->q);
            $query->whereAnyIs([
                ['name' => "%{$q}%"],
                ['code' => "%{$q}%"],
            ], 'LIKE ');
        }

        $coupons = [];

        foreach($query->paginate(15) as $item){
            $item->data = json_decode($item->data, true);
            $coupons[] = $item;
        }

        CDN::load('datetimepicker');

        View::set('title', e('Coupons Manager'));

        return View::with('admin.coupons.index', compact('coupons', 'q'))->extend('admin.layouts.main');
    }   
    /**
     * New Coupons
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.2
     * @return void
     */
    public function new(){    

        if(!user()->hasRolePermission('plans.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create coupons.'));
        }

        CDN::load('datetimepicker');

        View::set('title', e('New Coupon'));

        return View::with('admin.coupons.new')->extend('admin.layouts.main');
    }
    /**
     * Save coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        if(!user()->hasRolePermission('plans.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create coupons.'));
        }
        
        \Gem::addMiddleware('DemoProtect');
        
        if(!$request->name || !$request->code || !$request->discount) return Helper::redirect()->back()->with('danger', e('The name, the promo code and the discount percentage are required.'));
        
        if($request->discount >= 100 || $request->discount < 1) return Helper::redirect()->back()->with('danger', e('Discount must be between 1 to 99%.'));

        if(DB::coupons()->where('code', strtoupper($request->code))->first()){
            return Helper::redirect()->back()->with('danger', e('The promo code already exists.'));
        }
        
        $data = [];

        if($request->plans){
            $data['plans'] = $request->plans;
        }

        foreach($this->processor() as $name => $processor){
            if(!config($name) || !config($name)->enabled || !$processor['createcoupon']) continue;
            $data[$name] = call_user_func($processor['createcoupon'], $request);
        }
        
        $coupon = DB::coupons()->create();
        $coupon->name = Helper::clean($request->name, 3, true);
        $coupon->code = strtoupper(clean($request->code));
        $coupon->description = clean($request->description);
        $coupon->discount = $request->discount;
        $coupon->validuntil = $request->validuntil ? Helper::dtime($request->validuntil) : null;
        $coupon->maxuse = !is_numeric($request->maxuse) || $request->maxuse < 0 ? 0 : $request->maxuse;
        $coupon->date = Helper::dtime();
        $coupon->data = json_encode($data);
        $coupon->save();

        \Core\Plugin::dispatch('admin.coupon.add', [$coupon]);

        return Helper::redirect()->to(route('admin.coupons'))->with('success', e('Coupon has been added successfully'));
    }   
    /**
     * Edit coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.2
     * @param integer $id
     * @return void
     */ 
    public function edit(int $id){

        if(!user()->hasRolePermission('plans.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit coupons.'));
        }

        if(!$coupon = DB::coupons()->where('id', $id)->first()) return back()->with('danger', e('Coupon not found'));

        CDN::load('datetimepicker');

        $coupon->data = json_decode($coupon->data);

        View::set('title', e('Edit Coupon'));

        return View::with('admin.coupons.edit', compact('coupon'))->extend('admin.layouts.main');
    }
    /**
     * Update Coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        
        if(!user()->hasRolePermission('plans.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit coupons.'));
        }
        
        \Gem::addMiddleware('DemoProtect');
        
        if(!$request->name) return Helper::redirect()->back()->with('danger', e('The name is required.'));
        
        if(!$coupon = DB::coupons()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('The promo code does not exist.'));
        }

        $data = json_decode($coupon->data, true);

        $data['plans'] = $request->plans;
        
        $coupon->name = Helper::clean($request->name, 3, true);
        $coupon->description = clean($request->description);
        $coupon->validuntil = Helper::dtime($request->validuntil);
        $coupon->maxuse = !is_numeric($request->maxuse) || $request->maxuse < 0 ? 0 : $request->maxuse;
        $coupon->data = json_encode($data);
        $coupon->save();

        \Core\Plugin::dispatch('admin.coupon.update', [$coupon]);

        return Helper::redirect()->back()->with('success', e('Coupon has been updated successfully.'));
    }
    /**
     * Delete Coupon
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
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete coupons.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'coupon.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$coupon = DB::coupons()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Coupon not found. Please try again.'));
        }
        
        \Core\Plugin::dispatch('admin.coupon.delete', [$coupon]);

        $coupon->delete();
        return Helper::redirect()->back()->with('success', e('Coupon has been deleted.'));
    }
}