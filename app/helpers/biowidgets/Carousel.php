<?php
/**
 * Carousel Widget
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

class Carousel {
    /**
     * Carousel Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.8
     * @return void
     */
    public static function setup(){

        $type = 'carousel';

        return "function fncarousel(el, content = null, did = null){

            var images = (content && content['images']) ? content['images'] : [];

            var blockpreview = images.length > 0 ? images.length + ' images' : '".\Helpers\BioWidgets::e('Carousel')."';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Carousel Images').' <small class="text-muted">('.\Helpers\BioWidgets::e('Max 5 images').')</small></label>
                        <div id="carousel-dropzone-\'+slug(did)+\'" class="carousel-dropzone border border-2 border-dashed rounded-3 p-4 text-center" style="min-height: 200px; background: #f8f9fa; cursor: pointer;">
                            <div class="dropzone-content">
                                <i class="fa fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="mb-2"><strong>'.\Helpers\BioWidgets::e('Drag and drop images here').'</strong></p>
                                <p class="text-muted small mb-3">'.\Helpers\BioWidgets::e('or click to browse').'</p>
                                <input type="file" id="carousel-input-\'+slug(did)+\'" name="carousel-\'+slug(did)+\'[]" multiple accept="'.implode(',', array_map(function($ext) { return '.'.trim($ext); }, explode(',', config('extensions')->bio->image))).'" style="display: none;">
                                <button type="button" class="btn btn-sm btn-primary" data-trigger="carousel-select">'.\Helpers\BioWidgets::e('Select Images').'</button>
                                <p class="text-muted small mt-2 mb-0">'.\Helpers\BioWidgets::e('Formats: {f} - Max size: {s}kb', null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'</p>
                            </div>
                        </div>
                        <div id="carousel-preview-\'+slug(did)+\'" class="carousel-preview mt-3 row g-2"></div>
                    </div>
                    <div id="carousel-links-\'+slug(did)+\'" class="carousel-links"></div>
                </div>', $type))."';

            $('#linkcontent').append(html);
                        
            (function() {
                var dropzone = $('#carousel-dropzone-'+slug(did));
                var input = $('#carousel-input-'+slug(did));
                var preview = $('#carousel-preview-'+slug(did));
                var linksContainer = $('#carousel-links-'+slug(did));
                var maxImages = 5;
                var currentImages = (content && content.images) ? content.images.length : 0;
                                
                if(content && content.images && content.images.length > 0) {
                    content.images.forEach(function(image, index) {
                        addImagePreview(did, image, index, content.links && content.links[index] ? content.links[index] : '', null);
                    });
                }
                                                
                $('#container-'+did+' [data-trigger=carousel-select]').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    input[0].click();
                });
                                
                dropzone.on('click', function(e) {
                    if($(e.target).is('input[type=\"file\"]') || $(e.target).closest('input[type=\"file\"]').length) {
                        return;
                    }
                    if(!$(e.target).is('button') && !$(e.target).closest('button').length) {
                        e.preventDefault();
                        e.stopPropagation();
                        input[0].click();
                    }
                });
                                
                input.on('change', function(e) {
                    handleFiles(did, this.files);
                });
                                
                dropzone.on('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass('border-primary bg-light');
                });
                
                dropzone.on('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('border-primary bg-light');
                });
                
                dropzone.on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('border-primary bg-light');
                    
                    var files = e.originalEvent.dataTransfer.files;
                    if(files.length > 0) {
                        handleFiles(did, files);
                    }
                });
                
                function handleFiles(did, files) {
                    var allowedExts = [".implode(',', array_map(function($ext) { return '\''.trim($ext).'\''; }, explode(',', config('extensions')->bio->image)))."];
                    var maxSize = ".config('sizes')->bio->image.";
                    var fileArray = Array.from(files);
                    
                    fileArray.forEach(function(file) {
                        if(currentImages >= maxImages) {
                            $.notify({
                                message: '".\Helpers\BioWidgets::e('Maximum 5 images allowed')."'
                            }, {
                                type: 'danger',
                                placement: { from: 'top', align: 'right' }
                            });
                            return;
                        }
                        
                        var ext = file.name.split('.').pop().toLowerCase();
                        var sizeKB = file.size / 1024;
                        
                        if(!allowedExts.includes(ext)) {
                            $.notify({
                                message: '".\Helpers\BioWidgets::e('Invalid file format. Allowed: {f}', null, ['f' => config('extensions')->bio->image])."'
                            }, {
                                type: 'danger',
                                placement: { from: 'top', align: 'right' }
                            });
                            return;
                        }
                        
                        if(sizeKB > maxSize) {
                            $.notify({
                                message: '".\Helpers\BioWidgets::e('File size exceeds maximum of {s}kb', null, ['s' => config('sizes')->bio->image])."'
                            }, {
                                type: 'danger',
                                placement: { from: 'top', align: 'right' }
                            });
                            return;
                        }
                                                
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var imageIndex = currentImages;
                            addImagePreview(did, e.target.result, imageIndex, '', file);
                            currentImages++;
                        };
                        reader.readAsDataURL(file);
                    });
                }
                
                function addImagePreview(did, imageSrc, index, link, file) {
                    var isExisting = typeof imageSrc === 'string' && imageSrc.indexOf('data:') !== 0;
                    var fileInputId = 'carousel-file-'+slug(did)+'-'+index;
                    var imageUrl = isExisting ? '".url('content/profiles/')."'+imageSrc : imageSrc;
                    var previewHtml = '<div class=\"col-md-4 col-sm-6 mb-2\" data-index=\"'+index+'\">' +
                        '<div class=\"card position-relative\">' +
                        '<img src=\"'+imageUrl+'\" class=\"card-img-top\" style=\"height: 150px; object-fit: cover;\">' +
                        '<div class=\"card-body p-2\">' +
                        '<input type=\"text\" class=\"form-control form-control-sm mb-2\" name=\"data['+slug(did)+'][links]['+index+']\" placeholder=\"".\Helpers\BioWidgets::e('Optional link')."\" value=\"'+link+'\">' +
                        '<div class=\"d-flex gap-1\">' +
                        '<input type=\"file\" class=\"form-control form-control-sm\" name=\"carousel-'+slug(did)+'[]\" accept=\"".implode(',', array_map(function($ext) { return '.'.trim($ext); }, explode(',', config('extensions')->bio->image)))."\" style=\"display: none;\" id=\"'+fileInputId+'\">' +
                        '<button type=\"button\" class=\"btn btn-sm btn-secondary flex-fill\" data-trigger=\"carousel-replace\" data-fileid=\"'+fileInputId+'\">".\Helpers\BioWidgets::e('Replace')."</button>' +
                        '<button type=\"button\" class=\"btn btn-sm btn-danger\" data-trigger=\"carousel-remove\" data-did=\"'+slug(did)+'\" data-index=\"'+index+'\">".\Helpers\BioWidgets::e('Remove')."</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    
                    preview.append(previewHtml);
                                        
                    if(file) {
                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        $('#'+fileInputId)[0].files = dataTransfer.files;
                    }
                                                            
                    $('#container-'+did+' [data-trigger=carousel-replace][data-fileid='+fileInputId+']').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var fileId = $(this).data('fileid');
                        $('#'+fileId)[0].click();
                    });
                                        
                    $('#'+fileInputId).on('change', function(e) {
                        if(this.files && this.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $(this).closest('.card').find('img').attr('src', e.target.result);
                            }.bind(this);
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                }
                                
                $(document).on('click', '#container-'+did+' [data-trigger=carousel-remove]', function(e) {
                    e.preventDefault();
                    var index = parseInt($(this).data('index'));
                    $('[data-index=\"'+index+'\"]').remove();
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'data['+slug(did)+'][remove_images][]',
                        value: index
                    }).appendTo(linksContainer);
                    currentImages--;
                });
            })();
            
            countryInit(did, content);
            languageInit(did, content);
        }";
    }

    /**
     * Carousel Save
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.8
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
        $savedImages = [];
        $savedLinks = [];
        
        if(isset($profiledata['links'][$key]['images']) && is_array($profiledata['links'][$key]['images'])){
            $savedImages = $profiledata['links'][$key]['images'];
        }
        if(isset($profiledata['links'][$key]['links']) && is_array($profiledata['links'][$key]['links'])){
            $savedLinks = $profiledata['links'][$key]['links'];
        }
        
        $uploadedFiles = [];
        if($request->file('carousel-'.$key)){
            $files = $request->file('carousel-'.$key);
            if(!is_array($files)){
                $files = [$files];
            }
            
            foreach($files as $index => $image){
                if(!$image || !$image->name) continue;

                if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->image) {
                    throw new \Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => $extensions->bio->image, 's' => $sizes->bio->image]));
                }

                $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

                if(!file_exists($directory)){
                    mkdir($directory, 0775);
                    $f = fopen($directory.'/index.html', 'w');
                    fwrite($f, '');
                    fclose($f);
                }

                $filename = date('Y-m-d')."/profile_carousel".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $image->name);
                $request->move($image, $appConfig['storage']['profile']['path'], $filename);
                $uploadedFiles[] = $filename;
            }
        }
        
        $imageIndex = 0;
        while($request->file('carousel-image-'.$key.'-'.$imageIndex)){
            $image = $request->file('carousel-image-'.$key.'-'.$imageIndex);
            if($image && $image->name){
                if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->image)) || $image->sizekb > $sizes->bio->image) {
                    throw new \Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => $extensions->bio->image, 's' => $sizes->bio->image]));
                }

                $directory = $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

                if(!file_exists($directory)){
                    mkdir($directory, 0775);
                    $f = fopen($directory.'/index.html', 'w');
                    fwrite($f, '');
                    fclose($f);
                }

                $filename = date('Y-m-d')."/profile_carousel".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $image->name);
                $request->move($image, $appConfig['storage']['profile']['path'], $filename);
                                
                if(isset($savedImages[$imageIndex])){
                    \Helpers\App::delete($appConfig['storage']['profile']['path'].'/'.$savedImages[$imageIndex]);
                }
                $savedImages[$imageIndex] = $filename;
            }
            $imageIndex++;
        }
        
        $allImages = array_merge($savedImages, $uploadedFiles);
                
        $allImages = array_slice($allImages, 0, 5);
        
        $links = [];
        if(isset($data['links']) && is_array($data['links'])){
            foreach($data['links'] as $idx => $link){
                if(isset($allImages[$idx])){
                    $links[$idx] = clean($link);
                }
            }
        }
        
        if(isset($data['remove_images']) && is_array($data['remove_images'])){
            foreach($data['remove_images'] as $removeIdx){
                $removeIdx = (int)$removeIdx;
                if(isset($allImages[$removeIdx])){
                    \Helpers\App::delete($appConfig['storage']['profile']['path'].'/'.$allImages[$removeIdx]);
                    unset($allImages[$removeIdx]);
                    unset($links[$removeIdx]);
                }
            }            
            $allImages = array_values($allImages);
            $links = array_values($links);
        }

        $data['images'] = $allImages;
        $data['links'] = $links;
        $data['active'] = isset($data['active']) && $data['active'] == '1' ? 1 : 0;

        return $data;
    }

    /**
     * Carousel Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.8
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        if(!isset($value['images']) || !is_array($value['images']) || empty($value['images'])) return;

        $images = $value['images'];
        $links = isset($value['links']) && is_array($value['links']) ? $value['links'] : [];

        $carouselId = 'carousel-'.$id;
        $indicators = '';
        $items = '';

        foreach($images as $index => $image){
            $isActive = $index === 0 ? 'active' : '';
            $indicators .= '<button type="button" data-bs-target="#'.$carouselId.'" data-bs-slide-to="'.$index.'" class="'.$isActive.'" aria-current="true" aria-label="Slide '.($index + 1).'"></button>';
            
            $imageUrl = uploads($image, 'profile');
            $link = isset($links[$index]) && $links[$index] ? $links[$index] : '';
            
            $itemContent = '<img src="'.$imageUrl.'" class="d-block w-100 btn-custom" alt="Carousel image '.($index + 1).'">';
            
            if($link){
                $itemContent = '<a href="'.$link.'" target="_blank" rel="nofollow">'.$itemContent.'</a>';
            }
            
            $items .= '<div class="carousel-item '.$isActive.'">'.$itemContent.'</div>';
        }

        return '<div id="'.$carouselId.'" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">'.$indicators.'</div>
            <div class="carousel-inner">'.$items.'</div>
            <button class="carousel-control-prev" type="button" data-bs-target="#'.$carouselId.'" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#'.$carouselId.'" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>';
    }

    /**
     * Delete Carousel Block
     *     
     * @version 7.8
     * @param string $id Block ID
     * @param array $value Block data containing image paths
     * @return void
     */
    public static function delete($id, $value){
        
        $appConfig = appConfig('app');
        
        if(isset($value['images']) && is_array($value['images'])){
            foreach($value['images'] as $image){
                if($image){
                    \Helpers\App::delete($appConfig['storage']['profile']['path'].'/'.$image);
                }
            }
        }
    }
}
