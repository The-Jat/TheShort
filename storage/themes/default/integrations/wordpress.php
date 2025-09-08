<div class="d-flex mb-5">
    <div>
        <h1 class="mb-0 h3 fw-bold"><img src="<?php echo assets('images/wp.svg') ?>" class="icon-45 border rounded-3 p-2 bg-white me-3"> <?php ee('WordPress Integration') ?></h5>
    </div>
</div>  

<div class="row">
    <div class="col-md-3">
        <div class="card rounded-4 shadow-sm">
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action rounded-3 mb-2 border-0 fw-bold active" href="#plugin" data-bs-toggle="collapse"><?php echo e("WordPress Plugin") ?></a>
                    <a class="list-group-item list-group-item-action rounded-3 mb-2 border-0 fw-bold" href="#function" data-bs-toggle="collapse"><?php echo e("WordPress Function") ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9" id="tools">
        <div class="collapse show" id="plugin" data-bs-parent="#tools">
            <div class="card rounded-4 shadow-sm">
                <div class="card-header bg-transparent">
                    <h3 class="card-title fw-bold"><?php ee('WordPress Plugin') ?></h3>
                </div>
                <div class="card-body">
                    <p><?php ee('You can easily use a shortcode to shorten links with our WordPress plugin. You just need to download it below and upload it in WordPress and that is it. There is no need to configure it as it will be already configured for you. All of your links will be saved in your account.') ?></p>

                    <p class="alert alert-danger p-2"><?php ee('Do not share this plugin with anyone you do not trust as they will have access to the full API and essentially your account.') ?></p>

                    <p><strong><?php ee('Instructions') ?></strong></p>
                    <ol>
                        <li class="mb-2"><?php ee('Download the plugin below') ?></li>
                        <li class="mb-2"><?php ee('Go to WordPress Admin') ?> <i class="fa fa-chevron-right"></i> <?php ee('Plugins') ?> <i class="fa fa-chevron-right"></i> <?php ee('Add New') ?> <i class="fa fa-chevron-right"></i> <?php ee('Upload Plugin') ?></li>
                        <li class="mb-2"><?php ee('Upload the plugin named linkshortenershortcode.zip and activate it. The plugin will be named Link Shortener Shortcode.') ?></li>
                    </ol>

                    <a href="?download=1" class="btn btn-primary rounded-3 px-3 py-2"><?php ee('Download Plugin') ?></a>
                </div>
            </div>
            <div class="card rounded-4 card-body shadow-sm">
                <p><strong><?php ee('Examples') ?></strong></p>

                <p><?php ee('The following code will apply the shortcode "shorturl" to the system and you will be able to use the following format.') ?></p>
                <pre class="hljs rounded p-3"><code class="rounded text">[shorturl]https://google.com[/shorturl]</code></pre>

                <p><?php ee('You can also use the shortcode in html.') ?></p>

                <pre class="hljs rounded p-3"><code class="rounded html">&lt;a href="[shorturl]https://google.com[/shorturl]">Google&lt;/a&gt;</code></pre>
            </div>
        </div>
        <div class="collapse" id="function" data-bs-parent="#tools">
            <div class="card rounded-4 shadow-sm">
                <div class="card-header bg-transparent">
                    <h3 class="card-title fw-bold"><?php ee('WordPress Shortcode Function') ?></h3>
                </div>
                <div class="card-body">
                    <p><?php echo e("You can now shorten links directly from WordPress using shortcode. If you don't want to upload a plugin, you can use this method. It is very easy to setup and it works with all versions of WordPress and with any theme. All links you will shorten will be safely stored in your account.") ?></p>        

                    <p><strong><?php ee('Instructions') ?></strong></p>
                    <ol>
                        <li class="mb-2"><?php ee('Copy your unique php code below') ?></li>
                        <li class="mb-2"><?php ee('Go to WordPress Admin') ?> <i class="fa fa-chevron-right"></i> <?php ee('Appearance') ?> <i class="fa fa-chevron-right"></i> <?php ee('Theme File Editor') ?></li>
                        <li class="mb-2"><?php ee('On the right side, under Theme Files, find and click on Theme Functions (functions.php)') ?></li>
                        <li class="mb-2"><?php ee('Paste the code below at the very end of the file and save') ?></li>
                    </ol>       
                    <h4 class="mt-5 mb-3"><?php ee('Your Unique Code') ?></h4>
                    
                    <p class="alert alert-danger p-2"><?php ee('Do not share this code with anyone you do not trust as they will have access to the full API and essentially your account.') ?></p>

                    <pre class="hljs p-3 rounded"><code class="rounded php"><?php echo str_replace('            ', '', '// This code simply registers the shortcode "shorturl". You can change it if you want something else 
                        add_shortcode("shorturl", "pus_shortcode_shorten_url");

                        // Function to send the request
                        function pus_shortcode_shorten_url($atts, $content){
                            
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "'.route('api.url.create').'");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["url" => $content]));
                            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                "Authorization: Bearer '.user()->api.'",
                                "Content-Type: application/json"
                            ]);

                            $response = curl_exec($ch);
                            curl_close($ch);

                            $object = json_decode($response);

                            if($object && isset($object->shorturl)){
                                return $object->shorturl;
                            }

                            return $content;
                        }') ?>
                        </code></pre>
                </div>
            </div>
                    <div class="card rounded-4 card-body shadow-sm">
                        <p><strong><?php ee('Examples') ?></strong></p>

                        <p><?php ee('The following code will apply the shortcode "shorturl" to the system and you will be able to use the following format.') ?></p>
                        <pre class="hljs p-3 rounded"><code class="rounded text">[shorturl]https://google.com[/shorturl]</code></pre>

                        <p><?php ee('You can also use the shortcode in html.') ?></p>

                        <pre class="hljs p-3 rounded"><code class="rounded html">&lt;a href="[shorturl]https://google.com[/shorturl]">Google&lt;/a&gt;</code></pre>
                    </div>
            </div>
</div>