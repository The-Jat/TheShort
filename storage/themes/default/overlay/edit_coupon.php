<div class="d-flex">
	<i class="icon-45" data-feather="<?php echo $icon ?>" data-bs-toggle="tooltip" title="<?php echo $name ?>"></i>
	<div class="ms-3">
		<h1 class="h3 mb-2 fw-bold"><?php echo $overlay->name ?></h1>
		<p class="text-muted mb-4"><?php echo $description ?></p>
	</div>
</div>
<div class="row">
    <div class="col-md-8">
		<form method="post" action="<?php echo route("overlay.update", [$overlay->id]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off" class="mb-2">	
			<div class="card rounded-4 shadow-sm">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control p-2" name="name" id="name"  placeholder="e.g. Promo" value="<?php echo $overlay->name ?>" data-required="true">
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="coupon" class="form-label fw-bold"><?php ee("Coupon Code") ?></label>
								<input type="text" class="form-control p-2" name="coupon" id="coupon"  placeholder="e.g. SAVE20" value="<?php echo $overlay->data->coupon ?>">
							</div>								
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12">
							<div class="form-group">
								<label for="message" class="form-label fw-bold"><?php ee("Custom Message") ?> (Max: 140 chars)</label>
								<textarea name="message" id="message" cols="30" rows="5" class="form-control p-2" placeholder="e.g. <?php ee("Get a $10 discount with any purchase more than $50") ?>"><?php echo $overlay->data->message ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label for="text" class="form-label fw-bold"><?php ee("Button Text") ?></label>
								<input type="text" class="form-control p-2" name="text" id="text"  placeholder="e.g. <?php ee("Copy") ?>" value="<?php echo $overlay->data->text ?>">
							</div>	
						</div>
					</div>					
				</div>
			</div>
			<div class="card rounded-4 shadow-sm">
				<div class="card-header bg-transparent mt-2">					
					<a href="" data-bs-toggle="collapse" role="button" data-bs-target="#custom"><h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <span class="align-middle"><?php ee('Appearance Customization') ?></span></h5></a>
				</div>				
				<div class="card-body collapse" id="custom">					
					<div class="row">						
						<div class="col-md-6">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="bg"><?php ee("Overlay Background Color") ?></label> <br>
								<input type="text" name="bg" id="bg" value="<?php echo $overlay->data->bg ?>">
							</div>			
						</div>	
						<div class="col-md-6">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="color"><?php ee("Overlay Text Color") ?></label><br>
								<input type="text" name="color" id="color" value="<?php echo $overlay->data->color ?>">
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="btnbg"><?php ee("Button Background Color") ?></label><br>
								<input type="text" name="btnbg" id="btnbg" value="<?php echo $overlay->data->btnbg ?>">
							</div>		
						</div>
						<div class="col-md-6">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="btncolor"><?php ee("Button Text Color") ?></label><br>
								<input type="text" name="btncolor" id="btncolor" value="<?php echo $overlay->data->btncolor ?>">
							</div>					
						</div>
					</div>				
					<div class="form-group">
						<label class="form-label fw-bold d-block" for="position"><?php ee("Overlay Position") ?></label>
						<select name="position" id="position" class="form-control p-2" data-toggle="select">                        
							<option value="bl"<?php echo $overlay->data->position == 'bl' ? 'selected' : '' ?>><?php ee("Bottom Left") ?></option>
							<option value="br"<?php echo $overlay->data->position == 'br' ? 'selected' : '' ?>><?php ee("Bottom Right") ?></option> 
						</select>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee("Update") ?></button>
		</form>
    </div>
    <div class="col-md-4">
        <div class="position-sticky" id="main-overlay">
            <div class="contact-box mx-0 d-block w-100 mt-0" style="color:<?php echo $overlay->data->color ?>;background-color:<?php echo $overlay->data->bg ?> !important">
                <p class="custom-text" style="color:<?php echo $overlay->data->color ?>"><?php echo $overlay->data->message ?></p>
                <div class="d-flex align-items-center border rounded bg-white p-1">
                    <div>                         
                        <h4 class="mx-2 mb-0" style="color: <?php echo $overlay->data->btnbg ?>"><?php echo $overlay->data->coupon ?></h4>
                    </div>		
                    <div class="ms-auto">
                        <button type="button" class="btn btn-dark btn-lg" style="color:<?php echo $overlay->data->btncolor ?>;background-color:<?php echo $overlay->data->btnbg ?> !important"><?php echo $overlay->data->text ?></button>
                    </div>
                </div>															
            </div>
        </div>		
    </div>
</div>