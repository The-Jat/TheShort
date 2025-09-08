<h1 class="h3 mb-5 fw-bold"><?php ee('Advanced Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block position-sticky top-0">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">
                    <?php echo csrf() ?>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="root_domain" class="mb-0 form-label fw-bold"><?php ee('Shorten links with') ?> <strong><?php echo str_replace(["http://", "https://"], "", config("url")) ?></strong></label>
                            <p class="my-0 form-text"><?php ee('If you have additional domains and you want to prevent people from using the root domain to shorten, disable this.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="root_domain" name="root_domain" value="1" <?php echo config("root_domain") ? 'checked':'' ?>>
                        </div>                        
                    </div>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="multiple_domains" class="mb-0 form-label fw-bold"><?php ee('Multiple Domain Names') ?></label>
                            <p class="my-0 form-text"><?php ee('If enabled users will have the choice to select their preferred domain name from the list below. Make sure that all these point to the script.') ?></p>
                        </div>                        
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="multiple_domains" name="multiple_domains" value="1" <?php echo config("multiple_domains") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="domain_names">
                        </div>                        
                    </div>
                    <div class="form-group <?php echo config("multiple_domains") ? '':'d-none' ?>">
                        <label for="domain_names" class="form-label fw-bold"><?php ee('Domains') ?></label>
                        <textarea name="domain_names" id="domain_names" rows="5" class="form-control p-2"><?php echo config("domain_names") ?></textarea>
                        <p class="form-text"><?php ee('One domain per line including http://, do not include your main domain name (read documentation).') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="serverip" class="form-label fw-bold"><?php ee('Server IP') ?></label>
					    <input class="form-control p-2" name="serverip" id="serverip" value="<?php echo config('serverip') ?>">
					    <p class="form-text"><?php ee('Add your server IP here to enable A records. Otherwise your customers can only use CNAME.') ?></p>
                    </div>
                    <div class="form-group mb-4">
					    <label for="analytic" class="form-label fw-bold"><?php ee('Google Analytics Account ID') ?></label>
					    <input class="form-control p-2" name="analytic" id="analytic" value="<?php echo config('analytic') ?>">
					    <p class="form-text"><?php ee('Your Google Analytics account id e.g. G-12345678-1. This will be used to collect data separately for your information only.') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>             
            <h4 class="fw-bold mb-3 mt-5">DeepL</h4>
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">                         
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="multiple_domains" class="mb-0 form-label fw-bold"><?php ee('Enable DeepL API') ?></label>
                            <p class="my-0 form-text"><?php ee('Automatically translate to various languages using DeepL API.') ?></p>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="deepl[enabled]" name="deepl[enabled]" value="1" <?php echo config("deepl")->enabled ? 'checked':'' ?>>
                        </div>
                    </div>
                    <div class="form-group mb-4">
					    <label for="deepl[key]" class="form-label fw-bold"><?php ee('DeepL API Key') ?></label>
					    <input class="form-control p-2" name="deepl[key]" id="deepl[key]" value="<?php echo config('deepl')->key ?>">
					    <p class="form-text"><?php ee('Enter your DeepL API key so you can translate languages files automatically.') ?> <a href="https://www.deepl.com/" target="blank">DeepL</a></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>           
            <div class="d-flex align-items-center mt-5 mb-3">
                <h4 class="fw-bold mb-0"><?php ee('CDN Integration') ?></h4>
                <?php if(config('cdn')->key && config('cdn')->secret && config('cdn')->region): ?>
                    <div class="ms-auto">
                        <a href="<?php echo route('admin.settings.cdnsync', [\Core\Helper::nonce('cdnsync')]) ?>" class="btn btn-primary rounded-3 px-2 py-1"><span data-bs-toggle="modal" data-bs-target="#syncing"><?php ee('Sync') ?></span></a>
                    </div>
                <?php endif ?>
            </div> 
    
            <div class="card rounded-4 shadow-sm">
                <div class="card-body">                   
                    <p>
                        <?php ee('You can setup a CDN such as S3 and serve all files via CDN. You will also be able to sync current files to CDN. Please note that at the moment only files uploaded by users (located in public/content folder) will be uploaded/synced to the CDN.') ?>
                    </p>
                    <div class="form-group d-flex border rounded p-2 mb-3 align-items-center">
                        <div>
                            <label for="multiple_domains" class="mb-0 form-label fw-bold"><?php ee('Enable CDN Uploads') ?></label>
                        </div>
                        <div class="form-check form-switch ms-auto">
                            <input class="form-check-input form-check-input-lg" type="checkbox" data-binary="true" id="cdn[enabled]" name="cdn[enabled]" value="1" <?php echo config("cdn")->enabled ? 'checked':'' ?>>
                        </div>
                    </div>                    
                    <div class="form-group mb-4">
                        <label class="form-label fw-bold d-block"><?php ee('Provider') ?></label>
                        <select name="cdn[provider]" class="form-select p-2" id="cdnprovider">
                            <?php foreach(\Helpers\CDN::providers() as $name => $provider): ?>
                                <option value="<?php echo $name ?>" <?php echo config('cdn')->provider == $name ? 'selected' : ''  ?>><?php echo $provider['name'] ?></option>
                            <?php endforeach ?>
                        </select>                        
                    </div>
                    <div class="form-group mb-4">
					    <label for="cdn[key]" class="form-label fw-bold"><?php ee('Key ID') ?>*</label>
					    <input class="form-control p-2" name="cdn[key]" id="cdn[key]" value="<?php echo config('cdn')->key ?>">
                    </div>
                    <div class="form-group mb-4">
					    <label for="cdn[secret]" class="form-label fw-bold"><?php ee('Secret Key') ?>*</label>
					    <input class="form-control p-2" name="cdn[secret]" id="cdn[secret]" value="<?php echo config('cdn')->secret ?>">
                    </div>
                    <div class="form-group mb-4">
					    <label for="cdn[region]" class="form-label fw-bold"><?php ee('Region') ?>*</label>
					    <input class="form-control p-2" name="cdn[region]" id="cdnregion" value="<?php echo config('cdn')->region ?>" placeholder="e.g. us-east-1">
                    </div>
                    <div class="form-group mb-4">
					    <label for="cdn[bucket]" class="form-label fw-bold"><?php ee('Bucket Name') ?>*</label>
					    <input class="form-control p-2" name="cdn[bucket]" id="cdnbucket" value="<?php echo config('cdn')->bucket ?>" placeholder="e.g. urlshortener">
                    </div>
                    <div class="form-group mb-4 <?php echo config('cdn')->provider == 'custom' ? 'd-block' : 'd-none'  ?>">
					    <label for="cdn[s3url]" class="form-label fw-bold"><?php ee('S3-compatible API URL') ?></label>
					    <input class="form-control p-2" name="cdn[s3url]" id="cdns3url" value="<?php echo config('cdn')->s3url ?? '' ?>" placeholder="e.g. https://s3.us-east-1.amazonaws.com/urlshortener">
                        <div class="form-text"><?php ee('This is only required if you are using a custom provider. Enter the full S3 URL including the bucket name. e.g. https://s3.us-east-1.amazonaws.com/urlshortener') ?></div>
                    </div>                    
                    <div class="form-group mb-4">
					    <label for="cdn[url]" class="form-label fw-bold"><?php ee('CDN URL/Endpoint') ?></label>
					    <input class="form-control p-2" name="cdn[url]" id="cdnurl" value="<?php echo config('cdn')->url ?>" placeholder="e.g. https://12abc.cloudfront.net">
                        <p class="form-text"><?php ee('In most cases you will not be able to access CDN files directly. You will need to either make the bucket public or setup a CDN such as Cloudfront to access files.') ?></p>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-3 px-5 py-2 rounded-3 shadow-sm"><?php ee('Save Settings') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="syncing" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="syncing" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><span class="preloader me-2"><span class="spinner-border spinner-border-sm" role="status"></span></span> <?php ee('Syncing files...') ?> </h5>
      </div>
      <div class="modal-body">
        <p><?php ee("Syncing files with selected CDN. Please hold. Don't close this page or press update again. The page will refresh once it is done.") ?></p>
      </div>
    </div>
  </div>
</div>