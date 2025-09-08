<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.plans') ?>"><?php ee('Plans') ?></a></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('New Plan') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.plans.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="mb-4 rounded p-3 border">
                <h4 class="mb-4 fw-bold"><?php ee('Plan Information') ?></h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                            <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="My Sample Plan">
                            <p class="form-text"><?php ee('The name of the package.') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold d-block"><?php ee('Description') ?>  <span class="text-muted float-end"><?php ee('optional') ?></span></label>
                            <input type="text" class="form-control p-2" name="description" id="description" value="<?php echo old('description') ?>" placeholder="Plan description">
                            <p class="form-text"><?php ee('This field allows you to describe the package.') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="icon" class="form-label fw-bold d-block"><?php ee('Plan Icon Class') ?> <span class="text-muted float-end"><?php ee('optional') ?></span></label>
                            <input type="text" class="form-control p-2" name="icon" id="icon" value="<?php echo old('icon') ?>" placeholder="Icon class" autocomplete="off">
                            <p class="form-text"><?php ee('This field allows you to set a class for the icons. For example if you want to use fontawesome, add the library in the theme file and use the class name here e.g. fa fa-plus') ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">    
                            <label for="status" class="fw-bold form-label"><?php ee('Status') ?></label>
                            <select class="form-select p-2" name="status" id="status">
                                <option value="1"> <?php ee('Enabled') ?></option>
                                <option value="0"> <?php ee('Disabled') ?></option>
                            </select>
                            <p class="form-text"><?php ee("Disabled plans cannot be assigned to new users.") ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hidden" class="fw-bold form-label"><?php ee('Hidden') ?></label>
                            <select class="form-select p-2" name="hidden" id="hidden">
                                <option value="0"> <?php ee('Visible') ?></option>
                                <option value="1"> <?php ee('Hidden') ?></option>
                            </select>
                            <p class="form-text"><?php ee("Hidden plans can be assign to users and it will not show up in the pricing table.") ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hidden" class="fw-bold form-label"><?php ee('Popular Badge') ?></label>
                            <select class="form-select p-2" name="popular" id="hidden">
                                <option value="0"> <?php ee('Disabled') ?></option>
                                <option value="1"> <?php ee('Enabled') ?></option>
                            </select>
                            <p class="form-text"><?php ee("Popular plans will have a different styling.") ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4 rounded p-3 border">
                <h4 class="mb-4 fw-bold"><?php ee('Pricing') ?> (<?php echo config('currency') ?>)</h4>
                <div class="form-group">
                    <div class="form-check form-switch">
                        <input type="hidden" name="free" value="1">
                        <input class="form-check-input" type="checkbox" id="free" name="free" value="0" data-toggle="togglefield" data-toggle-for="trial,price_monthly,price_yearly,price_lifetime" checked>
                        <label class="form-check-label fw-bold" for="free"><?php ee('Paid Plan') ?></label>
                    </div>
                    <p class="form-text"><?php ee("If you want to make this plan free, turn this off. If you don't have a free plan, users will be forced to upgrade. You need at least one pricing plan for each plan. It can be either monthly, yearly or lifetime. To remove a payment plan, leave the field empty.") ?></p>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="trial" class="form-label fw-bold"><?php ee('Trial Days') ?></label>
                            <input type="text" class="form-control p-2" name="trial" id="trial" value="<?php echo old('trial') ?>" placeholder="e.g. 7">
                            <p class="form-text"><?php ee('Trial period for this plan in number of days. For example 14. Note this only applies to paid plans and trials do not require a credit card. Close to expiration users will receive an email to remind them that the trial will expire and they need to upgrade. ') ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="price_monthly" class="form-label fw-bold"><?php ee('Price Monthly') ?></label>
                            <input type="text" class="form-control p-2" name="price_monthly" id="price_monthly" value="<?php echo old('price_monthly') ?>" placeholder="e.g. 9.99">
                            <p class="form-text"><?php ee('To change your currency, you need to change it in the settings page.') ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="price_yearly" class="form-label fw-bold"><?php ee('Price Yearly') ?></label>
                            <input type="text" class="form-control p-2" name="price_yearly" id="price_yearly" value="<?php echo old('price_yearly') ?>" placeholder="e.g. 99.99">
                            <p class="form-text"><?php ee('To change your currency, you need to change it in the settings page.') ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="price_lifetime" class="form-label fw-bold"><?php ee('Price Lifetime') ?></label>
                            <input type="text" class="form-control p-2" name="price_lifetime" id="price_lifetime" value="<?php echo old('price_lifetime') ?>" placeholder="e.g. 999.99">
                            <p class="form-text"><?php ee('To change your currency, you need to change it in the settings page.') ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4 rounded p-3 border">
                <h4 class="mb-4 fw-bold"><?php ee('Plan Features') ?></h4>
                <div class="border rounded rounded-4 p-3 mb-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="counttype" class="form-label fw-bold"><?php ee('Links Count') ?></label>
                                <select class="form-select p-2" name="counttype" id="counttype">
                                    <option value="total"> <?php ee('Total') ?></option>
                                    <option value="monthly"> <?php ee('Monthly - Resets each month') ?></option>
                                </select>
                                <p class="form-text fs-6"><?php ee("If you choose monthly, user link counts will reset each month.") ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="numurls" class="form-label fw-bold"><?php ee('Number of links') ?></label>
                                <input type="text" class="form-control p-2" name="numurls" id="numurls" value="<?php echo old('numurls') ?>" placeholder="e.g. 10">
                                <p class="form-text fs-6"><?php ee("This will limit the number of URLs a user can have. '0' for unlimited.") ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="numclicks" class="form-label fw-bold"><?php ee('Number of clicks') ?></label>
                                <input type="text" class="form-control p-2" name="numclicks" id="numclicks" value="<?php echo old('numclicks') ?>" placeholder="e.g. 1000">
                                <p class="form-text fs-6"><?php ee("This will limit the number of clicks for each account. After this amount, clicks will not be counted anymore. URLs will still work however. '0' for unlimited.") ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="retention" class="form-label fw-bold"><?php ee('Stats Retention (days)') ?></label>
                                <input type="text" class="form-control p-2" name="retention" id="retention" value="<?php echo old('retention') ?>" placeholder="e.g. 15">
                                <p class="form-text fs-6"><?php ee("Number of days to keep stats for urls in this plan. Older stats will be deleted automatically. '0' for unlimited.") ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="permission-custom" class="form-label fw-bold"><?php ee('Custom Text') ?></label>
                                <input type="text" class="form-control p-2" name="permission[custom]" id="permission-custom" value="<?php echo old('permission-custom') ?>" placeholder="e.g. Phone Support">
                                <p class="form-text fs-6"><?php ee("You can use this field to add a custom feature e.g. Phone Support. This does not have an effect on the script.") ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php $i=0; foreach(\Helpers\App::features() as $slug => $feature): ?>
                        <?php if($i > 0 && $i%3 == 0) echo '</div><div class="row">' ?>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded rounded-4-3 p-3 h-100">
                                <div class="form-group mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" data-binary="true" id="permission-<?php echo $slug ?>-enabled" name="permission[<?php echo $slug ?>][enabled]" value="1" <?php echo ($feature['count'] || isset($feature['custom']) ? 'data-toggle="togglefield" data-toggle-for="permission-'.$slug.'-count,permission-'.$slug.'-custom"' : '') ?>>
                                        <label class="form-check-label fw-bold" for="permission-<?php echo $slug ?>-enabled"><?php ee($feature['name']) ?></label>
                                    </div>
                                    <p class="form-text mt-2 fs-5"><?php ee($feature['description']) ?></p>
                                </div>
                                <?php if($feature['count']): ?>
                                    <div class="form-group mb-4 d-none">
                                        <label for="permission-<?php echo $slug ?>-count" class="form-label fw-bold"><?php ee($feature['name']) ?></label>
                                        <input type="text" class="form-control p-2" name="permission[<?php echo $slug ?>][count]" id="permission-<?php echo $slug ?>-count" placeholder="e.g. 10">
                                        <p class="form-text mt-2 fs-5"><?php ee("Use '0' for unlimited.") ?></p>
                                        <?php if($slug == 'qr'): ?>
                                            <div>
                                                <label for="qrcounttype" class="form-label fw-bold"><?php ee('Qr Count') ?></label>
                                                <select class="form-select p-2" name="qrcounttype" id="qrcounttype">
                                                    <option value="total"> <?php ee('Total') ?></option>
                                                    <option value="monthly"> <?php ee('Monthly - Resets each month') ?></option>
                                                </select>
                                                <p class="form-text fs-6"><?php ee("If you choose monthly, user qr counts will reset each month.") ?></p>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                <?php endif ?>
                                <?php if(isset($feature['custom'])): ?>
                                    <div class="form-group mb-4 d-none">
                                        <label for="permission-<?php echo $slug ?>-custom" class="form-label fw-bold d-block mb-1"><?php echo $feature['custom']['title'] ?></label>
                                        <?php if($feature['custom']['type'] == 'input'): ?>
                                            <input type="text" class="form-control p-2" name="permission[<?php echo $slug ?>][custom]" id="permission-<?php echo $slug ?>-custom" value="">
                                        <?php endif ?>
                                        <?php if($feature['custom']['type'] == 'select'): ?>
                                            <div class="input-select" id="permission-<?php echo $slug ?>-custom">
                                                <select multiple="multiple" class="form-select p-2" name="permission[<?php echo $slug ?>][custom][]" data-toggle="select">
                                                    <?php foreach($feature['custom']['data'] as $data): ?>
                                                        <option><?php echo $data ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        <?php endif ?>
                                        <p class="form-text mt-2 fs-5"><?php echo $feature['custom']['description'] ?></p>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm mt-2"><?php ee('Add Plan') ?></button>
        </form>
    </div>
</div>