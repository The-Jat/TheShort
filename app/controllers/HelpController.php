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
use Core\Response;
use Core\DB;
use Core\Helper;
use Core\Localization;
use Core\View;
use Core\Email;
use Core\Auth;
use Core\Plugin;

class Help {
    /**
     * Constructor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     */
    public function __construct(){
        if(!config('helpcenter')) stop(404);
    }
    /**
     * Help center
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public function index(){

        $categories = [];

        $locale = Localization::locale();
        
        foreach(config('faqcategories') as $id => $category){
            $category->count = \Core\DB::faqs()->where('category', $id)->count();
            if($locale != 'en' && (!isset($category->lang) || $category->lang == 'en')) continue;
            if(isset($category->lang) && $category->lang != $locale) continue;
            if($category->count == 0) continue;
            $categories[$id] = $category;
        }

        $articles = DB::faqs()->where('lang', $locale)->orderByDesc('views')->limit(6)->find();

        View::set('title', e('Help Center'));
        View::set('description', e('Check out our help center'));

        // @group Plugin
        Plugin::dispatch('helpcenter');

        return View::with('help.index', compact('categories', 'articles'))->extend('layouts.main');
    }
    /**
     * Search
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public function search(Request $request){

        $locale = Localization::locale();
        
        $q = Helper::RequestClean($request->q);

        View::set('title', e('{t} - Help Center', null, ['t' => $q]));
        
        View::set('description', e('Check out our help center').': '.$q);

        if(empty($q) || strlen($q) < 3){
            $articles = [];
        } else {
            $articles = DB::faqs()->whereAnyIs([
                ['question' => "%{$q}%"],
                ['answer' => "%{$q}%"],
                ['category' => "%{$q}%"],
            ], 'LIKE ')->where('lang', $locale)->orderByDesc('created_at')->paginate(14);
        }

        $categories = config('faqcategories');
        
        Plugin::dispatch('helpcenter.search', [$q]);

        return View::with('help.search', compact('articles', 'categories', 'q'))->extend('layouts.main');
    }
    /**
     * Category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public function category(string $slug){

        $categories = config('faqcategories');

        if(!isset($categories->{$slug})) stop(404);

        $category = $categories->{$slug};

        View::set('title', e('{t} - Help Center', null, ['t' => $category->title]));

        View::set('description', e('Check out our help center').': '.$category->title);

        $articles = DB::faqs()->where('category', $slug)->orderByDesc('created_at')->paginate(14);

        Plugin::dispatch('helpcenter.category', [$category, $articles]);

        return View::with('help.category', compact('articles', 'category'))->extend('layouts.main');
    }
    /**
     * Single Article
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $slug
     * @return void
     */
    public function single(string $slug){

        $categories = config('faqcategories');

        if(!$article = DB::faqs()->where('slug', $slug)->orderByDesc('created_at')->first()) stop(404);

        $article->views++;
        $article->save();

        View::set('title', e('{t} - Help Center', null, ['t' => $article->question]));

        View::set('description', Helper::truncate($article->answer, 110));

        $category = $categories->{$article->category};

        Plugin::dispatch('helpcenter.single', [$category, $article]);
    
        View::push('<script type="application/ld+json">'.json_encode([
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => [
                "@type" => "Question",
                "name" => e($article->question),
                "acceptedAnswer" => [
                  "@type" => "Answer",
                  "text" => e($article->answer)
                ]             
            ]
        ]).'</script>', 'custom')->toFooter(); 

        View::push(assets('content-style.min.css'), 'css')->toHeader();

        $related = DB::faqs()->where('category', $article->category)->orderByDesc('created_at')->limit(5)->find();

        return View::with('help.single', compact('article', 'related', 'category'))->extend('layouts.main');
    }
}
