<section id="blog" class="bg-primary border-top border-bottom">
	<div class="container">
        <div class="row">
            <div class="col-md-10 mb-5">
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
                    <div class="d-flex align-items-center ">
                        <img src="<?php echo $post->avatar ?>" alt="<?php echo $post->author ?>" class="avatar-xs rounded-circle me-3 border border-2 border-secondary">
                        <div class="text-start">
                            <h6 class="d-block fw-bold mb-0"><?php if(!empty($authorIdentifier)): ?><a href="<?php echo route('blog.author', [strtolower($authorIdentifier)]) ?>" class="text-dark text-decoration-none"><?php echo htmlspecialchars($post->author) ?></a><?php else: ?><?php echo htmlspecialchars($post->author) ?><?php endif ?></h6>
                        </div>
                        <div class="text-muted">
                            <span class="text-muted mx-2">&bull;</span>
                            <?php echo $post->date ?>
                        </div>                        
                        <div class="text-muted">
                            <span class="text-muted mx-2">&bull;</span>
                            <?php $count = \Core\Helper::readCount($post->content); echo ee('{c} mins read', null, ['c' =>  $count]) ?>
                        </div>
                    </div>
                    <div class="d-flex d-md-none justify-content-start align-items-center pt-4">
                        <img src="<?php echo $post->avatar ?>" alt="<?php echo $post->author ?>" class="avatar-sm rounded-circle me-3 border border-2 border-secondary">
                        <div class="mt-2 text-start">
                            <h6 class="d-block fw-bold mb-0"><?php if(!empty($authorIdentifier)): ?><a href="<?php echo route('blog.author', [strtolower($authorIdentifier)]) ?>" class="text-dark text-decoration-none"><?php echo htmlspecialchars($post->author) ?></a><?php else: ?><?php echo htmlspecialchars($post->author) ?><?php endif ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 mb-5">
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
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="h4 mb-3"><?php ee('Author') ?></h3>
                        <div class="d-flex align-items-start gap-3">
                            <img src="<?php echo $post->avatar ?>" alt="<?php echo htmlspecialchars($post->author) ?>" class="rounded-circle border border-2 border-secondary flex-shrink-0" width="64" height="64" style="object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-1"><?php if(!empty($authorIdentifier)): ?><a href="<?php echo route('blog.author', [strtolower($authorIdentifier)]) ?>" class="text-dark text-decoration-none"><?php echo htmlspecialchars($post->author) ?></a><?php else: ?><?php echo htmlspecialchars($post->author) ?><?php endif ?></h6>
                                <?php if(!empty($authorBio)): ?>
                                    <div class="text-muted small"><?php echo nl2br(htmlspecialchars($authorBio)) ?></div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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