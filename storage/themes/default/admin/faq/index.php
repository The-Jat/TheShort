<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Articles') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bold mb-0"><?php ee('Help Center') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.faq.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Article') ?></a>
    </div>
</div>
<div class="card rounded-4 flex-fill shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Question') ?></th>
                    <th><?php ee('Category') ?></th>
                    <th><?php ee('Views') ?></th>
                    <th><?php ee('Updated on') ?></th>
                    <th>
                        <button type="button" class="btn btn-default bg-transparent p-0 float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="filter"></i></button>
                        <form action="" method="get" class="dropdown-menu p-2">
                            <div class="input-select d-block mb-2">
                                <label for="lang" class="form-label fw-bold"><?php ee('Language') ?></label>
                                <select name="lang" id="lang" class="form-select">
                                    <option value=""><?php ee('All') ?></option>
                                    <option value="en" <?php echo request()->lang == 'en' ? 'selected' : '' ?>>English</option>
                                    <?php foreach(\Core\Localization::listInfo() as $lang): ?>
                                        <option value="<?php echo $lang['code'] ?>" <?php echo request()->lang == $lang['code'] ? 'selected' : '' ?>><?php echo $lang['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Filter') ?></button>
                        </form>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($faqs as $faq): ?>
                    <tr>
                        <td>
                            <a href="<?php echo route('help.single', [$faq->slug], $faq->lang) ?>" target="_blank"><?php echo $faq->question ?></a>
                            <?php if($faq->pricing): ?>
                                <span class="badge bg-success"><?php ee("Pricing Page") ?></span>
                            <?php endif ?>
                            <span class="text-muted small d-block"><?php echo route('help.single', $faq->slug, $faq->lang) ?></span>
                        </td>
                        <td><a href="<?php echo route('help.category', $faq->category, $faq->lang) ?>" target="_blank"><?php echo ucfirst($faq->category) ?></a> (<?php echo $faq->lang ?? 'en' ?>)</td>
                        <td><?php echo $faq->views ?></td>
                        <td><?php echo \Core\Helper::dtime($faq->created_at, 'd-m-Y') ?></td>
                        <td>
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('admin.faq.edit', [$faq->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.faq.delete', [$faq->id, \Core\Helper::nonce('faq.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <?php echo pagination('pagination') ?>
</div>
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