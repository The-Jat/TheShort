<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.tools') ?>"><?php ee('Tools') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Send Email') ?></h1>
<div class="row">
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('Subscribed to newsletter') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $newsletterusers ?> <small class="text-muted fs-6 fw-bold"><?php ee("Users") ?></small></h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('Active') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $activeusers ?> <small class="text-muted fs-6 fw-bold"><?php ee("Users") ?></small></h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('Inactive') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $inactiveusers ?> <small class="text-muted fs-6 fw-bold"><?php ee("Users") ?></small></h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('Free Users') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $freeusers ?> <small class="text-muted fs-6 fw-bold"><?php ee("Users") ?></small></h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('Paid Users') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $paidusers ?> <small class="text-muted fs-6 fw-bold"><?php ee("Users") ?></small></h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('All') ?></h5>
                <h1 class="mt-1 mb-3"><?php echo $allusers ?> <small class="text-muted fs-6 fw-bold"><?php ee("Users") ?></small></h1>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">        
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">                            
                <form method="post" action="<?php echo route('admin.email.send') ?>" enctype="multipart/form-data" data-trigger="editor">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="sendto" class="form-label fw-bold"><?php ee('Send To') ?></label>
                        <input type="text" class="form-control" name="sendto" id="sendto" value="<?php echo (new \Core\Request)->email ?: 'list.newsletter' ?>" data-toggle="tags" placeholder="Type an email or a list and press enter">
                        <p class="form-text"><?php ee('You can choose to send email to a built-in list or send email to specific email addresses') ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="country" class="form-label fw-bold"><?php ee('Filter By Country') ?></label>
                        <select name="country" id="country" data-name="country" class="form-select" data-toggle="select" multiple>
                            <option value="all"<?php if(!request()->country) echo " selected" ?>><?php ee('All') ?></option>
                            <?php foreach(\Core\Helper::Country(false) as $country): ?>
                                <option value="<?php echo $country ?>"<?php if(request()->country && request()->country == $country) echo " selected" ?>><?php echo $country ?></option>
                            <?php endforeach ?>
                        </select>
                        <p class="form-text"><?php ee('You can filter the list by country. If you want to send to all users in a specific country, you need to choose the All users list. The country is filter is based on the billing address on file.') ?></p>
                    </div>
                    <div class="form-group mb-4">
                        <label for="subject" class="form-label fw-bold"><?php ee('Subject') ?></label>
                        <input type="text" class="form-control p-2" name="subject" id="subject" value="<?php echo old('subject') ?>" placeholder="e.g. Announcement...">
                    </div>                    
                    <div class="form-group mb-4">
                        <label for="content" class="form-label fw-bold"><?php ee('Content') ?></label>
                        <p class="form-text"><?php ee('You can send a custom message to your users to let them know of changes or important announcements. Simply enter your message below and press send. You can also use some shortcodes to add dynamic data.') ?></p>
                        <textarea id="editor" name="content" class="form-control"><?php echo old('content') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Send email') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <p><?php ee('This tool can be very memory intensive so you absolutely have to make sure that your hosting provider supports this function or allows you send many emails at once otherwise it will most likely get you in trouble. Please don\'t spam your users otherwise they will blacklist your domain name forever. Don\'t send too many newsletters as your hosting provider will suspect you of spam.') ?></p>
            </div>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('Built-in Lists') ?></h5>
                <ul>
                    <li><?php ee('Users with newsletters') ?>: <strong>list.newsletter</strong></li>
                    <li><?php ee('Active users') ?>: <strong>list.active</strong></li>
                    <li><?php ee('Inactive users') ?>: <strong>list.inactive</strong></li>
                    <li><?php ee('Free users') ?>: <strong>list.free</strong></li>
                    <li><?php ee('Paid users') ?>: <strong>list.paid</strong></li>
                    <li><?php ee('All users') ?>: <strong>list.all</strong></li>
                </ul>
            </div>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-4"><?php ee('Shortcodes') ?></h5>
                <p><?php ee('These shortcodes only work when using built-in lists.') ?></p>
                <ul>
                    <li><?php ee("User's username") ?>: <strong>{username}</strong></li>
                    <li><?php ee("User's email") ?>: <strong>{email}</strong></li>
                    <li><?php ee("User's registration date") ?>: <strong>{date}</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>