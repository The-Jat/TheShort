<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Statistics') ?></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('Statistics') ?></h1>
<div class="row">
    <?php foreach($counts as $id => $count): ?>
        <div class="col-md-3">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4"><?php echo $count['name'] ?></h5>
                    <h1 class="mt-1 mb-3"><?php echo $count['count']?: '0' ?></h1>
                    <div class="mb-1">
                        <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> +<?php echo $count['count.today']?:'0' ?> <?php ee('Today') ?></span>
                    </div>
                </div>
            </div>          
        </div>      
    <?php endforeach ?>
</div>

<section id="dynamic-charts">
    <div class="d-flex mb-4 mt-3 align-items-center">
        <h3 class="mb-0 fw-bold"><?php ee('Links') ?></h3>
    </div>
    <div class="card rounded-4 flex-fill w-100 shadow-sm">
        <div class="card-body py-3">
            <div class="chart chart-sm">
                <canvas style="height:400px" data-trigger="chart" data-url="<?php echo route('admin.stats.links') ?>" data-color-start="#64a1fa" data-color-border="#2f5d9e"></canvas>
            </div>
        </div>
    </div>
    <div class="d-flex mb-4 mt-5 align-items-center">
        <h3 class="mb-0 fw-bold"><?php ee('Clicks') ?></h3>
    </div>
    <div class="card rounded-4 flex-fill w-100 shadow-sm">
        <div class="card-body py-3">
            <div class="chart chart-sm">
                <canvas style="height:400px" data-trigger="chart" data-url="<?php echo route('admin.stats.clicks') ?>" data-color-start="#ed6673" data-color-border="#b53c47"></canvas>
            </div>
        </div>
    </div>
    <div class="d-flex mb-4 mt-5 align-items-center">
        <h3 class="mb-0 fw-bold"><?php ee('Visitor Map') ?></h3>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card rounded-4 flex-fill w-100 shadow-sm">
                <div class="card-body px-4">
                    <div id="visitor-map" data-trigger="dynamic-map"  data-url="<?php echo route('admin.stats.map') ?>" style="height:350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xxl-6 d-flex order-3 order-xxl-2">
            <div class="card rounded-4 flex-fill w-100 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Top Countries') ?></h5>
                </div>
                <div class="card-body px-4">
                    <ul id="top-countries" class="list-unstyled d-block"></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex mb-4 mt-5 align-items-center">
        <h3 class="mb-0 fw-bold"><?php ee('Users') ?></h3>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card rounded-4 mb-0 flex-fill w-100">
                <div class="card-body py-3">
                    <div class="chart">
                        <canvas style="height:400px" data-trigger="chart" data-url="<?php echo route('admin.stats.users') ?>" data-color-start="#74db8c" data-color-border="#208038"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card rounded-4 flex-fill w-100 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Memberships') ?></h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas data-trigger="dynamic-pie" data-url="<?php echo route('admin.stats.membership') ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>