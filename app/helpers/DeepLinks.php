<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed
 *  by GemPixel or authorized parties, you must not use this software and contact gempixel
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
use Core\View;
use Core\Auth;
use Core\Helper;
use Core\Response;
use Core\Request;
use Helpers\App;

class DeepLinks {

    /**
     * Deep Links List
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @return void
     */
    public static function list(){

        $list = [
            'airbnb' => [
                'icon' => assets('images/airbnb.svg'),
                'title' => e('Airbnb'),
                'ios' => 'https://apps.apple.com/us/app/airbnb/id401626263',
                'android' => 'https://play.google.com/store/apps/details?id=com.airbnb.android',
                'domains' => 'airbnb.(.*)',
                'supports' => ['room'],
                'deeplink' => [DeepLinks::class, 'airbnb'],
            ],
            'aliexpress' => [
                'icon' => assets('images/aliexpress.svg'),
                'title' => e('AliExpress'),
                'ios' => 'https://apps.apple.com/us/app/aliexpress/id436672029',
                'android' => 'https://play.google.com/store/apps/details?id=com.alibaba.aliexpresshd',
                'domains' => 'aliexpress.(.*)',
                'supports' => ['product', 'category'],
                'deeplink' => [DeepLinks::class, 'aliexpress'],
            ],
            'amazon' => [
                'icon' => assets('images/amazon.png'),
                'title' => e('Amazon'),
                'ios' => 'https://apps.apple.com/us/app/amazon-shopping/id297606951',
                'android' => 'https://play.google.com/store/apps/details?id=com.amazon.mShop.android.shopping',
                'domains' => 'amazon.(?:com|co.uk|ca|de|es|fe|it|co.jp|in|cn|com.sg|com.mx|ae|com.br|nl|com.au|com.tr|sa|se|pl)',
                'supports' => ['category', 'product'],
                'deeplink' => [DeepLinks::class, 'amazon'],
            ],
            'applemusic' => [
                'icon' => assets('images/itunes.svg'),
                'title' => e('Apple Music'),
                'ios' => 'https://apps.apple.com/us/app/apple-music/id1108187390',
                'android' => 'https://play.google.com/store/apps/details?id=com.apple.android.music',
                'domains' => 'music.apple.com',
                'supports' => ['album', 'artist', 'song'],
                'deeplink' => [DeepLinks::class, 'applemusic'],
            ],
            'facebook' => [
                'icon' => assets('images/facebook.svg'),
                'title' => e('Facebook'),
                'ios' => 'https://apps.apple.com/us/app/facebook/id284882215',
                'android' => 'https://play.google.com/store/apps/details?id=com.facebook.katana',
                'domains' => 'facebook.(?:com|co.uk|ca|de|es|fe|it|co.jp|in|cn|com.sg|com.mx|ae|com.br|nl|com.au|com.tr|sa|se|pl)',
                'supports' => ['videos', 'profile', 'page', 'event', 'post', 'group'],
                'deeplink' => [DeepLinks::class, 'facebook'],
            ],
            'grubhub' => [
                'icon' => assets('images/grubhub.png'),
                'title' => e('GrubHub'),
                'ios' => 'https://apps.apple.com/us/app/grubhub-food-delivery/id302920553',
                'android' => 'https://play.google.com/store/apps/details?id=com.grubhub.android&hl=en_CA',
                'domains' => 'grubhub.com',
                'supports' => ['restaurant'],
                'deeplink' => [DeepLinks::class, 'grubhub'],
            ],
            'instagram' => [
                'icon' => assets('images/instagram.svg'),
                'title' => e('Instagram'),
                'ios' => 'https://apps.apple.com/us/app/instagram/id389801252',
                'android' => 'https://play.google.com/store/apps/details?id=com.instagram.android',
                'domains' => 'instagram.(?:com|co.uk|ca|de|es|fe|it|co.jp|in|cn|com.sg|com.mx|ae|com.br|nl|com.au|com.tr|sa|se|pl)',
                'supports' => ['post','tv','profile'],
                'deeplink' => [DeepLinks::class, 'instagram'],
            ],
            'linkedin' => [
                'icon' => assets('images/linkedin.svg'),
                'title' => e('LinkedIn'),
                'ios' => 'https://apps.apple.com/us/app/linkedin/id288429040',
                'android' => 'https://play.google.com/store/apps/details?id=com.linkedin.android',
                'domains' => 'linkedin.(.*)',
                'supports' => ['company', 'job','message', 'profile'],
                'deeplink' => [DeepLinks::class, 'linkedin'],
            ],
            'messenger' => [
                'icon' => assets('images/messenger.png'),
                'title' => e('Messenger'),
                'ios' => 'https://apps.apple.com/us/app/facebook-messenger/id454638411',
                'android' => 'https://play.google.com/store/apps/details?id=com.facebook.orca',
                'domains' => '(messenger.com|m.me)',
                'supports' => null,
                'deeplink' => [DeepLinks::class, 'messenger'],
            ],
            'netflix' => [
                'icon' => assets('images/netflix.svg'),
                'title' => e('Netflix'),
                'ios' => 'https://apps.apple.com/us/app/netflix/id363590051',
                'android' => 'https://play.google.com/store/apps/details?id=com.netflix.mediaclient',
                'domains' => 'netflix.com',
                'supports' => ['episode', 'genre', 'show'],
                'deeplink' => [DeepLinks::class, 'netflix'],
            ],
            'pinterest' => [
                'icon' => assets('images/pinterest.svg'),
                'title' => e('Pinterest'),
                'ios' => 'https://apps.apple.com/us/app/pinterest/id429047995',
                'android' => 'https://play.google.com/store/apps/details?id=com.pinterest',
                'domains' => 'pinterest.(.*)',
                'supports' => ['pin', 'profile'],
                'deeplink' => [DeepLinks::class, 'pinterest'],
            ],
            'snapchat' => [
                'icon' => assets('images/snapchat.svg'),
                'title' => e('Snapchat'),
                'ios' => 'https://apps.apple.com/us/app/snapchat/id447188370',
                'android' => 'https://play.google.com/store/apps/details?id=com.snapchat.android',
                'domains' => 'snapchat.com',
                'supports' => ['business', 'profile'],
                'deeplink' => [DeepLinks::class, 'snapchat'],
            ],
            'spotify' => [
                'icon' => assets('images/spotify.svg'),
                'title' => e('Spotify'),
                'ios' => 'https://apps.apple.com/us/app/spotify-music-and-podcasts/id324684580',
                'android' => 'https://play.google.com/store/apps/details?id=com.spotify.music',
                'domains' => 'open.spotify.com',
                'supports' => ['album','artist','episode','playlist','show','track'],
                'deeplink' => [DeepLinks::class, 'spotify'],
            ],
            'telegram' => [
                'icon' => assets('images/telegram.png'),
                'title' => e('Telegram'),
                'ios' => 'https://apps.apple.com/us/app/telegram-messenger/id686449807',
                'android' => 'https://play.google.com/store/apps/details?id=org.telegram.messenger',
                'domains' => 't.me',
                'supports' => ['chat', 'messenger'],
                'deeplink' => [DeepLinks::class, 'telegram'],
            ],
            'tiktok' => [
                'icon' => assets('images/tiktok.svg'),
                'title' => e('TikTok'),
                'ios' => 'https://apps.apple.com/us/app/tiktok/id835599320',
                'android' => 'https://play.google.com/store/apps/details?id=com.zhiliaoapp.musically',
                'domains' => 'tiktok.com',
                'supports' => ['profile', 'songs', 'video'],
                'deeplink' => [DeepLinks::class, 'tiktok'],
            ],
            'twitch' => [
                'icon' => assets('images/twitch.svg'),
                'title' => e('Twitch'),
                'ios' => 'https://apps.apple.com/us/app/twitch-watch-stream-games/id460177396',
                'android' => 'https://play.google.com/store/apps/details?id=tv.twitch.android.app',
                'domains' => 'twitch.tv',
                'supports' => ['streaming', 'gaming'],
                'deeplink' => [DeepLinks::class, 'twitch'],
            ],
            'twitter' => [
                'icon' => assets('images/x.svg'),
                'title' => e('X'),
                'ios' => 'https://apps.apple.com/us/app/twitter/id333903271',
                'android' => 'https://play.google.com/store/apps/details?id=com.twitter.android',
                'domains' => '(?:twitter|x).com',
                'supports' => ['post','tv','profile'],
                'deeplink' => [DeepLinks::class, 'twitter'],
            ],
            'walmart' => [
                'icon' => assets('images/walmart.png'),
                'title' => e('Walmart'),
                'ios' => 'https://apps.apple.com/us/app/walmart-shopping-grocery/id338137227',
                'android' => 'https://play.google.com/store/apps/details?id=com.walmart.android',
                'domains' => 'walmart.com',
                'supports' => ['category', 'brand', 'product', 'search'],
                'deeplink' => [DeepLinks::class, 'walmart'],
            ],
            'whatsapp' => [
                'icon' => assets('images/whatsapp.svg'),
                'title' => e('Whatsapp'),
                'ios' => 'https://apps.apple.com/us/app/whatsapp-messenger/id310633997',
                'android' => 'https://play.google.com/store/apps/details?id=com.whatsapp',
                'domains' => '(whatsapp.com|wa.me)',
                'supports' => null,
                'deeplink' => [DeepLinks::class, 'whatsapp'],
            ],
            'wolt' => [
                'icon' => assets('images/wolt.png'),
                'title' => e('Wolt'),
                'ios' => 'https://apps.apple.com/us/app/wolt-delivery-food-and-more/id943905271',
                'android' => 'https://play.google.com/store/apps/details?id=com.wolt.android&hl=en',
                'domains' => 'wolt.com',
                'supports' => ['link'],
                'deeplink' => [DeepLinks::class, 'wolt'],
            ],
            'yelp' => [
                'icon' => assets('images/yelp.png'),
                'title' => e('Yelp'),
                'ios' => 'https://apps.apple.com/ca/app/yelp-local-food-services/id284910350',
                'android' => 'https://play.google.com/store/apps/details?id=com.yelp.android&hl=en_CA',
                'domains' => 'yelp.com',
                'supports' => ['biz'],
                'deeplink' => [DeepLinks::class, 'yelp'],
            ],
            'youtube' => [
                'icon' => assets('images/youtube.svg'),
                'title' => e('Youtube'),
                'ios' => 'https://apps.apple.com/us/app/youtube-watch-listen-stream/id544007664',
                'android' => 'https://play.google.com/store/apps/details?id=com.google.android.youtube',
                'domains' => '(youtube.com|youtu.be)',
                'supports' => ['channels', 'video', 'profile'],
                'deeplink' => [DeepLinks::class, 'youtube'],
            ],
            'zoom' => [
                'icon' => assets('images/zoom.svg'),
                'title' => e('Zoom'),
                'ios' => 'https://apps.apple.com/us/app/zoom-cloud-meetings/id546505307',
                'android' => 'https://play.google.com/store/apps/details?id=us.zoom.videomeetings',
                'domains' => '(.*).zoom.us',
                'supports' => ['video conferencing', 'online meetings'],
                'deeplink' => [DeepLinks::class, 'zoom'],
            ]
        ];

        if($extended = \Core\Plugin::dispatch('deeplinks.extend')){
            foreach($extended as $fn){
                $list = array_merge($list, $fn);
            }
        }

        return $list;
    }
    /**
     * Convert Links to Deep Links
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param string $url
     * @return void
     */
    public static function convert(string $url){

        $host = Helper::parseUrl(urldecode(clean($url)), 'host');

        $domain = strtolower(str_replace('www.', '', $host));

        $url = trim($url, '/');

        foreach(self::list() as $name => $provider){
            if(preg_match("/{$provider['domains']}/i", $domain)) {
                $response = call_user_func($provider['deeplink'], $url);
                return $response ? array_merge($response, ['iosapp' => $provider['ios'], 'androidapp' => $provider['android']]) : null;
            }
        }

        return null;
    }
    /**
     * Youtube Links
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param string $url
     * @return void
     */
    public static function youtube(string $url){

        $deeplink = ['provider' => 'youtube', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'youtube.com\/channel\/{*}',
            'youtube.com\/watch[?]v={*}',
            'youtu.be\/{*}',
            'youtube.com\/user\/{*}',
            'youtube.com\/@{*}'
        ];

        $ios = [
            'vnd.youtube://channel/{*}',
            'vnd.youtube://watch/{*}',
            'vnd.youtube://watch/{*}',
            'vnd.youtube://user/{*}',
            'vnd.youtube://www.youtube.com/{*}',
        ];

        $deeplink['android'] = str_replace(['http://', 'https://'], 'intent://', $url).'#Intent;package=com.google.android.youtube;scheme=https;end';

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            if($matches && isset($matches[1]) && !empty($matches[1])){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $matches[1]), $ios[$i]);
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * Amazon Links
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param string $url
     * @return void
     */
    public static function amazon(string $url){

        $deeplink = ['provider' => 'amazon', 'ios' => '', 'android' => ''];

        $deeplink['ios'] = str_replace(['http://', 'https://'], 'com.amazon.mobile.shopping.web://', $url);

        $deeplink['android'] = str_replace(['http://', 'https://'], 'com.amazon.mobile.shopping.web://', $url);

        return $deeplink;
    }
    /**
     * Facebook Links
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param string $url
     * @return void
     */
    public static function facebook(string $url){

        $deeplink = ['provider' => 'facebook', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'facebook.com\/profile.php[?]id={*}',
            'facebook.com\/events\/{*}',
            'facebook.com\/groups\/{*}',
            'facebook.com\/(.*)\/posts\/{*}',
            'facebook.com\/(.*)\/videos\/{*}',
            'facebook.com\/{*}',
        ];

        $ios = [
            'fb://profile/{*}',
            'fb://page/{*}',
            'fb://event/{*}',
            'fb://group/{*}',
            'fb://post/{*}',
            'fb://video/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                $deeplink['android'] = str_replace('fb://', 'intent://', $deeplink['ios']).'#Intent;package=com.facebook.katana;scheme=https;end';
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * Instagram
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param string $url
     * @return void
     */
    public static function instagram(string $url){

        $deeplink = ['provider' => 'instagram', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'instagram.com\/p\/{*}',
            'instagram.com\/{*}',
        ];

        $ios = [
            'instagram://media?id={*}',
            'instagram://user?username={*}',
        ];

        $deeplink['android'] = str_replace(['http://', 'https://'], 'intent://', $url).'#Intent;package=com.instagram.android;scheme=https;end';

        foreach($supportFormats as $i => $format){
            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){

                if($i == 0){
                    $tag = str_replace('/', '', $tag);
                    $tag = explode('?', $tag)[0];
                    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
                    $mediaid = 0;
                    for ($j = 0; $j < strlen($tag); $j++) {
                        $mediaid = ($mediaid * 64) + strpos($alphabet, $tag[$j]);
                    }

                    $tag = $mediaid;
                }

                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * Twitter / X
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param string $url
     * @return void
     */
    public static function twitter(string $url){
        $deeplink = ['provider' => 'twitter', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'twitter.com\/hashtag\/{*}',
            'twitter.com\/{*}',
        ];

        $ios = [
            'twitter://hashtag/{*}',
            'twitter://user?screen_name={*}'
        ];

        $deeplink['android'] = str_replace(['http://', 'https://'], 'intent://', $url).'#Intent;package=com.twitter.android;scheme=https;end';

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                return $deeplink;
            }
        }
    }
    /**
     * Spotify
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function spotify(string $url){

        $deeplink = ['provider' => 'spotify', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'open.spotify.com\/album\/{*}',
            'open.spotify.com\/artist\/{*}',
            'open.spotify.com\/episode\/{*}',
            'open.spotify.com\/playlist\/{*}',
            'open.spotify.com\/show\/{*}',
            'open.spotify.com\/track\/{*}',
            'open.spotify.com\/{*}',
        ];

        $ios = [
            'spotify://album/{*}',
            'spotify://artist/{*}',
            'spotify://episode/{*}',
            'spotify://playlist/{*}',
            'spotify://show/{*}',
            'spotify://track/{*}',
            'spotify://{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                $deeplink['android'] = $deeplink['ios'];
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * Whatsapp
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function whatsapp(string $url){

        $deeplink = ['provider' => 'whatsapp', 'ios' => 'whatsapp://app', 'android' => 'whatsapp://app'];

        $uri = parse_url($url);

        if($uri['host'] == 'wa.me' && isset($uri['path']) && !empty($uri['path'])){
            $deeplink['ios'] = 'whatsapp://send'.preg_replace('#\D+/g#', '', $uri['path']);
            $deeplink['android'] = 'whatsapp://send'.preg_replace('#\D+/g#', '', $uri['path']);

            if(isset($uri['query']) && !empty($uri['query'])){
                parse_str($uri['query'], $query);
                $deeplink['ios'] .= '?text='.urlencode($query['text']);
                $deeplink['android'] .= '?text='.urlencode($query['text']);
            }
        }

        return $deeplink;
    }
    /**
     * TikTok
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function tiktok(string $url){

        $deeplink = ['provider' => 'tiktok', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'tiktok.com\/{*}\/video\/{*}',
            'tiktok.com\/{*}',
        ];

        $ios = [
            'snssdk1233://vm.tiktok.com/video/{*}',
            'snssdk1233://user/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                $deeplink['android'] = str_replace(['http://', 'https://'], 'intent://', $url).'#Intent;package=com.zhiliaoapp.musically;scheme=https;end';
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * Snapchat
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function snapchat(string $url){

        $deeplink = ['provider' => 'snapchat', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'snapchat.com\/add\/{*}',
            'snapchat.com\/discover\/{*}',
        ];

        $ios = [
            'snapchat://add/{*}',
            'snapchat://discover/{*}',
        ];

        $android = [
            'intent://add/{*}#Intent;scheme=https;package=com.snapchat.android;end;',
            'intent://snapchat.com/discover/{*}#Intent;scheme=https;package=com.snapchat.android;end;'
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                $deeplink['android'] = str_replace('{*}', str_replace('&', '', $tag), $android[$i]);
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * Apple Music
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function applemusic(string $url){
        $deeplink = ['provider' => 'applemusic', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'music.apple.com\/{*}\/album\/{*}',
            'music.apple.com\/{*}\/playlist\/{*}',
            'music.apple.com\/{*}\/artist\/{*}',
        ];


        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'music://', $url);
                $deeplink['android'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'intent://', $url).'#Intent;package=com.apple.android.music;scheme=https;end';
                return $deeplink;
            }
        }

        return $deeplink;
    }

    /**
     * pinterest
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function pinterest(string $url){
        
        $deeplink = ['provider' => 'pinterest', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'pinterest.{*}\/pin\/{*}',
            'pinterest.{*}\/{*}',
        ];

        $ios = [
            'pinterest://pin/{*}',
            'pinterest://user/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                $deeplink['android'] = str_replace(['http://', 'https://'], 'intent://', $url).'#Intent;package=com.pinterest;scheme=https;end';
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * linkedin
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function linkedin(string $url){
        $deeplink = ['provider' => 'linkedin', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'linkedin.{*}\/in\/{*}',
            'linkedin.{*}\/company\/{*}',
            'linkedin.{*}\/jobs\/search\/{*}',
        ];

        $ios = [
            'linkedin://in/{*}',
            'linkedin://company/{*}',
            'linkedin://jobs/search/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $tag), $ios[$i]);
                $deeplink['android'] = str_replace(['http://', 'https://'], 'intent://', $url).'#Intent;package=com.linkedin.android;scheme=https;end';
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * walmart
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function walmart(string $url){
        $deeplink = ['provider' => 'walmart', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'walmart.{*}\/cp\/{*}',
            'walmart.{*}\/browse\/{*}',
            'walmart.{*}\/ip\/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = 'walmart://'.str_replace(['walmart.{*}', '\/{*}', '\/'], ['', '',''], $format).'/'.$tag;
                $deeplink['android'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'intent://', $url).'#Intent;package=com.walmart.android;scheme=https;end';
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * netflix
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function netflix(string $url){
        
        $deeplink = ['provider' => 'netflix', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'netflix.com\/browse\/{*}',
            'netflix.com\/watch\/{*}',
            'netflix.com\/title\/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = 'nflx://'.str_replace(['netflix.com\/{*}', '\/{*}', '\/'], ['', '','/'], $format).'/'.$tag;
                $deeplink['android'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'intent://', $url).'#Intent;package=com.netflix.mediaclient;scheme=https;end';
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * twitch
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function twitch(string $url){
        $deeplink = ['provider' => 'twitch', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'twitch.tv\/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = 'twitch://stream/'.$tag;
                $deeplink['android'] = $deeplink['ios'];
                return $deeplink;
            }
        }

        return $deeplink;
    }
    /**
     * zoom
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @param string $url
     * @return void
     */
    public static function zoom(string $url){

        $deeplink = ['provider' => 'zoom', 'ios' => '', 'android' => ''];

        $supportFormats = [
            '{*}.zoom.us\/{*}',
        ];

        $ios = [
            'zoommtg://zoom.us/join?action=join&confno={*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            $parts = explode('?', $tag);

            $id = explode('/', $parts[0]);

            $id = end($id);

            if($tag && !empty($tag)){
                $deeplink['ios'] = str_replace('{*}', str_replace('&', '', $id), $ios[$i]);
                $deeplink['android'] = $deeplink['ios'];
                return $deeplink;
            }
        }

        return $deeplink;
        
    }
    /**
     * Wolt
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @return void
     */
    public static function wolt(string $url){

        $deeplink = ['provider' => 'wolt', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'wolt.com\/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = 'wolt-app:/'.str_replace(['wolt.com\/{*}', '\/{*}', '\/'], ['', '','/'], $format).'/'.$tag;
                $deeplink['android'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'intent://', $url).'#Intent;package=com.wolt.android;scheme=https;end';
                return $deeplink;
            }
        }
        return $deeplink;
    }
    /**
     * Yelp
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @param string $url
     * @return void
     */
    public static function yelp(string $url){

        $deeplink = ['provider' => 'yelp', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'yelp.com\/biz\/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = 'yelp://biz/'.$tag;
                $query = explode('?', $url);
                $deeplink['android'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'intent://', $query[0]).'#Intent;package=com.yelp.android;scheme=https;end?'.$query[1];
                return $deeplink;
            }
        }
        return $deeplink;
    }
    /**
     * GrubHub
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @param string $url
     * @return void
     */
    public static function grubhub(string $url){

        $deeplink = ['provider' => 'airbnb', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'grubhub.com\/restaurant\/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = 'grubhubapp://restaurant/'.$tag;
                $query = explode('?', $url);
                $deeplink['android'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'intent://', $query[0]).'#Intent;package=com.yelp.android;scheme=https;end?'.$query[1];
                return $deeplink;
            }
        }
        return $deeplink;
    }
    /**
     * Airbnb
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param string $url
     * @return void
     */
    public static function airbnb(string $url){

        $deeplink = ['provider' => 'airbnb', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'airbnb.{*}\/rooms\/{*}',
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $deeplink['ios'] = 'airbnb://rooms/'.$tag;
                $deeplink['android'] = str_replace(['https://', 'http://', 'https://www.', 'http://www.'], 'intent://', $url).'#Intent;package=com.airbnb.android;scheme=https;end';
                return $deeplink;
            }
        }
        return $deeplink;
    }
    /**
     * Ali Express
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param string $url
     * @return void
     */
    public static function aliexpress(string $url){

        $deeplink = ['provider' => 'aliexpress', 'ios' => '', 'android' => ''];

        $supportFormats = [
            'aliexpress.{*}\/item\/{*}'
        ];

        foreach($supportFormats as $i => $format){

            $regex = str_replace('{*}', '(.*)', $format);

            preg_match("/{$regex}/i", $url, $matches);

            $tag = end($matches);

            if($tag && !empty($tag)){
                $tag = str_replace('.html?', '&', $tag);
                $deeplink['ios'] = 'aliexpress://product/detail?productId='.$tag;
                $deeplink['android'] = 'aliexpress://product/detail?productId='.$tag;
                return $deeplink;
            }
        }
        return $deeplink;
    }
}