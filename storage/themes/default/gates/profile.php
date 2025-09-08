<div class="container pt-5 pb-2" id="profile">    
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center mt-5">
            <?php \Helpers\App::ads('biopage') ?>
            <?php if(!isset($profiledata['style']['layout']) || $profiledata['style']['layout'] == 'layout1'): ?>
                <?php if(!isset($profiledata['avatarenabled']) || $profiledata['avatarenabled']): ?>
                    <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                        <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                    <?php else: ?>
                        <img src="<?php echo $user->avatar() ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                    <?php endif ?>
                <?php endif ?>
                <h3>
                    <span class="align-middle"><?php echo $profile->name ?></span>
                    <?php if($user->verified && (isset($profiledata['settings']['verified']) && $profiledata['settings']['verified'] || !isset($profiledata['settings']['verified']))): ?>
                        <span class="ml-2 ms-2" data-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" data-bs-placement="top" title="<?php ee('Verified Account') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><polygon stroke-width="1" stroke="#fff" fill="#3899e8" points="29.50,3 33.053,8.308 39.367,8.624 39.686,14.937 44.997,18.367 42.116,23.995 45,29.62 39.692,33.053 39.376,39.367 33.063,39.686 29.633,44.997 24.005,42.116 18.38,45 14.947,39.692 8.633,39.376 8.314,33.063 3.003,29.633 5.884,24.005 3,18.38 8.308,14.947 8.624,8.633 14.937,8.314 18.367,3.003 23.995,5.884"></polygon><polygon fill="#fff" points="21.396,31.255 14.899,24.76 17.021,22.639 21.428,27.046 30.996,17.772 33.084,19.926"></polygon></svg></span>
                    <?php endif ?>
                </h3>
                <?php if(isset($profiledata['links']['tagline'])) echo \Helpers\BioWidgets::render('tagline', $profiledata['links']['tagline']) ?>
                <?php if(!isset($profiledata['style']['socialposition']) || $profiledata['style']['socialposition'] == 'top'): ?>
                    <?php if(isset($profiledata['social'])): ?>
                        <div id="social" class="text-center my-4">
                            <?php foreach($profiledata['social'] as $key => $social): ?>
                                <?php if(empty($social['link'])) continue ?>
                                <?php if($key == 'envelope') $social['link'] = 'mailto:'.str_replace('mailto:', '', $social['link']) ?>
                                <a href="<?php echo $social['link'] ?>" class="ml-2 ms-2 mb-2 d-inline-block" target="_blank" data-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" title="<?php echo $social['name'] ?>" rel="nofollow"><?php echo (isset($profiledata['style']['iconstyle']) && $profiledata['style']['iconstyle'] == 'square' && isset($social['square']) ? $social['square'] : $social['icon']) ?></a>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php elseif($profiledata['style']['layout'] == 'layout2'): ?>
                <div class="layout2">
                    <div class="d-block p-3 rounded" style="background-color: <?php echo $profiledata['style']['bg'] ?>;<?php if(isset($profiledata['layoutbanner']) && $profiledata['layoutbanner']) echo 'background-image:url(\''.uploads($profiledata['layoutbanner'], 'profile').'\');background-size:cover;'; ?>">

                    </div>
                    <?php if(!isset($profiledata['avatarenabled']) || $profiledata['avatarenabled']): ?>
                        <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                            <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                        <?php else: ?>
                            <img src="<?php echo $user->avatar() ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                        <?php endif ?>
                    <?php endif ?>
                    <h3>
                        <span class="align-middle"><?php echo $profile->name ?></span>
                        <?php if($user->verified && (isset($profiledata['settings']['verified']) && $profiledata['settings']['verified'] || !isset($profiledata['settings']['verified']))): ?>
                            <span class="ml-2 ms-2" data-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" data-bs-placement="top" title="<?php ee('Verified Account') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><polygon fill="#42a5f5" points="29.50,3 33.053,8.308 39.367,8.624 39.686,14.937 44.997,18.367 42.116,23.995 45,29.62 39.692,33.053 39.376,39.367 33.063,39.686 29.633,44.997 24.005,42.116 18.38,45 14.947,39.692 8.633,39.376 8.314,33.063 3.003,29.633 5.884,24.005 3,18.38 8.308,14.947 8.624,8.633 14.937,8.314 18.367,3.003 23.995,5.884"></polygon><polygon fill="#fff" points="21.396,31.255 14.899,24.76 17.021,22.639 21.428,27.046 30.996,17.772 33.084,19.926"></polygon></svg></span>
                        <?php endif ?>
                    </h3>
                    <?php if(isset($profiledata['links']['tagline'])) echo \Helpers\BioWidgets::render('tagline', $profiledata['links']['tagline']) ?>
                    <?php if(!isset($profiledata['style']['socialposition']) || $profiledata['style']['socialposition'] == 'top'): ?>
                        <?php if(isset($profiledata['social'])): ?>
                            <div id="social" class="text-center my-4">
                                <?php foreach($profiledata['social'] as $key => $social): ?>
                                    <?php if(empty($social['link'])) continue ?>
                                    <?php if($key == 'envelope') $social['link'] = 'mailto:'.str_replace('mailto:', '', $social['link']) ?>
                                    <a href="<?php echo $social['link'] ?>" class="ml-2 ms-2 mb-2 d-inline-block" target="_blank" data-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" title="<?php echo $social['name'] ?>" rel="nofollow"><?php echo (isset($profiledata['style']['iconstyle']) && $profiledata['style']['iconstyle'] == 'square' && isset($social['square']) ? $social['square'] : $social['icon']) ?></a>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            <?php elseif($profiledata['style']['layout'] == 'layout3'): ?>
                <div class="layout3">
                    <div class="d-block p-3 p-sm-5 rounded" style="background-color: <?php echo $profiledata['style']['bg'] ?>;<?php if(isset($profiledata['layoutbanner']) && $profiledata['layoutbanner']) echo 'background-image:url(\''.uploads($profiledata['layoutbanner'], 'profile').'\');background-size:cover;'; ?>">
                        <div class="d-flex align-items-center">
                            <div>
                                <?php if(!isset($profiledata['avatarenabled']) || $profiledata['avatarenabled']): ?>
                                    <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                                        <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="80" height="80">
                                    <?php else: ?>
                                        <img src="<?php echo $user->avatar() ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="100" height="100">
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                            <div class="ml-4 text-left ms-4 text-start align-items-center">
                                <h3>
                                    <span class="align-middle"><?php echo $profile->name ?></span>
                                    <?php if($user->verified && (isset($profiledata['settings']['verified']) && $profiledata['settings']['verified'] || !isset($profiledata['settings']['verified']))): ?>
                                        <span class="ml-2 ms-2 text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php ee('Verified Account') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><polygon fill="#42a5f5" points="29.50,3 33.053,8.308 39.367,8.624 39.686,14.937 44.997,18.367 42.116,23.995 45,29.62 39.692,33.053 39.376,39.367 33.063,39.686 29.633,44.997 24.005,42.116 18.38,45 14.947,39.692 8.633,39.376 8.314,33.063 3.003,29.633 5.884,24.005 3,18.38 8.308,14.947 8.624,8.633 14.937,8.314 18.367,3.003 23.995,5.884"></polygon><polygon fill="#fff" points="21.396,31.255 14.899,24.76 17.021,22.639 21.428,27.046 30.996,17.772 33.084,19.926"></polygon></svg></span>
                                    <?php endif ?>
                                </h3>
                                <?php if(isset($profiledata['links']['tagline'])) echo \Helpers\BioWidgets::render('tagline', $profiledata['links']['tagline']) ?>
                                <?php if(!isset($profiledata['style']['socialposition']) || $profiledata['style']['socialposition'] == 'top'): ?>
                                    <?php if(isset($profiledata['social'])): ?>
                                        <div id="social" class="text-start text-left mt-4">
                                            <?php foreach($profiledata['social'] as $key => $social): ?>
                                                <?php if(empty($social['link'])) continue ?>
                                                <?php if($key == 'envelope') $social['link'] = 'mailto:'.str_replace('mailto:', '', $social['link']) ?>
                                                <a href="<?php echo $social['link'] ?>" class="ml-2 ms-2 mb-2 d-inline-block" target="_blank" data-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" title="<?php echo $social['name'] ?>" rel="nofollow"><?php echo (isset($profiledata['style']['iconstyle']) && $profiledata['style']['iconstyle'] == 'square' && isset($social['square']) ? $social['square'] : $social['icon']) ?></a>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
     <div class="row">
        <div class="col-md-6 offset-md-3 text-center my-4">
            <?php echo message() ?>
            <div id="content">
                <?php foreach($profiledata['links'] as $id => $value): ?>
                    <?php if($id == 'tagline' || $id =='bio-tag') continue; ?>
                    <?php echo \Helpers\BioWidgets::render($id, $value) ?>
                <?php endforeach ?>
            </div>
            <?php if(isset($profiledata['style']['socialposition']) && $profiledata['style']['socialposition'] == 'bottom'): ?>
            <div id="social" class="text-center mt-5">
                <?php foreach($profiledata['social'] as $key => $social): ?>
                    <?php if(empty($social['link'])) continue ?>
                    <?php if($key == 'envelope') $social['link'] = 'mailto:'.str_replace('mailto:', '', $social['link']) ?>
                    <a href="<?php echo $social['link'] ?>" class="ml-2 ms-2 mb-2 d-inline-block" target="_blank" data-toggle="tooltip" data-bs-toggle="tooltip" data-placement="top" title="<?php echo $social['name'] ?>" rel="nofollow"><?php echo (isset($profiledata['style']['iconstyle']) && $profiledata['style']['iconstyle'] == 'square' && isset($social['square']) ? $social['square'] : $social['icon']) ?></a>
                <?php endforeach ?>
            </div>
            <?php endif ?>
        </div>
    </div>
    <?php if(!isset($profiledata['settings']['branding']) || !$profiledata['settings']['branding']): ?>
    <div class="text-center mt-3 opacity-8">
        <a class="navbar-brand mr-0 me-0" href="<?php echo url() ?>">
            <?php if(config('logo')): ?>
                <img alt="<?php echo $sitetitle ?? ''?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo" width="180">
            <?php else: ?>
                <h1 class="h5 mt-2"><?php echo $sitetitle ?? ''?></h1>
            <?php endif ?>
        </a>
    </div>
    <?php endif ?>    
