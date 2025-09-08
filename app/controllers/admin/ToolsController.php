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

namespace Admin;

use Core\DB;
use Core\View;
use Core\Request;
use Core\Response;
use Core\Helper;
use Core\Email;
use Models\User;

class Tools {
    /**
     * Tools
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('tools.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view tools.'));
        }
        
        \Helpers\CDN::load('datetimepicker');
        
        View::set('title', e('Tools'));

        $optimized = new \stdClass;

        if(
            !\Core\DB::hasIndex('stats', 'stats_urlid_date') || 
            !\Core\DB::hasIndex('stats', 'stats_urlid_domain') || 
            !\Core\DB::hasIndex('stats', 'stats_urlid_country') || 
            !\Core\DB::hasIndex('stats', 'stats_urlid_os_date') || 
            !\Core\DB::hasIndex('stats', 'stats_urlid_browser_date') || 
            !\Core\DB::hasIndex('stats', 'stats_urlid_language_date') || 
            !\Core\DB::hasIndex('stats', 'stats_urlid_ip') ||
            !\Core\DB::hasIndex('stats', 'stats_urluserid') ||
            !\Core\DB::hasIndex('stats', 'stats_urluserid_date') ||
            \Core\DB::hasIndex('stats', 'short')

        ){
            $optimized->stats = false;
        } else {
            $optimized->stats = true;
        }

        if(!\Core\DB::hasIndex('url', 'url_qrid_profileid_click') || !\Core\DB::hasIndex('url', 'url_alias_custom_domain') || !\Core\DB::hasIndex('url', 'url_qrid_profileid_date') || !\Core\DB::hasIndex('url', 'url_userid_date')){
            $optimized->url = false;
        } else {
            $optimized->url = true;
        }
        return View::with('admin.tools', compact('optimized'))->extend('admin.layouts.main');
    }
    /**
     * Tools Action
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param string $action
     * @param [type] $nonce
     * @return void
     */
    public function action(Request $request, string $action, $nonce = null){
        if(!user()->hasRolePermission('tools.update')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to perform this action.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'tools')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        $fn = 'tool_'.$action;
        
        if(\method_exists(__CLASS__, $fn)) return $this->{$fn}($request);

        return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Add Index
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.4.3
     * @param [type] $request
     * @return void
     */
    private function tool_addindex($request){

        if(!$request->table) return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));

        if($request->table == "url"){
            if(!DB::hasIndex('url', 'url_qrid_profileid_click')){
                DB::alter('url', function($table){
                    $table->multiindex('url_qrid_profileid_click', ['qrid', 'profileid', 'click']);
                });
            }
    
            if(!DB::hasIndex('url', 'url_alias_custom_domain')){
                DB::alter('url', function($table){
                    $table->change('domain')->string('domain', 100);
                    $table->change('custom')->string('custom', 100);
                    $table->change('alias')->string('alias', 10);                    
                    if(DB::hasIndex('url', 'alias')){
                        $table->dropindex('alias');
                    }

                    if(DB::hasIndex('url', 'custom')){
                        $table->dropindex('custom');
                    }
                    $table->multiindex('url_alias_custom_domain', ['alias', 'custom', 'domain']);
                });
            }
    
            if(!DB::hasIndex('url', 'url_qrid_profileid_date')){
                DB::alter('url', function($table){
                    $table->multiindex('url_qrid_profileid_date', ['qrid', 'profileid', 'date']);
                });
            }

            if(!DB::hasIndex('url', 'url_userid_date')){
                DB::alter('url', function($table){
                    $table->multiindex('url_userid_date', ['userid', 'date']);
                });
            }

            return Helper::redirect()->back()->with('success', e('URL table has been successfully optimized'));
        }

