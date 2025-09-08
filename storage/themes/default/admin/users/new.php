<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.users') ?>"><?php ee('Users') ?></a></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('New User') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.users.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="username" class="form-label fw-bold"><?php ee('Username') ?></label>
                <input type="text" class="form-control p-2" name="username" id="username" value="<?php echo old('username') ?>" placeholder="username">
                <p class="form-text"><?php ee('A username is required for the public profile to be visible.') ?></p>
            </div>
            <div class="form-group mb-4">
                <label for="email" class="form-label fw-bold"><?php ee('Email') ?></label>
                <input type="text" class="form-control p-2" name="email" id="email" value="<?php echo old('email') ?>" placeholder="admin@site.com">
                <p class="form-text"><?php ee('Please make sure that email is valid.') ?></p>
            </div>
            <div class="form-group mb-4">
                <label for="password" class="form-label fw-bold"><?php ee('Password') ?></label>
                <input type="password" class="form-control p-2" name="password" id="password" value="" placeholder="">
                <p class="form-text"><?php ee('Password needs to be at least 5 characters.') ?></p>
            </div>
            <div class="form-group mb-4 input-select">
                <label for="plan" class="form-label fw-bold"><?php ee('Plan') ?></label>
                <select name="plan" id="plan" class="form-control" data-toggle="select">
                    <option value=""><?php ee('None') ?></option>
                    <?php foreach($plans as $plan): ?>
                        <option value="<?php echo $plan->id ?>"><?php echo $plan->name ?> (<?php echo $plan->free ? e('Free') : e('Paid') ?><?php echo $plan->hidden ? ' '.e('& Hidden') : '' ?>)</option>
                    <?php endforeach ?>
                </select>
                <p class="form-text"><?php ee('Choose the membership plan. This does not subscribe a user via Stripe. You will have to do that manually!') ?></p>
            </div>
            <div class="form-group mb-4">
                <label for="lastpayment" class="form-label fw-bold"><?php ee('Last Payment') ?></label>
                <input type="text" class="form-control p-2" name="lastpayment" id="lastpayment" value="<?php echo old('lastpayment') ?>" data-toggle="datetimepicker" autocomplete="off">
                <p class="form-text"><?php ee('Set the last payment date in this format: YYYY-MM-DD (e.g. 2014-04-01)') ?></p>
            </div>
            <div class="p-3 border border-warning rounded mb-3 d-flex align-items-center">
                <i class="fa fa-warning me-2 fs-3 text-warning"></i>
                <p class="my-0"><?php ee('When updating the plan manually, make sure to set the expiration date otherwise the user will not be able to use the plan.') ?></p>
            </div>            
            <div class="form-group mb-4">
                <label for="expiration" class="form-label fw-bold"><?php ee('Expiration') ?></label>
                <input type="text" class="form-control p-2" name="expiration" id="expiration" value="<?php echo old('expiration') ?>" data-toggle="datetimepicker" autocomplete="off">
                <p class="form-text"><?php ee('Set the expiration date in this format: YYYY-MM-DD (e.g. 2014-04-01)') ?></p>
            </div>
            <div class="form-group mb-4">
                <label for="admin" class="form-label fw-bold"><?php ee('User Role') ?></label>
                <select name="admin" id="admin" class="form-control" data-toggle="select">
                    <option value="0" selected><?php ee('Regular User') ?></option>
                    <?php foreach($roles as $role): ?>
                        <option value="<?php echo $role->id ?>"><?php echo $role->name ?></option>
                    <?php endforeach ?>
                </select>
                <p class="form-text"><?php ee('Assign this user to a role. Super Administrator is the highest role and has access to everything.') ?></p>
            </div>
            <div class="form-group">
                <div class="d-flex border rounded rounded-3 p-2 mb-3 align-items-center">
                    <div>
                        <label class="form-check-label fw-bold" for="active"><?php ee('Active') ?></label>
                        <p class="form-text my-0"><?php ee('Do you want this user to be active?') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="active" name="active" value="1">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="d-flex border rounded rounded-3 p-2 mb-3 align-items-center">
                    <div>
                        <label class="form-check-label fw-bold" for="banned"><?php ee('Banned') ?></label>
                        <p class="form-text my-0"><?php ee('Do you want to ban this user?') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="banned" name="banned" value="1">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="d-flex border rounded rounded-3 p-2 mb-3 align-items-center">
                    <div>
                        <label class="form-check-label fw-bold" for="public"><?php ee('Public Profile') ?></label>
                        <p class="form-text my-0"><?php ee('Do you want to make this user\'s profile public?') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="public" name="public" value="1">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add User') ?></button>
        </form>

    </div>
</div>