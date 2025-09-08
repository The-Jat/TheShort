<h1 class="h3 mb-5 fw-bold"><?php ee('New Site Setup Checklist') ?></h1>

<div class="row">
    <div class="col-md-12">        
        <div class="card rounded-4 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><?php ee('Overall Setup Progress') ?></h5>
                    <div class="ms-auto">
                        <span class="badge bg-<?php echo $overall_completion >= 80 ? 'success' : ($overall_completion >= 50 ? 'warning' : 'danger') ?> fs-6">
                            <?php echo $overall_completion ?>% <?php ee('Complete') ?>
                        </span>
                    </div>
                </div>
                <div class="progress mb-2" style="height: 10px;">
                    <div class="progress-bar bg-<?php echo $overall_completion >= 80 ? 'success' : ($overall_completion >= 50 ? 'warning' : 'danger') ?>" 
                         role="progressbar" 
                         style="width: <?php echo $overall_completion ?>%" 
                         aria-valuenow="<?php echo $overall_completion ?>" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                    </div>
                </div>
                <p class="text-muted mb-0">
                    <?php if($overall_completion >= 80): ?>
                        <i class="mdi mdi-check-circle text-success"></i> <?php ee('Great! Your site is well configured.') ?>
                    <?php elseif($overall_completion >= 50): ?>
                        <i class="mdi mdi-alert-circle text-warning"></i> <?php ee('Good progress! Complete the remaining items for optimal setup.') ?>
                    <?php else: ?>
                        <i class="mdi mdi-alert text-danger"></i> <?php ee('Please complete the essential setup items below.') ?>
                    <?php endif ?>
                </p>
            </div>
        </div>
        
        <div class="card rounded-4 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold mb-0"><?php ee('1. Site Basic Information') ?></h5>
                    <div class="ms-auto">
                        <span class="badge bg-<?php echo $completion['site_basic'] >= 80 ? 'success' : ($completion['site_basic'] >= 50 ? 'warning' : 'danger') ?>">
                            <?php echo $completion['site_basic'] ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['site_basic']['url']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Site URL') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['site_basic']['url']) ? $settings['site_basic']['url'] : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings') ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['site_basic']['sitename']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Site Name') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['site_basic']['sitename']) ? $settings['site_basic']['sitename'] : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings') ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['site_basic']['title']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Site Title') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['site_basic']['title']) ? $settings['site_basic']['title'] : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings') ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['site_basic']['description']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Site Description') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['site_basic']['description']) ? substr($settings['site_basic']['description'], 0, 50).'...' : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings') ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['site_basic']['logo']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Site Logo') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['site_basic']['logo']) ? e('Uploaded') : e('Not uploaded') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings') ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Upload') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['site_basic']['favicon']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Favicon') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['site_basic']['favicon']) ? e('Uploaded') : e('Not uploaded') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings') ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Upload') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card rounded-4 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold mb-0"><?php ee('2. User Settings') ?></h5>
                    <div class="ms-auto">
                        <span class="badge bg-<?php echo $completion['user_settings'] >= 80 ? 'success' : ($completion['user_settings'] >= 50 ? 'warning' : 'danger') ?>">
                            <?php echo $completion['user_settings'] ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['user_settings']['user'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('User Registration') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['user_settings']['user'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['users']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['user_settings']['user_activate'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Email Activation') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['user_settings']['user_activate'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['users']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['user_settings']['userlogging'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Login Logging') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['user_settings']['userlogging'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['users']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['user_settings']['gravatar'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Gravatar Support') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['user_settings']['gravatar'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['users']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['user_settings']['verification'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('User Verification') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['user_settings']['verification'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['users']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['user_settings']['allowdelete'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Account Deletion') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['user_settings']['allowdelete'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['users']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card rounded-4 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold mb-0"><?php ee('3. Security Settings') ?></h5>
                    <div class="ms-auto">
                        <span class="badge bg-<?php echo $completion['security_settings'] >= 80 ? 'success' : ($completion['security_settings'] >= 50 ? 'warning' : 'danger') ?>">
                            <?php echo $completion['security_settings'] ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['security_settings']['adult'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('URL Blacklisting') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['security_settings']['adult'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['security']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['security_settings']['keyword_blacklist']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Keyword Blacklist') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['security_settings']['keyword_blacklist']) ? e('Configured') : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['security']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['security_settings']['domain_blacklist']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Domain Blacklist') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['security_settings']['domain_blacklist']) ? e('Configured') : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['security']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['security_settings']['captcha']) && $settings['security_settings']['captcha'] != '0' ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Captcha Protection') ?></strong>
                                    <p class="text-muted mb-0 small">
                                        <?php 
                                        if(empty($settings['security_settings']['captcha']) || $settings['security_settings']['captcha'] == '0') {
                                            echo e('Disabled');
                                        } else {
                                            echo e('Enabled') . ' (' . $settings['security_settings']['captcha'] . ')';
                                        }
                                        ?>
                                    </p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['security']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['security_settings']['safe_browsing']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Google Web Risk API') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['security_settings']['safe_browsing']) ? e('Configured') : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['security']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo $settings['security_settings']['phish_api'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Phishtank API') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo $settings['security_settings']['phish_api'] ? e('Enabled') : e('Disabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['security']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card rounded-4 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold mb-0"><?php ee('4. Application Settings') ?></h5>
                    <div class="ms-auto">
                        <span class="badge bg-<?php echo $completion['app_settings'] >= 80 ? 'success' : ($completion['app_settings'] >= 50 ? 'warning' : 'danger') ?>">
                            <?php echo $completion['app_settings'] ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !$settings['app_settings']['maintenance'] ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Maintenance Mode') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !$settings['app_settings']['maintenance'] ? e('Disabled') : e('Enabled') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['app']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['app_settings']['timezone']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Timezone') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['app_settings']['timezone']) ? $settings['app_settings']['timezone'] : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['app']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo !empty($settings['app_settings']['default_lang']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Default Language') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo !empty($settings['app_settings']['default_lang']) ? strtoupper($settings['app_settings']['default_lang']) : e('Not configured') ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['app']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                        <div class="checklist-item mb-3">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-<?php echo empty($settings['app_settings']['home_redir']) ? 'check-circle text-success' : 'circle-outline text-muted' ?> me-2"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Home Redirect') ?></strong>
                                    <p class="text-muted mb-0 small"><?php echo empty($settings['app_settings']['home_redir']) ? e('Not set') : e('Redirecting to: ') . $settings['app_settings']['home_redir'] ?></p>
                                </div>
                                <a href="<?php echo route('admin.settings.config', ['app']) ?>" class="btn btn-sm btn-outline-primary rounded-3"><?php ee('Configure') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card rounded-4 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="fw-bold mb-0"><?php ee('5. Additional Setup Recommendations') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="border border-2 rounded-4 mt-3 p-3">
                            <div class="d-flex align-items-start">
                                <i class="fa fa-lightbulb text-warning me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Payment Gateway Setup') ?></strong>
                                    <p class="text-muted mb-0 small"><?php ee('Configure payment gateways to enable premium features and subscriptions.') ?></p>
                                    <a href="<?php echo route('admin.settings.config', ['payments']) ?>" class="btn btn-sm btn-outline-secondary mt-3 rounded-3"><?php ee('Setup Payments') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-2 rounded-4 mt-3 p-3">
                            <div class="d-flex align-items-start">
                                <i class="fa fa-lightbulb text-warning me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Email Configuration') ?></strong>
                                    <p class="text-muted mb-0 small"><?php ee('Configure email settings for user notifications and system emails.') ?></p>
                                    <a href="<?php echo route('admin.settings.config', ['mail']) ?>" class="btn btn-sm btn-outline-secondary mt-3 rounded-3"><?php ee('Setup Email') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border border-2 rounded-4 mt-3 p-3">
                            <div class="d-flex align-items-start">
                                <i class="fa fa-lightbulb text-warning me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('Theme Customization') ?></strong>
                                    <p class="text-muted mb-0 small"><?php ee('Customize your site theme and appearance settings.') ?></p>
                                    <a href="<?php echo route('admin.settings.config', ['theme']) ?>" class="btn btn-sm btn-outline-secondary mt-3 rounded-3"><?php ee('Customize Theme') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="border border-2 rounded-4 mt-3 p-3">
                            <div class="d-flex align-items-start">
                                <i class="fa fa-lightbulb text-warning me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong><?php ee('FAQs') ?></strong>
                                    <p class="text-muted mb-0 small"><?php ee('Setup FAQs to help users find answers to common questions.') ?></p>
                                    <a href="<?php echo route('admin.faq') ?>" class="btn btn-sm btn-outline-secondary mt-3 rounded-3"><?php ee('Setup FAQs') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
               
    </div>
</div>