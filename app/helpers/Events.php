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

namespace Helpers;

use Core\View;
use Core\Response;
use Core\Request;
use Core\Helper;
use Core\Http;
use Core\DB;

final class Events {

    private $type = null;
    private $userid = null;
    private $planid = null;

    /**
     * Set event type
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4.3
     * @return void
     */
    public static function for($type){
        $instance = new self();
        $instance->type = $type;
        return $instance;
    }

    /**
     * Set User id
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4.3
     * @param [type] $id
     * @return void
     */
    public function user($id){
        $this->userid = $id;
        return $this;
    }

    /**
     * Set Plan Id
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4.3
     * @param [type] $id
     * @return void
     */
    public function plan($id){
        $this->planid = $id;
        return $this;
    }
    /**
     * Log Event
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4.3
     * @param [type] $data
     * @return void
     */
    public function log($data){

        if(!config('userlogging')) return false;

        $notification = DB::appevents()->create();

        $notification->type = $this->type;
        $notification->data = $data;
        $notification->userid = $this->userid;
        $notification->planid = $this->planid;
        $notification->created_at = Helper::dtime();
        $notification->expires_at = null;
        $notification->save();
    }
}