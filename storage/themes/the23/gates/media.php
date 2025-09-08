<section class="bg-primary py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-body border-0 shadow-sm">
                    <div class="embed">
                        <?php echo $url->embed ?>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-9">
                            <h6><?php echo $url->meta_title ?></h6>
                        </div>
                        <div class="col-sm-3 text-end">
                            <span><?php echo $url->click+1 ?></span>
                            <?php echo e("Views") ?>
                        </div>
                    </div>
                    <p class="mt-2">
                        <?php echo $url->meta_description ?>
                    </p>
                </div>
                <?php \Helpers\App::ads(728) ?>
            </div>
            <div class="col-md-4">
                <?php \Helpers\App::ads(300) ?>
                <div class="card card-body">
                    <h6><?php echo e("Short URL") ?></h6>
                    <input type="text" class="form-control" value="<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>" readonly>
                    <br>
                    <a href="#copy" class="btn btn-primary copy" data-clipboard-text="<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>"><?php echo e("Copy") ?></a>
                    <?php if(config("sharing")): ?>
                        <hr>
                        <p>
                            <a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>" class="btn btn-block btn-icon border rounded-circle" title="<?php echo e("Share on") ?> Facebook">
                                <img src="<?php echo assets('images/facebook.svg') ?>" alt="<?php echo e("Share on") ?> Facebook">
                            </a>
                            <a target="_blank" href="https://twitter.com/share?url=<?php echo \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom) ?>&amp;text=Check+out+this+url" class="btn btn-block btn-icon border rounded-circle" title="<?php echo e("Share on") ?> Twitter">
                                <img src="<?php echo assets('images/twitter.svg') ?>" alt="<?php echo e("Share on") ?> Twitter">
                            </a>
                        </p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>