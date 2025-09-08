<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
        <li class="breadcrumb-item"><?php ee('Bio Pages') ?></li>
    </ol>
</nav>		
<h1 class="h3 mb-5 fw-bold"><?php ee('Bio Pages') ?>
    <?php echo request()->userid ? ' - '.e('User').' #'.request()->userid.' <a href="'.route('admin.bio').'"><i data-feather="x-circle" class="text-dark"></i></a>' : '' ?>
    <?php echo request()->q ? ' - '.e('Search result for {q}', null, ['q' => $q]).' <a href="'.route('admin.bio').'"><i data-feather="x-circle" class="text-dark"></i></a>' : '' ?>
</h1>
<div class="card rounded-4 flex-fill shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('ID') ?></th>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Link') ?></th>
                    <th><?php ee('Views') ?></th>
                    <th><?php ee('Date') ?></th>
                    <th>
                        <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#filterModal"  aria-expanded="false"><i data-feather="filter"></i></button>                       
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bios as $bio): ?>
                    <tr>
                        <td><?php echo $bio->id ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $bio->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <?php echo ($bio->user->admin)?"<strong>{$bio->user->email}</strong>":$bio->user->email ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="d-block"><?php echo $bio->name ?></span>
                            <a href="<?php echo Helpers\App::shortRoute($bio->url->domain, $bio->alias) ?>" target="_blank"><span class="text-muted" data-href="<?php echo Helpers\App::shortRoute($bio->url->domain, $bio->alias) ?>"><?php echo Helpers\App::shortRoute($bio->url->domain, $bio->alias) ?></span></a>      
                            <?php if($bio->url->status == '0') : ?>
                                <span class="badge bg-danger"><?php ee('Disabled') ?></span>
                            <?php endif ?>
                        </td>
                        <td><?php echo $bio->url->click ?></td>
                        <td><?php echo $bio->created_at ?></td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.users.view', [$bio->user->id]) ?>"><i data-feather="user"></i> <?php ee('View User') ?></span></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('stats', [$bio->url->id]) ?>"><i data-feather="bar-chart"></i> <?php ee('View Stats') ?></span></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.bio.reassign', [$bio->id]) ?>" data-bs-toggle="modal" data-bs-target="#assignModal" data-toggle="updateFormContent" data-content='<?php echo htmlentities(json_encode(['user' => $bio->userid]), ENT_QUOTES) ?>'><i data-feather="repeat"></i> <?php ee('Reassign') ?></span></a></li>
                                <?php if($bio->url->status == '1'): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.bio.toggle', ['disable', $bio->id]) ?>"><i data-feather="x-circle"></i> <?php ee('Disable') ?></span></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.bio.toggle', ['enable', $bio->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Enable') ?></span></a></li>
                                <?php endif ?>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.bio.delete', [$bio->id, \Core\Helper::nonce('bio.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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
<div class="modal fade" id="assignModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Reassign') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label fw-bold"><?php ee("User") ?></label>
                    <div class="input-select">
                        <select name="user" id="user" class="form-control" data-trigger="userlist" data-route="<?php echo route('admin.users.list') ?>">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label><input class="form-check-input me-2" type="checkbox" id="accept" name="accept" value="1"> <?php ee('I understand that this item will be move from one user to another.') ?><label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Reassign') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="" method="get">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Filter Bio Pages') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="input-select d-block mb-2">
                    <label for="userid" class="form-label fw-bold"><?php ee('Search user') ?></label>
                    <select name="userid" id="userid" class="form-control"  data-trigger="userlist" data-route="<?php echo route('admin.users.list') ?>"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Filter') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>