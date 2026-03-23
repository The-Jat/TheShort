<?php
/**
 * PayPal Widget
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

class PayPal {
    /**
     * PayPal Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'paypal';
        $list = '';

        foreach (\Helpers\App::currency() as $code => $info){
            $list .= '<option value="'.$code.'"  \'+(currency == \''.$code.'\' ? \'selected\':\'\')+\'>'.$code.' - '.$info["label"].'</option>';
        }

        return "function fnpaypal(el, content = null, did = null){

            if(content){
                var label = content['label'] ?? '';
                var email = content['email'] ?? '';
                var amount = content['amount'] ?? '';
                var currency = content['currency'] ?? '';
            } else {
                var label = '';
                var email = '';
                var amount = '';
                var currency = '';
            }
            var blockpreview = email;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Label').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Purchase Course" value="\'+label+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Email').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][email]" placeholder="e.g. mybusiness@email.com" value="\'+email+\'">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Amount').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][amount]" placeholder="e.g. 9.99" value="\'+amount+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold d-block mb-2">'.\Helpers\BioWidgets::e('Currency').'</label>
                            <div class="input-group input-select rounded">
                                <select name="data[\'+slug(did)+\'][currency]" class="form-select mb-2 p-2" data-toggle="select">
                                    '.$list.'
                                </select>
                            </div>
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
     * Save Paypal
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['label'] = \Core\Helper::clean($data['label'], 3);

        $data['email'] = \Core\Helper::clean($data['email'], 3);

        $data['amount'] = (double) \Core\Helper::clean($data['amount'], 3);

        if($data['email'] && !\Core\Helper::Email($data['email'])) throw new \Exception(e('Please enter a valid email'));

        $data['currency'] = strtoupper($data['currency']);

        return $data;
    }
    /**
     * Paypal Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        return '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">

            <input type="hidden" name="business" value="'.$value['email'].'">

            <input type="hidden" name="cmd" value="_xclick">

            <input type="hidden" name="item_name" value="'.$value['label'].'">
            <input type="hidden" name="amount" value="'.$value['amount'].'">
            <input type="hidden" name="currency_code" value="'.$value['currency'].'">

            <button type="submit" name="submit" class="btn btn-block d-block p-3 btn-custom w-100">'.$value['label'].'</button>
        </form>';
    }
}
