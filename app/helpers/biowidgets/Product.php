<?php
/**
 * Product Widget
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel <https://gempixel.com>
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com
 */

namespace Helpers\BioWidgets;

use Helpers\App;
use Core\DB;
use Core\View;
use Core\Auth;
use Core\Helper;
use Core\Response;
use Core\Request;
use Core\Plugin;
use Core\Http;
use Helpers\BioWidgets;

class Product {
    /**
     * Product Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'product';

        return "function fnproduct(el, content = null, did = null){

            if(content){
                var text = content['name'] ?? '';
                var description = content['description'] ?? '';
                var amount = content['amount'] ?? '';
                var link = content['link'] ?? '';
            } else {
                var text = '';
                var description = '';
                var amount = '';
                var link = '';
            }
            var blockpreview = text;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);
            

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Name').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][name]" placeholder="e.g. Product" value="\'+text+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Description').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][description]" placeholder="e.g. Product description."  value="\'+description+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Amount').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][amount]" placeholder="e.g. $9.99" value="\'+amount+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Image').'</label>
                                <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept=".jpg, .png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][link]" value="\'+link+\'" placeholder="http://">
                            </div>
                        </div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Save Product
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $appConfig = appConfig('app');
        $sizes = config('sizes');
        $extensions = config('extensions');

        $key = $data['id'];

        if($image = $request->file($key)){
            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->avatar){
                throw new \Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => $extensions->bio->image, 's' => $sizes->bio->avatar]));
            }
            
            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

                if(!file_exists($directory)){
                    mkdir($directory, 0775);
        
                    $f = fopen($directory.'/index.html', 'w');
                    fwrite($f, '');
                    fclose($f);
                }

                $filename = date('Y-m-d')."/profile_producttype".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);
            if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image']);
            }

            $data['image'] = $filename;
        } else {
            $data['image'] = $profiledata['links'][$key]['image'];
        }

        return $data;
    }
    /**
     * Product Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        $imageHtml = (isset($value['image']) && $value['image']) ? 
            '<img src="'.uploads($value['image'], 'profile').'" class="rounded w-100 h-100">' : '';
        
        $contentHtml = '<div class="d-flex align-items-center">
            '.$imageHtml.'
            <div class="flex-grow-1 m-3">
                <h5 class="mb-1 fw-bold">'.$value['name'].'</h5>
                <p class="mb-0 fw-normal">'.$value['description'].'</p>
            </div>
            <div class="text-end">
                <strong class="fs-4">'.$value['amount'].'</strong>
            </div>
        </div>';
        
        if(!empty($value['link'])){
            return '<a href="'.$value['link'].'" target="_blank" class="d-block btn-custom p-3 text-start text-left" rel="nofollow">
                '.$contentHtml.'
            </a>';
        } else {
            return '<div class="d-block btn-custom p-3 text-start text-left">
                '.$contentHtml.'
            </div>';
        }
    }
    /**
     * Delete Product Block Images
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data
     * @return void
     */
    public static function delete($id, $value){
        $appConfig = appConfig('app');
        
        // Handle multiple products
        if(isset($value['image']) && is_array($value['image'])){
            foreach($value['image'] as $image){
                if($image){
                    App::delete($appConfig['storage']['profile']['path'].'/'.$image);
                }
            }
        } else if(isset($value['image']) && $value['image']){
            // Handle single product (backward compatibility)
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
    }
}
