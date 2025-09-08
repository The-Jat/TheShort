<div class="d-flex">
	<i class="icon-45" data-feather="<?php echo $icon ?>" data-bs-toggle="tooltip" title="<?php echo $name ?>"></i>
	<div class="ms-3">
		<h1 class="h3 mb-2 fw-bold"><?php echo $name ?></h1>
		<p class="text-muted mb-4"><?php echo $description ?></p>
	</div>
</div>
<div class="row">
    <div class="col-md-8">
		<form method="post" action="<?php echo route("overlay.save", [$type]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off" class="mb-3">		
			<div class="card rounded-4 shadow-sm">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control p-2" name="name" id="name"  placeholder="e.g. Promo" value="" data-required="true">
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="label"><?php ee("Form Label") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control p-2" name="label" id="label"  value="" placeholder="<?php ee("e.g. Need help?") ?>">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="content"><?php ee("Form Description") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input class="form-control p-2" name="content" id="content" placeholder="<?php ee("(optional) Provide a description or anything you want to add to the form.") ?>" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="success"><?php ee("Thank You Message") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control p-2" name="success" id="success"  value="" placeholder="<?php ee("e.g. Thank you.") ?>">
							</div>
						</div>
					</div>
					<div class="form-group mb-3">
						<label class="form-label fw-bold" for="disclaimer"><?php ee("Disclaimer") ?> <small><?php ee("leave empty to disable") ?></small></label>
						<textarea class="form-control p-2" name="disclaimer" id="disclaimer" placeholder=""></textarea>
						<p class="form-text"><?php ee('You can add your own disclaimer and a checkbox will show up requiring users to check before submitting.') ?></p>
					</div>
					<hr>
					<div class="form-group mb-3">
						<label class="form-label fw-bold" for="webhook"><?php ee("Webhook Notification") ?></label><br>
						<input type="text" name="webhook" id="webhook" class="form-control p-2" placeholder="e.g. https://domain.com/path/to/webhook-receiver">
						<p class="form-text"><?php ee("If you want to receive a notification directly to your app, add the url to your app's handler and as soon as there is a submission, we will send a notification to this url as well as an email to the address provided above.") ?></p>
					</div>
				</div>
			</div>
			<div class="card rounded-4 shadow-sm">
				<div class="card-header bg-transparent mt-2">
					<a href="" data-bs-toggle="collapse" role="button" data-bs-target="#textlabels"><h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <span class="align-middle"><?php ee('Text Labels') ?></span></h5></a>
				</div>				
				<div class="card-body collapse" id="textlabels">				
					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="button-p"><?php ee("Button") ?></label>
								<input type="text" class="form-control p-2" name="button" id="button-p" value="<?php ee('Subscribe') ?>">
								<p class="form-text"><?php ee("If you want to use a different language, change these.") ?></p>
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
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="bg"><?php ee("Overlay Background Color") ?></label> <br>
								<input type="text" name="bg" id="bg">
							</div>			
						</div>	
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="color"><?php ee("Overlay Text Color") ?></label><br>
								<input type="text" name="color" id="color">
							</div>	
                        </div>						
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="btnbg"><?php ee("Button Background Color") ?></label><br>
								<input type="text" name="btnbg" id="btnbg">
							</div>		
						</div>
						<div class="col-md-4">
							<div class="form-group mb-5">
								<label class="form-label fw-bold" for="btncolor"><?php ee("Button Text Color") ?></label><br>
								<input type="text" name="btncolor" id="btncolor">
							</div>					
						</div>
					</div>				
					<div class="form-group mb-3">
						<label class="form-label d-block fw-bold" for="position"><?php ee("Overlay Position") ?></label>
						<select name="position" id="position" class="form-control p-2" data-toggle="select">               
							<option value="bl"><?php ee("Bottom Left") ?></option>
							<option value="br" selected><?php ee("Bottom Right") ?></option> 
						</select>
					</div>					
				</div>
			</div>
			<button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee("Create") ?></button>
		</form>
    </div>
    <div class="col-md-4">
        <div class="position-sticky" id="main-overlay">                  
            <div class="contact-box mx-0 d-block w-100 mt-0">
                <h1 class="contact-label"><?php ee('Newsletter') ?></h1>
                <p class="contact-description"><?php ee('Description') ?></p>
                <div class="d-flex align-items-center border rounded bg-white p-1">
                    <div>                         
                        <input type="text" class="form-control border-0" id="contact-email" placeholder="johnsmith@company.com">
                    </div>		
                    <div class="ms-auto">
                        <button type="submit" class="btn btn-dark btn-lg"><?php ee("Subscribe") ?></button>
                    </div>
                </div>	
				<div id="disclaimer-area"></div>
            </div>
        </div>
		<div class="card rounded-4 mt-4">
			<div class="card-header bg-transparent">
				<h5 class="fw-bold"><?php ee("Webhook Notification") ?></h5>
			</div>
			<div class="card-body">
				<p><?php ee("If you add a webhook url, we will send a notification to that url with the form data. You will be able to integrate it with your own app or a third-party app. Below is a sample data that will be sent in <code>JSON</code> format via a <code>POST</code> request.") ?></p>
				<pre class="bg-light p-3 text-break rounded"><?php echo json_encode(['type' => 'newsletter', 'data' => ['email' => 'johnsmith@company.com', 'date' => date('Y-m-d H:i')]], JSON_PRETTY_PRINT) ?></pre>
			</div>
		</div>
    </div>
</div>