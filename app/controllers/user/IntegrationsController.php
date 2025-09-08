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

use Core\Helper;
use Core\View;
use Core\DB;
use Core\Auth;
use Core\Request;

class Integrations {

    /**
     * INtegrations
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public function index(Request $request, $provider = null){
        $integrations = $this->integrations();

		if(isset($integrations[$provider])){
            if(isset($integrations[$provider]['setup'][0]) && \method_exists($integrations[$provider]['setup'][0], $integrations[$provider]['setup'][1])) return call_user_func($integrations[$provider]['setup'], $request);
		}

        View::set('title', e('Integrations'));

        return View::with('integrations.index', compact('integrations'))->extend('layouts.dashboard');
    }
    /**
     * Integrations
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @param [type] $name
     * @return void
     */
    public function integrations($name = null){

        $user = Auth::user();

        $list = [			 			
            'zapier' => [
                'name' => e('Zapier'),
                'icon' => '<img src="'.assets('images/zapier.svg').'" class="icon-45 border rounded-3 p-2">',
                'link' => 'https://zapier.com',
                'available' => true,
                'condition' => $user->zapurl || $user->zapview,
                'description' => e('Connect with Zapier and receive requests when a new short url is generated or a new click is made.'),
                'route' => route('integrations','zapier'),
                'setup' => [self::class, 'zapier']
            ],
            'wordpress' => [
                'name' => e('WordPress'),
                'icon' => '<img src="'.assets('images/wp.svg').'" class="icon-45 border rounded-3 p-2">',
                'available' => config('api') && $user->has('api'),
                'condition' => false,
                'description' => e('Install our WP plugin and start shortening links directly from WordPress using a shortcode.'),
                'route' => route('integrations','wordpress'),
                'setup' => [self::class, 'wordpress'],
                'text' => e('Download')
            ],
            'shortcuts' => [
                'name' => e('Shortcuts'),
                'icon' => '<img src="'.assets('images/shortcuts.svg').'" class="icon-45 border rounded-3 p-2">',
                'available' => config('api') && $user->has('api'),
                'condition' => false,
                'description' => e('Use our powerful Shortcut in your iOS device and shorten links easily and quickly.'),
                'route' => route('integrations','shortcuts'),
                'setup' => [self::class, 'shortcuts']
            ],
		];

        if(config('slackclientid') && config('slacksecretid')){
            $list = array_merge(['slack' => [
                'name' => e('Slack'),
                'icon' => '<img src="'.assets('images/slack.svg').'" class="icon-45 border rounded-3 p-2">',
                'link' => 'https://slack.com',
                'available' => true,
                'condition' => $user->slackid,
                'description' => e('Connect our app with Slack and start shortening links directly from your Slack workspace.'),
                'route' => route('integrations','slack'),
                'setup' => [self::class, 'slack'],
            ]], $list);
        }

		if($extended = \Core\Plugin::dispatch('integrations.extend')){
			foreach($extended as $fn){
				$list = array_merge($list, $fn);
			}
		}

		if($name) return isset($list[$name]) ? $list[$name] : false;
        
		return $list;
    }
    /**
     * Slack Integration
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public static function slack(){

        if(!config('slackclientid') || !config('slacksecretid')){
            stop(404);
        }

        View::set('title', e('Slack Integration'));
        
        $slack = new \Helpers\Slack(config('slackclientid'), config('slacksecretid'), route('user.slack'));

        return View::with('integrations.slack', compact('slack'))->extend('layouts.dashboard');
    }    
    /**
     * Zapier Integration
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public static function zapier(){

        View::set('title', e('Zapier Integration'));

        \Helpers\CDN::load('hljs');
        View::push('<script>hljs.highlightAll();</script>','custom')->toFooter();
    
        return View::with('integrations.zapier')->extend('layouts.dashboard');
    }    
    /**
     * WordPress Integration
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public static function wordpress(){

        if(!config('api') || !user()->has('api')) return \Models\Plans::notAllowed();

        if(request()->download) return self::plugin();

        View::set('title', e('WordPress Integration'));

        \Helpers\CDN::load('hljs');
        View::push('<script>hljs.highlightAll();</script>','custom')->toFooter();
    
        return View::with('integrations.wordpress')->extend('layouts.dashboard');
    } 
    /**
     * Shortcuts Integration
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public static function shortcuts(){
        
        if(!config('api') || !user()->has('api')) return \Models\Plans::notAllowed();

        View::set('title', e('Shortcuts Integration'));
    
        return View::with('integrations.shortcuts')->extend('layouts.dashboard');
    }
    /**
     * WP Plugin
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public static function plugin(){
        
        if(!config('api') || !user()->has('api')) return \Models\Plans::notAllowed();

        $plugin = file_get_contents(STORAGE."/app/wpplugin.php");

		$plugin = str_replace("__URL__", config('url'), $plugin);
		$plugin = str_replace("__AUTHOR__", config('title'), $plugin);
		$plugin = str_replace("__API__", route('api.url.create'), $plugin);
		$plugin = str_replace("__KEY__", user()->api, $plugin);

        $zip = new \ZipArchive();
        
        $tmpname = Helper::rand(12).time().".zip";

        if(!$zip->open(STORAGE."/app/".$tmpname,  \ZipArchive::CREATE)){
            return back()->wih('danger', e('Plugin cannot be generated. Please contact us for more information.'));
        }

        $zip->addFromString('plugin.php', $plugin);
        $zip->close();
        
        header('Content-disposition: attachment; filename=linkshortenershortcode.zip');
        header('Content-type: application/zip');
        readfile(STORAGE."/app/".$tmpname);
        unlink(STORAGE."/app/".$tmpname);
    }
}