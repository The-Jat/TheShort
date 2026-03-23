<?php
/**
 * Contact Widget
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel <https://gempixel.com>
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com
 */

namespace Helpers\BioWidgets;

use Helpers\App;
use Core\DB;
use Core\View;
use Core\Auth;
use Core\Helper;
use Core\Response;
use Core\Request;
use Core\Plugin;
use Core\Http;
use Helpers\BioWidgets;

class Contact {
    /**
     * Contact Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5.1
     * @return void
     */
    public static function setup(){

        $type = 'contact';

        return "function fncontact(el, content = null, did = null){

            if(content){
                var text = content['text'] ?? '';
                var email = content['email'] ?? '';
            } else {
                var text = '';
                var email = '';
            }

            var disclaimer = content && 'disclaimer' in content ? content['disclaimer'] : '';

            var blockpreview = email;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Text').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][text]" value="\'+text+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Email').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][email]" value="\'+email+\'">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Disclaimer').' ('.\Helpers\BioWidgets::e('Optional').')</label>
                        <textarea type="text" class="form-control p-2" name="data[\'+slug(did)+\'][disclaimer]">\'+disclaimer+\'</textarea>
                        <p class="form-text">'.\Helpers\BioWidgets::e('You can add your own disclaimer and a checkbox will show up requiring users to check before submitting.').'</p>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Save Contact
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['text'] = clean($data['text']);
        $data['email'] = clean($data['email']);
        $data['disclaimer'] = clean($data['disclaimer']);

        if($data['email'] && !\Core\Helper::Email($data['email'])) throw new \Exception(e('Please enter a valid email'));

        return $data;
    }
    /**
     * Contact Form Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function processor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){

            if($request->action == 'contact'){

                \Gem::addMiddleware('ValidateCaptcha');

                if(!$request->email || !$request->validate($request->email, 'email')) return back()->with('danger', e('Please enter a valid email.'))->exit();

                if(isset($block['disclaimer']) && $block['disclaimer'] && !$request->disclaimer) return back()->with('danger', e('Please accept the disclaimer.'))->exit();

                $profiledata = json_decode($profile->data, true);

                $data = $profiledata['links'][$request->blockid];
                $message = clean($request->message);
                $email = clean($request->email);
                $page = \Helpers\App::shortRoute($url->domain??null, $profile->alias);


                $spamConfig = appConfig('app.spamcheck');

                if (preg_match($spamConfig['regex'], $request->message)) {
                    return back()->with('danger', e('Your message has been flagged as potential spam. Please review and try again.'))->exit();
                }
                
                $linkCount = preg_match_all('/(https?:\/\/[^\s]+)/', $request->message, $matches);
        
                if ($linkCount > $spamConfig['numberoflinks']) {
                    return back()->with('danger', e('Your message has been flagged as potential spam. Please review and try again.'))->exit();
                }
                
                if($spamConfig['postmarkcheck']) {
                    $emailContent = "From: ".\Core\Helper::RequestClean($request->name)." <".\Core\Helper::RequestClean($request->email).">\r\n";
                    $emailContent .= "To: ".config('email')."\r\n";
                    $emailContent .= "Subject: Contact Form Submission\r\n\r\n";
                    $emailContent .= \Core\Helper::RequestClean($request->message);
        
                    $response = Http::url('https://spamcheck.postmarkapp.com/filter')->withHeaders(['Accept' => 'application/json','Content-Type' => 'application/json'])->body(['email' => $emailContent, 'options' => 'short']) ->post();
        
                    if ($response && $response->bodyObject()) {
                        $result = $response->bodyObject();
                        if (isset($result->success) && $result->success === true) {
                            if ($result->score >= 5) {
                                return back()->with('danger', e('Your message has been flagged as potential spam. Please review and try again.'))->exit();
                            }
                        }
                    }
                }

                Plugin::dispatch('profile.contacted', [$message, $email, $page]);

                $resp = json_decode($profile->responses, true);

                if(!isset($resp['contactform'])) $resp['contactform'] = [];
                $resp['contactform'][] = [
                    'from' => $email,
                    'message' => $message,
                    'page' => $page,
                    'date' => \Core\Helper::dtime()
                ];
                $profile->responses = json_encode($resp);
                $profile->save();

                Emails::setup()
                        ->replyto([\Core\Helper::RequestClean($request->email)])
                        ->to($block['email'])
                        ->send([
                            'subject' => '['.config('title').'] You were contacted from your Bio Page: '.$profile->name,
                            'message' => function($template, $block) use ($message, $email, $page){
                                if(config('logo')){
                                    $title = '<img align="center" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" width="166"/>';
                                } else {
                                    $title = '<h3>'.config('title').'</h3>';
                                }

                                return \Core\Email::parse($template, ['content' => "<p>You have received an email from <strong>{$email}</strong> sent via the Bio Page {$page}.</p><strong>Message:</strong><br><p>{$message}</p>", 'brand' => $title]);
                            }
                        ]);
                
                return back()->with('success', e('Message sent successfully.'))->exit();
            }
        }
    }
    /**
     * Contact Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        return '<a href="#" data-bs-target="#C'.$id.'" data-bs-toggle="collapse" data-target="#C'.$id.'" data-toggle="collapse"  role="button" class="btn btn-block p-3 d-block btn-custom position-relative fa-animated collapsed">
                    <span class="align-top">'.$value['text'].'</span>
                    <i class="fa fa-chevron-down position-absolute end-0 me-3 right-0 mr-3"></i>
                </a>
                <form method="post" action="" id="C'.$id.'" class="btn-custom border-0 collapse rounded rounded-3 text-start text-left p-3 mt-3">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label fw-bold">'.\Helpers\BioWidgets::e('Email').'</label>
                        <input type="text" class="form-control" name="email" placeholder="johnsmith@company.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label fw-bold">'.\Helpers\BioWidgets::e('Message').'</label>
                        <textarea class="form-control" name="message" required></textarea>
                    </div>
                    '.(isset($value['disclaimer']) && $value['disclaimer'] ? '<div class="text-left text-start my-2"><label><input type="checkbox" name="disclaimer" class="me-2 mr-2" value="1" required> '.$value['disclaimer'].'</label></div>' : '').'                    
                    '.csrf().'
                    <input type="hidden" name="action" value="contact">
                    <input type="hidden" name="blockid" value="'.$id.'">
                    '.\Helpers\Captcha::display().'
                    <button type="submit" class="btn btn-dark d-block">'.\Helpers\BioWidgets::e('Send').'</button>
                </form>';
    }
}
