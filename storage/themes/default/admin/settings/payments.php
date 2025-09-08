<h1 class="h3 mb-5 fw-bold"><?php ee('Payment Gateway') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">                
        <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <?php echo call_user_func($paypal['settings']) ?>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>                        
            </div> 
        </form>  
        <?php if(\Helpers\App::possible()): ?>
            <?php foreach($processors as $name => $processor): ?>
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="card rounded-4 shadow-sm">
                        <div class="card-body">
                            <?php echo call_user_func($processor['settings']) ?>
                            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                        </div>                        
                    </div>
                </form>
            <?php endforeach ?>
        <?php else: ?>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <?php view('admin.partials.extended') ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>