<h1 class="h3 mb-5 fw-bold"><?php ee('Mail Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <?php ee('To ensure that emails are delivered, you need to use SMTP at the very least as system emails are not reliable. You can also use email via API from the following providers.') ?>
            </div>
        </div>        
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>

                    <div class="form-group mb-4">
                        <label class="form-label d-block fw-bold"><?php ee('Email Provider') ?></label>
                        <select name="smtp[provider]" id="mailprovider" class="form-select p-2">
                            <option value="smtp" <?php echo (!isset(config('smtp')->provider) || config('smtp')->provider == 'smtp' ? 'selected' : '')  ?>><?php ee('SMTP') ?></option>
                            <option value="mailgun" <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'mailgun' ? 'selected' : '')  ?>>Mailgun</option>
                            <option value="sendgrid" <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'sendgrid' ? 'selected' : '')  ?>>Sendgrid</option>
                            <option value="postmark" <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'postmark' ? 'selected' : '')  ?>>Postmark</option>
                            <option value="mailchimp" <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'mailchimp' ? 'selected' : '')  ?>>Mailchimp (Mandrill)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
					    <label for="email" class="form-label fw-bold"><?php ee('From Email') ?></label>
					    <input type="text" class="form-control p-2" name="email" id="email" value="<?php echo config('email') ?>">
					    <p class="form-text"><?php ee('This email will be used to send emails and to receive emails. We recommend using an email at @yourdomain.') ?></p>
                    </div>
                    <div id="mailgun" class="mailblock p-3 border rounded-3 <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'mailgun' ? '' : 'd-none')  ?>">
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('Mailgun API Key') ?></label>
                            <input type="text" class="form-control p-2" name="smtp[mailgunapi]" value="<?php echo config('smtp')->mailgunapi ?? '' ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('Mailgun Domain') ?></label>
                            <input type="text" class="form-control p-2" name="smtp[mailgundomain]" value="<?php echo config('smtp')->mailgundomain ?? '' ?>" placeholder="e.g. domain.com">
                        </div>
                    </div>
                    <div id="sendgrid" class="mailblock p-3 border rounded-3 <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'sendgrid' ? '' : 'd-none')  ?>">
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('Sendgrid API Key') ?></label>
                            <input type="text" class="form-control p-2" name="smtp[sendgridapi]" value="<?php echo config('smtp')->sendgridapi ?? '' ?>">
                        </div>
                    </div>
                    <div id="postmark" class="mailblock p-3 border rounded-3 <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'postmark' ? '' : 'd-none')  ?>">
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('Postmark API Key') ?></label>
                            <input type="text" class="form-control p-2" name="smtp[postmarkapi]" value="<?php echo config('smtp')->postmarkapi ?? '' ?>">
                        </div>
                    </div>
                    <div id="mailchimp" class="mailblock p-3 border rounded-3 <?php echo (isset(config('smtp')->provider) && config('smtp')->provider == 'mailchimp' ? '' : 'd-none')  ?>">
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('Mailchimp (Mandrill) API Key') ?></label>
                            <input type="text" class="form-control p-2" name="smtp[mailchimpapi]" value="<?php echo config('smtp')->mailchimpapi ?? '' ?>">
                        </div>
                    </div>
                    <div id="smtp" class="mailblock p-3 border rounded-3 <?php echo (!isset(config('smtp')->provider) || config('smtp')->provider == 'smtp' ? '' : 'd-none')  ?>">
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('SMTP Host') ?></label>
                            <input type="text" class="form-control p-2" name="smtp[host]" value="<?php echo config('smtp')->host ?? '' ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3 input-select rounded">
                                    <label for="smtp" class="form-label fw-bold"><?php ee('SMTP Security') ?></label>
                                    <select name="smtp[security]" id="smtp" class="form-select p-2">
                                        <option value="none" <?php echo (isset(config('smtp')->security) && config('smtp')->security == 'none' ? 'selected' : '') ?>>None</option>
                                        <option value="tls" <?php echo (isset(config('smtp')->security) && config('smtp')->security == 'tls' ? 'selected' : '') ?>>TLS</option>
                                        <option value="ssl" <?php echo (isset(config('smtp')->security) && config('smtp')->security == 'ssl' ? 'selected' : '') ?>>SSL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="smtp" class="form-label fw-bold"><?php ee('SMTP Port') ?></label>
                                    <input type="text" class="form-control p-2" name="smtp[port]" value="<?php echo config('smtp')->port ?? '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('SMTP User') ?></label>
                            <input type="text" class="form-control p-2" name="smtp[user]" value="<?php echo config('smtp')->user ?? '' ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="smtp" class="form-label fw-bold"><?php ee('SMTP Pass') ?></label>
                            <input type="password" class="form-control p-2" name="smtp[pass]" value="<?php echo config('smtp')->pass ?? '' ?>">
                        </div>
                    </div>
                    <div class="d-flex mt-3">
                        <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                        <div class="ms-auto">
                            <a href="<?php echo route('admin.email', ['email' => config('email')]) ?>" class="btn bg-white text-dark border px-5 py-2 rounded-3 shadow-sm fw-bold"><?php ee('Send Test Email') ?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>