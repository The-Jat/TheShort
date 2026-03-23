<?php
/**
 * TikTok Widget
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

class TikTok {
    /**
     * Tiktok Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'tiktok';

        return "function fntiktok(el, content = null, did = null){
            let regex = /^https?:\/\/(?:www|m)\.(?:tiktok.com)\/(.*)\/video\/(.*)/i;

            var link = content && content['link'] ? content['link'] : '';
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://tiktok.com/..." value="\'+link+\'">
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid TikTok video link')."'
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
     * TikTok Save
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

        if($data['link'] && !preg_match("/^https?:\/\/(?:www|m)\.(?:tiktok.com)\/(.*)\/video\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid TikTok video link'));
        }

        return $data;
    }
    /**
     * Tiktok Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        $tid = explode('/', $value['link']);
        $tid = end($tid);
        return '<blockquote class="tiktok-embed btn-custom" cite="'.$value['link'].'" data-video-id="'.$tid.'" style="max-width: 660px;min-width: 325px;"><section></section></blockquote> <script async src="https://www.tiktok.com/embed.js"></script>';
    }
}
