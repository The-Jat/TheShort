<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.plugins') ?>"><?php ee('Plugins') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.plugins.dir') ?>"><?php ee('Marketplace') ?></a></li>
  </ol>
</nav>

<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bold"><?php ee('Marketplace') ?></h1>
</div>
<div class="row">
    <div class="col-md-12">
      <form action="<?php echo route('admin.plugins.dir') ?>" method="get" class="card rounded-4 card-body shadow-sm">
        <div class="d-flex">
          <h6 class="fw-bold"><?php ee('Search for Plugins') ?></h6>
        </div>
        <div class="d-flex mt-3">
          <div class="input-group border rounded-pill">
              <input type="text" class="form-control p-3 border-0 rounded-pill" name="q" value="<?php echo request()->q ?>" placeholder="Search for plugins" aria-label="Search">
              <button class="btn" type="submit">
                <i class="align-middle" data-feather="search"></i>
              </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-7">            
                <div class="card rounded-4 shadow-sm">
                    <?php if($plugin->thumbnail): ?>
                        <img src="<?php echo $plugin->thumbnail ?>" class="img-fluid img-responsive rounded rounded-4 w-100">
                    <?php else : ?>
                        <div class="w-100 d-flex justify-content-center align-items-center primary-gradient text-white fw-bold rounded rounded-3" style="height:300px"><h2 class="text-white fw-bold"><?php echo $plugin->name ?></h2></div>
                    <?php endif ?>                                            
                    <div class="card-body">
                        <div class="mb-2 d-flex align-items-center">
                            <h4><strong><?php echo $plugin->name ?></strong></h4>
                            <?php if($plugin->installed): ?>
                                <span class="ms-1 fw-bold ms-auto"><i class="text-success me-1" data-feather="check-circle"></i> <?php ee('Installed') ?> v<?php echo $plugin->installedversion ?></span>
                            <?php endif ?>
                        </div>
                        <div class="border rounded rounded-4 p-2 mb-3">
                            <span class="fw-bold"><i data-feather="book" class="text-primary me-1"></i> <?php echo ucfirst($plugin->category) ?></span>
                            <span class="ms-3 fw-bold"><i data-feather="code" class="text-primary me-1"></i> Latest version: <?php echo $plugin->version ?></span>
                        </div>
                        <h5 class="fw-bold mt-5"><?php ee('Description') ?></h5>
                        <p class="mt-3"><?php echo $plugin->longdescription ?? $plugin->description ?></p>
                        <?php if($plugin->category == 'addons'): ?>
                            <h5 class="fw-bold mt-3"><?php ee('Addons') ?></h5>
                            <p class="mt-3"><?php ee('Addons extend the functionality of Premium URL Shortener by adding new core features to your website.') ?></p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card rounded-3 p-3 pt-5 justify-content-center d-flex flex-column align-items-center">
                    <?php if($plugin->type == "paid"): ?>
                        <h1 class="fw-bolder">$<?php echo $plugin->price ?></h1>
                        <span class="text-muted flex-fill"><?php ee('Price in USD.') ?></span>
                        <a href="<?php echo $plugin->buy ?>" class="btn btn-success shadow w-100 rounded-3 mt-3 py-3 px-5 fw-bold" target="_blank"><?php ee("Purchase") ?></a>
                    <?php else: ?>
                        <h1 class="fw-bolder">Free</h1>
                        <?php if($plugin->installed): ?>
                            <?php if(version_compare($plugin->installedversion, $plugin->version, '<')): ?>
                                <a href="<?php echo route('admin.plugins.dir', ['install' => $plugin->tag]) ?>" class="btn btn-primary shadow w-100 rounded-3 mt-3 py-3 px-5 fw-bold" data-load><?php ee("Update") ?></a>
                            <?php else: ?>
                                <?php ee('Installed & Up-to-date') ?>
                            <?php endif ?>
                        <?php else: ?>
                            <a href="<?php echo route('admin.plugins.dir', ['install' => $plugin->tag]) ?>" class="btn btn-primary shadow w-100 rounded-3 mt-3 py-3 px-5 fw-bold" data-load><?php ee("Install") ?></a>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="justify-content-center d-flex">
                    <div class="card rounded-3 flex-fill me-1">
                        <div class="card-body">
                            <p><strong><?php ee('Author') ?></strong></p>
                            <a href="<?php echo $plugin->link ?>" target="_blank" class="me-2"><strong><?php echo $plugin->author ?></strong></a>
                            <span class="fw-bold ms-auto" data-bs-toggle="tooltip" title="<?php ee('Trusted Author') ?>"><i class="text-success me-1" data-feather="star"></i></span>                            
                        </div>
                    </div>
                    <div class="card rounded-3 p-3 flex-fill ms-1">
                        <p><strong><strong><?php ee('Minimum Version') ?></strong></p>
                        <span class="me-2"><?php echo $plugin->minversion ?></span>
                        <?php if(version_compare($plugin->minversion, config('version'), '<=')): ?>
                            <span class="fw-bold ms-auto" data-bs-toggle="tooltip" title="<?php ee('Compatible') ?>"><i class="text-success me-1" data-feather="check-circle"></i></span>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>