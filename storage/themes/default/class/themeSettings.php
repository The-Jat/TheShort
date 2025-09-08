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
        if(!isset($option->homelinks)) $option->homelinks = "";
        if(!isset($option->homestyle)) $option->homestyle = "dark";
        if(!isset($option->languageselector)) $option->languageselector = "bottom";
        if(!isset($option->homecolor)) {
            $option->homecolor = new \stdClass;
            $option->homecolor->type = 'default';
            $option->homecolor->c1 = '#DD7BFF';
            $option->homecolor->c2 = '#FF6C6C';
        }
        if(!isset($option->pricing)) $option->pricing = "list";
                     
        \Helpers\CDN::load('simpleeditor');

        \Core\View::push("<script>
                            $('#homedescription').summernote({
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear'],
                                  ],
                                  height: 100 
                            });
                        </script>", "custom")->toFooter();  

        
        \Helpers\CDN::load("spectrum");
		
        \Core\View::push('<script type="text/javascript">																			    						    				    
                        $("#c1").spectrum({
                            color: "'.(isset($option->homecolor->c1) ? $option->homecolor->c1 : '#DD7BFF').'",
                            showInput: true,
                            preferredFormat: "hex"
                        });	
                        $("#c2").spectrum({
                            color: "'.(isset($option->homecolor->c1) ? $option->homecolor->c2 : '#FF6C6C').'",
                            showInput: true,
                            preferredFormat: "hex"
                        });
                    </script>', 'custom')->tofooter(); 

        $content = '<div class="row">
                        <div class="col-md-8">
                            <div class="card card-default">
                                <div class="card-body">
                                    <form action="'.route("admin.themes.update").'" method="post" enctype="multipart/form-data" id="setting-form">
                                        <div class="form-group">
                                            <label for="style" class="form-label fw-bold mb-3">Theme Scheme</label><br>
                                            <label class="btn btn-dark text-light px-3 py-4">
                                                <input type="radio" name="homestyle" value="darkmode" class="me-2" autocomplete="off" '.($option->homestyle == 'darkmode' ? 'checked' : '').'> Dark Theme
                                            </label>
                                            <label class="btn btn-primary text-light px-3 py-4">
                                                <input type="radio" name="homestyle" value="dark" class="me-2" autocomplete="off" '.($option->homestyle == 'dark' ? 'checked' : '').'> Default Theme
                                            </label>
                                            <label class="btn btn-light text-black border px-3 py-4">
                                                <input type="radio" name="homestyle" value="light" class="me-2" autocomplete="off" '.($option->homestyle == 'light' ? 'checked' : '').'> Light Theme
                                            </label>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="style" class="form-label fw-bold mb-4 d-block">Custom Background Color</label>
                                            <label>
                                                <input type="radio" name="homecolor[type]" value="default" class="me-2" autocomplete="off" '.(isset($option->homecolor->type) && $option->homecolor->type == 'default' ? 'checked' : '').'> Default
                                            </label>
                                            <label>
                                                <input type="radio" name="homecolor[type]" value="custom" class="ms-4 me-2" autocomplete="off" '.(isset($option->homecolor->type) && $option->homecolor->type ==  'custom' ? 'checked' : '').'> Custom                                        
                                            </label>
                                            <p class="form-text my-2">Use the default colors for the homepage and other pages background. If you want to set a single color, choose the same color for both otherwise you can create some cool gradients.</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold" for="c1">'.e("Color 1").'</label><br>
                                                    <input type="text" name="homecolor[c1]" id="c1" value="'.(isset($option->homecolor->c1) && $option->homecolor->c1 ? $option->homecolor->c1 : '#DD7BFF').'">
                                                </div>
                                            </div>	
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold" for="c2">'.e("Color 2").'</label><br>
                                                    <input type="text" name="homecolor[c2]" id="c2" value="'.(isset($option->homecolor->c2) && $option->homecolor->c2 ? $option->homecolor->c2 : '#FF6C6C').'">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group mb-4">
                                            <label for="style" class="form-label fw-bold mb-3">Pricing Style</label><br>                                            
                                            <label class="btn btn-light border rounded text-black px-5 py-4">
                                                <input type="radio" name="pricing" value="list" class="me-2" autocomplete="off" '.(!$option->pricing || $option->pricing == 'list' ? 'checked' : '').'> List
                                            </label>                                                                                        
                                            <label class="btn btn-light border rounded text-black px-5 py-4">
                                                <input type="radio" name="pricing" value="table" class="me-2" autocomplete="off" '.($option->pricing == 'table' ? 'checked' : '').'> Table
                                            </label>                                            
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="style" class="form-label fw-bold mb-3">'.e('Language Selector').'</label><br>
                                            <label class="btn btn-light border rounded text-dark px-5 py-4">
                                                <input type="radio" name="languageselector" value="bottom" class="me-2" autocomplete="off" '.(!$option->languageselector || $option->languageselector == 'bottom' ? 'checked' : '').'> '.e('Bottom').'
                                            </label>
                                            <label class="btn btn-light border rounded text-dark px-5 py-4">
                                                <input type="radio" name="languageselector" value="top" class="me-2" autocomplete="off" '.($option->languageselector == 'top' ? 'checked' : '').'> '.e('Top & Bottom').'
                                            </label>
                                        </div
                                        <hr>
                                        <div class="form-group mt-3">                                                                                        
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <label for="hero" class="form-label fw-bold">Custom Home Page Image</label>
                                                </div>
                                                <div class="ms-auto">                                                    
                                                    '.(!empty($option->hero) ? '<p class="form-text"><a href="#" id="remove_logo" data-trigger="removeimage" class="btn btn-danger btn-sm">'.e('Remove').'</a></p>':"").'
                                                </div>
                                            </div> 
                                            '.(!empty($option->hero) ? '<img src="'.uploads($option->hero).'" class="img-fluid mb-2 rounded" style="max-height: 200px">' : '').'
                                            <input type="file" class="form-control" name="hero" id="hero" value="'.$option->hero.'">
                                            <p class="form-text">This will replace the default hero image that comes shipped with the script. JPG or PNG. 500 kb max. Recommended size: 560x710</p>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="homeheader" class="form-label fw-bold">Home Main Header</label>
                                            <input type="text" class="form-control" name="homeheader" id="homeheader" value="'.$option->homeheader.'">
                                            <p class="form-text">This will replace the home main header right before the shortener form. If you leave it empty, the site title will be shown.</p>
                                        </div>	
                                        <div class="form-group">
                                            <label for="homedescription" class="form-label fw-bold">Home Main Description</label>
                                            <textarea class="form-control" name="homedescription" id="homedescription">'.$option->homedescription.'</textarea>
                                            <p class="form-text">This will replace the home main description right before the shortener form. If you leave it empty, the site description will be shown.</p>
                                        </div>
                                        <div class="form-group mt-4">                                           
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <label for="siteimage" class="form-label fw-bold">Default Site Image</label>
                                                </div>
                                                <div class="ms-auto">                                                    
                                                '.(!empty($option->siteimage) ? '<p class="form-text"><a href="#" id="remove_siteimage" data-trigger="removeimage" class="btn btn-danger btn-sm">'.e('Remove').'</a></p>':"").'
                                                </div>
                                            </div>               
                                            '.(!empty($option->siteimage) ? '<img src="'.uploads($option->siteimage).'" class="img-fluid mb-2 rounded" style="max-width: 200px">' : '').'
                                            <input type="file" class="form-control" name="siteimage" id="siteimage" value="'.$option->siteimage.'">
                                            <p class="form-text">This will be used as default OG image unless overrided by pages.</p>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="homelinks" class="form-label fw-bold">Menu Links</label>
                                            <textarea class="form-control" name="homelinks" id="homelinks" rows="5" placeholder="e.g. Google|https://google.com">'.$option->homelinks.'</textarea>
                                            <p class="form-text">You can add custom links to the menu using the following format (one per line): TITLE|LINK</p>
                                        </div>
                                        '.csrf().'
                                        <button class="btn btn-primary rounded-3 px-3 py-2">Save Settings</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-default">
                                <div class="card-header fw-bold">Help</div>
                                <div class="card-body">	
                                    <p><strong>HTML Usage</strong></p>
                                    <p>You can use the following HTML elements: '.htmlentities("<b> <i> <s> <u> <strong> <span> <p> <br>").'</p>

                                    <p><strong>Translating Strings</strong></p>
                                    <p>If you add a new title or a new description, you can still translate them to any language by simply adding it via the language manager.</p>
                                </div>
                            </div>
                            <div class="card card-default">
                                <div class="card-header fw-bold">Custom Background Color</div>
                                <div class="card-body">	
                                    <p>You can now create your own background color for the homepage and some other pages. You can either choose a single color and a cool gradient using the color selector. You can play with the Scheme and Color to create your unique theme. For example if your background is too bright, choose the "Light Theme" scheme to change the text to dark.</p>

                                    <p><strong>Note</strong> The custom background does not apply to the Dark Theme/Dark Mode.</p>

                                    <p><strong>Need gradient ideas?</strong> <a href="https://uigradients.com" rel="nofollow" target="blank">Check here</a></p>
                                </div>
                            </div>
                            <div class="card card-default">
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
        $data['homestyle'] = Helper::clean($request->homestyle, 3);
        $data['homelinks'] = Helper::clean($request->homelinks, 3);
        $data['homecolor'] = Helper::clean($request->homecolor, 3);
        $data['pricing'] = Helper::clean($request->pricing, 3);
        $data['languageselector'] = Helper::clean($request->languageselector, 3);

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
        return Helper::redirect()->back()->with('success', e('Settings are successfully saved.'));
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

            if( $config->homestyle == $is && !request()->cookie('darkmode')) return $set;

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