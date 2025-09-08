<div class="d-flex align-items-center mb-5">
    <h3 class="mb-0 fw-bold"><?php ee('Recent Activity') ?></h3>
</div>
<div class="card shadow-sm rounded-4 p-2">
    <form action="<?php echo route('user.stats.activity') ?>" method="get" class="d-flex align-items-center">
        <div class="me-2 flex-fill">
            <label class="fw-bold d-block mb-2"><?php ee('Country') ?></label>
            <div class="input-select d-block">
                <select name="country" class="form-select p-2 pe-5" data-toggle="select">
                    <option value="all"><?php ee('All') ?></option>
                    <?php echo \Core\Helper::Country(request()->country ?? '', true, true) ?>
                </select>
            </div>
        </div>
        <div class="me-2 flex-fill">
            <label class="fw-bold d-block mb-2"><?php ee('Language') ?></label>
            <div class="input-select d-block">
                <select name="language" class="form-select p-2 pe-5" data-toggle="select">
                    <option value="all"><?php ee('All') ?></option>
                    <?php echo \Helpers\App::languagelist(request()->language ?? null) ?>
                </select>
            </div>
        </div>
        <div class="me-2 flex-fill">
            <label class="fw-bold d-block mb-2"><?php ee('Device') ?></label>
            <div class="input-select d-block">
                <select name="device" class="form-select p-2 pe-5" data-toggle="select">
                    <option value="all"><?php ee('All') ?></option>
                    <?php echo \Core\Helper::devices(request()->device ?? null) ?>
                </select>
            </div>
        </div>
        <div class="me-2 flex-fill">
            <label class="fw-bold d-block mb-2"><?php ee('Between') ?></label>
            <div class="input-select d-block">
                <input type="text" name="customreport" data-action="customreport" class="form-control p-2" placeholder="<?php echo e("Choose a date range to update stats") ?>">
            </div>
        </div>
        <div>
            <label class="fw-bold d-block mb-2">&nbsp;</label>
            <button type="submit" class="btn btn-primary py-2 px-3"><?php ee('Filter') ?></button>
        </div>
    </form> 
</div>
<?php foreach($recentActivity as $stats): ?>
    <div class="card mb-2 shadow-sm">
        <div class="card-body no-checkbox">
            <div class="mb-2">
                <?php if($stats->url->qrid): ?>
                    <span class="badge bg-success text-sm"><?php ee("QR Code") ?></span>
                    <strong><?php echo $stats->qr ?></strong></a>
                <?php elseif($stats->url->profileid): ?>
                    <span class="badge bg-success text-sm"><?php ee("Bio Page") ?></span>
                    <strong><?php echo $stats->profile ?></strong></a>
                    <a href="<?php echo $stats->url->url ?>" target="_blank" rel="nofollow"><strong class="text-break"><?php echo \Core\Helper::truncate(\Core\Helper::empty($stats->url->meta_title, $stats->url->url), 30) ?></strong></a>
                    <?php if($stats->url->alias || $stats->url->custom): ?>
                        <span class="text-muted d-block mt-2" data-href="<?php echo Helpers\App::shortRoute($stats->url->domain, $stats->url->alias.$stats->url->custom) ?>"><?php echo Helpers\App::shortRoute($stats->url->domain, $stats->url->alias.$stats->url->custom) ?></span>
                    <?php endif ?>
                <?php else: ?>
                    <img src="<?php echo route('link.ico', $stats->urlid) ?>" width="16" height="16" class="rounded-circle me-1" alt="<?php echo $stats->url->meta_title ?>">
                    <a href="<?php echo $stats->url->url ?>" target="_blank" rel="nofollow"><strong class="text-break"><?php echo \Core\Helper::truncate(\Core\Helper::empty($stats->url->meta_title, $stats->url->url), 30) ?></strong></a>
                    <?php if($stats->url->alias || $stats->url->custom): ?>
                        <span class="text-muted d-block mt-2" data-href="<?php echo Helpers\App::shortRoute($stats->url->domain, $stats->url->alias.$stats->url->custom) ?>"><?php echo Helpers\App::shortRoute($stats->url->domain, $stats->url->alias.$stats->url->custom) ?></span>
                    <?php endif ?>
                <?php endif ?>
            </div>        
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <?php if($stats->country): ?>
                        <span class="text-start d-inline-block">
                            <img src="<?php echo \Helpers\App::flag($stats->country) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($stats->country) ?>">
                            <span class="mr-3 me-3 align-middle"><?php echo $stats->city ? ucfirst($stats->city).',': e('Somewhere from') ?> <?php echo ucfirst($stats->country) ?></span>
                        </span>
                    <?php endif ?>
                    <?php if($stats->os): ?>
                        <span class="text-start d-inline-block">
                            <img src="<?php echo \Helpers\App::os($stats->os) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($stats->os) ?>">
                            <span class="mr-3 me-3 align-middle"><?php echo $stats->os ?></span>
                        </span>
                    <?php endif ?>
                    <?php if($stats->browser): ?>
                        <span class="text-start d-inline-block">
                            <img src="<?php echo \Helpers\App::browser($stats->browser) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($stats->browser) ?>">
                            <span class="mr-3 me-3 align-middle"><?php echo $stats->browser ?></span>
                        </span>
                    <?php endif ?>
                    <?php if($stats->domain): ?>
                        <span class="text-start d-inline-block">
                            <i class="me-1 fa fa-globe"></i>
                            <a href="<?php echo $stats->referer ?>" rel="nofollow" target="_blank"><span class="mr-3 me-3 align-middle"><?php echo $stats->domain ?></span></a>
                        </span>
                    <?php else: ?>
                        <span class="text-start d-inline-block">
                            <i class="me-1 fa fa-globe"></i>
                            <span class="mr-3 me-3 align-middle"><?php echo ee('Direct, email or others') ?></span>
                        </span>
                    <?php endif ?>
                    <?php if($stats->language): ?>
                        <span class="text-start d-inline-block">
                            <i class="me-1 fa fa-language"></i>
                            <span class="mr-3 me-3 align-middle"><?php echo \Helpers\App::languagelist($stats->language, true) ?></span>
                        </span>
                    <?php endif ?>
                    <div class="mt-1">
                        <span><i data-feather="calendar" class="me-1"></i> <span class="align-middle"><?php echo \Core\Helper::dtime($stats->date, 'd/m/Y') ?></span> </span>
                        <span class="ms-3"><i data-feather="clock" class="me-1"></i> <span class="align-middle"><?php echo \Core\Helper::dtime($stats->date, 'H:i') ?></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<div class="mt-4 d-block">
    <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
</div>