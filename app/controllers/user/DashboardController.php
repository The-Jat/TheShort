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

use Core\View;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\Request;
use Core\Response;
use Helpers\CDN;
use Models\Url;

class Dashboard {

    /**
     * User Dashboard
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6
     * @return void
     */
    public function index(Request $request){

        if($request->success && $request->success == 'true') return Helper::redirect()->to(route('dashboard'))->with("info", e("Your payment was successfully made. Thank you."));

        if($alias = $request->cookie('bioalias')){
            $request->name = $alias;
            $request->custom = $alias;
            $request->cookieClear('bioalias');
            return \User\Bio::saveStatic($request);
        }

        $urls = [];
        
        foreach(Url::recent()->where("userid", Auth::user()->rID())->orderByDesc('date')->limit(10)->findMany() as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $url->url = clean($url->url);
            $urls[] = $url;
        }
                    
        $count = new \stdClass;

        $count->links = null;
        $count->linksToday = null;

        $clicks = DB::url()->selectExpr('SUM(click) as click')->where('userid', Auth::user()->rID())->first();
        $count->clicks = $clicks->click ? $clicks->click : 0;

        $count->clicksToday = DB::stats()->whereRaw('date >= CURDATE()')->where('urluserid', Auth::user()->rID())->count();

        $recentActivity = DB::stats()->where('urluserid', Auth::user()->rID())->limit(count($urls) > 5 ? 16 : 10)->orderByDesc('date')->find(); 
        
        foreach($recentActivity as $id => $stats){
            if(!$url = DB::url()->first($stats->urlid)){
                unset($recentActivity[$id]);
            } else {
                if($url->qrid && $qr = DB::qrs()->select('name')->where('urlid', $url->id)->first()){
                    $recentActivity[$id]->qr = $qr->name;    
                }

                if($url->profileid && $profile = DB::profiles()->select('name')->where('urlid', $url->id)->first()){
                    $recentActivity[$id]->profile = $profile->name;    
                }

                $recentActivity[$id]->url = $url;
            }
        }
                
        View::set('title', e('Dashboard'));

        CDN::load('datetimepicker');
        CDN::load('autocomplete');
        CDN::load('cropper');

        View::push(assets('Chart.min.js'), "script")->toFooter();
        View::push(assets('charts.min.js')."?v=1.3", 'script')->toFooter();

        View::push("<script>$(document).ready(function(){ 		
            $('input[name=customreport]').daterangepicker({
                locale: {
                    'applyLabel': '".e('Apply')."',
                    'cancelLabel': '".e('Cancel')."',
                    'fromLabel': '".e('From')."',
                    'toLabel': '".e('To')."',
                    'customRangeLabel': '".e('Custom')."',
                    'daysOfWeek': ['".e('Su')."','".e('Mo')."','".e('Tu')."','".e('We')."','".e('Th')."','".e('Fr')."','".e('Sa')."'],
                    'monthNames': ['".e('January')."','".e('February')."','".e('March')."','".e('April')."','".e('May')."','".e('June')."','".e('July')."','".e('August')."','".e('September')."','".e('October')."','".e('November')."','".e('December')."'],
                },
                maxDate: moment(),
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoUpdateInput: true,
                ranges: {
                    '".e("Last 7 Days")."': [moment().subtract(6, 'days'), moment()],
                    '".e("Last 30 Days")."': [moment().subtract(29, 'days'), moment()],
                    '".e("This Month")."': [moment().startOf('month'), moment().endOf('month')],
                    '".e("Last Month")."': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '".e("Last 3 Months")."': [moment().subtract(2, 'month').startOf('month'), moment()]
                }
			});
		});</script>", "custom")->toFooter();

