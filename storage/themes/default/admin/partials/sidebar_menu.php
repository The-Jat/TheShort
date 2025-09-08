<ul class="sidebar-nav">
    <li class="sidebar-item active">
        <a class="sidebar-link" href="<?php echo route('admin') ?>">
            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"><?php ee('Dashboard') ?></span>
        </a>
    </li>
    <?php if(\Helpers\Permissions::can('links.view')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-urls" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="link"></i> <span class="align-middle"><?php ee('Links') ?></span>
        </a>
        <ul id="nav-urls" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links') ?>"><?php ee('All Links') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.expired') ?>"><?php ee('Expired Links') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.archived') ?>"><?php ee('Archived Links') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.anonymous') ?>"><?php ee('Anonymous Links') ?></a></li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?php echo route('admin.links.report') ?>"><?php ee('Reported Links') ?>
                    <?php if($notifications['data']['reports']): ?>
                        <span class="sidebar-badge badge bg-primary"><?php echo $notifications['data']['reports'] ?></span>
                    <?php endif ?>
                </a>
            </li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.pending') ?>"><?php ee('Pending Links') ?></a></li>
            <?php if(\Helpers\Permissions::can('links.create')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.links.import') ?>"><?php ee('Import Links') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['users.view', 'users.create', 'roles.view'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-users" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="users"></i> <span class="align-middle"><?php ee('Users') ?></span>
        </a>
        <ul id="nav-users" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('users.create')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.new') ?>"><?php ee('Add User') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('users.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users') ?>"><?php ee('All Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.inactive') ?>"><?php ee('Inactive Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.banned') ?>"><?php ee('Banned Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.admin') ?>"><?php ee('Admin Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.teams') ?>"><?php ee('Team Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.import') ?>"><?php ee('Import Users') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.users.logins') ?>"><?php ee('Login Logs') ?></a></li>
            <?php endif ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.testimonial') ?>"><?php ee('Testimonials') ?></a></li>
            <?php if(\Helpers\Permissions::can('roles.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.roles') ?>"><?php ee('Roles & Permissions') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['plans.view', 'subscriptions.view', 'payments.view'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-card" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle"><?php ee('Memberships') ?></span>
        </a>
        <ul id="nav-card" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('plans.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.plans') ?>"><?php ee('Plans') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\App::possible()): ?>
                <?php if(\Helpers\Permissions::can('subscriptions.view')): ?>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.subscriptions') ?>"><?php ee('Subscriptions') ?></a></li>
                <?php endif ?>
                <?php if(\Helpers\Permissions::can('plans.view')): ?>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.coupons') ?>"><?php ee('Coupons') ?></a></li>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.vouchers') ?>"><?php ee('Vouchers') ?></a></li>
                <?php endif ?>
                <?php if(\Helpers\Permissions::can('settings.view')): ?>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.tax') ?>"><?php ee('Tax Rates') ?></a></li>
                <?php endif ?>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('payments.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.payments') ?>"><?php ee('Payments') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['bio.view', 'bio.create'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-bio" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="layout"></i> <span class="align-middle"><?php ee('Bio Pages') ?></span>
        </a>
        <ul id="nav-bio" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('bio.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.bio') ?>"><?php ee('All Bio Pages') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('bio.create')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.bio.themes') ?>"><?php ee('Bio Page Themes') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['qr.view', 'settings.view'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed"  data-bs-target="#nav-qr" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="aperture"></i> <span class="align-middle"><?php ee('QR Codes') ?></span>
        </a>
        <ul id="nav-qr" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('qr.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.qr') ?>"><?php ee('All QR codes') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('settings.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.qr.templates') ?>"><?php ee('QR Code Templates') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if($plugged = plug('adminmenu.top')): ?>
        <?php foreach($plugged as $i => $page): ?>
            <?php if(is_array($page)): ?>
                    <?php if(isset($page['menu'])): ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link collapsed" data-bs-target="#nav-<?php echo $i ?>" data-bs-toggle="collapse">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                            <ul id="nav-<?php echo $i ?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <?php foreach($page['menu'] as $menu): ?>
                                    <li class="sidebar-item"><a class="sidebar-link" href="<?php echo $menu['link'] ?>"><?php echo $menu['title'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?php echo $page['link'] ?>">
                                <?php echo $page['icon'] ?? '' ?> <span class="align-middle"><?php echo $page['title'] ?></span>
                            </a>
                        </li>
                    <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['blog.view', 'blog.create'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-blog" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="book"></i> <span class="align-middle"><?php ee('Blog') ?></span>
        </a>
        <ul id="nav-blog" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('blog.create')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.blog.new') ?>"><?php ee('Add Post') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('blog.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.blog') ?>"><?php ee('All Posts') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.blog.categories') ?>"><?php ee('Categories') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['pages.view', 'pages.create'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-pages" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="file-text"></i> <span class="align-middle"><?php ee('Pages') ?></span>
        </a>
        <ul id="nav-pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('pages.create')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.page.new') ?>"><?php ee('Add Page') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('pages.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.page') ?>"><?php ee('All Pages') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::can('settings.view')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-domain" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="globe"></i> <span class="align-middle"><?php ee('Domains') ?></span>
        </a>
        <ul id="nav-domain" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.domains.new') ?>"><?php ee('Add Domain') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.domains') ?>"><?php ee('All Domains') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('admin.verifications') ?>">
            <i class="align-middle" data-feather="user-check"></i> <span class="align-middle"><?php ee('Verifications') ?></span>
            <?php if($notifications['data']['verifications']): ?>
                <span class="sidebar-badge badge bg-primary"><?php echo $notifications['data']['verifications'] ?></span>
            <?php endif ?>
        </a>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['faq.view', 'faq.create'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-faqs" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="help-circle"></i> <span class="align-middle"><?php ee('Help Center') ?></span>
        </a>
        <ul id="nav-faqs" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('faq.create')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.faq.new') ?>"><?php ee('Add Article') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('faq.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.faq') ?>"><?php ee('All Articles') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.faq.categories') ?>"><?php ee('Categories') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['affiliates.view', 'affiliates.create'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-aff" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="percent"></i> <span class="align-middle"><?php ee('Affiliates') ?></span>
            <?php if($notifications['data']['withdrawals']): ?>
                <span class="sidebar-badge badge bg-primary"><?php echo $notifications['data']['withdrawals'] ?></span>
            <?php endif ?>
        </a>
        <ul id="nav-aff" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.affiliate') ?>"><?php ee('Referrals') ?></a></li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?php echo route('admin.affiliate.withdrawals') ?>"><?php ee('Withdrawals') ?>
                    <?php if($notifications['data']['withdrawals']): ?>
                        <span class="sidebar-badge badge bg-primary"><?php echo $notifications['data']['withdrawals'] ?></span>
                    <?php endif ?>
                </a>
            </li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.affiliate.settings') ?>"><?php ee('Settings') ?></a></li>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::can('settings.view')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" href="<?php echo route('admin.ads') ?>">
            <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle"><?php ee('Advertisement') ?></span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-theme" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="eye"></i> <span class="align-middle"><?php ee('Themes') ?></span>
        </a>
        <ul id="nav-theme" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes') ?>"><?php ee('Themes') ?></a></li>
            <?php if(\Core\View::config('settings')): ?>
                <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes.settings') ?>"><?php ee('Settings') ?></a></li>
            <?php endif ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes.editor') ?>"><?php ee('Editor') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.themes.custom') ?>"><?php ee('Custom CSS/JS') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-lang" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="flag"></i> <span class="align-middle"><?php ee('Languages & Emails') ?></span>
        </a>
        <ul id="nav-lang" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.languages') ?>"><?php ee('Languages') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.email.template') ?>"><?php ee('Email Templates') ?></a></li>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" href="<?php echo route('admin.notifications') ?>">
            <i class="align-middle" data-feather="bell"></i> <span class="align-middle"><?php ee('Notifications') ?></span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-plugin" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="server"></i> <span class="align-middle"><?php ee('Plugins') ?></span>
        </a>
        <ul id="nav-plugin" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.plugins') ?>"><?php ee('All Plugins') ?></span></a></li>
            <?php plug('adminmenu') ?>
        </ul>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('admin.plugins.dir') ?>">
            <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle"><?php ee('Marketplace') ?></span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-setting" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="settings"></i> <span class="align-middle"><?php ee('Settings') ?></span>
        </a>
        <ul id="nav-setting" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings') ?>"><?php ee('General Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['app']) ?>"><?php ee('Application Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['link']) ?>"><?php ee('Link Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['qr']) ?>"><?php ee('QR Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['bio']) ?>"><?php ee('Bio Page Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['upload']) ?>"><?php ee('Upload Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['advanced']) ?>"><?php ee('Advanced Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['theme']) ?>"><?php ee('Themes Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['security']) ?>"><?php ee('Security Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['membership']) ?>"><?php ee('Membership Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['payments']) ?>"><?php ee('Payment Gateway') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['users']) ?>"><?php ee('Users Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['mail']) ?>"><?php ee('Mail Settings') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.settings.config', ['integrations']) ?>"><?php ee('Integrations') ?></a></li>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::canAny(['tools.view', 'settings.view'])): ?>
    <li class="sidebar-item">
        <a class="sidebar-link collapsed" data-bs-target="#nav-tool" data-bs-toggle="collapse">
            <i class="align-middle" data-feather="tool"></i> <span class="align-middle"><?php ee('Tools & Newsletter') ?></span>
        </a>
        <ul id="nav-tool" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <?php if(\Helpers\Permissions::can('tools.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.tools') ?>"><?php ee('All Tools') ?></a></li>
            <?php endif ?>
            <?php if(\Helpers\Permissions::can('settings.view')): ?>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.email') ?>"><?php ee('Send Email') ?></a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="<?php echo route('admin.data') ?>"><?php ee('Backup/Restore Data') ?></a></li>
            <?php endif ?>
        </ul>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::can('settings.view')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('admin.oauth') ?>">
            <i class="align-middle" data-feather="share-2"></i> <span class="align-middle"><?php ee('OAuth Applications') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::can('stats.view')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('admin.stats') ?>">
            <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle"><?php ee('Statistics') ?></span>
        </a>
    </li>
    <?php endif ?>
    <?php if(\Helpers\Permissions::can('settings.view')): ?>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route('admin.crons') ?>">
            <i class="align-middle" data-feather="terminal"></i> <span class="align-middle"><?php ee('Cron Jobs') ?></span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo route("admin.update") ?>">
            <i class="align-middle" data-feather="download-cloud"></i> <?php ee('Update') ?>
            <?php if(\Helpers\App::newUpdate(true)): ?>
                <small class="badge bg-success ms-2"><?php ee('New') ?></small>
            <?php endif ?>
        </a>
    </li>
    <?php endif ?>
</ul>