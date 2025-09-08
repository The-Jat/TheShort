<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo route('admin.qr') ?>"><?php ee('QR Codes') ?></a></li>
    </ol>
</nav>	
<div class="d-flex mb-5 align-items-center">
	<h1 class="h3 mb-0 fw-bold"><?php ee('QR Code Template Manager') ?></h1>
	<div class="ms-auto">
		<a href="" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#newModal"  class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Create Template') ?></a>
	</div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
	<div class="table-responsive">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th width="20%"></th>
					<th><?php ee('Name') ?></th>
					<th><?php ee('Status') ?></th>
					<th><?php ee('Availability') ?></th>
					<th><?php ee('Created on') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($templates as $template): ?>
					<tr>
						<td>
							<img src="<?php echo uploads($template->filename, 'qr') ?>" width="150" class="rounded">
						</td>
						<td><?php echo $template->name ?></td>
						<td><?php echo ($template->status ? '<span class="badge bg-success">'.e('Active').'</span>':'<span class="badge bg-danger">'.e('Not Active').'</span>') ?></td>                
						<td>
							<?php if($template->paidonly == -1): ?>
								<span class="badge bg-primary"><?php ee('Everyone') ?></span>
							<?php elseif($template->paidonly == 0): ?>
								<span class="badge bg-success"><?php ee('Premium Users Only') ?></span>
							<?php else: ?>
								<?php $plan = \Core\DB::plans()->where('id', $template->paidonly)->first(); ?>
								<span class="badge bg-info"><?php echo $plan->name ?> (<?php echo $plan->free ? e('Free') : e('Paid') ?>)</span>
							<?php endif ?>
						<td><?php echo date("F d, Y",strtotime($template->created_at)) ?></td>						
						<td>
							<button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="<?php echo route('admin.qr.template.edit', [$template->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.qr.template.delete', [$template->id, \Core\Helper::nonce('template.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>                                
							</ul>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?php echo pagination('pagination') ?>
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
<div class="modal fade" id="newModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title fw-bold"><?php ee('Create Template') ?></h5>
		<button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
	  </div>
      <form action="<?php echo route('admin.qr.template.save') ?>" method="post">
        <?php echo csrf() ?>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label fw-bold"><?php ee('Template Name') ?></label>
                <input type="text" class="form-control p-2" name="name" placeholder="e.g. Modern QR">
            </div>
            <div class="form-group mt-3">
                <label class="form-label fw-bold"><?php ee('Template Description') ?></label>
                <input type="text" class="form-control p-2" name="description">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Create') ?></button>
        </div>    
      </form>
    </div>
  </div>
</div> 