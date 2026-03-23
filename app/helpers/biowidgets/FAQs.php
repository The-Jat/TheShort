<?php
/**
 * FAQs Widget
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

class FAQs {
    /**
     * FAQS Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'faqs';

        return "function fnfaqs(el, content = null, did = null){

            if(content){
                var question = content['question'] ?? [];
                var answer = content['answer'] ?? [];
            } else {
                var question = [];
                var answer = [];
            }
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="faq-container">\';
                        question.forEach(function(value, i){
                            html += \'<div class="faq-holder row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Question').'</label>
                                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][question][]" value="\'+value+\'">
                                                <button type="button" data-trigger="deletefaq" class="btn btn-sm btn-danger mt-1 rounded-3">'.\Helpers\BioWidgets::e('Delete').'</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Answer').'</label>
                                            <textarea class="form-control p-2" name="data[\'+slug(did)+\'][answer][]">\'+answer[i]+\'</textarea>
                                        </div>
                                    </div>
                                </div>\';
                        });
                html += \'</div>
                    <button type="button" data-trigger="addfaq" class="btn btn-dark mt-3 rounded-3">'.\Helpers\BioWidgets::e('Add FAQ').'</button>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            $('[data-trigger=addfaq]').click(function(e){
                e.preventDefault();
                $('#container-'+did+' button[data-trigger=addfaq]').before('".\Helpers\BioWidgets::format('<div class="faq-holder row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Question').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][question][]" value="">
                            <button type="button" data-trigger="deletefaq" class="btn btn-sm btn-danger mt-1 rounded-3">'.\Helpers\BioWidgets::e('Delete').'</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Answer').'</label>
                            <textarea class="form-control p-2" name="data[\'+slug(did)+\'][answer][]"></textarea>
                        </div>
                    </div>
                </div>')."');
              });
              $(document).on('click','[data-trigger=deletefaq]', function(e){
                    e.preventDefault();
                    $(this).parents('.faq-holder').fadeOut('fast', function(){
                        $(this).remove();
                    })
              });
        }";
    }
    /**
     * Save Faq
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['question'] = isset($data['question']) && $data['question'] ? array_map('clean', $data['question']) : [];
        $data['answer'] = isset($data['answer']) && $data['answer'] ? array_map(function($value){
            return nl2br(clean($value));
        }, $data['answer']) : [];

        return $data;
    }
    /**
     * FAQS Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        if(!isset($value['question'])) return;

        $html = '<div class="btn-custom card d-block border-0 mb-2">';
        foreach($value['question'] as $i => $question){
            $html .='<div class="card-body text-start text-left">
                <a href="#faq-'.$i.'" class="collapsed fa-animated" data-bs-toggle="collapse" data-toggle="collapse" data-target="#faq-'.$i.'" data-bs-target="#faq-'.$i.'">
                    <h6 class="card-title fw-bold mb-0">
                        <i class="fa fa-chevron-down me-2"></i>
                        <span class="align-middle">'.$question.'</span>
                    </h6>
                </a>
                <div class="collapse pt-3" id="faq-'.$i.'">
                    '.$value['answer'][$i].'
                </div>
            </div>';
        }
        $html .='</div>';

        return $html;
    }
}
