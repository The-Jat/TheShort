<?php
/**
 * Reddit Widget
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

class Reddit {
    /**
     * Reddit Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'reddit';

        return "function fnreddit(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?((.*).)?reddit.com\/user\/(.*)/i;

            if(content){
                var name = content['name'] ?? '';
                var link = content['link'] ?? '';
            } else {
                var name = '';
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. My profile" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://www.reddit.com/user/...." value="\'+link+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            $('#container-'+did+' input[type=url]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".\Helpers\BioWidgets::e('Please enter a valid Reddit link')."'
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
     * Reddit Save
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
        $data['name'] = \Core\Helper::clean($data['name'], 3);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?((.*).)?reddit.com\/user\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid Reddit link'));
        }

        return $data;
    }
    /**
     * Reddit Widget Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        preg_match("/^https?:\/\/(www.)?((.*).)?reddit.com\/user\/(.*)/i", $value['link'], $match);

        $json = \Core\Http::url('https://www.reddit.com/user/'.trim(end($match), '/').'/about.json')
        ->with('user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36')->get();

        $user = $json->bodyObject();

        $html = '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-bs-toggle="modal" data-bs-target="#modal-'.$id.'" data-toggle="modal" data-target="#modal-'.$id.'">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Reddit').'</a>
        <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="sensitiveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">';
                        if(isset($user->data)){
                            $user = $user->data;
                            $html .='<div class="text-center">
                                <img src="'.$user->icon_img.'" class="img-responsive rounded-3 mb-2" width="100">
                                <h4 class="mb-0 text-dark">'.$user->subreddit->title.'</h4>
                                <small class="text-muted">'.str_replace('_', '/', $user->subreddit->display_name).'</small>
                                <div class="border p-3 mt-3 rounded text-start text-left">
                                    <p class="text-dark">'.\Helpers\BioWidgets::e('Karma').' <span class="float-end float-right fw-bold font-weight-bold">'.$user->total_karma.'</span></p>
                                    <p class="text-dark mb-0">'.\Helpers\BioWidgets::e('Member since').' <span class="float-end fw-bold float-right font-weight-bold">'.date('d F, Y', $user->created).'</span></p>
                                </div>
                                <a href="'.$value['link'].'" class="btn btn-dark text-white mt-3 d-block">'.\Helpers\BioWidgets::e('Visit Profile').'</a>
                            </div>';
                        }else {
                            $html .='An error occurred';
                        }
            $html .='</div>
                </div>
            </div>
        </div>';

        return $html;
    }
}
