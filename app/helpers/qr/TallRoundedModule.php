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
final class TallRoundedModule implements ModuleInterface
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
        $horizontalGap = 0.1;

        for ($y = 0; $y < $height; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                if (! $matrix->get($x, $y)) {
                    continue;
                }         
                
                $pathX = $x + $margin + ($horizontalGap / 2);
                $pathY = $y + $margin;
                $hasTop = $y > 0 && $matrix->get($x, $y - 1);
                $hasBottom = $y < $height - 1 && $matrix->get($x, $y + 1);
                $adjustedSize = $this->size - $horizontalGap;
                
                $path = $path->move($pathX, $pathY + ($hasTop ? 0 : $radius));
                $path = $path
                    ->curve(
                        $pathX, $pathY,
                        $pathX, $pathY,
                        $pathX + $radius, $pathY
                    );
                $path = $path->line($pathX + $adjustedSize - $radius, $pathY);
                $path = $path
                    ->curve(
                        $pathX + $adjustedSize, $pathY,
                        $pathX + $adjustedSize, $pathY,
                        $pathX + $adjustedSize, $pathY + ($hasTop ? 0 : $radius)
                    );
                $path = $path->line($pathX + $adjustedSize, $pathY + $this->size - ($hasBottom ? 0 : $radius));
                $path = $path
                    ->curve(
                        $pathX + $adjustedSize, $pathY + $this->size,
                        $pathX + $adjustedSize, $pathY + $this->size,
                        $pathX + $adjustedSize - $radius, $pathY + $this->size
                    );
                $path = $path->line($pathX + $radius, $pathY + $this->size);
                $path = $path
                    ->curve(
                        $pathX, $pathY + $this->size,
                        $pathX, $pathY + $this->size,
                        $pathX, $pathY + $this->size - ($hasBottom ? 0 : $radius)
                    );
                $path = $path->line($pathX, $pathY + ($hasTop ? 0 : $radius));              
                $path = $path->close();
            }
        }

        return $path;
    }
}
