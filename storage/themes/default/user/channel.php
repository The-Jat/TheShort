<div class="d-flex mb-5">
    <div>
        <h1 class="h3 mb-2 fw-bold"><span class="badge me-2 px-2" style="background:<?php echo $channel->color ?>">&nbsp;</span><span class="align-middle"><?php echo $channel->name ?></span></h1>
        <p class="text-muted"><?php echo $channel->description ?></p>
    </div>
    <div class="ms-auto">
        <a class="btn btn-primary rounded-3 px-3 py-2 "" href="<?php echo route('channel.update', [$channel->id]) ?>" data-bs-toggle="modal" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo htmlentities(json_encode(['newname' => $channel->name, 'newdescription' => $channel->description, 'newcolor' => $channel->color, 'newstarred' => $channel->starred]), ENT_QUOTES) ?>'><?php ee('Edit') ?></span></a>
    </div>
</div>
<div class="card shadow-sm rounded-4 p-2 py-3">
    <div class="d-flex align-items-center">        
        <div>
			<span class="h3 ms-2"><?php echo $count ?></span> <span class="text-muted"> <?php ee('items') ?></span>			
		</div>             
    </div>
</div>

<div class="row">
    <?php foreach($items as $item): ?>
        <div class="col-md-12">
            <div class="card flex-fill rounded-4 shadow-sm mb-2">
                <div class="card-body">        
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <?php if($item['type'] == "bio"): ?>
                                <img src="<?php echo $item['icon'] ?>" class="avatar-lg rounded border p-2 m-0" alt="">                              
                            <?php elseif($item['type'] == "qr"): ?>
                                <img src="<?php echo $item['icon'] ?>" class="avatar-lg rounded border p-2 m-0" alt="">
                            <?php else: ?>
                                <img src="<?php echo $item['icon'] ?>" class="avatar-lg rounded border p-2 m-0" alt="">
                            <?php endif ?>
                        </div>
                        <div class="flex-grow-1">
                            <div class="float-end">
                                <button type="button" class="btn btn-default bg-white" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></button>                                
                                <ul class="dropdown-menu">
                                <?php if(user()->teamPermission($item['type'].'.edit')): ?>
                                    <li><a class="dropdown-item" href="<?php echo route($item['type'].'.edit', [$item['id']]) ?>"><i data-feather="edit"></i> <?php ee('Edit') ?></a></li>    
                                <?php endif ?>                                    
                                <?php if(isset($item['urlid']) && $item['urlid']): ?>
                                    <li><a class="dropdown-item" href="<?php echo route('stats', [$item['urlid']]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></a></li>
                                <?php endif ?>
                                <?php if(user()->teamPermission('bundles.edit')): ?>
                                    <li class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" href="<?php echo route('channel.removefrom', [$channel->id, $item['type'], $item['id']]) ?>"><i data-feather="trash"></i> <?php ee('Remove from channel') ?></a></li>
                                <?php endif ?>
                                </ul>
                            </div>
                            <?php if($item['preview']): ?>
                                <a href="<?php echo $item['preview'] ?>" target="_blank">
                                    <?php if($item['type'] == "bio"): ?>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Bio Pages') ?>"><i data-feather="layout"></i></span>
                                    <?php elseif($item['type'] == "qr"): ?>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('QR Codes') ?>"><i data-feather="aperture"></i></span>
                                    <?php else: ?>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php ee('Links') ?>"><i data-feather="link"></i></span>
                                    <?php endif ?>                                    
                                    <strong><?php echo $item['title'] ?: 'n\a' ?></strong>
                                </a>
                                <br>
                                <div class="mt-2">
                                    <span class="text-muted" data-href="<?php echo $item['link'] ?>"><?php echo $item['link'] ?></span>
                                    <a href="#copy" class="copy inline-copy" data-lang="<?php ee('Copied') ?>" data-clipboard-text="<?php echo $item['link'] ?>"><small><?php echo e("Copy")?></small></a>	
                                </div>
                            <?php else: ?>
                               <strong><?php echo $item['title'] ?: 'n\a' ?></strong><br><br>
                            <?php endif ?>   
                            <p class="mt-2 mb-0">                         
                                <small class="text-navy"><?php ee('Created on') ?> <?php echo $item['date'] ?></small>
                                <?php if(!is_null($item['views'])): ?>
                                    - 
                                    <small class="text-navy"><?php echo $item['views'] ?> <?php echo $item['type'] == 'qr' ? e('Scans') : e('Views') ?></small>
                                <?php endif ?>
                            </p>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<div class="mt-4 d-block">
    <?php echo pagination('pagination justify-content-center border rounded-4 p-3', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
</div> 

<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Are you sure you want to remove this item from this channel?') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to remove an item from a channel.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<?php if(user()->teamPermission('bundle.edit')): ?>
<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Update Channel') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label fw-bold"><?php ee("Name") ?> (<?php ee("required") ?>)</label>			
                    <input type="text" value="" name="newname" id="newname" class="form-control p-2">
                </div> 
                <div class="form-group mb-3">
                    <label class="form-label fw-bold"><?php ee("Description") ?></label>			
                    <input type="text" value="" name="newdescription" id="newdescription" class="form-control p-2">
                </div>   
                <div class="form-group mb-3">
                    <label class="form-label fw-bold d-block"><?php ee("Badge Color") ?></label>			
                    <input type="color" value="" name="newcolor" id="newcolor" class="form-control p-2" data-trigger="colorpicker">
                </div>
                <div class="d-flex">
                    <div>
                        <label class="form-check-label fw-bold" for="starred"><?php ee('Star Channel') ?></label>
                        <p class="form-text my-0"><?php ee('Starred channels will show up in the sidebar navigation for quick access.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto align-self-center">
                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="newstarred" name="newstarred" value="1">
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Update') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>