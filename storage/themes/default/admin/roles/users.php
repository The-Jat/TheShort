<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('admin.roles') ?>"><?php ee('Roles & Permissions') ?></a></li>
	</ol>
</nav>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-2 fw-bold"><?php ee('Users with Role: {role}', null, ['role' => $role->name]) ?></h1>
        <p class="text-muted"><?php ee('Manage users assigned to this role') ?></p>
    </div>
</div>

<div class="card rounded-4 shadow-sm">
    <div class="card-body p-0">
        <?php if(empty($users)): ?>
            <div class="text-center py-5">
                <i data-feather="users" class="text-muted" style="width: 48px; height: 48px;"></i>
                <h5 class="mt-3"><?php ee('No Users Found') ?></h5>
                <p class="text-muted"><?php ee('No users are currently assigned to this role') ?></p>
                <a href="<?php echo route('admin.users') ?>" class="btn btn-primary">
                    <?php ee('Manage Users') ?>
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php ee('User') ?></th>
                            <th><?php ee('Email') ?></th>
                            <th><?php ee('Plan') ?></th>
                            <th><?php ee('Status') ?></th>
                            <th><?php ee('Joined') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo $user->avatar() ?>" class="rounded-circle me-3" width="40" height="40" alt="">
                                        <div>
                                            <h6 class="mb-0"><?php echo e($user->username ?: $user->name) ?></h6>
                                            <small class="text-muted">ID: <?php echo $user->id ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span><?php echo e($user->email) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark"><?php echo e($user->planname) ?></span>
                                </td>
                                <td>
                                    <?php if($user->active): ?>
                                        <span class="badge bg-success"><?php ee('Active') ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><?php ee('Inactive') ?></span>
                                    <?php endif ?>
                                    
                                    <?php if($user->banned): ?>
                                        <span class="badge bg-warning"><?php ee('Banned') ?></span>
                                    <?php endif ?>                                
                                </td>
                                <td>
                                    <span class="text-muted"><?php echo \Core\Helper::timeago($user->date) ?></span>
                                </td>
                                <td>        
                                    <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">                                     
                                        <li><a href="<?php echo route('admin.users.view', $user->id) ?>" class="dropdown-item" title="<?php ee('View') ?>"><i data-feather="eye"></i> <?php ee('View User') ?></a></li>
                                        <li><a href="<?php echo route('admin.users.edit', $user->id) ?>" class="dropdown-item" title="<?php ee('Edit') ?>"><i data-feather="edit-2"></i> <?php ee('Edit User') ?></a></li>
                                        <?php if($role->id > 1) : ?>
                                            <li class="dropdown-divider"></li>
                                            <li><a href="<?php echo route('admin.users.remove.role', $user->id) ?>" class="dropdown-item text-danger" title="<?php ee('Remove Role') ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="user-minus"></i> <?php ee('Remove Role') ?></a></li>
                                        <?php endif ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif ?>
    </div>
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