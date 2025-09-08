<h1 class="h3 mb-5 fw-bold"><?php ee('Upload Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <?php echo csrf() ?>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold"><?php ee('File Size Limits') ?></label>
                        <div class="card rounded-4">
                            <div class="card-body">
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold"><?php ee('Avatar Size (kb)') ?></label>
                                    <input type="number" class="form-control p-2" name="sizes[avatar]" value="<?php echo config('sizes')->avatar ?>">
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold"><?php ee('Bio Pages Sizes') ?></label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label class="form-label"><?php ee('Avatar (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[bio][avatar]" value="<?php echo config('sizes')->bio->avatar ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label class="form-label"><?php ee('Background (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[bio][background]" value="<?php echo config('sizes')->bio->background ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label class="form-label"><?php ee('Image (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[bio][image]" value="<?php echo config('sizes')->bio->image ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label class="form-label"><?php ee('Link (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[bio][link]" value="<?php echo config('sizes')->bio->link ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="form-group mb-2">
                                                <label class="form-label"><?php ee('Banner (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[bio][banner]" value="<?php echo config('sizes')->bio->banner ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold"><?php ee('Splash Pages Sizes') ?></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="form-label"><?php ee('Avatar (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[splash][avatar]" value="<?php echo config('sizes')->splash->avatar ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label class="form-label"><?php ee('Banner (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[splash][banner]" value="<?php echo config('sizes')->splash->banner ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold"><?php ee('QR Code Sizes') ?></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php ee('QR File Size (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[qrfile]" value="<?php echo config('sizes')->qrfile ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php ee('QR CSV Size (kb)') ?></label>
                                                <input type="number" class="form-control p-2" name="sizes[qrcsv]" value="<?php echo config('sizes')->qrcsv ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold"><?php ee('Allowed Extensions') ?></label>
                        <p><?php ee('Separate extensions with comma') ?></p>
                        <div class="card rounded-4">
                            <div class="card-body">
                                <div class="form-group border rounded mb-2 p-2 mb-3">
                                    <label class="form-label fw-bold"><?php ee('Avatar Extensions') ?></label>
                                    <input type="text" class="form-control p-2" name="extensions[avatar]" value="<?php echo config('extensions')->avatar ?>" placeholder="jpg,png" data-toggle="tags">
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold"><?php ee('Bio Pages Extensions') ?></label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group border rounded mb-2 p-2">
                                                <label class="form-label"><?php ee('Avatar') ?></label>
                                                <input type="text" class="form-control p-2" name="extensions[bio][avatar]" value="<?php echo config('extensions')->bio->avatar ?>" placeholder="jpg,png"  data-toggle="tags">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group border rounded mb-2 p-2">
                                                <label class="form-label"><?php ee('Background') ?></label>
                                                <input type="text" class="form-control p-2" name="extensions[bio][background]" value="<?php echo config('extensions')->bio->background ?>" placeholder="jpg,png"  data-toggle="tags">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group border rounded mb-2 p-2">
                                                <label class="form-label"><?php ee('Image') ?></label>
                                                <input type="text" class="form-control p-2" name="extensions[bio][image]" value="<?php echo config('extensions')->bio->image ?>" placeholder="jpg,png"  data-toggle="tags">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group border rounded mb-2 p-2">
                                                <label class="form-label"><?php ee('Link') ?></label>
                                                <input type="text" class="form-control p-2" name="extensions[bio][link]" value="<?php echo config('extensions')->bio->link ?>" placeholder="jpg,png"  data-toggle="tags">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group border rounded mb-2 p-2">
                                                <label class="form-label"><?php ee('Banner') ?></label>
                                                <input type="text" class="form-control p-2" name="extensions[bio][banner]" value="<?php echo config('extensions')->bio->banner ?>" placeholder="jpg,png"  data-toggle="tags">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label fw-bold"><?php ee('Splash Pages Extensions') ?></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group border rounded mb-2 p-2">
                                                <label class="form-label"><?php ee('Avatar') ?></label>
                                                <input type="text" class="form-control p-2" name="extensions[splash][avatar]" value="<?php echo config('extensions')->splash->avatar ?>" placeholder="jpg,png"  data-toggle="tags">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group border rounded mb-2 p-2">
                                                <label class="form-label"><?php ee('Banner') ?></label>
                                                <input type="text" class="form-control p-2" name="extensions[splash][banner]" value="<?php echo config('extensions')->splash->banner ?>" placeholder="jpg,png"  data-toggle="tags">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>