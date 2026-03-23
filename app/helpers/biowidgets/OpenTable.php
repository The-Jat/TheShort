<?php
/**
 * OpenTable Widget
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

class OpenTable {
    /**
     * Open Table Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'opentable';

        $langlist = '';

        foreach(['en-US' => 'English-US','fr-CA' => 'Français-CA','de-DE' => 'Deutsch-DE','es-MX' => 'Español-MX','ja-JP' => '日本語-JP','nl-NL' => 'Nederlands-NL','it-IT' => 'Italiano-IT'] as $key => $value){
            $langlist .= '<option value="'.$key.'"  \'+(lang == \''.$key.'\' ? \'selected\':\'\')+\'>'.$value.'</option>';
        }

        return "function fnopentable(el, content = null, did = null){

            if(content){
                var id = content['rid'] ?? '';
                var lang = content['lang'] ?? 'en-US';
            } else {
                var id = '';
                var lang = 'en-US';
            }
            var blockpreview = id;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Restaurant ID').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][rid]" placeholder="e.g. 12345678" value="\'+id+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Language').'</label>
                            <select name="data[\'+slug(did)+\'][lang]" class="form-select mb-2 p-2">
                                '.$langlist.'
                            </select>
                        </div>
                    </div>
                </div>
            </div>', $type))."';
            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!parseInt($(this).val())){
                    e.preventDefault();
                    $.notify({
                        message: '".\Helpers\BioWidgets::e('Please enter a valid OpenTable restaurant ID')."'
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
     * Save OpenTable
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        if($data['rid'] && !is_numeric($data['rid'])) throw new \Exception(e('{b} Error: Please enter a valid ID', null, ['b' => 'Eventbrite']));

        $data['lang'] = clean($data['lang']);

        return $data;
    }
    /**
     * Opentable Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        if(!isset($value['rid']) || !$value['rid']) return;

        return '<div class="df-opentable btn-custom"><script type="text/javascript" src="//www.opentable.com/widget/reservation/loader?rid='.$value['rid'].'&domain=com&type=standard&theme=standard&lang='.$value['lang'].'&overlay=true&iframe=false&newtab=false"></script></div>';
    }
}
