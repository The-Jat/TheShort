<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo route('admin.users') ?>"><?php ee('Users') ?></a></li>
		<li class="breadcrumb-item"><?php ee('Teams') ?></li>
	</ol>
</nav>
<div class="d-flex mb-5 align-items-center">
	<h1 class="h3 mb-0 fw-bold"><?php ee('Team Users') ?></h1>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
	<div class="table-responsive">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th><?php ee('User') ?></th>
					<th><?php ee('Team') ?></th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($members as $member): ?>
					<tr>
						<td>							
							<div class="d-flex align-items-center">
								<img src="<?php echo $member['user']->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
								<div class="ms-2">
									<?php echo ($member['user']->admin)?"<strong>{$member['user']->email}</strong>":$member['user']->email ?> <?php echo ($member['user']->trial)?"(".e('Free Trial').")":"" ?>
									<?php if($member['user']->verified) echo '<span class="badge bg-success ms-2">'.e('Verified').'</span>' ?>
								</div>
							</div>
						</td>
                        <td>							
							<div class="d-flex align-items-center">
								<img src="<?php echo $member['team']->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
								<div class="ms-2">
									<?php echo ($member['team']->admin)?"<strong>{$member['team']->email}</strong>":$member['team']->email ?> <?php echo ($member['team']->trial)?"(".e('Free Trial').")":"" ?>
									<?php if($member['team']->verified) echo '<span class="badge bg-success ms-2">'.e('Verified').'</span>' ?>
								</div>
							</div>
						</td>	
                        <td>
							<button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#loginModal" href="<?php echo route('admin.users.login', [$member['user']->id, \Core\Helper::nonce('user.login.'.$member['user']->id)]) ?>" target="_blank"><i data-feather="log-in"></i> <?php ee('Login as User') ?></a></li>
								<li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#loginModal" href="<?php echo route('admin.users.login', [$member['team']->id, \Core\Helper::nonce('user.login.'.$member['team']->id)]) ?>" target="_blank"><i data-feather="log-in"></i> <?php ee('Login as Team') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.users.removeteam', [$member['id'], \Core\Helper::nonce('user.remove')]) ?>"><i data-feather="trash"></i> <?php ee('Remove from team') ?></a></li>
							</ul>
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
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title fw-bold"><?php ee('You are about to login as a user') ?></h5>
		<button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
	  </div>
	  <div class="modal-body">
		<p><?php ee("You are about to login as a user. For security reasons, you will be logged out from this account and logged in as this user. You will need to logout from this user's account and login back as your own account.") ?></p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
		<a href="#" class="btn btn-success" data-trigger="confirm"><?php ee('Confirm') ?></a>
	  </div>
	</div>
  </div>
</div>