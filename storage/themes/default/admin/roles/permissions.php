<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('admin.roles') ?>"><?php ee('Roles & Permissions') ?></a></li>
	</ol>
</nav>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-2 fw-bold"><?php ee('Role Permissions: {role}', null, ['role' => $role->name]) ?></h1>
        <p class="text-muted"><?php ee('View and manage permissions for this role') ?></p>
    </div>
    <div>
        <a href="<?php echo route('admin.roles.edit', $role->id) ?>" class="btn btn-primary px-3 py-2">
            <?php ee('Edit Permissions') ?>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0 fw-bold"><?php ee('Permission Overview') ?></h5>
            </div>
            <div class="card-body">
                <?php if(empty($rolePermissions)): ?>
                    <div class="text-center py-4">
                        <i data-feather="lock" class="text-muted" style="width: 48px; height: 48px;"></i>
                        <h5 class="mt-3"><?php ee('No Permissions') ?></h5>
                        <p class="text-muted"><?php ee('This role has no permissions assigned') ?></p>
                        <a href="<?php echo route('admin.roles.edit', $role->id) ?>" class="btn btn-primary">
                            <?php ee('Add Permissions') ?>
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach($permissions as $category => $data): ?>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-primary"><?php echo e($data['name']) ?></h6>
                            <div class="row">
                                <?php foreach($data['permissions'] as $permission => $label): ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <?php if(in_array($permission, $rolePermissions)): ?>
                                                <i data-feather="check-circle" class="text-success me-2"></i>
                                                <span class="text-success"><?php echo e($label) ?></span>
                                            <?php else: ?>
                                                <i data-feather="x-circle" class="text-muted me-2"></i>
                                                <span class="text-muted"><?php echo e($label) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="card-title fw-bold mb-0"><?php ee('Role Information') ?></h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted"><?php ee('Role Name') ?></label>
                    <p class="mb-0 fw-bold"><?php echo e($role->name) ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted"><?php ee('Description') ?></label>
                    <p class="mb-0"><?php echo e($role->description) ?: e('No description provided') ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted"><?php ee('Total Permissions') ?></label>
                    <p class="mb-0">
                        <span><?php echo count($rolePermissions) ?></span>
                        <?php ee('out of') ?> 
                        <?php 
                        $totalPermissions = 0;
                        foreach($permissions as $data) {
                            $totalPermissions += count($data['permissions']);
                        }
                        echo $totalPermissions;
                        ?>
                    </p>
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
                    <label class="form-label fw-bold text-muted"><?php ee('Created') ?></label>
                    <p class="mb-0"><?php echo \Core\Helper::timeago($role->created_at) ?></p>
                </div>
            </div>
        </div>

        <div class="card rounded-4 shadow-sm mt-3">
            <div class="card-header bg-transparent">
                <h5 class="card-title fw-bold mb-0"><?php ee('Permission Categories') ?></h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php foreach($permissions as $category => $data): ?>
                        <?php 
                        $categoryPermissions = array_intersect_key($data['permissions'], array_flip($rolePermissions));
                        $categoryCount = count($categoryPermissions);
                        $totalCategoryPermissions = count($data['permissions']);
                        ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="fw-bold"><?php echo e($data['name']) ?></span>
                                <br>
                                <small class="text-muted"><?php echo $categoryCount ?>/<?php echo $totalCategoryPermissions ?> <?php ee('permissions') ?></small>
                            </div>
                            <div class="progress" style="width: 60px; height: 6px;">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo $totalCategoryPermissions > 0 ? ($categoryCount / $totalCategoryPermissions) * 100 : 0 ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>