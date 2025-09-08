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

use Core\DB;
use Core\View;
use Core\Http;

final class CDN {
    /**
     * JS
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     */
    public static $list = [];
    /**
     * Configuration Keys
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     */
    private $key = null;
    private $secret = null;
    private $region = null;
    private $bucket = null;

    /**
     * Load Assets from CDNJS
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $name
     * @return void
     */
    public static function load(string $name){

        if(empty(self::$list)) self::$list = appConfig('cdn');

        if(isset(self::$list[$name])){
            if(isset(self::$list[$name]['js'])){
                foreach(self::$list[$name]['js'] as $js){
                    $js = str_replace('[version]', self::$list[$name]['version'], $js);
                    View::push($js, 'js')->toFooter();
                }
            }
            if(isset(self::$list[$name]['css'])){
                foreach(self::$list[$name]['css'] as $css){
                    $css = str_replace('[version]', self::$list[$name]['version'], $css);
                    View::push($css, 'css')->toHeader();
                }
            }
        }
    }
    /**
     * CDN Providers
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public static function providers($type = null){
        $list = [
            's3' => [
                'name' => 'AWS S3',
                'host' => 'https://{bucket}.s3.{region}.amazonaws.com',
            ],
            'digitalocean' => [
                'name' => 'Digitalocean Spaces',
                'host' => 'https://{bucket}.{region}.digitaloceanspaces.com'
            ],
            'cloudflare' => [
                'name' => 'Cloudflare R2',
                'host' => 'https://{bucket}.{region}.r2.cloudflarestorage.com',
                'region' => 'auto',
                'exempts' => ['x-amz-acl']
            ],
            'contabo' => [
                'name' => 'Contabo Storage',
                'host' => 'https://{region}.contabostorage.com/{bucket}'
            ],
            'vultr' => [
                'name' => 'Vultr Objects',
                'host' => 'https://{bucket}.{region}.vultrobjects.com'
            ],
            'wasabi' => [
                'name' => 'Wasabi Storage',
                'host' => 'https://s3.{region}.wasabisys.com/{bucket}'
            ],
            'backblaze' => [
                'name' => 'BackBlaze B2',
                'host' => 'https://{bucket}.s3.{region}.backblazeb2.com',
                'exempts' => ['x-amz-acl']
            ],
            'custom' => [
                'name' => 'Custom',
                'host' => '{s3url}'
            ]
        ];

        if($extended = \Core\Plugin::dispatch('cdnproviders.extend')){
			foreach($extended as $fn){
				$list = array_merge($list, $fn);
			}
		}

        if($type && isset($list[$type])) return $list[$type];

        return $list;
    }
    /**
     * Factory with dynamic config
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public static function factory(){
        $class = new self(config('cdn')->key, config('cdn')->secret, config('cdn')->region);
        return $class->in(config('cdn')->bucket);
    }
    /**
     * Configuration
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     */
    public function __construct($key, $secret, $region){
        $this->key = $key;
        $this->secret = $secret;
        $this->region = $region;
    }
    /**
     * Choose Bucket
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $bucket
     * @return void
     */
    public function in(string $bucket){
        $this->bucket = $bucket;
        return $this;
    }
    /**
     * Upload File
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $key
     * @param string $file
     * @param string $type
     * @return void
     */
    public function upload(string $key, string $file, string $type){
        $request = $this->httpSigned('put', $key,
                            ['x-amz-acl' => 'public-read', 'content-type' => $type, 'x-amz-content-sha256' => hash_file('sha256', $file)]
                        )
                        ->body(file_get_contents($file))
                        ->put();
        return $request->httpCode() == 200 ? true : false;
    }
    /**
     * Upload Raw
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $key
     * @param [type] $data
     * @param [type] $type
     * @return void
     */
    public function uploadRaw(string $key, $data, $type){

        $request = $this->httpSigned('put', $key,
                            ['x-amz-acl' => 'public-read', 'content-type' => $type, 'x-amz-content-sha256' => hash('sha256', $data)]
                        )
                        ->body($data)
                        ->put();
        return $request->httpCode() == 200 ? true : false;
    }
    /**
     * Get a signed URL
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.8
     * @param string $key
     * @return void
     */
    public function signed(string $key, int $expire = 60){

        $headers = [
            'host' => str_replace('https://', '', self::host()),
            'x-amz-date' => gmdate('Ymd\THis\Z'),
            'x-amz-expires' => is_integer($expire) ? $expire : 60
        ];

        $array = $this->signatureV4Array('/'.$key, $headers);

        return self::host().'/'.$key.'?'.http_build_query($array);
    }
    /**
     * Get File
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $key
     * @return void
     */
    public function get(string $key){

        $request = $this->httpSigned('get', $key)
                        ->get();

        return $request->httpCode() == 200 ? true : false;
    }
    /**
     * Delete File
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $key
     * @return void
     */
    public function delete(string $key){

        $request = $this->httpSigned('delete', $key)
                        ->delete();

        return $request->httpCode() == 200 ? true : false;
    }
    /**
     * Is Enabled
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public static function enabled(){
        $config = config('cdn');
        return $config && $config->enabled ? true : false;
    }
    /**
     * Signature v2
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $http
     * @param string $key
     * @param array $params
     * @return void
     */
    public function signatureV2(string $http, string $key, array $params = []){

        $signature = base64_encode(
            hash_hmac(
                'sha1',
                trim("".strtoupper($http)."\n\n\n".gmdate('D, d M Y H:i:s T')."\n/{$this->bucket}/{$key}"),
                $this->secret,
                true
            )
        );

        return $signature;
    }
    /**
     * Signature v4
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $http
     * @param string $key
     * @param array $params
     * @return void
     */
    public function signatureV4(string $method, string $uri, $headers = []){

        $cdn = self::providers(config('cdn')->provider);

        $method = strtoupper($method);

        $service = 's3';

        $region = $cdn['region'] ?? $this->region;

		$algorithm = 'AWS4-HMAC-SHA256';

		$date = date('Ymd', strtotime(substr($headers['x-amz-date'], 0, 8)));

        ksort($headers);

		$payload = array($method);

		$qsPos = strpos($uri, '?');
		$payload[] = ($qsPos === false ? $uri : substr($uri, 0, $qsPos));
		$payload[] = '';

		foreach ($headers as $k => $v ){
			$payload[] = $k . ':' . $v;
		}
		$payload[] = '';

		$payload[] = implode(';', array_keys($headers));
		$payload[] = $headers['x-amz-content-sha256'];

		$payloadStr = implode("\n", $payload);

		$credentialScope = array($date, $region, $service, 'aws4_request');

		$string = implode("\n", array($algorithm, $headers['x-amz-date'], implode('/', $credentialScope), hash('sha256', $payloadStr)));

		$kSecret = 'AWS4' . $this->secret;
		$kDate = hash_hmac('sha256', $date, $kSecret, true);
		$kRegion = hash_hmac('sha256', $region, $kDate, true);
		$kService = hash_hmac('sha256', $service, $kRegion, true);
		$kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);

