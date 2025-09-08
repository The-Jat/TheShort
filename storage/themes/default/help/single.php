<?php view('help.top') ?>
<section class="bg-section-secondary py-5">
    <div class="container pt-5 pt-lg-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb px-0 breadcrumb-links">
                <li class="breadcrumb-item"><a href="<?php echo route('home') ?>"><?php ee('Home') ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo route('help') ?>"><?php ee('Help Center') ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo route('help.category', [$article->category]) ?>"><?php ee($category->title) ?></a></li>
            </ol>
        </nav>
        <h2 class="mb-5"><?php echo $article->question ?></h2>
    </div>
    <div class="pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body">
                            <article>
                                <?php echo $article->answer ?>
                            </article>
                        </div>
                    </div>
                    <?php if(config('contact')): ?>
                        <h6 class="mb-4"><?php ee('Did not answer your question?') ?> </h6>
                        <a href="<?php echo route('contact') ?>" class="btn btn-sm btn-warning"><?php ee('Contact us') ?></a>
                    <?php endif ?>
                </div>
                <div class="col-md-4">
                    <h6><?php ee('Related Questions') ?></h6>
                    <?php foreach($related as $article): ?>
                        <a href="<?php echo route('help.single', [$article->slug]) ?>" class="mb-2 d-block"><?php echo $article->question ?></a>
                    <?php endforeach ?>

                    <?php \Helpers\App::ads('helpsidebar') ?>
                </div>
            </div>
        </div>
    </div>
</section>