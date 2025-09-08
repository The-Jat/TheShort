<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo route('admin') ?>"><?php ee('Dashboard') ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo route('admin.email.template') ?>"><?php ee('Email Templates') ?></a></li>
  </ol>
</nav>

<h1 class="h3 mb-5 fw-bold"><?php ee('Create Email Translation') ?></h1>

<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" id="language" action="<?php echo route('admin.email.template.save') ?>">
            <input type="hidden" name="encoded">
            <?php echo csrf() ?>              
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="name" class="form-label fw-bold"><?php ee('Name') ?></label>
                        <input type="text" class="form-control p-2" name="name" id="name" value="<?php echo old('name') ?>" placeholder="E.g. French">
                        <p class="form-text"><?php ee('The name of the language you are translating.') ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="code" class="form-label fw-bold"><?php ee('Code') ?></label>
                        <input type="text" class="form-control p-2" name="code" id="code" value="<?php echo old('code') ?>" placeholder="E.g. fr">
                        <p class="form-text"><?php ee('If you leave this empty, we will use the first two letters of the name.') ?></p>
                    </div>
                </div>
            </div>                        
            <div class="blocks">
                <?php $i = 0; foreach($strings as $base => $string): ?>
                    <div class="p-3 rounded border mb-3">
                        <div class="form-group position-relative">
                            <h4 class="mb-3"><?php echo ucfirst($base) ?></h4>
                            <textarea class="form-control p-2" data-new name="string[<?php echo ($base) ?>]" rows="16" id="email-<?php echo ($base) ?>"><?php echo $string ?></textarea>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>                      
            <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Create') ?></button>
        </form>
    </div>
</div>