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

namespace Helpers\Payments;

use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\View;
use Core\Email;

class Mollie {

    /**
     * Generate Payment Form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function settings(){

        $config = config('mollie');

        if(!$config && !isset($config->enabled)){
                    
            $settings = DB::settings()->create();

            $settings->config = 'mollie';
            $settings->var = json_encode(['enabled' => config('pt') == 'mollie', 'api' => '']);
            $settings->save();
            $config = json_decode($settings->var);
        }

        $html = '<div class="form-group">
                    <label for="mollie[enabled]" class="form-label fw-bold">'.e('Mollie Payments').'</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="mollie[enabled]" name="mollie[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="mollieholder">
                        <label class="form-check-label" for="mollie[enabled]">'.e('Enable').'</label>
                    </div>
                    <p class="form-text">'.e('Collect payments securely with Mollie.').'</p>
                </div>
                <div id="mollieholder" class="toggles '.(!$config->enabled ? 'd-none' : '') .'">
                    <div class="form-group">
                        <label for="mollie[api]" class="form-label fw-bold">'.e('Mollie API Key').'</label>
                        <input type="text" class="form-control p-2" name="mollie[api]" placeholder="" id="mollie[api]" value="'.$config->api.'">
                        <p class="form-text">'.e('Get your API key from your Mollie account.').'</p>
                    </div>
                </div>';
        return $html;
    }

    /**
     * Checkout
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function checkout($plan = null){    

        if(!config('mollie') || !config('mollie')->enabled || !config('mollie')->api) {            
            return false;
        }
        
        echo '<div id="mollie" class="paymentOptions"></div>';
    }

    /**
     * Payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public static function payment(Request $request, int $id, string $type){

        if(!config('mollie') || !config('mollie')->enabled || !config('mollie')->api) {
            
            \GemError::log('Payment system "Mollie" not enabled or configured.');

            return back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
        }

        if(!$plan = DB::plans()->where('id', $id)->first()){
            return back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
        }

        $user = Auth::user();

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(config('mollie')->api);

        $term = e($plan->name);
        $text = e("First month");
        $price = $plan->price_monthly;
        $planid = $plan->slug."monthly";
    
        if($type == "yearly" && $plan->price_yearly){
            $term = e($plan->name);
            $text = e("First year");
            $price = $plan->price_yearly;
            $planid = $plan->slug."yearly";             
        }

        if($type == "lifetime" && $plan->price_lifetime){
            $term = e($plan->name);
            $text = e("Lifetime");
            $price = $plan->price_lifetime;
            $planid = $plan->slug."lifetime";           
        }

        $sub = DB::subscription()->create();
 
        

        if($request->coupon && $coupon = DB::coupons()->where('code', clean($request->coupon))->first()){
			if($coupon->validuntil && strtotime("now") < strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) {
				$coupon->used++;
				$coupon->save();
				$price = round((1 - ($coupon->discount / 100)) * $price, 2);
				$sub->coupon = $coupon->id;
				$coupon->data = json_decode($coupon->data);
			}
		}

		if($tax = DB::taxrates()->whereRaw('countries LIKE ?', ["%".clean($request->country)."%"])->first()){
			$tax->data = json_decode($tax->data);
            $price = round($price * (1+($tax->rate / 100)), 2);
		}

        $uniqueid = Helper::rand(16, '', 'abcdef0123456789').$user->id;

        $sub->tid = null;
        $sub->userid = $user->id;
        $sub->plan = $type;
        $sub->planid = $plan->id;
        $sub->status = "Pending";
        $sub->amount = "0";
        $sub->date = Helper::dtime();
        $sub->expiry = Helper::dtime();
        $sub->lastpayment = Helper::dtime();
        $sub->data = NULL;
        $sub->uniqueid = $uniqueid;
        $sub->save();

        $user->last_payment = Helper::dtime();
        $user->expiration = Helper::dtime();
        $user->pro = 1;
        $user->planid = $plan->id;
        
        $customerExists = false;

        if($user->customerid){
            try{
                $customer = $mollie->customers->get($user->customerid);
                $customerExists = true;
            }catch(\Exception $e) {
            }   
        }

        if(!$customerExists || !$user->customerid){
            $customer = $mollie->customers->create([
                "name" => (isset($user->address->type) && $user->address->type == 'business') ? clean($user->address->company) : clean($request->name),
                "email" => $user->email,
            ]);
            $user->customerid = $customer->id;
        }

        $user->save();

        try {
            $molliepayment = $customer->createPayment([
                "amount" => [
                    "currency" => strtoupper(config('currency')),
                    "value" => number_format($price, 2, '.', '')
                ],
                "description" => "$term - Initial payment for recurring $type subscription",
                "webhookUrl"  => route('webhook', 'mollie'),
                "redirectUrl"  => route('callback.mollie'),
                "cancelUrl"  => route('dashboard',['success' => false]),
                "metadata" => [
                    "subscription_id" => $sub->id,
                    "user_id" => $user->id,
                    "plan_id" => $plan->id,
                ],
                "sequenceType" => \Mollie\Api\Types\SequenceType::SEQUENCETYPE_FIRST
            ]);

            $payment = DB::payment()->create();
            $payment->date = Helper::dtime('now');
            $payment->cid = $molliepayment->id;
            $payment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
            $payment->amount =  $price;
            $payment->userid =  $user->id;
            $payment->status = "Pending";
            $payment->expiry =  null;
            $payment->data =  json_encode($molliepayment);
            $payment->save();

            return Helper::redirect()->to($molliepayment->_links->checkout->href);

        } catch(\Exception $e) {
            \GemError::log('Mollie Error: '.$e->getMessage());
            return back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
        }
    }

    /**
     * Webhook
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function callback(Request $request){

        if(!config('mollie') || !config('mollie')->enabled || !config('mollie')->api) {            
            \GemError::log('Payment system "Mollie" not enabled or configured.');
            return null;
        }

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(config('mollie')->api);

        try {

            $user = Auth::user();

            $payment = DB::payment()->where('userid', Auth::id())->where('status', 'Pending')->first();

            $molliepayment = $mollie->payments->get($payment->cid);
            
            if ($molliepayment->isPaid() && !$molliepayment->hasRefunds() && !$molliepayment->hasChargebacks()) {
                
                $subscription = DB::subscription()->where('id', $molliepayment->metadata->subscription_id)->first();

                if($subscription->plan == "yearly"){
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($molliepayment->paidAt)));
                } elseif($subscription->plan == "lifetime"){
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+10 year", strtotime($molliepayment->paidAt)));
                } else {
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($molliepayment->paidAt)));
                }

                $payment->status = 'Completed';
                $payment->expiry = $new_expiry;

                $payment->save();

                $subscription->data = json_encode($molliepayment);

                if($subscription->plan != 'lifetime'){
                    $customer = $mollie->customers->get($user->customerid);
                    $molliesubscription  = $customer->createSubscription([
                        "amount" => [
                            "currency" => strtoupper(config('currency')),
                            "value" => $molliepayment->amount->value,
                        ],
                        "times" => 10*10,
                        "interval" => $subscription->plan == 'yearly' ? '12 months' : '1 month',
                        "startDate" =>  date("Y-m-d", strtotime($new_expiry)),
                        "description" => "Subscription of {$subscription->plan} payment for {$user->email}",
                        "webhookUrl"  => route('webhook', 'mollie'),
                    ]);
    
                    $subscription->data = json_encode($molliesubscription);
                }

                $subscription->tid = $molliesubscription->id;
                $subscription->status = "Active";
                $subscription->amount = $molliepayment->amount->value;
                $subscription->expiry = $new_expiry;
                $subscription->save();

                $user->expiration = $new_expiry;
                $user->pro = 1;
                $user->planid = $subscription->planid;
                $user->save();


                \Core\Plugin::dispatch('payment.success', [$user, $subscription->planid, $payment->id]);

                return Helper::redirect()->to(route('confirmation', ['id' => $subscription->id]));
            }

        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            \GemError::log('Mollie Webhook Error: '.$e->getMessage());
        }

        return Helper::redirect()->to(route('dashboard', ['success' => 'false']));
    }
    /**
     * Webhook
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5
     * @param \Core\Request $request
     * @return void
     */
    public static function webhook(Request $request){

        if(!config('mollie') || !config('mollie')->enabled || !config('mollie')->api) {            
            \GemError::log('Payment system "Mollie" not enabled or configured.');
            return null;
        }

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(config('mollie')->api);

        $body = json_decode($request->getBody());

        if(!$body || empty($body)) die('error');

        try {

            $molliepayment = $mollie->molliepayments->get($body->id);

            if(DB::payment()->where('cid', $molliepayment->id)->first()) return \GemError::log('Congrats transction already exists');

            if ($molliepayment->isPaid() && !$molliepayment->hasRefunds() && !$molliepayment->hasChargebacks()) {
                
                $subscription = DB::subscription()->where('id', $molliepayment->metadata->subscription_id)->first();
                
                if(!$user = DB::user()->where('id', $molliepayment->metadata->user_id)->first()) {
                    return \GemError::log("Mollie Webhook Error: User not found {$molliepayment->metadata->user_id}");
                }

                if($subscription->plan == "yearly"){
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($molliepayment->paidAt)));
                } elseif($subscription->plan == "lifetime"){
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+10 year", strtotime($molliepayment->paidAt)));
                } else {
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($molliepayment->paidAt)));
                }

                $subscription->status = "Active";
                $subscription->amount = $molliepayment->amount->value;
                $subscription->expiry = $new_expiry;
                $subscription->save();

                $user->expiration = $new_expiry;
                $user->pro = 1;
                $user->planid = $subscription->planid;
                $user->save();

                $payment = DB::payment()->create();
                $payment->date = Helper::dtime('now');
                $payment->cid = $molliepayment->id;
                $payment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
                $payment->amount =  $molliepayment->amount->value;
                $payment->userid =  $user->id;
                $payment->status = "Completed";
                $payment->expiry =  $new_expiry;
                $payment->data =  json_encode($molliepayment);
                $payment->save();

                \Core\Plugin::dispatch('payment.success', [$user, $subscription->planid, $payment->id]);
            }

        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            \GemError::log('Mollie Webhook Error: '.$e->getMessage());
        }

        return Response::factory('OK')->send();
    }
    /**
     * Cancel Subscription
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5
     * @return void
     */
    public static function cancel(){
        if(!config('mollie') || !config('mollie')->enabled || !config('mollie')->api) {            
            \GemError::log('Payment system "Mollie" not enabled or configured.');
            return null;
        }

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(config('mollie')->api);

        $user = Auth::user();

        $subscription = DB::subscription()->where('userid', $user->id)->where('status', 'Active')->first();

        try{
            if($subscription->plan == 'yearly'){

                $lastpayment = DB::payment()->where('userid', $user->id)->where('status', 'Completed')->first();

                $amount = $lastpayment->amount;
    
                $start = $subscription->date;
                $end = $subscription->expiry;
    
                $yStart = date('Y', strtotime($start));
                $yEnd = date('Y',  strtotime($end));
    
                $mStart = date('m',  strtotime($start));
                $mEnd = date('m',  strtotime($end));
    
                $diff = (($yEnd - $yStart) * 12) + ($mEnd - $mStart);
    
                $refund = round(($diff - 1) * $amount / 12, 2);
                
                $payment = $mollie->payments->get($lastpayment->cid);
                $mollierefund = $payment->refund([
                    "amount" => [
                        "currency" => strtoupper(config('currency')),
                        "value" => "{$refund}",
                    ],
                    "metadata" => [
                        "subscription_id" => $subscription->id,
                        "user_id" => $user->id,
                    ],
                ]);
            }

            $mollie->subscriptions->cancelForId($user->customerid, $subscription->tid);

        }catch(\Exception $e){
            \GemError::log($e->getMessage());
            return null;
        }
    }
}