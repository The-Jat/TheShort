<div class="d-flex mb-5">
    <h1 class="h3 mb-0 fw-bold"><span class="align-middle"><?php ee('Tracking Pixels') ?> </span> <i class="fa fa-question-circle text-muted fs-6 opacity-50" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?php echo ee('Ad platforms such as Facebook and Adwords provide a conversion tracking tool to allow you to gather data on your customers and how they behave on your website. By adding your pixel ID from either of the platforms, you will be able to optimize marketing simply by using short URLs.') ?>"></i></h1>
    <div class="ms-auto">
        <?php if(\Core\Auth::user()->teamPermission('pixels.create')): ?>
            <a href="<?php echo route('pixel.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"> <?php ee('Add Pixel') ?></a>
        <?php endif ?>
    </div>
</div>
<div class="card rounded-4 shadow-sm p-2">
    <div class="d-block d-md-flex align-items-center">
        <div>
			<span class="h3 ms-2"><?php echo $count ?></span> <span class="text-muted"> <?php ee('Pixels') ?> / <?php echo $total == 0 ? e('Unlimited') : $total ?></span>
		</div>
        <div class="ms-auto">
            <form action="<?php echo route('pixels') ?>" method="get" class="d-flex align-items-center border rounded-3 p-1">
                <div class="me-2">
                    <input type="text" class="form-control border-0 p-2" name="q" value="<?php echo clean(request()->q) ?>" placeholder="<?php ee('Search for {t}', null, ['t' => e('Tracking Pixels')]) ?>">
                </div>
                <div class="me-2">
                    <div class="input-select d-block">
                        <select name="sort" id="sortable" class="form-select border-0 border-start p-2 pe-5 rounded-0">
                            <optgroup label="<?php ee('Provider') ?>">
                            <option value="all"><?php ee('All') ?></a>
                            <?php foreach($providers as $key => $provider): ?>
                                <option value="<?php echo $key ?>"><?php echo $provider['name'] ?></option>
                            <?php endforeach ?>
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
<?php if($pixels): ?>
    <div class="card rounded-4 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="1%"><?php ee('Provider') ?></th>
                        <th><?php ee('Name') ?></th>
                        <th><?php ee('Tag') ?></th>
                        <th><?php ee('Created') ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pixels as $pixel): ?>
                        <tr>
                            <td>
                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo ucfirst(\Helpers\App::pixelName($pixel->type)) ?>">
                                    <img src="<?php echo assets('images/'.str_replace(['pixel','fb'], ['', 'facebook'], $pixel->type).'.svg') ?>" width="30">
                                </span>
                            </td>
                            <td><strong><?php echo $pixel->name ?: 'n\a' ?></strong></td>
                            <td><span class="badge border border-dark text-dark"><?php echo \Core\Helper::truncate($pixel->tag, 20) ?></span></td>
                            <td><spanass="text-navy"><?php echo \Core\Helper::timeago($pixel->created_at) ?></spantd>
                            <td class="text-end">
                                <button type="button" class="btn btn-default bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></button>
                                <ul class="dropdown-menu">
                                <?php if(\Core\Auth::user()->teamPermission('pixels.edit')): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('pixel.edit', [$pixel->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit Pixel') ?></a></li>
                                <?php endif ?>
                                <?php if(\Core\Auth::user()->teamPermission('pixels.delete')): ?>
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('pixel.delete', [$pixel->id, \Core\Helper::nonce('pixel.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                <?php endif ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 d-block">
        <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
    </div>
<?php else: ?>
    <div class="card rounded-4 shadow-sm">
        <div class="card-body text-center">
            <p><?php ee('No content found. You can create some.') ?></p>
            <?php if(\Core\Auth::user()->teamPermission('pixels.create')): ?>
                <a href="<?php echo route('pixel.create') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Add Pixel') ?></a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>

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
