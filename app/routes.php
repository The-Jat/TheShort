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
use Core\Helper;
use Core\Localization;

\Helpers\App::checkEncryption();

$prefix = '';
if(in_array(request()->segment(1), Localization::listArray())){
    $prefix = '/'.request()->segment(1);
    Localization::setLocale(request()->segment(1));
}

// Homepage
Gem::route(['GET','POST'], $prefix.'/', 'Home@index')->name('home')->middleware('CheckDomain')->middleware('CheckMaintenance')->middleware('CheckPrivate');

// Pricing Page
Gem::get($prefix.'/pricing', 'Subscription@pricing')->name('pricing')->middleware('CheckDomain')->middleware('CheckMaintenance')->middleware('CheckPrivate');
Gem::get($prefix.'/checkout/{id}/{type}', 'Subscription@checkout')->name('checkout');
Gem::post($prefix.'/checkout/{id}/{type}', 'Subscription@process')->middleware('Auth')->name('checkout.process');
Gem::get($prefix.'/checkout/{id}/{type}/coupon', 'Subscription@coupon')->middleware('Auth')->name('checkout.coupon');
Gem::get($prefix.'/checkout/{id}/{type}/tax', 'Subscription@tax')->middleware('Auth')->name('checkout.tax');
Gem::post($prefix.'/checkout/redeem', 'Subscription@redeem')->middleware('Auth')->name('checkout.redeem');

// Custom Page
Gem::get($prefix.'/page/{page}', 'Page@index')->name('page')->middleware('CheckDomain')->middleware('CheckMaintenance');
Gem::get($prefix.'/qr-codes', 'Page@qr')->name('page.qr')->middleware('CheckDomain')->middleware('CheckMaintenance');
Gem::get($prefix.'/bio-profiles', 'Page@bio')->name('page.bio')->middleware('CheckDomain')->middleware('CheckMaintenance');

// Contact Page
Gem::get($prefix.'/contact', 'Page@contact')->name('contact')->middleware('CheckDomain')->middleware('CheckPrivate');
Gem::post($prefix.'/contact/send', 'Page@contactSend')->middleware('CheckPrivate')->middleware('BlockBot')->middleware('CheckDomain')->middleware('ValidateCaptcha')->name('contact.send');
// Report Page
Gem::get($prefix.'/report', 'Page@report')->name('report')->middleware('CheckDomain')->middleware('CheckPrivate');
Gem::post($prefix.'/report/send', 'Page@reportSend')->middleware('BlockBot')->middleware('CheckDomain')->middleware('ValidateCaptcha')->middleware('CheckPrivate')->name('report.send');

Gem::get($prefix.'/developers', 'Page@api')->name('apidocs')->middleware('CheckDomain')->middleware('CheckMaintenance')->middleware('CheckPrivate');
Gem::get($prefix.'/consent', 'Page@consent')->name('consent');

Gem::get($prefix.'/oauth/authorize', 'API\OAuth@authorize')->name('oauth.authorize');
Gem::post($prefix.'/oauth/authorize/proceed', 'API\OAuth@proceed')->name('oauth.proceed');

Gem::route(['GET', 'POST'], $prefix.'/verify/links', 'Link@verify')->name('links.verify');

// Blog Group
Gem::group($prefix.'/blog', function(){
    Gem::setMiddleware(['CheckDomain', 'CheckPrivate']);
    Gem::get('/', 'Blog@index')->name('blog');
    Gem::get('/category/{post}', 'Blog@category')->name('blog.category');
    Gem::get('/search', 'Blog@search')->name('blog.search');    
    Gem::get('/{post}', 'Blog@post')->name('blog.post');
});

Gem::post($prefix.'/shorten', 'Link@shorten')->name('shorten')->middleware('BlockBot')->middleware('ShortenThrottle')->middleware('ValidateLoggedCaptcha');

Gem::get($prefix.'/faq', 'Page@faq')->name('faq')->middleware('CheckDomain')->middleware('CheckPrivate');

Gem::get($prefix.'/help', 'Help@index')->name('help')->middleware('CheckDomain')->middleware('CheckPrivate');
Gem::get($prefix.'/help/topic/{category}', 'Help@category')->name('help.category')->middleware('CheckDomain')->middleware('CheckPrivate');
Gem::get($prefix.'/help/search/', 'Help@search')->name('help.search')->middleware('CheckDomain')->middleware('CheckPrivate');
Gem::get($prefix.'/help/article/{slug}', 'Help@single')->name('help.single')->middleware('CheckDomain')->middleware('CheckPrivate');
Gem::post($prefix.'/help/article/{slug}/{vote}', 'Help@vote')->name('help.vote')->middleware('CheckDomain')->middleware('CheckPrivate');

Gem::get($prefix.'/affiliate', 'Page@affiliate')->name('affiliate')->middleware('CheckDomain')->middleware('CheckPrivate');

Gem::route(['GET', 'POST'], '/u/{username}', 'Link@profile')->name('profile')->middleware('CheckDomain');

// Gem::get('/packed.{ext}', 'Home@packed')->name('packed')->middleware('CheckDomain');

Gem::get('/user/login/facebook', 'Users@loginWithFacebook')->middleware('CheckDomain')->middleware('UserLogged')->name('login.facebook');
Gem::get('/user/login/twitter', 'Users@loginWithTwitter')->middleware('CheckDomain')->middleware('UserLogged')->name('login.twitter');
Gem::get('/user/login/google', 'Users@loginWithGoogle')->middleware('CheckDomain')->middleware('UserLogged')->name('login.google');

