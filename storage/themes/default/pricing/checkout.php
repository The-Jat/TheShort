<section class="slice slice-lg pb-0 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
    <div class="container position-relative zindex-100"> </div>
</section>
<section class="bg-section-secondary pt-4">
    <div class="container">
        <?php echo message() ?>
        <form action="<?php echo route('checkout.process', [$plan->id, $type]) ?>" method="post" id="payment-form">
            <?php echo csrf() ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="card-title"><?php ee('Payment Method') ?></h6>
                            <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">
                                <?php $i = 0; foreach($processors as $name => $processor): ?>
                                    <?php if(!config($name) || !config($name)->enabled) continue ?>
                                    <label class="btn btn-outline-light <?php echo themeSettings::isDark() ? 'text-white' : 'text-dark' ?> border <?php echo ($i == 0 ? 'active':'') ?>">
                                        <input type="radio" name="payment" value="<?php echo $name ?>" autocomplete="off" <?php echo ($i == 0 ? 'checked':'') ?>> <?php echo $processor['name'] ?>
                                    </label>
                                <?php $i++; endforeach ?>
                            </div>
                            <?php foreach($processors as $name => $processor): ?>
                                <?php if(!config($name) || !config($name)->enabled) continue ?>
                                <?php if($processor['checkout']): ?>
                                    <?php call_user_func($processor['checkout'], $plan) ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body">                    
                            <h6 class="card-title"><?php ee('Billing Address') ?></h6>

                            <div class="mt-3 mb-5 btn-stack d-flex" data-bs-toggle="buttons">
                                <label class="btn btn-outline-light py-3 px-4 flex-fill fw-bold <?php echo themeSettings::isDark() ? 'text-white' : 'text-dark' ?> <?php echo (!isset($user->address->type) || $user->address->type != 'business' ? 'active' : '') ?>">
                                    <input type="radio" name="type" class="d-none" value="personal" data-toggle="customertype" autocomplete="off" <?php echo (!isset($user->address->type) || $user->address->type != 'business' ? 'checked' : '') ?>> <?php ee('Personal') ?>
                                </label>
                                <label class="btn btn-outline-light py-3 px-4 flex-fill fw-bold <?php echo themeSettings::isDark() ? 'text-white' : 'text-dark' ?> <?php echo (isset($user->address->type) && $user->address->type == 'business' ? 'active' : '') ?>">
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
                                            <label class="form-label fw-bold" for="taxid"><?php echo e("Tax ID") ?></label>
                                            <input type="text" class="form-control p-2" id="taxid" name="taxid" placeholder="e.g. 123456" value="<?php echo (isset($user->address->taxid) ? $user->address->taxid : "" ) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name"><?php echo e("Full Name") ?></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user->name ?>">
                            </div>
                            <div class="form-group">
                                <label for="address"><?php echo e("Address") ?></label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo (isset($user->address->address) ? $user->address->address : "" ) ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city"><?php echo e("City") ?></label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="e.g. New York" value="<?php echo (isset($user->address->city) ? $user->address->city : "" ) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state"><?php echo e("State/Province") ?></label>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="e.g. NY" value="<?php echo (isset($user->address->state) ? $user->address->state : "" ) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country"><?php echo e("Country") ?></label>
                                        <select name="country" id="country" class="form-control" data-toggle="select">
                                            <?php echo \Core\Helper::Country($user->address->country ?? request()->country()['country'], true, true) ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zip"><?php echo e("Zip/Postal code") ?></label>
                                        <input type="text" class="form-control" id="zip" name="zip" placeholder="e.g. 44205" value="<?php echo (isset($user->address->zip) ? $user->address->zip : "" ) ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-section-dark border-0 rounded-lg mb-2">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title text-white"><?php ee('Summary') ?></h6>
                        </div>
                        <div class="card-body text-white">
                            <div class="row">
                                <div class="col">
                                    <strong><?php echo $plan->name ?></strong>
                                </div>
                                <div class="col-auto">
                                    <?php echo \Helpers\App::currency(config('currency'), $plan->price) ?>
                                </div>
                            </div>
                            <hr class="opacity-2">
                            <div class="row">
                                <div class="col">
                                    <strong><?php ee('Subtotal') ?></strong>
                                </div>
                                <div class="col-auto" id="subtotal">
                                    <?php echo \Helpers\App::currency(config('currency'), $plan->price) ?>
                                </div>
                            </div>
                            <div class="form-group mt-4 collapse" id="promocode">
                                <label for="coupon"><?php echo e("Promo Code") ?></label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" data-url="<?php echo route('checkout.coupon', [$plan->id, $type]) ?>" class="form-control form-control-sm" id="coupon" name="coupon" placeholder="">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" data-trigger="applycoupon" class="btn btn-sm btn-primary"><?php ee('Apply') ?></button>
                                    </div>
                                </div>
                            </div>
                            <a href="#promocode" data-toggle="collapse"><?php ee('Apply promo code') ?></a>
                            <div class="form-group mt-4 collapse">
                                <div class="row">
                                    <div class="col">
                                        <?php ee('Discount') ?>
                                    </div>
                                    <div class="col-auto" id="discount"></div>
                                </div>
                            </div>
                            <div id="taxrate" data-url="<?php echo route('checkout.tax', [$plan->id, $type]) ?>">
                                <?php if($tax): ?>
                                    <div class="form-group mt-4">
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
                            <hr class="opacity-2">
                            <div class="row">
                                <div class="col">
                                    <strong><?php ee('Total') ?></strong>
                                </div>
                                <div class="col-auto text-right">
                                    <span id="total"><?php echo \Helpers\App::currency(config('currency'), $plan->price) ?></span>
                                    <p class="text-sm"><?php echo $type == 'lifetime' ? e('One-time payment') : e('Billed').' '.e($type) ?></p>
                                </div>
                            </div>
                            <div class="d-flex mt-5">
                                <div class="ml-auto">
                                    <button type="submit" class="btn btn-primary btn-sm"><?php ee('Checkout') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(\Helpers\App::possible()): ?>
                    <div class="d-flex w-100">
                        <a href="#redeemvoucher" class="text-dark ml-auto" data-toggle="modal"><i class="fa fa-ticket-alt mr-2"></i> <?php ee('Redeem Voucher') ?></a>
                    </div>
                    <?php endif ?>
                    <div class="card rounded card-body mt-4">
                        <?php ee('By subscribing to this plan, you agree to our Terms & Conditions. Subscription is charged in {c}. If you have any questions, please contact us.', null, ['c' => config('currency')]) ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php if(\Helpers\App::possible()): ?>
<div class="modal fade" id="redeemvoucher" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form action="<?php echo route('checkout.redeem') ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><i class="fa fa-ticket-alt mr-2"></i> <?php ee('Redeem Voucher') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo ee('Close') ?>">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group">
                    <label class="form-control-label"><?php ee('Voucher') ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="fa fa-ticket-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" id="input-voucher" name="code" placeholder="e.g. A1A1-A1A1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo ee('Close') ?></button>
                <button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Redeem') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>