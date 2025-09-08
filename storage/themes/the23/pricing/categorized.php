<div class="row mb-5">
    <?php foreach($plans as $id => $plan): ?>
        <div class="<?php echo $class ?> mb-2 position-relative">
            <?php if($plan['ispopular']): ?>
                <span class="px-3 py-1 position-absolute top-0 start-50 translate-middle zindex-1">
                    <span class="fw-bold badge bg-info py-1 px-3 fs-6"><?php ee('Popular') ?></span>
                </span>  
            <?php endif ?> 
            <div class="card mb-4 text-center h-100 <?php echo $plan['ispopular'] ? 'border border-3 border-info shadow' : 'border-0 shadow-sm ' ?>">
                <div class="p-4">
                    <?php if($plan['icon']): ?>
                        <span class="fs-1 mb-3 d-block"><i class="<?php echo $plan['icon'] ?> gradient-primary clip-text"></i></span>
                    <?php endif ?>
                    <h4 class="fw-bold mb-4"><?php ee($plan['name']) ?></h4>
                    <p><?php echo $plan['description'] ? '<span class="d-block text-muted mt-3">'.e($plan['description']).'</span>': '' ?></p>
                    <div class="h2 mb-2">
                        <strong class="gradient-primary clip-text">
                            <div class="h2 text-center mb-0 fw-bolder" data-pricing-monthly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_monthly"]) ?>" data-pricing-yearly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_yearly"]) ?>" data-pricing-lifetime="<?php echo  $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_lifetime"]) ?>"><strong class="gradient-primary clip-text"><span class="price"><?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_".$default]) ?></span><?php echo $plan['free'] ? '' : '<small data-toggle="pricingterm" data-term-monthly="/'.e('month').'" data-term-yearly="/'.e('year').'" data-term-lifetime=" '.e('lifetime').'" class="fs-6">'.$term.'</small>' ?></strong></div>
                        </strong>
                    </div>             
                    <?php if(isset($plan['discount']) && $plan['discount']): ?>
                        <small data-toggle="discount" class="d-none fw-bold text-success"><?php ee('Save {p}% by paying yearly', null, ['p' => $plan['discount'] ]) ?></small>
                    <?php endif ?>
                    <ul class="list-unstyled mb-4 mt-4">
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold"><?php ee("Short Links") ?></span>
                            <strong><?php echo $plan["urls"] == "0" ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan["urls"]).($plan['ismonthly'] ? '/'.e('mo') : '') ?></strong>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold" data-bs-toggle="tooltip" title="<?php ee('Total clicks allowed over a period') ?>"><?php ee("Link Clicks") ?></span>
                            <strong><?php echo $plan["clicks"] == "0" ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan["clicks"]).'/'.e('mo') ?></strong>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold"><?php ee("QR Codes") ?></span>
                            <strong><?php echo (isset($plan["permission"]->qr) && $plan["permission"]->qr->enabled) ? ($plan["permission"]->qr->count == '0' ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : $plan["permission"]->qr->count).($plan['isqrmonthly'] ? '/'.e('mo') : '') : '<i class="fa fa-times text-danger"></i>' ?></strong>
                        </li>
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="fw-bold"><?php ee("Bio Pages") ?></span>
                            <strong><?php echo (isset($plan["permission"]->bio) && $plan["permission"]->bio->enabled) ? ($plan["permission"]->bio->count == '0' ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : $plan["permission"]->bio->count) : '<i class="fa fa-times text-danger"></i>' ?></strong>
                        </li>
                        <?php echo $plan["permission"]->custom  ? '<li class="mb-3 d-flex justify-content-between fw-bold">'.$plan["permission"]->custom.'<span class="float-end"><i class="fa fa-check text-success"></i></span></li>' : '' ?>
                    </ul>                            
                    <?php if($plan['planurl'] == "#"):?>
                        <a href="<?php echo route('billing') ?>" class="btn bg-secondary mt-5 py-3 d-block"><strong><?php echo $plan['plantext'] ?></strong></a>
                    <?php else: ?>
                        <a href="<?php echo $plan['planurl'] ?>" class="btn btn-primary mt-5 py-3 d-block fw-bolder" data-trigger="checkout"><?php echo $plan['plantext'] ?></a>
                    <?php endif?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<div class="card sticky-top mb-3 border-0 shadow-sm">
    <div class="card-header bg-dark text-white rounded rounded-2 py-3 border-0">
        <div class="row align-items-center">
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <h5 class="mb-0 fw-bold"><?php ee('Compare Plans') ?></h5>
            </div>           
            <div class="col-12 col-md-8">
                <div class="row text-center">
                    <?php foreach($plans as $plan): ?>
                        <div class="col px-3 mt-3 mt-sm-0">
                            <div class="d-flex align-items-center">
                                <span class="fw-bolder"><?php echo $plan['name'] ?></span>
                                <div class="fw-bold gradient-primary clip-text ms-auto">
                                    <?php if($plan['free']): ?>
                                        <?php ee('Free') ?>
                                    <?php else: ?>
                                        <small data-pricing-monthly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_monthly"]) ?>" data-pricing-yearly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_yearly"]) ?>" data-pricing-lifetime="<?php echo  $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_lifetime"]) ?>"><strong class="gradient-primary clip-text"><span class="price"><?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_".$default]) ?></span><?php echo $plan['free'] ? '' : '<small data-toggle="pricingterm" data-term-monthly="/'.e('month').'" data-term-yearly="/'.e('year').'" data-term-lifetime=" '.e('lifetime').'">'.$term.'</small>' ?></strong></small>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php if($plan['planurl'] == "#"):?>
                                <a href="<?php echo route('billing') ?>" class="btn bg-transparent border-white text-white btn-sm d-block mt-2"><strong><?php echo $plan['plantext'] ?></strong></a>
                            <?php else: ?>
                                <a href="<?php echo $plan['planurl'] ?>" class="btn btn-light btn-sm fw-bolder d-block mt-2" data-trigger="checkout"><?php echo $plan['plantext'] ?></a>
                            <?php endif?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach($categories as $category => $title): ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white rounded rounded-2 py-3 border-0">
            <div class="row align-items-center">
                <div class="col-12 col-md-4 mb-2 mb-md-0">
                    <h5 class="mb-0 fw-bold"><?php echo $title ?></h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if($category == 'link'): ?>
                <div class="feature-row p-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <div class="d-flex align-items-center">
                                <span data-bs-toggle="tooltip" data-bs-placement="right" title="<?php ee('Number of short links allowed.') ?>" class="fw-bold"><?php ee('Short Links') ?> <i class="fa-regular fa-circle-question ms-2 text-muted small"></i></span>                                            
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row text-center">
                                <?php foreach($plans as $plan): ?>
                                    <div class="col">
                                        <strong><?php echo $plan["urls"] == "0" ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan["urls"]).($plan['ismonthly'] ? '/'.e('mo') : '') ?></strong>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feature-row p-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <div class="d-flex align-items-center">
                                <span class="fw-bold" data-bs-toggle="tooltip" title="<?php ee('Total clicks allowed over a period') ?>"><?php ee("Link Clicks") ?> <i class="fa-regular fa-circle-question ms-2 text-muted small"></i></span>                                            
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row text-center">
                                <?php foreach($plans as $plan): ?>
                                    <div class="col">
                                        <strong><?php echo $plan["clicks"] == "0" ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan["clicks"]).'/'.e('mo') ?></strong>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php foreach(\Helpers\App::features() as $slug => $feature): ?>
                <?php if(!isset($feature['category'])) $feature['category'] = 'management'; ?>
                <?php if($feature['category'] == $category): ?>
                    <div class="feature-row p-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <span data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo $feature['description'] ?>" class="fw-bold"><?php echo $feature['name'] ?> <i class="fa-regular fa-circle-question ms-2 text-muted small"></i></span>                                            
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="row text-center">
                                    <?php foreach($plans as $plan): ?>
                                        <div class="col">
                                            <?php if(isset($plan["permission"]->{$slug}) && $plan["permission"]->{$slug}->enabled): ?>
                                                <?php if(isset($feature['count']) && $feature['count']): ?>
                                                    <?php if($slug == 'apirate'): ?>
                                                        <strong>
                                                            <?php echo $plan["permission"]->apirate->count == '0' ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : ee('{x}/min', null, ['x' => $plan["permission"]->apirate->count]) ?>
                                                        </strong>
                                                    <?php elseif($slug == 'qr'): ?>
                                                        <strong>
                                                            <?php echo $plan["permission"]->qr->count == '0' ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : $plan["permission"]->qr->count.($plan['isqrmonthly'] ? '/'.e('mo') : '') ?>
                                                        </strong>
                                                    <?php else: ?>
                                                        <strong>
                                                            <?php echo $plan["permission"]->{$slug}->count == '0' ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : $plan["permission"]->{$slug}->count ?>
                                                        </strong>
                                                    <?php endif ?>
                                                <?php elseif($slug == 'bioblocks'): ?>
                                                    <span class="gradient-primary clip-text fw-bold">
                                                        <?php echo !empty($plan["permission"]->bioblocks->custom) ? count(explode(',', $plan["permission"]->bioblocks->custom)).' '.e('Widgets') : count(\Helpers\BioWidgets::widgets()).' '. e('Widgets') ?>
                                                    </span> 
                                                <?php else: ?>
                                                    <i class="fa fa-check text-success"></i>
                                                <?php endif ?>
                                            <?php else: ?>
                                                <i class="fa fa-times text-danger"></i>
                                            <?php endif ?>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
<?php endforeach ?>