<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><span class="align-middle"><?php ee('CTA Overlay') ?> </span> <i class="fa fa-question-circle text-muted fs-6 opacity-50" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo ee('An overlay page allows you to display a small non-intrusive overlay on the destination website to advertise your product or your services. You can also use this feature to send a message to your users. You can customize the message and the appearance of the overlay right from this page. As soon as you save it, the changes will be applied immediately across all your URLs using this type. Please note that some secured and sensitive websites such as google.com or facebook.com do not work with this feature. You can have unlimited overlay pages and you can choose one for each URL.') ?>"></i></h1>
    <div class="ms-auto">
        <?php if(\Core\Auth::user()->teamPermission('overlay.create')): ?>
            <a href="<?php echo route('overlay.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create') ?></a>
        <?php endif ?>
    </div>
</div>
<div class="card rounded-4 shadow-sm p-2">
    <div class="d-block d-md-flex align-items-center">
        <div>
			<span class="h3 ms-2"><?php echo $count ?></span> <span class="text-muted"> <?php ee('CTA Overlay') ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></span>
		</div>
        <div class="ms-auto">
            <form action="<?php echo route('overlay') ?>" method="get" class="d-flex align-items-center border rounded-3 p-1">
                <div class="me-2 flex-fill">
                    <input type="text" class="form-control border-0 p-2" name="q" value="<?php echo clean(request()->q) ?>" placeholder="<?php ee('Search for {t}', null, ['t' => e('CTA Overlay')]) ?>">
                </div>
                <div>
                    <button type="submit" class="btn bg-white py-2 px-3"><i data-feather="search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php if($overlaypages): ?>
    <div class="row">
    <?php foreach($overlaypages as $overlay): ?>
        <div class="col-md-4">
            <div class="card rounded-4 flex-fill shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="icon-45 border rounded-3 p-2" data-feather="<?php echo $overlay->icon ?>" data-bs-toggle="tooltip" title="<?php ee(ucfirst($overlay->type)) ?>">></i>
                        </div>
                        <div>
                            <strong><?php echo $overlay->name ?></strong>
                        </div>
                        <div class="flex-grow-1">
                            <div class="float-end">
                                <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></button>
                                <ul class="dropdown-menu">
                                <?php if(\Core\Auth::user()->teamPermission('overlay.edit')): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('overlay.edit', [$overlay->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                                <?php endif ?>
                                <?php if(\Core\Auth::user()->teamPermission('overlay.delete')): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?php echo route('overlay.delete', [$overlay->id, \Core\Helper::nonce('overlay.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                                <?php endif ?>
                                </ul>
                            </div>   
                        </div>
                    </div>
                    <p class="text-muted mb-0 mt-3"><?php ee('Overlay created {t} and assigned to {x}.', null, ['t' => \Core\Helper::timeago($overlay->date), 'x' =>  $overlay->urlcount.' '.e('link|links', $overlay->urlcount)]) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    </div>
    <div class="mt-4 d-block">
        <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
    </div>
<?php else: ?>
    <div class="card rounded-4 flex-fill shadow-sm">
        <div class="card-body text-center">
            <p><?php ee('No content found. You can create some.') ?></p>
            <?php if(\Core\Auth::user()->teamPermission('overlay.edit')): ?>
                <a href="<?php echo route('overlay.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create a CTA Overlay') ?></a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
<?php if(\Core\Auth::user()->teamPermission('overlay.delete')): ?>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
        <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<?php endif ?>