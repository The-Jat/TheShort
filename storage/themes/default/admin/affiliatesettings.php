<h1 class="h3 mb-5 fw-bold"><?php ee('Affiliate Settings') ?></h1>

<div class="row">
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="affiliate[enabled]" class="form-label fw-bold"><?php ee('Enable Affiliates') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="affiliate[enabled]" name="affiliate[enabled]" value="1" <?php echo config("affiliate")->enabled ? 'checked':'' ?>>
                            <label class="form-check-label" for="homepage_stats"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enable customers to earn commission on qualifying sales.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="affiliate[type]" class="form-label fw-bold"><?php ee('Commission Type') ?></label>
                        <select name="affiliate[type]" id="affiliate[type]" class="form-select p-2">
                            <option value="percent" <?php echo !isset($affiliate->type) || $affiliate->type == 'percent' ? 'selected' : '' ?>><?php ee('Percentage') ?></option>
                            <option value="fixed"  <?php echo isset($affiliate->type) && $affiliate->type == 'fixed' ? 'selected' : '' ?>><?php ee('Fixed Amount') ?></option>
                        </select>
                        <p class="form-text"><?php ee('Choose the type of rate your are paying. Percentage or fixed amount.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="affiliate[rate]" class="form-label fw-bold"><?php ee('Commission Rate') ?></label>
                        <input type="text" class="form-control p-2" name="affiliate[rate]" id="affiliate[rate]" value="<?php echo $affiliate->rate ?>">
                        <p class="form-text"><?php ee('Enter the commission you want to give to users.').' '.ee('If type is percentage, the rate will be calculated as the percentage of the sales amount. If type is fixed then the fixed amount will be paid regardless of sales amount.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="affiliate[freq]" class="form-label fw-bold"><?php ee('Commission Frequency') ?></label>
                        <select name="affiliate[freq]" id="affiliate[freq]" class="form-select p-2">
                            <option value="once" <?php echo !isset($affiliate->freq) || $affiliate->freq == 'once' ? 'selected' : '' ?>><?php ee('Once on first payment') ?></option>
                            <option value="recurring"  <?php echo isset($affiliate->freq) && $affiliate->freq == 'recurring' ? 'selected' : '' ?>><?php ee('Recurring on each payment') ?></option>
                        </select>
                        <p class="form-text"><?php ee('Choose whether to pay users once or on a recurring basis.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="affiliate[payout]" class="form-label fw-bold"><?php ee('Minimum Payout') ?></label>
                        <input type="text" class="form-control p-2" name="affiliate[payout]" id="affiliate[payout]" value="<?php echo $affiliate->payout ?>">
                        <p class="form-text"><?php ee('Enter the minimum amount of commission to qualify for a payout.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="affiliate[terms]" class="form-label fw-bold"><?php ee('Terms') ?></label>
                        <textarea id="affiliate[terms]" class="form-control p-2" name="affiliate[terms]"><?php echo $affiliate->terms ?></textarea>
                        <p class="form-text"><?php ee('Add your custom terms for affiliate.') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>   
    <div class="col-md-6">
        <div class="card rounded-4">
            <div class="card-body">
                <h5 class="card-title fw-bold"><?php ee('Affiliate Rate') ?></h5>
                <?php if($affiliate->rate): ?>
                    <h1 class="text-success"><?php echo (isset($affiliate->type) && $affiliate->type == 'fixed' ? \Helpers\App::currency(config('currency'), $affiliate->rate) : $affiliate->rate.'%') ?> <span class="text-dark text-sm"><?php ee('per qualifying sales') ?> <?php echo (isset($affiliate->freq) && $affiliate->freq == 'recurring' ? e('per user payment (recurring)') : e('paid once')) ?></span></h1>
                    <p class="mb-3 text"><?php ee('Minimum earning of {amount} is required for payment.', null, ['amount' => \Helpers\App::currency(config('currency'), $affiliate->payout)]) ?></p>
                <?php endif ?>
                <?php if($affiliate->terms): ?>
                    <h6 class="fw-bold"><?php ee('Terms') ?></h6>
                    <p class="mb-4"><?php ee($affiliate->terms) ?></p>
                <?php endif ?>
            </div>
        </div>
    </div> 
</div>