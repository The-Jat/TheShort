<div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-between vh-100">
        <div class="col-12 text-center">
            <a href="<?php echo route('home') ?>" class="mb-5 mb-md-0 text-dark text-decoration-none text-center">
            <?php if(config('logo')): ?>
                <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
            <?php else: ?>
                <h1 class="h5 fw-bold"><?php echo config('title') ?></h1>
            <?php endif ?>        
            </a>

            <h6 class="display-1 mb-3 mt-5 fw-bolder text-warning"><?php ee('BRB') ?></h6>
            <p class="lead text-lg mb-5">
                <?php ee('We are currently offline for maintenance. We will be back online as soon as we are done. It should not take long.') ?>
            </p>
            <?php if($facebook = config('facebook')): ?>
                <a href="<?php echo $facebook ?>" class="text-muted fs-3 me-3" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
            <?php endif ?>
            <?php if($twitter = config('twitter')): ?>
                <a href="<?php echo $twitter ?>" class="text-muted fs-3" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
            <?php endif ?>
        </div>
    </div>
</div>