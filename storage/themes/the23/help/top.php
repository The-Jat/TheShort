<div class="py-10">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h2 class="text-center fw-bolder"><?php ee('How can we help you?') ?></h2>
            <form action="<?php echo route('help.search') ?>" class="card rounded-pill mb-0 px-2 py-2 mt-5 shadow-sm border-0">
                <div class="input-group p-2 d-flex align-items-center">
                    <span class="mx-2">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-0" name="q" value="<?php echo $q ?? '' ?>" aria-label="Find something" placeholder="<?php ee('Search') ?>...">
                    <span>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><?php ee('Search') ?></button>
                    </span>
                </div>
            </form>
        </div>
    </div>    
</div>