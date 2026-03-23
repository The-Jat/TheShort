<?php
/**
 * Tawk.to Widget
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

class TawkTo {
    /**
     * Tawk.to Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.6.3
     * @return void
     */
    public static function setup(){
        $type = 'tawkto';

        return "function fntawkto(el, content = null, did = null){
            
            if($('[data-id=tawkto]').length > 0) {
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

            if($('[data-id=intercom]').length > 0 || $('[data-id=tidio]').length > 0) {
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

            var propertyId = content && content['property_id'] ? content['property_id'] : '';
            var widgetId = content && content['widget_id'] ? content['widget_id'] : '';

            var did = 'tawkto';
            var blockpreview = '';

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Property ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][property_id]" placeholder="e.g. 6123456789abcdef1234567" value="\'+propertyId+\'">
                        <p class="form-text">'.\Helpers\BioWidgets::e('Enter your Tawk.to Property ID').'</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Widget ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][widget_id]" placeholder="e.g. 1ab2c3d4" value="\'+widgetId+\'">
                        <p class="form-text">'.\Helpers\BioWidgets::e('Enter your Tawk.to Widget ID').'</p>
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }

    /**
     * Save Tawk.to Settings
     *
     * @author GemPixel
     * @version 7.6.3
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function save($request, $profiledata, $data){
        $data['property_id'] = clean($data['property_id']);
        $data['widget_id'] = clean($data['widget_id']);
        
        if(empty($data['property_id'])) {
            throw new \Exception(e('Please enter a valid Property ID'));
        }

        if(empty($data['widget_id'])) {
            throw new \Exception(e('Please enter a valid Widget ID'));
        }
        
        return $data;
    }

    /**
     * Display Tawk.to Block
     *
     * @author GemPixel
     * @version 7.6.3
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function block($id, $value){
        if(!isset($value['property_id']) || empty($value['property_id']) || !isset($value['widget_id']) || empty($value['widget_id'])) return '';
        
        $html = '<!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src="https://embed.tawk.to/'.clean($value['property_id']).'/'.clean($value['widget_id']).'";
            s1.charset="UTF-8";
            s1.setAttribute("crossorigin","*");
            s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->';
        
        return $html;
    }
}
