<?php
/**
 * Snapchat Widget
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

class Snapchat {
    /**
     * Snapchat Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'snapchat';

        return "function fnsnapchat(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?snapchat.com)\/(spotlight|add|lens)\/(.*)/i;

            var link = content && content['link'] ? content['link'] : '';
            var blockpreview = link;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://www.snapchat.com/spotlight/..." value="\'+link+\'">
                    <p class="form-text">'.\Helpers\BioWidgets::e('Insert a link to a Snapchat Spotlight, Profile or Lens.').'</p>
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Snapchat post link')."'
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
     * Snapchat Save
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

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?snapchat.com)\/(spotlight|add|lens)\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Snapchat post link'));
        }

        return $data;
    }
    /**
     * Snapchat Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        if(empty($value['link'])) return;

        if(strpos($value['link'], '?') !== 0) $value['link'] = explode('?', $value['link'])[0];

        return '<blockquote class="snapchat-embed" data-snapchat-embed-width="100%" data-snapchat-embed-height="692" data-snapchat-embed-url="'.$value['link'].'/embed" data-snapchat-embed-style="border-radius: 40px;" style="background:#C4C4C4; border:0; border-radius:40px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:416px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px); display: flex; flex-direction: column; position: relative; height:650px;"><div style=" display: flex; flex-direction: row; align-items: center;"><a href="'.$value['link'].'" style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px; margin:16px; cursor: pointer"></a><div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"></div></div><div style="flex: 1;"></div><div style="display: flex; flex-direction: row; align-items: center; border-end-end-radius: 40px; border-end-start-radius: 40px;"><a href="'.$value['link'].'" style="background-color: yellow; width:100%; padding: 10px 20px; border: none; border-radius: inherit; cursor: pointer; text-align: center; display: flex;flex-direction: row;justify-content: center; text-decoration: none; color: black;">View more on Snapchat</a></div></blockquote><script async src="https://www.snapchat.com/embed.js"></script>';
    }
}
