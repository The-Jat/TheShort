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

namespace Admin;

use Core\DB;
use Core\View;
use Core\Request;
use Core\Helper;
Use Helpers\CDN;

class Faqs {
    /**
     * Help Center
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @return void
     */
    public function index(Request $request){

        if(!user()->hasRolePermission('faq.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view FAQs.'));
        }

        $query = DB::faqs()->orderByDesc('id');
        
        if($request->lang && strlen($request->lang) == '2') {
            $query->where('lang', clean($request->lang));
        }

        $faqs = [];

        foreach($query->paginate(15) as $item){
            $faqs[] = $item;
        }


        View::set('title', e('Help Center'));

        return View::with('admin.faq.index', compact('faqs'))->extend('admin.layouts.main');
    }
    /**
     * Add Article
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @return void
     */
    public function new(){

        if(!user()->hasRolePermission('faq.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create FAQs.'));
        }

        View::set('title', e('New Article'));

        CDN::load('editor');
        if(request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true)){
            View::push('<style>
                :root{
                    --ck-color-base-background: #222e3c !important;
                    --ck-color-base-border: #0c0d0e !important;    
                    --ck-color-base-text: #fff !important;                
                }
            </style>', 'custom')->toHeader();
        }       
        View::push("<script>            
            ClassicEditor.create(document.querySelector('#editor'), editorConfig);
        </script>", "custom")->toFooter();   

        return View::with('admin.faq.new')->extend('admin.layouts.main');
    }
    /**
     * Save page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){

        if(!user()->hasRolePermission('faq.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create FAQs.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $request->save('question', clean($request->question));
        $request->save('answer', $request->answer);

        if(!$request->question || !$request->answer) return Helper::redirect()->back()->with('danger', e('The question and the answer are required.'));

        if($request->slug && DB::faqs()->where('slug', $request->slug)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));

        $categories = config('faqcategories');

        $faq = DB::faqs()->create();
        $faq->question = Helper::clean($request->question, 3, true);
        $faq->slug = $request->slug ? $request->slug : Helper::slug($faq->question);
        $faq->answer = $request->answer;

        preg_match_all('~< *img[^>]*src *= *["\']?([^"\']*)~i', $request->answer, $images);

        if(isset($images[1]) && is_array($images[1])){
            foreach($images[1] as $image){

                if(empty($image)) continue;
                [$type, $data] = explode(';base64,', $image);
                $type = str_replace('data:', '', $type);
                $ext = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg'];

                if($type  == 'image/png' || $type == 'image/jpeg'){
                    $name = $faq->slug.'-'.Helper::rand(5).time().'.'.$ext[$type];
                    file_put_contents(PUB.'/content/images/'.$name, base64_decode($data));
                    $faq->answer = str_replace($image, uploads($name, 'images'), $faq->answer);
                }
            }
        }

        $faq->category = $request->category;
        $faq->pricing = is_numeric($request->pricing) ? $request->pricing : 0;
        $faq->created_at = Helper::dtime();

        if(isset($categories->{$request->category}->lang)) $faq->lang = $categories->{$request->category}->lang;

        $faq->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.faq'))->with('success', e('Article has been added successfully.'));
    }
    /**
     * Edit Article
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @param integer $id
     * @return void
     */
    public function edit(int $id){

        if(!user()->hasRolePermission('faq.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit FAQs.'));
        }

        if(!$faq = DB::faqs()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Article does not exist.'));

        View::set('title', e('Edit Article'));

        CDN::load('editor');
        if(request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true)){
            View::push('<style>
                :root{
                    --ck-color-base-background: #222e3c !important;
                    --ck-color-base-border: #0c0d0e !important;    
                    --ck-color-base-text: #fff !important;                
                }
            </style>', 'custom')->toHeader();
        }       
        View::push("<script>            
            ClassicEditor.create(document.querySelector('#editor'), editorConfig);
        </script>", "custom")->toFooter();   

        return View::with('admin.faq.edit', compact('faq'))->extend('admin.layouts.main');
    }
    /**
     * Update Article
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        if(!user()->hasRolePermission('faq.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit FAQs.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$faq = DB::faqs()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Article does not exist.'));

        if(!$request->question || !$request->answer) return Helper::redirect()->back()->with('danger', e('The name and the content are required.'));

        if($request->slug && DB::faqs()->where('slug', $request->slug)->whereNotEqual('id', $faq->id)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));

        $categories = config('faqcategories');

        $faq->question = Helper::clean($request->question, 3, true);
        $faq->slug = $request->slug;
        $faq->answer = $request->answer;

        preg_match_all('~< *img[^>]*src *= *["\']?([^"\']*)~i', $request->answer, $images);

        if(isset($images[1]) && is_array($images[1])){
            foreach($images[1] as $image){

                if(empty($image)) continue;
                
                if(strpos($image, 'data:image') === false) continue;

                [$type, $data] = explode(';base64,', $image);
                $type = str_replace('data:', '', $type);
                $ext = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg'];

                if($type  == 'image/png' || $type == 'image/jpeg'){
                    $name = $faq->slug.'-'.Helper::rand(5).time().'.'.$ext[$type];
                    file_put_contents(PUB.'/content/images/'.$name, base64_decode($data));
                    $faq->answer = str_replace($image, uploads($name, 'images'), $faq->answer);
                }
            }
        }

        $faq->category = $request->category;
        $faq->pricing = is_numeric($request->pricing) ? $request->pricing : 0;
        $faq->created_at = Helper::dtime();
        if(isset($categories->{$request->category}->lang)) $faq->lang = $categories->{$request->category}->lang;

        $faq->save();

        return Helper::redirect()->back()->with('success', e('Article has been update successfully.'));
    }
    /**
     * Delete Article
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){

        if(!user()->hasRolePermission('faq.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete FAQs.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'faq.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$faq = DB::faqs()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Article not found. Please try again.'));
        }

        $faq->delete();
        return Helper::redirect()->back()->with('success', e('Article has been deleted.'));
    }
    /**
     * Article Categories
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public function categories(){

        if(!user()->hasRolePermission('faq.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view FAQ categories.'));
        }

        $categories = [];

        View::set('title', e('Help Center Categories'));

        View::push(assets('frontend/libs/fontawesome-picker/dist/css/fontawesome-iconpicker.min.css'))->toHeader();
        View::push(assets('frontend/libs/fontawesome-picker/dist/js/fontawesome-iconpicker.min.js'), 'script')->toFooter();
        View::push(assets('frontend/libs/fontawesome/all.min.css'))->toHeader();

        View::push("<script>
                        $('input[name=icon]').iconpicker();
                        $('#iconstyle').change(function(){
                            if($(this).val() == 'emoji') {
                                $.iconpicker.batch('#icon', 'destroy');
                            }else {
                                $('#icon').iconpicker();
                            }
                        });
                        $('#newiconstyle').change(function(){
                            if($(this).val() == 'emoji') {
                                $.iconpicker.batch('#newicon', 'destroy');
                            }else {
                                $('#newicon').iconpicker();
                            }
                        });
                    </script>", "custom")->toFooter();

        foreach(config('faqcategories') as $id => $category){

            $icon = '';

            if(isset($category->icon) && !empty($category->icon)) {
                if(!isset($category->iconstyle) || (isset($category->iconstyle) && $category->iconstyle == 'icon')) {
                    $icon = '<i class="'.$category->icon.' me-1"></i>';
                } else {
                    $icon = $category->icon;
                }
            }
            $category->formattedicon = $icon;
            $categories[$id] = $category;
        }

        return View::with('admin.faq.categories', compact('categories'))->extend('admin.layouts.main');
    }
    /**
     * Add Category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @return void
     */
    public function categoriesSave(Request $request){

        if(!user()->hasRolePermission('faq.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create FAQ categories.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $categories = config('faqcategories');

        if(!$categories) $categories = [];

        if(!$request->title) return Helper::redirect()->back()->with('danger', e('Category title is required.'));

        if(isset($categories->{Helper::slug($request->title)})) return Helper::redirect()->back()->with('danger', e('Category already exists.'));

        $categories->{Helper::slug($request->title)} = ['title' => Helper::RequestClean($request->title), 'description' => Helper::RequestClean($request->description), 'icon' => Helper::RequestClean($request->icon), 'lang' => Helper::RequestClean($request->lang), 'iconstyle' => Helper::RequestClean($request->iconstyle)];

        $setting = DB::settings()->where('config', 'faqcategories')->first();

        $setting->var = json_encode($categories);
        $setting->save();
        return Helper::redirect()->back()->with('success', e('Category has been added.'));
    }
    /**
     * Update category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @param string $key
     * @return void
     */
    public function categoriesUpdate(Request $request, string $key){

        if(!user()->hasRolePermission('faq.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit FAQ categories.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $categories = config('faqcategories');

        if(!$categories) $categories = [];

        if(!$request->newtitle) return Helper::redirect()->back()->with('danger', e('Category title is required.'));

        if(!isset($categories->{$key})) return Helper::redirect()->back()->with('danger', e('Category does not exist.'));

        $categories->{$key} = ['title' => Helper::RequestClean($request->newtitle), 'description' => Helper::RequestClean($request->newdescription), 'icon' => Helper::RequestClean($request->icon), 'lang' => Helper::RequestClean($request->newlang), 'iconstyle' => Helper::RequestClean($request->newiconstyle)];

        $setting = DB::settings()->where('config', 'faqcategories')->first();

        $setting->var = json_encode($categories);
        $setting->save();
        return Helper::redirect()->back()->with('success', e('Category has been updated.'));
    }
    /**
     * Delete category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function categoriesDelete(Request $request, string $key, string $nonce){

        if(!user()->hasRolePermission('faq.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete FAQ categories.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'category.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        $categories = config('faqcategories');

        if(!isset($categories->{$key})){
            return Helper::redirect()->back()->with('danger', e('Category not found. Please try again.'));
        }

        unset($categories->{$key});

        $setting = DB::settings()->where('config', 'faqcategories')->first();

        $setting->var = json_encode($categories);
        $setting->save();

        return Helper::redirect()->back()->with('success', e('Category has been deleted.'));
    }
}