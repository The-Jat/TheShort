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

class Stats {	
    /**
     * Stats page 
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }
       
        View::set('title', e('Statistics'));

        $counts = [];
        $counts['urls'] = ['name' => e('Links'), 'count' => DB::url()->count(), 'count.today' => DB::url()->whereRaw('`date` >= CURDATE()')->count()];
        $counts['clicks'] = ['name' => e('Clicks'), 'count' => \Core\DB::url()->selectExpr('SUM(click) as click')->first()->click, 'count.today' => DB::stats()->whereRaw('`date` >= CURDATE()')->count()];
        $counts['bio'] = ['name' => e('Bio Pages'), 'count' => DB::profiles()->count(), 'count.today' => DB::profiles()->whereRaw('`created_at` >= CURDATE()')->count()];
        $counts['qr'] = ['name' => e('QR Codes'), 'count' => DB::qrs()->count(), 'count.today' => DB::qrs()->whereRaw('`created_at` >= CURDATE()')->count()];
    
        View::push(assets('frontend/libs/jsvectormap/dist/js/jsvectormap.min.js'), "script")->toFooter();
        View::push(assets('frontend/libs/jsvectormap/dist/maps/world.js'), "script")->toFooter();
        View::push(assets('frontend/libs/jsvectormap/dist/css/jsvectormap.min.css'), "css")->toHeader();
        View::push(assets('Chart.min.js'), "script")->toFooter();
        View::push(assets('charts.min.js')."?v=1.0", 'script')->toFooter();

        return View::with('admin.stats', compact('counts'))->extend('admin.layouts.main');
    }
    /**
     * Get Stats Links Ajax
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function statsLinks(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }
        $response = ['label' => e('Links')];

        $timestamp = strtotime('now');
        for ($i = 12 ; $i >= 0; $i--) {
            $d = $i*28;
            $timestamp = \strtotime("-{$d} days");            
            $response['data'][date('F', $timestamp)] = 0;
        }
        
        $results = Helper::cacheGet('adminchartlinks');

        if($results === null){
            $results = DB::url()->selectExpr('COUNT(MONTH(date))', 'count')->selectExpr('DATE_FORMAT(date, "%Y-%m")', 'newdate')->whereRaw('(DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH))')->groupByExpr('newdate')->findArray();
            Helper::cacheSet('adminchartlinks', $results,  60 * 60);
        }

        foreach($results as $data){
            $response['data'][Helper::dtime($data['newdate'], 'F')] = (int) $data['count'];
        }
        
        return (new Response($response))->json();
    }    
    /**
     * Generate Users Graphs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function statsUsers(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }

        $response = ['label' => e('Users')];

        $timestamp = strtotime('now');
        for ($i = 12 ; $i >= 0; $i--) {
            $d = $i*28;
            $timestamp = \strtotime("-{$d} days");            
            $response['data'][date('F', $timestamp)] = 0;
        }
        
        
       $results = Helper::cacheGet('adminchartusers');

        if($results === null){
            $results = DB::user()->selectExpr('COUNT(MONTH(date))', 'count')->selectExpr('DATE_FORMAT(date, "%Y-%m")', 'newdate')->whereRaw('(date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH))')->groupByExpr('newdate')->findArray();
            Helper::cacheSet('adminchartusers', $results,  60 * 60);
        }

        foreach($results as $data){
            $response['data'][Helper::dtime($data['newdate'], 'F')] = (int) $data['count'];
        }   
        
        return (new Response($response))->json(); 
    }
    /**
     * Generate Clicks Graphs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function statsClicks(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }

        $response = ['label' => e('Clicks')];

        $timestamp = strtotime('now');
        for ($i = 12 ; $i >= 0; $i--) {
            $d = $i*28;
            $timestamp = \strtotime("-{$d} days");            
            $response['data'][date('F', $timestamp)] = 0;
        }
        
        
       $results = Helper::cacheGet('adminchartclicks');

        if($results === null){

            $results = DB::stats()->selectExpr('COUNT(MONTH(date))', 'count')->selectExpr('DATE_FORMAT(date, "%Y-%m")', 'newdate')->whereRaw('(DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH))')->groupByExpr('newdate')->findArray();
            Helper::cacheSet('adminchartclicks', $results,  60 * 60);
        }

        foreach($results as $data){
            $response['data'][Helper::dtime($data['newdate'], 'F')] = (int) $data['count'];
        }   
        
        return (new Response($response))->json(); 
    }

    /**
     * Get Clicks Map
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function clicksMap(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }

        $countries = Helper::cacheGet("admincountrymaps");

        if($countries == null){
          $countries = DB::stats()->selectExpr('COUNT(country)', 'count')->selectExpr('country', 'country')->groupByExpr('country')->orderByDesc('count')->findArray();
          Helper::cacheSet("admincountrymaps", $countries, 60*60);
        }

        $i = 0;
        $topCountries = [];
        $country  = [];

        foreach ($countries as $list) {
          
            $name = $list["country"] ? Helper::Country(ucwords($list["country"]), false, true) : 'unknown';

            $country[$name] = $list["count"];

            if($i <= 10){
                if(empty($list["country"])) $list["country"] = e('Unknown');

                $topCountries[$name] = ['name' => ucwords($list["country"]), 'count' => $list["count"]];
            }
            $i++;
        }

        return (new Response(['list' => $country, 'top' => $topCountries]))->json();  
    }
    /**
     * Membership Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function memberships(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }

        $response = [];

        $response['chart']['Free'] = DB::user()->where('pro', 0)->count();

        $response['chart']['Paid'] = DB::user()->where('pro', 1)->count();

        return (new Response($response))->json();  
    }
    /**
     * Subscriptions
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function subscriptions(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }

        if(!\Helpers\App::isExtended()) return;

        $response = ['label' => e('Subscriptions')];

        $timestamp = strtotime('now');
        for ($i = 12 ; $i >= 0; $i--) {
            $d = $i*28;
            $timestamp = \strtotime("-{$d} days");            
            $response['data'][date('F', $timestamp)] = 0;
        }
        
        
       $results = Helper::cacheGet('adminchartsubscriptions');

        if($results === null){
            $results = DB::subscription()->selectExpr('COUNT(MONTH(date))', 'count')->selectExpr('DATE_FORMAT(date, "%Y-%m")', 'newdate')->whereRaw("status='Active' AND (DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH))")->groupByExpr('newdate')->findArray();
            Helper::cacheSet('adminchartsubscriptions', $results,  60 * 60);
        }

        foreach($results as $data){
            $response['data'][Helper::dtime($data['newdate'], 'F')] = (int) $data['count'];
        }
        
        return (new Response($response))->json(); 
    }
    /**
     * Payments
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @return void
     */
    public function payments(){
        if(!user()->hasRolePermission('stats.view')) {
            return Helper::redirect()->to(route('admin'))->with('danger', e('You do not have permission to view statistics.'));
        }

        $response = ['label' => e('Total Amount in ').config('currency')];

        $timestamp = strtotime('now');
        for ($i = 12 ; $i >= 0; $i--) {
            $d = $i*28;
            $timestamp = \strtotime("-{$d} days");            
            $response['data'][date('F', $timestamp)] = 0;
        }
        
        
       $results = Helper::cacheGet('adminchartpayment');

        if($results === null){

            $results = DB::payment()->selectExpr('COUNT(MONTH(date))', 'count')->selectExpr('DATE_FORMAT(date, "%Y-%m")', 'newdate')->selectExpr('SUM(amount)', 'sum')->whereRaw("(DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)) AND status = 'Completed'")->groupByExpr('newdate')->findArray();
            Helper::cacheSet('adminchartpayment', $results,  60 * 60);
        }

        foreach($results as $data){
            $response['data'][Helper::dtime($data['newdate'], 'F')] = $data['sum'];
        }
        
        return (new Response($response))->json(); 
    }
}