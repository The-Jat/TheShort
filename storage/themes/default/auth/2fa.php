<a href="<?php echo route('home') ?>" class="btn btn-white btn-icon-only rounded-circle position-absolute zindex-101 left-4 top-4 d-none d-lg-inline-flex" data-toggle="tooltip" data-placement="right" title="Go back">
    <span class="btn-inner--icon">
        <i data-feather="arrow-left"></i>
    </span>
</a>
<section class="section-half-rounded bg-dark py-4 py-sm-0" <?php echo themeSettings::config('homecolor') ?>>
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
                <div class="card shadow-lg border-0 mb-0">
                    <div class="card-body py-5 px-sm-5">
                        <div>
                            <div class="mb-5 text-center">
                                <h6 class="h3 mb-2"><?php ee('Enter your 2FA access code') ?></h6>
                                <p class="text-muted mb-0"><?php ee("The access code can be found on the Authenticator app. Please enter the code shown for this website. If you lost your phone or can't use the app, please contact us.") ?></p>
                            </div>
                            <span class="clearfix"></span>
                            <?php message() ?>
                            <form method="post" action="<?php echo route('login.2fa.validate') ?>">
                                <?php echo csrf() ?>
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('2FA Access Code') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepend" id="input-access" size="6" name="secret" data-mask="000 000" required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="code"></i></span>
                                        </div>
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#recovermodal" class="small text-muted float-end mt-1"><?php ee('Recover 2FA') ?></a>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block btn-primary"><?php ee('Validate') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="recovermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo route('login.2fa.recover') ?>" method="post">
                <?php echo csrf() ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><?php ee('Reset 2FA') ?></h5>
                    <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <p><?php ee('To recover your account, you will need your secret key and access to the email address on the account. If you do not have access to the 2FA secret key, please contact us.') ?></p>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label fw-bold d-block mb-2"><?php ee('Email') ?></label>                        
                        <input type="email" name="email" id="email" placeholder="e.g. email@domain.com" class="form-control p-2">
                    </div>
                    <div class="form-group mb-3">                        
                        <label for="secret" class="form-label fw-bold d-block mb-2"><?php ee('Secret Key') ?></label>                        
                        <input type="text" name="secret" id="secret" class="form-control p-2" placeholder="e.g. ABCXYZ123456789">
                    </div>
                    <button type="submit" class="btn btn-success" class="btn btn-success"><?php ee('Reset') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>