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

class Role extends Model {

	/**	
	 * Table Name
	 */
	public static $_table = DBprefix.'roles';

    /**
     * Check if role has permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @param string $permission
     * @return boolean
     */
    public function hasPermission($permission){
        if($this->id == 1) return true;
        $permissions = json_decode($this->permissions, true);
        return in_array($permission, $permissions);
    }

    /**
     * Get all available permissions
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @return array
     */
    public static function getAvailablePermissions(){
        return [
            'users' => [
                'name' => e('Users'),
                'permissions' => [
                    'users.view' => e('View Users'),
                    'users.create' => e('Create Users'),
                    'users.edit' => e('Edit Users'),
                    'users.delete' => e('Delete Users'),
                    'users.ban' => e('Ban Users'),
                    'users.verify' => e('Verify Users'),
                ]
            ],
            'links' => [
                'name' => e('Links'),
                'permissions' => [
                    'links.view' => e('View Links'),
                    'links.create' => e('Create Links'),
                    'links.edit' => e('Edit Links'),
                    'links.delete' => e('Delete Links'),
                    'links.approve' => e('Approve Links'),
                    'links.disable' => e('Disable Links'),
                ]
            ],
            'qr' => [
                'name' => e('QR Codes'),
                'permissions' => [
                    'qr.view' => e('View QR'),
                    'qr.create' => e('Create QR'),
                    'qr.edit' => e('Edit QR'),
                    'qr.delete' => e('Delete QR'),
                ]
            ],
            'bio' => [
                'name' => e('Bio Pages'),
                'permissions' => [
                    'bio.view' => e('View Bio'),
                    'bio.create' => e('Create Bio'),
                    'bio.edit' => e('Edit Bio'),
                    'bio.delete' => e('Delete Bio'),
                ]
            ],
            'plans' => [
                'name' => e('Plans'),
                'permissions' => [
                    'plans.view' => e('View Plans'),
                    'plans.create' => e('Create Plans'),
                    'plans.edit' => e('Edit Plans'),
                    'plans.delete' => e('Delete Plans'),
                ]
            ],
            'settings' => [
                'name' => e('Settings'),
                'permissions' => [
                    'settings.view' => e('View Settings'),
                    'settings.edit' => e('Edit Settings'),
                    'settings.system' => e('System Settings'),
                ]
            ],
            'statistics' => [
                'name' => e('Statistics'),
                'permissions' => [
                    'stats.view' => e('View Statistics'),
                    'stats.export' => e('Export Statistics'),
                ]
            ],
            'content' => [
                'name' => e('Content'),
                'permissions' => [
                    'pages.view' => e('View Pages'),
                    'pages.create' => e('Create Pages'),
                    'pages.edit' => e('Edit Pages'),
                    'pages.delete' => e('Delete Pages'),
                    'blog.view' => e('View Blog'),
                    'blog.create' => e('Create Blog'),
                    'blog.edit' => e('Edit Blog'),
                    'blog.delete' => e('Delete Blog'),
                    'faq.view' => e('View FAQ'),
                    'faq.create' => e('Create FAQ'),
                    'faq.edit' => e('Edit FAQ'),
                    'faq.delete' => e('Delete FAQ'),
                ]
            ],
            'subscriptions' => [
                'name' => e('Subscriptions'),
                'permissions' => [
                    'subscriptions.view' => e('View Subscriptions')
                ]
            ],
            'payments' => [
                'name' => e('Payments'),
                'permissions' => [
                    'payments.view' => e('View Payments')
                ]
            ],
            'tools' => [
                'name' => e('Tools'),
                'permissions' => [
                    'tools.view' => e('View Tools'),
                    'tools.backup' => e('Backup Data'),
                    'tools.restore' => e('Restore Data'),
                    'tools.update' => e('System Updates'),
                ]
            ],
            'affiliates' => [
                'name' => e('Affiliates'),
                'permissions' => [
                    'affiliates.view' => e('View Affiliates'),
                    'affiliates.pay' => e('Pay Affiliates'),
                ]
            ]
        ];
    }

    /**
     * Get users with this role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @return array
     */
    public function getUsers(){
        return \Core\DB::user()->where('admin', $this->id)->findMany();
    }

    /**
     * Get user count with this role
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.6
     * @return integer
     */
    public function getUserCount(){
        return \Core\DB::user()->where('admin', $this->id)->count();
    }
} 