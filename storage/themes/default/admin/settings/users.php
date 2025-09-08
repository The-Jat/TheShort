<h1 class="h3 mb-5 fw-bold"><?php ee('User Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="user" class="mb-0 form-label fw-bold"><?php ee('User Registration') ?></label>
                            <p class="my-0 form-text"><?php ee('Allow users to register and to bookmark their URLs. If disable registration links will be hidden.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="user" name="user" value="1" <?php echo config("user") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="fb_connect" class="mb-0 form-label fw-bold"><?php ee('User Activation') ?></label>
                            <p class="my-0 form-text"><?php ee('If enabled, an email containing an activation link will be sent to the user.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="user_activate" name="user_activate" value="1" <?php echo config("user_activate") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="require_registration" class="mb-0 form-label fw-bold"><?php ee('Require Registration') ?></label>
                            <p class="my-0 form-text"><?php ee('If enabled, users will be required to create an account before being able to shorten a URL.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="require_registration" name="require_registration" value="1" <?php echo config("require_registration") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="system_registration" class="mb-0 form-label fw-bold"><?php ee('System Registration') ?></label>
                            <p class="my-0 form-text"><?php ee('If disabled, users will not be able to register via the system and will need to use social logins.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="system_registration" name="system_registration" value="1" <?php echo config("system_registration") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="allowdelete" class="mb-0 form-label fw-bold"><?php ee('Account Deletion') ?></label>
                            <p class="my-0 form-text"><?php ee('If enabled, user will be able to completely delete their account and all their associated data.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="allowdelete" name="allowdelete" value="1" <?php echo config("allowdelete") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="verification" class="mb-0 form-label fw-bold"><?php ee('User Verification') ?></label>
                            <p class="my-0 form-text"><?php ee('Choose whether to enable or disable the verification system. If disabled users will not be able to make a verification request.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="verification" name="verification" value="1" <?php echo config("verification") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="gravatar" class="mb-0 form-label fw-bold"><?php ee('Use Gravatar') ?></label>
                            <p class="my-0 form-text"><?php ee('Use Gravatars as default user Avatar.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="gravatar" name="gravatar" value="1" <?php echo config("gravatar") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="userlogging" class="mb-0 form-label fw-bold"><?php ee('User Login Logging') ?></label>
                            <p class="my-0 form-text"><?php ee('Log every time a user logs in. It will allow you to see where the user has logged from.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="userlogging" name="userlogging" value="1" <?php echo config("userlogging") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Login with Facebook') ?></h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">                        
                        <div>
                            <label for="fb_connect" class="form-label mb-0 fw-bold"><?php ee('Login with Facebook') ?></label>
                            <p class="my-0 form-text"><?php ee('Users can login and get registered using their facebook account.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="fb_connect" name="fb_connect" value="1" <?php echo config("fb_connect") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="facebook_app_id,facebook_secret,facebook_cu">
                        </div>                        
                    </div>
                    <div class="form-group mb-3  <?php if(!config('fb_connect')) echo 'd-none' ?>">
					    <label for="facebook_app_id" class="form-label fw-bold"><?php ee('Facebook App ID') ?></label>
					    <input type="text" class="form-control p-2" name="facebook_app_id" id="facebook_app_id" value="<?php echo config('facebook_app_id') ?>">
                    </div>
					<div class="form-group mb-3  <?php if(!config('fb_connect')) echo 'd-none' ?>">
					    <label for="facebook_secret" class="form-label fw-bold"><?php ee('Facebook Secret') ?></label>
					    <input type="text" class="form-control p-2" name="facebook_secret" id="facebook_secret" value="<?php echo config('facebook_secret') ?>">
                    </div>
						<div class="form-group  <?php if(!config('fb_connect')) echo 'd-none' ?>">
					    <label for="facebook_cu" class="form-label fw-bold"><?php ee('Facebook Callback URL') ?></label>
					    <input type="text" class="form-control p-2" id="facebook_cu" value="<?php echo route("login.facebook") ?>" disabled>
					      <p class="form-text"><?php ee('Please use the link above as the authorized callback URL.') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Login with X (Twitter)') ?></h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">                        
                        <div>
                            <label for="tw_connect" class="form-label mb-0 fw-bold"><?php ee('Login with X (Twitter)') ?></label>
                            <p class="my-0 form-text"><?php ee('Users can login and get registered using their X account.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="tw_connect" name="tw_connect" value="1" <?php echo config("tw_connect") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="twitter_key,twitter_secret,twitter_cu">
                        </div>                        
                    </div>
                    <div class="form-group mb-3 <?php if(!config('tw_connect')) echo 'd-none' ?>">
					    <label for="twitter_key" class="form-label fw-bold"><?php ee('Twitter Public Key') ?></label>
					    <input type="text" class="form-control p-2" name="twitter_key" id="twitter_key" value="<?php echo config('twitter_key') ?>">
                    </div>
					<div class="form-group mb-3 <?php if(!config('tw_connect')) echo 'd-none' ?>">
					    <label for="twitter_secret" class="form-label fw-bold"><?php ee('Twitter Secret Key') ?></label>
					    <input type="text" class="form-control p-2" name="twitter_secret" id="twitter_secret" value="<?php echo config('twitter_secret') ?>">
                    </div>
						<div class="form-group <?php if(!config('tw_connect')) echo 'd-none' ?>">
					    <label for="twitter_cu" class="form-label fw-bold"><?php ee('Twitter Callback URL') ?></label>
					    <input type="text" class="form-control p-2" id="twitter_cu" value="<?php echo route("login.twitter") ?>" disabled>
					      <p class="form-text"><?php ee('Please use the link above as the authorized callback URL.') ?></p>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Login with Google') ?></h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">                        
                        <div>
                            <label for="gl_connect" class="form-label mb-0 fw-bold"><?php ee('Login with Google') ?></label>
                            <p class="my-0 form-text"><?php ee('Users can login and get registered using their google account.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="gl_connect" name="gl_connect" value="1" <?php echo config("gl_connect") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="google_cid,google_cs,google_cy">
                        </div>                        
                    </div>
                    <div class="form-group mb-3 <?php if(!config('gl_connect')) echo 'd-none' ?>">
					    <label for="google_cid" class="form-label fw-bold"><?php ee('Google Client ID') ?></label>
					    <input type="text" class="form-control p-2" name="google_cid" id="google_cid" value="<?php echo config('google_cid') ?>">
                    </div>
					<div class="form-group mb-3 <?php if(!config('gl_connect')) echo 'd-none' ?>">
					    <label for="google_cs" class="form-label fw-bold"><?php ee('Google Client Secret') ?></label>
					    <input type="text" class="form-control p-2" name="google_cs" id="google_cs" value="<?php echo config('google_cs') ?>">
                    </div>
						<div class="form-group <?php if(!config('gl_connect')) echo 'd-none' ?>">
					    <label for="google_cy" class="form-label fw-bold"><?php ee('Google Callback URL') ?></label>
					    <input type="text" class="form-control p-2" id="google_cy" value="<?php echo route("login.google") ?>" disabled>
					      <p class="form-text"><?php ee('Please use the link above as the authorized callback URL.') ?></p>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>