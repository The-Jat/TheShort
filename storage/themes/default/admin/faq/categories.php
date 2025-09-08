
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.faq') ?>"><?php ee('Articles') ?></a></li>
  </ol>
</nav>
<h1 class="h3 mb-5 fw-bold"><?php ee('Article Categories') ?></h1>
<div class="row">
    <div class="col-md-4">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.faq.categories.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group mb-4">
                        <label for="title" class="form-label fw-bold"><?php ee('Title') ?></label>
                        <input type="text" class="form-control p-2" name="title" id="title" value="<?php echo old('title') ?>" placeholder="My Sample Category" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="iconstyle" class="form-label fw-bold fw-bolder"><?php ee('Icon Style') ?></label>
                        <select class="form-select p-2" id="iconstyle" name="iconstyle">
                            <option value="icon"><?php ee('Fontawesome Icon') ?></option>
                            <option value="emoji"><?php ee('Emoji') ?></option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="icon" class="form-label fw-bold fw-bolder"><?php ee('Icon/Emoji') ?></label>
                        <input type="text" class="form-control p-2" name="icon" id="icon" value="<?php echo old('icon') ?>" placeholder="Fontawesome Icon or Emoji" autocomplete="off">
                    </div>
                    <div class="form-group mb-4">
                        <label for="lang" class="form-label fw-bold"><?php ee('Language') ?></label>
                        <select class="form-select p-2" name="lang">
                            <option value="en">English</option>
                            <?php foreach(\Core\Localization::listInfo() as $lang): ?>
                                <option value="<?php echo $lang['code'] ?>"><?php echo $lang['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="description" class="form-label fw-bold"><?php ee('Short Description') ?></label>
                        <textarea name="description" id="description" class="form-control"><?php echo old('description') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Category') ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Category') ?></th>
                            <th><?php ee('Description') ?></th>
                            <th><?php ee('Language') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $id => $category): ?>
                            <tr>
                                <td><a href="<?php echo route('help.category', [$id]) ?>" target="_blank">
                                <?php echo $category->formattedicon ?>
                                <?php echo $category->title ?></a></td>
                                <td><?php echo $category->description?:e('none') ?></td>
                                <td><?php echo $category->lang ?? 'en' ?></td>
                                <td>
                                    <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('admin.faq.categories.update', [$id]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo htmlentities(json_encode(['newtitle' => $category->title, 'newdescription' => $category->description, 'newicon' => $category->icon ?? '', 'newlang' => $category->lang ?? 'en', 'newiconstyle' => $category->iconstyle ?? 'icon']), ENT_QUOTES) ?>'><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.faq.categories.delete', [$id, \Core\Helper::nonce('category.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Edit Category') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="newtitle" class="form-label fw-bold"><?php ee('Title') ?></label>
                    <input type="text" class="form-control p-2" name="newtitle" id="newtitle" value="" placeholder="My Sample Category" required>
                </div>
                <div class="form-group mb-4">
                    <label for="iconstyle" class="form-label fw-bold fw-bolder"><?php ee('Icon Style') ?></label>
                    <select class="form-select p-2" id="newiconstyle" name="newiconstyle">
                        <option value="icon"><?php ee('Fontawesome Icon') ?></option>
                        <option value="emoji"><?php ee('Emoji') ?></option>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="newicon" class="form-label fw-bold"><?php ee('Icon') ?></label>
                    <input type="text" class="form-control p-2" name="icon" id="newicon" placeholder="Fontawesome Icon" autocomplete="off">
                </div>                
                <div class="form-group mb-4">
                    <label for="lang" class="form-label fw-bold"><?php ee('Language') ?></label>
                    <select class="form-select p-2"  name="newlang" id="newlang">
                        <option value="en">English</option>
                        <?php foreach(\Core\Localization::listInfo() as $lang): ?>
                            <option value="<?php echo $lang['code'] ?>"><?php echo $lang['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="newdescription" class="form-label fw-bold"><?php ee('Short Description') ?></label>
                    <textarea name="newdescription" id="newdescription" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Update Category') ?></button>
            </div>
        </form>
    </div>
  </div>
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