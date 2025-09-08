<section id="hero" class="position-relative py-4">
    <img src="<?php echo assets('images/shapes.svg') ?>" class="img-fluid position-absolute top-0 start-0 w-100 h-100 animate-float opacity-50 zindex-0">
    <div class="container position-relative" data-offset-top="#navbar-main">
        <div class="row align-items-center py-8">
            <div class="col-md-7">
                <h1 class="display-4 fw-bold mb-4">
                    <?php ee('Bio Pages') ?>
                </h1>
                <p class="lead opacity-8 pe-5">
                    <?php ee('Convert your followers by creating beautiful pages that group all of your important links on the single page.') ?>
                </p>
                <form action="<?php echo route('register') ?>" class="border rounded p-3 shadow-sm card mt-3 col-md-8">
                    <div class="fw-bolder mb-0">
                        <?php echo url() ?>
                        <input type="text" class="form-control d-inline-block w-auto ps-0 border-0 align-middle" name="bioalias" placeholder="<?php ee('Type your alias') ?>">
                        <button class="btn btn-primary btn-sm float-end"><?php ee('Reserve') ?></button>
                    </div>
                    <div class="alias-feedback"></div>
                </form>
                <p class="my-5">
                    <a href="<?php echo route('register') ?>" class="btn btn-primary px-5 py-3 fw-bold"><?php ee('Get Started') ?></a>
                    <a href="<?php echo route('contact', ['subject' => 'Contact Sales']) ?>" class="btn btn-transparent text-dark fw-bold"><?php ee('Contact sales') ?></a>
                </p>
            </div>
            <div class="col-md-5 text-center">
                <div class="card gradient-primary border-0 shadow overflow-hidden">
                    <div class="bg-white text-start border ps-3 d-flex align-items-center">
                        <i class="fa fa-home me-2"></i> <span class="fw-bolder bg-primary rounded-pill m-2 px-3 py-2 border flex-fill"><i class="fa fa-lock text-success me-2"></i> <?php echo url() ?><span class="gradient-primary clip-text" data-toggle="typed" data-list="<?php echo implode(',', [e('company'),e('shop'), e('name')]) ?>"></span></span>
                    </div>
                    <div class="p-5">
                        <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-f1.jpg') ?>" class="img-fluid rounded-circle"></span>
                        <h3 class="text-white fw-bold"><span>Madison</span></h3></em>
                        <div id="social" class="text-center mt-2">
                            <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>
                        <div id="content" class="mt-3">
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3">🛒 <?php ee('New Merch') ?></a>
                            </div>
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3">🔥 <?php ee('Shop') ?></a>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-10">
    <div class="container">
        <div class="row row-grid justify-content-between align-items-center">
            <div class="col-lg-5 order-lg-2">
                <h5 class="h3 fw-bold"><?php ee('One link to rule them all') ?>.</h5>
                <p class="lead my-4">
                    <?php ee('Create beautiful profiles and add content like links, donation, videos and more for your social media users. Share a single on your social media profiles so your users can easily find all of your important links on a single page.') ?>
                </p>
                <ul class="list-unstyled mb-2">
                    <li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-grip gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('{n}+ Dynamic Widgets', null, ['n' => count($widgets)]) ?></span>
								<p><?php ee('Enhance your Bio Page with our dynamic widgets') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-droplet gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Customizable Design') ?></span>
								<p><?php ee('Customize everything with our easy to use builder') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-sliders gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Advanced Settings') ?></span>
								<p><?php ee('Configure your Bio Page & blocks your way') ?></p>
							</div>
						</div>
					</li>
				</ul>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="position-relative d-none d-sm-block">
                    <div class="card bg-danger border-0 shadow p-5 position-absolute w-50 h-80 start-0 my-5">
                        <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-f2.jpg') ?>" class="img-fluid rounded-circle"></span>
                        <h3 class="text-white fw-bold text-center"><span>Laura</span></h3></em>
                        <div id="social" class="text-center mt-2">
                            <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>                        
                        <div id="content" class="mt-3">
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fa fa-music position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Listen') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card gradient-secondary border-0 shadow p-5 position-absolute w-50 h-80 my-5 end-0 top-0">
                        <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-m2.jpg') ?>" class="img-fluid rounded-circle"></span>
                        <h3 class="text-white fw-bold text-center"><span>Sam</span></h3></em>
                        <div id="social" class="text-center mt-2">
                            <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>
                        <div id="content" class="mt-3">
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-youtube position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Subscribe') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg gradient-primary border-0 shadow p-4 w-50 position-relative ms-auto me-auto">
                        <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-m1.jpg') ?>" class="img-fluid rounded-circle"></span>
                        <h3 class="text-white fw-bold text-center"><span>Steve</span></h3></em>
                        <div id="social" class="text-center mt-2">
                            <a href="<?php echo config('facebook') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo config('twitter') ?>" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                        </div>
                        <div id="content" class="mt-3">
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-youtube position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Subscribe') ?></a>
                            </div>
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-tiktok position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Our videos') ?></a>
                            </div>
                            <div class="item mb-3">
                                <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3 position-relative rounded-pill"><i class="fab fa-instagram position-absolute start-0 left-0 fs-4 ms-3 ml-3"></i> <?php ee('Follow us') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-grid justify-content-between align-items-center mt-10">
            <div class="col-lg-5">
                <h5 class="h3 fw-bold"><?php ee('Trackable to the dot') ?>.</h5>
                <p class="lead my-4">
                <?php ee('Profiles are fully trackable and you can find out exactly how many people have visited your profiles or clicked links on your profile and where they are from.') ?>
                </p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo assets('images/map.png') ?>" alt="<?php ee('Trackable to the dot') ?>" class="img-responsive w-100 py-5">
            </div>
        </div>
    </div>
</section>
<section class="mb-5">
    <div class="container">
        <div class="p-2 p-md-5 bg-primary rounded-4 border-0">
            <div class="text-center my-5">
                <h2 class="fw-bolder display-6 mb-3"><strong><?php ee("Connect with your <span class=\"gradient-primary clip-text\">audience</span>") ?></strong></h2>
                <p class="lead"><?php ee('Add widgets from popular providers and enhance your Bio Page with dynamic content') ?></p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold mt-3"><?php ee('Get Started') ?></a>
            </div>
            <div class="d-none d-md-block text-center">
                <?php foreach($widgets as $widget): ?>
                    <?php if(strpos($widget['icon'], '<img') === false) continue; ?>
                    <div class="mb-5 mx-5 d-inline-block text-center">
                        <?php echo str_replace('<img', '<img class="icon-md bg-white shadow-sm p-2 rounded-circle"', $widget['icon']) ?>
                        <span class="fw-bold text-dark my-3 d-block"><?php echo $widget['title'] ?></span>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="h-100 p-5 gradient-primary text-white with-shapes rounded-4 border-0 ">
			<div class="row align-items-center gy-lg-5">
				<div class="col-sm-8">
					<h2 class="fw-bold"><?php ee('Take control of your links') ?></h2>
					<p><?php ee('You are one click away from taking control of all of your links, and instantly get better results.') ?></p>
				</div>
				<div class="col-sm-4 text-end">
					<a class="btn btn-light text-primary btn-lg d-block d-sm-inline-block" href="<?php echo route('register') ?>"><?php ee('Get Started') ?></a>
				</div>
			</div>
		</div>
    </div>
</section>