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

/**
 * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
 * another product without prior authorization, we will take actions to take it down. We will not 
 * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
 */
final class FrameGenerator{
    /**
     * Frame Constructor
     * 
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     */
    static public function build(string $qr, int $size, array $frame){

        $type = $frame['type'] ?? null; 
        $color = $frame['color'] ?? '#000000'; 
        $text = $frame['text'] ? str_replace('&', '&amp;', $frame['text']) : ''; 
        $textcolor = $frame['textcolor'] ?? '#ffffff'; 
        $bg = $frame['bg'] ?? '#ffffff';
        $font = $frame['font'] ?? 'arial';
        
        if(!$bg || empty($bg)) $bg = 'transparent';

        $list = [
			'window' => [self::class, 'window'],
			'popup' => [self::class, 'popup'],
			'camera' => [self::class, 'camera'],
			'phone' => [self::class, 'phone'],
			'arrow' => [self::class, 'arrow'],
			'labeled' => [self::class, 'labeled'],
			'roundedlines' => [self::class, 'roundedlines'],
		];

		if($extended = \Core\Plugin::dispatch('qrframes.extend')){
			foreach($extended as $fn){
				$list = array_merge($list, $fn);
			}
		}

		if(isset($list[$type])) return call_user_func_array($list[$type], [$qr, $size, $color, $text, $textcolor, $bg, $font]);

		return $qr;
    }
    /**
     * Prepare QR code
     *
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     * 
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @param string $qr
     * @return $qr
     */
    private static function prepare(string $qr){
        $qr = str_replace(['<?xml version="1.0" encoding="utf-8"?>', "\n"], '', $qr);
        $qr = strip_tags($qr, '<g><path><image><linearGradient><stop><rect><radialGradient><defs>');
        return $qr;
    }    
    /**
     * Window QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.1
     * @param [type] $qr
     * @param [type] $size
     * @param string $frameColor
     * @param [type] $text
     * @param [type] $textColor
     * @param string $bgColor
     * @param string $font
     * @return void
     */
    private static function window($qr, $size, $frameColor = "#000000", $text = null, $textColor = null, $bgColor = "#ffffff", $font = "Arial"){
        
        $qr = self::prepare($qr);
        
        $width = $size;
        $height = round(0.96*$size);
        $scale = round(0.034*$size);
        $frameWidth = round($size*0.59284);
        $halfPoint = (($size/2) - ($frameWidth/2))/$scale;
        $frameHeight = round($size*0.59284);
        $qrScale = 0.65;
        $qrXY = [round(0.262*$size, 4), round(0.345*$size, 4)];
        $fontsize = 0.1*$size;
        $fontY = 0.105*$size;

        $length = strlen($text);
        
        if($length > 9){        
            if($length < 15) {
                $fontY = 0.99*$fontY;
                $fontsize =  0.8 * $fontsize;
            } else {
                $fontY = 0.99*$fontY;
                $fontsize =  0.7 * $fontsize;
            }
        }

        return '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'.("\n").'<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'"><g transform="scale('.$scale.') translate(2.5 0.1)" fill="'.$frameColor.'"><path d="M 1.3 28 L 22.6 28 C 23.3 28 23.9 27.4 23.9 26.7 L 24 1.4 C 24 0.7 23.33 -0.04 22.63 -0.04 L 1.4 0 C 0.7 0 0.1 0.6 0 1.3 L 0 26.6 C -0.1 27.4 0.5 28 1.3 28 Z M 1 6 C 1 5.4 1.5 5 2 5 L 22 5 C 22.6 5 23 5.5 23 6 L 23 26 C 23 26.6 22.5 27 22 27 L 2 27 C 1.4 27 1 26.5 1 26 L 1 6 Z"/></g>'.($text && !empty($text) ? '<text x="50%" y="'.$fontY.'" dominant-baseline="middle" text-anchor="middle" style="font-size:'.$fontsize.'px;fill:'.$textColor.';font-family:'.$font.',sans-serif;font-weight:bold;">'.$text.'</text>': '').'<rect x="'.(0.118*$size).'" y="'.(0.174*$size).'" width="'.(0.75*$size).'" height="'.(0.748*$size).'" fill="'.$bgColor.'" rx="20" /><g transform="scale('.$qrScale.') translate('.implode(', ', $qrXY).')">'.$qr.'</g></svg>';
    }
    /**
     * Popup Frame
     * 
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @param string $qr
     * @param integer $size
     * @param string $frameColor
     * @param string|null $text
     * @param string|null $textColor
     * @param string $bgColor
     * @param string $font
     * @return $qr
     */
    private static function popup(string $qr, int $size, $frameColor = "#000000", string $text = null, string $textColor = null, $bgColor = "#ffffff", $font = "Arial"){    
        
        $qr = self::prepare($qr);

        $width = $size;
        $height = round(0.96*$size);
        $scale = round(0.0315*$size);
        $frameWidth = round($size*0.59284);
        $halfPoint = (($size/2) - ($frameWidth/2))/$scale;
        $frameHeight = round($size*0.59284);
        $qrScale = 0.68;
        $qrXY = [round(0.228*$size, 4), round(0.35*$size, 4)];
        $fontsize = 0.08*$size;
        $fontY = 0.09*$size;

        $length = strlen($text);
        
        if($length > 9){
            
            if($length < 15) {
                $fontY = 0.99*$fontY;
                $fontsize =  0.8 * $fontsize;
            } else {
                $fontY = 0.99*$fontY;
                $fontsize =  0.7 * $fontsize;
            }
        }

        return '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'.("\n").'<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'"><g transform="scale('.$scale.') translate(3.5 0)" fill="'.$frameColor.'"><path d="M22.7,6L1.3,6C0.6,6,0,6.6,0,7.3l0,21.3C0,29.4,0.6,30,1.3,30l21.3,0c0.7,0,1.3-0.6,1.3-1.3l0-21.3 C24,6.6,23.4,6,22.7,6z M23,28c0,0.6-0.5,1-1,1L2,29c-0.6,0-1-0.5-1-1V8c0-0.6,0.5-1,1-1l20,0c0.6,0,1,0.5,1,1V28z"/><path d="M23,0H1C0.4,0,0,0.4,0,1v3c0,0.5,0.4,1,1,1h10l1,1l1-1h10c0.5,0,1-0.4,1-1V1C24,0.4,23.6,0,23,0z"/></g>'.($text ? '<text x="50%" y="'.$fontY.'" dominant-baseline="middle" text-anchor="middle" style="font-size:'.$fontsize.'px;fill:'.$textColor.';font-family:'.$font.', sans-serif;font-weight:bold;">'.$text.'</text>': '').'<rect x="'.(0.14*$size).'" y="'.(0.224*$size).'" width="'.(0.71*$size).'" height="'.(0.71*$size).'" fill="'.$bgColor.'" rx="20" /><g transform="scale('.$qrScale.') translate('.implode(', ', $qrXY).')">'.$qr.'</g></svg>';
    }
    /**
     * Camera
     *
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     * 
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @param string $qr
     * @param integer $size
     * @param string $frameColor
     * @param string|null $text
     * @param string|null $textColor
     * @param string $bgColor
     * @param string $font
     * @return void
     */
    private static function camera(string $qr, int $size, $frameColor = "#000000", string $text = null, string $textColor = null, $bgColor = "#ffffff", $font = "Arial"){    
        
        $qr = self::prepare($qr);

        $width = $size;
        $height = round(0.96*$size);
        $scale = round(0.0032*$size, 3);
        $frameWidth = round($size*0.59284);
        $halfPoint = (($size/2) - ($frameWidth/2))/$scale;
        $frameHeight = round($size*0.59284);
        $qrScale = 0.55;
        $qrXY = [round(0.39*$size, 4), round(0.6155*$size, 4)];
        $fontsize = 0.08*$size;
        $fontY = 0.11*$size;
        $length = strlen($text);
        
        if($length > 9){
            
            if($length < 15) {
                $fontY = 0.99*$fontY;
                $fontsize =  0.8 * $fontsize;
            } else {
                $fontY = 0.99*$fontY;
                $fontsize =  0.7 * $fontsize;
            }
        }

        return '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'.("\n").'<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'"><g transform="scale('.$scale.') translate(3.5 0)" fill="'.$frameColor.'"><path d="M224.88,93.12h19.39a5,5,0,0,1,5,5v18.73H254V98.12a9.68,9.68,0,0,0-9.68-9.68H224.88Z"></path><path d="M50.73,116.85V98.12a5,5,0,0,1,5-5H73.8V88.44H55.73a9.68,9.68,0,0,0-9.68,9.68v18.73Z"></path><path d="M73.8,291.67H55.73a5,5,0,0,1-5-5V267.94H46.05v18.73a9.68,9.68,0,0,0,9.68,9.68H73.8Z"></path><path d="M249.27,267.94v18.73a5,5,0,0,1-5,5H224.88v4.68h19.39a9.68,9.68,0,0,0,9.68-9.68V267.94Z"></path><path d="M244.75,3.65H55.45A9.25,9.25,0,0,0,46.2,12.9V54.46a9.25,9.25,0,0,0,9.25,9.26H126a2.32,2.32,0,0,1,1.64.67l20.74,20.74a2.33,2.33,0,0,0,3.28,0l20.75-20.74a2.28,2.28,0,0,1,1.64-.67h70.58a9.25,9.25,0,0,0,9.25-9.26V12.9A9.18,9.18,0,0,0,244.75,3.65Z"></path></g>'.($text ? '<text x="50%" y="'.$fontY.'" dominant-baseline="middle" text-anchor="middle" style="font-size:'.$fontsize.'px;fill:'.$textColor.';font-family:'.$font.', sans-serif;font-weight:bold;">'.$text.'</text>': '').'<rect x="'.(0.205*$size).'" y="'.(0.33*$size).'" width="'.(0.57*$size).'" height="'.(0.57*$size).'" fill="'.$bgColor.'" rx="10" /><g transform="scale('.$qrScale.') translate('.implode(', ', $qrXY).')">'.$qr.'</g></svg>';
    }
    /**
     * Phone Frame
     * 
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @param string $qr
     * @param integer $size
     * @param string $frameColor
     * @param string|null $text
     * @param string|null $textColor
     * @param string $bgColor
     * @param string $font
     * @return void
     */
    private static function phone(string $qr, int $size, $frameColor = "#000000", string $text = null, string $textColor = null, $bgColor = "#ffffff", $font = "Arial"){    
        $qr = self::prepare($qr);

        $width = $size;
        $height = round(0.96*$size);
        $scale = round(0.0032*$size, 3);
        $frameWidth = round($size*0.59284);
        $halfPoint = (($size/2) - ($frameWidth/2))/$scale;
        $frameHeight = round($size*0.59284);
        $qrScale = 0.55;
        $qrXY = [round(0.39*$size, 4), round(0.3155*$size, 4)];
        $fontsize = 0.08*$size;
        $fontY = 0.87*$size;
        $length = strlen($text);
        
        if($length > 9){            
            if($length < 15) {
                $fontY = 0.99*$fontY;
                $fontsize =  0.8 * $fontsize;
            } else {
                $fontY = 0.99*$fontY;
                $fontsize =  0.7 * $fontsize;
            }
        }
        return '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'.("\n").'<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'"><g transform="scale('.$scale.') translate(3.5 0)" fill="'.$frameColor.'"><path d="M57.6,251.64H56.27V37.3H57.6Zm185.47,0h1.34V37.3h-1.34Z"></path><path d="M220.31,1.06H80.36a24.08,24.08,0,0,0-24.09,24.1V39.41H244.41V25.16A24.09,24.09,0,0,0,220.31,1.06Zm-51.94,21.1H132.3a2,2,0,0,1,0-4h36.07a2,2,0,0,1,0,4Z"></path><path d="M164.93,241.1l-14.32-12.52L135.9,241.1H56.27v33.3a24.07,24.07,0,0,0,24.09,24.09h140a24.08,24.08,0,0,0,24.1-24.09V241.1Z"></path></g>'.($text ? '<text x="50%" y="'.$fontY.'" dominant-baseline="middle" text-anchor="middle" style="font-size:'.$fontsize.'px;fill:'.$textColor.';font-family:'.$font.', sans-serif;font-weight:bold;">'.$text.'</text>': '').'<rect x="'.(0.195*$size).'" y="'.(0.126*$size).'" width="'.(0.595*$size).'" height="'.(0.650*$size).'" fill="'.$bgColor.'" /><g transform="scale('.$qrScale.') translate('.implode(', ', $qrXY).')">'.$qr.'</g></svg>';
    }
    /**
     * Arrow
     *
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     * 
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @param string $qr
     * @param integer $size
     * @param string $frameColor
     * @param string|null $text
     * @param string|null $textColor
     * @param string $bgColor
     * @param string $font
     * @return void
     */
    private static function arrow(string $qr, int $size, $frameColor = "#000000", string $text = null, string $textColor = null, $bgColor = "#ffffff", $font = "Arial"){  

        $qr = self::prepare($qr);
        
        $width = $size;
        $height = round(0.96*$size);
        $scale = round(0.0032*$size, 3);
        $frameWidth = round($size*0.59284);
        $halfPoint = (($size/2) - ($frameWidth/2))/$scale;
        $frameHeight = round($size*0.59284);
        $qrScale = 0.7;
        $qrXY = [round(0.29*$size, 4), round(0.1*$size, 4)];
        $fontsize = 0.08*$size;
        $fontY = 0.87*$size;

        return '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'.("\n").'<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'"><g transform="scale('.$scale.') translate(-30 0)" fill="'.$frameColor.'"><path d="M 74.713 178.459 C 74.83 176.468 75.016 174.408 75.193 172.417 C 75.369 170.425 75.663 168.424 76.026 166.49 C 76.388 164.557 76.8 162.623 77.27 160.738 C 77.741 158.982 78.378 157.273 79.171 155.633 C 79.23 155.459 79.298 155.218 79.357 154.986 C 79.741 153.118 78.509 151.3 76.613 150.935 L 76.437 150.877 C 76.265 150.832 76.086 150.812 75.908 150.819 C 75.722 150.819 75.604 150.761 75.428 150.761 C 75.252 150.761 74.83 150.703 74.536 150.703 C 73.939 150.703 73.351 150.761 72.753 150.761 C 71.567 150.877 70.431 151.003 69.304 151.177 C 67.058 151.521 64.834 151.989 62.641 152.578 C 60.499 153.201 58.395 153.947 56.341 154.812 C 55.361 155.218 54.313 155.778 53.304 156.165 C 52.294 156.552 51.344 157.219 50.364 157.683 C 49.869 157.968 49.872 158.675 50.37 158.956 C 50.529 159.045 50.715 159.074 50.893 159.037 L 50.962 159.037 C 52.03 158.805 53.039 158.505 54.048 158.273 C 55.057 158.041 56.135 157.809 57.144 157.683 C 59.202 157.302 61.285 157.063 63.376 156.968 C 64.689 156.91 66.051 156.91 67.364 156.91 C 64.662 160.025 62.289 163.404 60.28 166.993 C 57.655 171.725 55.506 176.698 53.862 181.843 C 50.608 192.017 48.956 202.623 48.963 213.292 C 48.92 223.887 50.573 234.423 53.862 244.509 C 57.21 254.531 62.369 263.873 69.088 272.082 C 69.39 272.457 69.934 272.537 70.333 272.265 C 70.741 271.979 70.821 271.414 70.509 271.028 C 64.329 262.805 59.717 253.541 56.9 243.688 C 51.512 223.976 52.405 203.105 59.457 183.912 C 61.201 179.206 63.393 174.675 66.002 170.377 C 67.626 167.709 69.499 165.198 71.597 162.875 C 71.597 164.044 71.597 165.156 71.656 166.336 C 71.773 168.443 71.891 170.503 72.126 172.552 C 72.361 174.602 72.606 176.661 72.959 178.71 C 73.026 179.156 73.396 179.497 73.85 179.532 C 74.317 179.36 74.649 178.947 74.713 178.459 Z"></path></g>'.($text ? '<text x="20%" y="'.$fontY.'" style="font-size:'.$fontsize.'px;fill:'.$textColor.';font-family:'.$font.', sans-serif;font-weight:bold;">'.$text.'</text>': '').'<g transform="scale('.$qrScale.') translate('.implode(', ', $qrXY).')">'.$qr.'</g></svg>';
    }
    /**
     * Labeled
     *
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     * 
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @param string $qr
     * @param integer $size
     * @param string $frameColor
     * @param string|null $text
     * @param string|null $textColor
     * @param string $bgColor
     * @param string $font
     * @return void
     */
    private static function labeled(string $qr, int $size, $frameColor = "#000000", string $text = null, string $textColor = null, $bgColor = "#ffffff", $font = "Arial"){  

        $qr = self::prepare($qr);
        
        $width = $size;
        $height = round(0.96*$size);
        $scale = round(0.0032*$size, 3);
        $frameWidth = round($size*0.59284);
        $halfPoint = (($size/2) - ($frameWidth/2))/$scale;
        $frameHeight = round($size*0.59284);
        $qrScale = 0.60;
        $qrXY = [round(0.32*$size, 4), round(0.12*$size, 4)];
        $fontsize = 0.08*$size;
        $fontY = 0.89*$size;
        $length = strlen($text);
        
        if($length > 9){

            if($length < 15) {
                $fontY = 0.99*$fontY;
                $fontsize =  0.8 * $fontsize;
            } else {
                $fontY = 0.99*$fontY;
                $fontsize =  0.7 * $fontsize;
            }
        }

        return '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'.("\n").'<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'"><g transform="scale('.$scale.') translate(3.5 0)" fill="'.$frameColor.'"><path d="M253.83.69H46.09A11.28,11.28,0,0,0,34.77,12V219.83a11.33,11.33,0,0,0,11.32,11.31H253.91a11.33,11.33,0,0,0,11.32-11.31V12A11.41,11.41,0,0,0,253.83.69Zm2.64,215.59a6.1,6.1,0,0,1-6.11,6.11H49.55a6.1,6.1,0,0,1-6.11-6.11V15.47a6.1,6.1,0,0,1,6.11-6.11H250.36a6.09,6.09,0,0,1,6.11,6.11Z"></path><path id="IconCircleOutline" d="M64.42,246.09A23.53,23.53,0,1,0,88,269.62a23.47,23.47,0,0,0-23.53-23.53Z" fill-opacity="0"></path><path id="PhoneIcon" d="M74.57,254.59v29.73a3.39,3.39,0,0,1-3.38,3.38H56.57a3.39,3.39,0,0,1-3.38-3.38V254.59a3.39,3.39,0,0,1,3.38-3.38H71.19A3.46,3.46,0,0,1,74.57,254.59Zm-15.11.17A1.57,1.57,0,0,0,61,256.33h5.62a1.57,1.57,0,0,0,1.56-1.57,1.62,1.62,0,0,0-1.56-1.57H61.11A1.59,1.59,0,0,0,59.46,254.76ZM72,258.64l-16.43-.17v22H72Zm-10.4,25.43a2.23,2.23,0,1,0,2.23-2.23A2.22,2.22,0,0,0,61.61,284.07Z"></path><path id="PhoneIconBlack" d="M74.57,254.59v29.73a3.39,3.39,0,0,1-3.38,3.38H56.57a3.39,3.39,0,0,1-3.38-3.38V254.59a3.39,3.39,0,0,1,3.38-3.38H71.19A3.46,3.46,0,0,1,74.57,254.59Zm-15.11.17A1.57,1.57,0,0,0,61,256.33h5.62a1.57,1.57,0,0,0,1.56-1.57,1.62,1.62,0,0,0-1.56-1.57H61.11A1.59,1.59,0,0,0,59.46,254.76ZM72,258.64l-16.43-.17v22H72Zm-10.4,25.43a2.23,2.23,0,1,0,2.23-2.23A2.22,2.22,0,0,0,61.61,284.07Z" fill-opacity="0"></path><path d="M235.5,240H64.42a29.68,29.68,0,0,0,0,59.36h171A29.68,29.68,0,0,0,235.5,240ZM64.42,293.15A23.53,23.53,0,1,1,88,269.62,23.47,23.47,0,0,1,64.42,293.15Z"></path></g>'.($text ? '<text x="32%" y="'.$fontY.'" style="font-size:'.$fontsize.'px;fill:'.$textColor.';font-family:'.$font.', sans-serif;font-weight:bold;">'.$text.'</text>': '').'<rect x="'.(0.15*$size).'" y="'.(0.03*$size).'" width="'.(0.682*$size).'" height="'.(0.682*$size).'" fill="'.$bgColor.'" rx="20" /><g transform="scale('.$qrScale.') translate('.implode(', ', $qrXY).')">'.$qr.'</g></svg>';
    }
    /**
     * Rounded Lines QR
     *
     * This is a proprietary code owned by GemPixel coded for Premium URL Shortener, exclusively. If this code is detected in 
     * another product without prior authorization, we will take actions to take it down. We will not 
     * tolerate plagiarism. If you want to use the code, you will need to ask us permission.
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.6.3
     * @param string $qr
     * @param integer $size
     * @param string $frameColor
     * @param string|null $text
     * @param string|null $textColor
     * @param string $bgColor
     * @param string $font
     * @return $qr
     */
    
