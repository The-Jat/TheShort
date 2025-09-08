<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.coupons') ?>"><?php ee('Coupons') ?></a></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('New Coupon') ?></h1>

<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.coupons.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                <input type="text" class="form-control p-2" name="name" id="name" value="" placeholder="My Sample Coupon" required>
            </div>                    
            <div class="form-group mb-4">
                <label for="description" class="form-label fw-bold"><?php ee('Description') ?></label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group mb-4">
                <label for="code" class="form-label fw-bold"><?php ee('Promo Code') ?></label>
                <input type="text" class="form-control p-2" name="code" id="code" value="" placeholder="e.g. SAVE20" required>
            </div> 
            <div class="form-group mb-4">
                <label for="discount" class="form-label fw-bold"><?php ee('Discount Percentage') ?></label>
                <input type="number" class="form-control p-2" name="discount" id="discount" value="" max="100" min="1" placeholder="e.g. 20" required>
            </div>                     
            <div class="form-group mb-4">
                <label for="maxuse" class="form-label fw-bold"><?php ee('Maximum Uses') ?></label>
                <input type="number" class="form-control p-2" name="maxuse" id="maxuse" value="" min="0" placeholder="e.g. 20" required>
                <p class="form-text"><?php ee('Set 0 for unlimited uses') ?></p>
            </div> 
            <div class="form-group mb-4">
                <label for="plans" class="form-label fw-bold"><?php ee('Limit to Plans') ?> (Optional)</label>                        
                <select class="form-select" name="plans[]" id="plans" data-toggle="select" multiple>
                    <?php foreach(\Core\DB::plans()->findMany() as $plan): ?>
                        <option value="<?php echo $plan->id ?>"><?php echo $plan->name ?></option>
                    <?php endforeach ?>
                </select>
                <p class="form-text"><?php ee('You can limit the coupon to a specific plan.') ?></p>
            </div> 
            <div class="form-group mb-4">
                <label for="validuntil" class="form-label fw-bold"><?php ee('Valid Until') ?></label>
                <input type="text" class="form-control p-2" data-toggle="datetimepicker" name="validuntil" id="validuntil" value="" placeholder="e.g. 01-01-2020" autocomplete="off">
            </div> 		                                         
            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Coupon') ?></button>
        </form>
    </div>
</div>  