Gem::group($prefix.'/user', function(){

    Gem::get('/login', 'Users@login')->middleware('CheckDomain')->middleware('UserLogged')->name('login');
    Gem::post('/login/auth', 'Users@loginAuth')->middleware('BlockBot')->middleware('CheckDomain')->middleware('UserLogged')->middleware('ValidateCaptcha')->name('login.auth');
    Gem::get('/login/2fa', 'Users@login2FA')->middleware('CheckDomain')->middleware('UserLogged')->name('login.2fa');
    Gem::post('/login/2fa/validate', 'Users@login2FAValidate')->middleware('CheckDomain')->middleware('UserLogged')->name('login.2fa.validate');
    Gem::post('/login/2fa/recover', 'Users@login2FARecover')->middleware('CheckDomain')->middleware('UserLogged')->name('login.2fa.recover');

    Gem::get('/login/sso/{token}', 'Users@sso')->middleware('CheckDomain')->middleware('UserLogged')->name('login.sso');

    Gem::get('/login/verifyemail', 'Users@verifyEmail')->name('verifyemail');

    Gem::get('/register', 'Users@register')->middleware('CheckDomain')->middleware('UserLogged')->name('register');
    Gem::post('/register/validate', 'Users@registerValidate')->middleware('BlockBot')->middleware('UserLogged')->middleware('ValidateCaptcha')->name('register.validate');

    Gem::get('/login/forgot', 'Users@forgot')->middleware('CheckDomain')->name('forgot');
    Gem::post('/login/forgot/send', 'Users@forgotSend')->middleware('CheckDomain')->middleware('ValidateCaptcha')->name('forgot.send');
    Gem::get('/login/reset/{token}', 'Users@reset')->middleware('CheckDomain')->name('reset');
    Gem::post('/login/reset/{token}/change', 'Users@resetChange')->middleware('CheckDomain')->name('reset.change');
    Gem::get('/activate/{token}', 'Users@activate')->middleware('CheckDomain')->name('activate');
    Gem::get('/invited/{token}', 'Users@invited')->middleware('CheckDomain')->name('invited');
    Gem::post('/invited/{token}/accept', 'Users@acceptInvitation')->middleware('CheckDomain')->name('acceptinvitation');

    Gem::get('/login/2fa/reset/{token}', 'Users@reset2FA')->name('reset2fa');

    Gem::get('/unsubscribe', 'Users@unsubscribe')->middleware('CheckDomain')->name('unsubscribe');

    // Protect all routes below with Auth Middleware
    Gem::setMiddleware(['CheckDomain', 'Auth']);

    Gem::get('/','User\Dashboard@index')->name('dashboard');
    Gem::get('/logout', 'Users@logout')->name('logout');
    Gem::get('/return', 'Users@return')->name('return');

    Gem::get('/links', 'User\Dashboard@links')->name('links');
    Gem::get('/links/archived', 'User\Dashboard@archived')->name('archive');
    Gem::get('/links/expired', 'User\Dashboard@expired')->name('expired');
    Gem::get('/links/fetch', 'User\Dashboard@fetch')->name('links.fetch');
    Gem::get('/links/refresh', 'User\Dashboard@refresh')->name('links.refresh');
    Gem::get('/links/refresh/archive', 'User\Dashboard@refreshArchive')->name('links.refresh.archive');
    Gem::get('/links/{id}/delete/{token}', 'Link@delete')->name('links.delete');
    Gem::post('/links/deleteselected', 'Link@deleteMany')->name('links.deleteall');
    Gem::get('/links/archiveselected', 'Link@archiveSelected')->name('links.archive');
    Gem::get('/links/unarchiveselected', 'Link@unarchiveSelected')->name('links.unarchive');
    Gem::get('/links/publicselected', 'Link@publicSelected')->name('links.public');
    Gem::get('/links/privateselected', 'Link@privateSelected')->name('links.private');
    Gem::post('/links/exportselected', 'User\Export@exportSelected')->name('links.export');
    Gem::post('/links/addtocampaign', 'Link@addtocampaign')->name('links.addtocampaign');
    Gem::get('/links/{id}/edit', 'Link@edit')->name('links.edit');
    Gem::post('/links/{id}/update', 'Link@update')->name('links.update');
    Gem::get('/links/{id}/reset/{token}', 'Link@reset')->name('links.reset');

    Gem::get('/campaigns', 'User\Campaigns@index')->name('campaigns');
    Gem::post('/campaigns/save', 'User\Campaigns@save')->name('campaigns.save');
    Gem::post('/campaigns/{id}/update', 'User\Campaigns@update')->name('campaigns.update');
    Gem::get('/campaigns/{id}/delete/{token}', 'User\Campaigns@delete')->name('campaigns.delete');
    Gem::get('/campaigns/{id}/stats', 'User\Campaigns@stats')->name('campaigns.stats');
    Gem::get('/campaigns/{id}/statistics/clicks', 'User\Campaigns@statsClicks')->name('campaigns.stats.clicks');
    Gem::get('/campaigns/{id}/statistics/map', 'User\Campaigns@statsMap')->name('campaigns.stats.map');
    Gem::get('/campaigns/{id}/statistics/browser', 'User\Campaigns@statsBrowser')->name('campaigns.stats.browser');
    Gem::get('/campaigns/{id}/statistics/os', 'User\Campaigns@statsOs')->name('campaigns.stats.os');

    Gem::get('/search', 'User\Dashboard@search')->name('search');

    Gem::get('/integrations[/{name}]', 'User\Integrations@index')->name('integrations');

    Gem::get('/tools', 'User\Tools@index')->name('tools');
    Gem::get('/tools/slack', 'User\Tools@slack')->name('user.slack');
    Gem::post('/tools/zapier', 'User\Tools@zapier')->name('user.zapier');

    Gem::get('/confirmation', 'User\Account@confirmation')->name('confirmation');
    Gem::get('/billing', 'User\Account@billing')->name('billing');
    Gem::get('/billing/manage', 'User\Account@manage')->name('billing.manage');
    Gem::post('/billing/cancel', 'User\Account@billingCancel')->name('cancel');
    Gem::post('/terminate', 'User\Account@terminate')->name('terminate');    
    Gem::get('/settings', 'User\Account@settings')->name('settings');
    Gem::post('/settings/update', 'User\Account@settingsUpdate')->name('settings.update');
    Gem::post('/settings/api/regenerate', 'User\Account@regenerateApi')->name('regenerateapi');
    Gem::get('/twofa/{action}/{nonce}', 'User\Account@twoFA')->name('2fa');
    Gem::get('/settings/connect/{provider}', 'User\Account@connect')->name('settings.connect');

    Gem::get('/developers/apikeys', 'User\Developers@keys')->name('apikeys');
    Gem::post('/developers/apikeys/create', 'User\Developers@keyCreate')->name('apikeys.create');
    Gem::get('/developers/apikeys/{id}/revoke/{nonce}', 'User\Developers@keyRevoke')->name('apikeys.revoke');

    Gem::route(['GET', 'POST'], '/security', 'User\Account@security')->name('user.security');

    Gem::get('/splash/', 'User\Splash@index')->name('splash');
    Gem::get('/splash/create', 'User\Splash@create')->name('splash.create');
    Gem::post('/splash/save', 'User\Splash@save')->name('splash.save');
    Gem::get('/splash/{id}/edit', 'User\Splash@edit')->name('splash.edit');
    Gem::post('/splash/{id}/update', 'User\Splash@update')->name('splash.update');
    Gem::get('/splash/{id}/toggle', 'User\Splash@toggle')->name('splash.toggle');
    Gem::get('/splash/{id}/delete/{nonce}', 'User\Splash@delete')->name('splash.delete');

    Gem::get('/overlay/', 'User\Overlay@index')->name('overlay');
    Gem::get('/overlay/create[/{action}]', 'User\Overlay@create')->name('overlay.create');
    Gem::post('/overlay/save/{action}', 'User\Overlay@save')->name('overlay.save');
    Gem::get('/overlay/{id}/edit', 'User\Overlay@edit')->name('overlay.edit');
    Gem::post('/overlay/{id}/update', 'User\Overlay@update')->name('overlay.update');
    Gem::get('/overlay/{id}/delete/{nonce}', 'User\Overlay@delete')->name('overlay.delete');

    Gem::get('/pixels/', 'User\Pixels@index')->name('pixel');
    Gem::get('/pixels/create', 'User\Pixels@create')->name('pixel.create');
    Gem::post('/pixels/save', 'User\Pixels@save')->name('pixel.save');
    Gem::get('/pixels/{id}/edit', 'User\Pixels@edit')->name('pixel.edit');
    Gem::post('/pixels/{id}/update', 'User\Pixels@update')->name('pixel.update');
    Gem::get('/pixels/{id}/delete/{nonce}', 'User\Pixels@delete')->name('pixel.delete');
    Gem::post('/pixels/assign', 'User\Pixels@addto')->name('pixels.addto');

    Gem::get('/domains/', 'User\Domains@index')->name('domain');
    Gem::get('/domains/create', 'User\Domains@create')->name('domain.create');
    Gem::post('/domains/save', 'User\Domains@save')->name('domain.save');
    Gem::get('/domains/{id}/delete/{nonce}', 'User\Domains@delete')->name('domain.delete');
    Gem::get('/domains/{id}/edit', 'User\Domains@edit')->name('domain.edit');
    Gem::post('/domains/{id}/update', 'User\Domains@update')->name('domain.update');

    Gem::get('/teams/', 'User\Teams@index')->name('team');
    Gem::post('/teams/invite', 'User\Teams@invite')->name('team.save');
    Gem::get('/teams/user/{id}/remove/{nonce}', 'User\Teams@delete')->name('team.delete');
    Gem::get('/teams/{id}/edit', 'User\Teams@edit')->name('team.edit');
    Gem::post('/teams/{id}/update', 'User\Teams@update')->name('team.update');
    Gem::get('/teams/switch/{token}', 'User\Teams@switch')->name('team.switch');
    Gem::get('/teams/toggle/{id}', 'User\Teams@toggle')->name('team.toggle');
    Gem::get('/teams/{token}/accept', 'User\Teams@accept')->name('team.accept');

    Gem::get('/qr/', 'User\QR@index')->name('qr');
    Gem::get('/qr/create', 'User\QR@create')->name('qr.create');
    Gem::post('/qr/preview', 'User\QR@preview')->name('qr.preview');
    Gem::post('/qr/save', 'User\QR@save')->name('qr.save');
    Gem::get('/qr/{id}/edit', 'User\QR@edit')->name('qr.edit');
    Gem::post('/qr/{id}/update', 'User\QR@update')->name('qr.update');
    Gem::get('/qr/{id}/delete/{nonce}', 'User\QR@delete')->name('qr.delete');
    Gem::post('/qr/deleteall', 'User\QR@deleteall')->name('qr.deleteall');
    Gem::get('/qr/{id}/duplicate', 'User\QR@duplicate')->name('qr.duplicate');
    Gem::post('/qr/downloadall', 'User\QR@downloadall')->name('qr.downloadall');

    Gem::get('/qr/create/bulk', 'User\QR@createbulk')->name('qr.createbulk');
    Gem::post('/qr/save/bulk', 'User\QR@savebulk')->name('qr.savebulk');

    Gem::get('/bio/', 'User\Bio@index')->name('bio');    
    Gem::post('/bio/save', 'User\Bio@save')->name('bio.save');
    Gem::get('/bio/{id}/preview', 'User\Bio@preview')->name('bio.preview');
    Gem::get('/bio/{id}/edit', 'User\Bio@edit')->name('bio.edit');
    Gem::post('/bio/{id}/update', 'User\Bio@update')->name('bio.update');
    Gem::post('/bio/{id}/update/settings', 'User\Bio@updateSettings')->name('bio.update.settings');
    Gem::post('/bio/{id}/update/order', 'User\Bio@updateOrder')->name('bio.update.order');
    Gem::post('/bio/{id}/update/{block}', 'User\Bio@updateBlock')->name('bio.update.block');
    Gem::get('/bio/{id}/update/{block}/delete', 'User\Bio@deleteBlock')->name('bio.delete.block');
    Gem::get('/bio/{id}/delete/{nonce}', 'User\Bio@delete')->name('bio.delete');
    Gem::get('/bio/{id}/default', 'User\Bio@default')->name('bio.default');
    Gem::get('/bio/{id}/duplicate', 'User\Bio@duplicate')->name('bio.duplicate');
    Gem::get('/bio/widgetjs', 'User\Bio@widgets')->name('bio.widgetjs');    
    Gem::post('/bio/{id}/update/toggle/{i}', 'User\Bio@toggle')->name('bio.toggle');
    
    Gem::get('/statistics', 'User\Stats@index')->name('user.stats');
    Gem::get('/statistics/alllinks', 'User\Stats@statsLinks')->name('user.stats.links');
    Gem::get('/statistics/allclicks', 'User\Stats@statsClicks')->name('user.stats.clicks');
    Gem::get('/statistics/map', 'User\Stats@clicksMap')->name('user.stats.map');
    Gem::get('/statistics/platforms', 'User\Stats@clicksPlatforms')->name('user.stats.platforms');    
    Gem::get('/statistics/browsers', 'User\Stats@clicksBrowsers')->name('user.stats.browsers');    
    Gem::get('/statistics/languages', 'User\Stats@clicksLanguages')->name('user.stats.languages');    
    Gem::get('/statistics/clicks', 'User\Dashboard@statsClicks')->name('user.clicks');
    Gem::get('/statistics/recent', 'User\Stats@recent')->name('user.stats.recent');

    Gem::get('/channels', 'User\Channels@index')->name('channels');
    Gem::get('/channel/{id}', 'User\Channels@channel')->name('channel');
    Gem::post('/channel/save', 'User\Channels@save')->name('channel.save');
    Gem::post('/channel/{id}/update', 'User\Channels@update')->name('channel.update');
    Gem::get('/channel/{id}/delete/{token}', 'User\Channels@delete')->name('channel.delete');
    Gem::post('/channel/add/{type}', 'User\Channels@addto')->name('channel.addto');
    Gem::get('/channel/{id}/remove/{type}/{item}', 'User\Channels@removefrom')->name('channel.removefrom');

    Gem::get('/affiliate', 'User\Affiliate@index')->name('user.affiliate');
    Gem::post('/affiliate/save', 'User\Affiliate@affiliateSave')->name('user.affiliate.save');
    Gem::get('/affiliate/withdrawals', 'User\Affiliate@withdrawals')->name('user.withdrawals');
    Gem::post('/affiliate/withdrawals/request', 'User\Affiliate@withdrawalRequest')->name('user.withdrawals.request');

    Gem::get('/get-verified', 'User\Verification@index')->name('user.verification');
    Gem::post('/get-verified/verify', 'User\Verification@verify')->name('user.verification.verify');

    Gem::get('/invoice/{id}','User\Account@invoice')->name('invoice');

    Gem::get('/export/links', 'User\Export@links')->name('user.export.links');
    Gem::post('/export/statistics', 'User\Export@stats')->name('user.stats.export');
    Gem::get('/export/statistics/{id}', 'User\Export@single')->name('links.stats.export');
    Gem::post('/export/campaigns/{id}', 'User\Export@campaign')->name('campaigns.export');
    
    Gem::get('/import/links', 'User\Import@links')->name('import.links');
    Gem::post('/import/links/upload', 'User\Import@importLinks')->name('import.links.upload');
    Gem::get('/import/{id}/cancel/{token}', 'User\Import@cancel')->name('import.cancel');

});

