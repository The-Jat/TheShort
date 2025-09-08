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

namespace Traits;

use Core\Request;
use Core\DB;
use Core\Helper;
use User\Overlay;

trait Teams {
    /**
     * Permissions
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5     
     * @return void
     */
	public static function permissions(){
        $list = [
            'links' => [
                'available' => true,
                'name' => e("Links"),
                'permissions' => [
                    'create' => e("Create Links"),
                    'edit' => e("Edit Links"),
                    'delete' => e("Delete Links"),
                ]
            ],
            'qr' => [
                'available' => (user()->has("qr") !== false),
                'name' => e("QR Codes"),
                'permissions' => [
                    'create' => e("Create QR"),
                    'edit' => e("Edit QR"),
                    'delete' => e("Delete QR"),
                ]
            ],
            'bio' => [
                'available' => (user()->has("bio") !== false),
                'name' => e("Bio Pages"),
                'permissions' => [
                    'create' => e("Create Bio"),
                    'edit' => e("Edit Bio"),
                    'delete' => e("Delete Bio"),
                ]
            ],
            'splash' => [
                'available' => (user()->has("splash") !== false),
                'name' => e("Custom Splash"),
                'permissions' => [
                    'create' => e("Create Splash"),
                    'edit' => e("Edit Splash"),
                    'delete' => e("Delete Splash"),
                ]
            ],
            'overlay' => [
                'available' => (user()->has("overlay") !== false),
                'name' => e("CTA Overlay"),
                'permissions' => [
                    'create' => e("Create Overlay"),
                    'edit' => e("Edit Overlay"),
                    'delete' => e("Delete Overlay"),
                ]
            ],
            'pixels' => [
                'available' => (user()->has("pixels") !== false),
                'name' => e("Tracking Pixels"),
                'permissions' => [
                    'create' => e("Create Pixels"),
                    'edit' => e("Edit Pixels"),
                    'delete' => e("Delete Pixels"),
                ]
            ],
            'domain' => [
                'available' => (user()->has("domain") !== false),
                'name' => e("Branded Domain"),
                'permissions' => [
                    'create' => e("Add Custom Domain"),
                    'delete' => e("Delete Custom Domain"),
                ]
            ],
            'bundle' => [
                'available' => (user()->has("bundle") !== false),
                'name' => e("Campaigns").'/'.e('Channels'),
                'permissions' => [
                    'create' => e("Create Campaigns").'/'.e('Channels'),
                    'edit' => e("Edit Campaigns").'/'.e('Channels'),
                    'delete' => e("Delete Campaigns").'/'.e('Channels'),
                ]
            ],
            'api' => [
                'available' => (user()->has("api") !== false),
                'name' => e('Developer API'),
                'permissions' => [
                    'create' => e("Developer API"),
                ]
            ],
            'export' => [
                'available' => (user()->has("export") !== false),
                'name' => e('Export'),
                'permissions' => [
                    'create' => e("Export Data"),
                ]
            ]
        ];

        if($extended = \Core\Plugin::dispatch('teampermissions.extend')){
			foreach($extended as $fn){
				$list = array_merge($list, $fn);
			}
		}

		return $list;
    }   
}