<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('admin.roles') ?>"><?php ee('Roles & Permissions') ?></a></li>
	</ol>
</nav>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-2 fw-bold"><?php ee('Edit Role') ?></h1>
        <p class="text-muted"><?php ee('Modify role details and permissions') ?></p>
    </div>
    <div>
        <a href="<?php echo route('admin.roles.users', $role->id) ?>" class="btn btn-dark px-3 py-2 rounded-3">
            <?php ee('View Users') ?>
        </a>
        <a href="<?php echo route('admin.roles.permissions', $role->id) ?>" class="btn btn-dark px-3 py-2 rounded-3">
            <?php ee('View Permissions') ?>
        </a>        
    </div>    
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form action="<?php echo route('admin.roles.update', $role->id) ?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold"><?php ee('Role Name') ?> *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e($role->name) ?>" required>
                        <div class="form-text"><?php ee('Enter a unique name for this role') ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold"><?php ee('Description') ?></label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo e($role->description) ?></textarea>
                        <div class="form-text"><?php ee('Describe what this role is for') ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><?php ee('Permissions') ?></label>
                        <div class="border rounded p-3">
                            <?php foreach($permissions as $category => $data): ?>
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3"><?php echo e($data['name']) ?></h6>
                                    <div class="row">
                                        <?php foreach($data['permissions'] as $permission => $label): ?>
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo $permission ?>" id="<?php echo $permission ?>" <?php echo in_array($permission, $role->permissions) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="<?php echo $permission ?>">
                                                        <?php echo e($label) ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>  
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm">
                            <?php ee('Update Role') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0 fw-bold"><?php ee('Role Information') ?></h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted"><?php ee('Created') ?></label>
                    <p class="mb-0"><?php echo \Core\Helper::timeago($role->created_at) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted"><?php ee('Users with this role') ?></label>
                    <p class="mb-0">
                        <a href="<?php echo route('admin.roles.users', $role->id) ?>" class="text-decoration-none">
                            <?php echo $role->getUserCount() ?> <?php ee('users') ?>
                        </a>
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted"><?php ee('Permissions granted') ?></label>
                    <p class="mb-0"><?php echo count($role->permissions) ?> <?php ee('permissions') ?></p>
                </div>
            </div>
        </div>
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