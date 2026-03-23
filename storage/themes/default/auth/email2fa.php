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
                                <h6 class="h3 mb-2"><?php ee('Enter your email verification code') ?></h6>
                                <p class="text-muted mb-0"><?php ee("A verification code has been sent to your email address. Please enter the 6-digit code to complete your login.") ?></p>
                            </div>
                            <span class="clearfix"></span>
                            <?php message() ?>
                            <form method="post" action="<?php echo route('login.email2fa.validate') ?>">
                                <?php echo csrf() ?>
                                <div class="form-group">
                                    <label class="form-control-label"><?php ee('Verification Code') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control form-control-prepend" id="input-code" size="6" name="code" data-mask="000 000" required autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i data-feather="mail"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <a href="<?php echo route('login.email2fa.resend') ?>" class="small text-muted" onclick="event.preventDefault(); document.getElementById('resend-form').submit();"><?php ee('Resend Code') ?></a>
                                        <span class="small text-muted"><?php ee('Code expires in 10 minutes') ?></span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block btn-primary"><?php ee('Verify') ?></button>
                                </div>
                            </form>
                            <form id="resend-form" method="post" action="<?php echo route('login.email2fa.resend') ?>" style="display: none;">
                                <?php echo csrf() ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
