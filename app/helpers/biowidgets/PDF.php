<?php
/**
 * PDF Widget
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

class PDF {
    /**
     * PDF Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Content
     * @version 7.6.1
     * @return void
     */
    public static function setup(){
        $type = 'pdf';
        
        return "function fnpdf(el, content = null, did = null){
            if(content){
                var title = content['title'] || '';
                var description = content['description'] || '';
            } else {
                var title = '';
                var description = '';
            }
            var blockpreview = title;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Document Title').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][title]" value="\'+title+\'">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Description').' ('.\Helpers\BioWidgets::e('optional').')</label>
                                <textarea class="form-control p-2" name="data[\'+slug(did)+\'][description]" rows="3">\'+description+\'</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold d-block">'.\Helpers\BioWidgets::e('PDF File').' \'+(content && content[\'pdf\'] ? \'<span class="float-end"><input type="checkbox" name="data[\'+slug(did)+\'][removepdf]" value="1" class="me-1" id="remove-\'+slug(did)+\'"><span class="align-text-bottom">'.\Helpers\BioWidgets::e('Remove').'</span></span></label>\':\'\')+\'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="application/pdf">
                                <p class="form-text">'.\Helpers\BioWidgets::e('Acceptable file: PDF - Max size 10MB').'</p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">                                  
                                <label class="form-label fw-bold d-block">'.\Helpers\BioWidgets::e('Thumbnail').' \'+(content && content[\'thumbnail\'] ? \'<span class="float-end"><input type="checkbox" name="data[\'+slug(did)+\'][removethumb]" value="1" class="me-1" id="removethumb-\'+slug(did)+\'"><span class="align-text-bottom">'.\Helpers\BioWidgets::e('Remove').'</span></span></label>\':\'\')+\'</label>
                                <img id="thumbnail-preview-\'+slug(did)+\'" src="\'+(content && content[\'thumbnail\'] ? \''.url('content/profiles/').'\'+content[\'thumbnail\'] : \'\')+\'" class="img-thumbnail" style="max-width: 200px; max-height: 150px; display: \'+(content && content[\'thumbnail\'] ? \'block\' : \'none\')+\';" alt="Thumbnail Preview">     
                                <input type="file" class="form-control p-2 mt-2" name="\'+slug(did)+\'-thumb" accept=".jpg,.jpeg,.png" data-auto-crop="true" data-allowed-extensions="jpg,jpeg,png" data-max-size="2048" data-ratio="1:1" data-preview-selector="#thumbnail-preview-\'+slug(did)+\'">
                                <p class="form-text">'.\Helpers\BioWidgets::e('Acceptable files: JPG, JPEG, PNG - Max size 2MB').'</p>
                            </div>
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }

    /**
     * PDF Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.1
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){
        
        $appConfig = appConfig('app');
        $key = $data['id'];

        
        if($pdf = $request->file($key)){
            if($pdf->ext !== 'pdf' || $pdf->sizekb > 10000) {
                throw new \Exception(e('PDF must be in PDF format and maximum 10MB in size.'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_pdf".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $pdf->name);
            $request->move($pdf, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['pdf']) && $profiledata['links'][$key]['pdf']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['pdf']);
            }

            $data['pdf'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['pdf'])) $data['pdf'] = $profiledata['links'][$key]['pdf'];
        }

        
        if($thumb = $request->file($key.'-thumb')){
            if(!$thumb->mimematch || !in_array($thumb->ext, ['jpg', 'jpeg', 'png']) || $thumb->sizekb > 2000) {
                throw new \Exception(e('Thumbnail must be either a PNG or a JPEG (Max 2MB).'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_pdf_thumb".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $thumb->name);
            $request->move($thumb, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['thumbnail']) && $profiledata['links'][$key]['thumbnail']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['thumbnail']);
            }

            $data['thumbnail'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['thumbnail'])) $data['thumbnail'] = $profiledata['links'][$key]['thumbnail'];
        }

        if(isset($data['removepdf']) && $data['removepdf']){
            if(isset($profiledata['links'][$key]['pdf']) && $profiledata['links'][$key]['pdf']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['pdf']);
            }
            $data['pdf'] = '';
        }

        if(isset($data['removethumb']) && $data['removethumb']){
            if(isset($profiledata['links'][$key]['thumbnail']) && $profiledata['links'][$key]['thumbnail']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['thumbnail']);
            }
            $data['thumbnail'] = '';
        }

        return $data;
    }

    /**
     * PDF Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        if(!isset($value['pdf']) || !$value['pdf']) return;

        $thumb = isset($value['thumbnail']) && $value['thumbnail'] ? 
            '<img src="'.uploads($value['thumbnail'], 'profile').'" class="position-absolute start-0 left-0 top-50 translate-middle-y">' : 
            '<div class="position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3">
                <i class="fa fa-file-pdf fa-2x text-danger"></i>
            </div>';
        
        $title = isset($value['title']) && $value['title'] ? 
            '<span class="align-top">'.\Core\Helper::clean($value['title']).'</span>' : '';
        $description = isset($value['description']) && $value['description'] ? 
            '<div class="opacity-75 small">'.\Core\Helper::clean($value['description']).'</div>' : '';

        return '<a href="#" data-toggle="modal" data-target="#modal-'.$id.'" data-bs-toggle="modal" data-bs-target="#modal-'.$id.'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative">
                '.$thumb.'
                '.$title.$description.'
            </a>
        <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h4 class="mb-0">'.$title.'</h4>
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe src="'.uploads($value['pdf'], 'profile').'" width="100%" style="height:calc(100vh - 300px)"></iframe>
                        </div>
                        <div class="modal-body">
                            <a href="'.uploads($value['pdf'], 'profile').'" rel="nofollow" class="btn btn-dark text-white rounded-pill w-100 d-block py-2" download>'.\Helpers\BioWidgets::e('Download').'</a>
                        </div>
                    </div>
                </div>
            </div>';
    }

    /**
     * Delete PDF
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function delete($id, $value){
        if(isset($value['pdf']) && $value['pdf']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['pdf']);
        }
        if(isset($value['thumbnail']) && $value['thumbnail']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['thumbnail']);
        }
    }
}
