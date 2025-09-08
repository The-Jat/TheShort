<h1 class="fw-bold mb-2 h3">Welcome <?php echo user()->getRole()->name ?> 👋</h1>
<p class="text-muted mb-4"><?php ee('Here is a quick overview of your account. Do not forget to check the <a href="'.route('admin.settings.checklist').'">setup checklist</a> to ensure your site is fully configured.') ?></p>
<div class="row">
    <?php foreach($counts as $id => $count): ?>
        <div class="col-md-3">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4"><?php echo $count['name'] ?></h5>
                    <h1 class="mt-1 mb-3"><?php echo $id == 'payments' ? \Helpers\App::currency(config('currency')):'' ?><?php echo $count['count']?: '0' ?></h1>
                    <div class="mb-1">
                        <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> +<?php echo $id == 'payments' ? \Helpers\App::currency(config('currency')):'' ?><?php echo $count['count.today']?:'0' ?> <?php ee('Today') ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="border rounded rounded-4 rounded-4 p-2 mb-4 no-checkbox">
            <div class="d-flex align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?php ee('New Links') ?></h5>
                <div class="ms-auto">
                    <a href="<?php echo route('admin.links', ['sort'=>'new']) ?>" class="shadow-sm bg-white text-muted small border p-2 rounded-3"><?php ee('View All') ?></a>
                </div>
            </div>            
            <?php foreach($urls->latest as $url): ?>
                <?php view('admin.partials.links', compact('url')) ?>
            <?php endforeach ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded rounded-4 rounded-4 p-2 mb-4 no-checkbox">
            <div class="d-flex align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?php ee('Top Links') ?></h5>
                <div class="ms-auto">
                    <a href="<?php echo route('admin.links', ['sort'=>'most']) ?>" class="shadow-sm bg-white text-muted small border p-2 rounded-3"><?php ee('View All') ?></a>
                </div>
            </div>    
            <?php foreach($urls->top as $url): ?>
                <?php view('admin.partials.links', compact('url')) ?>
            <?php endforeach ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="border rounded rounded-4 rounded-4 p-2 mb-4">
            <div class="d-flex align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?php ee('Users') ?></h5>
                <div class="ms-auto">
                    <a href="<?php echo route('admin.users') ?>" class="shadow-sm bg-white text-muted small border p-2 rounded-3"><?php ee('View All') ?></a>
                </div>
            </div>
            <div class="card rounded-4 shadow-sm mb-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover my-0">
                            <thead>
                                <tr>
                                    <th><?php ee('Email') ?></th>
                                    <th><?php ee('Status') ?></th>
                                    <th><?php ee('Joined') ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                                <div class="ms-2">
                                                    <?php echo ($user->auth)? ucfirst($user->auth).' Auth: '.$user->auth_id : ''?>
                                                    <?php echo ($user->admin)?"<strong>{$user->email}</strong>":$user->email ?> <?php echo ($user->trial)?"(Free Trial)":"" ?> <?php echo ($user->teams())?"<strong class=\"badge bg-primary\">Team</strong>":'' ?>
                                                    <?php if($user->verified) echo '<span class="badge bg-success ms-2">'.e('Verified').'</span>' ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo ($user->active ? '<span class="badge bg-success">Active</span>':'<span class="badge bg-danger">Not Active</span>') ?> <?php echo $user->banned ? '<span class="badge bg-danger">'.e('Banned').'</span>':'' ?> <?php echo ($user->pro ? '<span class="badge bg-success">'.$user->planname.'</span>':'<span class="badge bg-warning">'.$user->planname.'</span>') ?></td>
                                        <td><?php echo date("d-m-y",strtotime($user->date)) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#loginModal" href="<?php echo route('admin.users.login', [$user->id, \Core\Helper::nonce('user.login.'.$user->id)]) ?>" target="_blank"><i data-feather="log-in"></i> <?php ee('Login as User') ?></a></li>
                                                <li><a class="dropdown-item" href="<?php echo route('admin.users.view', [$user->id]) ?>"><i data-feather="credit-card"></i> <?php ee('User Profile') ?></a></li>
                                                <li><a class="dropdown-item" href="<?php echo route('admin.users.edit', [$user->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                                <li><a class="dropdown-item" href="<?php echo route('admin.users.ban', [$user->id]) ?>"><i data-feather="x-circle"></i> <?php echo $user->banned ? e('Unban') : e('Ban') ?></a></li>
                                                <?php if(!$user->active): ?>
                                                    <li><a class="dropdown-item" href="<?php echo route('admin.users.verifyemail', [$user->id]) ?>"><i data-feather="send"></i> <?php ee('Verify Email') ?></a></li>
                                                <?php endif ?>
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
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded rounded-4 rounded-4 p-2 mb-4">
            <div class="d-flex align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?php ee('Subscriptions') ?></h5>
                <div class="ms-auto">
                    <a href="<?php echo route('admin.subscriptions') ?>" class="shadow-sm bg-white text-muted small border p-2 rounded-3"><?php ee('View All') ?></a>
                </div>
            </div>        
            <div class="card rounded-4 flex-fill shadow-sm mb-0">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th><?php ee('User') ?></th>
                                <th><?php ee('Status') ?></th>
                                <th><?php ee('Amount') ?></th>
                                <th><?php ee('Date') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($subscriptions as $subscription): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $subscription->useravatar ?>" alt="" width="36" class="img-responsive rounded-circle">
                                            <div class="ms-2">
                                                <a href="<?php echo route('admin.users.view', [$subscription->userid]) ?>"><?php echo $subscription->user ?></a>
                                                <a href="<?php echo route('admin.email', ['email' => $subscription->user]) ?>"><span class="badge bg-success"><?php ee('Send email') ?></span></a><br>
                                                <span class="badge bg-primary"><?php echo $subscription->plan ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($subscription->status) ?></td>
                                    <td><?php echo \Helpers\App::currency(config('currency'), $subscription->amount) ?></td>
                                    <td><?php echo \Core\Helper::dtime($subscription->date, 'd-m-y') ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="border rounded rounded-4 rounded-4 p-2 mb-4">
            <div class="d-flex align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?php ee('Payments') ?></h5>
                <div class="ms-auto">
                    <a href="<?php echo route('admin.payments') ?>" class="bg-white text-muted small border p-2 rounded"><?php ee('View All') ?></a>
                </div>
            </div>
            <div class="card rounded-4 shadow-sm mb-0">        
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th><?php ee('Transaction ID') ?></th>
                                <th><?php ee('User') ?></th>
                                <th><?php ee('Status') ?></th>
                                <th><?php ee('Amount') ?></th>
                                <th><?php ee('Date') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($payments as $payment): ?>
                                <tr>
                                    <td><?php echo $payment->tid?:'NA' ?> <?php echo (($payment->status == "Refunded") ? "(Refund)" : "") ?></td>
                                    <td>
                                        <a href="<?php echo route('admin.users.view', [$payment->userid]) ?>"><img src="<?php echo $payment->useravatar ?>" alt="" width="36" class="img-responsive rounded-circle" data-bs-toggle="tooltip" title="<?php echo $payment->user ?>"></a>
                                    </td>
                                    <td><?php echo e($payment->status) ?></td>
                                    <td><?php echo \Helpers\App::currency(config('currency'), $payment->amount) ?></td>
                                    <td><?php echo \Core\Helper::dtime($payment->date, 'd-m-y')?></td>
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
        </div>
    </div>
    <div class="col-md-6">
        <div class="border rounded rounded-4 rounded-4 p-2 mb-4">
            <div class="d-flex align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?php ee('Reported Links') ?></h5>
                <div class="ms-auto">
                    <a href="<?php echo route('admin.links.report') ?>" class="bg-white text-muted small border p-2 rounded"><?php ee('View All') ?></a>
                </div>
            </div>        
            <div class="card rounded-4 flex-fill shadow-sm mb-0">
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th><?php ee('Reported Link') ?></th>
                                <th><?php ee('Reason') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($reports as $report): ?>
                                <tr>
                                    <td><a href="<?php echo $report->url ?>" target="_blank"><?php echo $report->url ?></a></td>
                                    <td><?php echo ucfirst($report->type) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo route('admin.links.report.action', [$report->id, 'banurl']) ?>"><i data-feather="x-circle"></i> <?php ee('Ban URL') ?></a></li>
                                            <li><a class="dropdown-item" href="<?php echo route('admin.links.report.action', [$report->id, 'bandomain']) ?>"><i data-feather="x-circle"></i> <?php ee('Ban Domain') ?></a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.links.report.action', [$report->id, 'delete']) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
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