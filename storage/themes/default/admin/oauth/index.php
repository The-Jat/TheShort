<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('OAuth Applications') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bold mb-0"><?php ee('OAuth Applications') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.oauth.create') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Create Application') ?></a>
    </div>
</div>
<div class="card rounded-4">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th><?php ee('Name') ?></th>
                    <th><?php ee('Client ID') ?></th>
                    <th><?php ee('Client Secret') ?></th>
                    <th><?php ee('Redirect URI') ?></th>
                    <th><?php ee('Created') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $client): ?>
                    <tr>
                        <td><?php echo $client->name ?></td>
                        <td><code class="text-dark"><?php echo $client->client_id ?></code></td>
                        <td>
                            <code class="text-dark"><?php echo  substr($client->client_secret, 0, 8).str_repeat('*', 6).substr($client->client_secret, -4) ?></code> <a href="#copy" class="copy inline-copy" data-lang="<?php ee('Copied') ?>" data-clipboard-text="<?php echo $client->client_secret ?>"><small><?php echo e("Copy")?></small></a>
                        </td>
                        <td><?php echo $client->redirect_uri ?></td>
                        <td><?php echo $client->created_at ?></td>
                        <td>
                            <a href="<?php echo route('admin.oauth.list', $client->id) ?>" class="btn btn-sm btn-white rounded-3 shadow-sm border"><i data-feather="list"></i></a>
                            <a href="<?php echo route('admin.oauth.delete', [$client->id,  \Core\Helper::nonce('oauth.delete.'.$client->id)]) ?>" class="btn btn-sm btn-outline-danger rounded-3 shadow-sm" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
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
        <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>