Gem::group(appConfig('app.adminroute'), function(){

    // Protect all routes with Admin Auth Middleware
    Gem::setMiddleware(['Auth@admin', 'Locale@admin']);

    Gem::get('/', 'Admin\Dashboard@index')->name('admin');

    Gem::post('/verify', 'Admin\Settings@verify')->name('admin.verify');

    Gem::get('/statistics', 'Admin\Stats@index')->name('admin.stats');
    Gem::get('/statistics/links', 'Admin\Stats@statsLinks')->name('admin.stats.links');
    Gem::get('/statistics/users', 'Admin\Stats@statsUsers')->name('admin.stats.users');
    Gem::get('/statistics/clicks', 'Admin\Stats@statsClicks')->name('admin.stats.clicks');
    Gem::get('/statistics/map', 'Admin\Stats@clicksMap')->name('admin.stats.map');
    Gem::get('/statistics/memberships', 'Admin\Stats@memberships')->name('admin.stats.membership');
    Gem::get('/statistics/subscriptions', 'Admin\Stats@subscriptions')->name('admin.stats.subscriptions');
    Gem::get('/statistics/payments', 'Admin\Stats@payments')->name('admin.stats.payments');

    Gem::get('/search', 'Admin\Dashboard@search')->name('admin.search');
    // Plans
    Gem::get('/plans', 'Admin\Plans@index')->name('admin.plans');
    Gem::get('/plans/new', 'Admin\Plans@new')->name('admin.plans.new');
    Gem::post('/plans/save', 'Admin\Plans@save')->name('admin.plans.save');
    Gem::get('/plans/{id}/delete/{nonce}', 'Admin\Plans@delete')->name('admin.plans.delete');
    Gem::get('/plans/{id}/edit', 'Admin\Plans@edit')->name('admin.plans.edit');
    Gem::post('/plans/{id}/update', 'Admin\Plans@update')->name('admin.plans.update');
    Gem::get('/plans/sync', 'Admin\Plans@sync')->name('admin.plans.sync');
    Gem::get('/plans/{id}/toggle', 'Admin\Plans@toggle')->name('admin.plans.toggle');
    Gem::get('/subscriptions', 'Admin\Membership@subscriptions')->name('admin.subscriptions');
    Gem::get('/subscription/{id}/{markas}', 'Admin\Membership@subscriptionMarkas')->name('admin.subscription.markas');
    Gem::get('/payments', 'Admin\Membership@payments')->name('admin.payments');
    Gem::get('/payments/{id}/invoice','Admin\Membership@invoice')->name('admin.invoice');
    Gem::get('/payments/{id}/delete/{nonce}','Admin\Membership@delete')->name('admin.payments.delete');
    Gem::get('/payments/{id}/{action}','Admin\Membership@markAs')->name('admin.payments.markas');
    Gem::get('/finance', 'Admin\Finance@index')->name('admin.finance');

    // Coupons
    Gem::get('/coupons', 'Admin\Coupons@index')->name('admin.coupons');
    Gem::get('/coupons/new', 'Admin\Coupons@new')->name('admin.coupons.new');
    Gem::post('/coupons/save', 'Admin\Coupons@save')->name('admin.coupons.save');
    Gem::get('/coupons/{id}/delete/{nonce}', 'Admin\Coupons@delete')->name('admin.coupons.delete');
    Gem::get('/coupons/{id}/edit', 'Admin\Coupons@edit')->name('admin.coupons.edit');
    Gem::post('/coupons/{id}/update', 'Admin\Coupons@update')->name('admin.coupons.update');

    // Vouchers
    Gem::get('/vouchers', 'Admin\Vouchers@index')->name('admin.vouchers');
    Gem::post('/vouchers/save', 'Admin\Vouchers@save')->name('admin.vouchers.save');
    Gem::get('/vouchers/{id}/delete/{nonce}', 'Admin\Vouchers@delete')->name('admin.vouchers.delete');
    Gem::post('/vouchers/{id}/update', 'Admin\Vouchers@update')->name('admin.vouchers.update');
    Gem::post('/vouchers/save/bulk', 'Admin\Vouchers@bulk')->name('admin.vouchers.bulk');

    // Tax
    Gem::get('/tax', 'Admin\Tax@index')->name('admin.tax');
    Gem::get('/tax/new', 'Admin\Tax@new')->name('admin.tax.new');
    Gem::post('/tax/save', 'Admin\Tax@save')->name('admin.tax.save');
    Gem::get('/tax/{id}/edit', 'Admin\Tax@edit')->name('admin.tax.edit');
    Gem::post('/tax/{id}/update', 'Admin\Tax@update')->name('admin.tax.update');
    Gem::get('/tax/{id}/delete/{nonce}', 'Admin\Tax@delete')->name('admin.tax.delete');

    // Links
    Gem::get('/links', 'Admin\Links@index')->name('admin.links');
    Gem::get('/links/{id}/delete/{nonce}', 'Admin\Links@delete')->name('admin.links.delete');
    Gem::post('/links/delete/all', 'Admin\Links@deleteAll')->name('admin.links.deleteall');
    Gem::post('/links/disable/all', 'Admin\Links@disableAll')->name('admin.links.disableall');
    Gem::post('/links/enable/all', 'Admin\Links@enableAll')->name('admin.links.enableall');
    Gem::get('/links/{id}/edit', 'Admin\Links@edit')->name('admin.links.edit');
    Gem::post('/links/{id}/update', 'Admin\Links@update')->name('admin.links.update');
    Gem::get('/links/{id}/view', 'Admin\Links@view')->name('admin.links.view');
    Gem::get('/links/expired', 'Admin\Links@expired')->name('admin.links.expired');
    Gem::get('/links/archived', 'Admin\Links@archived')->name('admin.links.archived');
    Gem::get('/links/anonymous', 'Admin\Links@anonymous')->name('admin.links.anonymous');
    Gem::get('/links/pending', 'Admin\Links@pending')->name('admin.links.pending');
    Gem::get('/links/report', 'Admin\Links@report')->name('admin.links.report');
    Gem::post('/links/report/add', 'Admin\Links@reportAdd')->name('admin.links.report.add');
    Gem::post('/links/report/massdelete', 'Admin\Links@reportDeleteall')->name('admin.links.report.deleteall');
    Gem::get('/links/report/{id}/{action}', 'Admin\Links@reportAction')->name('admin.links.report.action');
    Gem::get('/links/bad', 'Admin\Links@bad')->name('admin.links.bad');
    Gem::get('/links/bad/{id}/cancel', 'Admin\Links@badCancel')->name('admin.links.bad.cancel');
    Gem::get('/links/{id}/disable', 'Admin\Links@disable')->name('admin.links.disable');
    Gem::get('/links/{id}/approve', 'Admin\Links@approve')->name('admin.links.approve');
    Gem::route(['GET', 'POST'], '/links/import', 'Admin\Links@import')->name('admin.links.import');
    // Users
    Gem::get('/users', 'Admin\Users@index')->name('admin.users');
    Gem::get('/users/new', 'Admin\Users@new')->name('admin.users.new');
    Gem::post('/users/save', 'Admin\Users@save')->name('admin.users.save');
    Gem::get('/users/inactive', 'Admin\Users@inactive')->name('admin.users.inactive');
    Gem::get('/users/banned', 'Admin\Users@banned')->name('admin.users.banned');
    Gem::get('/users/admins', 'Admin\Users@admin')->name('admin.users.admin');
    Gem::get('/users/teams', 'Admin\Users@teams')->name('admin.users.teams');
    Gem::get('/users/teams/{id}/remove/{nonce}', 'Admin\Users@removeteam')->name('admin.users.removeteam');
    Gem::get('/users/{id}/edit', 'Admin\Users@edit')->name('admin.users.edit');
    Gem::post('/users/{id}/update', 'Admin\Users@update')->name('admin.users.update');
    Gem::get('/users/{id}/delete/{nonce}', 'Admin\Users@delete')->name('admin.users.delete');
    Gem::get('/users/{id}/wipe/{nonce}', 'Admin\Users@wipe')->name('admin.users.delete.all');
    Gem::post('/user/delete/all', 'Admin\Users@deleteAll')->name('admin.users.deleteall');
    Gem::get('/users/{id}/ban', 'Admin\Users@ban')->name('admin.users.ban');
    Gem::get('/users/{id}/view', 'Admin\Users@view')->name('admin.users.view');
    Gem::post('/users/{id}/assign-role', 'Admin\Users@assignRole')->name('admin.users.assign.role');
    Gem::get('/users/{id}/remove-role', 'Admin\Users@removeRole')->name('admin.users.remove.role');
    Gem::post('/user/ban/all', 'Admin\Users@banAll')->name('admin.users.banall');
    Gem::post('/user/email/all', 'Admin\Users@emailAll')->name('admin.users.emailall');
    Gem::get('/user/{id}/verify/{token}', 'Admin\Users@verify')->name('admin.users.verify');
    Gem::get('/user/{id}/unverify/{token}', 'Admin\Users@unverify')->name('admin.users.unverify');
    Gem::get('/user/{id}/verifyemail', 'Admin\Users@verifyEmail')->name('admin.users.verifyemail');
    Gem::get('/users/testimonials', 'Admin\Users@testimonial')->name('admin.testimonial');
    Gem::post('/users/testimonial/save', 'Admin\Users@testimonialSave')->name('admin.testimonial.save');
    Gem::get('/users/testimonial/{id}/edit', 'Admin\Users@testimonialEdit')->name('admin.testimonial.edit');
    Gem::post('/users/testimonial/{id}/update', 'Admin\Users@testimonialUpdate')->name('admin.testimonial.update');
    Gem::get('/users/testimonial/{id}/delete/{nonce}', 'Admin\Users@testimonialDelete')->name('admin.testimonial.delete');
    Gem::post('/users/changeplan', 'Admin\Users@changePlan')->name('admin.users.changeplan');
    Gem::route(['GET', 'POST'], '/users/import', 'Admin\Users@import')->name('admin.users.import');

    Gem::get('/users/list', 'Admin\Users@list')->name('admin.users.list');

    Gem::get('/users/logs/logins', 'Admin\Users@logins')->name('admin.users.logins');
    Gem::get('/users/{id}/activity', 'Admin\Users@activity')->name('admin.users.activity');
    Gem::get('/users/logs/logins/clear/{nonce}', 'Admin\Users@loginsClear')->name('admin.users.loginsclear');

    Gem::get('/users/login/{id}/{nonce}', 'Admin\Users@loginAs')->name('admin.users.login');

    // Roles & Permissions
    Gem::get('/roles', 'Admin\Roles@index')->name('admin.roles');
    Gem::get('/roles/new', 'Admin\Roles@new')->name('admin.roles.new');
    Gem::post('/roles/save', 'Admin\Roles@save')->name('admin.roles.save');
    Gem::get('/roles/{id}/edit', 'Admin\Roles@edit')->name('admin.roles.edit');
    Gem::post('/roles/{id}/update', 'Admin\Roles@update')->name('admin.roles.update');
    Gem::get('/roles/{id}/delete/{nonce}', 'Admin\Roles@delete')->name('admin.roles.delete');
    Gem::post('/roles/assign', 'Admin\Roles@assign')->name('admin.roles.assign');
    Gem::post('/roles/remove', 'Admin\Roles@remove')->name('admin.roles.remove');
    Gem::get('/roles/{id}/users', 'Admin\Roles@users')->name('admin.roles.users');
    Gem::get('/roles/{id}/permissions', 'Admin\Roles@permissions')->name('admin.roles.permissions');

    Gem::get('/verifications', 'Admin\Verifications@index')->name('admin.verifications');
    Gem::get('/verifications/{id}', 'Admin\Verifications@view')->name('admin.verifications.view');
    Gem::post('/verifications/{id}/process}', 'Admin\Verifications@process')->name('admin.verifications.process');

    // Bio
    Gem::get('/bio', 'Admin\Bio@index')->name('admin.bio');
    Gem::get('/bio/toggle/{type}/{id}', 'Admin\Bio@toggle')->name('admin.bio.toggle');
    Gem::get('/bio/{id}/delete/{nonce}', 'Admin\Bio@delete')->name('admin.bio.delete');
    Gem::post('/bio/{id}/reassign', 'Admin\Bio@reassign')->name('admin.bio.reassign');
    Gem::get('/bio/themes', 'Admin\BioThemes@index')->name('admin.bio.themes');
    Gem::post('/bio/themes/save', 'Admin\BioThemes@save')->name('admin.bio.theme.save');
    Gem::get('/bio/themes/{id}/edit', 'Admin\BioThemes@edit')->name('admin.bio.theme.edit');
    Gem::post('/bio/themes/{id}/update', 'Admin\BioThemes@update')->name('admin.bio.theme.update');
    Gem::get('/bio/themes/{id}/delete/{nonce}', 'Admin\BioThemes@delete')->name('admin.bio.theme.delete');

    // QR
    Gem::get('/qr', 'Admin\Qr@index')->name('admin.qr');
    Gem::post('/qr/{id}/reassign', 'Admin\Qr@reassign')->name('admin.qr.reassign');
    Gem::get('/qr/{id}/delete/{nonce}', 'Admin\Qr@delete')->name('admin.qr.delete');
    Gem::get('/qr/templates', 'Admin\QrTemplates@index')->name('admin.qr.templates');
    Gem::post('/qr/templates/save', 'Admin\QrTemplates@save')->name('admin.qr.template.save');
    Gem::get('/qr/templates/{id}/edit', 'Admin\QrTemplates@edit')->name('admin.qr.template.edit');
    Gem::post('/qr/templates/{id}/update', 'Admin\QrTemplates@update')->name('admin.qr.template.update');
    Gem::get('/qr/templates/{id}/delete/{nonce}', 'Admin\QrTemplates@delete')->name('admin.qr.template.delete');


    //Pages
    Gem::get('/page', 'Admin\Pages@index')->name('admin.page');
    Gem::get('/page/new', 'Admin\Pages@new')->name('admin.page.new');
    Gem::post('/page/save', 'Admin\Pages@save')->name('admin.page.save');
    Gem::get('/page/{id}/edit', 'Admin\Pages@edit')->name('admin.page.edit');
    Gem::post('/page/{id}/update', 'Admin\Pages@update')->name('admin.page.update');
    Gem::get('/page/{id}/delete/{nonce}', 'Admin\Pages@delete')->name('admin.page.delete');
    // Blog
    Gem::get('/blog', 'Admin\Blog@index')->name('admin.blog');
    Gem::get('/blog/new', 'Admin\Blog@new')->name('admin.blog.new');
    Gem::post('/blog/save', 'Admin\Blog@save')->name('admin.blog.save');
    Gem::get('/blog/{id}/edit', 'Admin\Blog@edit')->name('admin.blog.edit');
    Gem::post('/blog/{id}/update', 'Admin\Blog@update')->name('admin.blog.update');
    Gem::get('/blog/{id}/delete/{nonce}', 'Admin\Blog@delete')->name('admin.blog.delete');
    Gem::get('/blog/categories', 'Admin\Blog@categories')->name('admin.blog.categories');
    Gem::post('/blog/category/save', 'Admin\Blog@categorySave')->name('admin.blog.category.save');
    Gem::get('/blog/category/{id}/edit', 'Admin\Blog@categoryEdit')->name('admin.blog.category.edit');
    Gem::post('/blog/category/{id}/update', 'Admin\Blog@categoryUpdate')->name('admin.blog.category.update');
    Gem::get('/blog/category/{id}/delete/{nonce}', 'Admin\Blog@categoryDelete')->name('admin.blog.category.delete');

    // Domains
    Gem::get('/domains', 'Admin\Domains@index')->name('admin.domains');
    Gem::get('/domains/new', 'Admin\Domains@new')->name('admin.domains.new');
    Gem::post('/domains/save', 'Admin\Domains@save')->name('admin.domains.save');
    Gem::get('/domains/{id}/edit', 'Admin\Domains@edit')->name('admin.domains.edit');
    Gem::post('/domains/{id}/update', 'Admin\Domains@update')->name('admin.domains.update');
    Gem::get('/domains/{id}/disable', 'Admin\Domains@disable')->name('admin.domains.disable');
    Gem::get('/domains/{id}/activate', 'Admin\Domains@activate')->name('admin.domains.activate');
    Gem::get('/domains/{id}/pending', 'Admin\Domains@pending')->name('admin.domains.pending');
    Gem::get('/domains/{id}/delete/{nonce}', 'Admin\Domains@delete')->name('admin.domains.delete');
    // FAQS
    Gem::get('/faq', 'Admin\Faqs@index')->name('admin.faq');
    Gem::get('/faq/new', 'Admin\Faqs@new')->name('admin.faq.new');
    Gem::post('/faq/save', 'Admin\Faqs@save')->name('admin.faq.save');
    Gem::get('/faq/{id}/edit', 'Admin\Faqs@edit')->name('admin.faq.edit');
    Gem::post('/faq/{id}/update', 'Admin\Faqs@update')->name('admin.faq.update');
    Gem::get('/faq/{id}/delete/{nonce}', 'Admin\Faqs@delete')->name('admin.faq.delete');
    Gem::get('/faq/categories', 'Admin\Faqs@categories')->name('admin.faq.categories');
    Gem::post('/faq/categories/save', 'Admin\Faqs@categoriesSave')->name('admin.faq.categories.save');
    Gem::get('/faq/categories/{id}/edit', 'Admin\Faqs@categoriesEdit')->name('admin.faq.categories.edit');
    Gem::post('/faq/categories/{id}/update', 'Admin\Faqs@categoriesUpdate')->name('admin.faq.categories.update');
    Gem::get('/faq/categories/{id}/delete/{nonce}', 'Admin\Faqs@categoriesDelete')->name('admin.faq.categories.delete');

    // Affiliates
    Gem::get('/affiliates', 'Admin\Affiliates@index')->name('admin.affiliate');
    Gem::get('/affiliates/payments', 'Admin\Affiliates@payments')->name('admin.affiliate.payments');
    Gem::get('/affiliates/payments/history', 'Admin\Affiliates@history')->name('admin.affiliate.history');
    Gem::get('/affiliates/settings', 'Admin\Affiliates@settings')->name('admin.affiliate.settings');
    Gem::get('/affiliates/{id}/delete/{nonce}', 'Admin\Affiliates@delete')->name('admin.affiliate.delete');
    Gem::get('/affiliates/{id}/pay', 'Admin\Affiliates@pay')->name('admin.affiliate.pay');
    Gem::get('/affiliates/{id}/{action}', 'Admin\Affiliates@update')->name('admin.affiliate.update');

    // Ads
    Gem::get('/ads', 'Admin\Ads@index')->name('admin.ads');
    Gem::get('/ads/new', 'Admin\Ads@new')->name('admin.ads.new');
    Gem::post('/ads/save', 'Admin\Ads@save')->name('admin.ads.save');
    Gem::get('/ads/{id}/edit', 'Admin\Ads@edit')->name('admin.ads.edit');
    Gem::post('/ads/{id}/update', 'Admin\Ads@update')->name('admin.ads.update');
    Gem::get('/ads/{id}/delete/{nonce}', 'Admin\Ads@delete')->name('admin.ads.delete');
    // Themes
    Gem::get('/themes', 'Admin\Themes@index')->name('admin.themes');
    Gem::get('/themes/settings', 'Admin\Themes@settings')->name('admin.themes.settings');
    Gem::get('/themes/editor', 'Admin\Themes@editor')->name('admin.themes.editor');
    Gem::post('/themes/update', 'Admin\Themes@update')->name('admin.themes.editor.update');
    Gem::post('/themes/upload', 'Admin\Themes@upload')->name('admin.themes.upload');
    Gem::get('/themes/custom', 'Admin\Themes@custom')->name('admin.themes.custom');
    Gem::post('/themes/custom/update', 'Admin\Themes@customUpdate')->name('admin.themes.custom.update');
    Gem::get('/themes/{id}/activate', 'Admin\Themes@activate')->name('admin.themes.activate');
    Gem::get('/themes/{id}/delete/{nonce}', 'Admin\Themes@delete')->name('admin.themes.delete');
    Gem::get('/themes/{id}/clone/{nonce}', 'Admin\Themes@clone')->name('admin.themes.clone');
    Gem::get('/themes/menu', 'Admin\Themes@menu')->name('admin.themes.menu');
    Gem::post('/themes/menu/update', 'Admin\Themes@menuUpdate')->name('admin.themes.menu.update');

    Gem::get('/plugins', 'Admin\Plugins@index')->name('admin.plugins');
    Gem::get('/plugins/{id}/activate', 'Admin\Plugins@activate')->name('admin.plugins.activate');
    Gem::get('/plugins/{id}/disable', 'Admin\Plugins@disable')->name('admin.plugins.disable');
    Gem::get('/plugins/{id}/delete/{token}', 'Admin\Plugins@delete')->name('admin.plugins.delete');
    Gem::post('/plugins/upload', 'Admin\Plugins@upload')->name('admin.plugins.upload');
    Gem::get('/marketplace', 'Admin\Plugins@directory')->name('admin.plugins.dir');
    Gem::get('/marketplace/{tag}', 'Admin\Plugins@single')->name('admin.plugins.single');

    // Settings
    Gem::get('/settings', 'Admin\Settings@index')->name('admin.settings');
    Gem::get('/settings/checklist', 'Admin\Settings@checklist')->name('admin.settings.checklist');
    Gem::post('/settings/save', 'Admin\Settings@store')->name('admin.settings.save');
    Gem::get('/settings/cdnsync/{token}', 'Admin\Settings@cdnsync')->name('admin.settings.cdnsync');
    Gem::get('/settings/{config}', 'Admin\Settings@config')->name('admin.settings.config');

    Gem::get('/oauth', 'Admin\OAuth@index')->name('admin.oauth');
    Gem::get('/oauth/{id}/list', 'Admin\OAuth@list')->name('admin.oauth.list');
    Gem::route(['GET', 'POST'], '/oauth/create', 'Admin\OAuth@create')->name('admin.oauth.create');
    Gem::get('/oauth/{id}/delete/{nonce}', 'Admin\OAuth@delete')->name('admin.oauth.delete');
    Gem::get('/oauth/token/{id}/delete', 'Admin\OAuth@deleteToken')->name('admin.oauth.token.delete');

    // Languages
    Gem::get('/languages', 'Admin\Languages@index')->name('admin.languages');
    Gem::get('/languages/new', 'Admin\Languages@new')->name('admin.languages.new');
    Gem::post('/languages/save', 'Admin\Languages@save')->name('admin.languages.save');
    Gem::post('/languages/upload', 'Admin\Languages@upload')->name('admin.languages.upload');
    Gem::get('/languages/{id}/delete/{nonce}', 'Admin\Languages@delete')->name('admin.languages.delete');
    Gem::get('/languages/{id}/set', 'Admin\Languages@set')->name('admin.languages.set');
    Gem::get('/languages/{id}/edit', 'Admin\Languages@edit')->name('admin.languages.edit');
    Gem::post('/languages/{id}/update', 'Admin\Languages@update')->name('admin.languages.update');
    Gem::post('/languages/translate', 'Admin\Languages@translate')->name('admin.translate');
    Gem::get('/languages/{id}/sync', 'Admin\Languages@sync')->name('admin.languages.sync');
    Gem::get('/languages/{id}/auto', 'Admin\Languages@automatic')->name('admin.languages.auto');

    //Tools
    Gem::get('/tools', 'Admin\Tools@index')->name('admin.tools');
    Gem::get('/tools/{action}/{nonce}', 'Admin\Tools@action')->name('admin.toolsAction');
    Gem::get('/tools/data', 'Admin\Tools@data')->name('admin.data');
    Gem::post('/tools/data/backup', 'Admin\Tools@backup')->name('admin.backup');
    Gem::post('/tools/data/restore', 'Admin\Tools@restore')->name('admin.restore');

    Gem::get('/email', 'Admin\EmailManager@index')->name('admin.email');
    Gem::post('/email/send', 'Admin\EmailManager@emailSend')->name('admin.email.send');
    Gem::get('/email/templates', 'Admin\EmailManager@templates')->name('admin.email.template');
    Gem::get('/email/templates/new', 'Admin\EmailManager@new')->name('admin.email.template.new');
    Gem::post('/email/templates/save', 'Admin\EmailManager@save')->name('admin.email.template.save');
    Gem::get('/email/templates/{id}/delete/{nonce}', 'Admin\EmailManager@delete')->name('admin.email.template.delete');
    Gem::get('/email/templates/{id}/edit', 'Admin\EmailManager@edit')->name('admin.email.template.edit');
    Gem::post('/email/templates/{id}/update', 'Admin\EmailManager@update')->name('admin.email.template.update');

    Gem::get('/notifications', 'Admin\Notifications@index')->name('admin.notifications');
    Gem::get('/notifications/new', 'Admin\Notifications@new')->name('admin.notifications.new');
    Gem::post('/notifications/save', 'Admin\Notifications@save')->name('admin.notifications.save');
    Gem::get('/notifications/{id}/delete/{nonce}', 'Admin\Notifications@delete')->name('admin.notifications.delete');

    Gem::route(['GET', 'POST'], '/update', 'Admin\Dashboard@update')->name('admin.update');
    Gem::post('/update/process', 'Admin\Dashboard@updateProcess')->name('admin.update.process');

    Gem::get('/crons', 'Admin\Dashboard@crons')->name('admin.crons');
    Gem::get('/crons/clear', 'Admin\Dashboard@cronsClear')->name('admin.crons.clear');
    Gem::get('/phpinfo', 'Admin\Dashboard@phpinfo')->name('admin.phpinfo');

    Gem::get('/affiliates/withdrawals', 'Admin\Affiliates@withdrawals')->name('admin.affiliate.withdrawals');
    Gem::post('/affiliates/withdrawals/{id}/{action}', 'Admin\Affiliates@withdrawalAction')->name('admin.affiliate.withdrawals.action');
});

