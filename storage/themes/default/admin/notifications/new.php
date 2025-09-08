<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.notifications') ?>"><?php ee('Notifications') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('New Notification') ?></h1>

<div class="row">
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.notifications.save') ?>" enctype="multipart/form-data" autocomplete="off">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4 input-select rounded">
                        <label for="user" class="form-label fw-bold"><?php ee('Users') ?></label>
                        <select name="user[]" id="user" class="form-control p-2" data-toggle="select" data-trigger="userlist" data-route="<?php echo route('admin.users.list') ?>" multiple>
                            <option value="all" selected><?php ee('All Users') ?></option>
                            <?php foreach($users as $user): ?>
                                <option value="<?php echo $user->id ?>"><?php echo $user->id ?> - <?php echo $user->email ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-4 input-select rounded">
                        <label for="plan" class="form-label fw-bold"><?php ee('Plan') ?></label>
                        <select name="plan[]" id="plan" class="form-control p-2" data-toggle="select" multiple>
                            <option value="all" selected><?php ee('All Plans') ?></option>
                            <?php foreach($plans as $plan): ?>
                                <option value="<?php echo $plan->id ?>"><?php echo $plan->id ?> - <?php echo $plan->name ?><?php echo $plan->free ? '('.e('Free').')' : '' ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="title" class="form-label fw-bold"><?php ee('Notification Title') ?></label>
                        <input type="text" class="form-control p-2" name="title" id="title" value="<?php echo old('title') ?>">
                    </div>
                    <div class="form-group mb-4">
                        <label for="content" class="form-label fw-bold"><?php ee('Content') ?></label>
                        <textarea class="form-control p-2" name="content" id="content"><?php echo old('content') ?></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="expiry" class="form-label fw-bold"><?php ee('Expires At') ?></label>
                        <input type="text" class="form-control p-2" name="expiry" id="expiry" value="<?php echo old('expiry') ?>" data-toggle="datetimepicker">
                        <p class="form-text"><?php ee('Leave it empty to always display this notification until deleted') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Notification') ?></button>
                </form>
            </div>
        </div>        
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold"><?php ee('Notifications') ?></h4>
                <p>
                    <?php ee('You can send notifications to specific users and plans. If you want to send a notification to specific plans, select All Users then select the plan. If you want to send notifications to specific users then the plan selector will be ignored.') ?>
                </p>
                <p><?php ee('Once you send the notification, you cannot edit it. You can only delete it.') ?></p>
            </div>
        </div>
    </div>
</div>