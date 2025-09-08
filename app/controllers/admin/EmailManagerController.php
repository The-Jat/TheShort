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
use Core\Localization;
use Core\Plugin;
use Core\Email;

class EmailManager {
    
    /**
     * Send Emails
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view email settings.'));
        }

        $newsletterusers = DB::user()->where('newsletter', 1)->count();
        $activeusers = DB::user()->where('active', 1)->count();
        $inactiveusers = DB::user()->where('active', 0)->count();
        $freeusers = DB::user()->where('pro', 0)->count();
        $paidusers = DB::user()->where('pro', 1)->count();
        $allusers = DB::user()->count();

        View::set('title', e('Send Emails'));

        View::push(assets('frontend/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'), 'js')->toFooter();
        \Helpers\CDN::load('editor');
        if(request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true)){
            View::push('<style>
                :root{
                    --ck-color-base-background: #222e3c !important;
                    --ck-color-base-border: #0c0d0e !important;    
                    --ck-color-base-text: #fff !important;                
                }
            </style>', 'custom')->toHeader();
        }       
        View::push("<script>            
            ClassicEditor.create(document.querySelector('#editor'), editorConfig);
        </script>", "custom")->toFooter();   


        return View::with('admin.email', compact('newsletterusers', 'activeusers', 'allusers', 'freeusers', 'paidusers', 'inactiveusers'))->extend('admin.layouts.main');
    }
    /**
     * Send email
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @param \Core\Request $request
     * @return void
     */
    public function emailSend(Request $request){
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to send emails.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$request->sendto) return Helper::redirect()->back()->with('danger', e('Please add an email or a list to send emails.'));
        if(!$request->content || !$request->subject) return Helper::redirect()->back()->with('danger', e('You are trying to send an empty email'));

        $lists = explode(',', $request->sendto);
        $emails = [];
        $query = DB::user();

        if($request->country && $request->country !== 'all'){
            $query->whereRaw("address LIKE '%".Helper::clean($request->country, 3, true)."%'");
        }

