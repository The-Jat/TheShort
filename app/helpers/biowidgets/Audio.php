<?php
/**
 * Audio Widget
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

class Audio {
    /**
     * Audio Setup
     *
     * @author GemPixel <https://gempixel.com> 
     * @category Content
     * @version 7.6
     * @return void
     */
    public static function setup(){
        $type = 'audio';
    
        return "function fnaudio(el, content = null, did = null){
            if(content){
                var title = content['title'] || '';
                var artist = content['artist'] || '';
            } else {
                var title = '';
                var artist = '';
            }
            var blockpreview = title;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);
    
            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Title').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][title]" value="\'+title+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Artist').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][artist]" value="\'+artist+\'">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold d-block">'.\Helpers\BioWidgets::e('Audio File').'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="audio/mp3">
                                <p class="form-text">'.\Helpers\BioWidgets::e('Acceptable file: MP3 - Max size 5MB').'</p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold d-block">'.\Helpers\BioWidgets::e('Album Cover').'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'-cover" accept=".jpg,.jpeg,.png">
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
     * Audio Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){
        
        $appConfig = appConfig('app');
        $key = $data['id'];

        // Handle audio file upload
        if($audio = $request->file($key)){
            if($audio->ext !== 'mp3' || $audio->sizekb > 5000) {
                throw new \Exception(e('Audio must be MP3 format and maximum 5MB in size.'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_audio".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $audio->name);
            $request->move($audio, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['audio']) && $profiledata['links'][$key]['audio']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['audio']);
            }

            $data['audio'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['audio'])) $data['audio'] = $profiledata['links'][$key]['audio'];
        }

        // Handle cover image upload
        if($cover = $request->file($key.'-cover')){
            if(!$cover->mimematch || !in_array($cover->ext, ['jpg', 'jpeg', 'png']) || $cover->sizekb > 2000) {
                throw new \Exception(e('Cover image must be either a PNG or a JPEG (Max 2MB).'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_cover".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $cover->name);
            $request->move($cover, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['cover']) && $profiledata['links'][$key]['cover']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['cover']);
            }

            $data['cover'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['cover'])) $data['cover'] = $profiledata['links'][$key]['cover'];
        }

        return $data;
    }

    /**
     * Audio Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        if(!isset($value['audio']) || !$value['audio']) return;

        $cover = isset($value['cover']) && $value['cover'] ? 
            '<div class="col-auto">
                <img src="'.uploads($value['cover'], 'profile').'" class="img-fluid rounded shadow" style="width: 100px; height: 100px; object-fit: cover;">
            </div>' : '';
        
        $title = isset($value['title']) && $value['title'] ? 
            '<div class="fw-bolder fs-6 pt-2">'.\Core\Helper::clean($value['title']).'</div>' : '';
        $artist = isset($value['artist']) && $value['artist'] ? 
            '<div class="text-muted fs-6">'.\Core\Helper::clean($value['artist']).'</div>' : '';

        return '<div class="card p-3 text-start text-left">
            <div class="row align-items-center">
                '.$cover.'
                <div class="col">
                    '.$title.$artist.'
                    <audio class="w-100" controlsList="nodownload" controls>
                        <source src="'.uploads($value['audio'], 'profile').'" type="audio/mp3">
                        '.e('Your browser does not support the audio element.').'
                    </audio>
                </div>
            </div>
        </div>';
    }

    /**
     * Delete Audio
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function delete($id, $value){
        if(isset($value['audio']) && $value['audio']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['audio']);
        }
        if(isset($value['cover']) && $value['cover']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['cover']);
        }
    }
}
