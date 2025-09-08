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
use Core\Helper;
use Core\Localization;
use Core\View;
use Core\Email;
use Core\Auth;
use Core\Plugin;
use Core\Http;

class Page {
    use \Traits\Pixels;
    /**
     * Get Custom Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $page
     * @return void
     */
    public function index(string $slug){
        
        $locale = Localization::locale();

        if(!$page = DB::page()->where('seo', Helper::RequestClean($slug))->first()){
            stop(404);
        }        

        $page->lastupdated = date('F d, Y', strtotime($page->lastupdated));
        $page->metadata = $page->metadata ? json_decode($page->metadata) : [];

        View::set('title', $page->metadata->title ?? $page->name);

        View::set('description', $page->metadata->description ?? Helper::truncate($page->name, 150));

        View::push(assets('content-style.min.css'), 'css')->toHeader();

        if($page->category == "main"){
            $template = 'pages.main';            
        } else {
            $template = 'pages.index';
        }

        return View::with($template, compact('page'))->extend('layouts.main');
    }
    /**
     * Contact Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function contact(Request $request){

        if(!config('contact')) stop(404);

        View::set('title', e('Contact Us'));

        View::set('description', e('If you have any questions, feel free to contact us so we can help you.'));

        if($request->name){
            View::push('<script>$("input[name=name]").val("'.Helper::clean($request->name, 3, true).'")</script>', 'custom')->toFooter();
        }

        if($request->email){
            View::push('<script>$("input[name=email]").val("'.Helper::clean($request->email, 3, true).'")</script>', 'custom')->toFooter();
        }

        // @group Plugin
        Plugin::dispatch('contact');

        return View::with('pages.contact')->extend('layouts.main');
    }   

    /**
     * Send Contact Form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function contactSend(Request $request){

        if(!config('contact')) stop(404);

        // if($request->vtoken || strlen($request->vtoken) > 0){
        //     return (new Response([
        //         'error' => true,
        //         'message' => e('An error occurred. Please try again later.')
        //     ]))->json();
        // }


        if(!Helper::Email($request->email)) {
            return (new Response([
                'error' => true,
                'message' => e('Please enter a valid email.'),
                'token' => csrf_token()
            ]))->json();
        }

        if(!$request->name || strlen($request->name) < 2){
            return (new Response([
                'error' => true,
                'message' => e('Please enter your name.'),
                'token' => csrf_token()
            ]))->json();
        }

        if(!$request->message || strlen($request->message) < 10){
            return (new Response([
                'error' => true,
                'message' => e('Please enter a message or message too short.'),
                'token' => csrf_token()
            ]))->json();
        }        
        
        $spamConfig = appConfig('app.spamcheck');

        if (preg_match($spamConfig['regex'], $request->message)) {
            return (new Response([
                'error' => true,
                'message' => e('Your message has been flagged as potential spam. Please review and try again.'),
                'token' => csrf_token()
            ]))->json();
        }
        
        $linkCount = preg_match_all('/(https?:\/\/[^\s]+)/', $request->message, $matches);

        if ($linkCount > $spamConfig['numberoflinks']) {
            return (new Response([
                'error' => true,
                'message' => e('Your message has been flagged as potential spam. Please review and try again.'),
                'token' => csrf_token()
            ]))->json();
        }
        
        if($spamConfig['postmarkcheck']) {
            $emailContent = "From: ".Helper::RequestClean($request->name)." <".Helper::RequestClean($request->email).">\r\n";
            $emailContent .= "To: ".config('email')."\r\n";
            $emailContent .= "Subject: Contact Form Submission\r\n\r\n";
            $emailContent .= Helper::RequestClean($request->message);

            $response = Http::url('https://spamcheck.postmarkapp.com/filter')->withHeaders(['Accept' => 'application/json','Content-Type' => 'application/json'])->body(['email' => $emailContent, 'options' => 'short']) ->post();

            if ($response && $response->bodyObject()) {
                $result = $response->bodyObject();
                if (isset($result->success) && $result->success === true) {
                    if ($result->score >= 5) {
                        return (new Response([
                            'error' => true,
                            'message' => e('Your message has been flagged as potential spam. Please review and try again.'),
                            'token' => csrf_token()
                        ]))->json();
                    }
                }
            }
        }

        $message = 'Name: '.Helper::RequestClean($request->name).''.($request->subject ? '<br>Subject: '.Helper::RequestClean($request->subject) : '' ).'<br><br>Email: '.Helper::RequestClean($request->email).'<br><br>'.Helper::RequestClean($request->message);

        // @group Plugin
        Plugin::dispatch('contacted', ['name' => Helper::RequestClean($request->name), 'email' => Helper::RequestClean($request->email), 'message' => Helper::RequestClean($request->message)]);

        \Helpers\Emails::setup()
                ->replyto([Helper::RequestClean($request->email),Helper::RequestClean($request->name)])
                ->to(config('email'))
                ->send([
                    'subject' => '['.config('title').'] You have been contacted!',
                    'message' => function($template, $data) use ($message){

                        if(config('logo')){
                            $title = '<img align="center" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                        } else {
                            $title = '<h3>'.config('title').'</h3>';
                        }

                        return Email::parse($template, ['content' => $message, 'brand' => $title]);
                   }
                ]);

        return (new Response([
            'error' => false,
            'message' => e('Your message has been sent. We will reply you as soon as possible.'),
            'html' => '<script>$(\'form input, form textarea\').val(\'\');</script>',
            'token' => csrf_token()
        ]))->json();
    }
    /**
     * Report Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public function report(Request $request){
        
        if(!config('report')) stop(404);

        View::set('title', e('Report Link'));

        View::set('description', e('Please report a link that you consider risky or dangerous. We will review all cases and take measure to remove the link.'));

        if($request->email){
            View::push('<script>$("input[name=email]").val("'.Helper::clean($request->email, 3, true).'")</script>', 'custom')->toFooter();
        }

        // @group Plugin
        Plugin::dispatch('report');

        return View::with('pages.report')->extend('layouts.main');
    }
    /**
     * Send Report
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function reportSend(Request $request){

        if(!config('report')) stop(404);

        if(!Helper::Email($request->email)) {
            return (new Response([
                'error' => true,
                'message' => e('Please enter a valid email.'),
                'token' => csrf_token()
            ]))->json();
        }

        if(!$request->link || !filter_var($request->link, FILTER_VALIDATE_URL)) {
            return (new Response([
                'error' => true,
                'message' => e('Please enter a valid link.'),
                'token' => csrf_token()
            ]))->json();
        }

        // @group Plugin
        Plugin::dispatch('reported', ['email' => Helper::RequestClean($request->email), 'link' => Helper::RequestClean($request->link)]);

        if(!DB::reports()->where('url', $request->link)->first()){

            $report = DB::reports()->create();
            $report->url = Helper::RequestClean($request->link);
            $report->type = Helper::RequestClean($request->reason);
            $report->email = Helper::RequestClean($request->email);            
            $report->status = 0;
            $report->ip = appConfig('haship') ? md5(AuthToken.$request->ip()) : $request->ip();
            $report->date = Helper::dtime();
            $report->save();

            $smtp = config('smtp');

            \Helpers\Emails::setup()
                    ->replyto([Helper::RequestClean($request->email)])
                    ->to(config('email'))
                    ->send([
                        'subject' => '['.config('title').'] A link has been reported!',
                        'message' => function($template, $data) use ($report){
                            if(config('logo')){
                                $title = '<img align="center" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" width="166"/>';
                            } else {
                                $title = '<h3>'.config('title').'</h3>';
                            }

                            return Email::parse($template, ['content' => 'A user reported a link as '.clean($report->type).'. Please review the link below and ban it in Admin > Links > Reported Links if necessary to keep your website clean. Do not delete the link because they will be able shorten it again.<br>'.clean($report->url), 'brand' => $title]);
                       }
                    ]);
                
        }    
        return (new Response([
            'error' => false,
            'message' => e('Thank you. We will review this link and take action.'),
            'html' => '<script>$(\'form input, form textarea\').val(\'\');</script>',
            'token' => csrf_token()
        ]))->json();
    }
    /**
     * FAQ Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @deprecated 6.7
     * @return void
     */
    public function faq(){    
        return Helper::redirect(null, 301)->to(route('help'));
    }
    /**
     * API Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function api(){
        
        if(!config('api')) return stop(404);

        View::set('title', e('API Reference for Developers'));

        View::set('description', e('API Reference for Developers.'));    

        $token = Auth::logged() && Auth::user()->has('api') ? Auth::user()->api : 'YOURAPIKEY';       

        $api = appConfig('api');
        
        $menu = [];

        if($extended = \Core\Plugin::dispatch('apidocs.extend')){
			foreach($extended as $array){
				$api = array_merge($api, $array);
			}
		}

        asort($api);
        $content = [];

        foreach($api as $key => $data){

            if(isset($data['admin']) && $data['admin'] && (!Auth::logged() || !Auth::user()->admin)) continue;

            $menu[$key] = [];
            $menu[$key]['title'] = $data['title'];
            $menu[$key]['endpoints'] = [];
            $menu[$key]['admin'] = isset($data['admin']) && $data['admin'] ? true : false;

            foreach($data['endpoints'] as $endpoint){                
                $menu[$key]['endpoints'][Helper::slug($endpoint['title'])] = $endpoint['title'];
            }
            $content[$key] = $data;
        }
        
        $rate = appConfig('app.throttle');

        if(Auth::user() && Auth::user()->has('apirate')){
            if(Auth::user()->hasLimit('apirate') !== 0){
                $rate = [(int) Auth::user()->hasLimit('apirate'), 1];
            }
        }

        if($rate[0] == '0') $rate[0] = 100000;

        \Helpers\CDN::load('hljs');
        View::push('<script>hljs.highlightAll();</script>','custom')->toFooter();
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        // @group Plugin
        Plugin::dispatch('api');

        return View::with('pages.api', compact('token', 'rate', 'menu', 'api', 'content'))->extend('layouts.api');
    }

    /**
     * Affiliate Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function affiliate(){

        $affiliate = config('affiliate');

        if(!config('pro') || !$affiliate->enabled) {
            stop(404);
        }

        View::set('title', e('Affiliate Program'));

        View::set('description', e('Refer customers to us and we will reward you a commission on all qualifying sales made on our website. Anyone can join the affiliate program.'));

        // @group Plugin
        Plugin::dispatch('affiliate');

        return View::with('pages.affiliate', compact('affiliate'))->extend('layouts.main');
    }
    /**
     * QR Codes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.3
     * @return void
     */
    public function qr(){

        View::set('title', e('QR Codes'));

        View::set('description', e('Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement.'));

        if(config('publicqr')){
            
            View::set('title', e('Free QR Code Generator'));

            \Helpers\CDN::load('coloris');
            View::push('<style>.clr-field button{border-radius: 0 5px 5px 0}.position-sticky{top: 120px}</style>', 'custom')->toHeader();

            View::push("<script>
                        Coloris({
                            themeMode: 'dark',
                            alpha: false,
                        });
                        $('[data-trigger=switcher]').click(function(e){
                            e.preventDefault();
                            if($(this).hasClass('active')) return false;
                            $('.switcher').fadeOut('fast');
                            $($(this).attr('href')).show();
                            $('[data-trigger=switcher]').removeClass('active').removeClass('border-success');
                            $(this).addClass('active').addClass('border-success');
                            $('input[name=type]').val($(this).attr('href').replace('#', ''));
                        });
                        $('form').submit(function(e){
                            e.preventDefault();
                            let f = $(this);
                            let text = f.find('button[type=submit]').text();
                            $.ajax({
                                data: f.serialize(),
                                url: f.attr('action'),
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function(){
                                    f.find('button[type=submit]').html('<div class=\"preloader\"><div class=\"spinner-border text-dark\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></div>');
                                },
                                complete: function(){
                                    f.find('button[type=submit]').text(text);
                                },
                                success: function(response){
                                    $('input[name=_token]').val(response.token);
                                    if(response.error){
                                        $.notify({
                                            message: response.message
                                        },{
                                            type: 'danger',
                                            placement: {
                                                from: 'top',
                                                align: 'right'
                                            },
                                        });
                                    } else {
                                        $.notify({
                                            message: response.message
                                        },{
                                            type: 'success',
                                            placement: {
                                                from: 'top',
                                                align: 'right'
                                            },
                                        });
                                        if(typeof response.html !== 'undefined'){
                                            $('#return-ajax').html(response.html);
                                        }
                                    }
                                }
                                
                            });
                        });
                        $('[data-trigger=saveqr]').click(function(e){
                            e.preventDefault();
                            let svgdata = $('#return-ajax img').attr('src');
                            const format = $(this).data('format');
                            svg = atob(svgdata.replace('data:image/svg+xml;base64,',''));
                            svg = svg.replace('<?xml version=\"1.0\" encoding=\"UTF-8\"?>', '').replace('<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\" \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">', '');
                            const data = svg;
                            const svgBlob = new Blob([data], {
                                type: 'image/svg+xml;charset=utf-8'
                            });
                            const url = URL.createObjectURL(svgBlob);

                            if(format == 'svg'){                        
                                const a = document.createElement('a');
                                a.download = 'QRCode.svg';
                                document.body.appendChild(a);
                                a.href = svgdata;
                                a.click();
                                a.remove();
                                return false;
                            }

                            const img = new Image();
                            img.addEventListener('load', () => {
                                let filename = null;
                                let mime = null;
            
                                if(format == 'webp'){
                                    filename = 'QRcode.webp';
                                    mime = 'image/webp';
                                }else {
                                    filename = 'QRcode.png';
                                    mime = 'image/png';
                                }
                                const canvas = document.createElement('canvas');
                                canvas.width = 1000;
                                canvas.height = 1000;
                            
                                const context = canvas.getContext('2d');
                                if(format == 'jpg') context.fillStyle = '#ffffff';
                                context.drawImage(img, 0, 0, 1000, 1000);
                            
                                URL.revokeObjectURL(url);
                            
                                const a = document.createElement('a');
                                a.download = filename;
                                document.body.appendChild(a);
                                a.href = canvas.toDataURL(mime);
                                a.click();
                                a.remove();
                            });
                            img.src = url;
                        });
                    </script>", 'custom')->toFooter();            
        }

        return View::with('pages.qr')->extend('layouts.main');        
    }
    /**
     * Bio Profiles
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function bio(Request $request){

        if($request->alias){
            if(strlen($request->alias) < 3){
                return Response::factory(['available' => false, 'message' => e('Custom alias must be at least 3 characters.')])->json();

            }
            if(DB::url()->where('custom', Helper::slug($request->alias))->whereRaw("(domain = '' OR domain IS NULL OR domain = '".config('url')."')")->first()){
                return Response::factory(['available' => false, 'message' => e('That alias is taken. Please choose another one.')])->json();

            }
            if(DB::url()->where('alias', Helper::slug($request->alias))->whereRaw("(domain = '' OR domain IS NULL OR domain = '".config('url')."')")->first()){
                return Response::factory(['available' => false, 'message' => e('That alias is taken. Please choose another one.')])->json();
            }
            return Response::factory(['available' => true])->json();
        }

        View::set('title', e('Bio Pages'));
        
        View::set('description', e('Convert your followers by creating beautiful pages that group all of your important links on the single page.'));

        View::push(assets('frontend/libs/typedjs/typed.min.js'), 'script')->toFooter();

        $widgets = \Helpers\BioWidgets::widgets();

        return View::with('pages.bio', compact('widgets'))->extend('layouts.main'); 
    }
    /**
     * Consent
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public function consent(Request $request){

        if($request->accept){
            $request->cookie('cookieconsent_status', 'dismiss', 15*60*24);
            return Helper::redirect()->to($request->session('redirectbackto'));
        }
        
        View::set('title', e('Cookie Policy Consent'));

        return View::with('pages.consent')->extend('layouts.api'); 
    }
}