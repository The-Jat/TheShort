<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.page') ?>"><?php ee('Pages') ?></a></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('New Page') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('admin.page.save') ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="My Sample Page">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="slug" class="form-label fw-bold"><?php ee('Slug') ?></label>
                        <input type="text" class="form-control p-2" name="slug" id="slug" value="<?php echo old('slug') ?>" placeholder="my-sample-page">
                        <p class="form-text"><?php ee('Leave this empty to automatically generate it from the title.') ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4 rounded input-select">
                        <label for="category" class="form-label fw-bold"><?php ee('Category') ?></label>
                        <select class="form-select p-2" name="category" id="category">
                            <?php foreach(\Helpers\App::pageCategories() as $id => $category): ?>
                                <option value="<?php echo $id ?>"><?php echo $category ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="lang" class="form-label fw-bold"><?php ee('Language') ?></label>
                        <select class="form-select p-2" name="lang">
                            <option value="en">English</option>
                            <?php foreach(\Core\Localization::listInfo() as $lang): ?>
                                <option value="<?php echo $lang['code'] ?>"><?php echo $lang['name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="content" class="form-label fw-bold"><?php ee('Content') ?></label>
                <p class="form-text"><?php ee('Use the rich editor below to write your page.') ?></p>
                <textarea name="content" id="editor" class="form-control"><?php echo old('content') ?></textarea>
            </div>

            <div class="border rounded rounded-4 rounded-4 p-2 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="metatitle" class="form-label fw-bold"><?php ee('Meta Title') ?></label>
                            <input type="text" class="form-control p-2" name="metatitle" id="metatitle" value="">
                            <p class="form-text"><?php ee('If you want to define a custom meta title fill this field otherwise leave it empty to use post title.') ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="metadescription" class="form-label fw-bold"><?php ee('Meta Description') ?></label>
                            <input type="text" class="form-control p-2" name="metadescription" id="metadescription" value="">
                            <p class="form-text"><?php ee('If you want to define a custom meta description fill this field otherwise leave it empty to use post title.') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu" class="form-label fw-bold"><?php ee('Menu') ?></label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" data-binary="true" id="menu" name="menu" value="1" checked>
                    <label class="form-check-label" for="menu"><?php ee('Enabled') ?></label>
                </div>
                <p class="form-text"><?php ee('Do you want to add a link to this page in the menu?') ?></p>
            </div>
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Page') ?></button>
        </form>

    </div>
</div>