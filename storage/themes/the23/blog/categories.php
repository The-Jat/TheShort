<section id="blog" class="bg-primary border-top border-bottom">
	<div class="container">
		<div class="py-10 text-center">
            <p class="font-weight-700 mb-2"><?php ee('Blog') ?></p>
            <h1 class="display-4 mb-2"><?php echo $current->name ?></h1>                    
            <?php if($current->description): ?>
                <p class="lead mb-2"><?php echo $current->description ?></p>
            <?php endif ?>
        </div>
        <?php view('blog.menu', compact('menu', 'current')) ?>
        <div class="py-5">
            <div class="row">
                <?php if(themeSettings::config('blog') == 'grid'): ?>
                    <div class="col-md-12 mb-5">
                        <div class="row">
                        <?php foreach($posts as $post): ?>
                            <div class="col-sm-4">
                                <?php view('blog.partial', compact('post', 'categories')); ?>
                            </div>
                        <?php endforeach ?>                        
                        </div>
                        <?php echo pagination('pagination bg-white rounded p-2 shadow-sm', 'page-item', 'page-link') ?>
                    </div>
                <?php else: ?>
                    <div class="col-md-8 mb-5">
                        <?php foreach($posts as $post): ?>
                            <?php view('blog.partial', compact('post', 'categories')); ?>
                        <?php endforeach ?>
                        <?php echo pagination('pagination bg-white rounded p-2 shadow-sm', 'page-item', 'page-link') ?>
                    </div>
                    <div class="col-md-4">
                        <?php \Helpers\App::ads('blogsidebar') ?>
                        <h5 class="fw-bolder mb-3"><?php ee('Popular Posts') ?></h5>
                        <?php foreach($popular as $post): ?>
                            <a href="<?php echo route('blog.post', [$post->slug]) ?>" class="mb-2 d-block" title="<?php echo $post->title ?>"><?php echo $post->title ?></a>
                        <?php endforeach ?>
                        <?php plug('blogsidebar') ?>
                    </div>                        
                <?php endif ?>
            </div>
        </div>
    </div>
</section>