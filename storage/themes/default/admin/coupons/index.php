<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Coupons') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Coupons') ?></h1>
    <div class="ms-auto">
      <a href="<?php echo route('admin.coupons.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Create') ?></a>	    
	</div>
</div>
<div class="card rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th><?php ee('Coupon Name') ?></th>
                        <th><?php ee('Coupon Code') ?></th>
                        <th><?php ee('Discount') ?></th>
                        <th><?php ee('Valid Until') ?></th>
                        <th><?php ee('Used') ?></th>
                        <th><?php ee('Max Use') ?></th>
                        <th>
                          <button type="button" class="btn btn-default bg-transparent p-0 float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="filter"></i></button>
                          <form action="" method="get" class="dropdown-menu p-2">
                            <div class="input-select d-block mb-2">
                              <label for="q" class="form-label fw-bold"><?php ee('Contains') ?></label>
                              <input type="text" class="form-control" name="q" value="<?php echo clean(request()->q) ?>" placeholder="<?php ee('Keyword in coupon') ?>">
                            </div>                            
                              <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Filter') ?></button>
                          </form>                          
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($coupons as $coupon): ?>
                        <tr>
                            <td>
                                <?php echo $coupon->name ?>
                                <?php echo (($coupon->validuntil && strtotime($coupon->validuntil) < strtotime('now')) || ($coupon->maxuse > 0 && $coupon->used >= $coupon->maxuse)) ? '<span class="badge bg-danger">'.e('Expired').'</span>' : '' ?>
                            </td>
                            <td><span class="badge border border-primary text-primary fw-bold"><?php echo $coupon->code ?></span></td>
                            <td><?php echo $coupon->discount ?>% OFF</td>
                            <td><?php echo $coupon->validuntil ? date("d-m-Y", strtotime($coupon->validuntil)) : "N/A"?></td>
                            <td><?php echo $coupon->used ?> times</td>
                            <td><?php echo $coupon->maxuse == '0' ? e('Unlimited') : $coupon->maxuse ?> times</td>
                            <td>
                                <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo route('admin.coupons.edit', [$coupon->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.coupons.delete', [$coupon->id, \Core\Helper::nonce('coupon.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php echo pagination('bg-white shadow rounded pagination p-3') ?>
    </div>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to delete this?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete a record. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>