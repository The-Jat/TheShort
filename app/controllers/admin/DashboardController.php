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
use Helpers\App;

class Dashboard {

    /**
     * Index
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function index(){

        $urls = new \stdClass;
        $urls->latest = DB::url()->whereNull('qrid')->whereNull('profileid')->orderByDesc('date')->limit(5)->findMany();
        $urls->top = DB::url()->whereNull('qrid')->whereNull('profileid')->orderByDesc('click')->limit(5)->findMany();

        $users = [];

        foreach(User::orderByDesc('date')->limit(5)->findMany() as $user){
            if(_STATE == "DEMO") $user->email="demo@demo.com";
            if($plan = DB::plans()->where('id', $user->planid)->first()){
                $user->planname = $plan->name;
            } else{
                $user->planname = "n\a";
            }

            $users[] = $user;
        }

        $reports = DB::reports()->orderByDesc('date')->limit(5)->findMany();

        $payments = \Helpers\App::possible() ? DB::payment()->orderByDesc('date')->limit(5)->map(function($payment){
            if($user = User::where('id', $payment->userid)->first()){
                if(_STATE == "DEMO") $user->email = "demo@demo.com";
                $payment->user = $user->email;
                $payment->useravatar = $user->avatar();
            }
            return $payment;
        }) : [];

        $subscriptions = \Helpers\App::possible() ? DB::subscription()->orderByDesc('date')->limit(5)->map(function($subscription){
            if($user = User::where('id', $subscription->userid)->first()){
                if(_STATE == "DEMO") $user->email = "demo@demo.com";
                $subscription->user = $user->email;
                $subscription->useravatar = $user->avatar();
            }
            if($plan = DB::plans()->where('id', $subscription->planid)->first()){
                $subscription->plan = $plan->name;
            }
            return $subscription;
        }) : [];

        $counts = [];
        $counts['urls'] = ['name' => e('Links'), 'count' => DB::url()->count(), 'count.today' => DB::url()->whereRaw('`date` >= CURDATE()')->count()];
        $counts['users'] = ['name' => e('Users'), 'count' => DB::user()->count(), 'count.today' => DB::user()->whereRaw('`date` >= CURDATE()')->count()];

        if(\Helpers\App::possible()){
            $counts['subscriptions'] =['name' => e('Subscriptions'), 'count' => DB::subscription()->where('status', 'Active')->count(), 'count.today' => DB::subscription()->where('status', 'Active')->whereRaw('`date` >= CURDATE()')->count()];
            $counts['payments'] = ['name' => e('Payments'), 'count' => DB::payment()->where('status', 'Completed')->sum('amount'), 'count.today' => DB::payment()->where('status', 'Completed')->whereRaw('`date` >= CURDATE()')->sum('amount')];
        }

        View::set('title', e('Admin Dashboard'));
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        return View::with('admin.index', compact('urls', 'users', 'reports', 'payments', 'subscriptions', 'counts'))->extend('admin.layouts.main');
    }
    /**
     * Search database
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function search(Request $request){

        $urls = [];
        $users = [];
        $payments = [];
        $subscriptions = [];

        if(strlen($request->q) > 2) {

            if($request->type == 'links'){

                if(Helper::isURL($request->q)){
                    $request->q = trim(trim(Helper::parseUrl($request->q, 'path')), '/');
                }

                $urls = DB::url()->whereAnyIs([
                    ['url' => "%{$request->q}%"],
                    ['custom' => "%{$request->q}%"],
                    ['alias' => "%{$request->q}%"],
                    ['meta_title' => "%{$request->q}%"],
                ], 'LIKE ')->paginate(15);
            }
            if($request->type == 'users'){
                $users = DB::user()->whereAnyIs([
                    ['username' => "%{$request->q}%"],
                    ['email' => "%{$request->q}%"],
                ], 'LIKE ')->paginate(15);
            }

            if($request->type == 'payments'){

                foreach( DB::payment()->whereAnyIs([
                    ['tid' => "%{$request->q}%"],
                ], 'LIKE ')->paginate(15) as $payment){
                    $payment->user = User::where('id', $payment->userid)->first();
                    $payments[] = $payment;
                }
            }

            if($request->type == 'bio'){
                return Helper::redirect()->to(route('admin.bio', ['q' => $request->q]));
            }

            if($request->type == 'qr'){
                return Helper::redirect()->to(route('admin.qr', ['q' => $request->q]));
            }

            if(App::possible() && $request->type == 'subscriptions'){
                return Helper::redirect()->to(route('admin.subscriptions', ['q' => $request->q]));
            }
        }

        View::set('title', e('Search for ').$request->q);

        return View::with('admin.search', compact('urls', 'users', 'payments'))->extend('admin.layouts.main');
    }
    /**
     * Email page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function email(Request $request){

        $newsletterusers = DB::user()->where('newsletter', 1)->count();
        $activeusers = DB::user()->where('active', 1)->count();
        $allusers = DB::user()->count();

        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();
        \Helpers\CDN::load('editor');

        View::push("<script>
                        ClassicEditor.create( document.querySelector( '#editor' ))
                    </script>", "custom")->toFooter();

        return View::with('admin.email', compact('newsletterusers', 'activeusers', 'allusers'))->extend('admin.layouts.main');
    }
    /**
     * Send Email
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function emailSend(Request $request){

        if(!$request->sendto) return Helper::redirect()->back()->with('danger', e('Please add an email or a list to send emails.'));
        if(!$request->content || !$request->subject) return Helper::redirect()->back()->with('danger', e('You are trying to send an empty email'));

        $lists = explode(',', $request->sendto);
        $emails = [];

        if(in_array('list.newsletter', $lists)){
            foreach(DB::user()->where('newsletter', 1)->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        if(in_array('list.active', $lists)){
            foreach(DB::user()->where('active', 1)->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }


        if(in_array('list.all', $lists)){
            foreach(DB::user()->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        foreach($lists as $list){
            if(!Helper::Email($list)) continue;
            if(in_array($list, $emails)) continue;
            $emails[] = ['email' => $list];
        }

        $i = 0;
        foreach($emails as $email){

            $mailer = \Helpers\Emails::setup();

            $message = $request->content;

            if(isset($email['username'])){
                $message = str_replace("{username}", $email['username'], $message);
            }
            if(isset($email['email'])){
                $message = str_replace("{email}", $email['email'], $message);
            }
            if(isset($email['date'])){
                $message = str_replace("{date}", date("F-m-d H:i", strtotime($email['date'])), $message);
            }

            $mailer->to($email['email'])
                   ->send([
                       'subject' => Helper::clean($request->subject),
                       'message' => function($template, $data) use ($message) {

                            if(config('logo')){
                                $title = '<img align="center" alt="Image" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                            } else {
                                $title = '<h3>'.config('title').'</h3>';
                            }
                            return Email::parse($template, ['content' => $message, 'brand' => $title]);
                       }
                   ]);
            $i++;
        }

        return Helper::redirect()->back()->with('success', e('Emails were sent successfully to {n} emails.', null, ['n' => $i]));
    }
    /**
     * Update Email Templates
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.9
     * @param \Core\Request $request
     * @return void
     */
    public function emailTemplates(Request $request){

        if($request->isPost()){

            foreach ($request->all() as $key => $value) {
                $key = str_replace(["_","-"],".", $key);

                if(in_array($key, ["email.registration", "email.activation", "email.activated", "email.reset", "email.invitation"])){

                    $setting = DB::settings()->where('config', $key)->first();
                    $setting->var = $value;
                    $setting->save();
                }
            }

            return Helper::redirect()->back()->with('success', e('Emails templates were saved successfully.'));
        }

        View::set('title', e('Email Templates'));

        \Helpers\CDN::load('editor');
        View::push("<script>
                        ClassicEditor.create( document.querySelector('#editor'))
                        ClassicEditor.create( document.querySelector('#email-registration'));
                        ClassicEditor.create( document.querySelector('#email-activation'));
                        ClassicEditor.create( document.querySelector('#email-activated'));
                        ClassicEditor.create( document.querySelector('#email-reset'));
                        ClassicEditor.create( document.querySelector('#email-invitation'));
                    </script>", "custom")->toFooter();

        return View::with('admin.email_templates')->extend('admin.layouts.main');
    }
    /**
     * Update Script
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function update(Request $request){

        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to update the script.'));
        }

        if($request->newcode){
            \Gem::addMiddleware('DemoProtect');

            if(!\Helpers\App::license($request->newcode)) return Helper::redirect()->back()->with('danger', e('Please enter a valid purchase code.'));

            $setting = DB::settings()->where('config', 'purchasecode')->first();

            $setting->var = Helper::RequestClean($request->newcode);
            $setting->save();

            return Helper::redirect()->back()->with('success', e('Purchase code has been updated successfully.'));
        }

        $update = \Helpers\App::newUpdate(true);
        $log = \Helpers\App::updateChangelog();

        $changes = [];

        $label = ["Added" => "primary", "Improved" => "success", "Fixed" => "warning", "Removed" => "danger"];
        if($log){
            foreach($log->log as $change){
                $change->date = $log->date;
                $change->class = $label[$change->type];
                $changes[] = $change;
            }
        }

        View::set("title", e("Update Script"));

        return View::with('admin.update', compact('update', 'changes'))->extend('admin.layouts.main');
    }
    /**
     * Process Update
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function updateProcess(Request $request){

        $purchasecode = trim(Helper::RequestClean($request->code));

        $update = new \Helpers\Autoupdate($purchasecode);

        try {

            $update->install();

            $setting = DB::settings()->where('config', 'purchasecode')->first();

            $setting->var = $purchasecode;
            $setting->save();

            return Helper::redirect()->back()->with("success", e("Script has been successfully updated."));

        }catch(\Exception $e){
            return Helper::redirect()->back()->with("danger", $e->getMessage());
        }
    }
    /**
     * View PHP Info
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function phpinfo(){
        \Gem::addMiddleware('DemoProtect');
        return phpinfo();
    }

    /**
     * Cron Jobs
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function crons(){

        View::set('title', e('Cron Jobs'));

        return View::with('admin.crons')->extend('admin.layouts.main');
    }
    /**
     * Clear Logs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.7
     * @return void
     */
    public function cronsClear(){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to clear cron logs.'));
        }

        foreach([LOGS.'/Cron.users.log', LOGS.'/Cron.reminded.log', LOGS.'/Cron.data.log', LOGS.'/Cron.urls.log', LOGS.'/Cron.imports.log'] as $file){
            if(file_exists($file)) unlink($file);
        }

        return Helper::redirect()->back()->with('success', e('Cron logs were cleared successfully.'));
    }
}