// API
Gem::group(appConfig('app.apiroute'), function(){

    Gem::post('/oauth/token', 'API\OAuth@token')->name('api.oauth.token');

    Gem::setMiddleware(['Auth@api', 'Throttle', 'CheckDomain']);

    Gem::get('/', 'API\Index@index');

    // Account
    Gem::get('/account', 'API\Account@get')->name("api.account.get");
    Gem::put('/account/update', 'API\Account@update')->name("api.account.update");

    // Links
    Gem::get('/urls', 'API\Links@get')->name("api.url.get");
    Gem::post('/url/add', 'API\Links@create')->name("api.url.create");
    Gem::put('/url/{id}/update', 'API\Links@update')->name("api.url.update");
    Gem::delete('/url/{id}/delete', 'API\Links@delete')->name("api.url.delete");
    Gem::get('/url/{id}', 'API\Links@single')->name("api.url.single");

    // QR Codes
    Gem::get('/qr', 'API\QR@get')->name("api.qr.get");
    Gem::post('/qr/add', 'API\QR@create')->name("api.qr.create");
    Gem::put('/qr/{id}/update', 'API\QR@update')->name("api.qr.update");
    Gem::delete('/qr/{id}/delete', 'API\QR@delete')->name("api.qr.delete");
    Gem::get('/qr/{id}', 'API\QR@single')->name("api.qr.single");

    Gem::get('/domains', 'API\Domains@get')->name("api.domain.get");
    Gem::post('/domain/add', 'API\Domains@create')->name("api.domain.create");
    Gem::put('/domain/{id}/update', 'API\Domains@update')->name("api.domain.update");
    Gem::delete('/domain/{id}/delete', 'API\Domains@delete')->name("api.domain.delete");

    Gem::get('/campaigns', 'API\Campaigns@get')->name("api.campaign.get");
    Gem::post('/campaign/add', 'API\Campaigns@create')->name("api.campaign.create");
    Gem::put('/campaign/{id}/update', 'API\Campaigns@update')->name("api.campaign.update");
    Gem::post('/campaign/{id}/assign/{link}', 'API\Campaigns@assign')->name("api.campaign.assign");
    Gem::delete('/campaign/{id}/delete', 'API\Campaigns@delete')->name("api.campaign.delete");

    Gem::get('/channels', 'API\Channels@get')->name("api.channel.get");
    Gem::get('/channel/{id}', 'API\Channels@single')->name("api.channel.single");
    Gem::post('/channel/add', 'API\Channels@create')->name("api.channel.create");
    Gem::put('/channel/{id}/update', 'API\Channels@update')->name("api.channel.update");
    Gem::post('/channel/{id}/assign/{type}/{link}', 'API\Channels@assign')->name("api.channel.assign");
    Gem::delete('/channel/{id}/delete', 'API\Channels@delete')->name("api.channel.delete");

    Gem::get('/splash', 'API\Splash@get')->name("api.splash.get");
    Gem::get('/overlay', 'API\Overlay@get')->name("api.overlay.get");

    // Pixels
    Gem::get('/pixels', 'API\Pixels@get')->name("api.pixels.get");
    Gem::post('/pixel/add', 'API\Pixels@create')->name("api.pixel.create");
    Gem::put('/pixel/{id}/update', 'API\Pixels@update')->name("api.pixel.update");
    Gem::delete('/pixel/{id}/delete', 'API\Pixels@delete')->name("api.pixel.delete");

    Gem::get('/users', 'API\Users@get')->name("api.user.get");
    Gem::post('/user/add', 'API\Users@create')->name("api.user.create");
    Gem::delete('/user/{id}/delete', 'API\Users@delete')->name("api.user.delete");
    Gem::get('/user/{id}', 'API\Users@single')->name("api.user.single");
    Gem::get('/user/login/{id}', 'API\Users@login')->name("api.user.login");

    Gem::get('/plans', 'API\Plans@get')->name("api.plan.get");
    Gem::put('/plan/{id}/user/{userid}', 'API\Plans@subscribe')->name("api.plan.subscribe");
    
});

