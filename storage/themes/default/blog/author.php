<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-secondary', 'bg-section-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="col py-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 col-lg-7 text-center">
                    <h1 class="display-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> mb-2"><?php echo e('Posts by {name}', null, ['name' => $authorName]) ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<?php view('blog.menu', compact('menu')) ?>
<section class="slice pt-5 pb-7 bg-section-secondary">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm rounded mb-5">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3">
                            <img src="<?php echo $author->avatar() ?>" alt="<?php echo htmlspecialchars($authorName) ?>" class="rounded-circle flex-shrink-0" width="80" height="80" style="object-fit: cover;">
                            <div>
                                <h2 class="h5 fw-bold mb-2"><?php echo htmlspecialchars($authorName) ?></h2>
                                <?php if (!empty($authorBio)): ?>
                                    <div class="text-muted small"><?php echo nl2br(htmlspecialchars($authorBio)) ?></div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (empty($posts)): ?>
                    <p class="text-muted"><?php echo e('No posts by this author yet.') ?></p>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <?php view('partials.blog_post', compact('post', 'categories')); ?>
                    <?php endforeach ?>
                    <?php echo pagination('pagination', 'page-item', 'page-link') ?>
                <?php endif ?>
            </div>
            <div class="col-md-4">
                <?php \Helpers\App::ads('blogsidebar') ?>
                <h6><?php ee('Popular Posts') ?></h6>
                <?php foreach ($popular as $post): ?>
                    <a href="<?php echo route('blog.post', [$post->slug]) ?>" class="mb-2 d-block" title="<?php echo $post->title ?>"><?php echo $post->title ?></a>
                <?php endforeach ?>
                <?php plug('blogsidebar') ?>
            </div>
        </div>
    </div>
</section>
