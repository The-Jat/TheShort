<?php
/**
 * Text Widget
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

class Text {
    /**
     * Text Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'text';

        return "function fntext(el, content = null, did = null){

            var text = content && content['text'] ? content['text'] : '';
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                          <div class="form-group">
                              <textarea id="\'+did+\'_editor" class="form-control p-2" name="data[\'+did+\'][text]" placeholder="e.g. some description here">\'+text+\'</textarea>
                          </div>
                      </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
            $('#'+did+'_editor').summernote({
                toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['link','ul', 'ol', 'paragraph']],
                ],
                height: 150
            });
        }";
    }
    /**
     * Save Text
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

        if(strlen(clean($data['text'])) > 2000) throw new \Exception(e('{b} Error: Text is too long.', null, ['b' => e('Text')]));

        $data['text'] =  \Core\Helper::clean($data['text'], 3, false, '<strong><i><a><b><u><img><iframe><ul><ol><li><p><span>');

        return $data;
    }
    /**
     * Text Block
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){
        return $value['text'];
    }
}
