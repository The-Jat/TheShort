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
use Core\View;
use Core\Helper;
use Core\DB;
use Helpers\Payments\Paypal;
use Helpers\Slack;

class Webhook {

    use Traits\Links, Traits\Payments;

	/**
	 * Handle Webhook
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 7.3
	 * @param [type] $provider
	 * @return void
	 */
	public function index(Request $request, $provider = null){

		if(!$provider) $provider = 'stripe';

		if($provider == 'paypal') $provider = 'paypalapi';

		\Core\Plugin::register('payment.success', function($data){

			$config = config('affiliate');

			if(!$config->enabled) return;

			[$user, $planid, $payment] = $data;

			if(isset($config->freq) && $config->freq == 'recurring'){
				$affiliate = DB::affiliates()->where('userid', $user->id)->first();
			}else{
				$affiliate = DB::affiliates()->where('userid', $user->id)->whereNull('paid_on')->first();
			}

			if($affiliate){
				if($payment = DB::payment()->where('id', $payment)->first()){
					if($payment->status == 'Completed'){
						if(isset($config->type) && $config->type == 'fixed'){
							if(isset($config->freq) && $config->freq == 'recurring'){
								$affiliate->amount = $affiliate->amount + $config->rate;
							} else {
								$affiliate->amount = $config->rate;
							}
						} else {
							if(isset($config->freq) && $config->freq == 'recurring'){
								$affiliate->amount = $affiliate->amount + round(($config->rate / 100) * $payment->amount, 2);
							} else {
								$affiliate->amount = round(($config->rate / 100) * $payment->amount, 2);
							}
						}
						$affiliate->paid_on = Helper::dtime();
						$affiliate->save();
					}
				}
			}
		});

		if($provider && method_exists(__CLASS__, $provider)){
			return $this->{$provider}($request);
		}

		if($class = $this->processor($provider, 'webhook')){
			return call_user_func($class, $request);
		}

		die();
	}
	/**
	 * Slack Webhook
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.6.3
	 * @param \Core\Request $request
	 * @return void
	 */
    public function slack(Request $request){

		$start = microtime(true);

		if($body = $request->getJSON()){
			
			if(isset($body->challenge) && isset($body->type) && $body->type == 'url_verification'){
				return Response::factory($body->challenge)->send();
			}

			if(isset($body->event->type) && isset($body->team_id) && $body->event->type == 'app_uninstalled'){
				DB::user()->where('slackteamid', clean($body->team_id))->update(['slackteamid' => null, 'slackid' => null]);
				return true;
			}
		}


		if(Slack::validate(config("slacksigningsecret"))){

			$user_id = $request->user_id;
			$content = $request->text;
			$webhook = $request->response_url;

			preg_match_all('#\(([^)]+)\)[\s](.*)#i', $content, $matches);

			if(isset($matches[1][0]) && !empty($matches[1][0])){
				$custom     = $matches[1][0];
				$url 		= $matches[2][0];
			}else{
				$url    = $content;
				$custom = "";
			}


			if(!$user_id || !$user = \Models\User::where('slackid', $user_id)->first()){
				return print('*Error*: User not authenticated. Please connect to Slack via your dashboard.');
			}

			if($url == 'help'){
				return print("*Help*\n\nYou can use /".config('slackcommand')." to shorten links as follows:\n `/".config("slackcommand")." https://google.com` \n\n If you want to use a custom alias you can define a custom alias in parenthesis as follows:\n `/".config("slackcommand")." (CUSTOMALIAS) https://google.com`\n\nYou can also request last 5 clicks using *clicks:* preceding you short link as follows:\n`/".config("slackcommand")." clicks:".url('myshortlink')."`\n");
			}

			if(empty($url)){
				return print("*Invalid URL*\n\nYou can use /".config('slackcommand')." to shorten links as follows:\n `/".config("slackcommand")." https://google.com` \n\n If you want to use a custom alias you can define a custom alias in parenthesis as follows:\n `/".config("slackcommand")." (CUSTOMALIAS) https://google.com`");
			}

			// Clicks Command
			if(strpos($url, 'clicks:') !== false){
				$shorturl = trim(trim(str_replace('clicks:', '', $url), '/'));

				if(empty($shorturl)) return print("*Invalid Short URL*");

				$shorturl = explode('?', $shorturl)[0];
				$shorturl = explode('#', $shorturl)[0];

				if(!Helper::isURL($shorturl)) return print("*Invalid Short URL*");

				$parts = explode('/', $shorturl);

				$alias = end($parts);

				$domain = trim(str_replace($alias, '', $shorturl), '/');

				$domain = idn_to_utf8($domain);

				$current = str_replace(["http://", "https://"], "", $domain);

				if("http://".$current == config("url") || "https://".$current == config("url")){
					$url = DB::url()->whereRaw("userid = :user AND (alias = BINARY :alias OR custom = BINARY :alias) AND (domain LIKE :domain OR domain IS NULL OR domain = '')", [':user' => $user->id, ':alias' => $alias, ':domain' => "%{$current}"])->first();
				}else{
					$url = DB::url()->whereRaw("userid = :user AND (alias = BINARY :alias OR custom = BINARY :alias) AND domain = :domain", [':user' => $user->id, ':alias' => $alias, ':domain' => $domain])->first();
				}

				if(!$clicks = DB::stats()->where('urlid', $url->id)->limit(5)->orderByDesc('date')->find()){
					return print('This link has not been clicked as of '.Helper::dtime());
				}

				foreach($clicks as $stats){
					echo sprintf('Someone from *%s* on *%s*, *%s* originated from %s clicked at *%s*', 
							($stats->city ? $stats->city.', ':'').ucfirst($stats->country), 
							$stats->browser, 
							$stats->os, 
							$stats->referer, 
							$stats->date
						)."\n\n";
				}
				return;
			}

            $data = new \stdClass;

			$data->custom = isset($custom) && !empty($custom) ? $custom : null;

			$data->url = clean($url);

			$data->pass =  null;

			$data->domain = $user->domain ?? null;

			$data->expiry = null;

			$data->type = null;
			$data->location = null;
			$data->language = null;
			$data->device = null;
			$data->state = null;
			$data->paramname  = null;
			$data->paramvalue  = null;
			$data->metatitle = null;
			$data->metadescription = null;
			$data->metaimage = null;
			$data->description = null;
			$data->pixels = null;

            try	{

                $response = $this->createLink($data, $user);

            } catch (\Exception $e){

                $response = [];

				\GemError::log('Slack Error: '.$e->getMessage());

				return print("*Error*: ".$e->getMessage());
            }

			if((microtime(true) - $start) > 3){

                \Core\Http::url($webhook)->with('content-type', 'application/json')->body(["text" => isset($response['shorturl']) ? $response["shorturl"] : $url])->post();

				return true;
			}


			return print(isset($response["shorturl"]) ? $response["shorturl"] : $url);
		}
	
		return print("Error");
	}
	/**
	 * PayPal IPN
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.0
	 * @param \Core\Request $request
	 * @return void
	 */
	public function ipn(Request $request){
		return Paypal::webhook($request);
	}
}