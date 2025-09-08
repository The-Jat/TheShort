<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed
 *  by GemPixel or authorized parties, you must not use this software and contact Gempixel
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
use Core\Http;
use Core\View;
use Core\Email;
use Core\Helper;
use Core\Request;
use Core\Response;

class PaddleBilling {

    /**
     * API URL
     */
    const API = "https://api.paddle.com";

    /**
     * Admin Settings
     *
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.0
     */
    public static function settings(){

        $config = config('paddlebilling');

        if(!$config && !isset($config->enabled)){
            $settings = DB::settings()->create();
            $settings->config = 'paddlebilling';
            $settings->var = json_encode(['enabled' => false, 'secret' => null, 'clientid'=> null, 'webhooksecret' => null]);
            $settings->save();
            $config = json_decode($settings->var);
        }

        $html = '<div class="form-group">
                    <label for="paddlebilling[enabled]" class="form-label fw-bold">'.e('Paddle Billing').'</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="paddlebilling[enabled]" name="paddlebilling[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="paddlebillingholder">
                        <label class="form-check-label" for="paddlebilling[enabled]">'.e('Enable').'</label>
                    </div>
                    <p class="form-text">'.e('Collect payments securely with Paddle Billing.').'</p>
                </div>
                <div id="paddlebillingholder" class="toggles '.(!$config->enabled ? 'd-none' : '') .'">
                    <div class="form-group">
                        <label for="paddlebilling[clientid]" class="form-label fw-bold">'.e('Client-side Token').'</label>
                        <input type="text" class="form-control p-2" name="paddlebilling[clientid]" placeholder="" id="paddlebilling[clientid]" value="'.$config->clientid.'">
                        <p class="form-text">'.e('Get your client-side token from Paddle dashboard').'</p>
                    </div>
                    <div class="form-group">
                        <label for="paddlebilling[secret]" class="form-label fw-bold">'.e('API Key').'</label>
                        <input type="text" class="form-control p-2" name="paddlebilling[secret]" placeholder="" id="paddlebilling[secret]" value="'.$config->secret.'">
                        <p class="form-text">'.e('Get your API key from Paddle dashboard').'</p>
                    </div>
                    <div class="form-group">
                        <label for="webhook" class="form-label fw-bold">'.e('Webhook URL').'</label>
                        <input type="text" class="form-control p-2" id="webhook" value="'.route('webhook', ['paddlebilling']).'" disabled>
                        <p class="form-text">'.e('Add this webhook URL to your Paddle dashboard to receive payment notifications').'</p>
                    </div>
                    <div class="form-group">
                        <label for="webhooksecret" class="form-label fw-bold">'.e('Webhook Secret Key').'</label>
                        <input type="text" class="form-control p-2" id="webhooksecret" name="paddlebilling[webhooksecret]" value="'.($config->webhooksecret ?? '').'">
                        <p class="form-text">'.e('You can find this when creating a notification webhook in your Paddle dashboard').'</p>
                    </div>
                </div>';

        View::push("<script>$('#paddlebilling\\\[enabled\\\]').change(function(){
            $('.alert-danger').remove();
            if($(this).is(':checked') && $('#paddle\\\[enabled\\\]').is(':checked')){
                $('#paddlebilling\\\[enabled\\\]').parents('.form-group').before('<div class=\"alert alert-danger p-3\">".e('You cannot enable both Paddle Classic and Paddle Billing at the same time. You must choose one.')."</div>');
            }
         })</script>", 'custom')->toFooter();
        return $html;
    }

    /**
     * Checkout
     *
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.0
     */
    public static function checkout($plan){
        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->clientid || !config('paddlebilling')->secret) {
            return false;
        }

        $paddleData = json_decode($plan->data, true);
        $paddleData = $paddleData['paddlebilling']['prices'] ?? false;
        $type = request()->segment(3);
        $priceId = $paddleData[$type];    

        echo '<div id="paddlebilling" class="paymentOptions"></div>';

        View::push("<script src=\"https://cdn.paddle.com/paddle/v2/paddle.js\"></script>
        <script type=\"text/javascript\">
            let form = $('#payment-form');
            form.find('button[type=submit]').click(function(e){
                if($('input[name=payment]:checked').val() == 'paddlebilling') {
                    e.preventDefault();
                    let text = form.find('button[type=submit]').text();
                    Paddle.Initialize({
                        token: '".config('paddlebilling')->clientid."',
                        eventCallback: function(data){
                            switch(data.name){
                                case 'checkout.completed':
                                    $('#payment-form').append('<input type=\"hidden\" name=\"txn\" value=\"'+data.data.transaction_id+'\" />');
                                    $('#payment-form').submit();
                                    break;
                            }
                        }
                    });
                    Paddle.Checkout.open({
                        'customer': {
                            'email': '".user()->email."'
                        },
                        'items': [{
                            'priceId': '".$priceId."',
                            'quantity': 1
                        }],                        
                        'discountCode': $('#coupon').val(),
                        'customData': {
                            'user_id': '".user()->id."'
                        }
                    });
                }
            });
        </script>", "custom")->toFooter();
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

        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->clientid || !config('paddlebilling')->secret) {
            \GemError::log('Payment system "Paddle Billing" not enabled or configured.');
            return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
        }
        
        if(!$request->txn) return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));

        $http = Http::url(self::API.'/transactions/'.clean($request->txn))
                    ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)
                    ->with('Content-Type', 'application/json')
                    ->get();
        
        if(!$response = $http->bodyObject()) {
            \GemError::log('PaddleBilling Error: '.$response->getBody());
            return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));                
        }

        $paddle = $response->data;
        
        if(!in_array($paddle->status, ['paid', 'completed'])) return Helper::redirect()->back()->with('danger', e('Payment was not completed. Please try again')); 

        if(!$plan = DB::plans()->first($id)){
			return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));        
	  	}

        $user = Auth::user();

        $uniqueid = Helper::rand(16, '', 'abcdef0123456789').$user->id;

        if($type == "yearly"){

            $expiry = date("Y-m-d H:i:s", strtotime("+1 year"));

        }elseif($type == "lifetime"){

            $expiry = date("Y-m-d H:i:s", strtotime("+10 year"));

        }else{

            $expiry = date("Y-m-d H:i:s", strtotime("+1 month"));
        }

		$sub = DB::subscription()->create();
		$sub->tid = null;
		$sub->userid = $user->id;
		$sub->plan = $type;
		$sub->planid = $plan->id;
		$sub->status = "Completed";
		$sub->amount = $paddle->details->totals->grand_total / 100;
		$sub->date = Helper::dtime();
		$sub->expiry = $expiry;
		$sub->lastpayment = Helper::dtime();
		$sub->data = json_encode($paddle);
		$sub->uniqueid = $uniqueid;
		$sub->save();

        $user->last_payment = Helper::dtime();
        $user->expiration = $expiry;
        $user->pro = 1;
        $user->planid = $plan->id;
        $sub->last_payment = Helper::dtime();
        $user->save();
        
        if($request->coupon && $coupon = DB::coupons()->where('code', clean($request->coupon))->first()){
			if($coupon->validuntil && strtotime("now") < strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) {
				$coupon->used++;
				$coupon->save();				
				$sub->coupon = $coupon->id;
				$sub->save();
			}
		}

        return Helper::redirect()->to(route('confirmation', ['id' => $sub->id]))->with('success', e('Your payment was successfully made. Thank you.'));
    }

    /**
     * Create a Product and Price in Paddle
     *
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.0
     * @param array $data Plan data
     * @return object|false
     */
    public static function createplan($plan) {
        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->clientid || !config('paddlebilling')->secret) {
            return false;
        }

        try {

            $product = Http::url(self::API.'/products')
                            ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)
                            ->with('Content-Type', 'application/json')
                            ->body([
                                'name' => $plan->name,
                                'description' => $plan->description ?? '',
                                'type' => 'standard',
                                'tax_category' => 'standard',
                                'custom_data' => [
                                    'planid' => $plan->id
                                ]
                            ])->post();
            if(!$product = $product->bodyObject()) return false;

            $prices = [];
            
            if(isset($plan->price_lifetime) && $plan->price_lifetime > 0) {
                $lifetime = Http::url(self::API.'/prices')
                                ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)    
                                ->with('Content-Type', 'application/json')
                                ->body([
                                    'product_id' => $product->data->id,
                                    'description' => 'Lifetime Subscription',
                                    'billing_cycle' => null,
                                    'unit_price' => [
                                        'amount' => "".($plan->price_lifetime * 100)."",
                                        'currency_code' => strtoupper(config('currency'))
                                    ]
                                ])->post();
                if($lifetime = $lifetime->bodyObject()) {
                    $prices['lifetime'] = $lifetime->data->id;
                }
            }

            if(isset($plan->price_monthly) && $plan->price_monthly > 0) {
                $monthly = Http::url(self::API.'/prices')
                                ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)    
                                ->with('Content-Type', 'application/json')
                                ->body([
                                    'product_id' => $product->data->id,
                                    'description' => 'Monthly subscription',
                                    'billing_cycle' => [
                                        'interval' => 'month',
                                        'frequency' => 1
                                    ],
                                    'unit_price' => [
                                        'amount' => "".($plan->price_monthly * 100)."",
                                        'currency_code' => strtoupper(config('currency'))
                                    ]
                                ])->post();
                if($monthly = $monthly->bodyObject()) {
                    $prices['monthly'] = $monthly->data->id;
                }
            }

            if(isset($plan->price_yearly) && $plan->price_yearly > 0) {
                $yearly = Http::url(self::API.'/prices')
                                ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)
                                ->with('Content-Type', 'application/json')
                                ->body([
                                    'product_id' => $product->data->id,
                                    'description' => 'Yearly subscription',
                                    'billing_cycle' => [
                                        'interval' => 'year',
                                        'frequency' => 1
                                    ],
                                    'unit_price' => [
                                        'amount' => "".($plan->price_yearly * 100)."",
                                        'currency_code' => strtoupper(config('currency'))
                                    ]
                                ])->post();      
                if($yearly = $yearly->bodyObject()) {
                    $prices['yearly'] = $yearly->data->id;
                }
            }

            return [
                'product_id' => $product->data->id,
                'prices' => $prices
            ];

        } catch(\Exception $e) {
            \GemError::log('Paddle Billing Error: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Update a Product and Price in Paddle
     *
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.0
     * @param string $productId Paddle Product ID
     * @param array $prices Existing price IDs
     * @param array $data Updated plan data
     * @return object|false
     */
    public static function updateplan($request, $plan){
        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->clientid || !config('paddlebilling')->secret) {
            return false;
        }

        try {


            $data = json_decode($plan->data, true);
            $paddle = $data['paddlebilling'];
            
            if($request->price_monthly != $plan->price_monthly){

                if(isset($paddle['prices']['monthly']) && $paddle['prices']['monthly']){

                    $monthly = Http::url(self::API.'/prices/'.$paddle['prices']['monthly'])
                                ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)  
                                ->with('Content-Type', 'application/json')      
                                ->body([
                                    'unit_price' => [
                                        'amount' => "".($request->price_monthly * 100)."",
                                        'currency_code' => strtoupper(config('currency'))
                                    ]
                                ])->patch();
                } else {

                    $monthly = Http::url(self::API.'/prices')
                                ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)    
                                ->with('Content-Type', 'application/json')
                                ->body([
                                    'product_id' => $paddle['product_id'],
                                    'description' => 'Monthly subscription',
                                    'billing_cycle' => [
                                        'interval' => 'month',
                                        'frequency' => 1
                                    ],
                                    'unit_price' => [
                                        'amount' => "".($plan->price_monthly * 100)."",
                                        'currency_code' => strtoupper(config('currency'))
                                    ]
                                ])->post();
                    if($monthly = $monthly->bodyObject()) {
                        $paddle['prices']['monthly'] = $monthly->data->id;
                    }   
                }
            }

            if($request->price_yearly != $plan->price_yearly){

                if(isset($paddle['prices']['yearly']) && $paddle['prices']['yearly']){
                    $yearly = Http::url(self::API.'/prices/'.$paddle['prices']['yearly'])
                                    ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)    
                                    ->with('Content-Type', 'application/json')    
                                    ->body([
                                        'unit_price' => [
                                            'amount' => "".($request->price_yearly * 100)."",
                                            'currency_code' => strtoupper(config('currency'))
                                        ]
                                    ])->patch();

                }else{
                    $yearly = Http::url(self::API.'/prices')
                                    ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)
                                    ->with('Content-Type', 'application/json')
                                    ->body([
                                        'product_id' => $product->data->id,
                                        'description' => 'Yearly subscription',
                                        'billing_cycle' => [
                                            'interval' => 'year',
                                            'frequency' => 1
                                        ],
                                        'unit_price' => [
                                            'amount' => "".($plan->price_yearly * 100)."",
                                            'currency_code' => strtoupper(config('currency'))
                                        ]
                                    ])->post();
                    if($yearly = $yearly->bodyObject()) {
                        $paddle['prices']['yearly'] = $yearly->data->id;
                    }                   
                }
            }

            if($request->price_lifetime != $plan->price_lifetime){
                if(isset($paddle['prices']['lifetime']) && $paddle['prices']['lifetime']){
                    $lifetime = Http::url(self::API.'/prices/'.$paddle['prices']['lifetime'])
                                    ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)        
                                    ->with('Content-Type', 'application/json')
                                    ->body([
                                        'unit_price' => [
                                            'amount' => "".($request->price_lifetime * 100)."",
                                            'currency_code' => strtoupper(config('currency'))
                                        ]
                                    ])->patch();

                }else{
                    $lifetime = Http::url(self::API.'/prices')
                                    ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)    
                                    ->with('Content-Type', 'application/json')
                                    ->body([
                                        'product_id' => $product->data->id,
                                        'description' => 'Lifetime Subscription',
                                        'billing_cycle' => null,
                                        'unit_price' => [
                                            'amount' => "".($plan->price_lifetime * 100)."",
                                            'currency_code' => strtoupper(config('currency'))
                                        ]
                                    ])->post();
                    if($lifetime = $lifetime->bodyObject()) {
                        $paddle['prices']['lifetime'] = $lifetime->data->id;
                    }                
                }
            }

            return $paddle;

        } catch(\Exception $e) {
            \GemError::log('Paddle Billing Error: '.$e->getMessage());
        }
    }

        /**
     * Sync Plans with Paddle
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function syncplan($plan) {
        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->clientid || !config('paddlebilling')->secret) {
            return false;
        }

        $response = false;
        try {
            $paddleData = $plan->data->paddlebilling ?? false;
            
            if(!$paddleData || !isset($paddleData->product_id)) {
                $response = self::createPlan($plan);
            }

            return $response;

        } catch(\Exception $e) {
            \GemError::log('Paddle Billing Sync Error: '.$e->getMessage());
        }
    }

    /**
     * Create a Discount in Paddle
     *
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.0
     * @param array $data Coupon data
     * @return string|false Returns discount ID if successful, false otherwise
     */
    public static function createcoupon($request) {
        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->clientid || !config('paddlebilling')->secret) {
            return false;
        }

        try {
            $discount = Http::url(self::API.'/discounts')
                            ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)
                            ->with('Content-Type', 'application/json')
                            ->body([
                                'type' => 'percentage',
                                'amount' => $request->discount,
                                'description' => $request->description,
                                'enabled_for_checkout' => true,
                                'code' => $request->code,
                                'expires_at' => $request->validuntil ? date('Y-m-d\TH:i:s\Z', strtotime($request->validuntil)) : null,
                                'recur' => true,
                                'usage_limit' => $request->maxuse > 0 ? (int) $request->maxuse : null,
                            ])->post();
            if($response = $discount->bodyObject()) {
                return $response->data->id;
            }
        } catch(\Exception $e) {
            \GemError::log('Paddle Billing Error: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Webhook Handler
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param Request $request
     * @return void
     */
    public static function webhook(Request $request){

        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->secret) return null;

        try {
            // Get webhook data
            $payload = $request->getJSON();
            
            // Verify webhook signature
            if(!$signature = $_SERVER['HTTP_PADDLE_SIGNATURE']){
                \GemError::log('Paddle Billing Error: Invalid signature');
            }

            // Parse the signature header
            $signatures = [];
            foreach (explode(';', $signature) as $part) {
                if (strpos($part, '=') === false) continue;
                list($key, $value) = explode('=', $part, 2);
                $signatures[trim($key)] = trim($value);
            }

            if (!isset($signatures['ts'], $signatures['h1'])) {
                \GemError::log('Paddle Billing Error: Invalid signature format');
                http_response_code(500);
                exit;
            }

            // Get raw request body
            $rawPayload = $request->getBody();

            // Construct the string to verify
            $verifyString = $signatures['ts'] . ':' . $rawPayload;

            // Calculate expected signature
            $expectedSignature = hash_hmac('sha256', $verifyString, config('paddlebilling')->webhooksecret);

            // Verify signature
            if (!hash_equals($expectedSignature, $signatures['h1'])) {
                \GemError::log('Paddle Billing Error: Signature verification failed');
                http_response_code(500);
                exit;
            }

            $data = $payload->data;
            // Get subscription info
            if(!isset($data->custom_data->user_id)){
                \GemError::log('Paddle Billing Error: Invalid user');
                http_response_code(500);
                exit;
            }

            if(!$user = DB::user()->where('id', $data->custom_data->user_id)->first()){
                \GemError::log('Paddle Billing Error: User not found');
                http_response_code(500);
                exit;
            }


            $subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('id')->first();

            if(isset($data->id) && $data->id && DB::payment()->where('cid', $data->id)->first()) return;

            if($payload->event_type == 'transaction.completed'){

                if($subscription->plan == "yearly"){

                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($payload->occurred_at)));
    
                }elseif($subscription->plan == "lifetime"){
    
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+10 year", strtotime($payload->occurred_at)));
    
                }else{
    
                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($payload->occurred_at)));
                }
    
                $payment = DB::payment()->create();
                $payment->date = Helper::dtime('now');
                $payment->cid = $data->id;
                $payment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
                $payment->amount =  $data->details->totals->grand_total / 100;
                $payment->userid =  $user->id;
                $payment->status = "Completed";
                $payment->expiry =  $new_expiry;
                $payment->data = json_encode($payload);
    
                $payment->save();
    
                $amount = $subscription->amount + ($payment->amount);
                $subscription->tid = $data->subscription_id;
                $subscription->amount = $amount;
                $subscription->expiry = $new_expiry;
                $subscription->status = "Active";
                $subscription->save();
                
                $user->last_payment = Helper::dtime();
                $user->expiration = $new_expiry;
                $user->pro = 1;
                $user->planid = $subscription->planid;
                $user->save();

            } elseif($payload->event_type == 'subscription.canceled'){

                $subscription->status = 'Canceled';
                $subscription->expiry = Helper::dtime();
                $subscription->save();

                $user->expiration = Helper::dtime();
                $user->pro = 1;
                $user->planid = null;
                $user->save();

            }

        } catch(\Exception $e){
            \GemError::log('Paddle Billing Webhook Error: '.$e->getMessage());
            http_response_code(500);
            exit;
        }
    }
    /**
     * Cancel
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @return void
     */
    public static function cancel($user, $subscription){

        if(!config('paddlebilling') || !config('paddlebilling')->enabled || !config('paddlebilling')->secret) return null;


        $cancel = Http::url(self::API.'/subscriptions/'.$subscription->tid.'/cancel')
                    ->with('Authorization', 'Bearer '.config('paddlebilling')->secret)
                    ->with('Content-Type', 'application/json')
                    ->body([
                        'effective_from' => 'next_billing_period'
                    ])->post();
    
        return null;
    }
}