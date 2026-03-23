<?php
/**
 * Image Widget
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

class Image {
    /**
     * Image Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'image';

        return "function fnimage(el, content = null, did = null){

            var images = [];
            var links = [];
            
            if(content){
                if(content['image']) images.push(content['image']);
                if(content['image2']) images.push(content['image2']);
                if(content['link']) links[0] = content['link'];
                if(content['link2']) links[1] = content['link2'];
            }

            var blockpreview = images.length > 0 ? images.length + ' images' : '".\Helpers\BioWidgets::e('Image')."';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Images').' <small class="text-muted">('.\Helpers\BioWidgets::e('Max 2 images').')</small></label>
                        <div id="image-dropzone-\'+slug(did)+\'" class="image-dropzone border-2 border-dashed rounded-3 p-4 text-center" style="min-height: 200px; background: #f8f9fa; cursor: pointer;">
                            <div class="dropzone-content">
                                <i class="fa fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="mb-2"><strong>'.\Helpers\BioWidgets::e('Drag and drop images here').'</strong></p>
                                <p class="text-muted small mb-3">'.\Helpers\BioWidgets::e('or click to browse').'</p>
                                <input type="file" id="image-input-\'+slug(did)+\'" name="image-\'+slug(did)+\'[]" multiple accept="'.implode(',', array_map(function($ext) { return '.'.trim($ext); }, explode(',', config('extensions')->bio->image))).'" style="display: none;">
                                <button type="button" class="btn btn-sm btn-primary" data-trigger="image-select">'.\Helpers\BioWidgets::e('Select Images').'</button>
                                <p class="text-muted small mt-2 mb-0">'.\Helpers\BioWidgets::e('Formats: {f} - Max size: {s}kb', null, ['f' => config('extensions')->bio->image, 's' => config('sizes')->bio->image]).'</p>
                            </div>
                        </div>
                        <div id="image-preview-\'+slug(did)+\'" class="image-preview mt-3 row g-2"></div>
                    </div>
                    <div id="image-links-\'+slug(did)+\'" class="image-links"></div>
                </div>', $type))."';

            $('#linkcontent').append(html);
                        
            (function() {
                var dropzone = $('#image-dropzone-'+slug(did));
                var input = $('#image-input-'+slug(did));
                var preview = $('#image-preview-'+slug(did));
                var linksContainer = $('#image-links-'+slug(did));
                var maxImages = 2;
                var currentImages = images.length;
                                
                if(images.length > 0) {
                    images.forEach(function(image, index) {
                        addImagePreview(did, image, index, links[index] || '', null);
                    });
                }
                                                
                $('#container-'+did+' [data-trigger=image-select]').on('click', function(e) {
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
                                message: '".\Helpers\BioWidgets::e('Maximum 2 images allowed')."'
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
                    var fileInputId = 'image-file-'+slug(did)+'-'+index;
                    var imageUrl = isExisting ? '".url('content/profiles/')."'+imageSrc : imageSrc;
                    var previewHtml = '<div class=\"col-md-6 col-sm-12 mb-2\" data-index=\"'+index+'\">' +
                        '<div class=\"card position-relative\">' +
                        '<img src=\"'+imageUrl+'\" class=\"card-img-top\" style=\"height: 200px; object-fit: cover;\">' +
                        '<div class=\"card-body p-2\">' +
                        '<label class=\"form-label small fw-bold\">".\Helpers\BioWidgets::e('Link')." <small class=\"text-muted\">(".\Helpers\BioWidgets::e('Optional').")</small></label>' +
                        '<input type=\"text\" class=\"form-control form-control-sm mb-2\" name=\"data['+slug(did)+'][link'+(index == 0 ? '' : '2')+']\" placeholder=\"".\Helpers\BioWidgets::e('Optional link')."\" value=\"'+link+'\">' +
                        '<div class=\"d-flex gap-1\">' +
                        '<input type=\"file\" class=\"form-control form-control-sm\" name=\"image-file-'+slug(did)+'-'+index+'\" accept=\"".implode(',', array_map(function($ext) { return '.'.trim($ext); }, explode(',', config('extensions')->bio->image)))."\" style=\"display: none;\" id=\"'+fileInputId+'\">' +
                        '<button type=\"button\" class=\"btn btn-sm btn-secondary flex-fill\" data-trigger=\"image-replace\" data-fileid=\"'+fileInputId+'\">".\Helpers\BioWidgets::e('Replace')."</button>' +
                        '<button type=\"button\" class=\"btn btn-sm btn-danger\" data-trigger=\"image-remove\" data-did=\"'+slug(did)+'\" data-index=\"'+index+'\">".\Helpers\BioWidgets::e('Remove')."</button>' +
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
                                                            
                    $('#container-'+did+' [data-trigger=image-replace][data-fileid='+fileInputId+']').on('click', function(e) {
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
                                
                $(document).on('click', '#container-'+did+' [data-trigger=image-remove]', function(e) {
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
     * Image Save
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
        $savedImages = [];
        
        if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
            $savedImages[0] = $profiledata['links'][$key]['image'];
        }
        if(isset($profiledata['links'][$key]['image2']) && $profiledata['links'][$key]['image2']){
            $savedImages[1] = $profiledata['links'][$key]['image2'];
        }
        
        $uploadedFiles = [];
        if($request->file('image-'.$key)){
            $files = $request->file('image-'.$key);
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

                $filename = date('Y-m-d')."/profile_imagetype".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $image->name);
                $request->move($image, $appConfig['storage']['profile']['path'], $filename);
                $uploadedFiles[] = $filename;
            }
        }
        
        $imageIndex = 0;
        $hasIndexedUploads = false;
        while($request->file('image-file-'.$key.'-'.$imageIndex)){
            $image = $request->file('image-file-'.$key.'-'.$imageIndex);
            if($image && $image->name){
                $hasIndexedUploads = true;
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

                $filename = date('Y-m-d')."/profile_imagetype".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $image->name);
                $request->move($image, $appConfig['storage']['profile']['path'], $filename);
                                
                if(isset($savedImages[$imageIndex])){
                    App::delete($appConfig['storage']['profile']['path'].'/'.$savedImages[$imageIndex]);
                }
                $savedImages[$imageIndex] = $filename;
            }
            $imageIndex++;
        }
        
        // Use only one source to avoid duplicate: when form sends image-file-{key}-{index},
        // the same file is often also in image-{key}[], so prefer indexed slots and skip merge.
        $allImages = $hasIndexedUploads ? $savedImages : array_merge($savedImages, $uploadedFiles);
        $allImages = array_slice($allImages, 0, 2);
        
        if(isset($data['remove_images']) && is_array($data['remove_images'])){
            foreach($data['remove_images'] as $removeIdx){
                $removeIdx = (int)$removeIdx;
                if(isset($allImages[$removeIdx])){
                    App::delete($appConfig['storage']['profile']['path'].'/'.$allImages[$removeIdx]);
                    unset($allImages[$removeIdx]);
                }
            }            
            $allImages = array_values($allImages);
        }
        
        $data['image'] = isset($allImages[0]) ? $allImages[0] : '';
        $data['image2'] = isset($allImages[1]) ? $allImages[1] : '';
        
        if(!isset($data['link']) || empty($data['link'])){
            if(isset($profiledata['links'][$key]['link'])){
                $data['link'] = $profiledata['links'][$key]['link'];
            } else {
                $data['link'] = '';
            }
        }
        
        if(!isset($data['link2']) || empty($data['link2'])){
            if(isset($profiledata['links'][$key]['link2'])){
                $data['link2'] = $profiledata['links'][$key]['link2'];
            } else {
                $data['link2'] = '';
            }
        }

        return $data;
    }
    /**
     * Image Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){
        
        if(!isset($value['image']) || empty($value['image'])) return;

        if(isset($value['image2']) && !empty($value['image2'])){
            return '<div class="row">
                <div class="col-6">
                    '.($value['link'] ? '
                        <a href="'.$value['link'].'" target="_blank" rel="nofollow"><img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid w-100 btn-custom"></a>
                    ' : '
                        <img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid btn-custom w-100">
                    ').'
                </div>
                <div class="col-6">
                    '.(isset($value['link2']) && $value['link2'] ? '
                        <a href="'.$value['link2'].'" target="_blank" rel="nofollow"><img src="'.uploads($value['image2'], 'profile').'" class="img-responsive img-fluid w-100 btn-custom"></a>
                    ' : '
                        <img src="'.uploads($value['image2'], 'profile').'" class="img-responsive img-fluid btn-custom w-100">
                    ').'
                </div>
            </div>';
        }else{
            if($value['link']){
                return '<a href="'.$value['link'].'" target="_blank" rel="nofollow"><img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid w-100 btn-custom"></a>';
            } else {
                return '<img src="'.uploads($value['image'], 'profile').'" class="img-responsive img-fluid btn-custom w-100">';
            }
        }
    }
    /**
     * Delete Image Block
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data containing image paths
     * @return void
     */
    public static function delete($id, $value){
        
        $appConfig = appConfig('app');
        
        if(isset($value['image']) && $value['image']){
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
        
        if(isset($value['image2']) && $value['image2']){
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image2']);
        }
    }
}
