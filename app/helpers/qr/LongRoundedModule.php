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
 * Renders individual modules as squares with spaces.
 */
final class LongRoundedModule implements ModuleInterface
{
    /**
     * @var float
     */
    private $size;

    public function __construct()
    {
        $this->size = 1;
    }

    public function createPath(ByteMatrix $matrix) : Path
    {
        $width = $matrix->getWidth();
        $height = $matrix->getHeight();
        $path = new Path();
        $margin = (1 - $this->size) / 2;
        $radius = 0.8;
        $verticalGap = 0.1;

        for ($y = 0; $y < $height; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                if (! $matrix->get($x, $y)) {
                    continue;
                }         
                
                $pathX = $x + $margin;
                $pathY = $y + $margin + ($verticalGap / 2);
                $hasRight = $x < $width - 1 && $matrix->get($x + 1, $y);
                $hasLeft = $x > 0 && $matrix->get($x - 1, $y);
                $adjustedSize = $this->size - $verticalGap;
                $path = $path->move($pathX, $pathY + $radius);
                $path = $path
                    ->curve(
                        $pathX, $pathY,
                        $pathX, $pathY,
                        $pathX + ($hasLeft ? 0 : $radius), $pathY
                    );
                $path = $path->line($pathX + $this->size - ($hasRight ? 0 : $radius), $pathY);
                $path = $path
                    ->curve(
                        $pathX + $this->size, $pathY,
                        $pathX + $this->size, $pathY,
                        $pathX + $this->size, $pathY + $radius
                    );
                $path = $path->line($pathX + $this->size, $pathY + $adjustedSize - $radius);
                $path = $path
                    ->curve(
                        $pathX + $this->size, $pathY + $adjustedSize,
                        $pathX + $this->size, $pathY + $adjustedSize,
                        $pathX + $this->size - ($hasRight ? 0 : $radius), $pathY + $adjustedSize
                    );
                $path = $path->line($pathX + ($hasLeft ? 0 : $radius), $pathY + $adjustedSize);
                $path = $path
                    ->curve(
                        $pathX, $pathY + $adjustedSize,
                        $pathX, $pathY + $adjustedSize,
                        $pathX, $pathY + $adjustedSize - $radius
                    );
                $path = $path->line($pathX, $pathY + $radius);              
                $path = $path->close();
            }
        }

        return $path;
    }
}
