<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Advertisement') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bold mb-0"><?php ee('Advertisement') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.ads.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Ad') ?></a>
    </div>
</div>
<div class="card rounded-4 shadow-sm flex-fill">
    <table class="table table-hover my-0">
        <thead>
            <tr>
                <th><?php ee('Name') ?></th>
                <th class="d-none d-xl-table-cell"><?php ee('Type') ?></th>
                <th class="d-none d-xl-table-cell"><?php ee('Impression') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ads as $ad): ?>
                <tr>
                    <td>
                        <span class="badge <?php echo $ad->enabled ? 'bg-success' : 'bg-danger' ?> me-2 px-1 py-0 rounded-circle" data-bs-toggle="tooltip" title="<?php echo $ad->enabled ? e('Enabled') : e('Disabled') ?>">&nbsp;</span>                        
                        <span class="align-middle"><?php echo $ad->name ?></span>
                    </td>
                    <td class="d-none d-xl-table-cell"><?php echo \Helpers\App::adType($ad->type, true) ?></td>
                    <td class="d-none d-xl-table-cell"><?php echo $ad->impression ?></td>
                    <td>
                        <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo route('admin.ads.edit', [$ad->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.ads.delete', [$ad->id, \Core\Helper::nonce('ads.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php echo pagination('pagination') ?>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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