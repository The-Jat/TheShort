<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Plans') ?></li>
  </ol>
</nav>

<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Plans') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.plans.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"> <?php ee('Add Plan') ?></a>
        <?php if (\Helpers\App::possible()): ?>
            <a href="<?php echo route("admin.plans.sync") ?>" class="btn btn-dark rounded-3 px-3 py-2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Sync Plans') ?>"><i data-feather="repeat"></i></a> 
            <a href="<?php echo route("admin.settings.config",['payments']) ?>" class="btn btn-dark rounded-3 px-3 py-2" data-bs-toggle="tooltip" data-bs-placement="top" title=" <?php ee('Settings') ?>"><i data-feather="settings"></i></a> 
        <?php endif ?>
    </div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">    
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th scope="col"><?php ee('Name') ?></th>
                    <th scope="col"><?php ee('Price M/Y/L') ?></th>
                    <th scope="col"><?php ee('Users') ?></th>
                    <th scope="col" class="w-50"><?php ee('Details') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($plans as $plan): ?>
                    <tr>
                        <td>
                            <span class="fw-bold"><?php echo $plan->name ?></span> <br>
                            <?php if($plan->status): ?>
                                <span class="badge border border-success text-success"><?php ee('Enabled') ?></span>
                            <?php else: ?>
                                <span class="badge border border-danger text-danger"><?php ee('Disabled') ?></span>
                            <?php endif ?>
                            <?php if($plan->hidden): ?>
                                <span class="badge border border-warning text-warning"><?php ee('Hidden') ?></span>
                            <?php endif ?>
                            <?php if($plan->ispopular): ?>
                                <span class="badge border border-primary text-primary"><?php ee('Popular') ?></span>
                            <?php endif ?>
                            <?php echo ($plan->trial_days ? "<span class='badge text-info border border-info'>{$plan->trial_days}-day trial</span>" : "") ?>
                        </td>
                        <td>
                            <?php if ($plan->free): ?>
                                <?php ee('Free') ?>
                            <?php else: ?>
                                <?php echo $plan->price_monthly ? \Helpers\App::currency(config('currency'), $plan->price_monthly).' /' : 'none' ?>
                                <?php echo $plan->price_yearly ? \Helpers\App::currency(config('currency'), $plan->price_yearly).' /' : 'none' ?>
                                <?php echo $plan->price_lifetime ? \Helpers\App::currency(config('currency'), $plan->price_lifetime) : 'none' ?>
                            <?php endif ?>                        
                        </td>
                        <td>
                            <a href="<?php echo route('admin.users', ['plan' => $plan->id]) ?>" class="badge border border-dark text-dark"><?php echo \Core\DB::user()->where('planid', $plan->id)->count() ?> <?php ee('users') ?>
                        </td>
                        <td>
                            <span class="badge text-primary border border-primary"><?php echo $plan->numurls == "0" ? "Unlimited" : $plan->numurls ?> <?php echo e('links').' '.($plan->counttype ?? '') ?></span>
                            <?php foreach (json_decode($plan->permission) as $type => $p): ?>
                                <?php if (isset($p->enabled) && $p->enabled): ?>
                                    <?php $count = NULL; if (isset($p->count)): ?>
                                        <?php $count = $p->count == "0" ? "Unlimited" : $p->count ?>
                                    <?php endif ?>
                                    <span class="badge text-primary border border-primary"><?php echo $count ?> <?php echo $type == "api" ? "API Access" : ucfirst($type) ?> <?php echo $type == 'qr' ? ($plan->qrcounttype ?? 'total'): '' ?></span>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.plans.toggle', [$plan->id]) ?>"> <?php echo $plan->status == '1' ? '<i data-feather="toggle-left"></i> '.e('Disable') : '<i data-feather="toggle-right"></i> '.e('Enable') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.plans.edit', [$plan->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.plans.delete', [$plan->id, \Core\Helper::nonce('plan.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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