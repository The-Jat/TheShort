<section class="bg-primary pb-5 border-top border-bottom" id="help">    
    <div class="container">
        <?php view('help.top') ?>
        <div class="mt-3 text-start">
            <h2 class="fw-bold"><?php ee('Browse Topics') ?></h2>
        </div>
        <div class="row row-grid py-5">
            <?php foreach($categories as $slug => $category): ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card card-body flex-fill h-100 p-4 border-0 shadow-sm">
                        <a href="<?php echo route('help.category', [$slug]) ?>">
                            <div class="text-center">
                                <?php if(isset($category->icon) && $category->icon): ?>
                                    <?php if(isset($category->iconstyle) && $category->iconstyle == 'emoji'): ?>
                                        <span class="display-4"><?php echo $category->icon ?></span>
                                    <?php else: ?>
                                        <i class="display-4 gradient-primary clip-text <?php echo $category->icon ?>"></i>
                                    <?php endif ?>
                                <?php endif ?>
                                <div class="mt-2">
                                    <h4>
                                        <span><?php echo $category->title ?></span>
                                    </h4>
                                    <p class="text-dark"><?php echo $category->description ?></p>
                                    <small class="text-muted"><?php echo $category->count ?> <?php ee('articles') ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <div class="my-5 text-start">
            <h2 class="fw-bold"><?php ee('Common Questions') ?></h2>
        </div>
        <div class="row">
            <?php foreach($articles as $article): ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card card-body flex-fill h-100 p-4 border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div>
                                <a href="<?php echo route('help.single', $article->slug) ?>" class="h6 stretched-link mb-0"><?php echo $article->question ?></a>
                            </div>
                        </div>
                        <div class="my-2">
                            <?php echo \Core\Helper::truncate(strip_tags($article->answer), 100) ?>
                        </div>
                        <small class="text-muted"><?php ee('Updated {t}', null, ['t' => \Core\Helper::timeago($article->created_at)]) ?></small>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>