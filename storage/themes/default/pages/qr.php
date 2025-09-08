<section class="slice slice-lg py-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
    <div class="container" data-offset-top="#navbar-main">
    <?php if(config('publicqr')): ?>
            <div class="d-block d-md-flex align-items-center">
                <div>
                    <h1 class="display-6 fw-bold mb-5 <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?>">
                        <?php ee('Create QR Codes <br>for {t}', null, ['t' => '<strong class="font-weight-bolder">Free</strong>']) ?>
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
                            <a href="<?php echo route('register') ?>" class="btn text-white py-1" data-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                <i class="fa fa-lock small mr-1"></i> <span class="align-middle"><?php ee('Dynamic') ?> - <?php ee('Trackable') ?></span>
                            </a>
                        </div>
                        <div class="mb-2">
                            <a class="btn btn-transparent py-2 px-3 rounded-3 mb-2 mr-1 border-success text-dark" data-trigger="switcher" href="#text"><i class="me-2 fa fa-font"></i> <?php ee('Text') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 mr-1" data-trigger="switcher" href="#link"><i class="me-2 fa fa-link"></i> <?php ee('URL') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 mr-1" data-trigger="switcher" href="#email"><i class="me-2 fa fa-envelope"></i> <?php ee('Email') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 mr-1" data-trigger="switcher" href="#sms"><i class="me-2 fa fa-mobile"></i><?php ee('SMS') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 mr-1" data-trigger="switcher" href="#phone"><i class="me-2 fa fa-phone"></i><?php ee('Call') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 mr-1" data-trigger="switcher" href="#wifi"><i class="me-2 fa fa-wifi"></i> <?php ee('WiFi') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 mr-1" data-trigger="switcher" href="#staticvcard"><i class="me-2 fa fa-user"></i> <?php ee('vCard') ?></a>
                            <a class="btn btn-transparent text-dark py-2 px-3 rounded-3 mb-2 mr-1" data-trigger="switcher" href="#event"><i class="me-2 fa fa-calendar"></i> <?php ee('Event') ?></a>
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
                                        <button type="button" class="btn btn-primary btn-sm text-white" data-toggle="collapse" data-target="#vcard-address">+ <?php ee('Address') ?></button>
                                        <button type="button" class="btn btn-primary btn-sm text-white" data-toggle="collapse" data-target="#vcard-social">+ <?php ee('Social') ?></button>
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
                                    <a href="" data-toggle="collapse" class="text-decoration-none text-dark" role="button" data-target="#colors">
                                        <h6 class="card-title fw-bold mb-0"><i class="fa fa-tint mr-1"></i> <span class="align-middle"><?php ee('Customization') ?></span>
                                        </h6>
                                    </a>
                                </div>
                                <div class="card-body collapse" id="colors">
                                    <div class="p-3 border rounded mb-3">
                                        <div class="mb-5">
                                            <div class="d-flex bg-primary p-2 rounded-pill">
                                                <a href="#singlecolor" class="btn flex-fill shadow-sm bg-white border rounded-pill fw-bold active"><?php ee('Single Color') ?></a>
                                                <a href="<?php echo route('register') ?>" class="btn flex-fill text-white" data-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                    <i class="fa fa-lock small mr-1"></i> <span class="align-middle"><?php ee('Gradient') ?>
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
                                            <a href="<?php echo route('register') ?>" class="mt-3 d-block border bg-primary p-2 rounded-pill text-white">
                                                <span class="btn bg-white rounded-pill"><?php ee('Upload logo') ?></span>
                                                <i class="fa fa-lock mx-2"></i> <span class="align-middle"><?php ee('Register to unlock this feature') ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-3 border rounded mb-3">
                                        <label class="fw-bold"><?php ee('Design') ?></label>
                                        <div class="d-flex bg-primary p-2 rounded-pill mt-3">
                                            <a href="<?php echo route('register') ?>" class="btn flex-fill text-white" data-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                <i class="fa fa-lock small mr-1"></i> <span class="align-middle"><?php ee('Eye') ?>
                                            </a>
                                            <a href="<?php echo route('register') ?>" class="btn flex-fill text-white" data-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                <i class="fa fa-lock small mr-1"></i> <span class="align-middle"><?php ee('Matrix') ?>
                                            </a>
                                            <a href="<?php echo route('register') ?>" class="btn flex-fill text-white" data-toggle="tooltip" title="<?php ee('Register to unlock this feature') ?>">
                                                <i class="fa fa-lock small mr-1"></i> <span class="align-middle"><?php ee('Frame') ?>
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
                                <button data-trigger="saveqr" data-format="svg" type="button" class="btn btn-transparent border text-dark flex-fill"><i class="fa fa-download mr-1"></i> <span class="align-middle">SVG</span></button>
                                <button data-trigger="saveqr" data-format="png" type="button" class="btn btn-transparent border text-dark flex-fill"><i class="fa fa-download mr-1"></i> <span class="align-middle">PNG</span></button>
                                <button data-trigger="saveqr" data-format="webp" type="button" class="btn btn-transparent border text-dark flex-fill"><i class="fa fa-download mr-1"></i> <span class="align-middle">WEBP</span></button>
                            </div>
                            <p class="mt-3"><?php ee('Register to unlock advanced features such as Dynamic QR Codes, advanced QR Code customization and frames.') ?></p>
                            <a href="<?php echo route('register') ?>" class="btn btn-primary w-100"><?php ee('Register') ?></a>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
        <div class="row align-items-center py-8">
            <div class="col-md-7">
                <h1 class="display-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> font-weight-bolder mb-4">
                    <?php ee('QR Codes') ?>
                </h1>                    
                <p class="lead <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> opacity-8">
                    <?php ee('Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement.') ?>
                </p>  
                <p class="my-5">
                    <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Get Started') ?></a>
                    <a href="<?php echo route('contact') ?>" class="btn btn-secondary"><?php ee('Contact us') ?></a>
                </p>              
            </div>
            <div class="col-md-5 text-center">
                <div class="row">
                    <div class="col-6">
                        <div class="card bg-primary shadow rounded-3 border-0">
                            <div class="px-4 py-5 text-center text-white">
                                <div class="h1 mb-3">
                                    <i class="fa fa-qrcode fw-bolder"></i>
                                </div>
                                <h5 class="fw-bolder text-white"><?php ee('Advanced QR Codes') ?></h5>
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
                        <div class="card bg-primary shadow rounded-3 border-0 mt-5">
                            <div class="px-4 py-5 text-center text-white">
                                <div class="h1 mb-3">
                                    <i class="fa fa-wand-magic-sparkles fw-bolder"></i>
                                </div>
                                <h5 class="fw-bolder text-white"><?php ee('Customize Design & Frames') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        <?php endif ?>
    </div>
