<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('admin.roles') ?>"><?php ee('Roles & Permissions') ?></a></li>
	</ol>
</nav>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold"><?php ee('Create Role') ?></h1>
        <p class="text-muted"><?php ee('Create a new role with specific permissions') ?></p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form action="<?php echo route('admin.roles.save') ?>" method="post">
                    <?php echo csrf() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold"><?php ee('Role Name') ?> *</label>
                        <input type="text" class="form-control p-2" id="name" name="name" value="<?php echo old('name') ?>" required>
                        <div class="form-text"><?php ee('Enter a unique name for this role') ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold"><?php ee('Description') ?></label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo old('description') ?></textarea>
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
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo $permission ?>" id="<?php echo $permission ?>">
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

                    <div class="">
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm">
                            <?php ee('Create Role') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>