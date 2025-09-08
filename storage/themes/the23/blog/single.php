<section id="blog" class="bg-primary border-top border-bottom">
	<div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-10 mb-5">
                <div class="pt-5 text-start">
                    <?php if($category): ?>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb px-0 breadcrumb-links">
                                <li class="breadcrumb-item"><a href="<?php echo route('home') ?>" class="text-dark"><?php ee('Home') ?></a></li>
                                <li class="breadcrumb-item"><a href="<?php echo route('blog') ?>" class="text-dark"><?php ee('Blog') ?></a></li>
                                <li class="breadcrumb-item"><a href="<?php echo route('blog.category', [$category->slug]) ?>" title="<?php echo $category->name ?>" class="active fw-bold"><?php echo $category->name ?></a></li>
                            </ol>
                        </nav>
                    <?php endif ?>
                    <h1 class="display-6 fw-bold mt-5">
                        <?php echo $post->title ?>
                    </h1>
                    <div class="mt-2 text-start">
                        <span><?php echo $post->date ?></span>
                    </div>
                    <div class="d-flex d-md-none justify-content-start align-items-center pt-4">
                        <img src="<?php echo $post->avatar ?>" alt="<?php echo $post->author ?>" class="avatar-sm rounded-circle me-3 border border-2 border-secondary">
                        <div class="mt-2 text-start">
                            <h6 class="d-block fw-bold mb-0"><?php echo $post->author ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 d-none d-md-block">
                <div class="d-flex justify-content-end align-items-center ">
                    <img src="<?php echo $post->avatar ?>" alt="<?php echo $post->author ?>" class="avatar-sm rounded-circle me-3 border border-2 border-secondary">
                    <div class="mt-2 text-start">
                        <h6 class="d-block fw-bold mb-0"><?php echo $post->author ?></h6>
                    </div>
                </div>
                <div class="text-end mt-4 text-muted">
                    <?php $count = \Core\Helper::readCount($post->content); echo ee('{c} mins read', null, ['c' =>  $count]) ?>
                </div>
            </div>
            <div class="col-md-10 mb-5">
                <div class="mb-5">
                    <article class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <?php if($post->image): ?>
                                <a href="<?php echo route('blog.post', $post->slug) ?>" class="d-block" title="<?php echo $post->title ?>">
                                    <img alt="<?php echo $post->title ?>" src="<?php echo uploads($post->image, 'blog') ?>" alt="<?php echo $post->title ?>" class="img-fluid rounded-4 mb-5 w-100">
                                </a>
                            <?php endif ?>
                            <?php echo $post->content ?>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <?php if($posts): ?>
        <div class="py-5">
            <?php \Helpers\App::ads('resp') ?>
            <div class="row align-items-center mb-5">
                <div class="col-12 col-md">
                    <h3 class="h4 mb-0"><?php ee('Keep reading') ?></h3>
                    <p class="mb-0 text-muted"><?php ee('More posts from our blog') ?></p>
                </div>
                <div class="col-12 col-md-auto">
                    <a href="<?php echo route('blog') ?>" class="btn btn-sm btn-dark d-none d-md-inline"><?php ee("View all") ?></a>
                </div>
            </div>
            <div class="row">
                <?php foreach($posts as $post): ?>
                    <div class="col-md-4">
                        <?php $post->content = \Core\Helper::truncate($post->content, 150); view('blog.partial',['post' => $post]); ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <?php endif ?>
    </div>
</section>