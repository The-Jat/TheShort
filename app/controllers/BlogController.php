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

use Core\Request;
use Core\DB;
use Core\Helper;
use Core\Localization;
use Core\View;
use Core\Plugin;
use Models\User;

class Blog {
    /**
     * Constructor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     */
    public function __construct(){
        if(!config('blog')) stop(404);
    }
    /**
     * Blog Posts
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function index(){

        $posts = [];

        $categories = $this->categoryList();
        $menu = [];

        $i = 0;
        foreach($categories as $item){
            if($i > 3) {
                $menu['other'][$item->id] = $item;
            } else {
                $menu[$item->id] = $item;
            }
            $i++;            
        }

        foreach($this->getPosts()->orderByDesc('date')->paginate(6) as $post){

            $post->content = str_replace('{{--ad--}}', '', $post->content);

            if(strpos($post->content, '{{--more--}}') !== false){
                $post->content = Helper::readmore($post->content, '', null);
            } else {
                $post->content = Helper::readmore(Helper::truncate(strip_tags($post->content), 250), '', null);
            }
            $post->date = date('F d, Y', strtotime($post->date));

            if(!$author = User::where('id', $post->userid)->first()){
                $author = User::where('id', '1')->first();
            }
            $name = $author->name ?? ucfirst($author->username);
            $post->author = $name;
            $post->avatar = $author->avatar();
            $posts[] = $post;
        }

        $popular = $this->getPosts()->orderByDesc('views')->limit(10)->find();

        View::set('title', e('Blog'));
        View::set('description', e('Check out blog for tips & tricks'));

        // @group Plugin
        Plugin::dispatch('blog');

        return View::with('blog.index', compact('posts', 'categories', 'popular', 'menu'))->extend('layouts.main');
    }
    /**
     * Category Posts
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function category(string $slug){

        if(!$current = DB::postcategories()->where('status', '1')->where('slug', clean($slug))->first()) stop(404);

        $posts = [];

        $categories = $this->categoryList();

        $menu = [];

        $i = 0;
        foreach($categories as $item){
            if($i > 3) {
                $menu['other'][$item->id] = $item;
            } else {
                $menu[$item->id] = $item;
            }
            $i++;            
        }

        foreach($this->getPosts()->where('published', 1)->where('categoryid', $current->id)->orderByDesc('date')->paginate(6) as $post){

            $post->content = str_replace('{{--ad--}}', '', $post->content);

            if(strpos($post->content, '{{--more--}}') !== false){
                $post->content = Helper::readmore($post->content, '', null);
            } else {
                $post->content = Helper::readmore(Helper::truncate(strip_tags($post->content), 250), '', null);
            }
            $post->date = date('F d, Y', strtotime($post->date));

            if(!$author = User::where('id', $post->userid)->first()){
                $author = User::where('id', '1')->first();
            }
            $name = $author->name ?? ucfirst($author->username);
            $post->author = $name;
            $post->avatar = $author->avatar();
            $posts[] = $post;
        }

        $popular = $this->getPosts()->orderByDesc('views')->limit(10)->find();

        View::set('title', e('{c} Posts', null, ['c' => $current->name]));
        View::set('description', $current->description);

        // @group Plugin
        Plugin::dispatch('blog.category');

        return View::with('blog.categories', compact('posts', 'categories', 'popular', 'current', 'menu'))->extend('layouts.main');
    }
    /**
     * Search Blog
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param Request $request
     * @return void
     */
    public function search(Request $request){

        $locale = Localization::locale();

        $q = Helper::RequestClean($request->q);

        if(empty($q) || strlen($q) < 3){
            $articles = [];
        } else {
            $articles = DB::posts()->whereAnyIs([
                ['title' => "%{$q}%"],
                ['content' => "%{$q}%"],
            ], 'LIKE ')->where('lang', $locale)->orderByDesc('date')->paginate(9);
        }
        $posts = [];
        $categories = $this->categoryList();

        $menu = [];

        $i = 0;
        foreach($categories as $item){
            if($i > 3) {
                $menu['other'][$item->id] = $item;
            } else {
                $menu[$item->id] = $item;
            }
            $i++;            
        }

        foreach($articles as $post){

            $post->content = str_replace('{{--ad--}}', '', $post->content);

            if(strpos($post->content, '{{--more--}}') !== false){
                $post->content = Helper::readmore($post->content, '', null);
            } else {
                $post->content = Helper::readmore(Helper::truncate(strip_tags($post->content), 250), '', null);
            }
            $post->date = date('F d, Y', strtotime($post->date));

            if(!$author = User::where('id', $post->userid)->first()){
                $author = User::where('id', '1')->first();
            }
            $name = $author->name ?? ucfirst($author->username);
            $post->author = $name;
            $post->avatar = $author->avatar();
            $posts[] = $post;
        }

        $popular = $this->getPosts()->orderByDesc('views')->limit(10)->find();

        View::set('title', e('{c} Posts', null, ['c' => $q]));
        View::set('description', e('Check out blog for tips & tricks').': '.$q);

        // @group Plugin
        Plugin::dispatch('blog.search');

        return View::with('blog.search', compact('posts', 'categories', 'popular', 'q', 'menu'))->extend('layouts.main');
    }

