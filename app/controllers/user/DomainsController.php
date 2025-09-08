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

use Core\Request;
use Core\Helper;
use Core\Auth;
use Core\DB;
use Core\View;
use Models\User;
use Helpers\Emails;

class Domains {

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('domain') === false){
            return \Models\Plans::notAllowed();
        }
    }

    /**
     * List Domains Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){

        $domains = [];
        $count = DB::domains()->where('userid', Auth::user()->rID())->count();
        $total = Auth::user()->hasLimit('domain');
        $query = DB::domains()->where('userid', Auth::user()->rID())->orderByDesc('id');
        
        $limit = 15;
        
        if($total > 0 && $count >= $total) {
            $count = $total;
            $db = $query->limit($total)->findMany();
        } else {
            $db = $query->paginate($limit);
        }

        foreach($db as $domain){
            if($domain->bioid){
                if($bio = DB::profiles()->where('id', $domain->bioid)->first()){
                    $domain->bioname = $bio->name;
                }
            }   
            $domains[] = $domain;
        }

        View::set('title', e('Branded Domains'));

        return View::with('domains.index', compact('domains', 'count', 'total'))->extend('layouts.dashboard');
    }

    /**
     * Add Domains Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function create(){

        if(Auth::user()->teamPermission('domain.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        $count = DB::domains()->where('userid', Auth::user()->rID())->count();
        $total = Auth::user()->hasLimit('domain');
        
        \Models\Plans::checkLimit($count, $total);

        View::set('title', e('New Domain'));    

        View::push('<script type="text/javascript">
                        $("[data-trigger=switcher]").click(function(e){
                            e.preventDefault();
                            if($(this).hasClass("active")) return false;
                            $(".switcher").removeClass("show");
                            $($(this).attr("href")).addClass("show");
                            $("[data-trigger=switcher]").removeClass("active").removeClass("border-primary");
                            $(this).addClass("active").addClass("border-primary");
                            $("input[name=type]").val($(this).attr("href").replace("#", ""));
                        });
                    </script>', 'custom')->toFooter();
        
        $bios = DB::profiles()->where('userid', Auth::user()->rID())->orderByDesc('created_at')->find();

        return View::with('domains.new', compact('count', 'total', 'bios'))->extend('layouts.dashboard');
    }

    /**
     * Save Domains Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){

        \Gem::addMiddleware('DemoProtect');

        if(Auth::user()->teamPermission('domain.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }

        $user = Auth::user();

        $count = DB::domains()->where('userid', $user->rID())->count();
        $total = $user->hasLimit('domain');        

        \Models\Plans::checkLimit($count, $total);

        if(!$request->domain || filter_var(idn_to_ascii($request->domain), FILTER_VALIDATE_URL) == false) return Helper::redirect()->back()->with('danger', e('A valid domain name is required.'));

        $domain =  trim(str_replace(['http://', 'https://'], '', Helper::RequestClean($request->domain)));
        
        if(DB::domains()->whereRaw('domain = ? OR domain = ?', ['http://'.$domain, 'https://'.$domain])->first()) return Helper::redirect()->back()->with('danger', e('The domain has been already used.'));
        
        $multiples = array_map('trim', explode("\n", str_replace(['http://', 'https://'], '', config('domain_names'))));

        if(trim($domain, '/') == str_replace(['http://', 'https://'], '', config('url')) || ($multiples && in_array($domain, $multiples))) {
            return Helper::redirect()->back()->with('danger', e('A valid domain name is required.'));
        }
        // if(\Helpers\App::checkDNS(config('url'), $request->domain) === false) {
        //     return Helper::redirect()->back()->with('danger', e('The domain name is not pointed to our server. DNS changes could take up to 36 hours.'));
        // }

        if($request->root && !filter_var($request->root, FILTER_VALIDATE_URL)) return Helper::redirect()->back()->with('danger', e('A valid url is required for the root domain.'));

        if($request->root404 && !filter_var($request->root404, FILTER_VALIDATE_URL)) return Helper::redirect()->back()->with('danger', e('A valid url is required for the 404 page.'));

        $domain = DB::domains()->create();
        $domain->domain = trim(Helper::clean($request->domain, 3, true), '/');
        
        if($request->type && $request->type == 'bio' && $user->has('bio') && DB::profiles()->where('id', $request->biopage)->where('userid', $user->id)->first()){
            $domain->bioid = (int) $request->biopage;            
            $domain->redirect = null;
        } else {
            $domain->bioid = null;
            $domain->redirect = Helper::clean($request->root, 3, true);    
        }

        $domain->redirect404 = Helper::clean($request->root404, 3, true);
        $domain->status = 1;
        $domain->userid = $user->rID();

        $domain->save();

        Emails::notifyAdmin([
                                'subject' => e('A new domain was added.'), 
                                'message' => e('A customer ({e}) added a new domain to the platform. Please make sure the domain is pointed correctly and is resolving as expected. Their domain name is {d}.', null, ['e' => user()->email, 'd' => $domain->domain])
                            ]);

        return Helper::redirect()->to(route('domain'))->with('success', e('Domain has been added successfully'));
    }

    /**
     * Edit Domains
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){

        if(Auth::user()->teamPermission('domain.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }


        if(!$domain = DB::domains()->where('id', $id)->where('userid',Auth::user()->rID())->first()) {
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }
        
        View::set('title', e('Edit Domain'));

        View::push('<script type="text/javascript">
                        $("[data-trigger=switcher]").click(function(e){
                            e.preventDefault();
                            if($(this).hasClass("active")) return false;
                            $(".switcher").removeClass("show");
                            $($(this).attr("href")).addClass("show");
                            $("[data-trigger=switcher]").removeClass("active").removeClass("border-primary");
                            $(this).addClass("active").addClass("border-primary");
                            $("input[name=type]").val($(this).attr("href").replace("#", ""));
                        });
                    </script>', 'custom')->toFooter();

        $bios = DB::profiles()->where('userid', Auth::user()->rID())->orderByDesc('created_at')->find();

        return View::with('domains.edit', compact('domain', 'bios'))->extend('layouts.dashboard');
    }
    
    /**
     * Update Existing Domains
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();

        if($user->teamPermission('domain.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }        

        if(!$domain = DB::domains()->where('id', $id)->where('userid', $user->rID())->first()) return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
                
        if($request->type && $request->type == 'bio' && $user->has('bio') && DB::profiles()->where('id', $request->biopage)->where('userid', $user->id)->first()){
            $domain->bioid = (int) $request->biopage;            
            $domain->redirect = null;
        } else {
            $domain->bioid = null;
            $domain->redirect = Helper::clean($request->root, 3, true);    
        }

        $domain->redirect404 = Helper::clean($request->root404, 3, true);

        $domain->save();

        return Helper::redirect()->back()->with('success', e('Domain has been updated successfully.'));
    }

    /**
     * Delete Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){
        \Gem::addMiddleware('DemoProtect');

        if(Auth::user()->teamPermission('domain.delete') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }


        if(!Helper::validateNonce($nonce, 'domain.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$domain = DB::domains()->where('id', $id)->where('userid',Auth::user()->rID())->first()){
            return Helper::redirect()->back()->with('danger', e('Domain not found. Please try again.'));
        }
        
        DB::url()->where("domain", $domain->domain)->update(['domain' => '']);
        $domain->delete();
        return Helper::redirect()->back()->with('success', e('Domain has been deleted.'));
    }

}