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

class Paddle {

    /**
     * Checkout API URls
     */
    const CHECKOUT = "https://checkout.paddle.com/api/";

    /**
     * Vendor API URL
     */
    const VENDOR = "https://vendors.paddle.com/api/2.0";

    /**
     * Admin Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.6
     * @return void
     */
    public static function settings(){

        $config = config('paddle');

		if(!$config && !isset($config->enabled)){
					
			$settings = DB::settings()->create();

			$settings->config = 'paddle';
			$settings->var = json_encode(['enabled' => false, 'secret' => null, 'public'=> null, 'vendor' => null, 'monthly' => null, 'yearly' => null]);
			$settings->save();
			$config = json_decode($settings->var);
		}

		$html = '<div class="form-group">
					<label for="paddle[enabled]" class="form-label fw-bold">'.e('Paddle Classic').'</label>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" data-binary="true" id="paddle[enabled]" name="paddle[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="paddleholder">
						<label class="form-check-label" for="paddle[enabled]">'.e('Enable').'</label>
					</div>
					<p class="form-text">'.e('Collect payments securely with Paddle. This payment method is not available for new Paddle accounts. You need to use Paddle Billing instead.').'</p>
				</div>
				<div id="paddleholder" class="toggles '.(!$config->enabled ? 'd-none' : '') .'">
					<div class="form-group">
						<label for="paddle[vendor]" class="form-label fw-bold">'.e('Paddle Vendor ID ').'</label>
						<input type="text" class="form-control p-2" name="paddle[vendor]" placeholder="" id="paddle[vendor]" value="'.$config->vendor.'">
						<p class="form-text">'.e('Get your vendor id from here once logged in <a href="https://vendors.paddle.com/authentication" target="_blank">click here</a>').'</p>
					</div>
					<div class="form-group">
						<label for="paddle[secret]" class="form-label fw-bold">'.e('Paddle API Key').'</label>
						<input type="text" class="form-control p-2" name="paddle[secret]" placeholder="" id="paddle[secret]" value="'.$config->secret.'">
						<p class="form-text">'.e('Get your paddle keys from here once logged in <a href="https://vendors.paddle.com/authentication" target="_blank">click here</a>').'</p>
					</div>
					<div class="form-group">
						<label for="paddle[public]" class="form-label fw-bold">'.e('Paddle Public Key').'</label>
						<textarea class="form-control p-2" name="paddle[public]" placeholder="" id="paddle[public]" rows="10">'.$config->public.'</textarea>
						<p class="form-text">'.e('Get your paddle public key from here once logged in <a href="https://vendors.paddle.com/public-key" target="_blank">click here</a>').'</p>
					</div>
					<div class="form-group">
						<label for="webhook" class="form-label fw-bold">'.e('Webhook URL').'</label>
						<input type="text" class="form-control p-2" id="webhook" value="'.route('webhook', ['paddle']).'" disabled>
						<p class="form-text">'.e('You can add your webhooks <a href="https://vendors.paddle.com/alerts-webhooks" target="_blank">here</a>. For more info, please check the docs.').'</p>
					</div>
                    <div class="form-group">
						<label for="paddle[monthly]" class="form-label fw-bold">'.e('Monthly Plan ID').'</label>
						<input class="form-control p-2" name="paddle[monthly]" placeholder="" id="paddle[monthly]" value="'.$config->monthly.'">
						<p class="form-text">'.e('You need to create a single monthly plan manually and insert the plan ID here. View documentation for more information.').'</p>
					</div>
                    <div class="form-group">
						<label for="paddle[yearly]" class="form-label fw-bold">'.e('Yearly Plan ID').'</label>
						<input class="form-control p-2" name="paddle[yearly]" placeholder="" id="paddle[yearly]"  value="'.$config->yearly.'">
						<p class="form-text">'.e('You need to create a single yearly plan manually and insert the plan ID here. View documentation for more information.').'</p>
					</div>
				</div>';
                View::push("<script>$('#paddle\\\[enabled\\\]').change(function(){ 
                    $('.alert-danger').remove();
                    if($(this).is(':checked') && $('#stripe\\\[enabled\\\]').is(':checked')){
                        $('#paddle\\\[enabled\\\]').parents('.form-group').before('<div class=\"alert alert-danger p-3\">".e('You cannot enable both Stripe and Paddle at the same time because they both work in the same way. You must choose one.')."</div>');
                    }
                 })</script>", 'custom')->toFooter();
		return $html;
    }
    /**
     * Checkout page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.6
     * @return void
     */
    public static function checkout(){

		if(!config('paddle') || !config('paddle')->enabled || !config('paddle')->public || !config('paddle')->secret) {            
            return false;
        }

        echo "<div id=\"paddle\" class=\"paddle paymentOptions\"></div>";

        View::push("<script src=\"https://cdn.paddle.com/paddle/paddle.js\"></script>
                    <script type=\"text/javascript\">
                        let form = $('#payment-form');
                        form.find('button[type=submit]').click(function(e){
                            if($('input[name=payment]:checked').val() == 'paddle') {
                                e.preventDefault();      
                                let text = form.find('button[type=submit]').text();
                                Paddle.Setup({
                                    vendor: ".config('paddle')->vendor."
                                });
                                $.ajax({
                                    type: 'POST',
                                    url: form.attr('action'),
                                    data: form.serialize(),
                                    dataType: 'json',
                                    beforeSend: function(){                
                                        form.find('button[type=submit]').html('<div class=\"preloader\"><div class=\"spinner-border spinner-border-sm text-white\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></div>').attr('disabled', 'disabled');
                                    },
                                    complete: function(){
                                        $('.preloader').remove();
                                        form.find('button[type=submit]').text(text).removeAttr('disabled');
                                    },
                                    success: function(response){
                                        $('input[name=_token]').val(response.token);
                                        if(response.error == false){
                                            Paddle.Checkout.open({ override: response.url });                                           
                                        } else{
                                            $.notify({message: response.message},{type: 'danger', placement: {from: 'top', align: 'left'}});
                                        }
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
     * @version 6.6
     * @param \Core\Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public static function payment(Request $request, int $id, string $type){

        if(!config('paddle') || !config('paddle')->enabled || !config('paddle')->vendor || !config('paddle')->secret) {
            
            \GemError::log('Payment system "Paddle" not enabled or configured.');

            return Response::factory(['error' => true, 'message' => e('An error occurred, please try again. You have not been charged.'), 'token' => csrf_token()])->json();
        }

	  	if(!$plan = DB::plans()->first($id)){
			return Response::factory(['error' => true, 'message' => e('An error occurred, please try again. You have not been charged.'), 'token' => csrf_token()])->json();
	  	}

        $user = Auth::user();
		
		$term = e($plan->name);
		$text = e("Monthly");
		$price = $plan->price_monthly;
		$planid = $plan->slug."monthly";
	
		if($type == "yearly" && $plan->price_yearly){
			$term = e($plan->name);
			$text = e("Yearly");
			$price = $plan->price_yearly;
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
        
        if($request->coupon && $coupon = DB::coupons()->where('code', clean($request->coupon))->first()){
			if($coupon->validuntil && strtotime("now") < strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) {
				$coupon->used++;
				$coupon->save();
				$price = round((1 - ($coupon->discount / 100)) * $price, 2);
				$sub->coupon = $coupon->id;
				$sub->save();
				$coupon->data = json_decode($coupon->data);
			}
		}

		if($tax = DB::taxrates()->whereRaw('countries LIKE ?', ["%".clean($request->country)."%"])->first()){
			$price = round($price * (1+($tax->rate / 100)), 2);
		}

        if($type == 'lifetime'){
            $data = [
                'vendor_id' => config('paddle')->vendor,
                'vendor_auth_code' => config('paddle')->secret,
                'title' => Helper::truncate($term.' - '.$text, 200),
                'prices' => [
                    strtoupper(config('currency')).':'.$price
                ],
                'custom_message' => Helper::truncate(empty($plan->description) ? $term : $plan->description, 175),
                'discountable' => 0,
                'webhook_url' => route('webhook', ['paddle']),
                'return_url' => route('callback.paddle').'?paymentid={checkout_hash}',
                'marketing_consent' => 1,
                'quantity_variable'=> 0,
                'customer_country' => Helper::Country($request->country, false, true),
                'customer_email' => $user->email,
                'customer_postcode' => $request->zip,
                'passthrough' => "user_id={$user->id}&type={$type}&plan_id={$plan->id}"
            ];
        } else {
            $data = [
                'vendor_id' => config('paddle')->vendor,
                'vendor_auth_code' => config('paddle')->secret,
                'title' => Helper::truncate($term.' - '.$text, 200),
                'product_id' => $type == 'yearly' ? config('paddle')->yearly : config('paddle')->monthly,
                'prices' => [
                    strtoupper(config('currency')).':'.$price
                ],
                'recurring_prices' => [
                    strtoupper(config('currency')).':'.$price
                ],
                'custom_message' => Helper::truncate($plan->description, 175),
                'discountable' => 0,
                'return_url' => route('callback.paddle').'?paymentid={checkout_hash}',
                'marketing_consent' => 1,
                'quantity_variable'=> 0,
                'customer_country' => Helper::Country($request->country, false, true),
                'customer_email' => $user->email,
                'customer_postcode' => $request->zip,
                'passthrough' => "user_id={$user->id}&type={$type}&plan_id={$plan->id}"
            ];
        }
        
        
        $request = Http::url(self::VENDOR.'/product/generate_pay_link')->with('content-type', 'application/json')->body($data)->post();

        if($response = $request->bodyObject()){
            
            if(isset($response->response->url)){
                return Response::factory(['error' => false, 'url' => $response->response->url, 'token' => csrf_token()])->json();
            }
        }

        \GemError::log('Paddle Error', (array) $request->bodyObject());

        return Response::factory(['error' => true, 'message' => e('An error occurred, please try again. You have not been charged.'), 'token' => csrf_token()])->json();
    }
    /**
     * Paddle Webhook
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.5
     * @param Request $request
     * @return void
     */
    public static function webhook(Request $request){

		if(!config('paddle') || !config('paddle')->enabled || !config('paddle')->vendor || !config('paddle')->secret) {
            
            \GemError::log('Payment system "Paddle" not enabled or configured.');

            return null;
        }
        
        $public_key = openssl_get_publickey(config('paddle')->public);
        
        $signature = base64_decode($_POST['p_signature']);
        
        $fields = $_POST;
        unset($fields['p_signature']);
        
        ksort($fields);
        foreach($fields as $k => $v) {
            if(!in_array(gettype($v), array('object', 'array'))) {
                $fields[$k] = "$v";
            }
        }
        $data = serialize($fields);
        
        if(openssl_verify($data, $signature, $public_key, OPENSSL_ALGO_SHA1) != 1){
            \GemError::log('Paddle Webhook Error: Key does not match.');
            http_response_code(400);
            exit();            
        }

        if(!$request->alert_name || !$request->passthrough) {
            \GemError::log('Paddle Webhook Error: Invalid webhook data.');
            http_response_code(400);
            exit();             
        }

        parse_str($request->passthrough, $data);
        
        $array = $request->all();
        $array->paymentmethod = "Paddle";
        
        if($request->alert_name == 'subscription_created'){
            
            if(!$user = DB::user()->where("id", $data['user_id'])->first()) return print("User does not exist");

            $subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('id')->first();        

			$subscription->tid = $request->subscription_id;
            $subscription->data = json_encode($array);
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

        if($request->alert_name == 'subscription_payment_succeeded' || $request->alert_name == 'payment_succeeded'){
            
            if(!$user = DB::user()->where("id", $data['user_id'])->first()) return print("User does not exist");

            $subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('id')->first();

            if($subscription->plan == "yearly"){

                $new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($request->event_time)));

            }elseif($subscription->plan == "lifetime"){

                $new_expiry = date("Y-m-d H:i:s", strtotime("+10 year", strtotime($request->event_time)));

            }else{

                $new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($request->event_time)));
            }

            $payment = DB::payment()->create();
            $payment->date = Helper::dtime('now');
            $payment->cid = $request->order_id;
            $payment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
            $payment->amount =  $request->sale_gross;
            $payment->userid =  $user->id;
            $payment->status = "Completed";
            $payment->expiry =  $new_expiry;
            $payment->data = json_encode($array);

            $payment->save();

            $amount = $subscription->amount + ($request->sale_gross);

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
     * @version 6.6
     * @return void
     */
    public static function cancel($user, $subscription){
    
        if(!config('paddle') || !config('paddle')->enabled || !config('paddle')->vendor || !config('paddle')->secret) {
            return false;
        }

        $data = json_decode($subscription->data);

		if(!isset($data->paymentmethod) || $data->paymentmethod != 'Paddle') return null;

        if(!isset($data->cancel_url)) return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));

        $data = [
            'vendor_id' => config('paddle')->vendor,
            'vendor_auth_code' => config('paddle')->secret,
            'subscription_id' => $subscription->tid
        ];
    
        $request = Http::url(self::VENDOR.'/subscription/users_cancel')->with('content-type', 'application/json')->body($data)->post();
        
        return null;
    }
    /**
     * Create Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.6
     * @param [type] $plan
     * @return void
     */
    public static function createplan($plan){

        if(!config('paddle') || !config('paddle')->enabled || !config('paddle')->vendor || !config('paddle')->secret) {
            return false;
        }

        return false;

        $dataMonth = [
            'vendor_id' => config('paddle')->vendor,
            'vendor_auth_code' => config('paddle')->secret,
            'plan_name' => $plan->name.' Monthly',
            'plan_length' => 1,
            'plan_type' => 'month',
            'main_currency_code' => ucfirst(config('currency')),
            'recurring_price_'.strtolower(config('currency')) => $plan->price_monthly
        ];

        $dataYear = [
            'vendor_id' => config('paddle')->vendor,
            'vendor_auth_code' => config('paddle')->secret,
            'plan_name' => $plan->name.' Yearly',
            'plan_length' => 1,
            'plan_type' => 'year',
            'main_currency_code' => ucfirst(config('currency')),
            'recurring_price_'.strtolower(config('currency')) => $plan->price_yearly
        ];


        $request = Http::url(self::VENDOR.'/subscription/plans_create')->body($dataMonth)->post();

        if($response = $request->bodyObject()){
            $data['month'] = $response->response->product_id;
        }

        $request = Http::url(self::VENDOR.'/subscription/plans_create')->body($dataYear)->post();

        if($response = $request->bodyObject()){
            $data['year'] = $response->response->product_id;
        }

        return $data;
    }
    /**
     * Sync Plans
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.6
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
     * @version 6.5
     * @param \Core\Request $request
     * @return void
     */
    public static function callback(Request $request){
        
        if($request->paymentid) {
            
            \Core\Auth::check();
    
            $user = user();
    
            $subscription = \Core\DB::subscription()->where('userid', $user->id)->orderByDesc('id')->first();
            
            return Helper::redirect()->to(route('confirmation', ['id' => $subscription->id]))->with('success', e('Your payment was successfully made. Thank you.'));
        }
    
        return Helper::redirect()->to(route('dashboard'))->with('danger', e('Your payment has been canceled.'));
    }

    /**
	 * Redirect to Portal
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.6
	 * @param [type] $user
	 * @return void
	 */
	public static function manage($user, $subscription = null){

        $data = json_decode($subscription->data);

		if(!isset($data->paymentmethod) || $data->paymentmethod != 'Paddle') return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));

		if(!isset($data->update_url)) return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));

		header("Location: ".$data->update_url);
		exit();
	}
}