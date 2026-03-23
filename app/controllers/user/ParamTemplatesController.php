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

class ParamTemplates {

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     */
    public function __construct(){
        if(User::where('id', Auth::user()->rID())->first()->has('parametertemplates') === false){
            return \Models\Plans::notAllowed();
        }
    }

    /**
     * List parameter templates
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function index(Request $request){
        $templates = DB::paramtemplates()->where('userid', Auth::user()->rID())->orderByDesc('id')->findMany();
        View::set('title', e('Parameter Templates'));
        return View::with('paramtemplates.index', compact('templates'))->extend('layouts.dashboard');
    }

    /**
     * Create template page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function create(){
        if(Auth::user()->teamPermission('links.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        View::set('title', e('New Parameter Template'));
        return View::with('paramtemplates.create')->extend('layouts.dashboard');
    }

    /**
     * Save template
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){
        \Gem::addMiddleware('DemoProtect');
        if(Auth::user()->teamPermission('links.create') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        if(!$request->name || strlen(trim($request->name)) < 1){
            return Helper::redirect()->back()->with('danger', e('Template name is required.'));
        }
        $data = $this->buildTemplateData($request);
        $template = DB::paramtemplates()->create();
        $template->userid = Auth::user()->rID();
        $template->name = trim(clean($request->name));
        $template->data = json_encode($data);
        $template->created_at = Helper::dtime('now');
        $template->save();
        return Helper::redirect()->to(route('paramtemplates'))->with('success', e('Parameter template has been created.'));
    }

    /**
     * Edit template page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param int $id
     * @return void
     */
    public function edit(int $id){
        if(Auth::user()->teamPermission('links.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        if(!$param = DB::paramtemplates()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Template not found.'));
        }
        $param->data = json_decode($param->data, true);
        if(!is_array($param->data)){
            $param->data = ['utm' => [], 'custom' => []];
        }
        if(empty($param->data['utm'])) $param->data['utm'] = ['utm_source' => '', 'utm_medium' => '', 'utm_campaign' => '', 'utm_term' => '', 'utm_content' => ''];
        if(empty($param->data['custom'])) $param->data['custom'] = [];
        View::set('title', e('Edit Parameter Template'));
        return View::with('paramtemplates.edit', compact('param'))->extend('layouts.dashboard');
    }

    /**
     * Update template
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id){
        \Gem::addMiddleware('DemoProtect');
        if(Auth::user()->teamPermission('links.edit') == false){
            return back()->with('danger', e('You do not have this permission. Please contact your team administrator.'));
        }
        if(!$template = DB::paramtemplates()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Template not found.'));
        }
        if(!$request->name || strlen(trim($request->name)) < 1){
            return Helper::redirect()->back()->with('danger', e('Template name is required.'));
        }
        $data = $this->buildTemplateData($request);
        $template->name = trim(clean($request->name));
        $template->data = json_encode($data);
        $template->save();
        return Helper::redirect()->to(route('paramtemplates'))->with('success', e('Parameter template has been updated.'));
    }

    /**
     * Delete template
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param int $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){
        \Gem::addMiddleware('DemoProtect');
        if(!Helper::validateNonce($nonce, 'paramtemplate.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }
        if(!$template = DB::paramtemplates()->where('userid', Auth::user()->rID())->where('id', $id)->first()){
            return Helper::redirect()->back()->with('danger', e('Template not found.'));
        }
        $template->delete();
        return Helper::redirect()->back()->with('success', e('Parameter template has been deleted.'));
    }

    /**
     * Build template data array from request (UTM + custom params)
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @return array
     */
    private function buildTemplateData(Request $request){
        $utm = [
            'utm_source'   => $request->utm_source ? clean($request->utm_source) : '',
            'utm_medium'   => $request->utm_medium ? clean($request->utm_medium) : '',
            'utm_campaign' => $request->utm_campaign ? clean($request->utm_campaign) : '',
            'utm_term'     => $request->utm_term ? clean($request->utm_term) : '',
            'utm_content'  => $request->utm_content ? clean($request->utm_content) : '',
        ];
        $custom = [];
        if($request->paramname && is_array($request->paramname)){
            foreach($request->paramname as $i => $name){
                if(!empty(trim($name)) && isset($request->paramvalue[$i]) && $request->paramvalue[$i] !== ''){
                    $custom[] = ['name' => clean($name), 'value' => clean($request->paramvalue[$i])];
                }
            }
        }
        return ['utm' => $utm, 'custom' => $custom];
    }

    /**
     * Convert template data to flat parameters (for link.parameters)
     * Used when applying a template to a link.
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string|array $data JSON string or decoded array
     * @return array
     */
    public static function templateToParameters($data){
        if(is_string($data)) $data = json_decode($data, true);
        if(!is_array($data)) return [];
        $params = [];
        if(!empty($data['utm'])){
            foreach($data['utm'] as $k => $v){
                if($v !== '' && $v !== null) $params[$k] = $v;
            }
        }
        if(!empty($data['custom'])){
            foreach($data['custom'] as $row){
                if(!empty($row['name'])) $params[$row['name']] = $row['value'] ?? '';
            }
        }
        return $params;
    }
}
