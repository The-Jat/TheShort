<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><?php ee('Roles & Permissions') ?></li>
	</ol>
</nav>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-2 fw-bold"><?php ee('Roles & Permissions') ?></h1>
        <p class="text-muted"><?php ee('Manage user roles and their permissions') ?></p>
    </div>
    <div>
        <a href="<?php echo route('admin.roles.new') ?>" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm">
            <?php ee('Create Role') ?>
        </a>
    </div>
</div>

<div class="card rounded-4 shadow-sm">
    <div class="card-body p-0">
        <?php if(empty($roles)): ?>
            <div class="text-center py-5">
                <i data-feather="shield" class="text-muted" style="width: 48px; height: 48px;"></i>
                <h5 class="mt-3"><?php ee('No Roles Found') ?></h5>
                <p class="text-muted"><?php ee('Create your first role to get started') ?></p>
                <a href="<?php echo route('admin.roles.new') ?>" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm">
                    <?php ee('Create Role') ?>
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php ee('Role Name') ?></th>
                            <th><?php ee('Description') ?></th>
                            <th><?php ee('Users') ?></th>
                            <th><?php ee('Created') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($roles as $role): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm <?php echo $role->id == '1' ? 'bg-success' : 'bg-primary' ?> text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <?php echo $role->id == '1' ? '<i data-feather="star"></i>' : '<i data-feather="shield"></i>' ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo e($role->name) ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted"><?php echo e($role->description) ?></span>
                                </td>
                                <td>
                                    <span class="badge border text-dark"><?php echo $role->user_count ?></span>
                                </td>
                                <td>
                                    <span class="text-muted"><?php echo \Core\Helper::timeago($role->created_at) ?></span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo route('admin.roles.users', $role->id) ?>" class="dropdown-item" title="<?php ee('View Users') ?>"><i data-feather="users"></i> <?php ee('View Users') ?></a></li>
                                        <li class="dropdown-divider"></li>
                                        <?php if($role->id > 1) : ?>
                                            <li><a href="<?php echo route('admin.roles.edit', $role->id) ?>" class="dropdown-item" title="<?php ee('Edit') ?>"><i data-feather="edit-2"></i> <?php ee('Edit Role') ?></a></li>
                                            <li><a href="<?php echo route('admin.roles.permissions', $role->id) ?>" class="dropdown-item" title="<?php ee('View Permissions') ?>"><i data-feather="key"></i> <?php ee('View Permissions') ?></a></li>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?php echo route('admin.roles.delete', [$role->id, \Core\Helper::nonce('role.delete')]) ?>" class="dropdown-item text-danger" title="<?php ee('Delete') ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash-2"></i> <?php ee('Delete') ?></a></li>
                                        <?php endif ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="mt-4 d-block">
	<?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
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