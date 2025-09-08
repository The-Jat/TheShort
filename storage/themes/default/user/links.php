<h3 class="h3 mb-5 fw-bold"><?php echo $title ?></h3>
<div class="row">
    <div class="col-md-8">
		<?php if(user()->teamPermission('links.create') && \Gem::currentRoute() == 'links'): ?>
			<?php if(config('manualapproval') && !user()->verified): ?>
				<div class="alert bg-dark rounded p-3 text-white"><?php ee('We are currently manually approving links. As soon as the link is approved, you will be able to start using it.') ?></div>
			<?php endif ?>
			<div class="card rounded-4 shadow-sm mb-0">
				<div class="card-body">
					<?php view('partials.shortener') ?>
				</div>
			</div>
		<?php endif ?>
        <div class="card shadow-sm rounded-4 mb-2 mt-4">
            <div class="p-3 d-flex align-items-center">
                <div>
                    <form method="post" action="" data-trigger="options">
                        <?php echo csrf() ?>
                        <input type="hidden" name="selected">
                        <div class="btn-group btn-group-sm border rounded-3 px-1">
                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e("Select All") ?>" data-trigger="selectall" class="fa fa-check-square btn px-3 py-2"></a>
                            <a href="#" data-bs-toggle="dropdown" class="btn p-1"><span data-count-selected="<?php ee('Selected') ?>"><?php ee('Actions') ?></span> <i class="fa fa-chevron-down ms-2"></i></a>
                            <div class="dropdown-menu">
                                <?php if(user()->teamPermission('links.edit')): ?>
                                    <?php if(\Gem::currentRoute() == 'archive'): ?>
                                        <a href="<?php echo route('links.unarchive') ?>" data-trigger="archiveselected" class="dropdown-item px-3"><i data-feather="briefcase" class="me-2"></i> <?php echo e("Unarchive Selected") ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo route('links.archive') ?>" data-trigger="archiveselected" class="dropdown-item px-3"><i data-feather="briefcase" class="me-2"></i> <?php echo e("Archive Selected") ?></a>
                                    <?php endif ?>
                                <?php endif ?>
                                <?php if(user()->teamPermission('links.edit')): ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#bundleModal" data-trigger="getchecked" data-for="#bundleids" class="dropdown-item px-3"><i data-feather="crosshair" class="me-2"></i> <?php echo e("Add to Campaign") ?></a>                                    

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#channelModal" data-trigger="getchecked" data-for="#channelids" class="dropdown-item px-3"><i data-feather="package" class="me-2"></i> <?php echo e("Add to Channel") ?></a>

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#pixelModal" data-trigger="getchecked" data-for="#pixelids" class="dropdown-item px-3"><i data-feather="compass" class="me-2"></i> <?php echo e("Add Pixels") ?></a>
                                </span>
                                <?php endif ?>
                                <?php if(\Models\User::where('id', user()->rID())->first()->has('export') !== false): ?>
                                    <a href="<?php echo route('links.export') ?>" data-trigger="submitchecked" class="dropdown-item px-3"><i data-feather="download" class="me-2"></i> <?php echo e("Export") ?></a>
                                <?php endif ?>
                                <div class="dropdown-divider"></div>
                                <?php if(user()->teamPermission('links.delete')): ?>
                                    <a title="<?php echo e("Delete Selected") ?>" data-bs-toggle="modal" data-bs-target="#deleteAllModal" class="dropdown-item px-3 text-danger"><i data-feather="trash" class="me-2"></i> <?php echo e("Delete Selected") ?></a>
                                <?php endif ?>                                    
                            </div>
                        </div>
                    </form>
                </div>
                <div class="my-md-0 my-2 ms-auto">
                    <div class="rounded border">
                      <form action="" method="get">
                        <a href="#search" data-bs-toggle="collapse" class="btn btn-white bg-white"><i class="align-middle" data-feather="search"></i></a>
                        <button type="button" class="btn btn-default bg-white border-start" data-bs-toggle="dropdown"  aria-expanded="false"><span  data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Sort Results') ?>"><i data-feather="filter"></i></span></button>
                        <div class="dropdown-menu p-2">
                            <div class="input-select d-block mb-2">
                              <label for="sort" class="form-label fw-bold"><?php ee('Sort By') ?></label>
                              <select name="sort" id="sort" data-name="sort" class="form-select">
                                <optgroup label="Sort by">
                                  <option value=""<?php if(!request()->sort) echo " selected" ?>><?php ee('Newest') ?></option>
                                  <option value="old"<?php if(request()->sort == 'old') echo " selected" ?>><?php ee('Oldest') ?></option>
                                  <option value="most"<?php if(request()->sort == 'most') echo " selected" ?>><?php ee('Most Popular') ?></option>
                                  <option value="less"<?php if(request()->sort == 'less') echo " selected" ?>><?php ee('Less Popular') ?></option>
                                </optgroup>
                              </select>
                            </div>
                            <?php if(user()->has('bundle')): ?>
                            <div class="input-select d-block mb-2">
                              <label for="campaign" class="form-label fw-bold"><?php ee('Campaign') ?></label>
                              <select name="campaign" id="campaign" data-name="campaign" class="form-select">
                                  <option value=""<?php if(!request()->campaign) echo " selected" ?>><?php ee('All') ?></option>
                                  <?php foreach(\Core\DB::bundle()->where('userid', user()->rID())->orderByDesc('id')->findArray() as $bundle): ?>
                                      <option value="<?php echo $bundle['id'] ?>" <?php if(request()->campaign == $bundle['id']) echo 'selected' ?>><?php echo $bundle['name'] ?></option>
                                  <?php endforeach ?>
                              </select>
                            </div>
                            <?php endif ?>
                            <?php if(user()->has('channels')): ?>
                            <div class="input-select d-block mb-2">
                              <label for="channel" class="form-label fw-bold"><?php ee('Channel') ?></label>
                              <select name="channel" id="channel" data-name="channel" class="form-select">
                                  <option value=""<?php if(!request()->channel) echo " selected" ?>><?php ee('All') ?></option>
                                  <?php foreach(\Core\DB::channels()->where('userid', user()->rID())->orderByDesc('id')->findArray() as $channel): ?>
                                      <option value="<?php echo $channel['id'] ?>" <?php if(request()->channel == $channel['id']) echo 'selected' ?>><?php echo $channel['name'] ?></option>
                                  <?php endforeach ?>
                              </select>
                            </div>
                            <?php endif ?>
                            <div class="input-select d-block mb-2">
                                <label for="perpage" class="form-label fw-bold"><?php ee('Results Per Page') ?></label>
                                <select name="perpage" id="perpage" data-name="perpage" class="form-select">
                                    <option value="15"<?php if(!request()->perpage) echo " selected" ?>>15</option>
                                    <option value="50"<?php if(request()->perpage == 50) echo " selected" ?>>50</option>
                                    <option value="100"<?php if(request()->perpage == 100) echo " selected" ?>>100</option>
                                </select>
                            </div>
                            <div class="input-select d-block mb-2">
                              <label for="perpage" class="form-label fw-bold"><?php ee('Older than') ?></label>
                              <input type="text" class="form-control" name="date" placeholder="" value="<?php echo clean(request()->date) ?>" data-toggle="datepicker">
                            </div>
                            <button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Filter') ?></button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
            <form class="rounded border collapse mb-3 p-3 mx-3" id="search" action="<?php echo route('search') ?>">
                <div class="input-group input-group-navbar">
                    <input type="text" class="form-control bg-white rounded-3" placeholder="<?php ee('Search for links') ?>" aria-label="Search">
                    <button class="btn btn-white bg-white" type="submit">
                        <i class="align-middle" data-feather="search"></i>
                    </button>
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-white d-none bg-white" data-trigger="clearsearch">
                        <i class="align-middle" data-feather="x"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="links">            
            <div id="return-ajax"></div>
            <div id="link-holder" data-refresh="<?php echo \Gem::currentRoute() == 'archive' ? route('links.refresh.archive') : route('links.refresh') ?>" data-fetch="<?php echo route('links.fetch')?>">
                <?php foreach($urls as $url): ?>
                    <?php view('partials.links', compact('url')) ?>
                <?php endforeach ?>

                <div class="mt-4 d-block">
                    <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php \Helpers\App::ads('resp') ?>

        <div class="card shadow-sm rounded-4">
          <div class="card-body">
            <h5 class="fw-bold mb-3"><?php ee('Links') ?> <small class="float-end"><?php echo $count ?> / <?php echo ($total == 0 ? e('Unlimited') : $total).(user()->plan('counttype') == 'monthly' ? ' '.e('per month') : '') ?></small></h5>
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?php echo $total == 0 ? 100 : round($count*100/$total) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </div>

        <?php if(\Models\User::where('id', user()->rID())->first()->has('export') !== false): ?>
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><?php ee('Export Links') ?></h5>
                <p><?php ee('This tool allows you to generate a list of urls in CSV format. Some basic data such clicks will be included as well.') ?></p>
                <a href="<?php echo route('user.export.links') ?>" class="btn bg-white border px-5 py-2 rounded-3 shadow-sm w-100 fw-bold"><?php ee('Export') ?></a>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>
