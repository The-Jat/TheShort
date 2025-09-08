<div class="modal fade" id="quickshortener" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold"><?php ee('Quick Shortener') ?></h5>
                <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo route('shorten') ?>" method="post" data-trigger="shorten-form">
                    <?php echo csrf() ?>
                    <div class="d-flex items-align-center border rounded">
                        <div class="flex-grow-1" id="linksinput">
                            <div id="single" class="collapse show" data-bs-parent="#linksinput">
                                <input type="text" class="form-control p-3 border-0" name="url" id="url" placeholder="<?php ee('Paste a long link') ?>">
                            </div>
                        </div>
                        <div class="align-self-center me-3">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default border" data-bs-toggle="collapse" data-bs-target="#qsadvancedOptions"><i data-feather="sliders"></i></button>
                                <button type="submit" class="btn btn-primary rounded-3 px-3 py-2">
                                    <span class="d-none d-sm-block"><?php ee('Shorten') ?></span>
                                    <span class="d-block d-sm-none"><i class="fa fa-link"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="qsadvancedOptions">
                        <div class="row">
                            <?php if($domains = \Helpers\App::domains()): ?>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group rounded input-select">
                                    <label for="qsdomain" class="form-label fw-bold"><?php ee('Domain') ?></label>
                                    <select name="domain" id="qsdomain" class="form-select border-start-0 ps-0" data-toggle="select">
                                        <?php foreach($domains as $domain): ?>
                                            <option value="<?php echo $domain ?>" <?php echo user()->domain == $domain ? 'selected' : '' ?>><?php echo $domain ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif ?>
                            <?php if($redirects = \Helpers\App::redirects()): ?>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group rounded input-select">
                                    <label for="qstype" class="form-label fw-bold"><?php ee('Redirect') ?></label>
                                    <select name="type" id="qstype" class="form-select border-start-0 ps-0" data-toggle="select">
                                        <?php foreach($redirects as $name => $redirect): ?>
                                            <optgroup label="<?php echo $name ?>">
                                            <?php foreach($redirect as $id => $name): ?>
                                                <option value="<?php echo $id ?>" <?php echo user()->defaulttype == $id ? 'selected' : '' ?>><?php echo $name ?></option>
                                            <?php endforeach ?>
                                            </optgroup>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif ?>
                        </div>
                        <div class="row">
                            <?php if(\Core\Auth::user()->has("alias") !== false): ?>
                            <div class="col-sm-6 mt-3">
                                <div class="form-group">
                                    <label for="qscustom" class="form-label fw-bold"><?php ee('Custom') ?></label>
                                    <p class="form-text"><?php ee('If you need a custom alias, you can enter it below.') ?></p>
                                    <div class="input-group">
                                        <div class="input-group-text bg-white"><i data-feather="globe"></i></div>
                                        <input type="text" class="form-control border-start-0 ps-0 p-2" name="custom" id="qscustom" placeholder="<?php echo e("Type your custom alias here")?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <?php endif ?>
                            <?php if(\Core\Auth::user()->has("channels") !== false): ?>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="qschannel" class="form-label fw-bold"><?php echo e("Channel")?></label>
                                    <p class="form-text"><?php echo e('Assign link to a channel.')?></p>
                                    <div class="form-group rounded input-select">
                                        <select name="channel" id="qschannel" class="form-select" data-toggle="select">>
                                            <option value="0"><?php ee('None') ?></option>
                                            <?php foreach(\Core\DB::channels()->where('userid', user()->rID())->findArray() as $channel): ?>
                                                <option value="<?php echo $channel['id'] ?>"><?php echo $channel['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php endif ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="qspass" class="form-label fw-bold"><?php ee('Password Protection') ?></label>
                                    <p class="form-text"><?php ee('By adding a password, you can restrict the access.') ?></p>
                                    <div class="input-group">
                                        <div class="input-group-text bg-white"><i data-feather="lock"></i></div>
                                        <input type="text" class="form-control border-start-0 ps-0 p-2" name="pass" id="qspass" placeholder="<?php echo e("Type your password here")?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="qsdescription" class="form-label fw-bold"><?php echo e("Description")?></label>
                                    <p class="form-text"><?php echo e('This can be used to identify URLs on your account.')?></p>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i data-feather="tag"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0 p-2" name="description" id="qsdescription" placeholder="<?php echo e("Type your description here")?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>                                
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <button type="button" class="btn btn-transparent border-0 p-0 ms-auto" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="d-block">
            <div class="modal-qr">
                <p class="text-center"></p>
            </div>
            <button class="d-flex align-items-center w-100 bg-white border shadow-sm rounded-3 p-3 copy mt-2" data-clipboard-text="">
                <i class="fa fa-link me-2"></i>
                <span id="modal-input"></span>
                <div class="ms-auto">
                    <span data-copy><?php ee('Copy') ?></span>
                </div>
            </button>
            <div class="modal-qr mt-2">
                <div class="btn-group w-100 bg-white border shadow-sm rounded-3" role="group" aria-label="downloadQR">
                    <a href="#" class="btn btn-transparent w-100 p-3 text-start text-black" id="downloadPNG"><i class="fa fa-qrcode"></i> <span class="ms-2"><?php ee('Download QR Code') ?></span></a>
                    <div class="btn-group" role="group">
                        <button id="btndownloadqr" type="button" class="btn btn-transparent border-0 border-start ps-3 dropdown-toggle text-black" data-bs-toggle="dropdown" aria-expanded="false">PNG</button>
                        <ul class="dropdown-menu" aria-labelledby="btndownloadqr">
                            <li><a class="dropdown-item" href="#">PDF</a></li>
                            <li><a class="dropdown-item" href="#">SVG</a></li>
                        </ul>
                    </div>
                </div>                
            </div>
            <div id="modal-share">
                <?php echo \Helpers\App::share('--url--', ['class' =>'btn w-100 btn-white border shadow-sm rounded-3 p-3 mt-2 text-start text-black', 'text' => true]) ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cropperModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Crop Image') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-3">
          <div class="img-container">
            <img id="cropper-image" src="" alt="Image to crop" style="max-width: 100%; max-height: 400px;">
          </div>
        </div>
        <div class="text-center">
          <p class="text-muted"><?php ee('Drag to move, scroll to zoom. Crop area will be automatically adjusted to maintain square aspect ratio.') ?></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <button type="button" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm" id="crop-save"><?php ee('Save Crop') ?></button>
      </div>
    </div>
  </div>
</div>