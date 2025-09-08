<div class="d-flex mb-5 align-items-center">
	<h1 class="h3 mb-0 fw-bolder"><?php ee('Bio Pages') ?></h1>
	<div class="ms-auto">
		<?php if(user()->teamPermission('bio.create')): ?>
			<a role="button" data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create Bio') ?></a>
		<?php endif ?>
	</div>
</div>
<div class="card rounded-4 p-2 shadow-sm">
	<div class="d-block d-md-flex align-items-center">
		<div class="mb-3 mb-md-0">
			<span class="h3 ms-2"><?php echo $count ?></span> <span class="text-muted"> <?php ee('Bio Pages') ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></span>
			<div class="d-inline-block border-start ms-3 ps-3">
				<span class="h3"><?php echo $views ?></span> <span class="text-muted"><?php ee('views') ?></span>
			</div>
		</div>
		<div class="ms-auto">
			<form action="<?php echo route('bio') ?>" method="get" class="d-flex align-items-center border rounded-3 p-1">
                <div class="me-2">
                    <input type="text" class="form-control border-0 p-2" name="q" value="<?php echo clean(request()->q) ?>" placeholder="<?php ee('Search for {t}', null, ['t' => e('Bio Pages')]) ?>">
                </div>
                <div class="me-2">
                    <div class="input-select d-block">
                        <select name="sort" id="sortable" data-name="sort" class="form-select border-0 border-start p-2 pe-5 rounded-0">
                            <optgroup label="Sort by">
                                <option value=""<?php if(!request()->sort) echo " selected" ?>><?php ee('Newest') ?></option>
                                <option value="old"<?php if(request()->sort == 'old') echo " selected" ?>><?php ee('Oldest') ?></option>
                                <option value="popular"<?php if(request()->sort == 'popular') echo " selected" ?>><?php ee('Popular') ?></option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div>
					<button type="submit" class="btn bg-white py-2 px-3"><i data-feather="search"></i></button>
                </div>
            </form>
		</div>
	</div>
