<div class="d-flex mb-5">
    <div>
        <h1 class="h3 fw-bold"><?php echo e('Campaign Statistics').' '.$bundle->name ?></h1>
    </div>
    <?php if(\Core\Auth::user()->has('export')): ?>        
        <div class="ms-auto">
            <a data-bs-toggle="modal" data-bs-target="#exportModal" href="#" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Export Stats') ?></a>
        </div>
    <?php endif ?>
</div>
<section id="charts">
    <div class="row">
        <div class="col-md-4">
            <div class="card rounded-4 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Traffic Distribution') ?></h5>
                </div>
                <div class="card-body py-3 overflow-auto" style="height:286px">
                    <ul id="top-links" class="list-unstyled d-block">
                        <?php foreach($links as $url): ?>
                            <?php $percent = $url->click *100 / ($total === 0 ? 1 : $total) ?>
                            <li class="d-block mb-2 w-100 border-bottom pb-2 fw-bold position-relative" style="min-height:38px">
                                <div class="bg-primary d-block position-absolute h-100" style="z-index:0;opacity:0.1;width:<?php echo $percent ?>%"></div>
                                <div class="position-absolute w-100 h-100 p-2">
                                    <img src="<?php echo route('link.ico', $url->id) ?>" width="16" height="16" class="rounded-circle me-1" alt="<?php echo $url->meta_title ?>"> <a href="<?php echo $url->url ?>" target="_blank" rel="nofollow"><strong><?php echo \Core\Helper::truncate(\Core\Helper::empty($url->meta_title, $url->url), 30) ?></strong></a>
                                    <small class="float-end"><?php echo round($percent) ?>%</small>                                
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card flex-fill rounded-4 w-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Clicks') ?></h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas data-trigger="chart" data-url="<?php echo route('campaigns.stats.clicks', [$bundle->id]) ?>" data-color-start="#3b7ddd" data-color-stop="rgba(255,255,255,0.1)"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card flex-fill rounded-4 w-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Visitor Map') ?></h5>
                </div>
                <div class="card-body px-4">
                    <div id="visitor-map" data-trigger="dynamic-map"  data-url="<?php echo route('campaigns.stats.map', [$bundle->id]) ?>" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card flex-fill rounded-4 w-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Top Countries') ?></h5>
                </div>
                <div class="card-body px-4">
                    <ul id="top-countries" class="list-unstyled d-block"></ul>
                </div>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-6">
            <div class="card flex-fill rounded-4 w-100 h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Browser') ?></h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas data-trigger="dynamic-pie" data-url="<?php echo route('campaigns.stats.browser', [$bundle->id]) ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-fill rounded-4 w-100 h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Platforms') ?></h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas data-trigger="dynamic-pie" data-url="<?php echo route('campaigns.stats.os', [$bundle->id]) ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</section>
<?php if(\Core\Auth::user()->has('export')): ?>
<div class="modal fade" id="exportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo route('campaigns.export', [$bundle->id]) ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Export Data') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <p><?php ee("Choose a range to export data as CSV. Exported data will including information like date, city and country, os, browser, referer and language.") ?></p>
                <input type="text" class="form-control mt-3 p-2" name="range">        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Export') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>