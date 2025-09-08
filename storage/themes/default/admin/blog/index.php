<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Blog') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Posts') ?></h1>
    <div class="ms-auto">
        <a href="<?php echo route('admin.blog.new') ?>" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Add Post') ?></a>
    </div>
</div>
<div class="card rounded-4 shadow-sm flex-fill">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th><?php ee('Name') ?></th>
                    <th><?php ee('Category') ?></th>
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
                            <span class="badge <?php echo $post->published ? 'bg-success' : 'bg-danger' ?> me-2 px-1 py-0 rounded-circle" data-bs-toggle="tooltip" title="<?php echo $post->published ? e('Published') : e('Draft') ?>">&nbsp;</span>
                            <a href="<?php echo route('blog.post', [$post->slug]) ?>?lang=<?php echo $post->lang ?? 'en' ?>" target="_blank" class="align-middle"><?php echo $post->title ?></a>
                            <?php if(strtotime($post->date) > time()): ?>
                                <span class="badge bg-warning text-dark rounded-3 ms-1"><?php ee('Scheduled') ?></span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($post->categoryname): ?>
                                <span class="badge border border-dark text-dark"><?php echo $post->categoryname ?></span>
                            <?php endif ?>
                        </td>
                        <td class="d-none d-xl-table-cell"><?php echo $post->lang ?? 'en' ?></td>
                        <td class="d-none d-xl-table-cell"><?php echo \Core\Helper::dtime($post->date, "d-m-Y") ?></td>
                        <td class="d-none d-xl-table-cell"><?php echo $post->views ?></td>
                        <td class="t">
                            <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo route('blog.post', [$post->slug]) ?>" target="_blank"><i data-feather="eye"></i> <?php ee('View') ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo route('admin.blog.edit', [$post->id]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
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