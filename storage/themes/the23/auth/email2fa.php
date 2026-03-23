<section class="bg-primary min-vh-100 pt-5">
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center justify-content-lg-start min-vh-100">
            <div class="row justify-content-center px-0 px-sm-5">
                <div class="col-12 col-lg-5">
                    <a href="<?php echo route('home') ?>" class="mb-5 mb-md-0 text-dark text-decoration-none text-center">
                    <?php if(config('logo')): ?>
                        <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                    <?php else: ?>
                        <h1 class="h5 fw-bold"><?php echo config('sitename') ?></h1>
                    <?php endif ?>
                    </a>
                    <div class="card border-0 p-5 shadow-sm mt-5">
                        <div class="mb-3">
                            <h6 class="mb-2 fw-bold"><?php ee('Email Verification') ?></h6>
                            <p class="text-muted mb-4"><?php ee("A verification code has been sent to your email address. Please enter the 6-digit code to complete your login.") ?></p>
                        </div>
                        <?php message() ?>
                        <form method="post" action="<?php echo route('login.email2fa.validate') ?>">
                            <div class="my-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control p-3" name="code" id="code" data-mask="000 000" placeholder="000 000" required autocomplete="off">
                                    <label><?php ee('Email Verification Code') ?></label>
                                </div>
                                <div class="d-flex mt-2">
                                    <small class="text-muted ms-auto"><?php ee('Expires in 10 minutes') ?></small>
                                </div>
							</div>        
                            <div class="mt-3">
                                <?php echo csrf() ?>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2"><?php ee('Validate') ?></button>
                                </div>
                            </div>
                        </form>
                        <form id="resend-form" method="post" action="<?php echo route('login.email2fa.resend') ?>" class="mt-3">
                            <?php echo csrf() ?>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-transparent p-0 text-primary text-decoration-none"><?php ee('Resend Code') ?></button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center mt-5">&copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="fw-bold"><?php echo config('title') ?></a>. <?php ee('All Rights Reserved') ?></p>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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