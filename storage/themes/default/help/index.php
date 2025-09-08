<?php view('help.top') ?>
<section class="slice slice-lg bg-section-secondary" id="sct-faq">
    <div class="container">
        <div class="mb-5 mt-3 text-left">
            <h2><?php ee('Browse Topics') ?></h2>
        </div>
        <div class="row row-grid">
            <?php foreach($categories as $id => $category): ?>
                <div class="col-md-6 mb-4">
                    <div class="card card-body shadow-sm flex-fill h-100 pb-0 shadow-sm">
                        <a href="<?php echo route('help.category', [$id]) ?>">
                            <div class="media">
                                <?php if(isset($category->icon) && $category->icon): ?>
                                    <?php if(isset($category->iconstyle) && $category->iconstyle == 'emoji'): ?>                                    
                                        <div class="media-left mr-4 pt-3 pl-2 text-center">
                                            <span class="display-4"><?php echo $category->icon ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="media-left mr-4 pt-3 pl-2 text-center">
                                            <i class="display-4 <?php echo \Helpers\App::isDark() ? 'text-white' : 'text-dark' ?> <?php echo $category->icon ?>"></i>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                                <div class="media-body">
                                    <h4>
                                        <span><?php ee($category->title) ?></span>
                                    </h4>
                                    <p class="<?php echo \Helpers\App::isDark() ? 'text-white' : 'text-dark' ?>"><?php ee($category->description) ?></p>
                                    <small class="text-muted"><?php echo $category->count ?> <?php ee('articles') ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <div class="my-5 text-left">
            <h2><?php ee('Common Questions') ?></h2>
        </div>
        <div class="row">
            <?php foreach($articles as $article): ?>
                <div class="col-md-6 mb-4">
                    <div class="card card-body shadow-sm flex-fill h-100 pb-0 shadow-sm">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <a href="<?php echo route('help.single', $article->slug) ?>" class="h6 stretched-link mb-0"><?php echo $article->question ?></a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <?php echo \Core\Helper::truncate(strip_tags($article->answer), 100) ?>
                        </div>
                        <small><?php ee('Updated {t}', null, ['t' => \Core\Helper::timeago($article->created_at)]) ?></small>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>