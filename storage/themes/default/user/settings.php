<h1 class="h3 mb-5 fw-bold"><?php ee('Settings') ?></h1>
<div class="row">
    <div class="col-md-8">
        <?php if(empty($user->username)): ?>
            <div class="custom-alert bg-white shadow-sm alert border border-warning d-flex align-items-center rounded-4">
                <i class="fa fa-warning fs-4 text-warning me-2"></i>
                <?php echo e("You have used a social network to login. You will need to choose a username.") ?>
            </div>
        <?php endif ?>
        <form method="post" action="<?php echo route('settings.update') ?>" enctype="multipart/form-data" autocomplete="off" id="settings-form">
            <?php echo csrf() ?>
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <div class="form-group mb-3 mb-4 d-flex align-items-center">
                        <div class="me-3">
                            <label for="avatar" role="button">
                                <img src="<?php echo $user->avatar() ?>" width="100" class="rounded-3 border shadow-sm" id="avatar-preview">
                            </label>
                        </div>
                        <div>
                            <label for="avatar" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2">
                                <?php ee('Upload') ?>
                            </label>
                            
                            <?php if($user->avatar): ?>
                                <button type="button" class="btn btn-sm bg-white border fw-bold rounded-3 py-2 shadow-sm" data-trigger="removeimage" id="removeavatar">
                                    <?php ee('Remove Image') ?>
                                </button>
                            <?php endif ?>
                            <p class="form-text mb-0"><?php ee('By default, we will use the Gravatar associated to your email. Uploaded avatars must be square with the width ranging from 200-500px with a maximum size of {s}kb.', null, ['s' => config('sizes')->avatar]) ?></p>
                            <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*" data-auto-crop data-max-size="<?php echo config('sizes')->avatar ?>" data-allowed-extensions="<?php echo config('extensions')->avatar ?>" data-preview-selector="#avatar-preview" data-error="<?php ee('Avatar must be the one of the following formats and size: {f} - {s}kb.', null, ['f' => config('extensions')->avatar, 's' => config('sizes')->avatar]) ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 mt-2"><?php ee('Save Changes') ?></button>
                </div>
            </div>            
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                                <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo $user->name ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label fw-bold"><?php ee('Email') ?></label>
                                <input type="text" class="form-control p-2" name="email" id="email" value="<?php echo $user->email ?>">
                                <?php if(config("user_activate")): ?>
                                    <p class="form-text"><?php echo e("Please note that if you change your email, you will need to activate your account again.") ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="username" class="form-label fw-bold"><?php ee('Username') ?></label>
                                <input type="text" class="form-control p-2" name="username" id="username" value="<?php echo $user->username ?>" <?php echo (empty($user->username)?"":" disabled")?>>
                                <p class="form-text"><?php ee('A username is required for your public profile to be visible.') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="f-password"><?php echo e("Password")?></label>
                                <input type="password" value="" name="password" id="f-password" class="form-control p-2" autocomplete="new-password" />
                                <p class="form-text"><?php ee("Leave blank to keep current one.") ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="f-cpassword"><?php echo e("Confirm Password")?></label>
                                <input type="password" value="" name="cpassword" id="f-cpassword" class="form-control p-2" autocomplete="off" />
                                <p class="form-text"><?php ee("Leave blank to keep current one.") ?></p>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 mt-2"><?php ee('Save Changes') ?></button>
                </div>
            </div>
            <h4 class="mt-5 mb-4 fw-bold"><?php ee('Billing Address') ?></h4>
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="billingname"><?php echo e("Full Name") ?></label>
                                <input type="text" class="form-control p-2" id="billingname" name="billingname" placeholder="e.g. John Doe" value="<?php echo (isset($user->address->name) ? $user->address->name : $user->name ) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="type"><?php echo e("Account Type") ?></label>
                                <select name="type" class="form-select p-2">
                                    <option value="personal" <?php echo (!isset($user->address->type) || $user->address->type != 'business' ? 'selected' : '') ?>><?php ee('Personal') ?></option>
                                    <option value="business" <?php echo (isset($user->address->type) && $user->address->type == 'business' ? 'selected' : '') ?>><?php ee('Business') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="company"><?php echo e("Company Name") ?></label>
                                <input type="text" class="form-control p-2" id="company" name="company" placeholder="e.g. Acme Inc" value="<?php echo (isset($user->address->company) ? $user->address->company : "" ) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="taxid"><?php echo e("Tax ID") ?></label>
                                <input type="text" class="form-control p-2" id="taxid" name="taxid" placeholder="e.g. 123" value="<?php echo (isset($user->address->taxid) ? $user->address->taxid : "" ) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 mb-3">
                        <label class="form-label fw-bold" for="address"><?php echo e("Address") ?></label>
                        <input type="text" class="form-control p-2" id="address" name="address" value="<?php echo (isset($user->address->address) ? $user->address->address : "" ) ?>">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="city"><?php echo e("City") ?></label>
                                <input type="text" class="form-control p-2" id="city" name="city" placeholder="e.g. New York" value="<?php echo (isset($user->address->city) ? $user->address->city : "" ) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="state"><?php echo e("State/Province") ?></label>
                                <input type="text" class="form-control p-2" id="state" name="state" placeholder="e.g. NY" value="<?php echo (isset($user->address->state) ? $user->address->state : "" ) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3 input-select rounded">
                                <label class="form-label fw-bold" for="country"><?php echo e("Country") ?></label>
                                <select name="country" id="country" class="form-control p-2" data-toggle="select">
                                    <?php echo \Core\Helper::Country($user->address->country ?? request()->country()['country'], true, true) ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="zip"><?php echo e("Zip/Postal code") ?></label>
                                <input type="text" class="form-control p-2" id="zip" name="zip" placeholder="e.g. 44205" value="<?php echo (isset($user->address->zip) ? $user->address->zip : "" ) ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 mt-2"><?php ee('Save Changes') ?></button>
                </div>
            </div>
            <h4 class="mt-5 mb-4 fw-bold"><?php ee('Preferences') ?></h4>
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold" for="domain"><?php echo e("Default Domain")?></label>
                                    <div class="input-group input-select rounded">
                                        <select name="domain" id="domain" class="form-control border-start-0 ps-0" data-toggle="select">
                                            <?php foreach(\Helpers\App::domains() as $domain): ?>
                                                <option value="<?php echo $domain ?>" <?php echo $user->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php if($user->pro()): ?>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="defaulttype" class="form-label fw-bold"><?php echo e("Default Redirection") ?></label>
                                        <div class="input-group input-select rounded">
                                            <select name="defaulttype" id="defaulttype" class="form-select p-2" data-toggle="select">
                                                <option value="direct" <?php echo ($user->defaulttype == "direct" || $user->defaulttype== "" ? " selected":"") ?>> <?php echo e("Direct") ?></option>
                                                <option value="frame" <?php echo ($user->defaulttype == "frame" ? " selected":"") ?>> <?php echo e("Frame") ?></option>
                                                <option value="splash" <?php echo ($user->defaulttype == "splash" ? " selected":"") ?>> <?php echo e("Splash") ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <div class="d-flex">
                                        <div>
                                            <label class="form-check-label fw-bold" for="public"><?php ee('Public Profile') ?></label>
                                            <p class="form-text mt-1"><?php ee('Public profile will be activated only when this option is public.') ?></p>
                                        </div>
                                        <div class="form-check form-switch ms-auto">
                                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="public" name="public" value="1" <?php echo $user->public ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <div class="d-flex">
                                        <div>
                                            <label class="form-check-label fw-bold" for="media"><?php ee('Media Gateway') ?></label>
                                            <p class="form-text mt-1"><?php ee('If enabled, special pages will be automatically created for your media URLs (e.g. youtube, vimeo, dailymotion...).') ?></p>
                                        </div>
                                        <div class="form-check form-switch ms-auto">
                                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="media" name="media" value="1" <?php echo $user->media ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <div class="d-flex">
                                        <div>
                                            <label class="form-check-label fw-bold" for="newsletter"><?php ee('Newsletter') ?></label>
                                            <p class="form-text mt-1"><?php ee('If enabled, you will receive occasional newsletters from us.') ?></p>
                                        </div>
                                        <div class="form-check form-switch ms-auto">
                                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="newsletter" name="newsletter" value="1" <?php echo $user->newsletter ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 mt-2"><?php ee('Save Changes') ?></button>
                    </form>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-3 fw-bold"><?php echo e("Two-Factor Authentication (2FA)") ?></h4>
                <p>
                <?php echo e("2FA is an enhanced level security for your account. Each time you login, an extra step where you will need to enter a unique code will be required to gain access to your account. To enable 2FA, please click the button below and download the <strong>Google Authenticator</strong> app from Apple Store or Play Store.") ?></p>
                <?php if($user->secret2fa): ?>

                    <a href="#qrcode" data-bs-toggle="collapse" data-bs-target="#qrcode" class="mb-4 btn btn-primary btn-sm"><?php ee("View QR") ?></a>
                    <div id="qrcode" class="<?php echo (!request()->qr) ? 'collapse' : '' ?> border p-3 mb-3">
                        <p><img src="<?php echo $QR2FA ?>" width="150"></p>
                        <strong><small><?php echo e("Secret Key") ?></small></strong>: <small data-href="<?php echo $user->secret2fa ?>"><?php echo $user->secret2fa ?></small> <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo $user->secret2fa ?>"><small><?php echo e("Copy")?></small></a>
                    </div>

                    <h5 class="mb-2"><?php echo e("Important") ?></h5>

                    <p><?php echo e("You need to scan the code above with the app. You need to backup the QR code by saving it and save the key somewhere safe in case you lose your phone. You will not be able to login if you can't provide the code, in that case you will need to contact us. If you disable 2FA and re-enable it, you will need to scan a new code.") ?></p>
                    <p><a href="<?php echo route("2fa", ['disable', \Core\Helper::nonce('2fa'.$user->id)]) ?>" class="btn btn-danger"><?php echo e("Disable 2FA") ?></a></p>
                <?php else: ?>
                    <p class="mb-0"><a href=""  data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#twofaModal" class="btn btn-white border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm"><?php echo e("Activate 2FA") ?></a></p>
                <?php endif ?>
            </div>
        </div>
        <?php if(config('fb_connect') || config('tw_connect') || config('gl_connect')): ?>
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-3 fw-bold"><?php echo e("Connect your account") ?></h4>
                <p class="text-muted"><?php echo e("You can connect your account to Facebook, X or Google to login with your social accounts. You can only connect one social media account.") ?></p>
                <?php if(config('fb_connect')): ?>
                    <?php if($user->auth_id && $user->auth == 'facebook'): ?>
                        <a href="#" class="btn btn-white mb-2 border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm">
                            <img src="<?php echo assets('images/facebook.svg') ?>" alt="<?php echo e("Sign in with") ?> Facebook" width="20" class="me-2">
                            <?php echo e("Connected with Facebook") ?>
                        </a>
                    <?php elseif(!$user->auth_id): ?>
                        <a href="<?php echo route('settings.connect', 'facebook') ?>" class="btn btn-white mb-2 border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm" onclick="window.open(this.href, 'facebookConnect', 'width=500,height=600,scrollbars=yes,resizable=yes'); return false;">
                            <img src="<?php echo assets('images/facebook.svg') ?>" alt="<?php echo e("Sign in with") ?> Facebook" width="20" class="me-2" onclick="window.open(this.href, 'facebookConnect', 'width=500,height=600,scrollbars=yes,resizable=yes'); return false;">
                            <?php echo e("Connect with Facebook") ?>
                        </a>
                    <?php endif ?>
                <?php endif ?>
                <?php if(config('tw_connect')): ?>
                    <?php if($user->auth_id && $user->auth == 'twitter'): ?>
                        <a href="#" class="btn btn-white mb-2 border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm">
                            <img src="<?php echo assets('images/x.svg') ?>" alt="<?php echo e("Sign in with") ?> X" height="20" class="me-2">
                            <?php echo e("Connected with X") ?>
                        </a>
                    <?php elseif(!$user->auth_id): ?>
                        <a href="<?php echo route('settings.connect', 'x') ?>" class="btn btn-white mb-2 border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm" onclick="window.open(this.href, 'xConnect', 'width=500,height=600,scrollbars=yes,resizable=yes'); return false;">
                            <img src="<?php echo assets('images/x.svg') ?>" alt="<?php echo e("Sign in with") ?> X" height="20" class="me-2">
                            <?php echo e("Connect with X") ?>
                        </a>
                    <?php endif ?>
                <?php endif ?>
                <?php if(config('gl_connect')): ?>
                    <?php if($user->auth_id && $user->auth == 'google'): ?>
                        <a href="#" class="btn btn-white border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm">
                            <img src="<?php echo assets('images/google.svg') ?>" alt="<?php echo e('Sign in with') ?> Google" width="20" class="me-2">
                            <?php echo e('Connected with Google') ?>
                        </a>
                    <?php elseif(!$user->auth_id): ?>
                        <a href="<?php echo route('settings.connect', 'google') ?>" class="btn btn-white border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm" onclick="window.open(this.href, 'googleConnect', 'width=500,height=600,scrollbars=yes,resizable=yes'); return false;">
                            <img src="<?php echo assets('images/google.svg') ?>" alt="<?php echo e('Sign in with') ?> Google" width="20" class="me-2">
                            <?php echo e('Connect with Google') ?>
                        </a>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
        <?php endif ?>
        <?php if(config('api') && $user->has('api') && $user->teamPermission('api.create')): ?>
			<div class="card card-body shadow-sm rounded-4">
				<h4 class="mb-3 fw-bold"><?php echo e("Developer API Key") ?></h4>
				<p class="mb-0"><a href="<?php echo route('apikeys') ?>" class="btn btn-white border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm"><?php echo e("API Keys") ?></a></p>
			</div>
		<?php endif ?>
        <?php if(config('allowdelete')): ?>
			<div class="card card-body shadow-sm rounded-4">
				<h4 class="mb-3 fw-bold"><?php echo e("Delete your account") ?></h4>
				<p><?php echo e("We respect your privacy and as such you can delete your account permanently and remove all your data from our server. Please note that this action is permanent and cannot be reversed.") ?></p>
				<p class="mb-0"><a href="#" class="btn btn-white border border-danger text-danger fw-bold rounded-3 px-3 py-2 w-100 shadow-sm" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><?php echo e("Delete Permanently") ?></a></p>
			</div>
		<?php endif ?>
        <?php plug('sidebar.settings') ?>
    </div>
