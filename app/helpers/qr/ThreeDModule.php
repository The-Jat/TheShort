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

use BaconQrCode\Encoder\ByteMatrix;
use BaconQrCode\Exception\InvalidArgumentException;
use BaconQrCode\Renderer\Path\Path;
use BaconQrCode\Renderer\Module\ModuleInterface;
/**
 * Renders individual modules as distorted squares with spaces.
 */
final class ThreeDModule implements ModuleInterface
{
    /**
     * @var float
     */
    private $size;

    public function __construct()
    {
        $this->size = 0.80;
    }

    public function createPath(ByteMatrix $matrix) : Path
    {
        $width = $matrix->getWidth();
        $height = $matrix->getHeight();
        $path = new Path();
        $margin = (1 - $this->size) / 2;
        $depth = 0.15; // 3D depth factor

        for ($y = 0; $y < $height; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                if (! $matrix->get($x, $y)) {
                    continue;
                }

                $pathX = $x + $margin;
                $pathY = $y + $margin;
                $randX = 0;
                $randY = 0;
                
                // Front face
                $path = $path
                    ->move($pathX, $pathY)
                    ->line($pathX + $this->size, $pathY+$randY)
                    ->line($pathX + $this->size, $pathY + $this->size)
                    ->line($pathX, $pathY + $this->size)
                    ->line($pathX+$randX, $pathY)
                    ->close();
                
                // Add 3D effect with side and top faces
                $path = $path
                    ->move($pathX, $pathY)
                    ->line($pathX + $depth, $pathY - $depth) // Top-left to top-right of top face
                    ->line($pathX + $this->size + $depth, $pathY - $depth + $randY) // Top-right of top face
                    ->line($pathX + $this->size, $pathY + $randY) // Back to front face
                    ->move($pathX + $this->size, $pathY + $randY)
                    ->line($pathX + $this->size + $depth, $pathY - $depth + $randY) // Right edge top
                    ->line($pathX + $this->size + $depth, $pathY + $this->size - $depth) // Right edge bottom
                    ->line($pathX + $this->size, $pathY + $this->size) // Back to front face
                ;
            }
        }

        return $path;
    }
}
