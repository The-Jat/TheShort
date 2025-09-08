<h1 class="h3 mb-5 fw-bold"><?php ee('Theme Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>                                        
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="user_history" class="form-label fw-bold mb-0"><?php ee('Anonymous User History') ?></label>
                            <p class="my-0 form-text"><?php ee('If enabled, anonymous users can view their personal history of URLs on the home page.').' '.ee('Please note that some themes might not support this feature') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="user_history" name="user_history" value="1" <?php echo config("user_history") ? 'checked':'' ?>>
                        </div>                        
                    </div>   
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="public_dir" class="form-label fw-bold mb-0"><?php ee('Public URL List') ?></label>
                            <p class="my-0 form-text"><?php ee('Enabling this will display a list of new public URLs on the home page. Only the last 25 URLs will be shown there. If you enable this, some parts of the homepage will be removed.').' '.ee('Please note that some themes might not support this feature') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="public_dir" name="public_dir" value="1" <?php echo config("public_dir") ? 'checked':'' ?>>
                        </div>                        
                    </div> 
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="homepage_stats" class="form-label fw-bold mb-0"><?php ee('Stats on Homepage') ?></label>
                            <p class="my-0 form-text"><?php ee('Enabling this will display stats at the bottom of the homepage.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="homepage_stats" name="homepage_stats" value="1" <?php echo config("homepage_stats") ? 'checked':'' ?>>
                        </div>                        
                    </div> 
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>