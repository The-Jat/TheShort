<?php if($teams = user()->teams()): ?>
    <div class="position-relative">
        <a class="bg-white shadow d-flex align-items-center border rounded-4 mx-2 mb-3 p-2 text-dark" href="#" data-toggle="dropdownfixed">
            <?php $isteam = false; foreach($teams as $team): ?>
                <?php if(user()->team() && user()->team()->id == $team->id): $isteam = true; ?>
                    <img src="<?php echo $team->user->avatar() ?>" class="avatar rounded-3 me-2">
                    <div>
                        <?php echo !empty($team->user->name) ? '<span class="d-block fw-bold">'.$team->user->name.'</span>' : '' ?>
                        <span class="text-muted align-middle small"><?php echo \Core\Helper::truncate($team->user->email, 25) ?></span>
                    </div>
                    <i class="ms-auto fa-rotate-90" data-feather="code"></i>
                <?php break; endif; ?>
            <?php endforeach ?>
            <?php if(!$isteam): ?>
                <img src="<?php echo user()->avatar() ?>" class="avatar rounded-3 me-2">
                <div>
                    <?php echo !empty(user()->name) ? '<span class="d-block fw-bold">'.user()->name.'</span>' : '' ?>
                    <span class="text-muted align-middle small"><?php echo \Core\Helper::truncate(user()->email, 25) ?></span>
                </div>
                <i class="ms-auto fa-rotate-90" data-feather="code"></i>
            <?php endif ?>
        </a>        
        <div class="dropdown-menu dropdown-menu-fixed py-0 shadow-lg position-fixed ms-2">
            <div class="dropdown-menu-header text-dark">
                <?php ee('Switch Workspace') ?>
            </div>
            <div class="px-2 pt-2">
                <a class="dropdown-item mb-2 py-4 rounded d-flex align-items-center <?php echo !user()->team() ? 'active' : ''?>" href="<?php echo route('team.switch', ['default']) ?>">
                    <img src="<?php echo user()->avatar() ?>" class="avatar rounded-3 me-1">
                    <div class="ms-1">
                        <span class="fw-bold"><?php echo user()->email ?></span> <br><small><?php ee('Individual') ?></small>
                    </div>
                </a>
                <?php foreach($teams as $team): ?>
                    <a class="dropdown-item mb-2 py-4 rounded d-flex align-items-center <?php echo (user()->team() && user()->team()->id == $team->id) ? 'active' : ''?>" href="<?php echo route('team.switch', [$team->token]) ?>">
                        <img src="<?php echo $team->user->avatar() ?>" class="avatar rounded-circle me-1">
                        <div class="ms-1">
                            <span class="fw-bold"><?php echo $team->user->email ?></span> <br><small><?php ee('Team') ?></small>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php endif ?>
