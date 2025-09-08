<?php view('stats.partial', ['url' => $url, 'top' => $top]) ?>

<div class="card rounded-4 card-body shadow-sm mb-4">
    <div class="align-items-center">
        <?php view('partials.stats_nav', ['url' => $url]) ?>
    </div>
</div>

<div class="d-flex mb-4 align-items-center">
    <h3 class="mb-0 fw-bold"><?php ee('Clicks') ?></h3>
    <div class="ms-auto ml-auto card rounded-4 mb-0 shadow-sm p-2">
        <input type="text" name="customreport" data-action="customreport" class="form-control border-0" placeholder="<?php echo e("Choose a date range to update stats") ?>">
    </div>
</div>

<div class="card rounded-4 shadow-sm">
    <div class="card-body py-3">
        <div>
            <canvas data-trigger="chart" data-url="<?php echo route('data.clicks', [$url->id]) ?>" height="400" data-color-start="rgba(43, 130, 255, 0.5)" data-color-stop="rgba(255,255,255,0.1)" data-color-border="rgb(43, 130, 255)"></canvas>
        </div>
    </div>
</div>

<div class="d-flex align-items-center mt-5 mb-4">
    <h3 class="mb-0 fw-bold"><?php ee('Recent Activity') ?></h3>
    <div class="ms-auto"><a href="<?php echo route('stats.activity', $url->id) ?>" class="btn btn-primary rounded-3 px-3 py-2 "-sm"><?php ee('View all') ?></a></div>
</div>
<?php foreach($recentActivity as $stats): ?>
    <div class="card rounded-4 mb-2 shadow-sm">
        <div class="card-body no-checkbox">
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
                        <span class="text-start d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $stats->referer ?>">
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
                        <small class="fw-bold"><?php echo \Core\Helper::timeago($stats->date) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>