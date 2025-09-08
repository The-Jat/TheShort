<section>
    <div class="container py-10">    
        <div class="text-start mb-3">
            <h1 class="fw-bold mb-3"><?php ee('Verify Short Link') ?></h1>
            <p ><?php ee("Check the short link's source to make sure the destination is safe before you click on it.") ?></p>            
        </div>        
        <div class="card card-body shadow-sm rounded-4">
            <?php message() ?>
            <form class="mt-2" method="post" action="<?php echo route('links.verify') ?>"> 
                <?php echo csrf() ?> 
                <div class="position-relative">
                    <input type="text" class="form-control p-3" placeholder="<?php echo e("Paste url") ?>" name="url" id="url">
                    <button class="btn btn-success btn-xs mt-2 mr-2 me-2 position-absolute right-0 end-0 top-0" type="submit"><?php ee('Verify') ?></button>
                </div>
                <?php if(!\Core\Auth::logged()) { echo \Helpers\Captcha::display('shorten'); } ?>
            </form>
        </div>
    </div>
</section>