Gem::group('/crons', function(){
    Gem::get('/users/{id}', 'Cron@user')->name('crons.user');
    Gem::get('/data/{id}', 'Cron@data')->name('crons.data');
    Gem::get('/urls/{id}', 'Cron@urls')->name('crons.urls');
    Gem::get('/remind/{days}/{id}', 'Cron@remind')->name('crons.remind');
    Gem::get('/imports/{id}', 'Cron@imports')->name('crons.imports');
});

Gem::get('/q', 'Link@quick')->name('quick');

Gem::get('/fullpage', 'Link@fullpage')->name('fullpage');

Gem::get("/script.js", 'Link@scriptjs')->name('scriptjs');

Gem::get('/sitemap.xml', 'Sitemap@index')->name('sitemap');
Gem::get('/sitemap/site.xml', 'Sitemap@site')->name('sitemap.site');
Gem::get('/sitemap/links.xml', 'Sitemap@links')->name('sitemap.links');
Gem::get('/sitemap/biopages.xml', 'Sitemap@bio')->name('sitemap.bio');

Gem::route(['GET', 'POST'], '/update', 'Update@index');

Gem::post('/server/contact', 'Server@contact')->name('server.contact');
Gem::post('/server/subscribe', 'Server@subscribe')->name('server.subscribe');
Gem::post('/server/vote', 'Server@vote')->name('server.vote');
Gem::get('/server/states', '\Helpers\App@states')->middleware('CheckDomain')->name('server.states');

