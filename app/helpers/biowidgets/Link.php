<?php
/**
 * Link Widget
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

class Link {
    use \Traits\Links;
    /**
     * Link Block Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'link';

        return "function fnlink(el, content = null, did = null){

            var text = '', link = '', animation = '', icon = '', urlid = null, clicks = 0, opennew = 0, iconmode = 'none';

            if(content){
                var text = content['text'] ?? '';
                var icon = content['icon'] ?? '';
                var animation = content['animation'] ?? '';
                var link = content['link'] ?? '';
                var urlid = content['urlid'] ?? null;
                var clicks = content['clicks'] ?? 0;
                var opennew = content['opennew'] ?? 0;
                var featured = content['featured'] ?? 0;
                if(icon && !content['iconmode']){
                    var iconmode = 'icon';
                }else{
                    var iconmode = content['iconmode'] ?? 'none';
                }
            }

            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="icon-parent">
                        <div class="icon-selector mb-3">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Icon').'</label>
                            <div class="d-flex bg-light p-2 rounded-3" data-toggle="multibuttons">
                                <a href="#" class="btn flex-fill \'+(iconmode == \'none\' ? \'shadow-sm bg-white border rounded-3 fw-bold active\' : \'\')+\'" data-trigger="icontype"  data-value="none">'.e('None ').'</a>
                                <a href="#\'+did+\'_formicon" data-trigger="icontype" data-value="icon" class="btn flex-fill \'+(iconmode == \'icon\' ? \'shadow-sm bg-white border rounded-3 fw-bold active\' : \'\')+\'">'.e('Icon/Emoji').'</a>
                                <a href="#\'+did+\'_formimage" data-trigger="icontype" data-value="image" class="btn flex-fill \'+(iconmode == \'image\' ? \'shadow-sm bg-white border rounded-3 fw-bold active\' : \'\')+\'">'.e('Image').'</a>
                            </div>
                            <input type="hidden" class="iconmode" name="data[\'+slug(did)+\'][iconmode]" value="\'+iconmode+\'">
                        </div>
                        <div class="form-group mb-3 icon-collapse \'+(iconmode == \'icon\' ? \'\' : \'collapse\')+\'" id="\'+did+\'_formicon">
                            <div class="block">
                                <span class="p-3 px-5 border rounded display-4 d-inline-block my-2 iconpicker-component" id="\'+did+\'_icon_preview"><i class="\'+icon+\'"></i></span>
                                <input type="text" class="form-control p-2 d-block mt-2" name="data[\'+slug(did)+\'][icon]" id="\'+did+\'_icon" placeholder="e.g. fab fa-twitter or type an emoji e.g. ✋" value="\'+icon+\'">
                            </div>
                        </div>
                        <div class="form-group mb-3 icon-collapse \'+(iconmode == \'image\' ? \'\' : \'collapse\')+\'" id="\'+did+\'_formimage">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Image').'</label>
                            <div class="mb-2">
                                <label for="iconimage-\'+slug(did)+\'" role="button" class="d-block">
                                    <img src="\'+(content && content[\'image\'] ? \''.url('content/profiles/').'\'+content[\'image\'] : \'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAJCAQAAACRI2S5AAAAEklEQVR42mP8/58BL2AcVQAGAHscEfhX5bYNAAAAAElFTkSuQmCC\')+\'" width="100" height="100" class="rounded-3 border shadow-sm" id="iconimage-preview-\'+slug(did)+\'">
                                </label>
                            </div>
                            <div>
                                <label for="iconimage-\'+slug(did)+\'" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2">
                                    '.\Helpers\BioWidgets::e('Upload Image').'
                                </label>
                                <p class="form-text">'.\Helpers\BioWidgets::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'</p>
                                <input type="file" name="iconimage[\'+slug(did)+\']" id="iconimage-\'+slug(did)+\'" class="d-none" accept="image/*" data-auto-crop data-ratio="1:1" data-max-size="'.config('sizes')->bio->image.'" data-allowed-extensions="'.config('extensions')->bio->image.'" data-preview-selector="#iconimage-preview-\'+slug(did)+\'" data-error="'.\Helpers\BioWidgets::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">                        
                        <div class="d-flex">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Text').'</label>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input" type="checkbox" data-binary="true" id="data[\'+slug(did)+\'][featured]" name="data[\'+slug(did)+\'][featured]" value="1"\'+(featured == 1 ? \'checked\': \'\')+\'>
                                    <label class="form-check-label fw-bold" for="data[\'+slug(did)+\'][featured]">'.\Helpers\BioWidgets::e('Featured').'</label>
                                </div>
                            </div>
                        <input type="text" class="form-control p-2 text" name="data[\'+slug(did)+\'][text]" value="\'+text+\'" placeholder="e.g. My Site">
                    </div>
                    <div class="mt-3">
                        <div class="form-group">
                            <div class="d-flex">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input" type="checkbox" data-binary="true" id="data[\'+slug(did)+\'][opennew]" name="data[\'+slug(did)+\'][opennew]" value="1"\'+(opennew == 1 ? \'checked\': \'\')+\'>
                                    <label class="form-check-label fw-bold" for="data[\'+slug(did)+\'][opennew]">'.\Helpers\BioWidgets::e('New window').'</label>
                                </div>
                            </div>
                            <input type="text" class="form-control p-2 text" name="data[\'+slug(did)+\'][link]" value="\'+link+\'" placeholder="e.g. https://google.com">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Animation').'</label>
                                <select name="data[\'+slug(did)+\'][animation]" class="animation form-select mb-2 p-2">
                                <option value="none" \'+(animation == \'none\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('None').'</option>
                                <option value="shake" \'+(animation == \'shake\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Shake').'</option>
                                <option value="scale" \'+(animation == \'scale\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Scale').'</option>
                                <option value="jello" \'+(animation == \'jello\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Jello').'</option>
                                <option value="vibrate" \'+(animation == \'vibrate\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Vibrate').'</option>
                                <option value="wobble" \'+(animation == \'wobble\' ? \'selected\':\'\')+\'>'.\Helpers\BioWidgets::e('Wobble').'</option>
                            </select>
                        </div>
                    </div>
                  </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            if(isEmoji(icon)){
                $('#'+did+'_icon_preview i').attr('class','').text(icon);
            }

            $('#'+did+'_icon').iconpicker();

            $('#'+did+'_icon').change(function(){
                if(isEmoji($(this).val())){
                    $('#'+did+'_icon').val($(this).val());
                    $('#'+did+'_icon_preview i').attr('class','').text($(this).val());
                }
            });
            $('#'+did+'_icon').on('iconpickerSelected', function(){
                $('#'+did+'_icon_preview i').attr('class', $(this).val()).text('');
                $('#'+did+'_icon').val($(this).val());
            });

            $('#'+did+'_link').change(function(e){
                if($(this).val() == ''){
                    e.preventDefault();
                    $.notify({
                        message: '".\Helpers\BioWidgets::e('Please enter a valid link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            });
        }";
    }
    /**
     * Save Link
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

        $data['iconmode'] = in_array($data['iconmode'], ['none', 'icon', 'image']) ? $data['iconmode'] : 'none';

        $data['opennew'] = $data['opennew'] == '1' ? 1 : 0;

        $data['featured'] = $data['featured'] == '1' ? 1 : 0;

        $data['sensitive'] = $data['sensitive'] == '1' ? 1 : 0;

        $data['subscribe'] = $data['subscribe'] == '1' ? 1 : 0;

        $data['animation'] = in_array($data['animation'], ['shake','wobble','vibrate','jello','scale']) ? $data['animation'] : 'none';

        $data['icon'] = clean($data['icon']);

        $data['sensitivemessage'] = \Core\Helper::clean($data['sensitivemessage'], 3);

        if($data['sensitive'] && $data['subscribe']) throw new \Exception(e('{b} Error: You can either enable Sensitive Content or Subscribe gate but not both.', null, ['b' => e('Link')]));

        $user = Auth::user();

        $profileid = $request->segment(3);

        $self = new self();

        $data['urlid'] = $profiledata['links'][$data['id']]['urlid'] ?? null; 
    
        if($data['link']){

            if(!\Core\Helper::isURL($data['link'])) throw new \Exception(e('{b} Error: Please enter a valid URL.', null, ['b' => e('Link')]));

            if(isset($data['urlid'])){

                $currenturl = DB::url()->where('userid', $user->rID())->where('id', $data['urlid'])->first();

                if(!$currenturl){

                    if(
                        $self->domainBlacklisted($data['link']) ||
                        $self->wordBlacklisted($data['link']) ||
                        !$self->safe($data['link']) ||
                        $self->phish($data['link']) ||
                        $self->virus($data['link'])
                    ) {
                        throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $newlink = DB::url()->create();
                    $newlink->url = \Core\Helper::clean($data['link'], 3);
                    $newlink->userid = $user->rID();
                    $newlink->alias = null;
                    $newlink->custom = null;
                    $newlink->date = \Core\Helper::dtime();
                    $newlink->profileid = $profileid;
                    $newlink->save();
                    $data['urlid'] = $newlink->id;

                }else{

                    if(
                        $self->domainBlacklisted($data['link']) ||
                        $self->wordBlacklisted($data['link']) ||
                        !$self->safe($data['link']) ||
                        $self->phish($data['link']) ||
                        $self->virus($data['link'])
                    ) {
                        throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $currenturl->url = \Core\Helper::clean($data['link'], 3);

                    if(!$currenturl->profileid) {
                        $currenturl->date = \Core\Helper::dtime();
                        $currenturl->profileid = $profileid;
                    }

                    $currenturl->save();
                }

            }else {

                if(
                    $self->domainBlacklisted($data['link']) ||
                    $self->wordBlacklisted($data['link']) ||
                    !$self->safe($data['link']) ||
                    $self->phish($data['link']) ||
                    $self->virus($data['link'])
                ) {
                    throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                }

                $newlink = DB::url()->create();
                $newlink->url = \Core\Helper::clean($data['link'], 3);
                $newlink->userid = $user->rID();
                $newlink->alias = null;
                $newlink->custom = null;
                $newlink->date = \Core\Helper::dtime();
                $newlink->profileid = $profileid;
                $newlink->save();
                $data['urlid'] = $newlink->id;
            }
        }

        if(isset($profiledata['links'][$data['id']]['image'])){
            $data['image'] = $profiledata['links'][$data['id']]['image'];
        }
        $appConfig = appConfig('app');
        $extensions = config('extensions');
        $sizes = config('sizes');

        if($data['iconmode'] == 'image' && $file = $request->file('iconimage')){

            if(isset($file[$data['id']])){

                $image = $file[$data['id']];

                if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->link)) || $image->sizekb > $sizes->bio->link) {
                    throw new \Exception(e('Image must be either a GIF, PNG or a JPEG (Max {s}kb).', null, ['s' =>  $sizes->bio->link]));
                }

                $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

                if(!file_exists($directory)){
                    mkdir($directory, 0775);
        
                    $f = fopen($directory.'/index.html', 'w');
                    fwrite($f, '');
                    fclose($f);
                }

                $filename = date('Y-m-d')."/profile_linktype_".\Core\Helper::rand(6).md5(microtime(false)).'.'.$image->ext;

                $request->move($image, $appConfig['storage']['profile']['path'], $filename);

                if(isset($profiledata['links'][$data['id']]['image']) && $profiledata['links'][$data['id']]['image']){
                    App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$data['id']]['image']);
                }

                $data['icon'] = '';
                $data['image'] = $filename;
            }
        }

        if($data['iconmode'] !== 'image'){
            if(isset($profiledata['links'][$data['id']]['image']) && $profiledata['links'][$data['id']]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$data['id']]['image']);
                $data['image'] = '';
            }
        }

        return $data;
    }

    /**
     * Delete Link Block Images
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data
     * @return void
     */
    public static function delete($id, $value){
        if(isset($value['image']) && $value['image']){
            $appConfig = appConfig('app');
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
    }
    /**
     * Process Links
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function processor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){
            if($request->action == "clicked" && $request->blockid && is_numeric($request->blockid)){

                \Gem::addMiddleware('BlockBot');

                if($link = \Core\DB::url()->where('id', $request->blockid)->first()){
                    (new Link)->updateStats($request, $link, $user);
                    return Response::factory('success')->exit();
                } else {
                    return Response::factory('error')->exit();
                }
            }

            if($request->action == "newslettergate"){

                if(!$request->email || !$request->validate($request->email, 'email')) {
                    Response::factory(['error' => true, 'message' => e('Please enter a valid email.')])->json();
                    exit;
                }

                $resp = json_decode($profile->responses, true);

                if(!isset($resp['newsletter']) || !in_array($request->email, $resp['newsletter'])){
                    $resp['newsletter'][] = clean($request->email);

                    $profile->responses = json_encode($resp);
                    $profile->save();
                }

                \Gem::addMiddleware('BlockBot');

                if($link = \Core\DB::url()->where('id', $request->blockid)->first()){
                    (new Link)->updateStats($request, $link, $user);
                    Response::factory(['error' => false, 'message' => e('You have been subscribed successfully'), 'html' => "<script>window.location = '".$link->url."';</script>"])->json();
                    exit;
                } else {
                    Response::factory(['error' => true, 'message' => e('An error occurred. Please try again.')])->json();                
                    exit;
                }
            }
        }
    }
    /**
     * Link Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        if(!isset($value['urlid'])) return;

        $value['animation'] = isset($value['animation']) && in_array($value['animation'], ['shake','wobble','vibrate','jello','scale']) ? ' animate_'.$value['animation'] : '';

        if(isset($value['featured']) && $value['featured']){
            $html .= '<span class="position-absolute top-0 start-0 badge bg-primary">Featured</span>';
        }

        if(isset($value['sensitive']) && $value['sensitive']){
            $html ='<a href="#" data-toggle="modal" data-bs-toggle="modal" data-target="#modal-'.$id.'" data-bs-target="#modal-'.$id.'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative'.$value['animation'].'">';

            if((!isset($value['iconmode']) && $value['icon']) || (isset($value['iconmode']) && $value['iconmode'] == 'icon' && $value['icon'])){
                if(preg_match('/[\x{1F600}-\x{1F64F}|\x{1F300}-\x{1F5FF}|\x{1F680}-\x{1F6FF}|\x{1F700}-\x{1F77F}|\x{1F780}-\x{1F7FF}|\x{1F800}-\x{1F8FF}|\x{1F900}-\x{1F9FF}|\x{1FA00}-\x{1FA6F}|\x{1FA70}-\x{1FAFF}|\x{1FB00}-\x{1FBFF}]/u', $value['icon']) && !preg_match('/fa-/u', $value['icon'])){
                    $html.='<span class="position-absolute start-0 left-0 top-50 translate-middle-y ms-0 ml-2 display-6">'.$value['icon'].'</span>';
                } else {
                    $html.='<i class="'.$value['icon'].' position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3"></i>';
                }
            }
            if(isset($value['iconmode']) && $value['iconmode'] == 'image' && isset($value['image']) && $value['image']){
                $html.='<img src="'.uploads($value['image'], 'profile').'" class="position-absolute start-0 left-0 top-50 translate-middle-y">';
            }

            $html.='<span class="align-top">'.$value['text'].'</span>
            </a>
            <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            '.(isset($value['sensitivemessage']) && !empty($value['sensitivemessage']) ? $value['sensitivemessage'] : e('This link may contain inappropriate content not suitable for all ages.')).'
                        </div>
                        <div class="modal-body">
                            <a href="'.$value['link'].'" '.(isset($value['opennew']) && $value['opennew'] ? 'target="_blank"' : '').' rel="nofollow" data-blockid="'.$value['urlid'].'" class="btn btn-dark text-white rounded-pill w-100 d-block py-2">'.\Helpers\BioWidgets::e('Continue').'</a>
                        </div>
                    </div>
                </div>
            </div>';
            return $html;
        }

        if(isset($value['subscribe']) && $value['subscribe']){
            $html ='<a href="#" data-toggle="modal" data-bs-toggle="modal" data-target="#modal-'.$id.'" data-bs-target="#modal-'.$id.'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative'.$value['animation'].'">';

            if((!isset($value['iconmode']) && $value['icon']) || (isset($value['iconmode']) && $value['iconmode'] == 'icon' && $value['icon'])){
                if(preg_match('/[\x{1F600}-\x{1F64F}|\x{1F300}-\x{1F5FF}|\x{1F680}-\x{1F6FF}|\x{1F700}-\x{1F77F}|\x{1F780}-\x{1F7FF}|\x{1F800}-\x{1F8FF}|\x{1F900}-\x{1F9FF}|\x{1FA00}-\x{1FA6F}|\x{1FA70}-\x{1FAFF}|\x{1FB00}-\x{1FBFF}]/u', $value['icon']) && !preg_match('/fa-/u', $value['icon'])){
                    $html.='<span class="position-absolute start-0 left-0 top-50 translate-middle-y ms-0 ml-2 display-6">'.$value['icon'].'</span>';
                } else {
                    $html.='<i class="'.$value['icon'].' position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3"></i>';
                }
            }
            if(isset($value['iconmode']) && $value['iconmode'] == 'image' && isset($value['image']) && $value['image']){
                $html.='<img src="'.uploads($value['image'], 'profile').'" class="position-absolute start-0 left-0 top-50 translate-middle-y">';
            }

            $html.='<span class="align-top">'.$value['text'].'</span></a>
            <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bolder">'.\Helpers\BioWidgets::e('Subscribe to unlock').'</h5>
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" data-trigger="server-form">
                                <div class="form-group position-relative mb-2">
                                    <input type="email" class="form-control p-3" name="email" placeholder="'.\Helpers\BioWidgets::e('Please enter a valid email').'" data-error="'.\Helpers\BioWidgets::e('Please enter a valid email').'" required>
                                    <input type="hidden" name="action" value="newslettergate">
                                    <input type="hidden" name="blockid" value="'.$value['urlid'].'">
                                    <input type="hidden" name="target" value="'.$value['link'].'">
                                    <button type="submit" class="btn btn-secondary btn-sm position-absolute top-50 right-0 end-0 translate-middle-y btn-dark me-2 mr-2">'.\Helpers\BioWidgets::e('Subscribe').'</button>
                                </div>
                            </form>
                            <span class="text-muted text-start text-left d-block">'.\Helpers\BioWidgets::e('By subscribing, I agree to the terms and conditions and privacy policy.').'</span>
                        </div>
                    </div>
                </div>
            </div>';
            return $html;
        }

        $html= '<a href="'.$value['link'].'" '.(isset($value['opennew']) && $value['opennew'] ? 'target="_blank"' : '').' rel="nofollow" data-blockid="'.$value['urlid'].'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative'.$value['animation'].'">';

        if((!isset($value['iconmode']) && $value['icon']) || (isset($value['iconmode']) && $value['iconmode'] == 'icon' && $value['icon'])){
            if(preg_match('/[\x{1F600}-\x{1F64F}|\x{1F300}-\x{1F5FF}|\x{1F680}-\x{1F6FF}|\x{1F700}-\x{1F77F}|\x{1F780}-\x{1F7FF}|\x{1F800}-\x{1F8FF}|\x{1F900}-\x{1F9FF}|\x{1FA00}-\x{1FA6F}|\x{1FA70}-\x{1FAFF}|\x{1FB00}-\x{1FBFF}]/u', $value['icon']) && !preg_match('/fa-/u', $value['icon'])){
                $html.='<span class="position-absolute start-0 left-0 top-50 translate-middle-y ms-0 ml-2 display-6">'.$value['icon'].'</span>';
            } else {
                $html.='<i class="'.$value['icon'].' position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3"></i>';
            }
        }

        if(isset($value['iconmode']) && $value['iconmode'] == 'image' && isset($value['image']) && $value['image']){
            $html.='<img src="'.uploads($value['image'], 'profile').'" class="position-absolute start-0 left-0 top-50 translate-middle-y">';
        }

        $html.='<span class="align-top">'.$value['text'].'</span></a>';

        return $html;
    }
}
