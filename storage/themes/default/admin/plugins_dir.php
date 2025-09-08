<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.plugins') ?>"><?php ee('Plugins') ?></a></li>
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
        <?php if($plugins): ?>
            <h3 class="my-4 fw-bold"><?php echo count($plugins) ?> Plugins</h3>
            <div class="mb-4">
                <a href="<?php echo route('admin.plugins.dir') ?>" class="btn btn-outline-dark rounded-3 me-2 <?php echo (!request()->category ? 'active' : '' ) ?>"><?php ee('All Plugins') ?></a>
                <?php foreach($categories as $category): ?>
                    <a href="<?php echo route('admin.plugins.dir', ['category' => $category]) ?>" class="btn btn-outline-dark rounded-3 me-2 <?php echo (request()->category == $category ? 'active' : '' ) ?>"><?php echo ucfirst($category) ?></a>
                <?php endforeach ?>
            </div>
            <?php foreach($plugins as $plugin): ?>
                <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card rounded-4 shadow-sm h-100 position-relative">
                        <?php if($plugin->installed): ?>
                            <p class="position-absolute top-0 start-50 translate-middle"><span class="badge bg-success"><?php ee('Installed') ?></span></p>
                        <?php endif ?>
                        <a href="<?php echo route('admin.plugins.single', $plugin->tag) ?>">
                        <?php if($plugin->thumbnail): ?>
                            <img src="<?php echo $plugin->thumbnail ?>" class="img-fluid rounded">
                        <?php else : ?>
                            <div class="w-100 d-flex justify-content-center align-items-center primary-gradient text-white fw-bold rounded" style="height:163px"><?php echo $plugin->name ?></div>
                        <?php endif ?>
                        </a>
                        <div class="card-body">
                            <p class="mb-2"><strong><?php echo $plugin->name ?></strong> (v<?php echo $plugin->version ?>)</p>
                            <p>
                                <span class="badge me-2 bg-dark"><?php echo ucfirst($plugin->category) ?></span> <?php echo $plugin->type == "paid" ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-primary">Free</span>' ?>
                            </p>
                            <p><a href="<?php echo $plugin->link ?>" target="_blank"><strong><?php echo $plugin->author ?></strong></a></p>
                            <p><?php echo $plugin->description ?></p>
                            <p>
                            <?php if($plugin->type == "paid"): ?>
                                <a href="<?php echo $plugin->buy ?>" class="btn btn-success" target="_blank"><?php ee("Purchase") ?></a>
                            <?php else: ?>
                                <?php if($plugin->installed): ?>
                                    <?php if(version_compare($plugin->installedversion, $plugin->version, '<')): ?>
                                        <a href="<?php echo route('admin.plugins.dir', ['install' => $plugin->tag]) ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm" data-load><?php ee("Update") ?></a>
                                    <?php endif ?>
                                <?php else: ?>
                                    <a href="<?php echo route('admin.plugins.dir', ['install' => $plugin->tag]) ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm" data-load><?php ee("Install") ?></a>
                                <?php endif ?>
                            <?php endif ?>
                            <a href="<?php echo route('admin.plugins.single', $plugin->tag) ?>" class="d-inline-block ms-2 text-muted fw-bold"><?php ee('View Details') ?></a>
                            </p>
                            <small class="text-muted"><?php ee('Works with') ?> v<?php echo $plugin->minversion ?>+</small>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="card rounded-4 card-body shadow-sm"><?php ee('No results.') ?></div>
            </div>
        <?php endif ?>
        </div>
    </div>
</div>