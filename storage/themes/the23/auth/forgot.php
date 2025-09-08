<section class="bg-primary min-vh-100">
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center justify-content-lg-start min-vh-100">
            <div class="row justify-content-center px-0 px-sm-5">
                <div class="col-12 col-lg-5">
                    <a href="<?php echo route('home') ?>" class="mb-5 mb-md-0 text-dark text-decoration-none text-center d-block">
                    <?php if(config('logo')): ?>
                        <?php if(config('altlogo') && (request()->cookie('darkmode') || themeSettings::isDark() ? ' data-theme="dark"' : '')): ?>
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('altlogo')) ?>" id="navbar-logo">
                        <?php else: ?>
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                        <?php endif ?>
                    <?php else: ?>
                        <h1 class="h5 fw-bold"><?php echo config('sitename') ?></h1>
                    <?php endif ?>
                    </a>
                    <div class="card border-0 p-5 shadow-sm mt-5">
                        <div class="mb-3 text-center">
                            <h5 class="fw-bold mb-2"><?php ee('Reset Password') ?></h5>
                            <p class="text-muted mb-0"><?php ee("If you forgot your password, you can request a link to reset your password.") ?></p>
                        </div>
                        <?php message() ?>
                        <form method="post" action="<?php echo route('forgot.send') ?>">
                            <div class="my-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="email" id="input-email" placeholder="name@domain">
                                    <label><?php ee('Email') ?></label>
                                </div>
							</div>
                            <div class="mt-4">
                                <?php echo \Helpers\Captcha::display('reset') ?>
                                <?php echo csrf() ?>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2"><?php ee('Reset Password') ?></button>
                                </div>
                            </div>                        
                        </form>
                    </div>
                    <div class="text-center mt-5">&copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="fw-bold"><?php echo config('title') ?></a>. <?php ee('All Rights Reserved') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>