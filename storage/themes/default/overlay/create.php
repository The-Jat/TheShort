<div class="d-flex mb-5">
    <h1 class="h3 fw-bold"><?php ee('Create a CTA Overlay') ?></h1>
</div>

<div class="row">
<?php foreach($types as $tag => $type): ?>
    <div class="col-md-4">
        <div class="card rounded-4 flex-fill shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1 text-center">
                        <p><i class="icon-45" data-feather="<?php echo $type["icon"] ?>"></i> </p>
                        <strong><?php echo e($type["name"]) ?></strong>
                        <p class="my-3"><?php echo e($type["description"]) ?></p>
                        <a href="<?php echo route('overlay.create', [$tag]) ?>" class="btn btn-primary rounded-3 px-3 py-2 w-100"><?php ee("Create") ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>
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