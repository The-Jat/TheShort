<?php
/**
 * RSS Widget
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

class Rss {
    /**
     * RSS Feed
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'rss';

        return "function fnrss(el, content = null, did = null){

            let regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;

            var link = '';
            if(content){
                var link = content['link'] ?? '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://mysite.com/rss" value="\'+link+\'">
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid RSS Feed link')."'
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
     * Undocumented function
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

        if($data['link'] && !\Core\Helper::isURL($data['link'])) throw new \Exception(e('Please enter a valid RSS Feed link'));

        if($data['link'] && \Helpers\App::rss($data['link']) == 'Invalid RSS') throw new \Exception(e('Please enter a valid RSS Feed link'));

        return $data;
    }
    /**
     * RSS Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        $items = \Helpers\App::rss($value['link']);

        $html ='<div class="rss card card-body overflow-auto btn-custom">';
            if(!is_array($items)){
                $html .= $items;
            }else {
                foreach($items as $item){
                    $html .='<div class="media mb-3 text-start text-left">
                        '.(isset($item['image']) && $item['image'] ? '<img class="me-3" src="'.\Core\Helper::clean($item['image'], 3).'" alt="'.\Core\Helper::clean($item['title'], 3).'">':'').'
                        <div class="media-body">
                            <h6 class="mt-3 fw-bolder"><a href="'.\Core\Helper::clean($item['link'], 3).'" target="_blank">'.\Core\Helper::clean($item['title'], 3).'</a></h6>
                            '.\Core\Helper::clean($item['description'], 3).'
                        </div>
                    </div>';
                }
            }
        $html.='</div>';
        return $html;
    }
}
