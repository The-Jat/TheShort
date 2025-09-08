<div class="pricing row mt-5">
    <?php foreach($plans as $id => $plan): ?>
        <div class="<?php echo $class ?>">
            <div class="card mb-5 text-center mx-1 position-relative <?php echo ($plan['ispopular'] ? 'border border-3 border-info shadow' : 'border-0 shadow-sm') ?>">
                <div class="w-100 position-absolute top-0 start-50 translate-middle">
                    <?php if($plan['ispopular']): ?>
                        <span class="px-3 py-1 d-inline">
                            <span class="fw-bold badge bg-info py-1 px-3 fs-6"><?php ee('Popular') ?></span>
                        </span>  
                    <?php endif ?> 	                      
                    <?php if(isset($plan['discount']) && $plan['discount']): ?>
                        <span data-toggle="discount" class="d-none px-3 py-1">
                            <span class="fw-bold badge bg-success py-1 px-3 fs-6"><?php ee('Save {p}%', null, ['p' => $plan['discount'] ]) ?></span>
                        </span>
                    <?php endif ?>                  
                </div>
                <div class="p-5 border-0">                    
                    <?php if($plan['icon']): ?>
                        <span class="fs-1 mb-3 d-block"><i class="<?php echo $plan['icon'] ?>"></i></span>
                    <?php endif ?>
                    <span class="d-block h5 mb-4 fw-bold"><?php ee($plan['name']) ?></span>
                    <div class="h2 text-center mb-0 fw-bolder" data-pricing-monthly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_monthly"]) ?>" data-pricing-yearly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_yearly"]) ?>" data-pricing-lifetime="<?php echo  $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_lifetime"]) ?>"><strong class="gradient-primary clip-text"><span class="price"><?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_".$default]) ?></span><?php echo $plan['free'] ? '' : '<small data-toggle="pricingterm" data-term-monthly="/'.e('month').'" data-term-yearly="/'.e('year').'" data-term-lifetime=" '.e('lifetime').'" class="fs-6">'.$term.'</small>' ?></strong></div>
                    <?php echo $plan['description'] ? '<span class="d-block text-muted mt-3">'.e($plan['description']).'</span>': '' ?>
                    <?php if($plan['planurl'] == "#"):?>
                        <a href="<?php echo route('billing') ?>" class="btn bg-secondary mt-5 py-3 d-block"><strong><?php echo $plan['plantext'] ?></strong></a>
                    <?php else: ?>
                        <a href="<?php echo $plan['planurl'] ?>" class="btn btn-primary mt-5 py-3 d-block fw-bolder" data-trigger="checkout"><?php echo $plan['plantext'] ?></a>
                    <?php endif?>
                </div>
                <div class="card-body rounded-bottom p-4 position-relative">
                    <ul class="list-unstyled mb-4 text-start text-dark">
                        <li class="mb-3"><span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php ee('Number of short links allowed.') ?>"><?php ee("Short Links") ?></span><span class="float-end fw-bold"><?php echo $plan["urls"] == "0" ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan["urls"]).($plan['ismonthly'] ? '/'.e('mo') : '') ?></span></li>
                        <li class="mb-3"><span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php ee('Total clicks allowed over a period') ?>"><?php ee("Link Clicks") ?></span><span class="float-end fw-bold"><?php echo $plan["clicks"] == "0" ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : number_format($plan["clicks"]).'/'.e('mo') ?></span></li>
                        <li class="mb-3"><span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php ee('Amount of time statistics are kept for each short link.') ?>"><?php ee("Data Retention") ?></span><span class="float-end fw-bold"><?php echo $plan["retention"] == "0" ? '<i class="fa fa-infinity gradient-primary clip-text"></i>' : $plan["retention"].' '.e('days') ?></span></li>
                        <?php if($features = \Helpers\App::features()): ?>
                            <?php foreach($features as $slug => $feature): ?>
                                <?php if(isset($plan["permission"]->{$slug}) && $plan["permission"]->{$slug}->enabled): ?>
                                    <?php if(isset($feature['count']) && $feature['count'] !== false): ?>
                                        <li class="mb-3">
                                            <span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span>
                                            <?php if($slug == 'apirate'): ?>
                                                <?php if($plan["permission"]->apirate->count == '0'): ?>
                                                    <span class="float-end fw-bolder"><i class="fa fa-infinity gradient-primary clip-text"></i></span>
                                                <?php else: ?>
                                                    <span class="float-end fw-bolder"><?php ee('{x}/min', null, ['x' => $plan["permission"]->apirate->count]) ?></span>
                                                <?php endif ?>
                                            <?php else: ?>
                                                <span class="float-end fw-bolder"><?php echo $plan["permission"]->{$slug}->count == '0' ? e('Unlimited') : $plan["permission"]->{$slug}->count ?><?php if($slug == 'qr') echo ($plan['isqrmonthly'] ? '/'.e('mo') : '') ?></span>
                                            <?php endif ?>
                                        </li>
                                    <?php elseif($slug == 'bioblocks'): ?>
                                        <li class="mb-3"><span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span><span class="float-end gradient-primary clip-text fw-bold">
                                            <?php echo !empty($plan["permission"]->bioblocks->custom) ? count(explode(',', $plan["permission"]->bioblocks->custom)).' '.e('Widgets') : count(\Helpers\BioWidgets::widgets()).' '. e('Widgets') ?>
                                        </span>   </li>
                                    <?php else: ?>
                                        <li class="mb-3"><span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span><span class="float-end"><i class="fa fa-check text-success"></i></span></li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <li class="mb-3"><span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span><span class="float-end"><i class="fa fa-times text-danger"></i></span></li>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>                        
                        <li class="mb-3"><span class="border-bottom border-1" data-bs-toggle="tooltip" title="<?php ee("No advertisement will be shown when logged or in your links") ?>"><?php ee("Advertisement-Free") ?></span><span class="float-end"><?php echo !$plan["free"]  ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></span></li>
                        <?php echo $plan["permission"]->custom  ? '<li>'.$plan["permission"]->custom.'<span class="float-end"><i class="fa fa-check text-success"></i></span></li>' : '' ?>
                    </ul>                    
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>