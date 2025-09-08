<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bolder mb-0"><?php ee('QR Codes') ?></h1>
    <div class="ms-auto">
        <?php if(user()->teamPermission('qr.create')): ?>
            <a href="<?php echo route('qr.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create QR') ?></a>
        <?php endif ?>
        <?php if(user()->teamPermission('qr.create') && user()->has('bulkqr')): ?>
            <a href="<?php echo route('qr.createbulk') ?>" class="btn btn-dark rounded-3 px-3 py-2"><?php ee('Bulk QR') ?></a>
        <?php endif ?>
    </div>
</div>
<div class="card rounded-4 shadow-sm p-2">
    <div class="d-block d-md-flex align-items-center">
        <div class="mb-3 mb-md-0">
			<span class="h3 ms-2"><?php echo $count ?></span> <span class="text-muted"> <?php echo e('QR Codes') ?>  / <?php echo $total == 0 ? e('Unlimited') : $total ?><?php echo (user()->plan('qrcounttype') == 'monthly' ? ' '.e('per month') : '') ?></span>
            <div class="border-start ms-3 ps-3 d-inline-block">
                <span class="h3"><?php echo $scans ?? '0' ?></span> <span class="text-muted"><?php ee('scans') ?></span>
            </div>
		</div>
        <div class="ms-auto">
            <form action="<?php echo route('qr') ?>" method="get" class="d-flex align-items-center border rounded-3 p-1">
                <div class="me-2">
                    <input type="text" class="form-control border-0 p-2" name="q" value="<?php echo clean(request()->q) ?>" placeholder="<?php ee('Search for {t}', null, ['t' => e('QR Codes')]) ?>">
                </div>
                <div class="me-2">
                    <div class="input-select d-block">
                        <select name="sort" id="sortable" data-name="sort" class="form-select border-0 border-start p-2 pe-5">
                            <optgroup label="Sort by">
                                <option value=""<?php if(!request()->sort) echo " selected" ?>><?php ee('Newest') ?></option>
                                <option value="old"<?php if(request()->sort == 'old') echo " selected" ?>><?php ee('Oldest') ?></option>
                                <option value="popular"<?php if(request()->sort == 'popular') echo " selected" ?>><?php ee('Popular') ?></option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn bg-white py-2 px-3"><i data-feather="search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card rounded-4 shadow-sm mb-2">
    <div class="p-3 d-flex align-items-center">
        <div>
            <form method="post" action="" data-trigger="options">
                <?php echo csrf() ?>
                <input type="hidden" name="selected">
                <div class="btn-group btn-group-sm border rounded-3 px-1">
                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Select All") ?>" data-trigger="selectall" class="fa fa-check-square btn px-3 py-2"></a>
                    <a href="#" data-bs-toggle="dropdown" class="btn p-1"><span data-count-selected="<?php ee('Selected') ?>"><?php ee('Actions') ?></span> <i class="fa fa-chevron-down ms-2"></i></a>
                    <div class="dropdown-menu">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#channelModal" data-trigger="getchecked" data-for="#channelids" class="dropdown-item px-3"><i data-feather="package" class="me-2"></i> <?php echo e("Add to Channel") ?></a>
                        <a title="<?php echo e("Download Selected") ?>" data-bs-toggle="modal" data-bs-target="#downloadModal" data-trigger="getchecked" data-for="#qrids" class="dropdown-item px-3"><i data-feather="download" class="me-2"></i> <?php echo e("Download Selected") ?></a>
                        <?php if(user()->teamPermission('qr.delete')): ?>
                            <li class="dropdown-divider"></li>
                            <a title="<?php echo e("Delete Selected") ?>" data-bs-toggle="modal" data-bs-target="#deleteAllModal"  class="dropdown-item px-3 text-danger"><i data-feather="trash" class="me-2"></i> <?php echo e("Delete Selected") ?></a>
                        <?php endif ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if($qrs): ?>
    <div class="row">
        <?php foreach($qrs as $qr): ?>
            <div class="col-12 col-xl-4 mb-4">
                <div class="card rounded-4 flex-fill shadow-sm h-100">
                    <div class="card-body text-center position-relative pb-0">
                        <div class="position-absolute top-0 start-0 mt-3 ms-3">
                            <input class="form-check-input me-2" type="checkbox" data-dynamic="1" value="<?php echo $qr->id ?>">
                        </div>
                        <div class="position-absolute top-0 end-0 mt-3">
                            <button type="button" class="btn btn-default bg-transparent" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></button>
                            <ul class="dropdown-menu">
                                <?php if($qr->urlid): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('stats', [$qr->urlid]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></span></a></li>
                                <?php endif ?>
                                <?php if(user()->teamPermission('qr.edit')): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('qr.edit', [$qr->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit QR') ?></a></li>
                                <?php endif ?>
                                <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'svg', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as SVG') ?></a></li>
                                <?php if(!config('imagemagick')): ?>
                                    <li><a class="dropdown-item" href="" data-trigger="downloadqr" data-svg="<?php echo route('qr.download', [$qr->alias, 'svg', 1000]) ?>" data-format="png"><i data-feather="download"></i> <?php ee('Download as PNG') ?></a></li>
                                    <li><a class="dropdown-item" href="" data-trigger="downloadqr" data-svg="<?php echo route('qr.download', [$qr->alias, 'svg', 1000]) ?>" data-format="webp"><i data-feather="download"></i> <?php ee('Download as WebP') ?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'png', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as PNG') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'webp', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as WebP') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'pdf', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as PDF') ?></a></li>
                                <?php endif ?>
                                <?php if(user()->teamPermission('qr.edit')): ?>
                                    <li><a class="dropdown-item" href="#" data-id="<?php echo $qr->id ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#channelModal" data-toggle="addtochannel"><i data-feather="package"></i> <?php ee('Add to Channel') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo route('links.reset', [$qr->urlid, \Core\Helper::nonce('link.reset')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#resetModal"><i data-feather="rotate-ccw"></i> <?php ee('Reset Stats') ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo route('qr.duplicate', [$qr->id]) ?>"><i data-feather="copy"></i> <?php ee('Duplicate') ?></a></li>
                                <?php endif ?>
                                <?php if(user()->teamPermission('qr.delete')): ?>
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('qr.delete', [$qr->id, \Core\Helper::nonce('qr.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                <?php endif ?>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <a href="<?php echo route('qr.generate', [$qr->alias]) ?>" target="_blank"><img src="<?php echo route('qr.generate', [$qr->alias]) ?>" width="150" class="img-fluid rounded"></a>
                        </div>
                        <strong><?php echo $qr->name ?: 'n\a' ?></strong>
                        <div class="border p-2 rounded rounded-4 mt-4 text-start">  
                            <i data-feather="aperture"></i> <span class="align-middle me-2"><?php echo \Helpers\QR::types($qr->data->type)['name'] ?></span> 
                            <?php if(isset($qr->scans)):?>
                                <i data-feather="eye"></i> <span class="align-middle ms-2 me-2"><?php echo $qr->scans .' '.e('Scans') ?></span>
                            <?php endif ?>
                            <i data-feather="clock"></i> <span class="align-middle ms-1"><?php echo \Core\Helper::timeago($qr->created_at) ?></span>
                        </div>
                        <div class="text-start">
                        <?php if($channels = $qr->channels): ?>
                            <div class="mt-3">
                            <?php foreach($channels as $channel): ?>
                                <small class="badge text-xs me-2 p-1 px-2 rounded-3 text-white" style="background-color: <?php echo $channel->color ?>!important;"><?php echo $channel->name ?> <a href="<?php echo route('channel.removefrom', [$channel->id, 'qr', $qr->id]) ?>" class="ms-1 text-danger border-start ps-1 text-white" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Remove from channel') ?>"><i data-feather="x"></i></span></a></small>
                            <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <div class="card rounded-4 flex-fill shadow-sm">
        <div class="card-body text-center">
            <p><?php ee('No content found. You can create some.') ?></p>
            <?php if(user()->teamPermission('qr.create')): ?>
                <a href="<?php echo route('qr.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create QR') ?></a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
<div class="mt-4 d-block">
    <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
</div>

<?php if(user()->teamPermission('qr.delete')): ?>
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
<div class="modal fade" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to reset this?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to reset all statistic data for this link. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="channelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo route('channel.addto', ['qr', null]) ?>" data-trigger="server-form">
        <?php echo csrf() ?>
        <div class="modal-header">
            <h5 class="modal-title fw-bold"><?php ee('Add to Channels') ?></h5>
            <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
        </div>
        <div class="modal-body">
            <label for="channels" class="form-label d-block mb-2"><?php ee('Channels') ?></label>
            <div class="form-group rounded input-select">
                <select name="channels[]" id="channels" class="form-control" multiple data-toggle="select">
                    <?php foreach(\Core\DB::channels()->where('userid', user()->rID())->findArray() as $channel): ?>
                        <option value="<?php echo $channel['id'] ?>"><?php echo $channel['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <input type="hidden" name="channelids" id="channelids" value="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal" data-trigger="addtocampaign"><?php ee('Add') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteAllModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to proceed?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete many records. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="<?php echo route('qr.deleteall') ?>" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="submitchecked"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="downloadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Download QR Codes') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo route('qr.downloadall') ?>" method="post">
            <?php echo csrf() ?>
            <div class="form-group">
                <label class="form-label fw-bold"><?php ee('Download as') ?></label>
                <select name="format" class="form-select">
                    <option value="svg">SVG</option>
                    <?php if(!!config('imagemagick')): ?>
                        <option value="png">PNG</option>
                        <option value="webp">WebP</option>
                        <option value="pdf">PDF</option>
                    <?php endif ?>
                </select>
            </div>
            <input type="hidden" name="qrids" id="qrids" value="">
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm mt-2" data-bs-close data-bs-dismiss="modal"><?php ee('Download') ?></button>       
        </form>
      </div>
    </div>
  </div>
</div>