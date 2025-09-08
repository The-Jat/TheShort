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

use Core\View;
use Core\File;
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\Localization;
use Core\DB;
use Core\Plugin;

class Sitemap {

	/**
	 * Track count
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.3
	 */
    protected $count = 0;

	/**
	 * Sitemap Index
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.5
	 * @return void
	 */
	public function index(){
		$config = appConfig('app.sitemap');

		if(isset($config['enabled']) && $config['enabled'] == false) return stop(404);
		
		header('Content-type: application/xml');

		echo '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.("\n\t").'<sitemap>'.("\n\t\t").'<loc>'.route('sitemap.site').'</loc>'.("\n\t").'</sitemap>'.("\n\t").'<sitemap>'.("\n\t\t").'<loc>'.route('sitemap.links').'</loc>'.("\n\t").'</sitemap>'.("\n\t").'<sitemap>'.("\n\t\t").'<loc>'.route('sitemap.bio').'</loc>'.("\n\t").'</sitemap>'.("\n").'</sitemapindex>';
	}
	/**
	 * Site Sitemap
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.5
	 * @return void
	 */
	public function site(){
		$time = microtime(true);

		$config = appConfig('app.sitemap');

		if(isset($config['enabled']) && $config['enabled'] == false) return stop(404);
            
        $this->setHeader();

		echo $this->url(route('home'), date("c", filemtime(View::$path."/index.php")), 1);

		echo $this->url(route('page.qr'), date("c", filemtime(View::$path."/pages/qr.php")), 1);
		echo $this->url(route('page.bio'), date("c", filemtime(View::$path."/pages/bio.php")), 1);
		if(config('pro') && config('affiliate')->enabled){
			echo $this->url(route('affiliate'), date("c", filemtime(View::$path."/pages/affiliate.php")), 1);
		}
		
		echo $this->url(route('pricing'), date("c", filemtime(View::$path."/pricing/index.php")), 1);

		foreach(\Core\Localization::listInfo() as $lang){
			echo $this->url(route('home', null, $lang['code']), date("c", filemtime(View::$path."/index.php")), 1);
		}

		foreach(DB::page()->findArray() as $page){
            echo $this->url(route('page', $page['seo'], $page['lang']),  date("c", strtotime($page['lastupdated'])), 0.6);
        }
		
		if(config('blog')){
			foreach(DB::posts()->where('published', 1)->findArray() as $post){
				echo $this->url(route('blog.post', $post['slug'], $post['lang']),  date("c", strtotime($post['date'])), 0.8);
			}
			foreach(DB::postcategories()->where('status', 1)->findArray() as $category){
				echo $this->url(route('blog.category', $category['slug'], $category['lang']),  date("c", strtotime($category['created_at'])), 0.8);
			}
			echo $this->url(route('blog'),  date("c", strtotime($post['date'] ?? date('Y-m-d'))), 0.8);
		}

        if(config('helpcenter')){
			foreach(DB::faqs()->findArray() as $post){
				echo $this->url(route('help.single', [$post['slug']]),  date("c", strtotime($post['created_at'])), 0.8);
			}

			foreach(config('faqcategories') as $id => $category){
				echo $this->url(route('help.category', [$id]),  date("c", strtotime($post['created_at'])), 0.8);
			}
			
			echo $this->url(route('help'),  date("c", strtotime($post['created_at'])));
		} 

		if(config('contact')){
			echo $this->url(route('contact'),  date("c", filemtime(View::$path."/pages/contact.php")));
		}
		
		if(config('report')){
			echo $this->url(route('report'),  date("c", filemtime(View::$path."/pages/report.php")));
		}        
        
		if(config('api')) {
        	echo $this->url(route('apidocs'),  date("c", filemtime(ROOT."/app/config/api.php")));
		}

		Plugin::dispatch('sitemap', $this);

		$this->setFooter($time);
	}
   /**
     * Generate sitemap
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5
     * @return void
     */
    public function links(){

		$time = microtime(true);

		$config = appConfig('app.sitemap');

		if(isset($config['enabled']) && $config['enabled'] == false) return stop(404);
            
        $this->setHeader();
		
		if(!isset($config['urls']) || (isset($config['urls']) && $config['urls'])){
			foreach(DB::url()->where('public', '1')->limit($config['numberoflinks'])->orderByDesc('date')->findArray() as $url){
				echo $this->url(\Helpers\App::shortRoute($url['domain'], urlencode($url['alias'].$url['custom'])),  date("c", strtotime($url['date'])), 0.5);
			}
		}

		Plugin::dispatch('sitemap.links', $this);

		$this->setFooter($time);
    }
	/**
	 * Bio Pages sitemap
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.5
	 * @return void
	 */
	public function bio(){

		$time = microtime(true);

		$config = appConfig('app.sitemap');

		if(isset($config['enabled']) && $config['enabled'] == false) return stop(404);
            
        $this->setHeader();
		
		if(isset($config['bio']) && $config['bio']){
			foreach(DB::profiles()->limit($config['numberofbio'])->orderByDesc('created_at')->findArray() as $bio){
				$url = DB::url()->where('id', $bio['urlid'])->first();
				echo $this->url(\Helpers\App::shortRoute($url->domain, urlencode($url->alias.$url->custom)),  date("c", strtotime($url->date)), 0.5);
			}
		}

		Plugin::dispatch('sitemap.bio', $this);

		$this->setFooter($time);
    }

    /**
	 * Set header
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 */
	protected function setHeader(){
		header('Content-type: application/xml');
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\nhttp://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";
	}
	/**
	 * Set footer
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 */
	protected function setFooter($time){
		echo "\n<!-- Generated {$this->count} urls in ".round((microtime(true) - $time), 3)." seconds-->\n</urlset>";
	}
	/**
	 * Generate URL
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $loc      [description]
	 * @param   [type] $lastmod  [description]
	 * @param   [type] $priority [description]
	 * @return  [type]           [description]
	 */
	public function url($loc, $lastmod, $priority = 1){
		$this->count++;
		$lastmod = date("c", strtotime($lastmod));
		return "\n\t<url>\n\t\t<loc>$loc</loc>\n\t\t<lastmod>$lastmod</lastmod>\n\t\t<priority>$priority</priority>\n\t</url>";
	}        
}