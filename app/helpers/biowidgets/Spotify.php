<?php
/**
 * Spotify Widget
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

class Spotify {
    /**
     * Spotify Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'spotify';

        return "function fnspotify(el, content = null, did = null){
            let regex = /^https:\/\/open.spotify.com\/(track|playlist|episode|album)\/([a-zA-Z0-9]+)(.*)$/i;

            var link = content && content['link'] ? content['link'] : '';

            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://open.spotify.com/..." value="\'+link+\'">
                    <p class="form-text">'.\Helpers\BioWidgets::e('You can add a link to a spotify song, a playlist or a podcast.').'</p>
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Spotify track, playlist or podcast link')."'
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
     * Spotify Save
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

        if($data['link'] && !preg_match("/^https:\/\/open.spotify.com\/(track|playlist|episode|album)\/([a-zA-Z0-9]+)(.*)$/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Spotify track, playlist or podcast link'));
        }

        return $data;
    }
    /**
     * Spotify Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        if(empty($value['link'])) return;

        preg_match("/^https:\/\/open.spotify.com\/(track|playlist|episode|album)\/([a-zA-Z0-9]+)(.*)$/i", $value['link'], $match);

        if(isset($match[1])){
            if($match[1] == 'playlist'){
                $link = str_replace('/playlist/', '/embed/playlist/', $value['link']);
            }elseif($match[1] == 'episode'){
                $link = str_replace('/episode/', '/embed/episode/', $value['link']);
            }elseif($match[1] == 'album'){
                $link = str_replace('/album/', '/embed/album/', $value['link']);
            }else{
                $link = str_replace('/track/', '/embed/track/', $value['link']);
            }
        }
        return '<iframe width="100%" height="152" style="aspect-ratio: 16/9;" src="'.$link.'" class="rounded rounded-4 btn-custom"></iframe>';
    }
}