<ul class="sidebar-nav">
    <li class="sidebar-item active">
        <a class="sidebar-link rounded-4" href="<?php echo route('dashboard') ?>">
            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?php ee('Dashboard') ?></span>
        </a>
    </li>
    <?php if($user->has('bio')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('bio') ?>">
            <i class="align-middle" data-feather="layout"></i> <span class="align-middle"><?php ee('Bio Pages') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($user->has('qr')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('qr') ?>">
            <i class="align-middle" data-feather="aperture"></i> <span class="align-middle"><?php ee('QR Codes') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($plugged = plug('usermenu.top')): ?>
        <?php foreach($plugged as $i => $page): ?>
            <?php if(is_array($page)): ?>
                    <?php if(isset($page['menu'])): ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link rounded-4 collapsed" data-bs-target="#nav-<?php echo $i ?>" data-bs-toggle="collapse">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                            <ul id="nav-<?php echo $i ?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <?php foreach($page['menu'] as $menu): ?>
                                    <li class="sidebar-item"><a class="sidebar-link rounded-4" href="<?php echo $menu['link'] ?>"><?php echo $menu['title'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link rounded-4" href="<?php echo $page['link'] ?>">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                        </li>
                    <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('user.stats') ?>">
            <i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle"><?php ee('Statistics') ?></span>
        </a>
    </li>
    <?php if($user->has('channels')): ?>
        <li class="sidebar-header"><?php ee('Channels') ?></li>
        <?php foreach($user->starredChannels() as $channel): ?>
            <li class="sidebar-item"><a class="sidebar-link rounded-4" href="<?php echo route('channel', [$channel->id]) ?>"><span class="badge me-2 roundeds px-2" style="background:<?php echo $channel->color ?>">&nbsp;</span> <?php echo $channel->name ?></a></li>
        <?php endforeach ?>
        <li class="sidebar-item">
            <a class="sidebar-link rounded-4" href="<?php echo route('channels') ?>">
                <i data-feather="package"></i> <span class="align-middle"><?php ee('My Channels') ?></span>
            </a>
        </li>
    <?php endif ?>
    <li class="sidebar-header"><?php ee('Link Management') ?></li>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('links') ?>">
            <i class="align-middle" data-feather="link"></i> <span class="align-middle"><?php ee('Links') ?> </span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('archive') ?>">
            <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle"><?php ee('Archived Links') ?> </span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('expired') ?>">
            <i class="align-middle" data-feather="calendar"></i> <span class="align-middle"><?php ee('Expired Links') ?></span>
        </a>
    </li>
    <?php if($plugged = plug('usermenu.medium')): ?>
        <?php foreach($plugged as $i => $page): ?>
            <?php if(is_array($page)): ?>
                    <?php if(isset($page['menu'])): ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link rounded-4 collapsed" data-bs-target="#nav-<?php echo $i ?>" data-bs-toggle="collapse">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                            <ul id="nav-<?php echo $i ?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <?php foreach($page['menu'] as $menu): ?>
                                    <li class="sidebar-item"><a class="sidebar-link rounded-4" href="<?php echo $menu['link'] ?>"><?php echo $menu['title'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link rounded-4" href="<?php echo $page['link'] ?>">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                        </li>
                    <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <?php if($user->has('bundle')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('campaigns') ?>">
            <i class="align-middle" data-feather="crosshair"></i> <span class="align-middle"><?php ee('Campaigns') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($user->has('splash')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('splash') ?>">
            <i class="align-middle" data-feather="loader"></i> <span class="align-middle"><?php ee('Custom Splash') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($user->has('overlay')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('overlay') ?>">
            <i class="align-middle" data-feather="layers"></i> <span class="align-middle"><?php ee('CTA Overlay') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($user->has('pixels')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('pixel') ?>">
            <i class="align-middle" data-feather="compass"></i> <span class="align-middle"><?php ee('Tracking Pixels') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($user->has('domain')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('domain') ?>">
            <i class="align-middle" data-feather="globe"></i> <span class="align-middle"><?php ee('Branded Domains') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($user->has('team')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('team') ?>">
            <i class="align-middle" data-feather="users"></i> <span class="align-middle"><?php ee('Teams') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if($plugged = plug('usermenu')): ?>
        <?php foreach($plugged as $i => $page): ?>
            <?php if(is_array($page)): ?>
                    <?php if(isset($page['menu'])): ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link rounded-4 collapsed" data-bs-target="#nav-<?php echo $i ?>" data-bs-toggle="collapse">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                            <ul id="nav-<?php echo $i ?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <?php foreach($page['menu'] as $menu): ?>
                                    <li class="sidebar-item"><a class="sidebar-link rounded-4" href="<?php echo $menu['link'] ?>"><?php echo $menu['title'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link rounded-4" href="<?php echo $page['link'] ?>">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                        </li>
                    <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4" href="<?php echo route('integrations') ?>">
            <i class="align-middle" data-feather="git-branch"></i> <span class="align-middle"><?php ee('Integrations') ?></span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link rounded-4 collapsed" data-bs-target="#nav-tool" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="zap"></i> <span class="align-middle"><?php ee('Tools') ?></span>
        </a>
        <ul id="nav-tool" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link rounded-4" href="<?php echo route('tools') ?>"><?php ee('Tools') ?></a></li>
            <?php if ($user->has('import') && $user->teamPermission('links.create')): ?>
                <li class="sidebar-item"><a class="sidebar-link rounded-4" href="<?php echo route('import.links') ?>"><?php ee('Import Links') ?></a></li>
            <?php endif ?>
            <?php if(config('api') && $user->has('api')): ?>
                <li class="sidebar-item"><a class="sidebar-link rounded-4" href="<?php echo route('apidocs') ?>"><?php ee('Developer API') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
</ul>
<?php if(config('pro') && !$user->pro() && !$user->team()): ?>
<div class="sidebar-cta">
    <div class="sidebar-cta-content bg-white border rounded-4 p-3 text-dark">
        <strong class="d-inline-block mb-2"><?php ee('Upgrade') ?></strong>
        <div class="mb-3 text-sm">
            <?php ee('Are you looking for more features? Check out our plans.') ?>
        </div>
        <div class="d-grid">
            <a class="btn btn-primary rounded-3" href="<?php echo route('pricing') ?>"><?php ee('Upgrade') ?></a>
        </div>
    </div>
</div>
<?php endif ?>
<?php if(config('pro') && $user->pro() && !$user->team() && $user->trial): ?>
<div class="sidebar-cta">
    <div class="sidebar-cta-content bg-white border rounded-4 p-3 text-dark">
        <strong class="d-inline-block mb-2"><?php ee('Free Trial') ?></strong>
        <div class="mb-3 text-sm">
            <?php ee('Your trial will end on {t}', null, ['t' => \Core\Helper::dtime($user->expiration, 'F j, Y')]) ?>
        </div>
        <div class="d-grid">
            <a class="btn btn-primary rounded-3" href="<?php echo route('pricing') ?>"><?php ee('Upgrade') ?></a>
        </div>
    </div>
</div>
<?php endif ?>