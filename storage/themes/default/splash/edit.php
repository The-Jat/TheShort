<div class="d-flex align-items-center mb-5">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Update a Custom Splash') ?></h1>
    <div class="ms-auto">
        <a href="#previewModal" data-bs-toggle="modal" class="btn btn-success rounded-3 px-3 py-2"><?php ee('Preview') ?></a>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
		<form method="post" action="<?php echo route("splash.update", [$splash->id]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off">		
			<div class="card rounded-4 shadow-sm">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row mb-3">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control p-2" name="name" id="name"  placeholder="e.g. Promo" value="<?php echo $splash->name ?>" data-required="true">
							</div>	
						</div>
                        <div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="counter"><?php ee("Counter") ?></label>
								<input type="text" class="form-control p-2" name="counter" id="counter"  placeholder="e.g. 15" value="<?php echo $splash->data->counter ?? '' ?>">
							</div>	
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label fw-bold" for="product"><?php ee('Link to Product') ?></label>
                                <input type="text" class="form-control p-2" name="product" id="product" value="<?php echo $splash->data->product ?>" placeholder="e.g. http://domain.com/">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label class="form-label fw-bold" for="title"><?php ee('Custom Title') ?></label>
                                <input type="text" class="form-control p-2" name="title" id="title" value="<?php echo $splash->data->title ?>" placeholder="e.g. <?php ee("Get a $10 discount") ?>">
                            </div>
                        </div>
                    </div>
					<div class="row mb-3 align-items-end">
                        <div class="col-md-6 mb-4">
                            <div class="form-group mb-3 mb-4">
                                <div class="mb-2">
                                    <label for="avatar" role="button" class="d-block">
                                        <img src="<?php echo uploads($splash->data->avatar) ?>" width="100" class="rounded-3 border shadow-sm" id="avatar-preview">
                                    </label>
                                </div>
                                <div>
                                    <label for="avatar" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2">
                                        <?php ee('Upload Avatar') ?>
                                    </label>
                                    <p class="form-text"><?php ee('Avatar must be one the following formats {f} and be less than {s}kb.', null, ['f' => config('extensions')->splash->avatar, 's' => config('sizes')->splash->avatar]) ?></p>
                                    <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*" data-auto-crop data-max-size="<?php echo config('sizes')->splash->avatar ?>" data-allowed-extensions="<?php echo config('extensions')->splash->avatar ?>" data-preview-selector="#avatar-preview" data-error="<?php ee('Avatar must be the one of the following formats and size: {f} - {s}kb.', null, ['f' => config('extensions')->splash->avatar, 's' => config('sizes')->splash->avatar]) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group mb-3 mb-4">
                                <div class="mb-2">
                                    <label for="banner" role="button" class="d-block">
                                        <img src="<?php echo uploads($splash->data->banner) ?>" class="w-100 rounded-3 border shadow-sm" id="banner-preview">
                                    </label>
                                </div>
                                <div>
                                    <label for="banner" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2">
                                        <?php ee('Upload Banner') ?>
                                    </label>
                                    <p class="form-text"><?php ee("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => config('extensions')->splash->banner, 's' => config('sizes')->splash->banner]) ?></p>
                                    <input type="file" name="banner" id="banner" class="d-none" accept="image/*" data-auto-crop data-ratio="16:7" data-max-size="<?php echo config('sizes')->splash->banner ?>" data-allowed-extensions="<?php echo config('extensions')->splash->banner ?>" data-preview-selector="#banner-preview" data-error="<?php ee("The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb.", null, ['f' => config('extensions')->splash->banner, 's' => config('sizes')->splash->banner]) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label class="form-label fw-bold" for="message"><?php ee('Custom Message') ?></label>
                            <textarea name="message" id="message" cols="30" rows="5" class="form-control p-2" placeholder="e.g. <?php ee("Get a $10 discount with any purchase more than $50") ?>"><?php echo $splash->data->message ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2"><?php ee("Update") ?></button>
				</div>
			</div>
		</form>
    </div>    
</div>
<div class="modal fade" id="previewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">        
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fw-bold"><?php ee('Preview') ?></h5>
            <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
        </div>        
        <div class="mb-3 p-2">
            <img src="<?php echo uploads($splash->data->banner) ?>" class="rounded w-100">
            <div class="d-flex align-items-center">
                <div>
                    <img src="<?php echo uploads($splash->data->avatar) ?>" height="100" class="rounded">
                </div>
                <div class="ms-3 py-2">
                    <strong><?php echo $splash->data->title ?></strong>
                    <p class="mt-2"><?php echo $splash->data->message ?></p>
                    <p><a href="<?php echo $splash->data->product ?>" rel="nofollow" target="_blank" class='btn btn-primary btn-sm'><?php ee('View site') ?></a></p>
                </div>
            </div> 
        </div> 
    </div>
  </div>
</div>