<h1 class="h3 mb-5 fw-bold"><?php ee('Affiliate Withdrawals') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('PayPal') ?></th>
                    <th><?php ee('Amount') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th><?php ee('Requested At') ?></th>
                    <th><?php ee('Processed At') ?></th>
                    <th><?php ee('Note') ?></th>
                    <th><?php ee('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($withdrawals as $w): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $w->user ? $w->user->avatar() : '' ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <?php echo $w->user ? e($w->user->email) : 'User deleted' ?>
                                </div>
                            </div>
                        </td>
                        <td><?php echo e($w->paypal) ?></td>
                        <td><?php echo \Helpers\App::currency(config('currency'), $w->amount) ?></td>
                        <td>
                            <?php if($w->status == 'pending'): ?>
                                <span class="badge bg-warning"><?php ee('Pending') ?></span>
                            <?php elseif($w->status == 'approved'): ?>
                                <span class="badge bg-success"><?php ee('Approved') ?></span>
                            <?php elseif($w->status == 'rejected'): ?>
                                <span class="badge bg-danger"><?php ee('Rejected') ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($w->created_at) ?></td>
                        <td><?php echo $w->processed_at ? e($w->processed_at) : '-' ?></td>
                        <td><?php echo e($w->note) ?></td>
                        <td>
                            <?php if($w->status == 'pending'): ?>
                                <form action="<?php echo route('admin.affiliate.withdrawals.action', [$w->id, 'approve']) ?>" method="post" style="display:inline-block;">
                                    <?php echo csrf() ?>
                                    <input type="text" name="note" class="form-control mb-1" placeholder="<?php ee('Note (optional)') ?>">
                                    <button type="submit" class="btn btn-success btn-sm mb-1 rounded-3"><?php ee('Approve') ?></button>
                                </form>
                                <form action="<?php echo route('admin.affiliate.withdrawals.action', [$w->id, 'reject']) ?>" method="post" style="display:inline-block;">
                                    <?php echo csrf() ?>
                                    <input type="text" name="note" class="form-control mb-1" placeholder="<?php ee('Note (optional)') ?>">
                                    <button type="submit" class="btn btn-danger btn-sm mb-1 rounded-3"><?php ee('Reject') ?></button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
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