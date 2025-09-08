<div class="d-flex">
	<i class="icon-45" data-feather="<?php echo $icon ?>" data-bs-toggle="tooltip" title="<?php echo $name ?>"></i>
	<div class="ms-3">
		<h1 class="h3 mb-2 fw-bold"><?php echo $name ?></h1>
		<p class="text-muted mb-4"><?php echo $description ?></p>
	</div>
</div>
<div class="row">
    <div class="col-md-8">
		<form method="post" action="<?php echo route("overlay.save", [$type]) ?>" enctype="multipart/form-data" id="settings-form" autocomplete="off" class="mb-2">		
			<div class="card rounded-4 shadow-sm">
				<div class="card-body">
                    <?php echo csrf() ?>
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="name"><?php ee("Name") ?></label>
								<input type="text" class="form-control p-2" name="name" id="name"  placeholder="e.g. Poll" value="" data-required="true">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="subject"><?php ee("Question") ?></label>
								<input type="text" class="form-control p-2" name="question" id="question" value="" placeholder="<?php ee('e.g. What is your favorite color?') ?>" data-required="true">
							</div>
						</div>						
					</div>
                    <hr>
                    <h4><?php ee("Options") ?> <small>(max 10)</small></h4>
					<p><?php ee("You can add up to 10 options for each poll. To add an extra option click Add Option above. To ignore a field, leave it empty.") ?></p>
					<div class="poll-options">
						<div class="form-group mb-2">
							<input type="text" class="form-control p-2" name="answer[]" placeholder="#1" data-id="1">
						</div>	
						<div class="form-group mb-2">
							<input type="text" class="form-control p-2" name="answer[]" placeholder="#2" data-id="2">
						</div>
					</div>
                    <a href="#" data-trigger="addpollchoice" class='btn btn-sm btn-primary'><?php ee("Add Option") ?></a>
				</div>
			</div>
			<div class="card rounded-4 shadow-sm">
				<div class="card-header bg-transparent mt-2">
					<a href="" data-bs-toggle="collapse" role="button" data-bs-target="#textlabels"><h5 class="card-title fw-bold"><i data-feather="plus-circle" class="me-2"></i> <span class="align-middle"><?php ee('Text Labels') ?></span></h5></a>
				</div>				
				<div class="card-body collapse" id="textlabels">				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="votetext"><?php ee("Vote Button Placeholder") ?></label>
								<input type="text" class="form-control p-2" name="votetext" id="votetext" value="<?php ee('Vote') ?>">
							</div>							
						</div>	
                        <div class="col-md-6">
							<div class="form-group mb-3">
								<label class="form-label fw-bold" for="thankyou"><?php ee("Thank You Message") ?> <small><?php ee("leave empty to disable") ?></small></label>
								<input type="text" class="form-control p-2" name="thankyou" id="thankyou" placeholder="<?php ee('Thanks...') ?>">
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
						<label class="form-label fw-bold d-block" for="position"><?php ee("Overlay Position") ?></label>
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
            <div class="poll-box mt-0">
                <p class="poll-question"><?php ee("Your question here?") ?></p>
                <ol class="poll-answers">
                    <li data-id="1">#1</li>
                    <li data-id="2">#2</li>
                </ol>
                <button type="submit" class="poll-btn" data-trigger="vote"><?php ee("Vote") ?></button>
            </div>
        </div>		
    </div>
</div>