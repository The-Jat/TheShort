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

namespace Helpers;

use Core\Helper;

class QR {
    /**
     * Instance of the writer
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $writer = null;
    /**
     * Add Logo
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $logo = null;
    /**
     * Get Extension
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $extension = null;    
    /**
     * Instance of the QR
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    private $QR = null;    
    /**
     * QR types
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4.4
     * @return void
     */
    public static function types($type = null){
        $list = [
            'text' => [
                'name' => e('Text')
            ],
            'link' => [
                'name' => e('Link')
            ],
            'email' => [
                'name' => e('Email')
            ],
            'sms' => [
                'name' => e('SMS & Message')
            ],
            'smsonly' => [
                'name' => e('SMS')
            ],
            'phone' => [
                'name' => e('Phone')
            ],
            'wifi' => [
                'name' => e('Wifi')
            ],
            'staticvcard' => [
                'name' => e('Static vCard')
            ],
            'event' => [
                'name' => e('Event')
            ],
            'geolocation' => [
                'name' => e('Geolocation')
            ],
            'crypto' => [
                'name' => e('Cryptocurrency')
            ],
            'file' => [
                'name' => e('File')
            ],
            'vcard' => [
                'name' => e('vCard')
            ],
            'application' => [
                'name' => e('Application')
            ],
            'whatsapp' => [
                'name' => e('Whatsapp')
            ]
        ];
		
        if(isset($list[$type])) return $list[$type];
        
        return $list;
    }