</section>
<section class="slice">
    <div class="container">
        <div class="section-process-step">
            <div class="row row-grid justify-content-between align-items-center">
                <div class="col-lg-5 order-lg-2">
                    <h5 class="h3"><?php ee('The new standard') ?>.</h5>
                    <p class="lead my-4">
                        <?php ee('QR Codes are everywhere and they are not going away. They are a great asset to your company because you can easily capture users and convert them. QR codes can be customized to match your company, brand or product.') ?>
                    </p>
                    <ul class="list-unstyled mb-2">
                    <li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="text-primary">									
									<i class="fa fa-map-location fw-bolder"></i>
								</strong>
							</div>
							<div class="ml-3">
								<span class="fw-bold"><?php ee('Dynamic QR codes') ?></span>
								<p><?php ee('Track QR code scans with our dynamic QR codes') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="text-primary">									
									<i class="fa fa-sliders fw-bolder"></i>
								</strong>
							</div>
							<div class="ml-3">
								<span class="fw-bold"><?php ee('Customizable Design') ?></span>
								<p><?php ee('Customize the eye & the matrix') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="text-primary">									
									<i class="fa fa-crop-simple fw-bolder"></i>
								</strong>
							</div>
							<div class="ml-3">
								<span class="fw-bold"><?php ee('Frames & Custom Logo') ?></span>
								<p><?php ee('Add your own logo and frame your QR code') ?></p>
							</div>
						</div>
					</li>
					<li class="mb-4">
						<div class="d-flex">
							<div>
								<strong class="text-primary">									
									<i class="fa fa-droplet fw-bolder"></i>
								</strong>
							</div>
							<div class="ml-3">
								<span class="fw-bold"><?php ee('Custom Colors') ?></span>
								<p><?php ee('Customize colors to match your brand') ?></p>
							</div>
						</div>
					</li>
				</ul>
                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-sm"><?php ee('Get Started') ?></a>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="card mb-0 shadow-sm mr-lg-5">
                        <div class="card-body p-2">
                            <img src="<?php echo assets('images/qrcodes.png') ?>" alt="<?php ee('The new standard') ?>" class="img-responsive w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-process-step">
            <div class="row row-grid justify-content-between align-items-center">
                <div class="col-lg-5">
                    <h5 class="h3"><?php ee('Trackable to the dot') ?>.</h5>
                    <p class="lead my-4">
                        <?php ee('The beautify of QR codes is that almost any type of data can be encoded in them. Most types of data can be tracked very easily so you will know exactly when and from where a person scanned your QR code.') ?>
                    </p>
                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-sm"><?php ee('Get Started') ?></a>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-0 shadow-sm ml-lg-5">
                        <div class="card-body p-2">
                            <img src="<?php echo assets('images/map.png') ?>" alt="<?php ee('Trackable to the dot') ?>" class="img-responsive w-100 py-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   