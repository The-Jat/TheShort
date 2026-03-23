<?php
/**
 * Divider Widget
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

class Divider {
    /**
     * Divider Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'divider';

        return "function fndivider(el, content = null, did = null){

            if(content){
                var color = content['color'] ?? '#000000';
                var style = content['style'] ?? 'solid';
                var height = content['height'] ?? 2;
            } else {
                var color = '#000000';
                var style = 'solid';
                var height = 2;
            }

            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                              <div class="form-group mb-2">
                                  <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Style').'</label>
                                  <select name="data[\'+slug(did)+\'][style]" class="form-select mb-2 p-2">
                                      <option value="solid" \'+(style == \'solid\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Solid').'</option>
                                      <option value="dotted" \'+(style == \'dotted\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Dotted').'</option>
                                      <option value="dashed" \'+(style == \'dashed\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Dashed').'</option>
                                      <option value="double" \'+(style == \'double\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Double').'</option>
                                  </select>
                              </div>
                              <div class="form-group mb-2">
                                  <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Height').'</label>
                                  <input type="range" min="1" max="10" class="form-range mt-2" name="data[\'+slug(did)+\'][height]" placeholder="e.g. 5" value="\'+height+\'">
                              </div>
                              <div class="form-group mb-2">
                                  <label class="form-label fw-bold d-block mb-2">'.\Helpers\BioWidgets::e('Color').'</label>
                                  <input type="color" name="data[\'+slug(did)+\'][color]" value="\'+color+\'" class="form-control p-2">
                              </div>
                      </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            $('[data-id='+did+'] [type=color]').spectrum({
                color: color,
                showInput: true,
                preferredFormat: 'hex',
                move: function (color) { Color('#'+did, color, $(this)); },
                hide: function (color) { Color('#'+did, color, $(this)); }
            });
        }";
    }
    /**
     * Save Divider
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
        $data['style'] = in_array($data['style'], ['solid', 'dotted', 'dashed', 'double']) ? $data['style'] : 'solid';
        $data['height'] = is_numeric($data['height']) && $data['height'] > 1 && $data['height'] < 10 ? $data['height'] : 3;

        $color = str_replace('#', '', $data['color']);
        $data['color'] = ctype_xdigit($color) && strlen($color) == 6 ? "#{$color}" : "#000000";

        return $data;
    }
    /**
     * Divider Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        if(!isset($value['height']) || !$value['height'] || !is_numeric($value['height']) || $value['height'] < 1 || $value['height'] > 10) $value['height'] = 2;

        if(!isset($value['style']) || !$value['style'] || !in_array($value['style'], ['solid', 'dotted', 'dashed', 'double'])) $value['style'] = 'solid';

        if(!isset($value['color']) || !$value['color'] || !ctype_xdigit(str_replace('#', '', $value['color']))) $value['style'] = '#000000';

        return '<hr style="background:transparent;border-top-style:'.$value['style'].' !important;border-top-width:'.$value['height'].'px !important;border-top-color:'.$value['color'].' !important;">';
    }
}
