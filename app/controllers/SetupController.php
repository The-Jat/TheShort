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
use Core\DB;
use Core\Helper;

class Setup {

    /**
     * Current version
     *
     * @author GemPixel <https://gempixel.com>
     */
    private $version = '7.8.4';

    /**
     * Error
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * 
     * 
     */
    private $error = false;
    private $warning = false;

    /**
     * Check if install is required
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function check(){

        if(file_exists(ROOT."/config.php")) return true;

        new self();

        return false;
    }
    /**
     * Upgrade
     *
     * @author GemPixel <https://gempixel.com>f
     * @version 6.0
     * @return void
     */
    public function __construct(){

        $request = new Request;

        $step = $request->segment(1);

        $fn = "step{$step}";

        if(!method_exists(__CLASS__, $fn)) return \GemError::cleanError(404, 'The page you are looking for cannot be found.', 404);

        $this->{$fn}($request);
    }

    /**
     * Step 1
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param Request $request
     * @return void
     */
    public function step(Request $request){

        $this->header($request);

        echo '<h2>Welcome</h2>
            '.message().'
            <p>Thanks for purchasing Premium URL Shortener. This installation wizard will accompany you in installing the product without hassle. You need to make sure that you meet the following requirements and you created a database.</p>
            <div class="content">
                <p>
                PHP Version<br>
                <small>Minimum PHP 8.2</small>
                '.$this->verify('version').'
                </p>
                <span class="info text-red '.(!$this->error ? 'hide': '').'">
                    It is very important to have at least PHP Version 8.2.
                </span>
            </div>
            <div class="content">
                <p>Filesystem</p>
                <ul>
                    <li>
                        <strong><i>config_sample.php</i> must be accessible</strong> '.$this->verify('config').'
                        <p class="info '.(!$this->error ? 'hide': '').'">
                            This installation will open that file to put values in so it must be accessible. Make sure that file is there in the root folder and is writable.
                        </p>
                    </li>
                    <li>
                        <strong><i>storage/</i> folder and its subfolder must be writable. </strong> '.$this->verify('storage').'
                        <p class="info '.(!$this->error ? 'hide': '').'">
                            Many things will be uploaded to that folder so please make sure it has the proper permission.
                        </p>
                    </li>
                    <li>
                        <strong><i>public/content/</i> folder must be writable and its subfolder must be writable.</strong> '.$this->verify('content').'
                        <p class="info '.(!$this->error ? 'hide': '').'">
                            Many things will be uploaded to that folder so please make sure it has the proper permission.
                        </p>
                    </li>
                </ul>
            </div>
            <div class="content">
                <p>Modules & Extensions</p>
                <ul>
                    <li>
                        <strong>PDO and MYSQL Driver</strong>'.$this->verify('pdo').'
                        <p class="info '.(!$this->error ? 'hide': '').'">
                            PDO driver is very important so it must enabled. Without this, the script will not connect to the database hence it will not work at all. If this verify fails, you will need to contact your web host and ask them to either enable it or configure it properly.
                        </p>
                    </li>
                    <li>
                        <strong>cURL</strong> '.$this->verify('curl').'
                        <p class="info '.(!$this->error ? 'hide': '').'">
                            cURL is used to interact with external servers and APIs.
                        </p>
                    </li>
                    <li>
                        <strong>Mbstring</strong> '.$this->verify('mbstring').'
                        <p class="info '.(!$this->error ? 'hide': '').'">
                            Mbstring is required for correct encoding.
                        </p>
                    </li>
                    <li>
                        <strong>GD Library</strong> '.$this->verify('gd').'
                        <p class="info '.(!$this->error ? 'hide': '').'">
                            GD library is needed to generate QRs.
                        </p>
                    </li>
                    <li>
                        <strong>ImageMagick</strong> '.$this->verify('imagick').'
                        <p class="info '.(!$this->warning ? 'hide': '').'">
                            ImageMagick library is not required and you can proceed with the installation. This extension is needed for server-side QR code processing. You can still generate QR codes without this extension but QR codes will be converted to other formats using the browser instead of the server. If you are installing it, please make sure to install Imagick version 7.1 and the RSVG delegate as these are required. You can find more info on our <a href="https://gempixel.com/solutions/how-to-install-latest-imagemagick-imagick-on-ubuntu" target="_blank">guide</a>.
                        </p>
                    </li>
                </ul>
            </div>';
            if(!$this->error) echo '<p><a href="database" class="button"><span>Proceed</span> <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg></a></p>';
        $this->footer();
    }
    /**
     * Dump Database
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function stepdatabase(Request $request){

        if($request->isPost()){

            $this->error = '';

            if(!$request->host){
                $this->error .= 'Please enter a database host.<br>';
            }

            if(!$request->name){
                $this->error .= 'Please enter a database name.<br>';
            }

            if(!$request->user){
                $this->error .= 'Please enter a database user.<br>';
            }

            if($this->error || !empty($this->error)){

                \Core\Helper::setMessage('danger', $this->error);

            } else {

                try{

                    new PDO("mysql:host=".$request->host.";dbname=".$request->name."", $request->user, $request->pass);

                    $this->generateConfig($request);

                    $this->dump($request);

                    \Core\Helper::setMessage('success', 'Database successfully installed.');

                    return \Core\Helper::redirect()->to('user');

                }catch (PDOException $e){
                    \Core\Helper::setMessage('danger', $e->getMessage());
                }

            }

        }


        $this->header($request);

        echo '<h2>Database Configuration</h2>
        '.message().'
        <p>
            Now you have to set up your database by filling the following fields. Make sure you fill them correctly.
        </p>
        <form method="post" action="" class="form" autocomplete="off">
            <div class="group">
                <label>Database Host <a>Usually it is localhost.</a></label>
                <input type="text" name="host" class="input" placeholder="e.g. localhost">

                <label>Database Name</label>
                <input type="text" name="name" class="input" placeholder="e.g. dbname" required>

                <label>Database User </label>
                <input type="text" name="user" class="input" placeholder="e.g. dbuser" required>

                <label>Database Password</label>
                <input type="password" name="pass" class="input">

                <label>Database Prefix <a>Prefix for your tables (Optional) e.g. short_</a></label>
                <input type="text" name="prefix" class="input" value="">

                <label>Security Key <a>Keep this secret!</a></label>
                <input type="text" name="key" class="input" value="'."PUS".md5(rand(0,100000)).md5(time()).'">
            </div>
            <button type="submit" class="button"><span>Proceed</span> <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg></button>
        </form>';
        $this->footer();
    }
    /**
     * Setup user
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function stepuser(Request $request){

        if($request->isPost()){

            $this->error = '';

            if(!$request->email || !$request->validate($request->email, 'email')){
                $this->error .= 'Please enter a valid email.<br>';
            }

            if(!$request->username || !$request->validate($request->username, 'username')){
                $this->error .= 'Please enter a username.<br>';
            }

            if(!$request->pass || strlen($request->pass) < 5){
                $this->error .= 'Please enter use a password that is more than 5 characters.<br>';
            }

            if($this->error || !empty($this->error)){

                \Core\Helper::setMessage('danger', $this->error);

            } else {

                try{

                    include(ROOT."/config.sample.php");

                    DB::Connect();

                    DB::settings()->where('config', 'url')->update(['var' => $request->url]);

                    $user = DB::user()->create();

                    $user->email = $request->email;
                    Helper::set('hashCost', 8);
                    $user->password = Helper::Encode($request->pass);
                    $user->username = trim($request->username);
                    $user->admin = 1;
                    $user->date = Helper::dtime();

                    $user->api = Helper::rand(32);
                    $user->uniquetoken = Helper::rand(32);
                    $user->public = 0;
                    $user->auth_key = Helper::Encode($user->email.Helper::dtime());

                    $user->save();

                    $request->save('username', clean($request->username));
                    $request->save('email', clean($request->email));
                    $request->save('password', clean($request->pass));
                    $request->save('site', clean($request->url));

                    \Core\Helper::setMessage('success', 'Admin successfully created.');

                    return \Core\Helper::redirect()->to('final');

                }catch (PDOException $e){
                    \Core\Helper::setMessage('danger', $e->getMessage());
                }

            }

        }

        $this->header($request);

        echo '<h2>Admin Account</h2>
            '.message().'
            <p>
                Now you have to create an admin account by filling the fields below. Make sure to add a valid email and a strong password. For the site URL, make sure to remove the last slash.
            </p>
            <form method="post" action="" class="form" autocomplete="off">
                <div class="group">
                    <label>Admin Email</label>
                    <input type="email" name="email" class="input" required>

                    <label>Admin Username</label>
                    <input type="text" name="username" class="input" minlenght="3" required>

                    <label>Admin Password (min 5 characters)</label>
                    <input type="password" name="pass" class="input" minlength="5" required>

                    <label>Site URL <a>Including http:// or https:// but without the ending slash "/"</a></label>
                    <input type="text" name="url" class="input" value="'.str_replace('/user', '', $request->uri()).'" placeholder="http:// or https://" required>
                    <p><strong>Double check to make sure the url is correct. If you have SSL enabled, please make sure the schema is https:// and not http://</strong></p>
                </div>
                <button type="submit" class="button"><span>Proceed</span> <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg></button>
            </form>';
        $this->footer();
    }
    /**
     * Final Step
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    private function stepfinal($request){

        rename(ROOT."/config.sample.php", ROOT."/config.php");

        $this->header($request);

        echo''.message().'<p>
                The script has been successfully installed and your admin account has been created. All you have to do is to go to your main site, login using the info below and configure your site by clicking the "Admin" menu and then "Settings". Thanks for your purchase and enjoy!
            </p>
            <p>
            <strong>Login URL: <a href="'.old('site').'/user/login" target="_blank">'.old('site').'/user/login</a></strong> <br />
            <strong>Email: '.old('email').'</strong> <br />
            <strong>Username: '.old('username').'</strong> <br />
            <strong>Password: '.old('password').'</strong>
            </p>
            <p><a href="'.old('site').'" class="button"><span>Visit your site</span> <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg></a></p>';
        $this->footer();
    }
    /**
     * Verify
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $module
     * @return void
     */
    private function verify($module){
        switch ($module) {
            case 'version':
                if(PHP_VERSION >= "8.2"){
                    return "<span class='ok'>You have ".PHP_VERSION."</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>You have ".PHP_VERSION."</span>";
                }
                break;
            case 'config':
                if(@file_get_contents(ROOT.'/config.sample.php') && is_writable(ROOT.'/config.sample.php')){
                    return "<span class='ok'>Writable</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>Not writable</span>";
                }
                break;
            case 'storage':
                    if(is_writable(STORAGE)){
                        return "<span class='ok'>Writable</span>";
                    }else{
                        $this->error = true;
                        return "<span class='fail'>Not writable</span>";
                    }
                    break;
            case 'content':
                if(is_writable(UPLOADS)){
                    return "<span class='ok'>Writable</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>Not Writable</span>";
                }
                break;
            case 'pdo':
                if(defined('PDO::ATTR_DRIVER_NAME') && class_exists("PDO") && (extension_loaded('pdo_mysql') || extension_loaded('nd_pdo_mysql'))){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>Disabled</span>";
                }
                break;
            case 'file':
                if(ini_get('allow_url_fopen')){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    return "<span class='warning'>Disabled</span>";
                }
                break;
            case 'curl':
                if(extension_loaded('curl')){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>Disabled</span>";
                }
                break;
            case 'mbstring':
                if(extension_loaded('mbstring')){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>Disabled</span>";
                }
                break;
            case 'gd':
                if(extension_loaded('gd')){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    $this->error = true;
                    return "<span class='fail'>Disabled</span>";
                }
                break;
            case 'imagick':
                if(extension_loaded('imagick')){
                    return "<span class='ok'>Enabled</span>";
                }else{
                    $this->warning = true;
                    return "<span class='warning'>Disabled</span>";
                }
                break;
        }
    }
    /**
     * Generate Config File
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    private function generateConfig($request){

        $file = file_get_contents(ROOT.'/config.sample.php');
	    $file = str_replace("__HOST__", trim($request->host), $file);
	    $file = str_replace("__DB__", trim($request->name), $file);
	    $file = str_replace("__USER__", trim($request->user), $file);
	    $file = str_replace("__PASS__", trim($request->pass), $file);
	    $file = str_replace("__PRE__", trim($request->prefix), $file);
	    $file = str_replace("__PUB__", md5(rand(100000, 1000000).time()), $file);

        $file = str_replace("__ENC__", \Defuse\Crypto\Key::createNewRandomKey()->saveToAsciiSafeString(), $file);
	    $file = str_replace("__KEY__", trim($request->key), $file);

	    $fh = fopen(ROOT.'/config.sample.php', 'w') or die("Can't open config.sample.php. Make sure it is writable.");

	    fwrite($fh, $file);
	    fclose($fh);
    }
    /**
     * Dump Database
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    private function dump($request){

        include(ROOT."/config.php");

        DB::Connect();

        \Core\Support\ORM::configure('id_column_overrides', array(
			DBprefix.'settings'  => 'config'
		));        

        DB::schema('subscription', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('tid', 191)->index();
            $table->bigint('userid')->index();
            $table->string('plan', 191);
            $table->bigint('planid')->index();
            $table->string('status', 191);
            $table->double('amount', '10,2');
            $table->timestamp('date');
            $table->timestamp('expiry', null);
            $table->timestamp('lastpayment', null);
            $table->text('data');
            $table->string('uniqueid', 191)->index();
            $table->bigint('coupon', null);
            $table->bigint('customerid', null);
        });

        DB::schema('oauth_clients', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('user_id')->index();
            $table->string('name', 191);
            $table->string('client_id', 80)->unique();
            $table->string('client_secret', 100);
            $table->text('redirect_uri');
            $table->timestamp('created_at');
        });

        DB::schema('oauth_access_tokens', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('user_id')->index();
            $table->integer('client_id');
            $table->string('name', 191);
            $table->string('code', 191);
            $table->string('token', 191);
            $table->text('scopes');
            $table->timestamp('created_at');
            $table->timestamp('expires_at', null);
        });

        DB::schema('apikeys', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('apikey',  191, null)->index();
            $table->string('description',  191, null);
            $table->text('permissions');
            $table->timestamp('created_at');
        });

        DB::schema('ads', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->string('type')->index();
            $table->text('code');
            $table->integer('impression');
            $table->integer("enabled", null, '1');
        });

        DB::schema('affiliates', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->integer("refid")->index();
            $table->integer("userid")->index();
            $table->double('amount', '10,2');
            $table->timestamp('referred_on');
            $table->timestamp('paid_on', null);
            $table->integer("status", null, '0');
        });

        DB::schema('appevents', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->bigint('planid')->index();
            $table->string('type',  191, null)->index();
            $table->string('handler', 191, null);
            $table->text('data');
            $table->int("status", null, '0');
            $table->timestamp('created_at');
            $table->timestamp('expires_at', null);
        });

        DB::schema('bundle', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->string('slug')->index();
            $table->bigint('userid')->index();
            $table->timestamp('date');
            $table->string('access', 10, 'private');
            $table->string('domain', 191, null);
            $table->integer("view", null, '0');
        });

        DB::schema('coupons', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->text('description');
            $table->string('code')->index();
            $table->integer('discount');
            $table->timestamp('date');
            $table->integer('used', null, '0');
            $table->integer('maxuse', null, '0');
            $table->timestamp('validuntil', null);
            $table->text('data');
        });

        DB::schema('channels', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string("name");
            $table->string("description");
            $table->string("color");
            $table->int("starred", null, '0');
            $table->timestamp('created_at');
        });

        DB::schema('tochannels', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->bigint('itemid')->index();
            $table->bigint('channelid')->index();
            $table->string("type", 255, 'links');
            $table->timestamp('created_at');
        });

        DB::schema('domains', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('domain')->index();
            $table->string('redirect');
            $table->string('redirect404');
            $table->bigint('bioid');
            $table->int("status", null, '1');
        });

        DB::schema('faqs', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('lang', 10, 'en');
            $table->string('slug')->index();
            $table->string('category')->index();
            $table->text('question');
            $table->text('answer');
            $table->integer('views', null, '0');
            $table->int('pricing', null, '0');
            $table->timestamp('created_at');
        });

        DB::schema('overlay', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('name');
            $table->string('type', 191, 'message')->index();
            $table->text('data');
            $table->timestamp('date');
        });
        DB::schema('members', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('teamid')->index();
            $table->bigint('userid')->index();
            $table->string("token", 191, null)->index();
            $table->text("permission");
            $table->int("status", null, '0');
            $table->timestamp('created_at');
        });

        DB::schema('imports', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string("filename");
            $table->text("data");
            $table->bigint("processed", null, '0');
            $table->int("status", null, '0');
            $table->timestamp('created_at');
        });
        DB::schema('page', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('lang', 10, 'en');
            $table->string('name');
            $table->string('category');
            $table->string('seo')->index();
            $table->text('content');
            $table->text('metadata');
            $table->int('menu', null, '1');
            $table->timestamp('lastupdated');
        });

        DB::schema('payment', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('tid')->index();
            $table->bigint('userid')->index();
            $table->string('status');
            $table->double('amount', '10,2');
            $table->timestamp('date');
            $table->datetime('expiry', null);
            $table->int('trial_days');
            $table->text('data');
        });

        DB::schema('pixels', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('type')->index();
            $table->string('name');
            $table->text('tag');
            $table->timestamp('created_at');
        });

        DB::schema('paramtemplates', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('name');
            $table->text('data');
            $table->timestamp('created_at');
        });

        DB::schema('plans', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->string('slug')->index();
            $table->text('description');
            $table->string('icon');
            $table->int('trial_days');
            $table->double('price_monthly', '10,2');
            $table->double('price_yearly', '10,2');
            $table->double('price_lifetime', '10,2');
            $table->int('free', null, '0');
            $table->bigint('numurls');
            $table->bigint('numclicks');
            $table->integer('retention');
            $table->text('permission');
            $table->int('status', null, '0');
            $table->int('hidden', 1, '0');
            $table->string('stripeid');
            $table->string('counttype', 191, 'total');
            $table->string('qrcounttype', 191, 'total');
            $table->int('ispopular', null, '0');
            $table->text('data');
        });

        DB::schema('postcategories', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string("name");
            $table->string("slug")->index();
            $table->string("icon");
            $table->string("color", 6);
            $table->string("lang", 10, 'en');
            $table->text("description");
            $table->int("status", null, '1');
            $table->timestamp('created_at');
        });

        DB::schema('posts', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->integer('userid', null, '1')->index();
            $table->integer('categoryid', null)->index();
            $table->string('lang', 10, 'en');
            $table->string('title');
            $table->text('content');
            $table->string('slug')->index();
            $table->timestamp('date');
            $table->bigint('views', null, '0');
            $table->string('image');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->int('published', null, '1');
        });

        DB::schema('profiles', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('alias')->index();
            $table->string('name');
            $table->bigint('urlid')->index();
            $table->text('data');
            $table->text('responses');
            $table->int('status', null, '1');
            $table->timestamp('created_at');
        });

        DB::schema('qrs', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('alias')->index();
            $table->string('name');
            $table->string('filename');
            $table->bigint('urlid')->index();
            $table->text('data');
            $table->int('status', null, '1');
            $table->timestamp('created_at');
        });

        DB::schema('qrtemplates', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name', 191);
            $table->text('description');
            $table->text('data');
            $table->string('filename', 191);
            $table->int('paidonly', null, '0');
            $table->int('status', null, '1');
            $table->timestamp('created_at');
        });

        DB::schema('reports', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->text('url');
            $table->text('bannedlink');
            $table->string('type');
            $table->string('ip');
            $table->string('email');
            $table->timestamp('date');
            $table->int('status', null, '0');
        });

        DB::schema('roles', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name', 191);
            $table->text('description');
            $table->text('permissions');
            $table->timestamp('created_at');
        });

        $role = DB::roles()->create();
        $role->name = 'Super Administrator';
        $role->description = 'Super Administrator is the highest role and has access to everything.';
        $role->permissions = null;
        $role->created_at = date('Y-m-d H:i:s');
        $role->save();

        DB::schema('settings', function($table){
            $table->charset("utf8mb4");
            $table->string('config', 191, false)->primary();
            $table->text('var');
        });

        DB::schema('taxrates', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string("name");
            $table->double('rate', '10,2');
            $table->int('exclusive', '1', '1');
            $table->text('countries');
            $table->text('data');
            $table->int("status", null, '0');
        });

        $settings = ['url' => '','title' => '','sitename' => '', 'description' => '','api' => '1','user' => '1','sharing' => '1','geotarget' => '1','adult' => '1','maintenance' => '0','keywords' => '','theme' => 'the23','apikey' => '','ads' => '1','captcha' => '0','ad728' => '','ad468' => '','ad300' => '','frame' => '0','facebook' => '','twitter' => '','email' => '','fb_connect' => '0','analytic' => '','private' => '0','facebook_app_id' => '','facebook_secret' => '','twitter_key' => '','twitter_secret' => '','safe_browsing' => '','captcha_public' => '','captcha_private' => '','tw_connect' => '0','multiple_domains' => '0','domain_names' => '','tracking' => '1','update_notification' => '1','default_lang' => '','user_activate' => '0','domain_blacklist' => '','keyword_blacklist' => '','user_history' => '0','show_media' => '0','paypal_email' => '','logo' => '','timer' => '','smtp' => '','style' => '','font' => '','currency' => 'USD','gl_connect' => '0','require_registration' => '0','phish_api' => '','aliases' => '','pro' => '0','google_cid' => '','google_cs' => '','public_dir' => '0','devicetarget' => '1','homepage_stats' => '1','home_redir' => '','detectadblock' => '0','timezone' => '','freeurls' => '10','allowdelete' => '1','serverip' => '','favicon' => '','advanced' => '0','alias_length' => '5','theme_config' => '{"homeheader":"","homedescription":"","homestyle":"dark"}','schemes' => 'https,ftp,http','blog' => '1','root_domain' => '1','slackclientid' => '','slacksecretid' => '','slackcommand' => '','slacksigningsecret' => '','contact' => '1','report' => '1','customheader' => '','customfooter' => '','saleszapier' => '','pppublic' => '','ppprivate' => '','manualapproval' => '0','version' => $this->version,'faqcategories' => '{}','invoice' => '{"header":"","footer":""}','virustotal' => '{"key":"","limit":"2"}','affiliate' => '{"enabled":"0","rate":"30","payout":"10","terms":"terms of affiliate","freq":"once","type":"percent"}','paypal' => '{"enabled":"0","email":""}','testimonials' => '[]', 'cookieconsent' => '{"enabled":"0","message":"", "link":""}', 'plugins' => '{}', 'sociallinks' => '{"instagram":"","linkedin":""}', 'deepl' => '{"enabled":"0","key":"", "limit":""}', 'verification' => '0', 'gravatar' => 1, 'helpcenter' => '1', 'cdn' => json_encode(['enabled' => false, 'provider' => null, 'key' => null, 'secret' => null, 'region' => null, 'bucket' => null, 'url' => null]), 'customplan' => 1, "system_registration" => 1, 'altlogo' => '', 'publicqr' => false, 'qrlogo' => '', 'userlogging' => '0', 'bio' => json_encode(['blocked' => []]), 'verifylink' => '0', 'sizes' => json_encode(['avatar' => 500,'bio' => ['avatar' => 500,'background' => 1024,'image' => 500,'link' => 500,'banner' => 1024],'splash' => ['avatar' => 500,'banner' => 1024,],'qrfile' => 2048,'qrcsv' => 1024]), 'extensions' => json_encode(['avatar' => implode(',', ['jpg', 'png', 'jpeg']),'bio' => ['avatar' => implode(',', ['jpg', 'png', 'jpeg']),'background' => implode(',',['jpg', 'png', 'jpeg']),'image' => implode(',',['jpg', 'png', 'jpeg']),'link' => implode(',',['jpg', 'png', 'jpeg', 'gif']), 'banner' => implode(',', ['jpg', 'png', 'jpeg'])],'splash' => ['avatar' => implode(',',['jpg', 'png', 'jpeg', 'gif']),'banner' => implode(',',['jpg', 'png', 'jpeg'])]]), 'imagemagick' => class_exists('Imagick', false), 'email2fa' => false];

        foreach($settings as $config => $var){
            $query = DB::settings()->create();
            $query->config = $config;
            $query->var = $var;
            $query->save();
        }

        DB::schema('splash', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('name');
            $table->text('data');
            $table->timestamp('date');
        });

        DB::schema('stats', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('short');
            $table->bigint('urlid')->index();
            $table->bigint('urluserid', null, '0');
            $table->timestamp('date');
            $table->string('ip')->index();
            $table->string('country')->index();
            $table->string('city')->index();
            $table->string('language')->index();
            $table->string('domain')->index();
            $table->text('referer');
            $table->string('browser')->index();
            $table->string('os')->index();
        });

        DB::schema('biotemplates', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('profileid')->index();
            $table->string('name', 191);
            $table->text('description');
            $table->text('data');
            $table->text('planids');
            $table->string('preview', 191);
            $table->int('status', null, '1');
            $table->timestamp('created_at');
        });

        DB::schema('themes', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string("name", 191, null)->index();
            $table->string("description", 191, null)->index();
            $table->text("data");
            $table->int("paidonly", null, '0');
            $table->text('planids');
            $table->int("status", null, '0');
            $table->timestamp('created_at');
        });

        $themes = [
            [                
                'name' => 'Notepad',
                'description' => 'A modern theme on a notebook style background',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"body {\\r\\n   background-color: #fdfdfe !important;\\r\\n   opacity: 1 !important;\\r\\n   background-size: 20px 20px !important;\\r\\n   background-image:  repeating-linear-gradient(0deg, #e0e0e0, #e0e0e0 1px, #fdfdfe 1px, #fdfdfe) !important;\\r\\n}","textcolor":"#000000","buttoncolor":"#ffa500","buttontextcolor":"#ffffff","buttonstyle":"rectangular","shadow":"none","shadowcolor":"#bb7900","frost":0}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Animated Gradient',
                'description' => 'An smooth animated theme with frosted buttons',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"body {\\r\\n\\tbackground: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);\\r\\n\\tbackground-size: 400% 400%;\\r\\n\\tanimation: gradient 15s ease infinite;\\r\\n}\\r\\n@keyframes gradient {\\r\\n\\t0% {\\r\\n\\t\\tbackground-position: 0% 50%;\\r\\n\\t}\\r\\n\\t50% {\\r\\n\\t\\tbackground-position: 100% 50%;\\r\\n\\t}\\r\\n\\t100% {\\r\\n\\t\\tbackground-position: 0% 50%;\\r\\n\\t}\\r\\n}","textcolor":"#ffffff","buttoncolor":"#ffffff","buttontextcolor":"#000000","buttonstyle":"rounded","shadow":"none","shadowcolor":"#ababab","frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Isometric',
                'description' => 'A cool theme with an isometric background',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"body {\\r\\n\\t\\tbackground-color: #fdfdfe !important;\\r\\n\\t\\topacity: 1 !important;\\r\\n\\t\\tbackground-image:  linear-gradient(30deg, #e0e0e0 12%, transparent 12.5%, transparent 87%, #e0e0e0 87.5%, #e0e0e0), linear-gradient(150deg, #e0e0e0 12%, transparent 12.5%, transparent 87%, #e0e0e0 87.5%, #e0e0e0), linear-gradient(30deg, #e0e0e0 12%, transparent 12.5%, transparent 87%, #e0e0e0 87.5%, #e0e0e0), linear-gradient(150deg, #e0e0e0 12%, transparent 12.5%, transparent 87%, #e0e0e0 87.5%, #e0e0e0), linear-gradient(60deg, #e0e0e077 25%, transparent 25.5%, transparent 75%, #e0e0e077 75%, #e0e0e077), linear-gradient(60deg, #e0e0e077 25%, transparent 25.5%, transparent 75%, #e0e0e077 75%, #e0e0e077) !important;\\r\\n\\t\\tbackground-size: 20px 35px !important;\\r\\n\\t\\tbackground-position: 0 0, 0 0, 10px 18px, 10px 18px, 0 0, 10px 18px !important;\\r\\n}\\r\\n","textcolor":"#000000","buttoncolor":"#ffffff","buttontextcolor":"#000000","buttonstyle":"rounded","shadow":"soft","shadowcolor":"#c1c1c1","frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Coil',
                'description' => 'A modern with a coil background',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"body {\\r\\n\\tbackground-color: #e9edf1 !important;\\r\\n\\tbackground-image:  url(\\"data:image\\/svg+xml,%3Csvg xmlns=\'http:\\/\\/www.w3.org\\/2000\\/svg\' version=\'1.1\' xmlns:xlink=\'http:\\/\\/www.w3.org\\/1999\\/xlink\' xmlns:svgjs=\'http:\\/\\/svgjs.dev\\/svgjs\' viewBox=\'0 0 800 800\'%3E%3Cdefs%3E%3ClinearGradient x1=\'50%25\' y1=\'0%25\' x2=\'50%25\' y2=\'100%25\' id=\'cccoil-grad\'%3E%3Cstop stop-color=\'hsl(206  75%25  49%25)\' stop-opacity=\'1\' offset=\'0%25\'%3E%3C\\/stop%3E%3Cstop stop-color=\'hsl(331  90%25  56%25)\' stop-opacity=\'1\' offset=\'100%25\'%3E%3C\\/stop%3E%3C\\/linearGradient%3E%3C\\/defs%3E%3Cg stroke=\'url(%23cccoil-grad)\' fill=\'none\' stroke-linecap=\'round\'%3E%3Ccircle r=\'363\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'1939 2281\' transform=\'rotate(360  400  400)\' opacity=\'0.05\'%3E%3C\\/circle%3E%3Ccircle r=\'346.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'1762 2177\' transform=\'rotate(343  400  400)\' opacity=\'0.10\'%3E%3C\\/circle%3E%3Ccircle r=\'330\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'1595 2073\' transform=\'rotate(326  400  400)\' opacity=\'0.14\'%3E%3C\\/circle%3E%3Ccircle r=\'313.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'1435 1970\' transform=\'rotate(309  400  400)\' opacity=\'0.19\'%3E%3C\\/circle%3E%3Ccircle r=\'297\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'1284 1866\' transform=\'rotate(291  400  400)\' opacity=\'0.23\'%3E%3C\\/circle%3E%3Ccircle r=\'280.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'1141 1762\' transform=\'rotate(274  400  400)\' opacity=\'0.28\'%3E%3C\\/circle%3E%3Ccircle r=\'264\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'1007 1659\' transform=\'rotate(257  400  400)\' opacity=\'0.32\'%3E%3C\\/circle%3E%3Ccircle r=\'247.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'881 1555\' transform=\'rotate(240  400  400)\' opacity=\'0.37\'%3E%3C\\/circle%3E%3Ccircle r=\'231\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'764 1451\' transform=\'rotate(223  400  400)\' opacity=\'0.41\'%3E%3C\\/circle%3E%3Ccircle r=\'214.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'655 1348\' transform=\'rotate(206  400  400)\' opacity=\'0.46\'%3E%3C\\/circle%3E%3Ccircle r=\'198\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'554 1244\' transform=\'rotate(189  400  400)\' opacity=\'0.50\'%3E%3C\\/circle%3E%3Ccircle r=\'181.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'462 1140\' transform=\'rotate(171  400  400)\' opacity=\'0.55\'%3E%3C\\/circle%3E%3Ccircle r=\'165\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'378 1037\' transform=\'rotate(154  400  400)\' opacity=\'0.59\'%3E%3C\\/circle%3E%3Ccircle r=\'148.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'302 933\' transform=\'rotate(137  400  400)\' opacity=\'0.64\'%3E%3C\\/circle%3E%3Ccircle r=\'132\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'235 829\' transform=\'rotate(120  400  400)\' opacity=\'0.68\'%3E%3C\\/circle%3E%3Ccircle r=\'115.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'176 726\' transform=\'rotate(103  400  400)\' opacity=\'0.73\'%3E%3C\\/circle%3E%3Ccircle r=\'99\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'126 622\' transform=\'rotate(86  400  400)\' opacity=\'0.77\'%3E%3C\\/circle%3E%3Ccircle r=\'82.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'84 518\' transform=\'rotate(69  400  400)\' opacity=\'0.82\'%3E%3C\\/circle%3E%3Ccircle r=\'66\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'50 415\' transform=\'rotate(51  400  400)\' opacity=\'0.86\'%3E%3C\\/circle%3E%3Ccircle r=\'49.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'25 311\' transform=\'rotate(34  400  400)\' opacity=\'0.91\'%3E%3C\\/circle%3E%3Ccircle r=\'33\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'8 207\' transform=\'rotate(17  400  400)\' opacity=\'0.95\'%3E%3C\\/circle%3E%3Ccircle r=\'16.5\' cx=\'400\' cy=\'400\' stroke-width=\'7\' stroke-dasharray=\'0 104\' opacity=\'1.00\'%3E%3C\\/circle%3E%3C\\/g%3E%3C\\/svg%3E\\") !important;\\r\\n}","textcolor":"#000000","buttoncolor":"#000000","buttontextcolor":"#ffffff","buttonstyle":"rounded","shadow":"none","shadowcolor":null,"frost":1,"font":"Inter"}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Cyberpunk',
                'description' => 'A cyberpunk theme',
                'data' => '{"bgtype":"image","singlecolor":"#7f2aeb","gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":"cyberpunk-biopage.png","customcss":null,"textcolor":"#e95fdf","buttoncolor":"#e95fdf","buttontextcolor":"#ffffff","buttonstyle":"rectangular","shadow":"hard","shadowcolor":"#000000","font":"Coda","frost":0}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1
            ],
            [                
                'name' => 'Floating Bubbles',
                'description' => '',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"@keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } } body { background: linear-gradient( to bottom, #4facfe 0%, #00f2fe 100% );  position: relative; } body::before, body::after { content: \'\'; position: absolute; background: rgba(255,255,255,0.1); border-radius: 50%; animation: float 6s ease-in-out infinite; z-index:-1} body::before { width: 200px; height: 200px; left: 20%; bottom: 20%; } body::after { width: 300px; height: 300px; right: 20%; top: 20%; animation-delay: 2s; }","textcolor":"#ffffff","buttoncolor":"#ffffff","buttontextcolor":"#0070cc","buttonstyle":"rounded","shadow":"soft","shadowcolor":"#0987cf","font":"Inter","frost":0}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Ocean Wave',
                'description' => '',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"@keyframes wave { 0% { transform: translateX(0) translateY(0); } 50% { transform: translateX(-25%) translateY(-10px); } 100% { transform: translateX(-50%) translateY(0); } } body { background: linear-gradient( to bottom, #4facfe 0%, #00f2fe 100% ); position: relative;} body::before { content: \'\'; position: absolute; width: 100%; height: 100%; background: radial-gradient( circle, rgba(255,255,255,0.1) 10%, transparent 10%), radial-gradient( circle, rgba(255,255,255,0.1) 10%, transparent 10% ); background-size: 60px 60px; background-position: 0 0, 30px 30px; animation: wave 20s linear infinite;  z-index:-1;}","textcolor":"#ffffff","buttoncolor":"#ffffff","buttontextcolor":"#000000","buttonstyle":"rounded","shadow":"none","shadowcolor":null,"font":null,"frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Clean Gray',
                'description' => '',
                'data' => '{"bgtype":"single","singlecolor":"#eceef1","gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":null,"textcolor":"#000000","buttoncolor":"#ffffff","buttontextcolor":"#000000","buttonstyle":"rectangular","shadow":"none","shadowcolor":null,"font":null,"frost":0}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Floating Hearts',
                'description' => '',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"@keyframes float-heart { 0% { transform: translateY(-50px) scale(0); opacity: 0; } 50% { opacity: 1; } 100% { transform: translateY(-300px) scale(1); opacity: 0; } } body { background: linear-gradient( to bottom, #FFE5EC 0%, #FFC2D1 100% ); position: relative; } body::before, body::after { content: \'\\ud83d\\udc95\'; position: absolute; bottom: 10px; font-size: 40px; animation: float-heart 8s ease-in-out infinite; } body::before { left: 30%; } body::after { right: 25%; animation-delay: 3s; }","textcolor":"#ff0045","buttoncolor":"#ffffff","buttontextcolor":"#ff0045","buttonstyle":"rounded","shadow":"soft","shadowcolor":"#fb9fb8","font":null,"frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Pulsating Starfield',
                'description' => '',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"@keyframes pulse { 0%, 100% { opacity: 0.6; } 50% { opacity: 1; } } body { background: radial-gradient( circle at 20% 50%, rgba(120,119,198,0.3), transparent ), radial-gradient( circle at 80% 80%, rgba(255,110,127,0.3), transparent ), radial-gradient( circle at 40% 20%, rgba(138,180,248,0.3), transparent ), #0f0c29; animation: pulse 8s ease-in-out infinite; }","textcolor":"#ffffff","buttoncolor":"#000000","buttontextcolor":"#ffffff","buttonstyle":"rectangular","shadow":"none","shadowcolor":null,"font":null,"frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Luxury Cross',
                'description' => '',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"body{\\r\\nbackground-color: #453630;\\r\\nbackground: radial-gradient(circle, transparent 20%, #453630 20%, #453630 80%, transparent 80%, transparent), radial-gradient(circle, transparent 20%, #453630 20%, #453630 80%, transparent 80%, transparent) 25px 25px, linear-gradient(#9B7E4B 2px, transparent 2px) 0 -1px, linear-gradient(90deg, #9B7E4B 2px, #453630 2px) -1px 0;\\r\\nbackground-size: 50px 50px, 50px 50px, 25px 25px, 25px 25px;\\r\\n}","textcolor":"#ffffff","buttoncolor":"#9b7e4b","buttontextcolor":"#ffffff","buttonstyle":"rectangular","shadow":"soft","shadowcolor":"#382506","font":"Inter","frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Sunset Florida',
                'description' => '',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"body{\\r\\nbackground-color: #C4ECF8;\\r\\nbackground-image:  repeating-radial-gradient( circle at 0 0, transparent 0, #C4ECF8 10px ), repeating-linear-gradient( #FAB79655, #FAB796 );\\r\\n}","textcolor":"#000000","buttoncolor":"#ffffff","buttontextcolor":"#000000","buttonstyle":"rounded","shadow":"soft","shadowcolor":"#c1c1c1","font":"Coda","frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Valentines',
                'description' => '',
                'data' => '{"bgtype":"css","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":null,"customcss":"body{\\r\\nbackground-color: #FD647C;\\r\\nbackground-image: radial-gradient( ellipse farthest-corner at 10px 10px , #F6383A, #F6383A 50%, #FD647C 50%);\\r\\nbackground-size: 10px 10px;\\r\\n}","textcolor":"#ffffff","buttoncolor":"#ff0000","buttontextcolor":"#ffffff","buttonstyle":"rectangular","shadow":"hard","shadowcolor":"#a90303","font":"Karla","frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Mother Nature',
                'description' => '',
                'data' => '{"bgtype":"gradient","singlecolor":null,"gradientstart":"#9aa969","gradientstop":"#3c4718","gradientangle":"135","bgimage":null,"customcss":null,"textcolor":"#ffffff","buttoncolor":"#d9e27b","buttontextcolor":"#3c4718","buttonstyle":"rounded","shadow":"soft","shadowcolor":"#242d05","font":"Roboto","frost":0}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1                
            ],
            [                
                'name' => 'Fun Party',
                'description' => 'A fun party theme',
                'data' => '{"bgtype":"image","singlecolor":null,"gradientstart":null,"gradientstop":null,"gradientangle":null,"bgimage":"fun-party-biopage.png","customcss":null,"textcolor":"#000000","buttoncolor":"#ffffff","buttontextcolor":"#000000","buttonstyle":"rectangular","shadow":"soft","shadowcolor":"#cacaca","font":"Poppins","frost":1}',
                'paidonly' => 0,
                'planids' => null,
                'status' => 1
            ],
        ];

        foreach($themes as $themeData){
            $theme = DB::themes()->create();
            $theme->name = $themeData['name'];
            $theme->description = $themeData['description'];
            $theme->data = $themeData['data'];
            $theme->paidonly = $themeData['paidonly'];
            $theme->planids = $themeData['planids'];
            $theme->status = $themeData['status'];
            $theme->created_at = date('Y-m-d H:i:s');
            $theme->save();
        }

        DB::schema('url', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('alias', 50)->index();
            $table->string('custom', 100)->index();
            $table->text('url');
            $table->text('location');
            $table->text('devices');
            $table->text('options');
            $table->string('domain', 100);
            $table->text('description');
            $table->timestamp('date');
            $table->string('pass');
            $table->bigint('click', null, '0');
            $table->bigint('uniqueclick', null, '0');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_image');
            $table->bigint('bundle');
            $table->int('public', null, '0');
            $table->int('archived', null, '0');
            $table->string('type');
            $table->string('pixels');
            $table->timestamp('expiry', null);
            $table->text('parameters');
            $table->int('status', null, '1')->index();
            $table->bigint('qrid');
            $table->bigint('profileid');
        });

        DB::schema('user', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->text('auth');
            $table->string('auth_id');
            $table->int('admin', null, '0');
            $table->string('email')->index();
            $table->string('username')->index();
            $table->string('name');
            $table->string('password');
            $table->text('address');
            $table->timestamp('date');
            $table->string('api')->index();
            $table->int('active', null, '1');
            $table->int('banned', null, '0');
            $table->int('public', null, '0');
            $table->string('domain');
            $table->int('media', null, '0');
            $table->string('auth_key')->index();
            $table->timestamp('last_payment', null);
            $table->datetime('expiration', null);
            $table->int('pro', null, '0');
            $table->integer('planid', null, '0');
            $table->string('defaulttype', 50, 'direct');
            $table->bigint('defaultbio');
            $table->string('secret2fa');
            $table->string('slackid');
            $table->string('slackteamid', 191, null);
            $table->string('zapurl');
            $table->string('zapview');
            $table->int('trial', null, '0');
            $table->text('avatar');
            $table->int('newsletter');
            $table->string('uniquetoken');
            $table->string('mailchimpapikey', 191, null);
            $table->string('paypal');
            $table->double('pendingpayment', '10,2');
            $table->int('verified', null, '0');
            $table->text('extra', null);
        });

        DB::schema('verification', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string("file");
            $table->int("status", null, '0');
            $table->timestamp('created_at');
        });

        DB::schema('vouchers', function($table){
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->string('name');
            $table->text('description');
            $table->string('code')->index();
            $table->integer('planid', null, '0');
            $table->integer('used', null, '0');
            $table->integer('maxuse', null, '0');
            $table->timestamp('validuntil', null);
            $table->string('period', 15, null);
            $table->timestamp('created_at');
        });

        DB::schema('withdrawals', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('user_id')->index();
            $table->string('amount', 191);
            $table->string('paypal', 191);
            $table->string('status', 191, 'pending');
            $table->text('note');
            $table->timestamp('created_at');
            $table->datetime('processed_at', null);
        });

        DB::schema('email2fa', function($table) {
            $table->charset("utf8mb4");
            $table->increment('id');
            $table->bigint('userid')->index();
            $table->string('code', 6);
            $table->string('ip')->index();
            $table->int('used', null, '0')->index();
            $table->timestamp('expires_at')->index();
            $table->timestamp('created_at');
            $table->multiindex('email2fa_userid_used', ['userid', 'used']);
        });

        $this->importFaqs();
    }
    /**
     * Faqs
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    private function importFaqs(){

        $categories = '{"affiliate":{"title":"Affiliate","description":"Questions and answers about our affiliate program."},"pixels":{"title":"Pixels","description":"Pixels are great. Learn how to use to them."},"subscription":{"title":"Subscription","description":"Everything you need to know about your subscription."}}';

        $faqs = [
            ['slug' => 'google-tag-manager-pixel','category' => 'pixels','question' => 'Google Tag Manager Pixel','answer' => '<p>Google Tag Manager allows you to combine hundreds of pixels into a single pixel. Please make sure to add the correct &quot;Container ID&quot; otherwise events will not be tracked!</p><p><code>e.g. GTM-ABC123DE</code></p><p><a href="https://marketingplatform.google.com/about/tag-manager/" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'facebook-pixel','category' => 'pixels','question' => 'Facebook Pixel','answer' => '<p>Facebook pixel makes conversion tracking, optimization and remarketing easier than ever. The Facebook pixel ID is usually composed of 16 digits. Please make sure to add the correct value otherwise events will not be tracked!</p> <p><code>e.g. 1234567890123456</code></p><p><a href="https://www.facebook.com/business/a/facebook-pixel" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'google-adwords-conversion-pixel','category' => 'pixels','question' => 'Google Adwords Conversion Pixel','answer' => '<p>With AdWords conversion tracking, you can see how effectively your ad clicks lead to valuable customer activity. The Adwords pixel ID is usually composed of AW followed by 11 digits followed by 19 mixed characters. Please make sure to add the correct value otherwise events will not be tracked!</p><p><code>e.g. AW-12345678901/ABCDEFGHIJKLMOPQRST</code></p><p><a href="https://support.google.com/adwords/answer/1722054?hl=en" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'linkedin-insight-pixel','category' => 'pixels','question' => 'LinkedIn Insight Pixel','answer' => '<p>The LinkedIn Insight Tag is a piece of lightweight JavaScript code that you can add to your website to enable in-depth campaign reporting and unlock valuable insights about your website visitors. You can use the LinkedIn Insight Tag to track conversions, retarget website visitors, and unlock additional insights about members interacting with your ads.!</p><p><code>e.g. 123456</code></p><p><a href="https://www.linkedin.com/help/linkedin/answer/65521" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'twitter-pixel','category' => 'pixels','question' => 'Twitter Pixel','answer' => '<p>Conversion tracking for websites enables you to measure your return on investment by tracking the actions users take after viewing or engaging with your ads on Twitter.</p><p><code>e.g. 123456789</code></p><p><a href="https://business.twitter.com/en/help/campaign-measurement-and-analytics/conversion-tracking-for-websites.html" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'adroll-pixel','category' => 'pixels','question' => 'AdRoll Pixel','answer' => '<p>The AdRoll Pixel is uniquely generated when you create an AdRoll account. The AdRoll ID has two components: the Advertiser ID or adroll_adv_id (X) and Pixel ID or adroll_pix_id (Y) for the AdRoll Pixel. To use the AdRoll Pixel, merge the two components together, separating them by a slash (/).</p><p><code>e.g. adroll_adv_id/adroll_pix_id</code></p><p><a href="https://help.adroll.com/hc/en-us/articles/211846018" target="_blank">Learn more</a></p>','pricing' => '0','created_at' => '2021-11-04 10:46:59'],

            ['slug' => 'quora-pixel','category' => 'pixels','question' => 'Quora Pixel Pixel','answer' => '<p>The Quora Pixel is a tool that is placed in your website code to track traffic and conversions. When someone clicks on your ad and lands on your website, the Quora Pixel allows you to identify how many people are visiting your website and what actions they are taking.</p><p><code>e.g. 1a79a4d60de6718e8e5b326e338ae533</code></p><p><a href="https://quoraadsupport.zendesk.com/hc/en-us/articles/115010466208-How-do-I-install-the-Quora-pixel-" target="_blank">Learn more</a></p>','pricing' => '0'],

            ['slug' => 'can-i-upgrade-my-account-at-any-time','category' => 'subscription','question' => ' Can I upgrade my account at any time?','answer' => '<p>Yes! You can start with our free package and upgrade anytime to enjoy premium features.</p>','pricing' => '1'],

            ['slug' => 'how-will-i-be-charged','category' => 'subscription','question' => 'How will I be charged?','answer' => '<p>You will be charged at the beginning of each period automatically until canceled.</p>','pricing' => '1'],

            ['slug' => 'what-happens-when-i-delete-my-account','category' => 'subscription','question' => 'What happens when I delete my account?','answer' => '<p>Once your account has been deleted, your subscription will be canceled and we will wipe all of your data from our servers including but not limited to your links, traffic data, pixels and all other associated data.</p>','pricing' => '1'],

            ['slug' => 'how-do-refunds-work','category' => 'subscription','question' => ' How do refunds work?','answer' => '<p>Upon request, we will issue a refund at the moment of the request for all <strong>upcoming</strong periods. If you are on a monthly plan, we will stop charging you at the end of your current billing period. If you are on a yearly plan, we will refund amounts for the remaining months.</p>','pricing' => '1']
        ];

        \Core\Support\ORM::configure('id_column_overrides', array(
			DBprefix.'settings' => 'config'
		));

        $query = DB::settings()->where('config', 'faqcategories')->first();
        $query->var = $categories;
        $query->save();

        foreach($faqs as $request){
            if(DB::faqs()->where('slug', $request['slug'])->first()) continue;
            $faq = DB::faqs()->create();
            $faq->question = $request['question'];
            $faq->slug = $request['slug'];
            $faq->answer = $request['answer'];
            $faq->category = $request['category'];
            $faq->pricing = $request['pricing'];
            $faq->created_at = Helper::dtime();
            $faq->save();
        }
    }
    /**
     * Header
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    private function header($request){
        echo '<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Premium URL Shortener Installation</title>
                <style type="text/css">
                    '.$this->css().'
                </style>
            </head>
            <body>
                <div class="container">
                    <h1 class="heading">Premium URL Shortener</h1>
                    <ul class="progress">
                        <li class="'.($request->segment(1) ? 'current completed' : 'current').'">Requirements</li>
                        <li class="'.($request->segment(1) == 'database' ? 'current' : '').' '.(in_array($request->segment(1), ['user', 'final']) ? "current completed":"").'">Database</li>
                        <li class="'.($request->segment(1) == 'user' ? 'current' : '').' '.(in_array($request->segment(1), ['final']) ? "current completed":"").'">Admin Account</li>
                        <li class="'.($request->segment(1) == 'final' ? 'current' : '').'">Complete</li>
                    </ul>
                    <div class="card">';
        }
    /**
     * Footer
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    private function footer(){
                echo '</div>
                    <div class="footer">
                        '.date("Y").' &copy; <a href="https://gempixel.com" target="_blank">GemPixel</a> - All Rights Reserved.
                        <div class="float-right">
                            <a href="https://gempixel.com/" target="_blank">Home</a>
                            <a href="https://gempixel.com/products" target="_blank">Products</a>
                            <a href="https://support.gempixel.com/" target="_blank">Support</a>
                        </div>
                    </div>
                </div>
            </body>
        </html>';
    }
    /**
     * CSS
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.4
     * @return void
     */
    private function css(){
        $css = ':root {
            --bg: #f2f4f7;
            --ct: #ffffff;
            --color: #333a46;
            --primary: #5b59d8;
            --input: #fff;
        }
        * {
            box-sizing: border-box;
        }
        body {
            background-color: var(--bg);
            font-family: Helvetica, Arial;
            line-height: 25px;
            font-size: 13px;
            color: var(--color);
        }
        a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }
        a:hover {
            opacity: 0.9;
            text-decoration: none;
        }
        .text-red {
            color: #ff3146;
        }
        .container{
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
            padding: 6rem 0 20px;
        }
        .heading{
            text-align: center;
            margin-bottom: 30px;
        }
        .card {
            background: var(--ct);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 10px;
            display: block;
            overflow: hidden;
            margin: 15px 0;
            padding: 18px;
        }
        .card h1 {
            font-size: 20px;
            display: block;
            border-bottom: 1px solid #e6eaef;
            margin: 0 !important;
            padding: 20px 10px;
        }
        .card h2 {
            color: var(--color);
            font-size: 18px;
        }
        .card h3 {
            border-bottom: 1px solid #e6eaef;
            border-radius: 3px 0 0 0;
            text-align: center;
            margin: 0;
            padding: 20px 0;
        }
        .form {
            display: block;
            border: 1px solid #e6eaef;
            border-radius: 5px;
        }
        .form label {
            font-size: 15px;
            font-weight: 700;
            display: block;
        }
        .form label a {
            float: right;
            color: var(--primary);
            font: bold 12px Helvetica, Arial;
            padding-top: 5px;
        }
        .form .input {
            background: var(--input);
            display: block;
            width: 100%;
            padding: 10px;
            border: 2px #e6eaef solid;
            font: bold 15px Helvetica, Arial;
            color: #000;
            border-radius: 3px;
            margin: 10px 0;
            padding: 15px;
        }
        .form .input:focus {
            border: 2px var(--primary) solid;
            outline: none;
            color: #000e6eaef;
        }
        .form .group{
            padding: 10px;
        }
        .button {
            background-color: var(--primary);
            font-weight: 700;
            display: block;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            color: #fff;
            font: 15px Helvetica, Arial bold;
            cursor: pointer;
            margin: 30px auto;
            padding: 10px 30px;
            border: 0;
            font-weight: 700;
            float: right;
        }

        .button:active,
        .button:hover {
            opacity: 0.9;
            color: #fff;
        }
        .button span {
            vertical-align: top;
        }
        .button:hover svg {
            transform: translateX(10px);
        }

        .button svg {
            transition: 0.5s linear transform;
        }
        .content {
            color: var(--color);
            display: block;
            border: 1px solid #e6eaef;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        li {
            color: var(--color);
        }
        li.current {
            color: #000;
            font-weight: 700;
        }
        li span {
            float: right;
            margin-right: 10px;
            font-size: 11px;
            font-weight: 700;
            color: #00b300;
        }
        .content > p {
            color: var(--color);
            font-weight: 700;
        }
        span.ok {
            float: right;
            border-radius: 3px;
            background-color: #00BCD4;
            font-weight: 700;
            background-image: -moz-linear-gradient(45deg, #00BCD4 0%, #4CAF50 100%);
            background-image: -webkit-linear-gradient(45deg, #00BCD4 0%, #4CAF50 100%);
            background-image: -ms-linear-gradient(45deg, #00BCD4 0%, #4CAF50 100%);
            color: #fff;
            padding: 2px 10px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }
        span.fail {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            float: right;
            border-radius: 3px;
            background-color: #ff3146;
            font-weight: 700;
            background-image: -moz-linear-gradient(45deg, #f04c74 0%, #ff3146 100%);
            background-image: -webkit-linear-gradient(45deg, #f04c74 0%, #ff3146 100%);
            background-image: -ms-linear-gradient(45deg, #f04c74 0%, #ff3146 100%);
            color: #fff;
            padding: 2px 10px;
        }
        span.warning {
            float: right;
            border-radius: 3px;
            background: #fb923c;
            background-image: -moz-linear-gradient(45deg, #fb923c 0%, #ff3146 100%);
            background-image: -webkit-linear-gradient(45deg, #fb923c 0%, #ff3146 100%);
            background-image: -ms-linear-gradient(45deg, #fb923c 0%, #ff3146 100%);
            color: #fff;
            padding: 2px 10px;
        }
        .bg-success,
        .alert-success {
            background: #68b835;
            color: #fff;
            font: bold 15px Helvetica, Arial;
            border: 1px solid #68b835;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }
        .bg-danger,
        alert-danger {
            background-color: #ff3146;
            background-image: -moz-linear-gradient(45deg, #f04c74 0%, #ff3146 100%);
            background-image: -webkit-linear-gradient(45deg, #f04c74 0%, #ff3146 100%);
            background-image: -ms-linear-gradient(45deg, #f04c74 0%, #ff3146 100%);
            color: #fff;
            font: bold 15px Helvetica, Arial;
            margin: 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }
        span.hide,
        p.hide {
            display: none;
        }
        .info {
            display: block;
        }
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
            font-size: 0.9em;
        }
        ul li {
            overflow: hidden;
            margin-bottom: 10px;
        }
        ul li span {
            font-size: 0.8em;
        }
        ul li strong {
            opacity: 0.8;
        }
        .progress {
            counter-reset: step;
        }
        .progress li {
            list-style: none;
            display: inline-block;
            width: 19.25%;
            position: relative;
            text-align: center;
            overflow: visible;
        }
        .progress li:before {
            content: counter(step);
            counter-increment: step;
            width: 30px;
            height: 30px;
            line-height : 30px;
            border: 2px solid #ddd;
            border-radius: 100%;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            background-color: #fff;
        }
        .progress li:after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #ddd;
            top: 15px;
            left: -50%;
            z-index : -1;
        }
        .progress li:first-child:after {
            content: none;
        }
        .progress li.current {
            color: var(--primary);
        }
        .progress li.current:before {
            border-color: var(--primary);
        }
        .progress li.current + li:after {
            background-color: var(--primary);
        }
        .progress li.current.completed:before {
            background: var(--primary);
            color: #fff;
            content: url("data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2230%22%20height%3D%2230%22%20fill%3D%22%23fff%22%20%20viewBox%3D%220%200%2016%2016%22%3E%0A%20%20%3Cpath%20d%3D%22M10.97%204.97a.75.75%200%200%201%201.07%201.05l-3.99%204.99a.75.75%200%200%201-1.08.02L4.324%208.384a.75.75%200%201%201%201.06-1.06l2.094%202.093%203.473-4.425z%22%2F%3E%0A%3C%2Fsvg%3E");
        }
        .float-right{
            float:right;
        }
        .footer{
            opacity: 0.8
        }
        .footer .float-right a{
            margin-left: 8px;
        }';

        $css = preg_replace("/\s{2,}/", " ", $css);
        $css = str_replace("\n", "", $css);
        $css = str_replace(', ', ",", $css);

        return $css;
    }
}