<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Bio Templates') ?></li>
  </ol>
</nav>

<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Bio Templates') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.bio.templates.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"> <?php ee('New Template') ?></a>
    </div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">    
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th scope="col"><?php ee('Preview') ?></th>
                    <th scope="col"><?php ee('Name') ?></th>
                    <th scope="col"><?php ee('Description') ?></th>
                    <th scope="col"><?php ee('Source Bio Page') ?></th>
                    <th scope="col"><?php ee('Available Plans') ?></th>
                    <th scope="col"><?php ee('Status') ?></th>
                    <th scope="col"><?php ee('Created') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($templates as $template): ?>
                    <tr>
                        <td>
                            <?php if($template->preview): ?>
                                <img src="<?php echo uploads($template->preview, 'images') ?>" alt="<?php echo htmlspecialchars($template->name) ?>" class="img-thumbnail" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif ?>
                        </td>
                        <td>
                            <span class="fw-bold"><?php echo $template->name ?></span>
                        </td>
                        <td>
                            <?php echo $template->description ?: '<span class="text-muted">-</span>' ?>
                        </td>
                        <td>
                            <?php if($template->profile): ?>
                                <a href="<?php echo route('bio.edit', [$template->profile->id]) ?>" target="_blank"><?php echo $template->profile->name ?></a>
                            <?php else: ?>
                                <span class="text-muted"><?php ee('Deleted') ?></span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if(empty($template->planids)): ?>
                                <span class="badge bg-info"><?php ee('All Plans') ?></span>
                            <?php else: ?>
                                <?php 
                                $planNames = [];
                                foreach($template->planids as $planid){
                                    if($plan = \Core\DB::plans()->first($planid)){
                                        $planNames[] = $plan->name;
                                    }
                                }
                                echo implode(', ', $planNames) ?: '<span class="text-muted">-</span>';
                                ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($template->status): ?>
                                <span class="badge border border-success text-success"><?php ee('Enabled') ?></span>
                            <?php else: ?>
                                <span class="badge border border-danger text-danger"><?php ee('Disabled') ?></span>
                            <?php endif ?>
                        </td>
                        <td><?php echo $template->created_at ?></td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.bio.templates.toggle', [$template->id]) ?>"> <?php echo $template->status == '1' ? '<i data-feather="toggle-left"></i> '.e('Disable') : '<i data-feather="toggle-right"></i> '.e('Enable') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.bio.templates.edit', [$template->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.bio.templates.delete', [$template->id, \Core\Helper::nonce('bio.template.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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
