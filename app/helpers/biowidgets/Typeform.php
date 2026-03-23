<?php
/**
 * Typeform Widget
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

class Typeform {
    /**
     * Typeform Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'typeform';

        return "function fntypeform(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?((.*).typeform.com)\/to\/(.*)/i;

            var name = content && content['name'] ? content['name'] : '';
            var link = content && content['link'] ? content['link'] : '';
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. Survey" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://XXXXXX.typeform.com/to/XXXXXX" value="\'+link+\'">
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Typeform link')."'
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
     * Save Typeform
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

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?((.*).typeform.com)\/to\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Typeform link'));
        }

        return $data;
    }
    /**
     * Typeform Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        preg_match("/^https?:\/\/(www.)?((.*).typeform.com)\/to\/(.*)/i", $value['link'], $match);
        $typeformid = end($match);

        return '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-toggle="modal" data-bs-toggle="modal" data-target="#modal-'.$id.'" data-bs-target="#modal-'.$id.'">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Typeform').'</a>
            <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div data-tf-widget="'.$typeformid.'"></div>
                            <script src="//embed.typeform.com/next/embed.js"></script>
                        </div>
                        <div class="modal-body">
                            <a href="'.$value['link'].'" class="btn btn-dark text-white rounded-pill w-100 d-block py-2" rel="nofollow" target="_blank">'.\Helpers\BioWidgets::e('Open in a new tab').'</a>
                        </div>
                    </div>
                </div>
            </div>';
    }
}
