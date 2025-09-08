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
use Models\User;

class Plugins {	
    /**
     * Plugins Home
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.2
     * @return void
     */
    public function index(Request $request){

        if(!user()->hasRolePermission('settings.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view plugins.'));
        }

        if($request->activated){            
            \Core\Plugin::dispatch('admin.plugin.activate', $request->activated);
        }
        
        if($request->updated){            
            \Core\Plugin::dispatch('admin.plugin.update', $request->updated);
        }

        $plugins = [];
        $list = [];

        foreach (new \RecursiveDirectoryIterator(STORAGE."/plugins/") as $path){
            
            if($path->isDir() && $path->getFilename() !== "." && $path->getFilename() !== ".." && file_exists(STORAGE."/plugins/".$path->getFilename()."/config.json")){          

                $data = json_decode(file_get_contents(STORAGE."/plugins/".$path->getFilename()."/config.json"));

                $plugin = new \stdClass;
                
                $plugin->id = $path->getFilename();
                $plugin->name = isset($data->name) ? Helper::clean($data->name, 3) : "No Name";
                $plugin->author = isset($data->author) ? Helper::clean($data->author, 3) : "Unknown";
                $plugin->link = isset($data->link) ? Helper::clean($data->link, 3) : "#none";
                $plugin->version = isset($data->version) ? Helper::clean($data->version, 3) : "1.0";
                $plugin->description = isset($data->description) ? Helper::clean($data->description, 3) : "";

                $plugin->enabled = isset(config('plugins')->{$plugin->id}) ? true : false;

                $plugin->update = false;
            
                $list[] = $plugin->id;

                $plugins[$plugin->id] = $plugin;
            }
        }  
        
        $http = \Core\Http::url('https://cdn.gempixel.com/plugins/v2/versions?plugins='.implode(',', $list))
                    ->with('X-Authorization', 'TOKEN '.config('purchasecode'))
                    ->with('X-Script', 'Premium URL Shortener')
                    ->post();

        if($http->getBody() !== 'Failed' || $http->getBody() !== 'Error'){
            if($response = $http->bodyObject()){
                foreach($response as $plugin){
                    if(version_compare($plugins[$plugin->tag]->version, $plugin->version, '<')){
                        $plugins[$plugin->tag]->update = $plugin->version;                        
                    }
                }
            }
        } 

        View::set('title', e('Plugins'));

