<?php 
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact GemPixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package GemFramework
 * @author GemPixel (http://gempixel.com) 
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

namespace Models;

use Gem;
use Core\Model;
use Core\Helper;

class User extends Model {

	/**	
	 * Table Name
	 */
	public static $_table = DBprefix.'user';

	/**
	 * Auth Key Name
	 */
	const AUTHKEY = 'auth_key';

	/**
	 * Return id or teamid for resources
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function rID(){

		$team = null;

		if($session = request()->session('team_'.$this->id)){
			$data = json_decode(\Core\Helper::decrypt($session));
			if(isset($data->teamid) && isset($data->token)){
				$team = \Core\DB::members()->where('teamid', clean($data->teamid))->where('userid', $this->id)->where('status', 1)->first();
			}
		}
		
		return $team ? $team->teamid : $this->id;
	}	
	/**
	 * User avatar
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function avatar(){
		
		if($this->avatar) {
			return \Core\View::uploads($this->avatar, 'avatar');
		}

		if($this->auth == "facebook" && !empty($this->auth_id)){
			return "https://graph.facebook.com/".$this->auth_id."/picture?type=large";
		}else{
			return config('gravatar') ? "https://www.gravatar.com/avatar/".md5(trim($this->email ?? ''))."?s=200&d=identicon" : assets('images/user.png');
		}	
	}
	/**
	 * Refresh Plans
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.1.6
	 * @return void
	 */
	public function refresh(){
		unset(Gem::$App['userplan']);
		return $this;
	}
	/**
	 * Get User Plan
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function plan($limit = null){
			
		if(!isset(Gem::$App['userplan'])) {
			if($this->planid && $data = \Core\DB::plans()->where('id', $this->planid)->first()) {
				$plan = $data->asArray();
			} else {
				$plan = [];
			}
			Gem::$App['userplan'] = !config('pro') || $this->admin || is_null($this->planid) ? \Helpers\App::defaultPlan() : $plan;
		}

		if($limit) {
			return isset(Gem::$App['userplan'][$limit]) ? Gem::$App['userplan'][$limit] : false;
		}			

		return Gem::$App['userplan'];
	}
	/**
	 * Check User Permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $permission
	 * @return boolean
	 */
	public function has($permission){	

		if(!config('pro')) return true;

		if(!$this->admin && !$this->planid) return false;

		$plan = $this->plan();	
		
		if(!$plan) return false;

		$plan["permission"] = json_decode($plan["permission"]);		

		if(isset($plan["permission"]->{$permission}) && $plan["permission"]->{$permission}->enabled){			
			return true;
		}
		return false;
	}

	/**
	 * Check User Role Permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.6.6
	 * @param string $permission
	 * @return boolean
	 */
	public function hasRolePermission($permission){

		// Check if user has a role
		if(!$this->admin) return false;

		$role = \Models\Role::first($this->admin);
		if(!$role) return false;

		return $role->hasPermission($permission);
	}

	/**
	 * Get user role
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.6.6
	 * @return Models\Role|null
	 */
	public function getRole(){
		if(!$this->admin) return null;
		return \Models\Role::first($this->admin);
	}

	/**
	 * Assign role to user
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.6.6
	 * @param integer $roleId
	 * @return void
	 */
	public function assignRole($roleId){
		$this->admin = $roleId;
		$this->save();
	}

	/**
	 * Remove role from user
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.6.6
	 * @return void
	 */
	public function removeRole(){
		$this->admin = 0;
		$this->save();
	}
	/**
	 * Count User Permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $permission
	 * @return boolean
	 */	
	public function hasLimit($permission){

		if(!config('pro')) return 0;
		
		$plan = $this->plan();	

		if(!$plan) return false;
		
		$plan["permission"] = json_decode($plan["permission"]);	
		if(isset($plan["permission"]->{$permission}) && $plan["permission"]->{$permission}->enabled){		
			if(isset($plan["permission"]->{$permission}->count)){
				return $plan["permission"]->{$permission}->count;
			}
		}

		return false;
	}
	/**
	 * Check if user is in a team
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.8
	 * @return void
	 */
	public function team(){

		if($session = request()->session('team_'.$this->id)){
			$data = json_decode(\Core\Helper::decrypt($session));
			if(isset($data->teamid) && isset($data->token)){
				return \Core\DB::members()->where('teamid', clean($data->teamid))->where('userid', $this->id)->where('status', 1)->first();
			}
		}

		return false;
	}
	/**
	 * Find all teams
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.8
	 * @return void
	 */
	public function teams(){
		return \Core\DB::members()->where('userid', $this->id)->where('status', 1)->map(function($team){
			$team->user = \Core\Auth::getUser($team->teamid);
			return $team;
		});
	}
	/**
	 * View team permission
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.8
	 * @param string $permission
	 * @return void
	 */
	public function teamPermission(string $permission){

		if($session = request()->session('team_'.$this->id)){
			$data = json_decode(\Core\Helper::decrypt($session));
			if(isset($data->teamid) && isset($data->token)){
				$team = \Core\DB::members()->where('teamid', clean($data->teamid))->where('userid', $this->id)->first();
			}
			if(!$team) return false;

			$permissions = json_decode($team->permission, true);
	
			if(in_array($permission, $permissions)) return true;
			
			return false;
		}

		return true;
	}		
	/**
	 * Get user pixels list
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public function pixels(){
		$list = [];
		
		$query = \Core\DB::pixels()->where('userid', $this->rID())->orderByDesc('type');
		$total = $this->hasLimit('pixels');

		if($total > 0) {
			$db = $query->limit($total)->findMany();
		} else {
			$db = $query->findMany();
		}

		foreach($db as $pixel){
			    
			$list[\Helpers\App::pixelName($pixel->type)][] = $pixel;
		}

		return $list;
	}
	/**
	 * Check if user is pro
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @return void
	 */
	public function pro(){
		
		if(!config('pro')) return true;

		if($this->admin || $this->pro) return true;

		if($this->team()){
			if($user = \Core\DB::user()->where('id', $this->rID())->first()){
				if($user->pro) return true;
			}
		}

		return false;
	}
	/**
	 * Check if user has access to billing portal
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.6
	 * @return boolean
	 */
	public function hasPortal(){
		
		if(!\Helpers\App::possible()) return false;

		if(!$subscription = \Core\DB::subscription()->where('userid', $this->id)->where('status', 'Active')->first()) return false;
		
		$subscription->data = json_decode($subscription->data);

		if(!isset($subscription->data->paymentmethod)) return false;

		if($subscription->data->paymentmethod == 'Stripe' && config('stripe')->enabled && config('stripe')->type == 'stripe') return true;

		if($subscription->data->paymentmethod == 'Paddle' && config('paddle')->enabled) return true;

		return false;
	}
	/**
	 * Starred Channels
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.4
	 * @return void
	 */
	public function starredChannels(){

		$query = \Core\DB::channels()->where('userid', $this->rID())->where('starred', 1)->orderByAsc('name');
		$total = $this->hasLimit('channels');

		if($total > 0) {
			return $query->limit($total)->findMany();
		} else {
			return $query->findMany();
		}
	}
	/**
	 * User Channels
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.5.1
	 * @return void
	 */
	public function channels(){
		
		$query = \Core\DB::channels()->where('userid', $this->rID())->orderByAsc('name');

		$total = $this->hasLimit('channels');

		if($total > 0) {
			return $query->limit($total)->findMany();
		} else {
			return $query->findMany();
		}
	}
	/**
	 * User Notification
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.4.3
	 * @return void
	 */
	public function notifications(){
		if($notifications = \Core\DB::appevents()->whereRaw("type='notification' AND (userid IS NULL OR userid = '$this->id') AND (planid IS NULL OR planid = '".($this->planid ?? '0')."') AND (expires_at IS NULL OR DATE(expires_at) > DATE('".Helper::dtime()."'))")->limit(10)->orderByDesc('id')->findMany()){

			$list = new \stdClass;
			$list->list = [];
			$list->count = count($notifications);
			foreach($notifications as $notification){
				$data = json_decode($notification->data);
				$list->list[] = $data->content;
				$list->dates[] =  $notification->created_at ? \Core\Helper::timeago($notification->created_at) : null;
			}
			$list->signature = md5(implode(',', $list->list));

			return $list;
		}
		return false;
	}
	/**
	 * Check if key has endpoint access
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.6
	 * @param [type] $permission
	 * @return void
	 */
	public function keyCan($permission){
		$customkey = request()->session('customkey');

		if($customkey) {		

			$key = \Core\DB::apikeys()->where('apikey', clean($customkey))->where('userid', $this->id)->first();

			if(!$key) return false;

			$permissions = json_decode($key->permissions, true);

			if(in_array('all', $permissions)) return true;
	
			if(in_array($permission, $permissions)) return true;

			return false;
		}

		return true;
	}
}