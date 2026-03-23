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
use Helpers\BioWidgets\Tagline;
use Helpers\BioWidgets\Heading;
use Helpers\BioWidgets\Divider;
use Helpers\BioWidgets\Text;
use Helpers\BioWidgets\Link;
use Helpers\BioWidgets\FeaturedLink;
use Helpers\BioWidgets\Html;
use Helpers\BioWidgets\Image;
use Helpers\BioWidgets\Phone;
use Helpers\BioWidgets\VCard;
use Helpers\BioWidgets\PayPal;
use Helpers\BioWidgets\WhatsAppCall;
use Helpers\BioWidgets\WhatsApp;
use Helpers\BioWidgets\Rss;
use Helpers\BioWidgets\Newsletter;
use Helpers\BioWidgets\Contact;
use Helpers\BioWidgets\FAQs;
use Helpers\BioWidgets\Product;
use Helpers\BioWidgets\MusicLink;
use Helpers\BioWidgets\YouTube;
use Helpers\BioWidgets\Spotify;
use Helpers\BioWidgets\Itunes;
use Helpers\BioWidgets\TikTok;
use Helpers\BioWidgets\OpenSea;
use Helpers\BioWidgets\Twitter;
use Helpers\BioWidgets\SoundCloud;
use Helpers\BioWidgets\Facebook;
use Helpers\BioWidgets\Instagram;
use Helpers\BioWidgets\Typeform;
use Helpers\BioWidgets\Pinterest;
use Helpers\BioWidgets\Reddit;
use Helpers\BioWidgets\Calendly;
use Helpers\BioWidgets\Threads;
use Helpers\BioWidgets\TikTokProfile;
use Helpers\BioWidgets\GoogleMaps;
use Helpers\BioWidgets\OpenTable;
use Helpers\BioWidgets\Eventbrite;
use Helpers\BioWidgets\Snapchat;
use Helpers\BioWidgets\LinkedIn;
use Helpers\BioWidgets\Video;
use Helpers\BioWidgets\Audio;
use Helpers\BioWidgets\PDF;
use Helpers\BioWidgets\Intercom;
use Helpers\BioWidgets\TawkTo;
use Helpers\BioWidgets\VideoEmbed;
use Helpers\BioWidgets\Tidio;
use Helpers\BioWidgets\Countdown;
use Helpers\BioWidgets\Carousel;

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
                    'setup' => [Link::class, 'setup'],
                    'save' => [Link::class, 'save'],
                    'delete' => [Link::class, 'delete'],
                    'block' => [Link::class, 'block'],
                    'processor' => [Link::class, 'processor'],
                ],
                'featuredlink' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-star"></i></h1>',
                    'title' => e('Featured Link'),
                    'description' => e('Add a featured link with rectangular image and title'),
                    'setup' => [FeaturedLink::class, 'setup'],
                    'save' => [FeaturedLink::class, 'save'],
                    'delete' => [FeaturedLink::class, 'delete'],
                    'block' => [FeaturedLink::class, 'block'],
                    'processor' => [FeaturedLink::class, 'processor'],
                ],            
                'tagline' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-info-circle"></i></h1>',
                    'title' => e('Tagline'),
                    'description' => e('Add a tagline under your profile name'),
                    'setup' => [Tagline::class, 'setup'],
                    'save' => [Tagline::class, 'save'],
                    'delete' => null,
                    'block' => [Tagline::class, 'block'],
                    'processor' => null,
                ],
                'heading' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-heading"></i></h1>',
                    'title' => e('Heading'),
                    'description' => e('Add a heading with different sizes'),
                    'setup' => [Heading::class, 'setup'],
                    'save' => [Heading::class, 'save'],
                    'delete' => null,
                    'block' => [Heading::class, 'block'],
                    'processor' => null,
                ],
                'text' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-align-center"></i></h1>',
                    'title' => e('Text'),
                    'description' => e('Add a text body to your page'),
                    'setup' => [Text::class, 'setup'],
                    'save' => [Text::class, 'save'],
                    'delete' => null,
                    'block' => [Text::class, 'block'],
                    'processor' => null,
                ],
                'divider' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-grip-lines"></i></h1>',
                    'title' => e('Divider'),
                    'description' => e('Separate your content with a line'),
                    'setup' => [Divider::class, 'setup'],
                    'save' => [Divider::class, 'save'],
                    'delete' => null,
                    'block' => [Divider::class, 'block'],
                    'processor' => null,
                ],
                'html' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-code"></i></h1>',
                    'title' => e('HTML'),
                    'description' => e('Add custom HTML code. Script codes are not accepted'),
                    'setup' => [Html::class, 'setup'],
                    'save' => [Html::class, 'save'],
                    'delete' => null,
                    'block' => [Html::class, 'block'],
                    'processor' => null,
                ],
                'image' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-image"></i></h1>',
                    'title' => e('Image'),
                    'description' => e('Upload an image or 2 images in a row'),
                    'setup' => [Image::class, 'setup'],
                    'save' => [Image::class, 'save'],
                    'delete' => [Image::class, 'delete'],
                    'block' => [Image::class, 'block'],
                    'processor' => null,
                ],
                'phone' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-phone"></i></h1>',
                    'title' => e('Phone Call'),
                    'description' => e('Set your phone number to call directly'),
                    'setup' => [Phone::class, 'setup'],
                    'save' => [Phone::class, 'save'],
                    'delete' => null,
                    'block' => [Phone::class, 'block'],
                    'processor' => null,
                ],

                'vcard' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-address-card"></i></h1>',
                    'title' => e('vCard'),
                    'description' => e('Add a downloadable vCard'),
                    'setup' => [VCard::class, 'setup'],
                    'save' => [VCard::class, 'save'],
                    'delete' => [VCard::class, 'delete'],
                    'block' => [VCard::class, 'block'],
                    'processor' => [VCard::class, 'processor'],
                ],
                'paypal' => [
                    'category' => 'content',
                    'icon' => '<img src="'.assets('images/paypal.svg').'" width="30">',
                    'title' => e('PayPal Button'),
                    'description' => e('Generate a PayPal button to accept payments'),
                    'setup' => [PayPal::class, 'setup'],
                    'save' => [PayPal::class, 'save'],
                    'delete' => null,
                    'block' => [PayPal::class, 'block'],
                    'processor' => null,
                ],
                'whatsappcall' => [
                    'category' => 'content',
                    'icon' => '<img src="'.assets('images/whatsapp.svg').'" width="30">',
                    'title' => e('WhatsApp Call'),
                    'description' => e('Add button to initiate a Whatsapp call'),
                    'setup' => [WhatsAppCall::class, 'setup'],
                    'save' => [WhatsAppCall::class, 'save'],
                    'delete' => null,
                    'block' => [WhatsAppCall::class, 'block'],
                    'processor' => null,
                ],
                'whatsapp' => [
                    'category' => 'content',
                    'icon' => '<img src="'.assets('images/whatsapp.svg').'" width="30">',
                    'title' => e('WhatsApp Message'),
                    'description' => e('Add button to send a Whatsapp message'),
                    'setup' => [WhatsApp::class, 'setup'],
                    'save' => [WhatsApp::class, 'save'],
                    'delete' => null,
                    'block' => [WhatsApp::class, 'block'],
                    'processor' => null,
                ],
                'rss' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-danger fa fa-rss"></i></h1>',
                    'title' => e('RSS Feed'),
                    'description' => e('Add a dynamic RSS feed widget'),
                    'setup' => [Rss::class, 'setup'],
                    'save' => [Rss::class, 'save'],
                    'delete' => null,
                    'block' => [Rss::class, 'block'],
                    'processor' => null,
                ],
                'newsletter' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-primary fa fa-envelope-open"></i></h1>',
                    'title' => e('Newsletter'),
                    'description' => e('Add a newsletter form to store emails'),
                    'setup' => [Newsletter::class, 'setup'],
                    'save' => [Newsletter::class, 'save'],
                    'delete' => null,
                    'block' => [Newsletter::class, 'block'],
                    'processor' => [Newsletter::class, 'processor'],
                ],
                'contact' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-success fa fa-envelope-square"></i></h1>',
                    'title' => e('Contact Form'),
                    'description' => e('Add a contact form to receive emails'),
                    'setup' => [Contact::class, 'setup'],
                    'save' => [Contact::class, 'save'],
                    'delete' => null,
                    'block' => [Contact::class, 'block'],
                    'processor' => [Contact::class, 'processor'],
                ],
                'faqs' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-info fa fa-question-circle "></i></h1>',
                    'title' => e('FAQs'),
                    'description' => e('Add a widget of questions and answers'),
                    'setup' => [FAQs::class, 'setup'],
                    'save' => [FAQs::class, 'save'],
                    'delete' => null,
                    'block' => [FAQs::class, 'block'],
                    'processor' => null,
                ],
                'product' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-warning fa fa-store"></i></h1>',
                    'title' => e('Product'),
                    'description' => e('Add a widget to a product on your site'),
                    'setup' => [Product::class, 'setup'],
                    'save' => [Product::class, 'save'],
                    'delete' => [Product::class, 'delete'],
                    'block' => [Product::class, 'block'],
                    'processor' => null,
                ],
                'musiclink' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="text-danger fa fa-music"></i></h1>',
                    'title' => e('Music/Booking Links'),
                    'description' => e('Add a dynamic widget for all of your music or booking links'),
                    'setup' => [MusicLink::class, 'setup'],
                    'save' => [MusicLink::class, 'save'],
                    'delete' => null,
                    'block' => [MusicLink::class, 'block'],
                    'processor' => [Link::class, 'processor'],
                ],
                'youtube' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/youtube.svg').'" width="30">',
                    'title' => e('Youtube Video or Playlist'),
                    'description' => e('Embed a Youtube video or a playlist'),
                    'setup' => [YouTube::class, 'setup'],
                    'save' => [YouTube::class, 'save'],
                    'delete' => null,
                    'block' => [YouTube::class, 'block'],
                    'processor' => null,
                ],
                'spotify' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/spotify.svg').'" width="30">',
                    'title' => e('Spotify Embed'),
                    'description' => e('Embed a Spotify music or playlist widget'),
                    'setup' => [Spotify::class, 'setup'],
                    'save' => [Spotify::class, 'save'],
                    'delete' => null,
                    'block' => [Spotify::class, 'block'],
                    'processor' => null,
                ],
                'itunes' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/itunes.svg').'" width="30">',
                    'title' => e('Apple Music Embed'),
                    'description' => e('Embed an Apple music widget'),
                    'setup' => [Itunes::class, 'setup'],
                    'save' => [Itunes::class, 'save'],
                    'delete' => null,
                    'block' => [Itunes::class, 'block'],
                    'processor' => null,
                ],
                'tiktok' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/tiktok.svg').'" width="30">',
                    'title' => e('TikTok Embed'),
                    'description' => e('Embed a tiktok video'),
                    'setup' => [TikTok::class, 'setup'],
                    'save' => [TikTok::class, 'save'],
                    'delete' => null,
                    'block' => [TikTok::class, 'block'],
                    'processor' => null,
                ],
                'opensea' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/opensea.svg').'" width="30">',
                    'title' => e('OpenSea NFT'),
                    'description' => e('Embed your NFT from OpenSea'),
                    'setup' => [OpenSea::class, 'setup'],
                    'save' => [OpenSea::class, 'save'],
                    'delete' => null,
                    'block' => [OpenSea::class, 'block'],
                    'processor' => null,
                ],
                'twitter' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/twitter.svg').'" width="30">',
                    'title' => e('Embed Tweets'),
                    'description' => e('Embed your latest tweets'),
                    'setup' => [Twitter::class, 'setup'],
                    'save' => [Twitter::class, 'save'],
                    'delete' => null,
                    'block' => [Twitter::class, 'block'],
                    'processor' => null,
                ],
                'soundcloud' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/soundcloud.svg').'" width="30">',
                    'title' => e('SoundCloud'),
                    'description' => e('Embed a SoundCloud track'),
                    'setup' => [SoundCloud::class, 'setup'],
                    'save' => [SoundCloud::class, 'save'],
                    'delete' => null,
                    'block' => [SoundCloud::class, 'block'],
                    'processor' => null,
                ],
                'facebook' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/facebook.svg').'" width="30">',
                    'title' => e('Facebook Post'),
                    'description' => e('Embed a Facebook post'),
                    'setup' => [Facebook::class, 'setup'],
                    'save' => [Facebook::class, 'save'],
                    'delete' => null,
                    'block' => [Facebook::class, 'block'],
                    'processor' => null,
                ],
                'instagram' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/instagram.svg').'" width="30">',
                    'title' => e('Instagram Post'),
                    'description' => e('Embed an Instagram post'),
                    'setup' => [Instagram::class, 'setup'],
                    'save' => [Instagram::class, 'save'],
                    'delete' => null,
                    'block' => [Instagram::class, 'block'],
                    'processor' => null,
                ],
                'typeform' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/typeform.svg').'" width="30">',
                    'title' => e('Typeform'),
                    'description' => e('Embed a Typeform form'),
                    'setup' => [Typeform::class, 'setup'],
                    'save' => [Typeform::class, 'save'],
                    'delete' => null,
                    'block' => [Typeform::class, 'block'],
                    'processor' => null
                ],
                'pinterest' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/pinterest.svg').'" width="30">',
                    'title' => e('Pinterest'),
                    'description' => e('Embed a Pinterest board'),
                    'setup' => [Pinterest::class, 'setup'],
                    'save' => [Pinterest::class, 'save'],
                    'delete' => null,
                    'block' => [Pinterest::class, 'block'],
                    'processor' => null,
                ],
                'reddit' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/reddit.svg').'" width="30">',
                    'title' => e('Reddit'),
                    'description' => e('Embed a Reddit profile'),
                    'setup' => [Reddit::class, 'setup'],
                    'save' => [Reddit::class, 'save'],
                    'delete' => null,
                    'block' => [Reddit::class, 'block'],
                    'processor' => null,
                ],
                'calendly' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/calendly.svg').'" width="30">',
                    'title' => e('Calendly'),
                    'description' => e('Schedule booking & appointments'),
                    'setup' => [Calendly::class, 'setup'],
                    'save' => [Calendly::class, 'save'],
                    'delete' => null,
                    'block' => [Calendly::class, 'block'],
                    'processor' => [Calendly::class, 'processor'],
                ],
                'threads' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/threads.svg').'" width="30">',
                    'title' => e('Threads'),
                    'description' => e('Display a Threads post'),
                    'setup' => [Threads::class, 'setup'],
                    'save' => [Threads::class, 'save'],
                    'delete' => null,
                    'block' => [Threads::class, 'block'],
                    'processor' => null,
                ],
                'tiktokprofile' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/tiktok.svg').'" width="30">',
                    'title' => e('TikTok Profile'),
                    'description' => e('Display your profile'),
                    'setup' => [TikTokProfile::class, 'setup'],
                    'save' => [TikTokProfile::class, 'save'],
                    'delete' => null,
                    'block' => [TikTokProfile::class, 'block'],
                    'processor' => null,
                ],
                'googlemaps' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/maps.svg').'" width="30">',
                    'title' => e('Google Maps'),
                    'description' => e('Add a pin to your location on Google Maps'),
                    'setup' => [GoogleMaps::class, 'setup'],
                    'save' => [GoogleMaps::class, 'save'],
                    'delete' => null,
                    'block' => [GoogleMaps::class, 'block'],
                    'processor' => null,
                ],
                'opentable' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/opentable.svg').'" width="30">',
                    'title' => e('OpenTable Reservation'),
                    'description' => e('Allow visitors to easily book a table'),
                    'setup' => [OpenTable::class, 'setup'],
                    'save' => [OpenTable::class, 'save'],
                    'delete' => null,
                    'block' => [OpenTable::class, 'block'],
                    'processor' => null,
                ],
                'eventbrite' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/eventbrite.svg').'" width="30">',
                    'title' => e('EventBrite'),
                    'description' => e('Allow visitors to easily book an event'),
                    'setup' => [Eventbrite::class, 'setup'],
                    'save' => [Eventbrite::class, 'save'],
                    'delete' => null,
                    'block' => [Eventbrite::class, 'block'],
                    'processor' => null,
                ],
                'snapchat' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/snapchat.svg').'" width="30">',
                    'title' => e('Snapchat'),
                    'description' => e('Add a Snapchat widget on your page'),
                    'setup' => [Snapchat::class, 'setup'],
                    'save' => [Snapchat::class, 'save'],
                    'delete' => null,
                    'block' => [Snapchat::class, 'block'],
                    'processor' => null,
                ],
                'linkedin' => [
                    'category' => 'widgets',
                    'icon' => '<img src="'.assets('images/linkedin.svg').'" width="30">',
                    'title' => e('LinkedIn Post'),
                    'description' => e('Display a LinkedIn post'),
                    'setup' => [LinkedIn::class, 'setup'],
                    'save' => [LinkedIn::class, 'save'],
                    'delete' => null,
                    'block' => [LinkedIn::class, 'block'],
                    'processor' => null,
                ],
                'video' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-video text-warning"></i></h1>',
                    'title' => e('Video'),
                    'description' => e('Upload a video'),
                    'setup' => [Video::class, 'setup'],
                    'save' => [Video::class, 'save'],
                    'delete' => [Video::class, 'delete'],
                    'block' => [Video::class, 'block'],
                    'processor' => null,
                ],
                'audio' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-music text-primary"></i></h1>',
                    'title' => e('Audio'),
                    'description' => e('Upload an MP3 audio file'),
                    'setup' => [Audio::class, 'setup'],
                    'save' => [Audio::class, 'save'],
                    'delete' => [Audio::class, 'delete'],
                    'block' => [Audio::class, 'block'],
                    'processor' => null,
                ],
                'pdf' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-file-pdf"></i></h1>',
                    'title' => e('PDF Document'),
                    'description' => e('Upload a PDF document with preview'),
                    'setup' => [PDF::class, 'setup'],
                    'save' => [PDF::class, 'save'],
                    'delete' => [PDF::class, 'delete'],
                    'block' => [PDF::class, 'block'],
                    'processor' => null,
                ],
                'intercom' => [
                    'category' => 'communication',
                    'icon' => '<h1><i class="fab fa-intercom"></i></h1>',
                    'title' => e('Intercom Chat'),
                    'description' => e('Add Intercom live chat widget to your profile'),
                    'setup' => [Intercom::class, 'setup'],
                    'delete' => null,
                    'save' => [Intercom::class, 'save'],
                    'block' => [Intercom::class, 'block'],
                    'processor' => null,
                ],
                'tawkto' => [
                    'category' => 'communication',
                    'icon' => '<img src="'.assets('images/tawkto.svg').'" width="30">',
                    'title' => e('Tawk.to Chat'),
                    'description' => e('Add Tawk.to live chat widget to your profile'),
                    'delete' => null,
                    'setup' => [TawkTo::class, 'setup'],
                    'save' => [TawkTo::class, 'save'],
                    'block' => [TawkTo::class, 'block'],
                    'processor' => null,
                ],
                'tidio' => [
                    'category' => 'communication',
                    'icon' => '<img src="'.assets('images/tidio.svg').'" width="30">',
                    'title' => e('Tidio Chat'),
                    'description' => e('Add tidio live chat widget to your profile'),
                    'delete' => null,
                    'setup' => [Tidio::class, 'setup'],
                    'save' => [Tidio::class, 'save'],
                    'block' => [Tidio::class, 'block'],
                    'processor' => null,
                ],
                'vembed' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-film text-info"></i></h1>',
                    'title' => e('Video Embed'),
                    'description' => e('Embed videos from YouTube, Vimeo, Dailymotion and more'),
                    'setup' => [VideoEmbed::class, 'setup'],
                    'save' => [VideoEmbed::class, 'save'],
                    'block' => [VideoEmbed::class, 'block'],
                ],
                'countdown' => [
                    'category' => 'widgets',
                    'icon' => '<h1><i class="fa fa-clock text-danger"></i></h1>',
                    'title' => e('Countdown'),
                    'description' => e('Add a countdown timer with an expiration message'),
                    'setup' => [Countdown::class, 'setup'],
                    'save' => [Countdown::class, 'save'],
                    'delete' => null,
                    'block' => [Countdown::class, 'block'],
                    'processor' => null,
                ],
                'carousel' => [
                    'category' => 'content',
                    'icon' => '<h1><i class="fa fa-images text-primary"></i></h1>',
                    'title' => e('Carousel'),
                    'description' => e('Create an image carousel with up to 5 images'),
                    'setup' => [Carousel::class, 'setup'],
                    'save' => [Carousel::class, 'save'],
                    'delete' => [Carousel::class, 'delete'],
                    'block' => [Carousel::class, 'block'],
                    'processor' => null,
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
    public static function render($id, $value, $user = null){

        if(isset(config('bio')->blocked) && in_array($value['type'], config('bio')->blocked)) return;

        $permissions = json_decode($user->plan()['permission'], true);

        $bioblocks = $permissions['bioblocks'] ?? null;


        if(isset($bioblocks['custom']) && !empty($bioblocks['custom'])){
            $list = explode(',', $bioblocks['custom']);
            if(!in_array($value['type'], $list)) return;
        }

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

        $user = Auth::user();

        $permissions = json_decode($user->plan()['permission'], true);

        $bioblocks = $permissions['bioblocks'] ?? null;

        if(isset($bioblocks['custom']) && !empty($bioblocks['custom'])){
            $list = explode(',', $bioblocks['custom']);
            if(!in_array($data['type'], $list)) throw new Exception(e('Block not available in your plan, please upgrade.'));
        }
        
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
        echo self::format("function truncate(text, length) {
            return text && text.length > length ? text.substring(0, length) + '...' : text;
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
                            <div class="mb-0 flex-fill"><a class="text-dark d-block py-1" data-bs-toggle="collapse" data-bs-target="#container-\'+did+\'" aria-expanded="false"><h5 class="my-0"><i class="fa fa-chevron-down me-2"></i><span class="small-icon">\'+$(\'[data-type="'.$type.'"] .icon\').html()+\'</span><span class="align-top fw-bold">\'+$(\'[data-type="'.$type.'"] h5\').text()+\'</span></h5> <p class="text-muted mb-0 text-small small">\'+truncate(blockpreview, 80)+\'</p></a></div>
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
}