<?php if(user()->teamPermission('links.delete')): ?>
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
        <a href="<?php echo route('links.deleteall') ?>" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="submitchecked"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
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
<?php endif ?>
<div class="modal fade" id="bundleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo route('links.addtocampaign') ?>" data-trigger="server-form">
        <?php echo csrf() ?>
        <div class="modal-header">
            <h5 class="modal-title fw-bold"><?php ee('Add to Campaign') ?></h5>
            <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
        </div>
        <div class="modal-body">
            <label for="campaigns" class="form-label d-block mb-2"><?php ee('Campaigns') ?></label>
            <div class="input-group input-select">
                <select name="campaigns" id="campaigns" class="form-control" data-toggle="select">
                    <option value="0"><?php ee('None') ?></option>
                    <?php foreach(\Core\DB::bundle()->where('userid', user()->rID())->findArray() as $campaign): ?>
                        <option value="<?php echo $campaign['id'] ?>"><?php echo $campaign['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <input type="hidden" name="bundleids" id="bundleids" value="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal" data-trigger="addtocampaign"><?php ee('Add') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="channelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo route('channel.addto', ['links', null]) ?>" data-trigger="server-form">
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
<div class="modal fade" id="pixelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?php echo route('pixels.addto') ?>" data-trigger="server-form">
        <?php echo csrf() ?>
        <div class="modal-header">
            <h5 class="modal-title fw-bold"><?php ee('Add Pixels') ?></h5>
            <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
        </div>
        <div class="modal-body">
            <label for="pixels" class="form-label d-block mb-2"><?php ee('Pixels') ?></label>
            <div class="form-group rounded input-select">
                <select name="pixels[]" data-placeholder="Your Pixels" multiple data-toggle="select">
                    <?php foreach(\Core\Auth::user()->pixels() as $type => $pixels): ?>
                        <optgroup label="<?php echo ucwords($type) ?>">
                        <?php foreach($pixels as $pixel): ?>
                            <option value="<?php echo $pixel->id ?>"><?php echo $pixel->name ?></option>
                        <?php endforeach ?>
                        </optgroup>
                    <?php endforeach ?>
                </select>
            </div>
            <input type="hidden" name="pixelids" id="pixelids" value="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal" data-trigger="addtopixels"><?php ee('Add') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>