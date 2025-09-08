<?php view('stats.partial', ['url' => $url, 'top' => $top]) ?>

<div class="card rounded-4 card-body shadow-sm mb-4">
    <div class="align-items-center">
        <?php view('partials.stats_nav', ['url' => $url]) ?>
    </div>
</div>

<div class="d-flex mt-5 mb-4 align-items-center">
    <h3 class="mb-0 fw-bold"><?php ee('URL Traffic Distribution') ?></h3>
</div>

<div class="card rounded-4 shadow-sm">    
    <div class="card-body px-4">
        <ul id="top-referrers" class="list-unstyled d-block">
            <?php foreach($rotators as $rotator): ?>
                <?php $percent = $rotator['count'] * 100 / ($url->click === 0 ? 1 : $url->click) ?>
                <li class="d-block mb-2 w-100 border-bottom pb-2 fw-bold position-relative" style="min-height:38px">
                    <div class="bg-primary d-block position-absolute h-100" style="z-index:0;opacity:0.1;width:<?php echo $percent ?>%"></div>
                    <div class="position-absolute w-100 h-100 p-2">
                        <strong><?php echo $rotator['link'] ?></strong></a>
                        <small class="float-right"><?php echo $rotator['count'] ?> <?php ee('clicks') ?> - <?php echo round($percent) ?>% <?php ee('of traffic') ?></small>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>