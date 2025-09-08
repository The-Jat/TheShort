<form action="<?php echo route('qr.update', [$qr->id]) ?>" method="post" data-trigger="saveqr" enctype="multipart/form-data">
    <div class="d-flex mb-5">
        <h1 class="fw-bold h3 mb-0"><?php ee('Edit QR') ?></h1>
    </div>
    <?php echo csrf() ?>
    <input type="hidden" name="type" value="<?php echo $qr->data->type ?>">
    <div class="row">
        <div class="col-md-7">
            <div class="card rounded-4 card-body shadow-sm">
                <div class="form-group">
                    <label for="text" class="form-label fw-bold"><?php ee('QR Code Name') ?></label>
                    <input type="text" class="form-control p-2" name="name" value="<?php echo $qr->name ?>" placeholder="e.g. For Instagram">
                </div>
                <?php if($domains): ?>
                    <div class="form-group input-select mt-4">
                        <label class="form-label fw-bold d-block"><?php ee('Domain') ?></label>
                        <small class="text-danger d-block mb-2"><?php ee('If you change the domain name, the QR code will change!') ?></small>
                        <select name="domain" id="domain" class="form-control p-2" data-toggle="select">
                            <?php foreach($domains as $domain): ?>
                                <option value="<?php echo $domain ?>" <?php echo $url && $url->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                            <?php endforeach ?>
                        </select>
                        <p class="form-text"><?php ee('Choose domain to generate the link with when using dynamic QR codes. Not applicable for static QR codes.') ?></p>
                    </div>
                <?php endif ?>
            </div>
            <div class="card rounded-4 shadow-sm" id="qrbuilder">
                <?php if($qr->data->type == 'text'): ?>
                <div id="text">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="type"></i> <?php ee('Text') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label fw-bold"><?php ee('Your Text') ?></label>
                            <textarea class="form-control p-2" name="text" placeholder="<?php ee('Your Text') ?>"><?php echo $qr->data->data ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'link'): ?>
                <div id="link">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="link"></i> <?php ee('Link') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label fw-bold"><?php ee('Your Link') ?></label>
                            <input type="text" class="form-control p-2" name="link" value="<?php echo $qr->data->data ?>" placeholder="https://">
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'email'): ?>
                <div id="email">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="mail"></i> <?php ee('Email') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Email') ?></label>
                            <input type="email" class="form-control p-2" name="email[email]" value="<?php echo $qr->data->data->email ?>" placeholder="e.g. someone@domain.com">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Subject') ?></label>
                            <input type="text" class="form-control p-2" name="email[subject]" value="<?php echo $qr->data->data->subject ?>" placeholder="e.g. <?php ee('Job Application') ?>">
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label fw-bold"><?php ee('Message') ?></label>
                            <textarea class="form-control" name="email[body]" placeholder="e.g. <?php ee('Your message here to be sent as email') ?>"><?php echo $qr->data->data->body ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'phone'): ?>
                <div id="phone">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="phone"></i> <?php ee('Phone') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="text" class="form-label fw-bold"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="phone" value="<?php echo $qr->data->data ?>" placeholder="e.g. 123456789">
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'sms'): ?>
                <div id="sms">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="smartphone"></i> <?php ee('SMS & Message') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="sms[phone]" value="<?php echo $qr->data->data->phone ?>" placeholder="e.g 123456789">
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label fw-bold"><?php ee('Message') ?></label>
                            <input type="text" class="form-control p-2" name="sms[message]" value="<?php echo $qr->data->data->message ?>" placeholder="e.g. Job Application">
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'smsonly'): ?>
                <div id="sms">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="smartphone"></i> <?php ee('SMS') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="smsonly[phone]" value="<?php echo $qr->data->data->phone ?>" placeholder="e.g 123456789">
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold"><?php ee('Message') ?></label>
                            <textarea class="form-control p-2" name="smsonly[message]" placeholder="e.g. <?php ee('Job Application') ?>"><?php echo $qr->data->data->message ?? '' ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'whatsapp'): ?>
                <div id="whatsapp">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="smartphone"></i> <?php ee('Whatsapp') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Phone Number') ?></label>
                            <input type="text" class="form-control p-2" name="whatsapp[phone]" value="<?php echo $qr->data->data->phone ?>" placeholder="e.g +123456789">
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label fw-bold"><?php ee('Message') ?></label>
                            <textarea class="form-control" name="whatsapp[body]"  placeholder="e.g. <?php ee('Your Text') ?>"><?php echo $qr->data->data->body ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'vcard'): ?>
                <div id="vcard">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="user"></i> <?php ee('vCard') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Picture') ?></label>
                            <input type="file" class="form-control p-2" name="vcard">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('First Name') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[fname]" value="<?php echo $qr->data->data->fname ?>" placeholder="e.g. John">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Last Name') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[lname]" value="<?php echo $qr->data->data->lname ?>" placeholder="e.g. Doe">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Organization') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[org]" value="<?php echo $qr->data->data->org ?>" placeholder="e.g. Internet Inc">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Phone') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[phone]" value="<?php echo $qr->data->data->phone ?>" placeholder="e.g. +112345689">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('Cell') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[cell]"  value="<?php echo $qr->data->data->cell ?>" placeholder="e.g. +112345689">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('Fax') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[fax]"  value="<?php echo $qr->data->data->fax ?>" placeholder="e.g. +112345689">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Email') ?></label>
                            <input type="email" class="form-control p-2" name="vcard[email]" value="<?php echo $qr->data->data->email ?>" placeholder="e.g. someone@domain.com">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Website') ?></label>
                            <input type="text" class="form-control p-2" name="vcard[site]" value="<?php echo $qr->data->data->site ?>" placeholder="e.g. https://domain.com">
                        </div>
                        <div class="btn-group ms-auto">
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-address">+ <?php ee('Address') ?></button>
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#vcard-social">+ <?php ee('Social') ?></button>
                        </div>
                        <div id="vcard-address" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Street') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[street]" value="<?php echo $qr->data->data->street ?>" placeholder="e.g. 123 My Street">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('City') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[city]" value="<?php echo $qr->data->data->city ?>" placeholder="e.g. My City">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('State') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[state]" value="<?php echo $qr->data->data->state ?>" placeholder="e.g. My State">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Zipcode') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[zip]" value="<?php echo $qr->data->data->zip ?>" placeholder="e.g. 123456">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Country') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[country]" value="<?php echo $qr->data->data->country ?>" placeholder="e.g. My Country">
                            </div>
                        </div>
                        <div id="vcard-social" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Facebook') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[facebook]" value="<?php echo $qr->data->data->facebook ?>" placeholder="e.g. https://www.facebook.com/myprofile">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Twitter') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[twitter]" value="<?php echo $qr->data->data->twitter ?>" placeholder="e.g. https://www.twitter.com/myprofile">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Instagram') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[instagram]" value="<?php echo $qr->data->data->instagram ?>" placeholder="e.g. https://www.instagram.com/myprofile">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Linkedin') ?></label>
                                <input type="text" class="form-control p-2" name="vcard[linkedin]" value="<?php echo $qr->data->data->linkedin ?>" placeholder="e.g. https://www.linkedin.com/myprofile">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'staticvcard'): ?>
                <div id="staticvcard">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="user"></i> <?php ee('vCard') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('First Name') ?></label>
                            <input type="text" class="form-control p-2" name="staticvcard[fname]" value="<?php echo $qr->data->data->fname ?>" placeholder="e.g. John">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Last Name') ?></label>
                            <input type="text" class="form-control p-2" name="staticvcard[lname]" value="<?php echo $qr->data->data->lname ?>" placeholder="e.g. Doe">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Organization') ?></label>
                            <input type="text" class="form-control p-2" name="staticvcard[org]" value="<?php echo $qr->data->data->org ?>" placeholder="e.g. Internet Inc">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Phone') ?></label>
                            <input type="text" class="form-control p-2" name="staticvcard[phone]" value="<?php echo $qr->data->data->phone ?>" placeholder="e.g. +112345689">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('Cell') ?></label>
                            <input type="text" class="form-control p-2" name="staticvcard[cell]" placeholder="e.g. +112345689" value="<?php echo $qr->data->data->cell ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('Fax') ?></label>
                            <input type="text" class="form-control p-2" name="staticvcard[fax]" placeholder="e.g. +112345689" value="<?php echo $qr->data->data->fax ?>">
                        </div>                        
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Email') ?></label>
                            <input type="email" class="form-control p-2" name="staticvcard[email]" value="<?php echo $qr->data->data->email ?>" placeholder="e.g. someone@domain.com">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Website') ?></label>
                            <input type="text" class="form-control p-2" name="staticvcard[site]" value="<?php echo $qr->data->data->site ?>" placeholder="e.g. https://domain.com">
                        </div>
                        <div class="btn-group ms-auto">
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#staticvcard-address">+ <?php ee('Address') ?></button>
                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#staticvcard-social">+ <?php ee('Social') ?></button>
                        </div>
                        <div id="staticvcard-address" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Street') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[street]" value="<?php echo $qr->data->data->street ?>" placeholder="e.g. 123 My Street">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('City') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[city]" value="<?php echo $qr->data->data->city ?>" placeholder="e.g. My City">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('State') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[state]" value="<?php echo $qr->data->data->state ?>" placeholder="e.g. My State">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Zipcode') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[zip]" value="<?php echo $qr->data->data->zip ?>" placeholder="e.g. 123456">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Country') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[country]" value="<?php echo $qr->data->data->country ?>" placeholder="e.g. My Country">
                            </div>
                        </div>
                        <div id="staticvcard-social" class="collapse">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Facebook') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[facebook]" value="<?php echo $qr->data->data->facebook ?>" placeholder="e.g. https://www.facebook.com/myprofile">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Twitter') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[twitter]" value="<?php echo $qr->data->data->twitter ?>" placeholder="e.g. https://www.twitter.com/myprofile">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Instagram') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[instagram]" value="<?php echo $qr->data->data->instagram ?>" placeholder="e.g. https://www.instagram.com/myprofile">
                            </div>
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-bold"><?php ee('Linekdin') ?></label>
                                <input type="text" class="form-control p-2" name="staticvcard[linkedin]" value="<?php echo $qr->data->data->linkedin ?>" placeholder="e.g. https://www.linkedin.com/myprofile">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'wifi'): ?>
                <div id="wifi">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="wifi"></i> <?php ee('WiFi') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Network SSID') ?></label>
                            <input type="text" class="form-control p-2" name="wifi[ssid]" placeholder="e.g 123456789" value="<?php echo $qr->data->data->ssid ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php ee('Password') ?></label>
                            <input type="text" class="form-control p-2" name="wifi[pass]" placeholder="Optional" value="<?php echo $qr->data->data->pass ?>">
                        </div>
                        <div class="form-group">
                            <label for="text" class="form-label fw-bold"><?php ee('Encryption') ?></label>
                            <select name="wifi[encryption]" class="form-select">
                                <option value="wep" <?php echo $qr->data->data->encryption == "wep" ? 'selected' : '' ?>>WEP</option>
                                <option value="wpa" <?php echo $qr->data->data->encryption == "wpa" ? 'selected' : '' ?>>WPA/WPA2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type == 'crypto'): ?>
                <div id="sms">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="smartphone"></i> <?php ee('Cryptocurrency') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <p><?php ee('Cryptocurrency') ?></p>
                            <label class="me-3">
                                <input type="radio" name="crypto[currency]" value="btc" <?php echo $qr->data->data->currency == 'btc' ? 'checked' : '' ?>> <?php ee('Bitcoin') ?>
                            </label>
                            <label class="me-3">
                                <input type="radio" name="crypto[currency]" value="eth" <?php echo $qr->data->data->currency == 'eth' ? 'checked' : '' ?>> <?php ee('Ethereum') ?>
                            </label>
                            <label class="me-3">
                                <input type="radio" name="crypto[currency]" value="bch" <?php echo $qr->data->data->currency == 'bch' ? 'checked' : '' ?>> <?php ee('Bitcoin Cash') ?>
                            </label>
                        </div>
                        <div class="form-group mb-3">
                            <label for="text" class="form-label fw-bold"><?php echo strtoupper($qr->data->data->currency) ?> <?php ee('Wallet Address') ?></label>
                            <input type="text" class="form-control p-2" name="crypto[wallet]" value="<?php echo $qr->data->data->wallet ?>" placeholder="">
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <?php if($qr->data->type =='file'): ?>
                    <div class="card-header bg-transparent">
                        <div class="d-flex">
                            <h5 class="card-title fw-bold"><i class="me-2 fa fa-file"></i> <?php ee('File Upload (Image or PDF)') ?></h5>
                            <div class="ms-auto">
                                <a href="<?php echo uploads('files/'.$qr->data->data, 'qr') ?>" class="btn btn-primary rounded-3 px-3 py-2" target="_blank"><?php ee('View File') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><?php ee('This can be used to upload an image or a PDF. Most common uses are restaurant menu, promotional poster and resume.') ?></p>
                        <div class="form-group mb-3">
                            <label for="file" class="form-label fw-bold"><?php ee('File') ?></label>
                            <input type="file" class="form-control p-2" name="file" accept=".jpg, .jpeg, .png, .gif, .pdf">
                            <p class="form-text"><?php ee('Acceptable file: jpg, png, gif, pdf. Max {d}MB.', null, ['d' => round(appConfig('app.sizes')['qrfile'] /1024, 0)]) ?></p>
                        </div>
                    </div>
                <?php endif ?>
                <?php if($qr->data->type == 'event'): ?>
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2" data-feather="calendar"></i> <?php ee('Event') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('Title') ?></label>
                            <input type="text" class="form-control p-2" name="event[title]" placeholder="" value="<?php echo $qr->data->data->title ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('Description') ?></label>
                            <textarea class="form-control p-2" name="event[description]"><?php echo $qr->data->data->description ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('Location') ?></label>
                            <textarea class="form-control p-2" name="event[location]"><?php echo $qr->data->data->location ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold"><?php ee('URL') ?></label>
                            <input type="text" class="form-control p-2" name="event[url]" placeholder="" value="<?php echo $qr->data->data->url ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold"><?php ee('Start') ?></label>
                                    <input type="datetime-local" class="form-control p-2" name="event[start]" value="<?php echo $qr->data->data->start ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold"><?php ee('End') ?></label>
                                    <input type="datetime-local" class="form-control p-2" name="event[end]" value="<?php echo $qr->data->data->end ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
                <?php if($qr->data->type == 'application'): ?>
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><i class="me-2 fab fa-apple"></i> <?php ee('Application') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold fw-bold"><?php ee('Link to App Store') ?></label>
                            <input type="text" class="form-control p-2" name="application[apple]" placeholder="https://" value="<?php echo $qr->data->data->apple ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold fw-bold"><?php ee('Link to Google Play') ?></label>
                            <input type="text" class="form-control p-2" name="application[google]" placeholder="https://" value="<?php echo $qr->data->data->google ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold fw-bold"><?php ee('Link for others') ?>*</label>
                            <input type="text" class="form-control p-2" name="application[link]" placeholder="https://" value="<?php echo $qr->data->data->link ?>">
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <div class="card rounded-4 shadow-sm">
				<div class="card-header bg-transparent mt-2">
                    <a href="" data-bs-toggle="collapse" class="text-decoration-none" role="button" data-bs-target="#templates"><h5 class="card-title fw-bold"><i class="fa fa-magic fa-lg me-2"></i> <span class="align-middle"><?php ee('Templates') ?></span></h5></a>
                </div>
                <div class="card-body collapse" id="templates">
                    <div class="d-flex overflow-auto" data-toggle="buttons">
                        <label class="d-block btn text-center border border-2 border-secondary rounded-3 p-3 me-1 col-md-3 flex-shrink-0 mx-2" style="min-width: 200px;"for="template0">
                            <input class="form-check-input d-none" type="radio" name="template" value="0" id="template0" checked>
                            <img src="<?php echo route('qr.generate', [$qr->alias]) ?>" class="img-responsive img-fluid mb-2">
                            <?php ee('Your Design') ?>
                        </label>
                        <?php foreach($templates as $template): ?>
                            <label class="d-block btn text-center border border-2 rounded-3 p-3 me-1 col-md-3 flex-shrink-0 mx-2" style="min-width: 200px;" for="template<?php echo $template->id ?>">
                                <input class="form-check-input d-none" type="radio" name="template" value="<?php echo $template->id ?>" id="template<?php echo $template->id ?>">
                                <img src="<?php echo uploads($template->filename, 'qr') ?>" class="img-responsive img-fluid mb-2">
                                <?php echo $template->name ?>
                            </label>
                        <?php endforeach ?>
                    </div>
                </div>				
            </div>
            <div class="card rounded-4 shadow-sm">
                <div class="card-header bg-transparent mt-2">
                    <a href="" data-bs-toggle="collapse" class="text-decoration-none" role="button" data-bs-target="#colors"><h5 class="card-title fw-bold"><i class="fa fa-tint fa-lg me-3"></i> <span class="align-middle"><?php ee('Colors') ?></span></h5></a>
				</div>
				<div class="card-body collapse" id="colors">
                    <?php if(\Helpers\QR::hasImagick()): ?>
                    <div class="mb-3">
                        <div class="d-flex bg-light p-2 rounded-3" data-toggle="multibuttons">
                            <a href="#singlecolor" class="btn flex-fill <?php echo isset($qr->data->color) ? 'shadow-sm bg-white border rounded-3 fw-bold active' : '' ?>" data-trigger="color" data-bs-parent="#colors"><?php ee('Single Color') ?></a>
                            <a href="#gradient" class="btn flex-fill <?php echo isset($qr->data->gradient) ? 'shadow-sm bg-white border rounded-3 flex-fill fw-bold' : '' ?>" data-trigger="color" data-bs-parent="#colors"><?php ee('Gradient Color') ?></a>
                        </div>
                    </div>
                    <?php endif ?>
                    <div id="singlecolor" class="collapse <?php echo isset($qr->data->color) ? 'show' : '' ?> p-3 border rounded mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold" for="bg"><?php ee("Background") ?></label><br>
                                    <input type="text" name="bg" id="bg" value="<?php echo isset($qr->data->color) ? $qr->data->color->bg : 'rgb(255,255,255)' ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold" for="fg"><?php ee("Foreground") ?></label><br>
                                    <input type="text" name="fg" id="fg" value="<?php echo isset($qr->data->color) ? $qr->data->color->fg : 'rgb(0,0,0)' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(\Helpers\QR::hasImagick()): ?>
                        <div id="gradient" class="collapse <?php echo isset($qr->data->gradient) ? 'show' : '' ?> p-3 border rounded mb-3">
                            <input type="hidden" name="mode" value="<?php echo isset($qr->data->gradient) ? 'gradient' : 'simple' ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="bg"><?php ee("Background") ?></label><br>
                                        <input type="text" name="gradient[bg]" id="gbg" value="<?php echo isset($qr->data->gradient) ? $qr->data->gradient[1] : 'rgb(255,255,255)' ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col form-group mb-3">
                                            <label class="form-label fw-bold" for="fg"><?php ee("Gradient Start") ?></label><br>
                                            <input type="text" name="gradient[start]" id="gfg" value="<?php echo isset($qr->data->gradient) ? $qr->data->gradient[0][0] : 'rgb(0,0,0)' ?>">
                                        </div>
                                        <div class="col form-group mb-3">
                                            <label class="form-label fw-bold" for="fgs"><?php ee("Gradient Stop") ?></label><br>
                                            <input type="text" name="gradient[stop]" id="gfgs" value="<?php echo isset($qr->data->gradient) ? $qr->data->gradient[0][1] : 'rgb(0,0,0)' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="fgd"><?php ee("Gradient Direction") ?></label><br>
                                        <select name="gradient[direction]" id="gfgd" class="form-select">
                                            <option value="vertical" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "vertical" ? 'selected' : '' ?>><?php ee('Vertical') ?></option>
                                            <option value="horizontal" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "horizontal" ? 'selected' : '' ?>><?php ee('Horizontal') ?></option>
                                            <option value="radial" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "radial" ? 'selected' : '' ?>><?php ee('Radial') ?></option>
                                            <option value="diagonal" <?php echo isset($qr->data->gradient) && $qr->data->gradient[2] == "diagonal" ? 'selected' : '' ?>><?php ee('Diagonal') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 border rounded">
                            <div class="col form-group mb-3">
                                <label class="form-label fw-bold"><?php ee("Eye Frame Color") ?></label><br>
                                <input type="text" name="eyeframecolor" id="eyeframecolor" value="<?php echo $qr->data->eyeframecolor ?? '' ?>">
                            </div>
                            <div class="col form-group mb-3">
                                <label class="form-label fw-bold" for="fgs"><?php ee("Eye Color") ?></label><br>
                                <input type="text" name="eyecolor" id="eyecolor" value="<?php echo $qr->data->eyecolor ?? '' ?>">
                            </div>
                        </div>
                    <?php endif ?>
				</div>
			</div>
            <div class="card rounded-4 shadow-sm">
                <div class="card-header bg-transparent mt-2">
                    <a href="" data-bs-toggle="collapse" class="text-decoration-none" role="button" data-bs-target="#design"><h5 class="card-title fw-bold"><i class="fa fa-magic fa-lg me-3"></i> <span class="align-middle"><?php ee('Design') ?></span></h5></a>
				</div>
				<div class="card-body collapse" id="design">
                    <div class="p-3 border rounded mb-3">
                        <?php if(user()->has('qrlogo')): ?>
                        <div class="mb-4" data-toggle="buttons">
                            <label class="btn text-center border rounded <?php echo !isset($qr->data->definedlogo) && !isset($qr->data->custom) ? 'border-secondary' : '' ?> p-3 me-1" style="height:58px">
                                <input type="radio" name="selectlogo" value="none" class="d-none" <?php echo !isset($qr->data->definedlogo) && !isset($qr->data->custom) ? 'checked' : '' ?>>
                                <i data-feather="x"></i>
                            </label>
                            <label class="btn text-center border <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'instagram.png' ? 'border-secondary' : '' ?> rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="instagram" class="d-none" <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'instagram.png' ? 'checked' : '' ?>>
                                <img src="<?php echo assets('images/instagram.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'facebook.png' ? 'border-secondary' : '' ?> rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="facebook" class="d-none" <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'facebook.png' ? 'checked' : '' ?>>
                                <img src="<?php echo assets('images/facebook.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'youtube.png' ? 'border-secondary' : '' ?> rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="youtube" class="d-none" <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'youtube.png' ? 'checked' : '' ?>>
                                <img src="<?php echo assets('images/youtube.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'twitter.png' ? 'border-secondary' : '' ?> rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="twitter" class="d-none" <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'twitter.png' ? 'checked' : '' ?>>
                                <img src="<?php echo assets('images/twitter.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'tiktok.png' ? 'border-secondary' : '' ?> rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="tiktok" class="d-none" <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'tiktok.png' ? 'checked' : '' ?>>
                                <img src="<?php echo assets('images/tiktok.png') ?>" class="img-fluid" width="40">
                            </label>
                            <label class="btn text-center border <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'linkedin.png' ? 'border-secondary' : '' ?> rounded p-2 h-100 me-1">
                                <input type="radio" name="selectlogo" value="linkedin" class="d-none" <?php echo isset($qr->data->definedlogo) && $qr->data->definedlogo == 'linkedin.png' ? 'checked' : '' ?>>
                                <img src="<?php echo assets('images/linkedin.png') ?>" class="img-fluid" width="40">
                            </label>
                            <?php if(isset($qr->data->custom)): ?>
                                <label class="btn text-center border border-secondary rounded p-2 h-100 me-1">
                                <img src="<?php echo url('content/qr/'.$qr->data->custom) ?>" class="img-fluid" width="40" height="40">
                            </label>
                            <?php endif ?>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold" for="logo"><?php ee("Custom Logo") ?></label>
                            <input type="file" class="form-control" name="logo" id="logo">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold d-block mb-2"><?php ee("Size") ?></label>
                            <input type="range" name="logosize" min="50" max="500" class="form-range" value="<?php echo $qr->data->logosize ?? '' ?>">
                        </div>
                        <div class="form-group mt-4">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <label class="form-check-label fw-bold" for="punched"><?php ee('Embedded Logo') ?></label>
                                    <p class="form-text"><?php ee('Logo can now be embedded in the QR code. Please note that embedded logos can sometimes lead to unstable QR codes so please check to make sure the QR works.') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input" type="checkbox" data-binary="true" id="punched" name="punched" value="1" <?php echo isset($qr->data->punchedlogo) && $qr->data->punchedlogo ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block"><?php ee("Custom Logo") ?></label>
                                <a href="<?php echo route('pricing') ?>" class="mt-3 d-block border p-2 rounded-pill text-muted">
                                    <span class="btn bg-primary rounded-pill text-white"><i class="fa fa-lock mx-2"></i>  <?php ee('Upgrade') ?></span>
                                    <span class="align-middle ms-1"><?php ee('Upgrade to unlock this feature') ?></span>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                    <?php if(\Helpers\QR::hasImagick()): ?>
                        <div class="p-3 border rounded mb-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block" for="fgd"><?php ee("Matrix Style") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'square' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="0" y="0" height="30" width="30" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="matrix" value="square" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'square' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'circle' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="0" y="0" rx="10" ry="10" height="30" width="30" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="matrix" value="circle" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'circle' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'splash' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="5" y="0" rx="20" ry="10" height="30" width="20" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="matrix" value="splash" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'splash' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'hexagon' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><g transform="scale(5.0) translate(-2.5 -1.5)"><path d="M4,2 L7,2 L8.5,4.5 L7,7 L4,7 L2.5,4.5 Z" fill="black"></path></g></svg>
                                        <input type="radio" name="matrix" value="hexagon" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'hexagon' ? 'checked' : '' ?>>
                                    </label>                                      
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'dot' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><circle cx="15" cy="15" r="15" fill="black"></circle></svg>
                                        <input type="radio" name="matrix" value="dot" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'dot' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'diamond' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="0" y="0" width="20" height="20" transform="translate(15 0) rotate(45)"></rect></svg>
                                        <input type="radio" name="matrix" value="diamond" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'diamond' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'heart' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30" viewBox="0 0 30 30"><path d="M15 25C15 25 4 16 4 10C4 6 7 4 10 4C13 4 15 6 15 6C15 6 17 4 20 4C23 4 26 6 26 10C26 16 15 25 15 25Z" style="fill:rgb(0,0,0);" /></svg>
                                        <input type="radio" name="matrix" value="heart" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'heart' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'squarespace' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="5" y="10" rx="1" ry="1" height="10" width="10" fill="black"></rect><rect x="16" y="10" r="" rx="1" ry="1" height="10" width="10" fill="black"></rect></svg>
                                        <input type="radio" name="matrix" value="squarespace" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'diamond' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'longrounded' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="5" y="11" rx="5" ry="5" height="10" width="20" fill="black"></rect><rect x="15" y="0" r="" rx="5" ry="5" height="10" width="10" fill="black"></rect></svg>
                                        <input type="radio" name="matrix" value="longrounded" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'longrounded' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'tallrounded' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="5" y="10" rx="5" ry="5" height="10" width="10" fill="black"></rect><rect x="16" y="0" r="" rx="5" ry="5" height="20" width="10" fill="black"></rect></svg>
                                        <input type="radio" name="matrix" value="tallrounded" class="d-none"  <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'tallrounded' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'distored' ? 'border-secondary' : '' ?>" >
                                        <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><polygon points="5,10 15,8 16,20 4,19" fill="black" /><polygon points="16,10 26,11 25,21 17,19" fill="black" /></svg>
                                        <input type="radio" name="matrix" value="distorted" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'distorted' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'threed' ? 'border-secondary' : '' ?>" >
                                        <svg width="30" height="30" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg"><polygon points="5,10 15,10 15,20 5,20" fill="black" /><polygon points="5,10 15,10 18,5 8,5" fill="#333333" /><polygon points="15,10 18,5 18,15 15,20" fill="#666666" /></svg>
                                        <input type="radio" name="matrix" value="threed" class="d-none" <?php echo isset($qr->data->matrix) && $qr->data->matrix == 'threed' ? 'checked' : '' ?>>
                                    </label>    
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block mb-3"><?php ee("Eye Frame") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'square' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect height="30" width="30" style="fill:rgb(255,255,255);stroke-width:8;stroke:rgb(0,0,0)"></svg>
                                        <input type="radio" name="eyeframe" value="square" class="d-none" <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'square' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'rounded' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect height="30" width="30" rx="8" ry="8" style="fill:rgb(0,0,0);"></rect><rect x="4" y="4" height="22" width="22" rx="5" ry="5" style="fill:rgb(255,255,255);"></rect></svg>
                                        <input type="radio" name="eyeframe" value="rounded" class="d-none" <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'rounded' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'circle' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><circle cx="15" cy="15" r="12" fill="white" stroke="black" stroke-width="4"></circle></svg>
                                        <input type="radio" name="eyeframe" value="circle" class="d-none" <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'circle' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'eye' ? 'border-secondary' : '' ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="#ffffff"></rect><g transform="scale(4.2)"><g transform="translate(0,-14)"><path fill-rule="evenodd" d="M10 5M0 21C0 14 0 14 7 14M7 14C7 21 7 21 0 21ZM1 20C1 15 1 15 6 15M6 15C6 20 6 20 1 20M2 5z" fill="#000000"/></g></g><circle cx="15" cy="15" r="9" fill="white"></circle></svg>
                                        <input type="radio" name="eyeframe" value="eye" class="d-none" <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'eye' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'eyeinverted' ? 'border-secondary' : '' ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="#ffffff"></rect><g transform="translate(-4 -8) scale(4.2)"><g transform="rotate(90 10 12)"><path fill-rule="evenodd" d="M10 5M0 21C0 14 0 14 7 14M7 14C7 21 7 21 0 21ZM1 20C1 15 1 15 6 15M6 15C6 20 6 20 1 20M2 5z" fill="#000000"/></g></g><circle cx="15" cy="15" r="9" fill="white"></circle></svg>
                                        <input type="radio" name="eyeframe" value="eyeinverted" class="d-none" <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'eyeinverted' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'bubble' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect height="30" width="30" rx="8" ry="8" style="fill:rgb(0,0,0);"></rect><rect x="20" y="20" height="10" width="10" style="fill:rgb(0,0,0);"></rect><rect x="4" y="4" height="22" width="22" rx="5" ry="5" style="fill:rgb(255,255,255);"></rect><rect x="21" y="21" height="5" width="5" style="fill:rgb(255,255,255);"></rect></svg>
                                        <input type="radio" name="eyeframe" value="bubble" class="d-none" <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'bubble' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'hexagon' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30">
                                            <path d="M15 5 L23 10 L23 20 L15 25 L7 20 L7 10 Z" style="fill:rgb(255,255,255);stroke:rgb(0,0,0);stroke-width:4;" />
                                        </svg>
                                        <input type="radio" name="eyeframe" value="hexagon" class="d-none" <?php echo isset($qr->data->eyeframe) && $qr->data->eyeframe == 'hexagon' ? 'checked' : '' ?>>
                                    </label>   
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block mb-3"><?php ee("Eye Style") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'square' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="5" y="5" height="20" width="20" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="eye" value="square" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'square' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'rounded' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="5" y="5" height="20" width="20" rx="6" ry="6" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="eye" value="rounded" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'rounded' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'circle' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><circle cx="15" cy="15" r="10" fill="black"></circle></svg>
                                        <input type="radio" name="eye" value="circle" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'circle' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'eye' ? 'border-secondary' : '' ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="transparent"></rect><g transform="scale(6)"><g transform="translate(-1,-15)"><path fill-rule="evenodd" d="M10 20M2 19C2 16 2 16 5 16M5 16C5 19 5 19 2 19" fill="#000000"/></g></g></svg>
                                        <input type="radio" name="eye" value="eye" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'eye' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'eyeinverted' ? 'border-secondary' : '' ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30"><rect x="5" y="5" width="20" height="20" fill="transparent"></rect><g transform="translate(-10 -17) scale(6)"><g transform="rotate(90 10 12)"><path fill-rule="evenodd" d="M10 20M2 19C2 16 2 16 5 16M5 16C5 19 5 19 2 19" fill="#000000"/></g></g></svg>
                                        <input type="radio" name="eye" value="eyeinverted" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'eyeinverted' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'butterfly' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><circle cx="12" cy="12" r="5" fill="black"></circle><circle cx="19" cy="12" r="5" fill="black"></circle><circle cx="12" cy="18" r="5" fill="black"></circle><circle cx="19" cy="18" r="5" fill="black"></circle></svg>
                                        <input type="radio" name="eye" value="butterfly" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'butterfly' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'bubble' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><rect x="5" y="5" height="20" width="20" rx="6" ry="6" style="fill:rgb(0,0,0);"></rect><rect x="17" y="17" height="8" width="8" style="fill:rgb(0,0,0);"></rect></svg>
                                        <input type="radio" name="eye" value="bubble" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'bubble' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'diamond' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><g transform="translate(15 -10) rotate(45)"><rect x="10" y="10" height="15" width="15" style="fill:rgb(0,0,0);"></rect></g></svg>
                                        <input type="radio" name="eye" value="diamond" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'diamond' ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo isset($qr->data->eye) && $qr->data->eye == 'hexagon' ? 'border-secondary' : '' ?>">
                                        <svg width="30" height="30"><path d="M15 5 L23 10 L23 20 L15 25 L7 20 L7 10 Z" style="fill:rgb(0,0,0);" /></svg>
                                        <input type="radio" name="eye" value="hexagon" class="d-none" <?php echo isset($qr->data->eye) && $qr->data->eye == 'hexagon' ? 'checked' : '' ?>>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 rounded border mb-3">
                            <?php if(user()->has('qrframes')): ?>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold d-block"><?php ee("Frame Style") ?></label>
                                <div data-toggle="buttons">
                                    <label class="btn text-center border <?php echo (!isset($qr->data->frame->type) || empty($qr->data->frame->type) || $qr->data->frame->type == 'none') ? 'border-secondary' : '' ?> rounded p-3 me-1" style="height:68px;width:68px">
                                        <input type="radio" name="frame[type]" value="none" class="d-none" <?php echo (!isset($qr->data->frame->type) || empty($qr->data->frame->type) || $qr->data->frame->type == 'none') ? 'checked' : '' ?>>
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i data-feather="x"></i>
                                        </div>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'window') ? 'border-secondary' : '' ?>">
                                        <svg width="50" height="50"><g transform="scale(1.8) translate(2.5 0)" fill="#000000"><path d="M 1.3 28 L 22.6 28 C 23.3 28 23.9 27.4 23.9 26.7 L 24 1.4 C 24 0.7 23.33 -0.04 22.63 -0.04 L 1.4 0 C 0.7 0 0.1 0.6 0 1.3 L 0 26.6 C -0.1 27.4 0.5 28 1.3 28 Z M 1 6 C 1 5.4 1.5 5 2 5 L 22 5 C 22.6 5 23 5.5 23 6 L 23 26 C 23 26.6 22.5 27 22 27 L 2 27 C 1.4 27 1 26.5 1 26 L 1 6 Z"/></g></svg>
                                        <input type="radio" name="frame[type]" value="window" class="d-none" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'window') ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'popup') ? 'border-secondary' : '' ?>">
                                        <svg width="50" height="50"><g transform="scale(1.55) translate(3.5 0)" fill="#000000"><path d="M22.7,6L1.3,6C0.6,6,0,6.6,0,7.3l0,21.3C0,29.4,0.6,30,1.3,30l21.3,0c0.7,0,1.3-0.6,1.3-1.3l0-21.3 C24,6.6,23.4,6,22.7,6z M23,28c0,0.6-0.5,1-1,1L2,29c-0.6,0-1-0.5-1-1V8c0-0.6,0.5-1,1-1l20,0c0.6,0,1,0.5,1,1V28z"/><path d="M23,0H1C0.4,0,0,0.4,0,1v3c0,0.5,0.4,1,1,1h10l1,1l1-1h10c0.5,0,1-0.4,1-1V1C24,0.4,23.6,0,23,0z"/></g></svg>
                                        <input type="radio" name="frame[type]" value="popup" class="d-none" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'popup') ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'camera') ? 'border-secondary' : '' ?>">
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><g transform="translate(3.5 0)" fill="#000000"><path d="M224.88,93.12h19.39a5,5,0,0,1,5,5v18.73H254V98.12a9.68,9.68,0,0,0-9.68-9.68H224.88Z"></path><path d="M50.73,116.85V98.12a5,5,0,0,1,5-5H73.8V88.44H55.73a9.68,9.68,0,0,0-9.68,9.68v18.73Z"></path><path d="M73.8,291.67H55.73a5,5,0,0,1-5-5V267.94H46.05v18.73a9.68,9.68,0,0,0,9.68,9.68H73.8Z"></path><path d="M249.27,267.94v18.73a5,5,0,0,1-5,5H224.88v4.68h19.39a9.68,9.68,0,0,0,9.68-9.68V267.94Z"></path><path d="M244.75,3.65H55.45A9.25,9.25,0,0,0,46.2,12.9V54.46a9.25,9.25,0,0,0,9.25,9.26H126a2.32,2.32,0,0,1,1.64.67l20.74,20.74a2.33,2.33,0,0,0,3.28,0l20.75-20.74a2.28,2.28,0,0,1,1.64-.67h70.58a9.25,9.25,0,0,0,9.25-9.26V12.9A9.18,9.18,0,0,0,244.75,3.65Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="camera" class="d-none" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'camera') ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'phone') ? 'border-secondary' : '' ?>>
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><g transform="translate(3.5 0)" fill="#000000"><path d="M57.6,251.64H56.27V37.3H57.6Zm185.47,0h1.34V37.3h-1.34Z"></path><path d="M220.31,1.06H80.36a24.08,24.08,0,0,0-24.09,24.1V39.41H244.41V25.16A24.09,24.09,0,0,0,220.31,1.06Zm-51.94,21.1H132.3a2,2,0,0,1,0-4h36.07a2,2,0,0,1,0,4Z"></path><path d="M164.93,241.1l-14.32-12.52L135.9,241.1H56.27v33.3a24.07,24.07,0,0,0,24.09,24.09h140a24.08,24.08,0,0,0,24.1-24.09V241.1Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="phone" class="d-none" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'phone') ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'arrow') ? 'border-secondary' : '' ?>">
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><g transform="translate(3.5 0)" fill="#000000"><path d="M 74.713 178.459 C 74.83 176.468 75.016 174.408 75.193 172.417 C 75.369 170.425 75.663 168.424 76.026 166.49 C 76.388 164.557 76.8 162.623 77.27 160.738 C 77.741 158.982 78.378 157.273 79.171 155.633 C 79.23 155.459 79.298 155.218 79.357 154.986 C 79.741 153.118 78.509 151.3 76.613 150.935 L 76.437 150.877 C 76.265 150.832 76.086 150.812 75.908 150.819 C 75.722 150.819 75.604 150.761 75.428 150.761 C 75.252 150.761 74.83 150.703 74.536 150.703 C 73.939 150.703 73.351 150.761 72.753 150.761 C 71.567 150.877 70.431 151.003 69.304 151.177 C 67.058 151.521 64.834 151.989 62.641 152.578 C 60.499 153.201 58.395 153.947 56.341 154.812 C 55.361 155.218 54.313 155.778 53.304 156.165 C 52.294 156.552 51.344 157.219 50.364 157.683 C 49.869 157.968 49.872 158.675 50.37 158.956 C 50.529 159.045 50.715 159.074 50.893 159.037 L 50.962 159.037 C 52.03 158.805 53.039 158.505 54.048 158.273 C 55.057 158.041 56.135 157.809 57.144 157.683 C 59.202 157.302 61.285 157.063 63.376 156.968 C 64.689 156.91 66.051 156.91 67.364 156.91 C 64.662 160.025 62.289 163.404 60.28 166.993 C 57.655 171.725 55.506 176.698 53.862 181.843 C 50.608 192.017 48.956 202.623 48.963 213.292 C 48.92 223.887 50.573 234.423 53.862 244.509 C 57.21 254.531 62.369 263.873 69.088 272.082 C 69.39 272.457 69.934 272.537 70.333 272.265 C 70.741 271.979 70.821 271.414 70.509 271.028 C 64.329 262.805 59.717 253.541 56.9 243.688 C 51.512 223.976 52.405 203.105 59.457 183.912 C 61.201 179.206 63.393 174.675 66.002 170.377 C 67.626 167.709 69.499 165.198 71.597 162.875 C 71.597 164.044 71.597 165.156 71.656 166.336 C 71.773 168.443 71.891 170.503 72.126 172.552 C 72.361 174.602 72.606 176.661 72.959 178.71 C 73.026 179.156 73.396 179.497 73.85 179.532 C 74.317 179.36 74.649 178.947 74.713 178.459 Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="arrow" class="d-none" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'arrow') ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'labeled') ? 'border-secondary' : '' ?>">
                                        <svg width="50" height="50"><g transform="scale(0.155) translate(3.5 0)" fill="#000000"><path d="M253.83.69H46.09A11.28,11.28,0,0,0,34.77,12V219.83a11.33,11.33,0,0,0,11.32,11.31H253.91a11.33,11.33,0,0,0,11.32-11.31V12A11.41,11.41,0,0,0,253.83.69Zm2.64,215.59a6.1,6.1,0,0,1-6.11,6.11H49.55a6.1,6.1,0,0,1-6.11-6.11V15.47a6.1,6.1,0,0,1,6.11-6.11H250.36a6.09,6.09,0,0,1,6.11,6.11Z"></path><path id="IconCircleOutline" d="M64.42,246.09A23.53,23.53,0,1,0,88,269.62a23.47,23.47,0,0,0-23.53-23.53Z" fill-opacity="0"></path><path id="PhoneIcon" d="M74.57,254.59v29.73a3.39,3.39,0,0,1-3.38,3.38H56.57a3.39,3.39,0,0,1-3.38-3.38V254.59a3.39,3.39,0,0,1,3.38-3.38H71.19A3.46,3.46,0,0,1,74.57,254.59Zm-15.11.17A1.57,1.57,0,0,0,61,256.33h5.62a1.57,1.57,0,0,0,1.56-1.57,1.62,1.62,0,0,0-1.56-1.57H61.11A1.59,1.59,0,0,0,59.46,254.76ZM72,258.64l-16.43-.17v22H72Zm-10.4,25.43a2.23,2.23,0,1,0,2.23-2.23A2.22,2.22,0,0,0,61.61,284.07Z"></path><path id="PhoneIconBlack" d="M74.57,254.59v29.73a3.39,3.39,0,0,1-3.38,3.38H56.57a3.39,3.39,0,0,1-3.38-3.38V254.59a3.39,3.39,0,0,1,3.38-3.38H71.19A3.46,3.46,0,0,1,74.57,254.59Zm-15.11.17A1.57,1.57,0,0,0,61,256.33h5.62a1.57,1.57,0,0,0,1.56-1.57,1.62,1.62,0,0,0-1.56-1.57H61.11A1.59,1.59,0,0,0,59.46,254.76ZM72,258.64l-16.43-.17v22H72Zm-10.4,25.43a2.23,2.23,0,1,0,2.23-2.23A2.22,2.22,0,0,0,61.61,284.07Z" fill-opacity="0"></path><path d="M235.5,240H64.42a29.68,29.68,0,0,0,0,59.36h171A29.68,29.68,0,0,0,235.5,240ZM64.42,293.15A23.53,23.53,0,1,1,88,269.62,23.47,23.47,0,0,1,64.42,293.15Z"></path></g></svg>
                                        <input type="radio" name="frame[type]" value="labeled" class="d-none" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'labeled') ? 'checked' : '' ?>>
                                    </label>
                                    <label class="btn text-center border bg-light rounded p-2 h-100 me-1 <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'roundedlines') ? 'border-secondary' : '' ?>">
                                        <img src="<?php echo assets('images/roundedlines.svg') ?>" width="50">
                                        <input type="radio" name="frame[type]" value="roundedlines" class="d-none" <?php echo (isset($qr->data->frame->type) && $qr->data->frame->type == 'roundedlines') ? 'checked' : '' ?>>
                                    </label>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold d-block mb-2"><?php ee("Text") ?></label>
                                            <input type="text" name="frame[text]" placeholder="e.g. Scan me" class="form-control p-2" value="<?php echo $qr->data->frame->text ?? '' ?>">
                                            <div class="form-text"><?php ee('Limit of {x} characters', null, ['x' => 20]) ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold d-block mb-2"><?php ee("Font") ?></label>
                                            <select name="frame[font]" class="form-select p-2">
                                                <?php foreach(['Arial', 'Courier_New', 'Times_New_Roman', 'Comic_Sans_MS', 'Verdana', 'Impact', 'Tahoma'] as $font): ?>
                                                    <option value="<?php echo $font ?>" style="font-family: '<?php echo str_replace('_', ' ', $font) ?>'" <?php echo isset($qr->data->frame->font) && $qr->data->frame->font == $font ? 'selected' : '' ?>><?php echo str_replace('_', ' ', $font) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col form-group mb-3">
                                        <label class="form-label fw-bold"><?php ee("Frame Color") ?></label><br>
                                        <input type="text" name="frame[color]" id="framecolor" value="<?php echo $qr->data->frame->color ?? 'rgb(0,0,0)' ?>">
                                    </div>
                                    <div class="col form-group">
                                        <label class="form-label fw-bold"><?php ee("Text Color") ?></label><br>
                                        <input type="text" name="frame[textcolor]" id="frametextcolor" value="<?php echo $qr->data->frame->textcolor ?? 'rgb(255,255,255)' ?>">
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold d-block"><?php ee("Frame Style") ?></label>
                                    <a href="<?php echo route('pricing') ?>" class="mt-3 d-block border p-2 rounded-pill text-muted">
                                        <span class="btn bg-primary rounded-pill text-white"><i class="fa fa-lock mx-2"></i>  <?php ee('Upgrade') ?></span>
                                        <span class="align-middle ms-1"><?php ee('Upgrade to unlock this feature') ?></span>
                                    </a>
                                </div>
                        <?php endif ?>
                        </div>
                    <?php endif ?>
                    <div class="p-3 border rounded">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold d-block"><?php ee("Margin") ?></label>
                            <input type="number" value="<?php echo $qr->data->margin ?? '' ?>" name="margin" placeholder="e.g. 10" class="form-control p-2">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold d-block mb-2"><?php ee("Error Correction") ?></label>
                            <div class="form-text mb-3"><?php ee('Error correction allows better readability when code is damaged or dirty but increase QR data') ?></div>
                            <select name="error" class="form-select p-2">
                                <option value="l" <?php echo isset($qr->data->error) && $qr->data->error == 'l'? 'selected' : '' ?>>L (7%)</option>
                                <option value="m" <?php echo !isset($qr->data->error) || $qr->data->error == 'm'? 'selected' : '' ?>>M (15%)</option>
                                <option value="q" <?php echo isset($qr->data->error) && $qr->data->error == 'q'? 'selected' : '' ?>>Q (25%)</option>
                                <option value="h" <?php echo isset($qr->data->error) && $qr->data->error == 'h'? 'selected' : '' ?>>H (30%)</option>
                            </select>
                        </div>
                    </div>
				</div>
			</div>
        </div>
        <div class="col-md-5">
            <div id="qr-preview">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title fw-bold"><?php ee('QR Code') ?></h5>
                    </div>
                    <div class="card-body">
                        <div id="return-ajax">
                            <img src="<?php echo route('qr.generate', [$qr->alias]) ?>" class="img-responsive w-100 mw-50">
                        </div>
                        <?php if(isset($qr->data->logosize) && ($qr->data->logosize / 1000 > 0.35)): ?>
                            <div class="alert alert-danger mt-2 p-2"><?php ee('Your QR code might not be readable. Please scan it with your phone to verify.') ?></div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card rounded-4 shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="block w-100 mb-2 btn btn-primary me-1 px-3 py-2 rounded-3"><?php ee('Save Changes') ?></button>
                        <div class="btn-group block w-100" role="group" aria-label="downloadQR">
                            <?php if(!config('imagemagick')): ?>                          
                                <div class="btn-group w-100" role="group">
                                    <button id="btndownloadqr" type="button" class="btn btn-dark dropdown-toggle rounded-3 w-100 px-3 py-2" data-bs-toggle="dropdown" aria-expanded="false"><span class="me-2"><?php ee('Download') ?></span></button>  
                                    <ul class="dropdown-menu" aria-labelledby="btndownloadqr">
                                        <li><a href="<?php echo route('qr.download', [$qr->alias, 'svg', 1000]) ?>" class="dropdown-item" id="downloadSVG"><i data-feather="download"></i> <?php ee('Download as SVG') ?></a></li>
                                        <li><a class="dropdown-item" href="" data-trigger="downloadqr" data-svg="<?php echo route('qr.download', [$qr->alias, 'svg', 1000]) ?>" data-format="png"><i data-feather="download"></i> <?php ee('Download as PNG') ?></a></li>
                                        <li><a class="dropdown-item" href="" data-trigger="downloadqr" data-svg="<?php echo route('qr.download', [$qr->alias, 'svg', 1000]) ?>" data-format="webp"><i data-feather="download"></i> <?php ee('Download as WebP') ?></a></li>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <div class="btn-group w-100" role="group">
                                    <button id="btndownloadqr" type="button" class="btn btn-dark dropdown-toggle rounded-3 w-100 px-3 py-2" data-bs-toggle="dropdown" aria-expanded="false"><span class="me-2"><?php ee('Download') ?></span></button>  
                                    <ul class="dropdown-menu" aria-labelledby="btndownloadqr">
                                        <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'png', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as PNG') ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'svg', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as SVG') ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'webp', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as WebP') ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo route('qr.download', [$qr->alias, 'pdf', 1000]) ?>"><i data-feather="download"></i> <?php ee('Download as PDF') ?></a></li>
                                    </ul>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="card rounded-4 card-body shadow-sm">
                    <p><?php ee("You will be able to download the QR code in PDF or SVG after it has been generated.") ?></p>
                    <p><?php ee("If you are using a fancy design, your QR code might not be readable. If that is the case, you can increase Error Correction to ensure optimal readability. It is recommended to test the QR code before saving it.") ?></p>
                </div>
            </div>
        </div>
    </div>
</form>