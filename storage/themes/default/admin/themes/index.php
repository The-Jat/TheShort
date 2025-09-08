<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo route('admin.bio') ?>"><?php ee('Bio Pages') ?></a></li>
    </ol>
</nav>	
<div class="d-flex mb-5 align-items-center">
	<h1 class="h3 mb-0 fw-bold"><?php ee('Bio Page Theme Manager') ?></h1>
	<div class="ms-auto">
		<a href="" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#newModal"  class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Create Theme') ?></a>
	</div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
	<div class="table-responsive">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th><?php ee('Name') ?></th>
					<th><?php ee('Status') ?></th>
					<th><?php ee('Availability') ?></th>
					<th><?php ee('Created on') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($themes as $theme): ?>
					<tr>
						<td class="fw-bold"><?php echo $theme->name ?></td>
						<td><?php echo ($theme->status ? '<span class="badge bg-success">'.e('Active').'</span>':'<span class="badge bg-danger">'.e('Not Active').'</span>') ?></td>                
						<td><?php echo ($theme->paidonly ? '<span class="badge bg-success">'.e('Premium Users Only').'</span>':'<span class="badge bg-primary">'.e('Everyone').'</span>') ?></td>                
						<td><?php echo date("F d, Y",strtotime($theme->created_at)) ?></td>						
						<td>
							<button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="<?php echo route('admin.bio.theme.edit', [$theme->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.bio.theme.delete', [$theme->id, \Core\Helper::nonce('theme.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>                                
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
		<a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="newModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title fw-bold"><?php ee('Create Theme') ?></h5>
		<button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
	  </div>
      <form action="<?php echo route('admin.bio.theme.save') ?>" method="post">
        <?php echo csrf() ?>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label fw-bold"><?php ee('Theme Name') ?></label>
                <input type="text" class="form-control p-2" name="name" placeholder="e.g. Blue Theme">
            </div>
            <div class="form-group mt-3">
                <label class="form-label fw-bold"><?php ee('Theme Description') ?></label>
                <input type="text" class="form-control p-2" name="description">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success"><?php ee('Create') ?></button>
        </div>    
      </form>
    </div>
  </div>
</div>