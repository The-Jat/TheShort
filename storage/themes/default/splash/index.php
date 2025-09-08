<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><span class="align-middle"><?php ee('Custom Splash Pages') ?> </span> <i class="fa fa-question-circle text-muted fs-6 opacity-50" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo ee('A custom splash page is a transitional page where you can add a banner and a logo along with a message to represent your brand or company. When creating a short link, you will be able to assign the page to your short url. Users who visit your url will briefly see the page before being redirected to their destination.') ?>"></i></h1>
    <div class="ms-auto">
        <?php if(\Core\Auth::user()->teamPermission('splash.create')): ?>
            <a href="<?php echo route('splash.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create') ?></a>
        <?php endif ?>
    </div>
</div>
<div class="card rounded-4 shadow-sm p-2">
    <div class="d-block d-md-flex align-items-center">
        <div>
			<span class="h3 ms-2"><?php echo $count ?></span> <span class="text-muted"> <?php ee('Custom Splash Pages') ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></span>
		</div>
        <div class="ms-auto">
            <form action="<?php echo route('splash') ?>" method="get" class="d-flex align-items-center border rounded-3 p-1">
                <div class="me-2 flex-fill">
                    <input type="text" class="form-control border-0 p-2" name="q" value="<?php echo clean(request()->q) ?>" placeholder="<?php ee('Search for {t}', null, ['t' => e('Custom Splash Pages')]) ?>">
                </div>
                <div>
                    <button type="submit" class="btn bg-white py-2 px-3"><i data-feather="search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if($splashpages): ?>
    <div class="row">
        <?php foreach($splashpages as $splash): ?>
            <div class="col-md-6">
                <div class="card rounded-4 flex-fill shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <?php if($avatar = json_decode($splash->data)->avatar):?>
                                <div class="me-3">
                                    <img src="<?php echo uploads($avatar) ?>" width="45" class="fluid-image rounded">
                                </div>
                            <?php endif ?>
                            <div class="flex-grow-1">
                                <div class="float-end">
                                    <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                    <?php if(\Core\Auth::user()->teamPermission('splash.edit')): ?>
                                        <li><a class="dropdown-item" href="<?php echo route('splash.edit', [$splash->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                                    <?php endif ?>
                                    <?php if(\Core\Auth::user()->teamPermission('splash.delete')): ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="<?php echo route('splash.delete', [$splash->id, \Core\Helper::nonce('splash.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                                    <?php endif ?>
                                    </ul>
                                </div>
                                <strong><?php echo $splash->name ?></strong>
                                <br />
                                <small class="text-navy"><?php echo \Core\Helper::timeago($splash->date) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="mt-4 d-block">
        <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
    </div>
<?php else: ?>
    <div class="card rounded-4 flex-fill shadow-sm">
        <div class="card-body text-center">
            <p><?php ee('No content found. You can create some.') ?></p>
            <?php if(\Core\Auth::user()->teamPermission('splash.create')): ?>
                <a href="<?php echo route('splash.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create a Custom Splash') ?></a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to delete this?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete a record. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>    
      </div>
    </div>
  </div>
</div>