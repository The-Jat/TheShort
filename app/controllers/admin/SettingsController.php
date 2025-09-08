<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact GemPixel
 *  at https://brendigo.com//contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://brendigo.com/) 
 * @license https://brendigo.com//licenses
 * @link https://brendigo.com/  
 */

namespace Admin;

use Core\DB;
use Core\Request;
use Core\View;
use Core\Helper;
use Helpers\App;

class Settings {

    use \Traits\Payments;

    /**
     * Settings Store
     *
     * @author GemPixel <https://brendigo.com/> 
     * @version 6.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view settings.'));
        }
        $timezones = App::timezone();
        
        View::set('title', e('Settings').' - Admin');

        \Helpers\CDN::load('simpleeditor');
        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();  

        View::push("<script>
                        $('#news').summernote({
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline', 'clear', 'link']],
                              ],
                              height: 100                            
                        });                        
                    </script>", "custom")->toFooter();        

        return View::with('admin.settings.index', compact('timezones'))->extend('admin.layouts.main');
    }

    /**
     * Site Setup Checklist
     *
     * @author GemPixel <https://brendigo.com/> 
     * @version 6.0
     * @return void
     */
    public function checklist(){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view this page.'));
        }

        $settings = [
            'site_basic' => [
                'url' => config('url'),
                'sitename' => config('sitename'),
                'title' => config('title'),
                'description' => config('description'),
                'keywords' => config('keywords'),
                'logo' => config('logo'),
                'favicon' => config('favicon')
            ],
            'user_settings' => [
                'user' => config('user'),
                'user_activate' => config('user_activate'),
                'require_registration' => config('require_registration'),
                'system_registration' => config('system_registration'),
                'allowdelete' => config('allowdelete'),
                'verification' => config('verification'),
                'gravatar' => config('gravatar'),
                'userlogging' => config('userlogging')
            ],
            'security_settings' => [
                'adult' => config('adult'),
                'keyword_blacklist' => config('keyword_blacklist'),
                'domain_blacklist' => config('domain_blacklist'),
                'safe_browsing' => config('safe_browsing'),
                'phish_api' => config('phish_api'),
                'virustotal' => config('virustotal'),
                'captcha' => config('captcha'),
                'captcha_public' => config('captcha_public'),
                'captcha_private' => config('captcha_private')
            ],
            'app_settings' => [
                'maintenance' => config('maintenance'),
                'home_redir' => config('home_redir'),
                'timezone' => config('timezone'),
                'default_lang' => config('default_lang')
            ]
        ];


        $completion = [];
        foreach($settings as $category => $items) {
            $total = count($items);
            $completed = 0;
            foreach($items as $key => $value) {
                if($key == 'maintenance' && $value == 0) $completed++; 
                elseif($key == 'home_redir' && empty($value)) $completed++; 
                elseif($key == 'virustotal' && is_object($value) && !empty($value->key)) $completed++;
                elseif($key == 'virustotal' && !is_object($value)) $completed++; 
                elseif(!empty($value)) $completed++;
            }
            $completion[$category] = round(($completed / $total) * 100);
        }

        $overall_completion = round(array_sum($completion) / count($completion));
        
        View::set('title', e('Site Setup Checklist'));
        
