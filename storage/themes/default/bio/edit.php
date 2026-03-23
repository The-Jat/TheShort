<div class="d-flex mb-3">
    <div class="ms-auto">
        <button type="button" data-bs-toggle="modal" data-trigger="shortinfo" data-shorturl="<?php echo Helpers\App::shortRoute($url->domain, $bio->alias) ?>" class="btn bg-white text-black border rounded-3 shadow-sm py-2 px-3"><i class="text-black fw-bold me-2 fa fa-arrow-up-from-bracket"></i> <span class="align-top"><?php ee('Share') ?></span></button>
        <a href="<?php echo \Helpers\App::shortRoute($url->domain, $bio->alias) ?>" class="btn bg-white text-black border rounded-3 shadow-sm py-2 px-3" id="viewbio" target="_blank"><i class="text-black me-2 fw-bold fa fa-eye"></i> <span class="align-top"><?php ee('View Bio') ?></span></a>
    </div>
</div>
<div data-action="<?php echo route('bio.update', [$bio->id]) ?>">
    <div class="card rounded-4 card-body shadow-sm">
        <div class="d-block d-md-flex align-items-center">
            <ul class="nav nav-pills flex-fill nav-fill scrollable-nav">
                <li class="nav-item mb-md-0">
                    <a href="#links" class="nav-link text-muted active" data-trigger="switcher"><i class="fa fa-layer-group me-2"></i> <span><?php ee('Content') ?></span></a>
                </li>
                <li class="nav-item mb-md-0">
                    <a href="#social" class="nav-link text-muted" data-trigger="switcher"><i class="fa fa-share me-2"></i>  <span><?php ee('Social Links') ?></span></a>
                </li>
                <li class="nav-item mb-md-0">
                    <a href="#appearance" class="nav-link text-muted" data-trigger="switcher"><i class="fa fa-desktop me-2"></i>  <span><?php ee('Design') ?></span></a>
                </li>
                <li class="nav-item mb-md-0">
                    <a href="#advanced" class="nav-link text-muted" data-trigger="switcher"><i class="fa fa-cogs me-2"></i>  <span><?php ee('Settings') ?></span></a>
                </li>
                <li class="nav-item mb-md-0">
                    <a href="#data" class="nav-link text-muted" data-trigger="switcher"><i class="fa fa-download me-2"></i>  <span><?php ee('Data') ?></span></a>
                </li>
                <li class="nav-item mb-md-0">
                    <a href="<?php echo route('stats', [$bio->urlid]) ?>" class="nav-link text-muted"><i class="fa fa-chart-area me-2"></i>  <span><?php ee('Statistics') ?></span></a>
                </li>
            </ul>
        </div>
    </div>
    <?php echo csrf() ?>
    <div class="row">
        <div class="col-md-7" id="generator">
            <div class="collapse switcher show" id="links">
                <form id="bioinfo" action="<?php echo route('bio.update.settings', $bio->id) ?>" data-autosave>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-5 col-lg-3">
                                <div class="me-sm-3 mb-2 position-relative border rounded rounded-4">
                                    <a href="#" data-trigger="uploadavatar">
                                    <?php if(isset($bio->data->avatar)): ?>
                                        <img src="<?php echo uploads($bio->data->avatar, 'profile') ?>" class="rounded rounded-4 w-100" id="useravatar">
                                    <?php else: ?>
                                        <img src="<?php echo user()->avatar() ?>" class="rounded rounded-4 w-100" id="useravatar">
                                    <?php endif ?>
                                    </a>
                                    <div class="position-absolute top-0 end-0">
                                        <button type="button" class="btn btn-default btn-sm rounded-3 shadow-sm" data-trigger="uploadavatar" aria-expanded="false"><i data-feather="upload"></i></button>
                                        <input type="file" name="avatar" id="avatar" class="d-none" data-error="<?php ee('Avatar must be one the following formats {f} and be less than {s}kb.', null, ['f' => config('extensions')->bio->avatar, 's' => config('sizes')->bio->avatar]) ?>" data-max-size="<?php echo config('sizes')->bio->avatar ?>" data-allowed-extensions="<?php echo config('extensions')->bio->avatar ?>" data-preview-selector="#useravatar" data-auto-crop data-ratio="1:1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <label class="form-label fw-bold"><?php ee('Bio Page Name') ?></label>
                                    <input type="text" class="form-control p-2" name="name" placeholder="e.g. For Instagram" value="<?php echo $bio->name ?>" data-required>
                                </div>
                                <div class="form-group mt-4">
                                    <label class="form-label fw-bold"><?php ee('Bio Page Alias') ?></label>
                                    <div class="d-flex">
                                        <div class="input-select rounded">
                                            <select name="domain" id="domain" class="form-select p-2" data-toggle="select">
                                                <?php foreach($domains as $domain): ?>
                                                    <option value="<?php echo $domain ?>" <?php echo $domain == $url->domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <p class="form-text mb-0"><?php ee('Choose domain to generate the link with') ?></p>
                                        </div>
                                        <div class="ps-2">
                                            <input type="text" class="form-control p-2" name="custom" value="<?php echo $bio->alias ?>" placeholder="e.g. my-page">
                                            <p class="form-text mb-0"><?php ee('Leave this field empty to generate a random alias.') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-primary btn-lg w-100 py-3 rounded-4" data-bs-toggle="modal" data-bs-target="#contentModal"><i class="fa fa-plus me-2"></i> <?php ee('Add Link or Content') ?></button>
                </div>                
                <div id="linkcontent" class="mb-5"></div>
            </div>
            <div class="collapse switcher" id="social">
                <form id="biosocial" action="<?php echo route('bio.update.settings', $bio->id) ?>">
                    <h4 class="fw-bold mb-3"><?php ee('Social Links') ?></h4>
                    <div class="card rounded-4 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-select mb-1">
                                        <select name="platform" class="form-select p-2 ignore" data-toggle="select">
                                            <?php foreach($platforms as $key => $array): ?>
                                                <?php if(!isset($bio->data->social->{$key}) || empty($bio->data->social->{$key})): ?>
                                                    <option value="<?php echo $key ?>" data-icon="<?php echo urlencode($array['icon']) ?>"  data-icon-square="<?php echo urlencode($array['square'] ?? $array['icon']) ?>"><?php echo $array['name'] ?></option>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control p-2 ignore" name="socialink" placeholder="https://">
                                </div>
                            </div>
                            <button type="button" data-trigger="addsocial" class="btn btn-primary mt-3" data-error="<?php ee('Please enter a valid link') ?>" data-error-alt="<?php ee('You have already added a link to this platform') ?>"><?php ee('Add') ?></button>
                        </div>
                    </div>
                    <div class="border rounded rounded-4 p-2" id="sociallinksholder" data-autosave>
                        <?php if(isset($bio->data->social)): ?>
                            <?php foreach($bio->data->social as $name => $sociallink): ?>
                                <?php if(empty($sociallink) || !isset($platforms[$name])) continue ?>
                                <div class="card rounded-4 card-body shadow-sm border rounded p-2 mb-3 socialsortable">
                                    <div class="mb-3 d-flex align-items-center">                                    
                                        <i class="fs-4 fa fa-grip-vertical handle ms-1" data-bs-toggle="tooltip" title="<?php ee('Move') ?>"></i>
                                        <span class="ms-2 fw-bold"><?php echo $platforms[$name]['name'] ?></span>
                                        <div class="ms-auto d-flex align-items-center">
                                            <a class="ms-auto fs-6 pe-2" data-trigger="deletesocial" href=""><i class="fa fa-times text-dark fs-4" data-bs-toggle="tooltip" title="<?php ee('Delete') ?>"></i></a>
                                        </div>                                    
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-text bg-white text-dark"><?php echo $platforms[$name]['icon'] ?></div>
                                        <input type="text" class="form-control p-2" name="social[<?php echo $name ?>]" value="<?php echo $sociallink ?>" placeholder="https://" data-error="<?php ee('Please enter a valid link') ?>">
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>

                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Design') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm" data-autosave>                    
                        <label class="form-label fw-bold"><?php ee('Style') ?></label>
                        <div class="row">
                            <div class="col-6 mb-2" data-bs-toggle="tooltip">
                                <label data-trigger="chooseiconstyle" class="btn text-center border bg-white rounded p-2 h-100 me-1 fs-1 w-100 <?php echo isset($bio->data->style->iconstyle) && $bio->data->style->iconstyle == "normal" ? 'border-secondary': '' ?>">
                                    <span class="d-block"><i class="me-2 fab fa-facebook"></i> <i class="me-2 fab fa-x-twitter"></i> <i class="me-2 fab fa-youtube"></i> <i class="me-2 fab fa-instagram"></i></span>
                                    <input type="radio" name="iconstyle" value="normal" class="d-none" <?php echo isset($bio->data->style->iconstyle) && $bio->data->style->iconstyle == "normal" ? 'checked': '' ?>>
                                </label>
                            </div>
                            <div class="col-6 mb-2" data-bs-toggle="tooltip">
                                <label data-trigger="chooseiconstyle" class="btn text-center border bg-white rounded p-2 h-100 me-1 fs-1 w-100 <?php echo isset($bio->data->style->iconstyle) && $bio->data->style->iconstyle == "square" ? 'border-secondary': '' ?>">
                                    <span class="d-block"><i class="me-2 fab fa-square-facebook"></i> <i class="me-2 fab fa-square-x-twitter"></i> <i class="me-2 fab fa-square-youtube"></i> <i class="me-2 fab fa-square-instagram"></i></span>
                                    <input type="radio" name="iconstyle" value="square" class="d-none" <?php echo isset($bio->data->style->iconstyle) && $bio->data->style->iconstyle == "square" ? 'checked': '' ?>>
                                </label>
                            </div>
                        </div>
                    </div>

                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Settings') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm" data-autosave>
                        <div class="form-group">
                            <label class="form-label fw-bold"><?php ee('Position') ?></label>
                            <select name="socialposition" class="form-select p-2">
                                <option value="off"<?php echo isset($bio->data->style->socialposition) && $bio->data->style->socialposition == 'off' ? ' selected' : '' ?>><?php ee('Off') ?></option>
                                <option value="top"<?php echo isset($bio->data->style->socialposition) && $bio->data->style->socialposition == 'top' ? ' selected' : '' ?>><?php ee('Top') ?></option>
                                <option value="bottom"<?php echo isset($bio->data->style->socialposition) && $bio->data->style->socialposition == 'bottom' ? ' selected' : '' ?>><?php ee('Bottom') ?></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="collapse switcher" id="appearance">
                <form id="bioappearance" action="<?php echo route('bio.update.settings', $bio->id) ?>" data-autosave>
                    <h4 class="fw-bold mb-3"><?php ee('Header Layout') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="row">
                            <div class="col-md-4">
                                <label role="button" data-trigger="chooselayout" data-value="layout1" class="d-block text-center border rounded-3 mb-2 mb-sm-0 <?php echo !isset($bio->data->style->layout) || $bio->data->style->layout == 'layout1' ? 'border-secondary': '' ?>" style="height: 150px;">
                                    <svg width="200" height="150">
                                        <circle cx="50%" cy="50" r="40" stroke="#ccc" stroke-width="4" fill="#eee" />
                                        <rect x="50" y="110" width="100" height="20" fill="#ddd" />
                                    </svg>
                                    <input type="radio" name="layout" value="layout1" class="d-none" <?php echo !isset($bio->data->style->layout) || $bio->data->style->layout == 'layout1' ? 'checked': '' ?>>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label role="button" data-trigger="chooselayout" data-value="layout2" class="d-block text-center border rounded-3 mb-2 mb-sm-0 <?php echo isset($bio->data->style->layout) && $bio->data->style->layout == 'layout2' ? 'border-secondary': '' ?>" style="height: 150px;">
                                    <svg width="100%" height="150" class="rounded">
                                        <rect x="0" y="0" width="100%" height="50" fill="#222e3c" />
                                        <circle cx="50%" cy="50" r="40" stroke="#ccc" stroke-width="4" fill="#eee" />
                                        <rect x="50" y="110" width="100" height="20" fill="#ddd" />
                                    </svg>
                                    <input type="radio" name="layout" value="layout2" class="d-none" <?php echo isset($bio->data->style->layout) && $bio->data->style->layout == 'layout2' ? 'checked': '' ?>>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label role="button" data-trigger="chooselayout" data-value="layout3" class="d-block text-center border rounded-3 mb-2 mb-sm-0 <?php echo isset($bio->data->style->layout) && $bio->data->style->layout == 'layout3' ? 'border-secondary': '' ?>" style="height: 150px;">
                                    <svg width="100%" height="150" class="rounded">
                                        <rect x="0" y="0" width="100%" height="150" fill="#222e3c" />
                                        <circle cx="40" cy="70" r="30" stroke="#ccc" stroke-width="4" fill="#eee" />
                                        <rect x="80" y="60" width="100" height="20" fill="#ddd" />
                                    </svg>
                                    <input type="radio" name="layout" value="layout3" class="d-none" <?php echo isset($bio->data->style->layout) && $bio->data->style->layout == 'layout3' ? 'checked': '' ?>>
                                </label>
                            </div>
                        </div>

                        <div class="form-group collapse mt-3 <?php echo isset($bio->data->style->layout) && ($bio->data->style->layout == 'layout2' || $bio->data->style->layout == 'layout3') ? 'show': '' ?>" id="layoutbanner">
                            <label for="layoutbannerupload" class="form-label fw-bold"><?php ee('Header Banner') ?></label>
                            <div class="mb-2">
                                <label for="layoutbannerupload" role="button" class="d-block">
                                    <?php if(isset($bio->data->layoutbanner) && $bio->data->layoutbanner): ?>
                                        <img src="<?php echo uploads($bio->data->layoutbanner, 'profile') ?>" class="w-100 rounded-3 border shadow-sm" id="layoutbanner-preview">
                                    <?php else: ?>
                                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDIwMCAxMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjIwMCIgaGVpZ2h0PSIxMDAiIGZpbGw9InRyYW5zcGFyZW50Ii8+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoODAsIDMwKSBzY2FsZSgwLjEpIj48cGF0aCBkPSJNMzQ0LjA1OCwyMDcuNTA2Yy0xNi41NjgsMC0zMCwxMy40MzItMzAsMzB2NzYuNjA5aC0yNTR2LTc2LjYwOWMwLTE2LjU2OC0xMy40MzItMzAtMzAtMzBjLTE2LjU2OCwwLTMwLDEzLjQzMi0zMCwzMHYxMDYuNjA5YzAsMTYuNTY4LDEzLjQzMiwzMCwzMCwzMGgzMTRjMTYuNTY4LDAsMzAtMTMuNDMyLDMwLTMwVjIzNy41MDZDMzc0LjA1OCwyMjAuOTM4LDM2MC42MjYsMjA3LjUwNiwzNDQuMDU4LDIwNy41MDZ6Ii8+PHBhdGggZD0iTTEyMy41NywxMzUuOTE1bDMzLjQ4OC0zMy40ODh2MTExLjc3NWMwLDE2LjU2OCwxMy40MzIsMzAsMzAsMzBjMTYuNTY4LDAsMzAtMTMuNDMyLDMwLTMwVjEwMi40MjZsMzMuNDg4LDMzLjQ4OGM1Ljg1Nyw1Ljg1OCwxMy41MzUsOC43ODcsMjEuMjEzLDguNzg3YzcuNjc4LDAsMTUuMzU1LTIuOTI5LDIxLjIxMy04Ljc4N2MxMS43MTYtMTEuNzE2LDExLjcxNi0zMC43MSwwLTQyLjQyNkwyMDguMjcxLDguNzg4Yy0xMS43MTUtMTEuNzE3LTMwLjcxMS0xMS43MTctNDIuNDI2LDBMODEuMTQ0LDkzLjQ4OWMtMTEuNzE2LDExLjcxNi0xMS43MTYsMzAuNzEsMCw0Mi40MjZDMTAyLjg1OSwxNDcuNjMxLDEyMS44NTUsMTQ3LjYzMSwxMjMuNTcsMTM1LjkxNXoiLz48L2c+PC9zdmc+" class="w-100 rounded-3 border shadow-sm" id="layoutbanner-preview">
                                    <?php endif ?>
                                </label>
                            </div>
                            <div>
                                <label for="layoutbannerupload" role="button" class="btn btn-sm btn-dark fw-bold rounded-3 py-2 shadow-sm me-2">
                                    <?php ee('Upload Banner') ?>
                                </label>
                                <p class="form-text"><?php ee("Banner must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->banner, 's' => config('sizes')->bio->banner]) ?></p>
                                <input type="file" name="layoutbanner" id="layoutbannerupload" class="d-none" accept="image/*" data-auto-crop data-ratio="16:7" data-max-size="<?php echo config('sizes')->bio->banner ?>" data-allowed-extensions="<?php echo config('extensions')->bio->banner ?>" data-preview-selector="#layoutbanner-preview" data-error="<?php ee("Banner must be one the following formats {f} and be less than {s}kb.", null, ['f' => config('extensions')->bio->banner, 's' => config('sizes')->bio->banner]) ?>">
                            </div>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Themes') ?></h4>
                    <input type="hidden" name="themeid" value="<?php echo $bio->data->themeid ?>">
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="row mt-3">
                            <div class="col-6 col-sm-4 col-xl-3 mb-2">
                                <div role="button" class="d-flex align-items-center justify-content-center overflow-hidden border border-2 rounded-3 bg-light p-3 <?php echo !isset($bio->data->themeid) || !$bio->data->themeid ? 'theme-active' : '' ?>" style="height:100px;" data-trigger="changetheme" data-value="-1" data-bs-toggle="tooltip" title="<?php ee('Custom') ?>">
                                    <div class="pt-3">
                                        <h3 class="d-block text-center text-muted"><i class="fa fa-brush"></i></h3>
                                        <p class="text-center text-muted"><?php ee('Custom') ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php foreach($themes as $theme): ?>
                                <div class="col-6 col-sm-4 col-xl-3 mb-2">
                                    <div id="theme-<?php echo $theme->id ?>" role="button" class="d-block border border-2 rounded-3 p-3 overflow-hidden position-relative <?php echo $theme->id == $bio->data->themeid ? 'theme-active' : '' ?><?php echo isset($theme->disabled) && $theme->disabled ? ' theme-disabled' : '' ?>" style="height:100px;<?php echo $theme->data->style??'' ?><?php echo isset($theme->data->fontStyle) ? ' '.$theme->data->fontStyle : '' ?>" data-trigger="changetheme" data-value="<?php echo $theme->id ?>" data-bs-toggle="tooltip" title="<?php echo $theme->name ?>">
                                        <h3 class="d-block" style="color:<?php echo $theme->data->textcolor ?>"><?php ee('Aa') ?></h3>
                                        <a href="#" class="d-block py-1 text-decoration-none text-center" style="<?php echo $theme->data->button ??'' ?>"><?php ee('Link') ?></a>
                                        <?php if(isset($theme->disabled) && $theme->disabled): ?>
                                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: rgba(0, 0, 0, 0.7); border-radius: 0.5rem;">
                                                <a href="<?php echo route('pricing') ?>" class="text-white text-decoration-none" data-bs-toggle="tooltip" title="<?php ee('Upgrade to unlock this theme') ?>">
                                                    <i class="fa fa-lock fa-2x"></i>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Fonts') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="row" data-toggle="buttons">
                            <?php foreach(['Arial', 'Helvetica_Neue', 'Courier_New', 'Times_New_Roman', 'Comic_Sans_MS', 'Verdana', 'Impact', 'Tahoma'] as $font): ?>
                                <div class="col-4 col-xl-2 mb-2" data-bs-toggle="tooltip" title="<?php echo str_replace(['_', '+'], ' ', $font) ?>">
                                    <label data-trigger="choosefont" class="<?php echo strtolower("font-{$font}") ?> btn text-center border bg-white rounded p-2 h-100 me-1 fs-1 w-100 <?php echo isset($bio->data->style->font) && $bio->data->style->font == str_replace('_', '+', $font) ? 'border-secondary': '' ?>">
                                        <span class="d-block"><strong>A</strong>B<i>C</i></span>
                                        <input type="radio" name="fonts" value="<?php echo str_replace('_', '+', $font) ?>" class="d-none" <?php echo isset($bio->data->style->font) && $bio->data->style->font == str_replace('_', '+', $font) ? 'checked': '' ?>>
                                    </label>
                                </div>
                            <?php endforeach ?>
                            <?php foreach(\Helpers\App::fonts() as $font): ?>
                                <div class="col-4 col-xl-2 mb-2" data-bs-toggle="tooltip" title="<?php echo str_replace(['_', '+'], ' ', $font) ?>">
                                    <label data-trigger="choosefont" class="<?php echo strtolower("font-{$font}") ?> btn text-center border bg-white rounded p-2 h-100 me-1 fs-1 w-100 <?php echo isset($bio->data->style->font) && $bio->data->style->font == str_replace('_', '+', $font) ? 'border-secondary': '' ?>">
                                        <span class="d-block"><strong>A</strong>B<i>C</i></span>
                                        <input type="radio" name="fonts" value="<?php echo str_replace('_', '+', $font) ?>" class="d-none" <?php echo isset($bio->data->style->font) && $bio->data->style->font == str_replace('_', '+', $font) ? 'checked': '' ?>>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <h5 class="mt-4 fw-bold"><?php ee('Text Color') ?></h5>
                        <div class="form-group mb-4">
                            <input type="text" name="textcolor" id="textcolor" value="<?php echo $bio->data->style->textcolor ?? '' ?>" data-default="<?php echo $bio->data->style->textcolor ?? '' ?>" data-trigger="color">
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Custom Background') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm" id="background">
                        <h5 class="fw-bold"><?php ee('Background') ?></h5>
                        <div class="mb-3 mt-3">
                            <div data-toggle="buttons">
                                <a href="#singlecolor" id="forsinglecolor" class="btn btn text-center border bg-white rounded p-2 h-100 me-1 <?php echo isset($bio->data->style->mode) && $bio->data->style->mode == 'singlecolor' ? 'border-secondary' : '' ?>" data-trigger="bgtype"><?php ee('Single Color') ?></a>
                                <a href="#gradient" id="forgradient" class="btn btn text-center border bg-white rounded p-2 h-100 me-1 <?php echo isset($bio->data->style->mode) && $bio->data->style->mode == 'gradient' ? 'border-secondary' : '' ?>" data-trigger="bgtype"><?php ee('Gradient Color') ?></a>
                                <a href="#image" id="forimage" class="btn btn text-center border bg-white rounded p-2 h-100 me-1 <?php echo isset($bio->data->style->mode) && $bio->data->style->mode == 'image' ? 'border-secondary' : '' ?>" data-trigger="bgtype"><?php ee('Image') ?></a>
                            </div>
                        </div>
                        <input type="hidden" name="mode" value="<?php echo $bio->data->style->mode ?? 'singlecolor' ?>">
                        <div id="singlecolor" class="collapse bgtype <?php echo isset($bio->data->style->mode) && $bio->data->style->mode == 'singlecolor' ? 'show' : '' ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="bg"><?php ee("Background") ?></label><br>
                                        <input type="text" name="bg" id="bg" value="<?php echo $bio->data->style->bg ?>" data-default="<?php echo $bio->data->style->bg ?? '' ?>" data-trigger="color">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="gradient" class="collapse bgtype <?php echo isset($bio->data->style->mode) && $bio->data->style->mode == 'gradient' ? 'show' : '' ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="bgst"><?php ee("Gradient Start") ?></label><br>
                                        <input type="text" name="gradient[start]" id="bgst" value="<?php echo $bio->data->style->gradient->start ?? '' ?>" data-trigger="color">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold" for="bgsp"><?php ee("Gradient Stop") ?></label><br>
                                        <input type="text" name="gradient[stop]" id="bgsp" value="<?php echo $bio->data->style->gradient->stop ?? '' ?>" data-trigger="color">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="gradientangle"><?php ee("Gradient Angle") ?></label><br>
                                <input type="range" id="gradientangle" name="gradient[angle]" min="0" max="360" value="<?php echo $bio->data->style->gradient->angle ?? '135' ?>" class="form-range">
                            </div>
                        </div>
                        <div id="image" class="collapse bgtype <?php echo isset($bio->data->style->mode) && $bio->data->style->mode == 'image' ? 'show' : '' ?>">
                            <input type="file" class="form-control mb-4" name="bgimage" id="bgimage" data-error="<?php ee('Please choose a valid background image. JPG, PNG') ?>" data-size="<?php echo config('sizes')->bio->background ?>">
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Buttons') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group mb-4">
                            <div class="d-flex align-items-center text-black">
                                <div>
                                    <label class="form-check-label fw-bold" for="frost"><?php ee('Frosted Glass Effect') ?></label>
                                    <p class="form-text mb-0 mt-1"><?php ee('Apply a frosted glass blur effect to buttons and cards using the button color') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="frost" name="frost" value="1" <?php echo isset($bio->data->style->frost) && $bio->data->style->frost ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                        <h5 class="fw-bold"><?php ee('Button Color') ?></h5>
                        <div class="form-group mb-4">
                            <input type="text" name="buttoncolor" id="buttoncolor" value="<?php echo $bio->data->style->buttoncolor ?? '' ?>" data-trigger="color">
                        </div>
                        <h5 class="fw-bold"><?php ee('Button Text Color') ?></h5>
                        <div class="form-group mb-4">
                            <input type="text" name="buttontextcolor" id="buttontextcolor" value="<?php echo $bio->data->style->buttontextcolor ?? '' ?>" data-trigger="color">
                        </div>
                        <h5 class="fw-bold"><?php ee('Button Style') ?></h5>
                        <div class="form-group mb-4">
                            <select name="buttonstyle" id="buttonstyle" class="form-select p-2">
                                <option value="none"<?php echo isset($bio->data->style->buttonstyle) && $bio->data->style->buttonstyle == 'none' ? ' selected' : '' ?>><?php ee('None') ?></option>
                                <option value="rectangular"<?php echo isset($bio->data->style->buttonstyle) && $bio->data->style->buttonstyle == 'rectangular' ? ' selected' : '' ?>><?php ee('Rectangular') ?></option>
                                <option value="rounded"<?php echo isset($bio->data->style->buttonstyle) && $bio->data->style->buttonstyle == 'rounded' ? ' selected' : '' ?>><?php ee('Rounded') ?></option>
                                <option value="trec"<?php echo isset($bio->data->style->buttonstyle) && $bio->data->style->buttonstyle == 'trec' ? ' selected' : '' ?>><?php ee('Transparent') ?> <?php ee('Rectangular') ?></option>
                                <option value="tro"<?php echo isset($bio->data->style->buttonstyle) && $bio->data->style->buttonstyle == 'tro' ? ' selected' : '' ?>><?php ee('Transparent') ?> <?php ee('Rounded') ?></option>
                            </select>
                        </div>
                        <h5 class="fw-bold"><?php ee('Button Shadow') ?></h5>
                        <div class="form-group mb-4">
                            <select name="shadow" id="shadow" class="form-select p-2">
                                <option value="none"<?php echo isset($bio->data->style->shadow) && $bio->data->style->shadow == 'none' ? ' selected' : '' ?>><?php ee('None') ?></option>
                                <option value="soft"<?php echo isset($bio->data->style->shadow) && $bio->data->style->shadow == 'soft' ? ' selected' : '' ?>><?php ee('Soft') ?></option>
                                <option value="hard"<?php echo isset($bio->data->style->shadow) && $bio->data->style->shadow == 'hard' ? ' selected' : '' ?>><?php ee('Hard') ?></option>
                            </select>
                        </div>
                        <h5 class="fw-bold"><?php ee('Shadow Color') ?></h5>
                        <div class="form-group mb-4">
                            <input type="text" name="shadowcolor" id="shadowcolor" data-trigger="color" value="<?php echo $bio->data->style->shadowcolor ?? '' ?>" data-default="<?php echo $bio->data->style->shadowcolor ?? '' ?>">
                        </div>
                    </div>
                </form>
			</div>
            <div class="collapse switcher" id="advanced">
                <form id="biooptions" action="<?php echo route('bio.update.settings', $bio->id) ?>" data-autosave>
                    <h4 class="fw-bold mb-3"><?php ee('SEO') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label fw-bold"><?php ee('Meta Title') ?></label>
                            <input type="text" class="form-control p-2" name="title" id="title" autocomplete="off" value="<?php echo $url->meta_title ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label fw-bold"><?php ee('Meta Description') ?></label>
                            <textarea class="form-control" name="description" id="description" autocomplete="off"><?php echo $url->meta_description ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label fw-bold"><?php ee('Meta Image') ?></label>
                            <input type="file" class="form-control" name="metaimage" id="metaimage" autocomplete="off">
                        </div>
                        <?php if(user()->has('customfavicon')): ?>
                        <div class="form-group">
                            <label for="description" class="form-label fw-bold"><?php ee('Custom Favicon') ?></label>
                            <input type="file" class="form-control" name="customfavicon" id="customfavicon" autocomplete="off">
                        </div>
                        <?php endif ?>
                    </div>
                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Settings') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <label class="form-check-label fw-bold" for="avatarenabled"><?php ee('Display Avatar') ?></label>
                                        <p class="form-text mb-0 mt-1"><?php ee('Display or hide your avatar from your Bio page') ?></p>
                                    </div>
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="avatarenabled" name="avatarenabled" value="1" data-toggle="togglefield" data-toggle-for="avatarstyle" <?php echo $bio->data->avatarenabled ? 'checked' : ''?>>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 <?php echo !$bio->data->avatarenabled ? 'd-none' : ''?>">
                                <label class="form-label fw-bold" for="avatarstyle"><?php ee('Avatar Style') ?></label>
                                <select name="avatarstyle" class="form-select rounded p-2" id="avatarstyle">
                                    <option value="rounded"<?php echo !isset($bio->data->avatarstyle) || $bio->data->avatarstyle == 'rounded' ? ' selected' : '' ?>><?php ee('Rounded') ?></option>
                                    <option value="rectangular" <?php echo isset($bio->data->avatarstyle) && $bio->data->avatarstyle == 'rectangular' ? ' selected' : '' ?>><?php ee('Rectangular') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-4 card-body shadow-sm">
                        <?php if(user()->verified): ?>
                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <label class="form-check-label fw-bold" for="verified"><?php ee('Verified Badge') ?></label>
                                        <p class="form-text mb-0 mt-1"><?php ee('Display the verified badge on this Bio Page') ?></p>
                                    </div>
                                    <div class="form-check form-switch ms-auto">
                                        <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="verified" name="verified" value="1" <?php echo isset($bio->data->settings->verified) && $bio->data->settings->verified ? 'checked' : '' ?>>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group">
                            <div class="d-flex">
                                <div>
                                    <label class="form-check-label fw-bold" for="sensitive"><?php ee('Sensitive Content') ?></label>
                                    <p class="form-text mb-0 mt-1"><?php ee('Sensitive content warns users before showing them the Bio Page') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="sensitive" name="sensitive" value="1" <?php echo isset($bio->data->settings->sensitive) && $bio->data->settings->sensitive ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <div>
                                    <label class="form-check-label fw-bold" for="agerestriction"><?php ee('Age Restriction') ?></label>
                                    <p class="form-text mb-0 mt-1"><?php ee('Require users to verify their age before accessing the Bio Page') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" data-bs-toggle="collapse" data-bs-target="#agerestrictionSettings" id="agerestriction" name="agerestriction" value="1" <?php echo isset($bio->data->settings->agerestriction) && $bio->data->settings->agerestriction ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                        <div class="collapse mt-3 <?php echo isset($bio->data->settings->agerestriction) && $bio->data->settings->agerestriction ? 'show' : '' ?>" id="agerestrictionSettings">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="minimumage"><?php ee('Minimum Age') ?></label>
                                <input type="number" class="form-control p-2" id="minimumage" name="minimumage" min="13" max="100" value="<?php echo isset($bio->data->settings->minimumage) ? (int)$bio->data->settings->minimumage : '18' ?>" placeholder="18">
                                <p class="form-text mb-0"><?php ee('Minimum age required to access this page') ?></p>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold" for="ageredirect"><?php ee('Redirect URL for Minors') ?></label>
                                <input type="url" class="form-control p-2" id="ageredirect" name="ageredirect" value="<?php echo isset($bio->data->settings->ageredirect) ? htmlspecialchars($bio->data->settings->ageredirect) : '' ?>" placeholder="https://example.com">
                                <p class="form-text mb-0"><?php ee('URL to redirect users who are under the minimum age') ?></p>
                            </div>
                        </div>
                    </div> 
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group">
                            <div class="d-flex">
                                <div>
                                    <label class="form-check-label fw-bold" for="cookie"><?php ee('Cookie Popup') ?></label>
                                    <p class="form-text mb-0 mt-1"><?php ee('Cookie popup allows users to review cookie collection terms') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="cookie" name="cookie" value="1" <?php echo isset($bio->data->settings->cookie) && $bio->data->settings->cookie ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group">
                            <div class="d-flex">
                                <div>
                                    <label class="form-check-label fw-bold" for="share"><?php ee('Share Icon') ?></label>
                                    <p class="form-text mb-0 mt-1"><?php ee('Share icon allows users to quickly share the Bio Page') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="share" name="share" value="1" <?php echo isset($bio->data->settings->share) && $bio->data->settings->share ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="card rounded-4 card-body shadow-sm">
                        <div class="form-group">
                            <div class="d-flex <?php echo !user()->has('poweredby') ? 'text-muted' : '' ?>" <?php echo !user()->has('poweredby') ? 'data-bs-toggle="tooltip" title="'.e('Please choose a premium package to unlock this feature').'"' : '' ?>>
                                <div>
                                    <label class="form-check-label fw-bold" for="branding"><?php ee('Remove Branding') ?></label>
                                    <p class="form-text mb-0 mt-1"><?php ee('Remove our branding from your Bio Page.') ?></p>
                                </div>
                                <div class="form-check form-switch ms-auto">
                                    <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="branding" name="branding" value="1" <?php echo isset($bio->data->settings->branding) && $bio->data->settings->branding ? 'checked' : '' ?> <?php echo !user()->has('poweredby') ? 'disabled' : '' ?>>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="card rounded-4 card-body shadow-sm">
                        <label for="pass" class="form-label fw-bold"><?php ee('Password Protection') ?></label>
                        <p class="form-text mt-0"><?php ee('By adding a password, you can restrict the access') ?></p>
                        <div class="form-group">                            
                            <input type="text" class="form-control p-2" name="pass" id="pass" value="<?php echo $url->pass ?>" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
                        </div>
                    </div> 
                    <div class="card rounded-4 card-body shadow-sm">
                        <?php if(\Core\Auth::user()->has("pixels") !== false):?>
                        <div id="pixels">
                            <label class="form-label fw-bold"><?php echo e("Targeting Pixels")?></label>
                            <p class="form-text mt-0"><?php echo e('Add your targeting pixels below from the list. Please make sure to enable them in the pixels settings.')?></p>
                            <div class="input-group input-select rounded">
                                <select name="pixels[]" data-placeholder="Your Pixels" multiple data-toggle="select" placeholder="<?php echo e("Your Pixels")?>">
                                    <?php foreach(\Core\Auth::user()->pixels() as $type => $pixels): ?>
                                        <optgroup label="<?php echo ucwords($type) ?>">
                                        <?php foreach($pixels as $pixel): ?>
                                            <option value="<?php echo $pixel->type ?>-<?php echo $pixel->id ?>" <?php echo in_array($pixel->type.'-'.$pixel->id, explode(',', $url->pixels ?? '')) ? 'selected': '' ?>><?php echo $pixel->name ?></option>
                                        <?php endforeach ?>
                                        </optgroup>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>
                    <h4 class="fw-bold mb-3 mt-5"><?php ee('Custom CSS') ?></h4>
                    <div class="card rounded-4 card-body shadow-sm">
                        <?php if(user()->has('biocss')): ?>
                            <div class="form-group">
                                <textarea class="form-control" name="customcss" id="customcss" rows="5" placeholder="e.g. .btn { display: block }"><?php echo $bio->data->style->custom ?></textarea>
                            </div>                        
                        <?php else: ?>
                            <div class="form-group">
                                <textarea class="form-control" name="customcss" id="customcss" rows="5" placeholder="e.g. .btn { display: block }" disabled data-bs-toggle="tooltip" title="<?php ee('Upgrade to unlock this feature') ?>"></textarea>
                            </div>                        
                        <?php endif ?>
                    </div>
                </form>
            </div>
            <div class="collapse switcher" id="data">
                <div class="card rounded-4 card-body shadow-sm">
                    <?php ee('You will be able to download submitted data here once available.') ?>
                </div>
                <?php if(isset($bio->responses->newsletter)): ?>
                    <h4 class="fw-bold mb-3"><?php ee("Newsletter Emails") ?></h4>
                    <div class="card rounded-4 mb-5">
                        <div class="card-body">
                            <p><?php ee('Collected {c} emails in total', null, ['c' => '<strong>'.count($bio->responses->newsletter).'</strong>']) ?></p>
                            <a href="?newsletterdata=1" class="btn btn-success"><?php ee('Download as CSV') ?></a>
                        </div>
                    </div>
                <?php endif ?>
                <?php if(isset($bio->responses->contactform)): ?>
                    <h4 class="fw-bold mb-3"><?php ee("Contact Form") ?></h4>
                    <?php foreach($bio->responses->contactform as $contact): ?>
                        <div class="card rounded-4 mb-2">
                            <div class="card-header bg-transparent">
                                <?php ee('Contacted by {e} on {t}', null, ['e' => "<strong>{$contact->from}</strong>", 't' => date('d-m-Y h:i')]) ?>
                            </div>
                            <div class="card-body pt-0">                    
                                <p class="mb-2"><?php echo $contact->message ?></p>
                                <a href="mailto:<?php echo $contact->from ?>?subject=Re:+Contact" class="text-muted fw-bold"><?php ee('Reply') ?></a>
                            </div>
                        </div>
                    <?php endforeach ?>    
                <?php endif ?>
            </div>
        </div>
        <div class="col-md-5 d-flex justify-content-center">
            <div class="card rounded-5 border-0 card-rounded card-preview ms-0 ms-lg-4 w-100">
                <iframe src="<?php echo route('bio.preview', $bio->id) ?>" width="100%" height="100%" class="js-simplebar"></iframe>
            </div>
        </div>
    </div>
</div>
<?php view('bio.widgets') ?>