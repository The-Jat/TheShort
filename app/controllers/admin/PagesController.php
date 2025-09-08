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

class Pages {
    /**
     * Custom pages
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('pages.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view pages.'));
        }

        $pages = DB::page()->orderByDesc('id')->paginate(15);

        View::set('title', e('Pages'));

        return View::with('admin.pages.index', compact('pages'))->extend('admin.layouts.main');
    }
    /**
     * Add Page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @return void
     */
    public function new(){
        if(!user()->hasRolePermission('pages.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create pages.'));
        }

        View::set('title', e('New Page'));

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

        return View::with('admin.pages.new')->extend('admin.layouts.main');
    }
    /**
     * Save page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        if(!user()->hasRolePermission('pages.create')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to create pages.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $request->save('name', clean($request->name));
        $request->save('content', $request->content);

        if(!$request->name || !$request->content) return Helper::redirect()->back()->with('danger', e('The name and the content are required.'));

        $slug = $request->slug ? Helper::slug($request->slug) : Helper::slug($request->name);

        if(DB::page()->where('seo', $slug)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));

        $page = DB::page()->create();
        $page->name = Helper::clean($request->name, 3, true);
        $page->seo = $request->slug ? Helper::slug($request->slug) : Helper::slug($page->name);
        $page->content = $request->content;
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
                                    ->uploadRaw('content/'.$name, base64_decode($data), $type);
                    } else {
                        file_put_contents(PUB.'/content/'.$name, base64_decode($data));
                    }
                    $page->content = str_replace($image, uploads($name), $page->content);
                }
            }
        }

        $page->category = $request->category;
        $page->lang = $request->lang;
        $page->lastupdated = Helper::dtime();
        $page->menu = Helper::clean($request->menu);
        $page->metadata = json_encode(['title' => $request->metatitle, 'description' => $request->metadescription]);

        $page->save();
        $request->clear();
        return Helper::redirect()->to(route('admin.page'))->with('success', e('Custom page has been added successfully'));
    }
    /**
     * Edit Page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @param integer $id
     * @return void
     */
    public function edit(int $id){
        if(!user()->hasRolePermission('pages.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit pages.'));
        }

        if(!$page = DB::page()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Page does not exist.'));

        View::set('title', e('Edit Page'));

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

        if(!$page->metadata = json_decode($page->metadata ?? '')) $page->metadata = new \stdClass;
        $page->metadata->title = $page->metadata->title ?? '';
        $page->metadata->description = $page->metadata->description ?? '';

        return View::with('admin.pages.edit', compact('page'))->extend('admin.layouts.main');
    }
    /**
     * Update Page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){
        if(!user()->hasRolePermission('pages.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit pages.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$page = DB::page()->where('id', $id)->first()) return Helper::redirect()->back()->with('danger', e('Page does not exist.'));

        if(!$request->name || !$request->content) return Helper::redirect()->back()->with('danger', e('The name and the content are required.'));

        if($request->slug && DB::page()->where('seo', $request->slug)->whereNotEqual('id', $page->id)->first()) return Helper::redirect()->back()->with('danger', e('This slug is already taken, please use another one.'));

        $page->name = Helper::clean($request->name, 3, true);
        $page->seo = Helper::slug($request->slug);
        $page->content = $request->content;
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
                                    ->uploadRaw('content/'.$name, base64_decode($data), $type);
                    } else {
                        file_put_contents(PUB.'/content/'.$name, base64_decode($data));
                    }
                    $page->content = str_replace($image, uploads($name), $page->content);
                }
            }
        }
        $page->category = $request->category;
        $page->lang = $request->lang;
        $page->lastupdated = Helper::dtime();
        $page->menu = Helper::clean($request->menu);
        $page->metadata = json_encode(['title' => $request->metatitle, 'description' => $request->metadescription]);

        $page->save();

        return Helper::redirect()->back()->with('success', e('Custom page has been update successfully.'));
    }
    /**
     * Delete Page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(Request $request, int $id, string $nonce){
        if(!user()->hasRolePermission('pages.delete')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete pages.'));
        }

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'page.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$page = DB::page()->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Custom page not found. Please try again.'));
        }

        $page->delete();
        return Helper::redirect()->back()->with('success', e('Page has been deleted.'));
    }
}