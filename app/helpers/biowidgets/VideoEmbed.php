<?php
/**
 * Video Embed Widget
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

class VideoEmbed {
    /**
     * Video Embed Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Content
     * @version 7.6.2
     * @return void
     */
    public static function setup(){
        $type = 'vembed';

        return "function fnvembed(el, content = null, did = null){
            var url = content && content['url'] ? content['url'] : '';
            
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Video URL').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][url]" placeholder="e.g. https://www.youtube.com/watch?v=..." value="\'+url+\'">
                        <p class="form-text">'.\Helpers\BioWidgets::e('Supported platforms: YouTube, Vimeo, Dailymotion, Facebook Video, Kick, Twitch').'</p>
                    </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }

    /**
     * Save Video Embed Settings
     *
     * @author GemPixel
     * @version 7.6.2
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function save($request, $profiledata, $data){
        $data['url'] = clean($data['url']);
        
        if(empty($data['url'])) {
            throw new \Exception(e('Please enter a valid video URL'));
        }

        if(preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $data['url'], $matches) || 
        preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
            $data['platform'] = 'youtube';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/vimeo\.com\/([0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'vimeo';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/dailymotion\.com\/video\/([a-zA-Z0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'dailymotion';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/facebook\.com\/watch\?v=([0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'facebook';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/kick\.com\/([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
            $data['platform'] = 'kick';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/twitch\.tv\/videos\/([0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'twitch';
            $data['video_id'] = $matches[1];
            $data['videotype'] = 'video';
        }elseif(preg_match('/twitch\.tv\/([a-zA-Z0-9_]+)\/?$/', $data['url'], $matches)) {            
            $data['platform'] = 'twitch';
            $data['video_id'] = $matches[1];
            $data['videotype'] = 'channel';            
        }else {
            throw new \Exception(e('Please enter a valid video URL from supported platforms'));
        }
        
        return $data;
    }

    /**
     * Display Video Embed Block
     *
     * @author GemPixel
     * @version 7.6.2
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function block($id, $value){

        if(!isset($value['platform']) || !isset($value['video_id'])) return '';
        
        switch($value['platform']) {
            case 'youtube':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;" 
                            src="https://www.youtube.com/embed/'.clean($value['video_id']).'" 
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                            encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                break;
                
            case 'vimeo':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"  
                            src="https://player.vimeo.com/video/'.clean($value['video_id']).'" 
                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen></iframe>';
                break;
                
            case 'dailymotion':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"  
                            src="https://www.dailymotion.com/embed/video/'.clean($value['video_id']).'" 
                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen></iframe>';
                break;
                
            case 'facebook':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"  
                            src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fvideo.php%3Fv%3D'.clean($value['video_id']).'&show_text=0" 
                            frameborder="0" allow="autoplay; clipboard-write; encrypted-media; 
                            picture-in-picture; web-share" allowfullscreen></iframe>';
                break;

            case 'kick':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"
                            src="https://player.kick.com/'.clean($value['video_id']).'"
                            frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                break;

            case 'twitch':
                if(isset($value['videotype']) && $value['videotype'] == 'channel') {
                    $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"
                                src="https://player.twitch.tv/?channel='.clean($value['video_id']).'&parent='.parse_url(url(''), PHP_URL_HOST).'"
                                frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                } else {
                    $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"
                                src="https://player.twitch.tv/?video='.clean($value['video_id']).'&parent='.parse_url(url(''), PHP_URL_HOST).'"
                                frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                }
                break;
                
            default:
                return '';
        }
        
        return '<div class="video-container">'.$embed.'</div>';
    }
}
