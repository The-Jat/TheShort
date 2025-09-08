<div class="d-flex mb-5">
    <div>
        <h1 class="h3 fw-bold mb-0"><?php ee('Branded Domains') ?></h1>
    </div>
    <div class="ms-auto">
    <?php if(\Core\Auth::user()->teamPermission('domain.create')): ?>
        <a href="<?php echo route('domain.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Add Domain') ?></a>
    <?php endif ?>
    </div>
</div>
<div class="card rounded-4 shadow-sm p-2 py-3">
    <div class="d-block d-md-flex align-items-center">
        <div>
			<span class="h3 ms-2"><?php echo $count ?></span> <span class="text-muted"> <?php ee('Domains') ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></span>
		</div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="card rounded-4 flex-fill shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th class="text-muted"><?php ee('Domain') ?></th>
                            <th class="text-muted"><?php ee('Domain Root') ?></th>
                            <th class="text-muted"><?php ee('404 Redirect') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($domains as $domain): ?>
                            <tr>
                                <td>
                                    <?php echo $domain->domain ?><br>
                                    <?php if($domain->status == "1"): ?>
                                    <span class="badge bg-success"><?php ee('Active') ?></span>
                                    <?php elseif($domain->status == "2"): ?>
                                    <span class="badge bg-warning"><?php ee('Pending DNS') ?></span>
                                    <?php else: ?>
                                    <span class="badge bg-danger"><?php ee('Inactive/Disabled') ?></span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if($domain->bioid): ?>
                                        <strong><?php echo $domain->bioname ?></strong>
                                    <?php else: ?>
                                        <?php echo $domain->redirect?:e('None') ?>
                                    <?php endif ?>
                                </td>
                                <td><?php echo $domain->redirect404?:e('None') ?></td>
                                <td>
                                    <button type="button" class="btn btn-transparent border-0 p-0 float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                    <?php if(user()->teamPermission('domain.edit')): ?>
                                        <li><a class="dropdown-item" href="<?php echo route('domain.edit', [$domain->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit Domain') ?></a></li>
                                    <?php endif ?>
                                    <?php if(user()->teamPermission('domain.delete')): ?>
                                        <li class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('domain.delete', [$domain->id, \Core\Helper::nonce('domain.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                    <?php endif ?>
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
    </div>
    <div class="col-md-3">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header bg-transparent">
                <div class="d-flex">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('How to setup custom domain') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p> <?php echo ee('If you have a custom domain name that you want to use with our service, you can associate it to your account very easily. Once added, we will add the domain to your account and set it as the default domain name for your URLs. DNS changes could take up to 36 hours. If you are planning to serve SSL on your domain name, we recommend using cloudflare.') ?></p>
                <?php if(config("serverip")): ?>
                    <?php if(filter_var(config("serverip"), FILTER_VALIDATE_IP)): ?>
                        <p><?php ee("To point your domain name, create an A record and set the value to ") ?><strong><?php echo config("serverip") ?></strong></p>
                    <?php else: ?>
                        <p><?php ee("To point your subdomain domain name, create a CNAME record and set the value to ") ?><strong><?php echo config("serverip") ?></strong></p>
                    <?php endif ?>
				<?php endif ?>
            </div>
        </div>
        <?php plug('sidebar.domain') ?>
    </div>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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