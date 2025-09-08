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

declare(strict_types = 1);

namespace Helpers\Qr;

use BaconQrCode\Renderer\Path\Path;
use BaconQrCode\Renderer\Eye\EyeInterface;


final class Diamond implements EyeInterface
{
    /**
     * @var self|null
     */
    private static $instance;

    private function __construct()
    {
    }

    public static function instance() : self
    {
        return self::$instance ?: self::$instance = new self();
    }

    public function getExternalPath() : Path
    {
       
    }

    public function getInternalPath() : Path
    {
        return (new Path())                  
            ->move(1.5, 0)
            ->ellipticArc(0., 0., 0., false, true, 0., 1.5)
            ->ellipticArc(0., 0., 0., false, true, -1.5, 0.)
            ->ellipticArc(0., 0., 0., false, true, 0., -1.5)
            ->ellipticArc(0., 0., 0., false, true, 1.5, 0.)
            ->close()
        ;
    }
}