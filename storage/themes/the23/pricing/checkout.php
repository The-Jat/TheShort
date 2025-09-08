<section class="bg-primary py-10">
    <div class="container">
        <h3 class="h1 fw-bolder text-start mb-5"><?php ee('Checkout') ?></h3>
        <?php echo message() ?>
        <form action="<?php echo route('checkout.process', [$plan->id, $type]) ?>" method="post" id="payment-form">
            <?php echo csrf() ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold"><?php ee('Payment Method') ?></h5>
                            <div class="mt-3 btn-stack d-block d-sm-flex" data-bs-toggle="buttons">
                                <?php $i = 0; foreach($processors as $name => $processor): ?>
                                    <?php if(!config($name) || !config($name)->enabled) continue ?>
                                    <label class="btn py-3 px-4 text-start mb-2 d-block flex-sm-fill <?php echo ($i == 0 ? 'active':'') ?>">
                                        <input type="radio" name="payment" class="d-none" value="<?php echo $name ?>" autocomplete="off" <?php echo ($i == 0 ? 'checked':'') ?>>
                                        <?php if(isset($processor['logos']) && $processor['logos']): ?>
                                            <p class="mb-2">
                                            <?php foreach($processor['logos'] as $logos): ?>
                                                <?php echo $logos ?>
                                            <?php endforeach ?>
                                            </p>
                                        <?php endif ?>
                                        <strong><?php echo $processor['name'] ?></strong>
                                    </label>
                                <?php $i++; endforeach ?>
                            </div>
                            <?php foreach($processors as $name => $processor): ?>
                                <?php if(!config($name) || !config($name)->enabled) continue ?>
                                <?php if($processor['checkout']): ?>
                                    <div class="mt-4"><?php call_user_func($processor['checkout'], $plan) ?></div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3"><?php ee('Billing Address') ?></h5>

                            <div class="mt-3 mb-5 btn-stack d-flex" data-bs-toggle="buttons">
                                <label class="btn py-3 px-4 flex-fill fw-bold <?php echo (!isset($user->address->type) || $user->address->type != 'business' ? 'active' : '') ?>">
                                    <input type="radio" name="type" class="d-none" value="personal" data-toggle="customertype" autocomplete="off" <?php echo (!isset($user->address->type) || $user->address->type != 'business' ? 'checked' : '') ?>> <?php ee('Personal') ?>
                                </label>
                                <label class="btn py-3 px-4 flex-fill fw-bold <?php echo (isset($user->address->type) && $user->address->type == 'business' ? 'active' : '') ?>">
                                    <input type="radio" name="type" class="d-none" value="business" data-toggle="customertype" autocomplete="off" <?php echo (isset($user->address->type) && $user->address->type == 'business' ? 'checked' : '') ?>> <?php ee('Business') ?>
                                </label>
                            </div>
                            <div id="company" class="<?php echo (isset($user->address->type) && $user->address->type == 'business' ? '' : 'd-none') ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold" for="company"><?php echo e("Company") ?></label>
                                            <input type="text" class="form-control p-2" id="company" name="company" placeholder="e.g. Acme Inc" value="<?php echo (isset($user->address->company) ? $user->address->company : "" ) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold" for="taxid"><?php echo e("Tax ID (optional)") ?></label>
                                            <input type="text" class="form-control p-2" id="taxid" name="taxid" placeholder="e.g. 123456" value="<?php echo (isset($user->address->taxid) ? $user->address->taxid : "" ) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold" for="name"><?php echo e("Full Name") ?></label>
                                <input type="text" class="form-control p-2" id="name" name="name" value="<?php echo $user->name ?>">
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label fw-bold" for="address"><?php echo e("Address") ?></label>
                                <input type="text" class="form-control p-2" id="address" name="address" value="<?php echo (isset($user->address->address) ? $user->address->address : "" ) ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold" for="city"><?php echo e("City") ?></label>
                                        <input type="text" class="form-control p-2" id="city" name="city" placeholder="e.g. New York" value="<?php echo (isset($user->address->city) ? $user->address->city : "" ) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold" for="state"><?php echo e("State/Province") ?></label>
                                        <input type="text" class="form-control p-2" id="state" name="state" placeholder="e.g. NY" value="<?php echo (isset($user->address->state) ? $user->address->state : "" ) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold" for="country"><?php echo e("Country") ?></label>
                                        <select name="country" id="country" class="form-select p-2" data-toggle="select">
                                            <?php echo \Core\Helper::Country($user->address->country ?? request()->country()['country'], true, true) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-bold" for="zip"><?php echo e("Zip/Postal code") ?></label>
                                        <input type="text" class="form-control p-2" id="zip" name="zip" placeholder="e.g. 44205" value="<?php echo (isset($user->address->zip) ? $user->address->zip : "" ) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-2">
                        <div class="card-body p-4">
                            <div class="mb-5 btn-stack d-flex" data-bs-toggle="buttons">
                                <?php if($plan->price_lifetime && $plan->price_lifetime != "0.00"): ?>
                                <a href="<?php echo route('checkout', [$plan->id, 'lifetime']) ?>" class="btn small flex-fill <?php echo $type == 'lifetime' ? 'active' : '' ?>">
                                    <?php ee('Lifetime') ?>
                                </a>
                                <?php endif ?>
                                <?php if($plan->price_monthly && $plan->price_monthly != "0.00"): ?>
                                <a href="<?php echo route('checkout', [$plan->id, 'monthly']) ?>" class="btn small flex-fill <?php echo $type == 'monthly' ? 'active' : '' ?>">
                                    <?php ee('Monthly') ?>
                                </a>
                                <?php endif ?>
                                <?php if($plan->price_yearly && $plan->price_yearly != "0.00"): ?>
                                <a href="<?php echo route('checkout', [$plan->id, 'yearly']) ?>" class="btn small flex-fill <?php echo $type == 'yearly' ? 'active' : '' ?>">
                                    <?php ee('Yearly') ?>
                                </a>
                                <?php endif ?>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col d-flex align-items-center">
                                    <?php if($plan->icon): ?>
                                        <strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3 me-3">
                                            <i class="fa <?php echo $plan->icon ?? 'fa-star' ?> gradient-primary clip-text fw-bolder"></i>
                                        </strong>
                                    <?php endif ?>
                                    <strong><?php echo $plan->name ?></strong>
                                </div>
                                <div class="col-auto">
                                    <?php echo \Helpers\App::currency(config('currency'), $plan->price) ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <strong><?php ee('Subtotal') ?></strong>
                                </div>
                                <div class="col-auto" id="subtotal">
                                    <?php echo \Helpers\App::currency(config('currency'), $plan->price) ?>
                                </div>
                            </div>
                            <div class="form-group mb-4 mt-4 collapse" id="promocode">
                                <label class="form-label" for="coupon"><?php echo e("Promo Code") ?></label>
                                <div class="input-group p-2 d-flex align-items-center border rounded">
                                    <input type="text" data-url="<?php echo route('checkout.coupon', [$plan->id, $type]) ?>" class="form-control border-0" id="coupon" name="coupon" placeholder="<?php ee('Enter promo code') ?>">
                                    <span>
                                        <button type="button" data-trigger="applycoupon" class="btn btn-sm btn-primary"><?php ee('Apply') ?></button>
                                    </span>
                                </div>
                                <span id="couponresponse"></span>
                            </div>
                            <a href="#promocode" data-bs-toggle="collapse"><?php ee('Apply promo code') ?></a>
                            <div class="form-group mb-4 mt-4 collapse">
                                <div class="row">
                                    <div class="col">
                                        <?php ee('Discount') ?>
                                    </div>
                                    <div class="col-auto" id="discount"></div>
                                </div>
                            </div>
                            <div id="taxrate" data-url="<?php echo route('checkout.tax', [$plan->id, $type]) ?>">
                                <?php if($tax): ?>
                                    <div class="form-group mb-4 mt-4">
                                        <div class="row">
                                            <div class="col">
                                                <?php echo "{$tax->name} ({$tax->rate}%)" ?>
                                            </div>
                                            <div class="col-auto" id="taxamount">
                                                <?php echo \Helpers\App::currency(config('currency'), $tax->price); $plan->price = $plan->price + $tax->price;?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <strong><?php ee('Total') ?></strong>
                                </div>
                                <div class="col-auto text-end">
                                    <span id="total"><?php echo \Helpers\App::currency(config('currency'), $plan->price) ?></span>
                                    <p class="small"><?php echo $type == 'lifetime' ? e('One-time payment') : e('Billed').' '.e($type) ?></p>
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-3"><small><?php ee('Checkout') ?></small></button>
                            </div>
                        </div>
                    </div>
                    <?php if(\Helpers\App::isExtended()): ?>
                    <div class="d-flex w-100 mt-3">
                        <a href="#redeemvoucher" class="text-dark ms-auto" data-bs-toggle="modal"><i class="fa fa-ticket-alt me-2"></i> <?php ee('Redeem Voucher') ?></a>
                    </div>
                    <?php endif ?>
                    <div class="card border-0 shadow-sm mt-4 p-4">
                        <?php ee('By subscribing to this plan, you agree to our Terms & Conditions. Subscription is charged in {c}. If you have any questions, please contact us.', null, ['c' => config('currency')]) ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php if(\Helpers\App::isExtended()): ?>
    <div class="modal fade" id="redeemvoucher" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="<?php echo route('checkout.redeem') ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"><?php ee('Redeem Voucher') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo csrf() ?>
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold label"><?php ee('Voucher') ?></label>
                            <input type="text" class="form-control p-2" id="input-voucher" name="code" placeholder="e.g. A1A1-A1A1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><?php ee('Redeem') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>