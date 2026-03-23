<?php
/**
 * Google Maps Widget
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

class GoogleMaps {
    /**
     * Google Maps Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'googlemaps';

        return "function fngooglemaps(el, content = null, did = null){

            if(content){
                var address = content['address'] ?? '';
            } else {
                var address = '';
            }
            var blockpreview = address;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Address').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][address]" placeholder="e.g. 1 Apple Park Way" value="\'+address+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Google Maps
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['address'] = clean($data['address']);

        return $data;
    }
    /**
     * Google Maps Blog
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        if(!isset($value['address'])) $value['address'] = '';

        return '<iframe src="https://maps.google.com/maps?q='.urlencode($value['address']).'&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="350" style="border:0;" class="btn-custom" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    }
}
