<?php
/**
 * Music Link Widget
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
use Traits\Links;

class MusicLink {   

    use \Traits\Links;
    /**
     * Musiclink Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup() {
        $type = 'musiclink';
    
        $providers = [
            'spotify' => 'Spotify',
            'applemusic' => 'Apple Music',
            'youtube' => 'YouTube',
            'youtubemusic' => 'YouTube Music',
            'amazonmusic' => 'Amazon Music',
            'bandcamp' => 'Bandcamp',
            'pandora' => 'Pandora',
            'googleplay' => 'Google Play',
            'soundcloud' => 'Soundcloud',
            'deezer' => 'Deezer',
            'tidal' => 'Tidal',
            'yandexmusic' => 'Yandex Music',
            'vkmusic' => 'VK Music',
            'mixcloud' => 'MixCloud',
            'iheartradio' => 'iHeartRadio',
            'vimeo' => 'Vimeo',
            'ticketmaster' => 'Ticketmaster',
            'stubhub' => 'Stubhub'
        ];
    
        $jsContent = "
            var content = content || {};
            var image = content['image'] || '';
            var title = content['title'] || '';
            var description = content['description'] || '';
            var layout = content['layout'] || 'list';
        ";
    
        foreach ($providers as $key => $name) {
            $jsContent .= "var $key = content['$key'] || '';\n";
            $jsContent .= "var button{$key} = content['button-$key'] || '';\n";
        }
    
        $htmlContent = '<div id="container-\'+did+\'">
            <h5 class="fw-bold mb-3">'.\Helpers\BioWidgets::e('Preview').'</h5>
            <div class="border rounded p-2 mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Image').'</label>
                            <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="image/*">
                            <p class="form-text">'.\Helpers\BioWidgets::e('Upload an image for the song (e.g., album cover).').'</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Title').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][title]" placeholder="Enter song title" value="\'+title+\'">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Headline').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][description]" placeholder="e.g. Listen to my latest hits" value="\'+description+\'">
                </div>
            </div>
            <h5 class="fw-bold mb-3">'.\Helpers\BioWidgets::e('Design').'</h5>
            <div class="border rounded p-2 mb-3">
                <div class="form-group" data-toggle="buttons">
                    <label class="btn text-center border rounded p-2 h-100 me-4 \'+(layout ==\'list\' ? \'border-secondary\' : \'\')+\'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="80" height="80"><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>                        
                        <input type="radio" name="data[\'+slug(did)+\'][layout]" value="list" class="d-none" \'+(layout ==\'list\' ? \'checked\' : \'\')+\'>
                    </label>
                    <label class="btn text-center border rounded p-2 h-100 me-1 \'+(layout ==\'grid\' ? \'border-secondary\' : \'\')+\'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="80" height="80"><path d="M128 136c0-22.1-17.9-40-40-40L40 96C17.9 96 0 113.9 0 136l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48zm0 192c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48zm32-192l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40zM288 328c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48zm32-192l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40zM448 328c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48z"/></svg>
                        <input type="radio" name="data[\'+slug(did)+\'][layout]" value="grid" class="d-none" \'+(layout ==\'grid\' ? \'checked\' : \'\')+\'>
                    </label>
                </div>
            </div>
            <h5 class="fw-bold my-3">'.\Helpers\BioWidgets::e('Platform Links').'</h5>';
    
        foreach ($providers as $key => $name) {
            $htmlContent .= '<div class="border rounded p-2 mb-2"><div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="form-label fw-bold d-block">'.\Helpers\BioWidgets::e($name) . ' \'+(typeof content[\'urlid-'.$key.'\'] !== "undefined" ? \'<a href="\'+appurl+\'\'+content[\'urlid-'.$key.'\']+\'/stats" class="text-muted text-small float-end" target="_blank" data-bs-toggle="tooltip"><i class="fa fa-chart-line"></i></a>\' : \'\')+\'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][' . $key . ']" placeholder="e.g. https://site.com/..." value="\'+' . $key . '+\'">
                    </div>                
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Button Text').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][button-' . $key . ']" placeholder="e.g. Listen" value="\'+'.'button'.$key.'+\'">
                    </div>
                </div>
            </div></div>';
        }
    
        $htmlContent .= '</div>';
    
        return "function fnmusiclink(el, content = null, did = null) {
            
            var blockpreview = '';

            if (did == null) did = (Math.random() + 1).toString(36).substring(2);
    
            $jsContent
    
            let html = '" . \Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate($htmlContent, $type)) . "';
    
            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Musiclink Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $appConfig = appConfig('app');
        $sizes = config('sizes');
        $extensions = config('extensions');

        $id = $data['id'];    
        
        if($image = $request->file($id)){

            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->image) {
                throw new \Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => $extensions->bio->image, 's' => $sizes->bio->image]));
            }
            
            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
    
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_musiclinktype".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$id]['image']) && $profiledata['links'][$id]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$id]['image']);
            }

            $data['image'] = $filename;

        } else {
            if(isset($profiledata['links'][$id]['image'])) $data['image'] = $profiledata['links'][$id]['image'];
        }

        $providers = [
            'spotify' => 'Spotify',
            'applemusic' => 'Apple Music',
            'youtube' => 'YouTube',
            'youtubemusic' => 'YouTube Music',
            'amazonmusic' => 'Amazon Music',
            'bandcamp' => 'Bandcamp',
            'pandora' => 'Pandora',
            'googleplay' => 'Google Play',
            'soundcloud' => 'Soundcloud',
            'deezer' => 'Deezer',
            'tidal' => 'Tidal',
            'yandexmusic' => 'Yandex Music',
            'vkmusic' => 'VK Music',
            'mixcloud' => 'MixCloud',
            'iheartradio' => 'iHeartRadio',
            'vimeo' => 'Vimeo',
            'ticketmaster' => 'Ticketmaster',
            'stubhub' => 'Stubhub'
        ];
        
        $self = new self();
        $user = Auth::user();
        $profileid = $request->segment(3);

        foreach($providers as $key => $provider){
            if(!isset($data[$key]) || empty($data[$key])) continue;

            if(isset($profiledata['links'][$id]['urlid-'.$key])){

                $currenturl = DB::url()->where('userid', $user->rID())->where('id', (int) $profiledata['links'][$id]['urlid-'.$key])->first();

                if(!$currenturl){

                    if(
                        $self->domainBlacklisted($data[$key]) ||
                        $self->wordBlacklisted($data[$key]) ||
                        !$self->safe($data[$key]) ||
                        $self->phish($data[$key]) ||
                        $self->virus($data[$key])
                    ) {
                        throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $newlink = DB::url()->create();
                    $newlink->url = \Core\Helper::clean($data[$key], 3);
                    $newlink->userid = $user->rID();
                    $newlink->alias = null;
                    $newlink->custom = null;
                    $newlink->date = \Core\Helper::dtime();
                    $newlink->profileid = $profileid;
                    $newlink->save();
                    $data['urlid-'.$key] = $newlink->id;

                }else{

                    if(
                        $self->domainBlacklisted($data[$key]) ||
                        $self->wordBlacklisted($data[$key]) ||
                        !$self->safe($data[$key]) ||
                        $self->phish($data[$key]) ||
                        $self->virus($data[$key])
                    ) {
                        throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $currenturl->url = \Core\Helper::clean($data[$key], 3);

                    if(!$currenturl->profileid) {
                        $currenturl->date = \Core\Helper::dtime();
                        $currenturl->profileid = $profileid;
                    }

                    $currenturl->save();
                    $data['urlid-'.$key] = $currenturl->id;
                }

            }else {

                if(!$self->validate($data[$key])) throw new \Exception(e('{b} Error: Please enter a valid url', null, ['b' => e('Link')]));
                if(
                    $self->domainBlacklisted($data[$key]) ||
                    $self->wordBlacklisted($data[$key]) ||
                    !$self->safe($data[$key]) ||
                    $self->phish($data[$key]) ||
                    $self->virus($data[$key])
                ) {
                    throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                }

                $newlink = DB::url()->create();
                $newlink->url = \Core\Helper::clean($data[$key], 3);
                $newlink->userid = $user->rID();
                $newlink->alias = null;
                $newlink->custom = null;
                $newlink->date = \Core\Helper::dtime();
                $newlink->profileid = $profileid;
                $newlink->save();
                $data['urlid-'.$key] = $newlink->id;
            }
        }

        $data = array_map('clean', $data);

        return $data;
    }
    /**
     * Musiclink Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        
        $providers = [
            'spotify' => 'Spotify',
            'applemusic' => 'Apple Music',
            'youtube' => 'YouTube',
            'youtubemusic' => 'YouTube Music',
            'amazonmusic' => 'Amazon Music',
            'bandcamp' => 'Bandcamp',
            'pandora' => 'Pandora',
            'googleplay' => 'Google Play',
            'soundcloud' => 'Soundcloud',
            'deezer' => 'Deezer',
            'tidal' => 'Tidal',
            'yandexmusic' => 'Yandex Music',
            'vkmusic' => 'VK Music',
            'mixcloud' => 'MixCloud',
            'iheartradio' => 'iHeartRadio',
            'vimeo' => 'Vimeo',
            'ticketmaster' => 'Ticketmaster',
            'stubhub' => 'Stubhub'
        ];

        $html = '<div class="card p-2 music-link-preview"><div class="d-flex align-items-center text-left text-start">
            '.(isset($value['image']) && !empty($value['image']) ? '<img src="'.uploads($value['image'], 'profile').'" alt="'.($value['title'] ?? '').'" class="img-fluid rounded mb-2" width="100">' : '').'
            <div class="ms-3 ml-3">
                <h6 class="fw-bold">'.($value['title'] ?? '').'</h6>
                '.(!empty($value['description']) ? '<p class="text-muted mb-0">'.$value['description'].'</p>':'').'
            </div>
        </div>';
        $i = 0;
        if($value['layout'] == 'grid'){
            $html .= '<div class="d-flex align-items-center">';
            foreach($providers as $key => $provider){
                if(!isset($value[$key]) || empty($value[$key])) continue;
                $html .='<div class="col-6 h-100"><a href="'.$value[$key].'" class="btn btn-block p-3 d-block shadow-none btn-custom text-center mt-2 border h-100 me-1 mr-1 ml-1 ms-1" target="_blank" rel="nofollow" data-blockid="'.$value['urlid-'.$key].'">
                    <p><img src="'.assets('images/'.$key.'.svg').'"></p>
                    <span class="c2a text-mute mt-2 d-inline-block w-100">'.(!empty($value['button-'.$key]) ? $value['button-'.$key] :  e('Listen')).'</span>
                </a></div>';
                if($i > 0 && $i%2) $html .= '</div><div class="d-flex align-items-center">';
                $i++;
            }
            $html .= '</div>';
        } else {
            foreach($providers as $key => $provider){
                if(!isset($value[$key]) || empty($value[$key])) continue;
                $html .='<a href="'.$value[$key].'" class="btn btn-block p-3 d-block shadow-none btn-custom d-flex align-items-center mt-2 border" target="_blank" rel="nofollow" data-blockid="'.$value['urlid-'.$key].'">
                    <img src="'.assets('images/'.$key.'.svg').'" width="40">
                    <span class="ms-3 ml-3">'.$provider.'</span>
                    <span class="ms-auto ml-auto c2a text-muted">'.(!empty($value['button-'.$key]) ? $value['button-'.$key] :  e('Listen')).'</span>
                </a>';
            }
        }
        $html .= "</div>";
        return $html;
    }
}
