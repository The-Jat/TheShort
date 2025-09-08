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

namespace User;

use \Core\Helper;
use \Core\View;
use \Core\DB;
use \Core\Auth;
use \Core\Request;
use \Traits\Links;

class Import {     
    use Links;
    /**
     * Check if user can export
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){
        if(\Models\User::where('id', Auth::user()->rID())->first()->has('import') === false){
			return \Models\Plans::notAllowed();
		}
    }
    /**
     * Import Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.8
     * @return void
     */
    public function links(){      

        if(Auth::user()->teamPermission('links.create') == false){
            return Helper::redirect()->to(route('dashboard'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        View::set('title', e('Import Links via CSV'));

        $imports = DB::imports()->where('userid', user()->id)->orderByDesc('created_at')->map(function($import){
            $import->data = json_decode($import->data);
            return $import;
        });

        return View::with('user.import', compact('imports'))->extend('layouts.dashboard');
    }   
    /**
     * Import Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.8
     * @param \Core\Request $request
     * @return void
     */
    public function importLinks(Request $request){
        
        if(Auth::user()->teamPermission('links.create') == false){
            return Helper::redirect()->to(route('dashboard'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        $user = Auth::user();

        if(!$file = $request->file('file')){
            return back()->with('danger', e('Incorrect format or empty file. Please upload .csv file.'));
        }

        if($file->ext != 'csv'){
            return back()->with('danger', e('Incorrect format or empty file. Please upload .csv file.'));
        }
        
        if($file->sizemb > \Helpers\App::maxSize()){
            return back()->with('danger', e('File is larger than {s}mb.', null, ['s' => \Helpers\App::maxSize()]));
        }

        $content = array_map('str_getcsv', file($file->location));
        unset($content[0]);

        $count = count($content);

        if($count == 0) return back()->with('danger', e('No links found.'));

        if($count > 100) {
            
            $filename = $user->id."_".md5(Helper::rand(32)).".csv";

            if(file_exists(STORAGE.'/app/imports/') === false) mkdir(STORAGE.'/app/imports/');

            \move_uploaded_file($file->location, STORAGE.'/app/imports/'.$filename);

            $import = DB::imports()->create();
            $import->userid = $user->id;
            $import->filename = $filename;
            $import->data = json_encode(['domain' => $request->domain, 'type' => $request->type, 'total' => $count]);
            $import->status = 0;
            $import->created_at = Helper::dtime();
            $import->save();

            return back()->with('success', e('The CSV file contains {num} links and it will be processed in the background. You can review the progress on this page.', null, ['num' => $count]));             

        } else {
            $i = 0;
            $error = null;
            foreach($content as $id => $url){
    
                if(empty($url[0])) continue;
    
                $request->url = clean($url[0]);
                
                if(!clean(empty($url[1])) && !DB::url()->where('custom', clean($url[1]))->first()){
                    $request->custom = clean($url[1]);
                }
                $request->metatitle = $url[2] ?? clean($url[2]);
                $request->metadescription = $url[3] ?? clean($url[3]);
    
                try{
                    $this->createLink($request, $user);
                    $i++;
                } catch(\Exception $e){
                    $error .= "<br>#".($id)." Failed: {$e->getMessage()}";
                    continue;
                }
            }
    
            if($error){
                return back()->with('danger', e('{num} links were successfully imported but some errors occurred:'.$error, null, ['num' => $i]));
            }
    
            return back()->with('success', e('{num} links were successfully imported.', null, ['num' => $i]));             
        }       
    }
    /**
     * Cancel Import
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.7.4
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function cancel(int $id, string $nonce){
		if(!Helper::validateNonce($nonce, 'import.cancel')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }
        $user = Auth::user();
        if(!$import = DB::imports()->where('userid', $user->id)->where('id', $id)->first()) stop(404);

        if(file_exists( STORAGE.'/app/imports/'.$import->filename)) unlink(STORAGE.'/app/imports/'.$import->filename);

        $import->delete();
        return back()->with('success', e('Import has been canceled.'));
    }
}