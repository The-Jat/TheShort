<h1 class="h3 mb-5 fw-bold"><?php ee('Edit Member') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('team.update', [$team->id]) ?>">
            <?php echo csrf() ?>
            <div class="form-group mb-3">
                <label for="email" class="label-control mb-2 fw-bold"><?php echo e("Email") ?></label>
                <input type="email" class="form-control p-2" value="<?php echo $team->user->email ?>" disabled>				
            </div>	
            <div class="form-group input-select mb-3">
                <label for="permissions" class="label-control mb-2 fw-bold"><?php echo e("Permissions") ?></label>
                <select name="permissions[]" class="form-control" placeholder="<?php echo e("Permissions") ?>" data-placeholder="<?php echo e("Permissions") ?>" multiple data-toggle="select">	
                    <?php foreach($list as $type => $item): ?>
                        <?php if (!user()->has("qr")) continue; ?>
                        <optgroup label="<?php echo $item['name'] ?>">    
                            <?php foreach($item['permissions'] as $key => $name): ?>
                                <option value="<?php echo $type ?>.<?php echo $key ?>" <?php echo in_array("{$type}.{$key}", $team->permission) ? 'selected': '' ?>><?php echo $name ?></option>
                            <?php endforeach ?>
                        </optgroup>
                    <?php endforeach ?>                     					    						    						    					    							    		
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Update') ?></button>
        </form>
    </div>
</div>