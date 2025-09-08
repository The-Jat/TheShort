<?php if($users): ?>
<h3 class="fw-bold mb-5"><?php ee('Users') ?> <?php ee('Results') ?></h3>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td>
                            <?php echo ($user->admin)?"<strong>{$user->email}</strong>":$user->email ?> <?php echo ($user->trial)?"(Free Trial)":"" ?>
                            <?php echo ($user->public)?"<a href='".route('profile',[$user->username])."' class='badge bg-primary text-white' target='_blank'>@{$user->username}</a>":"" ?>
                            <?php echo ($user->verified)? '<span class="badge bg-success">'.e('Verified').'</strong>':'' ?>
                        </td>
                        <td><?php echo ($user->active ? '<span class="badge bg-success">Active</span>':'<span class="badge bg-danger">Not Active</span>') ?> <?php echo $user->banned ? '<span class="badge bg-danger">'.e('Banned').'</span>':'' ?></td>
                        <td><?php echo date("F d, Y",strtotime($user->date)) ?></td>
                        <td><?php echo ($user->pro ? '<span class="badge bg-success">Pro</span>':'<span class="badge bg-warning">Free</span>') ?></td>
                        <td><?php echo ($user->pro?date("F d, Y",strtotime($user->expiration)):"n/a") ?></td>
                        <td class="d-none d-md-table-cell">
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#loginModal" href="<?php echo route('admin.users.login', [$user->id, \Core\Helper::nonce('user.login.'.$user->id)]) ?>" target="_blank"><i data-feather="log-in"></i> <?php ee('Login as User') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.view', [$user->id]) ?>"><i data-feather="user"></i> <?php ee('User Profile') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.edit', [$user->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.ban', [$user->id]) ?>"><i data-feather="x-circle"></i> <?php echo $user->banned ? e('Unban') : e('Ban') ?></a></li>
                                <?php if(!$user->verified): ?>
                                <li><hr class="dropdown-divider"></li>
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
<?php endif ?>
<?php if($urls): ?>
<h3 class="fw-bold mb-5"><?php ee('Links') ?> <?php ee('Results') ?></h3>
<div class="card rounded-4 flex-fill shadow-sm p-2 mb-2">
    <form method="post" action="" data-trigger="options">
        <?php echo csrf() ?>
        <input type="hidden" name="selected">
        <div class="btn-group">
            <span class="btn btn-white"><input class="form-check-input" type="checkbox" data-trigger="checkall"></span>
            <a class="btn btn-white" href="<?php echo route('admin.links.enableall') ?>" data-trigger="submitchecked"><i data-feather="check-circle"></i> <span class="align-middle"><?php ee('Enable Selected') ?></span></a>
            <a class="btn btn-white" href="<?php echo route('admin.links.disableall') ?>" data-trigger="submitchecked"><i data-feather="x-circle"></i> <span class="align-middle"><?php ee('Disable Selected') ?></span></a>
            <a class="btn btn-white text-danger" data-bs-toggle="modal" data-bs-target="#deleteAllModal" href=""><i data-feather="trash"></i> <span class="align-middle"><?php ee('Delete Selected') ?></span></a>
        </div>
    </form>
</div>
<?php foreach($urls as $url): ?>
    <?php view('admin.partials.links', compact('url')) ?>
<?php endforeach ?>
<?php endif ?>
<?php if($payments): ?>
<h3 class="fw-bold mb-5"><?php ee('Payments') ?> <?php ee('Results') ?></h3>
<div class="card rounded-4 flex-fill shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Transaction ID') ?></th>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th><?php ee('Amount') ?></th>
                    <th><?php ee('Date') ?></th>
                    <th><?php ee('Expiration') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($payments as $payment): ?>
                    <tr>
                        <td><?php echo $payment->tid?:'NA' ?> <?php echo (($payment->status == "Refunded") ? "(Refund)" : "") ?></td>
                        <td>
                            <div class="d-flex align-items-center">
								<img src="<?php echo $payment->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle me-2">
                                <?php echo $payment->user->email ?? 'Social Media' ?>
								<div class="ms-2">
                                    <a href="<?php echo route('admin.email', ['email' => $payment->user]) ?>"><span class="badge bg-success"><?php ee('Send email') ?></span></a>
								</div>
							</div>
                        </td>
                        <td><?php echo $payment->status ?></td>
                        <td><?php echo \Helpers\App::currency(config('currency'), $payment->amount) ?></td>
                        <td><?php echo $payment->date ?></td>
                        <td><?php echo $payment->expiry ?></td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.invoice', [$payment->id]) ?>"><i data-feather="file-text"></i> <?php ee('View Invoice') ?></a></li>
                                <?php if($payment->status == "Completed"): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.payments.markas', [$payment->id, 'refunded']) ?>"><i data-feather="delete"></i> <?php ee('Mark as Refunded') ?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.payments.markas', [$payment->id, 'paid']) ?>"><i data-feather="check-circle"></i> <?php ee('Mark as Paid') ?></a></li>
                                <?php endif ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.payments.delete', [$payment->id, \Core\Helper::nonce('payment.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif ?>
<?php if($users || $urls || $payments): ?>
	<div class="mt-4 d-block">
		<?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
	</div>
<?php else: ?>
    <div class="card rounded-4">
        <div class="card-body text-center">
            <?php ee('No results found...') ?>
        </div>
    </div>
<?php endif ?>
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
        <a href="#" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>