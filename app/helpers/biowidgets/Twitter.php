<?php
/**
 * Twitter Widget
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

class Twitter {
    /**
     * Twitter Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'twitter';

        return "function fntwitter(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(twitter.com|x.com)\/(.*)/i;

            var link = content && content['link'] ? content['link'] : '';
            var amount = content && content['amount'] ? content['amount'] : 2;
            var blockpreview = link;

            if(!parseInt(amount)) amount = 1;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://twitter.com/..." value="\'+link+\'">
                        </div>
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Tweet link')."'
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
     * Save Twitter
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

        $data['amount'] = (int) ($data['amount'] ?? 2);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(twitter.com|x.com)\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Tweet link'));
        }

        return $data;
    }
    /**
     * Twitter Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        if(!isset($value['amount']) || !$value['amount'] || !is_numeric($value['amount']) || $value['amount'] < 1) $value['amount'] = 1;

        if(!$value['link'] || empty($value['link'])) return '';

        if(preg_match("/^https?:\/\/(www.)?(x.com)\/(.*)/i", $value['link'])) {
            $value['link'] = str_replace('x.com', 'twitter.com', $value['link']);
        }

        return '<a class="twitter-timeline" data-width="100%" data-tweet-limit="'.$value['amount'].'" href="'.$value['link'].'" data-chrome="nofooter">Tweets</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
    }
}