</div>
<?php if(isset($profiledata['settings']['share']) && $profiledata['settings']['share']): ?>
    <a href="#" class="share-icon" data-toggle="modal" data-bs-toggle="modal" data-target="#sharemodal" data-bs-target="#sharemodal"><span data-toggle="tooltip" data-bs-toggle="tooltip" data-bs-placement="left" data-placement="left" title="<?php ee('Share') ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg></span></a>
    <div class="modal fade" id="sharemodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-black">
                <div class="modal-header border-0">
                    <h6 class="modal-title fw-bold"><?php ee('Share') ?></h6>
                    <button type="button" class="btn-close" data-dismiss="modal" data-bs-close data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="<?php echo (new \Helpers\QrGd($profile->url, 600, 0))->format('png')->create('uri') ?>" width="200" class="img-responsive img-fluid rounded border p-2 mb-3">
                    </div>
                    <div id="modal-share">
                        <div class="form-group position-relative mb-2 p-3 border rounded">
                            <span class="text-dark text-black"><?php echo $profile->url ?></span>
                            <button type="button" class="btn btn-secondary btn-sm position-absolute top-50 right-0 end-0 translate-middle-y btn-dark  me-2 mr-2 copy inline-copy" data-clipboard-text="<?php echo $profile->url ?>"><?php ee('Copy') ?></button>
                        </div>
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo $profile->url ?>" target="_blank" class="d-flex align-items-center text-left text-start btn text-dark text-black d-block w-100 p-3 border mb-2"><i class="mr-2 me-2 fab fa-facebook"></i> <span class="align-middle"><?php ee('Share on') ?> Facebook</span></a>

                        <a href="https://twitter.com/share?url=<?php echo $profile->url ?>" data-href="https://twitter.com/share?url=" target="_blank" class="d-flex align-items-center text-left text-start btn text-dark text-black d-block w-100 p-3 border mb-2"><i class="mr-2 me-2 fab fa-x-twitter"></i> <span class="align-middle"><?php ee('Share on') ?> X</span></a>

                        <a href="https://reddit.com/submit?url=<?php echo $profile->url ?>" target="_blank" class="d-flex align-items-center text-left text-start btn text-dark text-black d-block w-100 p-3 border mb-2"><i class="mr-2 me-2 fab fa-reddit"></i> <span class="align-middle"><?php ee('Share on') ?> Reddit</span></a>

                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $profile->url ?>" target="_blank" class="d-flex align-items-center text-left text-start btn text-dark text-black d-block w-100 p-3 border mb-2"><i class="mr-2 me-2 fab fa-linkedin"></i> <span class="align-middle"><?php ee('Share on') ?> Linkedin</span></a>

                        <a href="https://wa.me/?text=<?php echo $profile->url ?>" target="_blank" class="d-flex align-items-center text-left text-start btn text-dark text-black d-block w-100 p-3 border mb-2"><i class="mr-2 me-2 fab fa-whatsapp"></i> <span class="align-middle"><?php ee('Share on') ?> Whatsapp</span></a>

                        <a href="mailto:?subject=Check+out+this+BioPage&body=Check+out+this+Biopage+-+<?php echo $profile->url ?>" target="_blank" class="d-flex align-items-center text-left text-start btn text-dark text-black d-block w-100 p-3 border mb-2"><i class="mr-2 me-2 fa fa-envelope"></i> <span class="align-middle"><?php ee('Share via Email') ?></span></a>                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>