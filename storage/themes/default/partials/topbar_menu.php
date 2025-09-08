<a class="sidebar-toggle d-flex d-lg-none">
    <i class="hamburger align-self-center"></i>
</a>

<div class="d-none d-sm-inline-block card mb-0 rounded-pill p-2" role="button" data-trigger="quickshortener">
    <div class="d-flex align-items-center">
        <span class="text-muted ps-2 pe-5"><?php ee('Quick Shortener') ?></span> 
        <span class="float-end ms-5 pe-2">
            <span class="btn btn-sm btn-white border shadow rounded text-muted fw-bold">CTRL</span>
            <span class="btn btn-sm btn-white border shadow rounded text-muted fw-bold">K</span>
        </span>
    </div>
</div>

<div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">
        <?php if(config('pro') && !$user->pro() && !$user->team()): ?>
            <li class="nav-item">
                <a class="nav-link text-primary fw-bold me-2" href="<?php echo route('pricing') ?>">
                <?php ee('Upgrade') ?>
                </a>
            </li>
        <?php endif ?>
        <li class="nav-item">
            <a class="nav-link fw-bold <?php echo request()->cookie('darkmode') ? ' d-none':'' ?>" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php ee('Dark Mode') ?>" data-trigger="darkmode">
                <i class="align-middle text-black" data-feather="moon"></i>
            </a>
            <a class="nav-link text-white fw-bold <?php echo !request()->cookie('darkmode') ? ' d-none':'' ?>" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php ee('Light Mode') ?>" data-trigger="lightmode">
                <i class="align-middle text-warning" data-feather="sun"></i>
            </a>
        </li>
        <?php if($notifications = $user->notifications()): ?>
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-trigger="viewnews" data-hash="<?php echo $notifications->signature ?>" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        <?php if(!request()->cookie('notification') || request()->cookie('notification') != $notifications->signature): ?>
                            <span class="indicator"><?php echo $notifications->count ?></span>
                        <?php endif ?>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 <?php echo themeSettings::isDark() ? 'text-light' : 'text-dark' ?>" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                        <?php ee('{t} Notification|{t} Notifications', $notifications->count, ['t' => $notifications->count]) ?>
                    </div>
                    <div class="list-group">
                        <?php foreach($notifications->list as $i => $notification): ?>
                            <div class="p-2 border-top">
                                <?php echo str_replace('<p>', '<p class="mb-1">', $notification) ?>
                                <div class="text-muted small mt-2"><?php echo $notifications->dates[$i] ?></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </li>
        <?php endif ?>
        <?php if($user->admin): ?>
            <li class="nav-item">
                <a class="nav-link text-primary fw-bold" href="<?php echo route('admin') ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php ee('Admin Panel') ?>">
                    <i class="align-middle me-2" data-feather="sliders"></i> <span class="d-none d-sm-inline-block"><?php ee('Admin') ?></span>
                </a>
            </li>
        <?php endif ?>
        <?php if($teams = $user->teams()): ?>
            <li class="nav-item dropdown me-2">
                <a class="" href="#" data-bs-toggle="dropdown">
                    <span class="nav-icon d-inline-block pe-1"><i class="align-middle" data-feather="users" data-bs-toggle="tooltip" title="<?php ee('Switch Workspace') ?>"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 <?php echo themeSettings::isDark() ? 'text-light' : 'text-dark' ?>" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header text-dark">
                        <?php ee('Switch Workspace') ?>
                    </div>
                    <a class="dropdown-item mb-2 py-4 d-flex align-items-center <?php echo !$user->team() ? 'active' : ''?>" href="<?php echo route('team.switch', ['default']) ?>">
                            <img src="<?php echo $user->avatar() ?>" class="avatar rounded-circle me-1">
                            <div class="ms-1">
                                <span class="fw-bold"><?php echo $user->email ?></span> <br><small><?php ee('Individual') ?></small>
                            </div>
                        </a>
                    <?php foreach($teams as $team): ?>
                        <a class="dropdown-item mb-2 py-4 d-flex align-items-center <?php echo ($user->team() && $user->team()->id == $team->id) ? 'active' : ''?>" href="<?php echo route('team.switch', [$team->token]) ?>">
                            <img src="<?php echo $team->user->avatar() ?>" class="avatar rounded-circle me-1">
                            <div class="ms-1">
                                <span class="fw-bold"><?php echo $team->user->email ?></span> <br><small><?php ee('Team') ?></small>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            </li>
        <?php endif ?>
        <li class="nav-item dropdown">
            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="<?php echo route('settings') ?>" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
            </a>

            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="<?php echo $user->avatar() ?>" class="avatar img-fluid rounded me-1" alt="<?php echo $user->username ?>" /> <span class="text-dark"><?php echo $user->username ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end">             
                <?php if($user->verified): ?>
                    <span class="dropdown-item text-success fw-bold"><i data-feather="check-circle" class="me-1"></i> <?php ee('Verified') ?></span>
                <?php endif ?>
                <?php if($user->username): ?>
                <a class="dropdown-item" href="<?php echo route('profile', $user->username) ?>"><i class="align-middle me-1" data-feather="user"></i> <?php ee('Public Profile') ?></a>
                <?php endif ?>
                <?php if(config('pro') && !$user->team()): ?>
                    <a class="dropdown-item" href="<?php echo route('billing') ?>"><i class="align-middle me-1" data-feather="credit-card"></i> <?php ee('Billing') ?></a>
                <?php endif ?>
                <?php if(config('pro') && config('affiliate')->enabled): ?>
                    <a class="dropdown-item" href="<?php echo route('user.affiliate') ?>"><i class="align-middle me-1" data-feather="box"></i> <?php ee('Affiliate') ?></a>
                <?php endif ?>
                <?php if(config('verification') && !$user->verified): ?>
                    <a class="dropdown-item" href="<?php echo route('user.verification') ?>"><i class="align-middle me-1" data-feather="user-check"></i> <?php ee('Get Verified') ?></a>
                <?php endif ?>
                <?php if(config('userlogging')): ?>
                    <a class="dropdown-item" href="<?php echo route('user.security') ?>"><i class="align-middle me-1" data-feather="shield"></i> <?php ee('Security') ?></a>
                <?php endif ?>
                <?php if(config('api') && $user->has('api') && $user->teamPermission('api.create')): ?>
                    <a class="dropdown-item" href="<?php echo route('apikeys') ?>"><i class="align-middle me-1" data-feather="key"></i> <?php ee('API Keys') ?></a>
                <?php endif ?>
                <a class="dropdown-item" href="<?php echo route('settings') ?>"><i class="align-middle me-1" data-feather="settings"></i> <?php ee('Settings') ?></a>
                <?php if(config('helpcenter')): ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo route('help') ?>" class="dropdown-item" ><i class="align-middle me-1" data-feather="help-circle"></i> <?php ee('Help Center') ?></a>
                <?php endif ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo route('logout') ?>"><i class="align-middle me-1" data-feather="log-out"></i> <?php ee('Log out') ?></a>
            </div>
        </li>
    </ul>
</div>