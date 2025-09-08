<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed
 *  by GemPixel or authorized parties, you must not use this software and contact gempixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com)
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com
 */

use Core\Plugin;
use Core\Helper;
use Core\DB;
use Core\View;
use Helpers\CDN;

class themeSettings {

    /**
     * Generate extra menu
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function menu(){

        $option = config("theme_config");

        if(!isset($option->homelinks)) return null;
        $menu = [];
        foreach(explode("\n", $option->homelinks) as $list){
            if(empty($list)) continue;
            [$title, $link] = array_map('trim', explode("|", $list));

            $menu[] = ['link' => $link, 'title' => $title];
        }
        return $menu;
    }
    /**
     * Theme Settings
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function settings(){

        if(!$option = config("theme_config")){
            $option = new \stdClass;
        }

        if(!isset($option->hero)) $option->hero = "";
        if(!isset($option->siteimage)) $option->siteimage = "";
        if(!isset($option->homeheader)) $option->homeheader = "";
        if(!isset($option->homedescription)) $option->homedescription = "";
        if(!isset($option->customfooter)) $option->customfooter = "";
        if(!isset($option->homelinks)) $option->homelinks = "";
        if(!isset($option->homestyle)) $option->homestyle = "default";
        if(!isset($option->pricing)) $option->pricing = "list";
        if(!isset($option->blog)) $option->blog = "list";
        if(!isset($option->languageselector)) $option->languageselector = "bottom";
        if(!isset($option->menutype)) $option->menutype = "hybrid";
        if(!isset($option->colors)) {
            $option->colors = new \stdClass;
            $option->colors->primary = '#0088ff';
            $option->colors->primaryalt = '#0065bd';
            $option->colors->secondary = '#22cfff';
            $option->colors->primarybg = '#f7f9fc';
            $option->colors->scrollbar = '#0088ff';
        }

        if(!isset($optiion->colors->darkbg)) $option->colors->darkbg = '#030122';

        CDN::load('coloris');
        View::push("<script>
                    Coloris.setInstance('#primary', {
                        theme: 'polaroid',
                        themeMode: 'dark',
                        alpha: false,
                        swatches: ['#e2626b','#4e67eb','#2fad50','#0088ff','#010615','#ff0090']
                    });
                    Coloris.setInstance('#primaryalt', {
                        theme: 'polaroid',
                        themeMode: 'dark',
                        alpha: false,
                        swatches: ['#c25058','#2746e3','#24853d','#0065bd','#040b22','#ae00ff']
                    });
                    Coloris.setInstance('#secondary', {
                        theme: 'polaroid',
                        themeMode: 'dark',
                        alpha: false,
                        swatches: ['#fab758','#a357fa','#00ffc3', '#22cfff', '#030715','#00ff77']
                    });
                    Coloris.setInstance('#primarybg', {
                        theme: 'polaroid',
                        themeMode: 'dark',
                        alpha: false,
                        swatches: ['#fef6f5','#f5f8ff','#f5fff6','#f7f9fc','#e3e5ea','#f4ebf9']
                    });
                    Coloris.setInstance('#darkbg', {
                        theme: 'polaroid',
                        themeMode: 'dark',
                        alpha: false,
                        swatches: ['#3d1718','#131b3d','#0c2d15','#030122','#010615','#330025']
                    });                    
                    Coloris.setInstance('#scrollbar', {
                        theme: 'polaroid',
                        themeMode: 'dark',
                        alpha: false,
                        swatches: ['#e2626b','#627ee3','#2fad50','#0088ff','#010615','#ae00ff']
                    });
                    </script>", 'custom')->toFooter();

        CDN::load('simpleeditor');

        \Core\View::push("<script>
                            $('#homedescription').summernote({
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear'],
                                  ],
                                  height: 100
                            });
                        </script>", "custom")->toFooter();

        $content = '<div class="row">
                        <div class="col-md-8">
                            <form action="'.route("admin.themes.update").'" method="post" enctype="multipart/form-data" id="setting-form">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="form-group mb-4">
                                            <label for="style" class="form-label fw-bolder mb-3 d-block">'.e('Theme Scheme').'</label>
                                            <label class="btn border-primary text-dark border px-3 py-4">
                                                <input type="radio" name="homestyle" value="default" class="me-2" autocomplete="off" '.($option->homestyle == 'default' ? 'checked' : '').'> '.e('Default').'
                                            </label>
                                            <label class="btn btn-dark text-light px-3 py-4">
                                                <input type="radio" name="homestyle" value="darkmode" class="me-2" autocomplete="off" '.($option->homestyle == 'darkmode' ? 'checked' : '').'> '.e('Dark Mode').'
                                            </label>
                                            <label class="btn text-dark border px-3 py-4">
                                                <input type="radio" name="homestyle" value="light" class="me-2" autocomplete="off" '.($option->homestyle == 'light' ? 'checked' : '').'> '.e('Light Mode').'
                                            </label>
                                            <label class="btn border border-primary px-3 py-4 text-danger" style="background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.5) 50%, rgba(0, 0, 0, 1) 50%);">
                                                <input type="radio" name="homestyle" value="auto" class="me-2" autocomplete="off" '.($option->homestyle == 'auto' ? 'checked' : '').'> '.e('Auto Mode').'
                                            </label>
                                        </div>
                                        <h5 class="fw-bolder mb-3">'.e('Theme Colors').'</h5>
                                        <p>'.e('You can customize colors for front pages (home, pricing, blog etc). Some colors are already preset. You can either use colors from the palette (example #1 with #1 in all options) or mix and match. You can also use your own colors. After saving settings, if you do not see changes, you need to release browser cache. If you are using Cloudflare, you will need to purge cache as well.').'</p>

                                        <div class="form-group my-3">
                                            <label for="primary" class="form-label mb-3">'.e('Primary Color').'</label><br>
                                            <input type="text" value="'.$option->colors->primary.'" id="primary" name="colors[primary]" class="form-control" data-coloris>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="primaryalt" class="form-label mb-3">'.e('Primary Alternative Color').'</label><br>
                                            <input type="text" value="'.$option->colors->primaryalt.'" id="primaryalt" name="colors[primaryalt]" class="form-control" data-coloris>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="secondary" class="form-label mb-3">'.e('Secondary Color').'</label><br>
                                            <input type="text" value="'.$option->colors->secondary.'" id="secondary" name="colors[secondary]" class="form-control" data-coloris>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="primarybg" class="form-label mb-3">'.e('Primary Background Color (Light color)').'</label><br>
                                            <input type="text" value="'.$option->colors->primarybg.'" id="primarybg" name="colors[primarybg]" class="form-control" data-coloris>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="primarybg" class="form-label mb-3">'.e('Dark Background Color (Dark color)').'</label><br>
                                            <input type="text" value="'.$option->colors->darkbg.'" id="darkbg" name="colors[darkbg]" class="form-control" data-coloris>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="scrollbar" class="form-label mb-3">'.e('Scrollbar Color').'</label><br>
                                            <input type="text" value="'.$option->colors->scrollbar.'" id="scrollbar" name="colors[scrollbar]" class="form-control" data-coloris>
                                        </div>
                                        <button class="btn btn-primary">'.e('Save Settings').'</button>
                                    </div>
                                </div>
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="form-group mb-4">
                                            <label for="style" class="form-label fw-bold mb-3">'.e('Pricing Style').'</label><br>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="pricing" value="list" class="me-2" autocomplete="off" '.(!$option->pricing || $option->pricing == 'list' ? 'checked' : '').'> '.e('List').'
                                            </label>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="pricing" value="table" class="me-2" autocomplete="off" '.($option->pricing == 'table' ? 'checked' : '').'> '.e('Table').'
                                            </label>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="pricing" value="categorized" class="me-2" autocomplete="off" '.($option->pricing == 'categorized' ? 'checked' : '').'> '.e('Categorized').' <span class="badge bg-success text-white">New</span>
                                            </label>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="style" class="form-label fw-bold mb-3">'.e('Blog Style').'</label><br>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="blog" value="list" class="me-2" autocomplete="off" '.(!$option->blog || $option->blog == 'list' ? 'checked' : '').'> '.e('List').'
                                            </label>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="blog" value="grid" class="me-2" autocomplete="off" '.($option->blog == 'grid' ? 'checked' : '').'> '.e('Grid').'
                                            </label>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="style" class="form-label fw-bold mb-3">'.e('Language Selector').'</label><br>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="languageselector" value="bottom" class="me-2" autocomplete="off" '.(!$option->languageselector || $option->languageselector == 'bottom' ? 'checked' : '').'> '.e('Bottom').'
                                            </label>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="languageselector" value="top" class="me-2" autocomplete="off" '.($option->languageselector == 'top' ? 'checked' : '').'> '.e('Top & Bottom').'
                                            </label>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="menu" class="form-label fw-bold mb-3">'.e('Menu type').'</label><br>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="menutype" value="hybrid" class="me-2" autocomplete="off" '.(!$option->menutype || $option->menutype == 'hybrid' ? 'checked' : '').'> '.e('Dynamic').'<br><small>'.e('Menu stays on top until you scroll down then it follows').'</small>
                                            </label>
                                            <label class="btn border rounded text-dark px-5 py-4">
                                                <input type="radio" name="menutype" value="top" class="me-2" autocomplete="off" '.($option->menutype == 'top' ? 'checked' : '').'> '.e('Static').'<br><small>'.e('Menu always stays on top').'</small>
                                            </label>
                                        </div>
                                        <button class="btn btn-primary">'.e('Save Settings').'</button>
                                    </div>
                                </div>
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="form-group mt-3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <label for="hero" class="form-label fw-bold">'.e('Custom Home Page Image').'</label>
                                                </div>
                                                <div class="ms-auto">
                                                    '.(!empty($option->hero) ? '<p class="form-text"><a href="#" id="remove_logo" data-trigger="removeimage" class="btn btn-danger btn-sm">'.e('Remove').'</a></p>':"").'
                                                </div>
                                            </div>
                                            '.(!empty($option->hero) ? '<img src="'.uploads($option->hero).'" class="img-fluid mb-2 rounded" style="max-height: 200px">' : '').'
                                            <input type="file" class="form-control" name="hero" id="hero" value="'.$option->hero.'">
                                            <p class="form-text">'.e('This will replace the default hero image that comes shipped with the script. JPG or PNG. 500 kb max. Recommended size: 560x710').'</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="homeheader" class="form-label fw-bold">'.e('Home Main Header').'</label>
                                            <input type="text" class="form-control p-2" name="homeheader" id="homeheader" value="'.htmlentities($option->homeheader).'">
                                            <p class="form-text">'.e('This will replace the home main header right before the shortener form. If you leave it empty, the site title will be shown.').'</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="homedescription" class="form-label fw-bold">'.e('Home Main Description').'</label>
                                            <textarea class="form-control" name="homedescription" id="homedescription">'.$option->homedescription.'</textarea>
                                            <p class="form-text">'.e('This will replace the home main description right before the shortener form. If you leave it empty, the site description will be shown.').'</p>
                                        </div>
                                        <div class="form-group mt-4">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <label for="siteimage" class="form-label fw-bold">'.e('Default Site Image').'</label>
                                                </div>
                                                <div class="ms-auto">
                                                '.(!empty($option->siteimage) ? '<p class="form-text"><a href="#" id="remove_siteimage" data-trigger="removeimage" class="btn btn-danger btn-sm">'.e('Remove').'</a></p>':"").'
                                                </div>
                                            </div>
                                            '.(!empty($option->siteimage) ? '<img src="'.uploads($option->siteimage).'" class="img-fluid mb-2 rounded" style="max-width: 200px">' : '').'
                                            <input type="file" class="form-control" name="siteimage" id="siteimage" value="'.$option->siteimage.'">
                                            <p class="form-text">'.e('This will be used as default OG image unless override by pages.').'</p>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="homelinks" class="form-label fw-bold">Menu Links</label>
                                            <textarea class="form-control" name="homelinks" id="homelinks" rows="5" placeholder="e.g. Google|https://google.com">'.$option->homelinks.'</textarea>
                                            <p class="form-text">'.e('You can add custom links to the menu using the following format (one per line): TITLE|LINK').'</p>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="customfooter" class="form-label fw-bold">'.e('Custom Footer').'</label>
                                            <textarea class="form-control" name="customfooter" id="customfooter" rows="5">'.$option->customfooter.'</textarea>
                                            <p class="form-text">'.e('You can add custom footer to the page. This will be shown at the bottom of the page.').'</p>
                                        </div>
                                        '.csrf().'
                                        <button class="btn btn-primary">'.e('Save Settings').'</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm">
                                <div class="card-header fw-bold">Help</div>
                                <div class="card-body">
                                    <p><strong>HTML Usage</strong></p>
                                    <p>You can use the following HTML elements: '.htmlentities("<b> <i> <s> <u> <strong> <span> <p> <br>").'</p>

                                    <p><strong>Translating Strings</strong></p>
                                    <p>If you add a new title or a new description, you can still translate them to any language by simply adding it via the language manager.</p>

                                    <p><strong>Auto Mode</strong></p>
                                    <p>If you choose the Auto Mode, the color scheme will change based on the user browser or device preference.

                                    <p><strong>Home Header</strong></p>
                                    <p>You can add your custom header and description for the homepage. To use the typing animation use the following format:</p>
                                    <code>&lt;span class="gradient-primary clip-text" data-toggle="typed" data-list="Links,Bio Pages, QR Codes"&gt;&lt;/span&gt;</code>
                                </div>
                            </div>
                            <div class="card shadow-sm">
                                <div class="card-header fw-bold">Menu Link</div>
                                <div class="card-body">
                                    <p>You can add custom links to the menu using the following format (one per line): TITLE|LINK</p>

                                    <p><strong>Example</strong></p>
                                    <pre>Support|https://support.gempixel.com<br>Blog|https://gempixel.com/blog</pre>

                                    <p>You can add as much as you want however you need to make sure it does not break the template</p>
                                </div>
                            </div>
                        </div>
                    </div>';
        return $content;
    }
    /**
     * Update
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function update(){

        \Gem::addMiddleware('DemoProtect');

        $option = config("theme_config");

        $request = new \Core\Request;

        $data = [];

        $data['hero'] = $option->hero ?? '';
        $data['siteimage'] = $option->siteimage ?? '';
        $data['homeheader'] = Helper::clean($request->homeheader);
        $data['homedescription'] = $request->homedescription;
        $data['customfooter'] = $request->customfooter;
        $data['homestyle'] = Helper::clean($request->homestyle, 3);
        $data['homelinks'] = Helper::clean($request->homelinks, 3);
        $data['homecolor'] = Helper::clean($request->homecolor, 3);
        $data['pricing'] = Helper::clean($request->pricing, 3);
        $data['languageselector'] = Helper::clean($request->languageselector, 3);
        $data['menutype'] = Helper::clean($request->menutype, 3);
        $data['blog'] = Helper::clean($request->blog, 3);

        $data['colors'] = [
            'primary' => '#0088ff',
            'primaryalt' => '#0065bd',
            'secondary' => '#22cfff',
            'primarybg' => '#f7f9fc',
            'darkbg' => '#030122',
            'scrollbar' => '#0088ff'
        ];

        foreach($request->colors as $name => $color){
            if(strlen(trim($color)) == 7) $data['colors'][$name] = trim(clean($color));
        }

        if($request->remove_logo){
            if(isset($option->hero) && !empty($option->hero) && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$option->hero)){
				unlink(appConfig('app.storage')['uploads']['path'].'/'.$option->hero);
			}
            $data['hero'] = null;
        }

        if($image = $request->file('hero')){

            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('The custom image is not valid. Only a JPG or PNG are accepted.'));

            if($image->sizekb > 500) return Helper::redirect()->back()->with('danger', e('Custom image must be either a PNG or a JPEG (Max 500kb).'));

            $filename = Helper::rand(6)."_hero_".$image->name;

            if(isset($option->hero) && !empty($option->hero) && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$option->hero)){
				unlink(appConfig('app.storage')['uploads']['path'].'/'.$option->hero);
			}

            $request->move($image, appConfig('app.storage')['uploads']['path'], $filename);
            $data['hero'] = $filename;

        }

        if($request->remove_siteimage){
            if(isset($option->siteimage) && !empty($option->siteimage) && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$option->siteimage)){
				unlink(appConfig('app.storage')['uploads']['path'].'/'.$option->siteimage);
			}
            $data['siteimage'] = null;
        }

        if($image = $request->file('siteimage')){

            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('The custom image is not valid. Only a JPG or PNG are accepted.'));

            if($image->sizekb > 500) return Helper::redirect()->back()->with('danger', e('Custom image must be either a PNG or a JPEG (Max 500kb).'));

            $filename = Helper::rand(6)."_siteimage_".$image->name;

            if(isset($option->siteimage) && !empty($option->siteimage) && file_exists(appConfig('app.storage')['uploads']['path'].'/'.$option->siteimage)){
				unlink(appConfig('app.storage')['uploads']['path'].'/'.$option->siteimage);
			}

            $request->move($image, appConfig('app.storage')['uploads']['path'], $filename);
            $data['siteimage'] = $filename;

        }

        if($request->homestyle == "darkmode"){
            $request->cookie('darkmode', 1);
        } else {
            $request->cookie('darkmode', 1, -3600);
        }

        $setting = DB::settings()->where('config', 'theme_config')->first();

        $setting->var = json_encode($data);
        $setting->save();

        self::cssVariables($data['colors']);

        return Helper::redirect()->back()->with('success', e('Settings are successfully saved.'));
    }
    /**
     * Generate CSS variables
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param array $variables
     * @return void
     */
    private static function cssVariables(array $variables){

        $variables['primarybgrgb'] = implode(', ', sscanf($variables['primarybg'], "#%02x%02x%02x"));
        $variables['darkbgrgb'] = implode(', ', sscanf($variables['darkbg'], "#%02x%02x%02x"));

        $data = ":root{--body: #fff;--body-color: #343f52;--hamburger-color: #343f52;--bs-primary: {$variables['primary']};--bs-primary-alt: {$variables['primaryalt']};--bs-secondary: {$variables['secondary']};--bg-primary: {$variables['primarybg']};--bg-secondary: #fff;--bs-primary-rgb: {$variables['primarybgrgb']};--scrollbar-color: {$variables['scrollbar']};--bg-header: #fff;--bs-link-color: var(--bs-primary);--bs-link-hover-color: var(--bs-primary-alt);--bs-dark-rgb:{$variables['darkbgrgb']};}";

        file_put_contents(PUB.'/content/variables.css', $data);
    }
    /**
     * Theme Config
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.3
     * @param string $name
     * @return void
     */
    public static function config(string $name, $is = null, $set = null, $default = null){

        $config = config("theme_config");

        if($name == 'title'){
            return (isset($config->homeheader) && $config->homeheader ? e($config->homeheader) :  config('title'));
        }

        if($name == 'description'){
            return (isset($config->homedescription) && $config->homedescription ? e($config->homedescription) : e(config('description')));
        }

        if($name == 'homecolor'){
            if(isset($config->homecolor) && $config->homecolor->type == 'custom' && $config->homestyle != 'darkmode' && !request()->cookie('darkmode')){
                return 'style="background: linear-gradient(220.55deg, '.$config->homecolor->c2.' 0%, '.$config->homecolor->c1.' 100%) !important;"';
            }
            return null;
        }

        if($name == "homestyle") {

            if(!isset($config->homestyle)) return $default;

            if( $config->homestyle == $is && !request()->cookie('darkmode') && $set) return $set;

            if( $config->homestyle == $is) return true;

            return $default;
        }

        if($name == "pricing") {
            if(isset($config->pricing)){
                if($config->pricing == $is) return $set;
                return $config->pricing;
            }
            return 'list';
        }

        if($is) return isset($config->{$name}) && $config->{$name} == $is;

        return $config->{$name} ?? null;
    }
    /**
     * Is Dark Mode or Dark Theme
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.6
     * @param [type] $return
     * @return boolean
     */
    public static function isDark($return = null){

        $config = config("theme_config");

        $isdark = request()->cookie('darkmode') || (isset($config->homestyle) && $config->homestyle == 'darkmode');

        return $return && $isdark ? $return : $isdark;
    }
}