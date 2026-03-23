<?php
/**
 * Heading Widget
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

class Heading {
    /**
     * Heading Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'heading';

        return "function fnheading(el, content = null, did = null){
            var text = '', format, color='#000000';

            if(content){
                var text = content['text'] ?? '';
                var format = content['format'] ?? 'h1';
                var color = content['color'] ?? '#000000';
            }

            var blockpreview = text;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            if(did == 'bio-tag') did = 'tagline';

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Style').'</label>
                                  <select name="data[\'+slug(did)+\'][format]" class="form-select mb-2 p-2">
                                      <option value="h1" \'+(format == \'h1\' ? \'selected\':\'\')+\'>H1</option>
                                      <option value="h2" \'+(format == \'h2\' ? \'selected\':\'\')+\'>H2</option>
                                      <option value="h3" \'+(format == \'h3\' ? \'selected\':\'\')+\'>H3</option>
                                      <option value="h4" \'+(format == \'h4\' ? \'selected\':\'\')+\'>H4</option>
                                      <option value="h5" \'+(format == \'h5\' ? \'selected\':\'\')+\'>H5</option>
                                      <option value="h6" \'+(format == \'h6\' ? \'selected\':\'\')+\'>H6</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Text').'</label>
                                  <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][text]" placeholder="e.g. Bio Page" value="\'+text+\'">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group mt-3">
                                  <label class="form-label fw-bold d-block mb-2">'.\Helpers\BioWidgets::e('Color').'</label>
                                  <input type="color" name="data[\'+slug(did)+\'][color]" value="\'+color+\'" class="form-control p-2">
                              </div>
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
     * Save Heading
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
        $data['format'] = in_array($data['format'], ['h1','h2','h3','h4','h5','h6']) ? $data['format'] : 'h1';
        $data['text'] = clean($data['text']);

        $color = str_replace('#', '', $data['color']);
        $data['color'] = ctype_xdigit($color) && strlen($color) == 6 ? "#{$color}" : "#000000";

        return $data;
    }
    /**
     * Heading Block
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @param mixed $id
     * @param array $value
     * @return string
     */
    public static function block($id, $value){

        if(in_array($value['format'], ['h1','h2','h3','h4','h5','h6'])){
            return '<'.$value['format'].' style="color:'.($value['color'] ?? 'inherit').' !important">'.$value['text'].'</'.$value['format'].'>';
        }else{
            return '<h1>'.$value['text'].'</h1>';
        }
    }
}