        return View::with('user.index', compact('urls', 'count', 'recentActivity'))->extend('layouts.dashboard');
    }
    /**
     * User's Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @return void
     */
    public function links(Request $request){

        $user = Auth::user();

        $urls = [];

        $title = e('Links');

        if($request->channel){

            $query = Url::recent()->select(DBprefix.'url.*')
                        ->leftJoin(DBprefix.'tochannels', [DBprefix.'url.id', '=', DBprefix.'tochannels.itemid'])
                        ->where(DBprefix.'tochannels.userid', $user->rID())
                        ->where(DBprefix.'tochannels.channelid', (int)$request->channel)
                        ->where(DBprefix.'tochannels.type', 'links');
        }else{
            $query = Url::recent()->where("userid", $user->rID());
        }        

        if($request->campaign && is_numeric($request->campaign)){
            if($campaign = DB::bundle()->where('id', clean($request->campaign))->where('userid', $user->rID())->first()){
                $query->where('bundle', $request->campaign);
                $title = e('Campaign Links'). ' - '.$campaign->name;
            }
        }

        if($request->sort == "most"){
            $query->orderByDesc('click');
        }
        
        if($request->sort == "less"){
            $query->orderByAsc('click');
        }

        if(!$request->sort || $request->sort == "latest"){
            $query->orderByDesc('date');
        }

        if($request->sort == "old"){
            $query->orderByAsc('date');
        }

        if($request->pixel){
            $query->whereLike('pixels', '%'.clean($request->pixel).'%');
        }

        if($request->date && $date = date('Y-m-d 00:00:00', strtotime($request->date))){
            $query->whereRaw("DATE(date) < DATE('{$date}')");
        }
        $limit = 15;

        if($request->perpage && is_numeric($request->perpage) && $request->perpage > 15 && $request->perpage <= 100){
            $limit = $request->perpage;
        }
        $results = $query->paginate($limit);

        if($request->page > 1 && !$results) stop(404);

        foreach($results as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $url->url = clean($url->url);
            $urls[] = $url;
        }        

        if($user->plan('counttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::url()->whereRaw("(date BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::url()->where('userid', $user->rID())->count();

        }

        $total = $user->plan()['numurls'];
        
        View::set('title', $title);
        
        CDN::load('datetimepicker');
        CDN::load('cropper');
        
        return View::with('user.links', compact('urls', 'title', 'count', 'total'))->extend('layouts.dashboard');
    }
    /**
     * Archived Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @return void
     */
    public function archived(Request $request){
        
        $urls = [];
        
        $user = Auth::user();

        if($request->channel){

            $query = Url::archived()->select(DBprefix.'url.*')
                        ->leftJoin(DBprefix.'tochannels', [DBprefix.'url.id', '=', DBprefix.'tochannels.itemid'])
                        ->where(DBprefix.'tochannels.userid', $user->rID())
                        ->where(DBprefix.'tochannels.channelid', (int)$request->channel)
                        ->where(DBprefix.'tochannels.type', 'links');
        }else{
            $query = Url::archived()->where("userid", $user->rID());
        }

        if($request->campaign && is_numeric($request->campaign)){
            if($campaign = DB::bundle()->where('id', clean($request->campaign))->where('userid', $user->rID())->first()){
                $query->where('bundle', $request->campaign);
                $title = e('Campaign Links'). ' - '.$campaign->name;
            }
        }

        if($request->sort == "most"){
            $query->orderByDesc('click');
        }
        
        if($request->sort == "less"){
            $query->orderByAsc('click');
        }

        if(!$request->sort || $request->sort == "latest"){
            $query->orderByDesc('date');
        }

        if($request->sort == "old"){
            $query->orderByAsc('date');
        }

        if($request->pixel){
            $query->whereLike('pixels', '%'.clean($request->pixel).'%');
        }

        if($request->date && $date = date('Y-m-d 00:00:00', strtotime($request->date))){
            $query->whereRaw("DATE(date) < DATE('{$date}')");
        }
        $limit = 15;

        if($request->perpage && is_numeric($request->perpage) && $request->perpage > 15 && $request->perpage <= 100){
            $limit = $request->perpage;
        }
        $results = $query->paginate($limit);

        if($request->page > 1 && !$results) stop(404);

        foreach($results as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $url->url = clean($url->url);
            $urls[] = $url;
        }   

        $title = e('Archived Links');

        View::set('title', $title);        
        CDN::load('datetimepicker');
        CDN::load('cropper');

        if($user->plan('counttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::url()->whereRaw("(date BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::url()->where('userid', $user->rID())->count();

        }

        $total = Auth::user()->plan()['numurls'];

        return View::with('user.links', compact('urls', 'title', 'count', 'total'))->extend('layouts.dashboard');        
    }
    /**
     * Expired Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5.4
     * @return void
     */
    public function expired(Request $request){
        
        $urls = [];
        
        $user = Auth::user();

        if($request->channel){

            $query = Url::expired()->select(DBprefix.'url.*')
                        ->leftJoin(DBprefix.'tochannels', [DBprefix.'url.id', '=', DBprefix.'tochannels.itemid'])
                        ->where(DBprefix.'tochannels.userid', $user->rID())
                        ->where(DBprefix.'tochannels.channelid', (int)$request->channel)
                        ->where(DBprefix.'tochannels.type', 'links');
        }else{
            $query = Url::expired()->where("userid", $user->rID());
        }

        if($request->campaign && is_numeric($request->campaign)){
            if($campaign = DB::bundle()->where('id', clean($request->campaign))->where('userid', $user->rID())->first()){
                $query->where('bundle', $request->campaign);
                $title = e('Campaign Links'). ' - '.$campaign->name;
            }
        }

        if($request->sort == "most"){
            $query->orderByDesc('click');
        }
        
        if($request->sort == "less"){
            $query->orderByAsc('click');
        }

        if(!$request->sort || $request->sort == "latest"){
            $query->orderByDesc('date');
        }

        if($request->sort == "old"){
            $query->orderByAsc('date');
        }

        if($request->pixel){
            $query->whereLike('pixels', '%'.clean($request->pixel).'%');
        }

        if($request->date && $date = date('Y-m-d 00:00:00', strtotime($request->date))){
            $query->whereRaw("DATE(date) < DATE('{$date}')");
        }
        $limit = 15;

        if($request->perpage && is_numeric($request->perpage) && $request->perpage > 15 && $request->perpage <= 100){
            $limit = $request->perpage;
        }
        $results = $query->paginate($limit);

        if($request->page > 1 && !$results) stop(404);

        foreach($results as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $url->url = clean($url->url);
            $urls[] = $url;
        }   
         
        $title = e('Expired Links');

        View::set('title', $title);        
        CDN::load('datetimepicker');
        CDN::load('cropper');
        
        if($user->plan('counttype') == 'monthly'){
            
            $firstday = date('Y-m-01');

            $lastday = date('Y-m-t');

            $count = DB::url()->whereRaw("(date BETWEEN '{$firstday}' AND '{$lastday}') AND userid = ?", $user->rID())->count();

        } else {

            $count = DB::url()->where('userid', $user->rID())->count();

        }

        $total = Auth::user()->plan()['numurls'];
        
        return View::with('user.links', compact('urls', 'title', 'count', 'total'))->extend('layouts.dashboard');   
    }

    /**
     * Generate Clicks Graphs
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function statsClicks(Request $request){

        $response = ['label' => e('Clicks')];

        if(!$request->from || !$request->to){
            $from = date("Y-m-d", strtotime("-14 days"));
            $to = date("Y-m-d", strtotime("+1 day"));
        } else {
            $from = date("Y-m-d H:i:s", strtotime($request->from.' 00:00:00'));
            $to = date("Y-m-d H:i:s", strtotime($request->to.' 23:59:59'));					
        }
        $start = new \DateTime($from);
        $end = new \DateTime($to);

        $diff = $end->diff($start);

        if($diff->y >= 1 || $diff->m > 3){
            $interval = \DateInterval::createFromDateString('1 month');    
        } else {
            $interval = \DateInterval::createFromDateString('1 day');
        }

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            if($diff->y >= 1 || $diff->m > 3){
                $response['data'][e($dt->format("F")).' '.e($dt->format("Y"))] = 0;		
            } else {
                $response['data'][e($dt->format("d")).' '.e($dt->format("F"))] = 0;
            }
        }  
        $response['count']['currentPeriodClicks'] = 0;
        if($diff->y >= 1 || $diff->m > 3){

            $results = DB::stats()
                            ->selectExpr('COUNT(DATE(date))', 'count')
                            ->selectExpr('DATE(date)', 'date')
                            ->where('urluserid', Auth::user()->rID())
                            ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                            ->orderByDesc('date')
                            ->groupByExpr('YEAR(date)')
                            ->groupByExpr('MONTH(date)')                            
                            ->findArray();

            foreach($results as $data){
                $response['count']['currentPeriodClicks'] += (int) $data['count'];
                $response['data'][e(Helper::dtime($data['date'], 'F')).' '.e(Helper::dtime($data['date'], 'Y'))] = (int) $data['count'];
            }   
        }  else {
                $results = DB::stats()
                                ->selectExpr('COUNT(DATE(date))', 'count')
                                ->selectExpr('DATE(date)', 'date')
                                ->where('urluserid', Auth::user()->rID())
                                ->whereRaw("(date BETWEEN '{$from} 00:00:00' AND '{$to} 23:59:59')")
                                ->orderByDesc('date')
                                ->groupByExpr('DATE(date)')
                                ->findArray();
                        
            foreach($results as $data){
                $response['count']['currentPeriodClicks'] += (int) $data['count'];
                $response['data'][e(Helper::dtime($data['date'], 'd')).' '.e(Helper::dtime($data['date'], 'F'))] = (int) $data['count'];
            }
        }

        return (new Response($response))->json(); 
    }
    /**
     * Refresh Links
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function refresh(){
        $urls = [];
        foreach(Url::recent()->where("userid", Auth::user()->rID())->orderByDesc('date')->paginate(15, true) as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

        foreach($urls as $url){
            view('partials.links', compact('url'));
        }
    }
    /**
     * Refresh Archive
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function refreshArchive(){
        $urls = [];
        foreach(DB::url()->where("userid", Auth::user()->rID())->where('archived', 1)->orderByDesc('date')->paginate(15, true) as $url){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            $urls[] = $url;
        }

        foreach($urls as $url){
            view('partials.links', compact('url'));
        }
    }

    /**
     * Search 
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.9.3
     * @param Request $request
     * @return void
     */
    public function search(Request $request){

        $urls =  [];
        
        echo "<script>$('#search button[type=submit]').addClass('d-none'); $('#search button[type=button]').removeClass('d-none');</script>";

        $q = Helper::clean($request->q, 3);

        if(strlen($q) >= 3) {

            if(Helper::isURL($q)){
                $q = trim(trim(Helper::parseUrl($q, 'path')), '/');
            }
            
            $urls = Url::whereAnyIs([
                ['url' => "%{$q}%"],
                ['custom' => "%{$q}%"],
                ['alias' => "%{$q}%"],
                ['meta_title' => "%{$q}%"],
            ], 'LIKE ')->where('userid', Auth::user()->rID())->orderByDesc('click')->limit(50)->findMany();

            if(!$urls) return Response::factory('<div class="card card-body mb-0">'.e('No results found').'</div>')->send();

            echo '<div class="my-4"><h4 class="fw-bold mb-0">'.e('{c} Results', null, ['c' => count($urls)]).'</h4></div>';

            foreach($urls as $url){
                
                if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                    $url->bundlename = $bundle ? $bundle->name : 'na';
                }
                view('partials.links', compact('url'));
            }
       
        } else {
            return Response::factory('<p class="alert alert-danger p-3">'.e('Keyword must be more than 3 characters!').'</p><br>')->send();
        }       
    }   
    /**
     * Fetch Single Link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.5
     * @param \Core\Request $request
     * @return void
     */
    public function fetch(Request $request){

        if(is_numeric($request->id) && $url = Url::where('id', $request->id)->where("userid", Auth::user()->rID())->first()){
            if($url->bundle && $bundle = DB::bundle()->where('id', $url->bundle)->first()){
                $url->bundlename = $bundle ? $bundle->name : 'na';
            }
            view('partials.links', compact('url'));
        }
    }
}