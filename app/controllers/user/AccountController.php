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

namespace User;

use Core\Helper;
use Core\View;
use Core\DB;
use Core\Auth;
use Core\Request;
use Core\Email;
use Helpers\CDN;

class Account {     

    use \Traits\Payments;
    
    /**
     * Membership page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function billing(){

        $user = Auth::user();

        if($user->team()){
            return Helper::redirect()->to(route('settings'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        
        $plan = $user->plan();
        $plan["urls"] = $plan['numurls'];
        $plan["ismonthly"] = isset($plan['counttype']) && $plan['counttype'] == 'monthly';
        $plan["clicks"] = $plan['numclicks'];
        $plan["permission"] = json_decode($plan['permission']);
        
        $subscriptions = [];
        if(\Helpers\App::possible()){
            $pending = false;
            foreach(DB::subscription()->where('userid', $user->id)->orderByDesc('date')->findMany() as $sub){
                if($sub->status == 'Pending'){
                    if(!$pending) {
                        $pending = true;
                    }else{
                        continue;
                    }
                }
                $subscriptions[] = $sub;
            }
        }

        $payments = [];
        foreach(DB::payment()->where('userid', $user->id)->orderByDesc('date')->findMany() as $payment){
            if($payment->status == 'Refunded' && is_null($payment->amount)) continue;
            $payments[] = $payment;
        }

        View::set('title', e('Billing'));

        return View::with("user.billing", compact('user', 'plan', 'subscriptions', 'payments'))->extend('layouts.dashboard');
    }

    /**
     * Cancel Billing
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function billingCancel(Request $request){
        
        $user = Auth::user();

        if($user->admin){
            return Helper::redirect()->back()->with('danger', e("Wow there. You are an admin. You can't cancel your membership."));
        }

        if(!$user->pro()) {
            return Helper::redirect()->back()->with('danger', e('Something went wrong, please try again.'));
        }

        if(strlen($request->password) < 5) {
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }
        
        Helper::set("hashCost", 8);

        if(!Helper::validatePass($request->password, $user->password)){
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }

        if($user->trial){
            $user->expiration = Helper::dtime();
            $user->pro = 0;
            $user->trial = 0;
            $user->save();
            return Helper::redirect()->back()->with('success', e("Your trial has been canceled."));
        }
        
        $response = null;
        if(\Helpers\App::possible()){
            if($subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('id')->first()){
                foreach($this->processor() as $name => $processor){
                    if(!config($name) || !config($name)->enabled || !$processor['cancel']) continue;
                    $response = call_user_func_array($processor['cancel'], [$user, $subscription]);
                }    
                $subscription->status = 'Canceled';
                $subscription->reason = clean($request->reason);
                if($subscription->plan != 'monthly') {
                    $subscription->expiry = Helper::dtime();
                    $user->expiration = Helper::dtime();
                }
                $subscription->save();
            }
        }

        $payment = DB::payment()->create();
        $payment->date = Helper::dtime();
        $payment->tid = isset($subscription) && $subscription ? "r_{$subscription->uniqueid}" : "r_".Helper::rand(12);
        $payment->amount =  $response;
        $payment->status =  "Refunded";
        $payment->userid =  $user->id;
        $payment->expiry =  null;
        $payment->data  =  null;

        $payment->save();

        $user->save();


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

        $message = "<p>The user {$user->email} has canceled their subscription. Please review the cancellation and refund user if eligible.</p>";

        $mailer->to(config('email'))
                ->send([
                    'subject' => e('Subscription Canceled'),
                    'message' => function($template, $data) use ($message) {
                        if(config('logo')){
                            $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                        } else {
                            $title = '<h3>'.config('title').'</h3>';
                        }
                        return Email::parse($template, ['content' => $message, 'brand' => $title]);
                    }
                ]);

        return Helper::redirect()->back()->with('success', e('Your subscription has been canceled.'));
    }

    /**
     * View Payment Invoice
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $id
     * @return void
     */
    public function invoice(string $id){

        $user = Auth::user();

        if(!$payment = DB::payment()->where('tid', $id)->where('userid', $user->id)->first()){
            return Helper::redirect()->back()->with('danger', e('Payment not found. Please try again.'));
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
        $payment->data = json_decode($payment->data ?? '');

        if(isset($payment->data->planid)){
            if($plan = DB::plans()->where('id', $payment->data->planid)->first()){
                $payment->data->planname = $plan->name;
            }
        } else {
            try{
                $date = date('Y-m-d H:i:s', strtotime($payment->date));
                $subscription = DB::subscription()->where('userid', $user->id)->whereRaw("DATE(date) <= '{$date}'")->orderByDesc('date')->first();

                if($subscription && $plan = DB::plans()->where('id', $subscription->planid)->first()){
                    $payment->data->planname = $plan->name;
                }

            } catch(\Exception $e){

            }
        }

        View::push('<style>@media print {#sidebar,footer,nav.navbar,.page-header{display: none !important;}}</style>', 'custom')->toHeader();

        View::set('title', e('View Invoice'));

        return View::with('invoice', compact('payment', 'user'))->extend('layouts.dashboard');
    }

    /**
     * Terminate Account and Delete Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function terminate(Request $request){

        if(!config("allowdelete")) return stop(404);
        
        $user = Auth::user();
        $id = Auth::id();


        if($user->admin){
            return Helper::redirect()->back()->with('danger', e('As an admin, you cannot delete your account from this page.'));
        }
        
        if(strlen($request->cpassword) < 5) {
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }
        
        Helper::set("hashCost", 8);

        if(!Helper::validatePass($request->cpassword, $user->password)){
            return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
        }

        if($user->pro()){
            if(\Helpers\App::possible()){
               if($subscription = DB::subscription()->where('userid', $user->id)->first()){
                    foreach($this->processor() as $name => $processor){
                        if(!config($name) || !config($name)->enabled || !$processor['cancel']) continue;
                        call_user_func_array($processor['cancel'], [$user, $subscription]);
                    }
            
                    $subscription->expiry = Helper::dtime();
                    $subscription->status = 'Canceled';
                    $subscription->reason = clean($request->reason);
                    $subscription->save();
               }
            }
    
            $user->pro = 0;
            $user->expiration = Helper::dtime();
            $user->save();            
        }

        $mailer = \Helpers\Emails::setup();

        $message = e('Your account has been deleted successfully and your data has been wiped out. If you have any questions please don\'t hesitate to contact us.');

        $mailer->to(Auth::user()->email)
                ->send([
                    'subject' => e('Your account has been terminated.'),
                    'message' => function($template, $data) use ($message) {
                        if(config('logo')){
                            $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                        } else {
                            $title = '<h3>'.config('title').'</h3>';
                        }
                        return Email::parse($template, ['content' => $message, 'brand' => $title]);
                    }
                ]);
          
        DB::affiliates()->whereRaw("refid = '{$id}' OR userid = '{$id}'")->deleteMany();
        DB::bundle()->where('userid', $id)->deleteMany();
        DB::channels()->where('userid', $id)->deleteMany();
        DB::domains()->where('userid', $id)->deleteMany();
        DB::imports()->where('userid', $id)->deleteMany();
        DB::members()->where('userid', $id)->deleteMany();
        DB::overlay()->where('userid', $id)->deleteMany();
        DB::pixels()->where('userid', $id)->deleteMany();
        DB::profiles()->where('userid', $id)->deleteMany();
        DB::qrs()->where('userid', $id)->deleteMany();
        DB::splash()->where('userid', $id)->deleteMany();
        DB::stats()->where('urluserid', $id)->deleteMany();
        DB::tochannels()->where('userid', $id)->deleteMany();
        DB::url()->where('userid', $id)->deleteMany();
        DB::verification()->where('userid', $id)->deleteMany();        
        DB::payment()->where('userid', $id)->deleteMany();     
        DB::appevents()->where('userid', $id)->deleteMany();
           
        try{
            DB::subscription()->where('userid', $id)->deleteMany(); 
        } catch(\Exception $e){
            
        }
        $user->delete();
        Auth::logout();
        
        return Helper::redirect()->to(route('login'))->with('success', e('Your account has been successfully terminated.'));
    }
    
    /**
     * Account Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @param \Core\Request $request
     * @return void
     */
    public function settings(Request $request){
        
        $user = Auth::user();

        $QR2FA = null;
        $secret = null;
        $gAuth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        $title = explode(" ", config("title"));

        if($user->secret2fa){

            $QR2FA = \Helpers\QR::factory(['type' => 'oauth', 'data' => ['label' => $user->email, 'secret' => $user->secret2fa, 'issuer' => $title[0]]])->format('svg')->create('uri');

        } else {

            if(!$secret = Helper::cacheGet('user_twofa_'.user()->id)) {
                $secret = $gAuth->generateSecret();
                $request->session('qr2fa_temp', $secret);
                Helper::cacheSet('user_twofa_'.user()->id, $secret, 120);
            }

            $QR2FA = \Helpers\QR::factory(['type' => 'oauth', 'data' => ['label' => $user->email, 'secret' => $secret, 'issuer' => $title[0]]])->format('svg')->create('uri');        
        }
        
        $user->address = json_decode($user->address ?? '');

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        CDN::load('cropper');
        
        View::set('title', e('Settings'));

        return View::with("user.settings", compact('user', 'QR2FA', 'secret'))->extend('layouts.dashboard');
    }
    /**
     * Save Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function settingsUpdate(Request $request){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        $errors = '';

        if(!$user->email && (!$request->email || !$request->validate($request->email, 'email'))) $errors .= e("Please enter a valid email."). '</br>';
        
        // Validate email
        if($request->email != $user->email){
            if(DB::user()->where('email', Helper::RequestClean($request->email))->first()){
                $errors .= e("An account is already associated with this email."). '</br>';
            }
            
            if(config('user_activate')){
                $user->active = 0;
            }

            $user->email = Helper::RequestClean($request->email);
        }

        // Validate username
        if($request->username && $request->username != $user->username){

            if(!$request->validate($request->username, 'username')) $errors .= e("Please enter a valid username."). '</br>';

            if(DB::user()->where('username', Helper::RequestClean($request->username))->first()) $errors .= e("This username has already been used. Please try again.").'</br>';

            $user->username = Helper::RequestClean($request->username);
        }	

        // Check Password
        $passwordchanged = false;

        if($request->password){        

            if(strlen($request->password) < 5) $errors .= e("Password must contain at least 5 characters.").'</br>';

            if(!$request->cpassword || $request->password != $request->cpassword) $errors .= e("Passwords don't match.").'</br>';
        
            Helper::set("hashCost", 8);
            
            if(Helper::validatePass($request->password, $user->password)) $errors .= e("Passwords is the same as the old password.").'</br>';
            
            //Update Password
            if(!$errors){
                $user->password = Helper::Encode($request->password);
                $passwordchanged = true;
            }            
        }

        $appconfig = appConfig('app');
        
        // Update Avatar
        if($image = $request->file('avatar')){
            
            if(!$image->mimematch || !in_array($image->ext, explode(',', config('extensions')->avatar))) return Helper::redirect()->back()->with('danger', e('Avatar must be the one of the following formats and size: {f} - {s}kb.', null, ['f' => config('extensions')->avatar, 's' => config('sizes')->avatar]));

            if($image->sizekb >=  config('sizes')->avatar) $errors .= e('Avatar must be the one of the following formats and size: {f} - {s}kb.', null, ['f' => config('extensions')->avatar, 's' => config('sizes')->avatar]);

            [$width, $height] = getimagesize($image->location);
            
            if(empty($errors)){
                            
                if($user->avatar){
                    \Helpers\App::delete($appconfig['storage']['avatar']['path'].'/'.$user->avatar);
                }
                $filename = Helper::rand(6)."_".str_replace(['#', ' '], '-', $image->name);

                if($width > 500 || $height > 500) \Helpers\App::resizeTmp($image->location, $image->ext, 500);                            
                
                $request->move($image, $appconfig['storage']['avatar']['path'], $filename);   
                $user->avatar = $filename;
            }
        }

        if($request->removeavatar){
            if($user->avatar){
                \Helpers\App::delete( $appconfig['storage']['avatar']['path'].'/'.$user->avatar);
            }
            $user->avatar = null;
        }

        if($errors) return Helper::redirect()->back()->with('danger', $errors);

        $user->name =  $request->name ? Helper::RequestClean($request->name) : '';
        $user->media = in_array($request->media, array("0","1")) ? Helper::RequestClean($request->media) : 0;
        $user->public = in_array($request->public, array("0","1")) ? Helper::RequestClean($request->public) : 0;
        $user->newsletter = in_array($request->newsletter, array("0","1")) ? Helper::RequestClean($request->newsletter) : 0;

        if($user->pro()){
            $user->domain = $request->domain ? clean($request->domain) : '';
            $user->defaulttype = $request->defaulttype ? clean($request->defaulttype) : '';
        }

        $user->address = json_encode([
            "name"  	=>	$request->billingname ? Helper::RequestClean($request->billingname) : '',
            "company" 	=>	$request->company ? Helper::RequestClean($request->company) : '',
            "type"      =>  $request->type && $request->type == 'business' ? 'business' : 'personal',
            "taxid" 	=>	$request->taxid ? Helper::RequestClean($request->taxid) : '',
            "address" 	=>	Helper::RequestClean($request->address),
            "city" 		=>	Helper::RequestClean($request->city), 
            "state" 	=>	Helper::RequestClean($request->state),
            "zip" 		=>	Helper::RequestClean($request->zip),
            "country" 	=>	Helper::RequestClean($request->country)
        ]);

        if($user->active == 0){
            
            $user->uniquetoken = Helper::rand(32);
            $user->save();

            \Helpers\Emails::renewEmail($user);

            return Helper::redirect()->back()->with('success', e('Account has been successfully updated.').' '.e('You have changed your email. Please check your email before logging out and activate your account.'));
        }

        if($passwordchanged) {
            \Helpers\Emails::passwordChanged($user);
            $location = $request->country();
            \Helpers\Events::for('password')->user($user->id)->log(json_encode([
                'ip' => $request->ip(),
                'country' => $location['country'] ?? null,
                'city' => $location['city'] ?? null,
                'os' => $request->device(),
                'browser' => $request->browser()
            ]));
        }       
        
        $user->save();

        return Helper::redirect()->back()->with('success', e('Account has been successfully updated.'));
    }
    /**
     * Toggle 2FA
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $action
     * @param string $nonce
     * @return void
     */
    public function twoFA(string $action, string $nonce){

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, '2fa'.Auth::id())){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if($action == 'enable'){

            $request = request();

            if(!Helper::cacheGet('user_twofa_'.user()->id)){
                return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
            }

            $gAuth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();

            if(!$gAuth->checkCode(Helper::cacheGet('user_twofa_'.user()->id), $request->secret)) return back()->with("danger", e("Invalid token. Please try again."));

            $user = Auth::user();
            $user->secret2fa = Helper::cacheGet('user_twofa_'.user()->id);
            $user->save();

            return Helper::redirect()->to(route('settings'))->with('success', e('2FA has been activated on your account. Please make sure to backup the secret key or the QR code.'));
        }

        if($action == 'disable'){

            $user = Auth::user();
            $user->secret2fa = null;
            $user->save();

            request()->unset('qr2fa_temp');

            return Helper::redirect()->back()->with('success', e('2FA has been disabled on your account.'));

        }
        return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Regenerate API Key
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function regenerateApi(){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        $user->api = md5(Helper::rand(32).time().$user->id);

        $user->save();

        return back()->with('success', e('API key has been regenerated successfully. Please do not forget to update your application.'));

    }
    /**
     * Confirmation
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.5
     * @param \Core\Request $request
     * @return void
     */
    public function confirmation(Request $request){

        if(!\Helpers\App::possible() || !$request->id || !is_numeric($request->id)) return Helper::redirect()->to(route('billing'));

        $user = Auth::user();

        if(!$subscription = DB::subscription()->where('userid', $user->id)->where('id', $request->id)->first()) return Helper::redirect()->to(route('billing'));

        if(!$currentplan = DB::plans()->first($subscription->planid)) return Helper::redirect()->to(route('billing'));
        
        $user->address = json_decode($user->address);

        $plan = [];
        $plan["name"] = $currentplan->name;
        $plan["free"] = $currentplan->free;
        $plan["urls"] = $currentplan->numurls;
        $plan["clicks"] = $currentplan->numclicks;
        $plan["price_monthly"] = $currentplan->price_monthly;
        $plan["price_yearly"] = $currentplan->price_yearly;
        $plan["price_lifetime"] = $currentplan->price_lifetime;
        $plan["permission"] = json_decode($currentplan->permission);

        View::set('title', e('Order Confirmation'));
        
        return View::with('user.confirmation', compact('subscription', 'user', 'plan'))->extend('layouts.dashboard');
    }
    /**
     * Manage Membership
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.5
     * @return void
     */
    public function manage(){
        
        $user = user();

        if(\Helpers\App::possible()){
            if($subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('date')->first()){
                foreach($this->processor() as $name => $processor){
                    if(!config($name) || !config($name)->enabled || !$processor['manage']) continue;
                    call_user_func_array($processor['manage'], [$user, $subscription]);
                    exit;
                }    
            }
        }
        return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Security
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4.3
     * @param \Core\Request $request
     * @return void
     */
    public function security(Request $request){
        
        $user = Auth::user();

        if($request->isPost() && $request->cpassword){            
            
            if(strlen($request->cpassword) < 5) {
                return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
            }
            
            Helper::set("hashCost", 8);
    
            if(!Helper::validatePass($request->cpassword, $user->password)){
                return Helper::redirect()->back()->with('danger', e('Your password is incorrect.'));
            }

            $newAuthKey = Helper::Encode($user->email.$user->id.uniqid().rand(0, 99999));
            $user->auth_key = $newAuthKey;
            $user->save();

            $sessiondata = Helper::encrypt(json_encode(["loggedin" => true, "key" => $user->auth_key.$user->id]));

            if($request->cookie(Auth::COOKIE)){
                setcookie(Auth::COOKIE, '', -3600, "/", "", false, true);
                $request->cookie(Auth::COOKIE, $sessiondata, 30*24*60);
            } else {
                unset($_SESSION[Auth::COOKIE]);
                $request->session(Auth::COOKIE, $sessiondata);
            }

            return back()->with('success', e('You have been logged out of all devices.'));
        }

        $QR2FA = null;
        $secret = null;
        $gAuth = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
        $title = explode(" ", config("title"));

        if($user->secret2fa){

            $QR2FA = \Helpers\QR::factory(['type' => 'oauth', 'data' => ['label' => $user->email, 'secret' => $user->secret2fa, 'issuer' => $title[0]]])->format('svg')->create('uri');

        } else {

            if(!$secret = Helper::cacheGet('user_twofa_'.user()->id)) {
                $secret = $gAuth->generateSecret();
                $request->session('qr2fa_temp', $secret);
                Helper::cacheSet('user_twofa_'.user()->id, $secret, 120);
            }

            $QR2FA = \Helpers\QR::factory(['type' => 'oauth', 'data' => ['label' => $user->email, 'secret' => $secret, 'issuer' => $title[0]]])->format('svg')->create('uri');        
        }
        
        $user->address = json_decode($user->address ?? '');

        $events = [];
        
        $query = DB::appevents()->where('userid', $user->id)->whereRaw("(type='login' OR type='2fa' OR type='password')");

        foreach($query->orderByDesc('id')->paginate(15) as $event){
            $event->type = ucfirst($event->type);
            $event->data = json_decode($event->data);
            $events[] = $event;
        }
        

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        View::set('title', e('Security'));

        return View::with("user.security", compact('user', 'QR2FA', 'secret', 'events'))->extend('layouts.dashboard');
    }
    /**
     * Connect Social media
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.7
     * @param \Core\Request $request
     * @param string $provider
     * @return void
     */
    public function connect(Request $request, string $provider){

        $user = Auth::user();

        if($user->auth_id){
            return Helper::redirect()->back()->with('danger', e('You are already connected to a social account.'));
        }

        if($provider == 'x'){
            if(!config("tw_connect") || empty(config("twitter_key")) || empty(config("twitter_secret"))) return print(e("Sorry, Twitter connect is not available right now."));

            // Check for error
            if($request->denied) return print(e("You must grant permission to this application to use your twitter account."));
    
            // Attempt to login
            if($request->oauth_verifier && $request->session('oauth_token') && $request->session('oauth_token_secret')){
    
                $twitteroauth = new \Abraham\TwitterOAuth\TwitterOAuth(config("twitter_key"), config("twitter_secret"), $request->session('oauth_token'), $request->session('oauth_token_secret'));
    
                $tw = $twitteroauth->oauth("oauth/access_token", ["oauth_verifier" => $request->oauth_verifier]);
    
                $twitteroauth = new \Abraham\TwitterOAuth\TwitterOAuth(config("twitter_key"), config("twitter_secret"), $tw['oauth_token'], $tw['oauth_token_secret']);
    
                $userInfo = $twitteroauth->get("account/verify_credentials", ['oauth_token' => $tw['oauth_token'], 'include_entities' => true, 'skip_status' => true, 'include_email' => true]);
    
                $userId = $userInfo && isset($userInfo->id) ? $userInfo->id : $tw['user_id'];
    
                if(!$userId) return print(e("An error occurred, please try again later."));
                    
                $user->auth = 'twitter';
                $user->auth_id = $userId;
                $user->save();
                echo '<script>window.opener.location.reload();window.close();</script>';
                exit;
            }
    
            // The TwitterOAuth instance
            $twitteroauth = new \Abraham\TwitterOAuth\TwitterOAuth(config("twitter_key"), config("twitter_secret"), $request->session('oauth_token'));
    
            try{
    
                $request_token = $twitteroauth->oauth("oauth/request_token", ["oauth_callback" => route('login.twitter')]);
    
            } catch(\Exception $e){
    
                GemError::log('Twitter Auth: '.$e->getMessage()."\n".$e->getTraceAsString());
                return print(e("Sorry, Twitter connect is not available right now."));
            }
    
            // Saving them into the session
            $request->session('oauth_token', $request_token['oauth_token']);
            $request->session('oauth_token_secret', $request_token['oauth_token_secret']);
    
            // If everything goes well..
            if($twitteroauth->getLastHttpCode() == 200){
                // Let's generate the URL and redirect
                $url = $twitteroauth->url("oauth/authorize", ["oauth_token" => $request_token['oauth_token']]);
                return Helper::redirect()->to($url);
    
            } else {
                return print(e('An error has occurred! Please make sure that you have set up this application as instructed.'));
            }            
        }

        if($provider == 'facebook'){

            if(!config("fb_connect") || empty(config("facebook_app_id")) || empty(config("facebook_secret"))) return print(e("Sorry, Facebook connect is not available right now."));

            if($request->error) return print(e("You must grant access to this application to use your facebook account."));
    
            $fb = new \Helpers\FacebookAuth(config("facebook_app_id"), config("facebook_secret"), route('settings.connect', $provider));

            if(!$request->code){
                return Helper::redirect()->to($fb->redirectURI($request));
            }

            try{

                $fb->getAccessToken($request);
    
            } catch(\Exception $e){
    
                GemError::log('Facebook Auth: '.$e->getMessage()."\n".$e->getTraceAsString());
                return print(e("Sorry, Facebook connect is not available right now."));
    
            }
    
            $userInfo = $fb->getUser();

            $user->auth = 'facebook';
            $user->auth_id = $userInfo->id;
            $user->save();
            echo '<script>window.opener.location.reload();window.close();</script>';
            exit;
        }

        if($provider == 'google'){
            if(!config("gl_connect") || empty(config("google_cid")) || empty(config("google_cs"))) return print(e("Sorry, Google connect is not available right now."));

            $google = new \Helpers\GoogleAuth(config("google_cid"), config("google_cs"), route('settings.connect', 'google'));        

            if(!$request->code){
                return Helper::redirect()->to($google->redirectURI($request));
            }

            try{

                $google->getAccessToken($request);

            } catch(\Exception $e){

                \GemError::log('Google Auth: '.$e->getMessage()."\n".$e->getTraceAsString());
                return print(e("Sorry, Google connect is not available right now."));

            }            

            $userInfo = $google->getUser();

            if(DB::user()->where('auth_id', $userInfo->id)->first()){
                return print(e("This social account is already connected to another account."));
            }

            $user->auth = 'google';
            $user->auth_id = $userInfo->id;
            $user->save();
            echo '<script>window.opener.location.reload();window.close();</script>';
            exit;
        }
    }
}