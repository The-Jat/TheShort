<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Payments') ?></li>
  </ol>
</nav>


<div class="card rounded-4 flex-fill w-100 shadow-sm">
    <div class="card-body py-3">
        <div class="chart chart-sm">
            <canvas style="height:400px" data-trigger="chart" data-url="<?php echo route('admin.stats.payments') ?>" data-color-start="#3B7DDD" data-color-stop="rgba(255,255,255,0.1)"></canvas>
        </div>
    </div>
</div>
<div class="d-flex mb-4 mt-5 align-items-center">
    <h3 class="mb-0 fw-bold"><?php ee('Payments') ?></h3>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Transaction ID') ?></th>
                    <th><?php ee('Provider ID') ?></th>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th><?php ee('Amount') ?></th>
                    <th><?php ee('Date') ?></th>
                    <th><?php ee('Expiration') ?></th>
                    <th>
                        <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#filterModal"  aria-expanded="false"><i data-feather="filter"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($payments as $payment): ?>
                    <tr>
                        <td><?php echo $payment->tid?:'NA' ?> <?php echo (($payment->status == "Refunded") ? "(Refund)" : "") ?></td>
                        <td> <?php echo ($payment->provider ? "({$payment->provider})" : "") ?> <?php echo $payment->cid?:'NA' ?></td>
                        <td>
                            <a href="<?php echo route('admin.users.view', [$payment->userid]) ?>"><?php echo $payment->user ?: 'Social Media' ?></a>
                            <a href="<?php echo route('admin.email', ['email' => $payment->user]) ?>"><span class="badge bg-success"><?php ee('Send email') ?></span></a>
                        </td>
                        <td><?php echo $payment->status == "Refunded" ? 'Refunded/Canceled' : e($payment->status) ?></td>
                        <td><?php echo $payment->amount ? \Helpers\App::currency(config('currency'), $payment->amount) : '-' ?></td>
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
<div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="" method="get">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Filter Payments') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="input-select d-block mb-2">
                    <label for="userid" class="form-label fw-bold"><?php ee('Search user') ?></label>
                    <select name="userid" id="userid" class="form-control" data-trigger="userlist" data-route="<?php echo route('admin.users.list') ?>"></select>
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