Gem::get('/server/deeplink', 'Server@deeplink')->middleware('Auth')->name('server.deeplink');

// Webhooks
Gem::route(['GET', 'POST'], '/ipn', 'Webhook@ipn')->middleware('CheckDomain')->name('webhook.paypal');

Gem::route(['GET', 'POST'], '/webhook[/{provider}]', 'Webhook@index')->middleware('CheckDomain')->name('webhook');

Gem::get('/callback/paddle', '\Helpers\Payments\Paddle@callback')->middleware('CheckDomain')->name('callback.paddle');
Gem::get('/callback/paystack', '\Helpers\Payments\PayStack@callback')->middleware('Auth')->name('callback.paystack');
Gem::get('/callback/mollie', '\Helpers\Payments\Mollie@callback')->middleware('Auth')->name('callback.mollie');

// QR Codes
Gem::post('/server/generateqr', 'QR@generateqr')->name('qr.generateqr');
Gem::get('/qr/{id}', 'QR@generate')->name('qr.generate');
Gem::get('/qr/{id}/download/{format}[/{size}]', 'QR@download')->name('qr.download');

// Short URL Routes
Gem::get('/r/{alias}', 'Link@campaign')->name('campaign');
Gem::get('/u/{username}/{alias}', 'Link@campaignList')->name('campaign.list');

