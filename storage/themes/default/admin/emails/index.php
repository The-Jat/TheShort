<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Email Templates') ?></li>
  </ol>
</nav>
<div class="d-flex align-items-center mb-5">
	<h1 class="h3 mb-0 fw-bold"><?php ee('Email Templates') ?></h1>
	<div class="ms-auto">
		<a href="<?php echo route("admin.email.template.new") ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Create Translation') ?></a>
	</div>
</div>
<div class="row">
	<div class="col-md-9">
		<div class="card rounded-4 shadow-sm">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th><?php ee('Name') ?></th>
							<th><?php ee('Code') ?></th>
							<th><?php ee('Last Update') ?></th>
							<th><?php ee('% Translated') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($languages as $language): ?>
							<tr>
								<td><?php echo $language["name"] ?> <?php echo config('default_lang') && config('default_lang') == $language["code"] ? '<span class="badge bg-primary">Default</span>': '' ?></td>
								<td><?php echo $language["code"] ?></td>
								<td><?php echo $language["date"] ?></td>
								<td>
									<div class="progress">
										<div class="progress-bar" role="progressbar" style="width: <?php echo $language["percent"] ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $language["percent"] ?>%</div>
									</div>
								</td>
								<td class="d-flex">
									<button type="button" class="btn btn-default bg-white ms-auto" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
									<ul class="dropdown-menu">										
										<li><a class="dropdown-item" href="<?php echo route('admin.email.template.edit', [$language["code"]]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
										<li><hr class="dropdown-divider"></li>
										<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.email.template.delete', [$language["code"], \Core\Helper::nonce('template.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
									</ul>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card rounded-4 card-default">			
			<div class="card-body">
				<h5 class="fw-bold mb-3"><?php ee('Emails') ?></h5>
				<p><?php ee('You can now translate emails so your user receive emails in their preferred language. If you want to change the default emails, you need to create a translation and use the code "en" to overwrite the current email templates.') ?></p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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