<?php view('help.top') ?>
<section class="slice slice-lg bg-section-secondary" id="sct-faq">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb px-0 breadcrumb-links">
                <li class="breadcrumb-item"><a href="<?php echo route('home') ?>"><?php ee('Home') ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo route('help') ?>"><?php ee('Help Center') ?></a></li>
            </ol>
        </nav>
        <div class="my-5 media text-left">
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
                <h2><?php ee($category->title) ?></h2>
                <div class="mt-2">
                    <p class="lead lh-180"><?php ee($category->description) ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach($articles as $article): ?>
                <div class="col-md-6 mb-4">
                    <div class="card card-body shadow-sm flex-sm-fill h-100 pb-0 shadow-sm">
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
        <?php echo pagination() ?>
    </div>
</section>