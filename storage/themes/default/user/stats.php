<div class="d-flex align-items-center mb-5">
    <h1 class="mb-0 h3 fw-bold"><?php ee('Statistics') ?></h1>
    <?php if(\Core\Auth::user()->has('export')): ?>
        <div class="ms-auto">
            <a data-bs-toggle="modal" data-bs-target="#exportModal" href="#" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Export Stats') ?></a>
        </div>
    <?php endif ?>
</div>
<section id="dynamic-charts">
    <h4 class="fw-bold mb-3"><?php ee('Clicks') ?></h4>
    <div class="card flex-fill rounded-4 w-100">
        <div class="card-body py-3">
            <div class="chart chart-lg">
                <canvas data-trigger="chart" data-url="<?php echo route('user.stats.clicks') ?>" data-color-start="rgba(220, 53, 69, 0.5)" data-color-stop="rgba(255,255,255,0.1)" data-color-border="rgba(220, 53, 69, 1)"></canvas>
            </div>
        </div>
    </div>
    <h4 class="fw-bold mb-3 mt-5"><?php ee('Countries') ?></h4>
    <div class="row">
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card flex-fill rounded-4 w-100">
                <div class="card-body px-4">
                    <div id="visitor-map" data-trigger="dynamic-map"  data-url="<?php echo route('user.stats.map') ?>" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card flex-fill rounded-4 w-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Top Countries') ?></h5>
                </div>
                <div class="p-3">
                    <div class="d-flex bg-light p-2 rounded-3" data-toggle="multibuttons">
                        <a href="#top-countries" data-bs-parent="#countrylist" class="btn shadow-sm bg-white border rounded flex-fill fw-bold active"><?php ee('Countries') ?></a>
                        <a href="#top-cities"  data-bs-parent="#countrylist" class="btn flex-fill"><?php ee('Cities') ?></a>
                    </div>
                </div>
                <div class="card-body px-3" id="countrylist">
                    <ul id="top-countries" class="list-unstyled collapse show"></ul>
                    <ul id="top-cities" class="list-unstyled collapse"></ul>
                </div>
            </div>
        </div>
    </div>
    <h4 class="fw-bold my-3"><?php ee('Platforms') ?></h4>
    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="card shadow-sm rounded-4 mb-0">
                <div class="card-body px-4">
                    <canvas data-trigger="dynamic-pie" data-url="<?php echo route('user.stats.platforms') ?>" data-type="os" style="min-height:200px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="p-3">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Top Platforms') ?></h5>
                </div>
                <div class="card-body px-3">
                    <ul id="top-os" class="list-unstyled d-block"></ul>
                </div>
            </div>
        </div>
    </div>
    <h4 class="fw-bold mb-3 mt-5"><?php ee('Browsers') ?></h4>
    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="card shadow-sm rounded-4 mb-0">
                <div class="card-body px-4">
                    <canvas data-trigger="dynamic-pie" data-url="<?php echo route('user.stats.browsers') ?>" data-type="browsers" style="min-height:200px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="p-3">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Top Browsers') ?></h5>
                </div>                
                <div class="card-body px-3">
                    <ul id="top-browsers" class="list-unstyled d-block"></ul>
                </div>
            </div>
        </div>
    </div>
    <h4 class="fw-bold mb-3 mt-5"><?php ee('Languages') ?></h4>
    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="card shadow-sm rounded-4 mb-0 h-100">
                <div class="card-body mb-0 px-4">
                    <canvas data-trigger="dynamic-pie" data-url="<?php echo route('user.stats.languages') ?>" data-type="languages" style="min-height:200px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="p-3">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Top Languages') ?></h5>
                </div>
                <div class="card-body px-3">
                    <ul id="top-languages" class="list-unstyled d-block"></ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(\Core\Auth::user()->has('export')): ?>
<div class="modal fade" id="exportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo route('user.stats.export') ?>" method="post">
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
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Export') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>