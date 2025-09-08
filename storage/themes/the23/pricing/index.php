<section class="bg-primary border-top border-bottom">
    <div class="container py-8">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-7 col-md-9">
                <h4 class="py-2 px-3">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Simple Pricing') ?></strong>
				</h4>
                <h1 class="fw-bolder mt-4"><?php ee('Choose the plan <br>that works for you') ?></h1>
                <p class="lead mb-0">
                    <?php ee('Transparent pricing without any hidden fees so you always know what you will pay.') ?>
                </p>
            </div>
        </div>
        <div class="my-5 mx-auto">
            <?php message() ?>
            <div class="pricing-container">
                <div class="text-center mb-5">
                    <div class="bg-white d-inline-block shadow-sm mb-5 p-2 rounded-pill" role="group" aria-label="Pricing">
                        <?php if($settings['lifetime']):?>
                        <button type="button" class="px-4 px-md-5 btn <?php echo $default == 'lifetime' ? 'btn-primary' : 'bg-white btn-white' ?> fw-bold rounded-pill" data-pricing="lifetime"><?php ee('Lifetime') ?></button>
                        <?php endif ?>
                        <?php if($settings['monthly']):?>
                        <button type="button" class="px-4 px-md-5 btn <?php echo $default == 'monthly' ? 'btn-primary' : 'bg-white btn-white' ?> fw-bold rounded-pill" data-pricing="monthly"><?php ee('Monthly') ?></button>
                        <?php endif ?>
                        <?php if($settings['yearly']):?>
                        <button type="button" class="px-4 px-md-5 btn <?php echo $default == 'yearly' ? 'btn-primary' : 'bg-white btn-white' ?> fw-bold rounded-pill position-relative" data-pricing="yearly">
                            <span><?php ee('Yearly') ?></span>
                            <?php if($settings['discount']): ?>
                                <span class="badge bg-success border-0 badge-pill position-absolute start-100 ms-0 ms-md-2 top-0 translate-middle shadow-sm"><?php ee('Save {d}%', null, ['d' => $settings['discount']]) ?></span>
                            <?php endif ?>
                        </button>
                        <?php endif ?>
                    </div>
                </div>
                <?php if(themeSettings::config('pricing') == 'table'):?>
                    <?php view('pricing.table', compact('class', 'plans', 'default', 'term')) ?>
                <?php elseif(themeSettings::config('pricing') == 'categorized'): ?>
                    <?php view('pricing.categorized', compact('class', 'plans', 'default', 'term', 'categories')) ?>
                <?php else: ?>
                    <?php view('pricing.list', compact('class', 'plans', 'default', 'term')) ?>
                <?php endif ?>
            </div>
            <?php if(config('customplan')): ?>
                <div class="h-100 p-5 gradient-primary text-white rounded-3 border-0 shadow-sm">
                    <div class="row align-items-center gy-lg-5">
                        <div class="col-sm-8">
                            <h2 class="fw-bold"><?php ee('Need a custom plan?') ?></h2>
                            <p class="lead"><?php ee('If our current plans do not fit your needs, we will create a tailored plan just for your needs.') ?></p>
                        </div>
                        <div class="col-sm-4 text-end">
                            <a class="btn btn-light text-primary d-block d-sm-inline-block" href="<?php echo route('contact', ['subject' => e('Custom Plan')]) ?>"><?php ee('Contact Sales') ?></a>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <div class="py-8">
            <div class="row">
                <div class="col-12 col-lg-5 text-center text-lg-start mb-5">
                    <h2 class="mb-4 fw-bold"><?php ee('Frequently Asked Questions') ?></h2>
                    <p><?php ee("If you have questions, please don't hesitate to contact us.") ?></p>
                    <a href="<?php echo route('contact') ?>" class="btn btn-primary"><?php ee('Contact us') ?></a>
                </div>
                <div class="col-12 col-lg-7">
                    <?php foreach(\Helpers\App::pricingFaqs() as $i => $faq): ?>
                            <div id="<?php echo 'faq-holder-'.$faq->slug ?>" class="mb-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header border-0 bg-transparent py-4" id="<?php echo $faq->slug ?>" data-bs-toggle="collapse" role="button" data-bs-target="#faq-<?php echo $faq->id ?>" aria-expanded="false" aria-controls="faq-<?php echo $faq->id ?>">
                                        <h6 class="mb-0 fw-bold"><?php echo $faq->question ?></h6>
                                    </div>
                                    <div id="faq-<?php echo $faq->id ?>" class="collapse" aria-labelledby="<?php echo $faq->slug ?>" data-parent="#<?php echo 'faq-holder-'.$faq->slug ?>">
                                        <div class="card-body">
                                            <?php echo strip_tags($faq->answer) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</section>