    /**
     * Generate QR Code
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public static function factory($request, $size = 200, $margin = 0){

        if(is_array($request)){
            $data = call_user_func([self::class, 'type'.ucfirst($request['type'] )], clean($request['data']));
        }

        if(is_object($request)){
            $input = $request->{$request->type} ? $request->{$request->type} : $request->text;
            $data = call_user_func([self::class, 'type'.ucfirst($request->type)], clean($input));
        }

        if(is_string($request)){
            $data = call_user_func([self::class, 'typeText'], clean($request));
        }
    

        if(self::hasImagick()){
            try{
                return new QrImagick($data, $size, $margin);
            }catch(\Exception $e){                
                \GemError::log('QR Imagick Error:'.$e->getMessage());
                throw new \Exception(e('An error internal server error occurred. Please change the QR type.'));
            }
            
        }

        return new QrGd($data, $size, $margin);        
    }
    /**
     * Check if can use Imagick
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @return boolean
     */
    public static function hasImagick(){
        return true;
    }    
    /**
     * Check if Type Exists
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $type
     * @return void
     */
    public static function typeExists($type){
        return \method_exists(__CLASS__, 'type'.ucfirst($type));
    }
    /**
     * Generate String
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $data
     * @return string
     */
    public static function typeText(string $data){
        if(empty($data)) throw new \Exception(e('QR data cannot be empty. Please fill the appropriate field.'));
        if(strlen($data) > 4296) throw new \Exception(e('Text is too long.'));
        return $data;
    }
    /**
     * Get Link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $data
     * @return void
     */
    public static function typeLink(string $data){
        if(empty($data)) throw new \Exception(e('QR data cannot be empty. Please fill the appropriate field.'));
        if(!Helper::isURL($data)) throw new \Exception(e('Please enter a valid url.'));
        if(strlen($data) > 4296) throw new \Exception(e('Text is too long.'));

        return $data;
    }
    /**
     * Generate Email QR Codes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string
     */
    public static function typeEmail($data){
        
        if(is_string($data)) return "mailto:".clean($data); 
        
        $data = (array) $data;

        $response = "mailto:".clean($data['email']);

        $query = [];

        if(isset($data['subject'])) {
            if(strlen($data['subject']) > 500) throw new \Exception(e('Subject is too long.'));
            $query['subject'] = clean($data['subject']);
        }        

        if(isset($data['body'])) {
            
            if(strlen($data['body']) > 3500) throw new \Exception(e('Text is too long.'));

            $query['body'] = str_replace(["\r\n", "\n", ' ', '&#039;', '&#034;','&quot;', '&'], ['%0A', '%0A', '%20', '%27','%22','%22','%26'], strip_tags(clean($data['body'])));
        }

        return $response.($query ? '?'.urldecode(\http_build_query($query, '', '&', PHP_QUERY_RFC3986)) : '');
    }
    /**
     * Call Phone
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string
     */
    public static function typePhone($data){
        
        if(!is_numeric(str_replace('+', '', $data))) throw new \Exception(e('Invalid phone number. Please try again.'));

        if(strlen($data) > 500) throw new \Exception(e('Invalid phone number. Please try again.'));

        return 'tel:'.$data;
    }
    /**
     * Generate SMS with Message
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param mixed $data
     * @return string
     */
    public static function typeSms($data){
        
        $data = (array) $data;

        if(!is_numeric($data['phone'])) throw new \Exception(e('Invalid phone number. Please try again.'));     
        
        if(isset($data['message']) && strlen($data['message']) > 3500) throw new \Exception(e('Text is too long.'));

        return 'smsto:'.(is_array($data) ? $data['phone'].":{$data['message']}": $data);
    }
    /**
     * SMS Only 
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param mixed $data
     * @return void
     */
    public static function typeSmsonly($data){
        
        $data = (array) $data;

        if(!is_numeric($data['phone'])) throw new \Exception(e('Invalid phone number. Please try again.'));        

        if(isset($data['message']) && !empty($data['message'])){
            
            if(strlen($data['message']) > 3500) throw new \Exception(e('Text is too long.'));

            return 'sms:'.$data['phone'].'&body='.$data['message'];
        } else {
            return 'sms:'.$data['phone'];
        }
    }
    /**
     * Generate Whatsapp Link
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param mixed $data
     * @return void
     */
    public static function typeWhatsapp($data){

        $data = (array) $data;

        if(!is_numeric(str_replace('+', '', $data['phone']))) throw new \Exception(e('Invalid phone number. Please try again.'));

        if(strlen($data['body']) > 3500) throw new \Exception(e('Text is too long.'));

        return 'https://api.whatsapp.com/send?'.(is_array($data) ? "phone={$data['phone']}&text={$data['body']}": 'phone='.$data);
    }
    /**
     * Generate Vcard
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param mixed $data
     * @return string
     */
    public static function typeVcard($data){
        
        $request = request();

        self::validatevCardPicture();

        $data = (array) $data;

        $data = array_map('clean', $data);
        
        $builder = '';

        if(isset($data['fname']) || isset($data['lname'])){
            $builder .= "N:{$data['lname']};{$data['fname']}\r\n";
        }

        if(isset($data['org']) && $data['org']){
            $builder .= "ORG:{$data['org']}\r\n";
        }

        if(isset($data['phone']) && $data['phone']){
            $builder .= "TEL;TYPE=work,voice:{$data['phone']}\r\n";
        }

        if(isset($data['cell']) && $data['cell']){
            $builder .= "TEL;TYPE=cell,voice:{$data['cell']}\r\n";
        }
        if(isset($data['fax']) && $data['fax']){
            $builder .= "TEL;TYPE=fax:{$data['fax']}\r\n";
        }

        if(isset($data['email']) && $data['email']){
            $builder .= "EMAIL;TYPE=INTERNET;TYPE=WORK;TYPE=PREF:{$data['email']}\r\n";
        }

        if(isset($data['site']) && $data['site']){
            $builder .= "URL;TYPE=work:{$data['site']}\r\n";
        }

        if(isset($data['facebook']) && $data['facebook']){
            $builder .= "URL;TYPE=facebook:{$data['facebook']}\r\n";
        }

        if(isset($data['instagram']) && $data['instagram']){
            $builder .= "URL;TYPE=instagram:{$data['instagram']}\r\n";
        }

        if(isset($data['twitter']) && $data['twitter']){
            $builder .= "URL;TYPE=twitter:{$data['twitter']}\r\n";
        }

        if(isset($data['linkedin']) && $data['linkedin']){
            $builder .= "URL;TYPE=linkedin:{$data['linkedin']}\r\n";
        }

        if($data['street'] || $data['city'] || $data['state'] || $data['zip'] || $data['country']){

            $builder .= "ADR;TYPE=work:;;{$data['street']};{$data['city']};{$data['state']};{$data['zip']};{$data['country']}\r\n";
        }

        if(isset($data['image']) && file_exists(appConfig('app.storage')['qr']['path'].'/'.$data['image'])) {            
            $ext = strtoupper(Helper::extension(appConfig('app.storage')['qr']['path'].'/'.$data['image']));
            $builder .="PHOTO;ENCODING=b;TYPE={$ext}:".base64_encode(file_get_contents(appConfig('app.storage')['qr']['path'].'/'.$data['image']))."\r\n";
        }

        if(empty($builder)) throw new \Exception(e('vCard data cannot be empty. Please fill some fields'));

        $vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n";
        $vcard .= $builder;
        $vcard .= "\r\nREV:".date("Y-m-d")."T".date("H:i:s")."\r\nEND:VCARD";    
    
        return $vcard;
    }
    /**
     * Validate Location
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5
     * @return void
     */
    public static function validatevCardPicture(){

        $request = request();
        if($file = $request->file('vcard')) {            
            if(!$file->mimematch || !in_array($file->ext, ['jpg', 'png', 'jpeg'])) throw new \Exception(e('Picture must be either a PNG, JPEG (Max 512kb)'));
            if($file->sizekb >= 512*1024) throw new \Exception(e('Picture must be either a PNG, JPEG (Max 512kb'));    
        }

        return $file;
    }
    /**
     * Upload vCard Picture
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.5
     * @return void
     */
    public static function vcardPicture(){
        
        $request = request();

        if($file = $request->file('vcard')) {            
            if(!$file->mimematch || !in_array($file->ext, ['jpg', 'png', 'jpeg'])) throw new \Exception(e('Picture must be either a PNG, JPEG (Max 512kb)'));
            if($file->sizekb >= 512*1024) throw new \Exception(e('Picture must be either a PNG, JPEG (Max 512kb'));       
                        
            $filename = \Core\Helper::rand(6)."_".str_replace(' ', '-', $file->name);
            $request->move($file, appConfig('app.storage')['qr']['path'].'/', $filename);
        
            return $filename;
        }

    }
    /**
     * Static vCard
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3.2
     * @param [type] $data
     * @return void
     */
    public static function typeStaticvcard($data){    

        $data = (array) $data;

        $data = array_map('clean', $data);
        
        $builder = '';

        if(isset($data['fname']) || isset($data['lname'])){
            $builder .= "N:{$data['lname']};{$data['fname']}\r\n";
        }

        if(isset($data['org']) && $data['org']){
            $builder .= "ORG:{$data['org']}\r\n";
        }

        if(isset($data['phone']) && $data['phone']){
            $builder .= "TEL;TYPE=work,voice:{$data['phone']}\r\n";
        }

        if(isset($data['cell']) && $data['cell']){
            $builder .= "TEL;TYPE=cell,voice:{$data['cell']}\r\n";
        }
        if(isset($data['fax']) && $data['fax']){
            $builder .= "TEL;TYPE=fax:{$data['fax']}\r\n";
        }

        if(isset($data['email']) && $data['email']){
            $builder .= "EMAIL;TYPE=INTERNET;TYPE=WORK;TYPE=PREF:{$data['email']}\r\n";
        }

        if(isset($data['site']) && $data['site']){
            $builder .= "URL;TYPE=work:{$data['site']}\r\n";
        }

        if(isset($data['facebook']) && $data['facebook']){
            $builder .= "URL;TYPE=facebook:{$data['facebook']}\r\n";
        }

        if(isset($data['instagram']) && $data['instagram']){
            $builder .= "URL;TYPE=instagram:{$data['instagram']}\r\n";
        }

        if(isset($data['twitter']) && $data['twitter']){
            $builder .= "URL;TYPE=twitter:{$data['twitter']}\r\n";
        }

        if(isset($data['linkedin']) && $data['linkedin']){
            $builder .= "URL;TYPE=linkedin:{$data['linkedin']}\r\n";
        }

        if($data['street'] || $data['city'] || $data['state'] || $data['zip'] || $data['country']){
            $builder .= "ADR;TYPE=work:;;{$data['street']};{$data['city']};{$data['state']};{$data['zip']};{$data['country']}\r\n";
        }

        if(empty($builder)) throw new \Exception(e('vCard data cannot be empty. Please fill some fields'));

        $vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n";
        $vcard .= $builder;
        $vcard .= "\r\nREV:".date("Y-m-d")."T".date("H:i:s")."\r\nEND:VCARD";    
        return $vcard;
    }
    /**
     * Generate OAuth
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return void
     */
    public static function typeOauth($data){
        
        $data = (array) $data;

        $string = 'otpauth://totp/';
        $string .= $data['label'].'?secret=';
        $string .= $data['secret'];
        if(isset($data['issuer'])){
            $string .= '&issuer='.trim($data['issuer']);
        }
        return $string;
    }

