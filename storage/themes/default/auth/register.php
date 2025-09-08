<a href="<?php echo route('home') ?>" class="btn btn-white btn-icon-only rounded-circle position-absolute zindex-101 left-4 top-4 d-inline-flex" data-toggle="tooltip" data-placement="right" title="Go back">
    <span class="btn-inner--icon">
        <i data-feather="arrow-left"></i>
    </span>
</a>
<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-md-8 col-lg-5 pt-6">
                <div>
                    <div class="mb-5 text-center">
                        <h6 class="h3 mb-1"><?php ee("Create your account") ?></h6>
                        <p class="text-muted mb-0"><?php ee('Start your marketing campaign now and reach your customers efficiently.') ?></p>
                    </div>
                    <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                        <?php if(config('fb_connect') || config('tw_connect') || config('gl_connect')): ?>                                                               
                            <div class="row">
                                <?php if(config('fb_connect')): ?>
                                    <div class="col-sm-12 mb-2">
                                        <a href="<?php echo route('login.facebook') ?>" class="btn btn-block btn-neutral btn-icon mb-3 mb-sm-0">
                                            <span class="btn-inner--icon"><img src="<?php echo assets('images/facebook.svg') ?>" alt="<?php echo e("Sign in with") ?> Facebook"></span>
                                            <span class="btn-inner--text"><?php echo e("Sign in with") ?> Facebook</span>
                                        </a>
                                    </div>
                                <?php endif ?>
                                <?php if(config('gl_connect')): ?>
                                    <div class="col-sm-12 mb-2">
                                        <a href="<?php echo route('login.google') ?>" class="btn btn-block btn-neutral btn-icon mb-3 mb-sm-0">
                                            <span class="btn-inner--icon"><img src="<?php echo assets('images/google.svg') ?>" alt="<?php echo e("Sign in with") ?> Google"></span>
                                            <span class="btn-inner--text"><?php echo e("Sign in with") ?> Google</span>
                                        </a>
                                    </div>
                                <?php endif ?>
                                <?php if(config('tw_connect')): ?>
                                    <div class="col-sm-12 mb-2">
                                        <a href="<?php echo route('login.twitter') ?>" class="btn btn-block btn-neutral btn-icon mb-3 mb-sm-0">
                                            <span class="btn-inner--icon"><img src="<?php echo assets('images/twitter.svg') ?>" alt="<?php echo e("Sign in with") ?> Twitter"></span>
                                            <span class="btn-inner--text"><?php echo e("Sign in with") ?> Twitter</span>
                                        </a>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                        <div class="py-3 text-center">
                            <span class="text-xs text-uppercase"><?php ee('or') ?></span>
                        </div> 
                    <?php endif ?>
                    <span class="clearfix"></span>
                    <?php message() ?>
                    <?php if(config('system_registration')): ?>
                    <form method="post" action="<?php echo route('register.validate')?>" autocomplete="off">
                        <?php if($bioalias = request()->bioalias): ?>
                            <div class="form-group">
                                <label class="form-control-label" for="bioalias"><?php ee('Bio Page Alias') ?></label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control form-control-prepend" id="bioalias" name="bioalias" placeholder="<?php ee('Please enter a username') ?>" value="<?php echo $bioalias ?>" readonly="readonly">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <label class="form-control-label" for="user-name"><?php ee('Username') ?></label>
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-prepend" id="user-name" name="username" placeholder="<?php ee('Please enter a username') ?>" value="<?php echo old('username') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="user"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="user-email"><?php ee('Email address') ?></label>
                            <div class="input-group input-group-merge">
                                <input type="email" class="form-control form-control-prepend" id="user-email" name="email" placeholder="<?php ee('Please enter a valid email.') ?>" value="<?php echo old('email') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="at-sign"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label" for="user-pass"><?php ee('Password') ?></label>
                                </div>                                
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control form-control-prepend" id="user-pass" name="password" placeholder="<?php ee('Please enter a valid password.') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="key"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <label class="form-control-label" for="confirm-pass"><?php ee('Confirm Password') ?></label>
                                </div>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control form-control-prepend" id="confirm-pass" name="cpassword" placeholder="<?php ee('Please confirm your password.') ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i data-feather="key"></i></span>
                                </div>
                            </div>
                        </div>
                        <?php if($page): ?>
                            <div class="my-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="check-terms" name="terms" value="1">
                                    <label class="custom-control-label" for="check-terms"><?php ee('I agree to the') ?> <a href="<?php echo route('page', $page->seo) ?>" target="_blank"><?php echo $page->name ?></a>.</label>
                                </div>
                            </div>              
                        <?php else: ?>
                            <div class="my-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="check-terms" name="terms" value="1">
                                    <label class="custom-control-label" for="check-terms"><?php ee('I agree to the terms and conditions') ?>.</label>
                                </div>
                            </div>                
                        <?php endif ?>
                        <div class="mt-4">
                            <?php echo \Helpers\Captcha::display('register') ?>
                            <?php echo csrf() ?>
                            <button type="submit" class="btn btn-block btn-primary"><?php ee('Register') ?></button>
                        </div>
                    </form>
                    <?php endif ?>
                    <div class="mt-4 text-center"><small><?php ee('Already have an account?') ?></small>
                        <a href="<?php echo route('login') ?>" class="small font-weight-bold"><?php ee('Login') ?></a>
                    </div>

                    <div class="text-center mt-5">&copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="font-weight-bold"><?php echo config('title') ?></a>. <?php ee('All Rights Reserved') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>