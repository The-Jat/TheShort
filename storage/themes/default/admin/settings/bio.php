<h1 class="h3 mb-5 fw-bold"><?php ee('Bio Page Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>                                        
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold"><?php ee('Widgets Block List') ?></label>
                        <p><?php ee('By default all widgets are available. If you want to disable some widgets, you can disable them below.') ?></p>
                        <div class="row">
                            <?php foreach(\Helpers\BioWidgets::widgets(null, null, true) as $id => $widget): ?>
                                <div class="col-md-3 mb-3">
                                    <label class="border rounded rounded-4 p-2 py-4 text-center d-block cursor-pointer position-relative h-100">
                                        <div class="position-absolute top-0 start-0 ms-2 mt-2">
                                            <input type="checkbox" name="bio[blocked][]" value="<?php echo $id ?>" <?php echo config('bio')->blocked && in_array($id, config('bio')->blocked) ? 'checked' : '' ?>>
                                        </div>
                                        <div><?php echo $widget['icon'] ?></div>
                                        <div class="from-label ms-2 mt-3"><?php echo $widget['title'] ?></div>
                                        <p class="form-text mt-0 mb-0"><?php echo $widget['description'] ?></p>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div> 
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>