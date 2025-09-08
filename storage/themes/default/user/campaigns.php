<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bold mb-0">
        <?php ee('Campaigns') ?>
        <i class="fa fa-question-circle fs-6 text-muted opacity-50" data-bs-toggle="tooltip" title="<?php echo ee('A campaign can be used to group links together for various purpose. You can use the dedicated rotator link where a random link will be chosen and redirected to among the group. You will also be able to view aggregated statistics for a campaign.') ?>"></i>
    </h1>
    <div class="ms-auto">
        <?php if(user()->teamPermission('bundle.create')): ?>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Create a Campaign') ?></a>
        <?php endif ?>
    </div>
</div>
<?php if(!user()->public || !user()->defaultbio): ?>
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-3"><?php ee('Campaign List Disabled') ?></h5>

            <p><?php ee('To create a list page for the campaign, you need a default bio page and public profile settings.') ?></p>

            <p><i <?php echo (user()->defaultbio ? 'data-feather="check-circle" class="text-success"' : 'data-feather="x-circle" class="text-danger"') ?>></i> <span class="align-middle"><?php ee('Default Bio') ?></span></p>
            <p class="mb-0"><i <?php echo (user()->public ? 'data-feather="check-circle" class="text-success"' : 'data-feather="x-circle" class="text-danger"') ?>></i> <span class="align-middle"><?php ee('Public Profile') ?></span></p>
        </div>
    </div>