Gem::get('/{alias}+', 'Stats@simple')->name('stats.alt');
Gem::get('/bookmark', 'Link@bookmark');
Gem::get($prefix.'/{id}/stats', 'Stats@index')->middleware('CheckDomain')->name('stats');

Gem::get($prefix.'/{id}/stats/activity', 'Stats@activity')->middleware('CheckDomain')->name('stats.activity');

Gem::get($prefix.'/{id}/stats/clicks', 'Stats@clicks')->middleware('CheckDomain')->name('stats.clicks');
Gem::get($prefix.'/{id}/data/clicks', 'Stats@dataClicks')->middleware('CheckDomain')->name('data.clicks');

Gem::get($prefix.'/{id}/stats/countries', 'Stats@countries')->middleware('CheckDomain')->name('stats.countries');
Gem::get($prefix.'/{id}/data/countries', 'Stats@dataCountries')->middleware('CheckDomain')->name('data.countries');
Gem::get($prefix.'/{id}/data/cities', 'Stats@dataCities')->middleware('CheckDomain')->name('data.cities');

Gem::get($prefix.'/{id}/stats/platforms', 'Stats@platforms')->middleware('CheckDomain')->name('stats.platforms');
Gem::get($prefix.'/{id}/data/platforms', 'Stats@dataPlatforms')->middleware('CheckDomain')->name('data.platforms');

