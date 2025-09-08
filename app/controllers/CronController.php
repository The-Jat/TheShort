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
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\DB;
use Models\User;
use Helpers\Emails;

class Cron {
    use Traits\Links;

    /**
     * Check User Cron Jobs
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.1
     * @param string $token
     * @return void
     */
    public function user(string $token){

        if($token != md5('user'.AuthToken)) return null;

        if(!\Helpers\App::possible() || !config('pro')) return null;

        $i = 0;
        foreach(User::where('admin', 0)->where('pro', '1')->limit(500)->findMany() as $user){

			if($user->pro && strtotime($user->expiration) < time() || ($user->trial && strtotime('now') > strtotime($user->expiration))) {
                $user->pro = 0;
                $user->planid = null;
                $user->trial = 0;
                $user->save();
                if($user->email){
                    Emails::canceled($user);
                }
                if($plugged = \Core\Plugin::dispatch('cron.user', $user)){
                    foreach($plugged as $response){
                        if($response === true) $detected = true;
                    }
                }
                $i++;
			}
        }
        GemError::channel('Cron.users');
        GemError::toChannel('Cron.users', $i > 0 ? "{$i} users were downgraded.": "Nothing to report.");

    }
    /**
     * Remove Data
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.1
     * @param string $token
     * @return void
     */
    public function data(string $token){

        if($token != md5('data'.AuthToken)) return null;

        if(!config('pro')) return null;

        $ids = null;

        foreach(User::select('id')->select('planid')->where('admin', 0)->whereNotNull('planid')->limit(500)->findArray() as $user){

            if(!$plan = DB::plans()->where('id', $user['planid'])->first()) continue;

            $retention = $plan->retention;

            if($retention == 0) continue;

            if($plugged = \Core\Plugin::dispatch('cron.data', $user)){
                foreach($plugged as $response){
                    if($response === true) $detected = true;
                }
            }

            DB::stats()->where('urluserid', $user['id'])->whereRaw('DATE(date) < \''.date("Y-m-d 00:00:00", strtotime("-{$retention} days")).'\'')->deleteMany();
            $ids .= "#{$user['id']},";
        }

        GemError::channel('Cron.data');
        GemError::toChannel('Cron.data', $ids ? "Data for users {$ids} were removed.": "Nothing to report.");

    }
    /**
     * Check URLs
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.1
     * @param string $token
     * @return void
     */
    public function urls(string $token){

        if($token != md5('url'.AuthToken)) return null;

        $i = 0;

        foreach(DB::url()->whereNull('qrid')->whereNull('profileid')->where('status', 1)->orderByExpr('RAND()')->limit(500)->findMany() as $url){

            $detected = false;
            // Check blacklist domain
            if(!$url->qrid && !$url->profileid && ($this->domainBlacklisted($url->url) || $this->wordBlacklisted($url->url))){
                $detected = true;
            }

            // Check with Google Web Risk
            if(!$url->qrid && !$url->profileid && !$this->safe($url->url)) {
                $detected = true;
            }

            // Check with Phish
            if(!$url->qrid && !$url->profileid && $this->phish($url->url)) {
               $detected = true;
            }

            // Check with VirusTotal
            if(!$url->qrid && !$url->profileid && $this->virus($url->url)) {
                $detected = true;
            }

            if($plugged = \Core\Plugin::dispatch('cron.urls', $url)){
                foreach($plugged as $response){
                    if($response === true) $detected = true;
                }
            }

            if($detected){
                $url->status = 0;
                $url->save();

                if(DB::reports()->where('url', $url->url)->first()) continue;

                $report = DB::reports()->create();
                $report->url = \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom);
                $report->type = "Disabled by cron";
                $report->email = "Cron Job";
                $report->bannedlink = $url->url;
                $report->status = 1;
                $report->ip = null;
                $report->date = Helper::dtime();
                $report->save();
                $i++;
            }
        }

