<div class="d-flex mb-5">
    <div>
        <h1 class="mb-0h3 fw-bold"><img src="<?php echo assets('images/shortcuts.svg') ?>" class="icon-45 border rounded-3 p-2 bg-white me-3"><?php ee('Shortcuts Integration') ?></h5>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <p><?php ee('Shortcuts in an app developed by Apple and it allows you to create an automation. You can download our powerful Shortcut and you will be able to shorten links in a snap and save it directly in your account.') ?></p>

                <p><h4><?php ee('How does it work?') ?></h4></p>

                <p><?php ee('The Shortcut works in various ways:') ?></p>

                <p><strong><?php ee('Safari') ?></strong></p>

                <p><?php ee('If you want shorten the current viewing page, tap the share icon at the bottom of the screen and it will shorten the current URL. It will copy the short URL directly to your clipboard so you can paste it somewhere.') ?></p>

                <p><strong><?php ee('Siri') ?></strong></p>

                <p><?php ee('To use Siri, copy a link and ask Siri "Shorten Link" and it will shorten the link for you and copy it to your clipboard.') ?></p>

                <p><strong><?php ee('Manual') ?></strong></p>

                <p><?php ee('You can also run the Shortcut by just holding a link then tap Share and you will see Shorten Link in the list.') ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="border rounded rounded-4 p-3">
            <h4 class="fw-bold mb-3"><?php ee('How to install it?') ?></h4>

            <div class="mb-2 card rounded-4 p-3">
                <div class="card-body p-2">
                    <span class="d-block"><?php ee('Make sure you have the Shortcuts app, if not you can download it from the App Store: ') ?></span>
                    <a href="https://apps.apple.com/us/app/shortcuts/id915249334" target="_blank" class="btn btn-dark mt-3 rounded-3 p-3">
                        <span class="d-flex align-items-center">
                            <i class="fab fa-apple me-2 fs-2"></i> 
                            <span class="align-middle"> <?php ee('Download Shortcuts') ?></span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="mb-2 card rounded-4 p-3">
                <div class="card-body p-2">
                    <span class="d-block"><?php ee('Download our Shortcut') ?></span>
                    <a href="https://www.icloud.com/shortcuts/9e5151251d274664b47f934e0bc4bdab" target="_blank" class="btn btn-dark mt-3 rounded-3 p-3">
                        <span class="align-middle"> <?php ee('Download') ?></span>
                    </a>
                </div>
            </div>

            <div class="mb-2 card rounded-4 p-3">
                <div class="card-body p-2">
                    <span class="d-block"><?php ee("After installation, you will be presented with a configuration screen where you need to enter the API URL and the API key") ?></span>
                    <strong class="d-block my-2"><?php ee('API URL') ?></strong>
                    <p><?php echo route('api.url.create') ?></p>
                    
                    <strong class="d-block my-2"><?php ee('API Key') ?></strong> 
                    <p><?php echo user()->api ?></p>
                </div>
            </div>

            <div class="mb-0 card rounded-4 p-3">
                <?php ee('After the configuration is complete, you can start shortening links directly from your device in a single tap.') ?>
            </div>
        </div>
    </div>
</div>