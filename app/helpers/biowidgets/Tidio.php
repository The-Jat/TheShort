<?php
/**
 * Tidio Widget
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

class Tidio {
    /**
     * Tidio Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.6.3
     * @return void
     */
    public static function setup(){
        $type = 'tidio';

        return "function fntidio(el, content = null, did = null){
            
            if($('[data-id=tidio]').length > 0) {
                $.notify({
                    message: '".\Helpers\BioWidgets::e('You can only have this widget once')."'
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

            if($('[data-id=intercom]').length > 0 || $('[data-id=tawkto]').length > 0 ) {
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

            var projectId = content && content['project_id'] ? content['project_id'] : '';

            var did = 'tidio';
            var blockpreview = '';

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Project ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][project_id]" placeholder="e.g. a6c9duekcirqkykm1os6mznmj49opvadd" value="\'+projectId+\'">
                        <p class="form-text">'.\Helpers\BioWidgets::e('Enter your Tidio project ID. You caan get your Project ID from Tidio > Settings > Developer > Project data').'</p>
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }

    /**
     * Save tidio Settings
     *
     * @author GemPixel
     * @version 7.6.3
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function save($request, $profiledata, $data){
        $data['project_id'] = clean($data['project_id']);
        
        if(empty($data['project_id'])) {
            throw new \Exception(e('Please enter a valid project ID'));
        }
        
        return $data;
    }

    /**
     * Display tidio Block
     *
     * @author GemPixel
     * @version 7.6.3
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function block($id, $value){
        if(!isset($value['project_id']) || empty($value['project_id'])) return '';
        
        $html = '<!--Start of Tidio Script-->
        <script src="//code.tidio.co/'.$value['project_id'].'.js" async></script>
        <!--End of Tidio Script-->';
        
        return $html;
    }
}
