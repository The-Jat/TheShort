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

namespace Admin;

use Core\DB;
use Core\View;
use Core\Request;
use Core\Helper;
Use Helpers\CDN;
use Helpers\App;

class BioThemes {
    /**
     * Bio Themes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function index(Request $request){        
        
        if(!user()->hasRolePermission('bio.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view bio themes.'));
        }

        View::set('title', e('Bio Page Theme Manager'));
        
        $themes = DB::themes()->orderByDesc('id')->paginate(15);
        
        return View::with('admin.themes.index', compact('themes'))->extend('admin.layouts.main');
    }
    /**
     * Add Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function new(){
        
        if(!user()->hasRolePermission('bio.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create bio themes.'));
        }

        View::set('title', e('New Theme'));

        return View::with('admin.themes.new')->extend('admin.layouts.main');
    }
    /**
     * Save domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        if(!user()->hasRolePermission('bio.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create bio themes.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $request->save('name', clean($request->name));
        $request->save('description', clean($request->description));
        
        if(!$request->name) return Helper::redirect()->back()->with('danger', e('The theme name is required.'));
        
        $theme = DB::themes()->create();
        $theme->name = Helper::clean($request->name, 3, true);
        $theme->description = Helper::clean($request->description, 3, true);
        $theme->paidonly = 0;
        $theme->status = 0;

        $data = [
            'bgtype' => null,
            'singlecolor' => null,
            'gradientstart' => null,
            'gradientstop' => null,
            'gradientangle' => null,
            'bgimage' => null,
            'customcss' => null,
            'textcolor' => null,
            'buttoncolor' => null,
            'buttontextcolor' => null,
            'buttonstyle' => null,
            'shadow' => null,
            'shadowcolor' => null,
        ];
        $theme->data = json_encode($data);

        $theme->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.bio.theme.edit', $theme->id))->with('success', e('Theme has been created successfully'));
    }
    /**
     * Edit Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        
        if(!user()->hasRolePermission('bio.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit bio themes.'));
        }

        if(!$theme = DB::themes()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Theme does not exist.'));

        View::set('title', e('Edit Bio Page Theme'));

        \Helpers\CDN::load('spectrum');
        
        $theme->data = json_decode($theme->data);        

        View::push('
                <style>.btn-transparent { background: transparent !important; } #preview .btn {border: 2px solid transparent}</style>
                <script>

                    $("#preview .card h3, #preview .card p").attr("style", "color: '.($theme->data->textcolor ?? '#000').' !important");

                    $("#preview .card .btn").attr("style", "border-color: '.($theme->data->buttoncolor ?? '#000').';background: '.($theme->data->buttoncolor ?? '#000').';color: '.($theme->data->buttontextcolor ?? '#fff').'");

                    '.($theme->data->bgtype == 'single' ? 
                        '$("#preview .card").attr("style", "background: '.($theme->data->singlecolor ?? '#fff').' !important");'
                    :'').'

                    '.($theme->data->bgtype == 'gradient' ? 
                        '$("#preview .card").attr("style", "background:  linear-gradient('.($theme->data->gradientangle ?? '135').'deg, '.$theme->data->gradientstart.' 0%, '.$theme->data->gradientstop.' 100%);");'
                    :'').'

                    '.($theme->data->bgtype == 'image' ? 
                        '$("#preview .card").attr("style", "background-image: url('.uploads($theme->data->bgimage, 'profile').');background-size: cover;");'
                    :'').'

                    '.($theme->data->bgtype == 'css' ? 
                        '$("#preview .card").attr("style", "'.preg_replace("/[\n\r\t]/", "", $theme->data->customcss).'");'
                    :'').'

                    '.($theme->data->buttonstyle == 'rectangle' ? 
                        '$("#preview .card .btn").removeClass("rounded-pill").removeClass("btn-transparent");'
                    :'').'

                    '.($theme->data->buttonstyle == 'rounded' ? 
                        '$("#preview .card .btn").addClass("rounded-pill").removeClass("btn-transparent");'
                    :'').'

                    '.($theme->data->buttonstyle == 'trec' ? 
                        '$("#preview .card .btn").removeClass("rounded-pill").addClass("btn-transparent");'
                    :'').'

                    '.($theme->data->buttonstyle == 'tro' ? 
                        '$("#preview .card .btn").addClass("rounded-pill").addClass("btn-transparent");'
                    :'').'

                    '.($theme->data->shadow == 'soft' ? 
                        '$("#preview .card .btn").css("box-shadow","2px 2px 5px '.$theme->data->shadowcolor.'");'
                    :'').'

                    '.($theme->data->shadow == 'hard' ? 
                        '$("#preview .card .btn").css("box-shadow","5px 5px 0px 1px '.$theme->data->shadowcolor.'");'
                    :'').'

                    $("select[name=bgtype]").change(function() {
                        let v = $(this).val();
                        $(".bgblock").addClass("d-none");
                        $("#"+v).removeClass("d-none");
                        $("#preview .card").attr("style", "background:#fff");
                    });

                    $("select[name=buttonstyle]").change(function() {
                        let v = $(this).val();
                        if(v == "rectangular"){
                            $("#preview .card .btn").removeClass("rounded-pill").removeClass("btn-transparent");
                        }
                        if(v == "rounded"){
                            $("#preview .card .btn").addClass("rounded-pill").removeClass("btn-transparent");
                        }
                        if(v == "trec"){
                            $("#preview .card .btn").removeClass("rounded-pill").addClass("btn-transparent");
                        }
                        if(v == "tro"){
                            $("#preview .card .btn").addClass("rounded-pill").addClass("btn-transparent");
                        }
                    });
                    $("select[name=shadow]").change(function() {
                        let v = $(this).val();
                        let color = $("input[name=shadowcolor]").val();

                        if(v == "none"){
                            $("#preview .card .btn").css("box-shadow","none");
                        }
                        if(v == "soft"){
                            $("#preview .card .btn").css("box-shadow","2px 2px 5px "+color);
                        }
                        if(v == "hard"){
                            $("#preview .card .btn").css("box-shadow","5px 5px 0px 1px "+color);
                        }
                    });

                    var d = "135deg";

                    $("#gradientangle").change(function(){
                        d = $(this).val()+"deg";
                        let start = $("input[name=gradientstart").val();
                        let end = $("input[name=gradientstop").val();
                        $("#angle i").text($(this).val());
                        $("#preview .card").attr("style", "background:  linear-gradient("+d+", "+start+" 0%, "+end+" 100%);"); 
                    });
                    
                    $("input[name=textcolor]").spectrum({
                        color: "'.($theme->data->textcolor ?? '#000000').'",
                        showInput: true,
                        preferredFormat: "hex",
                        move: function (color) { $("#preview .card h3, #preview .card p").attr("style", "color: "+color.toHexString()+" !important"); $(this).val(color.toHexString()); },
                        hide: function (color) { $("#preview .card h3, #preview .card p").attr("style", "color: "+color.toHexString()+" !important"); $(this).val(color.toHexString()); }
                    });
                    $("input[name=singlecolor]").spectrum({
                        color: "'.($theme->data->singlecolor ?? '#ffffff').'",
                        showInput: true,
                        preferredFormat: "hex",
                        move: function (color) { $("#preview .card").attr("style", "background: "+color.toHexString()); $(this).val(color.toHexString()); },
                        hide: function (color) { $("#preview .card").attr("style", "background: "+color.toHexString()); $(this).val(color.toHexString()); }
                    });
                    $("input[name=gradientstart").spectrum({
                        color: "'.($theme->data->gradientstart ?? '#ffffff').'",
                        showInput: true,
                        preferredFormat: "hex",
                        move: function (color) { 
                            let end = $("input[name=gradientstop").val();
                            if(end.length == 0) end = "#fff";
                            $("#preview .card").attr("style", "background:  linear-gradient("+d+", "+color.toHexString()+" 0%, "+end+" 100%);"); 
                            $(this).val(color.toHexString()); 
                        },
                        hide: function (color) { 
                            let end = $("input[name=gradientstop").val();
                            if(end.length == 0) end = "#fff";
                            $("#preview .card").attr("style", "background:  linear-gradient("+d+", "+color.toHexString()+" 0%, "+end+" 100%);"); 
                            $(this).val(color.toHexString());                             
                        }
                    });
                    $("input[name=gradientstop").spectrum({
                        color: "'.($theme->data->gradientstop ?? '#ffffff').'",
                        showInput: true,
                        preferredFormat: "hex",
                        move: function (color) { 
                            let start = $("input[name=gradientstart").val();
                            $("#preview .card").attr("style", "background:  linear-gradient("+d+", "+start+" 0%, "+color.toHexString()+" 100%);"); 
                            $(this).val(color.toHexString()); 
                        },
                        hide: function (color) { 
                            let start = $("input[name=gradientstart").val();
                            $("#preview .card").attr("style", "background:  linear-gradient("+d+", "+start+" 0%, "+color.toHexString()+" 100%);"); 
                            $(this).val(color.toHexString());
                        }
                    });

                    $("input[name=buttoncolor]").spectrum({
                        color: "'.($theme->data->buttoncolor ?? '#000000').'",
                        showInput: true,
                        preferredFormat: "hex",
                        move: function (color) { $("#preview .card .btn").css("background", color.toHexString()).css("borderColor", color.toHexString()); $(this).val(color.toHexString()); },
                        hide: function (color) { $("#preview .card .btn").css("background", color.toHexString()).css("borderColor", color.toHexString()); $(this).val(color.toHexString()); }
                    });
                    $("input[name=buttontextcolor]").spectrum({
                        color: "'.($theme->data->buttontextcolor ?? '#ffffff').'",
                        showInput: true,
                        preferredFormat: "hex",
                        move: function (color) { $("#preview .card .btn").css("color", color.toHexString()); $(this).val(color.toHexString()); },
                        hide: function (color) { $("#preview .card .btn").css("color", color.toHexString()); $(this).val(color.toHexString()); }
                    });
                    $("input[name=shadowcolor]").spectrum({
                        color: "'.($theme->data->shadowcolor ?? '#000000').'",
                        showInput: true,
                        preferredFormat: "hex",
                        move: function (color) {
                            let v = $("select[name=shadow]").val();

                            if(v == "none"){
                                $("#preview .card .btn").css("box-shadow","none");
                            }
                            if(v == "soft"){
                                $("#preview .card .btn").css("box-shadow","2px 2px 5px "+color.toHexString());
                            }
                            if(v == "hard"){
                                $("#preview .card .btn").css("box-shadow","5px 5px 0px 1px "+color.toHexString());
                            }

                            $(this).val(color.toHexString());
                        },
                        hide: function (color) { 
                            
                            let v = $("select[name=shadow]").val();

                            if(v == "none"){
                                $("#preview .card .btn").css("box-shadow","none");
                            }
                            if(v == "soft"){
                                $("#preview .card .btn").css("box-shadow","2px 2px 5px "+color.toHexString());
                            }
                            if(v == "hard"){
                                $("#preview .card .btn").css("box-shadow","5px 5px 0px 1px "+color.toHexString());
                            }

                            $(this).val(color.toHexString()); }
                    });
                    
                    $("#bgimage").change(function(){
                        var files = $(this).prop("files");                
                        for (var i = 0, f; f = files[i]; i++) {
                
                            if (!["image/jpeg", "image/jpg", "image/png"].includes(f.type) || f.size > 3*1024*1024) {
                                $.notify({
                                message: $("#bgimage").data("error")
                                },{
                                    type: "danger",
                                    placement: {
                                        from: "top",
                                        align: "right"
                                    },
                                });
                                continue;
                            }else {
                                var reader = new FileReader();

                                reader.onload = (function() {
                                    return function(e) {
                                        $("#preview .card").attr("style", "background-image: url("+e.target.result+");background-size: cover;");
                                    }
                                })(f);
                    
                                reader.readAsDataURL(f);
                            }
                            
                        }
                    });

                    $("textarea[name=customcss]").keyup(function(){
                        $("#preview .card").attr("style", $(this).val());
                    });
            </script>', 'custom')->tofooter();
        
        return View::with('admin.themes.edit', compact('theme'))->extend('admin.layouts.main');
    }
    /**
     * Update Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){        

        if(!user()->hasRolePermission('bio.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit bio themes.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!$theme = DB::themes()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Theme does not exist.'));
        
        if(!$request->name) return Helper::redirect()->back()->with('danger', e('The theme name is required.'));
            
        $theme->name = Helper::clean($request->name, 3, true);
        $theme->description = Helper::clean($request->description, 3, true);
        $theme->paidonly = $request->paidonly ?? 0;
        $theme->status = $request->status ?? 0;
        
        $data = json_decode($theme->data, true);

        $data['bgtype'] = Helper::clean($request->bgtype, 3, true);

        if($request->bgtype == 'single'){
            $data['singlecolor'] = Helper::clean($request->singlecolor, 3, true);
        }

        if($request->bgtype == 'gradient'){
            $data['gradientstart'] = Helper::clean($request->gradientstart, 3, true);
            $data['gradientstop'] = Helper::clean($request->gradientstop, 3, true);
            $data['gradientangle'] = Helper::clean($request->gradientangle, 3, true);                    
        }

        if($request->bgtype == 'image'){
            if($image = $request->file('bgimage')){
                if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png','jpeg'])) return Helper::redirect()->back()->with('danger', e('The background image is not valid. Only a JPG, PNG are accepted.'));
                
                if($data['bgimage']) App::delete(appConfig('app.storage')['profile']['path'].'/'.$data['bgimage']);
                
                $data['bgimage'] = time().str_replace(' ', '-', $image->name);

                $request->move($image, appConfig('app.storage')['profile']['path'], $data['bgimage']);
            }            
        }

        if($request->bgtype == 'css'){
            $data['customcss'] = Helper::clean($request->customcss, 3, true);
        }

        if($request->textcolor){
            $data['textcolor'] = Helper::clean($request->textcolor, 3, true);
        }

        if($request->buttoncolor){
            $data['buttoncolor'] = Helper::clean($request->buttoncolor, 3, true);
        }
        if($request->buttontextcolor){
            $data['buttontextcolor'] = Helper::clean($request->buttontextcolor, 3, true);
        }
        if($request->buttonstyle){
            $data['buttonstyle'] = Helper::clean($request->buttonstyle, 3, true);
        }
        if($request->shadow){
            $data['shadow'] = Helper::clean($request->shadow, 3, true);
        }
        if($request->shadowcolor){
            $data['shadowcolor'] = Helper::clean($request->shadowcolor, 3, true);
        }

        $theme->data = json_encode($data);

        $theme->save();

        return Helper::redirect()->back()->with('success', e('Theme has been updated successfully.'));
    }
    /**
     * Delete Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        
        if(!user()->hasRolePermission('bio.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete bio themes.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'theme.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$theme = DB::themes()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Theme does not exist.'));

        $data = json_decode($theme->data, true);

        if($data['bgimage']) App::delete(appConfig('app.storage')['profile']['path'].'/'.$data['bgimage']);

        $theme->delete();

        return Helper::redirect()->back()->with('success', e('Theme has been deleted.'));
    }    
}