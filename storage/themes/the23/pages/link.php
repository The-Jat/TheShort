<section id="hero" class="position-relative py-4">
    <div class="container position-relative" data-offset-top="#navbar-main">
        <div class="row align-items-center py-8">
            <div class="col-md-7">
                <h1 class="display-4 fw-bold mb-4">
                    <?php ee('Link Shortener') ?>
                </h1>
                <p class="lead opacity-8 pe-5">
                    <?php ee('Transform long, complex URLs into memorable short links. Perfect for social media, marketing campaigns, and keeping your brand consistent.') ?>
                </p>
                <form method="post" action="<?php echo route('shorten') ?>" data-trigger="shorten-form" class="border rounded p-3 shadow-sm card mt-3">
                    <?php echo csrf() ?>
                    <div class="input-group input-group-lg align-items-center">
                        <input type="text" class="form-control border-0" placeholder="<?php echo e("Paste a long url") ?>" name="url" id="url">
                        <div class="input-group-append">
                            <?php if(config('user_history') && !\Core\Auth::logged() && $urls = \Helpers\App::userHistory()): ?>
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#userhistory"><i data-bs-toggle="tooltip" title="<?php ee('Your latest links') ?>" class="fa fa-clock-rotate-left"></i></button>
                            <?php endif ?>
                            <button class="btn btn-warning d-none" type="button"><?php ee('Copy') ?></button>
                            <button class="btn btn-primary" type="submit"><?php ee('Shorten') ?></button>
                        </div>
                    </div>
                    <?php if(!config('pro')): ?>
                        <a href="#advanced" data-bs-toggle="collapse" class="btn btn-sm btn-primary mb-2 mt-2"><?php ee('Advanced') ?></a>
                        <div class="collapse row" id="advanced">
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="custom" class="control-label fw-bold mb-2"><?php ee('Custom') ?></label>
                                    <input type="text" class="form-control p-2" name="custom" id="custom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="pass" class="control-label fw-bold mb-2"><?php ee('Password Protection') ?></label>
                                    <input type="text" class="form-control p-2" name="pass" id="pass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if(!\Core\Auth::logged()) { echo \Helpers\Captcha::display('shorten'); } ?>
                </form>
                <div id="output-result" class="border border-success p-3 rounded d-none mb-3">
                    <div class="d-flex align-items-center">
                        <div id="qr-result" class="me-2"></div>
                        <div id="text-result">
                            <p><?php ee('Your link has been successfully shortened. Want to more customization options?') ?></p>
                            <a href="<?php echo route('register') ?>" class="btn btn-sm btn-primary"><?php ee('Get started') ?></a>
                        </div>
                    </div>
                </div>
                <p class="my-5">
                    <a href="<?php echo route('register') ?>" class="btn btn-primary px-5 py-3 fw-bold"><?php ee('Get Started') ?></a>
                    <a href="<?php echo route('contact', ['subject' => 'Contact Sales']) ?>" class="btn btn-transparent text-dark fw-bold"><?php ee('Contact sales') ?></a>
                </p>
            </div>
            <div class="col-md-10 mx-auto col-lg-5 h-100 d-none d-sm-block position-relative">
				<div class="zindex-100 ml-lg-6">
					<?php if (isset($themeconfig->hero) && !empty($themeconfig->hero)): ?>
						<img src="<?php echo uploads($themeconfig->hero) ?>" alt="<?php echo config("title") ?>" class="img-fluid mw-lg-120 rounded-top zindex-100">
					<?php else: ?>
						<img src="<?php echo assets('images/shapes.svg') ?>" class="img-fluid position-absolute top-0 ms-5 end-0 w-100 h-100 animate-float opacity-50 zindex-0 outer-top">
						<div class="position-relative card shadow-0 bg-transparent p-5 border-0 perspective" style="height:500px">
							<div class="position-absolute gradient-primary w-100 top-0 start-0 opacity-75 rounded-3 h-100"></div>
							<div class="p-5 w-100 position-absolute top-50 start-50 translate-middle">
								<div class="card border-0 shadow-lg mb-3">
									<div class="card-body fs-6">
										<div class="d-flex align-items-center">
											<i class="fa fa-link fs-5"></i>
											<div class="ms-3">
												<h6 class="fw-bold mb-0"><?php echo config('sitename') ?></h6>
												<span class="fw-bold text-muted"><?php echo url('short') ?></span>
											</div>
											<div class="ms-auto">
												<span class="fs-6 text-success"><?php $rand = round(mt_rand() / mt_getrandmax() * 3, 2); echo $rand; ?>M <?php ee('Clicks') ?></span>
											</div>
										</div>
									</div>
								</div>
								<div class="card p-3 border-0 shadow-lg">
									<div class="d-flex align-items-center mb-0">
										<h3 class="text-dark h5 fw-bolder mb-0">
											<?php ee('Clicks') ?> <span class="fs-6 text-success">+<?php echo rand(10, 80) ?>%</span>
										</h3>
										<span class="fs-6 d-block text-muted ms-auto fw-bold"><?php echo $rand ?>M <?php ee('Clicks') ?></span>
									</div>
									<svg class="rounded" viewBox="0 0 2000 1400" xmlns="http://www.w3.org/2000/svg"><path d="M0 1383.803c21-9.972 63-30.067 105-49.86s63-36.615 105-49.107c42-12.492 63 17.422 105-13.354 42-30.777 63-125.032 105-140.528 42-15.495 63 88.592 105 63.05 42-25.543 63-144.923 105-190.761 42-45.838 63-56.416 105-38.43 42 17.987 63 142.285 105 128.363 42-13.92 63-148.434 105-197.97 42-49.534 63-51.791 105-49.705 42 2.086 63 83.56 105 60.136 42-23.425 63-127.997 105-177.258 42-49.262 63-62.948 105-69.05 42-6.102 63 90.824 105 38.54s63-274.834 105-299.962c42-25.13 63 170.32 105 174.318 42 3.999 63-66.754 105-154.324 42-87.57 63-207.459 105-283.526 42-76.068 84-77.45 105-96.811L2000 1400H0Z" fill="rgba(var(--bs-primary-rgb), 1)"/><path d="M0 1383.803c21-9.972 63-30.067 105-49.86s63-36.615 105-49.107c42-12.492 63 17.422 105-13.354 42-30.777 63-125.032 105-140.528 42-15.495 63 88.592 105 63.05 42-25.543 63-144.923 105-190.761 42-45.838 63-56.416 105-38.43 42 17.987 63 142.285 105 128.363 42-13.92 63-148.434 105-197.97 42-49.534 63-51.791 105-49.705 42 2.086 63 83.56 105 60.136 42-23.425 63-127.997 105-177.258 42-49.262 63-62.948 105-69.05 42-6.102 63 90.824 105 38.54s63-274.834 105-299.962c42-25.13 63 170.32 105 174.318 42 3.999 63-66.754 105-154.324 42-87.57 63-207.459 105-283.526 42-76.068 84-77.45 105-96.811" fill="none" stroke="var(--bs-primary)" stroke-width="4"/><g fill="var(--bs-primary)" opacity="0.2"><circle cx="1575" cy="397.907" r="30"/></g><g fill="var(--bs-primary)"><circle cx="105" cy="1333.943" r="8"/><circle cx="210" cy="1284.836" r="8"/><circle cx="315" cy="1271.482" r="8"/><circle cx="420" cy="1130.954" r="8"/><circle cx="525" cy="1194.003" r="8"/><circle cx="630" cy="1003.243" r="8"/><circle cx="735" cy="964.814" r="8"/><circle cx="840" cy="1093.176" r="8"/><circle cx="945" cy="895.207" r="8"/><circle cx="1050" cy="845.501" r="8"/><circle cx="1155" cy="905.637" r="8"/><circle cx="1260" cy="728.379" r="8"/><circle cx="1365" cy="659.329" r="8"/><circle cx="1470" cy="697.869" r="8"/><circle cx="1575" cy="397.907" r="8"/><circle cx="1680" cy="572.225" r="8"/><circle cx="1785" cy="417.901" r="8"/><circle cx="1890" cy="134.375" r="8"/><text x="1480" y="300" class="fw-bold display-2"><?php echo round(mt_rand() / mt_getrandmax() * 2, 2) ?>K</text></g></svg>
								</div>
							</div>
							<div class="card liquid-blur border-0 shadow-lg mb-3 position-absolute top-0 start-0 me-5 animate-float outer-left">
								<div class="card-body">
									<div class="position-relative">
										<div class="border-0 d-block rounded p-1 d-inline-block gradient-primary text-white position-absolute top-0 start-100 translate-middle ms-3">
											<img src="<?php echo \Helpers\QR::factory('Sample QR', 40, 0)->format('svg')->create('uri') ?>" class="rounded">
										</div>
										<h5 class="mb-0 fw-bold me-3"><?php ee('QR Codes') ?></h5>
									</div>
								</div>
							</div>
							<div class="card liquid-blur border-0 shadow-lg mb-3 position-absolute top-50 end-0 mt-5 me-4 animate-float outer-right">
								<div class="position-relative p-2">
									<span class="shadow-0 rounded p-2 px-3 d-inline-block gradient-primary text-white position-absolute top-0 start-50 translate-middle">
										<i class="fa fa-mobile"></i>
									</span>
									<h5 class="mb-0 mt-3 mx-3 fw-bold"><?php ee('Bio Pages') ?></h5>
								</div>
							</div>
							<div class="card liquid-blur border-0 shadow-lg mb-3 position-absolute top-100 start-0 ms-5 animate-float outer-left">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<span class="shadow-0 rounded p-2 px-3 d-inline-block gradient-primary text-white me-2">
											<i class="fa fa-link"></i>
										</span>
										<h5 class="mb-0 fw-bold"><?php ee('Smart Short Links') ?></h5>
									</div>
								</div>
							</div>
						</div>
					<?php endif ?>
				</div>
			</div>
        </div>
    </div>
