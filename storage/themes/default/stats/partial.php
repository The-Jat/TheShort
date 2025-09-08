<div class="card rounded-4 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex">
            <?php if(isset($url->qr)): ?>
                <div class="media-body">
                    <h4 class="mb-3"><?php echo $url->qr->name ?></h4>
                    <span class="badge bg-success text-sm"><?php echo ee('QR Code') ?></span>
                </div>
            <?php elseif(isset($url->profile)): ?>
                <div class="media-body">
                    <h4 class="mb-3"><?php echo $url->profile->name ?></h4>
                    <span class="badge bg-success text-sm"><?php echo ee('Bio Page') ?></span>
                    <?php if(!empty($url->url)): ?>
                        <a href="<?php echo $url->url ?>" target="_blank" class="ml-2"><?php echo $url->url ?></a>
                    <?php endif ?>
                </div>
            <?php else: ?>
                <div class="d-flex align-items-center">
                    <div class="me-3 mr-3">
                        <img src="<?php echo route('link.ico', $url->id) ?>" class="icon-45 rounded-circle border p-1">
                    </div>
                    <div>
                        <h4 class="mb-1"><a href="<?php echo $url->url ?>" target="blank" rel="nofollow" class="text-dark fw-bold"><?php echo $url->meta_title ?></a></h4>
                        <span class="text-muted" data-href="<?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?></span>
                        <p class="mb-0"><?php echo $url->meta_description ?></p>                        
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>  
<div class="row">
    <div class="col-lg-3 col-sm-4">
        <div class="card rounded-4 mb-3 shadow-sm">
            <div class="card-body text-center">                            
                <h5 class="h3 fw-bolder mb-1"><?php echo $url->click ?></h5>
                <span class="d-block text-sm text-muted fw-bold"><?php $url->qrid ? ee('Scans') : ee('Clicks') ?></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-4">
        <div class="card rounded-4 mb-3 shadow-sm">
            <div class="card-body text-center">                            
                <h5 class="h3 fw-bolder mb-1"><?php echo $url->uniqueclick ?></h5>
                <span class="d-block text-sm text-muted fw-bold"><?php $url->qrid ? ee('Unique Scans') : ee('Unique Clicks') ?></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-4">
        <div class="card rounded-4 mb-3 shadow-sm">
            <div class="card-body text-center h-100">              
                <h5 class="h4 fw-bolder mb-1"><?php echo $top->country && !empty($top->country->country) ? '<img src="'.\Helpers\App::flag($top->country->country).'" width="32" class="rounded mr-1" alt=" '.ucfirst($top->country->country).'">': e('Unknown') ?></h5>
                <span class="d-block text-sm text-muted fw-bold"><?php ee('Top Country') ?></span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-4">
        <div class="card rounded-4 mb-3 shadow-sm">
            <div class="card-body text-center h-100">                            
                <h5 class="h4 fw-bolder mb-1"><?php echo $top->referer ? "{$top->referer->domain}" : e('Unknown') ?></h5>
                <span class="d-block text-sm text-muted fw-bold"><?php ee('Top Referrer') ?></span>
            </div>
        </div>
    </div>
</div> 