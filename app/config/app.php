<?php
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact GemPixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package AppConfig
 * @author GemPixel (http://gempixel.com)
 * @copyright 2023 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 */

return [

	/**
	 * Enable Sitemap
	 * 
	 * To disable sitemap set enabled to false. To disable public links in sitemap set urls to false
	 * 
	 * @var array
	 * @since 6.6
	 */
	'sitemap' => [
		// To disable sitemap, set this to false
		'enabled' => true,

		// To disable urls in sitemap, set this to false
		'urls' => true,
		
		// Number of public short links to show
		'numberoflinks' => 50,

		// To disable bio pages in sitemap, set this to false
		'bio' => true,

		// Number of bio pages to show
		'numberofbio' => 50
	],

	/**
	 * Default Language
	 * 
	 * @var string
	 */
	'language' => 'en',

	/**
	 * Spam check rules
	 */
	'spamcheck' => [
		
		'numberoflinks' => 2,

		'postmarkcheck' => true,

		'regex' => '/\b(viagra|cialis|casino|porn|sex|xxx|fuck|bitch|shit|adult|escort|nude|naked|erotic|orgasm|penis|vagina|boobs|tits|ass|cock|pussy|dildo|masturbate|horny|slut|whore|cunt|dick)\b/i'
	],

	/**
	 * Browser Language Based Redirection
	 * 
	 * To enable browser language-based redirection
	 * 
	 * @var boolean
	 */
	'browserbasedlang' => true,

	/**
	 * Allow users to shorten already-shortened link
	 * 
	 * @var boolean
	 */
	'self_shortening' => false,

	/**
	 * This options enable duplicate urls for logged in users
	 * 
	 * @var boolean
	 */
	'duplicateurls' => false,
	
  	/**
	* Anti-Flood Time
   	* 
	* @var integer Minutes, Stats will not be updated when the same visitor clicks the same url for this amount of time
	*/	
	'antiflood' => 15,

	/**
	 * Automatically redirect splash page when a timer is set. Set to true for this to happen
	 * 
	 * @var boolean
	 */
	'redirectauto' => false,

	/**
	 * The following string is used to generate random aliases, Feel free to add numbers or remove things
	 * 
	 * @var string
	 */
	'aliasformat' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

	/**
	 * List of Executables
	 * 
	 * Links ending with the following extensions will be blocked
	 * 
	 * @var array
	 */
	'executables' => ["exe","dll","bin","dat","osx"],

	/**
	 * Storage Paths Configuration - Do not change
	 * 
	 * @var array
	 */
	'storage' => [
		'public' => [
			'path' => PUB,
			'link' => config('url')
		],
		'uploads'  => [
			'path' => PUB.'/content',
			'link' => config('url').'/content'
		],
		'blog' => [
			'path' => PUB.'/content/blog',
			'link' => config('url').'/content/blog'
		],
		'avatar' => [
			'path' => PUB.'/content/avatar',
			'link' => config('url').'/content/avatar'        
		],
		'images' => [
			'path' => PUB.'/content/images',
			'link' => config('url').'/content/images'
		],
		'qr' => [
			'path' => PUB.'/content/qr',
			'link' => config('url').'/content/qr'        
		],
		'profile' => [
			'path' => PUB.'/content/profiles',
			'link' => config('url').'/content/profiles'        
		],
		'files' => [
			'path' => PUB.'/content/files',
			'link' => config('url').'/content/files'        
		],
	],

	/**
	 * Geo Driver
	 * 
	 * api: Path to api with with {IP} as placeholder
	 * maxmind: Path to database
	 * custom: Fully qualified name of a class
	 * 
	 * @var string api | maxmind | custom
	 */
	'geodriver' => 'maxmind',

	'geopath' => STORAGE.'/app/GeoLite2-City.mmdb',
	// 'geopath' => 'https://freegeoip.app/json/{IP}',  
	// 'geopath' => \Helpers\MyClass::class,

	/**
	 * Mail Drivers
	 * @var array
	 */
	'maildrivers' => [
		'mailgun' => \Core\Support\Mailgun::class,
		'sendgrid' => \Core\Support\Sendgrid::class,
		'postmark' => \Core\Support\Postmark::class,
		'mailchimp' => \Core\Support\Mailchimp::class,
	],
	/**
	 * Path to cache folder
	 * 
	 * @var string
	 */
	'cachepath' => STORAGE.'/cache',

	/**
	 * Route to the API
	 * 
	 * You can change this if you don't want to use /api
	 * If you change it to /secret then all api links will update to
	 * /secret/* automatically
	 * 
	 * @var string
	 */
	'apiroute' => '/api',

	/**
	 * Route to Admin
	 * 
	 * If you want to replace the admin path /admin you can change that in here. 
	 * If you change it to /secret then all admin links will update to
	 * /secret/* automatically
	 * 
	 * @var string
	 */
	'adminroute' => '/admin',

	/** 
	 * Throttle API X per Y minutes
	 * 
	 * @var array
	 * @example [3, 10] = 3 requests per 10 minutes
	 * @example [30, 1] = 30 requests per 1 minute
	 */
	'throttle' => [30, 1],

	/**
	 * Enable debugger
	 * 
	 * @var integer
	 */
	'debug' => defined('DEBUG') ? DEBUG : 0,
	/**
	 * Logs Path
	 * 
	 * @var string
	 */
	'log' => LOGS.'/',

	/** 
	 * Default Theme
	 * 
	 * @var string
	 */
	'default_theme' => 'default',

	/**
	 * Proxy
	 * 
	 * If enabled, all outbound requests will use the proxy. 
	 * Make sure the proxy works otherwise some features might not work correctly
	 * 
	 * @var array
	 */
	'proxy' => [
		'enabled' 	=> false,
		'server' 	=> '',
		'port' 		=> '',
		'user' 		=> '',
		'password' 	=> ''
	],

	/**
	* Hash IP Address
	* 
	* IP address is stored for each click and it allows us to identify unique clicks. 
	* In some countries that may cause issues so if you want to hash IP address then enable this.
	*
	* @var boolean
	*/

	'haship' => false,

	/**
	 * Sizes in KB for various uploads
	 */
	'sizes' => [
		// Avatar
		'avatar' => 500,
		
		// Bio Pages
		'bio' => [
			'avatar' => 500,
			'background' => 1024,
			'image' => 500,
			'link' => 500,
		],

		// Custom Splash Pages
		'splash' => [
			'avatar' => 500,
			'banner' => 1024,
		],
		
		// QR file size
		'qrfile' => 2048,
		
		'qrcsv' => 1024,
	],
	/**
	 * Allowed files for various uploads
	 */
	'extensions' => [
		// Account
		'avatar' => ['jpg', 'png'],
		
		// Bio Pages
		'bio' => [
			'avatar' => ['jpg', 'png', 'jpeg'],
			'background' => ['jpg', 'png', 'jpeg'],
			'image' => ['jpg', 'png', 'jpeg'],
			'link' => ['jpg', 'png', 'jpeg', 'gif']
		],

		// Custom Splash Pages
		'splash' => [
			'avatar' => ['jpg', 'png', 'jpeg', 'gif'],
			'banner' => ['jpg', 'png', 'jpeg'],
		]
	],
	/**
	 * Download QR codes natively i.e. via browser instead of servers-side processing
	 * @var boolean
	 */
	'nativeqrdownload' => class_exists('Imagick', false) == false
];