</section>
<section class="py-10">
    <div class="container">
        <div class="row row-grid justify-content-between align-items-center">
            <div class="col-lg-5 order-lg-2">
                <h5 class="h3 fw-bold"><?php ee('One short link, infinite possibilities') ?>.</h5>
                <p class="lead my-4">
                    <?php ee('A short link is a powerful marketing tool when you use it carefully. It is not just a link but a medium between your customer and their destination. A short link allows you to collect so much data about your customers and their behaviors.') ?>
                </p>
                <ul class="list-unstyled mb-2">
                    <li class="mb-4">
                        <div class="d-flex">
                            <div>
                                <strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
                                    <i class="fa fa-link gradient-primary clip-text fw-bolder"></i>
                                </strong>
                            </div>
                            <div class="ms-3">
                                <span class="fw-bold"><?php ee('Branded Domains') ?></span>
                                <p><?php ee('Use your own domain name for short links') ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="mb-4">
                        <div class="d-flex">
                            <div>
                                <strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
                                    <i class="fa fa-chart-line gradient-primary clip-text fw-bolder"></i>
                                </strong>
                            </div>
                            <div class="ms-3">
                                <span class="fw-bold"><?php ee('Quick Analytics') ?></span>
                                <p><?php ee('Track clicks, locations, and referrers in real-time') ?></p>
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
                                <span class="fw-bold"><?php ee('Advanced Targeting') ?></span>
                                <p><?php ee('Target users by location, device, and language') ?></p>
                            </div>
                        </div>
                    </li>
                </ul>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6 order-lg-1">
            <div class="position-relative d-none d-sm-block" style="min-height: 500px;">                    
                    <div class="card border shadow-lg p-4 position-absolute w-50 start-0 my-5 animate-float" style="z-index: 1; animation-delay: 0s;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-md bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fa fa-link fs-5 gradient-primary clip-text"></i>
                                </div>
                                <div>
                                    <h6 class="text-dark fw-bold mb-0"><?php echo url() ?><span class="gradient-primary clip-text">short</span></h6>
                                    <small class="text-muted"><?php ee('Branded Domain') ?></small>
                                </div>
                            </div>
                            <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                <i class="fa fa-check-circle me-1"></i> <?php ee('Active') ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-dark fw-bold"><?php ee('Total Clicks') ?></span>
                                <span class="text-dark fw-bolder fs-5"><?php $clicks = rand(100, 999); echo $clicks; ?>K</span>
                            </div>
                            <div class="progress mb-3" style="height: 10px; border-radius: 10px; background: rgba(var(--bs-primary-rgb), 0.1);">
                                <div class="progress-bar gradient-primary" role="progressbar" style="width: <?php echo rand(60, 90) ?>%; border-radius: 10px;" data-animate="true"></div>
                            </div>
                            <div class="d-flex justify-content-between text-muted small">
                                <span><i class="fa fa-arrow-up text-success me-1"></i> +<?php echo rand(10, 30) ?>% <?php ee('this month') ?></span>
                                <span><i class="fa fa-clock me-1"></i> <?php ee('Live') ?></span>
                            </div>
                        </div>
                    </div>                                        
                    <div class="card border shadow-lg p-4 position-absolute w-50 end-0 top-0 my-5 animate-float" style="z-index: 2; animation-delay: 0.2s;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-md bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fa fa-globe fs-5 gradient-primary clip-text"></i>
                                </div>
                                <div>
                                    <h6 class="text-dark fw-bold mb-0"><?php ee('Geo Targeting') ?></h6>
                                    <small class="text-muted"><?php ee('Location-based redirects') ?></small>
                                </div>
                            </div>
                            <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1">
                                <?php echo rand(5, 15) ?> <?php ee('Countries') ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo assets('images/flags/us.svg') ?>" class="icon-sm rounded me-2" style="width: 20px; height: 15px;">
                                        <span class="text-dark small fw-bold"><?php ee('United States') ?></span>
                                    </div>
                                    <span class="text-dark small fw-bold"><?php $us = rand(40, 60); echo $us; ?>%</span>
                                </div>
                                <div class="progress" style="height: 8px; border-radius: 8px; background: rgba(var(--bs-primary-rgb), 0.1);">
                                    <div class="progress-bar gradient-primary" role="progressbar" style="width: <?php echo $us; ?>%; border-radius: 8px;"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo assets('images/flags/gb.svg') ?>" class="icon-sm rounded me-2" style="width: 20px; height: 15px;">
                                        <span class="text-dark small fw-bold"><?php ee('United Kingdom') ?></span>
                                    </div>
                                    <span class="text-dark small fw-bold"><?php $uk = rand(20, 30); echo $uk; ?>%</span>
                                </div>
                                <div class="progress" style="height: 8px; border-radius: 8px; background: rgba(var(--bs-primary-rgb), 0.1);">
                                    <div class="progress-bar gradient-primary" role="progressbar" style="width: <?php echo $uk; ?>%; border-radius: 8px;"></div>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between text-muted small">
                                    <span><i class="fa fa-map-marker-alt me-1"></i> <?php echo rand(50, 200) ?> <?php ee('Locations') ?></span>
                                    <span><i class="fa fa-sync-alt me-1"></i> <?php ee('Auto-redirect') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>                                        
                    <div class="card liquid-blur border shadow-lg p-4 w-50 position-relative ms-auto me-auto animate-float" style="z-index: 3; animation-delay: 0.4s; margin-top: 200px !important;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-md bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fa fa-chart-line fs-5 gradient-primary clip-text"></i>
                                </div>
                                <div>
                                    <h6 class="text-dark fw-bold mb-0"><?php ee('Analytics Dashboard') ?></h6>
                                    <small class="text-muted"><?php ee('Real-time insights') ?></small>
                                </div>
                            </div>
                            <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">
                                <i class="fa fa-circle text-success me-1" style="font-size: 8px;"></i> <?php ee('Live') ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="bg-white rounded-3 p-3 text-center border">
                                        <div class="text-dark">
                                            <h4 class="fw-bold mb-1 gradient-primary clip-text"><?php $totalClicks = rand(10, 50); echo $totalClicks; ?>K</h4>
                                            <small class="text-muted d-block"><?php ee('Total Clicks') ?></small>
                                            <small class="text-success mt-1 d-block"><i class="fa fa-arrow-up"></i> +<?php echo rand(5, 15) ?>%</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white rounded-3 p-3 text-center border">
                                        <div class="text-dark">
                                            <h4 class="fw-bold mb-1 gradient-primary clip-text"><?php $unique = rand(5, 20); echo $unique; ?>K</h4>
                                            <small class="text-muted d-block"><?php ee('Unique Visitors') ?></small>
                                            <small class="text-success mt-1 d-block"><i class="fa fa-arrow-up"></i> +<?php echo rand(3, 10) ?>%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted d-block mb-3 fw-bold">
                                    <i class="fa fa-share-alt me-1"></i> <?php ee('Top Referrers') ?>
                                </small>
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-facebook text-primary me-2"></i>
                                            <span class="text-dark small"><?php ee('Social Media') ?></span>
                                        </div>
                                        <span class="text-dark small fw-bold"><?php $social = rand(50, 70); echo $social; ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius: 6px; background: rgba(var(--bs-primary-rgb), 0.1);">
                                        <div class="progress-bar gradient-primary" role="progressbar" style="width: <?php echo $social; ?>%; border-radius: 6px;"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-muted small mt-3">
                                    <span><i class="fa fa-mouse-pointer me-1"></i> <?php echo round($totalClicks / $unique, 1); ?>x <?php ee('CTR') ?></span>
                                    <span><i class="fa fa-clock me-1"></i> <?php echo rand(1, 24); ?>h <?php ee('ago') ?></span>
                                </div>
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
                    <?php ee('Understanding your users and customers will help you increase your conversion. Our system allows you to track everything. Whether it is the amount of clicks, the country or the referrer, the data is there for you to analyze it.') ?>
                </p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-lg border p-4 rounded-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-md bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa fa-globe-americas fs-5 gradient-primary clip-text"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark"><?php ee('Where are most of your users located?') ?></h6>
                                <small class="text-muted"><?php ee('Geographic distribution') ?></small>
                            </div>
                        </div>
                        <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                            <i class="fa fa-map-marker-alt me-1"></i> <?php echo rand(50, 200) ?> <?php ee('Locations') ?>
                        </div>
                    </div>
                    <div class="mt-4">
                        <?php 
                        $countries = [
                            ['flag' => 'us.svg', 'name' => e('United States of America'), 'percent' => rand(50, 70)],
                            ['flag' => 'gb.svg', 'name' => e('United Kingdom'), 'percent' => rand(15, 25)],
                            ['flag' => 'ca.svg', 'name' => e('Canada'), 'percent' => rand(8, 15)],
                            ['flag' => 'jp.svg', 'name' => e('Japan'), 'percent' => rand(3, 8)]
                        ];
                        foreach($countries as $index => $country): 
                        ?>
                        <div class="d-flex align-items-center mb-4 <?php echo $index < count($countries) - 1 ? 'pb-4 border-bottom' : '' ?>">
                            <div class="position-relative me-3">
                                <img src="<?php echo assets('images/flags/'.$country['flag']) ?>" class="rounded shadow-sm" style="width: 32px; height: 24px; object-fit: cover;">
                                <?php if($index === 0): ?>
                                    <span class="badge bg-success rounded-circle position-absolute top-0 start-100 translate-middle" style="width: 12px; height: 12px; border: 2px solid white; font-size: 0;"></span>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark"><?php echo $country['name'] ?></span>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-dark me-2"><?php echo $country['percent'] ?>%</span>
                                        <?php if($index === 0): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1" style="font-size: 10px;">
                                                <i class="fa fa-arrow-up"></i> <?php echo rand(2, 8) ?>%
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="progress" style="height: 10px; border-radius: 10px; background: rgba(var(--bs-primary-rgb), 0.1);">
                                    <div class="progress-bar gradient-primary" role="progressbar" style="width: <?php echo $country['percent'] ?>%; border-radius: 10px;" data-animate="true"></div>
                                </div>
                                <?php if($index === 0): ?>
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted">
                                            <i class="fa fa-users me-1"></i> <?php echo rand(5000, 15000) ?> <?php ee('visitors') ?>
                                        </small>
                                        <small class="text-success">
                                            <i class="fa fa-trending-up me-1"></i> <?php ee('Top country') ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="mt-4 pt-3 border-top">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-center p-3 bg-primary rounded-3 border">
                                        <div class="fw-bold text-dark mb-1"><?php echo rand(100, 500) ?>+</div>
                                        <small class="text-muted"><?php ee('Countries') ?></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-3 bg-primary rounded-3 border">
                                        <div class="fw-bold text-dark mb-1"><?php echo rand(1000, 5000) ?>+</div>
                                        <small class="text-muted"><?php ee('Cities') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mb-5">
    <div class="container">
        <div class="p-2 p-md-5 bg-primary rounded-4 border-0">
            <div class="text-center my-5">
                <h2 class="fw-bolder display-6 mb-3"><strong><?php ee("Features that <span class=\"gradient-primary clip-text\">supercharge</span> your links") ?></strong></h2>
                <p class="lead"><?php ee('Powerful features to help you create, manage, and track your short links effectively') ?></p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold mt-3"><?php ee('Get Started') ?></a>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-spinner fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('Custom Landing Page') ?></h4>
                            <p>
                                <?php ee('Create a custom landing page to promote your product or service on forefront and engage the user in your marketing campaign.') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-layer-group fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('CTA Overlays') ?></h4>
                            <p>
                                <?php ee('Use our overlay tool to display unobtrusive notifications, polls or even a contact on the target website. Great for campaigns.') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-compass fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('Event Tracking') ?></h4>
                            <p>
                                <?php ee('Add your custom pixel from providers such as Facebook and track events right when they are happening.') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-bullseye fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('Smart Targeting') ?></h4>
                            <p>
                                <?php ee('Easily apply restrictions to your links and target users in specific countries & languages using specific devices.') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-users fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('Team Management') ?></h4>
                            <p>
                                <?php ee('Invite your team members and assign them specific privileges to manage everything and collaborate together.') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-globe fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('Branded Domain Names') ?></h4>
                            <p>
                                <?php ee("Easily add your own domain name for short links and take control of your brand name and your users' trust.") ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-box fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('Campaigns & Channels') ?></h4>
                            <p>
                                <?php ee('Group and organize your Links, Bio Pages and QR Codes. With Campaigns, you can also get aggregated stats.') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="h-100 card shadow-sm border-0">
                        <div class="card-body p-4 p-sm-5">
                            <i class="fa fa-terminal fa-2x gradient-primary clip-text"></i>
                            <h4 class="fw-bold my-3"><?php ee('Developer API') ?></h4>
                            <p>
                                <?php ee('Use our powerful API to build custom applications or extend your own application with our powerful tools.') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="h-100 p-5 gradient-primary text-white with-shapes rounded-4 border-0">
            <div class="row align-items-center gy-lg-5">
                <div class="col-sm-8">
                    <h2 class="fw-bold"><?php ee('Take control of your links') ?></h2>
                    <p><?php ee('You are one click away from taking control of all of your links, and instantly get better results.') ?></p>
                </div>
                <div class="col-sm-4 text-end">
                    <a class="btn btn-light btn-lg d-block d-sm-inline-block" href="<?php echo route('register') ?>"><?php ee('Get Started') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(config('user_history') && !\Core\Auth::logged() && $urls = \Helpers\App::userHistory()): ?>
<div class="modal fade" id="userhistory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bolder"><?php ee('Your latest links') ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php foreach($urls as $url): ?>
                    <h6 class="mb-1"><a href="<?php echo $url['url'] ?>" target="_blank"><?php echo $url['meta_title'] ?></a></h6>
                    <a href="<?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?>" class="text-muted d-block mb-3"><?php echo \Helpers\App::shortRoute($url['domain'], $url['alias'].$url['custom']) ?></a>
                <?php endforeach ?>
                <div class="d-flex mt-5 border rounded p-2">
                    <div class="opacity-8">
                        <?php ee('Want more options to customize the link, QR codes, branding and advanced metrics?') ?>
                    </div>
                    <div class="ml-auto">
                        <a href="<?php echo route('register') ?>" class="btn btn-primary btn-xs"><?php ee('Get Started') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
