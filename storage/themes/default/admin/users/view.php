<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo route('admin.users') ?>"><?php ee('Users') ?></a></li>
        <li class="breadcrumb-item active"><?php ee('Profile') ?></li>
    </ol>
</nav>
<div class="d-flex align-items-center mb-5">
    <h1 class="h3 mb-0 fw-bold"><?php echo $user->email ?> (#<?php echo $user->id ?>)
        <?php if($user->verified) echo '<span class="badge bg-success ms-2 fs-6">'.e('Verified').'</span>' ?>
    </h1>
    <div class="ms-auto">
        <a class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#loginModal" href="<?php echo route('admin.users.login', [$user->id, \Core\Helper::nonce('user.login.'.$user->id)]) ?>" target="_blank"><?php ee('Login as User') ?></a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card rounded-4 mb-3">
            <div class="card-body text-center">
                <img src="<?php echo $user->avatar() ?>" alt="<?php echo $user->username ?>" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                <h5 class="card-title mb-0"><?php echo $user->username ?></h5>
                <div class="text-muted mb-2"><?php echo $user->pro && $plan ? $plan->name : 'Free user' ?></div>

                <div>
                    <a class="btn btn-primary btn-sm" href="<?php echo route('admin.email', ['email'=> $user->email]) ?>"><span data-feather="message-square"></span> <?php echo e('Send Email') ?></a>
                    <?php if(!$user->verified): ?>                    
                    <a class="btn btn-success btn-sm" href="<?php echo route('admin.users.verify', [$user->id, \Core\Helper::nonce('verify-'.$user->id)]) ?>"><i data-feather="check-circle"></i> <?php ee('Verify User') ?></a>
                    <?php endif ?>
                    <a class="btn btn-primary btn-sm" href="<?php echo route('admin.users.edit', [$user->id]) ?>"><span data-feather="edit"></span></a>                    
                </div>
            </div>            
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action rounded border-0" href="<?php echo route('admin.users.view', [$user->id]) ?>"><?php ee('Links') ?></a>
                    <a class="list-group-item list-group-item-action rounded border-0" href="<?php echo route('admin.bio', ['userid' => $user->id]) ?>"><?php ee('Bio Pages') ?></a>
                    <a class="list-group-item list-group-item-action rounded border-0" href="<?php echo route('admin.qr', ['userid' => $user->id]) ?>"><?php ee('QR Codes') ?></a>
                    <a class="list-group-item list-group-item-action rounded border-0" href="<?php echo route('admin.payments', ['userid' => $user->id]) ?>"><?php ee('Payments') ?></a>
                    <a class="list-group-item list-group-item-action rounded border-0" href="<?php echo route('admin.subscriptions', ['userid' => $user->id]) ?>"><?php ee('Subscriptions') ?></a>
                    <a class="list-group-item list-group-item-action rounded border-0" href="<?php echo route('admin.domains', ['userid' => $user->id]) ?>"><?php ee('Domains') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-xl-9">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0 fw-bold"><?php ee('Links') ?></h5>
            </div>
            <div class="card-body h-100">
                <?php foreach($urls as $url): ?>
                    <div class="d-flex align-items-start">
                        <img src="<?php echo route('link.ico', $url->id) ?>" width="36" height="36" class="rounded-circle me-2" alt="<?php echo $url->meta_title ?>">                        
                        <div class="flex-grow-1">
                            <small class="float-end text-navy"><?php echo \Core\Helper::timeago($url->date) ?></small>
                            <?php if($url->qrid): ?>
                                <span class="badge bg-success">QR Code</span><br>
                            <?php elseif($url->profileid): ?>
                                <span class="badge bg-success">Profile</span><br>                         
                            <?php else: ?>
                                <a href="<?php echo $url->url ?>" target="_blank" rel="nofollow"><strong><?php echo \Core\Helper::empty($url->meta_title, $url->url) ?></strong></a><br />
                            <?php endif ?>
                            <small class="text-muted"><?php echo Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?></small> - 
                            <a href="<?php echo route('admin.links.delete', [$url->id, \Core\Helper::nonce('link.delete')]) ?>"><small class="text-danger"><?php ee('Delete') ?></span></small></a>
                        </div>
                    </div>          
                <hr>          
                <?php endforeach ?>
                <?php echo pagination('pagination') ?>
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