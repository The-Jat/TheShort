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
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (http://gempixel.com)
 * @copyright 2023 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */
namespace Core;

use Core\Helper;
use Core\Request;

class Middleware {	
	/**
	 * Exempt List
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.7
	 */
	protected $_exempt = [];

	/**
	 * Check if route is allowed
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.7
	 * @return  [type] [description]
	 */
	protected function check(Request $request){
		foreach ($this->_exempt as $ignore) {
			if(strpos($request->path(), str_replace("*", "", $ignore)) !== false) return false;
		}

		return true;
	}
	/**
	 * Add exempts
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.7
	 * @param [type] $exempts
	 * @return void
	 */
	public function add($exempts){
		if(is_array($exempts)) {
			foreach($exempts as $exempt){
				if(is_array($exempt)) {
					foreach($exempt as $exempted){
						if(!in_array($exempted, $this->_exempt)) array_push($this->_exempt, $exempted);
					}
				} else {
					if(!in_array($exempt, $this->_exempt)) array_push($this->_exempt, $exempt);
				}
			}
		}
	}
}
