<h1 class="h3 mb-5 fw-bold"><?php ee('About') ?></h1>
<div class="row">
    <div class="col-md-7">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <ul class="list-unstyled">
                    <?php if (!in_array('curl', get_loaded_extensions())): ?>
                        <li class="mb-2"><i class="me-2 text-danger" data-feather="x-circle"></i>cURL library is not
                            available. Please update manually.</li>
                    <?php else: ?>
                        <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>cURL library is
                            available.</li>
                    <?php endif ?>
                    <?php if (!class_exists("ZipArchive", false)): ?>
                        <li class="mb-2"><i class="me-2 text-danger" data-feather="x-circle"></i>ZipArchive library is not
                            available. Please update manually or enable/install php-zip.</li>
                    <?php else: ?>
                        <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>ZipArchive library is
                            available.</li>
                    <?php endif ?>
                    <?php if (!is_writable(ROOT)): ?>
                        <li class="mb-2"><i class="me-2 text-danger" data-feather="x-circle"></i>Document root is not
                            writable.</li>
                    <?php else: ?>
                        <li class="mb-2"><i class="me-2 text-success" data-feather="check-circle"></i>Document root is
                            writable.</li>
                    <?php endif ?>
                </ul>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Script Information') ?></div>
            <div class="card-body">
                <div class="p-2 border rounded-3 mb-3">
                    <div class="d-flex mb-2">
                        <div>
                            <strong><?php ee('Current Script Version') ?>:</strong> <?php echo config('version') ?>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div>
                            <strong><?php ee('Current PHP Version') ?>:</strong> <?php echo phpversion() ?>
                        </div>
                        <div class="ms-auto">
                            <a href="<?php echo route('admin.phpinfo') ?>" class="badge bg-primary text-white"
                                target="_blank"><?php ee('View PHP Info') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card rounded-4 shadow-sm">
            <div class="card-header fw-bold bg-transparent"><?php ee('Join the Community') ?></div>
            <div class="card-body">
                <p><?php ee('Follow us on social media and be the first to benefit from news related to this product, new plugins and releases.') ?>
                </p>
                <span class="text-primary mb-2 d-block"><i data-feather="whatsapp"></i> <a
                        href="https://whatsapp.com/channel/0029VanJUaFFCCoMNuIMDd0v" target="_blank"
                        class="text-primary">Follow us on WhatsApp Channel</a></span>
            </div>
        </div>
    </div>
</div>