    private static function roundedlines($qr, $size, $frameColor = "#000000", $text = null, $textColor = null, $bgColor = "#ffffff", $font = "Arial"){
        
        $qr = self::prepare($qr);

        $ratio = $size / 1000;
        $x = $size / 2;
        $r = 0.95 * $x;
        $s = ($size / 80);
        $scale = $ratio * 4.09;
        $qrScale = 0.61;
        $qX = $ratio * 197.272727;

        return '<?xml version="1.0" encoding="UTF-8"?>'.("\n").'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'.("\n").'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 '.$size.' '.$size.'" width="'.$size.'" height="'.$size.'" text-rendering="optimizeLegibility">
        <circle xmlns="http://www.w3.org/2000/svg" cx="'.$x.'" cy="'.$x.'" r="'.$r.'" stroke-width="'.$s.'" stroke="'.$frameColor.'" fill="'.$bgColor.'"></circle>
        <g shape-rendering="auto" transform="translate('.($x/10).', '.($x/10).') scale('.$scale.')">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M121.542 0.69266C121.992 1.39279 121.789 2.32486 121.089 2.77449L113.376 7.72785C112.676 8.17748 111.744 7.97441 111.294 7.27428C110.844 6.57415 111.048 5.64208 111.748 5.19245L119.461 0.239096C120.161 -0.210538 121.093 -0.0074708 121.542 0.69266ZM138.967 2.82857C139.326 2.07821 140.226 1.76143 140.977 2.12103L149.246 6.08409C149.997 6.44368 150.313 7.34348 149.954 8.09384C149.594 8.84421 148.694 9.16099 147.944 8.80139L139.674 4.83833C138.924 4.47873 138.607 3.57893 138.967 2.82857ZM95.7261 2.68062C96.3354 2.11401 97.2887 2.14865 97.8553 2.758L104.092 9.46453C104.658 10.0739 104.623 11.0272 104.014 11.5938C103.405 12.1604 102.451 12.1258 101.885 11.5164L95.6487 4.80988C95.0821 4.20053 95.1167 3.24723 95.7261 2.68062ZM81.1588 6.70382C81.6084 7.40395 81.4053 8.33602 80.7052 8.78566L72.9923 13.739C72.2922 14.1886 71.3601 13.9856 70.9105 13.2854C70.4608 12.5853 70.6639 11.6532 71.364 11.2036L79.0769 6.25026C79.7771 5.80062 80.7091 6.00369 81.1588 6.70382ZM61.1669 11.5466C61.8277 11.0411 62.7733 11.167 63.2789 11.8278L68.8411 19.0989C69.3466 19.7598 69.2207 20.7054 68.5598 21.211C67.899 21.7165 66.9534 21.5906 66.4478 20.9297L60.8856 13.6586C60.3801 12.9978 60.506 12.0522 61.1669 11.5466ZM77.7224 14.6302C78.5248 14.4097 79.3539 14.8814 79.5744 15.6838L81.9973 24.5011C82.2178 25.3034 81.7461 26.1326 80.9438 26.353C80.1415 26.5735 79.3123 26.1018 79.0918 25.2995L76.6689 16.4822C76.4484 15.6798 76.9201 14.8507 77.7224 14.6302ZM143.061 16.2983C143.224 17.1143 142.694 17.9077 141.878 18.0702L132.879 19.8629C132.063 20.0255 131.27 19.4958 131.107 18.6797C130.945 17.8637 131.474 17.0704 132.29 16.9078L141.289 15.1151C142.105 14.9525 142.898 15.4823 143.061 16.2983ZM111.723 15.2558C112.487 15.5846 112.84 16.4707 112.512 17.2351L108.898 25.6381C108.569 26.4025 107.683 26.7557 106.919 26.4269C106.154 26.0982 105.801 25.2121 106.13 24.4477L109.744 16.0447C110.072 15.2803 110.958 14.9271 111.723 15.2558ZM120.675 16.1798C121.354 15.6977 122.294 15.8565 122.776 16.5347L128.08 23.9947C128.563 24.6729 128.404 25.6135 127.726 26.0956C127.047 26.5778 126.107 26.4189 125.625 25.7408L120.321 18.2807C119.838 17.6026 119.997 16.662 120.675 16.1798ZM158.099 17.4085C158.636 18.0441 158.557 18.9947 157.921 19.5317L150.923 25.4456C150.288 25.9827 149.337 25.9029 148.8 25.2673C148.263 24.6318 148.343 23.6812 148.978 23.1441L155.976 17.2303C156.612 16.6932 157.562 16.773 158.099 17.4085ZM87.5346 18.5143C87.7167 17.7024 88.5225 17.1919 89.3345 17.374L98.2871 19.3823C99.099 19.5645 99.6095 20.3703 99.4274 21.1822C99.2452 21.9941 98.4394 22.5046 97.6275 22.3225L88.6749 20.3141C87.863 20.132 87.3525 19.3262 87.5346 18.5143ZM53.3984 18.2381C54.0604 18.7423 54.1882 19.6876 53.684 20.3495L48.1369 27.632C47.6327 28.2939 46.6874 28.4218 46.0255 27.9176C45.3635 27.4134 45.2357 26.4681 45.7399 25.8062L51.287 18.5237C51.7912 17.8617 52.7365 17.7339 53.3984 18.2381ZM164.595 19.6353C164.967 18.8913 165.873 18.5902 166.617 18.9628L174.816 23.069C175.56 23.4417 175.861 24.3468 175.488 25.0908C175.115 25.8348 174.21 26.1359 173.466 25.7633L165.267 21.657C164.523 21.2844 164.222 20.3793 164.595 19.6353ZM24.1967 45.5639C24.9395 45.9388 25.2378 46.8449 24.8629 47.5878L20.7409 55.7553C20.366 56.4982 19.4599 56.7964 18.7171 56.4216C17.9742 56.0467 17.6759 55.1406 18.0508 54.3977L22.1728 46.2301C22.5477 45.4873 23.4538 45.189 24.1967 45.5639ZM192.968 46.0005C193.47 45.3367 194.415 45.2053 195.079 45.7071L202.389 51.2329C203.053 51.7347 203.184 52.6795 202.683 53.3433C202.181 54.0071 201.236 54.1385 200.572 53.6367L193.262 48.1108C192.598 47.6091 192.467 46.6642 192.968 46.0005ZM209.4 61.0839C209.903 61.7466 209.774 62.6917 209.111 63.1948L201.812 68.7358C201.149 69.2389 200.204 69.1095 199.701 68.4467C199.198 67.784 199.327 66.8389 199.99 66.3357L207.289 60.7948C207.952 60.2917 208.897 60.4211 209.4 61.0839ZM16.4827 62.8884C17.1162 62.3489 18.0671 62.4251 18.6066 63.0586L24.5432 70.0297C25.0826 70.6632 25.0064 71.6141 24.3729 72.1536C23.7394 72.6931 22.7886 72.6169 22.2491 71.9834L16.3125 65.0122C15.773 64.3787 15.8492 63.4279 16.4827 62.8884ZM207.654 70.7873C208.353 70.3352 209.286 70.535 209.738 71.2336L214.71 78.917C215.162 79.6155 214.962 80.5483 214.264 81.0004C213.565 81.4524 212.633 81.2526 212.18 80.5541L207.208 72.8707C206.756 72.1721 206.956 71.2393 207.654 70.7873ZM7.13441 71.0004C7.88369 71.3622 8.19778 72.263 7.83593 73.0122L3.85765 81.2502C3.4958 81.9995 2.59506 82.3136 1.84578 81.9518C1.09649 81.5899 0.782411 80.6892 1.14425 79.9399L5.12254 71.7019C5.48438 70.9526 6.38513 70.6385 7.13441 71.0004ZM198.909 74.8153C199.736 74.7235 200.481 75.3195 200.573 76.1465L201.581 85.2328C201.673 86.0598 201.077 86.8047 200.25 86.8964C199.423 86.9882 198.678 86.3922 198.586 85.5652L197.578 76.4789C197.486 75.6519 198.082 74.9071 198.909 74.8153ZM10.9607 81.4324C11.2873 80.6671 12.1725 80.3114 12.9378 80.6381L21.3731 84.238C22.1384 84.5646 22.494 85.4498 22.1674 86.2151C21.8408 86.9804 20.9556 87.336 20.1903 87.0094L11.755 83.4094C10.9897 83.0828 10.6341 82.1977 10.9607 81.4324ZM206.485 90.4873C206.865 91.2272 206.574 92.1356 205.834 92.5162L197.68 96.7103C196.94 97.0909 196.032 96.7996 195.651 96.0597C195.27 95.3197 195.562 94.4114 196.302 94.0308L204.456 89.8366C205.196 89.456 206.104 89.7473 206.485 90.4873ZM28.8009 93.5021C29.2321 94.2138 29.0047 95.1402 28.2931 95.5714L20.4526 100.322C19.741 100.753 18.8146 100.526 18.3834 99.8141C17.9522 99.1025 18.1795 98.176 18.8912 97.7448L26.7316 92.9943C27.4433 92.5631 28.3697 92.7905 28.8009 93.5021ZM218.301 95.5102C218.865 96.1217 218.827 97.0749 218.215 97.6392L211.483 103.851C210.872 104.416 209.918 104.377 209.354 103.766C208.79 103.154 208.828 102.201 209.44 101.637L216.172 95.4247C216.783 94.8604 217.737 94.8987 218.301 95.5102ZM0.688233 99.3043C1.38679 98.8522 2.31956 99.052 2.77164 99.7506L7.74402 107.434C8.1961 108.133 7.99629 109.065 7.29773 109.517C6.59917 109.969 5.6664 109.77 5.21432 109.071L0.241942 101.388C-0.210135 100.689 -0.0103233 99.7564 0.688233 99.3043ZM193.626 104.985C193.953 104.22 194.838 103.864 195.603 104.191L204.038 107.791C204.804 108.117 205.159 109.002 204.833 109.768C204.506 110.533 203.621 110.889 202.856 110.562L194.42 106.962C193.655 106.635 193.299 105.75 193.626 104.985ZM17.6913 110.766C18.0179 110.001 18.9031 109.645 19.6684 109.972L28.1037 113.572C28.869 113.898 29.2246 114.783 28.898 115.549C28.5714 116.314 27.6862 116.67 26.9209 116.343L18.4856 112.743C17.7203 112.417 17.3647 111.531 17.6913 110.766ZM212.702 111.016C213.401 110.564 214.334 110.764 214.786 111.463L219.758 119.146C220.21 119.845 220.01 120.777 219.312 121.229C218.613 121.681 217.68 121.482 217.228 120.783L212.256 113.1C211.804 112.401 212.004 111.468 212.702 111.016ZM10.6459 116.768C11.2102 117.379 11.1719 118.332 10.5604 118.897L3.8281 125.109C3.21659 125.673 2.26342 125.635 1.69915 125.024C1.13487 124.412 1.17316 123.459 1.78467 122.895L8.51697 116.682C9.12848 116.118 10.0816 116.156 10.6459 116.768ZM210.03 120.72C210.461 121.431 210.234 122.358 209.522 122.789L201.682 127.539C200.97 127.971 200.044 127.743 199.612 127.032C199.181 126.32 199.409 125.394 200.12 124.962L207.961 120.212C208.672 119.781 209.599 120.008 210.03 120.72ZM20.2726 121.332C21.0842 121.515 21.5934 122.322 21.41 123.133L19.3939 132.052C19.2104 132.863 18.4038 133.372 17.5922 133.189C16.7806 133.006 16.2714 132.199 16.4548 131.387L18.4709 122.469C18.6544 121.657 19.461 121.148 20.2726 121.332ZM195.309 135.995C195.635 135.23 196.52 134.874 197.286 135.201L205.721 138.8C206.486 139.127 206.842 140.012 206.515 140.778C206.189 141.543 205.304 141.898 204.538 141.572L196.103 137.972C195.338 137.645 194.982 136.76 195.309 135.995ZM218.154 138.582C218.904 138.944 219.218 139.845 218.856 140.594L214.877 148.832C214.516 149.581 213.615 149.895 212.866 149.533C212.116 149.172 211.802 148.271 212.164 147.521L216.142 139.283C216.504 138.534 217.405 138.22 218.154 138.582ZM25.4574 139.751C25.6763 140.554 25.203 141.382 24.4002 141.601L15.549 144.014C14.7463 144.233 13.918 143.76 13.6991 142.957C13.4802 142.154 13.9535 141.326 14.7563 141.107L23.6075 138.694C24.4102 138.475 25.2385 138.948 25.4574 139.751ZM5.73619 139.533C6.43474 139.081 7.36751 139.281 7.81959 139.98L12.792 147.663C13.244 148.362 13.0442 149.294 12.3457 149.746C11.6471 150.199 10.7144 149.999 10.2623 149.3L5.2899 141.617C4.83782 140.918 5.03763 139.985 5.73619 139.533ZM195.627 148.38C196.261 147.841 197.211 147.917 197.751 148.55L203.688 155.521C204.227 156.155 204.151 157.106 203.517 157.645C202.884 158.185 201.933 158.109 201.393 157.475L195.457 150.504C194.917 149.87 194.994 148.92 195.627 148.38ZM20.2991 152.087C20.8022 152.75 20.6728 153.695 20.0101 154.198L12.7111 159.739C12.0483 160.242 11.1032 160.113 10.6001 159.45C10.097 158.787 10.2264 157.842 10.8891 157.339L18.1882 151.798C18.8509 151.295 19.796 151.424 20.2991 152.087ZM201.283 164.112C202.026 164.487 202.324 165.393 201.949 166.136L197.827 174.304C197.452 175.046 196.546 175.345 195.803 174.97C195.061 174.595 194.762 173.689 195.137 172.946L199.259 164.778C199.634 164.036 200.54 163.737 201.283 164.112ZM17.3173 167.19C17.819 166.527 18.7639 166.395 19.4277 166.897L26.7381 172.423C27.4019 172.925 27.5333 173.869 27.0315 174.533C26.5298 175.197 25.585 175.328 24.9212 174.827L17.6107 169.301C16.9469 168.799 16.8155 167.854 17.3173 167.19ZM115.681 192.194C116.445 192.522 116.799 193.408 116.47 194.173L112.856 202.576C112.527 203.34 111.641 203.693 110.877 203.365C110.112 203.036 109.759 202.15 110.088 201.385L113.702 192.982C114.03 192.218 114.917 191.865 115.681 192.194ZM174.891 194.055C175.553 194.559 175.681 195.505 175.177 196.167L169.63 203.449C169.126 204.111 168.18 204.239 167.518 203.735C166.857 203.231 166.729 202.285 167.233 201.623L172.78 194.341C173.284 193.679 174.23 193.551 174.891 194.055ZM139.973 195.62C140.775 195.399 141.605 195.871 141.825 196.673L144.248 205.491C144.468 206.293 143.997 207.122 143.194 207.343C142.392 207.563 141.563 207.091 141.343 206.289L138.92 197.472C138.699 196.669 139.171 195.84 139.973 195.62ZM45.4289 196.882C45.8015 196.138 46.7067 195.837 47.4506 196.21L55.6496 200.316C56.3936 200.688 56.6947 201.594 56.322 202.338C55.9494 203.082 55.0443 203.383 54.3003 203.01L46.1013 198.904C45.3573 198.531 45.0563 197.626 45.4289 196.882ZM72.1169 196.706C72.654 197.341 72.5742 198.292 71.9386 198.829L64.9407 204.743C64.3052 205.28 63.3546 205.2 62.8175 204.564C62.2804 203.929 62.3602 202.978 62.9958 202.441L69.9937 196.527C70.6292 195.99 71.5798 196.07 72.1169 196.706ZM105.246 198.963C105.388 199.783 104.837 200.562 104.017 200.703L94.9746 202.261C94.1546 202.402 93.3754 201.852 93.2342 201.032C93.0929 200.212 93.6432 199.432 94.4632 199.291L103.506 197.734C104.326 197.592 105.105 198.143 105.246 198.963ZM86.2346 198.898C86.999 199.227 87.3521 200.113 87.0234 200.878L83.4096 209.281C83.0809 210.045 82.1947 210.398 81.4304 210.069C80.666 209.741 80.3128 208.855 80.6415 208.09L84.2553 199.687C84.584 198.923 85.4702 198.57 86.2346 198.898ZM121.49 200.791C121.672 199.979 122.478 199.468 123.289 199.65L132.242 201.659C133.054 201.841 133.564 202.647 133.382 203.459C133.2 204.27 132.394 204.781 131.582 204.599L122.63 202.591C121.818 202.408 121.307 201.603 121.49 200.791ZM152.357 200.762C153.018 200.256 153.964 200.382 154.469 201.043L160.031 208.314C160.537 208.975 160.411 209.921 159.75 210.426C159.089 210.932 158.144 210.806 157.638 210.145L152.076 202.874C151.57 202.213 151.696 201.267 152.357 200.762ZM150.006 208.687C150.456 209.388 150.253 210.32 149.553 210.769L141.84 215.723C141.14 216.172 140.208 215.969 139.758 215.269C139.309 214.569 139.512 213.637 140.212 213.187L147.925 208.234C148.625 207.784 149.557 207.987 150.006 208.687ZM116.903 210.379C117.512 209.812 118.465 209.847 119.032 210.456L125.268 217.163C125.835 217.772 125.8 218.726 125.191 219.292C124.582 219.859 123.628 219.824 123.062 219.215L116.825 212.508C116.259 211.899 116.293 210.946 116.903 210.379ZM98.9598 211.956C99.3062 211.199 100.2 210.867 100.957 211.213L109.295 215.032C110.051 215.379 110.384 216.273 110.037 217.029C109.691 217.786 108.797 218.118 108.04 217.772L99.7022 213.953C98.9457 213.607 98.6133 212.712 98.9598 211.956ZM70.9631 213.879C71.3227 213.129 72.2225 212.812 72.9729 213.172L81.2425 217.135C81.9929 217.494 82.3097 218.394 81.9501 219.144C81.5905 219.895 80.6907 220.211 79.9403 219.852L71.6707 215.889C70.9203 215.529 70.6035 214.629 70.9631 213.879Z" fill="'.$frameColor.'"></path></g><g transform="translate('.$qX.', '.$qX.') scale('.$qrScale.')">'.$qr.'</g></svg>';
    }
}


