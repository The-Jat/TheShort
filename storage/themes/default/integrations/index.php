<div class="d-flex mb-5">
    <div>
        <h1 class="mb-0 h3 fw-bold"><?php ee('Integrations') ?></h1>
    </div>
</div>

<div class="row">
    <?php foreach($integrations as $integration): ?>
    <div class="col-md-4">
        <div class="card rounded-4 rounded rounded-3 position-relative">
            <?php if(!$integration['available']): ?>
                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center">
                    <div class="position-absolute bg-white opacity-50 w-100 h-100"></div>
                    <div class="position-absolute fw-bold"><a href="<?php echo route('pricing') ?>" class="btn btn-dark shadow-lg"><?php ee('Upgrade') ?></a></div>
                </div>
            <?php endif ?>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <?php echo $integration['icon'] ?? '' ?>
                    <h3 class="fw-bold ms-3 mb-0"><?php echo $integration['name'] ?></h3>
                    <?php if($integration['condition']): ?>
                        <i class="ms-2 fa fa-check-circle fs-5 text-success" data-bs-toggle="tooltip" title="<?php ee('Connected') ?>"></i>  
                    <?php endif ?>    
                    <?php if(isset($integration['link'])): ?>
                        <a href="<?php echo $integration['link'] ?>" target="_blank" class="ms-auto"><i class="fa fa-external-link text-muted opacity-50" data-bs-toggle="tooltip" title="<?php ee('Visit') ?>"></i></a>
                    <?php endif ?>                
                </div>
                <p class="mt-3">
                    <?php echo $integration['description'] ?>
                </p>
            </div>
            <div class="card-footer bg-transparent border-top">
                <a href="<?php echo $integration['route'] ?>" class="btn btn-light bg-white shadow-lg border rounded-3"><?php ee('Connect') ?></a>
            </div>
        </div>
    </div>
    <?php endforeach ?>
    <div class="col-md-4">
        <div class="card rounded-4 rounded rounded-3">
            <?php if(!config('api') || !user()->has('api')): ?>
                <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center">
                    <div class="position-absolute bg-white opacity-50 w-100 h-100"></div>
                    <div class="position-absolute fw-bold"><a href="<?php echo route('pricing') ?>" class="btn btn-dark rounded-3"><?php ee('Upgrade') ?></a></div>
                </div>
            <?php endif ?>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <span class="border rounded-3 text-warning p-2 icon-45 d-flex align-items-center justify-content-center"><i class="fa fa-code"></i></span>
                    <h3 class="fw-bold ms-3 mb-0"><?php ee('Developer API') ?></h3>
                </div>
                <p class="mt-3">
                    <?php ee('Create your own integration to shorten links and interact with other features with our powerful API.') ?>
                </p>                
            </div>
            <div class="card-footer bg-transparent border-top">
                <a href="<?php echo route('apidocs') ?>" class="btn btn-light bg-white shadow-lg border rounded-3"><?php ee('Get Started') ?></a>
            </div>
        </div>        
    </div>
</div>    