        if(in_array('list.newsletter', $lists)){
            foreach($query->where('newsletter', 1)->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        if(in_array('list.active', $lists)){
            foreach($query->where('active', 1)->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        if(in_array('list.inactive', $lists)){
            foreach($query->where('active', 0)->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }


        if(in_array('list.all', $lists)){
            foreach($query->whereNotEqual('email', '')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        if(in_array('list.free', $lists)){
            foreach($query->where('pro', '0')->findMany() as $user){
                if(in_array($user->email, $emails)) continue;
                $emails[] = ['email' => $user->email, 'username' => $user->username, 'date' => $user->date];
            }
        }

        if(in_array('list.paid', $lists)){
            foreach($query->where('pro', '1')->findMany() as $user){
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
            
            if(in_array('list.newsletter', $lists)){
                $message .= '<p style="margin-top:15px;display:block;text-align:center"><small>'.e("Don't want to receive these e-mails?").' <br> <a href="'.route('unsubscribe', ['token' => base64_encode($email['email'])]).'" style="text-decoration:none" target="_blank">'.e('Unsubscribe').'</a></small></p>';
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
     * List Languages
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function templates(){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view email templates.'));
        }

        View::set('title', e('Email Templates'));
        
        $languages = [];

        foreach(Localization::list() as $lang){
            if(!file_exists($lang['path'].'/email.php')) continue;
            $data = include($lang['path'].'/email.php');
            $total = count($data['data']) > 0 ? count($data['data']) : 1;
            $filled = count(array_filter($data['data']));
            $data['percent'] = round(($filled / $total)*100, 1);
            $languages[] = $data;
        }
        
        
        $max = ini_get('max_input_vars');

        if($max < 1500) View::push('<script>$(\'.container-fluid\').prepend(\'<div class="card bg-danger card-body text-white">Your server can only support '.$max.' strings however the language file requires at least 1500. If you use this tool, some parts of the language file will not be added. You will need to set the php config called max_input_vars to 1500. If you cannot change your php config, you will need to manually translate the file.</div>\')</script>', 'custom')->toFooter();

        return View::with('admin.emails.index', compact('languages'))->extend('admin.layouts.main');
    }
    /**
     * New Email Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function new(){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view email templates.'));
        }

        View::set('title', e('New Email Translation'));

        $sample = include(LOCALE.'/email.php');

        $strings = $sample['data'];

        \Helpers\CDN::load('editor');
        if(request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true)){
            View::push('<style>
                :root{
                    --ck-color-base-background: #222e3c !important;
                    --ck-color-base-border: #0c0d0e !important;    
                    --ck-color-base-text: #fff !important;                
                }
            </style>', 'custom')->toHeader();
        }               
        View::push("<script>
                        ClassicEditor.create( document.querySelector('#editor'), editorConfig)
                        ClassicEditor.create( document.querySelector('#email-registration'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-activation'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-success'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-passwordreset'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-teaminvitation'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-verify2fa'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-newip'),editorConfig);                        
                    </script>", "custom")->toFooter();

        return View::with('admin.emails.new', compact('strings'))->extend('admin.layouts.main');
    }
    /**
     * Save File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function save(Request $request){
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit email templates.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!$request->name){
            return back()->with('danger', e('Please enter a name'));
        }
        
        if(!$request->code){
            $request->code = substr($request->name, 0, 2);
        }

        $request->code = strtolower($request->code);

        $lang = [    
            "code" => $request->code,
            "region" => $request->code,
            "name" => $request->name,
            "author" => config('title'),
            "link" => config('url'),
            "date" => Helper::dtime('now', 'd/m/Y')
        ];

        $lang['data'] = [];

        foreach($request->string as $base => $string){            
            $lang['data'][$base] = $string;
        }
        
        if(!file_exists(LOCALE.'/'.$request->code)){
            \mkdir(LOCALE.'/'.$request->code, 0777);
        }
        $data = var_export($lang, true);
        $file = fopen(LOCALE.'/'.$request->code.'/email.php', 'w') or die(back()->with('error', e('Cannot open file {f}. Please check permission.', null, ['f' => LOCALE.'/'.$request->code.'/app.php'])));

        fwrite($file, "<?php\n return {$data};");
        fclose($file);

        return Helper::redirect()->to(route('admin.email.template'))->with('success', e('Translation file successfully created.'));
    }
    /**
     * Update Email
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function edit(string $code){
        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view email templates.'));
        }

        if(!file_exists(LOCALE."/{$code}/email.php")) return Helper::redirect()->to(route('admin.email.template'))->with('danger', e('Language file does not exist.')); 

        $data = include(LOCALE."/{$code}/email.php");        

        View::set('title', e('Update Email Templates'));

        \Helpers\CDN::load('editor');
        if(request()->cookie('darkmode') || \Helpers\App::themeConfig('homestyle', 'darkmode', true)){
            View::push('<style>
                :root{
                    --ck-color-base-background: #222e3c !important;
                    --ck-color-base-border: #0c0d0e !important;    
                    --ck-color-base-text: #fff !important;                
                }
            </style>', 'custom')->toHeader();
        }               
        View::push("<script>
                        ClassicEditor.create( document.querySelector('#editor'), editorConfig)
                        ClassicEditor.create( document.querySelector('#email-registration'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-activation'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-success'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-passwordreset'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-teaminvitation'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-verify2fa'), editorConfig);
                        ClassicEditor.create( document.querySelector('#email-newip'),editorConfig);
                    </script>", "custom")->toFooter();

        return View::with('admin.emails.edit', $data)->extend('admin.layouts.main');        
    }
    /**
     * Update File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function update(Request $request, string $code){
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to edit email templates.'));
        }
        \Gem::addMiddleware('DemoProtect');

        if(!file_exists(LOCALE."/{$code}/email.php")) return Helper::redirect()->to(route('admin.email.template'))->with('danger', e('Language file does not exist.')); 

        $lang = [    
            "code" => strtolower($code),
            "region" => strtolower($code),
            "name" => $request->name,
            "author" => config('title'),
            "link" => config('url'),
            "date" => Helper::dtime('now', 'd/m/Y'),
        ];

        $lang['data'] = [];

        foreach($request->string as $base => $string){
            $lang['data'][$base] = $string;
        }

        if(!file_exists(LOCALE.'/'.$code)){
            \mkdir(LOCALE.'/'.$code, 0777);
        }
        $data = var_export($lang, true);
        $file = fopen(LOCALE.'/'.$code.'/email.php', 'w') or die(back()->with('error', e('Cannot open file {f}. Please check permission.', null, ['f' => LOCALE.'/'.$code.'/app.php'])));

        fwrite($file, "<?php\n return {$data};");
        fclose($file);

        return back()->with('success', e('Translation file successfully updated.'));
    }
    /**
     * Delete
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function delete(string $code, string $nonce){
        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to delete email templates.'));
        }
        \Gem::addMiddleware('DemoProtect');
        
        if(!Helper::validateNonce($nonce, 'template.delete')){
            return Helper::redirect()->to(route('admin.email.template'))->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        \unlink(LOCALE.'/'.$code.'/email.php');

        Plugin::dispatch('admin.language.deleted', ['language' => $code]);

        return Helper::redirect()->to(route('admin.email.template'))->with('success', e('Language has been successfully deleted.'));        
    }
}