    /**
     * Generate Wifi string
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string WIFI:S:<SSID>;T:<WPA|WEP|>;P:<password>;;
     */
    public static function typeWifi($data){
        
        if(is_string($data)) throw new \Exception(e('Invalid QR format or missing data'));
        
        $data = (array) $data;

        $string = "WIFI:";

        if(empty($data['ssid'])) throw new \Exception(e('Please enter the Wifi SSID'));
        
        $string .= "S:".clean($data['ssid']).";";

        if($data['pass'] && $data['encryption']){
            $string .= "T:".clean(strtoupper($data['encryption'])).";";
        }

        if($data['pass'] && $data['encryption']){
            $string .= "P:".clean($data['pass']).";;";
        }    

        return $string;
    }
    /**
     * Generate Geodata
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $data
     * @return string geo:LAT,LONG
     */
    public static function typeGeo($data){
        if(is_string($data)) throw new \Exception(e('Invalid QR format or missing data'));
        
        $data = (array) $data;

        return 'geo:'.$data['lat'].','.$data['long'];
    }   
    /**
     * Crypto
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param mixed $data
     * @return void
     */
    public static function typeCrypto($data){
        
        $data = array_map('clean', $data);

        if(!in_array($data['currency'], ['btc', 'eth', 'bch'])) throw new \Exception(e('Invalid QR format or missing data'));

        if($data['currency'] == 'btc'){
            
            if(is_numeric($data['wallet']) || strlen($data['wallet']) < 26) throw new \Exception(e('Please enter a valid wallet address'));

            return 'bitcoin:'.clean($data['wallet']);
        }

        if($data['currency'] == 'eth'){
            
            if(is_numeric($data['wallet']) || strlen($data['wallet']) < 26) throw new \Exception(e('Please enter a valid wallet address'));

            return 'ethereum:'.clean($data['wallet']);
        }


        if($data['currency'] == 'bch'){
            
            if(is_numeric($data['wallet']) || strlen($data['wallet']) < 26) throw new \Exception(e('Please enter a valid wallet address'));

            return 'bitcoincash:'.clean($data['wallet']);
        }

    }
    /**
     * Validate File Upload
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public static function validateFile(){

        $request = request();

        if(!$file = $request->file('file')) throw new \Exception(e('Please choose a valid file.'));
        
        if(!$file->mimematch || !in_array($file->ext, ['jpg', 'png', 'jpeg', 'gif', 'pdf'])) throw new \Exception(e('File must be either a PNG, JPEG, GIF or a PDF (Max 2MB)'));

        if($file->sizekb >= appConfig('app.sizes')['qrfile']) throw new \Exception(e('File must be either a PNG, JPEG, GIF or a PDF (Max 2MB)'));

        return $file;
    }

    /**
     * Upload File
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @param [type] $data
     * @return void
     */
    public static function typeFile(){
        
        $request = request();

        try{
            
            $file = self::validateFile();

            $filename = \Core\Helper::rand(6)."_".str_replace(' ', '-', $file->name);

            $request->move($file, appConfig('app.storage')['qr']['path'].'/files', $filename);
            
            return $filename;

        } catch(\Exception $e){
            return back()->with('danger', $e->getMessage());
        }

    }
    /**
     * Array of data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.7
     * @param array $data
     * @return void
     */
    public static function typeEvent($data){

        $data = (array) $data;

        $data = array_map('clean', $data);
        
        $builder = '';

        if(isset($data['title']) && $data['title']){
            $builder .= "SUMMARY:".($data['title'])."\r\n";
        }

        if(isset($data['description']) && $data['description']){
            $builder .= "DESCRIPTION:".($data['description'])."\r\n";
        }

        if(isset($data['location']) && $data['location']){
            $builder .= "LOCATION:".($data['location'])."\r\n";
        }

        if(isset($data['url']) && $data['url']){
            $builder .= "URL:".($data['url'])."\r\n";
        }

        if(isset($data['start']) && $data['start']){
            $builder .= "DTSTART:".\Core\Helper::dtime($data['start'], 'Ymd').'T'.\Core\Helper::dtime($data['start'], 'His')."\r\n";
        }

        if(isset($data['end']) && $data['end']){
            $builder .= "DTEND:".\Core\Helper::dtime($data['end'], 'Ymd').'T'.\Core\Helper::dtime($data['end'], 'His')."\r\n";
        }

        if(empty($builder)) throw new \Exception(e('Event data cannot be empty. Please fill some fields'));

        $icard = "BEGIN:VEVENT\r\n";
        $icard .= $builder;
        $icard .= "END:VEVENT";
        
        return $icard;
    }
    /**
     * Application Type
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.1
     * @param array $data
     * @return void
     */
    public static function typeApplication(array $data){
        if(empty($data['apple']) && empty($data['google']) && empty($data['link'])) throw new \Exception(e('You must add at least 1 link.'));

        if(!empty($data['apple']) && !Helper::isURL($data['apple'])) throw new \Exception(e('Please enter a valid URL.'));

        if(!empty($data['google']) && !Helper::isURL($data['google'])) throw new \Exception(e('Please enter a valid URL.'));

        if(empty($data['link']) || !Helper::isURL($data['link'])) throw new \Exception(e('The link to redirect other devices is required.'));

        return $data;
    }
}