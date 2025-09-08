<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Notifications') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <div>
        <h1 class="h3 mb-0 fw-bold"><?php ee('Notifications') ?></h1>
    </div>
    <div class="ms-auto">
    <a href="<?php echo route('admin.notifications.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('New Notification') ?></a>
    </div>
</div>

<div class="card rounded-4 flex-fill shadow-sm">            
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Title') ?></th>
                    <th width="10%"><?php ee('Target') ?></th>
                    <th><?php ee('Content') ?></th>
                    <th><?php ee('Created') ?></th>
                    <th><?php ee('Expires') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($notifications as $notification): ?>
                    <tr>
                        <td>
                            <?php echo $notification->data->title ?>
                            <?php echo $notification->expires_at && strtotime('now') > strtotime($notification->expires_at) ? '<span class="badge bg-danger text-white">'.e('Expired').'</span>' : '' ?>
                        </td>
                        <td>
                            <?php echo $notification->data->target ?>
                        </td>
                        <td><?php echo $notification->data->content ?></td>
                        <td><?php echo $notification->created_at ?></td>
                        <td><?php echo $notification->expires_at ?? e('Never') ?></td>
                        <td>
                            <button type="button" class="btn btn-default  bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.notifications.delete', [$notification->id, \Core\Helper::nonce('notification.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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