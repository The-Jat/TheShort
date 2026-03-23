<?php
/**
 * Mailchimp Marketing API Helper
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel <https://gempixel.com>
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com
 */

namespace Helpers;

use Core\Http;
use GemError;

class MailchimpMarketing {

    private $apiKey;
    private $dataCenter;
    private $baseUrl;

    /**
     * Constructor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $apiKey
     */
    public function __construct($apiKey){
        $this->apiKey = $apiKey;
        
        // Extract data center from API key (format: key-us13)
        if(strpos($apiKey, '-') !== false){
            $this->dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
        } else {
            throw new \Exception('Invalid Mailchimp API key format');
        }
        
        $this->baseUrl = 'https://' . $this->dataCenter . '.api.mailchimp.com/3.0';
    }

    /**
     * Get Lists
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return array
     */
    public function getLists(){
        try {
            $http = Http::url($this->baseUrl . '/lists')
                ->with('Content-Type', 'application/json')
                ->auth('user', $this->apiKey)
                ->get(['timeout' => 10]);

            if($http->httpCode() == 200){
                $data = json_decode($http->getBody(), true);
                $lists = [];
                if(isset($data['lists']) && is_array($data['lists'])){
                    foreach($data['lists'] as $list){
                        $lists[$list['id']] = $list['name'];
                    }
                }
                return $lists;
            }
            
            GemError::log('Mailchimp API Error: '.$http->httpCode().' '.$http->getBody());
            return [];
        } catch(\Exception $e){
            GemError::log('Mailchimp API Exception: '.$e->getMessage());
            return [];
        }
    }

    /**
     * Add Subscriber to List
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @param string $listId
     * @param string $email
     * @param array $mergeFields
     * @param string $status
     * @return boolean
     */
    public function addSubscriber($listId, $email, $mergeFields = [], $status = 'subscribed'){
        try {
            $subscriberHash = md5(strtolower($email));
            $url = $this->baseUrl . '/lists/' . $listId . '/members/' . $subscriberHash;

            $payload = [
                'email_address' => $email,
                'status' => $status
            ];

            if(!empty($mergeFields)){
                $payload['merge_fields'] = $mergeFields;
            }

            $http = Http::url($url)
                ->with('Content-Type', 'application/json')
                ->auth('user', $this->apiKey)
                ->body($payload)
                ->put(['timeout' => 10]);

            if($http->httpCode() == 200 || $http->httpCode() == 201){
                return true;
            }
            
            GemError::log('Mailchimp API Error: '.$http->httpCode().' '.$http->getBody());
            return false;
        } catch(\Exception $e){
            GemError::log('Mailchimp API Exception: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Verify API Key
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.2
     * @return boolean
     */
    public function verify(){
        try {
            $http = Http::url($this->baseUrl . '/ping')
                ->with('Content-Type', 'application/json')
                ->auth('user', $this->apiKey)
                ->get(['timeout' => 10]);

            return $http->httpCode() == 200;
        } catch(\Exception $e){
            return false;
        }
    }
}
