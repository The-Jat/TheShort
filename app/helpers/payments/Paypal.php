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

class Paypal{
    /**
     * Generate Form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function settings(){
        $config = config('paypal');

        if(!$config && !isset($config->enabled)){

            $settings = DB::settings()->create();

            $settings->config = 'paypal';
            $settings->var = json_encode(['enabled' => config('pt') == 'paypal', 'email' => config('paypal_email')]);
            $settings->save();
            $config = json_decode($settings->var);
        }


        $html = '<div class="form-group">
                    <label for="paypal[enabled]" class="form-label fw-bold">'.e('Paypal Basic Checkout').'</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="paypal[enabled]" name="paypal[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="paypalholder">
                        <label class="form-check-label" for="paypal[enabled]">'.e('Enable').'</label>
                    </div>
                    <p class="form-text">'.e('Collect payments via basic paypal checkout.').'</p>
                </div>
                <div id="paypalholder" class="toggles '.(!$config->enabled ? 'd-none' : '') .'">
                    <div class="form-group">
                        <label for="paypal[email]" class="form-label fw-bold">'.e('PayPal Email').'</label>
                        <input type="text" class="form-control p-2" name="paypal[email]" placeholder="" id="paypal[email]" value="'.$config->email.'">
                        <p class="form-text">'.e('Payments will be sent to this address. Please make sure that you enable IPN and enable notification.').'</p>
                    </div>
                    <div class="form-group">
                        <label for="paypalipn" class="form-label fw-bold">'.e('PayPal IPN').'</label>
                        <input type="text" class="form-control p-2" placeholder="" id="paypalipn" value="'.route('webhook.paypal').'" disabled>
                        <p class="form-text">'.e('For more info <a href="https://developer.paypal.com/api/nvp-soap/ipn/IPNSetup/" target="_blank">click here</a>').'</p>
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
    public static function checkout(){
        echo '<div id="paypal" class="paymentOptions"></div>';
    }
    /**
     * Request
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param Request $request
     * @return void
     */
    public static function payment(Request $request, int $id, string $type){

        if(!config('paypal') || !config('paypal')->enabled || !config('paypal')->email) {
            
            \GemError::log('Payment system "PayPal" not enabled or configured.');

            return back()->with('danger', e('An error ocurred, please try again. You have not been charged.'));
        }

        if(!$plan = DB::plans()->first($id)){
			return back()->with('danger', e('An error ocurred, please try again. You have not been charged.'));
	  	}			

        if($type == "yearly"){
			$fee = $plan->price_yearly;
			$period = "Yearly";	
		}elseif($type == "lifetime"){
			$fee = $plan->price_lifetime;
			$period = "Lifetime";	
		}else{
			$fee = $plan->price_monthly;
			$period = "Monthly";
		}
        
        $renew = $request->session('renew') ? 1 : 0;

        $options = [
            "cmd" => "_xclick",
            "business" => config('paypal')->email,
            "currency_code" => config('currency'),
            "item_name" => "{$plan->name} $type Membership (Pro)",
            "custom"  =>  json_encode(["userid" => Auth::id(), "period" => $period, "renew" => $renew, "planid" => $plan->id]),
            "amount" => $fee,
            "return" => url('ipn'),
            "notify_url" => url("ipn"),
            "cancel_return" => url("ipn?cancel=true")
        ];

        if(DEBUG){
			$payurl = "https://www.sandbox.paypal.com/cgi-bin/webscr?";
		}else{
			$payurl = "https://www.paypal.com/cgi-bin/webscr?";
		}
        
        return Helper::redirect()->to($payurl.http_build_query($options));
    }
    /**
     * PayPal IPN
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param Request $request
     * @return void
     */
    public static function webhook(Request $request){

        if($request->canceled || $request->cancel) return Helper::redirect()->to(route('dashboard'))->with("warning", e("Your payment has been canceled."));

        $listener = new IpnListener();

        try {
            $listener->requirePostMethod();
            $verified = $listener->processIpn();   
        } catch (\Exception $e) {
            \GemError::log('Paypal Error: '.$e->getMessage());
            return Helper::redirect()->to(route('dashboard'))->with("info", e("Payment complete. We will upgrade your account as soon as the payment is verified."));
        }
        
        $info = [];

        $info['paymentmethod'] = 'paypal';
        
        if($verified){

            if($request->custom){
                $data = json_decode($request->custom);

                if(!$plan = DB::plans()->first($data->planid)){
                    return \GemError::log('Paypal Error: Plan does not exist');
                }
                
                if(!$user = DB::user()->first($data->userid)){
                    return \GemError::log('Paypal Error: User does not exist');
                }
                
                if($data->renew === "1"){

                    if($data->period == "Yearly"){
                        
                        $expires = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($user->expiration)) . " + 1 year"));
                        $info["duration"] = "1 Year";

                    }elseif($data->period == "Lifetime"){
                        
                        $expires = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($user->expiration)) . " + 20 years"));
                        $info["duration"] = "20 Years";

                    }else{
                        $expires = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($user->expiration)) . " + 1 month"));
                        $info["duration"] = "1 Month";
                    }

                } else {

                    if($data->period == "Yearly"){
                        
                        $expires = date("Y-m-d H:i:s", strtotime("+ 1 year"));
                        $info["duration"] = "1 Year";

                    }elseif($data->period == "Lifetime"){
                        
                        $expires = date("Y-m-d H:i:s", strtotime("+ 20 years"));
                        $info["duration"] = "20 Years";

                    }else{
                        $expires = date("Y-m-d H:i:s", strtotime("+ 1 month"));
                        $info["duration"] = "1 Month";
                    }

                }

                if($request->pending_reason){
                    $info["pending_reason"] = $request->pending_reason;
                }
                $info["payer_email"] = $request->payer_email;
                $info["payer_id"] = $request->payer_id;
                $info["payment_date"] = $request->payment_date;

                if($request->payment_status == "refunded") return;

                if($payment = DB::payment()->where('tid', $request->txn_id)->first()){
                    $payment->status =  $request->payment_status;
                    $payment->save();
                    return Helper::redirect()->to(route('dashboard'));
                }

                $payment = DB::payment()->create();

                $payment->date = Helper::dtime();
                $payment->tid = $request->txn_id;
                $payment->amount =  $request->mc_gross;
                $payment->status =  $request->payment_status;
                $payment->userid =  $data->userid;
                $payment->expiry = $expires;
                $payment->data = json_encode($info);
                $payment->save();

                $user->last_payment = Helper::dtime();
                $user->expiration = $expires;
                $user->pro = 1;
                $user->planid = $plan->id;
                $user->save();
                
                \Core\Plugin::dispatch('payment.success', [$user, $plan->id, $payment->id]);

                http_response_code(200);
                exit;
            }

            if(\Helpers\App::possible() && !$request->custom && $request->product_name){

                $userid = str_replace('userid:', '', $request->product_name);
                
                if(!$user = DB::user()->where("id", $userid)->first()) return \GemError::log('Paypal Error: User does not exist');

                $subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('date')->first();

                if($request->profile_status !== "Active") return null;

                if($subscription->plan == "yearly"){

                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($request->payment_date)));

                }else{

                    $new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($request->payment_date)));
                }

                $payment = DB::payment()->create();
                $payment->date = Helper::dtime($request->payment_date, 'Y-m-d H:i:s');
                $payment->cid = $request->txn_id;
                $payment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
                $payment->amount =  $request->payment_gross;
                $payment->userid =  $user->id;
                $payment->status = "Completed";
                $payment->expiry =  $new_expiry;
                $payment->data =  json_encode($_POST);

                $payment->save();

                $amount = $subscription->amount + $payment->amount;

                $subscription->amount = $amount;
                $subscription->expiry = $new_expiry;
                $subscription->status = "Active";
                $subscription->save();

                $user->expiration = $new_expiry;
                $user->pro = 1;
                $user->planid = $subscription->planid;
                $user->save();
                \Core\Plugin::dispatch('payment.success', [$user, $subscription->planid, $payment->id]);
                http_response_code(200);
                exit;
            }
            // return Helper::redirect()->to(route('dashboard'))->with("info", e("Your payment was successfully made. Thank you."));
        }

        return Helper::redirect()->to(route('dashboard'))->with("warning", e("Your payment has been canceled."));
    }

}