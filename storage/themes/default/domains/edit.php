<h1 class="h3 mb-5 fw-bold"><?php ee('Edit Domain') ?></h1>
<div class="card rounded-4 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?php echo route('domain.update', [$domain->id]) ?>" enctype="multipart/form-data">
            <?php echo csrf() ?>
            <div class="form-group mb-4">
                <label for="domain" class="form-label"><?php ee('Domain') ?></label>
                <input type="text" class="form-control p-2" disabled value="<?php echo $domain->domain ?>" placeholder="https://domain.com">
            </div>
            <?php if(user()->has('bio')): ?>
                <input type="hidden" name="type" value="<?php echo ($domain->bioid ? 'bio' : 'redirect') ?>">
                <div class="mb-3">
                    <a class="btn border <?php echo (!$domain->bioid ? 'border-primary' : '') ?>  p-2 fw-bold rounded-3 mb-2 me-1" data-trigger="switcher" href="#redirect"><i class="me-2" data-feather="globe"></i><?php ee('Custom Redirect') ?></a>
                    <a class="btn border <?php echo ($domain->bioid ? 'border-primary' : '') ?> p-2 fw-bold rounded-3 mb-2 me-1" data-trigger="switcher" href="#bio"><i class="me-2" data-feather="layout"></i> <?php ee('Bio Page') ?></a>                            
                </div>
                <div class="collapse switcher <?php echo (!$domain->bioid ? 'show' : '') ?>" id="redirect">
                    <div class="form-group mb-4">
                        <label for="rootdomain" class="form-label"><?php ee('Domain Root') ?></label>
                        <input type="text" class="form-control p-2" name="root" id="rootdomain" value="<?php echo $domain->redirect ?>" placeholder="https://mycompany.com">
                        <div class="form-text"><?php ee('Redirects to this page if someone visits the root domain above without a short alias.') ?></div>
                    </div>                            
                </div>
                <div class="collapse switcher <?php echo ($domain->bioid ? 'show' : '') ?>" id="bio">
                    <div class="form-group mb-4">
                        <label for="biopage" class="form-label fw-bold"><?php ee('Bio Page') ?></label>
                        <div class="input-select rounded">
                            <select name="biopage" id="biopage" class="form-select" data-toggle="select">
                                <?php foreach($bios as $bio): ?>
                                    <option value="<?php echo $bio->id ?>" <?php echo $domain->bioid == $bio->id ? 'selected' : '' ?>><?php echo $bio->name ?></option>
                                <?php endforeach ?>
                            </select>                                        
                        </div>
                        <div class="form-text"><?php ee('Assign a Bio Page to be accessed from your root domain.') ?></div>
                    </div> 
                </div> 
            <?php else: ?>
                <div class="form-group mb-4">
                    <label for="rootdomain" class="form-label"><?php ee('Domain Root') ?></label>
                    <input type="text" class="form-control p-2" name="root" id="rootdomain" value="<?php echo $domain->redirect ?>" placeholder="https://mycompany.com">
                    <div class="form-text"><?php ee('Redirects to this page if someone visits the root domain above without a short alias.') ?></div>
                </div>                           
            <?php endif ?>            
            <div class="form-group mb-4">
                <label for="root404" class="form-label"><?php ee('Domain 404') ?></label>
                <input type="text" class="form-control p-2" name="root404" id="root404" value="<?php echo $domain->redirect404 ?>" placeholder="https://mycompany.com/404">
                <div class="form-text"><?php ee('Redirects to this page if a short url is not found (error 404).') ?></div>
            </div>

            <button type="submit" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Update Domain') ?></button>
        </form>
    </div>
</div>