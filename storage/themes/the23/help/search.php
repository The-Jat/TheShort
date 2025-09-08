<section class="bg-primary pb-5 border-top border-bottom" id="help">    
    <div class="container">
        <?php view('help.top', ['q' => $q]) ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb px-0 breadcrumb-links">
                <li class="breadcrumb-item"><a href="<?php echo route('home') ?>"><?php ee('Home') ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo route('help') ?>"><?php ee('Help Center') ?></a></li>
            </ol>
        </nav>
        <div class="mb-5 justify-content-center">
            <h2 class="mt-4"><?php echo ee('Search Results for "{q}"', null, ['q' => "<strong>{$q}</strong>"]) ?></h2>
        </div>          
        <?php if($articles): ?>
            <div class="row">
                <?php foreach($articles as $article): ?>
                    <div class="col-md-6 mb-4">
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
            <?php echo pagination('pagination bg-white rounded p-2 shadow-sm', 'page-item', 'page-link') ?>
        <?php else: ?>
            <?php ee('No results') ?>
        <?php endif ?>
    </div>
</section>