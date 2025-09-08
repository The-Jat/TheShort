<div id="return-error"></div>
<form action="<?php echo route('shorten') ?>" method="post" data-trigger="shorten-form" enctype="multipart/form-data">
    <?php echo csrf() ?>
    <div class="d-flex items-align-center border rounded rounded-3">
        <div class="flex-grow-1" id="linksinput">
            <div id="single" class="collapse show" data-bs-parent="#linksinput">
                <input type="text" class="form-control p-3 border-0" name="url" id="url" placeholder="<?php ee('Paste a long link') ?>">
            </div>
            <div id="multiple" class="collapse" data-bs-parent="#linksinput">
                <textarea name="urls" rows="5" class="form-control p-3 border-0" name="urls" id="urls" placeholder="<?php ee('Paste up to 10 long urls. One URL per line.') ?>"></textarea>
                <input type="hidden" name="multiple" value="0">
            </div>
        </div>
        <div class="align-self-center me-3">
            <div class="btn-group">
                <button type="button" class="btn btn-default border" data-bs-toggle="collapse" data-bs-target="#advancedOptions"><i data-feather="sliders" data-bs-toggle="tooltip" title="<?php ee('Advanced Options') ?>"></i></button>
                <button type="submit" class="btn btn-primary rounded-3 px-3 py-2">
                    <span class="d-none d-sm-block"><?php ee('Shorten') ?></span>
                    <span class="d-block d-sm-none"><i class="fa fa-link"></i></span>
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex mt-4">
        <div class="btn-group ms-auto rounded border">
            <button type="button" class="btn btn-light rounded btn-sm active" data-bs-toggle="collapse" data-trigger="toggleSM" data-value="single" data-bs-target="#single"><?php ee('Single') ?></button>
            <button type="button" class="btn btn-light rounded btn-sm" data-bs-toggle="collapse" data-trigger="toggleSM" data-value="multiple" data-bs-target="#multiple"><?php ee('Multiple') ?></button>
        </div>
    </div>
    <div class="collapse" id="advancedOptions">
        <div class="row">
            <?php if($domains = \Helpers\App::domains()): ?>
            <div class="col-sm-6 mt-3">
                <div class="form-group rounded input-select">
                    <label for="domain" class="form-label fw-bold"><?php ee('Domain') ?></label>
                    <select name="domain" id="domain" class="form-select border-start-0 ps-0" data-toggle="select">
                        <?php foreach($domains as $domain): ?>
                            <option value="<?php echo $domain ?>" <?php echo user()->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <?php endif ?>
            <?php if($redirects = \Helpers\App::redirects()): ?>
            <div class="col-sm-6 mt-3">
                <div class="form-group rounded input-select">
                    <label for="type" class="form-label fw-bold"><?php ee('Redirect') ?></label>
                    <select name="type" id="type" class="form-select border-start-0 ps-0" data-toggle="select">
                        <?php foreach($redirects as $name => $redirect): ?>
                            <optgroup label="<?php echo $name ?>">
                            <?php foreach($redirect as $id => $name): ?>
                                <option value="<?php echo $id ?>" <?php echo user()->defaulttype == $id ? 'selected' : '' ?>><?php echo $name ?></option>
                            <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <?php endif ?>
        </div>
        <div class="row">
            <?php if(\Core\Auth::user()->has("alias") !== false): ?>
            <div class="col-sm-6 mt-3">
                <div class="form-group">
                    <label for="custom" class="form-label fw-bold"><?php ee('Custom') ?></label>
                    <p class="form-text"><?php ee('If you need a custom alias, you can enter it below.') ?></p>
                    <div class="input-group">
                        <div class="input-group-text bg-white"><i data-feather="globe"></i></div>
                        <input type="text" class="form-control border-start-0 ps-0 p-2" name="custom" id="custom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off">
                    </div>
                </div>
            </div>
            <?php endif ?>
            <?php if(\Core\Auth::user()->has("channels") !== false): ?>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="channel" class="form-label fw-bold"><?php echo e("Channel")?></label>
                    <p class="form-text"><?php echo e('Assign link to a channel.')?></p>
                    <div class="form-group rounded input-select">
                        <select name="channel" id="channel" class="form-select" data-toggle="select">>
                            <option value="0"><?php ee('None') ?></option>
                            <?php foreach(\Core\DB::channels()->where('userid', user()->rID())->findArray() as $channel): ?>
                                <option value="<?php echo $channel['id'] ?>"><?php echo $channel['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>
        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="pass" class="form-label fw-bold"><?php ee('Password Protection') ?></label>
                    <p class="form-text"><?php ee('By adding a password, you can restrict the access.') ?></p>
                    <div class="input-group">
                        <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                        <input type="text" class="form-control border-start-0 ps-0 p-2" name="pass" id="pass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="expiry" class="form-label fw-bold"><?php echo e("Description")?></label>
                    <p class="form-text"><?php echo e('This can be used to identify URLs on your account.')?></p>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i data-feather="tag"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0 p-2" name="description" id="description" placeholder="<?php echo e("Type your description here")?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="button" class="btn btn-primary w-100 py-2 rounded-3" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="settings"></i> <span class="align-middle ms-2"><?php ee('Customize') ?></span></button>
            <ul class="dropdown-menu dropdown-nav">
                <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#metatags"><i data-feather="edit-3"></i> <?php ee('Meta Tags') ?></a></li>
                <?php if(\Core\Auth::user()->has("deeplink") !== false && config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#deeplink,#device"><i data-feather="git-branch"></i> <?php ee('Deep Linking') ?></a></li>
                <?php endif ?>
                <?php if(config("geotarget") && \Core\Auth::user()->has("geo") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#geo"><i data-feather="map-pin"></i> <?php ee('Geo Targeting') ?></a></li>
                <?php endif ?>
                <?php if(config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#device"><i data-feather="smartphone"></i> <?php ee('Device Targeting') ?></a></li>
                <?php endif ?>
                <?php if(\Core\Auth::user()->has("language") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#language"><i data-feather="globe"></i> <?php ee('Language Targeting') ?></a></li>
                <?php endif ?>
                <?php if(\Core\Auth::user()->has("pixels") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#pixels"><i data-feather="compass"></i> <?php ee('Pixels') ?></a></li>
                <?php endif ?>
                <?php if(\Core\Auth::user()->has("expiration") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#expiration"><i data-feather="alert-triangle"></i> <?php ee('Expiration') ?></a></li>
                <?php endif ?>
                <?php if(\Core\Auth::user()->has("abtesting") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#abtesting"><i data-feather="refresh-ccw"></i> <?php ee('A/B Testing') ?></a></li>
                <?php endif ?>
                <?php if(\Core\Auth::user()->has("parameters") !== false):?>
                    <li><a class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#parameters"><i data-feather="hash"></i> <?php ee('Parameters') ?></a></li>
                <?php endif ?>
            </url>
        </div>
        <div id="metatags" class="mt-4 collapse border p-3 rounded-3">
            <h4><i class="me-2" data-feather="edit-3"></i> <span class="align-middle"><?php echo e("Meta Tags")?></span></h4>
            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-3 d-flex align-items-center">
                        <div class="me-3">
                            <label for="metaimage" role="button">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAJCAQAAACRI2S5AAAAEklEQVR42mP8/58BL2AcVQAGAHscEfhX5bYNAAAAAElFTkSuQmCC" width="200" class="rounded-3 border shadow-sm" id="metaimage-preview">
                            </label>
                        </div>
                        <div>
                            <label for="metaimage" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2 mb-2">
                                <?php ee('Upload Custom Banner') ?>
                            </label>
                            <p class="text-muted mb-0"><?php ee("Banner must be a {f} and the size must be less than {s}kb.", null, ['f' => 'jpg,png,jpeg', 's' => '500']) ?></p>
                            <input type="file" name="metaimage" id="metaimage" class="d-none" accept="image/*" data-auto-crop data-max-size="500" data-allowed-extensions="jpg,png,jpeg" data-preview-selector="#metaimage-preview" data-ratio="2:1" data-error="<?php ee("Banner must be a {f} and the size must be less than {s}kb.", null, ['f' => 'jpg,png,jpeg', 's' => '500']) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="metatitle" class="form-label fw-bold"><?php ee('Meta Title') ?></label>
                        <input type="text" class="form-control p-2" name="metatitle" id="metatitle" placeholder="<?php echo e("Enter your custom meta title")?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="metadescription" class="form-label fw-bold"><?php ee('Meta Description') ?></label>
                        <input type="text" class="form-control p-2" name="metadescription" id="metadescription" placeholder="<?php echo e("Enter your custom meta description")?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <?php if(config("geotarget") && \Core\Auth::user()->has("geo") !== false):?>
            <div class="collapse mt-4 border p-3 rounded-3" id="geo">
                <div class="d-flex">
                    <h4><i class="me-2" data-feather="map-pin"></i> <span class="align-middle"><?php echo e("Geo Targeting")?></span></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary rounded-3" data-trigger="addmore" data-for="geo"><i class="fa fa-plus me-1"></i> <?php echo e("Add")?></a>
                    </div>
                </div>
                <p class="form-text"><?php echo e('If you have different pages for different countries then it is possible to redirect users to that page using the same URL. Simply choose the country and enter the URL.')?></p>
                <div class="row" data-toggle="addable" data-label="geo" data-states="<?php echo route('server.states') ?>">
                    <div class="col-6 mt-3">
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                            <select name="location[]" class="form-control border-start-0 ps-0" data-trigger="getStates" data-toggle="select">
                                <?php echo \Core\Helper::Country('United States', true) ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                            <select name="state[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                <option value="0"><?php ee('All States') ?></option>
                                <?php foreach(\Helpers\App::states('United States') as $state): ?><option value="<?php echo strtolower($state->name) ?>"><?php echo $state->name ?></option><?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                            <input type="text" name="target[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if(\Core\Auth::user()->has("deeplink") !== false && config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>
            <div class="collapse mt-4 border p-3 rounded-3" id="deeplink">
                <div class="form-group d-flex align-items-center">
                    <div class="me-1">
                        <label for="deeplink[enabled]" class="form-label h4"><i class="fa fa-wand-sparkles me-3"></i><?php ee('Deep Linking') ?></label>
                        <p class="mb-0"><?php ee('Enable this feature to force apps to open when visiting on mobile or open app store if app is not installed.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="deeplink[enabled]" name="deeplink[enabled]" value="1" data-toggle="togglefield" data-toggle-for="deelinkapple,deelinkgoogle" data-server="<?php echo route('server.deeplink') ?>">
                    </div>
                </div>
                <div class="form-group my-3 d-none">
                    <p class="mb-3 border border-dark border-2 text-primary rounded-3 p-2 d-flex align-items-center"><i class="fa fa-question-circle fa-2x me-3"></i> <span><?php ee('To use deep links, you will need to define a main URL that will be used for all other devices, an app specific URL for iPhone/iPad and/or Android and the associated app store URL.') ?> <?php ee('You need to use the Device Targeting to set the correct app links for the associated devices') ?>.</span></p>
                    <label class="form-label fw-bold"><?php ee('Link to App Store') ?></label>
                    <input type="text" class="form-control p-2" id="deelinkapple" name="deeplink[apple]" placeholder="https://">
                </div>
                <div class="form-group d-none">
                    <label class="form-label fw-bold"><?php ee('Link to Google Play') ?></label>
                    <input type="text" class="form-control p-2" id="deelinkgoogle" name="deeplink[google]" placeholder="https://">
                </div>
            </div>
        <?php endif ?>
        <?php if(config("devicetarget") && \Core\Auth::user()->has("device") !== false):?>
            <div class="collapse mt-4 border p-3 rounded-3" id="device">
                <div class="d-flex">
                    <h4><i class="me-2" data-feather="smartphone"></i> <span class="align-middle"><?php echo e("Device Targeting")?></span></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary rounded-3" data-trigger="addmore" data-for="device"><i class="fa fa-plus me-1"></i> <?php echo e("Add")?></a>
                    </div>
                </div>
                <p class="form-text">
                    <?php echo e('If you have different pages for different devices (such as mobile, tablet etc) then it is possible to redirect users to that page using the same short URL. Simply choose the device and enter the URL.')?>
                </p>
                <div class="row" data-toggle="addable" data-label="device">
                    <div class="col-sm-6 mt-3">
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="smartphone"></i></span>
                            <select name="device[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                <?php echo \Core\Helper::devices() ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                            <input type="text" name="dtarget[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if(\Core\Auth::user()->has("language") !== false):?>
            <div class="collapse mt-4 border p-3 rounded-3" id="language">
                <div class="d-flex">
                    <h4><i class="me-2" data-feather="globe"></i> <span class="align-middle"><?php echo e("Language Targeting")?></span></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary rounded-3" data-trigger="addmore" data-for="language"><i class="fa fa-plus me-1"></i> <?php echo e("Add")?></a>
                    </div>
                </div>
                <p class="form-text"><?php echo e('If you have different pages for different languages then it is possible to redirect users to that page using the same URL. Simply choose the language and enter the URL.')?></p>
                <div class="row" data-toggle="addable" data-label="language">
                    <div class="col-sm-6 mt-3">
                        <div class="input-group input-select">
                            <span class="input-group-text bg-white"><i data-feather="type"></i></span>
                            <select name="language[]" class="form-select border-start-0 ps-0" data-toggle="select">
                                <?php echo \Helpers\App::languagelist('en') ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="link"></i></span>
                            <input type="text" name="ltarget[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if(\Core\Auth::user()->has("pixels") !== false):?>
            <div id="pixels" class="collapse mt-4 border p-3 rounded-3">
                <h4><i class="me-2" data-feather="compass"></i> <span class="align-middle"><?php echo e("Targeting Pixels")?></span></h4>
                <p class="form-text"><?php echo e('Add your targeting pixels below from the list. Please make sure to enable them in the pixels settings.')?></p>
                <div class="input-group input-select">
                    <span class="input-group-text bg-white"><i data-feather="filter"></i></span>
                    <select name="pixels[]" data-placeholder="Your Pixels" multiple data-toggle="select">
                        <?php foreach(\Core\Auth::user()->pixels() as $type => $pixels): ?>
                            <optgroup label="<?php echo ucwords($type) ?>">
                            <?php foreach($pixels as $pixel): ?>
                                <option value="<?php echo $pixel->type ?>-<?php echo $pixel->id ?>"><?php echo $pixel->name ?></option>
                            <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        <?php endif ?>
        <?php if (\Core\Auth::user()->has("expiration") !== false): ?>
            <div class="collapse mt-4 border p-3 rounded-3" id="expiration">
                <div class="d-flex">
                    <h4><i class="me-2" data-feather="alert-triangle"></i> <span class="align-middle"><?php echo e("Expiration")?></span></h4>
                </div>
                <p class="form-text">
                    <?php echo e("Links can be expired based on the amount of clicks or a specific date. You can also set a url to redirect to when the link expires.")?>
                </p>
                <div class="row" >
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="expiry" class="form-label fw-bold"><?php ee('Link Expiration') ?></label>
                            <p class="form-text"><?php ee('Set an expiration date to disable the link.') ?></p>
                            <div class="input-group">
                                <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                                <input type="text" class="form-control border-start-0 ps-0 p-2" data-toggle="datetimepicker" name="expiry" id="expiry" placeholder="<?php echo e("MM/DD/YYYY")?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <?php if(\Core\Auth::user()->has("clicklimit") !== false):?>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="expiry" class="form-label fw-bold"><?php ee('Click Limit') ?></label>
                                <p class="form-text"><?php ee('Limit the number of clicks.') ?></p>
                                <div class="input-group">
                                    <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                                    <input type="text" class="form-control border-start-0 ps-0 p-2" name="clicklimit" id="clicklimit" autocomplete="off" placeholder="e.g. 100">
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-group mt-3">
                    <label for="expiry" class="form-label fw-bold"><?php ee('Expiration Redirect') ?></label>
                    <p class="form-text"><?php ee('Set a link to redirect traffic to when the short link expires.') ?></p>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                        <input type="text" name="expirationredirect" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if (\Core\Auth::user()->has("abtesting") !== false): ?>
            <div class="collapse mt-4 border p-3 rounded-3" id="abtesting">
                <div class="d-flex">
                    <h4><i class="me-2" data-feather="refresh-ccw"></i> <span class="align-middle"><?php echo e("A/B Testing & Rotator")?></span></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary rounded-3" data-trigger="addmore" data-for="abtesting"><i class="fa fa-plus me-1"></i> <?php echo e("Add")?></a>
                    </div>
                </div>
                <p class="form-text">
                    <?php echo e("You can rotate multiple links using this feature. If you do not assign a percentage or the percentage is 100% for all links then the traffic will equally distributed. Please note that default link will be added to the list as well and rotator will not work if you assign another targeting condition that matches.")?>
                </p>
                <div class="row" data-toggle="addable" data-label="abtesting">
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="globe"></i></span>
                            <input type="text" name="abtesting[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type the url to redirect user to.")?>">
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="percent"></i></span>
                            <input type="text" name="abtestingpercent[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Type percentage e.g. 100")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if (\Core\Auth::user()->has("parameters") !== false): ?>
            <div class="collapse mt-4 border p-3 rounded-3" id="parameters">
                <div class="d-flex">
                    <h4><i class="me-2" data-feather="hash"></i> <span class="align-middle"><?php echo e("Parameter Builder")?></span></h4>
                    <div class="ms-auto">
                        <a href="#" class="btn btn-sm btn-primary rounded-3" data-trigger="addmore" data-for="parameters"><i class="fa fa-plus me-1"></i> <?php echo e("Add")?></a>
                    </div>
                </div>
                <p class="form-text">
                    <?php echo e("You can add custom parameters like UTM to the link above using this tool. Choose the parameter name and then assign a value. These will be added during redirection.")?>
                </p>
                <div class="row" data-toggle="addable" data-label="parameters">
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="list"></i></span>
                            <input type="text" name="paramname[]" class="form-control border-start-0 ps-0 p-2" data-trigger="autofillparam" placeholder="<?php echo e("Parameter name")?>">
                        </div>
                    </div>
                    <div class="col-sm-6 mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="edit"></i></span>
                            <input type="text" name="paramvalue[]" class="form-control border-start-0 ps-0 p-2" placeholder="<?php echo e("Parameter value")?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</form>