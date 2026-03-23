<?php
/**
 * HTML Widget
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

class Html {
    /**
     * HTML Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'html';

        return "function fnhtml(el, content = null, did = null){

            if(content){
                var code = content['html'] ?? '';
            } else {
                var code = '';
            }
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                          <div class="form-group">
                              <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('HTML').'</label>
                              <textarea class="form-control p-2" name="data[\'+slug(did)+\'][html]" placeholder="e.g. some description here">\'+code+\'</textarea>
                          </div>
                      </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Save HTML
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profieldata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profieldata, $data){
        $data['html'] = \Core\Helper::clean($data['html'], 3, false, '<strong><i><a><b><u><img><iframe><ul><ol><li><p><span><br>');
        return $data;
    }
    /**
     * HTML Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        return $value['html'];
    }
}