        if($request->table == "stats"){

            if(DB::hasIndex('stats', 'short')){
                DB::alter('stats', function($table){                    
                    $table->dropindex('short');
                });
            }

            if(!DB::hasIndex('stats', 'stats_urlid_date')){
                DB::alter('stats', function($table){                    
                    $table->multiindex('stats_urlid_date', ['urlid','date']);
                });
            }

            if(!DB::hasIndex('stats', 'stats_urlid_ip')){
                DB::alter('stats', function($table){
                    if(DB::hasIndex('stats', 'ip')){
                        $table->dropindex('ip');
                    }                    
                    $table->multiindex('stats_urlid_ip', ['urlid','ip']);
                });
            }


            if(!DB::hasIndex('stats', 'stats_urlid_domain')){
                DB::alter('stats', function($table){
                    
                    if(DB::hasIndex('stats', 'domain')){
                        $table->dropindex('domain');
                    }
                    $table->multiindex('stats_urlid_domain', ['urlid','domain']);
                });
            }

            if(!DB::hasIndex('stats', 'stats_urlid_country')){

               
                DB::alter('stats', function($table){
                     if(DB::hasIndex('stats', 'country')){
                        $table->dropindex('country');
                    }
                    $table->multiindex('stats_urlid_country', ['urlid','country']);
                });
            }

            if(!DB::hasIndex('stats', 'stats_urlid_os_date')){
               
                DB::alter('stats', function($table){
                     if(DB::hasIndex('stats', 'os')){
                        $table->dropindex('os');
                    }
                    $table->multiindex('stats_urlid_os_date', ['urlid','os', 'date']);
                });
            }

            if(!DB::hasIndex('stats', 'stats_urlid_browser_date')){
               
                DB::alter('stats', function($table){
                     if(DB::hasIndex('stats', 'browser')){
                        $table->dropindex('browser');
                    }
                    $table->multiindex('stats_urlid_browser_date', ['urlid','browser', 'date']);
                });
            }

            if(!DB::hasIndex('stats', 'stats_urlid_language_date')){
               
                DB::alter('stats', function($table){
                     if(DB::hasIndex('stats', 'language')){
                        $table->dropindex('language');
                    }
                    $table->multiindex('stats_urlid_language_date', ['urlid','language', 'date']);
                });
            }

            if(!DB::hasIndex('stats', 'stats_urluserid')){
               
                DB::alter('stats', function($table){
                    $table->multiindex('stats_urluserid', ['urluserid']);
                });
            }
            if(!DB::hasIndex('stats', 'stats_urluserid_date')){
               
                DB::alter('stats', function($table){
                    $table->multiindex('stats_urluserid_date', ['urluserid', 'date']);
                });
            }

            return Helper::redirect()->back()->with('success', e('Stats table has been successfully optimized'));
        }
        return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Optimize Database
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param [type] $request
     * @return void
     */
    private function tool_optimize($request){
        $data = ['ads','affiliates','bundle','coupons','domains','faqs','overlay','page','payment','pixels','plans','posts','profiles','qrs','reports','settings','splash','stats','url','user','taxrates'];

        foreach($data as $table){
            DB::optimize($table);
        }

        return Helper::redirect()->back()->with('success', e('Database has been successfully optimized'));
    }
    /**
     * Delete Inactive links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function tool_deleteurls($request){

        DB::url()->where('click', '0')->whereNull('qrid')->whereNull('profileid')->whereRaw('date < (CURDATE() - INTERVAL 30 DAY)')->deleteMany();

        return Helper::redirect()->back()->with('success', e('Inactive links have been removed from the database.'));
    }
    /**
     * Delete Users
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function tool_deleteusers($request){
     
        DB::user()->where('active', 0)->where('admin', 0)->deleteMany();
     
        return Helper::redirect()->back()->with('success', e('Inactive users have been removed from the database.'));
    }
    /**
     * Flush links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function tool_flushurls($request){

        if($request->confirm != 'DELETE') return back()->with('danger', e('Please enter DELETE in the appropriate field to confirm action.'));

        $urls = DB::url()->whereNull('qrid')->whereNull('profileid')->where('userid', '0');
        if($request->date){
            $urls->whereRaw('DATE(date) < ?', [$request->date]);
        }
        $urls->deleteMany();

        $stats = DB::stats()->where('urluserid', '0');
        if($request->date){
            $stats->whereRaw('DATE(date) < ?', [$request->date]);
        }
        $stats->deleteMany();

        return Helper::redirect()->back()->with('success', e('All links by anonymous users have been removed from the database.'));
    }
    /**
     * Export Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function tool_exporturls(){
        $content = "Short URL, Long URL, Date, Clicks, Unique Clicks, User ID\n";
        foreach(DB::url()->whereNull('qrid')->whereNull('profileid')->findMany() as $url){
            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",\"{$url->url}\",{$url->date},{$url->click},{$url->uniqueclick},{$url->userid}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=linkslist_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
    /**
     * Export Users
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function tool_exportusers(){
        $content = "Username (empty=none), Email, Marketing Consent, Registration Date, Auth Method (empty=system), Pro, Plan ID, Expiration, Trial\n";

        foreach(DB::user()->findMany() as $user){
            $content .= "{$user->username},{$user->email},{$user->date},".($user->newsletter ? 'Yes':'No').",{$user->auth},{$user->pro},{$user->planid},{$user->expiration},{$user->trial}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=userslist_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
    /**
     * Export Payments
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    private function tool_exportpayments(){
        $content = "Transaction ID, User ID, Status, Amount, Date\n";

        foreach(DB::payment()->findMany() as $payment){
            $content .= "{$payment->tid},{$payment->userid},{$payment->status},{$payment->amount},{$payment->date}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=paymentlist_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
    /**
     * Clean Up Site
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.6
     * @return void
     */
    private function tool_cleanup(Request $request){

        if($request->confirm != 'DELETE') return back()->with('danger', e('Please enter DELETE in the appropriate field to confirm action.'));
        
        $usercount = 0;
        if($request->users){            
            foreach(DB::user()->select('id')->whereRaw('DATE(date) < (CURDATE() - INTERVAL 30 DAY)')->find() as $user){
                if(DB::members()->where('userid', $user->id)->first()) continue;
                if(DB::url()->where('userid', $user->id)->count() == '0'){
                    $user->delete();

                    DB::bundle()->where('userid', $user->id)->deleteMany();
                    DB::channels()->where('userid', $user->id)->deleteMany();
                    DB::domains()->where('userid', $user->id)->deleteMany();
                    DB::imports()->where('userid', $user->id)->deleteMany();
                    DB::members()->where('userid', $user->id)->deleteMany();
                    DB::overlay()->where('userid', $user->id)->deleteMany();
                    DB::pixels()->where('userid', $user->id)->deleteMany();
                    DB::profiles()->where('userid', $user->id)->deleteMany();
                    DB::qrs()->where('userid', $user->id)->deleteMany();
                    DB::splash()->where('userid', $user->id)->deleteMany();
                    DB::stats()->where('urluserid', $user->id)->deleteMany();
                    DB::tochannels()->where('userid', $user->id)->deleteMany();
                    DB::url()->where('userid', $user->id)->deleteMany();
                    DB::verification()->where('userid', $user->id)->deleteMany();   
                    DB::payment()->where('userid', $user->id)->deleteMany();
            
                    DB::appevents()->where('userid', $user->id)->deleteMany();
            
                    if(\Helpers\App::possible()){
                        DB::subscription()->where('userid', $user->id)->deleteMany();
                    }

                    $usercount++;
                }
            }
        }

        $paymentcount = 0;
        if($request->payments){
            DB::payment()->where('status', 'Pending')->deleteMany();
            $paymentcount = 1;
        }
        $subcount = 0;
        if(\Helpers\App::possible()){
            if($request->subscription){
                DB::subscription()->where('status', 'Pending')->deleteMany();
                $subcount = 1;
            }
        }

        $statscount = 0;
        if($request->stats){
            DB::stats()->where('urluserid', '0')->deleteMany();
            DB::url()->where('userid', '0')->update(['click' => 0, 'uniqueclick' => 0]);
            $statscount = 1;
        }

        return back()->with('success', 
            ($usercount ? e('{x} users were removed.', null, ['x' => $usercount]).'<br>':'').
            ($paymentcount ? e('Pending payments were removed.').'<br>':'').
            ($subcount ? e('Pending subscriptions were removed.').'<br>':'').
            ($statscount ? e('Anonymous stats were removed and links were reset.').'<br>':'')
        );
    }

