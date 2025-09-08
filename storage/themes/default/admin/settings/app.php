<h1 class="h3 mb-5 fw-bold"><?php ee('Application Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>
                    <div class="form-group">
                        <label for="home_redir" class="form-label fw-bold"><?php ee('Home Page Redirect') ?></label>
                        <input type="text" class="form-control p-2" name="home_redir" id="home_redir" value="<?php echo config('home_redir') ?>">
                        <p class="form-text"><?php ee('If you want the homepage to redirect to another page at all time, enter the full link here otherwise empty it to disable it.') ?></p>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="maintenance" class="form-label mb-0 fw-bold"><?php ee('Site Maintenance') ?></label>
                            <p class="form-text my-0"><?php ee('Setting offline will make your website inaccessible for all users but admins.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="maintenance" name="maintenance" value="1" <?php echo config("maintenance") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="private" class="form-label mb-0 fw-bold"><?php ee('Private Service') ?></label>
                            <p class="form-text my-0"><?php ee('Enabling this will prevent users from shortening and registering. Only you can create accounts.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="private" name="private" value="1" <?php echo config("private") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="blog" class="form-label mb-0 fw-bold"><?php ee('Blog Module') ?></label>
                            <p class="form-text my-0"><?php ee('Enable the blog module to enable access to the blog posts for users.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="blog" name="blog" value="1" <?php echo config("blog") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="contact" class="form-label mb-0 fw-bold"><?php ee('Contact Page') ?></label>
                            <p class="form-text my-0"><?php ee('Enable the contact page so users can contact you.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="contact" name="contact" value="1" <?php echo config("contact") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="report" class="form-label mb-0 fw-bold"><?php ee('Report Page') ?></label>
                            <p class="form-text my-0"><?php ee('Enable the report page so users can report links.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="report" name="report" value="1" <?php echo config("report") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="helpcenter" class="form-label mb-0 fw-bold"><?php ee('Help Center') ?></label>
                            <p class="form-text my-0"><?php ee('Enable dedicated help center where you can post articles.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="helpcenter" name="helpcenter" value="1" <?php echo config("helpcenter") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="ads" class="form-label mb-0 fw-bold"><?php ee('Advertisement') ?></label>
                            <p class="form-text my-0"><?php ee('Enable or disable advertisement throughout the site.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="ads" name="ads" value="1" <?php echo config("ads") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="detectablock" class="form-label mb-0 fw-bold"><?php ee('Adblock Detection') ?></label>
                            <p class="form-text my-0"><?php ee('Enable or disable adblock detection on redirection (splash and frame - does not work for pro users)') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="detectablock" name="detectadblock" value="1" <?php echo config("detectadblock") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="border rounded p-2 mb-3 align-items-center">
                        <div class="form-group d-flex mb-3">
                            <div>
                                <label for="cookieconsent[enabled]" class="form-label mb-0 fw-bold"><?php ee('Cookie Consent') ?></label>
                                <p class="form-text my-0"><?php ee('Enable cookie consent notification.') ?></p>
                            </div>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="cookieconsent[enabled]" name="cookieconsent[enabled]" value="1" <?php echo config("cookieconsent")->enabled ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="cookieconsentmessage,cookieconsentlink,cookieconsentforce">
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-center <?php echo config("cookieconsent")->enabled ? '':'d-none' ?>">
                            <div>
                                <label for="cookieconsent[force]" class="form-label mb-0 fw-bold"><?php ee('Enforce Cookie Consent') ?></label>
                                <p class="form-text mt-0"><?php ee('Enforce cookie policy user who have previously not agreed will be redirected to another page for consent.') ?></p>
                            </div>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="cookieconsent[force]" name="cookieconsent[force]" value="1" <?php echo config('cookieconsent')->force ? 'checked':'' ?>>
                            </div>
                        </div>                        
                        <div class="form-group <?php echo config("cookieconsent")->enabled ? '':'d-none' ?>">
                            <label for="cookieconsent[message]" class="form-label fw-bold"><?php ee('Cookie Consent Message') ?></label>
                            <input type="text" class="form-control" name="cookieconsent[message]" id="cookieconsentmessage" value="<?php echo config('cookieconsent')->message ?? '' ?>">
                            <p class="form-text"><?php ee('Enter your personalized message. You can also translate this by adding it manually. If you leave it empty, a pre-defined message will be shown.') ?></p>
                        </div>
                        <div class="form-group <?php echo config("cookieconsent")->enabled ? '':'d-none' ?>">
                            <label for="cookieconsent[link]" class="form-label fw-bold"><?php ee('Cookie Consent Link') ?></label>
                            <input type="text" class="form-control" name="cookieconsent[link]" id="cookieconsentlink" value="<?php echo config('cookieconsent')->link ?? '' ?>">
                            <p class="form-text"><?php ee('Enter the link to your cookie policy.') ?></p>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="api" class="form-label mb-0 fw-bold"><?php ee('Developer API') ?></label>
                            <p class="form-text my-0"><?php ee('Allow registered users to shorten URLs from their site using the API.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="api" name="api" value="1" <?php echo config("api") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="sharing" class="form-label mb-0 fw-bold"><?php ee('Sharing') ?></label>
                            <p class="form-text my-0"><?php ee('Allow users to share their shorten URL through social networks such as facebook and twitter.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="sharing" name="sharing" value="1" <?php echo config("sharing") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="update_notification" class="form-label mb-0 fw-bold"><?php ee('Update Notification') ?></label>
                            <p class="form-text my-0"><?php ee('Be notified when an update is available.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="update_notification" name="update_notification" value="1" <?php echo config("update_notification") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>