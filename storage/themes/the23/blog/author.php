<section id="blog" class="bg-primary border-top border-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-10 mb-5">
				<div class="pt-5 text-start">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb px-0 breadcrumb-links">
							<li class="breadcrumb-item"><a href="<?php echo route('home') ?>" class="text-dark"><?php ee('Home') ?></a></li>
							<li class="breadcrumb-item"><a href="<?php echo route('blog') ?>" class="text-dark"><?php ee('Blog') ?></a></li>
							<li class="breadcrumb-item active fw-bold"><?php echo htmlspecialchars($authorName) ?></li>
						</ol>
					</nav>
					<h1 class="display-6 fw-bold mt-5"><?php echo e('Posts by {name}', null, ['name' => $authorName]) ?></h1>
					<div class="mt-4">
						<div class="d-flex align-items-start gap-4">
							<img src="<?php echo $author->avatar() ?>" alt="<?php echo htmlspecialchars($authorName) ?>" class="rounded-circle border border-2 border-secondary flex-shrink-0" width="96" height="96" style="object-fit: cover;">
							<div class="flex-grow-1">
								<h2 class="h5 fw-bold mb-2"><?php echo htmlspecialchars($authorName) ?></h2>
								<?php if (!empty($authorBio)): ?>
									<div class="text-muted"><?php echo nl2br(htmlspecialchars($authorBio)) ?></div>
								<?php endif ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php view('blog.menu', compact('menu')) ?>
		<div class="py-5">
			<div class="row">
				<?php if (themeSettings::config('blog') == 'grid'): ?>
					<div class="col-md-12 mb-5">
						<div class="row">
							<?php foreach ($posts as $post): ?>
								<div class="col-sm-4">
									<?php view('blog.partial', compact('post', 'categories')); ?>
								</div>
							<?php endforeach ?>
						</div>
						<?php echo pagination('pagination bg-white rounded p-2 shadow-sm', 'page-item', 'page-link') ?>
					</div>
				<?php else: ?>
					<div class="col-md-8 mb-5">
						<?php if (empty($posts)): ?>
							<div class="card shadow-sm border-0 rounded-4">
								<div class="card-body p-5 text-center text-muted">
									<?php echo e('No posts by this author yet.') ?>
								</div>
							</div>
						<?php else: ?>
							<?php foreach ($posts as $post): ?>
								<?php view('blog.partial', compact('post', 'categories')); ?>
							<?php endforeach ?>
							<?php echo pagination('pagination justify-content-center bg-white shadow-sm p-3 rounded', 'page-item mx-2 shadow-sm text-center', 'page-link rounded') ?>
						<?php endif ?>
					</div>
					<div class="col-md-4">
						<?php \Helpers\App::ads('blogsidebar') ?>
						<div class="card border-0 shadow-sm">
							<div class="card-body">
								<h5 class="fw-bolder mb-3"><?php ee('Popular Posts') ?></h5>
								<?php foreach ($popular as $post): ?>
									<a href="<?php echo route('blog.post', [$post->slug]) ?>" class="mb-4 d-flex align-items-center relative" title="<?php echo $post->title ?>">
										<?php if ($post->image): ?>
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
