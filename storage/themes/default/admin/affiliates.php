<h1 class="h3 mb-5 fw-bold"><?php ee('Affiliate Referrals') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Referred') ?></th>
                    <th><?php ee('Commission') ?></th>
                    <th><?php ee('Referred On') ?></th>
                    <th><?php ee('Paid On') ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($sales as $sale): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $sale->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <a href="<?php echo route('admin.users.view', [$sale->user->id]) ?>"><?php echo $sale->user->email ?></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if($sale->referred): ?>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $sale->referred->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <a href="<?php echo route('admin.users.view', [$sale->referred->id]) ?>"><?php echo $sale->referred->email ?></a>
                                </div>
                            </div>
                            <?php else: ?>
                                <?php ee('User deleted') ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php echo \Helpers\App::currency(config('currency'), $sale->amount) ?>
                            <?php if($sale->status == "1"): ?>
                                <span class="badge bg-success"><?php ee('Approved') ?></span>
                            <?php elseif($sale->status == "3"): ?>
                                <span class="badge bg-success"><?php ee('Paid') ?></span>                                  
                            <?php elseif($sale->status == "2"): ?>
                                <span class="badge bg-danger"><?php ee('Rejected') ?></span>
                            <?php else: ?>
                                <span class="badge bg-warning"><?php ee('Pending') ?></span>
                            <?php endif ?>
                        </td>                                    
                        <td><?php echo \Core\Helper::dtime($sale->referred_on, 'Y-m-d') ?></td>
                        <td><?php echo $sale->paid_on ? \Core\Helper::dtime($sale->paid_on, 'Y-m-d') : e('Pending') ?></td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <?php if($sale->status != "1" && $sale->status != "3"): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.affiliate.update', [$sale->id, 'approve']) ?>"><i data-feather="check"></i> <?php ee('Approve Referral') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.affiliate.update', [$sale->id, 'reject']) ?>"><i data-feather="x"></i> <?php ee('Reject Referral') ?></a></li>
                                <?php endif ?>
                                <li><a class="dropdown-item" href="<?php echo  route('admin.email', ['email'=> $sale->user->email])  ?>"><i data-feather="send"></i> <?php ee('Email User') ?></a></li>
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