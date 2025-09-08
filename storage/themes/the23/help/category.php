<section class="bg-primary pb-5 border-top border-bottom" id="help">    
    <div class="container">
        <?php view('help.top') ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb px-0 breadcrumb-links">
                <li class="breadcrumb-item"><a href="<?php echo route('home') ?>"><?php ee('Home') ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo route('help') ?>"><?php ee('Help Center') ?></a></li>
            </ol>
        </nav>
        <div class="mb-4 d-flex align-items-center">
            <?php if(isset($category->icon) && $category->icon): ?>
                <div class="me-4 text-center">
                    <?php if(isset($category->iconstyle) && $category->iconstyle == 'emoji'): ?>
                        <span class="display-4"><?php echo $category->icon ?></span>
                    <?php else: ?>
                        <i class="display-4 gradient-primary clip-text <?php echo $category->icon ?>"></i>
                    <?php endif ?>
                </div>
            <?php endif ?>
            <div>
                <h2 class="fw-bold"><?php echo $category->title ?></h2>
                <div class="mt-2">
                    <p class="lead lh-180"><?php echo $category->description ?></p>
                </div>
            </div>
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
        <?php echo pagination('pagination bg-white rounded p-2 shadow-sm', 'page-item', 'page-link') ?>
    </div>
</section>