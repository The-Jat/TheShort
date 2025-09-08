<div class="container my-5">
    <div class="card card-body shadow-sm rounded-4">
        <div class="text-center mb-4">
            <?php if(config('logo')): ?>
                <img src="<?php echo uploads(config('logo')) ?>" alt="<?php echo config('title') ?>" class="mb-3" height="45">
            <?php else: ?>
                <h1 class="h3"><?php echo config('title') ?></h1>
            <?php endif ?>
            
            <?php if(isset($client)): ?>
                <p class="text-muted">
                    <?php ee('The application "{name}" is requesting access to your account', null, ['name' => '<strong>'.$client->name.'</strong>']) ?>
                </p>
            <?php endif ?>
        </div>

        <?php if(!Auth::logged()): ?>
            <div class="login-form">
                <form method="post" action="<?php echo route('login') ?>">
                    <?php echo csrf() ?>
                    <input type="hidden" name="redirect" value="<?php echo \Core\Helper::requestUri() ?>">
                    
                    <?php if($error): ?>
                        <div class="alert alert-danger">
                            <?php echo $error ?>
                        </div>
                    <?php endif ?>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label"><?php ee('Email address') ?></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="<?php ee('Email address') ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">
                            <?php ee('Password') ?>
                            <a href="<?php echo route('forgot') ?>" class="float-end small"><?php ee('Forgot Password?') ?></a>
                        </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="<?php ee('Password') ?>" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Login to Continue') ?></button>
                    </div>

                    <?php if(config('user_registration')): ?>
                        <p class="text-center mt-4">
                            <?php ee("Don't have an account?") ?> <a href="<?php echo route('register') ?>"><?php ee('Register') ?></a>
                        </p>
                    <?php endif ?>
                </form>
            </div>
        <?php else: ?>
            <div class="authorization-form">
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo $user->avatar() ?>" class="rounded-circle" width="40" height="40">
                        <div class="ms-3">
                            <strong><?php echo $user->email ?></strong>
                            <div class="text-muted small"><?php echo $user->username ?></div>
                        </div>
                    </div>
                    <p class="text-muted small">
                        <?php ee('By clicking Authorize, you allow this application to:') ?>
                    </p>
                    <ul class="text-muted small">
                        <li><?php ee('Access your basic information') ?></li>
                        <li><?php ee('View your links and their statistics') ?></li>
                        <li><?php ee('Create short links on your behalf') ?></li>
                    </ul>
                </div>

                <form method="post" action="<?php echo route('oauth.authorize') ?>">
                    <?php echo csrf() ?>
                    <input type="hidden" name="client_id" value="<?php echo $client->client_id ?>">
                    <input type="hidden" name="redirect_uri" value="<?php echo $client->redirect_uri ?>">
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo route('home') ?>" class="btn btn-light"><?php ee('Cancel') ?></a>
                        <button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Authorize Application') ?></button>
                    </div>
                </form>

                <div class="mt-4">
                    <p class="text-muted small text-center">
                        <?php ee('This application will not have access to your password or any other private information.') ?>
                    </p>
                </div>
            </div>
        <?php endif ?>
    </div>
</div> 