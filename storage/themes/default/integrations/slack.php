<div class="d-flex mb-5">
    <div>
        <h1 class="mb-0 h3 fw-bold">
            <img src="<?php echo assets('images/slack.svg') ?>" class="icon-45 border rounded-3 p-2 bg-white me-3"> <?php ee('Slack Integration') ?>
            <?php if(user()->slackid): ?>
                <i class="ms-1 fa fa-check-circle fs-4 text-success" data-bs-toggle="tooltip" title="<?php ee('Connected') ?>"></i>
            <?php endif ?>  
        </h5>
    </div>
</div>

<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <p class="mb-0"><?php echo e("You can integrate this app with your Slack account and shorten directly from the Slack interface using the command line below. This Slack integration will save all of your links in your account in case you need to access them later. Please see below how to use the command.") ?></p>
        <?php if (!user()->slackid): ?>
            <p class="mt-3 mb-0"><?php echo $slack->generateAuth() ?></p>
        <?php endif ?>
    </div>
</div>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <p><?php echo e("The Slack command will return you the short link if everything goes well. In case there is an error, it will return you the error.") ?></p>

        <p><?php echo e("If you have set a default domain in your Settings, it will attempt to use that domain to shorten links.") ?></p>

        <h5 class="mt-4"><strong><?php echo e("Slack Command") ?></strong></h5>
        <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?></pre></p>

        <h5 class="mt-4"><strong><?php echo e("Shorten link") ?></strong></h5>
        <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?> https://google.com</pre></p>

        <h5 class="mt-4"><strong><?php echo e("Shorten link with custom name") ?></strong></h5>
        <p><?php echo e("To send a custom alias, use the following parameter (ABCDXYZ). This will tell the script to shorten the link with the custom alias ABCDXYZ.") ?></p>
        <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?> (google) https://google.com</pre></p>

        <h5 class="mt-4"><strong><?php echo e("Get last 5 clicks") ?></strong></h5>
        <p><?php echo e("You can get last 5 clicks if you preceed the short link with \"clicks:\" as follows.") ?></p>
        <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?> clicks:<?php echo url('sampleshort') ?></pre></p>

        <h5 class="mt-4"><strong><?php echo e("Help") ?></strong></h5>
        <p><?php echo e("You can always use the help command if you need help or remind you how it works.") ?></p>
        <p><pre class="p-3 border rounded">/<?php echo config("slackcommand") ?> help</pre></p>
    </div>
</div>