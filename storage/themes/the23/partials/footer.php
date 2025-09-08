<footer class="pt-5 text-start" id="footer-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0" class="text-dark">
                <a href="<?php echo route('home') ?>">
                <?php if(config('logo')): ?>
                    <?php if((request()->cookie('darkmode') || themeSettings::isDark()) && config('altlogo')): ?>
                        <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('altlogo')) ?>" id="navbar-logo">
                    <?php else: ?>
                        <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                    <?php endif ?>
                <?php else: ?>
                    <h1 class="h5 mt-2 fw-bold text-dark"><?php echo config('sitename') ?></h1>
                <?php endif ?>
                </a>
                <p class="mt-4"><?php echo e(config('description')) ?></p>
                <ul class="nav mt-4">
                    <?php if($facebook = config('facebook')): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2" href="<?php echo $facebook ?>" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if($twitter = config('twitter')): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2" href="<?php echo $twitter ?>" target="_blank">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if($instagram = config('sociallinks')->instagram): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2" href="<?php echo $instagram ?>" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if($linkedin = config('sociallinks')->linkedin): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2" href="<?php echo $linkedin ?>" target="_blank">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="col-lg-4 col-6 col-sm-6 ml-lg-auto mb-5 mb-lg-0">
                <h6 class="fw-bold mb-3"><?php ee('Solutions') ?></h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="nav-link" href="<?php echo route('page.qr') ?>"><?php ee('QR Codes') ?></a></li>
                    <li class="mb-2"><a class="nav-link" href="<?php echo route('page.bio') ?>"><?php ee('Bio Pages') ?></a></li>
                    <?php if($plugged = plug('solutionsmenu')): ?>
                        <?php foreach($plugged as $link): ?>
                            <?php if(is_array($link)): ?>
                                <li class="mb-2"><a class="nav-link"  href="<?php echo $link['link'] ?>"><?php echo $link['title'] ?></a></li>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                    <?php foreach(\Helpers\App::pages('main') as $page): ?>
                        <li class="mb-2"><a class="nav-link" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-lg-4 col-6 col-sm-6 mb-5 mb-lg-0">
                <h6 class="fw-bold mb-3"><?php ee('Resources') ?></h6>
                <ul class="list-unstyled">
                    <?php foreach(\Helpers\App::pages('company') as $page): ?>
                        <li class="mb-2"><a class="nav-link" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                    <?php endforeach ?>                    
                    <?php if(config('helpcenter')): ?>
                        <li class="mb-2"><a class="nav-link" href="<?php echo route('help') ?>"><?php ee('Help Center') ?></a></li>
                    <?php endif ?>
                    <?php if(config('api')): ?>
                        <li class="mb-2"><a class="nav-link" href="<?php echo route('apidocs') ?>"><?php ee('Developer API') ?></a></li>
                    <?php endif ?>
                    <?php if(config('pro') && config('affiliate')->enabled): ?>
                        <li class="mb-2"><a class="nav-link" href="<?php echo route('affiliate') ?>"><?php ee('Affiliate Program') ?></a></li>
                    <?php endif ?>
                    <?php if(config('contact')): ?>
                        <li class="mb-2"><a class="nav-link" href="<?php echo route('contact') ?>"><?php ee('Contact Us') ?></a></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class="row align-items-center justify-content-md-between pb-2 mt-5">
            <div class="col-md-4">
                <div class="copyright text-sm text-center text-md-start">
                    <?php if(isset(config('theme_config')->customfooter) && !empty(config('theme_config')->customfooter)): ?>
                        <?php echo config('theme_config')->customfooter ?>
                    <?php else: ?>
                        &copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="fw-bold"><?php echo config('sitename') ?></a>. <?php ee('All Rights Reserved') ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-8">
                <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                    <?php foreach(\Helpers\App::pages('policy') as $page): ?>
                        <li class="nav-item"><a class="nav-link text-dark" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                    <?php endforeach ?>
                    <?php foreach(\Helpers\App::pages('terms') as $page): ?>
                        <li class="nav-item"><a class="nav-link text-dark" href="<?php echo route('page', [$page->seo]) ?>"><?php ee($page->name) ?></a></li>
                    <?php endforeach ?>
                    <?php if(config('report')): ?>
                        <li class="nav-item"><a class="nav-link text-dark" href="<?php echo route('report') ?>"><?php ee('Report') ?></a></li>
                    <?php endif ?>
                    <?php if(config('verifylink')): ?>
                        <li class="nav-item"><a class="nav-link text-dark" href="<?php echo route('links.verify') ?>"><?php ee('Verify Link') ?></a></li>
                    <?php endif ?>
                    <?php if(config('cookieconsent')->enabled): ?>
                        <li class="nav-item"><a class="nav-link text-dark" href="" data-cc="c-settings"><?php ee('Cookie Settings') ?></a></li>
                    <?php endif ?>
                    <?php if($langs = \Helpers\App::langs()): ?>
                        <li class="nav-item dropup">
                            <a class="nav-link text-dark" data-bs-toggle="dropdown" href="#"><i class="fa fa-globe" class="mr-1"></i> <?php echo strtoupper(\Core\Localization::locale()) ?></a>
                            <ul class="dropdown-menu">
                                <?php foreach($langs as $lang): ?>
                                    <li><a class="dropdown-item" href="<?php echo \Core\Localization::localUrl($lang) ?>"><?php echo $lang['name'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
