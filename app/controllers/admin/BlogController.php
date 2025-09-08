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
use Core\Auth;
Use Helpers\CDN;

class Blog {
    /**
     * Blog posts
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('blog.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view blog posts.'));
        }

        $posts = [];
        
        foreach(DB::posts()->orderByDesc('date')->paginate(15) as $post){
            
            $post->categoryname = null;

            if($post->categoryid && $category = DB::postcategories()->first($post->categoryid)){
                $post->categoryname = $category->name;
            }
            $posts[] = $post;
        }

        View::set('title', e('Posts'));

        return View::with('admin.blog.index', compact('posts'))->extend('admin.layouts.main');
    }
    /**
     * Add Post
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @return void
     */
    public function new(){
        if(!user()->hasRolePermission('blog.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create blog posts.'));
        }

        View::set('title', e('New Post'));

        CDN::load('editor');
                  
        View::push("<script>            
                ClassicEditor.create(document.querySelector('#editor'), editorConfig);
            </script>", "custom")->toFooter();   

        $categories = DB::postcategories()->orderByAsc('name')->find();

        $langs[] = ['code' => 'en', 'name' => 'English'];
        if($list = \Core\Localization::listInfo()){
            $langs = array_merge($langs, $list);
        }

        CDN::load('datetimepicker');

        return View::with('admin.blog.new', compact('langs', 'categories'))->extend('admin.layouts.main');
    }
    /**
     * Save post
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8.2
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        if(!user()->hasRolePermission('blog.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create blog posts.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $request->save('title', clean($request->title));
        $request->save('content', $request->content);
        $request->save('meta_title', clean($request->meta_title));
        $request->save('meta_description', clean($request->meta_description));
        $request->save('date', clean($request->date));

        if(!$request->title || !$request->content) return Helper::redirect()->back()->with('danger', e('The title and the content are required.'));

        if($request->slug && DB::posts()->where('slug', $request->slug)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));

        $category = DB::postcategories()->first($request->category);

        $post = DB::posts()->create();
        $post->title = Helper::clean($request->title, 3, true);
        $post->slug = $request->slug ? Helper::slug($request->slug) : Helper::slug($post->title);
        $post->content = $request->content;        

        preg_match_all('~< *img[^>]*src *= *["\']?([^"\']*)~i', $request->content, $images);
        
        if(isset($images[1]) && is_array($images[1])){
            foreach($images[1] as $image){
                
                if(empty($image)) continue;
                [$type, $data] = explode(';base64,', $image);
                $type = str_replace('data:', '', $type);
                $ext = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg'];
                
                if($type  == 'image/png' || $type == 'image/jpeg'){
                    $name = $post->slug.'-'.Helper::rand(5).time().'.'.$ext[$type];
                    if(config('cdn')->enabled){
                        $cdn = \Helpers\CDN::factory()
                                    ->uploadRaw($name, base64_decode($data), $type);
                    } else {
                        file_put_contents(PUB.'/content/blog/'.$name, base64_decode($data));
                    }
                    $post->content = str_replace($image, uploads($name, 'blog'), $post->content);
                }
            }
        }
                
        $post->meta_title = Helper::clean($request->meta_title, 3, true);
        $post->meta_description = Helper::clean($request->meta_description, 3, true);
        $post->date = strtotime($request->date) && strtotime($request->date) > time() ? Helper::dtime($request->date) : Helper::dtime();
        $post->published = Helper::clean($request->published);
        $post->categoryid = Helper::clean($request->category);
        $post->lang = $category->lang;
        $post->userid = Auth::id();

        if($image = $request->file('image')){
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('The image is not valid. Only a JPG or PNG are accepted.'));
            $post->image = $image->name;
            $request->move($image, appConfig('app.storage')['blog']['path']);
        }

        $post->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.blog'))->with('success', e('Blog post has been added successfully'));
    }
    /**
     * Edit Post
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        if(!user()->hasRolePermission('blog.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit blog posts.'));
        }

        if(!$post = DB::posts()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Post does not exist.'));

        CDN::load('editor');
                  
        View::push("<script>            
                ClassicEditor.create(document.querySelector('#editor'), editorConfig);
            </script>", "custom")->toFooter();   

        View::set('title', e('Edit Post'));

        CDN::load('datetimepicker');

        $categories = DB::postcategories()->orderByAsc('name')->find();

        $langs[] = ['code' => 'en', 'name' => 'English'];
        if($list = \Core\Localization::listInfo()){
            $langs = array_merge($langs, $list);
        }        

        return View::with('admin.blog.edit', compact('post', 'langs', 'categories'))->extend('admin.layouts.main');
    }
    /**
     * Update Post
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8.2
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        if(!user()->hasRolePermission('blog.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit blog posts.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$post = DB::posts()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Post does not exist.'));

        if(!$request->title || !$request->content) return Helper::redirect()->back()->with('danger', e('The title and the content are required.'));

        if($request->slug && DB::posts()->where('slug', $request->slug)->whereNotEqual('id', $post->id)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));
        
        $category = DB::postcategories()->first($request->category);

        $post->title = Helper::clean($request->title, 3, true);
        $post->slug =  Helper::slug(Helper::clean($request->slug));
        $post->content = $request->content;

        preg_match_all('~< *img[^>]*src *= *["\']?([^"\']*)~i', $request->content, $images);
        
        if(isset($images[1]) && is_array($images[1])){
            foreach($images[1] as $image){
                
                if(empty($image)) continue;
                [$type, $data] = explode(';base64,', $image);
                $type = str_replace('data:', '', $type);
                $ext = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg'];
                
                if($type  == 'image/png' || $type == 'image/jpeg'){
                    $name = $post->slug.'-'.Helper::rand(5).time().'.'.$ext[$type];
                    if(config('cdn')->enabled){
                        $cdn = \Helpers\CDN::factory()
                                    ->uploadRaw('content/blog/'.$name, base64_decode($data), $type);
                    } else {
                        file_put_contents(PUB.'/content/blog/'.$name, base64_decode($data));
                    }
                    $post->content = str_replace($image, uploads($name, 'blog'), $post->content);
                }
            }
        }
        
        $post->meta_title = Helper::clean($request->meta_title, 3, true);
        $post->meta_description = Helper::clean($request->meta_description, 3, true);
        $post->date = !$request->date ? Helper::dtime() : Helper::dtime($request->date);
        $post->published = Helper::clean($request->published);
        $post->categoryid = Helper::clean($request->category);
        $post->lang = $category->lang;
        $post->userid = Auth::id();

        if($image = $request->file('image')){
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) return Helper::redirect()->back()->with('danger', e('The image is not valid. Only a JPG or PNG are accepted.'));
            
            if($post->image) \Helpers\App::delete(appConfig('app.storage')['blog']['path'].'/'.$post->image);

            $post->image = $image->name;
            $request->move($image, appConfig('app.storage')['blog']['path']);
        }

        $post->save();

        return Helper::redirect()->back()->with('success', e('Blog post has been update successfully'));
    }
    /**
     * Delete Post
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        if(!user()->hasRolePermission('blog.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete blog posts.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'blog.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$post = DB::posts()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Blog post not found. Please try again.'));
        }

        if($post->image) \Helpers\App::delete(PUB."/content/blog/{$post->image}");
        $post->delete();
        return Helper::redirect()->back()->with('success', e('Post has been deleted.'));
    }
    /**
     * Categories
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public function categories(){
        if(!user()->hasRolePermission('blog.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view blog categories.'));
        }

        View::set('title', e('Blog Categories'));

        View::push(assets('frontend/libs/fontawesome-picker/dist/css/fontawesome-iconpicker.min.css'))->toHeader();
        View::push(assets('frontend/libs/fontawesome-picker/dist/js/fontawesome-iconpicker.min.js'), 'script')->toFooter();
        View::push(assets('frontend/libs/fontawesome/all.min.css'))->toHeader();

        View::push("<script>
                        $('input[name=icon]').iconpicker();
                    </script>", "custom")->toFooter();

        $categories = DB::postcategories()->orderByDesc('id')->paginate(10);

        $langs[] = ['code' => 'en', 'name' => 'English'];
        if($list = \Core\Localization::listInfo()){
            array_push($langs, $list);
        }

        return View::with('admin.blog.categories', compact('categories', 'langs'))->extend('admin.layouts.main');
    }
    /**
     * Add category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @return void
     */
    public function categorySave(Request $request){
        if(!user()->hasRolePermission('blog.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create blog categories.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!$request->title) return Helper::redirect()->back()->with('danger', e('Category title is required.'));

        $slug = $request->slug ? Helper::slug($request->slug) : Helper::slug($request->title);

        if(DB::postcategories()->where('slug', $slug)->first()) return Helper::redirect()->back()->with('danger', e('Category already exists.'));

        $category = DB::postcategories()->create();
        $category->name = Helper::RequestClean($request->title);
        $category->slug = $slug;
        $category->description = Helper::RequestClean($request->description);
        $category->icon = Helper::RequestClean($request->icon);
        $category->lang = Helper::RequestClean($request->lang);
        $category->status = $request->status ?? 0;
        $category->created_at = Helper::dtime();
        $category->save();

        return Helper::redirect()->back()->with('success', e('Category has been added.'));
    }
    /**
     * Update category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function categoryUpdate(Request $request, int $id){
        if(!user()->hasRolePermission('blog.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit blog categories.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$category = DB::postcategories()->first($id)) return Helper::redirect()->back()->with('danger', e('Category does not exist.'));

        if(!$request->newtitle) return Helper::redirect()->back()->with('danger', e('Category title is required.'));

        $slug = $request->newslug ? Helper::slug($request->newslug) : Helper::slug($request->newtitle);

        $category->name = Helper::RequestClean($request->newtitle);
        $category->slug = $slug;
        $category->description = Helper::RequestClean($request->newdescription);
        $category->icon = Helper::RequestClean($request->icon);
        $category->lang = Helper::RequestClean($request->newlang);
        $category->status = $request->newstatus ?? 0;
        $category->save();

        return Helper::redirect()->back()->with('success', e('Category has been updated.'));
    }
    /**
     * Delete category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function categoryDelete(int $id, string $nonce){
        if(!user()->hasRolePermission('blog.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete blog categories.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'category.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$category = DB::postcategories()->first($id)) return Helper::redirect()->back()->with('danger', e('Category does not exist.'));

        DB::posts()->where('categoryid', $category->id)->update(['categoryid' => null]);

        $category->delete();

        return Helper::redirect()->back()->with('success', e('Category has been deleted.'));
    }
}