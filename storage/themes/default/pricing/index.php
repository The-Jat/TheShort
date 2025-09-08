<section class="slice slice-lg pb-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
    <div class="container mb-n7 position-relative zindex-100 pt-5 pt-lg-6">        
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-7 col-md-9">
                <h3 class="h1 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?>"><?php ee('Simple Pricing') ?></h3>
                <p class="lead <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> opacity-8 mb-0">
                    <?php ee('Transparent pricing for everyone. Always know what you will pay.') ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <?php message() ?>
                <div class="pricing-container">
                    <div class="text-center mb-7">
                        <div class="btn-group" role="group" aria-label="Pricing">
                            <?php if($settings['lifetime']):?>
                            <button type="button" class="btn btn-sm btn-light" data-pricing="lifetime"><?php ee('Lifetime') ?></button>
                            <?php endif ?>
                            <?php if($settings['monthly']):?>
                            <button type="button" class="btn btn-sm btn-primary" data-pricing="monthly"><?php ee('Monthly') ?></button>
                            <?php endif ?>
                            <?php if($settings['yearly']):?>                            
                            <button type="button" class="btn btn-sm btn-light" data-pricing="yearly">
                                <span><?php ee('Yearly') ?></span>
                                <?php if($settings['discount']): ?>
                                    <span class="badge badge-danger border-0 badge-pill badge-floating">-<?php echo $settings['discount'] ?>%</span>
                                <?php endif ?>
                            </button>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php if(themeSettings::config('pricing') == 'table'):?>
                        <?php view('pricing.table_list', compact('class', 'plans', 'default', 'term')) ?>
                    <?php else: ?>
                        <?php view('pricing.table', compact('class', 'plans', 'default', 'term')) ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <?php if(config('customplan')): ?>
            <div class="h-100 mt-5 card bg-primary border-0 text-white shadow-sm">
                <div class="card-body row align-items-center gy-lg-5">
                    <div class="col-sm-8">
                        <h2 class="fw-bold text-white "><?php ee('Need a custom plan?') ?></h2>
                        <p class="lead text-white "><?php ee('If our current plans do not fit your needs, we will create a tailored plan just for your needs.') ?></p>
                    </div>
                    <div class="col-sm-4 text-right">
                        <a class="btn btn-light d-block d-sm-inline-block" href="<?php echo route('contact', ['subject' => e('Custom Plan')]) ?>"><?php ee('Contact Sales') ?></a>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>        
    <div class="shape-container shape-line shape-position-bottom">
        <svg width="2560px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" viewBox="0 0 2560 100" style="enable-background:new 0 0 2560 100;" xml:space="preserve" class="fill-section-secondary">
            <polygon points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</section>
<section class="slice slice-lg pt-8 bg-section-secondary">
    <div class="container">            
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-8 col-md-10">
                <h2 class="mt-4"><?php ee('Frequently Asked Questions') ?></h2>
            </div>
        </div>
        <div class="row">
            <?php foreach(\Helpers\App::pricingFaqs() as $i => $faq): ?>
                <?php if($i > 0 && $i % 2 == 0): ?>
                    </div>
                    <div class="row">
                <?php endif; ?>
                <div class="col-xl-6">
                    <div id="<?php echo 'faq-holder-'.$faq->slug ?>" class="accordion accordion-spaced">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-header py-4" id="<?php echo $faq->slug ?>" data-toggle="collapse" role="button" data-target="#faq-<?php echo $faq->id ?>" aria-expanded="false" aria-controls="faq-<?php echo $faq->id ?>">
                                <h6 class="mb-0"><i data-feather="help-circle" class="mr-3"></i><?php ee($faq->question) ?></h6>
                            </div>
                            <div id="faq-<?php echo $faq->id ?>" class="collapse" aria-labelledby="<?php echo $faq->slug ?>" data-parent="#<?php echo 'faq-holder-'.$faq->slug ?>">
                                <div class="card-body">
                                    <?php echo strip_tags($faq->answer) ?>
                                </div>
                            </div>
                        </div>
                    </div>         
                </div>                  
            <?php endforeach ?> 
        </div>
    </div>
</section>