<?php endif ?>
<?php if($campaigns): ?>
    <div class="row">
        <?php foreach($campaigns as $campaign): ?>
            <div class="col-md-4">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-body">
                        <button type="button" class="btn btn-default bg-transparent btn-sm float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></button>
                        <ul class="dropdown-menu">
                            <?php if(user()->teamPermission('bundle.edit')): ?>
                            <li><a class="dropdown-item" href="<?php echo route('campaigns.update', [$campaign->id]) ?>" data-bs-toggle="modal" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo htmlentities(json_encode(['newname' => $campaign->name, 'newslug' => $campaign->slug, 'newaccess' => $campaign->access == 'public' ? '1' : '0']), ENT_QUOTES) ?>'><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                            <?php endif ?>                            
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo route('links', ['campaign' => $campaign->id]) ?>"><i data-feather="link"></i> <?php ee('Links') ?></span></a></li>
                            <li><a class="dropdown-item" href="<?php echo route('campaigns.stats', [$campaign->id]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></span></a></li>
                            <?php if(user()->teamPermission('bundle.delete')): ?>
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo route('campaigns.delete', [$campaign->id, \Core\Helper::nonce('campaign.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                            <?php endif ?>
                        </ul>

                        <div class="mb-2">
                            <?php if($campaign->access == 'private'): ?>
                                <span class="badge bg-danger me-2 px-1 py-0 rounded-circle" data-bs-toggle="tooltip" title="<?php ee('Inactive') ?>">&nbsp;</span>
                            <?php else: ?>
                                <span class="badge bg-success me-2 px-1 py-0 rounded-circle" data-bs-toggle="tooltip" title="<?php ee('Active') ?>">&nbsp;</span> 
                            <?php endif ?>
                            <strong><?php echo $campaign->name ?></strong>
                        </div>
                        <?php if($campaign->slug): ?>
                            <?php if(user()->username): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-table-list me-2" data-bs-toggle="tooltip" title="<?php ee('List') ?>"></i>
                                    <small class="text-muted" data-href="<?php echo \Helpers\App::shortRoute($campaign->domain, 'u/'.user()->username.'/'.$campaign->slug.'-'.$campaign->id) ?>"><?php echo \Helpers\App::shortRoute($campaign->domain, 'u/'.user()->username.'/'.$campaign->slug.'-'.$campaign->id) ?></small>
                                    <a href="#copy" class="copy inline-copy ms-2" data-clipboard-text="<?php echo \Helpers\App::shortRoute($campaign->domain, 'u/'.user()->username.'/'.$campaign->slug.'-'.$campaign->id) ?>"><small><?php echo e("Copy")?></small></a>
                                </div>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if($campaign->slug): ?>
                            <div class="d-flex align-items-center">
                                <i class="fa fa-arrows-spin me-2" data-bs-toggle="tooltip" title="<?php ee('Rotator') ?>"></i>
                                <small class="text-muted" data-href="<?php echo \Helpers\App::shortRoute($campaign->domain, 'r/'.$campaign->slug) ?>"><?php echo \Helpers\App::shortRoute($campaign->domain, 'r/'.$campaign->slug) ?></small>
                                <a href="#copy" class="copy inline-copy ms-2" data-clipboard-text="<?php echo \Helpers\App::shortRoute($campaign->domain, 'r/'.$campaign->slug) ?>"><small><?php echo e("Copy")?></small></a>
                            </div>
                        <?php endif ?>
                        <p class="text-muted mb-0 mt-3"><?php ee('This campaign was created {t}, contains {x} and has {y}.', null, ['t' => "<strong>".\Core\Helper::timeago($campaign->date)."</strong>", 'x' => "<a href=\"".route('links', ['campaign' => $campaign->id])."\"><strong>". $campaign->urlcount." ".e('link|links', $campaign->urlcount)."</strong></a>", 'y' => "<a href=\"".route('campaigns.stats', [$campaign->id])."\"><strong>".$campaign->view." ".e('views')."</strong></a>"]) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <div class="card flex-fill rounded-4 shadow-sm">
        <div class="card-body text-center">
            <p><?php ee('No content found. You can create some.') ?></p>
            <?php if(user()->teamPermission('bundle.create')): ?>
            <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary btn-sm"><?php ee('Create a Campaign') ?></a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
<div class="mt-4 d-block">
    <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
</div>
<?php if(user()->teamPermission('bundle.create')): ?>
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo route('campaigns.save') ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Create a Campaign') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label fw-bold"><?php ee("Campaign Name") ?> (<?php ee("required") ?>)</label>
                    <input type="text" value="" name="name" class="form-control p-2">
                </div>
                <?php if($domains = \Helpers\App::domains()): ?>
                    <div class="mb-3 form-group rounded input-select">
                        <label for="domain" class="form-label fw-bold"><?php ee('Domain') ?></label>
                        <select name="domain" id="domain" class="form-select border-start-0 ps-0" data-toggle="select">
                            <?php foreach($domains as $domain): ?>
                                <option value="<?php echo $domain ?>" <?php echo user()->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                <?php endif ?>
                <div class="form-group mb-3">
                    <label class="form-label fw-bold"><?php ee("Rotator Slug") ?> (<?php ee("optional") ?>)</label>
                    <input type="text" value="" name="slug" class="form-control p-2">
                    <p class="form-text"><?php ee("If you want to set a custom alias for the rotator link, you can fill this field.") ?></p>
                </div>
                <div class="d-flex">
                    <div>
                        <label class="form-check-label fw-bold" for="access"><?php ee('Access') ?></label>
                        <p class="form-text my-0"><?php ee('Disabling this option will deactivate the rotator link.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto align-self-center">
                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="access" name="access" value="1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Create Campaign') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>
<?php if(user()->teamPermission('bundle.edit')): ?>
<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Update Campaign') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label fw-bold"><?php ee("Campaign Name") ?> (<?php ee("required") ?>)</label>
                    <input type="text" value="" name="newname" id="newname" class="form-control p-2">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label fw-bold"><?php ee("Rotator Slug") ?> (<?php ee("optional") ?>)</label>
                    <input type="text" value="" name="newslug" id="newslug" class="form-control p-2">
                    <p class="form-text"><?php ee("If you want to set a custom alias for the rotator link, you can fill this field.") ?></p>
                </div>
                <div class="d-flex">
                    <div>
                        <label class="form-check-label fw-bold" for="access"><?php ee('Access') ?></label>
                        <p class="form-text my-0"><?php ee('Disabling this option will deactivate the rotator link.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto align-self-center">
                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="newaccess" name="newaccess" value="1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Update Campaign') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>
<?php if(user()->teamPermission('bundle.delete')): ?>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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