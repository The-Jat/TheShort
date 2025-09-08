<nav aria-label="breadcrumb" class="mb-3">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
		<li class="breadcrumb-item"><?php ee('Users') ?></li>
	</ol>
</nav>
<div class="d-flex mb-5 align-items-center">
	<h1 class="h3 mb-0 fw-bold"><?php echo \Core\View::$title ?></h1>
	<div class="ms-auto">
		<a href="<?php echo route('admin.users.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add User') ?></a>
	</div>
</div>
<div class="card rounded-4 p-2 mb-2">
	<div class="d-flex align-items-center">
		<form method="post" action="" data-trigger="options">
			<?php echo csrf() ?>
			<input type="hidden" name="selected">
			<div class="btn-group">
				<span class="btn btn-white"><input class="form-check-input" type="checkbox" data-trigger="checkall"></span>
				<a class="btn btn-white" href="<?php echo route('admin.users.emailall') ?>" data-trigger="submitchecked"><i class="me-1" data-feather="send"></i> <span class="align-middle"><?php ee('Email') ?></span></a>
				<a class="btn btn-white" href="<?php echo route('admin.users.banall') ?>" data-trigger="submitchecked"><i class="me-1" data-feather="x-circle"></i> <span class="align-middle"><?php ee('Ban') ?></span></a>
				<a class="btn btn-white" href="" data-bs-toggle="modal" data-bs-target="#downgradeModal" data-trigger="getchecked" data-for="#userids"><i class="me-1" data-feather="refresh-ccw"></i> <span class="align-middle"><?php ee('Change Plan') ?></span></a>
				<a class="btn btn-white text-danger" data-bs-toggle="modal" data-bs-target="#deleteAllModal" href=""><i class="me-1" data-feather="trash"></i> <span class="align-middle"><?php ee('Delete') ?></span></a>
			</div>
		</form>
		<div class="ms-auto">
			<button type="button" class="btn btn-default bg-transparent" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="filter"></i></button>
			<form action="" method="get" class="dropdown-menu p-2">
				<div class="input-select d-block mb-2">
					<label for="plan" class="form-label fw-bold"><?php ee('With Plan') ?></label>
					<select name="plan" id="plan" data-name="plan" class="form-select">
						<option value="all"<?php if(!request()->plan) echo " selected" ?>><?php ee('All') ?></option>
						<?php foreach($plans as $plan): ?>
							<option value="<?php echo $plan->id ?>"<?php if(request()->plan == $plan->id) echo " selected" ?>><?php echo $plan->name ?><?php echo $plan->free ? ' (free)': '' ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="input-select d-block mb-2">
					<label for="country" class="form-label fw-bold"><?php ee('Country') ?></label>
					<select name="country" id="country" data-name="country" class="form-select">
						<option value="all"<?php if(!request()->country) echo " selected" ?>><?php ee('All') ?></option>
						<?php foreach(\Core\Helper::Country(false) as $country): ?>
							<option value="<?php echo $country ?>"<?php if(request()->country && request()->country == $country) echo " selected" ?>><?php echo $country ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="input-select d-block mb-2">
					<label for="status" class="form-label fw-bold"><?php ee('Status') ?></label>
					<select name="status" id="status" data-name="status" class="form-select">
						<option value="all"<?php if(!request()->status) echo " selected" ?>><?php ee('All') ?></option>
						<option value="active"<?php if(request()->status == 'active') echo " selected" ?>><?php ee('Active') ?></option>
						<option value="inactive"<?php if(request()->status == 'inactive') echo " selected" ?>><?php ee('Inactive') ?></option>
						<option value="verified"<?php if(request()->status == 'verified') echo " selected" ?>><?php ee('Verified') ?></option>
					</select>
				</div>
				<div class="input-select d-block mb-3">
					<label for="date" class="form-label fw-bold"><?php ee('Older than') ?></label>
					<input type="text" class="form-control" name="date" placeholder="" value="<?php echo clean(request()->date) ?>" data-toggle="datepicker">
				</div>
				<div class="form-group d-block mb-2">
					<input type="checkbox" class="form-check-input me-2" name="expired" id="expired" value="1">
					<label for="expired" class="form-label fw-bold align-middle"><?php ee('Expired') ?></label>
				</div>
				<button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Filter') ?></button>
			</form>
		</div>
	</div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
	<div class="table-responsive">
		<table class="table table-hover my-0">
			<thead>
				<tr>
					<th><?php ee('Email') ?></th>
					<th><?php ee('User Status') ?></th>
					<th><?php ee('Registration Date') ?></th>
					<th><?php ee('Membership') ?></th>
					<th><?php ee('Expiration') ?></th>
					<th><?php ee('URLs') ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($users as $user): ?>
					<tr>
						<td>							
							<div class="d-flex align-items-center">
								<input class="form-check-input me-3" type="checkbox" data-dynamic="1" value="<?php echo $user->id ?>">
								<img src="<?php echo $user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
								<div class="ms-2">
									<?php echo ($user->admin)?"<strong>{$user->email}</strong>":$user->email ?>
									<?php echo ($user->verified)?'<span class="me-1" data-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" data-bs-placement="top" title="'.e('Verified Account').'"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><polygon stroke-width="1" stroke="#fff" fill="#3899e8" points="29.50,3 33.053,8.308 39.367,8.624 39.686,14.937 44.997,18.367 42.116,23.995 45,29.62 39.692,33.053 39.376,39.367 33.063,39.686 29.633,44.997 24.005,42.116 18.38,45 14.947,39.692 8.633,39.376 8.314,33.063 3.003,29.633 5.884,24.005 3,18.38 8.308,14.947 8.624,8.633 14.937,8.314 18.367,3.003 23.995,5.884"></polygon><polygon fill="#fff" points="21.396,31.255 14.899,24.76 17.021,22.639 21.428,27.046 30.996,17.772 33.084,19.926"></polygon></svg></span>':"" ?>
									<?php echo ($user->active ? '<span class="badge bg-success">'.e('Active').'</span>':'<span class="badge bg-danger">'.e('Not Active').'</span>') ?> <?php echo $user->banned ? '<span class="badge bg-danger">'.e('Banned').'</span>':'' ?>
								</div>
							</div>
						</td>
						<td>
							<?php echo ($user->admin)?"<span class=\"badge bg-primary\">{$user->getRole()->name}</span>": '' ?>
							<?php echo ($user->trial)?"(".e('Free Trial').")":"" ?>
							<?php echo ($user->teams())?"<strong class=\"badge bg-primary\">".e("Team")."</strong>":'' ?>
						</td>
						<td><?php echo date("F d, Y",strtotime($user->date)) ?></td>
						<td><?php echo ($user->pro ? '<span class="badge bg-success">'.$user->planname.'</span>':'<span class="badge bg-warning">'.$user->planname.'</span>') ?></td>
						<td><?php echo ($user->pro && $user->expiration ? date("F d, Y",strtotime($user->expiration)):"n/a") ?></td>
						<td><a href="<?php echo route('admin.users.view', [$user->id]) ?>" class="btn btn-success btn-sm"><?php echo $user->count ?></a></td>
						<td>
							<button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#loginModal" href="<?php echo route('admin.users.login', [$user->id, \Core\Helper::nonce('user.login.'.$user->id)]) ?>" target="_blank"><i data-feather="log-in"></i> <?php ee('Login as User') ?></a></li>
								<li><a class="dropdown-item" href="<?php echo route('admin.users.view', [$user->id]) ?>"><i data-feather="user"></i> <?php ee('User Profile') ?></a></li>
								<li><a class="dropdown-item" href="<?php echo route('admin.users.edit', [$user->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
								<li><a class="dropdown-item" href="<?php echo route('admin.users.ban', [$user->id]) ?>"><i data-feather="x-circle"></i> <?php echo $user->banned ? e('Unban') : e('Ban') ?></a></li>
								<?php if(!$user->active): ?>
									<li><a class="dropdown-item" href="<?php echo route('admin.users.verifyemail', [$user->id]) ?>"><i data-feather="send"></i> <?php ee('Verify Email') ?></a></li>
								<?php endif ?>
								<li><a class="dropdown-item" href="<?php echo route('admin.users.activity', $user->id) ?>"><i data-feather="activity"></i> <?php ee('Activity Logs') ?></a></li>
								<li><hr class="dropdown-divider"></li>
								<?php if($user->verified): ?>
								<li><a class="dropdown-item" href="<?php echo route('admin.users.unverify', [$user->id, \Core\Helper::nonce('unverify-'.$user->id)]) ?>"><i data-feather="check-circle" class="text-primary"></i> <?php ee('Unverify User') ?></a></li>
								<?php else: ?>
								<li><a class="dropdown-item" href="<?php echo route('admin.users.verify', [$user->id, \Core\Helper::nonce('verify-'.$user->id)]) ?>"><i data-feather="check-circle" class="text-primary"></i> <?php ee('Verify User') ?></a></li>
								<?php endif ?>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.users.delete', [$user->id, \Core\Helper::nonce('user.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete User') ?></a></li>
								<li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.users.delete.all', [$user->id, \Core\Helper::nonce('user.delete')]) ?>"><i data-feather="trash-2"></i> <?php ee('Delete User + Data') ?></a></li>
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
<div class="modal fade" id="deleteAllModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to proceed?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete many records. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="<?php echo route('admin.users.deleteall') ?>" class="btn btn-danger" data-trigger="submitchecked"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="downgradeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo route('admin.users.changeplan') ?>" method="post">
        <?php echo csrf() ?>
        <div class="modal-header">
            <h5 class="modal-title fw-bold"><?php ee('Change Plan') ?></h5>
            <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
        </div>
        <div class="modal-body">
			<p><?php ee('This feature changes the plan of selected users. It does not change the expiration date. If you downgrade users to a free, the changes will be immediate.') ?></p>
            <label for="plan" class="form-label fw-bold d-block mb-2"><?php ee('Plan') ?></label>
            <div class="form-group rounded input-select">
                <select name="plan" id="plan" class="form-control" data-toggle="select">
					<?php foreach($plans as $plan): ?>
						<option value="<?php echo $plan->id ?>"<?php if(request()->plan == $plan->id) echo " selected" ?>><?php echo $plan->name ?><?php echo $plan->free ? ' (free)': '' ?></option>
					<?php endforeach ?>
                </select>
            </div>
            <input type="hidden" name="userids" id="userids" value="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-success" data-load><?php ee('Change Plan') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>