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
Use Models\User;

class Membership {

    use \Traits\Payments;

    /**
     * All Subscriptions
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function subscriptions(Request $request){
        if(!user()->hasRolePermission('subscriptions.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view subscriptions.'));
        }

        if(!\Helpers\App::possible()){
            return Helper::redirect()->to(route('admin.settings.config', ['payments']))->with('danger', 'Please enter your extended purchase code to unlock payments');
        }
        
        View::set('title', e('Subscriptions'));

        $subscriptions = [];
        
        $query = DB::subscription();

        if($request->userid && \is_numeric($request->userid)) {
            $query->where('userid', $request->userid);
            View::set('title', e('Subscriptions for user'));
        }

        if($request->q){
            $q = clean($request->q);
            $query->whereAnyIs([
                ['tid' => "%{$q}%"],
                ['uniqueid' => "%{$q}%"],
            ], 'LIKE ');
        }

        foreach($query->orderByDesc('id')->paginate(15) as $subscription){
            if(!$user = User::where('id', $subscription->userid)->first()) continue;
            
            if(_STATE == "DEMO") $user->email = "Hidden in demo to protect privacy";
            
            $subscription->user = $user->email;
            $subscription->useravatar = $user->avatar();

            if($plan = DB::plans()->where('id', $subscription->planid)->first()){
                $subscription->plan = $plan->name;
            }
            $subscriptions[] = $subscription;
        }

        View::push(assets('Chart.min.js'), "script")->toFooter();
        View::push(assets('charts.min.js')."?v=1.0", 'script')->toFooter();

        return View::with('admin.subscriptions', compact('subscriptions'))->extend('admin.layouts.main');
    }
    /**
     * View Payments
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function payments(Request $request){
        if(!user()->hasRolePermission('payments.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view payments.'));
        }
        
        View::set('title', e('Payments'));

        $payments = [];
        
        $query = DB::payment();

        if($request->userid && \is_numeric($request->userid)) {
            $query->where('userid', $request->userid);
            View::set('title', e('Payments for user'));
        }

        foreach($query->orderByDesc('id')->paginate(15) as $payment){
            if($user = User::where('id', $payment->userid)->first()){
                if(_STATE == "DEMO") $user->email="Hidden in demo to protect privacy";
                $payment->data = json_decode($payment->data ?? '');
                $payment->provider = $payment->data->paymentmethod ?? null;
                $payment->user = $user->email;
                $payment->useravatar = $user->avatar();
            }
            $payments[] = $payment;
        }        

        View::push(assets('Chart.min.js'), "script")->toFooter();
        View::push(assets('charts.min.js')."?v=1.0", 'script')->toFooter();

        return View::with('admin.payments', compact('payments'))->extend('admin.layouts.main');
    }
    /**
     * Mark Payment As
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @param string $action
     * @return void
     */
    public function markAs(int $id, string $action){
        if(!user()->hasRolePermission('payments.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit payments.'));
        }
        
        \Gem::addMiddleware('DemoProtect');

        if(!$payment = DB::payment()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
        }

        if($action == "paid"){
            $payment->status = 'Completed';
        }
        if($action == "refunded"){
            $payment->status = 'Refunded';
        }

        $payment->save();

        return Helper::redirect()->back()->with('success', e('Payment status has been saved.'));
    }
    /**
     * Delete payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        if(!user()->hasRolePermission('payments.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete payments.'));
        }
        
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'payment.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$payment = DB::payment()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
        }
        
        $payment->delete();
        return Helper::redirect()->back()->with('success', e('Payment has been deleted.'));
    }
    /**
     * View Payment Invoice
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function invoice(int $id){
        if(!user()->hasRolePermission('payments.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view invoices.'));
        }
        if(!$payment = DB::payment()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
        }
        
        if(!$user = DB::user()->where('id', $payment->userid)->first()){
            return Helper::redirect()->back()->with('danger', e('User not found. Please try again.'));
        }

        $user->address = json_decode($user->address);

        if(!$user->address) {
            $user->address = new \stdCLass;
            $user->address->address = '';
            $user->address->city = '';
            $user->address->state = '';
            $user->address->zip = '';
            $user->address->country = '';
        }
        
        View::push(assets('frontend/libs/fontawesome/all.min.css'))->toHeader();

        View::set('title', e('View Invoice'));

        return View::with('invoice', compact('payment', 'user'))->extend('admin.layouts.main');
    }
    /**
     * Mark as
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.6.3
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function subscriptionMarkas(int $id, string $type){
        if(!user()->hasRolePermission('subscriptions.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit subscriptions.'));
        }
        if(!$subscription = DB::subscription()->first($id)){
            return back()->with('danger', e('Subscriptions not found.'));
        }

        if($type == 'activate'){

            if($subscription->plan == 'yearly'){
                $subscription->expiry = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($subscription->date)));
            } elseif($subscription->plan == 'lifetime'){
                $subscription->expiry = date('Y-m-d H:i:s', strtotime('+10 years', strtotime($subscription->date)));
            } else {
                $subscription->expiry = date('Y-m-d H:i:s', strtotime('+1 month', strtotime($subscription->date)));
            }
            $data = json_decode($subscription->data);

            if($data && isset($data->type) && $data->type == "bank"){
                if($affiliate = DB::affiliates()->where('userid', $subscription->userid)->whereNull('paid_on')->first()){
                    if($payment = DB::payment()->where('userid', $subscription->userid)->first()){
                        $affiliate->amount = round((config('affiliate')->rate / 100) * $payment->amount, 2);
                        $affiliate->paid_on = Helper::dtime();
                        $affiliate->save();
                    }
                }                
            }

            $subscription->status = 'Active';
            $subscription->save();

            $user = DB::user()->first($subscription->userid);
            $user->expiration = $subscription->expiry;
            $user->planid = $subscription->planid;
            $user->pro = 1;
            $user->save();

            return back()->with('success', e('User subscription has been marked as active.'));
        }

        if($type == 'cancel'){
            $subscription->expiry = Helper::dtime();
            $subscription->status = 'Canceled';
            $subscription->save();
            $user = \Models\User::where('id', $subscription->userid)->first();
            $plan = DB::plans()->where('free', 1)->first();
            $user->expiration = Helper::dtime();
            $user->planid = $plan ? $plan->id : null;
            $user->pro = 0;
            $user->save();

            if(\Helpers\App::possible()){
                foreach($this->processor() as $name => $processor){
                    if(!config($name) || !config($name)->enabled || !$processor['cancel']) continue;
                    $response = call_user_func_array($processor['cancel'], [$user, $subscription]);
                }
            }
    

            return back()->with('success', e('User subscription has been canceled.'));
        }

        return back()->with('danger', e('An error occurred. Please try again.'));
    }
}