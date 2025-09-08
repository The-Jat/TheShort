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

class QrTemplates {
    /**
     * QR Templates
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function index(Request $request){        
        
        if(!user()->hasRolePermission('qr.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view QR templates.'));
        }

        View::set('title', e('QR Code Template Manager'));
        
        $templates = DB::qrtemplates()->orderByDesc('id')->paginate(15);
        
        return View::with('admin.qrtemplates.index', compact('templates'))->extend('admin.layouts.main');
    }

    /**
     * New Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function new(){
        
        if(!user()->hasRolePermission('qr.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create QR templates.'));
        }

        View::set('title', e('New QR Template'));

        return View::with('admin.qrtemplates.new')->extend('admin.layouts.main');
    }

    /**
     * Save Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        if(!user()->hasRolePermission('qr.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create QR templates.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $request->save('name', clean($request->name));
        $request->save('description', clean($request->description));
        
        if(!$request->name) return Helper::redirect()->back()->with('danger', e('The template name is required.'));
        
        $template = DB::qrtemplates()->create();
        $template->name = Helper::clean($request->name, 3, true);
        $template->description = Helper::clean($request->description, 3, true);
        $template->paidonly = 0;
        $template->status = 0;
        $template->data = json_encode([]);

        $template->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.qr.template.edit', $template->id))->with('success', e('Template has been created successfully'));
    }

    /**
     * Edit Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        
        if(!user()->hasRolePermission('qr.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit QR templates.'));
        }

        if(!$template = DB::qrtemplates()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Template does not exist.'));

        View::set('title', e('Edit QR Template'));

        \Helpers\CDN::load('spectrum');

        $template->data = json_decode($template->data);

        View::push('<script type="text/javascript">
						$("#bg").spectrum({
					        color: "'.(isset($template->data->color->bg) ? $template->data->color->bg : 'rbg(255,255,255)').'",
					        preferredFormat: "rgb",
                            allowEmpty:true,
                            showInput: true,
                            move: function (color) { $("#bg").val(color.toRGBString()) },
                            hide: function (color) { $("#bg").val(color.toRGBString()) }
						});
                        $("#fg").spectrum({
					        color: "'.(isset($template->data->color->fg) ? $template->data->color->fg : 'rgb(0,0,0)').'",
					        preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#fg").val(color.toRGBString()) },
                            hide: function (color) { $("#fg").val(color.toRGBString()) }
						});
                        $("#framecolor").spectrum({
                            color: "'.(isset($template->data->frame->color) ? $template->data->frame->color : 'rbg(0,0,0)').'",
                            preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#framecolor").val(color.toRGBString()) },
                            hide: function (color) { $("#framecolor").val(color.toRGBString()) }
                        });
                        $("#frametextcolor").spectrum({
                            color: "'.(isset($template->data->frame->textcolor) ? $template->data->frame->textcolor : 'rgb(255,255,255)').'",
                            preferredFormat: "rgb",
                            showInput: true,
                            move: function (color) { $("#frametextcolor").val(color.toRGBString()) },
                            hide: function (color) { $("#frametextcolor").val(color.toRGBString()) }
                        });
                        $("input, select, textarea").on("change", function(){
                            updatePreview();
                        });
                        
                        function updatePreview(){
                            let data = new FormData($(\'[data-trigger=saveqr]\')[0]);
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
                        updatePreview();
                    </script>', 'custom')->toFooter();

        if(\Helpers\QR::hasImagick()){
            View::push('<script type="text/javascript">
                            $("#gbg").spectrum({
                                color: "'.(isset($template->data->gradient) ? $template->data->gradient[1] : 'rgb(255,255,255)').'",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#gbg").val(color.toRGBString()) },
                                hide: function (color) { $("#gbg").val(color.toRGBString()) }
                            });
                            $("#gfg").spectrum({
                                color: "'.(isset($template->data->gradient) ? $template->data->gradient[0][0] : 'rgb(0,0,0)').'",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfg").val(color.toRGBString()) },
                                hide: function (color) { $("#gfg").val(color.toRGBString()) }
                            });
                            $("#gfgs").spectrum({
                                color: "'.(isset($template->data->gradient) ? $template->data->gradient[0][1] : 'rgb(0,0,0)').'",
                                preferredFormat: "rgb",
                                showInput: true,
                                move: function (color) { $("#gfgs").val(color.toRGBString()) },
                                hide: function (color) { $("#gfgs").val(color.toRGBString()) }
                            });
                            $("#eyecolor").spectrum({
                                color: "'.(isset($template->data->eyecolor) ? $template->data->eyecolor : '').'",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#eyecolor").val(color.toRGBString()) },
                                hide: function (color) { $("#eyecolor").val(color.toRGBString()) }
                            });
                            $("#eyeframecolor").spectrum({
                                color: "'.(isset($template->data->eyeframecolor) ? $template->data->eyeframecolor : '').'",
                                preferredFormat: "rgb",
                                allowEmpty:true,
                                showInput: true,
                                move: function (color) { $("#eyeframecolor").val(color.toRGBString()) },
                                hide: function (color) { $("#eyeframecolor").val(color.toRGBString()) }
                            });
                        </script>', 'custom')->toFooter();
        }

        $plans = DB::plans()->find();

        View::push('<style>.main{overflow:initial !important;}#qr-preview{position: sticky; top: 5px}</style>', 'custom')->toHeader();    

        return View::with('admin.qrtemplates.edit', ['qrtemplate' => $template, 'plans' => $plans])->extend('admin.layouts.main');
    }

    /**
     * Update Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){        

        if(!user()->hasRolePermission('qr.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit QR templates.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!$template = DB::qrtemplates()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Template does not exist.'));
        
        if(!$request->name) return Helper::redirect()->back()->with('danger', e('The template name is required.'));
            
        $template->name = Helper::clean($request->name, 3, true);
        $template->description = Helper::clean($request->text, 3, true) ?? $template->name;
        $template->paidonly = $request->paidonly ?? 0;
        $template->status = $request->status ?? 0;
        $template->filename = md5(time().Helper::rand()).'.svg';
        
        $qrdata = [];

        $qrdata['type'] = 'text';

        $qrdata['data'] = clean($template->description);

        $qrdata['mode'] = clean($request->mode);

        $margin = is_numeric($request->margin) && $request->margin <= 10 ? $request->margin : 0;

        $data = \Helpers\QR::factory($request, 1000, $margin)->format('svg');

        if($request->mode == 'gradient'){
            $qrdata['gradient'] = [
                [clean($request->gradient['start']), clean($request->gradient['stop'])],
                clean($request->gradient['bg']),
                clean($request->gradient['direction'])
            ];
            $data->gradient(
                [$request->gradient['start'], $request->gradient['stop']],
                $request->gradient['bg'],
                $request->gradient['direction'],
                $request->eyeframecolor ?? null,
                $request->eyecolor ?? null
            );
        } else {
            $qrdata['color'] = ['bg' => clean($request->bg), 'fg' => clean($request->fg)];
            $data->color($request->fg, $request->bg, $request->eyeframecolor ?? null, $request->eyecolor ?? null);
        }


        if($request->frame){
            $qrdata['frame'] = $request->frame;
            $options = $request->frame;
            $options['bg'] = $request->mode == 'gradient' ? $request->gradient['bg'] : $request->bg;
            $data->withFrame($options);
        }


        if($request->punched){
            $qrdata['punchedlogo'] = true;
            $data->isPunched();
        }else{
            $qrdata['punchedlogo'] = false;
        }

        $size = is_numeric($request->logosize) && $request->logosize > 50 && $request->logosize <= 500 ? $request->logosize : 150;

        if($request->selectlogo && $request->selectlogo != 'none'){
            $qrdata['definedlogo'] = $request->selectlogo;
            $data->withLogo(PUB.'/static/images/'.$request->selectlogo.'.png', $size);
        }

        if(is_numeric($request->logosize) && $request->logosize > 50 && $request->logosize <= 500 ){
            $qrdata['logosize'] = $request->logosize;
        }

        if($image = $request->file('logo')){

            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('Logo must be either a PNG or a JPEG (Max 500kb).'));

            $filename = "qr_logo".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            move_uploaded_file($image->location, appConfig('app.storage')['qr']['path'].'/'.$filename);

            $qrdata['custom'] = $filename;

            $data->withLogo($image->location, $size);
        }

        if($request->selectlogo && $request->selectlogo != 'none' && !file_exists(PUB.'/static/images/'.$request->selectlogo)){
            $qrdata['custom'] = $request->selectlogo;
            $data->withLogo(appConfig('app.storage')['qr']['path'].'/'.$request->selectlogo, $size);
        }

        if($request->matrix){
            $qrdata['matrix'] = clean($request->matrix);
            $data->module($request->matrix);
        }

        if($request->eye){
            $qrdata['eye'] = clean($request->eye);
            $qrdata['eyeframe'] = clean($request->eyeframe);
            $qrdata['eyecolor'] = $request->eyecolor ?? null;
            $qrdata['eyeframecolor'] = $request->eyeframecolor ?? null;
            $data->eye($request->eye, $request->eyeframe ?? 'square');
        }

        if(is_numeric($request->margin) && $request->margin >= 0 && $request->margin <= 10){
            $qrdata['margin'] = $request->margin;
        }

        if($request->error){
            $qrdata['error'] = clean($request->error);
            $data->errorCorrection($request->error);
        }   
        
        $qr = $data->create('uri');

        if($template->filename){
            \Helpers\App::delete(appConfig('app.storage')['qr']['path'].'/'.$template->filename);
        }

        $data->create('file', appConfig('app.storage')['qr']['path'].'/'.$template->filename);

        $template->data = json_encode($qrdata);

        $template->save();

        return Helper::redirect()->back()->with('success', e('Template has been updated successfully.'));
    }

    /**
     * Delete Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        
        if(!user()->hasRolePermission('qr.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete QR templates.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'template.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$template = DB::qrtemplates()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Template does not exist.'));

        $data = json_decode($template->data, true);

        if(isset($data['logo']['image'])) App::delete(appConfig('app.storage')['qr']['path'].'/'.$data['logo']['image']);

        $template->delete();

        return Helper::redirect()->back()->with('success', e('Template has been deleted.'));
    }    
} 