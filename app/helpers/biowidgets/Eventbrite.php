<?php
/**
 * Eventbrite Widget
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

class Eventbrite {
    /**
     * EventBrite
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'eventbrite';

        return "function fneventbrite(el, content = null, did = null){

            if(content){
                var id = content['eid'] ?? '';
                var label = content['label'] ?? '';
            } else {
                var id = '';
                var label = '';
            }
            var blockpreview = id;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Event ID').'</label>
                            <input type="text" class="form-control p-2" id="event-\'+did+\'" name="data[\'+slug(did)+\'][eid]" placeholder="e.g. 12345678" value="\'+id+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Label').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Book now" value="\'+label+\'">
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            $('#container-'+did+' #event-'+did+'').change(function(e){
                if(!parseInt($(this).val())){
                    e.preventDefault();
                    $.notify({
                        message: '".\Helpers\BioWidgets::e('Please enter a valid EventBrite ID')."'
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
     * Save Eventbrite
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        if($data['eid'] && !is_numeric($data['eid'])) throw new \Exception(e('{b} Error: Please enter a valid ID', null, ['b' => 'Evenbrite']));

        $data['label'] = clean($data['label']);

        return $data;
    }
    /**
     * EventBrite Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        return '<a class="btn btn-custom btn-block d-block w-100 p-3" id="evenbrite-'.$id.'">'.(isset($value['label']) && !empty($value['label']) ? $value['label'] : e('Book now')).'</a>
        <script src="https://www.eventbrite.com/static/widgets/eb_widgets.js"></script>

        <script type="text/javascript">
            window.EBWidgets.createWidget({
                widgetType: \'checkout\',
                eventId: \''.$value['eid'].'\',
                modal: true,
                modalTriggerElementId: \'evenbrite-'.$id.'\'
            });
        </script>';
    }
}
