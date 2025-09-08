<h1 class="h3 mb-5 fw-bold"><?php ee('Security') ?></h1>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th><?php ee('Type') ?></th>
                            <th><?php ee('Logged Details') ?></th>
                            <th><?php ee('Date') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($events as $event): ?>
                            <tr>
                                <td>
                                    <?php if($event->type == '2fa'): ?>
                                        <span class="badge bg-danger text-white"><?php ee('Failed') ?> 2FA</span>
                                    <?php else: ?>
                                        <span class="badge bg-success text-white"><?php echo e($event->type) ?></span>
                                    <?php endif ?>
                                </td>
                                <td width="70%">
                                    <?php if($event->data->country): ?>
                                        <span class="text-start d-inline-block">
                                            <img src="<?php echo \Helpers\App::flag($event->data->country) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->country) ?>">
                                            <span class="mr-3 me-3 align-middle"><?php echo $event->data->city ? ucfirst($event->data->city).',': e('Somewhere from') ?> <?php echo ucfirst($event->data->country) ?></span>
                                        </span>
                                    <?php endif ?>
                                    <?php if($event->data->os): ?>
                                        <span class="text-start d-inline-block">
                                            <img src="<?php echo \Helpers\App::os($event->data->os) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->os) ?>">
                                            <span class="mr-3 me-3 align-middle"><?php echo $event->data->os ?></span>
                                        </span>
                                    <?php endif ?>
                                    <?php if($event->data->browser): ?>
                                        <span class="text-start d-inline-block">
                                            <img src="<?php echo \Helpers\App::browser($event->data->browser) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($event->data->browser) ?>">
                                            <span class="mr-3 me-3 align-middle"><?php echo $event->data->browser ?></span>
                                        </span>
                                    <?php endif ?>
                                    <?php if($event->data->ip): ?>
                                        <span class="text-start d-inline-block">
                                            <span data-feather="globe"></span>
                                            <span class="mr-3 align-middle"><?php echo $event->data->ip ?></span>
                                        </span>
                                    <?php endif ?>
                                    <?php if(isset($event->data->social) && $event->data->social): ?>
                                        <span class="text-start d-inline-block">
                                            <span data-feather="share-2"></span>
                                            <span class="mr-3 align-middle"><?php echo ucwords($event->data->social) ?></span>
                                        </span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php echo date('Y-m-d H:i', strtotime($event->created_at)) ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-3 fw-bold"><?php echo e("Logout on all devices") ?></h4>
                <?php echo e("If you think your account is exposed or at risk, you can logout of all devices. We also recommend you to change your password as a precaution after logging out of all devices.") ?></p>
                <a href=""  data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#logoutModal" class="btn btn-white border border-danger text-danger fw-bold rounded-3 px-3 py-2 w-100 shadow-sm"><?php echo e("Logout") ?></a>
            </div>
        </div>        
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-3 fw-bold"><?php echo e("Two-Factor Authentication (2FA)") ?></h4>
                <p>
                <?php echo e("2FA is an enhanced level security for your account. Each time you login, an extra step where you will need to enter a unique code will be required to gain access to your account. To enable 2FA, please click the button below and download the <strong>Google Authenticator</strong> app from Apple Store or Play Store.") ?></p>
                <?php if($user->secret2fa): ?>

                    <a href="#qrcode" data-bs-toggle="collapse" data-bs-target="#qrcode" class="mb-4 btn btn-primary btn-sm"><?php ee("View QR") ?></a>
                    <div id="qrcode" class="<?php echo (!request()->qr) ? 'collapse' : '' ?> border p-3 mb-3">
                        <p><img src="<?php echo $QR2FA ?>" width="150"></p>
                        <strong><small><?php echo e("Secret Key") ?></small></strong>: <small data-href="<?php echo $user->secret2fa ?>"><?php echo $user->secret2fa ?></small> <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo $user->secret2fa ?>"><small><?php echo e("Copy")?></small></a>
                    </div>

                    <h5 class="mb-2"><?php echo e("Important") ?></h5>

                    <p><?php echo e("You need to scan the code above with the app. You need to backup the QR code by saving it and save the key somewhere safe in case you lose your phone. You will not be able to login if you can't provide the code, in that case you will need to contact us. If you disable 2FA and re-enable it, you will need to scan a new code.") ?></p>
                    <p class="mb-0"><a href="<?php echo route("2fa", ['disable', \Core\Helper::nonce('2fa'.$user->id)]) ?>" class="btn btn-white border border-danger text-danger fw-bold rounded-3 px-3 py-2 w-100 shadow-sm"><?php echo e("Disable 2FA") ?></a></p>
                <?php else: ?>
                    <p class="mb-0"><a href=""  data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#twofaModal" class="btn btn-white border fw-bold rounded-3 px-3 py-2 w-100 shadow-sm"><?php echo e("Activate 2FA") ?></a></p>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php if($secret): ?>
<div class="modal fade" id="twofaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Two-Factor Authentication (2FA)') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <form action="<?php echo route("2fa", ['enable', \Core\Helper::nonce('2fa'.$user->id)]) ?>" method="get" autocomplete="off">
        <div class="modal-body">

            <p><?php echo e("You need to scan the code above with the app then enter the 6-digit number that you see in the app to activate 2FA. It is highly recommended to backup the unique key somewhere safe.") ?></p>

            <div class="border rounded rounded-4 p-3 mb-3 text-center">
                <p><img src="<?php echo $QR2FA ?>" width="200" class="rounded"></p>
                <strong><span><?php echo e("Secret Key") ?></span></strong>
                <p><span data-href="<?php echo $secret ?>"><?php echo $secret ?></span> <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo $secret ?>"><small><?php echo e("Copy")?></small></a></p>
            </div>

            <div class="form-group mb-3">
                <label class="form-label fw-bold mb-2" for="secret-2fa"><?php ee('2FA Access Code') ?></label>
                <input type="number" class="form-control p-3" size="6" maxlength="6" id="secret-2fa" name="secret" placeholder="<?php ee('2FA Access Code') ?>" required>
            </div>
            <?php echo csrf() ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-success"><?php ee('Activate') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif ?>

<div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><?php ee('Logout on all devices') ?></h5>
        <button type="button" class="btn btn-transparent border-0 p-0" data-bs-close data-bs-dismiss="modal" aria-label="Close"><i class="fs-3 fa fa-times"></i></button>
      </div>
      <form action="<?php echo route('user.security') ?>" method="post">
        <div class="modal-body">
        <p><?php ee('If you think your account is exposed or at risk, you can logout of all devices. We also recommend you to change your password as a precaution after logging out of all devices.') ?></p>
            <?php echo csrf() ?>
            <div class="form-group mb-3">
                <label class="form-label fw-bold"><?php echo e("Confirm Password")?></label>
                <input type="password" value="" name="cpassword" class="form-control p-2" autocomplete="off" />
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white border px-3 py-2 rounded-3 shadow-sm" data-bs-close data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
            <button type="submit" class="btn btn-danger"><?php ee('Logout') ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
