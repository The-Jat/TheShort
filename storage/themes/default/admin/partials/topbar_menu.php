<a class="sidebar-toggle d-flex d-md-none">
    <i class="hamburger align-self-center"></i>
</a>

<form class="d-none d-sm-inline-block card mb-0 rounded-pill flex-grow-1" method="get" action="<?php echo route('admin.search') ?>">
    <div class="input-group p-2">
        <input type="text" class="form-control border-0" name="q" value="<?php echo (new \Core\Request)->q ?>" placeholder="<?php ee('Search for') ?> ..." aria-label="Search">
        <select class="form-select border-start border-0" name="type">
            <option value="links"><?php ee('Links') ?></option>
            <option value="users"><?php ee('Users') ?></option>
            <option value="bio"><?php ee('Bio Page') ?></option>
            <option value="qr"><?php ee('QR Code') ?></option>            
            <option value="payments"><?php ee('Payments') ?></option>
            <option value="subscriptions"><?php ee('Subscriptions') ?></option>
        </select>
        <button class="btn" type="submit">
            <i class="align-middle" data-feather="search"></i>
        </button>
    </div>
</form>

<div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align"> 
        <li class="nav-item">
            <a class="nav-link fw-bold me-2<?php echo request()->cookie('darkmode') ? ' d-none':'' ?>" href="#" title="<?php ee('Dark Mode') ?>" data-trigger="darkmode">
                <i class="align-middle" data-feather="moon"></i>
            </a>
            <a class="nav-link text-white fw-bold me-2<?php echo !request()->cookie('darkmode') ? ' d-none':'' ?>" href="#" title="<?php ee('Light Mode') ?>" data-trigger="lightmode">
                <i class="align-middle" data-feather="sun"></i>
            </a>
        </li>
        <?php if($notifications['total']): ?>
        <li class="nav-item dropdown">
            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                <div class="position-relative">
                    <i class="align-middle" data-feather="bell"></i>
                    <span class="indicator"><?php echo $notifications['total'] ?></span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 <?php echo \Helpers\App::isDark() ? 'text-light' : 'text-dark' ?>" aria-labelledby="alertsDropdown">
                <div class="dropdown-menu-header">
                    <?php ee('{t} Notifications', null, ['t' => $notifications['total']]) ?>
                </div>
                <div class="list-group">
                    <?php if($notifications['data']['reports']): ?>
                        <a href="<?php echo route('admin.links.report') ?>" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-danger" data-feather="alert-circle"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark"><?php ee('You have {c} new link report.', null, ['c' => $notifications['data']['reports']]) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endif ?>
                    <?php if($notifications['data']['pending']): ?>
                        <a href="<?php echo route('admin.links.pending') ?>" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-warning" data-feather="link"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark"><?php ee('You have {c} links to review.', null, ['c' => $notifications['data']['pending']]) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endif ?>
                    <?php if($notifications['data']['verifications']): ?>
                        <a href="<?php echo route('admin.verifications') ?>" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-warning" data-feather="user-check"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark"><?php ee('You have {c} verification requests to review.', null, ['c' => $notifications['data']['verifications']]) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endif ?>
                    <?php if($notifications['data']['withdrawals']): ?>
                        <a href="<?php echo route('admin.withdrawals') ?>" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-warning" data-feather="user-check"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark"><?php ee('You have {c} withdrawal requests to review.', null, ['c' => $notifications['data']['withdrawals']]) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endif ?>
                </div>               
            </div>
        </li>
        <?php endif ?>
        <?php if(\Helpers\App::newUpdate()): ?>
            <li class="nav-item">
                <a class="nav-link text-primary fw-bold" href="<?php echo route("admin.update") ?>"><i data-feather="bell" class="me-1"></i> <?php ee('Update') ?></a>
            </li>
        <?php endif ?>
        <li class="nav-item">
            <a class="nav-link fw-bold me-2 align-middle" href="<?php echo route('home') ?>" data-tooltip="<?php ee('Home') ?>">
                <?php ee('Home') ?>
            </a>            
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold me-2 align-middle" href="<?php echo route('dashboard') ?>" data-tooltip="<?php ee('User Dashboard') ?>">
                <?php ee('Dashboard') ?>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="<?php echo route('settings') ?>" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
            </a>

            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="<?php echo $user->avatar() ?>" class="avatar img-fluid rounded me-1" alt="<?php echo $user->username ?>" /> <span class="text-dark"><?php echo $user->username ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="<?php echo route('settings') ?>"><i class="align-middle me-1" data-feather="settings"></i> <?php ee('Settings') ?></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo route('logout') ?>"><i class="align-middle me-1" data-feather="log-out"></i> <?php ee('Log out') ?></a>
            </div>
        </li>
    </ul>
</div>