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

use Core\Helper;
use Core\View;
use Core\DB;
use Core\Auth;
use Core\Request;
use Core\Email;
use Models\User;

class Teams {

    use \Traits\Teams;

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('team') === false || Auth::user()->team()){
            return \Models\Plans::notAllowed();
        }
    }

    /**
     * Team Page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public function index(){
        
        $user = Auth::user();

        $teams = [];
        foreach(DB::members()->where('teamid', $user->id)->paginate(15) as $team){
            if(!$team->user = User::where('id', $team->userid)->first()){
                $team->delete();
                continue;
            }
            $permissions = [];
            $html = '';
            foreach(json_decode($team->permission ?? '', true) as $permission){
                if(strpos($permission, '.') !== false){
                    [$category, $actions] = explode('.', $permission);
                    $permissions[$category][] = $actions;
                }else{
                    $permissions[$category] = '';
                }
            }

            foreach($permissions as $category => $actions){
                $html .= "<div class=\"border rounded-3 p-3 mb-2\"><h3 class=\"fw-bold\">".e(ucfirst($category))."</h3>";
                if($actions && is_array($actions)) {
                    $html .= "<p>";
                    foreach($actions as $action){
                        $html .= "<span class=\"badge bg-dark text-white me-2\">".e(ucfirst($action))."</span>";
                    }
                    $html .= "</p></div>";
                }

            }
            $team->permission = $html;
            $teams[] = $team;
        }

        $count = DB::members()->where('teamid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('team');

        $list = $this->permissions();

        View::set('title', e('Manage Members'));

        return View::with('teams.index', compact('teams', 'count', 'total', 'list'))->extend('layouts.dashboard');
    }
    /**
     * Invite Member
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param \Core\Request $request
     * @return void
     */
    public function invite(Request $request){

        \Gem::addMiddleware('DemoProtect');

        $user = Auth::user();
    
        if(Auth::user()->team()) return back()->with("danger", e("You do not have this permission. Please contact your team administrator."));

        $count = DB::members()->where('teamid', Auth::user()->rID())->count();

        $total = Auth::user()->hasLimit('team');

        \Models\Plans::checkLimit($count, $total);

        if(!$request->email || !$request->validate($request->email, 'email')) return back()->with("danger", e("Please enter a valid email."));

        if($invitee = DB::user()->where('email', clean($request->email))->first()){
            
            if($invitee->id == $user->id) return back()->with("danger", e("You cannot invite yourself. Please enter another email."));

            if(DB::members()->where('userid', $invitee->id)->where('teamid', $user->id)->first()){
                return back()->with("danger", e("This email address has been invited."));
            }
        }

        if(!$request->permissions) return back()->with("danger", e("No permission has been assigned for this user."));

        $permissions = \array_map('clean', $request->permissions);

        Helper::set("hashCost", 8);

        if(!$invitee){
            $invitee = DB::user()->create();
            $invitee->email = clean($request->email);

            $invitee->password = Helper::Encode(Helper::rand(16));
            $invitee->date = Helper::dtime();
            $invitee->api = Helper::rand(16);
            $invitee->public = 0;
            $invitee->auth_key = Helper::Encode($invitee->email.Helper::dtime());
            $invitee->active = 0;
        }

        $invitee->uniquetoken = md5($user->id.$user->email.time().Helper::rand(12));
        $invitee->save();

        $member = DB::members()->create();
        $member->userid = $invitee->id;
        $member->teamid = $user->id;
        $member->permission = json_encode($permissions);
        $member->token = $invitee->uniquetoken;
        $member->status = '-1';
        $member->created_at = Helper::dtime();
        $member->save();


        \Helpers\Emails::invite($invitee);

        return back()->with("success", e("An invite has been sent to the email."));
    }
    /**
     * Edit Team
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function edit(int $id){

        if(!$team = DB::members()->where('id', $id)->where('teamid', Auth::user()->rID())->first()){
            return back()->with('danger', e('Team member does not exist.'));
        }

        $team->user = DB::user()->where('id', $team->userid)->first();

        $team->permission = json_decode($team->permission ?? '', true);

        $list = $this->permissions();

        return View::with('teams.edit', compact('team', 'list'))->extend('layouts.dashboard');
    }
    /**
     * Update Team
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function update(Request $request, int $id){

        if(!$team = DB::members()->where('id', $id)->where('teamid', Auth::user()->rID())->first()){
            return back()->with('danger', e('Team member does not exist.'));
        }

        $permissions = \array_map('clean', $request->permissions ?? []);

        $team->permission = json_encode($permissions);

        $team->save();

        return back()->with('success', e('Team member has been updated successfully.'));

    }
    /**
     * Delete team member
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){

        \Gem::addMiddleware('DemoProtect');

        if(!Helper::validateNonce($nonce, 'team.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }
        
        $user = Auth::user();

        if(!$team = DB::members()->where('id', $id)->where('teamid', $user->id)->first()){
            return back()->with('danger', e('Team member does not exist.'));
        }

        $member = DB::user()->where('id', $team->userid)->first();
        if(isset($member->teamid)) $member->teamid = null;
        if(isset($member->teampermission)) $member->teampermission = null;
        $member->save();

        $team->delete();

        return back()->with('success', e('Team member has been removed successfully.'));
    }
    /**
     * Toggle User
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.8
     * @param integer $id
     * @return void
     */
    public function toggle(int $id){
        $user = Auth::user();

        if(!$team = DB::members()->where('id', $id)->where('teamid', $user->id)->first()){
            return back()->with('danger', e('Team member does not exist.'));
        }

        if($team->status == '-1') return back()->with('success', e('Team member needs to accept invitation.'));

        if($team->status == '0'){
            $team->status = '1';
            $team->save();
            return back()->with('success', e('Team member has been enabled.'));
        }else{
            $team->status = '0';
            $team->save();
            return back()->with('success', e('Team member has been disabled.'));
        }
    }
    /**
     * Switch Team
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.8
     * @param string $token
     * @return void
     */
    public function switch(Request $request, string $token){
        
        $user = Auth::user();
        
        if($token == 'default') {
            $request->unset('team_'.$user->id);
            return Helper::redirect()->to(route('dashboard'))->with('success', e('You are now using your individual space.'));
        }

        if(!$team = DB::members()->where('token', clean($token))->where('userid', $user->id)->first()) stop(404);

        $request->session('team_'.$user->id, Helper::encrypt(json_encode(['teamid' => $team->teamid, 'token' => $token])));

        return Helper::redirect()->to(route('dashboard'))->with('success', e('You are now using your team workspace.'));
    }
    /**
     * Accept Invitation
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.8
     * @param \Core\Request $request
     * @param string $token
     * @return void
     */
    public function accept(Request $request, string $token){
        
        $user = Auth::user();    

        if(!$team = DB::members()->where('token', $token)->where('userid', $user->id)->first()) stop(404);

        $user->uniquetoken = Helper::rand(32);

        $team->status = 1;
        $team->save();
        $user->save();
        
        return Helper::redirect()->to(route('dashboard'))->with('success', e("You have accepted your team's invite."));
    }
}