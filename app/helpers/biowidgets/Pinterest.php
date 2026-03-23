<?php
/**
 * Pinterest Widget
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

class Pinterest {
    /**
     * Pinterest Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'pinterest';

        return "function fnpinterest(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?pinterest.com)\/(.*)/i;

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
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. My Board" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://pinterest.com/..." value="\'+link+\'">
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Pinterest link')."'
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
     * Save Pinterest
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['link'] = trim(clean($data['link']), '/');
        $data['name'] = \Core\Helper::clean($data['name'], 3);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?pinterest.(com|ca|co.uk))\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Pinterest link'));
        }

        return $data;
    }
    /**
     * Pintereset Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function block($id, $value){

        return '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-toggle="modal" data-target="#modal-'.$id.'" data-bs-toggle="modal" data-bs-target="#modal-'.$id.'">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Pinterest Board').'</a>
        <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="sensitiveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
                        <a data-pin-do="embedUser" data-pin-board-width="400" data-pin-scale-height="320" data-pin-scale-width="80" href="'.$value['link'].'"></a>
                    </div>
                </div>
            </div>
        </div>';
    }
}
