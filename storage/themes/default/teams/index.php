<div class="d-flex mb-5">
    <div>
        <h1 class="h3 fw-bold"><?php ee('Manage Members') ?></h1>
    </div>
</div>
<?php if(!user()->teamid): ?>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <h4 class="fw-bold"><?php ee('Invite Members') ?> <span class="text-muted fs-6 align-middle">(<?php echo $count ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?>)</span></h4>
        <form method="post" action="<?php echo route('team.save') ?>">
            <?php echo csrf() ?>
            <div class="d-block d-sm-flex mt-4">
                <div class="form-group flex-grow-1 mb-3">
                    <label for="email" class="label-control fw-bold mb-2"><?php echo e("Email") ?></label>
                    <input type="email" value="" name="email" class="form-control p-2" placeholder="johndoe@email.tld">
                </div>
                <div class="form-group mb-3 m-0 ms-sm-3 w-50 flex-grow-1 input-select">
                    <label for="permissions" class="label-control fw-bold mb-2"><?php echo e("Permissions") ?></label>
                    <select name="permissions[]" class="form-control" placeholder="<?php echo e("Permissions") ?>" data-placeholder="<?php echo e("Permissions") ?>" multiple data-toggle="select">
                        <?php foreach($list as $type => $item): ?>
                            <?php if (!user()->has("qr")) continue; ?>
                            <optgroup label="<?php echo $item['name'] ?>">
                                <?php foreach($item['permissions'] as $key => $name): ?>
                                    <option value="<?php echo $type ?>.<?php echo $key ?>"><?php echo $name ?></option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group ms-0 ms-sm-2">
                    <label class="d-block label-control fw-bold mb-2">&nbsp;</label>
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Invite') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif ?>
<?php if($teams): ?>
    <?php foreach($teams as $team): ?>
        <div class="card rounded-4 shadow-sm rounded-lg p-3">
            <div class="d-block d-md-flex align-items-center">
                <div class="d-flex flex-fill">
                    <img src="<?php echo $team->user->avatar() ?>" class="avatar rounded-circle">
                    <div class="ms-2">
                        <strong><?php echo $team->user->name ? $team->user->name : $team->user->username ?> <?php echo ($team->status ? '<span class="badge bg-success">'.e("Active").'</span>' : '<span class="badge bg-danger">'.e("Disabled").'</span>') ?></strong><br>
                        <span class="text-muted"><?php echo $team->user->email ?></span>
                    </div>
                </div>
                <div class="flex-fill text-start text-md-end">
                    <?php if($team->status == '-1'): ?>
                        <span class="text-warning fw-bold align-middle"><?php ee('Requested') ?></span>
                    <?php else: ?>
                        <?php if($team->status): ?>
                        <a class="me-2 text-dark" href="<?php echo route('team.toggle', [$team->id]) ?>"><i class="text-muted" data-feather="x-circle"></i> <span class="align-middle"><?php ee('Disable') ?></span></a>
                        <?php else: ?>
                        <a class="me-2 text-dark" href="<?php echo route('team.toggle', [$team->id]) ?>"><i class="text-muted" data-feather="check-circle"></i> <span class="align-middle"><?php ee('Enable') ?></span></a>
                        <?php endif ?>
                    <?php endif ?>
                    <button type="button" class="btn btn-default bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo route('team.edit', [$team->id]) ?>"><i data-feather="edit"></i> <?php ee('Manage') ?></span></a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#permissionModal" data-permission="<?php echo htmlentities($team->permission, ENT_QUOTES) ?>"><i data-feather="user"></i> <?php ee('View Permissions') ?></span></a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?php echo route('team.delete', [$team->id, \Core\Helper::nonce('team.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <span class="align-middle ms-1"><?php ee('Remove') ?></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <div class="mt-4 d-block">
        <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
    </div>
<?php else: ?>
    <div class="card rounded-4 shadow-sm">
        <div class="card-body text-center">
            <p><?php ee('No members found. You can invite one.') ?></p>
            <?php if(!user()->team()): ?>
                <a href="#" data-bs-toggle="modal" data-bs-target="#inviteModal"  class="btn btn-primary btn-sm"><?php ee('Add Member') ?></a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
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
<div class="modal fade" id="permissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Permissions') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div></div>
      </div>
    </div>
  </div>
</div>