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

use Core\Request;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Models\User;

class QR {

    use \Traits\Links;

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('qr') === false){
			return \Models\Plans::notAllowed();
		}
    }
    /**
     * QR Generator
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function index(Request $request){

        $user = Auth::user();

        $total = Auth::user()->hasLimit('qr');

        $scans = DB::url()->where('userid', Auth::user()->rID())->whereNotNull('qrid')->sum('click');    
        
        if($request->sort == "popular"){
            
            $query = DB::qrs()->selectExpr(DBprefix.'qrs.*')->where('qrs.userid', Auth::user()->rID())->join(DBprefix.'url', [DBprefix.'qrs.urlid', '=', DBprefix.'url.id'])->orderByDesc('click');

        } else {

            $query = DB::qrs()->where('userid', Auth::user()->rID());

            if(!$request->sort || $request->sort == "latest"){
                $query->orderByDesc('created_at');
            }

            if($request->sort == "old"){
                $query->orderByAsc('created_at');
            }

        }

        if($request->q){
            $query->whereLike('name', '%'.clean($request->q).'%');
        }

        $limit = 12;

        $qrs = [];
        
        if($user->plan('qrcounttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::qrs()->whereRaw("(created_at BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

            $db = $query->paginate($limit);

        } else {

            $count = DB::qrs()->where('userid', $user->rID())->count();

            if($request->perpage && is_numeric($request->perpage) && $request->perpage > 14 && $request->perpage <= 100) $limit = $request->perpage;    
    
            if($total > 0 && $count >= $total) {
                $count = $total;
                $db = $query->limit($total)->findMany();
            } else {
                $db = $query->paginate($limit);
            }            

        }

        foreach($db as $qr){
            $qr->data = json_decode($qr->data);

            if($qr->urlid && $url = DB::url()->where('id', $qr->urlid)->first()){
                $qr->scans = $url->click;
            }
            $qr->channels = \Core\DB::tochannels()->join(DBprefix.'channels', [DBprefix.'tochannels.channelid' , '=', DBprefix.'channels.id'])->where(DBprefix.'tochannels.itemid', $qr->id)->where('type', 'qr')->findMany();

            $qrs[] = $qr;
        }

        // $categories = [];

        // foreach(DB::qrs()->selectExpr('JSON_EXTRACT(data, \'$.type\') as type')->where('userid', Auth::user()->rID())->groupByExpr('type')->findMany() as $category){
        //     $categories[] = str_replace('"', '', $category->type);
        // }

        View::set('title', e('QR Codes'));

        return View::with('qr.index', compact('qrs', 'count', 'total', 'scans'))->extend('layouts.dashboard');
    }
    /**
     * Create QR Code
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.9
     * @param \Core\Request $request
     * @return void
     */
    public function create(Request $request){

        if(Auth::user()->teamPermission('qr.create') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        $user = Auth::user();

        if($user->plan('qrcounttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::qrs()->whereRaw("(created_at BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::qrs()->where('userid', $user->rID())->count();

        }

        $total = Auth::user()->hasLimit('qr');

        \Models\Plans::checkLimit($count, $total);

        View::set('title', e('Create QR'));

        \Helpers\CDN::load("spectrum");

		View::push('<script type="text/javascript">
						$("#bg").spectrum({
					        color: "rgb(255,255,255)",
					        preferredFormat: "rgb",
                            allowEmpty:true,
                            showInput: true,
                            move: function (color) { $("#bg").val(color.toRGBString()) },
		                    hide: function (color) { $("#bg").val(color.toRGBString()) }
						});
                        $("#fg").spectrum({
					        color: "rgb(0,0,0)",
					        preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#fg").val(color.toRGBString()) },
		                    hide: function (color) { $("#fg").val(color.toRGBString()) }
						});
                        $("[data-trigger=switcher]").click(function(e){
                            e.preventDefault();
                            if($(this).hasClass("active")) return false;
                            $(".switcher").fadeOut("fast");
                            $($(this).attr("href")).show();
                            $("[data-trigger=switcher]").removeClass("active").removeClass("border-primary");
                            $(this).addClass("active").addClass("border-primary");
                            $("input[name=type]").val($(this).attr("href").replace("#", ""));
                        });
                        $("input, select, textarea").on("change", function(){
                            updatePreview();
                        });

                        function updatePreview(){
                            let data = new FormData($(\'[data-trigger=saveqr\')[0]);
                            $.ajax({
                                type: "POST",
                                url: "'.route('qr.preview').'",
                                data: data,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                $("#return-ajax").html(\'<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>\');
                                },
                                complete: function() {      
                                $(\'.preloader\').fadeOut("fast", function(){$(this).remove()});
                                },          
                                success: function (response) { 
                                    $(\'#return-ajax\').html(response);
                                }
                            }); 
                        }
                    </script>', 'custom')->toFooter();

        if(\Helpers\QR::hasImagick()){
            View::push('<script type="text/javascript">
                            $("#gbg").spectrum({
                                color: "rgb(255,255,255)",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#gbg").val(color.toRGBString()) },
                                hide: function (color) { $("#gbg").val(color.toRGBString()) }
                            });
                            $("#gfg").spectrum({
                                color: "rgb(0,0,0)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfg").val(color.toRGBString()) },
                                hide: function (color) { $("#gfg").val(color.toRGBString()) }
                            });
                            $("#gfgs").spectrum({
                                color: "rgb(0,0,0)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfgs").val(color.toRGBString()) },
                                hide: function (color) { $("#gfgs").val(color.toRGBString()) }
                            });
                            $("#framecolor").spectrum({
                                color: "rgb(0,0,0)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#framecolor").val(color.toRGBString()) },
                                hide: function (color) { $("#framecolor").val(color.toRGBString()) }
                            });
                            $("#frametextcolor").spectrum({
                                color: "rgb(255,255,255)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#frametextcolor").val(color.toRGBString()) },
                                hide: function (color) { $("#frametextcolor").val(color.toRGBString()) }
                            });
                            $("#eyecolor, #eyeframecolor").spectrum({
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                            });
                        </script>', 'custom')->toFooter();
        }

        if($request->link){
            View::push('<script type="text/javascript">
                            $(document).ready(function(){
                                $("a[href=#link]").click();
                            });

                        </script>', 'custom')->toFooter();
        }

        View::push('<style>.main{overflow:initial !important;}#qr-preview{position: sticky; top: 5px}</style>', 'custom')->toHeader();

        $domains = [];
        foreach(array_reverse(\Helpers\App::domains(), true) as $domain){
            $domains[] = $domain;
        }

        if($request->url){
            View::push('<script>
                $("[data-trigger=switcher]").parents(".card").hide();
                $("#text textarea[name=text]").val("'.clean($request->url).'");
                var collapse = new bootstrap.Collapse(document.getElementById("colors"));
                collapse.show();
                var collapse2 = new bootstrap.Collapse(document.getElementById("design"));
                collapse2.show();
            </script>', 'custom')->toFooter();
        }

        $templates = [];

        foreach(DB::qrtemplates()->where('status', 1)->findMany() as $template){
            if($template->paidonly == '-1' || ($template->paidonly == '0' && $user->pro()) || ($template->paidonly == $user->planid)){
                $templates[] = $template;
            }
        }


        return View::with('qr.new', compact('domains', 'templates'))->extend('layouts.dashboard');
    }
    /**
     * Preview QR Codes
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.9
     * @param \Core\Request $request
     * @return void
     */
    public function preview(Request $request){

        if(!$request->name) return \Core\Response::factory('<div class="alert alert-danger p-3">'.e('Please enter a name for your QR code.').'</div>')->send();

        if(!\Helpers\QR::typeExists($request->type)) return \Core\Response::factory('<div class="alert alert-danger p-3">'.e('Invalid QR format or missing data').'</div>')->send();

        $user = Auth::user();

        try{

            if($request->type == "file"){
                try{

                    \Helpers\QR::validateFile();

                    $request->type = "text";
                    $request->text = "Preview not available for file uploads. You can save the QR code to create it.";

                } catch(\Exception $e){
                    return \Core\Response::factory('<div class="alert alert-danger p-3">'.$e->getMessage().'</div>')->send();
                }
            }

            if($request->type == "vcard"){
                try{

                    \Helpers\QR::validatevCardPicture();

                    $request->type = "text";
                    $request->text = url('vcard');

                } catch(\Exception $e){
                    return \Core\Response::factory('<div class="alert alert-danger p-3">'.$e->getMessage().'</div>')->send();
                }
            }

            if($request->type == "application"){
                $request->type = "text";
                $request->text = url('shorturl');
            }

            if($request->template && $template = DB::qrtemplates()->where('id', $request->template)->first()){
                $template->data = json_decode($template->data);
                
                $request->mode = $template->data->mode;
                $request->bg = $template->data->color->bg ?? '';
                $request->fg = $template->data->color->fg ?? '';
                $request->gradient = [
                    'start' => $template->data->gradient[0][0] ?? '',
                    'stop' => $template->data->gradient[0][1] ?? '',
                    'bg' => $template->data->gradient[1] ?? '',
                    'direction' => $template->data->gradient[2] ?? ''
                ];
                $request->matrix = $template->data->matrix;
                $request->logosize = $template->data->logosize;
                $request->punchedlogo = $template->data->punchedlogo;
                $request->selectlogo = $template->data->definedlogo ?? '';
                $request->frame = [
                    'type' => $template->data->frame->type ?? '',
                    'color' => $template->data->frame->color ?? '',
                    'text' => $template->data->frame->text ?? '',
                    'textcolor' => $template->data->frame->textcolor ?? '',
                    'font' => $template->data->frame->font  
                ];
                $request->margin = $template->data->margin ?? '0';
                $request->error = $template->data->error ?? '';
                $request->eye = $template->data->eye ?? '';
                $request->eyeframe = $template->data->eyeframe ?? '';
                $request->eyecolor = $template->data->eyecolor ?? '';
                $request->eyeframecolor = $template->data->eyeframecolor;
            }

            $margin = is_numeric($request->margin) && $request->margin <= 10 ? $request->margin : 0;

            $data = \Helpers\QR::factory($request, 1000, $margin)->format('svg');

            if($request->mode == 'gradient'){
                $data->gradient(
                    [$request->gradient['start'], $request->gradient['stop']],
                    $request->gradient['bg'],
                    $request->gradient['direction'],
                    $request->eyeframecolor ?? null,
                    $request->eyecolor ?? null
                );
            } else {
                $data->color($request->fg, $request->bg, $request->eyeframecolor ?? null, $request->eyecolor ?? null);
            }

            if($request->matrix){
                $data->module($request->matrix);
            }

            if($request->eye){
                $data->eye($request->eye, $request->eyeframe ?? 'square');
            }

            if($user->has('qrframes') && $request->frame){
                $options = $request->frame;
                $options['bg'] = $request->mode == 'gradient' ? $request->gradient['bg'] : $request->bg;
                if(in_array($request->frame['font'], ['Arial', 'Courier_New', 'Times_New_Roman', 'Comic_Sans_MS', 'Verdana', 'Impact', 'Tahoma'])){
                    $options['font'] = str_replace('_', ' ', $request->frame['font']);
                }

                if($options['text'] && strlen($options['text']) > 20){
                    return \Core\Response::factory('<div class="alert alert-danger p-3">'.e('Maximum limit for text label is 20').'</div>')->send();
                }

                $data->withFrame($options);
            }

            if($user->has('qrlogo')){

                $size = is_numeric($request->logosize) && $request->logosize > 50 && $request->logosize <= 500 ? $request->logosize : 150;

                if($request->punched){
                    $data->isPunched();
                }                

                if($request->selectlogo && $request->selectlogo !='none'){                    
                    if(!file_exists(PUB.'/static/images/'.$request->selectlogo)){
                        $data->withLogo(appConfig('app.storage')['qr']['path'].'/'.$request->selectlogo, $size);
                    } else {
                        $data->withLogo(PUB.'/static/images/'.$request->selectlogo.'.png', $size);
                    }
                }

                if($image = $request->file('logo')){                    
                    if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png']))  return \Core\Response::factory('<div class="alert alert-danger p-3">'.e('Logo must be either a PNG or a JPEG (Max 500kb).').'</div>')->send();
                    $data->withLogo($image->location, $size);
                }

            } else {
                if(config('qrlogo')){
                    $data->withLogo(PUB.'/content/'.config('qrlogo'), 250);
                }
            }
            
            if(in_array($request->error, ['l', 'm', 'q', 'h'])){
                $data->errorCorrection($request->error);
            }

            $qr = $data->create('uri');

        } catch(\Exception $e){
            return \Core\Response::factory('<div class="alert alert-danger p-3">'.$e->getMessage().'</div>')->send();
        }

        $response = '<img src="'.$qr.'" class="img-responsive w-100 mw-50">';

        if($request->logosize / 1000 > 0.35) $response .= '<div class="alert alert-danger mt-2 p-2">'.e('Your QR code might not be readable. Please scan it with your phone to verify.').'</div>';

        return \Core\Response::factory($response)->send();
    }
    /**
     * Generate and Save QR Code
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.9
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){

        if(Auth::user()->teamPermission('qr.create') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        $user = Auth::user();

        if(!\Helpers\QR::typeExists($request->type)) return back()->with('danger',  e('Invalid QR format or missing data'));

        if(!$request->name) return back()->with('danger', e('Please enter a name for your QR code.'));


        if($user->plan('qrcounttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::qrs()->whereRaw("(created_at BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::qrs()->where('userid', $user->rID())->count();

        }

        $total = Auth::user()->hasLimit('qr');

        \Models\Plans::checkLimit($count, $total);
        try{
            if($request->type == 'file'){

                $input = call_user_func([\Helpers\QR::class, 'type'.ucfirst($request->type)]);
                $data = uploads('qr/files/'.$input);

            }elseif($request->type == 'vcard'){
                
                \Helpers\QR::validatevCardPicture();

                $input = $request->{$request->type} ? $request->{$request->type} : $request->text;
                $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($request->type)], clean($input));
                $input['image'] = \Helpers\QR::vcardPicture();

            }else {
                $input = $request->{$request->type} ? $request->{$request->type} : $request->text;
                $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($request->type)], clean($input));
            }
        }  catch(\Exception $e){
            return back()->with('danger',  $e->getMessage());
        }
        
        $qrdata = [];

        $qrdata['type'] = clean($request->type);

        $qrdata['data'] = $input;

        if($request->template && $template = DB::qrtemplates()->where('id', $request->template)->first()){
            $template->data = json_decode($template->data);
            
            $request->mode = $template->data->mode;
            $request->bg = $template->data->color->bg ?? '';
            $request->fg = $template->data->color->fg ?? '';
            $request->gradient = [
                'start' => $template->data->gradient[0][0],
                'stop' => $template->data->gradient[0][1],
                'bg' => $template->data->gradient[1],
                'direction' => $template->data->gradient[2]
            ];
            $request->matrix = $template->data->matrix;
            $request->logosize = $template->data->logosize;
            $request->punchedlogo = $template->data->punchedlogo;
            $request->selectlogo = $template->data->definedlogo;
            $request->frame = [
                'type' => $template->data->frame->type,
                'color' => $template->data->frame->color,
                'text' => $template->data->frame->text,
                'textcolor' => $template->data->frame->textcolor,
                'font' => $template->data->frame->font  
            ];
            $request->margin = $template->data->margin ?? '0';
            $request->error = $template->data->error;
            $request->eye = $template->data->eye;
            $request->eyeframe = $template->data->eyeframe;
            $request->eyecolor = $template->data->eyecolor;
            $request->eyeframecolor = $template->data->eyeframecolor;
        }


        $qrdata['mode'] = clean($request->mode);

        if($request->mode == 'gradient'){
            $qrdata['gradient'] = [
                [clean($request->gradient['start']), clean($request->gradient['stop'])],
                clean($request->gradient['bg']),
                clean($request->gradient['direction'])
            ];
        } else {
            $qrdata['color'] = ['bg' => clean($request->bg), 'fg' => clean($request->fg)];
        }


        if($user->has('qrframes') && $request->frame){
            $qrdata['frame'] = $request->frame;
        }

        if($user->has('qrlogo')){

            if($request->punched){
                $qrdata['punchedlogo'] = true;
            }else{
                $qrdata['punchedlogo'] = false;
            }

            if($request->selectlogo && $request->selectlogo != 'none'){
                $qrdata['definedlogo'] = $request->selectlogo.'.png';
            }

            if(is_numeric($request->logosize) && $request->logosize > 50 && $request->logosize <= 500 ){
                $qrdata['logosize'] = $request->logosize;
            }

            if($image = $request->file('logo')){

                if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

                $filename = "qr_logo".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

                move_uploaded_file($image->location, appConfig('app.storage')['qr']['path'].'/'.$filename);

                $qrdata['custom'] = $filename;
            }
        }

        if($request->matrix){
            $qrdata['matrix'] = clean($request->matrix);
        }

        if($request->eye){
            $qrdata['eye'] = clean($request->eye);
            $qrdata['eyeframe'] = clean($request->eyeframe);
            $qrdata['eyecolor'] = $request->eyecolor ?? null;
            $qrdata['eyeframecolor'] = $request->eyeframecolor ?? null;
        }

        if(is_numeric($request->margin) && $request->margin >= 0 && $request->margin <= 10){
            $qrdata['margin'] = $request->margin;
        }

        if($request->error){
            $qrdata['error'] = clean($request->error);
        }

        $url = null;
        $alias = \substr(md5(Auth::user()->rID().$data.Helper::rand(12)), 0, 8);

        if(!in_array($request->type, ['text', 'sms','wifi','staticvcard', 'event'])){
            $url = DB::url()->create();
            $url->userid = Auth::user()->rID();
            $url->url = $data;
            if($request->type == 'link'){
                if(
                    !$this->validate($data) ||
                    !$this->safe($data) ||
                    $this->phish($data) ||
                    $this->virus($data) ||
                    $this->domainBlacklisted($data) ||
                    $this->wordBlacklisted($data)
                ){
                    return Helper::redirect()->back()->with('danger', e('URL is suspected to contain malware and other harmful content.'));
                }
            }
            $url->alias = \substr(md5(Auth::user()->rID().$data.time()), 0, 6);

            if($request->domain && $this->validateDomainNames(trim($request->domain), Auth::user(), false)){
                $url->domain = clean($request->domain);
            }

            if((!$request->domain || $request->domain == config('url')) && !config("root_domain")) {
                if(!$user || !$user->admin){
                    $mdomains = explode("\n", config("domain_names"));
                    $mdomains = array_map("rtrim", $mdomains);
                    if(!empty($mdomains[0])){				
                        $url->domain = trim($mdomains[0]);
                    }else{
                        $url->domain = config("url");
                    }
                }
            }

            if($request->type == 'application') {
                $url->url = $data['link'] ?? url('');
                $url->devices = json_encode([
                    'mac os' => $data['apple'] ?? $data['link'],
                    'iphone' => $data['apple'] ?? $data['link'],
                    'ipad' => $data['apple'] ?? $data['link'],
                    'android' => $data['google'] ?? $data['link'],

                ]);
            }

            $url->date = Helper::dtime();
            $url->save();
        }

        $qr = DB::qrs()->create();
        $qr->userid = Auth::user()->rID();
        $qr->alias = $alias;
        $qr->urlid = $url ? $url->id : null;
        $qr->name = clean($request->name);
        $qr->data = json_encode($qrdata);
        $qr->status = 1;
        $qr->created_at = Helper::dtime();
        $qr->save();

        if($url){
            $url->qrid = $qr->id;
            $url->save();
        }

        return Helper::redirect()->to(route('qr.edit', [$qr->id]))->with('success',  e('QR Code has been successfully generated.'));
    }
    /**
     * Edit QR
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.9
     * @param integer $id
     * @return void
     */
    public function edit(int $id){

        if(Auth::user()->teamPermission('qr.edit') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return back()->with('danger', 'QR does not exist.');
        }

        $qr->data = json_decode($qr->data);

        $url = null;
        if($qr->urlid){
            $url = DB::url()->first($qr->urlid);
        }

        \Helpers\CDN::load("spectrum");

		View::push('<script type="text/javascript">
						$("#bg").spectrum({
					        color: "'.(isset($qr->data->color->bg) ? $qr->data->color->bg : 'rba(255,255,255)').'",
					        preferredFormat: "rgb",
                            allowEmpty:true,
                            showInput: true,
                            move: function (color) { $("#bg").val(color.toRGBString()) },
                            hide: function (color) { $("#bg").val(color.toRGBString()) }
						});
                        $("#fg").spectrum({
					        color: "'.(isset($qr->data->color->fg) ? $qr->data->color->fg : 'rgb(0,0,0)').'",
					        preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#fg").val(color.toRGBString()) },
                            hide: function (color) { $("#fg").val(color.toRGBString()) }
						});
                        $("#framecolor").spectrum({
                            color: "'.(isset($qr->data->frame->color) ? $qr->data->frame->color : 'rbg(0,0,0)').'",
                            preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#framecolor").val(color.toRGBString()) },
                            hide: function (color) { $("#framecolor").val(color.toRGBString()) }
                        });
                        $("#frametextcolor").spectrum({
                            color: "'.(isset($qr->data->frame->textcolor) ? $qr->data->frame->textcolor : 'rgb(255,255,255)').'",
                            preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#frametextcolor").val(color.toRGBString()) },
                            hide: function (color) { $("#frametextcolor").val(color.toRGBString()) }
                        });
                        $("input, select, textarea").on("change", function(){
                            updatePreview();
                        });

                        function updatePreview(){
                            let data = new FormData($(\'[data-trigger=saveqr\')[0]);
                            $.ajax({
                                type: "POST",
                                url: "'.route('qr.preview').'",
                                data: data,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                $("#return-ajax").html(\'<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>\');
                                },
                                complete: function() {      
                                $(\'.preloader\').fadeOut("fast", function(){$(this).remove()});
                                },          
                                success: function (response) { 
                                    $(\'#return-ajax\').html(response);
                                }
                            }); 
                        }
                    </script>', 'custom')->toFooter();

        if(\Helpers\QR::hasImagick()){
            View::push('<script type="text/javascript">
                            $("#gbg").spectrum({
                                color: "'.(isset($qr->data->gradient) ? $qr->data->gradient[1] : 'rgb(255,255,255)').'",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#gbg").val(color.toRGBString()) },
                                hide: function (color) { $("#gbg").val(color.toRGBString()) }
                            });
                            $("#gfg").spectrum({
                                color: "'.(isset($qr->data->gradient) ? $qr->data->gradient[0][0] : 'rgb(0,0,0)').'",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfg").val(color.toRGBString()) },
                                hide: function (color) { $("#gfg").val(color.toRGBString()) }
                            });
                            $("#gfgs").spectrum({
                                color: "'.(isset($qr->data->gradient) ? $qr->data->gradient[0][1] : 'rgb(0,0,0)').'",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfgs").val(color.toRGBString()) },
                                hide: function (color) { $("#gfgs").val(color.toRGBString()) }
                            });
                            $("#eyecolor").spectrum({
                                color: "'.(isset($qr->data->eyecolor) ? $qr->data->eyecolor : '').'",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#eyecolor").val(color.toRGBString()) },
                                hide: function (color) { $("#eyecolor").val(color.toRGBString()) }
                            });
                            $("#eyeframecolor").spectrum({
                                color: "'.(isset($qr->data->eyeframecolor) ? $qr->data->eyeframecolor : '').'",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#eyeframecolor").val(color.toRGBString()) },
                                hide: function (color) { $("#eyeframecolor").val(color.toRGBString()) }
                            });
                        </script>', 'custom')->toFooter();
        }

        View::set('title', e("Edit QR").' '. $qr->name);

        View::push('<style>.main{overflow:initial !important;}</style>', 'custom')->toHeader();

        $domains = false;
        if(!in_array($qr->data->type, ['text', 'sms','wifi','staticvcard'])){
            $domains = [];
            foreach(array_reverse(\Helpers\App::domains(), true) as $domain){
                $domains[] = $domain;
            }
        }

        View::push('<style>.main{overflow:initial !important;}#qr-preview{position: sticky; top: 5px}</style>', 'custom')->toHeader();

        $templates = DB::qrtemplates()->where('status', 1)->findMany();

        return View::with('qr.edit', compact('qr', 'url', 'domains', 'templates'))->extend('layouts.dashboard');
    }
    /**
     * Update QR
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.1
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        if(Auth::user()->teamPermission('qr.edit') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return back()->with('danger', e('QR does not exist.'));
        }

        if(!$request->name) return back()->with('danger', e('Please enter a name for your QR code.'));

        $qr->data = json_decode($qr->data);

        try{

            if($qr->data->type == 'file'){

                if($file = $request->file('file')){                

                    if($qr->data->data){
                        \Helpers\App::delete( appConfig('app.storage')['qr']['path'].'/files/'.$qr->data->data);
                    }
                    $input = call_user_func([\Helpers\QR::class, 'type'.ucfirst($qr->data->type)]);
                    $data = uploads('qr/files/'.$input);
                } else {
                    $input = $qr->data->data;
                    $data = uploads('qr/files/'.$input);
                }

            }elseif($qr->data->type == 'vcard'){

                if($file = $request->file('vcard')){
                    
                    \Helpers\QR::validatevCardPicture();                    
                    if($qr->data->data->image){
                        \Helpers\App::delete( appConfig('app.storage')['qr']['path'].'/'.$qr->data->data->image);
                    }

                    $input = $request->{$qr->data->type} ? $request->{$qr->data->type} : $request->text;
                    $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($qr->data->type)], clean($input));
                    $input['image'] = \Helpers\QR::vcardPicture();
                } else {
                    
                    $input = $request->{$qr->data->type} ? $request->{$qr->data->type} : $request->text;
                    $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($qr->data->type)], clean($input));
                    $input['image'] = $qr->data->data->image;
                }
                
            }else {
                $input = $request->{$qr->data->type} ? $request->{$qr->data->type} : $request->text;
                $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($qr->data->type)], clean($input));

            }
        } catch(\Exception $e){
            return Helper::redirect()->to(route('qr.edit', [$qr->id]))->with('danger',  $e->getMessage());
        }

        if($qr->data->type == 'link'){
            if(
                !$this->validate($data) ||
                !$this->safe($data) ||
                $this->phish($data) ||
                $this->virus($data) ||
                $this->domainBlacklisted($data) ||
                $this->wordBlacklisted($data)
            ){
                return Helper::redirect()->back()->with('danger', e('URL is suspected to contain malware and other harmful content.'));
            }
        }

        $qr->data->data = $input;

        if($request->template && $template = DB::qrtemplates()->where('id', $request->template)->first()){
            $template->data = json_decode($template->data);
            
            $request->mode = $template->data->mode;
            $request->bg = $template->data->color->bg ?? '';
            $request->fg = $template->data->color->fg ?? '';
            $request->gradient = [
                'start' => $template->data->gradient[0][0],
                'stop' => $template->data->gradient[0][1],
                'bg' => $template->data->gradient[1],
                'direction' => $template->data->gradient[2]
            ];
            $request->matrix = $template->data->matrix;
            $request->logosize = $template->data->logosize;
            $request->punchedlogo = $template->data->punchedlogo;
            $request->selectlogo = $template->data->definedlogo;
            $request->frame = [
                'type' => $template->data->frame->type,
                'color' => $template->data->frame->color,
                'text' => $template->data->frame->text,
                'textcolor' => $template->data->frame->textcolor,
                'font' => $template->data->frame->font  
            ];
            $request->margin = $template->data->margin ?? '0';
            $request->error = $template->data->error;
            $request->eye = $template->data->eye;
            $request->eyeframe = $template->data->eyeframe;
            $request->eyecolor = $template->data->eyecolor;
            $request->eyeframecolor = $template->data->eyeframecolor;
        }
        
        $qr->data->mode = clean($request->mode);

        if($request->mode == 'gradient'){
            unset($qr->data->color);
            $qr->data->gradient = [
                [clean($request->gradient['start']), clean($request->gradient['stop'])],
                clean($request->gradient['bg']),
                clean($request->gradient['direction'])
            ];
        } else {
            unset($qr->data->gradient);
            $qr->data->color = ['bg' => clean($request->bg), 'fg' => clean($request->fg)];
        }

        if($user->has('qrframes') && $request->frame){
            $qr->data->frame = $request->frame;
        }

        if($user->has('qrlogo')){
            if($request->selectlogo){
                if($request->selectlogo == 'none'){
                    if(isset($qr->data->custom)){
                        \Helpers\App::delete( appConfig('app.storage')['qr']['path'].'/'.$qr->data->custom);
                    }
                    unset($qr->data->definedlogo);
                    unset($qr->data->custom);
                } else{
                    $qr->data->definedlogo = $request->selectlogo.'.png';
                    unset($qr->data->custom);
                }
            }

            if($image = $request->file('logo')){

                if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

                $filename = "qr_logo".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

                move_uploaded_file($image->location, appConfig('app.storage')['qr']['path'].'/'.$filename);

                if(isset($qr->data->custom)){
                    \Helpers\App::delete( appConfig('app.storage')['qr']['path'].'/'.$qr->data->custom);
                }

                unset($qr->data->definedlogo);

                $qr->data->custom = $filename;
            }
        }

        if($request->matrix){
            $qr->data->matrix = clean($request->matrix);
        }

        if($request->punched){
            $qr->data->punchedlogo = true;
        }else{
            $qr->data->punchedlogo = false;
        }
        
        if($request->eye){
            $qr->data->eye = clean($request->eye);
            $qr->data->eyeframe = clean($request->eyeframe);
            $qr->data->eyecolor = clean($request->eyecolor);
            $qr->data->eyeframecolor = clean($request->eyeframecolor);
        }

        if(is_numeric($request->logosize) && $request->logosize > 50 && $request->logosize <= 500 ){
            $qr->data->logosize = $request->logosize;
        }

        if(is_numeric($request->margin) && $request->margin >= 0 && $request->margin <= 10){
            $qr->data->margin = $request->margin;
        }

        if($request->error){
            $qr->data->error = clean($request->error);
        }

        if($qr->urlid && $url = DB::url()->where('id', $qr->urlid)->first()){

            if($qr->data->type == 'application') {
                $url->url = $data['link'] ?? url('');
                $url->devices = json_encode([
                    'mac os' => $data['apple'] ?? $data['link'],
                    'iphone' => $data['apple'] ?? $data['link'],
                    'ipad' => $data['apple'] ?? $data['link'],
                    'android' => $data['google'] ?? $data['link'],

                ]);
            } else {
                $url->url = $data;
            }

            if($request->domain && $this->validateDomainNames(trim($request->domain), Auth::user(), false)){
                $url->domain = clean($request->domain);
            }

            $url->save();
        }
        if($qr->filename){
            \Helpers\App::delete(appConfig('app.storage')['qr']['path'].'/'.$qr->filename);
        }
        $qr->filename = null;
        
        $qr->name = Helper::clean($request->name, 3);
        $qr->data = json_encode($qr->data);

        $qr->save();

        return Helper::redirect()->to(route('qr.edit', [$qr->id]))->with('success',  e('QR Code has been successfully updated.'));
    }
    /**
     * Delete QR
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){

        if(Auth::user()->teamPermission('qr.delete') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'qr.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return back()->with('danger', 'QR does not exist.');
        }

        if($qr->filename){
            \Helpers\App::delete( appConfig('app.storage')['qr']['path'].'/'.$qr->filename);
        }

        $qr->delete();

        DB::tochannels()->where('itemid', $id)->where('type', 'qr')->deleteMany();

        if($url = DB::url()->where('qrid', $id)->where('userid', Auth::user()->rID())->first()){
            $this->deleteLink($url->id);
        }

        return back()->with('success', e('QR has been successfully deleted.'));
    }
    /**
     * Duplicate
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.1.3
     * @param integer $id
     * @return void
     */
    public function duplicate(int $id){
        if(Auth::user()->teamPermission('qr.edit') == false){
			return Helper::redirect()->to(route('qr'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        $user = Auth::user();

        if($user->plan('qrcounttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::qrs()->whereRaw("(created_at BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::qrs()->where('userid', $user->rID())->count();

        }

        $total = Auth::user()->hasLimit('qr');

        \Models\Plans::checkLimit($count, $total);

        if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return back()->with('danger', 'QR does not exist.');
        }

        $newurl = null;

        $alias = \substr(md5(Auth::user()->rID().Helper::rand(12)), 0, 8);

        if($qr->urlid){
            $url = DB::url()->first($qr->urlid);
            $newurl = DB::url()->create();
            $newurl->userid = Auth::user()->rID();
            $newurl->url = $qr->data;
            $newurl->alias = $alias;
            $newurl->date = Helper::dtime();
            $newurl->save();
        }

        $new = DB::qrs()->create();
        $new->userid = Auth::user()->rID();
        $new->alias = $alias;
        $new->urlid = $newurl ? $newurl->id : null;
        $new->name = $qr->name.' ('.e('Copy').')';
        $new->data = $qr->data;
        $new->status = 1;
        $new->created_at = Helper::dtime();
        $new->save();

        if($newurl){
            $newurl->qrid = $new->id;
            $newurl->save();
        }

        return Helper::redirect()->back()->with('success', e('Item has been successfully duplicated.'));
    }
    /**
     * Create QR code in Bulk
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public function createbulk(){
        
        if(User::where('id', Auth::user()->rID())->first()->has('bulkqr') === false){
			return \Models\Plans::notAllowed();
		}

        if(Auth::user()->teamPermission('qr.create') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        $user = Auth::user();

        if($user->plan('qrcounttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::qrs()->whereRaw("(created_at BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::qrs()->where('userid', $user->rID())->count();

        }

        $total = Auth::user()->hasLimit('qr');

        \Models\Plans::checkLimit($count, $total);

        View::set('title', e('Create QR in Bulk'));

        \Helpers\CDN::load("spectrum");

		View::push('<script type="text/javascript">
						$("#bg").spectrum({
					        color: "rgb(255,255,255)",
					        preferredFormat: "rgb",
                            allowEmpty:true,
                            showInput: true,
                            move: function (color) { $("#bg").val(color.toRGBString()) },
		                    hide: function (color) { $("#bg").val(color.toRGBString()) }
						});
                        $("#fg").spectrum({
					        color: "rgb(0,0,0)",
					        preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#fg").val(color.toRGBString()) },
		                    hide: function (color) { $("#fg").val(color.toRGBString()) }
						});
                        $("[data-trigger=switcher]").click(function(e){
                            e.preventDefault();
                            if($(this).hasClass("active")) return false;
                            $(".switcher").fadeOut("fast");
                            $($(this).attr("href")).show();
                            $("[data-trigger=switcher]").removeClass("active").removeClass("border-primary");
                            $(this).addClass("active").addClass("border-primary");
                            $("input[name=type]").val($(this).attr("href").replace("#", ""));
                        });
                    </script>', 'custom')->toFooter();

        if(\Helpers\QR::hasImagick()){
            View::push('<script type="text/javascript">
                            $("#gbg").spectrum({
                                color: "rgb(255,255,255)",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#gbg").val(color.toRGBString()) },
                                hide: function (color) { $("#gbg").val(color.toRGBString()) }
                            });
                            $("#gfg").spectrum({
                                color: "rgb(0,0,0)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfg").val(color.toRGBString()) },
                                hide: function (color) { $("#gfg").val(color.toRGBString()) }
                            });
                            $("#gfgs").spectrum({
                                color: "rgb(0,0,0)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfgs").val(color.toRGBString()) },
                                hide: function (color) { $("#gfgs").val(color.toRGBString()) }
                            });
                            $("#framecolor").spectrum({
                                color: "rgb(0,0,0)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#framecolor").val(color.toRGBString()) },
                                hide: function (color) { $("#framecolor").val(color.toRGBString()) }
                            });
                            $("#frametextcolor").spectrum({
                                color: "rgb(255,255,255)",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#frametextcolor").val(color.toRGBString()) },
                                hide: function (color) { $("#frametextcolor").val(color.toRGBString()) }
                            });
                            $("#eyecolor, #eyeframecolor").spectrum({
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                            });
                        </script>', 'custom')->toFooter();
        }
        View::push('<style>.main{overflow:initial !important;}#qr-preview{position: sticky; top: 5px}</style>', 'custom')->toHeader();

        $domains = [];
        foreach(array_reverse(\Helpers\App::domains(), true) as $domain){
            $domains[] = $domain;
        }

        return View::with('qr.bulk', compact('domains'))->extend('layouts.dashboard');
    }
        /**
     * Generate and Save QR Code in Bulk
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.9
     * @param \Core\Request $request
     * @return void
     */
    public function savebulk(Request $request){

        if(User::where('id', Auth::user()->rID())->first()->has('bulkqr') === false){
			return \Models\Plans::notAllowed();
		}

        if(Auth::user()->teamPermission('qr.create') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        $user = Auth::user();

        if(!in_array($request->type, ['text', 'link'])) return back()->with('danger',  e('Invalid QR format or missing data'));

        if(!$request->name) return back()->with('danger', e('Please enter a name for your QR code.'));
        
        if($user->plan('qrcounttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::qrs()->whereRaw("(created_at BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::qrs()->where('userid', $user->rID())->count();

        }

        $total = Auth::user()->hasLimit('qr');

        \Models\Plans::checkLimit($count, $total);

        $i = 0;

        if($file = $request->file('file')){

            $content = file_get_contents($file->location);

            $content = explode("\n", clean($content));

        } else {
            $content = explode("\n", clean($request->content));
        }

        $countdata = count($content);

        foreach($content as $input){

            if(empty($input)) continue;

            if($total != 0 && $count >= $total) {
                return Helper::redirect()->to(route('qr'))->with('success',  e('You have reached your limit. {i}/{j} QR codes have been generated.', null, ['i' => $i, 'j' => $countdata])); 
            }

            try{
                $data = call_user_func([\Helpers\QR::class, 'type'.ucfirst($request->type)], clean($input));
            }  catch(\Exception $e){
                continue;
            }
            $qrdata = [];

            $qrdata['type'] = clean($request->type);
    
            $qrdata['data'] = $input;
    
            $qrdata['mode'] = clean($request->mode);
    
            if($request->mode == 'gradient'){
                $qrdata['gradient'] = [
                    [clean($request->gradient['start']), clean($request->gradient['stop'])],
                    clean($request->gradient['bg']),
                    clean($request->gradient['direction'])
                ];
            } else {
                $qrdata['color'] = ['bg' => clean($request->bg), 'fg' => clean($request->fg)];
            }
    
    
            if($user->has('qrframes') && $request->frame){
                $qrdata['frame'] = $request->frame;
            }
    
            if($user->has('qrlogo')){
    
                if($request->punched){
                    $qrdata['punchedlogo'] = true;
                }else{
                    $qrdata['punchedlogo'] = false;
                }
    
                if($request->selectlogo && $request->selectlogo != 'none'){
                    $qrdata['definedlogo'] = $request->selectlogo.'.png';
                }
    
                if(is_numeric($request->logosize) && $request->logosize > 50 && $request->logosize <= 500 ){
                    $qrdata['logosize'] = $request->logosize;
                }
    
                if($image = $request->file('logo')){
    
                    if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));
    
                    $filename = "qr_logo".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);
    
                    move_uploaded_file($image->location, appConfig('app.storage')['qr']['path'].'/'.$filename);
    
                    $qrdata['custom'] = $filename;
                }
            }
    
            if($request->matrix){
                $qrdata['matrix'] = clean($request->matrix);
            }
    
            if($request->eye){
                $qrdata['eye'] = clean($request->eye);
                $qrdata['eyeframe'] = clean($request->eyeframe);
                $qrdata['eyecolor'] = $request->eyecolor ?? null;
                $qrdata['eyeframecolor'] = $request->eyeframecolor ?? null;
            }
    
            if(is_numeric($request->margin) && $request->margin >= 0 && $request->margin <= 10){
                $qrdata['margin'] = $request->margin;
            }
    
            if($request->error){
                $qrdata['error'] = clean($request->error);
            }
    
            $url = null;
            $alias = \substr(md5(Auth::user()->rID().$data.Helper::rand(12)), 0, 8);
    
            if(!in_array($request->type, ['text', 'sms','wifi','staticvcard', 'event'])){
                $url = DB::url()->create();
                $url->userid = Auth::user()->rID();
                $url->url = $data;
                if($request->type == 'link'){
                    if(
                        !$this->validate($data) ||
                        !$this->safe($data) ||
                        $this->phish($data) ||
                        $this->virus($data) ||
                        $this->domainBlacklisted($data) ||
                        $this->wordBlacklisted($data)
                    ){
                        continue;
                    }
                }
                $url->alias = \substr(md5(Auth::user()->rID().$data.time()), 0, 6);
    
                if($request->domain && $this->validateDomainNames(trim($request->domain), Auth::user(), false)){
                    $url->domain = clean($request->domain);
                }
    
                if($request->type == 'application') {
                    $url->url = $data['link'] ?? url('');
                    $url->devices = json_encode([
                        'mac os' => $data['apple'] ?? $data['link'],
                        'iphone' => $data['apple'] ?? $data['link'],
                        'ipad' => $data['apple'] ?? $data['link'],
                        'android' => $data['google'] ?? $data['link'],
    
                    ]);
                }
    
                $url->date = Helper::dtime();
                $url->save();
            }
    
            $qr = DB::qrs()->create();
            $qr->userid = Auth::user()->rID();
            $qr->alias = $alias;
            $qr->urlid = $url ? $url->id : null;
            $qr->name = clean($request->name);
            $qr->data = json_encode($qrdata);
            $qr->status = 1;
            $qr->created_at = Helper::dtime();
            $qr->save();
    
            if($url){
                $url->qrid = $qr->id;
                $url->save();
            }
            $count++;
            $i++;
        }

        return Helper::redirect()->to(route('qr'))->with('success',  e('{i}/{j} QR codes have been generated.', null, ['i' => $i, 'j' => $countdata]));
    }
    /**
     * Delete all
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public function deleteall(Request $request){
        if(Auth::user()->teamPermission('qr.delete') == false){
			return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}

        \Gem::addMiddleware('DemoProtect');
        
        $ids = json_decode($request->selected);

        if(!$ids || count($ids) < 1) return back()->with('danger', e('You must select at least 1 QR code.'));
        
        $i = 0;
        foreach($ids as $id){
            if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rID())->first()) continue;

            if($qr->filename){
                \Helpers\App::delete( appConfig('app.storage')['qr']['path'].'/'.$qr->filename);
            }

            $qr->delete();

            DB::tochannels()->where('itemid', $id)->where('type', 'qr')->deleteMany();

            if($url = DB::url()->where('qrid', $id)->where('userid', Auth::user()->rID())->first()){
                $this->deleteLink($url->id);
            }
            $i++;
        }

        return back()->with('success', e('{n} QR codes have been successfully deleted.', null, ['n' => $i]));
    }
    /**
     * Download QR codes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @param \Core\Request $request
     * @return void
     */
    public function downloadall(Request $request){
        
        $user = Auth::user();

        $ids = json_decode($request->qrids);

        if(!$ids || count($ids) < 1) return back()->with('danger', e('You must select at least 1 QR code.'));

        $folder = STORAGE.'/app/tmp/';

		$session = md5(time().$user->id.Helper::rand(12));
		
		mkdir($folder.$session, 0777);
        
        $files = [];

        foreach($ids as $id){
            
            if(!$qr = DB::qrs()->where('id', $id)->where('userid', Auth::user()->rID())->first()) continue;

            $qr->data = json_decode($qr->data);

            if($qr->urlid && $url = DB::url()->where('id', $qr->urlid)->first()){        
                $data = ['type' => 'link', 'data' =>  \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom)];
            } else {        
                $data = ['type' => $qr->data->type, 'data' => $qr->data->data];
            }

            $size = 1000;

            $format = 'svg';

            if(config('imagemagick')){
                $format = in_array($request->format, ['webp', 'png', 'pdf']) ? $request->format : 'svg';
            }

            try {
                
                $margin = isset($qr->data->margin) && is_numeric($qr->data->margin) && $qr->data->margin <= 10 ? $qr->data->margin : 0;
    
                $data = \Helpers\QR::factory($data, $size, $margin)->format($format);
    
                if(\Helpers\Qr::hasImagick() && isset($qr->data->gradient)){
                    
                    if(isset($qr->data->eyeframecolor) && $qr->data->eyeframecolor){
                        $qr->data->gradient[] = $qr->data->eyeframecolor;
                    }
    
                    if(isset($qr->data->eyecolor) && $qr->data->eyecolor){
                        $qr->data->gradient[] = $qr->data->eyecolor;
                    }
    
                    $data->gradient(...$qr->data->gradient);
    
                } else {
                    $data->color($qr->data->color->fg, $qr->data->color->bg, $qr->data->eyeframecolor ?? null, $qr->data->eyecolor ?? null);
                }
    
                if(\Helpers\Qr::hasImagick() && isset($qr->data->matrix)){
                    $data->module($qr->data->matrix);
                }
    
                if(\Helpers\Qr::hasImagick() && isset($qr->data->eye)){
                    $data->eye($qr->data->eye, $qr->data->eyeframe ?? 'square');
                }
    
                if(\Helpers\Qr::hasImagick() && isset($qr->data->frame) && $user->has('qrframes')){
                    
                    $options = (array) $qr->data->frame;
                    $options['bg'] = $qr->data->mode == 'gradient' ? $qr->data->gradient[1] : $qr->data->color->bg;
                    if(in_array($qr->data->frame->font, ['Arial', 'Courier_New', 'Times_New_Roman', 'Comic_Sans_MS', 'Verdana', 'Impact', 'Tahoma'])){
                        $options['font'] = str_replace('_', ' ', $qr->data->frame->font);
                    }
    
                    $data->withFrame($options);
                }
                
                $size = ($qr->data->logosize ?? 150)*$size/1000;
    
                if($user->has('qrlogo')){
    
                    if(isset($qr->data->punchedlogo) && $qr->data->punchedlogo){
                        $data->isPunched();
                    }
    
                    if(isset($qr->data->definedlogo) && $qr->data->definedlogo && $qr->data->definedlogo != 'none.png'){
                        $data->withLogo(PUB.'/static/images/'.$qr->data->definedlogo, ($margin > 0) ? ($size - $margin*4) : $size);
                    }  
    
                    if(isset($qr->data->custom) && $qr->data->custom && file_exists(View::storage($qr->data->custom, 'qr'))){
                        $data->withLogo(View::storage($qr->data->custom, 'qr'), ($margin > 0) ? ($size - $margin*4) : $size);
                    }
                } else {
                    if(config('qrlogo')){
                        $data->withLogo(PUB.'/content/'.config('qrlogo'), ($margin > 0) ? (250 - $margin*4) : 250);
                    }
                }
    
                if(isset($qr->data->error) && in_array($qr->data->error, ['l', 'm', 'q', 'h'])){
                    $data->errorCorrection($qr->data->error);
                }
                
                $filename = 'QR-'.$qr->name.'-'.Helper::rand(5).'.'.$data->extension();
                $files[] = $filename;
                $qr = $data->string();
                $fqr = fopen($folder.$session.'/'.$filename, 'w');
                fwrite($fqr, $qr);
                fclose($fqr);
            } catch(\Exception $e){
                continue;
            }
        }
        
		$zip = new \ZipArchive();
		$zip->open($folder.$session."/qrcodes.zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $i = 0;
		foreach($files as $file){
            $filePath = $folder.$session.'/'.$file;
            $relativePath = substr($filePath, strlen($folder.$session) + 1);
            $zip->addFile($filePath, $relativePath);
		}
		$zip->close();

		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=\"qrcodes.zip\"");
		readfile($folder.$session."/qrcodes.zip");

		unlink($folder.$session."/qrcodes.zip");

        \Helpers\App::deleteFolder($folder.$session);        
    }
}