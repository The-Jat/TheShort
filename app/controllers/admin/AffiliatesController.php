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
use Models\User;

class Affiliates {
    /**
     * Affiliates Refs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('affiliates.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view affiliates.'));
        }

        $sales = []; 
        foreach(DB::affiliates()->orderByDesc('id')->paginate(15) as $sale){
            if(!$sale->user = User::where('id', $sale->refid)->first()) continue;
            if(!$sale->referred = User::where('id', $sale->userid)->first()) continue;
            $sales[] = $sale;
        }

        View::set('title', e('Affiliates'));

        return View::with('admin.affiliates', compact('sales'))->extend('admin.layouts.main');
    }

    /**
     * Payments Due
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function payments(){

        $users = User::whereRaw('pendingpayment >= ?', config('affiliate')->payout)->paginate(15);

        View::set('title', e('Affiliate Payments'));

        return View::with('admin.affiliatepayments', compact('users'))->extend('admin.layouts.main');
    }    
    /**
     * Payment History
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public function history(Request $request){

        $payments = [];
        $query = DB::affiliates()->whereNotNull('paid_on');

        if($request->userid && $request->userid !== 'all'){
            $query->where('refid', $request->userid);
        }

        foreach($query->paginate(15) as $affiliate){
            if(!$affiliate->user = User::where('id', $affiliate->refid)->first()) continue;
            $payments[] = $affiliate;
        }

        View::set('title', e('Affiliate Payments History'));

        $users = DB::user()->select('id')->select('email')->orderByAsc('id')->findArray();

        return View::with('admin.affiliatehistory', compact('payments', 'users'))->extend('admin.layouts.main');
    }    

    /**
     * Update Affiliate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id, string $action){
        if(!user()->hasRolePermission('affiliates.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit affiliates.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$affiliate = DB::affiliates()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Referral does not exist.'));

        if($action == 'approve'){
            $user = User::where('id', $affiliate->refid)->first();
            $user->pendingpayment = $user->pendingpayment + $affiliate->amount;
            $user->save();
            
            $affiliate->status = 1; 
            $affiliate->save();

            return Helper::redirect()->back()->with('success', e('Referral status has been approved successfully and user has been awarded $'.$affiliate->amount.'.'));
        }    
        
        if($action == 'reject'){

            $affiliate->status = 2; 
            $affiliate->save();

            return Helper::redirect()->back()->with('success', e('Referral status has been rejected and no commission was awarded.'));
        } 
    }
    /**
     * Pay user
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    public function pay($id){
        
        if(!$user = User::where('id', $id)->first()){
            stop(404);
        }
        
        DB::affiliates()->where('refid', $user->id)->where('status', '1')->update(['paid_on' => Helper::dtime('now'), 'status' => '3']);
        
        \Helpers\Emails::affiliatePayment($user, \Helpers\App::currency(config('currency'), $user->pendingpayment));

        $user->pendingpayment = 0;
        $user->save();

        return Helper::redirect()->back()->with('success', e('User affiliate commissions have been marked as paid and user has been notified of the payment.'));
    }
    /**
     * Delete Post
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        if(!user()->hasRolePermission('affiliates.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete affiliates.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'affiliate.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$affiliate = DB::affiliates()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Referral not found. Please try again.'));
        }
        
        $affiliate->delete();
        return Helper::redirect()->back()->with('success', e('Referral has been deleted.'));
    }
    /**
     * Affiliate Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.3
     * @return void
     */
    public function settings(){

        View::set('title', e('Affiliate Settings'));

        $affiliate = config('affiliate');

        return View::with('admin.affiliatesettings', compact('affiliate'))->extend('admin.layouts.main');
    }
    /**
     * List all withdrawal requests
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.3
     */
    public function withdrawals() {
        $withdrawals = DB::withdrawals()->orderByDesc('created_at')->paginate(20);
        foreach($withdrawals as $w) {
            $w->user = User::where('id', $w->user_id)->first();
        }
        View::set('title', e('Affiliate Withdrawals'));
        return View::with('admin.affiliatewithdrawals', compact('withdrawals'))->extend('admin.layouts.main');
    }
    /**
     * Approve or reject a withdrawal request
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.3
     */
    public function withdrawalAction(Request $request, int $id, string $action) {
        
        \Gem::addMiddleware('DemoProtect');
        
        $withdrawal = DB::withdrawals()->where('id', $id)->first();
        
        if(!$withdrawal) return Helper::redirect()->back()->with('danger', e('Withdrawal request not found.'));
        
        $user = User::where('id', $withdrawal->user_id)->first();

        if($action == 'approve') {
            
            $withdrawal->status = 'approved';
            $withdrawal->processed_at = Helper::dtime('now');
            $withdrawal->note = $request->note;
            $withdrawal->save();
            
            \Helpers\Emails::affiliatePayment($user, \Helpers\App::currency(config('currency'), $withdrawal->amount));
            
            return Helper::redirect()->back()->with('success', e('Withdrawal approved.'));

        } elseif($action == 'reject') {

            $withdrawal->status = 'rejected';
            $withdrawal->processed_at = Helper::dtime('now');
            $withdrawal->note = $request->note;
            $withdrawal->save();
            
            $user->pendingpayment += $withdrawal->amount;
            $user->save();                

            return Helper::redirect()->back()->with('success', e('Withdrawal rejected and funds returned.'));
        }
        return Helper::redirect()->back()->with('danger', e('Invalid action.'));
    }
}