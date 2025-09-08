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

use Core\Request;
use Core\Response;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Core\Email;
use Core\Http;
use Models\User;

class Server {
    /**
     * Contact
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.1
     * @return void
     */
    public function contact(Request $request){				

        $integrity = explode(".", base64_decode($request->integrity))[1];
        
        $captcha = new \Helpers\Captcha;

		try{
			
            $captcha->validate($request);

        } catch(\Exception $e){
            return Response::factory(['error' => true, "message" => $e->getMessage(), "csrf" => csrf_token()])->json();
        }

        if($contact = DB::overlay()->where('id', $integrity)->first()){
            
            $contact->data = json_decode($contact->data);

            $name = clean($request->name, 3, true);
            $email = clean($request->email, 3, true);
            $message = clean($request->message, 3, true);

            if(!$request->email || !$request->validate($request->email, 'email')) return Response::factory(['error' => true, "message" => e('Please enter a valid email address.'), "csrf" => csrf_token()])->json();

            if(isset($contact->data->disclaimer) && !empty($contact->data->disclaimer) && !$request->disclaimer) return Response::factory(['error' => true, "message" => e('Please accept the disclaimer.'), "csrf" => csrf_token()])->json();

            $spamConfig = appConfig('app.spamcheck');

            if (preg_match($spamConfig['regex'], $request->message)) {
                 return Response::factory(['error' => true, "message" => e('Your message has been flagged as potential spam. Please review and try again.'), "csrf" => csrf_token()])->json();
            }
            
            $linkCount = preg_match_all('/(https?:\/\/[^\s]+)/', $request->message, $matches);
    
            if ($linkCount > $spamConfig['numberoflinks']) {
                 return Response::factory(['error' => true, "message" => e('Your message has been flagged as potential spam. Please review and try again.'), "csrf" => csrf_token()])->json();
            }
            
            if($spamConfig['postmarkcheck']) {
                $emailContent = "From: ".Helper::RequestClean($request->name)." <".Helper::RequestClean($request->email).">\r\n";
                $emailContent .= "To: ".$contact->data->email."\r\n";
                $emailContent .= "Subject: Contact Form Submission\r\n\r\n";
                $emailContent .= Helper::RequestClean($request->message);
    
                $response = Http::url('https://spamcheck.postmarkapp.com/filter')->withHeaders(['Accept' => 'application/json','Content-Type' => 'application/json'])->body(['email' => $emailContent, 'options' => 'short']) ->post();
    
                if ($response && $response->bodyObject()) {
                    $result = $response->bodyObject();
                    if (isset($result->success) && $result->success === true) {
                        if ($result->score >= 5) {
                             return Response::factory(['error' => true, "message" => e('Your message has been flagged as potential spam. Please review and try again.'), "csrf" => csrf_token()])->json();
                        }
                    }
                }
            }

            if(!empty($contact->data->webhook)){

                \Core\Http::url($contact->data->webhook)
                    ->body(["type" => "contact", "data" => ["name" => $name, "email" => $email, "message" => $message, "date" => date("Y-m-d H:i")]])
                    ->with('content-type', 'application/json')
                    ->post();
            }
            $message = "<p><strong>Contact Data</strong></p>Name: {$name}<br>Email: {$email}<br>Message: {$message}";

            $mailer = \Helpers\Emails::setup();
    
            $mailer->replyto([$email]);
        
            $mailer->to($contact->data->email)
                    ->send([
                        'subject' => $contact->data->subject,
                        'message' => function($template, $data) use ($message) {
                            if(config('logo')){
                                $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                            } else {
                                $title = '<h3>'.config('title').'</h3>';
                            }
                            return Email::parse($template, ['content' => $message, 'brand' => '<a href="'.config('url').'">'.$title.'</a>']);
                        }
                    ]);

        }

        return Response::factory(['error' => false, "message" => "Success", "csrf" => csrf_token()])->json();
    }
    /**
     * Subscribe
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.1
     * @param \Core\Request $request
     * @return void
     */
    public function subscribe(Request $request){
        $integrity = explode(".", base64_decode($request->integrity))[1];

        if(!Helper::Email($request->email)) return Response::factory(['error' => true, "message" => e('Please enter a valid email.'), "csrf" => csrf_token()])->json();
        
        $captcha = new \Helpers\Captcha;

		try{
			
            $captcha->validate($request);

        } catch(\Exception $e){
            return Response::factory(['error' => true, "message" => $e->getMessage(), "csrf" => csrf_token()])->json();
        }

        if($contact = DB::overlay()->where('id', $integrity)->first()){
            
            $data = json_decode($contact->data);

            if(isset($data->disclaimer) && !empty($data->disclaimer) && !$request->disclaimer) return Response::factory(['error' => true, "message" => e('Please accept the disclaimer.'), "csrf" => csrf_token()])->json();

            $email = clean($request->email, 3, true);

            if(!in_array($email, $data->emails)){
                
                $data->emails[] = $email;

                $contact->data = json_encode($data);
                
                $contact->save();
    
                if(!empty($data->webhook)){
    
                    \Core\Http::url($data->webhook)
                        ->with('content-type', 'application/json')
                        ->body(["type" => "newsletter", "data" => [ "email" => $request->email, "date" => date("Y-m-d H:i")]])
                        ->post();
                }
            }

            return Response::factory(['error' => false, "message" => $data->success, "csrf" => csrf_token()])->json();
        }

        return Response::factory(['error' => true, "message" => e('An error occurred. Please try again.'), "csrf" => csrf_token()])->json();
    }
    /**
     * Vote Polls
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.1.8
     * @param \Core\Request $request
     * @return void
     */
    public function vote(Request $request){
        
        $integrity = clean(explode(".", base64_decode($request->integrity))[1]);

        if($poll = DB::overlay()->first($integrity)){
						
            $data = json_decode($poll->data, true);
                        
            $request->answer = trim($request->answer);

            if(isset($data["answers"][$request->answer])){
                $data["answers"][$request->answer]["votes"] = $data["answers"][$request->answer]["votes"] + 1;
            }

            $poll->data = json_encode($data);
            $poll->save();

            return isset($data['thankyou']) && !empty($data['thankyou']) ? print($data['thankyou']) : null;
        }        
        return;
    }
    /**
     * Deeplink
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public function deeplink(Request $request){

        $user = Auth::user();

        if(!$user->has('deeplink')) return \Models\Plans::notAllowed();

        if(!$request->url) return Response::factory(['error' => true, 'message' => e('Please enter a valid URL.')])->json();

        $data = \Helpers\DeepLinks::convert($request->url);

        if(!$data) return null;

        return Response::factory(['error' => false, 'message' => e('Deep linking automatically generated'), 'data' => $data])->json();
    }
}