    /**
     * Backup Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function data(){
        if(!user()->hasRolePermission('tools.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view tools.'));
        }

        View::set("title", e("Backup/Restore Data"));

        return View::with('admin.backup')->extend('admin.layouts.main');         
    }
    /**
     * Backup Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function backup(Request $request){
        if(!user()->hasRolePermission('tools.backup')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to backup data.'));
        }
        \Gem::addMiddleware('DemoProtect');

        $data = [];

        if($request->ads){
            $data['ads'] = DB::ads()->findArray();
        }
        if($request->affiliates){
            $data['affiliates'] = DB::affiliates()->findArray();
        }
        if($request->bundle){
            $data['bundle'] = DB::bundle()->findArray();
        }
        if($request->channels){
            $data['channels'] = DB::channels()->findArray();
            $data['tochannels'] = DB::tochannels()->findArray();
        }
        if($request->coupons){
            $data['coupons'] = DB::coupons()->findArray();
        }
        if($request->domains){
            $data['domains'] = DB::domains()->findArray();
        }
        if($request->faqs){
            $data['faqs'] = DB::faqs()->findArray();
        }
        if($request->overlay){
            $data['overlay'] = DB::overlay()->findArray();
        }
        if($request->page){
            $data['page'] = DB::page()->findArray();
        }
        if($request->payment){
            $data['payment'] = DB::payment()->findArray();
        }
        if($request->pixels){
            $data['pixels'] = DB::pixels()->findArray();
        }
        if($request->plans){
            $data['plans'] = DB::plans()->findArray();
        }
        if($request->posts){
            $data['posts'] = DB::posts()->findArray();
        }
        if($request->profiles){
            $data['profiles'] = DB::profiles()->findArray();
        }
        if($request->qrs){
            $data['qrs'] = DB::qrs()->findArray();
        }
        if($request->reports){
            $data['reports'] = DB::reports()->findArray();
        }
        if($request->settings){
            $data['settings'] = DB::settings()->findArray();
        }
        if($request->splash){
            $data['splash'] = DB::splash()->findArray();
        }
        if($request->stats){
            $data['stats'] = DB::stats()->findArray();
        }
        if($request->subscription){
            $data['subscription'] = DB::subscription()->findArray();
        }
        if($request->url){
            $data['url'] = DB::url()->findArray();
        }
        if($request->user){
            $data['user'] = DB::user()->findArray();
        }
        if($request->verification){
            $data['verification'] = DB::verification()->findArray();
        }
        if($request->taxrates){
            $data['taxrates'] = DB::taxrates()->findArray();
        }
        
        \Core\File::contentDownload('backup-'.date('Y-m-d').'.gem', function() use ($data){
            return serialize($data);
        });
    }
    /**
     * Restore Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function restore(Request $request){
        if(!user()->hasRolePermission('tools.restore')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to restore data.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$file = $request->file('file')){
            return back()->with('danger', e('Incorrect format or empty file. Please upload .gem file.'));
        }

        if($file->ext != 'gem'){
            return back()->with('danger', e('Incorrect format or empty file. Please upload .gem file.'));
        }

        $content = unserialize(file_get_contents($file->location));

        foreach($content as $table => $data){

            DB::truncate($table);
        
            foreach($data as $rows){
                $record = DB::table($table)->create($rows);                
                $record->save();
            }
        }
        return back()->with('success', e('Data has been successfully restored.'));
    }
    /**
     * Clear System Cache
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.3
     * @return void
     */
    public function tool_clearcache(){
        
        Helper::cacheInstance()->clear();

        return back()->with('success', e('System cache has been reset.'));
    }
    /**
     * Robot.txt generator
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @param \Core\Request $request
     * @return void
     */
    public function tool_robots(Request $request){
        $file = fopen(PUB.'/robots.txt', 'w');
        fwrite($file, trim($request->content));
        fclose($file);

        return back()->with('success', e('Robots.txt has been generated successfully.'));
    }
}