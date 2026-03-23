<h1 class="h3 mb-5 fw-bold"><?php ee('New Parameter Template') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('paramtemplates.save') ?>">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="name" class="form-label fw-bold"><?php ee('Template name') ?></label>
                <input type="text" class="form-control p-2" name="name" id="name" required placeholder="<?php echo e('e.g. Facebook Campaign') ?>">
            </div>
            <h5 class="fw-bold mb-3"><?php ee('UTM Parameters') ?></h5>
            <p class="text-muted small"><?php ee('Optional. Leave blank to omit from the template.') ?></p>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="utm_source" class="form-label">utm_source</label>
                    <input type="text" class="form-control p-2" name="utm_source" id="utm_source" placeholder="e.g. newsletter">
                </div>
                <div class="col-md-6">
                    <label for="utm_medium" class="form-label">utm_medium</label>
                    <input type="text" class="form-control p-2" name="utm_medium" id="utm_medium" placeholder="e.g. email">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="utm_campaign" class="form-label">utm_campaign</label>
                    <input type="text" class="form-control p-2" name="utm_campaign" id="utm_campaign" placeholder="e.g. spring_sale">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="utm_term" class="form-label">utm_term</label>
                    <input type="text" class="form-control p-2" name="utm_term" id="utm_term" placeholder="<?php ee('Optional') ?>">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="utm_content" class="form-label">utm_content</label>
                    <input type="text" class="form-control p-2" name="utm_content" id="utm_content" placeholder="<?php ee('Optional') ?>">
                </div>
            </div>
            <h5 class="fw-bold mb-3"><?php ee('Custom Parameters') ?></h5>
            <p class="text-muted small"><?php ee('Add any custom query parameter name and value.') ?></p>
            <div class="mb-3">
                <a href="#" class="btn btn-sm btn-primary rounded-3" data-trigger="addmore" data-for="paramtemplate-custom"><i class="fa fa-plus me-1"></i> <?php ee('Add') ?></a>
            </div>
            <div id="paramtemplate-custom">
                <div class="row" data-toggle="addable" data-label="paramtemplate-custom">
                    <div class="col-sm-6 mt-2">
                        <input type="text" name="paramname[]" class="form-control p-2" data-trigger="autofillparam" placeholder="<?php echo e('Parameter name') ?>">
                    </div>
                    <div class="col-sm-6 mt-2">
                        <input type="text" name="paramvalue[]" class="form-control p-2" placeholder="<?php echo e('Parameter value') ?>">
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create Template') ?></button>
                <a href="<?php echo route('paramtemplates') ?>" class="btn btn-white border px-3 py-2 rounded-3"><?php ee('Cancel') ?></a>
            </div>
        </form>
    </div>
</div>
