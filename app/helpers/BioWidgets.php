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
use Core\Plugin;
use Core\Http;
use Traits\Links;
use Helpers\App;
use Exception;

class BioWidgets {

    use Links;

    static $preview = false;
    /**
     * Is preview
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5
     * @return boolean
     */
    public static function isPreview(){
        self::$preview = true;
    }

    /**
     * Bio Widgets
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5
     * @return string
     */
    public static function widgets($type = null, $action = null, $override = false){

        $list = [
                'link' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-link"></i></h1>',
                    'title' => e('Link'),
                    'description' => e('Add a trackable button to a link'),
                    'setup' => [BioWidgets::class, 'linkSetup'],
                    'save' => [BioWidgets::class, 'linkSave'],
                    'delete' => [BioWidgets::class, 'linkDelete'],
                    'block' => [BioWidgets::class, 'linkBlock'],
                    'processor' => [BioWidgets::class, 'linkProcessor'],
                ],            
                'tagline' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-info-circle"></i></h1>',
                    'title' => e('Tagline'),
                    'description' => e('Add a tagline under your profile name'),
                    'setup' => [BioWidgets::class, 'taglineSetup'],
                    'save' => [BioWidgets::class, 'taglineSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'taglineBlock'],
                    'processor' => null,
                ],
                'heading' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-heading"></i></h1>',
                    'title' => e('Heading'),
                    'description' => e('Add a heading with different sizes'),
                    'setup' => [BioWidgets::class, 'headingSetup'],
                    'save' => [BioWidgets::class, 'headingSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'headingBlock'],
                    'processor' => null,
                ],
                'text' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-align-center"></i></h1>',
                    'title' => e('Text'),
                    'description' => e('Add a text body to your page'),
                    'setup' => [BioWidgets::class, 'textSetup'],
                    'save' => [BioWidgets::class, 'textSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'textBlock'],
                    'processor' => null,
                ],
                'divider' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-grip-lines"></i></h1>',
                    'title' => e('Divider'),
                    'description' => e('Separate your content with a line'),
                    'setup' => [BioWidgets::class, 'dividerSetup'],
                    'save' => [BioWidgets::class, 'dividerSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'dividerBlock'],
                    'processor' => null,
                ],
                'html' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-code"></i></h1>',
                    'title' => e('HTML'),
                    'description' => e('Add custom HTML code. Script codes are not accepted'),
                    'setup' => [BioWidgets::class, 'htmlSetup'],
                    'save' => [BioWidgets::class, 'htmlSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'htmlBlock'],
                    'processor' => null,
                ],
                'image' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-image"></i></h1>',
                    'title' => e('Image'),
                    'description' => e('Upload an image or 2 images in a row'),
                    'setup' => [BioWidgets::class, 'imageSetup'],
                    'save' => [BioWidgets::class, 'imageSave'],
                    'delete' => [BioWidgets::class, 'imageDelete'],
                    'block' => [BioWidgets::class, 'imageBlock'],
                    'processor' => null,
                ],
                'phone' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-phone"></i></h1>',
                    'title' => e('Phone Call'),
                    'description' => e('Set your phone number to call directly'),
                    'setup' => [BioWidgets::class, 'phoneSetup'],
                    'save' => [BioWidgets::class, 'phoneSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'phoneBlock'],
                    'processor' => null,
                ],

