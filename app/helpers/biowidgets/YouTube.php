<?php
/**
 * YouTube Widget
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

class YouTube {
    /**
     * Youtube Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'youtube';

        return "function fnyoutube(el, content = null, did = null){
            let regex = /http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/(watch|playlist)\?(v|list)=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/i;

            var link = content && content['link'] ? content['link'] : '';
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://youtube.com/watch/..." value="\'+link+\'">
                    <p class="form-text">'.\Helpers\BioWidgets::e('You can add a link to a video or a playlist.').'</p>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Youtube video or playlist link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Youtube Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/(watch|playlist)\?(v|list)=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Youtube video or playlist link'));
        }

        return $data;
    }
    /**
     * Youtube Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        if(empty($value['link'])) return false;

        preg_match("/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/(watch|playlist)\?(v|list)=|\.be\/)([\w\-\_]*)(&(amp;)?[\w\?=]*)?/i", $value['link'], $match);
        
        if(isset($match[1])){
            if($match[1] == 'playlist'){
                $link = 'https://www.youtube.com/embed/videoseries?list='.$match[3];
            }elseif($match[1] == 'watch') {
                $link = 'https://www.youtube.com/embed/'.$match[3];
            }else {
                $link = 'https://www.youtube.com/embed/'.$match[3];
            }
        }
        return '<iframe width="100%" height="315" style="aspect-ratio: 16/9;" src="'.$link.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; fullscreen" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="btn-custom"></iframe>';
    }
}
