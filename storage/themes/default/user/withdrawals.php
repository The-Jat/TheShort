<h1 class="h3 mb-5 fw-bold"><?php ee('Withdrawals') ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm mb-4">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Amount') ?></th>
                            <th><?php ee('PayPal') ?></th>
                            <th><?php ee('Status') ?></th>
                            <th><?php ee('Requested At') ?></th>
                            <th><?php ee('Processed At') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($withdrawals as $w): ?>
                            <tr>
                                <td><?php echo \Helpers\App::currency(config('currency'), $w->amount) ?></td>
                                <td><?php echo e($w->paypal) ?></td>
                                <td>
                                    <?php if($w->status == 'pending'): ?>
                                        <span class="badge bg-warning"><?php ee('Pending') ?></span>
                                    <?php elseif($w->status == 'approved'): ?>
                                        <span class="badge bg-success"><?php ee('Approved') ?></span>
                                    <?php elseif($w->status == 'rejected'): ?>
                                        <span class="badge bg-danger"><?php ee('Rejected') ?></span>
                                    <?php endif; ?>

                                    <?php if($w->note): ?>
                                        <span class="ms-1 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $w->note ?>"><i class="fa fa-question-circle"></i></span>
                                    <?php endif ?>
                                </td>
                                <td><?php echo \Core\Helper::dtime($w->created_at) ?></td>
                                <td><?php echo $w->processed_at ? \Core\Helper::dtime($w->processed_at) : '-' ?></td>
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
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4"><?php ee('Current Earning') ?></h5>
                <h1 class="text-success mb-4"><?php echo \Helpers\App::currency(config('currency'), $user->pendingpayment ?? 0) ?></h1>
                <p class="mb-3 text"><?php ee('Minimum earning of {amount} is required for payment.', null, ['amount' => \Helpers\App::currency(config('currency'), $min_payout)]) ?></p>
                <?php if($pendingpayment >= $min_payout): ?>
                    <form action="<?php echo route('user.withdrawals.request') ?>" method="post">
                        <?php echo csrf() ?>
                        <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 mt-2"><?php ee('Request Withdrawal') ?></button>
                    </form>
                <?php endif ?>
            </div>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4"><?php ee('PayPal Email') ?></h5>
                <p><?php ee('Please enter your PayPal email so we can send you your commission') ?></p>
                <form action="<?php echo route('user.affiliate.save') ?>" method="post">
                    <input type="text" class="form-control p-2" name="paypal" placeholder="e.g. email@domain.com" value="<?php echo $user->paypal ?>">
                    <?php echo csrf() ?>
                    <button type="submit" class="btn btn-primary rounded-3 px-3 py-2 mt-4"><?php ee('Save') ?></button>
                </form>
            </div>
        </div>
    </div>
</div> 