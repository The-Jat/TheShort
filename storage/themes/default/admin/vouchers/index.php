<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Vouchers') ?></li>
  </ol>
</nav>

<div class="d-flex align-items-center mb-5">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Vouchers') ?></h1>      
    <div class="ms-auto">
        <a href="#" data-bs-toggle="modal" data-bs-target="#massModal" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Bulk Vouchers') ?></a>
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.vouchers.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                        <input type="text" class="form-control p-2" name="name" id="name" value="" placeholder="My Sample Voucher" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="description" class="form-label fw-bold"><?php ee('Description') ?></label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="code" class="form-label fw-bold"><?php ee('Voucher Code') ?></label>
                        <input type="text" class="form-control p-2" name="code" id="code" value="" placeholder="e.g. TESTDRIVE">
                        <p class="form-text"><?php ee('Leave empty to generate a random voucher code.') ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="plan" class="form-label fw-bold"><?php ee('Plan') ?></label>
                        <select id="plan" name="plan" class="form-select p-2">
                            <?php foreach($plans as $plan): ?>
                                <option value="<?php echo $plan->id ?>"><?php echo $plan->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <label for="" class="form-label fw-bold"><?php ee('Voucher Period') ?></label>
                    <p class="form-text"><?php ee('Users redeeming vouchers will be assigned the selected plan for the select amount of selected period.') ?></p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <label for="amount" class="form-label fw-bold"><?php ee('Amount') ?></label>
                                <input type="text" class="form-control p-2" name="amount" id="amount" value="" placeholder="e.g. 5" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <label for="period" class="form-label fw-bold"><?php ee('Period') ?></label>
                                <select id="period" name="period" class="form-select p-2">
                                    <option value="day"><?php ee('Days') ?></option>
                                    <option value="month"><?php ee('Months') ?></option>
                                    <option value="year"><?php ee('Years') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="maxuse" class="form-label fw-bold"><?php ee('Maximum Uses') ?></label>
                        <input type="number" class="form-control p-2" name="maxuse" id="maxuse" value="" min="0" placeholder="e.g. 20">
                        <p class="form-text"><?php ee('Set 0 for unlimited uses') ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="validuntil" class="form-label fw-bold"><?php ee('Valid Until') ?></label>
                        <input type="text" class="form-control p-2" data-toggle="datepicker" name="validuntil" id="validuntil" value="" placeholder="e.g. 01-01-2020" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Voucher') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Name') ?></th>
                            <th><?php ee('Code') ?></th>
                            <th><?php ee('Plan') ?></th>
                            <th><?php ee('Valid Until') ?></th>
                            <th><?php ee('Used') ?></th>
                            <th><?php ee('Max Use') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($vouchers as $voucher): ?>
                            <tr>
                                <td>
                                    <?php echo $voucher->name ?>
                                    (<?php echo $voucher->period ?>)
                                    <?php echo (strtotime($voucher->validuntil) < strtotime('now') || ($voucher->maxuse > 0 && $voucher->used >= $voucher->maxuse)) ? '<span class="badge bg-danger">'.e('Expired').'</span>' : '' ?>
                                </td>
                                <td><a href="#copy" class="copy" data-clipboard-text="<?php echo $voucher->code ?>" title="<?php ee('Copy') ?>"><span class="badge bg-success"><?php echo $voucher->code ?></span></a></td>
                                <td><?php echo $voucher->plan->name ?></td>
                                <td><?php echo $voucher->validuntil ? date("d-m-Y", strtotime($voucher->validuntil)) : "N/A"?></td>
                                <td><?php echo $voucher->used ?> times</td>
                                <td><?php echo $voucher->maxuse == '0' ? e('Unlimited') : $voucher->maxuse ?> times</td>
                                <td>
                                    <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('admin.vouchers.update', [$voucher->id]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo json_encode(['newname' => $voucher->name,'newdescription' => $voucher->description, 'newvaliduntil' => \Core\Helper::dtime($voucher->validuntil, 'Y-m-d'), 'newmaxuse' => $voucher->maxuse]) ?>'><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.vouchers.delete', [$voucher->id, \Core\Helper::nonce('voucher.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?php echo pagination('pagination') ?>
        </div>
    </div>
</div>
<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Edit Voucher') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="newname" class="form-label fw-bold"><?php ee('Name') ?></label>
                    <input type="text" class="form-control p-2" name="newname" id="newname" value="" placeholder="My Sample Voucher" required>
                </div>
                <div class="form-group mb-4">
                    <label for="newdescription" class="form-label fw-bold"><?php ee('Description') ?></label>
                    <textarea name="newdescription" id="newdescription" class="form-control"></textarea>
                </div>
                <div class="form-group mb-4">
                        <label for="newmaxuse" class="form-label fw-bold"><?php ee('Maximum Uses') ?></label>
                        <input type="number" class="form-control p-2" name="newmaxuse" id="newmaxuse" value="" min="0" placeholder="e.g. 20" required>
                        <p class="form-text"><?php ee('Set 0 for unlimited uses') ?></p>
                    </div>
                <div class="form-group mb-4">
                    <label for="newvaliduntil" class="form-label fw-bold"><?php ee('Valid Until') ?></label>
                    <input type="text" class="form-control p-2" data-datepicker name="newvaliduntil" id="newvaliduntil" value="" placeholder="e.g. 01-01-2020" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Update Voucher') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="massModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo route('admin.vouchers.bulk') ?>" method="post" id="massform">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Bulk Vouchers') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                    <input type="text" class="form-control p-2" name="name" id="name" value="" placeholder="My Sample Voucher" required>
                </div>
                <div class="form-group mb-4">
                    <label for="description" class="form-label fw-bold"><?php ee('Description') ?></label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="prefix" class="form-label fw-bold"><?php ee('Voucher Prefix') ?></label>
                    <input type="text" class="form-control p-2" name="prefix" id="prefix" value="" placeholder="e.g. YT">
                    <p class="form-text"><?php ee('You can prefix your voucher codes. Voucher codes will be generated as PREFIX-CODE') ?></p>
                </div>
                <div class="form-group mb-4">
                    <label for="plan" class="form-label fw-bold"><?php ee('Plan') ?></label>
                    <select id="plan" name="plan" class="form-select p-2">
                        <?php foreach($plans as $plan): ?>
                            <option value="<?php echo $plan->id ?>"><?php echo $plan->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <label for="" class="form-label fw-bold"><?php ee('Voucher Period') ?></label>
                <p class="form-text"><?php ee('Users redeeming vouchers will be assigned the selected plan for the select amount of selected period.') ?></p>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mb-4">
                            <label for="amount" class="form-label fw-bold"><?php ee('Amount') ?></label>
                            <input type="text" class="form-control p-2" name="amount" id="amount" value="" placeholder="e.g. 5" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mb-4">
                            <label for="period" class="form-label fw-bold"><?php ee('Period') ?></label>
                            <select id="period" name="period" class="form-select p-2">
                                <option value="day"><?php ee('Days') ?></option>
                                <option value="month"><?php ee('Months') ?></option>
                                <option value="year"><?php ee('Years') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="maxuse" class="form-label fw-bold"><?php ee('Maximum Uses') ?></label>
                    <input type="number" class="form-control p-2" name="maxuse" id="maxuse" value="" min="0" placeholder="e.g. 20">
                    <p class="form-text"><?php ee('Set 0 for unlimited uses') ?></p>
                </div>
                <div class="form-group mb-4">
                    <label for="validuntil" class="form-label fw-bold"><?php ee('Valid Until') ?></label>
                    <input type="text" class="form-control p-2" data-toggle="datepicker" name="validuntil" id="validuntil" value="" placeholder="e.g. 01-01-2020" autocomplete="off">
                </div>
                <div class="form-group mb-4">
                    <label for="number" class="form-label fw-bold"><?php ee('Number of Vouchers') ?></label>
                    <input type="text" class="form-control p-2" name="number" id="number" value="" placeholder="e.g.10" autocomplete="off">
                    <p class="form-text"><?php ee('You can create 100 vouchers at a time') ?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Create Vouchers and Download CSV') ?></button>
            </div>
        </form>
    </div>
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
        <a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>