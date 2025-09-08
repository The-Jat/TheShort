<h1 class="h3 mb-5 fw-bold"><?php ee('Link Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group input-select rounded">
                                <label for="frame" class="form-label fw-bold"><?php ee('Default Redirection') ?></label>
                                <select name="frame" id="frame" class="form-select p-2" data-toggle="select">
                                    <option <?php echo (config("frame") == '0' ? "selected":"") ?> value="0"><?php ee('None') ?></option>	
                                    <option <?php echo (config("frame") == '1' ? "selected":"") ?> value="1"><?php ee('Frame') ?></option>	
                                    <option <?php echo (config("frame") == '2' ? "selected":"") ?> value="2"><?php ee('Splash') ?></option>	
                                    <option <?php echo (config("frame") == '3' ? "selected":"") ?> value="3"><?php ee('Auto') ?></option>	
                                </select>
                                <p class="form-text"><?php ee('Choose the type of redirection mechanism. "None" will directly redirect while "Auto" will add an option to let the user choose for each URL.') ?></p>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="timer" class="form-label fw-bold"><?php ee('Splash Page Timer') ?></label>
                                <input class="form-control p-2" name="timer" id="timer" value="<?php echo config('timer') ?>">
                                <p class="form-text"><?php ee('Timer for the splash page.') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
					    <label for="alias_length" class="form-label fw-bold"><?php ee('Shortener Alias Length') ?></label>
					    <input class="form-control p-2" name="alias_length" id="alias_length" value="<?php echo config('alias_length') ?>">
					    <p class="form-text"><?php ee('This field is used to generate a random alias of X length. Minimum value 2.') ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="schemes" class="form-label fw-bold mb-0"><?php ee('Allowed Schemes') ?></label>
                        <p class="form-text mt-0"><?php ee('Add or remove allowed url schemes.') ?></p>
					    <div class="border rounded rounded-4 p-2">
					        <input type="text" class="form-control p-2" name="schemes" id="schemes" value="<?php echo config('schemes') ?>" data-toggle="tags" placeholder="Enter text">
                        </div>
                    </div>
                    
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="tracking" class="mb-0 form-label fw-bold"><?php ee('Anonymous Links Stats') ?></label>
                            <p class="form-text my-0"><?php ee('Disable this if you do not want to store data for anonymous links. Clicks will still be counted but not anything else. This is good if you want to save on database space.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="tracking" name="tracking" value="1" <?php echo config("tracking") ? 'checked':'' ?>>
                        </div>                        
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="manualapproval" class="mb-0 form-label fw-bold"><?php ee('Manual Link Approval') ?></label>
                            <p class="form-text my-0"><?php ee('Enable this to manually approve all links shortened.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="manualapproval" name="manualapproval" value="1" <?php echo config("manualapproval") ? 'checked':'' ?>>
                        </div>                        
                    </div>     
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="verifylink" class="mb-0 form-label fw-bold"><?php ee('Verify Links') ?></label>
                            <p class="form-text my-0"><?php ee('Enabling this will create a page at /verify/links where users can verify the url source of any short link.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="verifylink" name="verifylink" value="1" <?php echo config("verifylink") ? 'checked':'' ?>>
                        </div>                        
                    </div>                                 
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="show_media" class="mb-0 form-label fw-bold"><?php ee('Media Gateway') ?></label>
                            <p class="form-text my-0"><?php ee('Enabling this will create automatically media pages for URLs such as Youtube, Vine, Dailymotion. Registered users can override this option from user settings.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="show_media" name="show_media" value="1" <?php echo config("show_media") ? 'checked':'' ?>>
                        </div>                        
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="geotarget" class="mb-0 form-label fw-bold"><?php ee('Geo Targeting') ?></label>
                            <p class="form-text my-0"><?php ee('Redirects user according to their country (if set by user). This is a global feature. Disabling this will disable it across the app.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="geotarget" name="geotarget" value="1" <?php echo config("geotarget") ? 'checked':'' ?>>
                        </div>                        
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="devicetarget" class="mb-0 form-label fw-bold"><?php ee('Device Targeting') ?></label>
                            <p class="form-text my-0"><?php ee('Redirects user according to their device (if set by user). This is a global feature. Disabling this will disable it across the app.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="devicetarget" name="devicetarget" value="1" <?php echo config("devicetarget") ? 'checked':'' ?>>
                        </div>                        
                    </div>                    
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>