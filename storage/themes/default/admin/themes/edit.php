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
                                <select name="paidonly" class="form-select p-2">
                                    <option value="0" <?php echo !$theme->paidonly ? 'selected' : '' ?>><?php ee('Everyone') ?></option>
                                    <option value="1" <?php echo $theme->paidonly ? 'selected' : '' ?>><?php ee('Premium Users Only') ?></option>
                                </select>
                            </div>
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
                                <textarea class="form-control" name="customcss" rows="15" placeholder="e.g. background-color: red;"><?php echo $theme->data->customcss ?? '' ?></textarea>
                                <p class="form-text"><?php ee('Do not enter any element name or class name i.e. enter code between { __CODE__ } only. Simply enter your properties and styling. The CSS will automatically be assigned to the body. Also do not create any CSS for other parts of the Bio Page.') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 rounded border">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold d-block"><?php ee('Button Color') ?></label>
                            <input type="text" name="buttoncolor" id="buttoncolor" value="<?php echo $theme->data->buttoncolor ?? '' ?>">
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold d-block"><?php ee('Button Text Color') ?></label>
                            <input type="text" name="buttontextcolor" id="buttontextcolor" value="<?php echo $theme->data->buttontextcolor ?? '' ?>">
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
                    </div>
                    <button type="submit" class="btn btn-success mt-3"><?php ee('Save Theme') ?></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <div id="preview">
            <div class="card rounded-4 border border-5 border-rounded border-dark card-preview position-relative p-5">
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