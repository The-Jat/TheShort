<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Notifications') ?></h1>
</div>

<?php if(empty($notifications)): ?>
    <div class="card rounded-4 shadow-sm">
        <div class="card-body text-center py-5">
            <i data-feather="bell-off" class="text-muted mb-3" style="width: 64px; height: 64px;"></i>
            <h5 class="fw-bold mb-2"><?php ee('No Notifications') ?></h5>
            <p class="text-muted mb-0"><?php ee('You don\'t have any notifications at the moment.') ?></p>
        </div>
    </div>
<?php else: ?>
    <div class="card rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <?php foreach($notifications as $notification): ?>
                    <div class="list-group-item border-bottom p-4 bg-transparent">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex align-items-center justify-content-center">
                                    <i data-feather="bell" class="text-dark" style="width: 20px; height: 20px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <?php if(!empty($notification->title)): ?>
                                    <h6 class="fw-bold mb-2"><?php echo clean($notification->title) ?></h6>
                                <?php endif ?>
                                <div class="text-dark mb-2">
                                    <?php echo $notification->content ?>
                                </div>
                                <div class="d-flex align-items-center text-muted small">
                                    <i data-feather="clock" style="width: 14px; height: 14px;" class="me-1"  data-bs-toggle="tooltip" title="<?php echo $notification->dateFull ?>"></i>
                                    <span><?php echo $notification->date ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <?php echo pagination('pagination justify-content-center') ?>
    </div>
<?php endif ?>
