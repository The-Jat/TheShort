<section class="bg-primary py-4 py-sm-0">
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
                <div class="card shadow-sm border-0 mb-0">
                    <div class="card-body py-5 px-sm-5">
                        <div>
                            <div class="mb-5 text-center">
                                <h6 class="h3 mb-2"><?php ee('Enter Password') ?></h6>
                                <p><?php ee('The access to this URL is restricted. Please enter your password to view it.') ?></p>
                            </div>
                            <span class="clearfix"></span>
                            <?php message() ?>
                            <form method="post" action="">
                                <?php echo csrf() ?>
                                <div class="my-4">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" name="password" id="input-pass" placeholder="<?php ee('Please enter a valid password.') ?>">
                                        <label><?php ee('Password') ?></label>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block btn-primary"><?php ee('Unlock') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>