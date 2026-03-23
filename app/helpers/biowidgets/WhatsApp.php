<?php
/**
 * WhatsApp Widget
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

class WhatsApp {
    /**
     * Whatsapp Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'whatsapp';

        return "function fnwhatsapp(el, content = null, did = null){

            var label = content && content['label'] ? content['label'] : '';
            var phone = content && content['phone'] ? content['phone'] : '';
            var message = content && content['message'] ? content['message'] : '';

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
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Message').'</label>
                        <textarea class="form-control p-2" name="data[\'+slug(did)+\'][message]" placeholder="">\'+message+\'</textarea>
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
     * Save Whatsapp
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

        if(strlen(clean($data['message'])) > 1000) throw new \Exception(e('{b} Error: Text is too long.', null, ['b' => e('Whatsapp Message')]));

        $data['phone'] = clean($data['phone']);

        $data['label'] = \Core\Helper::clean($data['label'], 3);

        $data['message'] = \Core\Helper::clean($data['message'], 3);

        return $data;
    }
    /**
     * Whatsapp Message
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        return '<a href="https://wa.me/'.(str_replace([' ', '-'], '', $value['phone'])).'?text='.urlencode(clean($value['message'], 3)).'" class="btn btn-block d-block p-3 btn-custom position-relative"><img src="'.assets('images/whatsapp.svg').'" height="26" class="position-absolute start-0 left-0 top-50 translate-middle-y ms-1 ml-1"> '.(isset($value['label']) && $value['label'] ? $value['label'] : $value['phone']).'</a>';
    }
}
