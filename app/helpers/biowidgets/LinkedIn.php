<?php
/**
 * LinkedIn Widget
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

class LinkedIn {
    /**
     * LinkedIn Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'linkedin';

        return "function fnlinkedin(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?linkedin.com)\/posts\/(.*)/i;

            if(content){
                var link = content['link'] ?? '';
            } else {
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://linkedin.com/posts/..." value="\'+link+\'">
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
                        message: '".\Helpers\BioWidgets::e('Please enter a valid LinkedIn post link')."'
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
     * Save linkedin
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?linkedin.com)\/posts\/(.*)/i", $data['link'])) {
            throw new \Exception(e('Please enter a valid LinkedIn post link'));
        }
        $http = Http::url($data['link'])
                ->with('user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36')
                ->get(['timeout' => 2]);

        $response = '';

        if($http){
            $response = $http->getBody();
        }
        if(!$response || empty($response)){
            throw new \Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }
        
        preg_match('/<script type="application\/ld\+json">\s*(.*?)\s*<\/script>/s', $response, $matches);

        if(empty($matches)) {
            throw new \Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }
        
        if(!$content = json_decode($matches[1], true)){
            throw new \Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }
        
        $content = array_map('clean', $content);
        
        if(!in_array($content['@type'], ['SocialMediaPosting', 'VideoObject', 'DiscussionForumPosting'])){
            throw new \Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }

        if($content['@type'] == 'DiscussionForumPosting'){
            $data = array_merge($data, [
                'author' => $content['author']['name'],
                'avatar' => $content['author']['image']['url'],
                'profile' => $content['author']['url'],
                'date' => $content['datePublished'],
                'title' => '',
                'description' => nl2br($content['articleBody']),
                'media' => null,
                'thumbnail' => $content['image']['url'] ?? ''
            ]);
        }

        if($content['@type'] == 'SocialMediaPosting'){
            $data = array_merge($data, [
                'author' => $content['author']['name'],
                'avatar' => $content['author']['image']['url'],
                'profile' => $content['author']['url'],
                'date' => $content['datePublished'],
                'title' => '',
                'description' => nl2br($content['articleBody']),
                'media' => null,
                'thumbnail' => $content['image']['url'] ?? ''
            ]);
        }
        
        if($content['@type'] == 'VideoObject') {
            $data = array_merge($data, [
                'author' => $content['author']['name'],
                'avatar' => $content['author']['image']['url'],
                'profile' => $content['author']['url'],
                'date' => $content['datePublished'],
                'title' => $content['name'],
                'description' => nl2br($content['description']),
                'media' => $content['contentUrl'] ?? null,
                'thumbnail' => $content['thumbnailUrl'] ?? null
            ]);
        }

        return $data;
    }
    /**
     * linkedin Widget Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        $html = '<div class="card rounded">';
            $html .='<div class="d-flex align-items-center p-2">';
                if($value['avatar']) $html .='<a href="'.$value['profile'].'" target="_blank"><img src="'.$value['avatar'].'" class="img-responsive rounded-circle mb-2" width="50"></a>';
                $html .='<div class="ms-2 ml-2 text-start text-left">
                            <a href="'.$value['profile'].'" target="_blank"><h6 class="mb-0">'.$value['author'].'</h6></a>
                            <small class="text-muted small">'.\Core\Helper::timeago($value['date']).'</small>
                        </div>
                        <div class="ms-auto">
                            <a href="'.$value['profile'].'" class="btn btn-sm btn-custom border text-muted" target="_blank">'.e('Follow').'</a>
                        </div>
                </div>';
            $html .='
                <div class="border-top p-3 text-start text-left">
                    <div>'.$value['description'].'</div>
                </div>';
            if($value['media']){
                $html .= '<video width="100%" controls autoplay>
                            <source src="'.$value['media'].'" type="video/mp4">
                        </video>';
            }
            if($value['thumbnail']){
                $html .= '<img width="100%" class="img-fluid img-responsive" src="'.$value['thumbnail'].'">';
            }
            $html .= '<a href="'.$value['link'].'" class="btn btn-sm btn-custom border text-muted m-1 shadow-none" target="_blank">'.e('View on LinkedIn').'</a>';
        $html .= '</div>';
        return $html;
    }
}