                'vcard' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-address-card"></i></h1>',
                    'title' => e('vCard'),
                    'description' => e('Add a downloadable vCard'),
                    'setup' => [BioWidgets::class, 'vcardSetup'],
                    'save' => [BioWidgets::class, 'vcardSave'],
                    'delete' => [BioWidgets::class, 'vcardDelete'],
                    'block' => [BioWidgets::class, 'vcardBlock'],
                    'processor' => [BioWidgets::class, 'vcardProcessor'],
                ],
                'paypal' => [
                    'category' => 'content',
                    'icon' => '<img src="'.assets('images/paypal.svg').'" width="30">',
                    'title' => e('PayPal Button'),
                    'description' => e('Generate a PayPal button to accept payments'),
                    'setup' => [BioWidgets::class, 'paypalSetup'],
                    'save' => [BioWidgets::class, 'paypalSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'paypalBlock'],
                    'processor' => null,
                ],
                'whatsappcall' => [
                    'category' => 'content',
                    'icon' => '<img src="'.assets('images/whatsapp.svg').'" width="30">',
                    'title' => e('WhatsApp Call'),
                    'description' => e('Add button to initiate a Whatsapp call'),
                    'setup' => [BioWidgets::class, 'whatsappcallSetup'],
                    'save' => [BioWidgets::class, 'whatsappcallSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'whatsappcallBlock'],
                    'processor' => null,
                ],
                'whatsapp' => [
                    'category' => 'content',
                    'icon' => '<img src="'.assets('images/whatsapp.svg').'" width="30">',
                    'title' => e('WhatsApp Message'),
                    'description' => e('Add button to send a Whatsapp message'),
                    'setup' => [BioWidgets::class, 'whatsappSetup'],
                    'save' => [BioWidgets::class, 'whatsappSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'whatsappBlock'],
                    'processor' => null,
                ],
                'rss' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-danger fa fa-rss"></i></h1>',
                    'title' => e('RSS Feed'),
                    'description' => e('Add a dynamic RSS feed widget'),
                    'setup' => [BioWidgets::class, 'rssSetup'],
                    'save' => [BioWidgets::class, 'rssSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'rssBlock'],
                    'processor' => null,
                ],
                'newsletter' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-primary fa fa-envelope-open"></i></h1>',
                    'title' => e('Newsletter'),
                    'description' => e('Add a newsletter form to store emails'),
                    'setup' => [BioWidgets::class, 'newsletterSetup'],
                    'save' => [BioWidgets::class, 'newsletterSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'newsletterBlock'],
                    'processor' => [BioWidgets::class, 'newsletterProcessor'],
                ],
                'contact' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-success fa fa-envelope-square"></i></h1>',
                    'title' => e('Contact Form'),
                    'description' => e('Add a contact form to receive emails'),
                    'setup' => [BioWidgets::class, 'contactSetup'],
                    'save' => [BioWidgets::class, 'contactSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'contactBlock'],
                    'processor' => [BioWidgets::class, 'contactProcessor'],
                ],
                'faqs' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-info fa fa-question-circle "></i></h1>',
                    'title' => e('FAQs'),
                    'description' => e('Add a widget of questions and answers'),
                    'setup' => [BioWidgets::class, 'faqsSetup'],
                    'save' => [BioWidgets::class, 'faqsSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'faqsBlock'],
                    'processor' => null,
                ],
                'product' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-warning fa fa-store"></i></h1>',
                    'title' => e('Product'),
                    'description' => e('Add a widget to a product on your site'),
                    'setup' => [BioWidgets::class, 'productSetup'],
                    'save' => [BioWidgets::class, 'productSave'],
                    'delete' => [BioWidgets::class, 'productDelete'],
                    'block' => [BioWidgets::class, 'productBlock'],
                    'processor' => null,
                ],
                'musiclink' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-danger fa fa-music"></i></h1>',
                    'title' => e('Music/Booking Links'),
                    'description' => e('Add a dynamic widget for all of your music or booking links'),
                    'setup' => [BioWidgets::class, 'musiclinkSetup'],
                    'save' => [BioWidgets::class, 'musiclinkSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'musiclinkBlock'],
                    'processor' => [BioWidgets::class, 'linkProcessor'],
                ],
                'youtube' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/youtube.svg').'" width="30">',
                    'title' => e('Youtube Video or Playlist'),
                    'description' => e('Embed a Youtube video or a playlist'),
                    'setup' => [BioWidgets::class, 'youtubeSetup'],
                    'save' => [BioWidgets::class, 'youtubeSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'youtubeBlock'],
                    'processor' => null,
                ],
                'spotify' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/spotify.svg').'" width="30">',
                    'title' => e('Spotify Embed'),
                    'description' => e('Embed a Spotify music or playlist widget'),
                    'setup' => [BioWidgets::class, 'spotifySetup'],
                    'save' => [BioWidgets::class, 'spotifySave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'spotifyBlock'],
                    'processor' => null,
                ],
                'itunes' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/itunes.svg').'" width="30">',
                    'title' => e('Apple Music Embed'),
                    'description' => e('Embed an Apple music widget'),
                    'setup' => [BioWidgets::class, 'itunesSetup'],
                    'save' => [BioWidgets::class, 'itunesSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'itunesBlock'],
                    'processor' => null,
                ],
                'tiktok' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/tiktok.svg').'" width="30">',
                    'title' => e('TikTok Embed'),
                    'description' => e('Embed a tiktok video'),
                    'setup' => [BioWidgets::class, 'tiktokSetup'],
                    'save' => [BioWidgets::class, 'tiktokSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'tiktokBlock'],
                    'processor' => null,
                ],
                'opensea' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/opensea.svg').'" width="30">',
                    'title' => e('OpenSea NFT'),
                    'description' => e('Embed your NFT from OpenSea'),
                    'setup' => [BioWidgets::class, 'openseaSetup'],
                    'save' => [BioWidgets::class, 'openseaSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'openseaBlock'],
                    'processor' => null,
                ],
                'twitter' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/twitter.svg').'" width="30">',
                    'title' => e('Embed Tweets'),
                    'description' => e('Embed your latest tweets'),
                    'setup' => [BioWidgets::class, 'twitterSetup'],
                    'save' => [BioWidgets::class, 'twitterSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'twitterBlock'],
                    'processor' => null,
                ],
                'soundcloud' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/soundcloud.svg').'" width="30">',
                    'title' => e('SoundCloud'),
                    'description' => e('Embed a SoundCloud track'),
                    'setup' => [BioWidgets::class, 'soundcloudSetup'],
                    'save' => [BioWidgets::class, 'soundcloudSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'soundcloudBlock'],
                    'processor' => null,
                ],
                'facebook' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/facebook.svg').'" width="30">',
                    'title' => e('Facebook Post'),
                    'description' => e('Embed a Facebook post'),
                    'setup' => [BioWidgets::class, 'facebookSetup'],
                    'save' => [BioWidgets::class, 'facebookSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'facebookBlock'],
                    'processor' => null,
                ],
                'instagram' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/instagram.svg').'" width="30">',
                    'title' => e('Instagram Post'),
                    'description' => e('Embed an Instagram post'),
                    'setup' => [BioWidgets::class, 'instagramSetup'],
                    'save' => [BioWidgets::class, 'instagramSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'instagramBlock'],
                    'processor' => null,
                ],
                'typeform' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/typeform.svg').'" width="30">',
                    'title' => e('Typeform'),
                    'description' => e('Embed a Typeform form'),
                    'setup' => [BioWidgets::class, 'typeformSetup'],
                    'save' => [BioWidgets::class, 'typeformSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'typeformBlock'],
                    'processor' => null
                ],
                'pinterest' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/pinterest.svg').'" width="30">',
                    'title' => e('Pinterest'),
                    'description' => e('Embed a Pinterest board'),
                    'setup' => [BioWidgets::class, 'pinterestSetup'],
                    'save' => [BioWidgets::class, 'pinterestSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'pinterestBlock'],
                    'processor' => null,
                ],
                'reddit' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/reddit.svg').'" width="30">',
                    'title' => e('Reddit'),
                    'description' => e('Embed a Reddit profile'),
                    'setup' => [BioWidgets::class, 'redditSetup'],
                    'save' => [BioWidgets::class, 'redditSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'redditBlock'],
                    'processor' => null,
                ],
                'calendly' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/calendly.svg').'" width="30">',
                    'title' => e('Calendly'),
                    'description' => e('Schedule booking & appointments'),
                    'setup' => [BioWidgets::class, 'calendlySetup'],
                    'save' => [BioWidgets::class, 'calendlySave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'calendlyBlock'],
                    'processor' => [BioWidgets::class, 'calendlyProcessor'],
                ],
                'threads' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/threads.svg').'" width="30">',
                    'title' => e('Threads'),
                    'description' => e('Display a Threads post'),
                    'setup' => [BioWidgets::class, 'threadsSetup'],
                    'save' => [BioWidgets::class, 'threadsSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'threadsBlock'],
                    'processor' => null,
                ],
                'tiktokprofile' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/tiktok.svg').'" width="30">',
                    'title' => e('TikTok Profile'),
                    'description' => e('Display your profile'),
                    'setup' => [BioWidgets::class, 'tiktokprofileSetup'],
                    'save' => [BioWidgets::class, 'tiktokprofileSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'tiktokprofileBlock'],
                    'processor' => null,
                ],
                'googlemaps' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/maps.svg').'" width="30">',
                    'title' => e('Google Maps'),
                    'description' => e('Add a pin to your location on Google Maps'),
                    'setup' => [BioWidgets::class, 'googlemapsSetup'],
                    'save' => [BioWidgets::class, 'googlemapsSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'googlemapsBlock'],
                    'processor' => null,
                ],
                'opentable' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/opentable.svg').'" width="30">',
                    'title' => e('OpenTable Reservation'),
                    'description' => e('Allow visitors to easily book a table'),
                    'setup' => [BioWidgets::class, 'opentableSetup'],
                    'save' => [BioWidgets::class, 'opentableSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'opentableBlock'],
                    'processor' => null,
                ],
                'eventbrite' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/eventbrite.svg').'" width="30">',
                    'title' => e('EventBrite'),
                    'description' => e('Allow visitors to easily book an event'),
                    'setup' => [BioWidgets::class, 'eventbriteSetup'],
                    'save' => [BioWidgets::class, 'eventbriteSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'eventbriteBlock'],
                    'processor' => null,
                ],
                'snapchat' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/snapchat.svg').'" width="30">',
                    'title' => e('Snapchat'),
                    'description' => e('Add a Snapchat widget on your page'),
                    'setup' => [BioWidgets::class, 'snapchatSetup'],
                    'save' => [BioWidgets::class, 'snapchatSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'snapchatBlock'],
                    'processor' => null,
                ],
                'linkedin' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/linkedin.svg').'" width="30">',
                    'title' => e('LinkedIn Post'),
                    'description' => e('Display a LinkedIn post'),
                    'setup' => [BioWidgets::class, 'linkedinSetup'],
                    'save' => [BioWidgets::class, 'linkedinSave'],
                    'delete' => null,
                    'block' => [BioWidgets::class, 'linkedinBlock'],
                    'processor' => null,
                ],
                'video' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-video text-warning"></i></h1>',
                    'title' => e('Video'),
                    'description' => e('Upload a video'),
                    'setup' => [BioWidgets::class, 'videoSetup'],
                    'save' => [BioWidgets::class, 'videoSave'],
                    'delete' => [BioWidgets::class, 'videoDelete'],
                    'block' => [BioWidgets::class, 'videoBlock'],
                    'processor' => null,
                ],
                'audio' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-music text-primary"></i></h1>',
                    'title' => e('Audio'),
                    'description' => e('Upload an MP3 audio file'),
                    'setup' => [BioWidgets::class, 'audioSetup'],
                    'save' => [BioWidgets::class, 'audioSave'],
                    'delete' => [BioWidgets::class, 'audioDelete'],
                    'block' => [BioWidgets::class, 'audioBlock'],
                    'processor' => null,
                ],
                'pdf' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-file-pdf"></i></h1>',
                    'title' => e('PDF Document'),
                    'description' => e('Upload a PDF document with preview'),
                    'setup' => [BioWidgets::class, 'pdfSetup'],
                    'save' => [BioWidgets::class, 'pdfSave'],
                    'delete' => [BioWidgets::class, 'pdfDelete'],
                    'block' => [BioWidgets::class, 'pdfBlock'],
                    'processor' => null,
                ],
                'intercom' => [
                    'category' => 'communication',
                    'icon' => '<h1><i class="fab fa-intercom"></i></h1>',
                    'title' => e('Intercom Chat'),
                    'description' => e('Add Intercom live chat widget to your profile'),
                    'setup' => [BioWidgets::class, 'intercomSetup'],
                    'delete' => null,
                    'save' => [BioWidgets::class, 'intercomSave'],
                    'block' => [BioWidgets::class, 'intercomBlock'],
                    'processor' => null,
                ],
                'tawkto' => [
                    'category' => 'communication',
                    'icon' => '<img src="'.assets('images/tawkto.svg').'" width="30">',
                    'title' => e('Tawk.to Chat'),
                    'description' => e('Add Tawk.to live chat widget to your profile'),
                    'delete' => null,
                    'setup' => [BioWidgets::class, 'tawktoSetup'],
                    'save' => [BioWidgets::class, 'tawktoSave'],
                    'block' => [BioWidgets::class, 'tawktoBlock'],
                    'processor' => null,
                ],
                'tidio' => [
                    'category' => 'communication',
                    'icon' => '<img src="'.assets('images/tidio.svg').'" width="30">',
                    'title' => e('Tidio Chat'),
                    'description' => e('Add tidio live chat widget to your profile'),
                    'delete' => null,
                    'setup' => [BioWidgets::class, 'tidioSetup'],
                    'save' => [BioWidgets::class, 'tidioSave'],
                    'block' => [BioWidgets::class, 'tidioBlock'],
                    'processor' => null,
                ],
                'vembed' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-film text-info"></i></h1>',
                    'title' => e('Video Embed'),
                    'description' => e('Embed videos from YouTube, Vimeo, Dailymotion and more'),
                    'setup' => [BioWidgets::class, 'videoembedSetup'],
                    'save' => [BioWidgets::class, 'videoembedSave'],
                    'block' => [BioWidgets::class, 'videoembedBlock'],
                ],

            ];

        if($extended = \Core\Plugin::dispatch('biowidgets.extend')){
			foreach($extended as $fn){
				$list = array_merge($list, $fn);
			}
		}

        if($override == false){
            foreach($list as $id => $item){
                if(isset(config('bio')->blocked) && in_array($id, config('bio')->blocked)) {
                    unset($list[$id]);
                }
            }
        }

		if($type && $action) {
            return $list[$type][$action] ?? false;
        }

		if($type){
            return $list[$type] ?? false;
        }

		return $list;
    }
    /**
     * Social Platforms
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function socialPlatforms($key = null){

        $list = [
            'facebook' => [
                'name' => e('Facebook'),
                'icon' => '<i class="fab fa-facebook"></i>',                
            ],
            'twitter' => [
                'name' => e('Twitter'),
                'icon' => '<i class="fab fa-twitter"></i>',                
            ],
            'x' => [
                'name' => e('X'),
                'icon' => '<i class="fab fa-x-twitter"></i>',                
            ],
            'instagram' => [
                'name' => e('Instagram'),
                'icon' => '<i class="fab fa-instagram"></i>',                
            ],
            'threads' => [
                'name' => e('Threads'),
                'icon' => '<i class="fab fa-threads"></i>',
            ],
            'tiktok' => [
                'name' => e('TikTok'),
                'icon' => '<i class="fab fa-tiktok"></i>',
            ],
            'linkedin' => [
                'name' => e('Linkedin'),
                'icon' => '<i class="fab fa-linkedin"></i>',                
            ],
            'youtube' => [
                'name' => e('Youtube'),
                'icon' => '<i class="fab fa-youtube"></i>',                
            ],
            'telegram' => [
                'name' => e('Telegram'),
                'icon' => '<i class="fab fa-telegram"></i>',
            ],
            'snapchat' => [
                'name' => e('Snapchat'),
                'icon' => '<i class="fab fa-snapchat"></i>',                
            ],
            'discord' => [
                'name' => e('Discord'),
                'icon' => '<i class="fab fa-discord"></i>',
            ],
            'twitch' => [
                'name' => e('Twitch'),
                'icon' => '<i class="fab fa-twitch"></i>',
            ],
            'pinterest' => [
                'name' => e('Pinterest'),
                'icon' => '<i class="fab fa-pinterest"></i>',                
            ],
            'shopify' => [
                'name' => e('Shopify'),
                'icon' => '<i class="fab fa-shopify"></i>',
            ],
            'amazon' => [
                'name' => e('Amazon'),
                'icon' => '<i class="fab fa-amazon"></i>',
            ],
            'line' => [
                'name' => e('Line Messenger'),
                'icon' => '<i class="fab fa-line"></i>',
            ],
            'whatsapp' => [
                'name' => e('Whatsapp'),
                'icon' => '<i class="fab fa-whatsapp"></i>',                
            ],
            'viber' => [
                'name' => e('Viber'),
                'icon' => '<i class="fab fa-viber"></i>',
            ],
            'spotify' => [
                'name' => e('Spotify'),
                'icon' => '<i class="fab fa-spotify"></i>',
            ],
            'github' => [
                'name' => e('Github'),
                'icon' => '<i class="fab fa-github"></i>',                
            ],
            'behance' => [
                'name' => e('Behance'),
                'icon' => '<i class="fab fa-behance"></i>',                
            ],
            'dribbble' => [
                'name' => e('Dribbble'),
                'icon' => '<i class="fab fa-dribbble"></i>',                
            ],
            'envelope' => [
                'name' => e('Mail'),
                'icon' => '<i class="fa fa-envelope"></i>',
            ],
            'quora' => [
                'name' => e('Quora'),
                'icon' => '<i class="fab fa-quora"></i>',
            ],
            'vk' => [
                'name' => e('VK'),
                'icon' => '<i class="fab fa-vk"></i>',
            ],
            'wechat' => [
                'name' => e('WeChat'),
                'icon' => '<i class="fab fa-weixin"></i>',
            ],
            'mix' => [
                'name' => e('Mix'),
                'icon' => '<i class="fab fa-mix"></i>',
            ],
            'paypal' => [
                'name' => e('PayPal'),
                'icon' => '<i class="fab fa-paypal"></i>',
            ],
            'codepen' => [
                'name' => e('CodePen'),
                'icon' => '<i class="fab fa-codepen"></i>',
            ],
            'producthunt' => [
                'name' => e('Product Hunt'),
                'icon' => '<i class="fab fa-product-hunt"></i>',
            ],
            'skype' => [
                'name' => e('Skype'),
                'icon' => '<i class="fab fa-skype"></i>',
            ],
            'vimeo' => [
                'name' => e('Vimeo'),
                'icon' => '<i class="fab fa-vimeo"></i>',                
            ],
            'imdb' => [
                'name' => e('IMDB'),
                'icon' => '<i class="fab fa-imdb"></i>',
            ],
            'unsplash' => [
                'name' => e('Unsplash'),
                'icon' => '<i class="fab fa-unsplash"></i>',
            ],
            'mastodon' => [
                'name' => e('Mastodon'),
                'icon' => '<i class="fab fa-mastodon"></i>',
            ],
            'bluesky' => [
                'name' => e('Bluesky'),
                'icon' => '<i class="fab fa-bluesky"></i>',                
            ],
            'upwork' => [
                'name' => e('Upwork'),
                'icon' => '<i class="fab fa-upwork"></i>',                
            ],
            'messenger' => [
                'name' => e('Messenger'),
                'icon' => '<i class="fab fa-facebook-messenger"></i>'
            ],
            'signal' => [
                'name' => e('Signal'),
                'icon' => '<i class="fab fa-signal-messenger"></i>'
            ],
            'onlyfans' => [
                'name' => e('OnlyFans'),
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="align-top" width="20" height="20" viewBox="0 0 400 400"><defs><style>.a{fill:#000;}.b,.c{fill:#fff;}.b{opacity:0.8;}</style></defs><rect class="a" width="400" height="400" rx="200"/><path class="b" d="M156.25,125a87.5,87.5,0,1,0,87.5,87.5A87.53,87.53,0,0,0,156.25,125Zm0,113.75A26.25,26.25,0,1,1,182.5,212.5,26.21,26.21,0,0,1,156.25,238.75Z"/><path class="c" d="M254.6,190.62c22.23,6.4,48.48,0,48.48,0-7.62,33.25-31.77,54.07-66.59,56.61A87.33,87.33,0,0,1,156.25,300l26.25-83.43c27-85.76,40.81-91.57,104.81-91.57h43.94C323.9,157.37,298.57,182.11,254.6,190.62Z"/></svg>'
            ],
            'playstore' => [
                'name' => e('Google Play Store'),
                'icon' => '<i class="fab fa-google-play"></i>'
            ],
            'appstore' => [
                'name' => e('App Store'),
                'icon' => '<i class="fab fa-app-store"></i>'
            ],            
        ];

        if($extended = \Core\Plugin::dispatch('biosocials.extend')){
			foreach($extended as $fn){
				$list = array_merge($list, $fn);
			}
		}

		if($key) return $list[$key] ?? false;

        asort($list);

		return $list;
    }
    /**
     * Widgets by Category
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return string
     */
    public static function widgetsByCategory(){

        $permissions = json_decode(user()->plan()['permission'], true);

        $bioblocks = $permissions['bioblocks'] ?? null;
        
        $widgets = [];
        foreach(self::widgets() as $name => $widget){
            
            if((isset($bioblocks['enabled']) && !$bioblocks['enabled'])){
                
                $widget['available'] = false;

            }elseif(isset($bioblocks['custom']) && !empty($bioblocks['custom'])){

                $list = explode(',', $bioblocks['custom']);

                if(!in_array($name, $list)) $widget['available'] = false;
            }
            
            $widgets[$widget['category']][$name] = $widget;
        }
        return $widgets;
    }
    /**
     * Render Block
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function render($id, $value){

        if(isset(config('bio')->blocked) && in_array($value['type'], config('bio')->blocked)) return;

        if(self::isCountryAllowed($value) == false) return;

        if(self::isLanguageAllowed($value) == false) return;

        if(self::isScheduled($value) == false) return;

        if($class = self::widgets($value['type'], 'block')){
            if(self::$preview){
                if(isset($value['active']) && !$value['active']){
                    return '<p class="small mt-2">'.e('Preview Only - The following block is hidden in live Bio Page.').'</p><div class="item mb-3">'.call_user_func($class, $id, $value).'</div>';
                }
            }else{
                if(isset($value['active']) && !$value['active']) return;
            }
            return '<div class="item mb-3">'.call_user_func($class, $id, $value).'</div>';
        }
    }
    /**
     * Processors
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $data
     * @param [type] $url
     * @return void
     */
    public static function processors($profile, $url, $user){

        $profiledata = json_decode($profile->data, true);
        foreach($profiledata['links'] as $id => $block){
            if($class = self::widgets($block['type'], 'processor')){
                if(isset($block['active']) && !$block['active']) continue;
                call_user_func($class, $block, $profile, $url, $user);
            }
        }
    }
    /**
     * Validate data and update block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param \Core\Request $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function update(Request $request, $profiledata, $data){

        // Validate Geo Data
        if(isset($data['countries']) && $data['countries']){
            foreach($data['countries'] as $country){
                if(!in_array($country, \Core\Helper::Country(false))) throw new Exception(e('{b} Error: One or more countries are invalid.', null, ['b' => e('Tagline')]));
            }
        }else{
            $data['countries'] = [];
        }

        if(!isset($data['languages'])) $data['languages'] = [];
        if($class = self::widgets($data['type'], 'save')){
            return call_user_func($class, $request, $profiledata, $data);
        }
    }
    /**
     * Delete Block
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param \Core\Request $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function delete($profiledata, $data){
        if($class = self::widgets($data['type'], 'delete')){
            return call_user_func($class, $profiledata, $data);
        }
    }
    /**
     * Check if block has country restrictions
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param array $data
     * @return boolean
     */
    public static function isCountryAllowed($data){

        if(!isset($data['countries']) || empty($data['countries']) || !is_array($data['countries'])) return true;

        $location = request()->country();

        if($location['country'] && $data['countries'] && in_array($location['country'], $data['countries'])) return true;

        return false;
    }
    /**
     * Check if block has language restrictions
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param array $data
     * @return boolean
     */
    public static function isLanguageAllowed($data){

        if(!isset($data['languages']) || empty($data['languages']) || !is_array($data['languages'])) return true;

        $request = request();

        $browser_language = $request->server('http_accept_language') ? substr($request->server('http_accept_language'), 0, 2) : null;

        if($browser_language && strpos($browser_language, ' ') !== false){
            $language = strtolower(implode(' ', explode(' ', $browser_language, -1)));
        } else {
            $language = $browser_language ? strtolower($browser_language) : null;
        }

        if($language && $data['languages'] && in_array($language, $data['languages'])) return true;

        return false;
    }
    /**
     * Check if Scheduled
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param array $data
     * @return boolean
     */
    public static function isScheduled($data){

        $currenttime = strtotime('now');

        $displayed = true;

        if(isset($data['startdate']) && strtotime($data['startdate']) && $currenttime <= strtotime($data['startdate'])) $displayed = false;

        if(isset($data['enddate']) && strtotime($data['enddate']) && $currenttime >= strtotime($data['enddate'])) $displayed = false;

        return $displayed;
    }
    /**
     * Remove Lines
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @param string $string
     * @return string
     */
    public static function format(string $string){
        return preg_replace("/[\n\r\t]/", "", $string);
    }
    /**
     * Translate for Javascript
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $string
     * @return void
     */
    public static function e($string, $plural = null, $vars = []){
        return addslashes(e($string, $plural, $vars));
    }
    /**
     * Generate lists
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5
     * @return void
     */
    public function lists(){
        echo 'var listcountries = '.json_encode(\Core\Helper::Country(false)).';';
        echo 'var listlanguage = '.json_encode(\Helpers\App::languagelist(null, false, true)).';';
        echo self::format("function countryInit(did, content){
                var countriesSelect = document.getElementById('countries-'+did);
                for(const [key, country] of Object.entries(listcountries)) {
                    var option = document.createElement('option');
                    option.value = country;
                    option.text = country;
                    if (content && content.countries && content.countries.indexOf(country) !== -1) {
                        option.selected = true;
                    }
                    countriesSelect.appendChild(option);
                }
            }");;
        echo self::format("function languageInit(did, content){
            var languagesSelect = document.getElementById('languages-'+did);
            for(const [key, language] of Object.entries(listlanguage)) {
                var option = document.createElement('option');
                option.value = key;
                option.text = language;
                if (content && content.languages &&  content.languages.includes(key)) {
                    option.selected = true;
                }
                languagesSelect.appendChild(option);
            }
        }");
    }
    /**
     * Generate Template
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @param array $fields
     * @return string
     */
    public static function generateTemplate(string $fields, $type = null){
        return '<form method="post" data-trigger="saveblock" data-id="\'+did+\'" class="parent-block '.($type && $type != 'tagline' ? 'sortable' : '').'"><div class="px-1 pt-2 pb-1 border rounded rounded-4 widget mb-3" data-id="\'+did+\'">
                    <div class="d-flex align-items-center">
                    '.($type && !in_array($type, ['tagline', 'intercom', 'tawkto', 'tidio']) ? '<span class="handle ms-1" data-bs-toggle="tooltip" title="'.self::e('Move').'"><i class="fs-4 fa fa-grip-vertical"></i></span>' : '').'
                        <div class="ms-auto d-flex align-items-center">
                            <a class="ms-auto fs-6 pe-2" data-bs-toggle="modal" data-bs-target="#removecard" data-trigger="removeCard" href=""><i class="fa fa-times text-dark fs-4" data-bs-toggle="tooltip" title="'.self::e('Delete').'"></i></a>
                        </div>
                    </div>
                    <div class="card rounded-4 mt-2 mb-0 p-2 shadow-sm border flex-fill">
                        <div class="d-flex align-items-center">
                            <div class="mb-0 flex-fill"><a class="text-dark d-block py-1" data-bs-toggle="collapse" data-bs-target="#container-\'+did+\'" aria-expanded="false"><h5 class="my-0"><i class="fa fa-chevron-down me-2"></i><span class="small-icon">\'+$(\'[data-type="'.$type.'"] .icon\').html()+\'</span><span class="align-top fw-bold">\'+$(\'[data-type="'.$type.'"] h5\').text()+\'</span></h5> <p class="text-muted mb-0 text-small small">\'+blockpreview+\'</p></a></div>
                            \'+(typeof clicks !== "undefined" && clicks !== null ? \'<div class="me-4"><span class="text-muted"><i class="fa fa-mouse me-1"></i> \'+(urlid !== null ? \'<a href="\'+appurl+\'\'+urlid+\'/stats" class="text-muted text-small" target="_blank" data-bs-toggle="tooltip" title="'.self::e('View Stats').'">\'+clicks+\' '.self::e('Clicks').'</a>\' : clicks)+\' </span></div>\' : \'\')+\'
                            <div class="ms-auto">
                                <div class="form-check form-switch">
                                    <input class="form-check-input form-check-input-lg mt-0 cursor-pointer" type="checkbox" data-enable="\'+slug(did)+\'" data-binary="true" name="data[\'+slug(did)+\'][active]" value="1" data-bs-toggle="tooltip" title="'.self::e('Toggle Block').'" \'+(!content || typeof content === undefined  ? \'checked\' : \'\')+\' \'+(content && content[\'active\'] && content[\'active\'] ==\'1\' ? \'checked\' : \'\')+\'>
                                </div>
                            </div>
                        </div>
                        <div class="collapse mt-2" id="container-\'+did+\'">
                            <input type="hidden" name="data[\'+slug(did)+\'][type]" value="'.$type.'">
                            '.$fields.'                            
                            <div class="collapse mt-2" id="advanced-\'+did+\'">
                                <div class="form-group mt-4 border rounded p-2">
                                    <label class="form-label fw-bold">'.self::e('Geo Targeting').'</label>
                                    <p class="form-text">'.self::e('Display this block for specific countries').'</p>
                                    <div class="input-select">
                                        <select name="data[\'+slug(did)+\'][countries][]" class="form-control" id="countries-\'+did+\'" data-toggle="select" multiple placeholder="e.g. United States">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt-4 border rounded p-2">
                                    <label class="form-label fw-bold">'.self::e('Language Targeting').'</label>
                                    <p class="form-text">'.self::e('Display this block for specific languages').'</p>
                                    <div class="input-select">
                                        <select name="data[\'+slug(did)+\'][languages][]" class="form-control"  id="languages-\'+did+\'" data-toggle="select" multiple placeholder="e.g. English">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt-4 border rounded p-2">
                                    <label class="form-label fw-bold">'.self::e('Schedule').'</label>
                                    <p class="form-text">'.self::e('Schedule when this blocks goes live and ends').'</p>
                                    <div class="d-block d-sm-flex">
                                        <div class="flex-fill mb-2">
                                            <label class="form-label">'.self::e('Start').'</label>
                                            <input name="data[\'+slug(did)+\'][startdate]" class="form-control p-2 me-0 me-sm-1" data-toggle="biodatepicker" placeholder="e.g. 2023-01-01" value="\'+(content && content[\'startdate\'] ? content[\'startdate\'] : \'\')+\'" autocomplete="off">
                                        </div>
                                        <div class="flex-fill mb-2">
                                            <label class="form-label">'.self::e('End').'</label>
                                            <input name="data[\'+slug(did)+\'][enddate]" class="form-control p-2 ms-0 ms-sm-1" data-toggle="biodatepicker" placeholder="e.g. 2023-03-01" value="\'+(content && content[\'enddate\'] ? content[\'enddate\'] : \'\')+\'" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                '.($type == 'link' ? '
                                <div class="form-group mt-4 border rounded p-2">
                                    <label class="form-label fw-bold">'.self::e('Gate Access').'</label>
                                    <p class="form-text">'.self::e('Visitors can be gated before accessing the link. Please note that you can only activate one at a time.').'</p>
                                    <div class="d-flex">
                                        <div>
                                            <label class="form-check-label fw-bold">'.self::e('Sensitive Content').'</label>
                                            <p class="form-text">'.self::e('Visitors must acknowledge that the link may contain sensitive content').'</p>
                                        </div>
                                        <div class="form-check form-switch ms-auto">
                                            <input class="form-check-input" type="checkbox" data-binary="true" name="data[\'+slug(did)+\'][sensitive]" value="1" data-toggle="togglefield" data-toggle-for="sensitivemessage-\'+slug(did)+\'" \'+(content && content[\'sensitive\'] && content[\'sensitive\'] ==\'1\' ? \'checked\' : \'\')+\'>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 \'+(content && content[\'sensitive\'] && content[\'sensitive\'] ==\'1\' ? \'\' : \'d-none\')+\'">
                                        <label class="form-label">'.self::e('Custom Message').'</label>
                                        <textarea class="form-control" name="data[\'+slug(did)+\'][sensitivemessage]" id="sensitivemessage-\'+slug(did)+\'">\'+(content && content[\'sensitivemessage\'] ? content[\'sensitivemessage\'] : \'\')+\'</textarea>
                                    </div>
                                    <div class="d-flex">
                                        <div>
                                            <label class="form-check-label fw-bold">'.self::e('Subscribe').'</label>
                                            <p class="form-text">'.self::e('Visitors must subscribe before being redirected').'</p>
                                        </div>
                                        <div class="form-check form-switch ms-auto">
                                            <input class="form-check-input" type="checkbox" data-binary="true" name="data[\'+slug(did)+\'][subscribe]" value="1" \'+(content && content[\'subscribe\'] && content[\'subscribe\'] ==\'1\' ? \'checked\' : \'\')+\'>
                                        </div>
                                    </div>
                                </div>' : '').'
                            </div>
                            <div class="d-md-flex align-items-center">
                                <button type="button" data-bs-toggle="collapse" data-bs-target="#advanced-\'+did+\'" class="w-100 btn bg-white border fw-bold shadow-sm mt-3 py-2 px-3 rounded-3 me-1"><i class="fa fa-cog me-2"></i> '.self::e('Advanced Settings').'</button>
                                <button type="submit" data-trigger="savewidget" data-id="\'+did+\'" class="w-100 btn btn-primary mt-3 ms-1 rounded-3 px-5 py-2 shadow-sm ms-auto">'.e('Save Changes').'</button>
                            </div>
                        </div>
                    </div>
                </div></form>';
    }
    /**
     * Tagline Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Content
     * @version 7.2
     * @return string
     */
    public static function taglineSetup(){

        $type = 'tagline';

        return "function fntagline(el, content = null, did = null){

            if($('[data-id=bio-tag]').length > 0) {
                $.notify({
                    message: '".self::e('You already have a tagline widget.')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

            if(content){
                var text = content['text'];
            } else {
                var text = '';
            }

            var blockpreview = text;

            if(!did) did = 'tagline';

            if(did == 'bio-tag') did = 'tagline';

            let html = '".self::format(self::generateTemplate('<div class="form-group">
                        <input type="text" class="form-control p-2" name="data['.$type.'][text]" placeholder="e.g. My Bio Page" value="\'+text+\'">
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Tagline
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $value
     * @return void
     */
    public static function taglineSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;
        $data['text'] = clean($data['text']);

        return $data;
    }
    /**
     * Tagline Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $value
     * @return void
     */
    public static function taglineBlock($id, $value){

        if(!$value) return;

        if(isset($value['text']) && !empty($value['text'])){
            return '<p>'.clean($value['text']).'</p>';
        }
    }
    /**
     * Heading Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Content
     * @version 7.2
     * @return string
     */
    public static function headingSetup(){

        $type = 'heading';

        return "function fnheading(el, content = null, did = null){
            var text = '', format, color='#000000';

            if(content){
                var text = content['text'];
                var format = content['format'];
                var color = content['color'];
            }

            var blockpreview = text;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            if(did == 'bio-tag') did = 'tagline';

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Style').'</label>
                                <select name="data[\'+slug(did)+\'][format]" class="form-select mb-2 p-2">
                                    <option value="h1" \'+(format == \'h1\' ? \'selected\':\'\')+\'>H1</option>
                                    <option value="h2" \'+(format == \'h2\' ? \'selected\':\'\')+\'>H2</option>
                                    <option value="h3" \'+(format == \'h3\' ? \'selected\':\'\')+\'>H3</option>
                                    <option value="h4" \'+(format == \'h4\' ? \'selected\':\'\')+\'>H4</option>
                                    <option value="h5" \'+(format == \'h5\' ? \'selected\':\'\')+\'>H5</option>
                                    <option value="h6" \'+(format == \'h6\' ? \'selected\':\'\')+\'>H6</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Text').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][text]" placeholder="e.g. Bio Page" value="\'+text+\'">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold d-block mb-2">'.self::e('Color').'</label>
                                <input type="color" name="data[\'+slug(did)+\'][color]" value="\'+color+\'" class="form-control p-2">
                            </div>
                        </div>
                    </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('[data-id='+did+'] [type=color]').spectrum({
                color: color,
                showInput: true,
                preferredFormat: 'hex',
                move: function (color) { Color('#'+did, color, $(this)); },
                hide: function (color) { Color('#'+did, color, $(this)); }
            });
        }";
    }
    /**
     * Save Heading
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function headingSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;
        $data['format'] = in_array($data['format'], ['h1','h2','h3','h4','h5','h6']) ? $data['format'] : 'h1';
        $data['text'] = clean($data['text']);

        $color = str_replace('#', '', $data['color']);
        $data['color'] = ctype_xdigit($color) && strlen($color) == 6 ? "#{$color}" : "#000000";

        return $data;
    }
    /**
     * Heading Block
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @param mixed $id
     * @param array $value
     * @return string
     */
    public static function headingBlock($id, $value){

        if(in_array($value['format'], ['h1','h2','h3','h4','h5','h6'])){
            return '<'.$value['format'].' style="color:'.($value['color'] ?? 'inherit').' !important">'.$value['text'].'</'.$value['format'].'>';
        }else{
            return '<h1>'.$value['text'].'</h1>';
        }
    }
    /**
     * Divider
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function dividerSetup(){

        $type = 'divider';

        return "function fndivider(el, content = null, did = null){

            if(content){
                var color = content['color'];
                var style = content['style'];
                var height = content['height'];
            } else {
                var color = '#000000';
                var style = 'solid';
                var height = 2;
            }

            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.self::e('Style').'</label>
                                <select name="data[\'+slug(did)+\'][style]" class="form-select mb-2 p-2">
                                    <option value="solid" \'+(style == \'solid\' ? \'selected\':\'\')+\'>'.self::e('Solid').'</option>
                                    <option value="dotted" \'+(style == \'dotted\' ? \'selected\':\'\')+\'>'.self::e('Dotted').'</option>
                                    <option value="dashed" \'+(style == \'dashed\' ? \'selected\':\'\')+\'>'.self::e('Dashed').'</option>
                                    <option value="double" \'+(style == \'double\' ? \'selected\':\'\')+\'>'.self::e('Double').'</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.self::e('Height').'</label>
                                <input type="range" min="1" max="10" class="form-range mt-2" name="data[\'+slug(did)+\'][height]" placeholder="e.g. 5" value="\'+height+\'">
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold d-block mb-2">'.self::e('Color').'</label>
                                <input type="color" name="data[\'+slug(did)+\'][color]" value="\'+color+\'" class="form-control p-2">
                            </div>
                    </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('[data-id='+did+'] [type=color]').spectrum({
                color: color,
                showInput: true,
                preferredFormat: 'hex',
                move: function (color) { Color('#'+did, color, $(this)); },
                hide: function (color) { Color('#'+did, color, $(this)); }
            });
        }";
    }
    /**
     * Save Divider
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function dividerSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;
        $data['style'] = in_array($data['style'], ['solid', 'dotted', 'dashed', 'double']) ? $data['style'] : 'solid';
        $data['height'] = is_numeric($data['height']) && $data['height'] > 1 && $data['height'] < 10 ? $data['height'] : 3;

        $color = str_replace('#', '', $data['color']);
        $data['color'] = ctype_xdigit($color) && strlen($color) == 6 ? "#{$color}" : "#000000";

        return $data;
    }
    /**
     * Divider Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function dividerBlock($id, $value){

        if(!isset($value['height']) || !$value['height'] || !is_numeric($value['height']) || $value['height'] < 1 || $value['height'] > 10) $value['height'] = 2;

        if(!isset($value['style']) || !$value['style'] || !in_array($value['style'], ['solid', 'dotted', 'dashed', 'double'])) $value['style'] = 'solid';

        if(!isset($value['color']) || !$value['color'] || !ctype_xdigit(str_replace('#', '', $value['color']))) $value['style'] = '#000000';

        return '<hr style="background:transparent;border-top-style:'.$value['style'].' !important;border-top-width:'.$value['height'].'px !important;border-top-color:'.$value['color'].' !important;">';
    }
    /**
     * Text Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return string
     */
    public static function textSetup(){

        $type = 'text';

        return "function fntext(el, content = null, did = null){

            if(content){
                var text = content['text'];
            } else {
                var text = '';
            }
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                        <div class="form-group">
                            <textarea id="\'+did+\'_editor" class="form-control p-2" name="data[\'+did+\'][text]" placeholder="e.g. some description here">\'+text+\'</textarea>
                        </div>
                    </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            $('#'+did+'_editor').summernote({
                toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['link','ul', 'ol', 'paragraph']],
                ],
                height: 150
            });
        }";
    }
    /**
     * Save Text
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function textSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;

        if(strlen(clean($data['text'])) > 2000) throw new Exception(e('{b} Error: Text is too long.', null, ['b' => e('Text')]));

        $data['text'] =  Helper::clean($data['text'], 3, false, '<strong><i><a><b><u><img><iframe><ul><ol><li><p><span>');

        return $data;
    }
    /**
     * Text Block
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function textBlock($id, $value){
        return $value['text'];
    }
    /**
     * Link Block Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function linkSetup(){

        $type = 'link';

        return "function fnlink(el, content = null, did = null){

            var text = '', link = '', animation = '', icon = '', urlid = null, clicks = 0, opennew = 0, iconmode = 'none';

            if(content){
                var text = content['text'];
                var icon = content['icon'];
                var animation = content['animation'];
                var link = content['link'];
                var urlid = content['urlid'];
                var clicks = content['clicks'];
                var opennew = content['opennew'];
                if(icon && !content['iconmode']){
                    var iconmode = 'icon';
                }else{
                    var iconmode = content['iconmode'] ?? 'none';
                }
            }

            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="icon-parent">
                        <div class="icon-selector mb-3">
                            <label class="form-label fw-bold">'.self::e('Icon').'</label>
                            <div class="d-flex bg-light p-2 rounded-3" data-toggle="multibuttons">
                                <a href="#" class="btn flex-fill \'+(iconmode == \'none\' ? \'shadow-sm bg-white border rounded-3 fw-bold active\' : \'\')+\'" data-trigger="icontype"  data-value="none">'.e('None ').'</a>
                                <a href="#\'+did+\'_formicon" data-trigger="icontype" data-value="icon" class="btn flex-fill \'+(iconmode == \'icon\' ? \'shadow-sm bg-white border rounded-3 fw-bold active\' : \'\')+\'">'.e('Icon/Emoji').'</a>
                                <a href="#\'+did+\'_formimage" data-trigger="icontype" data-value="image" class="btn flex-fill \'+(iconmode == \'image\' ? \'shadow-sm bg-white border rounded-3 fw-bold active\' : \'\')+\'">'.e('Image').'</a>
                            </div>
                            <input type="hidden" class="iconmode" name="data[\'+slug(did)+\'][iconmode]" value="\'+iconmode+\'">
                        </div>
                        <div class="form-group mb-3 icon-collapse \'+(iconmode == \'icon\' ? \'\' : \'collapse\')+\'" id="\'+did+\'_formicon">
                            <div class="d-flex align-items-center">
                                <span class="p-3 px-5 border rounded display-4 d-inline-block my-2 iconpicker-component" id="\'+did+\'_icon_preview"><i class="\'+icon+\'"></i></span>
                                <input type="text" class="form-control p-2 ms-2" name="data[\'+slug(did)+\'][icon]" id="\'+did+\'_icon" placeholder="e.g. fab fa-twitter or type an emoji e.g. ✋" value="\'+icon+\'">
                            </div>
                        </div>
                        <div class="form-group mb-3 icon-collapse \'+(iconmode == \'image\' ? \'\' : \'collapse\')+\'" id="\'+did+\'_formimage">
                            <label class="form-label fw-bold">'.self::e('Image').'</label>
                            <div class="mb-2">
                                <label for="iconimage-\'+slug(did)+\'" role="button" class="d-block">
                                    <img src="'.url('content/profiles/').'\'+(content && content[\'image\'] ? content[\'image\'] : \'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAJCAQAAACRI2S5AAAAEklEQVR42mP8/58BL2AcVQAGAHscEfhX5bYNAAAAAElFTkSuQmCC\')+\'" width="100" height="100" class="rounded-3 border shadow-sm" id="iconimage-preview-\'+slug(did)+\'">
                                </label>
                            </div>
                            <div>
                                <label for="iconimage-\'+slug(did)+\'" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2">
                                    '.self::e('Upload Image').'
                                </label>
                                <p class="form-text">'.self::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'</p>
                                <input type="file" name="iconimage[\'+slug(did)+\']" id="iconimage-\'+slug(did)+\'" class="d-none" accept="image/*" data-auto-crop data-ratio="1:1" data-max-size="'.config('sizes')->bio->image.'" data-allowed-extensions="'.config('extensions')->bio->image.'" data-preview-selector="#iconimage-preview-\'+slug(did)+\'" data-error="'.self::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Text').'</label>
                        <input type="text" class="form-control p-2 text" name="data[\'+slug(did)+\'][text]" value="\'+text+\'" placeholder="e.g. My Site">
                    </div>
                    <div class="mt-3">
                        <div class="form-group">
                            <div class="d-flex">
                                <label class="form-label fw-bold">'.self::e('Link').'</label>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input" type="checkbox" data-binary="true" id="data[\'+slug(did)+\'][opennew]" name="data[\'+slug(did)+\'][opennew]" value="1"\'+(opennew == 1 ? \'checked\': \'\')+\'>
                                    <label class="form-check-label fw-bold" for="data[\'+slug(did)+\'][opennew]">'.self::e('New window').'</label>
                                </div>
                            </div>
                            <input type="text" class="form-control p-2 text" name="data[\'+slug(did)+\'][link]" value="\'+link+\'" placeholder="e.g. https://google.com">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Animation').'</label>
                                <select name="data[\'+slug(did)+\'][animation]" class="animation form-select mb-2 p-2">
                                <option value="none" \'+(animation == \'none\' ? \'selected\':\'\')+\'>'.self::e('None').'</option>
                                <option value="shake" \'+(animation == \'shake\' ? \'selected\':\'\')+\'>'.self::e('Shake').'</option>
                                <option value="scale" \'+(animation == \'scale\' ? \'selected\':\'\')+\'>'.self::e('Scale').'</option>
                                <option value="jello" \'+(animation == \'jello\' ? \'selected\':\'\')+\'>'.self::e('Jello').'</option>
                                <option value="vibrate" \'+(animation == \'vibrate\' ? \'selected\':\'\')+\'>'.self::e('Vibrate').'</option>
                                <option value="wobble" \'+(animation == \'wobble\' ? \'selected\':\'\')+\'>'.self::e('Wobble').'</option>
                            </select>
                        </div>
                    </div>
                  </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            if(isEmoji(icon)){
                $('#'+did+'_icon_preview i').attr('class','').text(icon);
            }

            $('#'+did+'_icon').iconpicker();

            $('#'+did+'_icon').change(function(){
                if(isEmoji($(this).val())){
                    $('#'+did+'_icon').val($(this).val());
                    $('#'+did+'_icon_preview i').attr('class','').text($(this).val());
                }
            });
            $('#'+did+'_icon').on('iconpickerSelected', function(){
                $('#'+did+'_icon_preview i').attr('class', $(this).val()).text('');
                $('#'+did+'_icon').val($(this).val());
            });

            $('#'+did+'_link').change(function(e){
                if($(this).val() == ''){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            });
        }";
    }
    /**
     * Save Link
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function linkSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;

        $data['iconmode'] = in_array($data['iconmode'], ['none', 'icon', 'image']) ? $data['iconmode'] : 'none';

        $data['opennew'] = $data['opennew'] == '1' ? 1 : 0;

        $data['sensitive'] = $data['sensitive'] == '1' ? 1 : 0;

        $data['subscribe'] = $data['subscribe'] == '1' ? 1 : 0;

        $data['animation'] = in_array($data['animation'], ['shake','wobble','vibrate','jello','scale']) ? $data['animation'] : 'none';

        $data['icon'] = clean($data['icon']);

        $data['sensitivemessage'] = Helper::clean($data['sensitivemessage'], 3);

        if($data['sensitive'] && $data['subscribe']) throw new Exception(e('{b} Error: You can either enable Sensitive Content or Subscribe gate but not both.', null, ['b' => e('Link')]));

        $user = Auth::user();

        $profileid = $request->segment(3);

        $self = new self();

        $data['urlid'] = $profiledata['links'][$data['id']]['urlid'] ?? null; 
    
        if($data['link']){

            if(!Helper::isURL($data['link'])) throw new Exception(e('{b} Error: Please enter a valid URL.', null, ['b' => e('Link')]));

            if(isset($data['urlid'])){

                $currenturl = DB::url()->where('userid', $user->rID())->where('id', $data['urlid'])->first();

                if(!$currenturl){

                    if(
                        $self->domainBlacklisted($data['link']) ||
                        $self->wordBlacklisted($data['link']) ||
                        !$self->safe($data['link']) ||
                        $self->phish($data['link']) ||
                        $self->virus($data['link'])
                    ) {
                        throw new Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $newlink = DB::url()->create();
                    $newlink->url = Helper::clean($data['link'], 3);
                    $newlink->userid = $user->rID();
                    $newlink->alias = null;
                    $newlink->custom = null;
                    $newlink->date = Helper::dtime();
                    $newlink->profileid = $profileid;
                    $newlink->save();
                    $data['urlid'] = $newlink->id;

                }else{

                    if(
                        $self->domainBlacklisted($data['link']) ||
                        $self->wordBlacklisted($data['link']) ||
                        !$self->safe($data['link']) ||
                        $self->phish($data['link']) ||
                        $self->virus($data['link'])
                    ) {
                        throw new Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $currenturl->url = Helper::clean($data['link'], 3);

                    if(!$currenturl->profileid) {
                        $currenturl->date = Helper::dtime();
                        $currenturl->profileid = $profileid;
                    }

                    $currenturl->save();
                }

            }else {

                if(
                    $self->domainBlacklisted($data['link']) ||
                    $self->wordBlacklisted($data['link']) ||
                    !$self->safe($data['link']) ||
                    $self->phish($data['link']) ||
                    $self->virus($data['link'])
                ) {
                    throw new Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                }

                $newlink = DB::url()->create();
                $newlink->url = Helper::clean($data['link'], 3);
                $newlink->userid = $user->rID();
                $newlink->alias = null;
                $newlink->custom = null;
                $newlink->date = Helper::dtime();
                $newlink->profileid = $profileid;
                $newlink->save();
                $data['urlid'] = $newlink->id;
            }
        }

        if(isset($profiledata['links'][$data['id']]['image'])){
            $data['image'] = $profiledata['links'][$data['id']]['image'];
        }
        $appConfig = appConfig('app');
        $extensions = config('extensions');
        $sizes = config('sizes');

        if($data['iconmode'] == 'image' && $file = $request->file('iconimage')){

            if(isset($file[$data['id']])){

                $image = $file[$data['id']];

                if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->link)) || $image->sizekb > $sizes->bio->link) {
                    throw new Exception(e('Image must be either a GIF, PNG or a JPEG (Max {s}kb).', null, ['s' =>  $sizes->bio->link]));
                }

                $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

                if(!file_exists($directory)){
                    mkdir($directory, 0775);
        
                    $f = fopen($directory.'/index.html', 'w');
                    fwrite($f, '');
                    fclose($f);
                }

                $filename = date('Y-m-d')."/profile_linktype_".Helper::rand(6).md5(microtime(false)).'.'.$image->ext;

                $request->move($image, $appConfig['storage']['profile']['path'], $filename);

                if(isset($profiledata['links'][$data['id']]['image']) && $profiledata['links'][$data['id']]['image']){
                    App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$data['id']]['image']);
                }

                $data['icon'] = '';
                $data['image'] = $filename;
            }
        }

        if($data['iconmode'] !== 'image'){
            if(isset($profiledata['links'][$data['id']]['image']) && $profiledata['links'][$data['id']]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$data['id']]['image']);
                $data['image'] = '';
            }
        }

        return $data;
    }

    /**
     * Delete Link Block Images
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data
     * @return void
     */
    public static function linkDelete($id, $value){
        if(isset($value['image']) && $value['image']){
            $appConfig = appConfig('app');
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
    }
    /**
     * Process Links
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function linkProcessor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){
            if($request->action == "clicked" && $request->blockid && is_numeric($request->blockid)){

                \Gem::addMiddleware('BlockBot');

                if($link = \Core\DB::url()->where('id', $request->blockid)->first()){
                    (new BioWidgets)->updateStats($request, $link, $user);
                    return Response::factory('success')->exit();
                } else {
                    return Response::factory('error')->exit();
                }
            }

            if($request->action == "newslettergate"){

                if(!$request->email || !$request->validate($request->email, 'email')) {
                    Response::factory(['error' => true, 'message' => e('Please enter a valid email.')])->json();
                    exit;
                }

                $resp = json_decode($profile->responses, true);

                if(!isset($resp['newsletter']) || !in_array($request->email, $resp['newsletter'])){
                    $resp['newsletter'][] = clean($request->email);

                    $profile->responses = json_encode($resp);
                    $profile->save();
                }

                \Gem::addMiddleware('BlockBot');

                if($link = \Core\DB::url()->where('id', $request->blockid)->first()){
                    (new BioWidgets)->updateStats($request, $link, $user);
                    Response::factory(['error' => false, 'message' => e('You have been subscribed successfully'), 'html' => "<script>window.location = '".$link->url."';</script>"])->json();
                    exit;
                } else {
                    Response::factory(['error' => true, 'message' => e('An error occurred. Please try again.')])->json();                
                    exit;
                }
            }
        }
    }
    /**
     * Link Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function linkBlock($id, $value){

        if(!isset($value['urlid'])) return;

        $value['animation'] = isset($value['animation']) && in_array($value['animation'], ['shake','wobble','vibrate','jello','scale']) ? ' animate_'.$value['animation'] : '';

        if(isset($value['sensitive']) && $value['sensitive']){
            $html ='<a href="#" data-toggle="modal" data-bs-toggle="modal" data-target="#modal-'.$id.'" data-bs-target="#modal-'.$id.'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative'.$value['animation'].'">';

            if((!isset($value['iconmode']) && $value['icon']) || (isset($value['iconmode']) && $value['iconmode'] == 'icon' && $value['icon'])){
                if(preg_match('/[\x{1F600}-\x{1F64F}|\x{1F300}-\x{1F5FF}|\x{1F680}-\x{1F6FF}|\x{1F700}-\x{1F77F}|\x{1F780}-\x{1F7FF}|\x{1F800}-\x{1F8FF}|\x{1F900}-\x{1F9FF}|\x{1FA00}-\x{1FA6F}|\x{1FA70}-\x{1FAFF}|\x{1FB00}-\x{1FBFF}]/u', $value['icon']) && !preg_match('/fa-/u', $value['icon'])){
                    $html.='<span class="position-absolute start-0 left-0 top-50 translate-middle-y ms-0 ml-2 display-6">'.$value['icon'].'</span>';
                } else {
                    $html.='<i class="'.$value['icon'].' position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3"></i>';
                }
            }
            if(isset($value['iconmode']) && $value['iconmode'] == 'image' && isset($value['image']) && $value['image']){
                $html.='<img src="'.uploads($value['image'], 'profile').'" class="position-absolute start-0 left-0 top-50 translate-middle-y">';
            }

            $html.='<span class="align-top">'.$value['text'].'</span>
            </a>
            <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            '.(isset($value['sensitivemessage']) && !empty($value['sensitivemessage']) ? $value['sensitivemessage'] : e('This link may contain inappropriate content not suitable for all ages.')).'
                        </div>
                        <div class="modal-body">
                            <a href="'.$value['link'].'" '.(isset($value['opennew']) && $value['opennew'] ? 'target="_blank"' : '').' rel="nofollow" data-blockid="'.$value['urlid'].'" class="btn btn-dark text-white rounded-pill w-100 d-block py-2">'.self::e('Continue').'</a>
                        </div>
                    </div>
                </div>
            </div>';
            return $html;
        }

        if(isset($value['subscribe']) && $value['subscribe']){
            $html ='<a href="#" data-toggle="modal" data-bs-toggle="modal" data-target="#modal-'.$id.'" data-bs-target="#modal-'.$id.'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative'.$value['animation'].'">';

            if((!isset($value['iconmode']) && $value['icon']) || (isset($value['iconmode']) && $value['iconmode'] == 'icon' && $value['icon'])){
                if(preg_match('/[\x{1F600}-\x{1F64F}|\x{1F300}-\x{1F5FF}|\x{1F680}-\x{1F6FF}|\x{1F700}-\x{1F77F}|\x{1F780}-\x{1F7FF}|\x{1F800}-\x{1F8FF}|\x{1F900}-\x{1F9FF}|\x{1FA00}-\x{1FA6F}|\x{1FA70}-\x{1FAFF}|\x{1FB00}-\x{1FBFF}]/u', $value['icon']) && !preg_match('/fa-/u', $value['icon'])){
                    $html.='<span class="position-absolute start-0 left-0 top-50 translate-middle-y ms-0 ml-2 display-6">'.$value['icon'].'</span>';
                } else {
                    $html.='<i class="'.$value['icon'].' position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3"></i>';
                }
            }
            if(isset($value['iconmode']) && $value['iconmode'] == 'image' && isset($value['image']) && $value['image']){
                $html.='<img src="'.uploads($value['image'], 'profile').'" class="position-absolute start-0 left-0 top-50 translate-middle-y">';
            }

            $html.='<span class="align-top">'.$value['text'].'</span></a>
            <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bolder">'.self::e('Subscribe to unlock').'</h5>
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="" data-trigger="server-form">
                                <div class="form-group position-relative mb-2">
                                    <input type="email" class="form-control p-3" name="email" placeholder="'.self::e('Please enter a valid email').'" data-error="'.self::e('Please enter a valid email').'" required>
                                    <input type="hidden" name="action" value="newslettergate">
                                    <input type="hidden" name="blockid" value="'.$value['urlid'].'">
                                    <input type="hidden" name="target" value="'.$value['link'].'">
                                    <button type="submit" class="btn btn-secondary btn-sm position-absolute top-50 right-0 end-0 translate-middle-y btn-dark me-2 mr-2">'.self::e('Subscribe').'</button>
                                </div>
                            </form>
                            <span class="text-muted text-start text-left d-block">'.self::e('By subscribing, I agree to the terms and conditions and privacy policy.').'</span>
                        </div>
                    </div>
                </div>
            </div>';
            return $html;
        }

        $html= '<a href="'.$value['link'].'" '.(isset($value['opennew']) && $value['opennew'] ? 'target="_blank"' : '').' rel="nofollow" data-blockid="'.$value['urlid'].'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative'.$value['animation'].'">';

        if((!isset($value['iconmode']) && $value['icon']) || (isset($value['iconmode']) && $value['iconmode'] == 'icon' && $value['icon'])){
            if(preg_match('/[\x{1F600}-\x{1F64F}|\x{1F300}-\x{1F5FF}|\x{1F680}-\x{1F6FF}|\x{1F700}-\x{1F77F}|\x{1F780}-\x{1F7FF}|\x{1F800}-\x{1F8FF}|\x{1F900}-\x{1F9FF}|\x{1FA00}-\x{1FA6F}|\x{1FA70}-\x{1FAFF}|\x{1FB00}-\x{1FBFF}]/u', $value['icon']) && !preg_match('/fa-/u', $value['icon'])){
                $html.='<span class="position-absolute start-0 left-0 top-50 translate-middle-y ms-0 ml-2 display-6">'.$value['icon'].'</span>';
            } else {
                $html.='<i class="'.$value['icon'].' position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3"></i>';
            }
        }

        if(isset($value['iconmode']) && $value['iconmode'] == 'image' && isset($value['image']) && $value['image']){
            $html.='<img src="'.uploads($value['image'], 'profile').'" class="position-absolute start-0 left-0 top-50 translate-middle-y">';
        }

        $html.='<span class="align-top">'.$value['text'].'</span></a>';

        return $html;
    }

    /**
     * Whatsapp Call Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function whatsappcallSetup(){

        $type = 'whatsappcall';

        return "function fnwhatsappcall(el, content = null, did = null){

            var label = '', phone = '';

            if(content){
                var label = content['label'];
                var phone = content['phone'];
            }

            var blockpreview = phone;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Phone').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][phone]" placeholder="e.g. +123456789" value="\'+phone+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Call us" value="\'+label+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Whatsapp
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function whatsappcallSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;

        $data['phone'] = clean($data['phone']);

        $data['label'] = Helper::clean($data['label'], 3);

        return $data;
    }
    /**
     * Whatsapp Calls Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function whatsappcallBlock($id, $value){
        return '<a href="https://wa.me/'.(str_replace([' ', '-'], '', $value['phone'])).'" class="btn btn-block d-block p-3 btn-custom position-relative"><img src="'.assets('images/whatsapp.svg').'" height="26" class="ms-2 ml-2 position-absolute left-0 start-0"> '.(isset($value['label']) && $value['label'] ? $value['label'] : $value['phone']).'</a>';
    }
    /**
     * Whatsapp Messages Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function whatsappSetup(){

        $type = 'whatsapp';

        return "function fnwhatsapp(el, content = null, did = null){

            var label = '', phone = '', message='';

            if(content){
                var label = content['label'];
                var phone = content['phone'];
                var message = content['message'];
            }

            var blockpreview = phone;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Phone').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][phone]" placeholder="e.g. +123456789" value="\'+phone+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Call us" value="\'+label+\'">
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Message').'</label>
                        <textarea class="form-control p-2" name="data[\'+slug(did)+\'][message]" placeholder="">\'+message+\'</textarea>
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Whatsapp
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function whatsappSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;

        if(strlen(clean($data['message'])) > 1000) throw new Exception(e('{b} Error: Text is too long.', null, ['b' => e('Whatsapp Message')]));

        $data['phone'] = clean($data['phone']);

        $data['label'] = Helper::clean($data['label'], 3);

        $data['message'] = Helper::clean($data['message'], 3);

        return $data;
    }
    /**
     * Whatsapp Message
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function whatsappBlock($id, $value){
        return '<a href="https://wa.me/'.(str_replace([' ', '-'], '', $value['phone'])).'?text='.urlencode(clean($value['message'], 3)).'" class="btn btn-block d-block p-3 btn-custom position-relative"><img src="'.assets('images/whatsapp.svg').'" height="26" class="ms-2 position-absolute start-0 ml-2 left-0"> '.(isset($value['label']) && $value['label'] ? $value['label'] : $value['phone']).'</a>';
    }
    /**
     * Call Phone Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function phoneSetup(){

        $type = 'phone';

        return "function fnphone(el, content = null, did = null){

            var label = '', phone = '';

            if(content){
                var label = content['label'];
                var phone = content['phone'];
            }

            var blockpreview = phone;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Phone').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][phone]" placeholder="e.g. +123456789" value="\'+phone+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Call us" value="\'+label+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Phone Call
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function phoneSave($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;

        $data['phone'] = clean($data['phone']);

        $data['label'] = Helper::clean($data['label'], 3);

        return $data;
    }
    /**
     * Phone Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function phoneBlock($id, $value){
        return '<a href="tel:'.(str_replace([' ', '-'], '', $value['phone'])).'" class="btn btn-block d-block p-3 btn-custom position-relative"><i class="fa fa-phone ms-2 position-absolute start-0 ml-2 left-0"></i> '.(isset($value['label']) && $value['label'] ? $value['label'] : $value['phone']).'</a>';
    }
    /**
     * Spotify Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function spotifySetup(){

        $type = 'spotify';

        return "function fnspotify(el, content = null, did = null){
            let regex = /^https:\/\/open.spotify.com\/(track|playlist|episode|album)\/([a-zA-Z0-9]+)(.*)$/i;

            var link = '';
            if(content){
                var link = content['link'];
            }

            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://open.spotify.com/..." value="\'+link+\'">
                    <p class="form-text">'.self::e('You can add a link to a spotify song, a playlist or a podcast.').'</p>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Spotify track, playlist or podcast link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Spotify Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function spotifySave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https:\/\/open.spotify.com\/(track|playlist|episode|album)\/([a-zA-Z0-9]+)(.*)$/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Spotify track, playlist or podcast link'));
        }

        return $data;
    }
    /**
     * Spotify Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function spotifyBlock($id, $value){

        if(empty($value['link'])) return;

        preg_match("/^https:\/\/open.spotify.com\/(track|playlist|episode|album)\/([a-zA-Z0-9]+)(.*)$/i", $value['link'], $match);

        if(isset($match[1])){
            if($match[1] == 'playlist'){
                $link = str_replace('/playlist/', '/embed/playlist/', $value['link']);
            }elseif($match[1] == 'episode'){
                $link = str_replace('/episode/', '/embed/episode/', $value['link']);
            }elseif($match[1] == 'album'){
                $link = str_replace('/album/', '/embed/album/', $value['link']);
            }else{
                $link = str_replace('/track/', '/embed/track/', $value['link']);
            }
        }
        return '<iframe width="100%" height="152" style="aspect-ratio: 16/9;" src="'.$link.'" class="rounded rounded-4 btn-custom"></iframe>';
    }
    /**
     * iTunes / Apple Music Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function itunesSetup(){

        $type = 'itunes';

        return "function fnitunes(el, content = null, did = null){

            let regex = /^https:\/\/music.apple.com\/(.*)/i;

            var link = '';
            if(content){
                var link = content['link'];
            }
            var blockpreview = link;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://music.apple.com/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Apple Music link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Itunes Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function itunesSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https:\/\/music.apple.com\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Apple Music link'));
        }

        return $data;
    }
    /**
     * Apple Music Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function itunesBlock($id, $value){
        $link = str_replace('music.apple', 'embed.music.apple', $value['link']);
        return '<iframe width="100%" height="450" style="aspect-ratio: 16/9;" src="'.$link.'" class="rounded rounded-4 btn-custom"></iframe>';
    }
    /**
     * PayPal Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function paypalSetup(){

        $type = 'paypal';
        $list = '';

        foreach (\Helpers\App::currency() as $code => $info){
            $list .= '<option value="'.$code.'"  \'+(currency == \''.$code.'\' ? \'selected\':\'\')+\'>'.$code.' - '.$info["label"].'</option>';
        }

        return "function fnpaypal(el, content = null, did = null){

            if(content){
                var label = content['label'];
                var email = content['email'];
                var amount = content['amount'];
                var currency = content['currency'];
            } else {
                var label = '';
                var email = '';
                var amount = '';
                var currency = '';
            }
            var blockpreview = email;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Label').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Purchase Course" value="\'+label+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Email').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][email]" placeholder="e.g. mybusiness@email.com" value="\'+email+\'">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Amount').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][amount]" placeholder="e.g. 9.99" value="\'+amount+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold d-block mb-2">'.self::e('Currency').'</label>
                            <div class="input-group input-select rounded">
                                <select name="data[\'+slug(did)+\'][currency]" class="form-select mb-2 p-2" data-toggle="select">
                                    '.$list.'
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Paypal
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function paypalSave($request, $profiledata, $data){

        $data['label'] = Helper::clean($data['label'], 3);

        $data['email'] = Helper::clean($data['email'], 3);

        $data['amount'] = (double) Helper::clean($data['amount'], 3);

        if($data['email'] && !Helper::Email($data['email'])) throw new Exception(e('Please enter a valid email'));

        $data['currency'] = strtoupper($data['currency']);

        return $data;
    }
    /**
     * Paypal Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function paypalBlock($id, $value){
        return '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">

            <input type="hidden" name="business" value="'.$value['email'].'">

            <input type="hidden" name="cmd" value="_xclick">

            <input type="hidden" name="item_name" value="'.$value['label'].'">
            <input type="hidden" name="amount" value="'.$value['amount'].'">
            <input type="hidden" name="currency_code" value="'.$value['currency'].'">

            <button type="submit" name="submit" class="btn btn-block d-block p-3 btn-custom w-100">'.$value['label'].'</button>
        </form>';
    }
    /**
     * Tiktok Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function tiktokSetup(){

        $type = 'tiktok';

        return "function fntiktok(el, content = null, did = null){
            let regex = /^https?:\/\/(?:www|m)\.(?:tiktok.com)\/(.*)\/video\/(.*)/i;

            var link = '';
            if(content){
                var link = content['link'];
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://tiktok.com/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid TikTok video link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * TikTok Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function tiktokSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(?:www|m)\.(?:tiktok.com)\/(.*)\/video\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid TikTok video link'));
        }

        return $data;
    }
    /**
     * Tiktok Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function tiktokBlock($id, $value){
        $tid = explode('/', $value['link']);
        $tid = end($tid);
        return '<blockquote class="tiktok-embed rounded btn-custom" cite="'.$value['link'].'" data-video-id="'.$tid.'" style="max-width: 660px;min-width: 325px;"><section></section></blockquote> <script async src="https://www.tiktok.com/embed.js"></script>';
    }
    /**
     * Tiktok Profile Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function tiktokprofileSetup(){

        $type = 'tiktokprofile';

        return "function fntiktokprofile(el, content = null, did = null){
            let regex = /^https?:\/\/(?:www|m)\.(?:tiktok.com)\/@(.*)/i;

            var link = '';
            if(content){
                var link = content['link'];
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://tiktok.com/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid TikTok profile link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Tiktok
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function tiktokprofileSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(?:www|m)\.(?:tiktok.com)\/@(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid TikTok profile link'));
        }

        return $data;
    }
    /**
     * Threads Profile Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function tiktokprofileBlock($id, $value){
        return '<blockquote class="tiktok-embed btn-custom rounded" cite="'.$value['link'].'" data-unique-id="'.str_replace('https://www.tiktok.com/@', '', $value['link']).'" data-embed-type="creator" style="max-width: 660px; min-width: 288px;"><section><a target="_blank" href="'.$value['link'].'?refer=creator_embed">@'.str_replace('https://www.tiktok.com/@', '', $value['link']).'</a> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>';
    }
    /**
     * Youtube Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function youtubeSetup(){

        $type = 'youtube';

        return "function fnyoutube(el, content = null, did = null){
            let regex = /http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/(watch|playlist)\?(v|list)=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/i;

            var link = '';
            if(content){
                var link = content['link'];
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://youtube.com/watch/..." value="\'+link+\'">
                    <p class="form-text">'.self::e('You can add a link to a video or a playlist.').'</p>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Youtube video or playlist link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Youtube Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function youtubeSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/(watch|playlist)\?(v|list)=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Youtube video or playlist link'));
        }

        return $data;
    }
    /**
     * Youtube Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function youtubeBlock($id, $value){

        if(empty($value['link'])) return false;

        preg_match("/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/(watch|playlist)\?(v|list)=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/i", $value['link'], $match);
        if(isset($match[1])){
            if($match[1] == 'playlist'){
                $link = 'https://www.youtube.com/embed/videoseries?list='.$match[3];
            }elseif($match[1] == 'watch') {
                $link = 'https://www.youtube.com/embed/'.$match[3];
            }else {
                $link = 'https://www.youtube.com/embed/'.$match[3];
            }
        }
        return '<iframe width="100%" height="315" style="aspect-ratio: 16/9;" src="'.$link.'" class="rounded btn-custom"></iframe>';
    }
    /**
     * RSS Feed
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function rssSetup(){

        $type = 'rss';

        return "function fnrss(el, content = null, did = null){

            let regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;

            var link = '';
            if(content){
                var link = content['link'];
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://mysite.com/rss" value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid RSS Feed link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Undocumented function
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function rssSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !Helper::isURL($data['link'])) throw new Exception(e('Please enter a valid RSS Feed link'));

        if($data['link'] && \Helpers\App::rss($data['link']) == 'Invalid RSS') throw new Exception(e('Please enter a valid RSS Feed link'));

        return $data;
    }
    /**
     * RSS Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function rssBlock($id, $value){

        $items = \Helpers\App::rss($value['link']);

        $html ='<div class="rss card card-body overflow-auto btn-custom rounded">';
            if(!is_array($items)){
                $html .= $items;
            }else {
                foreach($items as $item){
                    $html .='<div class="media mb-3 text-start text-left">
                        '.(isset($item['image']) && $item['image'] ? '<img class="me-3" src="'.Helper::clean($item['image'], 3).'" alt="'.Helper::clean($item['title'], 3).'">':'').'
                        <div class="media-body">
                            <h6 class="mt-3 fw-bolder"><a href="'.Helper::clean($item['link'], 3).'" target="_blank">'.Helper::clean($item['title'], 3).'</a></h6>
                            '.Helper::clean($item['description'], 3).'
                        </div>
                    </div>';
                }
            }
        $html.='</div>';
        return $html;
    }
    /**
     * Image
     *
     * @author GemPixel <https://gempixel.com>
     * @category Content
     * @version 7.2
     * @return void
     */
    public static function imageSetup(){

        $type = 'image';

        return "function fnimage(el, content = null, did = null){

            if(content){
                var link = content['link'];
                var link2 = content['link2'];
            } else {
                var link = '';
                var link2 = '';
            }

            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);                    

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold d-block">'.self::e('File').' \'+(content && content[\'image\'] ? \'<span class="float-end"><input type="checkbox" name="data[\'+slug(did)+\'][removeimage]" value="1" class="me-1" id="remove-\'+slug(did)+\'"><span class="align-text-bottom">'.self::e('Remove').'</span></span></label>\':\'\')+\'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept=".jpg, .png" data-ratio="16:9" data-max-size="'.config('sizes')->bio->image.'" data-allowed-extensions="'.config('extensions')->bio->image.'" data-preview-selector="#image-preview" data-error="'.self::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'">
                            </div>
                        </div>                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Link').' <small class="text-muted">('.self::e('Optional').')</small></label>
                                <input type="text" class="form-control p-2" id="link-\'+slug(did)+\'" name="data[\'+slug(did)+\'][link]" value="\'+link+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label class="form-label fw-bold d-block">'.self::e('File').' \'+(content && content[\'image2\'] ? \'<span class="float-end"><input type="checkbox" id="link-\'+slug(did)+\'"  name="data[\'+slug(did)+\'][removeimage2]" value="1" class="me-1" id="remove2-\'+slug(did)+\'"><span class="align-text-bottom">'.self::e('Remove').'</span></span></label>\':\'\')+\'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'-2" accept=".jpg, .png" data-ratio="16:9" data-max-size="'.config('sizes')->bio->image.'" data-allowed-extensions="'.config('extensions')->bio->image.'" data-preview-selector="#image2-preview" data-error="'.self::e("Image must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'">
                            </div>
                        </div>                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Link').' <small class="text-muted">('.self::e('Optional').')</small></label>
                                <input type="text" class="form-control p-2" id="link2-\'+slug(did)+\'" name="data[\'+slug(did)+\'][link2]" value="\'+link2+\'">
                            </div>
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            if($('#remove-'+slug(did)).is(':checked')){
                $(this).prop('checked', false).removeAttr('checked');
                $('#link-'+slug(did)).val('');
            }

            if($('#remove2-'+slug(did)).is(':checked')){
                $(this).prop('checked', false).removeAttr('checked');
                $('#link2-'+slug(did)).val('');
            }
        }";
    }
    /**
     * Image Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function imageSave($request, $profiledata, $data){

        $appConfig = appConfig('app');
        
        $sizes = config('sizes');
        $extensions = config('extensions');

        $key = $data['id'];

        if($image = $request->file($key)){

            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->image) {
                throw new Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => explode(',', $extensions->bio->image), 's' => $sizes->bio->image]));
            }

            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
    
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_imagetype".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image']);
            }

            $data['image'] = $filename;

        } else {
            if(isset($profiledata['links'][$key]['image'])) $data['image'] = $profiledata['links'][$key]['image'];
        }

        if($image = $request->file($key.'-2')){

            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->image){
                throw new Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => explode(',', $extensions->bio->image), 's' => $sizes->bio->image]));
            }


            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
    
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_imagetype".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['image2']) && $profiledata['links'][$key]['image2']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image2']);
            }

            $data['image2'] = $filename;

        } else {
            if(isset($profiledata['links'][$key]['image2'])) $data['image2'] = $profiledata['links'][$key]['image2'];
        }

        if(isset($data['removeimage']) && $data['removeimage']){
            if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image']);
            }
            $data['image'] = '';
            $data['link'] = '';
        }

        if(isset($data['removeimage2']) && $data['removeimage2']){
            if(isset($profiledata['links'][$key]['image2']) && $profiledata['links'][$key]['image2']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image2']);
            }
            $data['image2'] = '';
            $data['link2'] = '';
        }

        return $data;
    }
    /**
     * Image Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function imageBlock($id, $value){

        if(!isset($value['image']) || !$value['image']) return;

        if(isset($value['image2']) && $value['image2']){
            return '<div class="row">
                <div class="col-6">
                    '.($value['link'] ? '
                        <a href="'.$value['link'].'" target="_blank" rel="nofollow"><img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid rounded w-100"></a>
                    ' : '
                        <img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid rounded w-100">
                    ').'
                </div>
                <div class="col-6">
                    '.(isset($value['link2']) && $value['link2'] ? '
                        <a href="'.$value['link2'].'" target="_blank" rel="nofollow"><img src="'.uploads($value['image2'], 'profile').'" class="img-responsive img-fluid rounded w-100"></a>
                    ' : '
                        <img src="'.uploads($value['image2'], 'profile').'" class="img-responsive img-fluid rounded w-100">
                    ').'
                </div>
            </div>';
        }else{
            if($value['link']){
                return '<a href="'.$value['link'].'" target="_blank" rel="nofollow"><img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid rounded w-100"></a>';
            } else {
                return '<img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid rounded w-100">';
            }
        }
    }
    /**
     * Delete Image Block
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data containing image paths
     * @return void
     */
    public static function imageDelete($id, $value){
        
        $appConfig = appConfig('app');
        
        if(isset($value['image']) && $value['image']){
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
        
        if(isset($value['image2']) && $value['image2']){
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image2']);
        }
    }
    /**
     * Newsletter
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5.1
     * @return void
     */
    public static function newsletterSetup(){

        $type = 'newsletter';

        return "function fnnewsletter(el, content = null, did = null){

            var text = content ? content['text'] : '';
            var description = content && 'description' in content ? content['description'] : '';
            var disclaimer = content && 'disclaimer' in content ? content['disclaimer'] : '';

            var blockpreview = text;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Text').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][text]" value="\'+text+\'" placeholder="e.g. Subscribe">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Description').' ('.self::e('Optional').')</label>
                                <textarea type="text" class="form-control p-2" name="data[\'+slug(did)+\'][description]">\'+description+\'</textarea>
                            </div>
                        </div>                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Disclaimer').' ('.self::e('Optional').')</label>
                                <textarea type="text" class="form-control p-2" name="data[\'+slug(did)+\'][disclaimer]">\'+disclaimer+\'</textarea>
                                <p class="form-text">'.self::e('You can add your own disclaimer and a checkbox will show up requiring users to check before submitting.').'</p>
                            </div>
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Newsletter
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.1
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function newsletterSave($request, $profiledata, $data){

        $data['text'] = clean($data['text']);
        $data['disclaimer'] = clean($data['disclaimer']);
        $data['description'] = clean($data['description']);

        return $data;
    }
    /**
     * Newsletter Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function newsletterProcessor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){
            if($request->action == 'newsletter'){

                if(!$request->email || !$request->validate($request->email, 'email')) return back()->with('danger', e('Please enter a valid email.'))->exit();

                if(isset($block['disclaimer']) && $block['disclaimer'] && !$request->disclaimer) return back()->with('danger', e('Please accept the disclaimer.'))->exit();

                $resp = json_decode($profile->responses, true);

                if(!isset($resp['newsletter'])) $resp['newsletter'] = [];
                
                if(!in_array($request->email, $resp['newsletter'])){
                    $resp['newsletter'][] = clean($request->email);

                    $profile->responses = json_encode($resp);
                    $profile->save();
                }
                return back()->with('success', e('You have been successfully subscribed.'))->exit();;
            }
        }
    }
    /**
     * Newsletter Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function newsletterBlock($id, $value){

        return '<a href="#" data-bs-target="#N'.$id.'" data-bs-toggle="collapse" data-target="#N'.$id.'" data-toggle="collapse"  role="button" class="btn btn-block p-3 d-block btn-custom position-relative fa-animated collapsed">
                    <span class="align-top">'.($value['text'] ?? e('Subscribe')).'</span>
                    <i class="fa fa-chevron-down position-absolute end-0 me-3 right-0 mr-3"></i>
                </a>
                <form method="post" action="" class="collapse" id="N'.$id.'">
                    <div class="btn-custom rounded p-3 mt-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-fill me-1 mr-1">
                                <input type="email" class="form-control border-0 bg-white p-2" name="email" placeholder="e.g. johnsmith@company.com" required>
                            </div>
                            <div class="ms-auto">
                                <button type="submit" class="btn btn-dark p-2">'.($value['text'] ?? e('Subscribe')).'</button>
                            </div>
                        </div>
                        '.(isset($value['disclaimer']) && $value['disclaimer'] ? '<div class="text-left text-start mt-2"><label><input type="checkbox" name="disclaimer" class="me-2 mr-2" value="1" required> '.$value['disclaimer'].'</label></div>' : '').'
                    </div>
                    <input type="hidden" name="action" value="newsletter">
                    <input type="hidden" name="blockid" value="'.$id.'">
                </form>';
    }
    /**
     * Contact Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5.1
     * @return void
     */
    public static function contactSetup(){

        $type = 'contact';

        return "function fncontact(el, content = null, did = null){

            if(content){
                var text = content['text'];
                var email = content['email'];
            } else {
                var text = '';
                var email = '';
            }

            var disclaimer = content && 'disclaimer' in content ? content['disclaimer'] : '';

            var blockpreview = email;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Text').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][text]" value="\'+text+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Email').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][email]" value="\'+email+\'">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label fw-bold">'.self::e('Disclaimer').' ('.self::e('Optional').')</label>
                        <textarea type="text" class="form-control p-2" name="data[\'+slug(did)+\'][disclaimer]">\'+disclaimer+\'</textarea>
                        <p class="form-text">'.self::e('You can add your own disclaimer and a checkbox will show up requiring users to check before submitting.').'</p>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Contact
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function contactSave($request, $profiledata, $data){

        $data['text'] = clean($data['text']);
        $data['email'] = clean($data['email']);
        $data['disclaimer'] = clean($data['disclaimer']);

        if($data['email'] && !Helper::Email($data['email'])) throw new Exception(e('Please enter a valid email'));

        return $data;
    }
    /**
     * Contact Form Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function contactProcessor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){

            if($request->action == 'contact'){

                \Gem::addMiddleware('ValidateCaptcha');

                if(!$request->email || !$request->validate($request->email, 'email')) return back()->with('danger', e('Please enter a valid email.'))->exit();

                if(isset($block['disclaimer']) && $block['disclaimer'] && !$request->disclaimer) return back()->with('danger', e('Please accept the disclaimer.'))->exit();

                $profiledata = json_decode($profile->data, true);

                $data = $profiledata['links'][$request->blockid];
                $message = clean($request->message);
                $email = clean($request->email);
                $page = \Helpers\App::shortRoute($url->domain??null, $profile->alias);


                $spamConfig = appConfig('app.spamcheck');

                if (preg_match($spamConfig['regex'], $request->message)) {
                    return back()->with('danger', e('Your message has been flagged as potential spam. Please review and try again.'))->exit();
                }
                
                $linkCount = preg_match_all('/(https?:\/\/[^\s]+)/', $request->message, $matches);
        
                if ($linkCount > $spamConfig['numberoflinks']) {
                    return back()->with('danger', e('Your message has been flagged as potential spam. Please review and try again.'))->exit();
                }
                
                if($spamConfig['postmarkcheck']) {
                    $emailContent = "From: ".Helper::RequestClean($request->name)." <".Helper::RequestClean($request->email).">\r\n";
                    $emailContent .= "To: ".config('email')."\r\n";
                    $emailContent .= "Subject: Contact Form Submission\r\n\r\n";
                    $emailContent .= Helper::RequestClean($request->message);
        
                    $response = Http::url('https://spamcheck.postmarkapp.com/filter')->withHeaders(['Accept' => 'application/json','Content-Type' => 'application/json'])->body(['email' => $emailContent, 'options' => 'short']) ->post();
        
                    if ($response && $response->bodyObject()) {
                        $result = $response->bodyObject();
                        if (isset($result->success) && $result->success === true) {
                            if ($result->score >= 5) {
                                return back()->with('danger', e('Your message has been flagged as potential spam. Please review and try again.'))->exit();
                            }
                        }
                    }
                }

                Plugin::dispatch('profile.contacted', [$message, $email, $page]);

                $resp = json_decode($profile->responses, true);

                if(!isset($resp['contactform'])) $resp['contactform'] = [];
                $resp['contactform'][] = [
                    'from' => $email,
                    'message' => $message,
                    'page' => $page,
                    'date' => Helper::dtime()
                ];
                $profile->responses = json_encode($resp);
                $profile->save();

                Emails::setup()
                        ->replyto([Helper::RequestClean($request->email)])
                        ->to($block['email'])
                        ->send([
                            'subject' => '['.config('title').'] You were contacted from your Bio Page: '.$profile->name,
                            'message' => function($template, $block) use ($message, $email, $page){
                                if(config('logo')){
                                    $title = '<img align="center" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" width="166"/>';
                                } else {
                                    $title = '<h3>'.config('title').'</h3>';
                                }

                                return \Core\Email::parse($template, ['content' => "<p>You have received an email from <strong>{$email}</strong> sent via the Bio Page {$page}.</p><strong>Message:</strong><br><p>{$message}</p>", 'brand' => $title]);
                            }
                        ]);
                
                return back()->with('success', e('Message sent successfully.'))->exit();
            }
        }
    }
    /**
     * Contact Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function contactBlock($id, $value){

        return '<a href="#" data-bs-target="#C'.$id.'" data-bs-toggle="collapse" data-target="#C'.$id.'" data-toggle="collapse"  role="button" class="btn btn-block p-3 d-block btn-custom position-relative fa-animated collapsed">
                    <span class="align-top">'.$value['text'].'</span>
                    <i class="fa fa-chevron-down position-absolute end-0 me-3 right-0 mr-3"></i>
                </a>
                <form method="post" action="" id="C'.$id.'" class="btn-custom border-0 collapse rounded rounded-3 text-start text-left p-3 mt-3">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label fw-bold">'.self::e('Email').'</label>
                        <input type="text" class="form-control" name="email" placeholder="johnsmith@company.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label fw-bold">'.self::e('Message').'</label>
                        <textarea class="form-control" name="message" required></textarea>
                    </div>
                    '.(isset($value['disclaimer']) && $value['disclaimer'] ? '<div class="text-left text-start my-2"><label><input type="checkbox" name="disclaimer" class="me-2 mr-2" value="1" required> '.$value['disclaimer'].'</label></div>' : '').'                    
                    '.csrf().'
                    <input type="hidden" name="action" value="contact">
                    <input type="hidden" name="blockid" value="'.$id.'">
                    '.\Helpers\Captcha::display().'
                    <button type="submit" class="btn btn-dark d-block">'.self::e('Send').'</button>
                </form>';
    }
    /**
     * FAQS Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function faqsSetup(){

        $type = 'faqs';

        return "function fnfaqs(el, content = null, did = null){

            if(content){
                var question = content['question'];
                var answer = content['answer'];
            } else {
                var question = [];
                var answer = [];
            }
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="faq-container">\';
                        question.forEach(function(value, i){
                            html += \'<div class="faq-holder row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">'.self::e('Question').'</label>
                                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][question][]" value="\'+value+\'">
                                                <button type="button" data-trigger="deletefaq" class="btn btn-sm btn-danger mt-1 rounded-3">'.self::e('Delete').'</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label class="form-label fw-bold">'.self::e('Answer').'</label>
                                            <textarea class="form-control p-2" name="data[\'+slug(did)+\'][answer][]">\'+answer[i]+\'</textarea>
                                        </div>
                                    </div>
                                </div>\';
                        });
                html += \'</div>
                    <button type="button" data-trigger="addfaq" class="btn btn-dark mt-3 rounded-3">'.self::e('Add FAQ').'</button>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('[data-trigger=addfaq]').click(function(e){
                e.preventDefault();
                $('#container-'+did+' button[data-trigger=addfaq]').before('".self::format('<div class="faq-holder row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Question').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][question][]" value="">
                            <button type="button" data-trigger="deletefaq" class="btn btn-sm btn-danger mt-1 rounded-3">'.self::e('Delete').'</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Answer').'</label>
                            <textarea class="form-control p-2" name="data[\'+slug(did)+\'][answer][]"></textarea>
                        </div>
                    </div>
                </div>')."');
              });
              $(document).on('click','[data-trigger=deletefaq]', function(e){
                    e.preventDefault();
                    $(this).parents('.faq-holder').fadeOut('fast', function(){
                        $(this).remove();
                    })
              });
        }";
    }
    /**
     * Save Faq
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function faqsSave($request, $profiledata, $data){

        $data['question'] = isset($data['question']) && $data['question'] ? array_map('clean', $data['question']) : [];
        $data['answer'] = isset($data['answer']) && $data['answer'] ? array_map(function($value){
            return nl2br(clean($value));
        }, $data['answer']) : [];

        return $data;
    }
    /**
     * FAQS Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function faqsBlock($id, $value){

        if(!isset($value['question'])) return;

        $html = '<div class="btn-custom card d-block border-0 mb-2 faqs">';
        foreach($value['question'] as $i => $question){
            $html .='<div class="card-body text-start text-left">
                <a href="#faq-'.$i.'" class="collapsed fa-animated" data-bs-toggle="collapse" data-toggle="collapse" data-target="#faq-'.$i.'" data-bs-target="#faq-'.$i.'">
                    <h6 class="card-title fw-bold mb-0">
                        <i class="fa fa-chevron-down me-2"></i>
                        <span class="align-middle">'.$question.'</span>
                    </h6>
                </a>
                <div class="collapse pt-3" id="faq-'.$i.'">
                    '.$value['answer'][$i].'
                </div>
            </div>';
        }
        $html .='</div>';

        return $html;
    }
    /**
     * vCard Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function vcardSetup(){

        $type = 'vcard';

        $list = '';
        foreach (\Core\Helper::Country(false) as $country){
            $list .= '<option value="'.$country.'"  \'+(country == \''.$country.'\' ? \'selected\':\'\')+\'>'.$country.'</option>';
        }

        return "function fnvcard(el, content = null, did = null){

            if(content){
                var button = content['button'];
                var fname = content['fname'];
                var lname = content['lname'];
                var phone = content['phone'];
                var cell = content['cell'];
                var fax = content['fax'];
                var email = content['email'];
                var company = content['company'];
                var address = content['address'];
                var city = content['city'];
                var state = content['state'] ?? '';
                var country = content['country'] ?? '';
                var zip = content['zip'];
                var site = content['site'];
                var links = content['links'] ?? [];
            } else {
                var button = '';
                var fname = '';
                var lname = '';
                var phone = '';
                var cell = '';
                var fax = '';
                var company = '';
                var email = '';
                var address = '';
                var city = '';
                var state = '';
                var country = '';
                var site = '';
                var zip = '';
                var links = [];
            }

            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">'.self::e('Picture').' '.self::e('(optional)').'</label>
                        <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept=".jpg, .png">
                    </div>            
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('First Name').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][fname]" value="\'+fname+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Last Name').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][lname]" value="\'+lname+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Email').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][email]" value="\'+email+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Phone').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][phone]" value="\'+phone+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Cellphone').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][cell]" value="\'+cell+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Fax').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][fax]" value="\'+fax+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Company').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][company]" value="\'+company+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Site').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][site]" value="\'+site+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Address').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][address]" value="\'+address+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('City').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][city]" value="\'+city+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('State').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][state]" value="\'+state+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Zip').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][zip]" value="\'+zip+\'">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label fw-bold">'.self::e('Country').'</label>
                        <select class="form-select p-2" name="data[\'+slug(did)+\'][country]">
                            '.$list.'
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][button]" value="\'+button+\'">
                    </div>                    
                    <div class="border p-2 rounded mt-2">
                        <div class="d-flex mb-2">
                            <div><strong>'.self::e('Custom Links').'</strong></div>
                            <a href="#" data-trigger="addcustomlink" class="btn btn-sm btn-primary ms-auto rounded-3">+ '.self::e('Add').'</a>
                        </div>
                        <div class="customlink"></div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            if(links){
                links.forEach(function(link, i){
                    $('#container-'+did+' .customlink').append('".self::format('
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">'.self::e('Text').'</label>
                                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][linktext][]" value="\'+content[\'linktext\'][i]+\'">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][links][]" value="\'+link+\'">
                                </div>
                            </div>
                        </div>
                        <a href="#" data-trigger="deletecustomlink" class="btn btn-sm btn-danger mt-2 rounded-3">'.self::e('Delete').'</a>
                    ')."');
                });
            }


            $('#container-'+did+' [data-trigger=addcustomlink]').click(function(e){
                e.preventDefault();
                $('#container-'+did+' .customlink').append('".self::format('
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Text').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][linktext][]" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Link').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][links][]" value="">
                            </div>
                        </div>
                    </div>
                    <a href="#" data-trigger="deletecustomlink" class="btn btn-sm btn-danger mt-2 rounded-3">'.self::e('Delete').'</a>
                ')."');
            });
            $(document).on('click', '#container-'+did+' [data-trigger=deletecustomlink]',function(e){
                e.preventDefault();
                $(this).prev('.row').fadeOut('fast', function(){
                    $(this).remove();
                });
                $(this).remove();
            });
        }";
    }
    /**
     * vCard Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function vCardSave($request, $profiledata, $data){

        $appConfig = appConfig('app');
        $sizes = config('sizes');
        $extensions = config('extensions');

        $key = $data['id'];

        if($image = $request->file($key)){

            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->avatar)) || $image->sizekb > $sizes->bio->avatar) {
                throw new Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => explode(',', $extensions->bio->avatar), 's' => $sizes->bio->avatar]));
            }

            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
    
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_vcardtype".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image']);
            }

            $data['image'] = $filename;

        } else {
            if(isset($profiledata['links'][$key]['image'])) $data['image'] = $profiledata['links'][$key]['image'];
        }

        // if(isset($data['removeimage']) && $data['removeimage']){
        //     if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
        //         App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image']);
        //     }
        //     $data['image'] = '';
        // }

        return array_map('clean', $data);
    }
    /**
     * Delete vCard Block Images
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data
     * @return void
     */
    public static function vcardDelete($id, $value){
        if(isset($value['image']) && $value['image']){
            $appConfig = appConfig('app');
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
    }
    /**
     * vCard Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function vcardProcessor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){
            if($request->action == 'vcard'){
                
                $data = json_decode($profile->data, true);

                $block = $data['links'][$request->blockid];

                $vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n";
                $vcard .= "REV:".date("Y-m-d")."T".date("H:i:s")."Z\r\n";

                if((isset($block['fname']) && $block['fname']) && (isset($block['lname']) && $block['lname'])){
                    $vcard .= "N;CHARSET=utf-8:{$block['lname']};{$block['fname']}\r\n";
                    $vcard .= "FN;CHARSET=utf-8:{$block['fname']} {$block['lname']}\r\n";
                }
                if(isset($block['company']) && $block['company']){
                    $vcard .= "ORG;CHARSET=utf-8:{$block['company']}\r\n";
                }

                if(isset($block['phone']) && $block['phone']){
                    $vcard .= "TEL;TYPE=work,voice:{$block['phone']}\r\n";
                }
                if(isset($block['cell']) && $block['cell']){
                    $vcard .= "TEL;TYPE=cell,voice:{$block['cell']}\r\n";
                }
                if(isset($block['fax']) && $block['fax']){
                    $vcard .= "TEL;TYPE=fax:{$block['fax']}\r\n";
                }

                if(isset($block['email']) && $block['email']){
                    $vcard .= "EMAIL;TYPE=INTERNET;TYPE=WORK;TYPE=PREF:{$block['email']}\r\n";
                }

                if(isset($block['site']) && $block['site']){
                    $vcard .= "URL;TYPE=work:{$block['site']}\r\n";
                }

                if(isset($block['links']) && isset($block['linktext'])){
                    foreach($block['links'] as $i => $link){
                        $text = str_replace(' ', '', $block['linktext'][$i]);
                        $vcard .= "URL;TYPE={$text}:{$link}\r\n";
                    }
                }
                if(isset($block['address']) && isset($block['city'])){
                    $vcard .= "ADR;TYPE=work:;;{$block['address']};{$block['city']};".(isset($block['state']) ? "{$block['state']};":"")."".(isset($block['zip']) ? "{$block['zip']};":"")."".(isset($block['country']) ? "{$block['country']};":"")."\r\n";
                }

                if(isset($block['image']) && $block['image'] && file_exists(appConfig('app.storage')['profile']['path'].'/'.$block['image'])){
                    $ext = strtoupper(Helper::extension($block['image']));
                    $vcard .="PHOTO;ENCODING=b;TYPE={$ext}:".base64_encode(file_get_contents(appConfig('app.storage')['profile']['path'].'/'.$block['image']))."\r\n";
                }

                $vcard .= "END:VCARD";

                die(\Core\File::contentDownload('vcard.vcf', function() use ($vcard){
                    echo $vcard;
                }));
            }
        }
    }
    /**
     * vCard Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function vcardBlock($id, $value){

        return '<form method="post" action="?downloadvcard">
                    '.csrf().'
                    <input type="hidden" name="action" value="vcard">
                    <input type="hidden" name="blockid" value="'.$id.'">
                    <button type="submit" class="btn btn-custom btn-block d-block w-100 p-3">'.(isset($value['button']) && !empty($value['button']) ? $value['button'] : e('Download vCard')).'</button>
                </form>';
    }
    /**
     * Product Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function productSetup(){

        $type = 'product';

        return "function fnproduct(el, content = null, did = null){

            if(content){
                var text = content['name'];
                var description = content['description'];
                var amount = content['amount'];
                var link = content['link'];
            } else {
                var text = '';
                var description = '';
                var amount = '';
                var link = '';
            }
            var blockpreview = text;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);
            

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.self::e('Name').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. Product" value="\'+text+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.self::e('Description').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][description]" placeholder="e.g. Product description."  value="\'+description+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.self::e('Amount').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][amount]" placeholder="e.g. $9.99" value="\'+amount+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.self::e('Image').'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept=".jpg, .png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.self::e('Link').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" value="\'+link+\'" placeholder="http://">
                            </div>
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Product
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function productSave($request, $profiledata, $data){

        $appConfig = appConfig('app');
        $sizes = config('sizes');
        $extensions = config('extensions');

        $key = $data['id'];

        if($image = $request->file($key)){
            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->avatar){
                throw new Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => explode(',', $extensions->bio->image), 's' => $sizes->bio->avatar]));
            }
            
            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

                if(!file_exists($directory)){
                    mkdir($directory, 0775);
        
                    $f = fopen($directory.'/index.html', 'w');
                    fwrite($f, '');
                    fclose($f);
                }

                $filename = date('Y-m-d')."/profile_producttype".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);
            if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image']);
            }

            $data['image'] = $filename;
        } else {
            $data['image'] = $profiledata['links'][$key]['image'];
        }

        return $data;
    }
    /**
     * Product Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function productBlock($id, $value){
        if(!empty($value['link'])){
            return '<a href="'.$value['link'].'" target="_blank" class="d-block btn-custom rounded rounded-3 p-3 text-start text-left" rel="nofollow">
                <div class="d-flex align-items-center">
                    '.(isset($value['image']) && $value['image'] ? '
                    <div class="mr-3 me-3">
                        <img src="'.uploads($value['image'], 'profile').'" class="rounded" style="max-width: 130px">
                    </div>
                    ' : '').'
                    <div class="text-left text-start">
                        <h4 class="mb-1 fw-bold">'.$value['name'].'</h4>
                        <p class="mb-0">'.$value['description'].'</p>
                        <strong>'.$value['amount'].'</strong>
                    </div>
                </div>
            </a>';
        } else {
            return '<div class="d-block btn-custom rounded rounded-3 p-3 text-start text-left">
                <div class="d-flex align-items-center">
                    '.(isset($value['image']) && $value['image'] ? '
                    <div class="mr-3 me-3">
                        <img src="'.uploads($value['image'], 'profile').'" class="rounded" style="max-width: 130px">
                    </div>
                    ' : '').'
                    <div class="text-left text-start">
                        <h4 class="mb-1 fw-bold">'.$value['name'].'</h4>
                        <p class="mb-0">'.$value['description'].'</p>
                        <strong>'.$value['amount'].'</strong>
                    </div>
                </div>
            </div>';
        }
    }
    /**
     * Delete Prodcut Block Images
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data
     * @return void
     */
    public static function productDelete($id, $value){
        $appConfig = appConfig('app');
        
        // Handle multiple products
        if(isset($value['image']) && is_array($value['image'])){
            foreach($value['image'] as $image){
                if($image){
                    App::delete($appConfig['storage']['profile']['path'].'/'.$image);
                }
            }
        } else if(isset($value['image']) && $value['image']){
            // Handle single product (backward compatibility)
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
    }
    /**
     * HTML Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function htmlSetup(){

        $type = 'html';

        return "function fnhtml(el, content = null, did = null){

            if(content){
                var code = content['html'];
            } else {
                var code = '';
            }
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('HTML').'</label>
                        <textarea class="form-control p-2" name="data[\'+slug(did)+\'][html]" placeholder="e.g. some description here">\'+code+\'</textarea>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save HTML
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profieldata
     * @param [type] $data
     * @return void
     */
    public static function htmlSave($request, $profieldata, $data){
        $data['html'] = Helper::clean($data['html'], 3, false, '<strong><i><a><b><u><img><iframe><ul><ol><li><p><span><br>');
        return $data;
    }
    /**
     * HTML Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function htmlBlock($id, $value){
        return $value['html'];
    }
    /**
     * OpenSea NFT Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function openseaSetup(){

        $type = 'opensea';

        return "function fnopensea(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(opensea.io)\/assets\/(.*)\/(.*)\/(.*)/i;

            var link = '';
            if(content){
                var link = content['link'];
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://opensea.io/assets/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid OpenSea NFT link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save OpenSea
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function openseaSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(opensea.io)\/assets\/(.*)\/(.*)\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid OpenSea NFT link'));
        }

        return $data;
    }
    /**
     * Opensea Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function openseaBlock($id, $value){

        if(empty($value['link'])) return;

        preg_match("/^https?:\/\/(www.)?(opensea.io)\/assets\/(.*)\/(.*)\/(.*)/i", $value['link'], $match);
        return '<nft-card width="100%" contractAddress="'.$match[4].' ?>" tokenId="'.$match[5].' ?>"> </nft-card><script src="https://unpkg.com/embeddable-nfts/dist/nft-card.min.js"></script>';
    }
    /**
     * Twitter Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function twitterSetup(){

        $type = 'twitter';

        return "function fntwitter(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(twitter.com|x.com)\/(.*)/i;

            if(content){
                var link = content['link'];
                var amount = 2;
            } else {
                var link = '';
                var amount = 2;
            }
            var blockpreview = link;

            if(!parseInt(amount)) amount = 1;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Link').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://twitter.com/..." value="\'+link+\'">
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Tweet link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Twitter
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function twitterSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        $data['amount'] = (int) ($data['amount'] ?? 2);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(twitter.com|x.com)\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Tweet link'));
        }

        return $data;
    }
    /**
     * Twitter Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function twitterBlock($id, $value){
        if(!isset($value['amount']) || !$value['amount'] || !is_numeric($value['amount']) || $value['amount'] < 1) $value['amount'] = 1;

        if(!$value['link'] || empty($value['link'])) return '';

        if(preg_match("/^https?:\/\/(www.)?(x.com)\/(.*)/i", $value['link'])) {
            $value['link'] = str_replace('x.com', 'twitter.com', $value['link']);
        }

        return '<a class="twitter-timeline" data-width="100%" data-tweet-limit="'.$value['amount'].'" href="'.$value['link'].'" data-chrome="nofooter">Tweets</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
    }
    /**
     * Soundcloud Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function soundcloudSetup(){

        $type = 'soundcloud';

        return "function fnsoundcloud(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(soundcloud.com)\/(.*)/i;

            if(content){
                var link = content['link'];
            } else {
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://soundcloud.com/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid SoundCloud link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Soundcloud
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function soundcloudSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(soundcloud.com)\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid SoundCloud link'));
        }

        return $data;
    }
    /**
     * Soundcloud Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function soundcloudBlock($id, $value){
        return '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url='.urlencode($value['link']).'&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
    }
    /**
     * Facebook Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function facebookSetup(){

        $type = 'facebook';

        return "function fnfacebook(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?facebook.com)\/(.*)/i;

            if(content){
                var link = content['link'];
            } else {
                var link = '';
            }
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://facebook.com/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Facebook Post link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Facebook Post
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function facebookSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?facebook.com)\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Facebook Post link'));
        }

        return $data;
    }
    /**
     * Facebook Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function facebookBlock($id, $value){

        if(!$value['link'] || empty($value['link'])) return;

        return '<div class="btn-custom rounded"><div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v14.0" nonce="WaCixDC1"></script><div class="fb-post" data-href="'.$value['link'].'" data-show-text="true"></div></div>';
    }
    /**
     * Instagram Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function instagramSetup(){

        $type = 'instagram';

        return "function fninstagram(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?instagram.com)\/(.*)/i;

            if(content){
                var link = content['link'];
            } else {
                var link = '';
            }
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://instagram.com/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Instagram Post link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Instagram
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function instagramSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?instagram.com)\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Instagram Post link'));
        }

        return $data;
    }
    /**
     * Instagram Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function instagramBlock($id, $value){
        return '<blockquote class="instagram-media" data-instgrm-permalink="'.$value['link'].'" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"></blockquote><script async src="//www.instagram.com/embed.js"></script>';
    }
    /**
     * Typeform Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function typeformSetup(){

        $type = 'typeform';

        return "function fntypeform(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?((.*).typeform.com)\/to\/(.*)/i;

            if(content){
                var name = content['name'];
                var link = content['link'];
            } else {
                var name = '';
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. Survey" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://XXXXXX.typeform.com/to/XXXXXX" value="\'+link+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=url]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Typeform link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Typeform
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function typeformSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?((.*).typeform.com)\/to\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Typeform link'));
        }

        return $data;
    }
    /**
     * Typeform Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function typeformBlock($id, $value){

        preg_match("/^https?:\/\/(www.)?((.*).typeform.com)\/to\/(.*)/i", $value['link'], $match);
        $typeformid = end($match);

        return '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-toggle="modal" data-bs-toggle="modal" data-target="#modal-'.$id.'" data-bs-target="#modal-'.$id.'">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Typeform').'</a>
            <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div data-tf-widget="'.$typeformid.'"></div>
                            <script src="//embed.typeform.com/next/embed.js"></script>
                        </div>
                        <div class="modal-body">
                            <a href="'.$value['link'].'" class="btn btn-dark text-white rounded-pill w-100 d-block py-2" rel="nofollow" target="_blank">'.self::e('Open in a new tab').'</a>
                        </div>
                    </div>
                </div>
            </div>';
    }
    /**
     * Pinterest Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function pinterestSetup(){

        $type = 'pinterest';

        return "function fnpinterest(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?pinterest.com)\/(.*)/i;

            if(content){
                var name = content['name'];
                var link = content['link'];
            } else {
                var name = '';
                var link = '';
            }
            var blockpreview = link;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. My Board" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://pinterest.com/..." value="\'+link+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=url]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Pinterest link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Pinterest
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function pinterestSave($request, $profiledata, $data){

        $data['link'] = trim(clean($data['link']), '/');
        $data['name'] = Helper::clean($data['name'], 3);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?pinterest.(com|ca|co.uk))\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Pinterest link'));
        }

        return $data;
    }
    /**
     * Pintereset Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function pinterestBlock($id, $value){

        return '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-toggle="modal" data-target="#modal-'.$id.'" data-bs-toggle="modal" data-bs-target="#modal-'.$id.'">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Pinterest Board').'</a>
        <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="sensitiveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
                        <a data-pin-do="embedUser" data-pin-board-width="400" data-pin-scale-height="320" data-pin-scale-width="80" href="'.$value['link'].'"></a>
                    </div>
                </div>
            </div>
        </div>';
    }
    /**
     * Reddit Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function redditSetup(){

        $type = 'reddit';

        return "function fnreddit(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?((.*).)?reddit.com\/user\/(.*)/i;

            if(content){
                var name = content['name'];
                var link = content['link'];
            } else {
                var name = '';
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. My profile" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://www.reddit.com/user/...." value="\'+link+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=url]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Reddit link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Reddit Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function redditSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);
        $data['name'] = Helper::clean($data['name'], 3);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?((.*).)?reddit.com\/user\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Reddit link'));
        }

        return $data;
    }
    /**
     * Reddit Widget Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function redditBlock($id, $value){

        preg_match("/^https?:\/\/(www.)?((.*).)?reddit.com\/user\/(.*)/i", $value['link'], $match);

        $json = \Core\Http::url('https://www.reddit.com/user/'.trim(end($match), '/').'/about.json')
        ->with('user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36')->get();

        $user = $json->bodyObject();

        $html = '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-bs-toggle="modal" data-bs-target="#modal-'.$id.'" data-toggle="modal" data-target="#modal-'.$id.'">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Reddit').'</a>
        <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="sensitiveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">';
                        if(isset($user->data)){
                            $user = $user->data;
                            $html .='<div class="text-center">
                                <img src="'.$user->icon_img.'" class="img-responsive rounded-3 mb-2" width="100">
                                <h4 class="mb-0 text-dark">'.$user->subreddit->title.'</h4>
                                <small class="text-muted">'.str_replace('_', '/', $user->subreddit->display_name).'</small>
                                <div class="border p-3 mt-3 rounded text-start text-left">
                                    <p class="text-dark">'.self::e('Karma').' <span class="float-end float-right fw-bold font-weight-bold">'.$user->total_karma.'</span></p>
                                    <p class="text-dark mb-0">'.self::e('Member since').' <span class="float-end fw-bold float-right font-weight-bold">'.date('d F, Y', $user->created).'</span></p>
                                </div>
                                <a href="'.$value['link'].'" class="btn btn-dark text-white mt-3 d-block">'.self::e('Visit Profile').'</a>
                            </div>';
                        }else {
                            $html .='An error occurred';
                        }
            $html .='</div>
                </div>
            </div>
        </div>';

        return $html;
    }
    /**
     * Calendly Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function calendlySetup(){

        $type = 'calendly';

        return "function fncalendly(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?calendly.com)\/(.*)/i;

            if(content){
                var name = content['name'];
                var link = content['link'];
            } else {
                var name = '';
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. Book an appointment" value="\'+name+\'">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Link').'</label>
                        <input type="url" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://www.calendly.com/..." value="\'+link+\'">
                    </div>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=url]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Calendly link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Calendly
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function calendlySave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);
        $data['name'] = Helper::clean($data['name'], 3);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?calendly.com)\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Calendly link'));
        }

        return $data;
    }
    /**
     * Calendly Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function calendlyProcessor($id, $value){
        View::push('https://assets.calendly.com/assets/external/widget.css', 'css')->toHeader();
        View::push('https://assets.calendly.com/assets/external/widget.js', 'script')->toHeader();
    }
    /**
     * Calendly Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function calendlyBlock($id, $value){

        return '<a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" onclick="Calendly.initPopupWidget({url: \''.$value['link'].'\'});return false;">'.(isset($value['name']) && $value['name'] ? $value['name'] : 'Calendly').'</a>';
    }
    /**
     * Threads Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function threadsSetup(){

        $type = 'threads';

        return "function fnthreads(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?threads.net)\/(.*)\/post\/(.*)/i;

            if(content){
                var link = content['link'];
            } else {
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://threads.net/post/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Threads post link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Threads
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function threadsSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?threads.net)\/(.*)\/post\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Threads post link'));
        }

        return $data;
    }
    /**
     * Threads Widget Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function threadsBlock($id, $value){

        return '<blockquote class="text-post-media btn-custom" data-text-post-permalink="'.$value['link'].'" data-text-post-version="0" id="ig-tp-Cvk_NVnyZV9" style=" background:#FFF; border-width: 1px; border-style: solid; border-color: #00000026; border-radius: 16px; max-width:660px; margin: 1px; min-width:270px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"> <a href="'.$value['link'].'" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%; font-family: -apple-system, BlinkMacSystemFont, sans-serif;" target="_blank"> <div style=" padding: 40px; display: flex; flex-direction: column; align-items: center;"><div style=" display:block; height:32px; width:32px; padding-bottom:20px;"> <svg aria-label="Threads" height="32px" role="img" viewBox="0 0 192 192" width="32px" xmlns="http://www.w3.org/2000/svg"> <path d="M141.537 88.9883C140.71 88.5919 139.87 88.2104 139.019 87.8451C137.537 60.5382 122.616 44.905 97.5619 44.745C97.4484 44.7443 97.3355 44.7443 97.222 44.7443C82.2364 44.7443 69.7731 51.1409 62.102 62.7807L75.881 72.2328C81.6116 63.5383 90.6052 61.6848 97.2286 61.6848C97.3051 61.6848 97.3819 61.6848 97.4576 61.6855C105.707 61.7381 111.932 64.1366 115.961 68.814C118.893 72.2193 120.854 76.925 121.825 82.8638C114.511 81.6207 106.601 81.2385 98.145 81.7233C74.3247 83.0954 59.0111 96.9879 60.0396 116.292C60.5615 126.084 65.4397 134.508 73.775 140.011C80.8224 144.663 89.899 146.938 99.3323 146.423C111.79 145.74 121.563 140.987 128.381 132.296C133.559 125.696 136.834 117.143 138.28 106.366C144.217 109.949 148.617 114.664 151.047 120.332C155.179 129.967 155.42 145.8 142.501 158.708C131.182 170.016 117.576 174.908 97.0135 175.059C74.2042 174.89 56.9538 167.575 45.7381 153.317C35.2355 139.966 29.8077 120.682 29.6052 96C29.8077 71.3178 35.2355 52.0336 45.7381 38.6827C56.9538 24.4249 74.2039 17.11 97.0132 16.9405C119.988 17.1113 137.539 24.4614 149.184 38.788C154.894 45.8136 159.199 54.6488 162.037 64.9503L178.184 60.6422C174.744 47.9622 169.331 37.0357 161.965 27.974C147.036 9.60668 125.202 0.195148 97.0695 0H96.9569C68.8816 0.19447 47.2921 9.6418 32.7883 28.0793C19.8819 44.4864 13.2244 67.3157 13.0007 95.9325L13 96L13.0007 96.0675C13.2244 124.684 19.8819 147.514 32.7883 163.921C47.2921 182.358 68.8816 191.806 96.9569 192H97.0695C122.03 191.827 139.624 185.292 154.118 170.811C173.081 151.866 172.51 128.119 166.26 113.541C161.776 103.087 153.227 94.5962 141.537 88.9883ZM98.4405 129.507C88.0005 130.095 77.1544 125.409 76.6196 115.372C76.2232 107.93 81.9158 99.626 99.0812 98.6368C101.047 98.5234 102.976 98.468 104.871 98.468C111.106 98.468 116.939 99.0737 122.242 100.233C120.264 124.935 108.662 128.946 98.4405 129.507Z" /></svg></div><div style=" font-size: 15px; line-height: 21px; color: #000000; font-weight: 600;">View on Threads</div></div></a></blockquote> <script async src="https://www.threads.net/embed.js"></script>';
    }
    /**
     * Google Maps Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function googlemapsSetup(){

        $type = 'googlemaps';

        return "function fngooglemaps(el, content = null, did = null){

            if(content){
                var address = content['address'];
            } else {
                var address = '';
            }
            var blockpreview = address;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Address').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][address]" placeholder="e.g. 1 Apple Park Way" value="\'+address+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Google Maps
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function googlemapsSave($request, $profiledata, $data){

        $data['address'] = clean($data['address']);

        return $data;
    }
    /**
     * Google Maps Blog
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function googlemapsBlock($id, $value){

        if(!isset($value['address'])) $value['address'] = '';

        return '<iframe src="https://maps.google.com/maps?q='.urlencode($value['address']).'&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="350" style="border:0;" class="rounded btn-custom" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    }
    /**
     * Open Table Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function opentableSetup(){

        $type = 'opentable';

        $langlist = '';

        foreach(['en-US' => 'English-US','fr-CA' => 'Français-CA','de-DE' => 'Deutsch-DE','es-MX' => 'Español-MX','ja-JP' => '日本語-JP','nl-NL' => 'Nederlands-NL','it-IT' => 'Italiano-IT'] as $key => $value){
            $langlist .= '<option value="'.$key.'"  \'+(lang == \''.$key.'\' ? \'selected\':\'\')+\'>'.$value.'</option>';
        }

        return "function fnopentable(el, content = null, did = null){

            if(content){
                var id = content['rid'];
                var lang = content['lang'];
            } else {
                var id = '';
                var lang = 'en-US';
            }
            var blockpreview = id;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Restaurant ID').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][rid]" placeholder="e.g. 12345678" value="\'+id+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Language').'</label>
                            <select name="data[\'+slug(did)+\'][lang]" class="form-select mb-2 p-2">
                                '.$langlist.'
                            </select>
                        </div>
                    </div>
                </div>
            </div>', $type))."';
            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!parseInt($(this).val())){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid OpenTable restaurant ID')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save OpenTable
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function opentableSave($request, $profiledata, $data){

        if($data['rid'] && !is_numeric($data['rid'])) throw new Exception(e('{b} Error: Please enter a valid ID', null, ['b' => 'Eventbrite']));

        $data['lang'] = clean($data['lang']);

        return $data;
    }
    /**
     * Opentable Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function opentableBlock($id, $value){

        if(!isset($value['rid']) || !$value['rid']) return;

        return '<div class="df-opentable rounded btn-custom"><script type="text/javascript" src="//www.opentable.com/widget/reservation/loader?rid='.$value['rid'].'&domain=com&type=standard&theme=standard&lang='.$value['lang'].'&overlay=true&iframe=false&newtab=false"></script></div>';
    }
    /**
     * EventBrite
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function eventbriteSetup(){

        $type = 'eventbrite';

        return "function fneventbrite(el, content = null, did = null){

            if(content){
                var id = content['eid'];
                var label = content['label'];
            } else {
                var id = '';
                var label = '';
            }
            var blockpreview = id;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="row" id="container-\'+did+\'">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Event ID').'</label>
                            <input type="text" class="form-control p-2" id="event-\'+did+\'" name="data[\'+slug(did)+\'][eid]" placeholder="e.g. 12345678" value="\'+id+\'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Label').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][label]" placeholder="e.g. Book now" value="\'+label+\'">
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' #event-'+did+'').change(function(e){
                if(!parseInt($(this).val())){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid EventBrite ID')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save Eventbrite
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function eventbriteSave($request, $profiledata, $data){

        if($data['eid'] && !is_numeric($data['eid'])) throw new Exception(e('{b} Error: Please enter a valid ID', null, ['b' => 'Evenbrite']));

        $data['label'] = clean($data['label']);

        return $data;
    }
    /**
     * EventBrite Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function eventbriteBlock($id, $value){

        return '<a class="btn btn-custom btn-block d-block w-100 p-3" id="evenbrite-'.$id.'">'.(isset($value['label']) && !empty($value['label']) ? $value['label'] : e('Book now')).'</a>
        <script src="https://www.eventbrite.com/static/widgets/eb_widgets.js"></script>

        <script type="text/javascript">
            window.EBWidgets.createWidget({
                widgetType: \'checkout\',
                eventId: \''.$value['eid'].'\',
                modal: true,
                modalTriggerElementId: \'evenbrite-'.$id.'\'
            });
        </script>';
    }
    /**
     * Snapchat Embed
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return void
     */
    public static function snapchatSetup(){

        $type = 'snapchat';

        return "function fnsnapchat(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?snapchat.com)\/(spotlight|add|lens)\/(.*)/i;

            if(content){
                var link = content['link'];
            } else {
                var link = '';
            }
            var blockpreview = link;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://www.snapchat.com/spotlight/..." value="\'+link+\'">
                    <p class="form-text">'.self::e('Insert a link to a Snapchat Spotlight, Profile or Lens.').'</p>
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid Snapchat post link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Snapchat Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function snapchatSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?snapchat.com)\/(spotlight|add|lens)\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid Snapchat post link'));
        }

        return $data;
    }
    /**
     * Snapchat Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function snapchatBlock($id, $value){
        if(empty($value['link'])) return;

        if(strpos($value['link'], '?') !== 0) $value['link'] = explode('?', $value['link'])[0];

        return '<blockquote class="snapchat-embed" data-snapchat-embed-width="100%" data-snapchat-embed-height="692" data-snapchat-embed-url="'.$value['link'].'/embed" data-snapchat-embed-style="border-radius: 40px;" style="background:#C4C4C4; border:0; border-radius:40px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:416px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px); display: flex; flex-direction: column; position: relative; height:650px;"><div style=" display: flex; flex-direction: row; align-items: center;"><a href="'.$value['link'].'" style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px; margin:16px; cursor: pointer"></a><div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"></div></div><div style="flex: 1;"></div><div style="display: flex; flex-direction: row; align-items: center; border-end-end-radius: 40px; border-end-start-radius: 40px;"><a href="'.$value['link'].'" style="background-color: yellow; width:100%; padding: 10px 20px; border: none; border-radius: inherit; cursor: pointer; text-align: center; display: flex;flex-direction: row;justify-content: center; text-decoration: none; color: black;">View more on Snapchat</a></div></blockquote><script async src="https://www.snapchat.com/embed.js"></script>';
    }
    /**
     * Music Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5
     * @return void
     */
    public static function musiclinkSetup() {
        $type = 'musiclink';
    
        $providers = [
            'spotify' => 'Spotify',
            'applemusic' => 'Apple Music',
            'youtube' => 'YouTube',
            'youtubemusic' => 'YouTube Music',
            'amazonmusic' => 'Amazon Music',
            'bandcamp' => 'Bandcamp',
            'pandora' => 'Pandora',
            'googleplay' => 'Google Play',
            'soundcloud' => 'Soundcloud',
            'deezer' => 'Deezer',
            'tidal' => 'Tidal',
            'yandexmusic' => 'Yandex Music',
            'vkmusic' => 'VK Music',
            'mixcloud' => 'MixCloud',
            'iheartradio' => 'iHeartRadio',
            'vimeo' => 'Vimeo',
            'ticketmaster' => 'Ticketmaster',
            'stubhub' => 'Stubhub'
        ];
    
        $jsContent = "
            var content = content || {};
            var image = content['image'] || '';
            var title = content['title'] || '';
            var description = content['description'] || '';
            var layout = content['layout'] || 'list';
        ";
    
        foreach ($providers as $key => $name) {
            $jsContent .= "var $key = content['$key'] || '';\n";
            $jsContent .= "var button{$key} = content['button-$key'] || '';\n";
        }
    
        $htmlContent = '<div id="container-\'+did+\'">
            <h5 class="fw-bold mb-3">'.self::e('Preview').'</h5>
            <div class="border rounded p-2 mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Image').'</label>
                            <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="image/*">
                            <p class="form-text">'.self::e('Upload an image for the song (e.g., album cover).').'</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">'.self::e('Title').'</label>
                            <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][title]" placeholder="Enter song title" value="\'+title+\'">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Headline').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][description]" placeholder="e.g. Listen to my latest hits" value="\'+description+\'">
                </div>
            </div>
            <h5 class="fw-bold mb-3">'.self::e('Design').'</h5>
            <div class="border rounded p-2 mb-3">
                <div class="form-group" data-toggle="buttons">
                    <label class="btn text-center border rounded p-2 h-100 me-4 \'+(layout ==\'list\' ? \'border-secondary\' : \'\')+\'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="80" height="80"><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>                        
                        <input type="radio" name="data[\'+slug(did)+\'][layout]" value="list" class="d-none" \'+(layout ==\'list\' ? \'checked\' : \'\')+\'>
                    </label>
                    <label class="btn text-center border rounded p-2 h-100 me-1 \'+(layout ==\'grid\' ? \'border-secondary\' : \'\')+\'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="80" height="80"><path d="M128 136c0-22.1-17.9-40-40-40L40 96C17.9 96 0 113.9 0 136l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48zm0 192c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48zm32-192l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40zM288 328c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48zm32-192l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40zM448 328c0-22.1-17.9-40-40-40l-48 0c-22.1 0-40 17.9-40 40l0 48c0 22.1 17.9 40 40 40l48 0c22.1 0 40-17.9 40-40l0-48z"/></svg>
                        <input type="radio" name="data[\'+slug(did)+\'][layout]" value="grid" class="d-none" \'+(layout ==\'grid\' ? \'checked\' : \'\')+\'>
                    </label>
                </div>
            </div>
            <h5 class="fw-bold my-3">'.self::e('Platform Links').'</h5>';
    
        foreach ($providers as $key => $name) {
            $htmlContent .= '<div class="border rounded p-2 mb-2"><div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="form-label fw-bold d-block">'.self::e($name) . ' \'+(typeof content[\'urlid-'.$key.'\'] !== "undefined" ? \'<a href="\'+appurl+\'\'+content[\'urlid-'.$key.'\']+\'/stats" class="text-muted text-small float-end" target="_blank" data-bs-toggle="tooltip"><i class="fa fa-chart-line"></i></a>\' : \'\')+\'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][' . $key . ']" placeholder="e.g. https://site.com/..." value="\'+' . $key . '+\'">
                    </div>                
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Button Text').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][button-' . $key . ']" placeholder="e.g. Listen" value="\'+'.'button'.$key.'+\'">
                    </div>
                </div>
            </div></div>';
        }
    
        $htmlContent .= '</div>';
    
        return "function fnmusiclink(el, content = null, did = null) {
            
            var blockpreview = '';

            if (did == null) did = (Math.random() + 1).toString(36).substring(2);
    
            $jsContent
    
            let html = '" . self::format(self::generateTemplate($htmlContent, $type)) . "';
    
            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Musiclink Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function musiclinkSave($request, $profiledata, $data){

        $appConfig = appConfig('app');
        $sizes = config('sizes');
        $extensions = config('extensions');

        $id = $data['id'];    
        
        if($image = $request->file($id)){

            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->image) {
                throw new Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => explode(',', $extensions->bio->image), 's' => $sizes->bio->image]));
            }
            
            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
    
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_musiclinktype".Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$id]['image']) && $profiledata['links'][$id]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$id]['image']);
            }

            $data['image'] = $filename;

        } else {
            if(isset($profiledata['links'][$id]['image'])) $data['image'] = $profiledata['links'][$id]['image'];
        }

        $providers = [
            'spotify' => 'Spotify',
            'applemusic' => 'Apple Music',
            'youtube' => 'YouTube',
            'youtubemusic' => 'YouTube Music',
            'amazonmusic' => 'Amazon Music',
            'bandcamp' => 'Bandcamp',
            'pandora' => 'Pandora',
            'googleplay' => 'Google Play',
            'soundcloud' => 'Soundcloud',
            'deezer' => 'Deezer',
            'tidal' => 'Tidal',
            'yandexmusic' => 'Yandex Music',
            'vkmusic' => 'VK Music',
            'mixcloud' => 'MixCloud',
            'iheartradio' => 'iHeartRadio',
            'vimeo' => 'Vimeo',
            'ticketmaster' => 'Ticketmaster',
            'stubhub' => 'Stubhub'
        ];
        
        $self = new self();
        $user = Auth::user();
        $profileid = $request->segment(3);

        foreach($providers as $key => $provider){
            if(!isset($data[$key]) || empty($data[$key])) continue;

            if(isset($profiledata['links'][$id]['urlid-'.$key])){

                $currenturl = DB::url()->where('userid', $user->rID())->where('id', (int) $profiledata['links'][$id]['urlid-'.$key])->first();

                if(!$currenturl){

                    if(
                        $self->domainBlacklisted($data[$key]) ||
                        $self->wordBlacklisted($data[$key]) ||
                        !$self->safe($data[$key]) ||
                        $self->phish($data[$key]) ||
                        $self->virus($data[$key])
                    ) {
                        throw new Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $newlink = DB::url()->create();
                    $newlink->url = Helper::clean($data[$key], 3);
                    $newlink->userid = $user->rID();
                    $newlink->alias = null;
                    $newlink->custom = null;
                    $newlink->date = Helper::dtime();
                    $newlink->profileid = $profileid;
                    $newlink->save();
                    $data['urlid-'.$key] = $newlink->id;

                }else{

                    if(
                        $self->domainBlacklisted($data[$key]) ||
                        $self->wordBlacklisted($data[$key]) ||
                        !$self->safe($data[$key]) ||
                        $self->phish($data[$key]) ||
                        $self->virus($data[$key])
                    ) {
                        throw new Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                    }

                    $currenturl->url = Helper::clean($data[$key], 3);

                    if(!$currenturl->profileid) {
                        $currenturl->date = Helper::dtime();
                        $currenturl->profileid = $profileid;
                    }

                    $currenturl->save();
                    $data['urlid-'.$key] = $currenturl->id;
                }

            }else {

                if(!$self->validate($data[$key])) throw new Exception(e('{b} Error: Please enter a valid url', null, ['b' => e('Link')]));
                if(
                    $self->domainBlacklisted($data[$key]) ||
                    $self->wordBlacklisted($data[$key]) ||
                    !$self->safe($data[$key]) ||
                    $self->phish($data[$key]) ||
                    $self->virus($data[$key])
                ) {
                    throw new Exception(e('{b} Error: This link cannot be accepted because either it is invalid or it might not be safe.', null, ['b' => e('Link')]));
                }

                $newlink = DB::url()->create();
                $newlink->url = Helper::clean($data[$key], 3);
                $newlink->userid = $user->rID();
                $newlink->alias = null;
                $newlink->custom = null;
                $newlink->date = Helper::dtime();
                $newlink->profileid = $profileid;
                $newlink->save();
                $data['urlid-'.$key] = $newlink->id;
            }
        }

        $data = array_map('clean', $data);

        return $data;
    }
    /**
     * Musiclink Widget
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function musiclinkBlock($id, $value){
        
        $providers = [
            'spotify' => 'Spotify',
            'applemusic' => 'Apple Music',
            'youtube' => 'YouTube',
            'youtubemusic' => 'YouTube Music',
            'amazonmusic' => 'Amazon Music',
            'bandcamp' => 'Bandcamp',
            'pandora' => 'Pandora',
            'googleplay' => 'Google Play',
            'soundcloud' => 'Soundcloud',
            'deezer' => 'Deezer',
            'tidal' => 'Tidal',
            'yandexmusic' => 'Yandex Music',
            'vkmusic' => 'VK Music',
            'mixcloud' => 'MixCloud',
            'iheartradio' => 'iHeartRadio',
            'vimeo' => 'Vimeo',
            'ticketmaster' => 'Ticketmaster',
            'stubhub' => 'Stubhub'
        ];

        $html = '<div class="card rounded p-2 music-link-preview"><div class="d-flex align-items-center text-left text-start">
            '.(isset($value['image']) && !empty($value['image']) ? '<img src="'.uploads($value['image'], 'profile').'" alt="'.($value['title'] ?? '').'" class="img-fluid rounded mb-2" width="100">' : '').'
            <div class="ms-3 ml-3">
                <h6 class="fw-bold">'.($value['title'] ?? '').'</h6>
                '.(!empty($value['description']) ? '<p class="text-muted mb-0">'.$value['description'].'</p>':'').'
            </div>
        </div>';
        $i = 0;
        if($value['layout'] == 'grid'){
            $html .= '<div class="d-flex align-items-center">';
            foreach($providers as $key => $provider){
                if(!isset($value[$key]) || empty($value[$key])) continue;
                $html .='<div class="col-6 h-100"><a href="'.$value[$key].'" class="btn btn-block p-3 d-block shadow-none btn-custom text-center mt-2 border rounded h-100 me-1 mr-1 ml-1 ms-1" target="_blank" rel="nofollow" data-blockid="'.$value['urlid-'.$key].'">
                    <p><img src="'.assets('images/'.$key.'.svg').'"></p>
                    <span class="c2a text-mute mt-2 d-inline-block w-100">'.(!empty($value['button-'.$key]) ? $value['button-'.$key] :  e('Listen')).'</span>
                </a></div>';
                if($i > 0 && $i%2) $html .= '</div><div class="d-flex align-items-center">';
                $i++;
            }
            $html .= '</div>';
        } else {
            foreach($providers as $key => $provider){
                if(!isset($value[$key]) || empty($value[$key])) continue;
                $html .='<a href="'.$value[$key].'" class="btn btn-block p-3 d-block shadow-none btn-custom d-flex align-items-center mt-2 border rounded" target="_blank" rel="nofollow" data-blockid="'.$value['urlid-'.$key].'">
                    <img src="'.assets('images/'.$key.'.svg').'" width="40">
                    <span class="ms-3 ml-3">'.$provider.'</span>
                    <span class="ms-auto ml-auto c2a text-muted">'.(!empty($value['button-'.$key]) ? $value['button-'.$key] :  e('Listen')).'</span>
                </a>';
            }
        }
        $html .= "</div>";
        return $html;
    }
    /**
     * Linkedin Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5.2
     * @return void
     */
    public static function linkedinSetup(){

        $type = 'linkedin';

        return "function fnlinkedin(el, content = null, did = null){

            let regex = /^https?:\/\/(www.)?(((.*).)?linkedin.com)\/posts\/(.*)/i;

            if(content){
                var link = content['link'];
            } else {
                var link = '';
            }
            var blockpreview = link;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                <div class="form-group">
                    <label class="form-label fw-bold">'.self::e('Link').'</label>
                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" placeholder="e.g. https://linkedin.com/posts/..." value="\'+link+\'">
                </div>
            </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

            $('#container-'+did+' input[type=text]').change(function(e){
                if(!$(this).val().match(regex)){
                    e.preventDefault();
                    $.notify({
                        message: '".self::e('Please enter a valid LinkedIn post link')."'
                    },{
                        type: 'danger',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                    return false;
                }
            })
        }";
    }
    /**
     * Save linkedin
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function linkedinSave($request, $profiledata, $data){

        $data['link'] = clean($data['link']);

        if($data['link'] && !preg_match("/^https?:\/\/(www.)?(((.*).)?linkedin.com)\/posts\/(.*)/i", $data['link'])) {
            throw new Exception(e('Please enter a valid LinkedIn post link'));
        }
        $http = Http::url($data['link'])
                ->with('user-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36')
                ->get(['timeout' => 2]);

        $response = '';

        if($http){
            $response = $http->getBody();
        }
        if(!$response || empty($response)){
            throw new Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }
        
        preg_match('/<script type="application\/ld\+json">\s*(.*?)\s*<\/script>/s', $response, $matches);

        if(empty($matches)) {
            throw new Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }
        
        if(!$content = json_decode($matches[1], true)){
            throw new Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }
        
        $content = array_map('clean', $content);
        
        if(!in_array($content['@type'], ['SocialMediaPosting', 'VideoObject', 'DiscussionForumPosting'])){
            throw new Exception(e('LinkedIn post cannot be retrieved. Please make sure the post is public and try again.'));
        }

        if($content['@type'] == 'DiscussionForumPosting'){
            $data = array_merge($data, [
                'author' => $content['author']['name'],
                'avatar' => $content['author']['image']['url'],
                'profile' => $content['author']['url'],
                'date' => $content['datePublished'],
                'title' => '',
                'description' => nl2br($content['articleBody']),
                'media' => null,
                'thumbnail' => $content['image']['url'] ?? ''
            ]);
        }

        if($content['@type'] == 'SocialMediaPosting'){
            $data = array_merge($data, [
                'author' => $content['author']['name'],
                'avatar' => $content['author']['image']['url'],
                'profile' => $content['author']['url'],
                'date' => $content['datePublished'],
                'title' => '',
                'description' => nl2br($content['articleBody']),
                'media' => null,
                'thumbnail' => $content['image']['url'] ?? ''
            ]);
        }
        
        if($content['@type'] == 'VideoObject') {
            $data = array_merge($data, [
                'author' => $content['author']['name'],
                'avatar' => $content['author']['image']['url'],
                'profile' => $content['author']['url'],
                'date' => $content['datePublished'],
                'title' => $content['name'],
                'description' => nl2br($content['description']),
                'media' => $content['contentUrl'] ?? null,
                'thumbnail' => $content['thumbnailUrl'] ?? null
            ]);
        }

        return $data;
    }
    /**
     * linkedin Widget Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.2
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function linkedinBlock($id, $value){

        $html = '<div class="card rounded">';
            $html .='<div class="d-flex align-items-center p-2">';
                if($value['avatar']) $html .='<a href="'.$value['profile'].'" target="_blank"><img src="'.$value['avatar'].'" class="img-responsive rounded-circle mb-2" width="50"></a>';
                $html .='<div class="ms-2 ml-2 text-start text-left">
                            <a href="'.$value['profile'].'" target="_blank"><h6 class="mb-0">'.$value['author'].'</h6></a>
                            <small class="text-muted small">'.Helper::timeago($value['date']).'</small>
                        </div>
                        <div class="ms-auto">
                            <a href="'.$value['profile'].'" class="btn btn-sm btn-custom border text-muted" target="_blank">'.e('Follow').'</a>
                        </div>
                </div>';
            $html .='
                <div class="border-top p-3 text-start text-left">
                    <div>'.$value['description'].'</div>
                </div>';
            if($value['media']){
                $html .= '<video width="100%" controls autoplay>
                            <source src="'.$value['media'].'" type="video/mp4">
                        </video>';
            }
            if($value['thumbnail']){
                $html .= '<img width="100%" class="img-fluid img-responsive" src="'.$value['thumbnail'].'">';
            }
            $html .= '<a href="'.$value['link'].'" class="btn btn-sm btn-custom border text-muted m-1 shadow-none" target="_blank">'.e('View on LinkedIn').'</a>';
        $html .= '</div>';
        return $html;
    }
    /**
     * Video Setup
     *
     * @author GemPixel <https://gempixel.com> 
     * @category Content
     * @version 7.6
     * @return void
     */
    public static function videoSetup(){
        $type = 'video';
        
        return "function fnvideo(el, content = null, did = null){

            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="form-group">
                        <label class="form-label fw-bold d-block">'.self::e('Video File').'</label>
                        <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="video/mp4">
                        <p class="form-text">'.self::e('Acceptable file: MP4 - Max size 10MB').'</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold d-block">'.self::e('Poster Image').'</label>
                        <input type="file" class="form-control p-2" name="\'+slug(did)+\'-poster" accept="image/*">
                        <p class="form-text">'.self::e('Acceptable files: JPG, JPEG, PNG - Max size 2MB').'</p>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);

        }";
    }

    /**
     * Video Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function videoSave($request, $profiledata, $data){
        
        $appConfig = appConfig('app');
        $key = $data['id'];
        
        if($video = $request->file($key)){
            
            if($video->ext !== 'mp4' || $video->sizekb > 10000) {
                throw new Exception(e('Video must be MP4 format and maximum 10MB in size.'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);

                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_video".Helper::rand(6).str_replace(['#', ' '], '-', $video->name);

            $request->move($video, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['video']) && $profiledata['links'][$key]['video']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['video']);
            }

            $data['video'] = $filename;

        } else {
            if(isset($profiledata['links'][$key]['video'])) $data['video'] = $profiledata['links'][$key]['video'];
        }

        if($poster = $request->file($key.'-poster')){
            if(!$poster->mimematch || !in_array($poster->ext, ['jpg', 'jpeg', 'png']) || $poster->sizekb > 2000) {
                throw new Exception(e('Poster image must be either a PNG or a JPEG (Max 2MB).'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_poster".Helper::rand(6).str_replace(['#', ' '], '-', $poster->name);
            $request->move($poster, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['poster']) && $profiledata['links'][$key]['poster']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['poster']);
            }

            $data['poster'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['poster'])) $data['poster'] = $profiledata['links'][$key]['poster'];
        }

        return $data;
    }

    /**
     * Video Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function videoBlock($id, $value){
        if(!isset($value['video']) || !$value['video']) return;
        $id = Helper::rand(5);
        return '<video id="'.$id.'" class="w-100 rounded shadow-sm" controls'.
               (isset($value['poster']) && $value['poster'] ? ' poster="'.uploads($value['poster'], 'profile').'"' : '').'>
            <source src="'.uploads($value['video'], 'profile').'" type="video/mp4">
            '.e('Your browser does not support the video tag.').'
        </video>';
    }
    /**
     * Delete Video
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function videoDelete($id, $value){
        
        if(isset($value['video']) && $value['video']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['video']);
        }
        if(isset($value['poster']) && $value['poster']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['poster']);
        }
    }

    /**
     * Audio Setup
     *
     * @author GemPixel <https://gempixel.com> 
     * @category Content
     * @version 7.6
     * @return void
     */
    public static function audioSetup(){
        $type = 'audio';
    
        return "function fnaudio(el, content = null, did = null){
            if(content){
                var title = content['title'] || '';
                var artist = content['artist'] || '';
            } else {
                var title = '';
                var artist = '';
            }
            var blockpreview = title;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);
    
            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Title').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][title]" value="\'+title+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Artist').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][artist]" value="\'+artist+\'">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold d-block">'.self::e('Audio File').'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="audio/mp3">
                                <p class="form-text">'.self::e('Acceptable file: MP3 - Max size 5MB').'</p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold d-block">'.self::e('Album Cover').'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'-cover" accept=".jpg,.jpeg,.png">
                                <p class="form-text">'.self::e('Acceptable files: JPG, JPEG, PNG - Max size 2MB').'</p>
                            </div>
                        </div>
                    </div>
                </div>', $type))."';
    
            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }

    /**
     * Audio Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function audioSave($request, $profiledata, $data){
        
        $appConfig = appConfig('app');
        $key = $data['id'];

        // Handle audio file upload
        if($audio = $request->file($key)){
            if($audio->ext !== 'mp3' || $audio->sizekb > 5000) {
                throw new Exception(e('Audio must be MP3 format and maximum 5MB in size.'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_audio".Helper::rand(6).str_replace(['#', ' '], '-', $audio->name);
            $request->move($audio, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['audio']) && $profiledata['links'][$key]['audio']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['audio']);
            }

            $data['audio'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['audio'])) $data['audio'] = $profiledata['links'][$key]['audio'];
        }

        // Handle cover image upload
        if($cover = $request->file($key.'-cover')){
            if(!$cover->mimematch || !in_array($cover->ext, ['jpg', 'jpeg', 'png']) || $cover->sizekb > 2000) {
                throw new Exception(e('Cover image must be either a PNG or a JPEG (Max 2MB).'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_cover".Helper::rand(6).str_replace(['#', ' '], '-', $cover->name);
            $request->move($cover, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['cover']) && $profiledata['links'][$key]['cover']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['cover']);
            }

            $data['cover'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['cover'])) $data['cover'] = $profiledata['links'][$key]['cover'];
        }

        return $data;
    }

    /**
     * Audio Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function audioBlock($id, $value){
        if(!isset($value['audio']) || !$value['audio']) return;

        $cover = isset($value['cover']) && $value['cover'] ? 
            '<div class="col-auto">
                <img src="'.uploads($value['cover'], 'profile').'" class="img-fluid rounded shadow" style="width: 100px; height: 100px; object-fit: cover;">
            </div>' : '';
        
        $title = isset($value['title']) && $value['title'] ? 
            '<div class="fw-bolder fs-6 pt-2">'.Helper::clean($value['title']).'</div>' : '';
        $artist = isset($value['artist']) && $value['artist'] ? 
            '<div class="text-muted fs-6">'.Helper::clean($value['artist']).'</div>' : '';

        return '<div class="card p-3 text-start text-left">
            <div class="row align-items-center">
                '.$cover.'
                <div class="col">
                    '.$title.$artist.'
                    <audio class="w-100" controlsList="nodownload" controls>
                        <source src="'.uploads($value['audio'], 'profile').'" type="audio/mp3">
                        '.e('Your browser does not support the audio element.').'
                    </audio>
                </div>
            </div>
        </div>';
    }

    /**
     * Delete Audio
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function audioDelete($id, $value){
        if(isset($value['audio']) && $value['audio']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['audio']);
        }
        if(isset($value['cover']) && $value['cover']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['cover']);
        }
    }
    /**
     * PDF Setup
     *
     * @author GemPixel <https://gempixel.com> 
     * @category Content
     * @version 7.6.1
     * @return void
     */
    public static function pdfSetup(){
        $type = 'pdf';
        
        return "function fnpdf(el, content = null, did = null){
            if(content){
                var title = content['title'] || '';
                var description = content['description'] || '';
            } else {
                var title = '';
                var description = '';
            }
            var blockpreview = title;
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Document Title').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][title]" value="\'+title+\'">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.self::e('Description').' ('.self::e('optional').')</label>
                                <textarea class="form-control p-2" name="data[\'+slug(did)+\'][description]" rows="3">\'+description+\'</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold d-block">'.self::e('PDF File').' \'+(content && content[\'pdf\'] ? \'<span class="float-end"><input type="checkbox" name="data[\'+slug(did)+\'][removepdf]" value="1" class="me-1" id="remove-\'+slug(did)+\'"><span class="align-text-bottom">'.self::e('Remove').'</span></span></label>\':\'\')+\'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept="application/pdf">
                                <p class="form-text">'.self::e('Acceptable file: PDF - Max size 10MB').'</p>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">                                  
                                <label class="form-label fw-bold d-block">'.self::e('Thumbnail').' \'+(content && content[\'thumbnail\'] ? \'<span class="float-end"><input type="checkbox" name="data[\'+slug(did)+\'][removethumb]" value="1" class="me-1" id="removethumb-\'+slug(did)+\'"><span class="align-text-bottom">'.self::e('Remove').'</span></span></label>\':\'\')+\'</label>
                                <img id="thumbnail-preview-\'+slug(did)+\'" src="\'+(content && content[\'thumbnail\'] ? content[\'thumbnail\'] : \'\')+\'" class="img-thumbnail" style="max-width: 200px; max-height: 150px; display: \'+(content && content[\'thumbnail\'] ? \'block\' : \'none\')+\';" alt="Thumbnail Preview">     
                                <input type="file" class="form-control p-2 mt-2" name="\'+slug(did)+\'-thumb" accept=".jpg,.jpeg,.png" data-auto-crop="true" data-allowed-extensions="jpg,jpeg,png" data-max-size="2048" data-ratio="1:1" data-preview-selector="#thumbnail-preview-\'+slug(did)+\'">
                                <p class="form-text">'.self::e('Acceptable files: JPG, JPEG, PNG - Max size 2MB').'</p>
                            </div>
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }

    /**
     * PDF Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.1
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function pdfSave($request, $profiledata, $data){
        
        $appConfig = appConfig('app');
        $key = $data['id'];

        
        if($pdf = $request->file($key)){
            if($pdf->ext !== 'pdf' || $pdf->sizekb > 10000) {
                throw new Exception(e('PDF must be in PDF format and maximum 10MB in size.'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_pdf".Helper::rand(6).str_replace(['#', ' '], '-', $pdf->name);
            $request->move($pdf, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['pdf']) && $profiledata['links'][$key]['pdf']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['pdf']);
            }

            $data['pdf'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['pdf'])) $data['pdf'] = $profiledata['links'][$key]['pdf'];
        }

        
        if($thumb = $request->file($key.'-thumb')){
            if(!$thumb->mimematch || !in_array($thumb->ext, ['jpg', 'jpeg', 'png']) || $thumb->sizekb > 2000) {
                throw new Exception(e('Thumbnail must be either a PNG or a JPEG (Max 2MB).'));
            }

            $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_pdf_thumb".Helper::rand(6).str_replace(['#', ' '], '-', $thumb->name);
            $request->move($thumb, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['thumbnail']) && $profiledata['links'][$key]['thumbnail']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['thumbnail']);
            }

            $data['thumbnail'] = $filename;
        } else {
            if(isset($profiledata['links'][$key]['thumbnail'])) $data['thumbnail'] = $profiledata['links'][$key]['thumbnail'];
        }

        if(isset($data['removepdf']) && $data['removepdf']){
            if(isset($profiledata['links'][$key]['pdf']) && $profiledata['links'][$key]['pdf']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['pdf']);
            }
            $data['pdf'] = '';
        }

        if(isset($data['removethumb']) && $data['removethumb']){
            if(isset($profiledata['links'][$key]['thumbnail']) && $profiledata['links'][$key]['thumbnail']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['thumbnail']);
            }
            $data['thumbnail'] = '';
        }

        return $data;
    }

    /**
     * PDF Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function pdfBlock($id, $value){
        if(!isset($value['pdf']) || !$value['pdf']) return;

        $thumb = isset($value['thumbnail']) && $value['thumbnail'] ? 
            '<img src="'.uploads($value['thumbnail'], 'profile').'" class="h-100 position-absolute start-0 left-0 top-50 translate-middle-y rounded-2">' : 
            '<div class="position-absolute start-0 left-0 top-50 translate-middle-y ms-3 ml-3">
                <i class="fa fa-file-pdf fa-2x text-danger"></i>
            </div>';
        
        $title = isset($value['title']) && $value['title'] ? 
            '<span class="align-top">'.Helper::clean($value['title']).'</span>' : '';
        $description = isset($value['description']) && $value['description'] ? 
            '<div class="opacity-75 small">'.Helper::clean($value['description']).'</div>' : '';

        return '<a href="#" data-toggle="modal" data-target="#modal-'.$id.'" data-bs-toggle="modal" data-bs-target="#modal-'.$id.'" class="btn btn-block p-3 mb-2 d-block btn-custom position-relative">
                    '.$thumb.'
                    '.$title.$description.'
            </a>
        <div class="modal fade" id="modal-'.$id.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h4 class="mb-0">'.$title.'</h4>
                            <button type="button" class="btn-close close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe src="'.uploads($value['pdf'], 'profile').'" width="100%" style="height:calc(100vh - 300px)"></iframe>
                        </div>
                        <div class="modal-body">
                            <a href="'.uploads($value['pdf'], 'profile').'" rel="nofollow" class="btn btn-dark text-white rounded-pill w-100 d-block py-2" download>'.self::e('Download').'</a>
                        </div>
                    </div>
                </div>
            </div>';
    }

    /**
     * Delete PDF
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function pdfDelete($id, $value){
        if(isset($value['pdf']) && $value['pdf']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['pdf']);
        }
        if(isset($value['thumbnail']) && $value['thumbnail']){
            App::delete(appConfig('app')['storage']['profile']['path'].'/'.$value['thumbnail']);
        }
    }
    /**
     * Intercom Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Content
     * @version 7.6.2
     * @return string
     */
    public static function intercomSetup(){

        $type = 'intercom';

        return "function fnintercom(el, content = null, did = null){

            if($('[data-id=intercom]').length > 0) {
                $.notify({
                    message: '".self::e('You can only have this widget once.')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

                        
            if($('[data-id=tawkto]').length > 0 || $('[data-id=tidio]').length > 0) {
                $.notify({
                    message: '".self::e('You already have a chat widget')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

            if(content){
                var text = content['app_id'];
            } else {
                var text = '';
            }

            var blockpreview = '';

            var did = 'intercom';

            let html = '".self::format(self::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.self::e('App ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][app_id]" placeholder="e.g. a6gaewt" value="\'+text+\'">
                        <p class="form-text">'.self::e('The App ID can be found in Settings > General > Workspace name & time zone').'
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }
    /**
     * Save Intercom Settings
     *
     * @author GemPixel
     * @version 7.6.3
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function intercomSave($request, $profiledata, $data){
        $data['app_id'] = clean($data['app_id']);
        
        if(empty($data['app_id'])) {
            throw new Exception(e('Please enter a valid Intercom App ID'));
        }    
        
        return $data;
    }

    /**
     * Display Intercom Block
     *
     * @author GemPixel
     * @version 7.6.3
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function intercomBlock($id, $value){
        if(!isset($value['app_id']) || empty($value['app_id'])) return '';
        
        $html = '<script>
            window.intercomSettings = {
                api_base: "https://api-iam.intercom.io",
                app_id: "'.clean($value['app_id']).'"
            };
        </script>
        <script>
            (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic("reattach_activator");ic("update",w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement("script");s.type="text/javascript";s.async=true;s.src="https://widget.intercom.io/widget/'.clean($value['app_id']).'";var x=d.getElementsByTagName("script")[0];x.parentNode.insertBefore(s,x);};if(document.readyState==="complete"){l();}else if(w.attachEvent){w.attachEvent("onload",l);}else{w.addEventListener("load",l,false);}}})();
        </script>';
        
        return $html;
    }

    /**
     * Tawk.to Widget Setup
     *
     * @author GemPixel
     * @category Content
     * @version 7.6.3
     * @return string
     */
    public static function tawktoSetup(){
        $type = 'tawkto';

        return "function fntawkto(el, content = null, did = null){
            
            if($('[data-id=tawkto]').length > 0) {
                $.notify({
                    message: '".self::e('You can only have this widget once.')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

            if($('[data-id=intercom]').length > 0 || $('[data-id=tidio]').length > 0) {
                $.notify({
                    message: '".self::e('You already have a chat widget')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

            if(content){
                var propertyId = content['property_id'];
                var widgetId = content['widget_id'];
            } else {
                var propertyId = '';
                var widgetId = '';
            }

            var did = 'tawkto';
            var blockpreview = '';

            let html = '".self::format(self::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Property ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][property_id]" placeholder="e.g. 6123456789abcdef1234567" value="\'+propertyId+\'">
                        <p class="form-text">'.self::e('Enter your Tawk.to Property ID').'</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Widget ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][widget_id]" placeholder="e.g. 1ab2c3d4" value="\'+widgetId+\'">
                        <p class="form-text">'.self::e('Enter your Tawk.to Widget ID').'</p>
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }

    /**
     * Save Tawk.to Settings
     *
     * @author GemPixel
     * @version 7.6.3
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function tawktoSave($request, $profiledata, $data){
        $data['property_id'] = clean($data['property_id']);
        $data['widget_id'] = clean($data['widget_id']);
        
        if(empty($data['property_id'])) {
            throw new Exception(e('Please enter a valid Property ID'));
        }

        if(empty($data['widget_id'])) {
            throw new Exception(e('Please enter a valid Widget ID'));
        }
        
        return $data;
    }

    /**
     * Display Tawk.to Block
     *
     * @author GemPixel
     * @version 7.6.3
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function tawktoBlock($id, $value){
        if(!isset($value['property_id']) || empty($value['property_id']) || !isset($value['widget_id']) || empty($value['widget_id'])) return '';
        
        $html = '<!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src="https://embed.tawk.to/'.clean($value['property_id']).'/'.clean($value['widget_id']).'";
            s1.charset="UTF-8";
            s1.setAttribute("crossorigin","*");
            s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->';
        
        return $html;
    }
    /**
     * Video Widget Setup
     *
     * @author GemPixel
     * @category Content
     * @version 7.6.2
     * @return string
     */
    public static function videoembedSetup(){
        $type = 'vembed';

        return "function fnvembed(el, content = null, did = null){
            if(content){
                var url = content['url'];
            } else {
                var url = '';
            }
            
            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".self::format(self::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Video URL').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][url]" placeholder="e.g. https://www.youtube.com/watch?v=..." value="\'+url+\'">
                        <p class="form-text">'.self::e('Supported platforms: YouTube, Vimeo, Dailymotion, Facebook Video, Kick, Twitch').'</p>
                    </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }

    /**
     * Save Video Settings
     *
     * @author GemPixel
     * @version 7.6.2
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function videoembedSave($request, $profiledata, $data){
        $data['url'] = clean($data['url']);
        
        if(empty($data['url'])) {
            throw new Exception(e('Please enter a valid video URL'));
        }

        if(preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $data['url'], $matches) || 
        preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
            $data['platform'] = 'youtube';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/vimeo\.com\/([0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'vimeo';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/dailymotion\.com\/video\/([a-zA-Z0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'dailymotion';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/facebook\.com\/watch\?v=([0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'facebook';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/kick\.com\/([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
            $data['platform'] = 'kick';
            $data['video_id'] = $matches[1];
        }elseif(preg_match('/twitch\.tv\/videos\/([0-9]+)/', $data['url'], $matches)) {
            $data['platform'] = 'twitch';
            $data['video_id'] = $matches[1];
            $data['videotype'] = 'video';
        }elseif(preg_match('/twitch\.tv\/([a-zA-Z0-9_]+)\/?$/', $data['url'], $matches)) {            
            $data['platform'] = 'twitch';
            $data['video_id'] = $matches[1];
            $data['videotype'] = 'channel';            
        }else {
            throw new Exception(e('Please enter a valid video URL from supported platforms'));
        }
        
        return $data;
    }

    /**
     * Display Video Block
     *
     * @author GemPixel
     * @version 7.6.2
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function videoembedBlock($id, $value){

        if(!isset($value['platform']) || !isset($value['video_id'])) return '';
        
        switch($value['platform']) {
            case 'youtube':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;" 
                            src="https://www.youtube.com/embed/'.clean($value['video_id']).'" 
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                            encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                break;
                
            case 'vimeo':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"  
                            src="https://player.vimeo.com/video/'.clean($value['video_id']).'" 
                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen></iframe>';
                break;
                
            case 'dailymotion':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"  
                            src="https://www.dailymotion.com/embed/video/'.clean($value['video_id']).'" 
                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen></iframe>';
                break;
                
            case 'facebook':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"  
                            src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fvideo.php%3Fv%3D'.clean($value['video_id']).'&show_text=0" 
                            frameborder="0" allow="autoplay; clipboard-write; encrypted-media; 
                            picture-in-picture; web-share" allowfullscreen></iframe>';
                break;

            case 'kick':
                $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"
                            src="https://player.kick.com/'.clean($value['video_id']).'"
                            frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                break;

            case 'twitch':
                if(isset($value['videotype']) && $value['videotype'] == 'channel') {
                    $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"
                                src="https://player.twitch.tv/?channel='.clean($value['video_id']).'&parent='.parse_url(url(''), PHP_URL_HOST).'"
                                frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                } else {
                    $embed = '<iframe class="w-100 rounded" width="100%" style="aspect-ratio: 9/6 auto;"
                                src="https://player.twitch.tv/?video='.clean($value['video_id']).'&parent='.parse_url(url(''), PHP_URL_HOST).'"
                                frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                }
                break;
                
            default:
                return '';
        }
        
        return '<div class="video-container">'.$embed.'</div>';
    }
    /**
     * tidio Widget Setup
     *
     * @author GemPixel
     * @category Content
     * @version 7.6.3
     * @return string
     */
    public static function tidioSetup(){
        $type = 'tidio';

        return "function fntidio(el, content = null, did = null){
            
            if($('[data-id=tidio]').length > 0) {
                $.notify({
                    message: '".self::e('You can only have this widget once')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

            if($('[data-id=intercom]').length > 0 || $('[data-id=tawkto]').length > 0 ) {
                $.notify({
                    message: '".self::e('You already have a chat widget')."'
                },{
                    type: 'danger',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                });
                $('#contentModal .btn-close').click();
                return false;
            }

            if(content){
                var projectId = content['project_id'];
            } else {
                var projectId = '';
            }

            var did = 'tidio';
            var blockpreview = '';

            let html = '".self::format(self::generateTemplate('<div class="form-group">
                        <label class="form-label fw-bold">'.self::e('Project ID').'</label>
                        <input type="text" class="form-control p-2" name="data['.$type.'][project_id]" placeholder="e.g. a6c9duekcirqkykm1os6mznmj49opvadd" value="\'+projectId+\'">
                        <p class="form-text">'.self::e('Enter your Tidio project ID. You caan get your Project ID from Tidio > Settings > Developer > Project data').'</p>
                    </div>', $type))."';

            $('#linkcontent').prepend(html);
            countryInit(did, content);
            languageInit(did, content);
        }";
    }

    /**
     * Save tidio Settings
     *
     * @author GemPixel
     * @version 7.6.3
     * @param Request $request
     * @param array $profiledata
     * @param array $data
     * @return array
     */
    public static function tidioSave($request, $profiledata, $data){
        $data['project_id'] = clean($data['project_id']);
        
        if(empty($data['project_id'])) {
            throw new Exception(e('Please enter a valid project ID'));
        }
        
        return $data;
    }

    /**
     * Display tidio Block
     *
     * @author GemPixel
     * @version 7.6.3
     * @param string $id
     * @param array $value
     * @return string
     */
    public static function tidioBlock($id, $value){
        if(!isset($value['project_id']) || empty($value['project_id'])) return '';
        
        $html = '<!--Start of Tidio Script-->
        <script src="//code.tidio.co/'.$value['project_id'].'.js" async></script>
        <!--End of Tidio Script-->';
        
        return $html;
    }
}