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
use BaconQrCode\Renderer\Eye\SimpleCircleEye;
use BaconQrCode\Renderer\Eye\SquareEye;

final class EyeGenerator implements EyeInterface
{
    /**
     * @var self|null
     */
    private static $instance;

    private static $frame = 'square';

    private static $eye = 'square';

    /**
     * Eye Styles
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     */
    private static $eyestyles = [
        'eye' => Eye::class,
        'circle' => Circle::class,
        'diamond' => Diamond::class,
        'square' => SquareEye::class,
        'butterfly' => Butterfly::class,
        'rounded' => RoundedSquare::class,
        'eyeinverted' => EyeInverted::class,
        'bubble' => RoundedCornerSquare::class,
        'hexagon' => Hexagon::class
    ];

    /**
     * Frame Styles
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     */
    private static $framestyles = [
        'eye' => Eye::class,
        'circle' => Circle::class,
        'square' => SquareEye::class,
        'rounded' => RoundedSquare::class,
        'eyeinverted' => EyeInverted::class,
        'bubble' => RoundedCornerSquare::class,
        'hexagon' => Hexagon::class
    ];

    private function __construct()
    {
    }

    public static function instance($eye = null, $frame = null) : self
    {
        self::$eye = array_key_exists($eye, self::$eyestyles) ? self::$eyestyles[$eye] : self::$eyestyles['square'];

        self::$frame = array_key_exists($frame, self::$framestyles) ? self::$framestyles[$frame] : self::$framestyles['square'];

        return self::$instance ?: self::$instance = new self();
    }

    public function getExternalPath() : Path
    {

        $fn = \call_user_func([self::$frame, 'instance']);

        return $fn->getExternalPath();
    }

    public function getInternalPath() : Path
    {
        $fn = \call_user_func([self::$eye, 'instance']);

        return $fn->getInternalPath();
    }

    public function getRotation()
    {
        if(method_exists(self::$eye, 'getRotation')){
            $fn = \call_user_func([self::$eye, 'instance']);
            return $fn->getRotation();
        }

        if(method_exists(self::$frame, 'getRotation')){
            $fn = \call_user_func([self::$frame, 'instance']);
            return $fn->getRotation();
        }
        
        return [0, 90, -90];
    }
}