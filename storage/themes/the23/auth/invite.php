<section class="bg-primary min-vh-100 pt-5">
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
                        <div class="text-center mb-3">
                            <h4 class="fw-bold"><?php ee("Join Team") ?></h4>
                            <p><?php ee("Join team and collaborate on everything") ?></p>
                        </div>                        
                        <?php message() ?>
                        <form method="post" action="<?php echo route('acceptinvitation', [$token]) ?>">                              
                            <div class="my-4">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" disabled value="<?php echo $user->email ?>" id="input-email" placeholder="<?php ee('Please enter a email') ?>">
                                    <label><?php ee('Email') ?></label>
                                </div>                                
							</div>
                            <div class="my-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="username" value="<?php echo old('username') ?>" id="input-username" placeholder="<?php ee('Please enter a username') ?>">
                                    <label><?php ee('Username') ?></label>
                                </div>                                
							</div>
                            <div class="my-4">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="input-pass" placeholder="<?php ee('Please enter a valid password.') ?>">
                                    <label><?php ee('Password') ?></label>
                                </div>
							</div>
                            <div class="my-4">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="cpassword" id="input-cpass" placeholder="<?php ee('Please confirm your password.') ?>">
                                    <label><?php ee('Confirm Password') ?></label>
                                </div>
							</div>

                            <div class="form-check my-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" value="1">
                                <?php if($page): ?>
                                    <label class="form-check-label" for="terms"><?php ee('I agree to the') ?> <a href="<?php echo route('page', $page->seo) ?>" target="_blank"><?php echo $page->name ?></a>.</label>
                                <?php else: ?>
                                    <label class="custom-control-label" for="terms"><?php ee('I agree to the terms and conditions') ?>.</label>
                                <?php endif ?>
                            </div>
                            <div class="mt-4">
                                <?php echo \Helpers\Captcha::display('Register') ?>
                                <?php echo csrf() ?>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2"><?php ee('Accept') ?></button>
                                </div>
                            </div>
                            <p class="text-center mt-5">
                                <?php ee("Already have an account?") ?> <a href="<?php echo route('login') ?>"><?php ee('Login') ?></a>
                            </p>
                        </form>                        
                    </div>
                    <div class="text-center mt-5">&copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="fw-bold"><?php echo config('title') ?></a>. <?php ee('All Rights Reserved') ?></p>
                </div>
            </div>
        </div>
    </div>    
</section>