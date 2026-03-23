<?php
/**
 * Newsletter Widget
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

class Newsletter {
    /**
     * Newsletter Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5.1
     * @return void
     */
    public static function setup(){

        $type = 'newsletter';

        $user = \Core\Auth::user();
        $mailchimpLists = [];
        $mailchimpEnabled = false;
        
        if($user->has('mailchimp') && !empty($user->mailchimpapikey)){
            try {
                $mailchimp = new \Helpers\MailchimpMarketing($user->mailchimpapikey);
                $mailchimpLists = $mailchimp->getLists();
                $mailchimpEnabled = !empty($mailchimpLists);
            } catch(\Exception $e){
            }
        }

        return "function fnnewsletter(el, content = null, did = null){

            var text = content && 'text' in content ? content['text'] : '';
            var description = content && 'description' in content ? content['description'] : '';
            var disclaimer = content && 'disclaimer' in content ? content['disclaimer'] : '';
            var mailchimpenabled = content && 'mailchimpenabled' in content ? content['mailchimpenabled'] : 0;
            var mailchimplist = content && 'mailchimplist' in content ? content['mailchimplist'] : '';

            var blockpreview = text;

            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            var mailchimpLists = ".json_encode($mailchimpLists).";
            var mailchimpAvailable = ".($mailchimpEnabled ? 'true' : 'false').";

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Text').'</label>
                                <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][text]" value="\'+text+\'" placeholder="e.g. Subscribe">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Description').' ('.\Helpers\BioWidgets::e('Optional').')</label>
                                <textarea type="text" class="form-control p-2" name="data[\'+slug(did)+\'][description]">\'+description+\'</textarea>
                            </div>
                        </div>                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Disclaimer').' ('.\Helpers\BioWidgets::e('Optional').')</label>
                                <textarea type="text" class="form-control p-2" name="data[\'+slug(did)+\'][disclaimer]">\'+disclaimer+\'</textarea>
                                <p class="form-text">'.\Helpers\BioWidgets::e('You can add your own disclaimer and a checkbox will show up requiring users to check before submitting.').'</p>
                            </div>
                        </div>'.($mailchimpEnabled ? '
                        <div class="col-md-12 mt-3">
                            <div class="form-group border rounded p-3">
                                <div class="d-flex align-items-center">
                                    <label class="form-label fw-bold mb-0"><i class="fab fa-fw fa-mailchimp me-2"></i>'.\Helpers\BioWidgets::e('Mailchimp Integration').'</label>
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input" type="checkbox" data-binary="true" id="mailchimpenabled-\'+slug(did)+\'" name="data[\'+slug(did)+\'][mailchimpenabled]" value="1" data-toggle="togglefield" data-toggle-for="mailchimplist-\'+slug(did)+\'" \'+(mailchimpenabled == 1 ? \'checked\' : \'\')+\'>
                                        <label class="form-check-label fw-bold" for="mailchimpenabled-\'+slug(did)+\'">'.\Helpers\BioWidgets::e('Enable').'</label>
                                    </div>
                                </div>
                                <div class="form-group \'+(mailchimpenabled == 1 ? \'\' : \'d-none\')+\' mt-3" id="mailchimplist-\'+slug(did)+\'">
                                    <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Select Mailchimp List').'</label>
                                    <select name="data[\'+slug(did)+\'][mailchimplist]" class="form-select p-2">
                                        <option value="">'.\Helpers\BioWidgets::e('Select a list').'</option>\'+
                                        Object.keys(mailchimpLists).map(function(listId){
                                            return \'<option value="\'+listId+\'" \'+(mailchimplist == listId ? \'selected\' : \'\')+\'>\'+mailchimpLists[listId]+\'</option>\';
                                        }).join(\'\')+\'
                                    </select>
                                    <p class="form-text">'.\Helpers\BioWidgets::e('Subscribers will be automatically added to the selected Mailchimp list.').'</p>
                                </div>
                            </div>
                        </div>' : '').'
                    </div>
                </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
        }";
    }
    /**
     * Save Newsletter
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.1
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['text'] = clean($data['text']);
        $data['disclaimer'] = clean($data['disclaimer']);
        $data['description'] = clean($data['description']);
        $data['mailchimpenabled'] = isset($data['mailchimpenabled']) && $data['mailchimpenabled'] == '1' ? 1 : 0;
        $data['mailchimplist'] = isset($data['mailchimplist']) ? clean($data['mailchimplist']) : '';

        // Validate mailchimp settings if enabled
        if($data['mailchimpenabled']){
            $user = \Core\Auth::user();
            if(!$user->has('mailchimp')){
                throw new \Exception(e('Mailchimp integration is not available in your plan.'));
            }
            if(empty($user->mailchimpapikey)){
                throw new \Exception(e('Please configure your Mailchimp API key in Integrations first.'));
            }
            if(empty($data['mailchimplist'])){
                throw new \Exception(e('Please select a Mailchimp list.'));
            }
        }

        return $data;
    }
    /**
     * Newsletter Processor
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function processor($block, $profile, $url, $user){

        $request = request();

        if($request->isPost()){
            if($request->action == 'newsletter'){

                if(!$request->email || !$request->validate($request->email, 'email')) return back()->with('danger', e('Please enter a valid email.'))->exit();

                if(isset($block['disclaimer']) && $block['disclaimer'] && !$request->disclaimer) return back()->with('danger', e('Please accept the disclaimer.'))->exit();

                $resp = json_decode($profile->responses, true);

                if(!isset($resp['newsletter'])) $resp['newsletter'] = [];
                
                if(!in_array($request->email, $resp['newsletter'])){
                    $resp['newsletter'][] = clean($request->email);

                    $profile->responses = json_encode($resp);
                    $profile->save();
                }

                // Add to Mailchimp if enabled
                if(isset($block['mailchimpenabled']) && $block['mailchimpenabled'] && !empty($block['mailchimplist'])){
                    $user = \Core\Auth::user();
                    if($user->has('mailchimp') && !empty($user->mailchimpapikey)){
                        try {
                            $mailchimp = new \Helpers\MailchimpMarketing($user->mailchimpapikey);
                            $mailchimp->addSubscriber($block['mailchimplist'], clean($request->email), [], 'subscribed');
                        } catch(\Exception $e){
                            // Log error but don't fail the subscription
                            \GemError::log('Mailchimp subscription error: '.$e->getMessage());
                        }
                    }
                }

                return back()->with('success', e('You have been successfully subscribed.'))->exit();;
            }
        }
    }
    /**
     * Newsletter Block
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5.1
     * @param [type] $id
     * @param [type] $value
     * @return void
     */
    public static function block($id, $value){

        return '<a href="#" data-bs-target="#N'.$id.'" data-bs-toggle="collapse" data-target="#N'.$id.'" data-toggle="collapse"  role="button" class="btn btn-block p-3 d-block btn-custom position-relative fa-animated collapsed">
                    <span class="align-top">'.($value['text'] ?? e('Subscribe')).'</span>
                    <i class="fa fa-chevron-down position-absolute end-0 me-3 right-0 mr-3"></i>
                </a>
                <form method="post" action="" class="collapse" id="N'.$id.'">
                    <div class="btn-custom p-3 mt-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-fill me-1 mr-1">
                                <input type="email" class="form-control border-0 bg-white p-2" name="email" placeholder="e.g. johnsmith@company.com" required>
                            </div>
                            <div class="ms-auto">
                                <button type="submit" class="btn btn-dark p-2">'.($value['text'] ?? e('Subscribe')).'</button>
                            </div>
                        </div>
                        '.(isset($value['disclaimer']) && $value['disclaimer'] ? '<div class="text-start mt-2"><label><input type="checkbox" name="disclaimer" class="me-2" value="1" required> '.$value['disclaimer'].'</label></div>' : '').'
                    </div>
                    <input type="hidden" name="action" value="newsletter">
                    <input type="hidden" name="blockid" value="'.$id.'">
                </form>';
    }
}
