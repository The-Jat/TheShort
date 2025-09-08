<h1 class="h3 mb-5 fw-bold"><?php ee('Affiliate Payments History') ?></h1>

<div class="card rounded-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('User') ?></th>
                    <th><?php ee('Paypal') ?></th>
                    <th><?php ee('Amount') ?></th>
                    <th><?php ee('Status') ?></th>
                    <th><?php ee('Date') ?></th>
                    <th>
                        <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="filter"></i></button>
                        <form action="" method="get" class="dropdown-menu p-2">
                            <div class="input-select d-block mb-2">
                                <label for="userid" class="form-label fw-bold"><?php ee('For User') ?></label>
                                <select name="userid" id="userid" data-name="userid" class="form-select">
                                    <option value="all"<?php if(!request()->userid) echo " selected" ?>><?php ee('All') ?></option>
                                    <?php foreach($users as $user): ?>
                                        <option value="<?php echo $user['id'] ?>"<?php if(request()->userid == $user['id']) echo " selected" ?>>#<?php echo $user['id'] ?>- <?php echo $user['email'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Filter') ?></button>
                        </form>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($payments as $payment): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $payment->user->avatar() ?>" alt="" width="36" class="img-responsive rounded-circle">
                                <div class="ms-2">
                                    <?php echo $payment->user->email ?>
                                </div>
                            </div>

                        </td>
                        <td>
                            <?php echo ($payment->user->paypal)?"<strong>{$payment->user->paypal}</strong>": 'No Paypal ID' ?>
                        </td> 
                        <td>
                            <?php echo \Helpers\App::currency(config('currency'), $payment->amount) ?>
                        </td> 
                        <td><?php ee('Paid') ?></td>   
                        <td><?php echo $payment->paid_on ?></td>   
                        <td></td>                             
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>   
    </div>
</div>
<div class="mt-4 d-block">
	<?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
</div>  