<?php
/**
 * Tagline Widget
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

class Tagline {
    /**
     * Tagline Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return string
     */
    public static function setup(){

        $type = 'tagline';

        return "function fntagline(el, content = null, did = null){

            if($('[data-id=bio-tag]').length > 0) {
                $.notify({
                    message: '".\Helpers\BioWidgets::e('You already have a tagline widget.')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

            var text = content && content['text'] ? content['text'] : '';

            var blockpreview = text;

            if(!did) did = 'tagline';

            if(did == 'bio-tag') did = 'tagline';

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="form-group">
                        <input type="text" class="form-control p-2" name="data['.$type.'][text]" placeholder="e.g. My Bio Page" value="\'+text+\'">
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Save Tagline
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $value
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;
        $data['text'] = clean($data['text']);

        return $data;
    }
    /**
     * Tagline Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        if(!$value) return;

        if(isset($value['text']) && !empty($value['text'])){
            return '<p>'.clean($value['text']).'</p>';
        }
    }
}
