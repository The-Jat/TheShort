<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.bio.templates') ?>"><?php ee('Bio Templates') ?></a></li>
    <li class="breadcrumb-item"><?php ee('New Template') ?></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('New Bio Template') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.bio.templates.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="mb-4 rounded p-3 border">
                <h4 class="mb-4 fw-bold"><?php ee('Template Information') ?></h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="name" class="form-label fw-bold"><?php ee('Template Name') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="My Bio Template" required>
                            <p class="form-text"><?php ee('Enter a name for this template.') ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold d-block"><?php ee('Description') ?>  <span class="text-muted float-end"><?php ee('optional') ?></span></label>
                            <input type="text" class="form-control p-2" name="description" id="description" value="<?php echo old('description') ?>" placeholder="Template description">
                            <p class="form-text"><?php ee('A brief description of this template.') ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label for="preview" class="form-label fw-bold"><?php ee('Preview Image') ?> <span class="text-muted"><?php ee('(optional)') ?></span></label>
                            <input type="file" class="form-control p-2" name="preview" id="preview" accept="image/jpeg,image/jpg,image/png">
                            <p class="form-text"><?php ee('Upload a preview image for this template (JPG or PNG, max 2MB). This will be displayed when users browse templates.') ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label for="profileid" class="form-label fw-bold"><?php ee('Select Bio Page') ?> <span class="text-danger">*</span></label>
                            <select class="form-select p-2" name="profileid" id="profileid" required>
                                <option value=""><?php ee('-- Select a Bio Page --') ?></option>
                                <?php foreach($profiles as $profile): ?>
                                    <option value="<?php echo $profile->id ?>" <?php echo old('profileid') == $profile->id ? 'selected' : '' ?>><?php echo $profile->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <p class="form-text"><?php ee('Choose one of your bio pages to save as a template.') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4 rounded p-3 border">
                <h4 class="mb-4 fw-bold"><?php ee('Plan Access') ?></h4>
                <div class="form-group mb-3">
                    <p class="form-text"><?php ee('Select which plans can use this template. Leave all unchecked to make it available to all plans.') ?></p>
                </div>
                <div class="row">
                    <?php foreach($plans as $plan): ?>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="planids[]" value="<?php echo $plan->id ?>" id="plan_<?php echo $plan->id ?>">
                                <label class="form-check-label" for="plan_<?php echo $plan->id ?>">
                                    <?php echo $plan->name ?>
                                    <?php if($plan->free): ?>
                                        <span class="badge bg-info ms-2"><?php ee('Free') ?></span>
                                    <?php endif ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Create Template') ?></button>
                <a href="<?php echo route('admin.bio.templates') ?>" class="btn btn-white border px-5 py-2 rounded-3 shadow-sm"><?php ee('Cancel') ?></a>
            </div>
        </form>
    </div>
</div>
