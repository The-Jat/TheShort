<?php
/**
 * Phone Widget
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

class Phone {
    /**
     * Phone Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'phone';

        return "function fnphone(el, content = null, did = null){

            var label = '', phone = '';

            if(content){
                var label = content['label'] ?? '';
                var phone = content['phone'] ?? '';
            }

            var blockpreview = phone;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Phone').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][phone]" placeholder="e.g. +123456789" value="\'+phone+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Call us" value="\'+label+\'">
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
     * Save Phone Call
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;

        $data['phone'] = clean($data['phone']);

        $data['label'] = \Core\Helper::clean($data['label'], 3);

        return $data;
    }
    /**
     * Phone Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        return '<a href="tel:'.(str_replace([' ', '-'], '', $value['phone'])).'" class="btn btn-block d-block p-3 btn-custom position-relative"><i class="fa fa-phone ms-2 position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3"></i> '.(isset($value['label']) && $value['label'] ? $value['label'] : $value['phone']).'</a>';
    }
}
