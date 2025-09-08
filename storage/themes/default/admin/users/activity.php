<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('admin.users') ?>"><?php ee('Users') ?></a></li>
	</ol>
</nav>
<div class="d-flex mb-5 align-items-center">
	<h1 class="h3 mb-0 fw-bold"><?php ee('Activity Logs') ?></h1>
    <div class="ms-auto">
		<a href="<?php echo route('admin.users.loginsclear', \Core\Helper::nonce('login.clear')) ?>" class="btn btn-danger rounded-3 px-3 py-2" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><?php ee('Clear Logs') ?></a>
	</div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
	<div class="table-responsive">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th><?php ee('Email') ?></th>
                    <th><?php ee('Type') ?></th>
					<th><?php ee('Logged Details') ?></th>
					<th><?php ee('Date') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($events as $event): ?>
					<tr>
						<td>							
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $event->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <?php echo ($event->user->admin)?"<strong>{$event->user->email}</strong>":$event->user->email ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if($event->type == '2fa'): ?>
                                <span class="badge bg-danger text-white"><?php ee('Failed') ?> 2FA</span>
                            <?php else: ?>
                                <span class="badge bg-success text-white"><?php echo e($event->type) ?></span>
                            <?php endif ?>                            
                        </td>
                        <td width="50%">
                            <?php if($event->data->country): ?>
                                <span class="text-start d-inline-block">
                                    <img src="<?php echo \Helpers\App::flag($event->data->country) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->country) ?>">
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->city ? ucfirst($event->data->city).',': e('Somewhere from') ?> <?php echo ucfirst($event->data->country) ?></span>
                                </span>
                            <?php endif ?>
                            <?php if($event->data->os): ?>
                                <span class="text-start d-inline-block">
                                    <img src="<?php echo \Helpers\App::os($event->data->os) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->os) ?>">
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->os ?></span>
                                </span>
                            <?php endif ?>
                            <?php if($event->data->browser): ?>
                                <span class="text-start d-inline-block">
                                    <img src="<?php echo \Helpers\App::browser($event->data->browser) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->browser) ?>">
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->browser ?></span>
                                </span>
                            <?php endif ?>
                            <?php if($event->data->ip): ?>
                                <span class="text-start d-inline-block">
                                    <span data-feather="globe"></span>
                                    <span class="mr-3 me-3 align-middle"><?php echo $event->data->ip ?></span>
                                </span>
                            <?php endif ?>
                            <?php if(isset($event->data->social) && $event->data->social): ?>
                                <span class="text-start d-inline-block">
                                    <span data-feather="share-2"></span>
                                    <span class="mr-3 align-middle"><?php echo ucwords($event->data->social) ?></span>
                                </span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php echo $event->created_at ?>
                        </td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<div class="mt-4 d-block">
	<?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
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
		<a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
	  </div>
	</div>
  </div>
</div>