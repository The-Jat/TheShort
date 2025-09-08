<section id="hero" class="position-relative py-5">
	<img src="<?php echo assets('images/shapes.svg') ?>" class="img-fluid position-absolute top-0 start-0 w-100 h-100 animate-float opacity-50 zindex-0">
    <div class="container position-relative" data-offset-top="#navbar-main">
        <?php if(config('publicqr')): ?>
            <div class="d-block d-md-flex align-items-center">
                <div>
                    <h1 class="display-6 fw-bold mb-5">
                        <?php ee('Create QR Codes <br>for {t}', null, ['t' => '<strong class="gradient-primary clip-text">'.e('Free').'</strong>']) ?>
                    </h1>
                </div>
            </div>
            <form method="post" action="<?php echo route('qr.generateqr') ?>" class="card shadow-sm p-4 rounded w-100 mb-5">
                <?php echo csrf() ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="bg-primary d-inline-block mb-4 rounded-pill text-start p-1">
                            <span class="btn bg-white border rounded-pill text-dark py-1 px-3 fw-bold shadow-sm">
                                <?php ee('Static') ?>
                            </span>
                            <a href="<?php echo route('register') ?>" class="btn text-muted py-1" data-bs-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                <i class="fa fa-lock small me-1"></i> <span class="align-middle"><?php ee('Dynamic') ?> - <?php ee('Trackable') ?></span>
                            </a>
                        </div>
                        <div class="mb-2">
                            <a class="btn btn-transparent py-2 px-3 rounded-3 mb-2 me-1 border-success text-dark" data-trigger="switcher" href="#text"><i class="me-2 fa fa-font"></i> <?php ee('Text') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 me-1" data-trigger="switcher" href="#link"><i class="me-2 fa fa-link"></i> <?php ee('URL') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 me-1" data-trigger="switcher" href="#email"><i class="me-2 fa fa-envelope"></i> <?php ee('Email') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 me-1" data-trigger="switcher" href="#sms"><i class="me-2 fa fa-mobile"></i><?php ee('SMS') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 me-1" data-trigger="switcher" href="#phone"><i class="me-2 fa fa-phone"></i><?php ee('Call') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 me-1" data-trigger="switcher" href="#wifi"><i class="me-2 fa fa-wifi"></i> <?php ee('WiFi') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 me-1" data-trigger="switcher" href="#staticvcard"><i class="me-2 fa fa-user"></i> <?php ee('vCard') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 me-1" data-trigger="switcher" href="#event"><i class="me-2 fa fa-calendar"></i> <?php ee('Event') ?></a>
                        </div>
                        <div class="pe-md-5 pt-3">
                            <div class="switcher" id="text">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group">
                                        <label class="form-label fw-bold"><?php ee('Text') ?></label>
                                        <textarea class="form-control" name="text" placeholder="<?php ee('Your Text') ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse switcher" id="link">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group">
                                        <label class="form-label fw-bold"><?php ee('URL') ?></label>
                                        <input type="text" class="form-control p-2" name="link" placeholder="https://">
                                    </div>
                                </div>
                            </div>
                            <div class="collapse switcher" id="email">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Email') ?></label>
                                        <input type="email" class="form-control" name="email[email]" placeholder="e.g. someone@domain.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Subject') ?></label>
                                        <input type="text" class="form-control p-2" name="email[subject]" placeholder="e.g. <?php ee('Job Application') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fw-bold"><?php ee('Message') ?></label>
                                        <textarea class="form-control" name="email[body]" placeholder="e.g. <?php ee('Your message here to be sent as email') ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse switcher" id="phone">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group">
                                        <label class="form-label fw-bold"><?php ee('Phone Number') ?></label>
                                        <input type="text" class="form-control p-2" name="phone" placeholder="e.g. 123456789">
                                    </div>
                                </div>
                            </div>
                            <div class="collapse switcher" id="sms">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Phone Number') ?></label>
                                        <input type="text" class="form-control p-2" name="sms[phone]" placeholder="e.g 123456789">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fw-bold"><?php ee('Message') ?></label>
                                        <textarea class="form-control p-2" name="sms[message]" placeholder="e.g. <?php ee('Job Application') ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse switcher" id="staticvcard">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('First Name') ?></label>
                                        <input type="text" class="form-control p-2" name="staticvcard[fname]" placeholder="e.g. John">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Last Name') ?></label>
                                        <input type="text" class="form-control p-2" name="staticvcard[lname]" placeholder="e.g. Doe">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Organization') ?></label>
                                        <input type="text" class="form-control p-2" name="staticvcard[org]" placeholder="e.g. Internet Inc">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Phone') ?></label>
                                        <input type="text" class="form-control p-2" name="staticvcard[phone]" placeholder="e.g. +112345689">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Cell') ?></label>
                                        <input type="text" class="form-control p-2" name="staticvcard[cell]" placeholder="e.g. +112345689">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Fax') ?></label>
                                        <input type="text" class="form-control p-2" name="staticvcard[fax]" placeholder="e.g. +112345689">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Email') ?></label>
                                        <input type="email" class="form-control" name="staticvcard[email]" placeholder="e.g. someone@domain.com">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Website') ?></label>
                                        <input type="text" class="form-control p-2" name="staticvcard[site]" placeholder="e.g. https://domain.com">
                                    </div>
                                    <div class="btn-group ms-auto">
                                        <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-address">+ <?php ee('Address') ?></button>
                                        <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-social">+ <?php ee('Social') ?></button>
                                    </div>
                                    <div id="vcard-address" class="collapse">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('Street') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[street]" placeholder="e.g. 123 My Street">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('City') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[city]" placeholder="e.g. My City">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('State') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[state]" placeholder="e.g. My State">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('Zipcode') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[zip]" placeholder="e.g. 123456">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('Country') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[country]" placeholder="e.g. My Country">
                                        </div>
                                    </div>
                                    <div id="vcard-social" class="collapse">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('Facebook') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[facebook]" placeholder="e.g. https://www.facebook.com/myprofile">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('Twitter') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[twitter]" placeholder="e.g. https://www.twitter.com/myprofile">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('Instagram') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[instagram]" placeholder="e.g. https://www.instagram.com/myprofile">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold"><?php ee('Linekdin') ?></label>
                                            <input type="text" class="form-control p-2" name="staticvcard[linkedin]" placeholder="e.g. https://www.linkedin.com/myprofile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse switcher" id="wifi">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Network SSID') ?></label>
                                        <input type="text" class="form-control p-2" name="wifi[ssid]" placeholder="e.g 123456789">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Password') ?></label>
                                        <input type="text" class="form-control p-2" name="wifi[pass]" placeholder="Optional">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label fw-bold"><?php ee('Encryption') ?></label>
                                        <select name="wifi[encryption]" class="form-select">
                                            <option value="wep">WEP</option>
                                            <option value="wpa">WPA/WPA2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse switcher" id="event">
                                <div class="card p-3 rounded shadow-sm">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Title') ?></label>
                                        <input type="text" class="form-control p-2" name="event[title]" placeholder="">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Description') ?></label>
                                        <textarea class="form-control p-2" name="event[description]"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('Location') ?></label>
                                        <textarea class="form-control p-2" name="event[location]"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee('URL') ?></label>
                                        <input type="text" class="form-control p-2" name="event[url]" placeholder="">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold"><?php ee('Start') ?></label>
                                                <input type="datetime-local" class="form-control p-2" name="event[start]">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold"><?php ee('End') ?></label>
                                                <input type="datetime-local" class="form-control p-2" name="event[end]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-sm my-3">
                                <div class="p-3">
                                    <a href="" data-bs-toggle="collapse" class="text-decoration-none text-dark" role="button" data-bs-target="#colors">
                                        <h6 class="card-title fw-bold mb-0"><i class="fa fa-tint me-1"></i> <span class="align-middle"><?php ee('Customization') ?></span>
                                        </h6>
                                    </a>
                                </div>
                                <div class="card-body collapse" id="colors">
                                    <div class="p-3 border rounded mb-3">
                                        <div class="mb-5">
                                            <div class="d-flex bg-primary p-2 rounded-pill">
                                                <a href="#singlecolor" class="btn flex-fill shadow-sm bg-white border rounded-pill fw-bold active"><?php ee('Single Color') ?></a>
                                                <a href="<?php echo route('register') ?>" class="btn flex-fill text-muted" data-bs-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                    <i class="fa fa-lock small me-1"></i> <span class="align-middle"><?php ee('Gradient') ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold" for="bg"><?php ee("Background") ?></label><br>
                                                    <input type="text" name="bg" data-coloris value="#ffffff" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold" for="fg"><?php ee("Foreground") ?></label><br>
                                                    <input type="text" name="fg" data-coloris value="#000000" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 border rounded mb-3">
                                        <div class="form-group">
                                            <label class="fw-bold" for="logo"><?php ee('Logo') ?></label>
                                            <a href="<?php echo route('register') ?>" class="mt-3 d-block border bg-primary p-2 rounded-pill text-muted">
                                                <span class="btn bg-white rounded-pill"><?php ee('Upload logo') ?></span>
                                                <i class="fa fa-lock mx-2"></i> <span class="align-middle"><?php ee('Register to unlock this feature') ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-3 border rounded mb-3">
                                        <label class="fw-bold"><?php ee('Design') ?></label>
                                        <div class="d-flex bg-primary p-2 rounded-pill mt-3">
                                            <a href="<?php echo route('register') ?>" class="btn flex-fill text-muted" data-bs-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                <i class="fa fa-lock small me-1"></i> <span class="align-middle"><?php ee('Eye') ?>
                                            </a>
                                            <a href="<?php echo route('register') ?>" class="btn flex-fill text-muted" data-bs-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                <i class="fa fa-lock small me-1"></i> <span class="align-middle"><?php ee('Matrix') ?>
                                            </a>
                                            <a href="<?php echo route('register') ?>" class="btn flex-fill text-muted" data-bs-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                <i class="fa fa-lock small me-1"></i> <span class="align-middle"><?php ee('Frame') ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="type" value="text">
                            <button type="submit" class="btn btn-success mt-3 w-100 mb-3 mb-md-0"><?php ee('Generate') ?></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-sticky border rounded p-2">
                            <div id="return-ajax">
                                <img src="<?php echo \Helpers\QR::factory('Sample QR', 400, 0)->format('svg')->create('uri') ?>" class="img-responsive img-fluid rounded">
                            </div>
                            <div class="btn-group d-flex mt-3" role="group" aria-label="Basic example">
                                <button data-trigger="saveqr" data-format="svg" type="button" class="btn btn-transparent border text-dark flex-fill"><i class="fa fa-download me-1"></i> <span class="align-middle">SVG</span></button>
                                <button data-trigger="saveqr" data-format="png" type="button" class="btn btn-transparent border text-dark flex-fill"><i class="fa fa-download me-1"></i> <span class="align-middle">PNG</span></button>
                                <button data-trigger="saveqr" data-format="webp" type="button" class="btn btn-transparent border text-dark flex-fill"><i class="fa fa-download me-1"></i> <span class="align-middle">WEBP</span></button>
                            </div>
                            <p class="mt-3"><?php ee('Register to unlock advanced features such as Dynamic QR Codes, advanced QR Code customization and frames.') ?></p>
                            <a href="<?php echo route('register') ?>" class="btn btn-primary w-100"><?php ee('Register') ?></a>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="row align-items-center py-8 position-relative">
                <div class="col-md-7">
                    <h1 class="display-4 fw-bold mb-4">
                        <?php ee('QR Codes') ?>
                    </h1>
                    <p class="lead pe-5">
                        <?php ee('Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement.') ?>
                    </p>
                    <p class="my-5">
                        <a href="<?php echo route('register') ?>" class="btn btn-primary px-5 py-3 fw-bold"><?php ee('Get Started') ?></a>
                        <a href="<?php echo route('contact', ['subject' => 'Contact Sales']) ?>" class="btn btn-transparent text-dark fw-bold"><?php ee('Contact sales') ?></a>
                    </p>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="card gradient-primary shadow rounded-3 border-0">
                                <div class="px-4 py-5 text-center text-white">
                                    <div class="h1 mb-3">
                                        <i class="fa fa-qrcode fw-bolder"></i>
                                    </div>
                                    <h5 class="fw-bolder"><?php ee('Advanced QR Codes') ?></h5>
                                </div>
                            </div>
                            <div class="card shadow rounded-3 border-0 mt-5">
                                <div class="px-4 py-5 text-center text-primary">
                                    <div class="h1 mb-3">
                                        <i class="fa fa-eyedropper"></i>
                                    </div>
                                    <h5 class="fw-bolder"><?php ee('Customize Colors') ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pt-lg-5">
                            <div class="card shadow rounded-3 border-0 mt-5">
                                <div class="px-4 py-5 text-center text-dark">
                                    <div class="h1 mb-3">
                                        <i class="fa fa-map-pin"></i>
                                    </div>
                                    <h5 class="fw-bolder"><?php ee('Track Scans') ?></h5>
                                </div>
                            </div>
                            <div class="card gradient-primary-reverse shadow rounded-3 border-0 mt-5">
                                <div class="px-4 py-5 text-center text-white">
                                    <div class="h1 mb-3">
                                        <i class="fa fa-wand-magic-sparkles fw-bolder"></i>
                                    </div>
                                    <h5 class="fw-bolder"><?php ee('Customize Design & Frames') ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>