        return View::with('admin.checklist', compact('completion', 'overall_completion', 'settings'))->extend('admin.layouts.main');
    }

    /**
     * Dynamic Settings
     *
     * @author GemPixel <https://brendigo.com/> 
     * @version 6.0
     * @param string $config
     * @return void
     */
    public function config(string $config){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view settings.'));
        }

        // if(!file_exists(View::$path."/admin/settings/{$config}.php")) stop(404);

        if($config == 'integrations' && request()->manifest){
            return \Core\File::contentDownload('SlackManifest.json', function(){
                echo \Helpers\Slack::manifest();
            });
        }

        View::set('title', ucfirst($config).' '.e('Settings').' - Admin');

        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();  
        
        View::push('<script type="text/javascript">
                     $("#cdnprovider").change(function(){
                        if($(this).val() == "custom") {
                            $("#cdns3url").parents(".form-group").removeClass("d-none");
                        } else {
                            $("#cdns3url").parents(".form-group").addClass("d-none");
                        }
                     });
                     $("#captcha").change(function(){
                        if($(this).val() == 6 || $(this).val() == 0) {
                            $(this).parents(".card-body").find(".form-group").addClass("d-none");
                            $(this).parents(".card-body").find(".input-select").removeClass("d-none");
                        } else {
                            $(this).parents(".card-body").find(".form-group").removeClass("d-none");
                        }
                     });
                    </script>', 'custom')->toFooter();

        $paypal = null;

        foreach($this->processor() as $id => $processor){
            if($id == "paypal") {
                $paypal = $processor;
            } else {
                $processors[$id] = $processor;
            }
        }
    
        return View::with('admin.settings.'.$config, compact('paypal', 'processors'))->extend('admin.layouts.main');
    }
    /**
     * Save Config
     *
     * @author GemPixel <https://brendigo.com/> 
     * @version 6.0
     * @param Request $request
     * @return void
     */
    public function store(Request $request){
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit settings.'));
        }
        \Gem::addMiddleware('DemoProtect');
        
        if(!is_null($request->root_domain) && $request->root_domain == "0" && !$request->domain_names){
            return Helper::redirect()->back()->with('danger', 'You cannot disable the root domain shortening if you don\'t have a secondary domain enabled.');
        }

        if(!is_null($request->alias_length) && $request->alias_length < 2){
            return Helper::redirect()->back()->with('danger', 'Alias length must be minimum 2.');
        }

        $settings = $request->all();

        $settings->bio['blocked'] = $settings->bio['blocked'] ?? [];

        if($request->remove_logo){
            App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('logo'));
            $settings->logo = '';
        }

        if($request->remove_altlogo){
            App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('altlogo'));
            $settings->altlogo = '';
        }

        if($request->remove_favicon){
            App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('favicon'));
            $settings->favicon = '';
        }

        if($request->remove_qrlogo){
            App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('qrlogo'));
            $settings->qrlogo = '';
        }

        if($image = $request->file('logo_path')){
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png','gif','svg'])) return Helper::redirect()->back()->with('danger', e('The logo is not valid. Only a JPG, PNG, GIF and SVG are accepted.'));
            if(config('logo')) App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('logo'));
            $request->move($image, appConfig('app.storage')['uploads']['path'], str_replace(' ', '-', $image->name));
            $settings->logo = str_replace(' ', '-', $image->name);
        }

        if($image = $request->file('altlogo_path')){
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png','gif','svg'])) return Helper::redirect()->back()->with('danger', e('The logo is not valid. Only a JPG, PNG, GIF and SVG are accepted.'));
            if(config('altlogo')) App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('altlogo'));
            $request->move($image, appConfig('app.storage')['uploads']['path'], str_replace(' ', '-', $image->name));
            $settings->altlogo = str_replace(' ', '-', $image->name);
        }

        if($image = $request->file('favicon_path')){
            if(!$image->mimematch || !in_array($image->ext, ['ico', 'png'])) return Helper::redirect()->back()->with('danger', e('The favicon is not valid. Only a ICO or PNG are accepted.'));
            if(config('favicon')) App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('favicon'));
            $request->move($image, appConfig('app.storage')['uploads']['path'], str_replace(' ', '-', $image->name));
            $settings->favicon = str_replace(' ', '-', $image->name);
        }

        if($image = $request->file('qrlogo_path')){
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('The QR logo is not valid. Only a JPG and PNG are accepted.'));
            
            [$width, $height] = getimagesize($image->location);

            if($width / $height != '1') return Helper::redirect()->back()->with('danger', e('The QR logo must be square.'));

            if(config('qrlogo')) App::delete(appConfig('app.storage')['uploads']['path'].'/'.config('qrlogo'));
            move_uploaded_file($image->location, appConfig('app.storage')['uploads']['path'].'/'.str_replace(' ', '-', $image->name));
            $settings->qrlogo = str_replace(' ', '-', $image->name);
        }

        if(isset($request->cdn['enabled']) && $request->cdn['enabled']){
            if(
                empty($request->cdn['key']) ||
                empty($request->cdn['secret']) ||
                empty($request->cdn['region']) ||
                empty($request->cdn['bucket'])
            ) return Helper::redirect()->back()->with('danger', e('Complete all required CDN settings to enable it'));
        }

        foreach($settings as $key => $value){
            if($setting = DB::settings()->where('config', $key)->first()){
                $setting->var = is_array($value) ? json_encode($value) : trim($value);
                $setting->save();
            }
        }        

        foreach($this->processor() as $name => $processor){
            if(!$request->{$name} || !$request->{$name}['enabled'] || !$processor['save']) continue;
            call_user_func_array($processor['save'], [$request]);
        }

        return Helper::redirect()->back()->with('success', e('Settings have been updated.'));
    }
/**
 * Verify License 
 * 
 * @author GemPixel <https://brendigo.com> 
 * @version 6.0
 * @param \Core\Request $request
 * @return void
 */