        GemError::channel('Cron.urls');
        GemError::toChannel('Cron.urls', $i > 0 ? "{$i} urls were blocked.": "Nothing to report.");
    }
    /**
     * Remind Users
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.1
     * @param string $days
     * @param string $token
     * @return void
     */
    public function remind(string $days, string $token){

        if($token != md5('remind'.AuthToken)) return null;

        $i = 0;

        foreach(User::where('admin', 0)->where('trial', 1)->limit(500)->findArray() as $user){

            if(date('d-m-Y') == date('d-m-Y', strtotime("-{$days} days", strtotime($user['expiration'])))){
                Emails::remind($user);
                if($plugged = \Core\Plugin::dispatch('cron.remind', $user)){
                    foreach($plugged as $response){
                        if($response === true) $detected = true;
                    }
                }
                $i++;
            }
        }

        GemError::channel('Cron.reminded');
        GemError::toChannel('Cron.reminded', $i > 0 ? "{$i} users were reminded.": "Nothing to report.");
    }
    /**
     * Import links from CSV
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.1
     * @param string $token
     * @return void
     */
    public function imports(string $token){

        if($token != md5('import'.AuthToken)) return null;

        if(!$import = DB::imports()->where('status', 0)->first()) return null;

        if(!$user = User::where('id', $import->userid)->first()) {
            if(file_exists( STORAGE.'/app/imports/'.$import->filename)) unlink(STORAGE.'/app/imports/'.$import->filename);
            $import->delete();
        }

        $import->data = json_decode($import->data);

        if(!file_exists( STORAGE.'/app/imports/'.$import->filename)) $import->delete();

        $content = array_map('str_getcsv', file(STORAGE.'/app/imports/'.$import->filename));
        $header = $content[0];
        unset($content[0]);
        $count = count($content);
        $valid = 0;
        $total = 0;
        if($count > 0){
            foreach(array_chunk($content, 250)[0] as $i => $data){
                $link = new \stdClass;
                if(!empty($data[0])){

                    $link->url = clean($data[0]);

                    $link->custom = null;
                    if(!clean(empty($data[1])) && !DB::url()->where('custom', clean($data[1]))->first()){
                        $link->custom = clean($data[1]);
                    }
                    $link->metatitle = isset($data[2]) && $data[2] ? clean($data[2]) : null;
                    $link->metadescription = isset($data[3]) && $data[3] ? clean($data[3]) : null;

                    $link->domain = (isset($import->data->domain) && !empty($import->data->domain)) ? clean($import->data->domain) : null;
                    $link->type = (isset($import->data->type) && !empty($import->data->type)) ? clean($import->data->type) : null;

                    $link->pass = null;
                    $link->expiry = null;
                    $link->location = null;
                    $link->device = null;
                    $link->state = null;
                    $link->language = null;
                    $link->paramname  = null;
                    $link->paramvalue  = null;
                    $link->metaimage = null;
                    $link->custommetaimage = null;
                    $link->description = null;
                    $link->pixels = null;


                    try{

                        $this->createLink($link, $user);

                    } catch(\Exception $e){

                    }
                }
                unset($content[$i+1]);
                $total++;
            }
        }
        if(!empty($content)){
            $file = fopen(STORAGE.'/app/imports/'.$import->filename, 'w');
            fwrite($file, implode(',', $header)."\n");
            foreach($content as $new){
                fwrite($file, implode(',', $new)."\n");
            }
            fclose($file);
        }else{
            $import->status = 1;
            if(file_exists( STORAGE.'/app/imports/'.$import->filename)) unlink(STORAGE.'/app/imports/'.$import->filename);
        }
        $import->data = json_encode($import->data);
        $import->processed = $import->processed + $total;
        $import->save();

        GemError::channel('Cron.imports');
        GemError::toChannel('Cron.imports', $i > 0 ? "{$i} links imported for user #{$user->id} via CSV.": "Nothing to report.");

    }
}

