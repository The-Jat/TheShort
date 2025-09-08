<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Themes') ?></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bold mb-0"><?php ee('Themes') ?></h1>
    <div class="ms-auto">
        <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#uploadModal" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Upload Theme') ?></a>
        <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#customizeModal" class="btn btn-dark rounded-3 px-3 py-2"><?php ee('Child Theme') ?></a>
    </div>
</div>
<div class="row">
     <?php foreach($themes as $theme): ?>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card rounded-4 shadow-sm rounded-5 <?php echo (config('theme') == $theme->id ? 'border-5 border-success' : '') ?>">
                <?php if($theme->thumbnail): ?>
                  <img src="<?php echo $theme->thumbnail ?>"  class="img-fluid img-responsive rounded mb-3 border-bottom" height="220" alt="<?php echo $theme->name ?>">
                <?php else: ?>
                  <div class="w-100 d-flex justify-content-center align-items-center primary-gradient text-white fw-bold rounded mb-3" style="height:213px"><?php echo $theme->name ?></div>
                <?php endif ?>
                <div class="card-body position-relative">
                    <button type="button" class="btn btn-default position-absolute top-0 end-0 my-2 me-2 bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                    <ul class="dropdown-menu">
                        <?php if($theme->id == config('theme') && $theme->settings): ?>
                          <li><a class="dropdown-item" href="<?php echo route('admin.themes.settings') ?>" title="<?php ee('Settings') ?>"><i data-feather="settings"></i> <?php ee('Settings') ?></a></li>
                        <?php endif ?>
                        <li><a class="dropdown-item" href="<?php echo route('admin.themes.clone', [$theme->id, \Core\Helper::nonce('themes.clone')]) ?>" title="<?php ee('Clone Theme') ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#cloneModal"><i data-feather="copy"></i> <?php ee('Clone') ?></a></li>
                        <?php if($theme->id != config('theme')): ?>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="<?php echo route('admin.themes.delete', [$theme->id, \Core\Helper::nonce('themes.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash-2"></i> <?php ee('Delete') ?></a></li>
                        <?php else : ?>
                          <li><a class="dropdown-item" href="<?php echo route('admin.themes.editor') ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>
                        <?php endif ?>
                    </ul>
                    <h5 class="card-title fw-bold"><?php echo $theme->name ?> (v<?php echo $theme->version ?>)</h5>
                    <a href="<?php echo $theme->link ?>" target="_blank"><small class="text-muted"><?php ee('By') ?> <?php echo $theme->author ?></small></a> -
                    <small class="text-muted"><?php ee('Since') ?> <?php echo $theme->date ?></small>
                    <br>
                    <div class="d-flex mt-4">
                        <?php if($theme->child): ?>
                          <span class="badge border-primary border border-2 text-primary fs-6 me-2"><?php ee('Child') ?></span>
                        <?php endif ?>
                        <?php if(config('theme') == $theme->id): ?>
                            <span class="badge border-success border border-2 text-success fs-6 ms-auto"><?php ee('Active') ?></span>
                        <?php else: ?>
                            <a href="<?php echo route('admin.themes.activate', [$theme->id]) ?>" class="btn btn-primary btn-sm rounded fw-bold ms-auto"><?php ee('Activate') ?></a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
     <?php endforeach ?>
</div>
<div class="modal fade" id="customizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Learn how to create a child theme') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('We have introduced the ability to make child themes. Child Themes allow to you change only the part of the website you need to change without having to copy all theme files. They are easy to make and more importantly they are safe from all automated updates.') ?></p>

        <a href="https://gempixel.com/docs/premium-url-shortener#tct" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm" target="_blank"><?php ee('Learn how to make a child theme') ?></a>
      </div>
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
<div class="modal fade" id="cloneModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Things to know about cloning') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are about to clone the whole theme. Please note that if you clone the theme and the original is updated, your cloned theme will not be updated automatically. If you are an experienced user you can continue but otherwise it is recommended to change the cloned theme to a Child Theme so you can customize only some pages while keeping everything else up to date.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="uploadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo route('admin.themes.upload') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Upload New Theme or Update Existing Theme') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="file" class="form-label fw-bold"><?php ee('Theme File') ?></label>
                    <input type="file" class="form-control" name="file" id="file" value="" accept=".zip" placeholder="e.g. theme.zip">
                    <p class="form-text"><?php ee('Upload the zip file that comes in the package. Usually it is named THEMENAME.zip. Please make sure the theme respects the file structure.') ?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Upload') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>