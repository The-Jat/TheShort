<?php
/**
 * Featured Link Widget
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


class FeaturedLink {
    use \Traits\Links;
    /**
     * Featured Link Block Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'featuredlink';

        return "function fnfeaturedlink(el, content = null, did = null){

            var text = '', link = '', opennew = 0, clicks = 0, urlid = null;

            if(content){
                var text = content['text'] ?? '';
                var clicks = content['clicks'] ?? 0;
                var link = content['link'] ?? '';
                var urlid = content['urlid'] ?? null;
                var opennew = content['opennew'] ?? 0;
            }

            var blockpreview = text;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Image').'</label>
                        <div class="mb-2">
                            <label for="featuredimage-\'+slug(did)+\'" role="button" class="d-block">
                                <img src="\'+(content && content[\'image\'] ? \''.url('content/profiles/').'\'+content[\'image\'] : \'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAJCAQAAACRI2S5AAAAEklEQVR42mP8/58BL2AcVQAGAHscEfhX5bYNAAAAAElFTkSuQmCC\')+\'" width="100%" height="250" class="rounded-3 border shadow-sm" id="featuredimage-preview-\'+slug(did)+\'" style="object-fit: cover;">
                            </label>
                        </div>
                        <div>
                            <label for="featuredimage-\'+slug(did)+\'" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2">
                                '.\Helpers\BioWidgets::e('Upload Image').'
                            </label>
                            <p class="form-text">'.\Helpers\BioWidgets::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'</p>
                            <input type="file" name="featuredimage[\'+slug(did)+\']" id="featuredimage-\'+slug(did)+\'" class="d-none" accept="image/*" data-auto-crop data-ratio="406:250" data-max-size="'.config('sizes')->bio->image.'" data-allowed-extensions="'.config('extensions')->bio->image.'" data-preview-selector="#featuredimage-preview-\'+slug(did)+\'" data-error="'.\Helpers\BioWidgets::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'">
                        </div>
                    </div>
                    <div class="form-group mb-3">                        
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Title').'</label>
                        <input type="text" class="form-control p-2 text" name="data[\'+slug(did)+\'][text]" value="\'+text+\'" placeholder="e.g. My Featured Link">
                    </div>
                    <div class="form-group mb-3">
                        <div class="d-flex">
                            <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" type="checkbox" data-binary="true" id="data[\'+slug(did)+\'][opennew]" name="data[\'+slug(did)+\'][opennew]" value="1"\'+(opennew == 1 ? \'checked\': \'\')+\'>
                                <label class="form-check-label fw-bold" for="data[\'+slug(did)+\'][opennew]">'.\Helpers\BioWidgets::e('New window').'</label>
                            </div>
                        </div>
                        <input type="text" class="form-control p-2 text" name="data[\'+slug(did)+\'][link]" value="\'+link+\'" placeholder="e.g. https://google.com">
                    </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Save Featured Link
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

        $data['opennew'] = $data['opennew'] == '1' ? 1 : 0;

        $user = Auth::user();

        $profileid = $request->segment(3);

        $self = new self();

        $data['urlid'] = $profiledata['links'][$data['id']]['urlid'] ?? null; 
    
        if($data['link']){

            if(!\Core\Helper::isURL($data['link'])) throw new \Exception(e('{b} Error: Please enter a valid URL.', null, ['b' => e('Featured Link')]));

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
                        throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Featured Link')]));
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
                        throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Featured Link')]));
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
                    throw new \Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Featured Link')]));
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

        if($file = $request->file('featuredimage')){

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

                $filename = date('Y-m-d')."/profile_featuredlink_".\Core\Helper::rand(6).md5(microtime(false)).'.'.$image->ext;

                $request->move($image, $appConfig['storage']['profile']['path'], $filename);

                if(isset($profiledata['links'][$data['id']]['image']) && $profiledata['links'][$data['id']]['image']){
                    App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$data['id']]['image']);
                }

                $data['image'] = $filename;
            }
        }

        return $data;
    }

    /**
     * Delete Featured Link Block Images
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
     * Process Featured Links
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
                    (new FeaturedLink)->updateStats($request, $link, $user);
                    return Response::factory('success')->exit();
                } else {
                    return Response::factory('error')->exit();
                }
            }
        }
    }
    /**
     * Featured Link Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        if(!isset($value['urlid'])) return;

        if(!isset($value['image']) || !$value['image']) return;

        $html = '<div class="card mb-2 border-0 overflow-hidden">';
        
        $html .= '<a href="'.$value['link'].'" '.(isset($value['opennew']) && $value['opennew'] ? 'target="_blank"' : '').' rel="nofollow" data-blockid="'.$value['urlid'].'" class="text-decoration-none">';
        
        $html .= '<img src="'.uploads($value['image'], 'profile').'" class="card-img-top w-100" style="height: 250px;" alt="'.htmlspecialchars($value['text'] ?? '').'">';
        
        $html .= '<div class="card-body p-3">';
        $html .= '<h6 class="mb-0 fw-normal">'.htmlspecialchars($value['text'] ?? '').'</h5>';
        $html .= '</div>';
        
        $html .= '</a>';
        $html .= '</div>';

        return $html;
    }
}
