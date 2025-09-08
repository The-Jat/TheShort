<header class="py-3" id="<?php echo themeSettings::config('menutype', 'top') ? 'menu-top' : 'main-header' ?>">
    <div class="<?php echo isset($menu) && $menu == 'full' ? 'container-fluid' : 'container' ?>">
        <div class="navbar navbar-expand-lg py-3">
            <a href="<?php echo route('home') ?>" class="d-flex align-items-center col-md-3 text-dark text-decoration-none navbar-logo">
            <?php if(config('logo')): ?>
                <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                <?php if(config('altlogo')): ?>
                    <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('altlogo')) ?>" id="navbar-logo">
                <?php endif ?>
            <?php else: ?>
                <h1 class="h5 mt-2 fw-bold" title="<?php echo config('title') ?>"><?php echo config('sitename') ?></h1>
            <?php endif ?>
            </a>
            <button class="navbar-toggler border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggle-icon text-secondary">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 flex-fill text-start" id="main-menu">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php ee('Solutions') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-end border-0 shadow-lg end-0 rounded-3 p-3">
                            <li class="mb-2 me-0">
                                <a class="dropdown-item rounded d-flex align-items-center p-2 border-0" href="<?php echo route('page.bio') ?>">
                                    <div class="justify-content-center icon-md bg-primary align-items-center d-flex rounded-3">
                                        <i class="fa fa-mobile gradient-primary clip-text h4 fa-fw mb-0"></i>
                                    </div>
                                    <div class="ms-3 flex-fill">
                                        <strong class="d-block"><?php ee('Bio Pages') ?></strong>
                                        <small class="opacity-50 text-wrap"><?php ee('Convert your social media followers') ?></small>
                                    </div>
                                </a>
                            </li>
                            <li class="me-0">
                                <a class="dropdown-item rounded d-flex align-items-center p-2 border-0" href="<?php echo route('page.qr') ?>">
                                    <div class="justify-content-center icon-md bg-primary align-items-center d-flex rounded-3">
                                        <i class="fa fa-qrcode gradient-primary clip-text h4 mb-0 fa-fw"></i>
                                    </div>
                                    <div class="ms-3 flex-fill">
                                        <strong class="d-block"><?php ee('QR Codes') ?></strong>
                                        <small class="opacity-50 text-wrap"><?php ee('Customizable & trackable QR codes') ?></small>
                                    </div>
                                </a>
                            </li>
                            <?php if($plugged = plug('solutionsmenu')): ?>
                                <?php foreach($plugged as $link): ?>
                                    <?php if(is_array($link)): ?>
                                        <li class="mt-2 m-0">
                                            <a class="dropdown-item rounded d-flex align-items-center p-2 border-0" href="<?php echo $link['link'] ?>">
                                                <div class="justify-content-center icon-md bg-primary align-items-center d-flex rounded-3">
                                                    <i class="fa <?php echo $link['icon'] ?? 'fa-star' ?>  gradient-primary clip-text h4 fa-fw mb-0"></i>
                                                </div>
                                                <div class="ms-3 flex-fill">
                                                    <strong class="d-block"><?php echo $link['title'] ?></strong>
                                                    <?php if(isset($link['description'])): ?>
                                                        <small class="opacity-50 text-wrap"><?php echo $link['description'] ?></small>
                                                    <?php endif ?>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                            <?php foreach(\Helpers\App::pages('main') as $page): ?>
                                <li class="mt-2 m-0">
                                    <a class="dropdown-item rounded d-flex align-items-center p-2 border-0" href="<?php echo route('page', [$page->seo]) ?>">
                                        <div class="justify-content-center icon-md bg-primary align-items-center d-flex rounded-3">
                                            <i class="fa fa-star gradient-primary clip-text h4 fa-fw mb-0"></i>
                                        </div>
                                        <div class="ms-3 flex-fill">
                                            <strong class="d-block"><?php echo $page->name ?></strong>
                                            <?php if(isset($page->metadata->description) && $page->metadata->description): ?>
                                                <small class="opacity-50 text-wrap"><?php echo  \Core\Helper::truncate($page->metadata->description, 50) ?></small>
                                            <?php endif ?>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                    <?php if(config('pro')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo route('pricing') ?>"><?php ee('Pricing') ?></a>
                    </li>
                    <?php endif ?>
                    <?php if(config('blog')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo route('blog') ?>"><?php ee('Blog') ?></a>
                    </li>
                    <?php endif ?>
                    <?php if($plugged = plug('homemenu')): ?>
                        <?php foreach($plugged as $pages): ?>
                            <?php if(is_array($pages)): ?>
                                <?php foreach($pages as $page): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $page['link'] ?>"><?php echo $page['title'] ?></a>
                                    </li>
                                <?php endforeach ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php ee('Resources') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-end border-0 shadow-lg end-0 rounded-3 p-3">
                            <?php if(config('helpcenter')): ?>
                                <li class="mb-2 me-0">
                                    <a class="dropdown-item rounded d-flex align-items-center p-2 border-0" href="<?php echo route('help') ?>">
                                        <div class="justify-content-center icon-md bg-primary align-items-center d-flex rounded-3">
                                            <i class="fa fa-life-ring gradient-primary clip-text h4 mb-0 fa-fw"></i>
                                        </div>
                                        <div class="ms-3 flex-fill">
                                            <strong class="d-block"><?php ee('Help Center') ?></strong>
                                            <small class="opacity-50 text-wrap"><?php ee('Find answers to your questions') ?></small>
                                        </div>
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if(config('api')): ?>
                                <li class="m-0">
                                    <a class="dropdown-item rounded d-flex align-items-center p-2 border-0" href="<?php echo route('apidocs') ?>">
                                        <div class="justify-content-center icon-md bg-primary align-items-center d-flex rounded-3">
                                            <i class="fa fa-code gradient-primary clip-text h4 fa-fw mb-0"></i>
                                        </div>
                                        <div class="ms-3 flex-fill">
                                            <strong class="d-block"><?php ee('Developer API') ?></strong>
                                            <small class="opacity-50 text-wrap"><?php ee('Guide on how to use our API') ?></small>
                                        </div>
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if($plugged = plug('resourcemenu')): ?>
                                <?php foreach($plugged as $link): ?>
                                    <?php if(is_array($link)): ?>
                                        <li class="mt-2 m-0">
                                            <a class="dropdown-item rounded d-flex align-items-center p-2 border-0" href="<?php echo $link['link'] ?>">
                                                <div class="justify-content-center icon-md bg-primary align-items-center d-flex rounded-3">
                                                    <i class="fa <?php echo $link['icon'] ?? 'fa-star' ?>  gradient-primary clip-text h4 fa-fw mb-0"></i>
                                                </div>
                                                <div class="ms-3 flex-fill">
                                                    <strong class="d-block"><?php echo $link['title'] ?></strong>
                                                    <?php if(isset($link['description'])): ?>
                                                        <small class="opacity-50 text-wrap"><?php echo $link['description'] ?></small>
                                                    <?php endif ?>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </ul>
                    </li>
                </ul>

                <div class="col-md-3 text-end flex-fill" id="login-menu">
                    <?php if(themeSettings::config('languageselector', 'top') && $langs = \Helpers\App::langs()): ?>
                        <span class="dropdown d-none d-md-inline-block">
                            <a class="text-muted small me-3" data-bs-toggle="dropdown" href="#"><i class="fa fa-globe" class="mr-1"></i> <?php echo strtoupper(\Core\Localization::locale()) ?></a>
                            <ul class="dropdown-menu p-1">
                                <?php foreach($langs  as $lang): ?>
                                    <li><a class="dropdown-item" href="<?php echo \Core\Localization::localUrl($lang) ?>"><?php echo $lang['name'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </span>
                    <?php endif ?>
                    <?php if(\Core\Auth::logged()): ?>
                        <?php if(user()->admin): ?>
                            <a class="btn btn-outline-primary me-3 fw-bold" href="<?php echo route('admin') ?>"><?php ee('Admin Panel') ?></a>
                        <?php else: ?>
                            <a class="btn btn-outline-primary me-3 fw-bold" href="<?php echo route('dashboard') ?>"><?php ee('Dashboard') ?></a>
                        <?php endif ?>
                        <span class="dropdown">
                            <a href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo user()->avatar() ?>" class="avatar-sm rounded-circle border border-2 border-light" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end border-0 shadow end-0 p-3 mt-3">
                                <?php if(user()->username && user()->public): ?>
                                    <a class="dropdown-item" href="<?php echo route('profile', user()->username) ?>"><i class="text-muted small me-2 fa fa-fw fa-user"></i> <?php ee('Public Profile') ?></a>
                                <?php endif ?>
                                <a class="dropdown-item" href="<?php echo route('dashboard') ?>"><i class="text-muted small me-2 fa fa-fw fa-tachometer-alt"></i> <?php ee('Dashboard') ?></a>
                                <?php if(config('pro') && !user()->team()): ?>
                                    <a class="dropdown-item" href="<?php echo route('billing') ?>"><i class="text-muted small me-2 fa fa-fw fa-credit-card"></i> <?php ee('Billing') ?></a>
                                <?php endif ?>
                                <?php if(config('affiliate')->enabled): ?>
                                    <a class="dropdown-item" href="<?php echo route('user.affiliate') ?>"><i class="text-muted small me-2 fa fa-fw fa-money-bill"></i> <?php ee('Affiliate') ?></a>
                                <?php endif ?>
                                <?php if(config('userlogging')): ?>
                                    <a class="dropdown-item" href="<?php echo route('user.security') ?>"><i class="text-muted small me-2 fa fa-fw fa-shield"></i> <?php ee('Security') ?></a>
                                <?php endif ?>
                                <a class="dropdown-item" href="<?php echo route('settings') ?>"><i class="text-muted small me-2 fa fa-fw fa-cog"></i> <?php ee('Settings') ?></a>
                                <?php if(!themeSettings::config('homestyle', 'auto')): ?>
                                <div class="dropdown-divider opacity-50"></div>
                                <div class="dropdown-item d-flex">
                                    <label class="form-check-label" for="darkcheck"><?php ee('Dark Mode') ?></label>
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input float-end" type="checkbox" data-trigger="schememode" id="darkcheck" <?php echo themeSettings::isDark() ? 'checked' : '' ?>>
                                    </div>
                                </div>
                                <?php endif ?>
                                <div class="dropdown-divider opacity-50"></div>
                                <?php if(config('helpcenter')): ?>
                                <a href="<?php echo route('help') ?>" class="dropdown-item" ><i class="text-muted small me-2 fa fa-fw fa-life-ring"></i> <?php ee('Help') ?></a>
                                <?php endif ?>
                                <?php if(config('api')): ?>
                                    <a href="<?php echo route('apidocs') ?>" class="dropdown-item" ><i class="text-muted small me-2 fa fa-fw fa-code"></i> <?php ee('Developer API') ?></a>
                                <?php endif ?>
                                <div class="dropdown-divider opacity-50"></div>
                                <a class="dropdown-item" href="<?php echo route('logout') ?>"><i class="text-muted small me-2 fa fa-fw fa-sign-out-alt"></i> <?php ee('Log out') ?></a>
                            </div>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo route('login') ?>" class="btn btn-outline-primary me-3 fw-bold align-items-center"><?php ee('Login') ?></a>
                        <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                            <a href="<?php echo route('register') ?>" class="btn btn-primary fw-bold"><?php ee('Get Started') ?></a>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>