</div>

<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Delete your account') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <form action="<?php echo route('terminate') ?>" method="post">
        <div class="modal-body">
        <p><?php ee('We respect your privacy and as such you can delete your account permanently and remove all your data from our server. Please note that this action is permanent and cannot be reversed.') ?></p>
            <?php echo csrf() ?>
            <div class="form-group mb-3">
                <label class="form-label fw-bold"><?php echo e("Confirm Password")?></label>
                <input type="password" value="" name="cpassword" class="form-control p-2" autocomplete="off" />
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm"><?php ee('Delete') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php if($secret): ?>
<div class="modal fade" id="twofaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Two-Factor Authentication (2FA)') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <form action="<?php echo route("2fa", ['enable', \Core\Helper::nonce('2fa'.$user->id)]) ?>" method="get" autocomplete="off">
        <div class="modal-body">

            <p><?php echo e("You need to scan the code above with the app then enter the 6-digit number that you see in the app to activate 2FA. It is highly recommended to backup the unique key somewhere safe.") ?></p>

            <div class="border rounded rounded-4 p-3 mb-3 text-center">
                <p><img src="<?php echo $QR2FA ?>" width="200" class="rounded"></p>
                <strong><span><?php echo e("Secret Key") ?></span></strong>
                <p><span data-href="<?php echo $secret ?>"><?php echo $secret ?></span> <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo $secret ?>"><small><?php echo e("Copy")?></small></a></p>
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-bold mb-2" for="secret-2fa"><?php ee('2FA Access Code') ?></label>
                <input type="number" class="form-control p-3" size="6" maxlength="6" id="secret-2fa" name="secret" placeholder="<?php ee('2FA Access Code') ?>" required>
            </div>
            <?php echo csrf() ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Activate') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif ?>