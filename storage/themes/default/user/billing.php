<h1 class="h3 mb-5 fw-bold"><?php ee('Billing') ?></h1>
<div class="row">
    <div class="col-md-8">
        <?php if($subscriptions): ?>
        <h4 class="fw-bold mb-3"><?php ee('Subscription History') ?></h4>
        <div class="card shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee("Since") ?></th>
                            <th><?php ee("Next Payment") ?></th>
                            <th><?php ee("Status") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($subscriptions as $subscription): ?>
                            <tr>
                                <td><?php echo date("d F, Y",strtotime($subscription->date)) ?></td>
                                <td><?php echo $subscription->plan != 'lifetime' ? date("d F, Y",strtotime($subscription->expiry)) : '' ?></td>
                                <td><?php echo ($subscription->status == "Completed" ? e("Active") : e($subscription->status)) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif ?>
        <h4 class="mb-3 mt-5 fw-bold"><?php ee('Payment History') ?></h4>
        <div class="card shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee("Transaction ID") ?></th>
                            <th><?php ee("Amount") ?></th>
                            <th><?php ee("Date") ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($payments as $payment): ?>
                            <tr>
                                <td><?php echo ($payment->status == "Refunded" ? "<span class='badge bg-danger'>".e("Refunded")."</span> ":"").$payment->tid ?></td>
                                <td><?php echo ($payment->status == "Refunded" ? "-" :"").($payment->trial_days ? e('Free Trial') : \Helpers\App::currency(config("currency"), $payment->amount)) ?></td>
                                <td><?php echo date("d F, Y",strtotime($payment->date)) ?></td>
                                <td><?php if(!$payment->trial_days): ?><a href="<?php echo route('invoice', [$payment->tid]) ?>" class="btn btn-sm btn-dark rounded-3"><?php ee('View Invoice') ?></a><?php endif ?></td>                                
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php if($user->admin || $user->pro() || $user->planid): ?>
        <h4 class="mb-3 fw-bold"><?php ee('Current Plan') ?></h4>
        <div class="card shadow-sm rounded-4 rounded-4 position-relative">
            <div class="card-body">
                <div class="text-center">
                    <h5 class="mb-3 fw-bold"><?php echo $plan['name'] ?></h5>
                    <?php if(\Helpers\App::possible() && $subscription = \Core\DB::subscription()->where('userid', user()->id)->where('status', 'Active')->first()):?>
                        <?php if($subscription->plan != 'lifetime'): ?>
                        <h5 class="mb-3"><?php ee('Expiration') ?>: <?php echo date('d F, Y', strtotime($user->expiration)) ?></h5>
                        <?php endif ?>
                    <?php endif ?>
                </div>
                <div class="border rounded rounded-4 p-3 mb-3">
                    <ul class="list-unstyled mb-4 text-left text-sm">
                        <li class="mb-1"><span data-feather="check-circle" class="mr-1 text-success"></span> <?php echo $plan["urls"] == "0" ? e("Unlimited") : $plan["urls"].($plan['ismonthly'] ? e('/mo') : '') ?> <?php echo e("URLs allowed") ?></li>
                        <li class="mb-1"><span data-feather="check-circle" class="mr-1 text-success"></span> <?php echo $plan["clicks"] == "0" ? e("Unlimited") : $plan["clicks"] ?> <?php echo e("Clicks per month") ?></li>                     
                        <li class="mb-1"><span data-feather="check-circle" class="mr-1 text-success"></span> <?php echo $plan["retention"] == "0" ? e("Unlimited") : $plan["retention"].' '.e('days') ?> <?php ee("Data Retention") ?></li>
                        <?php if($features = \Helpers\App::features()): ?>
                            <?php foreach($features as $slug => $feature): ?>
                                <?php if($feature['count']): ?>
                                    <?php if($slug == 'apirate'): ?>
                                        <li class="mb-1"><?php echo isset($plan["permission"]->$slug->enabled) && $plan["permission"]->$slug->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php if(isset($plan["permission"]->$slug->enabled) && $plan["permission"]->$slug->count > 0): ?> <?php echo ($plan["permission"]->$slug->count == "0" ? e("Unlimited").e('/min') : $plan["permission"]->$slug->count.e('/min'))?><?php endif ?>  <?php echo $feature['name'] ?></li>
                                    <?php else: ?>
                                        <li class="mb-1"><?php echo isset($plan["permission"]->$slug->enabled) && $plan["permission"]->$slug->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span>' : '<span data-feather="x-circle" class="text-danger mr-1"></span>' ?>  <?php if(isset($plan["permission"]->$slug->enabled)): ?><?php echo ($plan["permission"]->$slug->count == "0" ? e("Unlimited") : $plan["permission"]->$slug->count)." ".$feature['name']; ?><?php endif ?></li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <li class="mb-1"><?php echo isset($plan["permission"]->$slug->enabled) && $plan["permission"]->$slug->enabled ? '<span data-feather="check-circle" class="mr-1 text-success"></span> ' : '<span data-feather="x-circle" class="text-danger mr-1"></span> ' ?>  <?php echo $feature['name'] ?></li>
                                <?php endif ?> 
                            <?php endforeach ?>
                        <?php endif ?>
                        <li class="mb-1"><?php echo $plan["free"]  ? '<span data-feather="x-circle" class="mr-1 text-danger"></span>' : '<span data-feather="check-circle" class="text-success"></span>' ?> <?php echo e("Advertisement-Free") ?></li>
                        <?php echo $plan["permission"]->custom  ? '<li class="mb-1"><span data-feather="check-circle" class="text-success"></span> '.$plan["permission"]->custom.'</li>' : '' ?>
                    </ul>
                    <a href="<?php echo route('pricing') ?>" class="btn btn-primary w-100"><?php ee('Change plan') ?></a>
                </div>
            </div>
        </div>
        <?php endif ?>
        <?php if(\Helpers\App::possible()): ?>
            <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3"><?php ee('Redeem Voucher') ?></h5>
                        <form action="<?php echo route('checkout.redeem') ?>" method="post">
                            <?php echo csrf() ?>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control p-2" id="input-voucher" name="code" placeholder="e.g. A1A1-A1A1">
                            </div>
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm w-100"><?php ee('Redeem') ?></button>
                        </form>
                    </div>
                </div>
            <?php if($user->pro): ?>
                <?php if(user()->hasPortal()): ?>
                    <div class="card shadow-sm rounded-4">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title fw-bold"><?php ee("Manage Membership") ?></h5>
                        </div>
                        <div class="card-body">
                            <p><?php ee("You can manage your membership on directly on the payment processor where you can update your credit card and view your invoices.") ?></p>
                            <p><a href="<?php echo route('billing.manage') ?>" class="btn btn-success px-5 py-2 rounded-3 shadow-sm" target="_blank"><?php ee("Manage Membership") ?></a></p>
                        </div>
                    </div>
                <?php endif ?>
                <?php if(\Helpers\App::possible() && $subscription = \Core\DB::subscription()->where('userid', user()->id)->where('status', 'Active')->first()):?>
                    <?php if($subscription->plan != 'lifetime'): ?>
                        <div class="card shadow-sm rounded-4">
                            <div class="card-header bg-transparent">
                                <h5 class="card-title fw-bold"><?php ee("Cancel Membership") ?></h5>
                            </div>
                            <div class="card-body">
                                <p><?php ee("You can cancel your membership whenever you want. Upon request, your membership will be canceled right before your next payment period. This means you can still enjoy premium features until the end of your membership.") ?></p>
                                <p><a href="#" data-bs-toggle="modal" data-bs-target="#cancelModal" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm"><?php ee("Cancel membership") ?></a></p>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>
<?php if($user->pro): ?>
<div class="modal fade" id="cancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="<?php echo route('cancel') ?>" method="post">
    <?php echo csrf() ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Cancel Membership') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p><?php ee('We respect your decision and we are sorry to see you go. If you want to share anything with us, please use the box below and we will do our best to improve our service.') ?></p>

                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Password") ?></label>
                    <input type="password" name="password" class="form-control p-2">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Reason for cancellation") ?></label>
                    <textarea name="reason" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm"><?php ee('Cancel membership') ?></button>
            </div>
        </div>
    </form>
  </div>
</div>
<?php endif ?>