</div>
<?php if($bios): ?>
	<div class="row">
		<?php foreach($bios as $bio): ?>
			<div class="col-md-4 mb-4">
				<div class="card rounded-4 flex-fill shadow-sm h-100">
					<div class="card-body position-relative pb-0">
							<div class="position-absolute end-0">
								<button type="button" class="btn btn-default bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></button>
								<ul class="dropdown-menu">
									<?php if(user()->teamPermission('bio.edit')): ?>
										<li><a class="dropdown-item" href="<?php echo route('bio.edit', [$bio->id]) ?>" class="align-middle"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
									<?php endif ?>
									<li><a class="dropdown-item" href="<?php echo route('stats', [$bio->urlid]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></span></a></li>
									<li><a class="dropdown-item" href="<?php echo $bio->url ?>"><i data-feather="eye"></i> <?php ee('View Bio') ?></a></li>
									<?php if(user()->defaultbio != $bio->id): ?>
									<li><a class="dropdown-item" href="<?php echo route('bio.default', [$bio->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Set as Default') ?></a></li>
									<?php endif ?>
									<?php if(user()->has('qr')): ?>
										<li><a class="dropdown-item" href="<?php echo route('qr.create', ['url' => $bio->url]) ?>"><i data-feather="aperture"></i> <?php ee('Custom QR Code') ?></a></li>
									<?php endif ?>
									<?php if(user()->teamPermission('bio.edit')): ?>
										<li><a class="dropdown-item" href="#" data-id="<?php echo $bio->id ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#channelModal" data-toggle="addtochannel"><i data-feather="package"></i> <?php ee('Add to Channel') ?></a></li>
										<li><a class="dropdown-item" href="<?php echo route('links.reset', [$bio->urlid, \Core\Helper::nonce('link.reset')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#resetModal"><i data-feather="rotate-ccw"></i> <?php ee('Reset Stats') ?></a></li>
										<li><a class="dropdown-item" href="<?php echo route('bio.duplicate', [$bio->id]) ?>"><i data-feather="copy"></i> <?php ee('Duplicate') ?></a></li>
									<?php endif ?>
									<?php if(user()->teamPermission('bio.delete')): ?>
									<li class="dropdown-divider"></li>
									<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('bio.delete', [$bio->id, \Core\Helper::nonce('bio.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
									<?php endif ?>
								</ul>
							</div>
							<div class="text-center">
								<img src="<?php echo $bio->avatar ?>" class="avatar-lg rounded-circle border p-2 m-0" alt=""><br>
								<div class="mt-2">

									<a href="<?php echo $bio->url ?>" target="_blank"><strong><?php echo $bio->name ?: 'n\a' ?></strong></a>
									<div class="mt-1">
										<small class="text-muted fs-6" data-href="<?php echo $bio->url ?>"><?php echo $bio->url ?></small>
										<a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo $bio->url ?>"><small><?php echo e("Copy")?></small></a>
									</div>
								</div>
							</div>
							<div class="border p-2 rounded rounded-4 mt-4">
								<?php echo (user()->defaultbio == $bio->id ? '<span class="badge bg-primary me-2">'.e('Default').'</span>' : '') ?>
								<?php if($bio->status == '0') : ?>
									<span class="badge bg-danger me-2"><?php ee('Disabled') ?></span>
								<?php endif ?>
								<?php if(isset($bio->views)):?>
									<i data-feather="eye"></i> <span class="align-middle ms-1 me-2"><?php echo $bio->views .' '.e('Views') ?></span>
								<?php endif ?>
								<i data-feather="clock"></i> <span class="align-middle ms-1"><?php echo \Core\Helper::timeago($bio->created_at) ?></span>
							</div>
							<?php if($channels = $bio->channels): ?>
								<div class="mt-3">
								<?php foreach($channels as $channel): ?>
                                	<small class="badge text-xs me-2 p-1 px-2 rounded-3 text-white" style="background-color: <?php echo $channel->color ?>!important;"><?php echo $channel->name ?> <a href="<?php echo route('channel.removefrom', [$channel->id, 'bio', $bio->id]) ?>" class="ms-1 text-danger border-start ps-1 text-white" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Remove from channel') ?>"><i data-feather="x"></i></span></a></small>
                            	<?php endforeach ?>
								</div>
							<?php endif ?>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<div class="mt-4 d-block">
		<?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
	</div>
<?php else: ?>
	<div class="card rounded-4 flex-fill shadow-sm">
		<div class="card-body text-center">
			<p><?php ee('No content found. You can create some.') ?></p>
			<?php if(user()->teamPermission('bio.create')): ?>
				<a href="#" data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create Bio') ?></a>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>
<?php if(user()->teamPermission('bio.create')): ?>
<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
	  		<form action="<?php echo route('bio.save') ?>" method="post" data-trigger="server-form">
				<?php echo csrf() ?>
				<div class="modal-header">
					<h5 class="modal-title fw-bold"><?php ee('Create Bio') ?></h5>
					<button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-3">
						<label for="name" class="form-label fw-bolder"><?php ee('Name') ?> <i data-bs-toggle="tooltip" title="<?php ee('A unique name will help you identify your bio page') ?>" class="ms-1 text-muted small fa fa-question-circle"></i></label>
						<input type="text" class="form-control p-2" name="name" id="name" placeholder="e.g. Bio Page" data-min="3" data-error="<?php ee('Please enter a valid name (min 3 characters)') ?>" required>
					</div>
					<div class="row">
						<?php if(count($domains) > 1): ?>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label for="domain" class="form-label fw-bolder"><?php ee('Domain') ?></label>
								<select name="domain" id="domain" class="form-select p-2">
								<?php foreach($domains as $domain): ?>
									<option value="<?php echo $domain ?>"><?php echo $domain ?></option>
								<?php endforeach ?>
								</select>
								<div class="form-text">
									<?php ee('Choose domain to generate the link with') ?>
								</div>
							</div>
						</div>
						<?php endif ?>
						<?php if(user()->has('alias')): ?>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label for="custom" class="form-label fw-bolder"><?php ee('Alias') ?></label>
								<input type="text" class="form-control p-2" name="custom" id="custom" placeholder="e.g. mybio">
								<p class="form-text"><?php ee('Leave this field empty to generate a random alias') ?></p>
							</div>
						</div>
						<?php endif ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
					<button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Create') ?></a>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif ?>
<?php if(user()->teamPermission('bio.delete')): ?>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title fw-bold"><?php ee('Are you sure you want to delete this?') ?></h5>
		<button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
	  </div>
	  <div class="modal-body">
		<p><?php ee('You are trying to delete a record. This action is permanent and cannot be reversed.') ?></p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
		<a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title fw-bold"><?php ee('Are you sure you want to reset this?') ?></h5>
		<button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
	  </div>
	  <div class="modal-body">
		<p><?php ee('You are trying to reset all statistic data for this link. This action is permanent and cannot be reversed.') ?></p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
		<a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
	  </div>
	</div>
  </div>
</div>
<?php endif ?>
<div class="modal fade" id="channelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
	  <form action="<?php echo route('channel.addto', ['bio', null]) ?>" data-trigger="server-form">
		<?php echo csrf() ?>
		<div class="modal-header">
			<h5 class="modal-title fw-bold"><?php ee('Add to Channels') ?></h5>
			<button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
		</div>
		<div class="modal-body">
			<label for="channels" class="form-label d-block mb-2"><?php ee('Channels') ?></label>
			<div class="form-group rounded input-select">
				<select name="channels[]" id="channels" class="form-control" multiple data-toggle="select">
					<?php foreach(\Core\DB::channels()->where('userid', user()->rID())->findArray() as $channel): ?>
						<option value="<?php echo $channel['id'] ?>"><?php echo $channel['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<input type="hidden" name="channelids" id="channelids" value="">
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
			<button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal" data-trigger="addtocampaign"><?php ee('Add') ?></button>
		</div>
	  </form>
	</div>
  </div>
</div>