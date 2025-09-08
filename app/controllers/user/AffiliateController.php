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

use Core\Auth;
use Core\DB;
use Core\Request;
use Core\View;
use Core\Helper;
use Models\User;
use Helpers\Emails;

class Affiliate {
     /**
     * Affiliate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function index(){
        
        if(!config('affiliate')->enabled) {
            stop(404);
        }

        View::set('title', e('Affiliate Referrals'));

        $user = Auth::user();
        
        $total = DB::affiliates()->where('refid', $user->id)->count();

        $sales = DB::affiliates()->where('refid', $user->id)->orderByDesc('referred_on')->paginate(15);

        $totalsales = DB::affiliates()->where('refid', $user->id)->whereRaw('(status = 1 OR status = 3)')->sum('amount');

        $affiliate = config('affiliate');

        return View::with('user.affiliate', compact('user', 'sales', 'affiliate', 'total', 'totalsales'))->extend('layouts.dashboard');
    }
    /**
     * Save Affiliate Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.3.2
     * @param \Core\Request $request
     * @return void
     */
    public function affiliateSave(Request $request){
        if(!config('affiliate')->enabled) {
            stop(404);
        }

        if(!$request->paypal || !$request->validate($request->paypal, 'email')) return back()->with('danger', e("Please enter a valid email."));

        $user = Auth::user();
        $user->paypal = clean($request->paypal);
        $user->save();

        return back()->with('success', e("Account has been successfully updated."));
    }
    /**
     * Show withdrawal history and request form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.3
     * @return void
     */
    public function withdrawals() {
        $user = Auth::user();

        $min_payout = config('affiliate')->payout;

        $pendingpayment = $user->pendingpayment;

        $withdrawals = DB::withdrawals()->where('user_id', $user->id)->orderByDesc('created_at')->findMany();

        View::set('title', e('Withdrawals'));

        return View::with('user.withdrawals', compact('user', 'min_payout', 'pendingpayment', 'withdrawals'))->extend('layouts.dashboard');
    }

    /**
     * Handle withdrawal request
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.3
     */
    public function withdrawalRequest(Request $request) {
        
        $user = Auth::user();
        
        $min_payout = config('affiliate')->payout;
        
        $amount = (float) $user->pendingpayment;

        if($amount < $min_payout) {
            return Helper::redirect()->back()->with('danger', e('You do not have enough balance to request a withdrawal.'));
        }
        if(!$user->paypal || !$request->validate($user->paypal, 'email')) {
            return Helper::redirect()->back()->with('danger', e('Please set a valid PayPal email in your account settings.'));
        }
        
        if(DB::withdrawals()->where('user_id', $user->id)->where('status', 'pending')->first()) {
            return Helper::redirect()->back()->with('danger', e('You already have a pending withdrawal request.'));
        }

        Emails::notifyAdmin([
            'subject' => e('An affiliate withdrawal request was made'), 
            'message' => e('A customer ({e}) requested a withdrawal of {a} to paypal email {pp}', null, ['e' => user()->email, 'a' => \Helpers\App::currency(config('currency'), $amount), 'pp' => $user->paypal])
        ]);

        $withdrawal = DB::withdrawals()->create();
        $withdrawal->user_id = $user->id;
        $withdrawal->amount = $amount;
        $withdrawal->paypal = $user->paypal;
        $withdrawal->status = 'pending';
        $withdrawal->created_at = Helper::dtime('now');
        $withdrawal->save();
        
        $user->pendingpayment = 0;
        $user->save();

        return Helper::redirect()->back()->with('success', e('Your withdrawal request has been submitted.'));
    }
} 