<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact gempixel
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

class PayStack {

    /**
     * Checkout API URls
     */
    const API = "https://api.paystack.co";

    /**
     * Admin Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    public static function settings(){

        $config = config('paystack');

		if(!$config && !isset($config->enabled)){
					
			$settings = DB::settings()->create();

			$settings->config = 'paystack';
			$settings->var = json_encode(['enabled' => false, 'secret' => null, 'public'=> null]);
			$settings->save();
			$config = json_decode($settings->var);
		}

		$html = '<div class="form-group">
					<label for="paystack[enabled]" class="form-label fw-bold">'.e('PayStack Payments').'</label>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" data-binary="true" id="paystack[enabled]" name="paystack[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="paystackholder">
						<label class="form-check-label" for="paystack[enabled]">'.e('Enable').'</label>
					</div>
					<p class="form-text">'.e('Collect payments securely with PayStack.').'</p>
				</div>
				<div id="paystackholder" class="toggles '.(!$config->enabled ? 'd-none' : '') .'">
					<div class="form-group">
						<label for="paystack[secret]" class="form-label fw-bold">'.e('Secret Key').'</label>
						<input type="text" class="form-control p-2" name="paystack[secret]" placeholder="" id="paystack[secret]" value="'.$config->secret.'">
						<p class="form-text">'.e('Get your paystack keys from here once logged in <a href="https://dashboard.paystack.com/#/settings/developers" target="_blank">click here</a>').'</p>
					</div>
					<div class="form-group">
						<label for="paystack[public]" class="form-label fw-bold">'.e('Public Key').'</label>
						<input type="text" class="form-control p-2" name="paystack[public]" placeholder="" id="paystack[public]" value="'.$config->public.'">
						<p class="form-text">'.e('Get your paystack keys from here once logged in <a href="https://dashboard.paystack.com/#/settings/developers" target="_blank">click here</a>').'</p>
					</div> 
					<div class="form-group">
						<label for="webhook" class="form-label fw-bold">'.e('Webhook URL').'</label>
						<input type="text" class="form-control p-2" id="webhook" value="'.route('webhook', ['paystack']).'" disabled>
						<p class="form-text">'.e('You can add your webhooks <a href="https://dashboard.paystack.com/#/settings/developers" target="_blank">here</a>. For more info, please check the docs.').'</p>
					</div>                    
				</div>';
                View::push("<script>$('#paystack\\\[enabled\\\]').change(function(){ 
                    $('.alert-danger').remove();
                    if($(this).is(':checked') && $('#stripe\\\[enabled\\\]').is(':checked')){
                        $('#paystack\\\[enabled\\\]').parents('.form-group').before('<div class=\"alert alert-danger p-3\">".e('You cannot enable both Stripe and PayStack at the same time because they both work in the same way. You must choose one.')."</div>');
                    }
                 })</script>", 'custom')->toFooter();
		return $html;
    }
    /**
     * Checkout page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    public static function checkout(){

		if(!config('paystack') || !config('paystack')->enabled || !config('paystack')->public || !config('paystack')->secret) {            
            return false;
        }

        echo '<div id="paystack" class="paymentOptions"></div>';
        
    }
    /**
     * Payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public static function payment(Request $request, int $id, string $type){

        if(!config('paystack') || !config('paystack')->enabled || !config('paystack')->public || !config('paystack')->secret) {
            
            \GemError::log('Payment system "PayStack" not enabled or configured.');

            return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
        }

	  	if(!$plan = DB::plans()->first($id)){
			return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
	  	}

        $user = Auth::user();
		
        $plan->data = json_decode($plan->data);

		$term = e($plan->name);
		$text = e("Monthly");
		$price = $plan->price_monthly;
		$planid = $plan->slug."monthly";
        $plancode = $plan->data->paystack->month;

		if($type == "yearly" && $plan->price_yearly){
			$term = e($plan->name);
			$text = e("Yearly");
			$price = $plan->price_yearly;
            $plancode = $plan->data->paystack->year;
		}

		if($type == "lifetime" && $plan->price_lifetime){
			$term = e($plan->name);
			$text = e("Lifetime");
			$price = $plan->price_lifetime;
		}


        $uniqueid = Helper::rand(16, '', 'abcdef0123456789').$user->id;

		$sub = DB::subscription()->create();
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

		$user->save();

        $pricechanged = false;

        $name = explode(' ', $user->name);
    
        $http = Http::url(self::API.'/customer')->with('authorization', 'Bearer '.config('paystack')->secret)->body([        
                        'email' => $user->email,
                        'first_name' => $name[0],
                        'last_name' => $name[1] ?? ''
                    ])->post();

        if($customer = $http->bodyObject()){
            if(isset($customer->status) && $customer->status){
                $user->customerid = $customer->data->customer_code;
                $user->save();
            }
        }
        
        if($request->coupon && $coupon = DB::coupons()->where('code', clean($request->coupon))->first()){
			if(!$coupon->validuntil || strtotime("now") < strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) {
				$coupon->used++;
				$coupon->save();
				$price = round((1 - ($coupon->discount / 100)) * $price, 2);
				$sub->coupon = $coupon->id;
				$sub->save();
				$coupon->data = json_decode($coupon->data);
                $pricechanged = "{$coupon->discount}% Discount ";
			}
		}

		if($tax = DB::taxrates()->whereRaw('countries LIKE ?', ["%".clean($request->country)."%"])->first()){
			$price = round($price * (1+($tax->rate / 100)), 2);
            $pricechanged = "{$tax->rate}% Tax ";
		}

        if($type == 'lifetime'){
            $data = [            
                'amount' => $price*100,
                'currency' => strtoupper(config('currency')),
                'reference' => $uniqueid,
                'callback_url' => route('callback.paystack'),
                'channels' => ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer', 'eft'],
                'email' => $user->email,
                'metadata' => [
                    'userid' => $user->id,
                    'type' => $type,
                    'plan_id' =>$plan->id
                ]
            ];
        } else {

            if($pricechanged){
                
                $hash = md5($plan->name." {$text} - Custom Plan: {$pricechanged}");

                if(isset($plan->data->paystack->{"P{$hash}"})){
                    
                    $plancode = $plan->data->paystack->{"P{$hash}"};

                } else {
                    $request = Http::url(self::API.'/plan')->with('authorization', 'Bearer '.config('paystack')->secret)->body([
                        'name' => $plan->name." - Custom Plan: {$pricechanged}",
                        'amount' => $price*100,
                        'interval' => $type == 'yearly' ? 'annually' : 'monthly'
                    ])->post();

                    if($response = $request->bodyObject()){
                        $plancode = $response->data->plan_code;
                        if(isset($plan->data->paystack)){
                            $plan->data->paystack->{"P{$hash}"} = $plancode;
                        }                    
                        $plan->data = json_encode($plan->data);
                        $plan->save();
                    }
                }                        
            }

            $data = [        
                'amount' => $price*100,
                'plan' => $plancode,
                'currency' => strtoupper(config('currency')),
                'reference' => $uniqueid,
                'callback_url' => route('callback.paystack'),
                'email' => $user->email,
                'channels' => ['card', 'bank', 'ussd', 'qr', 'mobile_money', 'bank_transfer', 'eft'],
                'metadata' => [
                    'userid' => $user->id,
                    'type' => $type,
                    'plan_id' =>$plan->id
                ]
            ]; 
        }
        
        $request = Http::url(self::API.'/transaction/initialize')->with('authorization', 'Bearer '.config('paystack')->secret)->body($data)->post();

        if($response = $request->bodyObject()){
            
            if(isset($response->data->authorization_url)){
                return Helper::redirect()->to($response->data->authorization_url);
            }
        }

        \GemError::log('PayStack Error', (array) $request->bodyObject());

        return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
    }
    /**
     * PayStack Webhook
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param Request $request
     * @return void
     */
    public static function webhook(){

		if(!config('paystack') || !config('paystack')->enabled || !config('paystack')->public || !config('paystack')->secret) {
            
            \GemError::log('Payment system "PayStack" not enabled or configured.');

            return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
        }

        $payload = @file_get_contents("php://input");

        if(!isset($_SERVER["HTTP_X_PAYSTACK_SIGNATURE"])) return Response::factory(null, 400)->send();

        if($_SERVER["HTTP_X_PAYSTACK_SIGNATURE"] !== hash_hmac('SHA512', $payload, config('paystack')->secret)){
            return Response::factory(null, 400)->send();
        }

        $data = json_decode($payload);

        $data->paymentmethod = "PayStack";
        
        if($data->event == 'subscription.create' && $data->data->status == 'active'){
            
            if(!$user = DB::user()->where("customerid", $data->data->customer->customer_code)->first()) return print("User does not exist");
            
            $subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('date')->first();
			$subscription->data = json_encode($data);
			$subscription->tid = $data->data->subscription_code;
			$subscription->save();

			if(config('smtp')->user){
				$mailer = Email::factory('smtp', [
					'username' => config('smtp')->user,
					'password' => config('smtp')->pass,
					'host' => config('smtp')->host,
					'port' => config('smtp')->port
				]);
			} else {
				$mailer = Email::factory();
			}
	
			$mailer->from([config('email'), config('sitename')])
				   ->template(View::$path.'/email.php');
	
			$message = '<p><strong>Congrats! You have a new subscription from '.$user->email.'.</strong></p>';
	
			$mailer->to(config('email'))
					->send([
						'subject' => e('You have a new Subscriber'),
						'message' => function($template, $data) use ($message) {
							if(config('logo')){
								$title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
							} else {
								$title = '<h3>'.config('title').'</h3>';
							}
							return Email::parse($template, ['content' => $message, 'brand' => $title]);
						}
					]);
        }

        if($data->event == 'charge.success'){
            
            if(!$user = DB::user()->where("customerid", $data->data->customer->customer_code)->first()) return print("User does not exist");

            $subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('id')->first();

            if($subscription->plan == "yearly"){

                $new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($data->data->paid_at)));

            }elseif($subscription->plan == "lifetime"){

                $new_expiry = date("Y-m-d H:i:s", strtotime("+10 year", strtotime($data->data->paid_at)));

            }else{

                $new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($data->data->paid_at)));
            }

            $payment = DB::payment()->create();
            $payment->date = Helper::dtime('now');
            $payment->cid = $data->data->reference;
            $payment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
            $payment->amount =  $data->data->amount / 100;
            $payment->userid =  $user->id;
            $payment->status = "Completed";
            $payment->expiry =  $new_expiry;
            $payment->data = json_encode($data);

            $payment->save();

            $amount = $subscription->amount + ($data->data->amount / 100);

            $subscription->amount = $amount;
            $subscription->expiry = $new_expiry;
            $subscription->status = "Active";
            $subscription->save();

            $user->expiration = $new_expiry;
            $user->pro = 1;
            $user->planid = $subscription->planid;
            $user->save();

            \Core\Plugin::dispatch('payment.success', [$user, $subscription->planid, $payment->id]);
        }

        http_response_code(200);
    }
    /**
     * Cancel
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @return void
     */
    public static function cancel($user, $subscription){
    
        if(!config('paystack') || !config('paystack')->enabled || !config('paystack')->public || !config('paystack')->secret) {
            
            \GemError::log('Payment system "PayStack" not enabled or configured.');

            return Helper::redirect()->back()->with('danger', e('An error occurred, please try again. You have not been charged.'));
        }

        $data = json_decode($subscription->data);

		if(!isset($data->paymentmethod) || $data->paymentmethod != 'PayStack') return null;
        
        $sub = Http::url(self::API.'/subscription/'.$subscription->tid)->with('authorization', 'Bearer '.config('paystack')->secret)->with('content-type', 'application/json')->get();

        $response = $sub->bodyObject();
        
        $sub = Http::url(self::API.'/subscription/disable')->with('authorization', 'Bearer '.config('paystack')->secret)->with('content-type', 'application/json')->body(['code' => $subscription->tid, 'token' => $data->data->email_token])->post();        
        
        return null;
    }
    /**
     * Create Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param [type] $plan
     * @return void
     */
    public static function createplan($plan){

        if(!config('paystack') || !config('paystack')->enabled || !config('paystack')->public || !config('paystack')->secret) {
            return false;
        }

        $dataMonth = [
            'name' => $plan->name.' Monthly',
            'interval' => 'monthly',
            'currency' => strtoupper(config('currency')),
            'amount' => $plan->price_monthly*100
        ];

        $dataYear = [
            'name' => $plan->name.' Yearly',
            'interval' => 'annually',
            'currency' => strtoupper(config('currency')),
            'amount' => $plan->price_yearly*100
        ];

        $request = Http::url(self::API.'/plan')->with('authorization', 'Bearer '.config('paystack')->secret)->body($dataMonth)->post();

        if($response = $request->bodyObject()){
            $data['month'] = $response->data->plan_code;
        }

        $request = Http::url(self::API.'/plan')->with('authorization', 'Bearer '.config('paystack')->secret)->body($dataYear)->post();

        if($response = $request->bodyObject()){
            $data['year'] = $response->data->plan_code;
        }

        return $data;
    }
    /**
     * Update Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param [type] $request
     * @param [type] $plan
     * @return void
     */
    public static function updateplan($request, $plan){
        
        if(!config('paystack') || !config('paystack')->enabled || !config('paystack')->public || !config('paystack')->secret) {
            return false;
        }

        $data = json_decode($plan->data);

        $productid = ['month' => $data->paystack->month, 'year' => $data->paystack->year];

		if($request->price_monthly != $plan->price_monthly){
		
            $payload = [            
                'currency' => strtoupper(config('currency')),
                'amount' => $request->price_monthly*100
            ];
    
            $http = Http::url(self::API.'/plan/'.$data->paystack->month)->with('authorization', 'Bearer '.config('paystack')->secret)->body($payload)->put();      
		}

		if($request->price_yearly != $plan->price_yearly){
			
            $payload = [            
                'currency' => strtoupper(config('currency')),
                'amount' => $request->price_yearly*100
            ];
    
            $http = Http::url(self::API.'/plan/'.$data->paystack->year)->with('authorization', 'Bearer '.config('paystack')->secret)->body($payload)->put();    	  			                
		}

		return $productid;        
    }
    /**
     * Sync Plans
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param [type] $plan
     * @return void
     */
    public static function syncplan($plan){
        return self::createplan($plan);
    }
    /**
     * Callback
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 1.0
     * @param \Core\Request $request
     * @return void
     */
    public static function callback(Request $request){

        if($request->reference){
            $request = Http::url(self::API.'/transaction/verify/'.clean($request->reference))->with('authorization', 'Bearer '.config('paystack')->secret)->get();

            if($response = $request->bodyObject()){
                if(isset($response->data->status) && $response->data->status == 'success'){
                    return Helper::redirect()->to(route('dashboard'))->with('success', e('Your payment has been confirmed and your subscription has been activated.'));
                }
            }
        }

        return Helper::redirect()->to(route('dashboard'))->with('danger', e('Your payment has been canceled.'));
    }

    /**
	 * Redirect to Portal
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @param [type] $user
	 * @return void
	 */
	public static function manage($user, $subscription = null){}
}