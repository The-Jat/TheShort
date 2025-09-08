<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.coupons') ?>"><?php ee('Coupons') ?></a></li>
  </ol>
</nav>

<h1 class="h3 mb-5"><?php ee('Edit Coupon') ?></h1>

<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.coupons.update', $coupon->id) ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="code" class="form-label fw-bold"><?php ee('Coupon Code') ?></label>
                <input type="text" class="form-control p-2" disabled value="<?php echo $coupon->code ?>">
            </div>  
            <div class="form-group mb-4">
                <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo $coupon->name ?>" placeholder="My Sample Coupon" required>
            </div>                    
            <div class="form-group mb-4">
                <label for="description" class="form-label fw-bold"><?php ee('Description') ?></label>
                <textarea name="description" id="description" class="form-control"><?php echo $coupon->description ?></textarea>
            </div>           
            <div class="form-group mb-4">
                <label for="maxuse" class="form-label fw-bold"><?php ee('Maximum Uses') ?></label>
                <input type="number" class="form-control p-2" name="maxuse" id="maxuse" value="<?php echo $coupon->maxuse ?>" min="0" placeholder="e.g. 20" required>
                <p class="form-text"><?php ee('Set 0 for unlimited uses') ?></p>
            </div> 
            <div class="form-group mb-4">
                <label for="plans" class="form-label fw-bold"><?php ee('Limit to Plans') ?> (Optional)</label>                
                <select class="form-select" name="plans[]" id="plans" data-toggle="select" multiple>
                    <?php foreach(\Core\DB::plans()->findMany() as $plan): ?>
                        <option value="<?php echo $plan->id ?>" <?php echo in_array($plan->id, $coupon->data->plans ?? []) ? 'selected' : '' ?>><?php echo $plan->name ?></option>
                    <?php endforeach ?>
                </select>
                <p class="form-text"><?php ee('You can limit the coupon to a specific plan.') ?></p>
            </div> 
            <div class="form-group mb-4">
                <label for="validuntil" class="form-label fw-bold"><?php ee('Valid Until') ?></label>
                <input type="text" class="form-control p-2" data-toggle="datetimepicker" name="validuntil" id="validuntil" value="<?php echo $coupon->validuntil ?>" placeholder="e.g. 01-01-2020" autocomplete="off" required>
            </div> 		                                         
            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Update') ?></button>
        </form>
    </div>
</div>   