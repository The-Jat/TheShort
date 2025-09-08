<div class="d-flex align-items-center mb-5">
    <h1 class="h3 mb-0 fw-bold"><?php ee('API Keys') ?></h1>
    <div class="ms-auto">
        <button type="button" class="btn btn-primary rounded-3 px-3 py-2" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#createModal"><?php ee('Generate Key') ?></button>
        <a class="btn btn-dark rounded-3 px-3 py-2" href="<?php echo route('apidocs') ?>"><i data-feather="book-open"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('API Key') ?></th>
                            <th><?php ee('Description') ?></th>
                            <th><?php ee('Permission') ?></th>
                            <th><?php ee('Created') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($keys as $key): ?>
                            <tr>
                                <td>
                                    <code class="text-dark"><?php echo  substr($key->apikey, 0, 8).str_repeat('*', 6).substr($key->apikey, -4) ?></code> <a href="#copy" class="copy inline-copy" data-lang="<?php ee('Copied') ?>" data-clipboard-text="<?php echo $key->apikey ?>"><small><?php echo e("Copy")?></small></a>
                                </td>
                                <td>
                                    <span><?php echo $key->description ?></span>
                                </td>
                                <td>
                                    <span><?php echo $key->permissions ?></span>
                                </td>
                                <td>
                                    <?php echo date('Y-m-d', strtotime($key->created_at)) ?>
                                </td>
                                <td>
                                    <a class="btn btn-danger btn-sm rounded" href="<?php echo route('apikeys.revoke', [$key->id, \Core\Helper::nonce('apikey.delete.'.$key->id)]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#revokeModal"><?php ee('Revoke') ?></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <?php if(!$keys): ?>
                            <tr>
                                <td colspan="4" class="text-center"><?php ee('No API keys found') ?></td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-body shadow-sm rounded-4">
            <div class="d-flex align-items-center mb-3">
                <h4 class="mb-0 fw-bold"><?php echo e("Master API Key") ?></h4>
                <div class="ms-auto">
                    <span data-bs-toggle="dropdown" aria-expanded="false" class="me-2" role="button"><i data-feather="more-horizontal"></i></span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#apiModal"><?php ee('Regenerate') ?></a></li>
                    </ul>
                </div> 
            </div>
            <p><?php ee('A master API key allows access to all API endpoints. If you need specific access, you can generate a custom API key.') ?></p>
            <code class="p-3 rounded position-relative d-block border text-dark"><?php echo $maskedkey ?> <a href="#" class="btn btn-success btn-sm position-absolute top-50 translate-middle-y end-0 copy me-2 rounded" data-clipboard-text="<?php echo $user->api ?>"><?php ee('Copy') ?></a></code>
        </div>
    </div>
</div>
<div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="post" action="<?php echo route('apikeys.create') ?>">
        <?php echo csrf() ?>
        <div class="modal-header">
            <h5 class="modal-title fw-bold"><?php ee('Generate API Key') ?></h5>
            <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label class="form-label fw-bold"><?php ee('Description') ?></label>
                <input type="text" class="form-control p-2" name="description">
            </div>
            <div class="form-group input-select">
                <label for="permissions" class="label-control fw-bold mb-2"><?php echo e("Permissions") ?></label>
                <select name="permissions[]" class="form-control" placeholder="<?php echo e("Permissions") ?>" data-placeholder="<?php echo e("Permissions") ?>" multiple data-toggle="select">
                    <?php foreach($endpoints as $key => $name): ?>
                        <option value="<?php echo $key ?>"><?php echo $name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Close') ?></button>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Create') ?></button>
        </div>
    </form>
  </div>
</div>
<div class="modal fade" id="revokeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Revoke API Key') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('Are you sure you want to revoke this API key? Applications using this key will no longer be able to access the API.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Revoke') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="apiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Developer API Key') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <form action="<?php echo route('regenerateapi') ?>" method="post">
        <div class="modal-body">
            <p><?php echo ee('If you regenerate your key, the current key will be revoked and your applications might stop working until you update the api key with the new one.') ?></p>
            <?php echo csrf() ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm"><?php ee('Regenerate') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>