<h1 class="h3 mb-5 fw-bold"><?php ee('Membership Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <?php echo csrf() ?>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="pro" class="form-label fw-bold mb-0"><?php ee('Membership Module') ?></label>                    
                            <p class="form-text my-0"><?php ee('Enabling this module will allow you to charge users for premium features. Disable this if you want to offer these for free.') ?></p>                            
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="pro" name="pro" value="1" <?php echo config("pro") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="customplan" class="form-label fw-bold mb-0"><?php ee('Custom Plan') ?></label>                    
                            <p class="form-text my-0"><?php ee('Enabling this will enable a special box on the pricing where users can contact you for custom plans.') ?></p>                            
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="customplan" name="customplan" value="1" <?php echo config("customplan") ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group input-select rounded">
                        <label for="currency" class="form-label fw-bold"><?php ee('Currency') ?></label>
                        <select name="currency" id="currency" class="form-control p-2" data-toggle="select">
                        <?php foreach (\Helpers\App::currency() as $code => $info): ?>
                            <option value="<?php echo $code ?>" <?php if(config("currency") == $code) echo "selected" ?>><?php echo $code ?>: <?php echo $info["label"] ?></option>
                        <?php endforeach ?>
                        </select>
                        <p class="form-text"><?php ee('<strong>Notice</strong> If you already have subscribed members, it is highly recommend you <u>do not change</u> the currency or the membership fees because Stripe does not allow modifcation of these parameters. The script will delete the plan and create another one!') ?></p>
                    </div>                    
                    <div class="form-group">
                        <label for="aliases" class="form-label fw-bold d-block mb-0"><?php ee('Premium Aliases') ?> <?php echo file_exists(STORAGE.'/app/aliases.txt') ? '<span class="float-end text-success">'.e('Text file detected').'</span>' : '' ?></label>
                        <p class="form-text mt-0"><?php ee('To reserve an alias for pro members only, add it to the list above (separated by a comma without space between each): google,apple,microsoft,etc. Only admins and pro users can select these.') ?></p>
                        <div class="border rounded rounded-4 p-2 mb-3">
                            <input type="text" name="aliases" id="aliases" class="form-control p-2" rows="5" data-toggle="tags" value="<?php echo config("aliases") ?>" placeholder="Enter alias">
                        </div>                        
                        <div class="custom-alert border border-dark p-3 rounded-3 mb-0 d-flex align-items-center mb-3">
                            <i class="fa fa-info-circle text-info me-3 fs-1"></i>
                            <span><?php ee('If you have a long list, you can add them in a text file named "aliases.txt" in the folder storage/app/ and that will be used instead of the list here.') ?></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Sales Zapier Integration') ?></h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <div class="form-group">
                        <label for="saleszapier" class="form-label fw-bold"><?php ee('Webhook') ?></label>
                        <input type="text" name="saleszapier" id="saleszapier" class="form-control p-2" value="<?php echo config("saleszapier") ?>">
                        <p class="form-text"><?php ee('Enter your zapier url or any other webhook services url to receive data as soon a sales is confirmed. Please check the <a href="https://gemp.me/docs" target="_blank">documentation</a> for more info.') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>       
            <h4 class="fw-bold mb-3 mt-5"><?php ee('Invoice Settings') ?></h4>
            <div class="card rounded-4 shadow-sm">                 
                <div class="card-body">
                    <div class="form-group">
                        <label for="invoice[header]" class="form-label fw-bold"><?php ee('Invoice Header') ?></label>
                        <textarea name="invoice[header]" id="invoice[header]" rows="5" class="form-control p-2"><?php echo config("invoice")->header ?></textarea>
                        <p class="form-text"><?php ee('This information will be added to the invoice header. It can be your address or your company information.') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="invoice[footer]" class="form-label fw-bold"><?php ee('Invoice Footer') ?></label>
                        <textarea name="invoice[footer]" id="invoice[footer]" rows="5" class="form-control p-2"><?php echo config("invoice")->footer ?></textarea>
                        <p class="form-text"><?php ee('This information will be added to the invoice footer. It can be your policy.') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>