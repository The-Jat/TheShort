<div class="d-flex mb-5">
    <div>
        <h1 class="mb-0 h3 fw-bold">
        <span class="border rounded-3 p-2 ps-1 icon-45 d-inline-block icon-45 bg-warning text-black me-3"><i class="fab fa-fw fa-mailchimp fs-2"></i></span>
            <?php ee('Mailchimp Integration') ?>
        </h5>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm border">
            <div class="card-body p-4">
                <p><?php ee('Connect your Mailchimp account to automatically add newsletter subscribers to your lists.') ?></p>
                <form method="post" action="<?php echo route('integrations.mailchimp') ?>">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold"><?php ee('Mailchimp API Key') ?></label>
                        <input type="text" class="form-control p-3" name="apikey" value="<?php echo htmlspecialchars(user()->mailchimpapikey ?? '') ?>" placeholder="e.g. abc123def456-us13" required>
                        <p class="form-text mt-2">
                            <?php ee('You can find your API key in your Mailchimp account under Account & Billing > Extras > API keys.') ?>
                            <a href="https://mailchimp.com/help/about-api-keys/" target="_blank" class="ms-1"><?php ee('Learn more') ?></a>
                        </p>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 shadow-sm"><?php ee('Save API Key') ?></button>
                        <?php if(!empty(user()->mailchimpapikey)): ?>
                            <a href="<?php echo route('integrations.mailchimp') ?>" class="btn btn-light ms-2 rounded-3 px-4 py-2"><?php ee('Refresh Lists') ?></a>
                        <?php endif ?>
                    </div>
                </form>
            </div>
        </div>

        <?php if(!empty($lists)): ?>
        <div class="card rounded-4 shadow-sm border mt-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><?php ee('Available Lists') ?></h5>
                <p class="text-muted"><?php ee('These are the lists available in your Mailchimp account. You can select one when configuring your Newsletter widget.') ?></p>
                <ul class="list-group">
                    <?php foreach($lists as $listId => $listName): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo htmlspecialchars($listName) ?></span>
                        <span class="badge bg-primary rounded-pill"><?php echo htmlspecialchars(substr($listId, 0, 8)) ?>...</span>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <?php elseif(!empty(user()->mailchimpapikey)): ?>
        <div class="alert alert-warning mt-4">
            <i class="fa fa-exclamation-triangle me-2"></i>
            <?php ee('No lists found or unable to connect to Mailchimp. Please verify your API key is correct.') ?>
        </div>
        <?php endif ?>
    </div>
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm border">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><?php ee('How it works') ?></h5>
                <ol class="ps-3">
                    <li class="mb-2"><?php ee('Enter your Mailchimp API key above') ?></li>
                    <li class="mb-2"><?php ee('Go to your Bio Page editor') ?></li>
                    <li class="mb-2"><?php ee('Add a Newsletter widget') ?></li>
                    <li class="mb-2"><?php ee('Enable Mailchimp and select a list') ?></li>
                    <li><?php ee('Subscribers will be automatically added to your Mailchimp list') ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
