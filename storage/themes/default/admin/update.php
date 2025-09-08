<h1 class="h3 mb-5 fw-bold"><?php ee('Automatic Updater') ?></h1>
<div class="row">
    <div class="col-md-7">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <?php if($update): ?>
                    <h5 class="card-title fw-bold mb-5"><?php ee('New update available') ?></h5>
                    <div class="p-3 my-3 bg-default border rounded">
                        <p class="mb-2"><strong>v<?php echo $update ?> - <?php echo $changes[0]->date ?></strong></p>
                        <?php foreach ($changes as $change): ?>
                            <p class="mb-2"><span class="badge bg-<?php echo $change->class ?> me-2"><?php echo $change->type ?></span>  <?php echo $change->title ?><?php echo $change->description ? " <br><small>{$change->description}</small>" : "" ?></p>
                        <?php endforeach ?>
                    </div>
                    <p><?php ee('You can use this tool to automatically update this script. To be safe, we recommend you backup your site regularly. You will need your purchase code to update automatically. You can find your purchase key in the downloads section of codecayon. Also please note that this updater will replace all files. This means all of your custom changes will be overwritten.') ?></p>
                    <p>
                        <ul class="list-unstyled">
                            <?php if(!in_array('curl', get_loaded_extensions())): ?>
                                <li class="mb-2"><i class="me-2 text-danger" data-feather="x-circle"></i>cURL library is not available. Please update manually.</li>
                            <?php else: ?>
                                <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>cURL library is available.</li>
                            <?php endif ?>
                            <?php if(!class_exists("ZipArchive", false)): ?>
                                <li class="mb-2"><i class="me-2 text-danger" data-feather="x-circle"></i>ZipArchive library is not available. Please update manually or enable/install php-zip.</li>
                            <?php else: ?>
                                <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>ZipArchive library is available.</li>
                            <?php endif ?>
                            <?php if(!is_writable(ROOT)): ?>
                                <li class="mb-2"><i class="me-2 text-danger" data-feather="x-circle"></i>Document root is not writable.</li>
                            <?php else: ?>
                                <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>Document root is writable.</li>
                            <?php endif ?>
                        </ul>                   
                    </p>
                    <form action="<?php echo route('admin.update.process') ?>" method="post" class="mt-5">
                        <?php echo csrf() ?>
                        <div class="form-group mb-4">
                            <label for="code" class="form-label fw-bold"><?php ee('Purchase Code') ?></label>
                            <input type="text" class="form-control p-2" id="code" name="code" placeholder="Envato Purchase Code"  value="<?php echo config('purchasecode') ?>" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#updating"><?php ee('Update') ?></button>
                    </form>                
                <?php else: ?>
                    <h5 class="card-title fw-bold"><?php ee('No update available') ?></h5>
                    <p><?php ee('When a new update is available, you will see a notification in the sidebar and in the top menu. Please make sure you have enabled update notification in the admin') ?> <a href="<?php echo route('admin.settings.config', ['app']) ?>"><u><?php ee('settings') ?></u></a>.</p>
                <?php endif ?>
            </div>
        </div>
    </div> 
    <div class="col-md-5">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Script Information') ?></div>
            <div class="card-body">             
                <div class="p-2 border rounded-3 mb-3">
                    <div class="d-flex mb-2">
                        <div>
                            <strong><?php ee('Current Script Version') ?>:</strong> <?php echo config('version') ?>
                        </div>
                        <form action="<?php echo route('admin.update.process') ?>" method="post" class="ms-auto">
                            <?php echo csrf() ?>
                            <input type="hidden" class="form-control p-2" id="code" name="code" placeholder="Envato Purchase Code"  value="<?php echo config('purchasecode') ?>" autocomplete="off">
                            <button type="submit" class="btn badge bg-primary text-white rounded" data-bs-toggle="modal" data-bs-target="#updating"><?php ee('Re-Update') ?></button>
                        </form> 
                    </div>
                    <div class="d-flex">
                        <div>
                            <strong><?php ee('Current PHP Version') ?>:</strong> <?php echo phpversion() ?> 
                        </div>
                        <div class="ms-auto">
                            <a href="<?php echo route('admin.phpinfo') ?>" class="badge bg-primary text-white" target="_blank"><?php ee('View PHP Info') ?></a>
                        </div>
                    </div>                    
                </div>
                <div class="p-2 border rounded-3">
                    <div class="d-flex mb-3">
                        <div>
                            <strong><?php ee('Last Update Released') ?>:</strong> <?php echo $changes ? $changes[0]->date : 'na' ?>
                        </div>
                        <div class="ms-auto">
                            <a href="https://gempixel.com/changelog/premium-url-shortener" class="badge bg-primary text-white" target="_blank"><?php ee('View Changelog') ?></a>
                        </div>
                    </div>
                    <p class="mb-0"><strong><?php ee('Envato Purchase Code') ?>: </strong> <?php echo config('purchasecode') ?></p>
                </div>
            </div>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('License Information') ?></div>      
            <div class="card-body">             
                <p><?php ee('Enter your purchase code to receive automated updates and access our plugin directory.') ?></p>
                <?php if(config('purchasecode') && $license = \Helpers\App::license()): ?> 
                    <span class="mb-2 d-block fw-bold"><?php ee('License Type') ?>: <?php echo $license->type ?></span>
                    <?php if($license->type == 'Regular License'): ?>
                        <p class="p-2 border rounded-3"><a href="https://gemp.me/BuySaaS" class="text-success">Upgrade to the Extended License and start charging your customers, create vouchers, coupons and more.</a></p>
                    <?php endif ?>
                    <span class="mb-4 d-block fw-bold"><?php ee('Support Until') ?>: <?php echo \Core\Helper::dtime($license->support, 'F d, Y') ?> <?php echo strtotime('now') > strtotime($license->support) ? '<small class="float-end text-danger">Expired</small>' : '' ?></span>
                <?php endif ?>
                <form method="post">
                    <div class="form-group">
                        <label class="form-label fw-bold"><?php ee('Envato Purchase Code') ?></label>
                        <input class="form-control p-2" name="newcode" placeholder="Envato Purchase Code" value="<?php echo config("purchasecode") ?>">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save') ?></button>
                </form>
            </div>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Join the Community') ?></div>            
            <div class="card-body">
                <p><?php ee('Follow us on social media and be the first to benefit from news related to this product, new plugins and releases.') ?></p>
                <span class="text-primary mb-2 d-block"><i data-feather="twitter"></i> <a href="https://x.com/kbrmedia" target="_blank" class="text-primary">Follow us on X</a></span>
                <span class="text-success mb-2 d-block"><i data-feather="mail"></i> <a href="https://gempixel.com/subscribe" target="_blank" class="text-success">Join our newsletter</a></span>
            </div>
        </div>
    </div>  
</div>
<div class="modal fade" id="updating" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Updating" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><span class="preloader me-2"><span class="spinner-border spinner-border-sm" role="status"></span></span> <?php ee('Updating...') ?> </h5>
            </div>
            <div class="modal-body">
                <p><?php ee("Updating script, please hold. Please do not close this page or press update again. The page will refresh once it is done.") ?></p>
            </div>
        </div>
    </div>
</div>