<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.links') ?>"><?php ee('Links') ?></a></li>
  </ol>
</nav>
<div class="d-flex mb-5 align-items-center">
    <h1 class="h3 fw-bold mb-0"><?php ee('Reported Links') ?></h1>
    <div class="ms-auto">
        <a href="#"  data-bs-toggle="modal" data-bs-target="#newModal" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><i data-feather="x-circle" class="me-2"></i> <span class="align-middle"><?php ee('Ban Links') ?></span></a>
    </div>    
</div>
<div class="card rounded-4 shadow-sm mb-2 p-2">
	<div class="d-flex align-items-center">
        <form method="post" action="" data-trigger="options">
            <?php echo csrf() ?>
            <input type="hidden" name="selected">		  
            <div class="btn-group">
                <span class="btn btn-white"><input class="form-check-input" type="checkbox" data-trigger="checkall"></span>
                <a class="btn btn-white" href="<?php echo route('admin.links.report.deleteall') ?>" data-trigger="submitchecked"><i data-feather="trash"></i> <span class="align-middle"><?php ee('Delete Selected') ?></span></a>
            </div>
        </form>
	</div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="card rounded-4 flex-fill shadow-sm">            
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th width="1%">
                                <input class="form-check-input me-2" type="checkbox" data-trigger="checkall">
                            </th>
                            <th><?php ee('Reported Link') ?></th>
                            <th><?php ee('Matched Long Link') ?></th>
                            <th><?php ee('Reason') ?></th>
                            <th><?php ee('Email') ?></th>
                            <th><?php ee('Status') ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reports as $report): ?>
                            <tr>
                                <td><input class="form-check-input me-2" type="checkbox" data-dynamic="1" value="<?php echo $report->id ?>"></td>
                                <td><a href="<?php echo $report->url ?>" target="_blank"><?php echo $report->url ?></a></td>
                                <td><?php echo $report->longurl ?></td>
                                <td><?php echo ucfirst($report->type) ?></td>
                                <td><?php echo $report->email ?></td>
                                <td>
                                    <?php if($report->status == "1"): ?>
                                        <span class="badge bg-danger"><?php ee('URL Banned') ?></span>
                                    <?php elseif($report->status == "2"): ?>
                                        <span class="badge bg-danger"><?php ee('Domain Banned') ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?php ee('Active') ?></span>
                                    <?php endif ?>
                                </td> 
                                <td>
                                    <button type="button" class="btn btn-default bg-transparent float-end" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">                    
                                        <li><a class="dropdown-item" href="<?php echo route('admin.links.report.action', [$report->id, 'banurl']) ?>"><i data-feather="x-circle"></i> <?php ee('Ban URL') ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo route('admin.links.report.action', [$report->id, 'bandomain']) ?>"><i data-feather="x-circle"></i> <?php ee('Ban Domain') ?></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('admin.links.report.action', [$report->id, 'delete']) ?>"><i data-feather="trash"></i> <?php ee('Delete') ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>    
            </div>
            <?php echo pagination('pagination') ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card rounded-4 shadow-sm">
            <div class="card-header bg-transparent">
                <div class="d-flex">
                    <h5 class="card-title mb-0 fw-bold"><?php ee('Domains') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p><?php ee('You can ban domains or links as soon as someone reports it. By banning the link, any other user who tries to shorten this link will be prevented.') ?></p>        

                <p><?php ee('If you ban the domain, any user who tries to shorten any link in that domain will not be allowed. Banned domains are added to the list in the') ?> <?php ee('Settings') ?> > <a href="<?php echo route("admin.settings.config", ['security']) ?>"><?php ee('Security Settings') ?></a>.</p>

                <p><?php ee('If you want to prevent users from using the same banned link then do not delete the report here.') ?></p>
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

<div class="modal fade" id="newModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo route('admin.links.report.add') ?>" method="post">
            <?php echo csrf() ?>
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Mass Ban Link Manually') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p><?php ee('You can use this tool to mass ban link. You have to option to ban short links, long links or both. You need to add one link per line.') ?></p>
                <div class="form-group mb-3">
                    <label for="short" class="form-label fw-bold"><?php ee('Short Link') ?></label>
                    <textarea class="form-control" name="short" id="short" placeholder="Enter one short link per line e.g. <?php echo url('somealias') ?>"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="long" class="form-label fw-bold"><?php ee('Long Link') ?></label>
                    <textarea class="form-control" name="long" id="long" placeholder="Enter one long link per line e.g. https://virusorscamlink.com"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Ban') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>