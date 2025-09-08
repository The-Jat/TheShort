<h1 class="h3 mb-5 fw-bold"><?php ee('Security Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <?php echo csrf() ?>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="adult" class="form-label fw-bold mb-0"><?php ee('Blacklisting URLs') ?></label>
                            <p class="form-text my-0"><?php ee('Once enabled, any url containing the keywords below (or an internal list) will not be allowed. This will also prevent links to executable files to be shortened.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="adult" name="adult" value="1" <?php echo config("adult") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="keyword_blacklist,domain_blacklist">
                        </div>
                    </div>
                    <div class="border rounded p-2 mb-2">
                    <div class="form-group mb-3 <?php echo config("adult") ? '':'d-none' ?>">
					    <label for="keyword_blacklist" class="form-label d-block fw-bold"><?php ee('Blacklist Keywords') ?> <?php echo file_exists(STORAGE.'/app/keywords.txt') ? '<span class="float-end text-success">'.e('Text file detected').'</span>' : '' ?></label>
                        <p class="form-text mt-0"><?php ee('Each short link will be matched with list of keywords below and if matched it will not allowed. Separate each keyword by a comma e.g. keyword1,keyword2') ?></p>
					    <div class="border rounded rounded-4 p-2 mb-2">
                            <input type="text" class="form-control p-2" name="keyword_blacklist" id="keyword_blacklist" value="<?php echo config('keyword_blacklist') ?>" data-toggle="tags" placeholder="Enter keyword and press enter">
                        </div>
                        <div class="custom-alert border border-dark p-3 rounded-3 mb-0 d-flex align-items-center">
                            <i class="fa fa-info-circle text-info me-3 fs-1"></i>
                            <span><?php ee('If you have a long list, you can add them in a text file named "keywords.txt" in the folder storage/app/ and that will be used instead of the list here.') ?></span>
                        </div>
                    </div>
                    </div>
                    <div class="border rounded p-2 mb-2">
                    <div class="form-group mb-2 <?php echo config("adult") ? '':'d-none' ?>">
					    <label for="domain_blacklist" class="form-label d-block fw-bold"><?php ee('Blacklist Domains') ?><?php echo file_exists(STORAGE.'/app/domains.txt') ? '<span class="float-end text-success">'.e('Text file detected').'</span>' : '' ?></label>
                        <p class="form-text mt-0"><?php ee('To blacklist domain names (or tlds) or IPs, simply add them in the field below in the following format (separated by a comma): domain.com,domain2.com,domain3.com,.tld. To block a subdomain, you can use the following format *.domain.com - this will block all subdomains (example *.google.com will block code.google.com but not google.com).') ?></p>
					    <div class="border rounded rounded-4 p-2 mb-2">
                            <input type="text" class="form-control p-2" name="domain_blacklist" id="domain_blacklist" value="<?php echo config('domain_blacklist') ?>" data-toggle="tags" placeholder="Enter domain and press enter">
                        </div>
                        <div class="custom-alert border border-dark p-3 rounded-3 mb-0 d-flex align-items-center">
                            <i class="fa fa-info-circle text-info me-3 fs-1"></i>
                            <span><?php ee('If you have a long list, you can add them in a text file named "domains.txt" in the folder storage/app/ and that will be used instead of the list here.') ?></span>
                        </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Security APIs') ?></h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group mb-4 border rounded p-2">
					    <label for="safe_browsing" class="form-label fw-bold"><?php ee('Google Web Risk') ?></label>
					    <input type="text" class="form-control p-2" name="safe_browsing" id="safe_browsing" value="<?php echo config('safe_browsing') ?>">
					    <p class="form-text mb-0"><?php ee('You can get your API key for free from <a href="https://cloud.google.com/web-risk/" target="_blank">Google</a>. Google has changed to Web Risk API for commercial usage.') ?> <?php ee('You can also use <a href="'.route('admin.plugins.single', ['safebrowsing']).'" target="_blank">Google Safe Browsing</a> instead.') ?></p>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="phish_api" class="form-label fw-bold mb-0"><?php ee('Phishtank API') ?></label>
                            <p class="form-text mb-0"><?php ee('Phishtank is built-in the script. You can choose to enable or disable it.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="phish_api" name="phish_api" value="1" <?php echo config("phish_api") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="border rounded mb-2 p-2">
                        <div class="form-group mb-4">
                            <label for="vtkey" class="form-label fw-bold"><?php ee('Virus Total API') ?></label>
                            <input type="text" class="form-control p-2" name="virustotal[key]" id="vtkey" value="<?php echo config('virustotal')->key ?>">
                            <p class="form-text"><?php ee('You will need to create an account <a href="https://developers.virustotal.com" target="_blank">here</a> and add your API key here.') ?></p>
                        </div>
                        <div class="form-group mb-2">
                            <label for="vtlimit" class="form-label fw-bold"><?php ee('Virus Total Tolerance') ?></label>
                            <input type="number" class="form-control p-2" name="virustotal[limit]" id="vtlimit" value="<?php echo  config('virustotal')->limit ?>" min="1" placeholder="e.g 2">
                            <p class="form-text mb-0"><?php ee('Choose the tolerance for number of positives to block a link. For example if you choose 2 and the VT returns at least 2 positives, the url will be blocked.') ?></p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Captcha') ?></h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="custom-alert border border-dark p-3 rounded-3 mb-3 d-flex align-items-center">
                        <i class="fa fa-exclamation-triangle text-warning me-3 fs-1"></i>
                        <span><?php ee('Before you logout, make sure you are using the correct captcha keys otherwise you will be locked out of your account and would not be able to login unless you directly disable captcha via the database.') ?></span>
                    </div>
                    <div class="form-group mb-4 input-select rounded">
					    <label for="frame" class="form-label fw-bold"><?php ee('Captcha') ?></label>
					      <select name="captcha" id="captcha" class="form-control p-2" data-toggle="select">
                            <option <?php echo (config("captcha") == '0' ? "selected":"") ?> value="0"><?php ee('None') ?></option>
                            <?php foreach(\Helpers\Captcha::systems() as $id => $system): ?>
                                <option <?php echo (config("captcha") == $id ? "selected":"") ?> value="<?php echo $id ?>"><?php echo $system['name'] ?></option>
                            <?php endforeach ?>
					      </select>
					      <p class="form-text"><?php ee('Users will be prompted to answer a captcha before processing their request. If you enable any of the captcha make sure to add your keys as well. To enable hCaptcha or Turnstile, add your "Site Key" in the Public Key field below and your "Secret Key" in the Private Key below.') ?> <?php ee('Altcha does not require any keys but requires PHP 8.2 or higher.') ?></p>
                    </div>
                    <div class="form-group mb-4 <?php echo config("captcha") == 6 || config("captcha") == 0 ? 'd-none' : '' ?>">
					    <label for="captcha_public" class="form-label fw-bold"><?php ee('Public Key') ?></label>
					    <input type="text" class="form-control p-2" name="captcha_public" id="captcha_public" value="<?php echo config('captcha_public') ?>">
					    <p class="form-text"><?php ee('For reCaptcha, you can get your public key for free from <a href="https://www.google.com/recaptcha" target="_blank">Google</a>') ?></p>
                    </div>
                    <div class="form-group mb-4 <?php echo config("captcha") == 6 || config("captcha") == 0 ? 'd-none' : '' ?>">
					    <label for="captcha_private" class="form-label fw-bold"><?php ee('Private Key') ?></label>
					    <input type="text" class="form-control p-2" name="captcha_private" id="captcha_private" value="<?php echo config('captcha_private') ?>">
					    <p class="form-text"><?php ee('For reCaptcha, you can get your private key for free from <a href="https://www.google.com/recaptcha" target="_blank">Google</a>') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>