Gem::get($prefix.'/{id}/stats/browsers', 'Stats@browsers')->middleware('CheckDomain')->name('stats.browsers');
Gem::get($prefix.'/{id}/data/browsers', 'Stats@dataBrowsers')->middleware('CheckDomain')->name('data.browsers');

Gem::get($prefix.'/{id}/stats/languages', 'Stats@languages')->middleware('CheckDomain')->name('stats.languages');
Gem::get($prefix.'/{id}/data/languages', 'Stats@dataLanguages')->middleware('CheckDomain')->name('data.languages');

Gem::get($prefix.'/{id}/stats/referrers', 'Stats@referrers')->middleware('CheckDomain')->name('stats.referrers');
Gem::get($prefix.'/{id}/data/referrers', 'Stats@dataReferrers')->middleware('CheckDomain')->name('data.referrers');

Gem::get($prefix.'/{id}/stats/abtesting', 'Stats@abtesting')->middleware('CheckDomain')->name('stats.abtesting');

Gem::get('/{id}/i', 'Link@image')->name('link.image');
Gem::get('/{id}/ico', 'Link@icon')->name('link.ico');
Gem::get('/{id}/qr[/{size}]', 'Link@qr')->name('link.qr');
Gem::get('/{id}/qr/download/{format}[/{size}]', 'Link@qrDownload')->name('link.qrDownload');

Gem::route(['GET', 'POST'], '/{alias}', 'Link@redirect')->name('redirect');

Gem::get('/captcha/challenge', '\Helpers\Captcha@altchaChallenge')->middleware('BlockBot')->name('captcha.challenge');

// Gem::get('/compile/1a589a9d55e6fff984', function(){
//     \Core\View::compile([
//          "frontend/libs/jquery/dist/jquery.min.js",
//          "frontend/libs/bootstrap/dist/js/bootstrap.bundle.min.js",
//          "frontend/libs/bootstrap-notify/bootstrap-notify.min.js",
//          "frontend/libs/svg-injector/dist/svg-injector.min.js",
//          "frontend/libs/feather-icons/dist/feather.min.js",
//          "frontend/libs/select2/dist/js/select2.min.js",
//     ], 'bundle.pack.js');
// });