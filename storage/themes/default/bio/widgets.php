<div class="modal fade" id="contentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content rounded-lg shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title fw-bolder text-center w-100 d-block"><?php ee('Add Link or Content') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div id="modalcontent">
            <div id="biowidgets">
                <div class="d-flex px-3 border rounded-pill mb-3 align-items-center">
                    <span><i class="fa fa-search"></i></span>
                    <div class="form-floating flex-fill">
                      <input type="text" data-trigger="livesearch" class="form-control border-0 bg-transparent" placeholder="<?php ee('Search') ?>">
                        <label><?php ee('Search') ?></label>
                    </div>
                </div>
                <?php foreach(\Helpers\BioWidgets::widgetsByCategory() as $category => $widgets): ?>
                    <h4 class="mb-4 fw-bold"><?php ee(ucfirst($category)) ?></h4>
                    <div class="row mb-5" id="content-<?php echo $category ?>">
                        <?php foreach($widgets as $name => $widget): ?>
                            <div class="col-sm-6 mb-3 item">
                              <?php if(isset($widget['available']) && !$widget['available']): ?>
                                <a href="<?php echo route('pricing') ?>" class="d-block text-decoration-none border rounded p-3 h-100 opacity-50" data-bs-toggle="tooltip" title="<?php ee('Upgrade to unlock this feature') ?>">
                                    <div class="d-flex align-items-center">
                                        <div class="icon">
                                            <?php echo $widget['icon'] ?>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold text-muted"><?php echo $widget['title'] ?></h5>
                                            <p class="text-muted"><?php echo $widget['description'] ?></p>
                                        </div>
                                    </div>
                                </a>                                
                              <?php else: ?>
                                <a href="" class="d-block text-decoration-none border rounded p-3 h-100" data-trigger="insertcontent" data-type="<?php echo $name ?>">
                                    <div class="d-flex align-items-center">
                                        <div class="icon">
                                            <?php echo $widget['icon'] ?>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="fw-bold"><?php echo $widget['title'] ?></h5>
                                            <p class="text-muted"><?php echo $widget['description'] ?></p>
                                        </div>
                                    </div>
                                </a>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="removecard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to delete this?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete a block. Please changes only take effect when you update the bio page.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirmremove"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>