<section class="slice slice-lg py-7 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-secondary', 'bg-section-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
    <div class="container pt-xl-6">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <h2 class="mb-5 text-center <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?>"><?php ee('Help Center') ?></h2>
                    <form action="<?php echo route('help.search') ?>">
                        <div class="form-group bg-neutral rounded-pill mb-0 px-2 py-2 shadow">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-merge shadow-none">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-0"><i data-feather="search"></i></span>
                                        </div>
                                        <input type="text" name="q" class="form-control form-control-flush shadow-none" value="<?php echo clean(request()->q ?? '') ?>" placeholder="<?php ee('Search') ?>...">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-block btn-dark rounded-pill"><?php ee('Search') ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>