<section class="py-10">
    <div class="container">
        <div class="row row-grid justify-content-between align-items-center">
            <div class="col-lg-5 order-lg-2">
                <h5 class="h3 fw-bold"><?php ee('The new standard') ?>.</h5>
                <p class="lead my-4">
                    <?php ee('QR Codes are everywhere and they are not going away. They are a great asset to your company because you can easily capture users and convert them. QR codes can be customized to match your company, brand or product.') ?>
                </p>
                <ul class="list-unstyled mb-2">
                    <li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">									
									<i class="fa fa-map-location gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Dynamic QR codes') ?></span>
								<p><?php ee('Track QR code scans with our dynamic QR codes') ?></p>
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
								<span class="fw-bold"><?php ee('Customizable Design') ?></span>
								<p><?php ee('Customize the eye & the matrix') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="icon-md bg-primary d-flex align-items-center justify-content-center rounded-3">									
									<i class="fa fa-crop-simple gradient-primary clip-text fw-bolder"></i>
								</strong>
							</div>
							<div class="ms-3">
								<span class="fw-bold"><?php ee('Frames & Custom Logo') ?></span>
								<p><?php ee('Add your own logo and frame your QR code') ?></p>
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
								<span class="fw-bold"><?php ee('Custom Colors') ?></span>
								<p><?php ee('Customize colors to match your brand') ?></p>
							</div>
						</div>
					</li>
				</ul>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="d-flex mt-3">
                    <div class="border rounded p-2 shadow-sm">
                        <span class="icon-md d-block rounded-circle mb-2 mt-3" style="background-color: #0093E9;background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);"></span>
                        <span class="icon-md d-block rounded-circle mb-2" style="background-color: #00DBDE;background-image: linear-gradient(45deg, #00DBDE 0%, #FC00FF 100%);"></span>
                        <span class="icon-md d-block rounded-circle mb-2" style="background-color: #08AEEA;background-image: linear-gradient(0deg, #08AEEA 0%, #2AF598 100%);"></span>
                        <span class="icon-md d-block rounded-circle mb-2" style="background-color: #FFE53B;background-image: linear-gradient(147deg, #FFE53B 0%, #FF2525 74%);"></span>
                        <span class="icon-md d-block rounded-circle mb-2" style="background-color: #FF9A8B;background-image: linear-gradient(90deg, #FF9A8B 0%, #FF6A88 55%, #FF99AC 100%);"></span>
                        <span class="icon-md d-block rounded-circle" style="background-color: #F4D03F;background-image: linear-gradient(132deg, #F4D03F 0%, #16A085 100%);"></span>
                    </div>
                    <div class="flex-fill ms-3">
                        <div class="border rounded p-4 shadow-sm">
                            <h5 class="fw-bold mb-0"><i class="fa fa-link me-2 d-none d-md-inline"></i> <?php echo url('pricing') ?></h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="border rounded p-2 shadow-sm mt-3 d-none d-md-block">
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="30"><rect height="30" width="30" style="fill:rgb(255,255,255);stroke-width:8;stroke:rgb(0,0,0)"></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center"><svg width="30" height="30"><rect height="30" width="30" rx="8" ry="8" style="fill:rgb(0,0,0);"></rect><rect x="4" y="4" height="22" width="22" rx="5" ry="5" style="fill:rgb(255,255,255);"></rect></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center"><svg width="30" height="30"><circle cx="15" cy="15" r="12" fill="white" stroke="black" stroke-width="4"></circle></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="#ffffff"></rect><g transform="scale(4.2)"><g transform="translate(0,-14)"><path fill-rule="evenodd" d="M10 5M0 21C0 14 0 14 7 14M7 14C7 21 7 21 0 21ZM1 20C1 15 1 15 6 15M6 15C6 20 6 20 1 20M2 5z" fill="#000000"/></g></g><circle cx="15" cy="15" r="9" fill="white"></circle></svg></span>
                                <span class="icon-md d-block rounded-circle text-center"><svg width="30" height="30"><rect height="30" width="30" rx="8" ry="8" style="fill:rgb(0,0,0);"></rect><rect x="20" y="20" height="10" width="10" style="fill:rgb(0,0,0);"></rect><rect x="4" y="4" height="22" width="22" rx="5" ry="5" style="fill:rgb(255,255,255);"></rect><rect x="21" y="21" height="5" width="5" style="fill:rgb(255,255,255);"></rect></svg></span>
                            </div>
                            <div class="border rounded p-2 shadow-sm mt-3 ms-3 d-none d-md-block">
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="30"><rect x="5" y="5" height="20" width="20" style="fill:rgb(0,0,0);"></rect></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="30"><rect x="5" y="5" height="20" width="20" rx="6" ry="6" style="fill:rgb(0,0,0);"></rect></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="30"><circle cx="15" cy="15" r="10" fill="black"></circle></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="transparent"></rect><g transform="scale(6)"><g transform="translate(-1,-15)"><path fill-rule="evenodd" d="M10 20M2 19C2 16 2 16 5 16M5 16C5 19 5 19 2 19" fill="#000000"/></g></g></svg></span>
                                <span class="icon-md d-block rounded-circle text-center mt-2"><svg width="30" height="30"><rect x="5" y="5" height="20" width="20" rx="6" ry="6" style="fill:rgb(0,0,0);"></rect><rect x="17" y="17" height="8" width="8" style="fill:rgb(0,0,0);"></rect></svg></span>
                            </div>
                             <div class="border rounded p-2 shadow-sm mt-3 ms-3 d-none d-md-block">
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="15"><rect x="20" y="0" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect x="25" y="0" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect y="0" height="5" width="15" style="fill:rgb(0,0,0);"></rect><rect y="5" x="10" height="5" width="20" style="fill:rgb(0,0,0);"></rect></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="15"><rect x="19" y="0" rx="1" ry="1" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect x="25" y="0" rx="1" ry="1" height="5" width="5" style="fill:rgb(0,0,0);"></rect><rect y="0" rx="2" ry="2" height="5" width="15" style="fill:rgb(0,0,0);"></rect><rect y="3" x="10" rx="2" ry="2" height="5" width="20" style="fill:rgb(0,0,0);"></rect></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="15"><circle cx="2" cy="2" r="2" fill="black"></circle><circle cx="7" cy="2" r="2" fill="black"></circle><circle cx="12" cy="2" r="2" fill="black"></circle><circle cx="12" cy="7" r="2" fill="black"></circle><circle cx="17" cy="7" r="2" fill="black"></circle><circle cx="22" cy="7" r="2" fill="black"></circle><circle cx="22" cy="2" r="2" fill="black"></circle><circle cx="27" cy="2" r="2" fill="black"></circle><circle cx="27" cy="7" r="2" fill="black"></circle></svg></span>
                                <span class="icon-md d-block rounded-circle mb-2 text-center mt-2"><svg width="30" height="15"><rect x="0" y="0" width="3" height="3" transform="translate(3,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(8,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(13,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(13,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(18,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(23,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(23,0) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(28,5) rotate(45)" /><rect x="0" y="0" width="3" height="3" transform="translate(28,0) rotate(45)" /></svg></span>
                                <span class="icon-md d-block rounded-circle text-center mt-2"><svg version="1.0" xmlns="http://www.w3.org/2000/svg"width="30" height="15" viewBox="0 0 191 97"preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,97.000000) scale(0.100000,-0.100000)"fill="#000000" stroke="none"><path d="M549 897 c-41 -27 -59 -60 -59 -108 0 -44 30 -87 134 -189 l76 -75 106 106 c91 91 106 111 111 146 13 101 -96 177 -182 125 -29 -18 -31 -18 -60 0 -40 24 -85 23 -126 -5z"/><path d="M1503 900 c-44 -26 -67 -73 -60 -123 5 -35 20 -55 111 -146 l106 -106 76 75 c104 102 134 145 134 189 0 48 -18 81 -59 108 -41 28 -86 29 -126 5 -29 -18 -31 -18 -60 0 -39 23 -82 23 -122 -2z"/><path d="M61 415 c-16 -14 -35 -42 -42 -62 -20 -61 -1 -96 109 -206 l98 -97 107 108 c102 104 107 111 107 151 0 81 -48 131 -127 131 -21 0 -48 -7 -61 -15 -19 -14 -24 -14 -51 0 -46 24 -104 19 -140 -10z"/><path d="M548 423 c-41 -26 -62 -72 -55 -123 5 -38 17 -55 109 -147 l103 -103 97 97 c59 59 102 111 109 131 16 50 4 96 -37 131 -40 36 -95 41 -145 16 -27 -14 -32 -14 -51 0 -29 20 -96 19 -130 -2z"/><path d="M1019 417 c-23 -15 -38 -37 -47 -65 -13 -38 -12 -46 7 -84 11 -24 61 -83 111 -133 l90 -90 90 90 c50 50 100 109 111 133 19 38 20 46 7 84 -23 75 -125 115 -186 72 -20 -14 -24 -14 -44 0 -33 24 -99 20 -139 -7z"/><path d="M1486 409 c-41 -35 -53 -81 -37 -131 7 -20 50 -72 109 -131 l97 -97 103 103 c92 92 104 109 109 147 11 78 -44 140 -124 140 -21 0 -48 -7 -61 -15 -19 -14 -24 -14 -51 0 -50 25 -105 20 -145 -16z"/></g></svg></span>
                            </div>
                            <div class="ms-3 mt-3">
                                <img src="<?php echo \Helpers\QR::factory(url('pricing'), 300, 0)->module('circle')->eye('circle', 'rounded')->format('svg')->create('uri') ?>" class="img-responsive img-fluid rounded">
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
                    <?php ee('The beautify of QR codes is that almost any type of data can be encoded in them. Most types of data can be tracked very easily so you will know exactly when and from where a person scanned your QR code.') ?>
                </p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo assets('images/map.png') ?>" alt="<?php ee('Trackable to the dot') ?>" class="img-responsive w-100 py-5">
            </div>
        </div>
        <div class="h-100 p-5 mt-10 gradient-primary text-white with-shapes rounded-4 border-0 ">
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