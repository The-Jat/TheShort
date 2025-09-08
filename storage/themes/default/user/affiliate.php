<h1 class="h3 mb-5 fw-bold"><?php ee('Affiliate') ?></h1>
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4"><?php ee('Current Earning') ?></h5>
                <h1 class="text-success"><?php echo \Helpers\App::currency(config('currency'), $user->pendingpayment ?? 0) ?></h1>
                <?php if($user->pendingpayment >= $affiliate->payout): ?>
                    <a href="<?php echo route('user.withdrawals') ?>" class="btn btn-primary rounded-3 px-3 py-2 w-100 mt-4"><?php ee('Withdraw') ?></a>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4"><?php ee('Lifetime Earnings') ?></h5>
                <h1 class="text-success"><?php echo \Helpers\App::currency(config('currency'), $totalsales) ?></h1>
            </div>
        </div>
    </div>    
    <div class="col-md-3">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4"><?php ee('Total Referrals') ?></h5>
                <h1 class="text-success"><?php echo $total ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4"><?php ee('Affiliate Link') ?></h5>
                <div class="d-flex align-items-center border rounded-3 p-2">
                    <span class="fw-bold"><?php echo url("?ref=".($user->username ?? $user->id)) ?></span>
                    <div class="ms-auto">
                        <button class="btn btn-outline-primary copy" data-clipboard-text="<?php echo url("?ref=".($user->username ?? $user->id)) ?>"><?php ee('Copy') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center mb-4 mt-5">
            <h4 class="fw-bold mb-0"><?php ee('Referral History') ?></h4>
            <a href="<?php echo route('user.withdrawals') ?>" class="btn bg-white border shadow-sm px-3 py-2 rounded-3 ms-auto"><?php ee('Withdrawals') ?></a>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Commission') ?></th>
                            <th><?php ee('Referred On') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sales as $sale): ?>
                            <tr>
                                <td>
                                    <?php echo \Helpers\App::currency(config('currency'), $sale->amount) ?>
                                    <?php if($sale->status == "1" || $sale->status == "3"): ?>
                                        <span class="ms-1 badge bg-success"><?php ee('Approved') ?></span>
                                    <?php elseif($sale->status == "2"): ?>
                                        <span class="ms-1 badge bg-warning"><?php ee('Rejected') ?></span>
                                    <?php else: ?>
                                        <span class="ms-1 badge bg-danger"><?php ee('Pending') ?></span>
                                    <?php endif ?>
                                </td>
                                <td><?php echo \Core\Helper::dtime($sale->referred_on, 'd-m-Y') ?></td>
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
                <h5 class="fw-bold mb-4"><?php ee('Affiliate Rate') ?></h5>
                <?php if($affiliate->rate): ?>
                    <h1 class="text-success"><?php echo (isset($affiliate->type) && $affiliate->type == 'fixed' ? \Helpers\App::currency(config('currency'), $affiliate->rate) : $affiliate->rate.'%') ?> <span class="text-dark text-sm"><?php ee('per qualifying sales') ?> <?php echo (isset($affiliate->freq) && $affiliate->freq == 'recurring' ? e('per user payment (recurring)') : e('paid once')) ?></span></h1>
                    <p class="mb-3 text"><?php ee('Minimum earning of {amount} is required for payment.', null, ['amount' => \Helpers\App::currency(config('currency'), $affiliate->payout)]) ?></p>
                <?php endif ?>
                <?php if($affiliate->terms): ?>
                    <hr>
                    <h6 class="fw-bold"><?php ee('Terms') ?></h6>
                    <p class="mb-4"><?php ee($affiliate->terms) ?></p>
                <?php endif ?>
                <a href="<?php echo route('contact') ?>" class="btn btn-primary rounded-3 px-5 py-2"><?php ee('Contact') ?></a>
            </div>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4"><?php ee('PayPal Email') ?></h5>
                <p><?php ee('Please enter your PayPal email so we can send you your commission') ?></p>
                <form action="<?php echo route('user.affiliate.save') ?>" method="post">
                    <input type="text" class="form-control p-2" name="paypal" placeholder="e.g. email@domain.com" value="<?php echo $user->paypal ?>">
                    <?php echo csrf() ?>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 mt-2"><?php ee('Save') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>