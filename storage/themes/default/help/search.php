<?php view('help.top') ?>
<section class="slice slice-lg bg-section-secondary" id="sct-faq">
    <div class="container">            
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb px-0 breadcrumb-links">
                <li class="breadcrumb-item"><a href="<?php echo route('home') ?>"><?php ee('Home') ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo route('help') ?>"><?php ee('Help Center') ?></a></li>
            </ol>
        </nav>        
        <div class="mb-5 justify-content-center text-left">
            <h2 class="mt-4"><?php echo ee('Search for "{q}"', null, ['q' => $q]) ?></h2>
        </div>                    
        <?php if($articles): ?>
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
            <?php echo pagination() ?>
        <?php else: ?>
            <?php ee('No results') ?>
        <?php endif ?>
    </div>
</section>