        return View::with('admin.plugins', compact('plugins'))->extend('admin.layouts.main');
    }
    /**
     * Activate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    public function activate($id){

        \Gem::addMiddleware('DemoProtect');

        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to activate plugins.'));
        }

        if(!file_exists(STORAGE."/plugins/".$id."/config.json")){
            return back()->with('danger', e('Plugin does not exist.'));
        }

        $plugins = config('plugins');

        if(isset($plugins->{$id})) return back()->with('danger', e('Plugin is already active.')); 

        $plugins->$id = ['settings' => []];
        
        $settings = DB::settings()->where('config', 'plugins')->first();
        $settings->var = json_encode($plugins);
        $settings->save();

        return Helper::redirect()->to(route('admin.plugins', ['activated' => $id]))->with('success', e('Plugin was successfully activated.'));
    }

     /**
     * Disable
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $id
     * @return void
     */
    public function disable($id){

        \Gem::addMiddleware('DemoProtect');
        
        $plugins = config('plugins');

        if(!isset($plugins->{$id})) return back()->with('danger', e('Plugin is already disabled.')); 

        unset($plugins->{$id});            

        $settings = DB::settings()->where('config', 'plugins')->first();
        $settings->var = json_encode($plugins);
        $settings->save();

        \Core\Plugin::dispatch('admin.plugin.disable', $id);

        return back()->with('success', e('Plugin was successfully disabled.'));
    }

    /**
     * Upload Plugin
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function upload(Request $request){
        
        \Gem::addMiddleware('DemoProtect');

        if($file = $request->file('file')){       

            if(!$file->mimematch || !in_array($file->ext, ['zip'])) return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file is not valid. Only .zip files are accepted.'));    

            $name = str_replace('.'.$file->ext, '', $file->name);

            $exists = file_exists(PLUGIN.'/'.$name);

            move_uploaded_file($file->location, PLUGIN.'/'.$file->name);

            $zip = new \ZipArchive();

            $f = $zip->open(PLUGIN.'/'.$file->name);
        
            if($f === true) {

                if(!$exists) mkdir(PLUGIN.'/'.$name);
              
                if(!$zip->extractTo(PLUGIN."/".$name."/")){
                    return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file was downloaded but cannot be extracted due to permission.'));
                }
        
                $zip->close();

                if(!file_exists(PLUGIN.'/'.$name.'/config.json')){
                    \Helpers\App::deleteFolder(PLUGIN.'/'.$name);
                    unlink(PLUGIN.'/'.$file->name);
                    return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('Invalid plugin. Please make sure the plugin is up to date and includes a config.json file.'));
                }
              
            } else {
                return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file cannot be extracted. You can extract it manually.'));
            }

            if(file_exists(PLUGIN.'/'.$file->name)){
                unlink(PLUGIN.'/'.$file->name);
            }

            
            if($exists){
                return Helper::redirect()->to(route('admin.plugins', ['updated' => $name]))->with('success', e('Plugin has been updated successfully.')); 
            }
            return Helper::redirect()->to(route('admin.plugins'))->with('success', e('Plugin has been installed successfully.')); 
        }

        return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('An unexpected error occurred. Please try again.'));
    }
    /**
     * Plugin Directory
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param \Core\Request $request
     * @return void
     */
    public function directory(Request $request){

        if(!config('purchasecode')){
            return Helper::redirect()->to(route('admin.update'))->with('danger', e('Please update your purchase code in the sidebar.'));
        }

        if($request->install){
            return $this->install($request);            
        }

        if($request->q){
            $http = \Core\Http::url('https://cdn.gempixel.com/plugins/v2/search?q='.$request->q)
                                ->with('X-Authorization', 'TOKEN '.config('purchasecode'))
                                ->with('X-Script', 'Premium URL Shortener')
                                ->body(clean($request->q))
                                ->post();
                                
        } elseif($request->category){
            $http = \Core\Http::url('https://cdn.gempixel.com/plugins/v2/category?q='.$request->category)
                                ->with('X-Authorization', 'TOKEN '.config('purchasecode'))
                                ->with('X-Script', 'Premium URL Shortener')
                                ->with('content-type', 'application/json')                                
                                ->body(['url' => url('/'), 'version' => config('version')])
                                ->post();
        } else {
            $http = \Core\Http::url('https://cdn.gempixel.com/plugins/v2/list')
                                ->with('X-Authorization', 'TOKEN '.config('purchasecode'))
                                ->with('X-Script', 'Premium URL Shortener')
                                ->with('content-type', 'application/json')
                                ->body(['url' => url('/'), 'version' => config('version')])
                                ->post();
        }

        $plugins = [];    
                                        
        if($http->getBody() == 'Failed'){
            return Helper::redirect()->to(route('admin.update'))->with('danger', e('Please update your purchase code in the sidebar.'));
        } 

        $plugins = [];
        $allplugins = config('plugins');
        $categories = [];

        foreach($http->bodyObject() as $plugin){
            $plugin->installed = file_exists(PLUGIN.'/'.$plugin->tag.'/');

            if($plugin->installed){
                $config = json_decode(file_get_contents(PLUGIN.'/'.$plugin->tag.'/config.json'));
                $plugin->installedversion = $config->version;
            }

            $plugins[] = $plugin;
        }
        

        $http = \Core\Http::url('https://cdn.gempixel.com/plugins/v2/categories')
                                ->with('X-Authorization', 'TOKEN '.config('purchasecode'))
                                ->with('X-Script', 'Premium URL Shortener')
                                ->with('content-type', 'application/json')
                                ->body(['url' => url('/'), 'version' => config('version')])
                                ->post();
        if($http->getBody()){
            $categories = $http->bodyObject();
        }
        
        View::set('title', e('Plugin Directory'));

        return View::with('admin.plugins_dir', compact('plugins', 'categories'))->extend('admin.layouts.main');
    }
    /**
     * Install Plugin
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param [type] $request
     * @return void
     */
    public function install(Request $request){

        if(!user()->hasRolePermission('settings.edit')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to install plugins.'));
        }

        \Gem::addMiddleware('DemoProtect');

        $name = $request->install;
 
        $exists = file_exists(PLUGIN.'/'.$name);

        $http = \Core\Http::url('https://cdn.gempixel.com/plugins/v2/get?plugin='.clean($name))
                                ->with('X-Script', 'Premium URL Shortener')
                                ->with('X-Authorization', 'TOKEN '.config('purchasecode'))
                                ->with('content-type', 'application/json')
                                ->body(['url' => url('/'), 'version' => config('version')])
                                ->post();

        if($http->getBody() == 'Failed'){
            return Helper::redirect()->to(route('admin.update'))->with('danger', e('Please update your purchase code in the sidebar.'));
        }

        if($http->getBody() == 'Error'){
            return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('This plugin is not available or cannot be downloaded at the moment.'));
        }
        
        if(!$data = $http->bodyObject()){
            return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        $plugin = \Core\Http::url($data->file)->get();
        

        if(!$data = $plugin->getBody()){
            return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('An error ocurred. Plugin was not downloaded.')); 
        }

        $fh = fopen(PLUGIN.'/'.$name.'.zip', 'w');
        fwrite($fh, $data);
        fclose($fh);

        $zip = new \ZipArchive();

        $f = $zip->open(PLUGIN.'/'.$name.'.zip');
    
        if($f === true) {

            if(!$exists) mkdir(PLUGIN.'/'.$name);
            
            if(!$zip->extractTo(PLUGIN."/".$name."/")){
                return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file was downloaded but cannot be extracted due to permission.'));
            }
    
            $zip->close();

            if(!file_exists(PLUGIN.'/'.$name.'/config.json')){
                \Helpers\App::deleteFolder(PLUGIN.'/'.$name);
                unlink(PLUGIN.'/'.$name.'.zip');
                return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('Invalid plugin. Please make sure the plugin is up to date and includes a config.json file.'));
            }
            
        } else {
            return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('The file cannot be extracted. You can extract it manually.'));
        }

        if(file_exists(PLUGIN.'/'.$name.'.zip')){
            unlink(PLUGIN.'/'.$name.'.zip');
        }

        if($exists){
            return Helper::redirect()->to(route('admin.plugins', ['updated' => $name]))->with('success', e('Plugin has been updated successfully.')); 
        }
        return Helper::redirect()->to(route('admin.plugins'))->with('success', e('Plugin has been installed successfully.')); 

    }
    /**
     * Delete Plugin
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @param string $plugin
     * @param string $nonce
     * @return void
     */
    public function delete(string $plugin, string $nonce){

        \Gem::addMiddleware('DemoProtect');
        
        if(!Helper::validateNonce($nonce, 'plugin.delete')){
            return Helper::redirect()->to(route('admin.plugins'))->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        $plugins = config('plugins');

        if(isset($plugins->{$plugin})) {
            unset($plugins->{$plugin});                    

            $settings = DB::settings()->where('config', 'plugins')->first();
            $settings->var = json_encode($plugins);
            $settings->save();
        }

        \Core\Plugin::dispatch('admin.plugin.disable', $plugin);

        if(!file_exists(STORAGE.'/plugins/'.$plugin.'/config.json')) return Helper::redirect()->to(route('admin.themes'))->with('danger', e('Invalid plugin.. Please make sure the plugin is up to date and includes a config.json file.'));

        \Helpers\App::deleteFolder(STORAGE.'/plugins/'.$plugin);

        \Core\Plugin::dispatch('admin.plugin.deleted', $plugin);

        return Helper::redirect()->to(route('admin.plugins'))->with('success', e('Plugin has been successfully deleted.'));
    }
    /**
     * Single Plugin Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @param [type] $id
     * @return void
     */
    public function single($id){

        $http = \Core\Http::url('https://cdn.gempixel.com/plugins/v2/info?plugin='.$id)
        ->with('X-Authorization', 'TOKEN '.config('purchasecode'))
        ->with('X-Script', 'Premium URL Shortener')
        ->post();
        if($http->getBody() !== 'Failed' || $http->getBody() !== 'Error'){
            if(!$plugin = $http->bodyObject()){
                return back()->with('danger', e('Item does not exist'));
            }
        } 

        $plugin->installed = file_exists(PLUGIN.'/'.$plugin->tag.'/');

        if($plugin->installed){
            $config = json_decode(file_get_contents(PLUGIN.'/'.$plugin->tag.'/config.json'));
            $plugin->installedversion = $config->version;
        }
        
        View::set('title', e('Plugin Details'));

        return View::with('admin.plugins_details', compact('plugin'))->extend('admin.layouts.main');
    }
}