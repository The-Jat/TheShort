<?php
/**
 * vCard Widget
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

class VCard {
    /**
     * vCard Widget Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.2
     * @return void
     */
    public static function setup(){

        $type = 'vcard';

        $list = '';
        foreach (\Core\Helper::Country(false) as $country){
            $list .= '<option value="'.$country.'"  \'+(country == \''.$country.'\' ? \'selected\':\'\')+\'>'.$country.'</option>';
        }

        return "function fnvcard(el, content = null, did = null){

            var button = content && content['button'] ? content['button'] : '';
            var fname = content && content['fname'] ? content['fname'] : '';
            var lname = content && content['lname'] ? content['lname'] : '';
            var phone = content && content['phone'] ? content['phone'] : '';
            var cell = content && content['cell'] ? content['cell'] : '';
            var fax = content && content['fax'] ? content['fax'] : '';
            var email = content && content['email'] ? content['email'] : '';
            var company = content && content['company'] ? content['company'] : '';
            var address = content && content['address'] ? content['address'] : '';
            var city = content && content['city'] ? content['city'] : '';
            var state = content && content['state'] ? content['state'] : '';
            var country = content && content['country'] ? content['country'] : '';
            var zip = content && content['zip'] ? content['zip'] : '';
            var site = content && content['site'] ? content['site'] : '';
            var links = content && content['links'] ? content['links'] : [];


            var blockpreview = '';

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Picture').' '.\Helpers\BioWidgets::e('(optional)').'</label>
                        <input type="file" class="form-control p-2" name="\'+slug(did)+\'" accept=".jpg, .png">
                    </div>            
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('First Name').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][fname]" value="\'+fname+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Last Name').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][lname]" value="\'+lname+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Email').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][email]" value="\'+email+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Phone').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][phone]" value="\'+phone+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Cellphone').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][cell]" value="\'+cell+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Fax').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][fax]" value="\'+fax+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Company').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][company]" value="\'+company+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Site').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][site]" value="\'+site+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Address').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][address]" value="\'+address+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('City').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][city]" value="\'+city+\'">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('State').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][state]" value="\'+state+\'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Zip').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][zip]" value="\'+zip+\'">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Country').'</label>
                        <select class="form-select p-2" name="data[\'+slug(did)+\'][country]">
                            '.$list.'
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Label').'</label>
                        <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][button]" value="\'+button+\'">
                    </div>                    
                    <div class="border p-2 rounded mt-2">
                        <div class="d-flex mb-2">
                            <div><strong>'.\Helpers\BioWidgets::e('Custom Links').'</strong></div>
                            <a href="#" data-trigger="addcustomlink" class="btn btn-sm btn-primary ms-auto rounded-3">+ '.\Helpers\BioWidgets::e('Add').'</a>
                        </div>
                        <div class="customlink"></div>
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();

            if(links){
                links.forEach(function(link, i){
                    $('#container-'+did+' .customlink').append('".\Helpers\BioWidgets::format('
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Text').'</label>
                                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][linktext][]" value="\'+(content[\'linktext\'] && content[\'linktext\'][i] ? content[\'linktext\'][i] : \'\')+\'">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                                    <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][links][]" value="\'+link+\'">
                                </div>
                            </div>
                        </div>
                        <a href="#" data-trigger="deletecustomlink" class="btn btn-sm btn-danger mt-2 rounded-3">'.\Helpers\BioWidgets::e('Delete').'</a>
                    ')."');
                });
            }


            $('#container-'+did+' [data-trigger=addcustomlink]').click(function(e){
                e.preventDefault();
                $('#container-'+did+' .customlink').append('".\Helpers\BioWidgets::format('
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Text').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][linktext][]" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Link').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][links][]" value="">
                            </div>
                        </div>
                    </div>
                    <a href="#" data-trigger="deletecustomlink" class="btn btn-sm btn-danger mt-2 rounded-3">'.\Helpers\BioWidgets::e('Delete').'</a>
                ')."');
            });
            $(document).on('click', '#container-'+did+' [data-trigger=deletecustomlink]',function(e){
                e.preventDefault();
                $(this).prev('.row').fadeOut('fast', function(){
                    $(this).remove();
                });
                $(this).remove();
            });
        }";
    }
    /**
     * vCard Save
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

            if(!$image->mimematch || !in_array($image->ext, explode(',', $extensions->bio->avatar)) || $image->sizekb > $sizes->bio->avatar) {
                throw new \Exception(e('Image must be the following formats {f} and be less than {s}kb.', null, ['f' => $extensions->bio->avatar, 's' => $sizes->bio->avatar]));
            }

            $directory =  $appConfig['storage']['profile']['path'].'/'.date('Y-m-d');

            if(!file_exists($directory)){
                mkdir($directory, 0775);
    
                $f = fopen($directory.'/index.html', 'w');
                fwrite($f, '');
                fclose($f);
            }

            $filename = date('Y-m-d')."/profile_vcardtype".\Core\Helper::rand(6).str_replace(['#', ' '], '-', $image->name);

            $request->move($image, $appConfig['storage']['profile']['path'], $filename);

            if(isset($profiledata['links'][$key]['image']) && $profiledata['links'][$key]['image']){
                App::delete($appConfig['storage']['profile']['path'].'/'.$profiledata['links'][$key]['image']);
            }

            $data['image'] = $filename;

        } else {
            if(isset($profiledata['links'][$key]['image'])) $data['image'] = $profiledata['links'][$key]['image'];
        }

        return array_map('clean', $data);
    }
    /**
     * Delete vCard Block Images
     *     
     * @version 7.6.1
     * @param string $id Block ID
     * @param array $value Block data
     * @return void
     */
    public static function delete($id, $value){
        if(isset($value['image']) && $value['image']){
            $appConfig = appConfig('app');
            App::delete($appConfig['storage']['profile']['path'].'/'.$value['image']);
        }
    }
    /**
     * vCard Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function processor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){
            if($request->action == 'vcard'){
                
                $data = json_decode($profile->data, true);

                $block = $data['links'][$request->blockid];

                $vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n";
                $vcard .= "REV:".date("Y-m-d")."T".date("H:i:s")."Z\r\n";

                if((isset($block['fname']) && $block['fname']) && (isset($block['lname']) && $block['lname'])){
                    $vcard .= "N;CHARSET=utf-8:{$block['lname']};{$block['fname']}\r\n";
                    $vcard .= "FN;CHARSET=utf-8:{$block['fname']} {$block['lname']}\r\n";
                }
                if(isset($block['company']) && $block['company']){
                    $vcard .= "ORG;CHARSET=utf-8:{$block['company']}\r\n";
                }

                if(isset($block['phone']) && $block['phone']){
                    $vcard .= "TEL;TYPE=work,voice:{$block['phone']}\r\n";
                }
                if(isset($block['cell']) && $block['cell']){
                    $vcard .= "TEL;TYPE=cell,voice:{$block['cell']}\r\n";
                }
                if(isset($block['fax']) && $block['fax']){
                    $vcard .= "TEL;TYPE=fax:{$block['fax']}\r\n";
                }

                if(isset($block['email']) && $block['email']){
                    $vcard .= "EMAIL;TYPE=INTERNET;TYPE=WORK;TYPE=PREF:{$block['email']}\r\n";
                }

                if(isset($block['site']) && $block['site']){
                    $vcard .= "URL;TYPE=work:{$block['site']}\r\n";
                }

                if(isset($block['links']) && isset($block['linktext'])){
                    foreach($block['links'] as $i => $link){
                        $text = str_replace(' ', '', $block['linktext'][$i]);
                        $vcard .= "URL;TYPE={$text}:{$link}\r\n";
                    }
                }
                if(isset($block['address']) && isset($block['city'])){
                    $vcard .= "ADR;TYPE=work:;;{$block['address']};{$block['city']};".(isset($block['state']) ? "{$block['state']};":"")."".(isset($block['zip']) ? "{$block['zip']};":"")."".(isset($block['country']) ? "{$block['country']};":"")."\r\n";
                }

                if(isset($block['image']) && $block['image'] && file_exists(appConfig('app.storage')['profile']['path'].'/'.$block['image'])){
                    $ext = strtoupper(\Core\Helper::extension($block['image']));
                    $vcard .="PHOTO;ENCODING=b;TYPE={$ext}:".base64_encode(file_get_contents(appConfig('app.storage')['profile']['path'].'/'.$block['image']))."\r\n";
                }

                $vcard .= "END:VCARD";

                die(\Core\File::contentDownload('vcard.vcf', function() use ($vcard){
                    echo $vcard;
                }));
            }
        }
    }
    /**
     * vCard Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        return '<form method="post" action="?downloadvcard">
                    '.csrf().'
                    <input type="hidden" name="action" value="vcard">
                    <input type="hidden" name="blockid" value="'.$id.'">
                    <button type="submit" class="btn btn-custom btn-block d-block w-100 p-3">'.(isset($value['button']) && !empty($value['button']) ? $value['button'] : e('Download vCard')).'</button>
                </form>';
    }
}
