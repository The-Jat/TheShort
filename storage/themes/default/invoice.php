<div class="d-flex align-items-center mb-5 page-header">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Invoice') ?></h1>
    <div class="ms-auto">
        <a href="javascript:window.print();" class="btn btn-primary rounded-3 px-3 py-2"><i class="fa fa-print"></i></a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm rounded-4">
            <div class="d-flex p-4 align-items-center">
                <div>
                    <a class="navbar-brand" href="<?php echo route('home') ?>">
                        <?php if(config('logo')): ?>
                            <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo" width="100">
                        <?php else: ?>
                            <h1 class="h2 mt-2 ms-4 fw-bold"><?php echo config('sitename') ?></h1>
                        <?php endif ?>
                    </a>
                </div>
                <div class="ms-auto">
                    <?php if($payment->status == "Completed" || $payment->status == "Refunded"): ?>
                        <span class="px-4 badge bg-success fs-4"><?php echo e($payment->status) ?></span>
                    <?php else: ?>
                        <span class="px-4 badge bg-warning fs-4"><?php echo e('Pending') ?></span>
                    <?php endif ?>
                </div>
            </div>
            <div class="card-body m-sm-3 m-md-5 border rounded-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="fw-bold"><?php ee('Invoice') ?></div>
                        <span><?php echo $payment->tid ?></span>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="fw-bold"><?php ee('Payment Date') ?></div>
                        <span><?php echo \Core\Helper::dtime($payment->date, 'd/m/Y') ?></span>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row mb-4">
                    <div class="col-md-6">
                    <div class="fw-bold"><?php ee('Bill to') ?></div>
                        <span>
                        <?php if(isset($user->address->company)): ?>
                            <?php echo $user->address->company ?><br>
                            <?php echo isset($user->address->taxid) && $user->address->taxid ? e('Tax ID:').' '.$user->address->taxid : '' ?>
                        <?php else: ?>
                            <?php echo $user->name ?: $user->username ?>
                        <?php endif ?>
                        </span>
                        <p><?php echo $user->email ?></p>
                        <p>
                            <?php echo $user->address->address?: '' ?> <br />
                            <?php echo $user->address->city?: '' ?> <?php echo $user->address->state?: '' ?> <br />
                            <?php echo $user->address->zip?: '' ?> <br />
                            <?php echo $user->address->country?: '' ?> <br />
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="fw-bold"><?php ee('Payment To') ?></div>
                        <?php echo nl2br(config('invoice')->header) ?>
                    </div>
                </div>

                <div class="border border-2 rounded">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th><?php ee('Description') ?></th>
                                <th></th>
                                <th class="text-end"><?php ee('Amount') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!$payment->trial_days && $tax = \Core\DB::taxrates()->whereRaw('countries LIKE ?', ["%".clean($user->address->country)."%"])->first()): ?>
                                <?php $beforetax = round($payment->amount / (1+($tax->rate/100)), 2) ?>
                                <tr class="border-0 border-top border-3">
                                    <td>
                                        <?php ee('Subscription') ?>
                                        <?php echo isset($payment->data->planname) ? " - {$payment->data->planname}" : '' ?>
                                    </td>
                                    <td></td>
                                    <td class="text-end"><?php echo $payment->trial_days ? 'Trial' : \Helpers\App::currency(config('currency'), number_format($beforetax, 2)) ?></td>
                                </tr>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th class="text-end"><?php ee('Tax') ?> - <?php echo $tax->name ?> (<?php echo $tax->rate ?>%)</th>
                                    <th class="text-end"><?php echo \Helpers\App::currency(config('currency'), number_format(($tax->rate/100)*$beforetax, 2)) ?></th>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td>
                                        <?php ee('Subscription') ?>
                                        <?php echo isset($payment->data->planname) ? " - {$payment->data->planname}" : '' ?>                                        
                                    </td>
                                    <td></td>
                                    <td class="text-end"><?php echo $payment->trial_days ? 'Trial' : \Helpers\App::currency(config('currency'), $payment->amount) ?></td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-end"><?php ee('Total') ?></th>
                                <th class="text-end"><?php echo $payment->trial_days ? 'Trial' : \Helpers\App::currency(config('currency'), $payment->amount) ?></th>
                            </tr>
                        </tbody>
                    </table>                    
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm">
                        <?php echo nl2br(config('invoice')->footer) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
