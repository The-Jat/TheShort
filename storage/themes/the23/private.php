<div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-between vh-100">
        <div class="col-12 text-center">
            <a href="<?php echo route('home') ?>" class="mb-5 text-dark text-decoration-none text-center">
            <?php if(config('logo')): ?>
                <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
            <?php else: ?>
                <h1 class="h5 fw-bold"><?php echo config('title') ?></h1>
            <?php endif ?>        
            </a>

            <h6 class="display-1 mb-3 mt-5 fw-bolder gradient-primary clip-text"><?php ee('Hello') ?></h6>
            <p class="lead text-lg mb-5">
                <?php ee('Thanks for your interest but this website is currently used privately.') ?>
            </p>
        </div>
    </div>
</div>