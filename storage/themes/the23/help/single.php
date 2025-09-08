<section class="bg-primary pb-5 border-top border-bottom" id="help">    
    <div class="container">
        <?php view('help.top') ?>
        <div class="row">
            <div class="col-md-8 mb-5">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb px-0 breadcrumb-links mb-0">
                        <li class="breadcrumb-item"><a href="<?php echo route('home') ?>"><?php ee('Home') ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo route('help') ?>"><?php ee('Help Center') ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo route('help.category', $article->category) ?>"><?php echo $category->title ?></a></li>
                    </ol>
                </nav>
                <div class="card border-0 shadow-sm"> 
                    <div class="card-body py-4 px-md-4">
                        <h2 class="mt-4"><?php echo $article->question ?></h2>
                        <small class="text-muted"><i class="fa fa-clock me-1"></i> <?php _ee('Last updated on {d}', ['d' => \Core\Helper::dtime($article->created_at, 'F d, Y')]) ?></small>
                        <article class="mt-5">
                            <?php echo $article->answer ?>
                        </article>
                    </div>
                    <?php if(config('contact')): ?>                        
                        <div class="text-center mt-5 mb-3">
                            <h6><?php ee('Did not answer your question?') ?> </h6>
                            <a href="<?php echo route('contact') ?>" class="btn btn-sm btn-primary"><?php ee('Contact us') ?></a>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-4">
                <h6 class="mb-3 fw-bold"><?php ee('Related Questions') ?></h6>
                <?php foreach($related as $article): ?>
                    <a href="<?php echo route('help.single', [$article->slug]) ?>" class="mb-2 d-block"><?php echo $article->question ?></a>
                <?php endforeach ?>

                <?php \Helpers\App::ads('helpsidebar') ?>
            </div>
        </div>
    </div>
</section>