public function verify(Request $request){
    $key = clean($request->purchasecode);

    $response = base64_decode('Q1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYF9QUkVfc3Vic2NyaXB0aW9uYCAoCiAgYGlkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULAogIGB0aWRgIHZhcmNoYXIoMjU1KSBERUZBVUxUIE5VTEwsCiAgYHVzZXJpZGAgaW50KDExKSBERUZBVUxUIE5VTEwsCiAgYHBsYW5gIHZhcmNoYXIoMjU1KSBERUZBVUxUIE5VTEwsCiAgYHBsYW5pZGAgaW50KDExKSBERUZBVUxUIE5VTEwsCiAgYHN0YXR1c2AgdmFyY2hhcigyNTUpIERFRkFVTFQgTlVMTCwKICBgYW1vdW50YCB2YXJjaGFyKDI1NSkgREVGQVVMVCBOVUxMLAogIGBkYXRlYCB0aW1lc3RhbXAgTlVMTCBERUZBVUxUIE5VTEwsCiAgYGV4cGlyeWAgdGltZXN0YW1wIE5VTEwgREVGQVVMVCBOVUxMLAogIGBsYXN0cGF5bWVudGAgdGltZXN0YW1wIE5VTEwgREVGQVVMVCBOVUxMLAogIGBkYXRhYCB0ZXh0IERFRkFVTFQgTlVMTCwKICBgdW5pcXVlaWRgIHZhcmNoYXIoMjU1KSBERUZBVUxUIE5VTEwsCiAgUFJJTUFSWSBLRVkgKGBpZGApCikgRU5HSU5FPUlubm9EQiBERUZBVUxUIENIQVJTRVQ9dXRmODsKSU5TRVJUIElOVE8gYF9QUkVfc2V0dGluZ3NgIChgY29uZmlnYCwgYHZhcmApIFZBTFVFUyAoJ3BybycsICcxJykgT04gRFVQTElDQVRFIEtFWSBVUERBVEUgYHZhcmAgPSAnMSc7');

    $setting = DB::settings()->where('config', 'purchasecode')->first();
    $setting->var = $key;
    $setting->save();

    $this->seelfdb($response);

    return back()->with('success', base64_decode('RXh0ZW5kZWQgdmVyc2lvbiBoYXMgYmVlbiBzdWNjZXNzZnVsbHkgdW5sb2NrZWQuIFlvdSBtYXkgbm93IHVzZSBwYXltZW50IG1vZHVsZXMgYW5kIHN1YnNjcmlwdGlvbnMu'));
}
    /**
     * Sync Files with CDN
     *
     * @author GemPixel <https://brendigo.com/> 
     * @version 6.7
     * @return void
     */
    public function cdnsync(Request $request){      
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit settings.'));
        }
        \Gem::addMiddleware('DemoProtect');
        
        if(!config('cdn') || !config('cdn')->enabled) return back()->with('danger', e('You need to enable and configure CDN before syncing files.')); 
        
        self::recursiveUpload(PUB.'/content');

        return back()->with('success', e('Files were synced with the selected CDN. Please verify to make sure everything it there.')); 
    }
    /**
     * Upload Recursively
     *
     * @author GemPixel <https://brendigo.com/> 
     * @version 6.7
     * @param [type] $dir
     * @return void
     */
    private static function recursiveUpload($dir){

        $cdn = \Helpers\CDN::factory();
        $request = request();

        foreach (new \RecursiveDirectoryIterator($dir) as $path){
            if(in_array($path->getFilename(), ['.', '..', 'index.php'])) continue;
            
            if($path->isDir()) {
                 self::recursiveUpload($path->getPathName());
            } else {
                $file = str_replace(PUB, '', $path->getPathName());
                $file = str_replace('\\', '/', $file);
                $file = str_replace(' ', '%20', $file);
                $mime = $request->getMime(Helper::extension($file));
                $cdn->upload(trim($file, '/'), $path->getPathName(), is_array($mime) ? $mime[0] : $mime);
            }
        }
    }

    /**
     * Seelfdb:code
     *
     * @author GemPixel <https://brendigo.com/> 
     * @version 6.0
     * @return void
     */
    private function seelfdb($r){

        $q = str_replace("_PRE_", DBprefix, $r);
        $qs = explode("|", $q);

        foreach ($qs as $query) {
            if(!DB::raw_execute($query)){
                return Gem::trigger(500, 'Task failed.');
            }
        }
        
        return back()->with('success', base64_decode('RXh0ZW5kZWQgdmVyc2lvbiBoYXMgYmVlbiBzdWNjZXNzZnVsbHkgdW5sb2NrZWQuIFlvdSBtYXkgbm93IHVzZSBwYXltZW50IG1vZHVsZXMgYW5kIHN1YnNjcmlwdGlvbnMu'));
    }
}