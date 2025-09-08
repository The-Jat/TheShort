<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact GemPixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com) 
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */
namespace User;

use Core\Request;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Models\User;
use Helpers\CDN;

class Splash {

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('splash') === false){
			return \Models\Plans::notAllowed();
		}
    }

    /**
     * List Splash Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public function index(Request $request){
        
        $count = DB::splash()->where('userid', Auth::user()->rID())->count();
        
        $total = Auth::user()->hasLimit('splash');
        
        $query = DB::splash()->where('userid', Auth::user()->rID())->orderByDesc('id');

        if($request->q){
            $query->whereLike('name', '%'.clean($request->q).'%');
        }

        if($total > 0 && $count >= $total) {
            $count = $total;
            $splashpages = $query->limit($total)->findMany();
        } else {
            $splashpages = $query->paginate(12);
        }

        View::set('title', e('Custom Splash Pages'));

        return View::with('splash.index', compact('splashpages', 'count', 'total'))->extend('layouts.dashboard');

    }

    /**
     * Create Splash Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function create(Request $request){
        
        if(Auth::user()->teamPermission('splash.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        $count = DB::splash()->where('userid', Auth::user()->rID())->count();
        $total = Auth::user()->hasLimit('splash');

        $request->clear();

        \Models\Plans::checkLimit($count, $total);

        View::set('title', e('Create a Custom Splash'));

        CDN::load('simpleeditor');
        CDN::load('cropper');
        View::push("<script> $('#message').summernote({
            toolbar: [
              ['style', ['bold', 'italic', 'underline', 'clear']]
            ],
            height: 150
        });</script>", 'custom')->toFooter();

        return View::with('splash.create', compact('count', 'total'))->extend('layouts.dashboard');
    }

    /**
     * Save Splash Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.9.3
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        
        if(Auth::user()->teamPermission('splash.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        
        $request->save('name', clean($request->name));
        $request->save('title', clean($request->title));
        $request->save('counter', clean($request->counter));
        $request->save('message', $request->message);
        $request->save('product', clean($request->product));

        if(!$request->name || !$request->message || !$request->title || !$request->name) return back()->with("danger", e("The name, title, message and link cannot be empty."));            

        if(!$request->validate($request->product, 'url')) return back()->with("danger", e("Please enter a valid URL."));

        if($request->counter && !$request->validate($request->counter, 'int')) return back()->with("danger", e("Please enter a valid counter time in seconds."));    

        $array = [
            "title" => clean(Helper::truncate($request->title, 50)),
            "message" => Helper::clean(Helper::truncate($request->message, 300), 3, false, '<b><strong><i><u>'),
            "product" => clean($request->product),
            "counter" => clean($request->counter),
            "avatar" => '',
            "banner" => ''
        ];
        
        $appConfig = appConfig('app');
        $sizes = config('sizes');
        $extensions = config('extensions');

        if(!$image = $request->file('avatar')) return Helper::redirect()->back()->with('danger', e('Avatar must be one the following formats {f} and be less than {s}kb.', null, ['f' => $extensions->splash->avatar, 's' => $sizes->splash->avatar]));
			
        if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->splash->avatar))) return Helper::redirect()->back()->with('danger', e('Avatar must be the one following formats {f} and be less than {s}kb.', null, ['f' => $extensions->splash->avatar, 's' => $sizes->splash->avatar]));

        if($image->sizekb >= $sizes->splash->avatar) return back()->with("danger", e('Avatar must be the one following formats {f} and be less than {s}kb.', null, ['f' => $extensions->splash->avatar, 's' => $sizes->splash->avatar]));

        [$width, $height] = getimagesize($image->location);
        
        if(($width > 1000 || $height > 1000)) {
            if(!\Helpers\App::resizeTmp($image->location, $image->ext, 200)) return back()->with("danger", e("Image cannot be processed. Please select another image."));
        }

        $directory =  $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d');

        if(!file_exists($directory)){
            mkdir($directory, 0775);

            $f = fopen($directory.'/index.html', 'w');
            fwrite($f, '');
            fclose($f);
        }

        $filename = "customsplash_avatar_".Helper::rand(6).str_replace(' ', '-', $image->name);

        $request->move($image, $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d'), $filename);

        $array['avatar'] = "images/".date('Y-m-d')."/".$filename;    

        if(!$image = $request->file('banner')) return Helper::redirect()->back()->with('danger', e("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => $extensions->splash->banner, 's' => $sizes->splash->banner]));
			
        if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->splash->banner))) return Helper::redirect()->back()->with('danger', e("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => $extensions->splash->banner, 's' => $sizes->splash->banner]));

        if($image->sizekb >= $sizes->splash->banner) return back()->with("danger", e("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => $extensions->splash->banner, 's' => $sizes->splash->banner]));

        [$width, $height] = getimagesize($image->location);
        
        if($width < 980 || $width > 3000 || $height < 250 || $height > 1500) return back()->with("danger", e("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => $extensions->splash->banner, 's' => $sizes->splash->banner]));
        
        $filename = "customsplash_banner_".Helper::rand(6).str_replace(' ', '-', $image->name);

        if($width > 1200 && $height > 600) {
            if(!\Helpers\App::resizeTmp($image->location, $image->ext, 1200)) return back()->with("danger", e("Image cannot be processed.Please select another image."));
        }

        $request->move($image, $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d'), $filename);

        $array['banner'] = "images/".date('Y-m-d')."/".$filename;
    
        $splash = DB::splash()->create();

        $splash->name = clean($request->name);
        $splash->data = json_encode($array);
        $splash->userid = Auth::user()->rID();
        $splash->date = Helper::dtime();
        $splash->save();    
        $request->clear();
        return Helper::redirect()->to(route('splash'))->with('success', e('Custom splash page has been created.'));
    }

    /**
     * Edit Splash
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        if(Auth::user()->teamPermission('splash.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        if(!$splash = DB::splash()->where('id', $id)->where('userid',Auth::user()->rID())->first()){
            return back()->with('danger', e('Custom splash page does not exist.'));
        }

        $splash->data = json_decode($splash->data);

        CDN::load('simpleeditor');
        CDN::load('cropper');
        View::push("<script> $('#message').summernote({
            toolbar: [
              ['style', ['bold', 'italic', 'underline', 'clear']]
            ],
            height: 150
        });</script>", 'custom')->toFooter();

        View::set('title', e('Update a Custom Splash'));

        return View::with('splash.edit', compact('splash'))->extend('layouts.dashboard');
    }
    
    /**
     * Update Existing Splash
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        if(Auth::user()->teamPermission('splash.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        if(!$splash = DB::splash()->where('id', $id)->where('userid',Auth::user()->rID())->first()){
            return back()->with('danger', e('Custom splash page does not exist.'));
        }

        if(!$request->name || !$request->message || !$request->title || !$request->name) return back()->with("danger", e("The name, title, message and link cannot be empty."));            

        if(!$request->validate($request->product, 'url')) return back()->with("danger", e("Please enter a valid URL."));
        if($request->counter && !$request->validate($request->counter, 'int')) return back()->with("danger", e("Please enter a valid counter time in seconds."));
        
        $data = json_decode($splash->data);

        $array = [
            "title" => clean(Helper::truncate($request->title, 50)),
            "message" => Helper::clean(Helper::truncate($request->message, 300), 3, false, '<b><strong><i><u>'),
            "product" => clean($request->product),
            "counter" => clean($request->counter),
            "avatar" => $data->avatar,
            "banner" => $data->banner            
        ];
        
        $appConfig = appConfig('app');
        $sizes = config('sizes');
        $extensions = config('extensions');

        if($image = $request->file('avatar')){
			
			if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->splash->avatar))) return Helper::redirect()->back()->with('danger', e('Avatar must be the one following formats {f} and be less than {s}kb.', null, ['f' => $extensions->splash->avatar, 's' => $sizes->splash->avatar]));

            if($image->sizekb >= $sizes->splash->avatar) return back()->with("danger", e('Avatar must be the one following formats {f} and be less than {s}kb.', null, ['f' => $extensions->splash->avatar, 's' => $sizes->splash->avatar]));

            [$width, $height] = getimagesize($image->location);
            
            if(($width > 1000 || $height > 1000)) {
                \Helpers\App::resizeTmp($image->location, $image->ext, 200);  
            }
            
            $directory =  $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);

                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }
            
			$filename = "customsplash_avatar_".Helper::rand(6).str_replace(' ', '-', $image->name);
            
			$request->move($image, $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d'), $filename);
            
            $array['avatar'] = "images/".date('Y-m-d')."/".$filename;

            if($data->avatar && file_exists($appConfig['storage']['uploads']['path'].'/'.$data->avatar)) {
                \Helpers\App::delete($appConfig['storage']['uploads']['path'].'/'.$data->avatar);
            }
		}

        if($image = $request->file('banner')){
			
			if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->splash->banner))) return Helper::redirect()->back()->with('danger', e("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => $extensions->splash->banner, 's' => $sizes->splash->banner]));

            if($image->sizekb >= $sizes->splash->banner) return back()->with("danger", e("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => $extensions->splash->banner, 's' => $sizes->splash->banner]));

            [$width, $height] = getimagesize($image->location);
            
            if($width < 980 || $width > 3000 || $height < 250 || $height > 1500) return back()->with("danger", e("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => $extensions->splash->banner, 's' => $sizes->splash->banner]));
            
            $directory =  $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);

                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }
            
			$filename = "customsplash_banner_".Helper::rand(6).str_replace(' ', '-', $image->name);
			$request->move($image, $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d'), $filename);

            if($width > 1200 && $height > 600) {
                \Helpers\App::resize($appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d').'/'.$filename, $appConfig['storage']['uploads']['path'].'/images/'.date('Y-m-d').'/'.$filename, 1200);
            }

			$array['banner'] = "images/".date('Y-m-d')."/".$filename;
            
            if($data->banner && file_exists($appConfig['storage']['uploads']['path'].'/'.$data->banner)) {
                \Helpers\App::delete($appConfig['storage']['uploads']['path'].'/'.$data->banner);
            }
		}

        $splash->name = clean($request->name);
        $splash->data = json_encode($array);
        $splash->save();    
        return back()->with('success', e('Custom splash page has been updated.'));
    }

    /**
     * Delete Splash
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function delete(int $id){

        if(Auth::user()->teamPermission('splash.delete') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        if(!$splash = DB::splash()->where('id', $id)->where('userid',Auth::user()->rID())->first()){
            return back()->with('danger', e('Custom splash page does not exist.'));
        }

        $data = json_decode($splash->data);
    
        \Helpers\App::delete( appConfig('app.storage')['uploads']['path'].'/'.$data->avatar);        

        \Helpers\App::delete( appConfig('app.storage')['uploads']['path'].'/'.$data->banner);    

        DB::url()->where("type", "{$splash->id}")->update(['type' => null]);

        $splash->delete();
        
        return back()->with('success', e('Custom splash page has been deleted.'));
    }

}