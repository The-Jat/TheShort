<h1 class="h3 mb-5 fw-bold"><?php ee('QR Settings') ?></h1>
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
                            <label for="publicqr" class="mb-0 form-label fw-bold"><?php ee('Public QR Generator') ?></label>
                            <p class="form-text my-0"><?php ee('If enabled, users will be able to generate static QR codes on the QR Code feature page.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="publicqr" name="publicqr" value="1" <?php echo config("publicqr") ? 'checked':'' ?>>
                        </div>                        
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="imagemagick" class="mb-0 form-label fw-bold"><?php ee('Use ImageMagick') ?></label>
                            <?php if(extension_loaded('imagick')){
                                $imagick = new \Imagick();
                                echo '<span class="text-danger">ImageMagick version: ' . $imagick->getVersion()['versionString'].'</span>';
                            } else {
                                echo '<span class="text-danger">ImageMagick is not installed</span>';
                            }
                            ?>
                            <p class="form-text my-0"><?php ee('If your server does not have the correct ImageMagick version + RSVG, you will need to disable this feature.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="imagemagick" name="imagemagick" value="1" <?php echo config("imagemagick") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="qrlogo" class="form-label fw-bold"><?php ee('QR Code Logo') ?></label>
                        <?php if(!empty(config("qrlogo"))):  ?>
                            <p><img src="<?php echo \Helpers\QR::factory('Sample QR', 400, 0)->withLogo(PUB.'/content/'.config('qrlogo'), 100)->format('svg')->create('uri') ?>" height="350" alt="" class="rounded"></p>
                        <?php endif ?>					    	
                        <input type="file" name="qrlogo_path" id="qrlogo" class="form-control mb-2">
                        <?php if(!empty(config("qrlogo"))):  ?>
                            <p class="form-text"><a href="#" id="remove_qrlogo" data-trigger="removeimage" class="btn btn-danger btn-sm"><?php ee('Remove Logo') ?></a></p>
                        <?php endif ?>
                        <p class="form-text"><?php ee('Set a default QR code logo for free users and anonymous users. Logo must be square with a recommended size of 500x500 and PNG format.') ?></p>
                    </div> 
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>