<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Plugins') ?></li>
  </ol>
</nav>

<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 mb-0 fw-bold"><?php ee('Plugins') ?></h1>
    <div class="ms-auto">
        <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#uploadModal" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Upload Plugin') ?></a>
        <a href="<?php echo route('admin.plugins.dir') ?>" class="btn btn-dark rounded-3 px-3 py-2"><?php ee('Marketplace') ?></a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
      <form action="<?php echo route('admin.plugins.dir') ?>" method="get" class="card rounded-4 card-body shadow-sm">
          <h6 class="fw-bold"><?php ee('Search for Plugins') ?></h6>
          <div class="d-flex mt-3">
            <div class="input-group border rounded-pill">
                <input type="text" class="form-control p-3 border-0 rounded-pill" name="q" value="<?php echo request()->q ?>" placeholder="Search for plugins" aria-label="Search">
                <button class="btn" type="submit">
                  <i class="align-middle" data-feather="search"></i>
                </button>
            </div>
          </div>
      </form>
    </div>
    <div class="col-md-12">        
        <div class="card rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Name') ?></th>
                            <th><?php ee('Author') ?></th>
                            <th><?php ee('Description') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>             
                        <?php foreach($plugins as $plugin): ?>
                            <tr>
                                <td>
                                    <?php echo $plugin->name ?> (v<?php echo $plugin->version ?>)
                                    <?php if($plugin->enabled): ?>
                                        <span class="badge bg-success text-white"><?php ee('Active') ?></span>
                                    <?php endif ?>
                                    <?php if($plugin->update): ?>
                                      <span class="badge bg-primary text-white"><?php ee('Update Available') ?></span><a class="d-block mt-2 fw-bold" data-load href="<?php echo route('admin.plugins.dir', ['install' => $plugin->id]) ?>"><?php ee('Update to {x}', null, ['x' => $plugin->update]) ?></a>
                                    <?php endif ?>
                                </td>
                                <td><a href="<?php echo $plugin->link ?>" target="_blank"><?php echo $plugin->author ?></a></td>
                                <td><?php echo $plugin->description ?></td>
                                <td>
                                    <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <?php if($plugin->enabled): ?>
                                            <li><a class="dropdown-item" href="<?php echo route('admin.plugins.disable', [$plugin->id]) ?>"><i data-feather="x-circle"></i> <?php ee('Disable') ?></a></li>
                                        <?php else: ?>
                                            <li><a class="dropdown-item" href="<?php echo route('admin.plugins.activate', [$plugin->id]) ?>"><i data-feather="check-circle"></i> <?php ee('Activate') ?></a></li>
                                        <?php endif ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.plugins.delete', [$plugin->id, \Core\Helper::nonce('plugin.delete')]) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>                                
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
<div class="modal fade" id="infoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Learn how to create a plugin') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('To learn more about plugins or to learn how to create your own plugin, please check our plugin documentation.') ?></p>
        <a href="https://gempixel.com/docs/premium-url-shortener/plugins" target="_blank" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm">Plugin Documentation</a>
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
<div class="modal fade" id="uploadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo route('admin.plugins.upload') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Upload or Update Plugin') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="file" class="form-label fw-bold"><?php ee('Plugin File') ?></label>
                    <input type="file" class="form-control" name="file" id="file" value="" accept=".zip" placeholder="e.g. PLUGINNAME.zip">
                    <p class="form-text"><?php ee('Upload the zip file that comes in the package. Usually it is named PLUGINNAME.zip. Please make sure the plugin respects the file structure.') ?></p>
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