		$signature = hash_hmac('sha256', $string, $kSigning);


		return $algorithm . ' ' . implode(',', array(
			'Credential=' . $this->key . '/' . implode('/', $credentialScope),
			'SignedHeaders=' . implode(';', array_keys($headers)),
			'Signature=' . $signature,
		));
    }
    /**
     * Sign Signature as Array
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @param string $uri
     * @param array $headers
     * @return void
     */
    public function signatureV4Array(string $uri, $headers = []){

        $method = 'get';

        $cdn = self::providers(config('cdn')->provider);

        $method = strtoupper($method);

        $service = 's3';

        $region = $cdn['region'] ?? $this->region;

		$algorithm = 'AWS4-HMAC-SHA256';

		$date = date('Ymd', strtotime(substr($headers['x-amz-date'], 0, 8)));

        ksort($headers);

		$payload = array($method);

		$qsPos = strpos($uri, '?');
		$payload[] = ($qsPos === false ? $uri : substr($uri, 0, $qsPos));
		$payload[] = '';

		foreach ($headers as $k => $v ){
			$payload[] = $k . ':' . $v;
		}

		$payload[] = '';

		$payload[] = implode(';', array_keys($headers));
		$payload[] = $headers['x-amz-content-sha256'] ?? null;

		$payloadStr = implode("\n", $payload);

		$credentialScope = array($date, $region, $service, 'aws4_request');

		$string = implode("\n", array($algorithm, $headers['x-amz-date'], implode('/', $credentialScope), hash('sha256', $payloadStr)));

		$kSecret = 'AWS4' . $this->secret;
		$kDate = hash_hmac('sha256', $date, $kSecret, true);
		$kRegion = hash_hmac('sha256', $region, $kDate, true);
		$kService = hash_hmac('sha256', $service, $kRegion, true);
		$kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);

		$signature = hash_hmac('sha256', $string, $kSigning);


		$awsheaders = [
            'X-Amz-Algorithm' => $algorithm,
			'X-Amz-Credential' => $this->key . '/' . implode('/', $credentialScope),
			'X-Amz-SignedHeaders' => 'host',
			'X-Amz-Signature' => $signature,
        ];

        foreach($headers as $key => $header){
            $awsheaders[ucwords($key, '-')] = $header;
        }

        return $awsheaders;
    }
    /**
     * Return a signed Http request
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.7
     * @return void
     */
    public function httpSigned(string $http, string $key, array $params = []){

        $config = config('cdn');

        $cdn = self::providers($config->provider);

        $headers = [
            'host' => parse_url(self::host(), PHP_URL_HOST),
            'x-amz-date' => gmdate('Ymd\THis\Z')
        ];

        if(!isset($headers['x-amz-content-sha256'])) $headers['x-amz-content-sha256'] = hash('sha256', '');

        foreach($params as $header => $value){
            if(isset($cdn['exempts']) && in_array($header, $cdn['exempts'])) continue;
            $headers[$header] = $value;
        }

        if($config->provider == 'contabo' || $config->provider == 'wasabi' || $config->provider == 'custom'){
            $signature = $this->signatureV4($http, '/'.$this->bucket.'/'.$key, $headers);
        } else {
            $signature = $this->signatureV4($http, '/'.$key, $headers);
        }

        $http = Http::url(self::host().'/'.$key)
                    ->with('authorization', $signature);
        foreach($headers as $header => $value){
            $http->with($header, $value);
        }

        return $http;
    }
    /**
     * Get Host
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.6
     * @return void
     */
    public static function host(){

        $config = config('cdn');

        $cdn = self::providers($config->provider);

        if(!isset($cdn['host'])) {
            throw new \Exception('CDN Error: CDN '.$config->provider.' not found');
        }

        if($config->provider == 'custom'){

            return trim($config->s3url, '/').'/'.$config->bucket;

        } else {
            $host = str_replace('{bucket}', $config->bucket, $cdn['host']);

            return str_replace('{region}', $config->region, $host);
        }
    }
    /**
     * CDN URL
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.6.6
     * @param [type] $config
     * @return void
     */
    public static function url($config){

        $cdn = self::providers($config->provider);

        if($config->provider == 'custom'){

            return trim($config->s3url, '/').'/'.$config->bucket;

        } else {

            $host = str_replace('{bucket}', $config->bucket, $cdn['host']);

            return str_replace('{region}', $config->region, $host);
        }
    }
}