    /**
     * Single Post
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.6
     * @return void
     */
    public function post(string $slug){

        if(!$post = DB::posts()->where('slug', Helper::RequestClean($slug, 3))->where("published", 1)->first()){
            stop(404);
        }

        $post->views++;
        $post->save();

        $post->content = str_replace(['<!--more-->', '&lt;!--more--&gt;', '{{--more--}}'], '', $post->content);

        View::set('title', $post->meta_title ? $post->meta_title : $post->title);
        View::set('description', $post->meta_description ? $post->meta_description : Helper::truncate(str_replace(['{{--ad--}}', "\n"],'', $post->content), 180));

        if(strpos($post->content, '{{--ad--}}')){
            $post->content = str_replace('{{--ad--}}', \Helpers\App::ads('resp', false), $post->content);
        }

        $post->content = str_replace('<img src', '<img class="img-fluid img-responsive" src', $post->content);


        $post->date = date('F d, Y', strtotime($post->date));
        if(!$author = User::where('id', $post->userid)->first()){
            $author = User::where('id', '1')->first();
        }
        $post->author = $author->name ?? ucfirst($author->username);
        $post->avatar = $author ? $author->avatar() : null;
        $name = $post->author;

        $query = DB::posts()->where('published', 1);

        if($post->categoryid){
            $query->where('categoryid', $post->categoryid);
        }

        $posts = $query->whereNotEqual('id', $post->id)->orderByDesc('date')->limit(3)->map(function($post) use ($name) {
            $post->content = Helper::readmore($post->content, '', null);
             $post->content = str_replace(['<!--more-->', '&lt;!--more--&gt;', '{{--more--}}', '{{--ad--}}'], '', $post->content);
            $post->date = date('F d, Y', strtotime($post->date));
            $post->author = $name;
            return $post;
        });

        $json = [
            "@context" => "https://schema.org",
            "@type" => "BlogPosting",
            "headline" => $post->title,
            "description" => Helper::truncate(strip_tags($post->content), 255),
            "datePublished" => Helper::dtime($post->date, DATE_ATOM),
            "url" => route('blog.post', [$slug]),
            "author" => [
                "@type" => "Person",
                "name" => $post->author
            ]
        ];

        if($post->image){
            View::set("image", uploads($post->image, 'blog'));
            $json['image'] = uploads($post->image, 'blog');
        }

        $category = DB::postcategories()->where('id', $post->categoryid)->first();

        View::push('<script type="application/ld+json">'.json_encode($json).'</script>', 'custom')->toFooter();

        View::push(assets('content-style.min.css'), 'css')->toHeader();

        // @group Plugin
        Plugin::dispatch('blog.single');

        return View::with('blog.single', compact('post', 'posts', 'category'))->extend('layouts.main');
    }
    /**
     * Category list
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    private function categoryList(){

        $locale = Localization::locale();

        $query = DB::postcategories()->where('status', '1');

        if($locale && $locale != 'en'){
            $query->where('lang', $locale);
        } else {
            $query->whereAnyIs([
                ['lang' => 'NULL'],
                ['lang' => 'en']
            ]);
        }

        $categories = [];

        foreach($query->find() as $item){
            if(DB::posts()->where('categoryid', $item->id)->count() == '0') continue;
            $categories[$item->id] = $item;
        }

        return $categories;
    }
    /**
     * Get Posts
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    private function getPosts(){

        $locale = Localization::locale();

        $query = DB::posts()->where('published', 1)->whereRaw("date <= '".Helper::dtime()."'");

        if($locale && $locale != 'en'){
            $query->where('lang', $locale);
        } else {
            $query->whereAnyIs([
                ['lang' => 'NULL'],
                ['lang' => 'en']
            ]);
        }

        return $query;
    }
}