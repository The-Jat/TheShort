<div class="pricing row no-gutters">
    <?php foreach($plans as $id => $plan): ?>
        <div class="<?php echo $class ?>">
            <div class="card bg-section-primary card-pricing text-center mx-1 <?php echo ($plan['ispopular'] ? 'border border-3 border-info shadow' : 'border-0 shadow-sm') ?>">
                <?php if($plan['ispopular']): ?>
                <span class="px-3 py-1 d-inline position-absolute">
                    <span class="fw-bold badge bg-primary py-1 px-3 fs-6 text-white"><?php ee('Popular') ?></span>
                </span>                  
                <?php endif ?>
                <div class="card-header py-5 border-0">
                    <?php if($plan['icon']): ?>
                        <span class="icon icon-lg bg-primary text-white rounded-circle icon-shape mb-3"><i class="<?php echo $plan['icon'] ?>"></i></span>
                    <?php endif ?> 
                    <span class="d-block h5 mb-4"><?php ee($plan['name']) ?></span>
                    <div class="h1 text-center mb-0" data-pricing-monthly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_monthly"]) ?>" data-pricing-yearly="<?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_yearly"]) ?>" data-pricing-lifetime="<?php echo  $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_lifetime"]) ?>"><span class="price"><?php echo $plan['free'] ? e('Free') : \Helpers\App::currency(config('currency'), $plan["price_".$default]) ?></span><strong><?php echo $plan['free'] ? '' : '<small data-toggle="pricingterm" data-term-monthly="/'.e('month').'" data-term-yearly="/'.e('year').'" data-term-lifetime=" '.e('lifetime').'" class="fs-6">'.$term.'</small>' ?></strong></div>
                    <?php echo $plan['description'] ? '<span class="d-block text-muted mt-3">'.e($plan['description']).'</span>': '' ?>
                    <?php if($plan['planurl'] == "#"):?>
                        <span class="btn bg-secondary text-dark mt-3 d-block"><strong><?php echo $plan['plantext'] ?></strong></span>
                    <?php else: ?>
                        <a href="<?php echo $plan['planurl'] ?>" class="btn btn-primary my-3 py-2 btn-sm d-block mx-3 checkout" data-trigger="checkout"><?php echo $plan['plantext'] ?></a>
                    <?php endif?>
                </div>
                <div class="card-body border-top rounded-bottom p-4 position-relative">
                    <ul class="list-unstyled mb-4 text-left">
                        <li><span class="border-bottom" data-toggle="tooltip" title="<?php ee('Number of short links allowed.') ?>"><?php ee("Short Links") ?></span><span class="float-right font-weight-bold"><?php echo $plan["urls"] == "0" ? '<i class="fa fa-infinity"></i>' : number_format($plan["urls"]).($plan['ismonthly'] ? '/'.e('mo') : '') ?></span></li>
                        <li><span class="border-bottom" data-toggle="tooltip" title="<?php ee('Total clicks allowed over a period') ?>"><?php ee("Link Clicks") ?></span><span class="float-right font-weight-bold"><?php echo $plan["clicks"] == "0" ? '<i class="fa fa-infinity"></i>' : number_format($plan["clicks"]).'/'.e('mo') ?></span></li>
                        <li><span class="border-bottom" data-toggle="tooltip" title="<?php ee('Amount of time statistics are kept for each short link.') ?>"><?php ee("Data Retention") ?></span><span class="float-right font-weight-bold"><?php echo $plan["retention"] == "0" ? '<i class="fa fa-infinity"></i>' : $plan["retention"].' '.e('days') ?></span></li>
                        <?php if($features = \Helpers\App::features()): ?>
                            <?php foreach($features as $slug => $feature): ?>
                                <?php if(isset($plan["permission"]->{$slug}) && $plan["permission"]->{$slug}->enabled): ?>
                                    <?php if(isset($feature['count']) && $feature['count'] !== false): ?>
                                        <li>
                                            <span class="border-bottom" data-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span>
                                            <span class="float-right font-weight-bolder"><?php echo $plan["permission"]->{$slug}->count == '0' ? e('Unlimited') : $plan["permission"]->{$slug}->count ?><?php if($slug == 'qr') echo ($plan['isqrmonthly'] ? '/'.e('mo') : '') ?></span>
                                        </li>
                                    <?php elseif($slug == 'bioblocks'): ?>
                                        <li><span class="border-bottom" data-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span><span class="float-right font-weight-bold">
                                            <?php echo !empty($plan["permission"]->bioblocks->custom) ? count(explode(',', $plan["permission"]->bioblocks->custom)).' '.e('Widgets') : count(\Helpers\BioWidgets::widgets()).' '. e('Widgets') ?>
                                        </span> </li>
                                    <?php else: ?>
                                        <li><span class="border-bottom" data-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span><span class="float-right"><i class="fa fa-check text-success"></i></span></li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <li><span class="border-bottom" data-toggle="tooltip" title="<?php echo $feature['description'] ?>"><?php echo $feature['name'] ?></span><span class="float-right"><i class="fa fa-times text-danger"></i></span></li>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>                        
                        <li><span class="border-bottom" data-toggle="tooltip" title="<?php ee("No advertisement will be shown when logged or in your links") ?>"><?php ee("Advertisement-Free") ?></span><span class="float-right"><?php echo !$plan["free"]  ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></span></li>
                        <?php echo $plan["permission"]->custom  ? '<li>'.$plan["permission"]->custom.'<span class="float-right"><i class="fa fa-check text-success"></i></span></li>' : '' ?>
                    </ul>                    
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>