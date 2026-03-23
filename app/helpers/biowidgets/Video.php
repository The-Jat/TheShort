<?php
/**
 * Video Widget
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

class Video {
    /**
     * Video Setup
     *
     * @author GemPixel <https://gempixel.com> 
     * @category Content
     * @version 7.6
     * @return void
     */
    public static function setup(){
        $type = 'video';
        
        return "function fnvideo(el, content = null, did = null){

            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="form-group">
                        <label class="form-label fw-bold d-block">'.\Helpers\BioWidgets::e('Video File').'</label>
                        <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="video/mp4">
                        <p class="form-text">'.\Helpers\BioWidgets::e('Acceptable file: MP4 - Max size 10MB').'</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold d-block">'.\Helpers\BioWidgets::e('Poster Image').'</label>
                        <input type="file" class="form-control p-2" name="\'+slug(did)+\'-poster" accept="image/*">
                        <p class="form-text">'.\Helpers\BioWidgets::e('Acceptable files: JPG, JPEG, PNG - Max size 2MB').'</p>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

        }";
    }

    /**
     * Video Save
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
        
        if($video = $request->file($key)){
            
            if($video->ext !== 'mp4' || $video->sizekb > 10000) {
                throw new \Exception(e('Video must be MP4 format and maximum 10MB in size.'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);

                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_video".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $video->name);

            $request->move($video, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['video']) && $profiledata['links'][$key]['video']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['video']);
            }

            $data['video'] = $filename;

        } else {
            if(isset($profiledata['links'][$key]['video'])) $data['video'] = $profiledata['links'][$key]['video'];
        }

        if($poster = $request->file($key.'-poster')){
            if(!$poster->mimematch || !in_array($poster->ext, ['jpg', 'jpeg', 'png']) || $poster->sizekb > 2000) {
                throw new \Exception(e('Poster image must be either a PNG or a JPEG (Max 2MB).'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_poster".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $poster->name);
            $request->move($poster, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['poster']) && $profiledata['links'][$key]['poster']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['poster']);
            }

            $data['poster'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['poster'])) $data['poster'] = $profiledata['links'][$key]['poster'];
        }

        return $data;
    }

    /**
     * Video Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        if(!isset($value['video']) || !$value['video']) return;
        $id = \Core\Helper::rand(5);
        return '<video id="'.$id.'" class="w-100 rounded shadow-sm" controls'.
               (isset($value['poster']) && $value['poster'] ? ' poster="'.uploads($value['poster'], 'profile').'"' : '').'>
            <source src="'.uploads($value['video'], 'profile').'" type="video/mp4">
            '.e('Your browser does not support the video tag.').'
        </video>';
    }
    /**
     * Delete Video
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function delete($id, $value){
        
        if(isset($value['video']) && $value['video']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['video']);
        }
        if(isset($value['poster']) && $value['poster']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['poster']);
        }
    }
}
