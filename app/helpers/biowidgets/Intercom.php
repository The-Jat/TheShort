<?php
/**
 * Intercom Widget
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

class Intercom {
    /**
     * Intercom Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.6.3
     * @return void
     */
    public static function setup(){

        $type = 'intercom';

        return "function fnintercom(el, content = null, did = null){

            if($('[data-id=intercom]').length > 0) {
                $.notify({
                    message: '".\Helpers\BioWidgets::e('You can only have this widget once.')."'
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

                        
            if($('[data-id=tawkto]').length > 0 || $('[data-id=tidio]').length > 0) {
                $.notify({
                    message: '".\Helpers\BioWidgets::e('You already have a chat widget')."'
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

            if(content){
                var text = content['app_id'] ?? '';
            } else {
                var text = '';
            }

            var blockpreview = '';

            var did = 'intercom';

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('App ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][app_id]" placeholder="e.g. a6gaewt" value="\'+text+\'">
                        <p class="form-text">'.\Helpers\BioWidgets::e('The App ID can be found in Settings > General > Workspace name & time zone').'
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Save Intercom Settings
     *
     * @author GemPixel
     * @version 7.6.3
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function save($request, $profiledata, $data){
        $data['app_id'] = clean($data['app_id']);
        
        if(empty($data['app_id'])) {
            throw new \Exception(e('Please enter a valid Intercom App ID'));
        }    
        
        return $data;
    }

    /**
     * Display Intercom Block
     *
     * @author GemPixel
     * @version 7.6.3
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function block($id, $value){
        if(!isset($value['app_id']) || empty($value['app_id'])) return '';
        
        $html = '<script>
            window.intercomSettings = {
                api_base: "https://api-iam.intercom.io",
                app_id: "'.clean($value['app_id']).'"
            };
        </script>
        <script>
            (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic("reattach_activator");ic("update",w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement("script");s.type="text/javascript";s.async=true;s.src="https://widget.intercom.io/widget/'.clean($value['app_id']).'";var x=d.getElementsByTagName("script")[0];x.parentNode.insertBefore(s,x);};if(document.readyState==="complete"){l();}else if(w.attachEvent){w.attachEvent("onload",l);}else{w.addEventListener("load",l,false);}}})();
        </script>';
        
        return $html;
    }
}
