<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.oauth') ?>"><?php ee('OAuth Applications') ?></a></li>
    <li class="breadcrumb-item"><?php echo $client->name ?></li>
  </ol>
</nav>
<div class="d-flex mb-5">
    <h1 class="h3 mb-0 fw-bold">
        <span class="text-muted"><?php ee('OAuth Tokens for') ?></span> <?php echo $client->name ?>
    </h1>
</div>
<div class="card rounded-4">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Token') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th><?php ee('Created') ?></th>
                    <th><?php ee('Expires') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tokens as $token): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if($user = \Models\User::where('id', $token->user_id)->first()): ?>
                                    <img src="<?php echo $user->avatar() ?>" class="rounded-circle" width="32" height="32">
                                    <div class="ms-2">
                                        <strong><?php echo $user->email ?></strong>
                                        <small class="text-muted d-block"><?php echo $user->username ?></small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted"><?php ee('User Deleted') ?></span>
                                <?php endif ?>
                            </div>
                        </td>
                        <td>
                            <?php if($token->token): ?>
                                <span class="badge bg-primary"><?php echo $token->token ?></span>
                            <?php else: ?>
                                <span class="badge bg-warning"><?php echo $token->code ?></span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if(strtotime($token->expires_at) < time()): ?>
                                <span class="badge bg-danger"><?php ee('Expired') ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?php ee('Active') ?></span>
                            <?php endif ?>
                        </td>
                        <td>
                            <span class="text-muted"><?php echo \Core\Helper::timeago($token->created_at) ?></span>
                        </td>
                        <td>
                            <span class="text-muted"><?php echo date('M d, Y', strtotime($token->expires_at)) ?></span>
                        </td>
                        <td>
                            <a href="<?php echo route('admin.oauth.token.delete', $client->id) ?>" class="btn btn-sm btn-outline-danger rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-trigger="modalopen"  data-title="<?php ee('Delete Token') ?>">
                                <i data-feather="trash"></i>
                            </a>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Are you sure you want to delete this?') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p><?php ee('You are about to delete this token. This action is permanent and cannot be reversed.') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
            </div>
        </div>
    </div>
</div>