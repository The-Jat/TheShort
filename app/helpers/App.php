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

namespace Helpers;

use Core\DB;
use Core\Helper;
use Core\Localization;

final class App {

    /**
     * Custom Pages Link
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function pages($category = null){

        $locale = Localization::locale();

        if(!Localization::exists($locale)) $locale = 'en';

        $query = DB::page()->where('menu', 1)->where('lang', $locale);

        if($category){
            $query->where('category', $category);
        }
        $pages = [];
        foreach($query->find() as $page){
            $page->metadata = json_decode($page->metadata ?? '');
            $pages[] = $page;
        }
        return $pages;
    }
    /**
     * Get pricing faqs
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function pricingFaqs(){
        $locale = Localization::locale();

        if(!Localization::exists($locale)) $locale = 'en';

        return DB::faqs()->where('pricing', 1)->where('lang', $locale)->findMany();
    }
    /**
     * Currency
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $code
     * @param string $amount
     * @return void
     */
    public static function currency($code="", $amount=""){

        $array = array('AED' => array('label'=>'United Arab Emirates Dirham','format' => 'AED %s'),'AUD' => array('label'=>'Australian Dollar','format' => '$%s'),'CAD' => array('label' => 'Canadian Dollar','format' => '$%s'),'EUR' => array('label' => 'Euro','format' => '%s €'),'GBP' => array('label' => 'Pound Sterling','format' => '£ %s'),'JPY' => array('label' => 'Japanese Yen','format' => '¥ %s'),'USD' => array('label' => 'U.S. Dollar','format' => '$%s'),'NZD' => array('label' => 'N.Z. Dollar','format' => '$%s'),'CHF' => array('label' => 'Swiss Franc','format' => '%s Fr'),'HKD' => array('label' => 'Hong Kong Dollar','format' => '$%s'),'SGD' => array('label' => 'Singapore Dollar','format' => '$%s'),'SEK' => array('label' => 'Swedish Krona','format' => '%s kr'),'DKK' => array('label' => 'Danish Krone','format' => '%s kr'),'PLN' => array('label' => 'Polish Zloty','format' => '%s zł'),'NOK' => array('label' => 'Norwegian Krone','format' => '%s kr'),'HUF' => array('label' => 'Hungarian Forint','format' => '%s Ft'),'CZK' => array('label' => 'Czech Koruna','format' => '%s Kč'),'ILS' => array('label' => 'Israeli New Sheqel','format' => '₪ %s'),'MXN' => array('label' => 'Mexican Peso','format' => '$%s'),'BRL' => array('label' => 'Brazilian Real','format' => 'R$%s'),'MYR' => array('label' => 'Malaysian Ringgit','format' => 'RM %s'),'PHP' => array('label' => 'Philippine Peso','format' => '₱ %s'),'TWD' => array('label' => 'New Taiwan Dollar','format' => 'NT$%s'),'THB' => array('label' => 'Thai Baht','format' => '฿ %s'),'TRY' => array('label' => 'Turkish Lira','format' => 'TRY %s'), 'INR' => array('label' => 'Indian Rupee','format' => '₹ %s'), 'SAR' => ['label' => 'Saudi Arabia Riyal', 'format' => 'SAR %s'], 'VND' => ['label' => 'Vietnamese Dong', 'format' => 'VND %s'], 'KRW' => ['label' => 'Korean Won', 'format' => '%s ￦'], 'DZD' => ['label' => 'Algerian Dinar', 'format' => '%s DZD'], 'ARS' => ['label' => 'Argentine Peso', 'format' => '$%s'], 'CLP' => ['label' => 'Chilean Peso', 'format' => '$%s'], 'COP' => ['label' => 'Colombian Peso', 'format' => '$%s'], 'PEN' => ['label' => 'Peruvian Sol', 'format' => 'S/%s'], 'UYU' => ['label' => 'Uruguayan Peso', 'format' => '$%s'],'NGN' => ['label' => 'Nigerian Naira', 'format' => '₦%s'],'GHS' => ['label' => 'Ghanaian Cedi', 'format' => 'GH₵%s'],'ZAR' => ['label' => 'South African Rand', 'format' => 'R%s'],'KES' => ['label' => '	Kenyan Shilling', 'format' => '%s/=']);

        if($currencies = \Core\Plugin::dispatch('currencies')){
			foreach($currencies as $fn){
				$array = array_merge($array, $fn);
			}
		}

        ksort($array);

        if(empty($code)) return $array;

        $code = strtoupper($code);
        if(isset($array[$code])) return sprintf($array[$code]["format"],$amount);
    }
    /**
     * Return Timezones
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function timezone(){
        $tzs = [];

        foreach(\DateTimeZone::listIdentifiers() as $tz){
            $tzs[] = $tz;
        }
        for($i = 12; $i > -13; $i--){
            if($i >=0) $i = "+".$i;
            $tzs[] = 'Etc/GMT'.$i;
        }

        return $tzs;
    }
    /**
     * Get List of Languages
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function languages(){

        $languages = [];

        foreach (new \RecursiveDirectoryIterator(LOCALE) as $path){
            if($path->getFilename() == "." || $path->getFilename() == ".." || $path->getFilename() == "index.php") continue;

            if(!\file_exists(LOCALE.'/'.$path->getFilename().'/app.php')) continue;

            $language = include LOCALE.'/'.$path->getFilename().'/app.php';
            $languages[$language['code']] = ['name' => $language['name'], 'author' => $language['author']];
        }

        return $languages;
    }
    /**
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return boolean
     */
    public static function isExtended(){

        try{
            DB::subscription()->first();
            return true;
        } catch(\Exception $e){
            return false;
        }

        if(!config('purchasecode')) return false;

        $response = \Core\Http::url("https://cdn.gempixel.com/validator/")
                                ->with('X-Authorization', 'TOKEN '.md5(url()))
                                ->with('X-Script', 'Premium URL Shortener')
                                ->body(['url' => url(), 'key' => config('purchasecode')])
                                ->post()
                                ->getBody();

        if(!$response || empty($response) || $response == "Failed"){
            return false;
        }elseif($response == "Wrong.Item"){
            return false;
        }elseif($response == "Wrong.License"){
            return false;
        }

        return true;
    }
    /**
     * Ad Type
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $type
     * @param boolean $format
     * @return void
     */
    public static function adType($type = null, $format = false){
		$types = array(
            "728" => array("name" => "728x90", "format" => "primary"),
            "300" =>  array("name" => "300x250","format" => "danger"),
            "468" =>  array("name" => "468x60", "format" => "info"),
            "resp" =>  array("name" => "Responsive", "format" => "warning"),
            "frame" =>  array("name" => "Frame Page", "format" => "success"),
            "splash" =>  array("name" => "Splash Page", "format" => "success"),
            "blogsidebar" => array("name" => "Blog Sidebar", "format" => "success"),
            "helpsidebar" => array("name" => "Help Center Sidebar", "format" => "success"),
            "biopage" => array("name" => "Bio Page", "format" => "success"),
        );

        if(isset($types[$type]) && $format){
			return "<span class='label label-{$types[$type]["format"]}'>{$types[$type]["name"]}</span>";
		}

        if(isset($types[$type])) return $types[$type]["name"];

		return $types;
	}
    /**
     * Page Category
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function pageCategories($name = null){
        $list = [
            'main' => 'Main',
            'policy' => 'Policy',
            'terms' => 'Terms',
            'others' => 'Others',
        ];

        if(isset($list[$name])) return $list[$name];

        return $list;
    }
    /**
     * Generate Short Link
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $domain
     * @param [type] $alias
     * @return void
     */
    public static function shortRoute($domain, $alias){

        if(!$domain || empty($domain)) $domain = config('url');

        // if(strpos($domain, '*.') !== false) return str_replace('*', $alias, $domain);

        return trim($domain).'/'.trim($alias);
    }
    /**
     * Copy Folder
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param string $source
     * @param string $destination
     * @param array $skip
     * @return void
     */
    public static function copyFolder($source, $destination, $skip = []){
        $directory = opendir($source);
        @mkdir($destination);
        while(false !== ( $file = readdir($directory)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                    if ( is_dir($source . '/' . $file) ) {
                        if($skip && in_array($file, $skip)) continue;
                        self::copyFolder($source . '/' . $file, $destination . '/' . $file);
                    }else {
                        copy($source . '/' . $file, $destination . '/' . $file);
                    }
            }
        }
        closedir($directory);
    }
    /**
     * Delete Folder
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $target
     * @return void
     */
    public static function deleteFolder($target){
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK );
            foreach($files as $file){
                self::deleteFolder($file);
            }
            if(is_dir($target)) rmdir($target);
        } elseif(is_file($target)) {
            unlink($target);
        }
    }
    /**
     * @author GemPixel <https://gempixel.com>
     * @return boolean
     */
    public static function possible($short = false){

        try{
            DB::subscription()->first();
            return true;
        } catch(\Exception $e){
            return false;
        }

        if(!config('purchasecode')) return false;

        $response = \Core\Http::url("https://cdn.gempixel.com/validator/")
                                ->with('X-Authorization', 'TOKEN '.md5(url()))
                                ->body(['url' => url(), 'key' => config('purchasecode')])
                                ->post()
                                ->getBody();

        if(!$response || empty($response) || $response == "Failed"){
            return false;
        }elseif($response == "Wrong.Item"){
            return false;
        }elseif($response == "Wrong.License"){
            return false;
        }
    }

    /**
     * Update Notification
     * @since 6.0
     */
    public static function newUpdate($version = false){

        $request = \Core\Http::url("https://cdn.gempixel.com/updater/index.php?p=".md5('shortener'))->get(['timeout' => 3]);

        $data = $request->bodyObject();

        if(isset($data->status) && $data->status == "ok"){
            if(config('version') < $data->current_version){
                if($version == true){
                    return $data->current_version;
                }else{
                    return "<div class='custom-alert alert-success'>This script has been updated to version {$data->current_version}. You can run the <a href='".route("admin.update")."' class='button green' style='color:#fff'><u>automatic updater</u></a> or you can download it from <a href='http://codecanyon.net/downloads' target='_blank' class='button green' style='color:#fff'><u>CodeCanyon</u></a> and manually update it.</div>";
                }
            }
        }
        return false;
    }
    /**
     * Get Changelog
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function updateChangelog(){
        return \Core\Http::url("https://gempixel.com/changelog/premium-url-shortener?integrity=".md5('shortener'))->get(['timeout' => 3])->bodyObject();
    }
    /**
     * Default Plan for admin
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.2.2
     * @return void
     */
    public static function defaultPlan(){

        if($pluggedplan = \Core\Plugin::dispatch('defaultplan')) return $pluggedplan;

        $plan = [];
        $plan['name'] = "Default";
        $plan['free'] = "0";
        $plan['numurls'] = "0";
        $plan['numclicks'] = "0";
        $plan['retention'] = "0";

        foreach(self::features() as $slug => $feature){
            if($slug == 'apirate'){
                $plan['permission'][$slug] = $feature['count'] ? ["enabled" => true, "count" => appConfig('app.throttle')[0]] : ['enabled' => true];
            } else {
                $plan['permission'][$slug] = $feature['count'] ? ["enabled" => true, "count" => 0] : ['enabled' => true];
            }
        }

        $plan['permission']['custom'] = '';

        $plan['permission'] = json_encode($plan['permission']);

        return $plan;
    }
    /**
     * List of features
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.0
     * @return void
     */
    public static function features(){

        $list = [
            "bio" => [
                'name' => e('Bio Pages'),
                'description' => e("Convert your followers by creating beautiful pages that group all of your important links on the single page."),
                'category' => 'bio',
                'count' => true
            ],
            "qr" => [
                'name' => e('QR Codes'),
                'description' => e("Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement."),
                'category' => 'qr',
                'count' => true
            ],
            "bulkqr" => [
                'name' => e('Bulk QR Codes'),
                'description' => e("Generate multiple QR codes at once."),
                'category' => 'qr',
                'count' => false
            ],
            'bioblocks' => [
                'name' => e('Bio Page Widgets'),
                'description' => e('Available Bio Page Widgets'),
                'category' => 'bio',
                'custom' => [
                    'type' => 'select',
                    'data' => array_map(function($id){return $id;}, array_keys(\Helpers\BioWidgets::widgets())),
                    'title' => e('Blocks'),
                    'description' => e('Choose from list of available blocks. Leave empty to allow all blocks.')
                ],
                'count' => false
            ],
            "splash" => [
                'name' => e('Custom Landing Page'),
                'description' => e('Create a custom landing page to promote your product or service on forefront and engage the user in your marketing campaign.'),
                'category' => 'link',
                'count' => true
            ],
            "overlay" => [
                'name' => e('CTA Overlays'),
                'description' => e('Use our overlay tool to display unobtrusive notifications, polls or even a contact on the target website. Great for campaigns.'),
                'category' => 'link',
                'count' => true
            ],
            "domain" => [
                'name' => e('Branded Domains'),
                'description' => e("Easily add your own domain name for short your links and take control of your brand name and your users' trust."),
                'category' => 'management',
                'count' => true
            ],
            "pixels" => [
                'name' => e('Tracking Pixels'),
                'description' => e('Add your custom pixel from providers such as Facebook and track events right when they are happening.'),
                'category' => 'management',
                'count' => true
            ],
            "channels"  => [
                'name' => e('Channels'),
                'description' => e('Group & organize your links.'),
                'category' => 'management',
                "enabled" => true,
                'count' => true
            ],
            "bundle"  => [
                'name' => e('Campaigns'),
                'description' => e('Group your links and visualize aggregate data.'),
                'category' => 'management',
                "enabled" => true,
                'count' => false
            ],
            "team"  => [
                'name' => e('Team Members'),
                'description' => e('Invite your team members and assign them specific privileges to manage links, bundles, pages and other features.'),
                'category' => 'management',
                'count' => true
            ],
            "alias" => [
                'name' => e('Custom Aliases'),
                'description' => e('Choose a custom alias instead of a randomly generated one.'),
                'category' => 'link',
                'count' => false
            ],
            "deeplink" => [
                'name' => e('Deep Linking'),
                'description' => e('Configure your links to automatically open apps if installed.'),
                'category' => 'link',
                'count' => false
            ],
            "geo"=> [
                'name' => e('Geo Targeting'),
                'description' => e('Target and redirect visitors based on their country or state.'),
                'category' => 'link',
                'count' => false
            ],
            "device" => [
                'name' => e('Device Targeting'),
                'description' => e('Target and redirect visitors based on their device.'),
                'category' => 'link',
                'count' => false
            ],
            "language"  => [
                'name' => e('Language Targeting'),
                'description' => e('Target and redirect visitors based on their language.'),
                'category' => 'link',
                'count' => false
            ],
            "abtesting" => [
                'name' => e('A/B Testing & Rotator'),
                'description' => e('Rotate links using the same short link. Great for A/B testing.'),
                'category' => 'link',
                'count' => false
            ],
            "expiration" => [
                'name' => e('Expiration'),
                'description' => e("Set a date or number to clicks to expire short links").'.',
                'category' => 'link',
                'count' => false
            ],
            "clicklimit" => [
                'name' => e('Click Limitation'),
                'description' => e("Limit number of clicks per short link").'.',
                'category' => 'link',
                'count' => false
            ],
            "parameters" => [
                'name' => e('Parameters'),
                'description' => e('Add parameters such as UTM to the short link.'),
                'category' => 'link',
                'count' => false
            ],
            "qrlogo" => [
                'name' => e('Custom Logo on QR'),
                'description' => e('Upload your own logo on QR codes.'),
                'category' => 'qr',
                'count' => false
            ],
            "qrframes" => [
                'name' => e('Frames on QR'),
                'description' => e('Add frames to your QR codes.'),
                'category' => 'qr',
                'count' => false
            ],
            "biocss" => [
                'name' => e('Custom CSS on Bio Page'),
                'description' => e('Add your own CSS on Bio Pages.'),
                'category' => 'bio',
                'count' => false
            ],
            "customfavicon" => [
                'name' => e('Custom Favicon'),
                'description' => e('Add your own favicons.'),
                'category' => 'bio',
                'count' => false
            ],
            "poweredby" => [
                'name' => e('Remove Branding'),
                'description' => e('Remove branding on Bio Pages and Custom Splash Pages'),
                'category' => 'bio',
                'count' => false
            ],
            "multiple"  => [
                'name' => e('Premium Domains'),
                'description' => e('Use premium domains we provide you with instead of the original one.'),
                'category' => 'management',
                'custom' => [
                    'type' => 'select',
                    'data' => array_merge(['All'], explode("\n", str_replace("\r", '', config("domain_names")))),
                    'title' => e('Domains'),
                    'description' => e('Choose from list of available domains or leave empty to allow all domains.')
                ],
                'count' => false
            ],
            "api" => [
                'name' => e('Developer API'),
                'description' => e('Use our powerful API to build custom applications or extend your own application with our powerful tools.'),
                'category' => 'management',
                'count' => false
            ],
            "apirate" => [
                'name' => e('API Rate Limit'),
                'description' => e('Amount of requests you can send per minute to our API system.'),
                'category' => 'management',
                'count' => true
            ],
            "import" => [
                'name' => e('Import Links'),
                'description' => e('Import links via CSV.'),
                'category' => 'management',
                'count' => false
            ],
            "export" => [
                'name' => e('Export Data'),
                'description' => e('Export clicks & visits.'),
                'category' => 'management',
                'count' => false
            ]
        ];

        if($features = plug('feature')){
            foreach($features as $feature){
                $list[$feature['slug']] = $feature;
            }
        }

        return $list;
    }
    /**
     * Check DNS and make sure both domains have the same IP
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $d1
     * @param string $d2
     * @return boolean
     */
    public static function checkDNS(string $d1, string $d2){

        $d1 = str_replace(['http://', 'https://'], '', $d1);
        $d2 = str_replace(['http://', 'https://'], '', $d2);

        $d2 = idn_to_ascii($d2);

        return gethostbyname($d1) == gethostbyname($d2) ? true : false;
    }
    /**
     * Notifications
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function notifications(){

        $list = [];
        $list['total'] = 0;

        $reports = DB::reports()->where('status', 0)->count();
        $list['total'] += $reports;

        $list['data']['reports'] = $reports;

        $pending = DB::url()->where('status', 0)->count();
        $list['total'] += $pending;

        $list['data']['pending'] = $pending;

        $verifications = DB::verification()->where('status', 0)->count();
        $list['total'] += $verifications;        

        $list['data']['verifications'] = $verifications;

        $withdrawals = DB::withdrawals()->where('status', 'pending')->count();
        $list['total'] += $withdrawals;        

        $list['data']['withdrawals'] = $withdrawals;

        return $list;
    }
    /**
     * Display Ads
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param mixed $size
     * @return void
     */
    public static function ads($size, $print = true){
        if(config('ads')){
            $user = user();
            if(config('pro') && $user && $user->pro()) return;
            if(!$ad = DB::ads()->where("type", $size)->where("enabled", "1")->orderByExpr('RAND()')->first()) return;
            $ad->impression++;
            $ad->save();
            $code = "<div class=\"a-block a--{$size} mt-2 mb-4\">{$ad->code}</div>";
            return $print ? print($code) : $code;
        }

		return;
    }
    /**
     * Detect bots
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function bot(){
        $CrawlerDetect = new \Jaybizzle\CrawlerDetect\CrawlerDetect;
        if($CrawlerDetect->isCrawler()) {
          return true;
        }
        return false;
    }
    /**
     * Flag SVG
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $country
     * @return void
     */
    public static function flag($country){
        if(empty($country) || strtolower($country) == "unknown") return assets('images/unknown.svg');
        return assets('images/flags/'.strtolower(Helper::Country($country, false, true)).'.svg');
    }
    /**
     * OS SVG
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $os
     * @return void
     */
    public static function os($os){

        $cos = strtolower(explode(' ', $os)[0]);

        if(empty($cos) || $cos == "unknown") return assets('images/unknown.svg');

        if(in_array($cos, ['iphone', 'ipod', 'ipad'])) $cos = 'mac';

        return assets('images/os/'.$cos.'.svg');
    }
    /**
     * Browser SVG
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $browser
     * @return void
     */
    public static function browser($browser){

        $cos = strtolower(explode(' ', $browser)[0]);

        if(empty($cos) || $cos == "unknown") return assets('images/unknown.svg');

        if(in_array($cos, ['Internet Explorer'])) $cos = 'ie';

        return assets('images/browsers/'.$cos.'.svg');
    }
    /**
     * iFrame Policy
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $url
     * @return void
     */
    public static function iframePolicy($url){

        if(!\Core\Helper::isURL($url)) return false;

        $url_headers = @get_headers($url);

        foreach ($url_headers as $key => $value){
            $x_frame_options_deny = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: DENY'));
            $x_frame_options_sameorigin = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: SAMEORIGIN'));
            $x_frame_options_allow_from = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: ALLOW-FROM'));
            $csp_frame_ancestors_self = strpos(strtolower($url_headers[$key]), strtolower('content-security-policy: frame-ancestors')) && strpos(strtolower($url_headers[$key]), strtolower('self'));
            if ($x_frame_options_deny !== false || $x_frame_options_sameorigin !== false || $x_frame_options_allow_from !== false || $csp_frame_ancestors_self !== false){
                return true;
            }
        }
        return false;
    }
    /**
     * Get metadata
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $url
     * @param boolean $checkHeader
     * @return void
     */
    public static function metaData($url, $checkHeader = false){

        if(!\Core\Helper::isURL($url)) return false;

        $array = array('title' => '','description' => '');

        $request = \Core\Http::url($url)
                        ->with('user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36')
                        ->get(['timeout' => 2]);

        $contentType = $request->response('content_type');

        if($contentType && !preg_match("~text/html~", strtolower($contentType))){
            return $array;
        }

        $charsetString = $contentType ? explode(';', $contentType) : null;
        $charset = null;
        if($charsetString && isset($charsetString[1])){
            $charset = str_replace('charset=', '', strtolower(trim($charsetString[1])));
        }

        if($content = $request->getBody()){
            $pattern = "#<[\s]*title[\s]*>([^<]+)<[\s]*/[\s]*title[\s]*>#Ui";
            if(preg_match($pattern, $content, $match)){
                try{
                    $array['title'] = $charset && $charset != 'utf-8' ? \mb_convert_encoding($match[1], 'utf-8', $charset) : $match[1];
                } catch(\ValueError $e){
                    return false;
                } catch(\Exception $e){
                    return false;
                }
            }

            $pattern = "#<[\s]*meta[\s]*name=(?:'|\")description(?:'|\")[\s]*content=(?:'|\")([^<]+)(?:'|\")[\s]*[-/]?>#i";
            if(preg_match($pattern, $content, $match)){
                try{
                    $array['description'] =  $charset && $charset != 'utf-8' ? \mb_convert_encoding($match[1], 'utf-8', $charset) : $match[1];
                } catch(\ValueError $e){
                    return false;
                } catch(\Exception $e){
                    return false;
                }
            }

            if(!mb_check_encoding($array['title'], 'utf-8')){
                $array['title'] = '';
            }

            if(!mb_check_encoding($array['description'], 'utf-8')){
                $array['description'] = '';
            }

            unset($data);
            unset($content);
            unset($match);

            return $array;
        }
        return false;
    }
    /**
     * Share Buttons
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $url
     * @param [type] $title
     * @param array $site
     * @return void
     */
    public static function share($url, $options = []){

        if(!config('sharing')) return;

        $site = $options['site'] ?? '';
        $class = $options['class'] ?? 'popup btn btn-default me-1';
        $text = $options['text'] ?? false;

        $html  = "";
        $url = urlencode($url);
        if(empty($site) || in_array("facebook",$site)){
          $html .='<a href="https://www.facebook.com/sharer.php?u='.$url.'" data-href="https://www.facebook.com/sharer.php?u=" target="_blank" class="'.$class.'"><span class="fab fa-facebook"></span>'.($text ? '<span class="ms-3">Facebook</span>' : '').'</a>';
        }
        if(empty($site) || in_array("twitter",$site)){
          $html .='<a href="https://twitter.com/share?url='.$url.'" data-href="https://twitter.com/share?url=" target="_blank" class="'.$class.'"><span class="fab fa-x-twitter"></span>'.($text ? '<span class="ms-3">Twitter</span>' : '').'</a>';
        }
        if(empty($site) || in_array("reddit",$site)){
          $html .='<a href="https://reddit.com/submit?url='.$url.'" data-href="https://reddit.com/submit?url=" target="_blank" class="'.$class.'"><span class="fab fa-reddit"></span>'.($text ? '<span class="ms-3">Reddit</span>' : '').'</a>';
        }
        if(empty($site) || in_array("linkedin",$site)){
          $html .='<a href="https://www.linkedin.com/shareArticle?mini=true&url='.$url.'" data-href="https://www.linkedin.com/shareArticle?mini=true&url=" target="_blank" class="'.$class.'"><span class="fab fa-linkedin"></span>'.($text ? '<span class="ms-3">Linkedin</span>' : '').'</a>';
        }
        if(empty($site) || in_array("whatsapp",$site)){
            $html .='<a href="https://wa.me/?text='.$url.'" data-href="https://wa.me/?text=" target="_blank" class="'.$class.'"><span class="fab fa-whatsapp"></span>'.($text ? '<span class="ms-3">Whatsapp</span>' : '').'</a>';
        }

        if(empty($site) || in_array("telegram",$site)){
            $html .='<a href="https://t.me/share/url?url='.$url.'" data-href="https://t.me/share/url?url=" target="_blank" class="'.$class.'"><span class="fab fa-telegram"></span>'.($text ? '<span class="ms-3">Telegram</span>' : '').'</a>';
        }

        if(empty($site) || in_array("mail", $site)){
            $html .='<a href="mailto:?subject=Check+out+this+url&body='.$url.'" data-href="mailto:?subject=Check+out+this+url&body=" target="_blank" class="'.$class.'"><span class="fas fa-envelope"></span>'.($text ? '<span class="ms-3">Email</span>' : '').'</a>';
        }

        return $html;
    }
    /**
     * Format Pixel Name
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $name
     * @return void
     */
    public static function pixelName($name){

        $type = str_replace('pixel', '', $name);
        if($type == 'fb') $type = 'facebook';
        if($type == 'ga') $type = 'Google Analytics';
        if($type == 'gtm') $type = 'Google Tag Manager';
        if($type == 'adwords') $type = 'Google Ads';
        return $type;
    }
    /**
     * Theme Configuration Shortcut
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $key
     * @param [type] $value
     * @param [type] $if
     * @param [type] $else
     * @return void
     */
    public static function themeConfig($key, $value, $if, $else = null){

        $config = config('theme_config');

        if( !isset($config->{$key}) || $config->{$key} != $value ) return $else;

        return $if;
    }

    /**
     * Is Dark mode on
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
    /**
     * Method Color
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $method
     * @return void
     */
    public static function apiMethodColor($method){
        $list  = [
            'GET' => 'info',
            'PUT' => 'warning',
            'POST' => 'success',
            'DELETE' => 'danger'
        ];

        return $list[$method];
    }
    /**
     * Get user history
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function userHistory(){
        $uh = request()->cookie('userhistory');

        $urls = [];

        if(!$uh) return false;

        foreach(json_decode(Helper::decrypt($uh), true) as $id){
            if(!$id || !$url = DB::url()->where('id', $id)->where('userid', 0)->findArray()) continue;
            $urls[] = $url[0];
        }

        return $urls;
    }
    /**
     * Langs
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function langs(){

        $langs = \Core\Localization::listInfo();

        if(!file_exists(LOCALE."/en/app.php")) $langs[] = ['name' => 'English', 'author' => 'GemPixel', 'code' => 'en'];

        if(count($langs) == 1) return null;

        return $langs;
    }
    /**
     * All available domains
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.4
     * @return void
     */
    public static function domains(){

        $user = \Models\User::where('id', \Core\Auth::user()->rID())->first();

        $domains = [];

        if($user->has("domain") !== false){
            $query = DB::domains()->where("userid", $user->rID())->where('status','1')->orderByDesc('id');
            $total = $user->hasLimit('domain');
            if($total > 0) {
                $userdomains = $query->limit($total)->findMany();
            } else {
                $userdomains = $query->findMany();
            }

            foreach ($userdomains as $domain) {
                $domains[] = trim($domain->domain);
            }
        }

        if(config('multiple_domains')){
            $list = explode("\n", config('domain_names'));
            if($user && $user->has("multiple") !== false){
                $allowed = null;
                $plan = null;
                if(!$user->admin) {
                    if($plan = DB::plans()->where('id', $user->planid)->first()){
                        $plan->permission = json_decode($plan->permission);
                        if(isset($plan->permission->multiple->custom) && !empty($plan->permission->multiple->custom)){
                            $allowed = explode(',', $plan->permission->multiple->custom);
                        }
                    }
                }
                
                foreach ($list as $domain) {

                    if(empty($domain)) continue;

                    if($allowed){
                        if(in_array('All', $allowed) || in_array(trim($domain), $allowed)) $domains[] = strtolower(trim($domain));
                    }else{
                        $domains[] = strtolower(trim($domain));
                    }
                }

            }

        }

        if(config('root_domain') || ($user && $user->admin)){
            $domains[] = strtolower(config('url'));
        }

		if($extended = \Core\Plugin::dispatch('domains.extend')){
			foreach($extended as $fn){
				$domains = array_merge($domains, $fn);
			}
		}

        return $domains;
    }
    /**
     * Redirect Types
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.1
     * @return void
     */
    public static function redirects(){

        $user = \Models\User::where('id', \Core\Auth::user()->rID())->first();
        $redirects = [];

        if(config('frame') == 3 || $user->pro()){

            $redirects[e('Redirection')] = [
               "direct" => e("Direct"),
               "frame" => e("Frame"),
               "splash" => e("Splash")
            ];

        } else {
            $methods = array("0" => "direct", "1" => "frame", "2" => "splash", "3" =>  "splash");

            $redirects[e('Redirection')] = [
                $methods[config('frame')] => e(ucfirst($methods[config('frame')]))
             ];
        }

        if($user->has('overlay') !== false){
            $query = DB::overlay()->where('userid', $user->id)->orderByDesc('date');
            $total = $user->hasLimit('overlay');
            if($total > 0) {
                $db = $query->limit($total)->findMany();
            } else {
                $db = $query->findMany();
            }

            foreach($db as $overlay){
                $redirects[e('CTA Overlay')]['overlay-'.$overlay->id] = $overlay->name;
            }

        }
        if($user->has('splash') !== false){
            $query = DB::splash()->where('userid', $user->id)->orderByDesc('date');
            $total = $user->hasLimit('splash');
            if($total > 0) {
                $db = $query->limit($total)->findMany();
            } else {
                $db = $query->findMany();
            }
            foreach($db as $overlay){
                $redirects[e('Custom Splash')][$overlay->id] = $overlay->name;
            }

        }

        if($extended = \Core\Plugin::dispatch('redirects.extend')){
			foreach($extended as $fn){
				$redirects = array_merge($redirects, $fn);
			}
		}

        return $redirects;
    }
    /**
     * Get States
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8.4
     * @param string $name
     * @return void
     */
    public static function states($name = 'United States'){

        $request = request();

        if($request->country) $name = $request->country;

        $response = \Core\Http::url('https://countriesnow.space/api/v0.1/countries/states/q?country='.urlencode(strtolower($name)))->get(['timeout' => 3]);

        if($response){
            $states = $response->bodyObject();
            if(isset($states->data->states)) {
                foreach($states->data->states as $i => $obj){
                    $states->data->states[$i]->name = str_replace(['County', 'District', 'Oblast', 'Province', 'Region', 'Department'], '', $obj->name);
                }
                return $request->output ? \Core\Response::factory($states->data->states)->json() : $states->data->states;
            }
        }

        return [];
    }
    /**
     * Check Encryption
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function checkEncryption(){

        if(EncryptionToken == null){
            $file = file_get_contents(ROOT.'/config.php');

            $file = str_replace("define('EncryptionToken', null)",  "define('EncryptionToken', '".\Defuse\Crypto\Key::createNewRandomKey()->saveToAsciiSafeString()."');", $file);

            $fh = fopen(ROOT.'/config.php', 'w') or die("Can't open config.php. Make sure it is writable.");

            fwrite($fh, $file);
            fclose($fh);
        }

        if(EncryptionToken == '__ENC__'){
            $file = file_get_contents(ROOT.'/config.php');

            $file = str_replace("__ENC__", \Defuse\Crypto\Key::createNewRandomKey()->saveToAsciiSafeString(), $file);

            $fh = fopen(ROOT.'/config.php', 'w') or die("Can't open config.php. Make sure it is writable.");

            fwrite($fh, $file);
            fclose($fh);
        }
    }
    /**
     * Extract RSS
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $url
     * @return void
     */
    public static function rss($url){

        if(!$url) return 'Invalid RSS';

        if(!$content = @file_get_contents($url)) return 'Invalid RSS';

        if(!preg_match('~<rss~i', $content)) return 'Invalid RSS';

        try{
            $feed = new \SimpleXMLElement($content);
        }catch(\Exception $e) {
            return 'Invalid RSS';
        }

        $items = [];

        if(!isset($feed->channel)) return 'Invalid RSS';

        foreach($feed->channel->item as $item){
            $items[] = [
                'title' => $item->title ?? null,
                'link' => $item->link ?? null,
                'image' => $item->image ?? null,
                'description' => $item->description ? \Core\Helper::truncate(strip_tags($item->description), 150) : null,
                'date' => $item->pubDate ?? null
            ];
        }

        return $items;

    }
    /**
     * Get License Information
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.2.1
     * @return void
     */
    public static function license($code = null){

        $purchasecode = $code ?? trim(config('purchasecode'));

        return \Core\Http::url("https://cdn.gempixel.com/verify/?detailed=true")
                            ->with('X-Authorization', 'TOKEN '.$purchasecode)
                            ->with('X-Script', 'Premium URL Shortener')
                            ->body(['url' => url(), 'key' => $purchasecode])
                            ->post()
                            ->bodyObject();
    }
    /**
     * Check Logged As
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.4
     * @return void
     */
    public static function loggedAs(){

        if(!request()->session('logged_as')) return false;

        $session = json_decode(Helper::decrypt(request()->session('logged_as')));

        if(!isset($session->id, $session->key)) return false;

        $user = DB::user()->first($session->id);

        if($user->auth_key != $session->key) return false;

        return $user->id;
    }
    /**
     * Random Words
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.4.1
     * @return void
     */
    public static function randomWord(){
        $word = '';
        $vowels = ["a","e","i","o","u"];
        $consonants = [
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
        ];

        $max = rand(4,12) / 2;
        for ($i = 1; $i <= $max; $i++)
        {
            $word .= $consonants[rand(0,19)];
            $word .= $vowels[rand(0,4)];
        }

        return $word;
    }
    /**
     * Language List
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.5
     * @param [type] $code
     * @return void
     */
    public static function languagelist($code = null, $lookup = false, $asArray = false){
        $list = ['af' => 'Afrikaans','sq' => 'Albanian','ar' => 'Arabic','eu' => 'Basque','bg' => 'Bulgarian','be' => 'Belarusian','ca' => 'Catalan','zh' => 'Chinese','hr' => 'Croatian','cs' => 'Czech','da' => 'Danish','nl' => 'Dutch','en' => 'English','et' => 'Estonian','fo' => 'Faeroese','fa' => 'Farsi','fi' => 'Finnish','fr' => 'French','gd' => 'Gaelic','de' => 'German','el' => 'Greek','he' => 'Hebrew','hi' => 'Hindi','hu' => 'Hungarian','is' => 'Icelandic','id' => 'Indonesian','it' => 'Italian','ja' => 'Japanese','ko' => 'Korean','ko' => 'Korean','lv' => 'Latvian','lt' => 'Lithuanian','mk' => 'FYRO Macedonian ms Malaysian','mt' => 'Maltese','no' => 'Norwegian','no' => 'Norwegian','pl' => 'Polish','pt' => 'Portuguese','rm' => 'Rhaeto-Romanic','ro' => 'Romanian','ru' => 'Russian','sz' => 'Sami','sr' => 'Serbian','sr' => 'Serbian','sk' => 'Slovak','sl' => 'Slovenian','sb' => 'Sorbian','es' => 'Spanish','sx' => 'Sutu','sv' => 'Swedish','th' => 'Thai','ts' => 'Tsonga','tn' => 'Tswana','tr' => 'Turkish','uk' => 'Ukrainian','ur' => 'Urdu','ve' => 'Venda','vi' => 'Vietnamese','xh' => 'Xhosa','ji' => 'Yiddish','zu' => 'Zulu', 'jp' => 'Japanese'];

        if($asArray) return $list;

        if($lookup){
            return isset($list[$code]) ? $list[$code] : $code;
        }

        $form = "";
        foreach ($list as $key => $value) {
          $form .= '<option value="'.$key.'"'.($code == strtolower($key)?' selected':'').'>'.$value.'</option>';
        }
        return $form;
    }
    /**
     * Sort array by Key for pricing table
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.6.3
     * @param array $array
     * @return void
     */
    public static function tableSort(array $array){
        $newarray = [];

        foreach($array as $i => $ar){
            foreach($ar as $key => $value){
                if(is_array($value) || is_object($value)){
                    foreach($value as $subkey => $subvalue){
                        $newarray[$subkey][$i] = $subvalue;
                    }
                }else {
                    $newarray[$key][$i] = $value;
                }
            }
        }

        return $newarray;
    }

    /**
     * Delete file Local or CDN
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public static function delete($file){

        $config = config('cdn');

        if(isset($config->enabled) && $config->enabled) {
            $file = str_replace(PUB.'/', '', $file);
            return CDN::factory()->delete($file);
        }

        if(file_exists($file)) return unlink($file);

        return false;
    }

    /**
     * Cookie Consent/Libraries Control
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param string $category
     * @return void
     */
    public static function cookieConsent(string $category){

        if(!config('cookieconsent')->enabled) return ' ';

        $cookie = json_decode(request()->cookie('cc_cookie'), true);

        if(isset($cookie['categories']) && is_array($cookie['categories']) && in_array($category, $cookie['categories'])) return ' ';

        return ' type="text/plain" data-cookiecategory="'.$category.'" ';
    }
    /**
     * Fonts
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @return void
     */
    public static function fonts(){

        $fonts = [];

        foreach (new \RecursiveDirectoryIterator(PUB.'/static/fonts') as $path){
            if($path->getFilename() == "." || $path->getFilename() == ".." || $path->getFilename() == "index.php") continue;

            if(!\file_exists(PUB.'/static/fonts/'.$path->getFilename().'/font.css')) continue;

            $fonts[] = $path->getFilename();
        }
        return $fonts;
    }
    /**
     * Max Upload Size
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @return void
     */
    public static function maxSize() {

        $max_size = -1;

        if ($max_size < 0) {
          $post_max_size = self::parseSize(ini_get('post_max_size'));
          if ($post_max_size > 0) {
            $max_size = $post_max_size;
          }
          $upload_max = self::parseSize(ini_get('upload_max_filesize'));
          if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
          }
        }
        return round($max_size / pow(1024, 2), 0);
    }
    /**
     * Parse Size
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param [type] $size
     * @return void
     */
    public static function parseSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $size = preg_replace('/[^0-9\.]/', '', $size);
        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }else {
            return round($size);
        }
    }

    /**
     * Crop
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.0
     * @param [type] $src
     * @param [type] $dest
     * @param [type] $desired_width
     * @param [type] $desired_height
     * @param string $quality
     * @return void
     */
    public static function cropthumb($src, $dest, $desired_width, $desired_height , $quality='100'){

        if(!file_exists($src)) return false;

        $extension = \Core\Helper::extension($src);

        if(empty($dest)) $dest=str_replace($extension, $desired_width.$extension, $src);

        $suffix = [
            'jpeg' => 'jpeg',
            'jpg' => 'jpeg',
            'gif' => 'gif',
            'png' => 'png'
        ];

        if(!isset($suffix[$extension])) return false;

        if($suffix[$extension] == "png"){
            $quality = 7;
        }elseif($suffix[$extension] == "gif") {
            $quality = false;
        }


        if(!isset($suffix[$extension])) return false;

        $start_X = floor($desired_width / 4);
        $start_Y = floor($desired_height / 4);
        $end_x = 3*$start_X;
        $end_y = 3*$start_Y;

        $imgsize = getimagesize($src);
        $width = $imgsize[0];
        $height = $imgsize[1];

        $width_new = $height * $desired_width / $desired_height;
        $height_new = $width * $desired_height / $desired_width;

        //Proceeds with resizing
        $image_suffix = $suffix[$extension];
        $createfrom = 'imagecreatefrom'.$image_suffix;

        $image = 'image'.$image_suffix;
        $source_image = $createfrom($src);

        $virtual_image = imagecreatetruecolor($desired_width,$desired_height);
        if($extension == 'png'){
            imagealphablending($virtual_image, false);
            imagesavealpha($virtual_image, true);
            $transparentindex = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
            imagefill($virtual_image, 0, 0, $transparentindex);
        }

        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, $h_point, $desired_width, $desired_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($virtual_image, $source_image, 0, 0, $w_point, 0, $desired_width, $desired_height, $width_new, $height);
        }

        $image($virtual_image, $dest, $quality);

        return true;
    }
    /**
     * Resize Temporary File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.7
     * @param [type] $src
     * @param [type] $ext
     * @param integer $size
     * @param string $quality
     * @return void
     */
    public static function resizeTmp($src, $extension, $size = 1600, $quality='100'){
        if(!file_exists($src)) return false;

        $dest = $src;

        $suffix = [
            'jpeg' => 'jpeg',
            'jpg' => 'jpeg',
            'gif' => 'gif',
            'png' => 'png'
        ];

        if(!isset($suffix[$extension])) return false;

        if($suffix[$extension] == "png"){
            $quality = 7;
        }elseif($suffix[$extension] == "gif") {
            $quality = false;
        }


        if(!isset($suffix[$extension])) return false;

        $imgsize = getimagesize($src);
        $width = $imgsize[0];
        $height = $imgsize[1];

        if($width <= $size) return;

        $ratio = $height / $width;

        $width_new = $size;
        $height_new = $size * $ratio;

        //Proceeds with resizing
        $image_suffix = $suffix[$extension];
        $createfrom = 'imagecreatefrom'.$image_suffix;

        $image = 'image'.$image_suffix;
        $source_image = $createfrom($src);

        if(!$source_image) return false;

        $virtual_image = imagecreatetruecolor($width_new,$height_new);
        if($extension == 'png'){
            imagealphablending($virtual_image, false);
            imagesavealpha($virtual_image, true);
            $transparentindex = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
            imagefill($virtual_image, 0, 0, $transparentindex);
        }

        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $width_new, $height_new, $width, $height);

        $image($virtual_image, $dest, $quality);

        return true;
    }
    /**
     * Resize
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.0
     * @param [type] $src
     * @param [type] $dest
     * @param string $quality
     * @return void
     */
    public static function resize($src, $dest, $size = 1600, $quality='100'){

        if(!file_exists($src)) return false;

        $extension = \Core\Helper::extension($src);

        if($extension == 'tmp') $extension = \Core\Helper::extension($dest);

        if(empty($dest)) $dest=str_replace($extension, $desired_width.$extension, $src);

        $suffix = [
            'jpeg' => 'jpeg',
            'jpg' => 'jpeg',
            'gif' => 'gif',
            'png' => 'png'
        ];

        if($suffix[$extension] == "png"){
            $quality = 7;
        }elseif($suffix[$extension] == "gif") {
            $quality = false;
        }


        if(!isset($suffix[$extension])) return false;


        $imgsize = getimagesize($src);
        $width = $imgsize[0];
        $height = $imgsize[1];
        
        if($width <= $size) return;

        $ratio = $height / $width;

        $width_new = $size;
        $height_new = $size * $ratio;

        //Proceeds with resizing
        $image_suffix = $suffix[$extension];
        $createfrom = 'imagecreatefrom'.$image_suffix;

        $image = 'image'.$image_suffix;
        $source_image = $createfrom($src);

        if(!$source_image) return false;

        $virtual_image = imagecreatetruecolor($width_new,$height_new);
        if($extension == 'png'){
            imagealphablending($virtual_image, false);
            imagesavealpha($virtual_image, true);
            $transparentindex = imagecolorallocatealpha($virtual_image, 255, 255, 255, 127);
            imagefill($virtual_image, 0, 0, $transparentindex);
        }

        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $width_new, $height_new, $width, $height);

        $image($virtual_image, $dest, $quality);

        return true;
    }
    /**
     * Format Number
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @param [type] $number
     * @param integer $precision
     * @return void
     */
    public static function formatNumber($number, $precision = 1) {
        if ($number >= 1000000000) {
            return round($number / 1000000000, $precision) . 'B';
        } else if ($number >= 1000000) {
            return round($number / 1000000, $precision) . 'M';
        }
        return $number;
    }
    /**
     * INvert Color
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param [type] $hex
     * @return void
     */
    public static function invertColor($hex) {
        if(is_null($hex)) return $hex;
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) !== 6) {
            return '#000000';
        }
        $new = '';
        for ($i = 0; $i < 3; $i++) {
            $rgbDigits = 255 - hexdec(substr($hex, (2 * $i), 2));
            $hexDigits = ($rgbDigits < 0) ? 0 : dechex($rgbDigits);
            $new .= (strlen($hexDigits) < 2) ? '0' . $hexDigits : $hexDigits;
        }
        return '#' . $new;
    }
}