<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><?php ee('Tools') ?></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('Removal Tools') ?></h1>

<div class="row">
    <div class="col-md-6">                
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Remove Anonymous Links') ?></h5>
                <p><?php ee('This tool deletes all URLs (and their associated stats) shortened by anonymous users (non-registered). If you are experiencing slow response, this is recommended. You can also choose a date to remove all anon links before.') ?></p>                

                <form action="<?php echo route('admin.toolsAction', ['flushurls', \Core\Helper::nonce('tools')]) ?>" method="get">
                    <div class="form-group mb-3">
                        <label for="date" class="form-label fw-bold"><?php ee('Remove Links Before') ?></label>
                        <input type="text" data-toggle ="datepicker" class="form-control p-2" id="date" name="date" placeholder="Leave empty to remove all urls" autocomplete="off">
                    </div>
                    <div class="form-group mb-2">
                        <label for="date" class="form-label fw-bold"><?php ee('Type <i><b>DELETE</b></i> below to confirm') ?></label>
                        <input type="text" class="form-control p-2" id="confirm" name="confirm" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm"><?php ee('Remove links') ?></button>
                </form>
            </div>
        </div>      
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold"><?php ee('Delete Inactive links') ?></h5>
                <p><?php ee('This tool deletes links that did not receive any clicks in the last 30 days. It can free up some resource in your database.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['deleteurls', \Core\Helper::nonce('tools')]) ?>" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" ><?php ee('Delete') ?></a>
            </div>
        </div>    
    </div> 
    <div class="col-md-6">   
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Cleanup Tools') ?></h5>
                <p><?php ee('This tool will cleanup your site. You can choose what to clean up below.') ?></p>
                <form action="<?php echo route('admin.toolsAction', ['cleanup', \Core\Helper::nonce('tools')]) ?>" method="get">
                    <label class="form-check form-check-inline d-block mb-2">
                        <input class="form-check-input" type="checkbox" value="1" name="users">
                        <span class="form-check-label"><?php ee('Users with no links (accounts more than 30 days)') ?></span>
                    </label>
                    <?php if(\Helpers\App::possible()): ?>
                    <label class="form-check form-check-inline d-block mb-2">
                        <input class="form-check-input" type="checkbox" value="1" name="subscription">
                        <span class="form-check-label"><?php ee('Pending Subscriptions') ?></span>
                    </label>
                    <?php endif ?>
                    <label class="form-check form-check-inline d-block mb-2">
                        <input class="form-check-input" type="checkbox" value="1" name="payments">
                        <span class="form-check-label"><?php ee('Pending Payments') ?></span>
                    </label>
                    <label class="form-check form-check-inline d-block mb-3">
                        <input class="form-check-input" type="checkbox" value="1" name="stats">
                        <span class="form-check-label"><?php ee('Anonymous links stats and reset links') ?></span>
                    </label>
                    <div class="form-group mb-2">
                        <label for="date" class="form-label fw-bold"><?php ee('Type <i><b>DELETE</b></i> below to confirm') ?></label>
                        <input type="text" class="form-control p-2" id="confirm" name="confirm" autocomplete="off">
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-danger px-5 py-2 rounded-3 shadow-sm"><?php ee('Cleanup') ?></button>
                    </div>
                </form>
            </div>
        </div>                 
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Delete Inactive Users') ?></h5>
                <p><?php ee('This tool deletes users who registered but did not activate their account. This can be users attempting to use fake emails or even spammers.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['deleteusers', \Core\Helper::nonce('tools')]) ?>" class="btn btn-danger px-5 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal" ><?php ee('Delete') ?></a>
            </div>
        </div>
    </div>  
</div>  

<h1 class="h3 my-4 fw-bold"><?php ee('Export Tools') ?></h1>

<div class="row">   
    <div class="col-md-6">    
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Export Links') ?></h5>
                <p><?php ee('This tool allows you to generate a list of urls in CSV format. Some basic data such clicks will be included as well.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['exporturls', \Core\Helper::nonce('tools')]) ?>" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Export') ?></a>
            </div>
        </div>      
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Export Users') ?></h5>
                <p><?php ee('This tool allows you to generate a list of users in CSV format. You can then import that in the email marketing tools.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['exportusers', \Core\Helper::nonce('tools')]) ?>" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Export') ?></a>
            </div>
        </div>      
    </div>
    <div class="col-md-6">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Export Payments') ?></h5>
                <p><?php ee('This tool allows you to generate a list of payments in CSV format. You can then import that in your accounting tools.') ?></p>
                <a href="<?php echo route('admin.toolsAction', ['exportpayments', \Core\Helper::nonce('tools')]) ?>" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Export') ?></a>
            </div>
        </div>
    </div> 
</div>
<h1 class="h3 my-4 fw-bold"><?php ee('Optimization Tools') ?></h1>    
<div class="row">
    <div class="col-md-12">            
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Optimize Database') ?></h5> 
                <p><?php ee('This tool will run an OPTIMIZE query for each table and removes overheads thereby reducing storage and improving I/O queries.') ?></p>   
                <a href="<?php echo route('admin.toolsAction', ['optimize', \Core\Helper::nonce('tools')]) ?>" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Optimize') ?></a>
            </div>
        </div> 
        
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Optimize Indexes') ?></h5>
                <p><?php ee('This tool will add indexes to optimize database queries. This is very helpful when receiving a lot of traffic. You can review each indexes below and if they are not added, you can choose to add them automatically.') ?></p>                
                
                <h5><?php ee('URL Table') ?></h5>
                <p>
                    <?php if($optimized->url == false): ?>
                        <a href="<?php echo route('admin.toolsAction', ['addindex', \Core\Helper::nonce('tools')]) ?>?table=url" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm mt-3"><?php ee('Optimize Indexes') ?></a>
                    <?php else: ?>
                        <i data-feather="check" class="text-primary"></i> <strong><i><?php ee('Optimized') ?></i></strong>
                    <?php endif ?>
                </p>  

                <h5><?php ee('Stats Table') ?></h5>
                <p>
                    <?php if($optimized->stats == false): ?>
                        <a href="<?php echo route('admin.toolsAction', ['addindex', \Core\Helper::nonce('tools')]) ?>?table=stats" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm mt-3"><?php ee('Optimize Indexes') ?></a>
                    <?php else: ?>
                        <i data-feather="check" class="text-primary"></i> <strong><i><?php ee('Optimized') ?></i></strong>
                    <?php endif ?>
                </p>
            </div>
        </div>
    </div>   
</div>
<h1 class="h3 my-4 fw-bold"><?php ee('System Tools') ?></h1>    
<div class="row">
    <div class="col-md-6">            
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Clear Cache') ?></h5> 
                <p><?php ee('This tool will clear system cache stored on the server. You can use this tool if the cache directory at storage/cache/ is getting big.') ?></p>   
                <a href="<?php echo route('admin.toolsAction', ['clearcache', \Core\Helper::nonce('tools')]) ?>" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Clear Cache') ?></a>
            </div>
        </div>             
    </div> 
    <div class="col-md-6">            
        <div class="card rounded-4 shadow-sm">
            <div class="card-body"> 
                <h5 class="card-title fw-bold"><?php ee('Robots.txt Generator') ?></h5> 
                <p><?php ee('This tool will allow you to generate a robots.txt directly from the admin panel.') ?></p>   
                <a href="" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#robotsModal"><?php ee('Generate') ?></a>
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
<div class="modal fade" id="robotsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Robots.txt Generator') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo route('admin.toolsAction', ['robots', \Core\Helper::nonce('tools')]) ?>" method="get">
            <div class="form-group mb-3">
                <label for="content" class="form-label fw-bold"><?php ee('Content') ?></label>
                <textarea class="form-control p-2" id="content" name="content" placeholder="" autocomplete="off" rows="5"><?php echo (file_exists(PUB.'/robots.txt') ? file_get_contents(PUB.'/robots.txt') : '') ?></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm"><?php ee('Save') ?></button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>