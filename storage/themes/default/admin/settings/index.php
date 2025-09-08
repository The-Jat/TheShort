<h1 class="h3 mb-5 fw-bold"><?php ee('General Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data" id="settings-form">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
					    <label for="url" class="form-label fw-bold"><?php ee('Site URL') ?></label>
					    <input type="text" class="form-control p-2" name="url" id="url" value="<?php echo config('url') ?>">
					    <p class="form-text"><?php ee('Please make sure to include http:// (or https://) and remove the last slash') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="sitename" class="form-label fw-bold"><?php ee('Site Name') ?></label>
					    <input type="text" class="form-control p-2" name="sitename" id="sitename" value="<?php echo config('sitename') ?>">
					    <p class="form-text"><?php ee('This is your site name') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="title" class="form-label fw-bold"><?php ee('Site Title') ?></label>
					    <input type="text" class="form-control p-2" name="title" id="title" value="<?php echo config('title') ?>">
					    <p class="form-text"><?php ee('This is you site meta title') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="description" class="form-label fw-bold"><?php ee('Site Description') ?></label>
					    <input type="text" class="form-control p-2" name="description" id="description" value="<?php echo config('description') ?>">
					    <p class="form-text"><?php ee('This your site description as well as the site meta description') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="keywords" class="form-label fw-bold"><?php ee('Site Keywords') ?></label>
					    <div class="border rounded p-2">
                            <input type="text" class="form-control p-2" name="keywords" id="keywords" placeholder="<?php ee('Site Keywords') ?>" value="<?php echo config('keywords') ?>" data-toggle="tags">
                            <p class="form-text mb-0"><?php ee('This your site keywords as well as the site meta keywords (only some important keywords)') ?></p>                            
                        </div>
                    </div>
                    <div class="form-group mb-4">
					    <label for="logo" class="form-label fw-bold"><?php ee('Logo') ?></label>
                        <?php if(!empty(config("logo"))):  ?>
                            <p><img src="<?php echo uploads(config("logo")) ?>" height="80" alt="" class="bg-secondary rounded p-3"></p>
                        <?php endif ?>
					    <input type="file" name="logo_path" id="logo" class="form-control mb-2">
                        <?php if(!empty(config("logo"))):  ?>
                            <p class="form-text"><a href="#" id="remove_logo" data-trigger="removeimage" class="btn btn-danger btn-sm"><?php ee('Remove Logo') ?></a></p>
                        <?php endif ?>
					    <p class="form-text"><?php ee('Please make sure that the logo is of adequate size and format') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="altlogo" class="form-label fw-bold"><?php ee('Dark Mode Logo') ?></label>
                        <?php if(!empty(config("altlogo"))):  ?>
                            <p><img src="<?php echo uploads(config("altlogo")) ?>" height="80" alt="" class="bg-secondary rounded p-3"></p>
                        <?php endif ?>
					    <input type="file" name="altlogo_path" id="altlogo" class="form-control mb-2">
                        <?php if(!empty(config("altlogo"))):  ?>
                            <p class="form-text"><a href="#" id="remove_altlogo" data-trigger="removeimage" class="btn btn-danger btn-sm"><?php ee('Remove Logo') ?></a></p>
                        <?php endif ?>
					    <p class="form-text"><?php ee('Please make sure that the logo is of adequate size and format. This logo will be used on dark mode.') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="favicon" class="form-label fw-bold"><?php ee('Favicon') ?></label>
                        <?php if(!empty(config("favicon"))):  ?>
                            <p><img src="<?php echo uploads(config("favicon")) ?>" height="32" alt=""></p>
                        <?php endif ?>
					    <input type="file" name="favicon_path" id="favicon" class="form-control mb-2">
                        <?php if(!empty(config("favicon"))):  ?>
                            <p class="form-text"><a href="#" id="remove_favicon" data-trigger="removeimage" class="btn btn-danger btn-sm"><?php ee('Remove Favicon') ?></a></p>
                        <?php endif ?>
					    <p class="form-text"><?php ee('Please make sure that the favicon is of adequate size and format (32x32 png or ico)') ?></p>
                    </div>
                    <div class="form-group mb-4 input-select rounded">
					    <label for="timezone" class="form-label fw-bold"><?php ee('Timezone') ?></label>
                        <select name="timezone" id="timezone" class="form-control p-2" data-toggle="select" title="Timezone" data-live-search="true" data-live-search-placeholder="Timezone">
                            <?php foreach($timezones as $key): ?>
                                <option <?php echo (config("timezone") == $key ? "selected":"") ?> value="<?php echo $key ?>"><?php echo $key ?></option>
                            <?php endforeach ?>
                        </select>
                        <p class="form-text"><?php ee('Select the timezone for your server. This is used to display the correct time on the website.') ?> <?php ee('Current server time is {d}', null, ['d' => \Core\Helper::dtime()]) ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="font" class="form-label fw-bold"><?php ee('Google Font') ?></label>
					    <input class="form-control p-2" name="font" id="font" value="<?php echo config('font') ?>">
					    <p class="form-text"><?php ee('Please add the exact name of the <a href="https://www.google.com/fonts" target="_blank">Google Font</a>: e.g. <strong>Open Sans</strong>') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Social Links') ?></h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group mb-4">
					    <label for="facebook" class="form-label fw-bold"><?php ee('Facebook Page') ?></label>
					    <input type="text" class="form-control p-2" name="facebook" id="facebook" value="<?php echo config('facebook') ?>">
					    <p class="form-text"><?php ee('Link to your Facebook page e.g. http://facebook.com/gempixel') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="twitter" class="form-label fw-bold"><?php ee('Twitter Page') ?></label>
					    <input type="text" class="form-control p-2" name="twitter" id="twitter" value="<?php echo config('twitter') ?>">
					    <p class="form-text"><?php ee('Link to your Twitter profile e.g. http://www.twitter.com/kbrmedia') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="sociallinks[instagram]" class="form-label fw-bold"><?php ee('Instagram Page') ?></label>
					    <input type="text" class="form-control p-2" name="sociallinks[instagram]" id="sociallinks[instagram]" value="<?php echo config('sociallinks')->instagram ?>">
					    <p class="form-text"><?php ee('Link to your Instagram page') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="sociallinks[linkedin]" class="form-label fw-bold"><?php ee('Linkedin Page') ?></label>
					    <input type="text" class="form-control p-2" name="sociallinks[linkedin]" id="sociallinks[linkedin]" value="<?php echo config('sociallinks')->linkedin ?>">
					    <p class="form-text"><?php ee('Link to your Linkedin page') ?></p>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>