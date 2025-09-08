<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Pages') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Pages') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.page.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Page') ?></a>
    </div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Name') ?></th>
                    <th><?php ee('Category') ?></th>
                    <th><?php ee('Language') ?></th>
                    <th><?php ee('Last Updated') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pages as $page): ?>
                    <tr>
                        <td>
                            <?php if($page->menu): ?>
                                <span class="badge bg-success me-2 px-1 py-0 rounded-circle" data-bs-toggle="tooltip" title="Menu">&nbsp;</span>
                            <?php endif ?>
                            <a href="<?php echo route('page', [$page->seo]) ?>?lang=<?php echo $page->lang ?>" target="_blank" class="align-middle"><?php echo $page->name ?></a>
                            <span class="text-muted small d-block"><?php echo route('page', $page->seo, $page->lang) ?></span>
                        </td>
                        <td><?php echo ucfirst($page->category) ?></td>
                        <td><?php echo $page->lang ?></td>
                        <td><?php echo $page->lastupdated ? \Core\Helper::dtime($page->lastupdated, 'd-m-Y') : null ?></td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.page.edit', [$page->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.page.delete', [$page->id, \Core\Helper::nonce('page.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
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