<section id="hero" class="position-relative mt-3">
	<div class="container position-relative zindex-1">
		<?php echo message() ?>
		<div class="row g-lg-5 py-10">
			<div class="col-lg-7 text-center text-lg-start">
				<?php if($count->users): ?>
					<span class="bg-primary py-2 px-3 rounded-pill text-muted fw-bold">
						<?php if($count->users > 100): ?>
							<?php _ee('Trusted by {n} worldwide', ['n' => '<strong class="gradient-primary clip-text fw-bolder">'.$count->users.' '.e('customers').'</strong>']) ?>
						<?php else: ?>
							<?php _ee('Trusted by {n} worldwide', ['n' => '<strong class="gradient-primary clip-text fw-bolder">'.e('thousands of users').'</strong>']) ?>
						<?php endif ?>
					</span>
				<?php endif ?>
				<h1 class="display-4 fw-bolder my-4">
				<strong><?php echo isset(config('theme_config')->homeheader) && !empty(config('theme_config')->homeheader) ? config('theme_config')->homeheader : ee('Intuitive, Secure<br>& Dynamic').'<br> <span class="gradient-primary clip-text" data-toggle="typed" data-list="'.(implode(',', [e('Links').'.',e('QR Codes').'.', e('Bio Pages').'.'])).'"></span>' ?></strong>
				</h1>
				<p class="col-lg-10 fs-5 mb-5">
					<?php echo isset(config('theme_config')->homedescription) && !empty(config('theme_config')->homedescription) ? config('theme_config')->homedescription :  e('Boost your campaigns by creating dynamic Links, QR codes and Bio Pages and get instant analytics.') ?>
				</p>
				<?php message() ?>
				<form method="post" action="<?php echo route('shorten') ?>" data-trigger="shorten-form" class="mt-3 mb-5 border rounded p-3 text-start">
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
				<?php if(\Core\DB::plans()->where('free', '1')->where('status', '1')->first()): ?>
					<a href="<?php echo route('register') ?>" class="btn btn-primary px-4 py-3 fw-bold mb-1"><?php ee('Get Started for Free') ?></a>
					<p>
						<ul class="list-unstyled mb-2 text-muted small">
							<li class="mb-1"><i class="fa fa-check text-success me-2"></i> <?php ee('Start free, upgrade later') ?></li>
							<li class="mb-1"><i class="fa fa-check text-success me-2"></i> <?php ee('No credit card required') ?></li>
							<li class="mb-1"><i class="fa fa-check text-success me-2"></i> <?php ee('Easy to use') ?></li>
						</ul>
					</p>
				<?php else: ?>
					<?php if(\Core\DB::plans()->whereNotEqual('trial_days', '0')->first()): ?>
						<a href="<?php echo route('pricing') ?>" class="btn btn-primary px-4 py-3 fw-bold mb-1"><?php ee('Get Started') ?></a>
						<p>
							<ul class="list-unstyled mb-2 text-muted small">
								<li class="mb-1"><i class="fa fa-check text-success me-2"></i> <?php ee('Start with a free trial') ?></li>
								<li class="mb-1"><i class="fa fa-check text-success me-2"></i> <?php ee('No credit card required') ?></li>
								<li class="mb-1"><i class="fa fa-check text-success me-2"></i> <?php ee('Easy to use') ?></li>
							</ul>
						</p>
					<?php else: ?>
						<a href="<?php echo route('register') ?>" class="btn btn-primary px-4 py-3 fw-bold mb-5"><?php ee('Get Started') ?></a>
					<?php endif ?>
				<?php endif ?>
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
							<div class="card border-0 shadow-lg mb-3 position-absolute top-0 start-0 me-5 animate-float outer-left">
								<div class="card-body">
									<div class="position-relative">
										<div class="border-0 d-block rounded p-1 d-inline-block gradient-primary text-white position-absolute top-0 start-100 translate-middle ms-3">
											<img src="<?php echo \Helpers\QR::factory('Sample QR', 40, 0)->format('svg')->create('uri') ?>" class="rounded">
										</div>
										<h5 class="mb-0 fw-bold me-3"><?php ee('QR Codes') ?></h5>
									</div>
								</div>
							</div>
							<div class="card border-0 shadow-lg mb-3 position-absolute top-50 end-0 mt-5 me-4 animate-float outer-right">
								<div class="position-relative p-2">
									<span class="shadow-0 rounded p-2 px-3 d-inline-block gradient-primary text-white position-absolute top-0 start-50 translate-middle">
										<i class="fa fa-mobile"></i>
									</span>
									<h5 class="mb-0 mt-3 mx-3 fw-bold"><?php ee('Bio Pages') ?></h5>
								</div>
							</div>
							<div class="card border-0 shadow-lg mb-3 position-absolute top-100 start-0 ms-5 animate-float outer-left">
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
<section id="mainfeatures">
	<div class="container">
		<div class="bg-dark shadow rounded p-5">
			<div class="d-sm-flex align-items-center">
				<h2 class="text-white fw-bolder display-5 lh-lg"><?php ee('<span class="gradient-primary clip-text fw-bolder gradient-bottom">Supercharge</span> <span class="thunder-animation fa fa-bolt text-warning"></span> your productivity') ?></h2>
				<a href="<?php echo route('register') ?>" class="btn btn-light text-dark fw-bold mt-2 rounded-pill ms-auto px-5"><?php ee('Get Started') ?><i class="fa fa-chevron-right fa-xs align-middle ps-3"></i></a>
			</div>			
			<div class="row align-items-center gy-5 pt-5" id="blurred">
				<div class="col-md-4">
					<div class="card border-0 overflow-hidden">
						<div class="gradient-primary">
							<div class="m-3 rounded-pill px-3 py-2 bg-white">
								<i class="fa fa-link gradient-primary clip-text me-2"></i> <strong><?php echo url() ?><span class="gradient-primary clip-text" data-toggle="typed" data-list="app,store,profile,page"></span></strong>
							</div>
							<div class="mt-3 card-carousel">
								<div class="card-carousel-inner">
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('Branded Domains')?></small>
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('Quick Analytics')?></small>
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('Custom Alias')?></small> 
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('Advanced Targeting')?></small>									
								</div>
							</div>
							<div class="mt-2 mb-4 card-carousel ps-5">
								<div class="card-carousel-inner">
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('Deep Links')?></small>
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('Custom Parameters')?></small>
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('A/B Testing')?></small>
									<small class="card-carousel-item bg-white shadow-sm py-1 px-2 fit-content rounded-pill text-dark"><?php ee('Custom Meta Tags')?></small> 							
								</div>
							</div>
						</div>
						<div class="p-4">
							<h4 class="fw-bold mb-3"><?php ee('URL Shortener') ?></h4>
							<p class="">
								<?php ee('Transform long, complex URLs into memorable short links. Perfect for social media, marketing campaigns, and keeping your brand consistent.') ?>							
							</p>
							<a href="#features" class="btn btn-transparent text-dark fw-bold mt-2 rounded-pill border"><?php ee('Learn more') ?></a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card border-0 overflow-hidden">
						<div class="gradient-primary p-3 text-center">
							<span class="rounded-circle mb-1 d-block bg-white mx-auto opacity-8" style="width:40px;height:40px"><img src="<?php echo assets('images/avatar-f1.jpg') ?>" class="img-fluid rounded-circle"></span>
							<h6 class="text-white fw-bold"><span><?php echo config('sitename') ?></span></h6></em>
							<div id="social" class="text-center mt-2">
								<a href="<?php echo config('facebook') ?>" target="_blank" class="mx-2 text-white" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
								<a href="<?php echo config('twitter') ?>" target="_blank" class="mx-2 text-white" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-x-twitter"></i></a>
							</div>
							<div id="content" class="mt-2">
								<a href="#" class="btn btn-sm d-block btn-light text-primary shadow-sm rounded-pill"><small>🔥 <?php ee('Shop') ?></small></a>
							</div>
						</div>
						<div class="p-4">
							<h4 class="fw-bold mb-3"><?php ee('Bio Pages') ?></h4>
							<p class="">
								<?php ee('Create stunning, mobile-optimized landing pages that showcase all your important links in one place. Perfect for social media profiles.') ?>
							</p>
							<a href="<?php echo route('page.bio') ?>" class="btn btn-transparent text-dark fw-bold mt-2 rounded-pill border"><?php ee('Learn more') ?></a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card border-0 overflow-hidden">
						<div class="gradient-primary p-3 text-center">
							<div class="position-relative">							
								<div class="position-relative qr-code-animation">                        
									<?php echo \Helpers\QR::factory(url('pricing'), 138, 2)->module('circle')->eye('circle', 'rounded')->color('rgb(0,0,0)', 'rgb(255,255,255)','rgb(255,255,0)', 'rgb(255,0,255)')->format('svg')->string() ?>
								</div>
								<div class="z-n1 mt-2 mb-4 card-carousel ps-5 position-absolute top-50 start-50 translate-middle">
									<div class="card-carousel">
										<div class="card-carousel-inner">
											<small class="card-carousel-item bg-dark shadow-sm py-1 px-2 fit-content rounded-pill text-white"><?php ee('Gradient Color')?></small>
											<small class="card-carousel-item bg-dark shadow-sm py-1 px-2 fit-content rounded-pill text-white"><?php ee('QR Styles')?></small>
											<small class="card-carousel-item bg-dark shadow-sm py-1 px-2 fit-content rounded-pill text-white"><?php ee('Dynamic QR Codes')?></small>
											<small class="card-carousel-item bg-dark shadow-sm py-1 px-2 fit-content rounded-pill text-white"><?php ee('Custom Frames')?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="p-4">
							<h4 class="fw-bold mb-3"><?php ee('QR Codes') ?></h4>
							<p class="">
								<?php ee('Generate dynamic QR codes that can be customized with your brand colors and tracked in real-time.') ?>							
							</p>
							<a href="<?php echo route('page.qr') ?>" class="btn btn-transparent text-dark fw-bold mt-2 rounded-pill border"><?php ee('Learn more') ?></a>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="py-10 pt-5" id="features">
	<div class="container">
		<div class="row flex-lg-row-reverse align-items-center gy-5 py-5">
			<div class="col-md-6 offset-md-1 text-start">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Collect data within minutes. Hassle-free.') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mt-3 mb-5">
					<?php ee('One short link, infinite possibilities.') ?>
				</h2>
				<p class="lead mb-5">
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
								<span class="fw-bold"><?php ee('Short Links') ?></span>
								<p><?php ee('Intuitive and trackable links') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-qrcode gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('QR Codes') ?></span>
								<p><?php ee('Customizable and secure QR codes') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">
									<i class="fa fa-mobile gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Beautiful Bio Pages') ?></span>
								<p><?php ee('Simple yet beautiful Bio Pages for your links') ?></p>
							</div>
						</div>
					</li>
				</ul>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
			<div class="col-md-5">
				<div class="p-4 p-md-5 rounded-3 shadow-sm position-relative h-100 gradient-primary">
					<h6 class="fw-bold text-white mb-2"><?php ee('Turn long links into short links') ?></h6>
					<h5 class="fw-bold text-white border rounded p-3"><span data-toggle="typed" data-list="<i class='fa fa-times-circle'></i> https://longurl.com/page/article-name,<i class='fa fa-check-circle'></i> <?php echo str_replace('www.', '', url('short')) ?>"></span></h5>
					<div class="position-absolute position-sm-relative card mt-10 top-0 ms-0 ms-md-5 start-0 d-block p-5 rounded shadow w-100 opacity-90 border-0">
						<h5 class="fw-bold"><?php ee('Where are most of your users located?') ?></h5>
						<div class="mt-4">
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/ca.svg') ?>" class="icon rounded">
							<span class="align-middle ms-2">
								<?php ee('Canada') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/us.svg') ?>" class="icon rounded">
							<span class="align-middle ms-2">
								<?php ee('United States of America') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/gb.svg') ?>" class="icon rounded">
							<span class="align-middle ms-2">
								<?php ee('United Kingdom') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<div class="mt-3">
							<img src="<?php echo assets('images/flags/jp.svg') ?>" class="icon rounded border">
							<span class="align-middle ms-2">
								<?php ee('Japan') ?>
							</span>
							<div class="progress progress-sm mt-2">
								<div class="progress-bar" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row align-items-center gy-5 py-5 mt-8 text-start">
			<div class="col-md-6 order-last order-sm-first">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Instantly link to apps. Automatically.') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mb-5 mt-3">
					<?php ee('Smart Deep Linking') ?>
				</h2>
				<p class="lead mb-5">
					<?php ee('Grow your audience by automatically opening mobile apps when the app is installed without any coding knowledge or SDK. Direct customers to download and install apps when not installed on the device. Many popular apps are supported and you can even add your own app links.') ?>
				</p>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
			<div class="col-md-6">
				<div class="border rounded p-3 shadow-sm card position-relative">
                    <h5 class="fw-bolder mb-0"><i class="fa fa-lock text-success me-2"></i> <?php echo url() ?><span class="gradient-primary clip-text" >smart</span></h5>
					<span class="gradient-primary d-inline-block position-absolute top-100 start-50 translate-middle text-white rounded-circle icon-sm text-center"><i class="fa fa-chevron-down mt-2 animate-float"></i></span>
                </div>
				<h3 class="h5 fw-bold mt-4 text-center"><?php ee('Popular Apps') ?></h3>
				<div class="row mt-4 justify-content-center">
					<?php foreach(\Helpers\DeepLinks::list() as $item): ?>
						<div class="col-4 col-lg-2 mb-5 text-center">
							<img alt="<?php echo $item['title'] ?>" src="<?php echo $item['icon'] ?>" class="icon-md bg-white shadow-sm p-2 rounded">
							<p class="fw-bold text-dark my-3"><?php echo $item['title'] ?></p>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="bg-primary py-15 text-dark">
	<div class="text-center mb-5 px-3">
		<h2 class="fw-bolder display-5 mb-3"><strong><?php ee("Features that<br>you'll <span class=\"gradient-primary clip-text\">ever need</span>") ?></strong></h2>
		<p class="lead"><?php ee('We provide you with all the tools you need to increase your productivity.') ?></p>
	</div>
	<div class="py-5 mt-sm-5 card-carousel">
		<div class="card-carousel-inner pe-2">
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
				<div class="card-body p-4 p-sm-5">
					<i class="fa fa-spinner fa-2x gradient-primary clip-text"></i>
					<h4 class="fw-bold my-3"><?php ee('Custom Landing Page') ?></h4>
					<p>
						<?php ee('Create a custom landing page to promote your product or service on forefront and engage the user in your marketing campaign.') ?>
					</p>
				</div>
			</div>
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
				<div class="card-body p-4 p-sm-5">
					<i class="fa fa-layer-group fa-2x gradient-primary clip-text"></i>
					<h4 class="fw-bold my-3"><?php ee('CTA Overlays') ?></h4>
					<p>
						<?php ee('Use our overlay tool to display unobtrusive notifications, polls or even a contact on the target website. Great for campaigns.') ?>
					</p>
				</div>
			</div>
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
				<div class="card-body p-4 p-sm-5">
					<i class="fa fa-compass fa-2x gradient-primary clip-text"></i>
					<h4 class="fw-bold my-3"><?php ee('Event Tracking') ?></h4>
					<p>
						<?php ee('Add your custom pixel from providers such as Facebook and track events right when they are happening.') ?>
					</p>
				</div>
			</div>
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
				<div class="card-body p-4 p-sm-5">
					<i class="fa fa-bullseye fa-2x gradient-primary clip-text"></i>
					<h4 class="fw-bold my-3"><?php ee('Smart Targeting') ?></h4>
					<p>
						<?php ee('Easily apply restrictions to your links and target users in specific countries & languages using specific devices.') ?>
					</p>
				</div>
			</div>
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
				<div class="card-body p-4 p-sm-5">
					<i class="fa fa-users fa-2x gradient-primary clip-text"></i>
					<h4 class="fw-bold my-3"><?php ee('Team Management') ?></h4>
					<p>
						<?php ee('Invite your team members and assign them specific privileges to manage everything and collaborate together.') ?>
					</p>
				</div>
			</div>
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
				<div class="card-body p-4 p-sm-5">
					<i class="fa fa-globe fa-2x gradient-primary clip-text"></i>
					<h4 class="fw-bold my-3"><?php ee('Branded Domain Names') ?></h4>
					<p>
						<?php ee("Easily add your own domain name for short links and take control of your brand name and your users' trust.") ?>
					</p>
				</div>
			</div>
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
				<div class="card-body p-4 p-sm-5">
					<i class="fa fa-box fa-2x gradient-primary clip-text"></i>
					<h4 class="fw-bold my-3"><?php ee('Campaigns & Channels') ?></h4>
					<p>
						<?php ee('Group and organize your Links, Bio Pages and QR Codes. With Campaigns, you can also get aggregated stats.') ?>
					</p>
				</div>
			</div>
			<div class="card-carousel-item item-lg item-animate h-100 card shadow-sm border-0">
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
</section>
<section class="py-10">
	<div class="container">
		<div class="row flex-lg-row-reverse align-items-center gy-5 py-5">
			<div class="col-md-6 order-last order-sm-first" id="notifications-card">
				<div class="card shadow border-0 p-3 mb-4 mt-5">
					<div class="d-flex">
						<img alt="<?php ee('New York, United States') ?>" src="<?php echo assets('images/flags/fr.svg') ?>" class="avatar text-white rounded mr-3">
						<div class="ms-3 mt-2">
							<h6 class="fw-bold mb-1"><?php ee('Someone scanned your QR Code') ?></h6>
							<div class="h6 mb-0 text-sm">
								<span class="text-muted"><?php ee('Paris, France') ?></span>
							</div>
						</div>
						<div class="ms-auto d-none d-lg-block mt-3">
							<span class="badge badge-pill gradient-primary p-2"><?php ee('{d} minutes ago', null, ['d' => $numbers[0]]) ?></span>
						</div>
					</div>
				</div>
				<div class="card shadow gradient-primary border-0 p-3 mb-4">
					<div class="d-flex">
						<img alt="<?php ee('New York, United States') ?>" src="<?php echo assets('images/flags/us.svg') ?>" class="avatar text-white rounded mr-3">
						<div class="ms-3 mt-2 text-white">
							<h6 class="fw-bold mb-1"><?php ee('Someone visited your Link') ?></h6>
							<div class="h6 mb-0 text-sm">
								<span><?php ee('New York, United States') ?></span>
							</div>
						</div>
						<div class="ms-auto d-none d-lg-block mt-3">
							<span class="badge badge-pill bg-white text-dark p-2"><?php ee('{d} minutes ago', null, ['d' => $numbers[1]]) ?></span>
						</div>
					</div>
				</div>
				<div class="card shadow border-0 p-3 mb-4">
					<div class="d-flex">
						<img alt="<?php ee('New York, United States') ?>" src="<?php echo assets('images/flags/gb.svg') ?>" class="avatar text-white rounded mr-3">
						<div class="ms-3 mt-2">
							<h6 class="fw-bold mb-1"><?php ee('Someone viewed your Bio Page') ?></h6>
							<div class="h6 mb-0 text-sm">
								<span class="text-muted"><?php ee('London, United Kingdom') ?></span>
							</div>
						</div>
						<div class="ms-auto d-none d-lg-block mt-3">
							<span class="badge badge-pill gradient-primary p-2"><?php ee('{d} minutes ago', null, ['d' => $numbers[2]]) ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 order-first order-sm-last text-start">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Get instant results') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mb-5 mt-3">
					<?php ee('Track & Optimize') ?>
				</h2>
				<p class="lead mb-5 pe-5">
					<?php ee('Understanding your users and customers will help you increase your conversion. Our system allows you to track everything. Whether it is the amount of clicks, the country or the referrer, the data is there for you to analyze it.') ?>
				</p>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
		</div>
		<div class="row flex-lg-row-reverse align-items-center gy-5 py-5 mt-8 text-start">
			<div class="col-md-6 order-first order-sm-last">
				<div class="card shadow border-0 p-4 mt-5 mx-2 mx-md-4 backdrop-cards">
					<div>
						<h5 class="fw-bolder"><?php ee('Invite People') ?></h5>
						<span class="text-muted"><?php ee('Invite your teammates & work together') ?></span>
						<div class="d-block mt-3"><strong><?php ee('Members') ?></strong> <small class="text-muted">(3/5)</small></div>
						<div class="d-flex my-2">
							<img alt="<?php ee('Invite your teammates & work together') ?>" src="<?php echo assets('images/avatar-f1.jpg') ?>" class="avatar-sm rounded-circle mr-3">
							<div class="ms-3 mt-2">
								<h6 class="fw-bold mb-1"><?php ee('Jane Doe') ?></h6>
								<div class="h6 mb-0 text-sm">
									<small class="text-muted">jane.doe@<?php echo str_replace('www.', '', \Core\Helper::parseUrl(config('url'), 'host')) ?></small>
								</div>
							</div>
						</div>
						<div class="d-flex my-2">
							<img alt="<?php ee('Invite your teammates & work together') ?>" src="<?php echo assets('images/avatar-m2.jpg') ?>" class="avatar-sm rounded-circle mr-3">
							<div class="ms-3 mt-2">
								<h6 class="fw-bold mb-1"><?php ee('Barry Tone') ?></h6>
								<div class="h6 mb-0 text-sm">
									<small class="text-muted">barry.tone@<?php echo str_replace('www.', '', \Core\Helper::parseUrl(config('url'), 'host')) ?></small>
								</div>
							</div>
							<div class="ms-auto d-none d-lg-block mt-3">
								<span class="badge badge-pill bg-primary p-2"><strong class="gradient-primary clip-text"><?php ee('Invited') ?></strong></span>
							</div>
						</div>
						<div class="d-flex my-2">
							<img alt="<?php ee('Invite your teammates & work together') ?>" src="<?php echo assets('images/avatar-m1.jpg') ?>" class="avatar-sm rounded-circle mr-3">
							<div class="ms-3 mt-2">
								<h6 class="fw-bold mb-1"><?php ee('John Doe') ?></h6>
								<div class="h6 mb-0 text-sm">
									<small class="text-muted">john.doe@<?php echo str_replace('www.', '', \Core\Helper::parseUrl(config('url'), 'host')) ?></small>
								</div>
							</div>
						</div>						
					</div>
				</div>
			</div>
			<div class="col-md-6 order-last order-sm-first">
				<span class="bg-primary py-2 px-3 rounded-pill">
					<strong class="gradient-primary clip-text fw-bolder"><?php ee('Collaborate with your teammates') ?></strong>
				</span>
				<h2 class="display-6 fw-bold mb-5 mt-3">
					<?php ee('Invite & Work Together') ?>
				</h2>
				<p class="lead mb-5">
					<?php ee('Invite your teammates within seconds and work together as team to manage your Links, Bio Pages and QR codes. Team members can can be assigned specific privileges and can work on different workspaces.') ?>
				</p>
				<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold"><?php ee('Get Started') ?></a>
			</div>
		</div>
		<div class="row mt-10">
			<div class="col-md-12">
				<div class="p-2 p-md-5 bg-primary rounded-4 border-0">
					<div class="row align-items-center">
						<div class="col-md-4 order-last order-sm-first d-none d-md-block">
							<div class="row">
								<div class="col-6 text-center">
									<div class="integrations mb-5">
										<img alt="Slack" src="<?php echo assets("images/slack.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Slack</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Zapier" src="<?php echo assets("images/zapier.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Zapier</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Google Tag Manager" src="<?php echo assets("images/gtm.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Google Tag Manager</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Facebook Pixels" src="<?php echo assets("images/facebook.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Facebook</p>
									</div>
								</div>
								<div class="col-6 py-5 text-center">
									<div class="integrations mb-5">
										<img alt="Bing" src="<?php echo assets("images/wp.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">WordPress</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Bing" src="<?php echo assets("images/shortcuts.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Shortcuts</p>
									</div>
									<div class="integrations mb-5">
										<span class="icon-md bg-white shadow-sm p-2 rounded-circle d-inline-block"><i class="fab fa-x-twitter fs-2"></i></span>
										<p class="fw-bold text-dark my-3">X</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Snapchat" src="<?php echo assets("images/snapchat.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Snapchat</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="text-center mb-5">
								<h3 class="fw-bold mt-4"><strong><?php ee('Integrations') ?></strong></h3>
								<p><?php ee('Connect your links to third-party applications so they can share information such as traffic and analytics.') ?></p>
								<a href="<?php echo route('register') ?>" class="btn btn-primary px-3 py-2 fw-bold mt-3"><?php ee('Get Started') ?></a>
							</div>
						</div>
						<div class="col-md-4 d-none d-md-block">
							<div class="row">
								<div class="col-6 py-5 text-center">
									<div class="integrations mb-5">
										<img alt="Bing" src="<?php echo assets("images/bing.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Bing</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Reddit" src="<?php echo assets("images/reddit.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Reddit</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Google Analytics" src="<?php echo assets("images/ga.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Google Analytics</p>
									</div>
									<div class="integrations mb-5">
										<img alt="LinkedIn" src="<?php echo assets("images/linkedin.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">LinkedIn</p>
									</div>
								</div>
								<div class="col-6 text-center">
									<div class="integrations mb-5">
										<img alt="Pinterest" src="<?php echo assets("images/pinterest.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Pinterest</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Quora" src="<?php echo assets("images/quora.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Quora</p>
									</div>
									<div class="integrations mb-5">
										<img alt="TikTok" src="<?php echo assets("images/tiktok.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">TikTok</p>
									</div>
									<div class="integrations mb-5">
										<img alt="Adroll" src="<?php echo assets("images/aroll.svg") ?>" class="icon-md bg-white shadow-sm p-2 rounded-circle">
										<p class="fw-bold text-dark my-3">Adroll</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-5 text-start">
						<div class="col-md-6 mb-2 mb-md-0">
							<div class="h-100 card shadow-sm border-0">
								<div class="card-body p-4 p-sm-5">
									<i class="fa fa-th fa-2x gradient-primary clip-text"></i>
									<h4 class="fw-bold my-3"><?php ee('Tracking Pixels') ?></h4>
									<p>
										<?php ee('Add your custom pixel from providers such as Facebook & Google Tag Manager and track events right when they are happening.') ?>
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-6 mb-0">
							<div class="h-100 card shadow-sm border-0">
								<div class="card-body p-4 p-sm-5">
									<i class="fa fa-bell fa-2x gradient-primary clip-text"></i>
									<h4 class="fw-bold my-3"><?php ee('Notifications') ?></h4>
									<p>
										<?php ee('Get notified when users use your links via various channels such as Slack and webhook services like Zapier.') ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php if($testimonials = (array) config('testimonials')): ?>
	<section class="bg-primary border-top border-bottom">
		<div class="container py-8">
			<div class="row my-5 justify-content-center text-center">
				<div class="col-lg-8 col-md-10">
					<h2 class="mb-2 fw-bolder h1"><strong><?php ee("Don't take our word for it.") ?></strong></h2>
					<h2 class="mb-5 fw-bolder h1"><strong class="gradient-primary clip-text"><?php ee('Trust our customers.') ?></strong></h2>
				</div>
			</div>
			<div class="row">
				<?php foreach(array_chunk($testimonials, ceil(count($testimonials)/3)) as $testimonials): ?>
					<div class="col-lg-4 px-sm-2">
						<?php foreach($testimonials as $testimonial): ?>
							<div class="card shadow-sm border-0 mb-4 mx-lg-1">
								<div class="card-body p-3">
									<p><?php echo $testimonial->testimonial ?></p>
									<div class="d-flex align-items-center mt-3">
										<div>
											<?php if(isset($testimonial->avatar) && file_exists(appConfig('app')['storage']['avatar']['path'].'/'.$testimonial->avatar)) $testimonial->avatar = uploads($testimonial->avatar, 'avatar');else{if($testimonial->email){$testimonial->avatar = 'https://www.gravatar.com/avatar/'.md5(trim($testimonial->email)).'?s=64&d=identicon';}} ?>
											<?php echo $testimonial->avatar ? '<img src="'.$testimonial->avatar.'" class="avatar-sm rounded-circle"" alt="'.$testimonial->name.'">': '' ?>
										</div>
										<div class="ms-3">
											<span class="h6 mb-0"><?php echo $testimonial->name ?>  <?php echo $testimonial->job  ? '<small class="d-block text-muted">'.$testimonial->job.'</small>' : '' ?></span>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</section>
<?php endif ?>
<?php if (config("homepage_stats")): ?>
	<section class="py-8">
        <div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<h2 class="fw-bolder display-5 mb-5 text-center text-md-start"><strong><?php ee("Let <br><span class=\"gradient-primary clip-text\">the numbers</span><br> do the talking") ?>.</strong></h2>
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-md-6 mb-5">
							<div class="text-center bg-primary py-5 px-2 px-lg-5 rounded">
								<h3 class="h5 text-capitalize"><span class="gradient-primary fw-bolder clip-text"><?php ee('Powering') ?></span></h3>
								<div class="h1">
									<span class="counter"><?php echo $count->links ?></span>
									<span class="counter-extra">+</span>
								</div>
								<h3 class="h6 text-capitalize fw-bold"><?php ee('Links') ?></h3>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="text-center bg-primary py-5 px-2 px-lg-5 rounded">
								<h3 class="h5 text-capitalize"><span class="gradient-primary fw-bolder clip-text"><?php ee('Serving') ?></span></h3>
								<div class="h1">
									<span class="counter"><?php echo $count->clicks ?></span>
									<span class="counter-extra">+</span>
								</div>
								<h3 class="h6 text-capitalize fw-bold"><?php ee('Clicks') ?></h3>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-5">
							<div class="text-center bg-primary py-5 px-2 px-lg-5 rounded">
								<h3 class="h5 text-capitalize"><span class="gradient-primary fw-bolder clip-text"><?php ee('Trusted by') ?></span></h3>
								<div class="h1">
									<span class="counter"><?php echo $count->users ?></span>
									<span class="counter-extra">+</span>
								</div>
								<h3 class="h6 text-capitalize fw-bold"><?php ee('Amazing Customers') ?></h3>
							</div>
						</div>
						<div class="col-md-6 mb-5 d-none d-md-block">
							<a href="<?php echo route('register') ?>">
								<div class="bg-primary py-5 px-2 px-lg-5 rounded h-100 d-flex align-items-center justify-content-center">
									<h3 class="h5 text-capitalize">
										<span class="gradient-primary fw-bolder clip-text"><?php ee('Get Started') ?> <i class="fa fa-chevron-right small"></i></span>
									</h3>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
        </div>
    </section>
<?php endif ?>
<section class="py-5">
	<div class="container">
		<div class="h-100 p-5 gradient-primary text-white with-shapes rounded-4 border-0 text-start">
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