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

namespace Traits;

use Core\DB;
use Core\Http;
use Core\Auth;
use Core\Helper;
use Core\Response;
use Core\Request;
use Helpers\App;

trait Links {

    /**
     * Get URL
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @param string $alias
     * @return object
     */
    public function getURL(Request $request, $alias){

        $alias = str_replace('&amp;', '&', $alias);

        $host = urldecode($request->uri(false));

        $current = trim(implode($alias, explode($alias, $host, -1)), '/');

        $current = str_replace(["http://", "https://"], "", $current);

		$current = idn_to_utf8($current);

		if("http://".$current == config("url") || "https://".$current == config("url")){
			$url = DB::url()->whereRaw("(alias = BINARY :id OR custom = BINARY :id) AND ((domain = :domain1 OR domain = :domain2) OR domain IS NULL OR domain = '')", [':id' => $alias, ':domain1' => 'http://'.$current, ':domain2' => 'https://'.$current])->first();
		}else{
			$url = DB::url()->whereRaw("(alias = BINARY :id OR custom = BINARY :id) AND (domain = :domain1 OR domain = :domain2)", [':id' => $alias, ':domain1' => 'http://'.$current, ':domain2' => 'https://'.$current])->first();
		}
        return $url;
    }
    /**
     * Shorten Link
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.4.1
     * @param object $request
     * @param object $user
     * @param boolean $output Return alias quickly and then process other checks
     * @return void
     */
    public function createLink($request, $user = null, $output = false){

        // Validate URL
		$url = $this->validate(Helper::clean($request->url, 3));

        if(config('require_registration') && !$user) throw new \Exception(e('Please create a free account or login to shorten links.')."<script>document.location='".route('register')."';</script>");

        if($user){
            if((!$user->pro() && is_null($user->planid)) || $user->plan('numurls') === false) throw new \Exception(e('You cannot shorten URLs at the moment. Please upgrade to another plan.')."<script>document.location='".route('pricing')."';</script>");

            if($user->plan('numurls') && $user->plan('numurls') > 0){
                if($user->plan('counttype') == 'monthly'){

                    $firstday = date('Y-m-01');

                    $lastday = date('Y-m-t');

                    $count = DB::url()->whereRaw("(date BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

                    if($count >= $user->plan('numurls')) throw new \Exception(e('You have reached your monthly limit. Please upgrade to another plan.'));

                } else {
                    if(DB::url()->where('userid', $user->rID())->count() >= $user->plan('numurls')) throw new \Exception(e('You have reached your maximum links limit. Please upgrade to another plan.'));
                }
            }
        }

		// Check if private
		if(config('private') && !$user) throw new \Exception(e('This service is meant to be used internally only.'));

        // Validate Request
		if(empty($url) || !$url) throw new \Exception(e('Please enter a valid URL.'));

		// Prevent self-shortening;
		if(appConfig('app.self_shortening') == false && $this->isSelf($url)) throw new \Exception(e('You cannot shorten URLs of this website.'));

		// Check domain is blacklisted
		if($this->domainBlacklisted($url)) throw new \Exception(e('This domain name or link has been blacklisted.'));

		// Match the domain to the list of keywords
		if($this->wordBlacklisted($url)) throw new \Exception(e('This URL contains blacklisted keywords.'));

		// Checks URL with Google
		if(!$this->safe($url)) throw new \Exception(e('URL is suspected to contain malware and other harmful content.'));

		// Checks URL with Phishtank
		if($this->phish($url)) throw new \Exception(e('URL is suspected to contain malware and other harmful content.'));

        // Check Virus Total
		if($this->virus($url)) throw new \Exception(e('URL is suspected to contain malware and other harmful content.'));

		// Check if URL is linked to .exe, .dll, .bin, .dat, .osx,
		if(config('adult') && in_array(Helper::extension($url), appConfig('app.executables'))) throw new \Exception(e('Linking to executable files is not allowed.'));

		// Check expiration
		if($request->expiry && strtotime("now") > strtotime($request->expiry)) throw new \Exception(e('The expiry date must be later than today.'));

        // @group Plugin
        \Core\Plugin::dispatch('link.shorten.verify', $request);

		// Validate selected domain name
		if($request->domain && !$this->validateDomainNames(trim($request->domain), $user, false)){
			$request->domain = config("url");
		}

		if(!$request->domain && config("root_domain")) {
			$request->domain = config("url");
		}

		if((!$request->domain || $request->domain == config('url')) && !config("root_domain")) {
            if(!$user || !$user->admin){
                $mdomains = explode("\n", config("domain_names"));
                $mdomains = array_map("rtrim", $mdomains);
                if(!empty($mdomains[0])){				
                    $request->domain = trim($mdomains[0]);
                }else{
                    $request->domain = config("url");
                }
			}
		}

		// Check custom alias
		if($request->custom && (!config('pro') || (config('pro') && $user && $user->has('alias')))){
            if(strlen($request->custom) < 3){
                throw new \Exception(e('Custom alias must be at least 3 characters.'));

            }elseif($this->wordBlacklisted($request->custom)){
                throw new \Exception(e('Inappropriate aliases are not allowed.'));

            }elseif(($request->domain == config('url') || !$request->domain) && DB::url()->where('custom', $this->slug($request->custom))->whereRaw("(domain = '' OR domain IS NULL)")->first()){
                throw new \Exception(e('That alias is taken. Please choose another one.'));

            }elseif(DB::url()->where('custom', $this->slug($request->custom))->where('domain', $request->domain)->first()){
                throw new \Exception(e('That alias is taken. Please choose another one.'));

            }elseif(DB::url()->where('alias', $this->slug($request->custom))->whereRaw('(domain = ? OR domain = ?)', [$request->domain, ''])->first()){
                throw new \Exception(e('That alias is taken. Please choose another one.'));

            }elseif($this->aliasReserved($request->custom)){
                throw new \Exception(e('That alias is reserved. Please choose another one.'));

            }elseif($user && !$user->pro() && $this->aliasPremium($request->custom)){
                throw new \Exception(e('That is a premium alias and is reserved to only pro members.'));
            }
        }

        // Generate formatted list of countries
        $countries = null;
		if($request->location && $user && $user->has('geo') && $request->location[0] && $request->target[0]){
			foreach ($request->location as $i => $country) {
				if(!empty($country) && $request->target[$i]){

                    if(
                        !$this->validate($request->target[$i]) ||
                        !$this->safe($request->target[$i]) ||
                        $this->phish($request->target[$i]) ||
                        $this->virus($request->target[$i]) ||
                        $this->domainBlacklisted($request->target[$i]) ||
                        $this->wordBlacklisted($request->target[$i])
                    ) continue;
                    if($request->state && $request->state[$i]){
                        $countries[strtolower(clean($country))][Helper::slug($request->state[$i])] = Helper::clean($request->target[$i], 3);
                    } else {
                        $countries[strtolower(clean($country))]['all'] = Helper::clean($request->target[$i], 3);
                    }
                }
			}
			$countries = $countries ? json_encode($countries) : $countries;
		}
        
        // Generate formatted list of devices
        $devices = null;

		if($request->device && $user && $user->has('device') && $request->device[0] && $request->dtarget[0]){
			foreach ($request->device as $i => $device) {
				if(!empty($device) && $request->dtarget[$i]){
                    if(
                        !$this->safe($request->dtarget[$i]) ||
                        $this->phish($request->dtarget[$i]) ||
                        $this->virus($request->dtarget[$i]) ||
                        $this->domainBlacklisted($request->dtarget[$i]) ||
                        $this->wordBlacklisted($request->dtarget[$i])
                    ) continue;
					$devices[strtolower(clean($device))] = Helper::clean($request->dtarget[$i], 3);
                }
			}
			$devices = $devices ? json_encode($devices) : $devices;
		}

        // Formatted list of languages
        $options = [];
        $languages = [];

		if($request->language && $user && $user->has('language') && $request->language[0] && $request->ltarget[0]){
			foreach ($request->language as $i => $language) {
				if(!empty($language) && $request->ltarget[$i]){

                    if(
                        !$this->validate($request->ltarget[$i]) ||
                        !$this->safe($request->ltarget[$i]) ||
                        $this->phish($request->ltarget[$i]) ||
                        $this->virus($request->ltarget[$i]) ||
                        $this->domainBlacklisted($request->ltarget[$i]) ||
                        $this->wordBlacklisted($request->ltarget[$i])
                    ) continue;
					$languages[strtolower(clean($language))] = Helper::clean($request->ltarget[$i], 3);
                }
			}
			if(!empty($languages) && count($languages) > 0){
                $options['languages'] = $languages;
            }
		}

        $rotators = [];
        $totalpercent = 0;
        if($request->abtesting && $user && $user->has('abtesting')){

            $rotatorcount = count(array_filter($request->abtesting));

			foreach ($request->abtesting as $i => $abtesting) {

				if(!empty($abtesting)){
                    if(
                        !$this->validate($abtesting) ||
                        !$this->safe($abtesting) ||
                        $this->phish($abtesting) ||
                        $this->virus($abtesting) ||
                        $this->domainBlacklisted($abtesting) ||
                        $this->wordBlacklisted($abtesting)
                    ) continue;
                    $percent = is_numeric($request->abtestingpercent[$i]) ? round($request->abtestingpercent[$i], 0) : round(100/$rotatorcount, 0);
                    $totalpercent += $percent;

                    if($totalpercent > 100) throw new \Exception(e('The total percentage is more than 100. Please re-adjust percentages.'));

					$rotators[] = ['percent' => $percent, 'link' => Helper::clean($abtesting, 3), 'count' => 0];
                }
			}

			if(!empty($rotators) && count($rotators) > 0){
                $options['rotators'] = $rotators;
            }
		}

        if($request->clicklimit && is_numeric($request->clicklimit) && $user && $user->has('clicklimit')){
            $options['clicklimit'] = clean($request->clicklimit);
        }

        if($request->expirationredirect && $user && $user->has('expiration')){

            if(!Helper::isURL($request->expirationredirect)) throw new \Exception(e('Please enter a valid url for the expiration redirect.'));

            $options['expirationredirect'] = Helper::clean($request->expirationredirect, 3);
        }

        // Generate formatted list of parameters
        $parameters = null;

		if($request->paramname && $user && $user->has('parameters')){
			foreach ($request->paramname as $i => $param) {
				if(!empty($param) && $request->paramvalue[$i]){
					$parameters[clean($param)] = clean($request->paramvalue[$i]);
                }
			}
			$parameters = $parameters ? json_encode($parameters) : $parameters;
		}

        $pixels = $request->pixels && $user && $user->has('pixels') ? clean(implode(",", $request->pixels)) : null;

        if($user && $user->has('deeplink') && $request->deeplink && $request->deeplink['enabled']){
            $options['deeplink']['enabled'] = true;
            $options['deeplink']['google'] = clean($request->deeplink['google']);
            $options['deeplink']['apple'] = clean($request->deeplink['apple']);
        }

        // @group Plugin
        \Core\Plugin::dispatch('link.shorten.pre', $request);

        $methods = array("0" => "direct", "1" => "frame", "2" => "splash", "3" =>  "splash");

        // If logged and URL is already shortened, retrieve it
        if($user){
            // Check if duplicate urls are enabled
            if(appConfig('app.duplicateurls') === false){
                $query = DB::url()
                        ->where('url', $url)
                        ->where('userid', $user->rID())
                        ->where('domain', $request->domain);

                if($request->custom){
                    $query->where('custom', $request->custom);
                }

                if($countries){
                    $query->where('location', $countries);
                } else {
                    $query->whereRaw("(location = '' OR location IS NULL)");
                }
                if($devices){
                    $query->where('devices', $devices);
                } else {
                    $query->whereRaw("(devices = '' OR devices IS NULL)");
                }
                if($options){
                    $query->where('options', json_encode($options));
                }else{
                    $query->whereRaw("(options = '' OR options = '[]' OR options IS NULL)");
                }

                if($pixels){
                    $query->where('pixels', $pixels);
                } else {
                    $query->whereRaw("(pixels = '' OR pixels IS NULL)");
                }

                if($parameters){
                    $query->where('parameters', $parameters);
                }

                if($request->pass){
                    $query->where('pass', $request->pass);
                } else {
                    $query->whereRaw("(pass = '' OR pass IS NULL)");
                }

                if($request->type) $query->where('type', clean($request->type));

                if($link = $query->first()){
                    if($output){
                        return (new Response(['error' => false,  'message' => e('Link has been shortened').(config('captcha') && !$user ? '<script>recaptcha()</script>' : ''), 'data' => ['id' => $link->id, 'shorturl' => App::shortRoute($link->domain, $link->custom.$link->alias)]]))->json();
                    } else {
                        return ['id' => $link->id, 'shorturl' => App::shortRoute($link->domain, $link->custom.$link->alias)];
                    }
                }
            }

        } else {
            $link = DB::url()
                    ->where('url', $url)
                    ->where('userid', 0)
                    ->first();

            if($link){
                if($output){
                    $result = ['id' => $link->id, 'shorturl' => App::shortRoute($link->domain, $link->custom.$link->alias)];
                    $this->addHistory($result);
                    (new Response(['error' => false,  'message' => e('Link has been shortened').(config('captcha') && !$user ? '<script>recaptcha()</script>' : ''), 'data' => $result]))->json();
                    exit;
                } else {
                    $result = ['id' => $link->id, 'shorturl' => App::shortRoute($link->domain, $link->custom.$link->alias)];
                    $this->addHistory($result);
                    return $result;
                }
            }
        }

        if($image = $request->metaimage){
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) throw new \Exception(e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) throw new \Exception(e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            $filename = Helper::rand(6)."_".str_replace(['#', ' '], '-', $image->name);

            request()->move($image, appConfig('app.storage')['images']['path'], $filename);
        }

        if($request->custommetaimage){
            $filename = $request->custommetaimage;
        }

		if($request->type && ($request->type == "frame" || preg_match("!overlay-!", $request->type))){
			if(App::iframePolicy($url)){
				throw new \Exception(e('This URL cannot be used with this redirect method because browsers will prevent it for security reasons.'));
			}
		}

        $link = DB::url()->create();

		if($request->custom && (!config('pro') || (config('pro') && $user && $user->has('alias')))){
			$link->custom = $this->slug(clean($request->custom));
		}else{
			$link->alias = $this->alias();
		}

        if($output){
			(new Response(['error' => false,  'message' => e('Link has been shortened').(config('captcha') && !$user ? '<script>recaptcha()</script>' : ''), 'data' => ['id' => null, 'shorturl' => App::shortRoute($request->domain, $link->custom.$link->alias)]]))->json();
		}

		$protocol = explode("://", $url, 2)[0];
		$schemes = explode(",", config("schemes"));

		$schemes = array_diff($schemes, ["http", "https", "ftp"]);

		$preg_schemes = implode("://|", $schemes);

        if($request->metatitle || $request->metadescription){
            $link->meta_title = clean($request->metatitle);
            $link->meta_description = clean($request->metadescription);

        }elseif(in_array(Helper::extension($url), array(".zip",".rar",".7z",".flv",".mp4",".avi",".mp3",".jpeg",".png",".jpg",".gif",".mk4",".iso"))){
			$link->meta_title = "This is a downloadable file.";
			$link->meta_description = "Please note that this short URL is linked to a downloadable file.";

		}elseif($preg_schemes && preg_match('~('.$preg_schemes.'://)(.*)~', $url)){
			$link->meta_title = "";
			$link->meta_description = "This url is using a custom protocol: {$protocol}";

		}else{
			$info = App::metaData($url, true);

			if(!empty($info)){
				$link->meta_title = Helper::truncate(clean($info['title'],3,true), 191);
				$link->meta_description = clean($info['description'],3,true);
			}
		}
        $link->meta_image = isset($filename) ? $filename : null;
        $link->url = $url;
        $link->description = $request->description ? clean($request->description) : null;
        $link->location = $countries;
        $link->devices = $devices;
        $link->date = Helper::dtime();
        $link->pass = $request->pass ? clean($request->pass) : null;
        $link->userid = $user ? $user->rID() : 0;
        $link->domain = $request->domain ? trim($request->domain) : null;
        $link->pixels = $pixels;
        $link->parameters = $parameters;
        $link->options = json_encode($options);
        $link->expiry = $request->expiry && strtotime("now") < strtotime($request->expiry) && $user->has('expiration') ? date("Y-m-d H:i:s", strtotime($request->expiry)) : null;

        if($request->bundle && $user && $bundle = DB::bundle()->where('userid', $user->rID())->where('id', $request->bundle)->first()){
            $link->bundle = $bundle->id;
        }else{
            $link->bundle = null;
        }

        if($request->status){
            $link->public = $request->status == 'public' ? 1 : 0;
        }else{
            $link->public = $user ? 0 : 1;
        }

        if(config("manualapproval")) {

            if(!$user || ($user && $user->verified == '0')){
                \Helpers\Emails::approveURL($link);
                $link->status = "0";
            }
        }

        if(!$request->type && !config('pro')) $link->type = $methods[config('frame')];
        
        if($request->type && !$user->pro()) $link->type = $methods[config('frame')];

        if((config("frame") == "3" || ($user && $user->pro())) && $request->type && in_array($request->type, array("direct","frame","splash"))) {
			$link->type = clean($request->type);
		}
		if($user && $user->has('splash') !== false && $request->type && is_numeric($request->type)){
			$link->type = $request->type;
		}
		if($user && $user->has('overlay') !== false && $request->type && preg_match("~overlay-(.*)~", $request->type)){
			$link->type = $request->type;
		}

        if($link->save()){

            if($request->channel && $request->channel > 0){
                if($channel = DB::channels()->where('id', clean($request->channel))->where('userid', $link->userid)->first()){
                    $tochannel = DB::tochannels()->create();

                    $tochannel->userid = user()->rID();
                    $tochannel->channelid = clean($request->channel);
                    $tochannel->itemid = $link->id;
                    $tochannel->type = 'links';
                    $tochannel->save();
                }
            }

            // @group Plugin
            \Core\Plugin::dispatch('link.shorten.final', $link);

			if($user && !empty($user->zapurl) && Helper::isURL($user->zapurl)){
				\Core\Http::url($user->zapurl)
                        ->with('content-type', 'application/json')
                        ->body([
								"type" 		=> "url",
								"longurl" 	=> $link->url,
								"shorturl" 	=> App::shortRoute($link->domain, $link->alias.$link->custom),
								"date" 		=> date("d-m-Y H:i:s")
                        ])->post();
			}
        }


        $result = ['id' => $link->id, 'shorturl' => App::shortRoute($link->domain, $link->custom.$link->alias)];

        $this->addHistory($result);

        if($output) return null;

        return $result;
    }
    /**
     * Update Link
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.4.1
     * @param [type] $request
     * @param [type] $link
     * @param [type] $user
     * @return void
     */
    public function updateLink($request, $link, $user = null){

        // Validate URL
		$url = $this->validate(Helper::clean($request->url, 3));

        // Validate Request
		if(empty($url) || !$url) throw new \Exception(e('Please enter a valid URL.'));

		// Prevent self-shortening;
		if(appConfig('app.self_shortening') == false && $this->isSelf($url)) throw new \Exception(e('You cannot shorten URLs of this website.'));

		// Check domain is blacklisted
		if($this->domainBlacklisted($url)) throw new \Exception(e('This domain name or link has been blacklisted.'));

		// Match the domain to the list of keywords
		if($this->wordBlacklisted($url)) throw new \Exception(e('This URL contains blacklisted keywords.'));

		// Checks URL with Google
		if(!$this->safe($url)) throw new \Exception(e('URL is suspected to contain malware and other harmful content.'));

		// Checks URL with Phishtank
		if($this->phish($url)) throw new \Exception(e('URL is suspected to contain malware and other harmful content.'));

        // Check with Virus Total
        if($this->virus($url)) throw new \Exception(e('URL is suspected to contain malware and other harmful content.'));

		// Check if URL is linked to .exe, .dll, .bin, .dat, .osx,
		if(config('adult') && in_array(Helper::extension($url), appConfig('app.executables'))) throw new \Exception(e('Linking to executable files is not allowed.'));

		// Check expiration
		if($request->expiry && strtotime("now") > strtotime($request->expiry)) throw new \Exception(e('The expiry date must be later than today.'));

		// Check domain name
		if($user && $request->domain && DB::domains()->where('userid', $user->rid())->where('domain', clean($request->domain))->where('status', 1)->first()){
			$request->domain = trim($request->domain);
		}

		// Validate selected domain name
		if($request->domain && !$this->validateDomainNames(trim($request->domain), $user, false)){
			$request->domain = config("url");
		}

		if(!$request->domain && config("root_domain")) {
			$request->domain = config("url");
		}

        if((!$request->domain || $request->domain == config('url')) && !config("root_domain")) {
            if(!$user || !$user->admin){
                $mdomains = explode("\n", config("domain_names"));
                $mdomains = array_map("rtrim", $mdomains);
                if(!empty($mdomains[0])){				
                    $request->domain = trim($mdomains[0]);
                }else{
                    $request->domain = config("url");
                }
			}
		}
        // @group Plugin
        \Core\Plugin::dispatch('link.update.verify', $request);

		// Check custom alias
		if((!config('pro') || (config('pro') && $user && $user->has('alias'))) && $request->custom && $link->custom !== $request->custom){
			if(strlen($request->custom) < 3){
                throw new \Exception(e('Custom alias must be at least 3 characters.'));

            }elseif($this->wordBlacklisted($request->custom)){
                throw new \Exception(e('Inappropriate aliases are not allowed.'));

            }elseif(($request->domain == config('url') || !$request->domain) && DB::url()->where('custom', $this->slug($request->custom))->whereRaw("(domain = '' OR domain IS NULL)")->first()){
                throw new \Exception(e('That alias is taken. Please choose another one.'));

            }elseif(DB::url()->where('custom', $this->slug($request->custom))->where('domain', $request->domain)->first()){
                throw new \Exception(e('That alias is taken. Please choose another one.'));

            }elseif(DB::url()->where('alias', $this->slug($request->custom))->whereRaw('(domain = ? OR domain = ?)', [$request->domain, ''])->first()){
                throw new \Exception(e('That alias is taken. Please choose another one.'));

            }elseif($this->aliasReserved($request->custom)){
                throw new \Exception(e('That alias is reserved. Please choose another one.'));

            }elseif($user && !$user->pro() && $this->aliasPremium($request->custom)){
                throw new \Exception(e('That is a premium alias and is reserved to only pro members.'));
            }
		}

        // Generate formatted list of countries
        $countries = null;

		if($request->location && $user && $user->has('geo')){
			foreach ($request->location as $i => $country) {
				if(!empty($country) && !empty($request->target[$i])){

                    if(
                        !$this->validate($request->target[$i]) ||
                        !$this->safe($request->target[$i]) ||
                        $this->phish($request->target[$i]) ||
                        $this->virus($request->target[$i]) ||
                        $this->domainBlacklisted($request->target[$i]) ||
                        $this->wordBlacklisted($request->target[$i])
                    ) continue;
                    if($request->state[$i]){
                        $countries[strtolower(clean($country))][$request->state[$i]] = Helper::clean($request->target[$i], 3);
                    } else {
                        $countries[strtolower(clean($country))]['all'] = Helper::clean($request->target[$i], 3);
                    }
                }
			}
			$countries = $countries ? json_encode($countries) : $countries;
		}

        // Generate formatted list of devices
        $devices = null;

		if($request->device && $user && $user->has('device')){
			foreach ($request->device as $i => $device) {
				if(!empty($device) && $request->dtarget[$i]){

                    if(
                        !$this->safe($request->dtarget[$i]) ||
                        $this->phish($request->dtarget[$i]) ||
                        $this->virus($request->dtarget[$i]) ||
                        $this->domainBlacklisted($request->dtarget[$i]) ||
                        $this->wordBlacklisted($request->dtarget[$i])
                    ) continue;
					$devices[strtolower(clean($device))] = Helper::clean($request->dtarget[$i], 3);
                }
			}
			$devices = $devices ? json_encode($devices) : null;
		}

        // Formatted list of languages
        $options = json_decode($link->options, true);
        $languages = [];

        if($request->language && $user && $user->has('language')){

            foreach ($request->language as $i => $language) {
                if(!empty($language) && $request->ltarget[$i]){

                    if(
                        !$this->validate($request->ltarget[$i]) ||
                        !$this->safe($request->ltarget[$i]) ||
                        $this->phish($request->ltarget[$i]) ||
                        $this->virus($request->ltarget[$i]) ||
                        $this->domainBlacklisted($request->ltarget[$i]) ||
                        $this->wordBlacklisted($request->ltarget[$i])
                    ) continue;
                    $languages[strtolower(clean($language))] = Helper::clean($request->ltarget[$i], 3);
                }
            }
        }

        $options['languages'] = $languages;

        $rotators = [];
        $totalpercent = 0;
        if($request->abtesting && $user && $user->has('abtesting')){
            $rotatorcount = count(array_filter($request->abtesting));

			foreach ($request->abtesting as $i => $abtesting) {

				if(!empty($abtesting)){
                    if(
                        !$this->validate($abtesting) ||
                        !$this->safe($abtesting) ||
                        $this->phish($abtesting) ||
                        $this->virus($abtesting) ||
                        $this->domainBlacklisted($abtesting) ||
                        $this->wordBlacklisted($abtesting)
                    ) continue;
                    $percent = is_numeric($request->abtestingpercent[$i]) ? round($request->abtestingpercent[$i], 0) : round(100/$rotatorcount, 0);
                    $totalpercent += $percent;
                    if($totalpercent > 100) throw new \Exception(e('The total percentage is more than 100. Please re-adjust percentages.'));

					$rotators[] = ['percent' => $percent, 'link' => Helper::clean($abtesting, 3), 'count' => $options['rotators'][$i]['count'] ?? 0];
                }
			}
		}

        $options['rotators'] = $rotators;

        if($user->has('clicklimit')){
            $options['clicklimit'] = $request->clicklimit && is_numeric($request->clicklimit) ? clean($request->clicklimit) : null;
        }

        if($user->has('expiration')){
            $options['expirationredirect'] = $request->expirationredirect && Helper::isURL($request->expirationredirect) ? Helper::clean($request->expirationredirect, 3) : null;
        }

        if($user->has('deeplink') && $request->deeplink['enabled']){
            $options['deeplink']['enabled'] = true;
            $options['deeplink']['google'] = clean($request->deeplink['google']);
            $options['deeplink']['apple'] = clean($request->deeplink['apple']);
        }

        // Generate formatted list of parameters
        $parameters = null;

		if($request->paramname && $user && $user->has('parameters')){
			foreach ($request->paramname as $i => $param) {
				if(!empty($param) && $request->paramvalue[$i]){
					$parameters[clean($param)] = clean($request->paramvalue[$i]);
                }
			}
			$parameters = $parameters ? json_encode($parameters) : $parameters;
		}

        $pixels = $request->pixels && $user && $user->has('pixels') ? clean(implode(",", $request->pixels)) : null;

        if($request->type && $request->type == 'system') $request->type = '';

		if($request->type && ($request->type == "frame" || preg_match("!overlay-!", $request->type))){
			if(App::iframePolicy($url)){
				throw new \Exception(e('This URL cannot be used with this redirect method because browsers will prevent it for security reasons.'));
			}
		}

		if((!config('pro') || (config('pro') && $user && $user->has('alias'))) && $request->custom && $request->custom != $link->custom){
			$link->custom = $this->slug(clean($request->custom));
            $link->alias = null;
		}

        if($request->metatitle){
            $link->meta_title = clean($request->metatitle);
        }
        if($request->metadescription){
            $link->meta_description = clean($request->metadescription);
        }

        if($image = $request->metaimage){
            if(!$image->mimematch || !in_array($image->ext, ['jpg', 'png'])) throw new \Exception(e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            if($image->sizekb >= 500) throw new \Exception(e('Banner must be either a PNG or a JPEG (Max 500kb).'));

            $filename = Helper::rand(6)."_".str_replace(['#', ' '], '-', $image->name);

            request()->move($image, appConfig('app.storage')['images']['path'], $filename);
            if($link->meta_image){
                unlink( appConfig('app.storage')['images']['path'].'/'.$link->meta_image);
            }
            $link->meta_image = $filename;
        }

        if($request->custommetaimage){
            $link->meta_image = $request->custommetaimage;
        }

        if($request->bundle && $user && $bundle = DB::bundle()->where('userid', $user->rID())->where('id', $request->bundle)->first()){
            $link->bundle = $bundle->id;
        }else{
            $link->bundle = null;
        }

        $link->url = $user->pro() ? $url : $link->url;
        $link->description = $request->description ? clean($request->description) : '';
        $link->location = $countries;
        $link->devices = $devices;
        $link->pass = $request->pass ? clean($request->pass) : null;
        $link->domain = $request->domain ? trim($request->domain) : null;
        $link->pixels = $pixels;
        $link->parameters = $parameters;
        $link->options = json_encode($options);
        $link->expiry = $request->expiry && strtotime("now") < strtotime($request->expiry) && $user->has('expiration') ? date("Y-m-d H:i:s", strtotime($request->expiry)) : null;
        $link->public = 0;

        if((config("frame") == "3" || ($user && $user->pro())) && $request->type && in_array($request->type, array("direct","frame","splash"))) {
			$link->type = clean($request->type);
		}
		if($user && $user->has('splash') !== false && $request->type && is_numeric($request->type)){
			$link->type = $request->type;
		}
		if($user && $user->has('overlay') !== false && $request->type && preg_match("~overlay-(.*)~", $request->type)){
			$link->type = $request->type;
		}

        // @group Plugin
        \Core\Plugin::dispatch('link.update.final', $link);

        $link->save();

        return ['id' => $link->id, 'shorturl' => App::shortRoute($link->domain, $link->custom.$link->alias)];

    }
    /**
     * Update Statistics
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param \Core\Request $request
     * @param object $url
     * @param object $user
     * @return void
     */
    private function updateStats($request, $url, $user){    

		// Prevents Bots
		if(\Helpers\App::bot()) return false;

        if(\Core\Auth::logged() && ($url->userid == \Core\Auth::id() || \Core\Auth::user()->admin)) return false;

        if(config('pro') && $user && !$user->admin && !$user->planid) return false;

        // @group Plugin
        if($plugged = \Core\Plugin::dispatch('link.update.stats', $url)){
            foreach($plugged as $response){
                if($response === false) return false;
            }
        }

        $url->click++;

		// Check user visited recently
		if($request->cookie("short_{$url->id}")) return false;

		// Check Limit
		if($url->userid && $user && !$user->admin){

            $count = Helper::cacheGet('monthlyclicks'.$user->id);

			if($count === null){
                $firstday = date('Y-m-01');
                $lastday = date('Y-m-t');
                $count = DB::stats()->whereRaw("(date BETWEEN '{$firstday}' AND '{$lastday}') AND urluserid = ?", $url->userid)->count();
                Helper::cacheSet('monthlyclicks'.$user->id, $count, 60*60);
            }

			$plan = DB::plans()->where('id', $user->planid)->first();
			if($plan && $plan->numclicks > 0 && $count >= $plan->numclicks) return false;
		}

		// Update clicks
        $request->cookie("short_{$url->id}", 1, appConfig('app.antiflood'));

        // Update unique clicks
		if(!DB::stats()->where("urlid", $url->id)->where("ip", appConfig('haship') ? md5(AuthToken.$request->ip()) : $request->ip())->first()){
            $url->uniqueclick++;
		}

        if(config("tracking") != "1" && $url->userid == "0") {
            $url->save();
            return false;
        }

        // System Analytics
        if($request->referer()){
            $domain = parse_url($request->referer());
            if(isset($domain["host"])){
                $domain = $domain["scheme"]."://".$domain["host"];
            }else{
                $domain = "";
            }
            $referer = $request->referer();
        }else{
            $referer = "direct";
            $domain = "";
        }

        $stats = DB::stats()->create();

        $stats->short = $url->alias.$url->custom;
        $stats->urlid = $url->id;
        $stats->urluserid = $url->userid;
        $stats->date = Helper::dtime();

        $location = $request->country();

        $stats->country = $location['country'];
        $stats->city = $location['city'];

        $stats->referer = $referer;
        $stats->domain = $domain;
        $stats->ip = appConfig('haship') ? md5(AuthToken.$request->ip()) : $request->ip();
        $stats->os = $request->device();
        $stats->browser = $request->browser();
        $stats->language = $request->server('http_accept_language') ? substr($request->server('http_accept_language'), 0, 2) : null;
        $stats->save();

        $url->save();

        // @group Plugin
        \Core\Plugin::dispatch('link.extend.stats', $stats);

        if($user && !empty($user->zapview) && Helper::isURL($user->zapview)){
           \Core\Http::url($user->zapview)
                        ->with('content-type', 'application/json')
                        ->body([
                            "type" 		=> "view",
                            "shorturl" 	=> \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom),
                            "country" 	=> $stats->country,
                            "city"      => $stats->city,
                            "referer" 	=> $stats->referer,
                            "os" 		=> $stats->os,
                            "browser" 	=> $stats->browser,
                            "date" 		=> Helper::dtime()
                        ])->post();
        }
    }
    /**
     * Delete Link
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function deleteLink(int $id, $user = null){

        if($user && isset($user->id)){
            $url = DB::url()->where('id', $id)->where('userid', $user->rID())->first();
        } else {
            $url = DB::url()->where('id', $id)->first();
        }

        if(!$url) return false;

        if($url->metaimage && file_exists(appConfig('app.storage')['images']['path'].'/'.$url->metaimage)){
            unlink(appConfig('app.storage')['images']['path'].'/'.$url->metaimage);
        }

        DB::stats()->where('urlid', $url->id)->deleteMany();
        DB::tochannels()->where('itemid', $url->id)->deleteMany();

        if($url->qrid){
            DB::qrs()->where('urlid', $url->id)->deleteMany();
        }

        $url->delete();
        return true;
    }
    /**
     * Validate URL
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $url
     * @return void
     */
    protected function validate($url){
		if(empty($url)) return FALSE;

		$parsed = parse_url($url);
		$protocol = $parsed['scheme'] ?? 'https://';

		$schemes = explode(",", config("schemes"));

		$schemes = array_diff($schemes, ["http", "https", "www"]);

		if($protocol){
            if(in_array($protocol, $schemes)){
			    return $url;
            }
		}

		if(preg_match('~^([a-zA-Z0-9+!*(),;?&=$_.-]+(:[a-zA-Z0-9+!*(),;?&=$_.-]+)?@)?([a-zA-Z0-9\-\.]*)\.(([a-zA-Z]{2,4})|([0-9]{1,3}\.([0-9]{1,3})\.([0-9]{1,3})))(:[0-9]{2,5})?(/([a-zA-Z0-9+$_%-]\.?)+)*/?(\?[a-z+&\$_.-][a-zA-Z0-9;:@&%=+/$_.-]*)?(#[a-z_.-][a-zA-Z0-9+$%_.-]*)?~', $url) && !preg_match('(http://|https://)', $url)){
			$url = "https://$url";
		}
        
        if(!Helper::isURL($url)) return false;

		if(!filter_var($url, FILTER_VALIDATE_URL)){
			$parsed = parse_url($url);
			if(!isset($parsed["scheme"]) || !$parsed["scheme"]) return false;
			if(!isset($parsed["host"]) || !$parsed["host"]) return false;
		}
		return $url;
	}
    /**
     * Check if domain is blacklisted
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $url
     * @return boolean
     */
    public function domainBlacklisted(string $url){

        // Check if banned
        $cleanurl = trim(explode('#', $url)[0], '/');

        if(DB::reports()->where('bannedlink', $cleanurl)->first()){
			return true;
		}

        if(!config("adult")) return false;

        $list = config("domain_blacklist");

        if(file_exists(STORAGE.'/app/domains.txt')){
            $list = file_get_contents(STORAGE.'/app/domains.txt');
        }

		if(empty($list)) return false;

		$url = parse_url(strtolower($url));

		$array = explode(",", $list);

		if(!isset($url["host"])) return false;

        // Check if IP and blacklisted
		if(filter_var($url["host"], FILTER_VALIDATE_IP) && in_array($url["host"], $array)) return true;
            
		foreach ($array as $domain) {

            $domain = trim($domain);

            $url['host'] = trim($url['host']);

			if(strpos($domain, "*") !== false){
				$rule = str_replace("*", "(.*)", $domain);
				if(preg_match("~{$rule}~i", $url["host"])){
					return true;
				}
			}

            if ($domain == $url["host"]) {
                return true;
            }
		}    
		return false;
    }
    /**
     * Check if URL contains blacklisted keywords
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $url
     * @return void
     */
    public function wordBlacklisted(string $url){

        if(!config("adult")) return false;

        $list = config("keyword_blacklist");

        if(file_exists(STORAGE.'/app/keywords.txt')){
            $list = file_get_contents(STORAGE.'/app/keywords.txt');
        }

		if(empty($list)) {
			$array = [
                    'porn','porno','redtube','4tube','spankwire',
					'xshare','ziporn','naked','pornstar','pussy','fuck','suck','porntube',
					'scriptmaster','warez','scriptmafia','nulled','jigshare','gaaks','newone','scriptease','xtragfx','vivaprogram','kickassgfx',
					'gfxdl','fulltemplatedownload','dlscript','nigger','dick','faggot','cunt','gay','internbiokis',
					'asshole','penis','vagina','motherfucker','fucker','shit','fucked','boobs'
            ];
		}else{
			$array = explode(",", $list);
		}
		foreach ($array as $word) {
            if (strpos(strtolower(trim($url)), strtolower(trim($word))) !== false) {
                return true;
            }
		}
		return false;
	}

    /**
     * Check with Web Risk
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $url
     * @return boolean
     */
    public function safe(string $url){

		if(empty(config("safe_browsing"))) return true;

		// $SAFE_URL = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key={$this->config["safe_browsing"]}";
		$webriskurl = "https://webrisk.googleapis.com/v1/uris:search?key=";

		// Add Key
		$webriskurl .= config("safe_browsing");

		$threatTypes = ["MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE"];

		foreach ($threatTypes as $threat) {
			$webriskurl .= "&threatTypes={$threat}";
		}

		$webriskurl .= "&uri=".urlencode($url);

		$response = Http::url($webriskurl)->get()->bodyObject();

		if(isset($response->threat) && $response->threat->threatTypes[0]) return false;

		return true;
	}
    /**
     * Check with Phishtank
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4.3
     * @param string $url
     * @return boolean
     */
	public function phish(string $url){

		if(!config("phish_api")) return false;

		$phishurl = "https://checkurl.phishtank.com/checkurl/";

		$data["format"]="json";

		$data["app_key"] = '23d8c8ec935b00bb079f07a160499f2b4241a4e81cfa0f62d22ef345dbe9ce88';

		$data["url"] = urlencode($url);

        $response = Http::url($phishurl)->with('user-agent',  "phishtank/gempixel")->body($data)->post(['timeout' => 2])->bodyObject();

		if(isset($response->results->valid) && $response->results->valid) return true;

		return false;
	}
    /**
     * Check with Virus Total
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $url
     * @return boolean
     */
    public function virus(string $url){

        $config = config("virustotal");

        if(!isset($config->key) || empty($config->key)) return false;

		$vturl = "https://www.virustotal.com/vtapi/v2/url/report?apikey=";

		// Add Key
		$vturl .= $config->key;

		$vturl .= "&resource=".urlencode($url);

		$response = Http::url($vturl)->get(['timeout' => 2])->bodyObject();

		if(isset($response->positives) && $response->positives >= $config->limit) return true;

		return false;
    }

    /**
     * Detect if URL is media
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $url
     * @category extendable
     * @return boolean
     */
    public function isMedia($url){
        preg_match('((http://|https://|www.)([\w\-\d]+\.)+[\w\-\d]+)',$url, $r);

        $host = @str_replace(".","", $r[2]);

        $hosts = [
                "youtube" => "youtube\.(.*)\/watch\?v=([^\&\?\/]+)",
                "vimeo" => "vimeo\.(.*)\/([^\&\?\/]+)",
                "dailymotion" => "dailymotion\.(.*)\/video/([^\&\?\/]+)_([^\&\?\/]+)",
                "funnyordie" => "funnyordie\.(.*)\/videos/([^\&\?\/]+)",
                "collegehumor" => "collegehumor\.(.*)\/video/([^\&\?\/]+)\/([^\&\?\/]+)"
        ];

        if($extended = \Core\Plugin::dispatch('mediahost.extend')){
			foreach($extended as $fn){
				$hosts = array_merge($hosts, $fn);
			}
		}

        if(array_key_exists($host, $hosts) && preg_match("~{$hosts[$host]}~", $url, $match)){
            return array("host" => $host, "id" => $match[2], "url" => $url);
        }

        return false;
    }
    /**
     * Validate Domain Names
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.4
     * @param [type] $domain
     * @param boolean $return
     * @return void
     */
    protected function validateDomainNames($domain, $user = null, $return = true){
		if($user){

            $host = Helper::parseUrl($domain, 'host');
            if($user && $user->has('domain') && DB::domains()->where('userid', $user->rID())->whereRaw("(domain = ? OR domain = ?)", ["http://".$host,"https://".$host])->first()){
                return true;
            }

            if($isteam = $user->team()){
                if($team = \Models\User::first($isteam->id)){
                    if($team->refresh()->has('domain') &&  DB::domains()->where('userid', $team->id)->whereRaw("(domain = ? OR domain = ?)", ["http://".$host,"https://".$host])->first()){
                        return true;
                    }
                }
            }

            if(config("multiple_domains")){
                $domains = explode("\n", config("domain_names"));
                $domains = array_map("rtrim", $domains);
                $domains[] = config("url");

                if($user->has('multiple')) {
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

                    if($allowed){
                        if(in_array(trim($domain), $allowed)){
                            if($return) return $domain;
                            return true;
                        }
                    }else{
                        if($return) return $domain;
                        return true;
                    }
                }
            }
		}
		return false;
	}
    /**
     * Check if user is trying to shorten a short url
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $url
     * @return boolean
     */
    private function isSelf($url){

        $user = Auth::user();

        if($user && $user->admin) return false;

        $domain = Helper::parseUrl($url, 'host');

        if(!$domain) return false;

        // Check main domain
        if(Helper::parseUrl(config('url'), 'host') == $domain) return true;

        // Check secondary domains
        foreach(explode(',', config('domain_names')) as $dn){
            if(Helper::parseUrl($dn, 'host') == $domain) return true;
        }

        return false;
    }
    /**
     * Alias is reserved
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.5
     * @param string $string
     * @return void
     */
    private function aliasReserved(string $string){

        // Check system alias
        foreach(\Gem::controllers() as $routes){
            $path = explode('/', trim($routes['path'], '/'));
            if(strtolower($string) == strtolower($path[0])) return true;
        }

		return false;
	}
	/**
	 * Premium Aliases
	 * @since 4.0
	 **/
	public function aliasPremium($alias){

        $list =  explode(",", config('aliases'));

        if(file_exists(STORAGE.'/app/aliases.txt')){
            $list = array_merge(explode(',', file_get_contents(STORAGE.'/app/aliases.txt')), $list);
        }

		// Check reserved alias
		if(in_array($alias, $list)) return true;

        return false;
	}
    /**
     * Generate a simple slug
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $string
     * @return void
     */
    public function slug(string $string){

        $str = preg_replace("/[\/_|+ -.]+/", "-", $string);
        $str = str_replace("'","",$str);
        $str = str_replace('"','',$str);
        $str = str_replace('?','',$str);
        return rtrim(trim($str,'-'), '-');
    }
    /**
     * Generate a random slug
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    protected function alias(){

        $unique = false;
		$max_loop = 100;
		$i = 0;
        $length = config("alias_length");

		if($length < 2) $length = 2;

        $format = appConfig('app.aliasformat');

		while (!$unique) {
			// retry if max attempt reached
			if($i >= $max_loop) {
                $length++;
				$i = 0;
			}
			$alias = Helper::rand($length, '', $format);
			if(!DB::url()->where('alias', $alias)->first()) $unique = true;
			$i++;
		}
		return $alias;
	}
    /**
     * Add to history
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param [type] $result
     * @return void
     */
    protected function addHistory($result){

        $request = request();

        if(config('user_history') && !\Core\Auth::logged()){

            if($userhistory = $request->cookie('userhistory')){
                $data = json_decode(Helper::decrypt($userhistory));
                if(!in_array($result['id'], $data)){
                    $data[] = $result['id'];
                    $new = array_reverse($data);
                    $keep = array_slice($new, 0, 9);
                    $request->cookie('userhistory', Helper::encrypt(json_encode($keep)), 60 * 24 *365);
                }
            }else{
                $request->cookie('userhistory', Helper::encrypt(json_encode([$result['id']])), 60 * 24 *365);
            }
        }
    }
}