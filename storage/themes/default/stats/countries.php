<?php view('stats.partial', ['url' => $url, 'top' => $top]) ?>

<div class="card rounded-4 card-body shadow-sm mb-4">
    <div class="align-items-center">
        <?php view('partials.stats_nav', ['url' => $url]) ?>
    </div>
</div>

<div class="d-flex mb-4 align-items-center">
    <h3 class="mb-0 fw-bold"><?php ee('Visitor Map') ?></h3>
    <div class="ms-auto ml-auto card rounded-4 mb-0 shadow-sm p-2">
        <input type="text" name="customreport" data-action="customreport" class="form-control border-0" placeholder="<?php echo e("Choose a date range to update stats") ?>">
    </div> 
</div>

<div class="row mb-3">
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm mb-0">
            <div class="card-body px-4">
                <div id="visitor-map" data-trigger="dynamic-map" data-url="<?php echo route('data.countries', [$url->id]) ?>" style="height:500px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm h-100">
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
<div class="mb-4 mt-5 align-items-center">
    <h3 class="fw-bold"><?php ee('Cities') ?></h3>
</div>
<div class="card rounded-4 shadow-sm">
    <div class="card-body px-4" data-toggle="cities" data-url="<?php echo route('data.cities', [$url->id]) ?>">
        <div class="text-center text-muted"><?php ee('Select a region in the map above to display city data.') ?></div>
    </div>
</div>