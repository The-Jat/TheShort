<section class="bg-primary border-top border-bottom">
    <div class="container py-10">
        <div class="row align-items-center">
            <div class="col-lg-5 text-center text-lg-start mb-5">
                <h1 class="display-4 mb-3 fw-bolder"><?php ee('Report link') ?></h1>
                <p class="lead"><?php ee('Please report a link that you consider risky or dangerous. We will review all cases and take measure to remove the link.') ?></p>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                    <form id="form-contact" method="post" action="<?php echo route('report.send') ?>" data-trigger="server-form">
                            <div class="form-group mb-4">
                                <label class="form-label" for="contact-email"><?php ee("Email") ?> <span class="text-danger">*</span></label>
                                <input class="form-control p-3" type="email" placeholder="<?php ee("Email") ?>" name="email" id="contact-email" value="<?php echo \Core\Auth::logged() ? \Core\Auth::user()->email : '' ?>" data-error="<?php ee('Please enter a valid email') ?>" required>
                            </div>   
                            <div class="form-group mb-4">
                                <label class="form-label" for="contact-link"><?php ee("Short Link") ?> <span class="text-danger">*</span></label>
                                <input class="form-control p-3" type="text" placeholder="<?php ee("Please enter a valid short link") ?>" id="contact-link" name="link" value="" data-error="<?php ee('Please enter a valid link.') ?>" min="10" required>
                            </div>                
                            <div class="form-group mb-4">
                                <label class="form-label" for="contact-reason"><?php ee("Reason") ?> <span class="text-danger">*</span></label>
                                <select name="reason" id="contact-reason" class="form-select p-3">
                                    <option value="spam"><?php echo e("Spam") ?></option>
                                    <option value="fraudulent"><?php echo e("Fraudulent") ?></option>
                                    <option value="malicious"><?php echo e("Malicious") ?></option>
                                    <option value="phishing"><?php echo e("Phishing") ?></option>
                                </select>
                            </div>
                            <?php echo \Helpers\Captcha::display('report') ?>
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