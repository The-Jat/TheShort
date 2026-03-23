<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Blog') ?></li>
  </ol>
</nav>
<div class="d-flex mb-4 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Posts') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.blog.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Post') ?></a>
    </div>
</div>
<div class="card rounded-4 shadow-sm mb-4 p-2">
    <div class="d-sm-flex align-items-center">
        <form method="post" action="" data-trigger="options">
            <?php echo csrf() ?>
            <input type="hidden" name="selected">
            <div class="d-flex align-items-center me-3 mb-2 mb-sm-0">
                <span class="btn btn-white me-2"><input class="form-check-input" type="checkbox" data-trigger="checkall"></span>
                <div class="btn-group">
                    <button type="button" class="btn btn-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="align-middle"><?php ee('Bulk Actions') ?></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo route('admin.blog.publishall') ?>" data-trigger="submitchecked"><i data-feather="eye"></i> <?php ee('Publish Selected') ?></a></li>
                        <li><a class="dropdown-item" href="<?php echo route('admin.blog.unpublishall') ?>" data-trigger="submitchecked"><i data-feather="eye-off"></i> <?php ee('Unpublish Selected') ?></a></li>
                        <li><a class="dropdown-item" href="<?php echo route('admin.blog.resetviewsall') ?>" data-trigger="submitchecked"><i data-feather="refresh-cw"></i> <?php ee('Reset Views') ?></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteAllModal" href=""><i data-feather="trash"></i> <?php ee('Delete Selected') ?></a></li>
                    </ul>
                </div>
            </div>
        </form>
        <form action="" method="get" class="d-sm-flex flex-grow-1 align-items-center ms-sm-5">
            <div class="flex-grow-1 me-2 mb-2 mb-sm-0">
                <input type="text" class="form-control p-2 rounded-3" name="q" value="<?php echo clean(request()->q) ?>" placeholder="<?php ee('Search posts by title or content...') ?>">
            </div>
            <div class="me-2 mb-2 mb-sm-0" style="min-width: 150px;">
                <select name="category" class="form-select p-2 rounded-3">
                    <option value="all"<?php if(!request()->category || request()->category == 'all') echo ' selected' ?>><?php ee('All Categories') ?></option>
                    <?php if(isset($categories) && !empty($categories)): ?>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category->id ?>"<?php if(request()->category == $category->id) echo ' selected' ?>><?php echo $category->name ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <div class="me-2 mb-2 mb-sm-0" style="min-width: 150px;">
                <select name="lang" class="form-select p-2 rounded-3">
                    <option value="all"<?php if(!request()->lang || request()->lang == 'all') echo ' selected' ?>><?php ee('All Languages') ?></option>
                    <?php if(isset($langList) && !empty($langList)): ?>
                        <?php foreach($langList as $langCode): ?>
                            <?php 
                                $langName = isset($langInfo[$langCode]) ? $langInfo[$langCode] : strtoupper($langCode);
                            ?>
                            <option value="<?php echo $langCode ?>"<?php if(request()->lang == $langCode) echo ' selected' ?>><?php echo $langName ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <button type="submit" class="btn btn-dark rounded-3 px-4 py-2 shadow-sm me-2">
                <i data-feather="search"></i> <?php ee('Search') ?>
            </button>
            <?php if(request()->q || (request()->lang && request()->lang != 'all') || (request()->category && request()->category != 'all')): ?>
                <a href="<?php echo route('admin.blog') ?>" class="btn btn-white border rounded-3 px-4 py-2 shadow-sm">
                    <i data-feather="x"></i> <?php ee('Clear') ?>
                </a>
            <?php endif ?>
        </form>
    </div>
</div>
<div class="card rounded-4 shadow-sm flex-fill">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Name') ?></th>
                    <th><?php ee('Author') ?></th>
                    <th class="d-none d-xl-table-cell"><?php ee('Language') ?></th>
                    <th class="d-none d-xl-table-cell"><?php ee('Published / Scheduled Date') ?></th>
                    <th class="d-none d-xl-table-cell"><?php ee('Views') ?></th>
                    <th class=""></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($posts as $post): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <input class="form-check-input me-3" type="checkbox" data-dynamic="1" value="<?php echo $post->id ?>">
                                <div class="d-flex align-items-center">
                                  <span class="badge <?php echo $post->published ? 'bg-success' : 'bg-danger' ?> me-2 px-1 py-0 rounded-circle" data-bs-toggle="tooltip" title="<?php echo $post->published ? e('Published') : e('Draft') ?>">&nbsp;</span>
                                  <div>
                                    <a href="<?php echo route('blog.post', [$post->slug]) ?>?lang=<?php echo $post->lang ?? 'en' ?>" target="_blank" class="align-middle"><?php echo $post->title ?></a>
                                    <?php if(strtotime($post->date) > time()): ?>
                                        <span class="badge bg-warning text-dark rounded-3 ms-1"><?php ee('Scheduled') ?></span>
                                    <?php endif ?>
                                    <?php if($post->categoryname): ?>
                                      <br>
                                      <span class="text-muted fw-bold small"><?php echo $post->categoryname ?></span>
                                    <?php endif ?>
                                  </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-xl-table-cell"><?php echo $post->user->name ?? $post->user->username ?></td>
                        <td class="d-none d-xl-table-cell"><?php echo $post->lang ?? 'en' ?></td>
                        <td class="d-none d-xl-table-cell"><?php echo \Core\Helper::dtime($post->date, "d-m-Y") ?></td>
                        <td class="d-none d-xl-table-cell"><?php echo $post->views ?></td>
                        <td class="t">
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('blog.post', [$post->slug]) ?>" target="_blank"><i data-feather="eye"></i> <?php ee('View') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.blog.edit', [$post->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php if($post->published): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.blog.toggle', [$post->id, \Core\Helper::nonce('blog.toggle')]) ?>"><i data-feather="eye-off"></i> <?php ee('Unpublish') ?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo route('admin.blog.toggle', [$post->id, \Core\Helper::nonce('blog.toggle')]) ?>"><i data-feather="eye"></i> <?php ee('Publish') ?></a></li>
                                <?php endif ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.blog.delete', [$post->id, \Core\Helper::nonce('blog.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
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
        <a href="<?php echo route('admin.blog.deleteall') ?>" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="submitchecked"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>