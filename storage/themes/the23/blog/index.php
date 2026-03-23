<section id="blog" class="bg-primary border-top border-bottom">
	<div class="container">
		<div class="py-8 text-center">
            <h2 class="display-6 fw-bold">
                <?php ee('Blog') ?>
            </h2>
        </div>
        <?php view('blog.menu', compact('menu')) ?>
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
                        <?php echo pagination('pagination justify-content-center bg-white shadow-sm p-3 rounded', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
                    </div>
                    <div class="col-md-4">
                        <?php \Helpers\App::ads('blogsidebar') ?>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bolder mb-3"><?php ee('Popular Posts') ?></h5>
                                <?php foreach($popular as $post): ?>
                                    <a href="<?php echo route('blog.post', [$post->slug]) ?>" class="mb-4 d-flex align-items-center relative" title="<?php echo $post->title ?>">
                                        <?php if($post->image): ?>
                                            <img src="<?php echo uploads($post->image, 'blog') ?>" class="img-fluid rounded w-25 me-3" alt="<?php echo $post->title ?>">
                                        <?php else: ?>
                                            <div class="relative w-25 py-3 bg-dark rounded flex-grow d-flex align-items-center justify-content-center me-3">
                                                <i class="fa fa-file-alt text-white fs-4"></i>
                                            </div>
                                        <?php endif ?>
                                        <div>
                                            <h6 class="fw-bold mb-0 d-block"><?php echo $post->title ?></h6>
                                            <span class="text-muted small"><?php echo \Core\Helper::timeAgo($post->date) ?></span>
                                        </div>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <?php plug('blogsidebar') ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>