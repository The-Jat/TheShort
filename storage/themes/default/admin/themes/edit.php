<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.bio.themes') ?>"><?php ee('Bio Page Theme Manager') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Edit Bio Page Theme') ?></h1>

<div class="row">
    <div class="col-md-8">
        <form action="<?php echo route('admin.bio.theme.update', $theme->id) ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="name" class="form-label fw-bold"><?php ee('Theme Name') ?></label>
                        <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo $theme->name ?>" placeholder="name">
                    </div>
                    <div class="form-group mb-4">
                        <label for="description" class="form-label fw-bold"><?php ee('Theme Description') ?></label>
                        <input type="text" class="form-control p-2" name="description" id="description" value="<?php echo $theme->description ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="description" class="form-label fw-bold"><?php ee('Status') ?></label>
                                <select name="status" class="form-select p-2">
                                    <option value="0" <?php echo !$theme->status ? 'selected' : '' ?>><?php ee('Disabled') ?></option>
                                    <option value="1" <?php echo $theme->status ? 'selected' : '' ?>><?php ee('Enabled') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="description" class="form-label fw-bold"><?php ee('Restriction') ?></label>
                                <select name="paidonly" id="paidonly" class="form-select p-2">
                                    <option value="0" <?php echo !$theme->paidonly ? 'selected' : '' ?>><?php ee('Everyone') ?></option>
                                    <option value="1" <?php echo $theme->paidonly ? 'selected' : '' ?>><?php ee('Premium Users Only') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="plan-access-section" class="mb-4 rounded p-3 border <?php echo $theme->paidonly == 1 ? '' : 'd-none' ?>">
                        <h4 class="mb-4 fw-bold"><?php ee('Plan Access') ?></h4>
                        <div class="form-group mb-3">
                            <p class="form-text"><?php ee('Select which plans can use this theme. Leave all unchecked to make it available to all plans.') ?></p>
                        </div>
                        <div class="row">
                            <?php foreach($plans as $plan): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="planids[]" value="<?php echo $plan->id ?>" id="plan_<?php echo $plan->id ?>" <?php echo in_array($plan->id, $theme->planids ?? []) ? 'checked' : '' ?>>
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
                    <div class="p-3 rounded border mb-3">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold d-block"><?php ee('Text Color') ?></label>
                            <input type="text" name="textcolor" id="textcolor" value="<?php echo $theme->data->textcolor ?? '' ?>">
                        </div>
                    </div>
                    <div class="p-3 rounded border mb-3">
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold"><?php ee('Background Type') ?></label>
                            <select name="bgtype" class="form-select p-2">
                                <option value="single" <?php echo $theme->data->bgtype == 'single' ? 'selected' : '' ?>><?php ee('Single Color') ?></option>
                                <option value="gradient" <?php echo $theme->data->bgtype == 'gradient' ? 'selected' : '' ?>><?php ee('Gradient') ?></option>
                                <option value="image" <?php echo $theme->data->bgtype == 'image' ? 'selected' : '' ?>><?php ee('Image') ?></option>
                                <option value="css" <?php echo $theme->data->bgtype == 'css' ? 'selected' : '' ?>><?php ee('CSS') ?></option>
                            </select>
                        </div>
                        <div id="single" class="bgblock <?php echo (!isset($theme->data->bgtype) || $theme->data->bgtype == 'single' ? '' : 'd-none')  ?>">
                            <div class="form-group mb-3">
                                <label for="singlecolor" class="form-label fw-bold d-block mb-2"><?php ee('Background Color') ?></label>
                                <input type="text" class="form-control p-2" name="singlecolor" value="<?php echo $theme->data->singlecolor ?? '' ?>">
                            </div>
                        </div>
                        <div id="gradient" class="bgblock <?php echo (isset($theme->data->bgtype) && $theme->data->bgtype == 'gradient' ? '' : 'd-none')  ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="bgst"><?php ee("Gradient Start") ?></label><br>
                                        <input type="text" name="gradientstart" id="bgst" value="<?php echo $theme->data->gradientstart ?? '' ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="bgsp"><?php ee("Gradient Stop") ?></label><br>
                                        <input type="text" name="gradientstop" id="bgsp" value="<?php echo $theme->data->gradientstop ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="gradientangle"><?php ee("Gradient Angle") ?></label><br>
                                <input type="range" id="gradientangle" name="gradientangle" min="0" max="360" value="<?php echo $theme->data->gradientangle ?? '135' ?>" class="form-range">
                                <span id="angle"><?php ee('Angle:') ?> <i><?php echo $theme->data->gradientangle ?? '135' ?></i>°</span>
                            </div>
                        </div>
                        <div id="image" class="bgblock <?php echo (isset($theme->data->bgtype) && $theme->data->bgtype == 'image' ? '' : 'd-none')  ?>">
                            <div class="form-group mb-3">
                                <label for="bgimage" class="form-label fw-bold d-block mb-2"><?php ee('Background Image') ?></label>
                                <input type="file" class="form-control" name="bgimage" id="bgimage" data-error="<?php ee('Please choose a valid background image. JPG, PNG') ?>">
                                <p class="form-text"><?php ee('Max upload size 1mb. JPG or PNG.') ?></p>
                            </div>
                        </div>
                        <div id="css" class="bgblock <?php echo (isset($theme->data->bgtype) && $theme->data->bgtype == 'css' ? '' : 'd-none')  ?>">
                            <div class="form-group mb-3">
                                <label for="customcss" class="form-label fw-bold d-block mb-2"><?php ee('Custom CSS') ?></label>
                                <textarea class="form-control" name="customcss" id="customcss" rows="15" placeholder="e.g. body { background: red; }"><?php echo $theme->data->customcss ?? '' ?></textarea>
                                <p class="form-text"><?php ee('Enter full CSS code with selectors. This CSS will be applied to the bio page. You need to assign the CSS to the <strong>body</strong> element. e.g. body { background: red; }') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 rounded border">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold d-block"><?php ee('Button Color') ?></label>
                            <input type="text" name="buttoncolor" id="buttoncolor" value="<?php echo $theme->data->buttoncolor ?? '' ?>" data-trigger="color">
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold d-block"><?php ee('Button Text Color') ?></label>
                            <input type="text" name="buttontextcolor" id="buttontextcolor" value="<?php echo $theme->data->buttontextcolor ?? '' ?>" data-trigger="color">
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold"><?php ee('Button Type') ?></label>
                            <select name="buttonstyle" id="buttonstyle" class="form-select p-2">
                                <option value="rectangular"<?php echo isset($theme->data->buttonstyle) && $theme->data->buttonstyle == 'rectangular' ? ' selected' : '' ?>><?php ee('Rectangular') ?></option>
                                <option value="rounded"<?php echo isset($theme->data->buttonstyle) && $theme->data->buttonstyle == 'rounded' ? ' selected' : '' ?>><?php ee('Rounded') ?></option>
                                <option value="trec"<?php echo isset($theme->data->buttonstyle) && $theme->data->buttonstyle == 'trec' ? ' selected' : '' ?>><?php ee('Transparent') ?> <?php ee('Rectangular') ?></option>
                                <option value="tro"<?php echo isset($theme->data->buttonstyle) && $theme->data->buttonstyle == 'tro' ? ' selected' : '' ?>><?php ee('Transparent') ?> <?php ee('Rounded') ?></option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold"><?php ee('Button Shadow') ?></label>
                            <select name="shadow" id="shadow" class="form-select p-2">
                                <option value="none"<?php echo isset($theme->data->shadow) && $theme->data->shadow == 'none' ? ' selected' : '' ?>><?php ee('None') ?></option>
                                <option value="soft"<?php echo isset($theme->data->shadow) && $theme->data->shadow == 'soft' ? ' selected' : '' ?>><?php ee('Soft') ?></option>
                                <option value="hard"<?php echo isset($theme->data->shadow) && $theme->data->shadow == 'hard' ? ' selected' : '' ?>><?php ee('Hard') ?></option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label fw-bold d-block"><?php ee('Shadow Color') ?></label>
                            <input type="text" name="shadowcolor" id="shadowcolor" data-trigger="color" value="<?php echo $theme->data->shadowcolor ?? '' ?>" data-default="<?php echo $theme->data->shadowcolor ?? '' ?>">
                        </div>
                        <div class="form-group mb-4">
                            <label for="font" class="form-label fw-bold d-block"><?php ee('Font') ?></label>
                            <select name="font" id="font" class="form-select p-2">
                                <option value=""><?php ee('Default') ?></option>
                                <?php foreach(['Arial', 'Helvetica_Neue', 'Courier_New', 'Times_New_Roman', 'Comic_Sans_MS', 'Verdana', 'Impact', 'Tahoma'] as $font): ?>
                                    <option value="<?php echo str_replace('_', '+', $font) ?>" <?php echo isset($theme->data->font) && $theme->data->font == str_replace('_', '+', $font) ? 'selected' : '' ?>><?php echo str_replace('_', ' ', $font) ?></option>
                                <?php endforeach ?>
                                <?php foreach(\Helpers\App::fonts() as $font): ?>
                                    <option value="<?php echo str_replace('_', '+', $font) ?>" <?php echo isset($theme->data->font) && $theme->data->font == str_replace('_', '+', $font) ? 'selected' : '' ?>><?php echo str_replace(['_', '+'], ' ', $font) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center">
                                <div>
                                    <label class="form-check-label fw-bold" for="frost"><?php ee('Frosted Glass Effect') ?></label>
                                    <p class="form-text mb-0 mt-1"><?php ee('Apply a frosted glass blur effect to buttons and cards using the button color') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="frost" name="frost" value="1" <?php echo isset($theme->data->frost) && $theme->data->frost ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3"><?php ee('Save Theme') ?></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <div id="preview" class="position-sticky top-0">
            <div class="card shadow-lg card-preview p-5">
                <div class="text-center mt-5">
                    <img src="<?php echo user()->avatar() ?>" class="rounded-circle mb-3 border mb-3" width="120" height="120">
                    <h3><?php echo config('title') ?></h3>
                    <p><?php echo config('description') ?></p>
                </div>
                <div class="mt-5">
                    <a href="#" class="btn d-block p-2 mb-3" style="background:#fff">👋 Hello</a>
                    <a href="#" class="btn d-block p-2" style="background:#fff">😃 Testing</a>
                </div>
            </div>
        </div>
    </div>
</div>