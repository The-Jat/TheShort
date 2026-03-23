<?php 
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact GemPixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package Core\Support
 * @author GemPixel (http://gempixel.com)
 * @copyright 2023 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 7.0
 */
namespace Core\Support;

use Core\Http;
use Core\Helper;
use GemError;

final class SES {

    public static $name = 'Amazon SES';
    public static $logo = 'aws.jpeg';
    public static $siteurl = 'https://aws.amazon.com/ses/';
    public static $description = 'Amazon Simple Email Service (SES) is a cost-effective email service built on the reliable and scalable infrastructure that Amazon.com developed to serve its own customer base.';

    private $url = null;
    /**
     * AWS Access Key ID
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     */
    private $accessKey = null;
    /**
     * AWS Secret Access Key
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     */
    private $secretKey = null;
    /**
     * AWS Region
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     */
    private $region = 'us-east-1';
    /**
     * Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.3.3
     */
    private $template = null;

    /**
     * Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     */
    private $data = ['to' => [], 'from' => ''];

    /**
     * Send as Amazon SES
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param mixed $config
     * @param string $endpoint
     */
    public function __construct($config, $endpoint = null){

        if(is_array($config)) {
            $this->accessKey = $config['access_key'] ?? $config['key'] ?? null;
            $this->secretKey = $config['secret_key'] ?? $config['secret'] ?? null;
            $this->region = $config['region'] ?? 'us-east-1';
		}

		if(is_object($config)){
            $this->accessKey = $config->access_key ?? $config->key ?? null;
            $this->secretKey = $config->secret_key ?? $config->secret ?? null;
            $this->region = $config->region ?? 'us-east-1';
		}

        $this->url = $endpoint ?? 'https://email.'.$this->region.'.amazonaws.com';
        return $this;
    }

	/**
	 * To user
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.0
	 * @param mixed $user
	 * @return void
	 */
	public function to($user){				
		if(is_array($user)){
            $this->data['to'][] = $user[0];
        } else {
            $this->data['to'][] = $user;
        }
		return $this;
	}
	/**
	 * Sender information
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.0
	 * @param mixed $sender
	 * @return void
	 */
	public function from($sender){		
		if(is_array($sender)){
            $this->data['from'] = $sender[0];
            $this->data['from_name'] = $sender[1] ?? '';
        } else {
            $this->data['from'] = $sender;
            $this->data['from_name'] = '';
        }
		return $this;
	}
    /**
     * Reply to
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param array $contact
     * @return void
     */
    public function replyto($contact){
        $this->data['replyto'] = is_array($contact) ? $contact[0] : $contact;
		return $this;
	}
    /**
	 * Fetch Template - using this method requires a closure as $data["message"] using $this->template
	 * Email::parse can be used to replace placeholders in templates
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 7.0
	 * @param   [type] $name [description]
	 * @return  [type]       [description]
	 */
	public function template($name){
		if(!file_exists($name)){
			$name =  STORAGE."/themes/".appConfig('app.default_theme')."/email.php";
		}
		$this->template = file_get_contents($name);
		return $this;
	}
    /**
	 * Parse template shortcodes: {{ shortcode }}
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 7.0
	 * @param   string $template
	 * @param   array  $parseArray  
	 * @return  string            
	 */
	public static function parse($template, array $parseArray) : string {

		foreach ($parseArray as $key => $value) {
			$template = preg_replace('#{{\t?\s?\t?'.$key.'\t?\s?\t?}}#', $value, $template);
		}

		return $template;
	}

    /**
     * Create AWS Signature Version 4
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.0
     * @param string $method
     * @param string $url
     * @param array $params
     * @return array
     */
    private function signRequest($method, $url, $params = []){
        
        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'];
        $path = $parsedUrl['path'] ?? '/';
        
        $date = gmdate('Ymd\THis\Z');
        $dateShort = gmdate('Ymd');
        
        // Build payload (body)
        $payload = http_build_query($params);
        $payloadHash = hash('sha256', $payload);
        
        // Create canonical query string (empty for POST requests)
        $canonicalQueryString = '';
        
        // Create canonical headers
        $canonicalHeaders = 'host:'.$host."\n";
        $canonicalHeaders .= 'x-amz-date:'.$date."\n";
        
        $signedHeaders = 'host;x-amz-date';
        
        // Create canonical request
        $canonicalRequest = $method."\n";
        $canonicalRequest .= $path."\n";
        $canonicalRequest .= $canonicalQueryString."\n";
        $canonicalRequest .= $canonicalHeaders."\n";
        $canonicalRequest .= $signedHeaders."\n";
        $canonicalRequest .= $payloadHash;
        
        // Create string to sign
        $algorithm = 'AWS4-HMAC-SHA256';
        $credentialScope = $dateShort.'/'.$this->region.'/ses/aws4_request';
        $stringToSign = $algorithm."\n";
        $stringToSign .= $date."\n";
        $stringToSign .= $credentialScope."\n";
        $stringToSign .= hash('sha256', $canonicalRequest);
        
        // Calculate signature
        $kSecret = 'AWS4'.$this->secretKey;
        $kDate = hash_hmac('sha256', $dateShort, $kSecret, true);
        $kRegion = hash_hmac('sha256', $this->region, $kDate, true);
        $kService = hash_hmac('sha256', 'ses', $kRegion, true);
        $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
        $signature = hash_hmac('sha256', $stringToSign, $kSigning);
        
        // Create authorization header
        $authorization = $algorithm.' Credential='.$this->accessKey.'/'.$credentialScope.', ';
        $authorization .= 'SignedHeaders='.$signedHeaders.', ';
        $authorization .= 'Signature='.$signature;
        
        return [
            'headers' => [
                'Host' => $host,
                'X-Amz-Date' => $date,
                'Authorization' => $authorization
            ],
            'body' => $payload
        ];
    }

   /**
    * Send as Amazon SES
    *
    * @author GemPixel <https://gempixel.com> 
    * @version 7.0
    * @param array $data
    * @return void
    */
    public function send(array $data){

        if(is_callable($data["message"]))	{
			$message = $data["message"]($this->template, $data);	
		} else {
			$message = $data["message"];	
		}

        // Build SES API parameters
        $params = [
            'Action' => 'SendEmail',
            'Source' => $this->data['from_name'] ? "{$this->data['from_name']} <{$this->data['from']}>" : $this->data['from'],
            'Message.Subject.Data' => $data['subject'],
            'Message.Subject.Charset' => 'UTF-8',
            'Message.Body.Html.Data' => $message,
            'Message.Body.Html.Charset' => 'UTF-8'
        ];

        // Add recipients
        $i = 1;
        foreach($this->data['to'] as $to){
            $params['Destination.ToAddresses.member.'.$i] = $to;
            $i++;
        }

        // Add reply-to if set
        if(isset($this->data['replyto'])){
            $params['ReplyToAddresses.member.1'] = $this->data['replyto'];
        }

        // Sign the request
        $signed = $this->signRequest('POST', $this->url, $params);

        // Send request - pass body as string to match signature
        $http = Http::url($this->url)
                    ->with('X-Amz-Date', $signed['headers']['X-Amz-Date'])
                    ->with('Authorization', $signed['headers']['Authorization'])
                    ->with('Content-Type', 'application/x-www-form-urlencoded')
                    ->body($signed['body'])
                    ->post(['timeout' => 10]);

        if($http->httpCode() == 200) return true;

        GemError::log('Amazon SES API Error: '.$http->httpCode().' '.$http->getBody());
    
        $this->fallback([
            'from' => $this->data['from'],
            'to' => $this->data['to'],
            'subject' => $data['subject'],
            'html' => $message
        ]);

        return false;
    }

    /**
     * Fallback
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param array $data
     * @return void
     */
    public function fallback(array $data){

        $headers  = "From:  {$data['from']}\r\n";

		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";

		if(isset($this->data['replyto'])){
			$headers .= "Reply-To: {$this->data['replyto']}\r\n";
		}

		mail($data["to"][0], $data["subject"], $data["html"], $headers);
	}

}
