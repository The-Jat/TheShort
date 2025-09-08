<a href="<?php echo route('home') ?>" class="position-absolute top-0 start-0 text-dark text-decoration-none d-block ps-4 pt-4" title="<?php echo config('title') ?>">
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
<section>    
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center justify-content-lg-start min-vh-100">
            <div class="col-sm-7 col-lg-6 col-xl-6 py-6 py-md-0">
                <div class="row justify-content-center">
                    <div class="col-11 col-lg-10 col-xl-6">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold"><?php ee('Welcome back') ?></h4>
                        </div>
                        <?php message() ?>
                        <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                            <?php if(config('fb_connect') || config('tw_connect') || config('gl_connect')): ?>
                                <div class="py-3 text-center">
                                    <span class="small fw-bold text-uppercase"><?php ee('Sign in with') ?></span>
                                </div>
                                <div class="d-flex justify-content-center mb-4">
                                    <?php if(config('fb_connect')): ?>
                                        <a href="<?php echo route('login.facebook') ?>" class="btn btn-block btn-icon border rounded-circle" title="<?php echo e("Sign in with") ?> Facebook">
                                            <img src="<?php echo assets('images/facebook.svg') ?>" alt="<?php echo e("Sign in with") ?> Facebook">
                                        </a>
                                    <?php endif ?>
                                    <?php if(config('gl_connect')): ?>
                                        <a href="<?php echo route('login.google') ?>" class="btn btn-block btn-icon border rounded-circle mx-3" title="<?php echo e("Sign in with") ?> Google" data-toggle="tooltip">
                                            <img src="<?php echo assets('images/google.svg') ?>" alt="<?php echo e("Sign in with") ?> Google" >
                                        </a>
                                    <?php endif ?>
                                    <?php if(config('tw_connect')): ?>
                                        <a href="<?php echo route('login.twitter') ?>" class="btn btn-block btn-icon border rounded-circle" title="<?php echo e("Sign in with") ?> X" data-toggle="tooltip">
                                            <img src="<?php echo assets('images/x.svg') ?>" class="p-1" alt="<?php echo e("Sign in with") ?> X">
                                        </a>
                                    <?php endif ?>
                                    <?php if($plugged = plug('sociallogin')): ?>
                                        <?php foreach($plugged as $provider): ?>
                                            <a href="<?php echo $provider['route'] ?>" class="btn btn-block btn-icon border rounded-circle" title="<?php echo e("Sign in with").' '.$provider['name'] ?>"  data-toggle="tooltip">
                                                <img src="<?php echo $provider['icon'] ?>" alt="<?php echo e("Sign in with").' '.$provider['name'] ?>">
                                            </a>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <div class="text-center">
                                    <span class="text-xs text-uppercase"><?php ee('or') ?></span>
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                        <div class="mt-1">
                            <form method="post" action="<?php echo route('login.auth') ?>">
                                <div class="my-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="email" id="input-email" placeholder="name@domain">
                                        <label><?php ee('Email or username') ?></label>
                                    </div>
                                    <div class="d-flex mt-2 d-sm-none">
                                        <div class="ms-auto">
                                            <a href="<?php echo route('register') ?>" class="small text-muted"><?php ee("Don't have an account?") ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" name="password" id="input-pass" placeholder="Enter your password">
                                        <label><?php ee('Password') ?></label>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div class="ms-auto">
                                            <a href="<?php echo route('forgot') ?>" class="small text-muted"><?php ee('Forgot Password?') ?></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check my-4 text-start">
                                    <input class="form-check-input" type="checkbox" value="1" name="rememberme" id="rememberme">
                                    <label class="form-check-label" for="rememberme"><?php ee('Remember me') ?></label>
                                </div>
                                <div class="mt-4">
                                    <?php echo \Helpers\Captcha::display('login') ?>
                                    <?php echo csrf() ?>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary py-2"><?php ee('Login') ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">&copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="font-weight-bold" title="<?php echo config('title') ?>"><?php echo config('sitename') ?></a>. <?php ee('All Rights Reserved') ?></p>
            </div>
        </div>
    </div>
    <div class="gradient-primary position-absolute h-100 top-0 end-0 zindex-10 col-lg-6 col-xl-6 d-none d-lg-flex flex-column justify-content-center">
        <div class="position-relative zindex-10 p-5">
            <div class="text-center text-white mx-auto">
                <h5 class="h5 mt-3 fw-bold"><?php ee("Don't have an account?") ?></h5>
                <p class="opacity-8">
                    <?php ee('Start your marketing campaign now and reach your customers efficiently.') ?>
                </p>
                <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                    <a href="<?php echo route('register') ?>" class="btn btn-light text-primary px-5 rounded-pill shadow-sm"><?php ee('Register') ?></a>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>