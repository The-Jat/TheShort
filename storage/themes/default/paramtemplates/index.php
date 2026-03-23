<div class="d-flex mb-5">
    <h1 class="h3 mb-0 fw-bold"><span class="align-middle"><?php ee('Parameter Templates') ?></span></h1>
    <div class="ms-auto">
        <?php if(\Core\Auth::user()->teamPermission('links.create')): ?>
            <a href="<?php echo route('paramtemplates.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('New Template') ?></a>
        <?php endif ?>
    </div>
</div>
<?php if($templates): ?>
    <div class="row g-3">
        <?php foreach($templates as $t): ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card rounded-4 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <h5 class="card-title mb-0 fw-bold"><?php echo e($t->name) ?></h5>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-default bg-white border-0 p-1" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical" class="align-middle"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <?php if(\Core\Auth::user()->teamPermission('links.edit')): ?>
                                        <li><a class="dropdown-item" href="<?php echo route('paramtemplates.edit', [$t->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                    <?php endif ?>
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('paramtemplates.delete', [$t->id, \Core\Helper::nonce('paramtemplate.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="card-text text-muted small mb-0 mt-auto"><?php ee('Created') ?> <?php echo \Core\Helper::timeago($t->created_at) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <div class="card rounded-4 shadow-sm">
        <div class="card-body text-center">
            <p><?php ee('No parameter templates yet. Create reusable UTM and custom parameter sets to assign to your links.') ?></p>
            <?php if(\Core\Auth::user()->teamPermission('links.create')): ?>
                <a href="<?php echo route('paramtemplates.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('New Template') ?></a>
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
