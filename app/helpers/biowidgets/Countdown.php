<?php
/**
 * Countdown Widget
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

class Countdown {
    /**
     * Countdown Setup
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5
     * @return void
     */
    public static function setup(){

        $type = 'countdown';

        return "function fncountdown(el, content = null, did = null){

            if(content){
                var title = content['title'] || '';
                var date = content['date'] ?? '';
                var message = content['message'] ?? '';
            } else {
                var title = '';
                var date = '';
                var message = '';
            }
            var blockpreview = title || date || '';
            if(did == null) did = (Math.random() + 1).toString(36).substring(2);

            let html = '".\Helpers\BioWidgets::format(\Helpers\BioWidgets::generateTemplate('<div id="container-\'+did+\'">
                          <div class="form-group">
                              <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Title').'</label>
                              <input type="text" class="form-control p-2" name="data[\'+slug(did)+\'][title]" placeholder="e.g. Event Countdown" value="\'+title+\'">
                              <p class="form-text">'.\Helpers\BioWidgets::e('Optional title displayed above the countdown').'</p>
                          </div>
                          <div class="form-group mt-3">
                              <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Target Date').'</label>
                              <input type="datetime-local" class="form-control p-2" name="data[\'+slug(did)+\'][date]" placeholder="e.g. 2024-12-31T23:59" value="\'+date+\'" required>
                              <p class="form-text">'.\Helpers\BioWidgets::e('Select the date and time when the countdown expires').'</p>
                          </div>
                          <div class="form-group mt-3">
                              <label class="form-label fw-bold">'.\Helpers\BioWidgets::e('Expired Message').'</label>
                              <textarea id="\'+did+\'_editor" class="form-control p-2" name="data[\'+slug(did)+\'][message]" placeholder="e.g. The event has ended">\'+message+\'</textarea>
                              <p class="form-text">'.\Helpers\BioWidgets::e('This message will be displayed when the countdown expires').'</p>
                          </div>
                      </div>', $type))."';

            $('#linkcontent').append(html);
            countryInit(did, content);
            languageInit(did, content);
            new AutoCropHandler();
            $('#'+did+'_editor').summernote({
                toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['link','ul', 'ol', 'paragraph']],
                ],
                height: 150
            });
        }";
    }
    /**
     * Save Countdown
     *
     * @author GemPixel <https://gempixel.com>
     * @version 7.5
     * @param [type] $request
     * @param [type] $profiledata
     * @param [type] $data
     * @return void
     */
    public static function save($request, $profiledata, $data){

        $data['active'] = $data['active'] == '1' ? 1 : 0;

        // Clean and save title
        if(isset($data['title'])){
            $data['title'] = \Core\Helper::clean($data['title'], 3);
        } else {
            $data['title'] = '';
        }

        if(empty($data['date'])) throw new \Exception(e('{b} Error: Please select a target date.', null, ['b' => e('Countdown')]));

        // Validate date format
        $date = strtotime($data['date']);
        if(!$date) throw new \Exception(e('{b} Error: Please enter a valid date.', null, ['b' => e('Countdown')]));

        $data['date'] = date('Y-m-d\TH:i', $date);

        // Clean message HTML
        if(isset($data['message']) && !empty($data['message'])){
            $data['message'] = \Core\Helper::clean($data['message'], 3, false, '<strong><i><a><b><u><img><iframe><ul><ol><li><p><span><br>');
        } else {
            $data['message'] = '';
        }

        return $data;
    }
    /**
     * Countdown Block
     *
     * @author GemPixel <https://gempixel.com>
     * @category Widget
     * @version 7.5
     * @param string $id
     * @param array $value
     * @return void
     */
    public static function block($id, $value){

        $title = isset($value['title']) ? $value['title'] : '';
        $date = isset($value['date']) ? $value['date'] : '';
        $message = isset($value['message']) ? $value['message'] : e('The countdown has expired.');

        if(empty($date)) return '';

        // Convert date to timestamp
        $targetTimestamp = strtotime($date);
        if(!$targetTimestamp) return '';

        $uniqueId = 'countdown-' . $id;

        return '<div id="'.$uniqueId.'" class="countdown-widget d-block btn-custom  p-3 text-start text-left">
                    '.(!empty($title) ? '<h5 class="mb-3 fw-bold text-center">'.htmlspecialchars($title).'</h5>' : '').'
                    <div class="countdown-display" style="display: none;">
                        <div class="row g-3">
                            <div class="col-3">
                                <div class="countdown-item">
                                    <div class="countdown-value" id="'.$uniqueId.'-days">0</div>
                                    <div class="countdown-label small">'.e('Days').'</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="countdown-item">
                                    <div class="countdown-value" id="'.$uniqueId.'-hours">0</div>
                                    <div class="countdown-label small">'.e('Hours').'</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="countdown-item">
                                    <div class="countdown-value" id="'.$uniqueId.'-minutes">0</div>
                                    <div class="countdown-label small">'.e('Minutes').'</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="countdown-item">
                                    <div class="countdown-value" id="'.$uniqueId.'-seconds">0</div>
                                    <div class="countdown-label small">'.e('Seconds').'</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="countdown-message custom-button text-center" style="display: none;">
                        '.$message.'
                    </div>
                </div>
                <script>
                (function(){
                    var targetDate = new Date("'.date('Y-m-d\TH:i:s', $targetTimestamp).'").getTime();
                    var countdownEl = document.getElementById("'.$uniqueId.'");
                    var displayEl = countdownEl.querySelector(".countdown-display");
                    var messageEl = countdownEl.querySelector(".countdown-message");
                    
                    function updateCountdown() {
                        var now = new Date().getTime();
                        var distance = targetDate - now;
                        
                        if (distance < 0) {
                            displayEl.style.display = "none";
                            messageEl.style.display = "block";
                            return;
                        }
                        
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        
                        document.getElementById("'.$uniqueId.'-days").textContent = days;
                        document.getElementById("'.$uniqueId.'-hours").textContent = hours;
                        document.getElementById("'.$uniqueId.'-minutes").textContent = minutes;
                        document.getElementById("'.$uniqueId.'-seconds").textContent = seconds;
                        
                        displayEl.style.display = "block";
                        messageEl.style.display = "none";
                    }
                    
                    updateCountdown();
                    setInterval(updateCountdown, 1000);
                })();
                </script>';
    }
}
