<?php
/**
 * Calendly Widget
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

class Calendly {
    /**
     * Calendly Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'calendly';

        return "function fncalendly(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?calendly.com)\/(.*)/i;

            if(content){
                var name = content['name'] ?? '';
                var link = content['link'] ?? '';
            } else {
                var name = '';
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. Book an appointment" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://www.calendly.com/..." value="\'+link+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            $('#container-'+did+' input[type=url]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Calendly link')."'
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
     * Save Calendly
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
        $data['name'] = \Core\Helper::clean($data['name'], 3);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?calendly.com)\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Calendly link'));
        }

        return $data;
    }
    /**
     * Calendly Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function processor($id, $value){
        View::push('https://assets.calendly.com/assets/external/widget.css', 'css')->toHeader();
        View::push('https://assets.calendly.com/assets/external/widget.js', 'script')->toHeader();
    }
    /**
     * Calendly Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        return '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" onclick="Calendly.initPopupWidget({url: \''.$value['link'].'\'});return false;">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Calendly').'</a>';
    }
}
