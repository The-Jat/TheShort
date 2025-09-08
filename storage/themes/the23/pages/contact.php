<section class="bg-primary border-top border-bottom">
    <div class="container py-8">
        <div class="row align-items-center">
            <div class="col-lg-5 text-center text-lg-start mb-5">
                <h1 class="display-4 mb-3 fw-bolder"><?php ee('Contact Us') ?></h1>
                <p class="lead"><?php ee('If you have any questions, feel free to contact us so we can help you.') ?></p>
                <ul class="nav mt-4 justify-content-center justify-content-lg-start">
                    <?php if($facebook = config('facebook')): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2 fs-5" href="<?php echo $facebook ?>" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if($twitter = config('twitter')): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2 fs-5" href="<?php echo $twitter ?>" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if($instagram = config('sociallinks')->instagram): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2 fs-5" href="<?php echo $instagram ?>" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php if($linkedin = config('sociallinks')->linkedin): ?>
                        <li>
                            <a class="nav-link text-muted ps-0 me-2 fs-5" href="<?php echo $linkedin ?>" target="_blank">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form id="form-contact" method="post" action="<?php echo route('contact.send') ?>" data-trigger="server-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="contact-name"><?php ee("Name") ?> <span class="text-danger">*</span></label>
                                        <input class="form-control p-3" type="text" placeholder="<?php ee("Name") ?>" id="contact-name" name="name" value="<?php echo \Core\Auth::logged() ? \Core\Auth::user()->username : '' ?>" min="2" data-error="<?php ee('Please enter a valid name') ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="contact-email"><?php ee("Email") ?> <span class="text-danger">*</span></label>
                                        <input class="form-control p-3" type="email" placeholder="<?php ee("Email") ?>" name="email" id="contact-email" value="<?php echo \Core\Auth::logged() ? \Core\Auth::user()->email : '' ?>" data-error="<?php ee('Please enter a valid email') ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="contact-message"><?php ee("Message") ?> <span class="text-danger">*</span></label>
                                <textarea class="form-control p-3" placeholder="<?php ee('If you have any questions, feel free to contact us so we can help you') ?>" rows="10" min="10" data-error="<?php ee('The message is empty or too short') ?>" id="content-message" name="message" required></textarea>
                            </div>
                            <?php echo \Helpers\Captcha::display('contact') ?>
                            <div class="d-flex mt-4">
                                <?php echo csrf() ?>
                                <div class="ms-auto">
                                    <button type="submit" class="btn btn-primary py-3 px-5"><?php ee('Send') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>