<section id="top">
    <div class="container-fluid">
        <div class="row row-grid">
            <div class="col-md-3 col-lg-2 px-0">
                <div class="list-group list-group-flush">
                    <a href="#started" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Getting Started') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a>
                    <a href="#auth" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Authentication') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a>
                    <?php if(user() && user()->admin): ?>
                    <a href="#oauth" data-trigger="scrollto" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('OAuth Authentication') ?> </span>
                        </div>
                        <span class="badge bg-success small text-white">Admin</span>
                    </a>
                    <?php endif ?>
                    <a href="#rate" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Rate Limit') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a>
                    <a href="#response" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <div>
                            <span><?php ee('Response Handling') ?></span>
                        </div>
                        <div><i data-feather="chevron-right"></i></div>
                    </a>
                    <?php foreach($menu as $id => $el): ?>
                        <h6 class="px-3 pt-3"><i data-feather="plus-circle" class="mr-1"></i> <a href="#<?php echo $id ?>" data-target="#holder-<?php echo $id ?>" data-toggle="collapse" class="align-middle"><?php echo $el['title'] ?></a> <?php echo ($el['admin']) ? '<small class="badge badge-warning text-xs float-right">'.e('Admin').'</small>' : '' ?></h6>
                        <div class="collapse" id="holder-<?php echo $id ?>">
                            <?php foreach($el['endpoints'] as $anchor => $title): ?>
                                <a href="#<?php echo $anchor ?>" data-scroll-to data-scroll-to-offset="50" class="list-group-item list-group-item-action d-flex justify-content-between">
                                    <div>
                                        <span><?php echo $title ?></span>
                                    </div>
                                    <div><i data-feather="chevron-right"></i></div>
                                </a>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 ml-lg-auto py-5 border-left">
                <div class="mb-5" id="getting-started">
                    <div class="row mb-5">
                        <div class="col-lg-7">
                            <h4 class="mb-5 px-4"><?php ee('API Reference for Developers') ?> <span class="badge badge-success text-sm align-middle">v3</span></h4>
                            <div class="card-header py-4">
                                <h6 class="mb-0" id="started"><i data-feather="terminal" class="mr-3"></i><?php ee('Getting Started') ?></h6>
                            </div>
                            <div class="card-body">
                                <p><?php ee("An API key is required for requests to be processed by the system. Once a user registers, an API key is automatically generated for this user. The API key must be sent with each request (see full example below). If the API key is not sent or is expired, there will be an error. Please make sure to keep your API key secret to prevent abuse.") ?></p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <?php if(\Core\Auth::logged() && \Core\Auth::user()->has('api') && \Core\Auth::user()->teamPermission('api.create')): ?>
                                <div class="mt-8">
                                    <p><strong><?php ee("Your API key") ?></strong></p>
                                    <pre class="code bg-secondary rounded p-3"><span><?php echo $token ?></span></pre>
                                    <a href="<?php echo route('apikeys') ?>" class="btn btn-primary btn-sm delete" title="<?php ee("Regenerate API Key") ?>" data-content="<?php ee("If you proceed, your current applications will not work anymore. You will need to change your api key for it to work again.") ?>"><?php ee("Regenerate") ?></a>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="mb-5" id="auth">
                    <div class="row mb-5">
                        <div class="col-lg-7">
                            <div class="card-header py-4">
                                <h6 class="mb-0" id="auth"><i data-feather="terminal" class="mr-3"></i><?php ee('Authentication') ?></h6>
                            </div>
                            <div class="card-body">
                                <p><?php ee("To authenticate with the API system, you need to send your API key as an authorization token with each request. You can see sample code below.") ?></p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mt-8 p-3 bg-secondary rounded">
                                <div class="btn-group code-lang mb-3">
                                    <a href="#curl" class="btn btn-dark btn-xs active">cURL</a>
                                    <a href="#php" class="btn btn-dark btn-xs">PHP</a>
                                    <a href="#nodejs" class="btn btn-dark btn-xs">Node.js</a>
                                    <a href="#python" class="btn btn-dark btn-xs">Python</a>
                                    <a href="#cpound" class="btn btn-dark btn-xs">C#</a>
                                </div>
                                <div class="code-selector" data-id="curl">
                                    <pre><code class="rounded bash"><?php echo str_replace("                  ","", "curl --location --request POST '".route('api.account.get')."' \
                                    --header 'Authorization: Bearer {$token}' \
                                    --header 'Content-Type: application/json' \ ") ?></code></pre>
                                </div>
                                <div class="code-selector" data-id="php">
                                    <pre><code class="rounded php"><?php echo str_replace("                  ","", '$curl = curl_init();
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => "'.route('api.account.get').'",
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_MAXREDIRS => 2,
                                        CURLOPT_TIMEOUT => 10,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_CUSTOMREQUEST => "POST",
                                        CURLOPT_HTTPHEADER => [
                                            "Authorization: Bearer '.$token.'",
                                            "Content-Type: application/json",
                                        ],
                                    ));

                                    $response = curl_exec($curl);') ?></code></pre>
                                </div>
                                <div class="code-selector" data-id="nodejs">
                                    <pre><code class="rounded js"><?php echo str_replace("                  ","", 'var request = require(\'request\');
                                    var options = {
                                        \'method\': \'POST\',
                                        \'url\': \''.route('api.account.get').'\',
                                        \'headers\': {
                                            \'Authorization\': \'Bearer '.$token.'\',
                                            \'Content-Type\': \'application/json\'
                                        },
                                        body: \'\'
                                    };
                                    request(options, function (error, response) {
                                        if (error) throw new Error(error);
                                        console.log(response.body);
                                    });') ?></code></pre>
                                </div>
                                <div class="code-selector" data-id="python">
                                    <pre><code class="rounded js"><?php echo str_replace("                  ","", 'import requests
                                    url = "'.route('api.account.get').'"
                                    payload = {}
                                    headers = {
                                      \'Authorization\': \'Bearer '.$token.'\',
                                      \'Content-Type\': \'application/json\'
                                    }
                                    response = requests.request("GET", url, headers=headers, json=payload)
                                    print(response.text)
                                    ') ?></code></pre>
                                </div>
                                <div class="code-selector" data-id="cpound">
                                    <pre><code class="rounded js"><?php echo str_replace("                  ","", 'var client = new HttpClient();
                                    var request = new HttpRequestMessage(HttpMethod.Get, "'.route('api.account.get').'");
                                    request.Headers.Add("Authorization", "Bearer '.$token.'");
                                    var content = new StringContent("{}", System.Text.Encoding.UTF8, "application/json");
                                    request.Content = content;
                                    var response = await client.SendAsync(request);
                                    response.EnsureSuccessStatusCode();
                                    Console.WriteLine(await response.Content.ReadAsStringAsync());                                        
                                    ') ?></code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(user() && user()->admin): ?>
                <div class="mb-5" id="oauth">
                    <div class="row mb-5">
                        <div class="col-lg-7 text-start">
                            <div class="card-header py-4">
                                <h6 class="mb-0 fw-bolder" id="auth"><i data-feather="terminal" class="mr-3"></i> <?php ee('OAuth Authentication') ?></h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-5">
                                    <p><?php ee('OAuth allows you to integrate our services into your application while letting users securely authenticate without sharing their passwords. The flow consists of three main steps:') ?></p>
                                    <ol>
                                        <li><?php ee('Redirect users to our authorization page') ?></li>
                                        <li><?php ee('Users approve your application access') ?></li>
                                        <li><?php ee('Exchange the authorization code for an access token') ?></li>
                                    </ol>
                                </div>

                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3"><?php ee('Step 1: Create OAuth Application') ?></h6>
                                    <p><?php ee('Before you begin, you need to create an OAuth application in your admin dashboard. You will receive:') ?></p>
                                    <ul>
                                        <li><?php ee('Client ID') ?></li>
                                        <li><?php ee('Client Secret') ?></li>
                                    </ul>
                                    <div class="alert alert-warning">
                                        <?php ee('Keep your Client Secret secure and never share it publicly!') ?>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3"><?php ee('Step 2: Authorization Request') ?></h6>
                                    <p><?php ee('To begin the OAuth flow, redirect users to our authorization URL:') ?></p>
                                    
                                    <pre class="bg-dark text-white p-3 rounded">GET <?php echo route('oauth.authorize') ?>?clientid=YOUR_CLIENT_ID&redirect=YOUR_REDIRECT_URI</pre>
                                    
                                    <p class="mt-3"><?php ee('Parameters:') ?></p>
                                    <ul>
                                        <li><code>clientid</code>: <?php ee('Your OAuth client ID') ?></li>
                                        <li><code>redirect</code>: <?php ee('Must match the redirect URI you registered') ?></li>
                                    </ul>
                                </div>

                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3"><?php ee('Step 3: Handle the Callback') ?></h6>
                                    <p><?php ee('After user authorization, we will redirect to your redirect_uri with an authorization code:') ?></p>
                                    
                                    <pre class="bg-dark text-white p-3 rounded">YOUR_REDIRECT_URI?code=AUTHORIZATION_CODE</pre>
                                </div>

                                <div class="mb-5">
                                    <h6 class="fw-bold mb-3"><?php ee('Step 4: Exchange Code for Token') ?></h6>
                                    <p><?php ee('Exchange the authorization code for an access token by making a POST request') ?></p>
                                    
                                    <pre class="bg-dark text-white p-3 rounded">POST <?php echo route('api.oauth.token') ?></br>Content-Type: application/json</br>{</br> "code": "AUTHORIZATION_CODE",</br> "secret": "YOUR_CLIENT_SECRET"</br>}</pre>

                                    <p class="mt-3"><?php ee('Successful response') ?></p>
                                    <pre class="bg-dark text-white p-3 rounded">{<br>"error": false,<br>"access_token": "YOUR_ACCESS_TOKEN",<br>"expires_at": 1234567890<br>}</pre>
                                </div>

                                <div class="mb-5">
                                    <h6 class="mb-3 fw-bold"><?php ee('Using the Access Token') ?></h6>
                                    <p><?php ee('Include the access token in the Authorization header for API requests:') ?></p>
                                    
                                    <pre class="bg-dark text-white p-3 rounded">GET <?php echo route('api.account.get') ?><br>Authorization: Bearer YOUR_ACCESS_TOKEN</pre>

                                    <div class="alert alert-info mt-3">
                                        <?php ee('Access tokens expire after 1 year and will need to be refreshed by repeating the OAuth flow.') ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <div id="ratelimit" class="row mb-5">
                    <div class="col-lg-7">
                        <div class="card-header py-4">
                            <h6 class="mb-0" id="rate"><i data-feather="terminal" class="mr-3"></i><?php ee('Rate Limit') ?></h6>
                        </div>
                        <div class="card-body">
                            <p><?php ee("Our API has a rate limiter to safeguard against spike in requests to maximize its stability. Our rate limiter is currently caped at {x} requests per {y} minute.", null, ['x' => $rate[0], 'y' => $rate[1]]) ?></p>

                            <p><?php ee('Several headers will be sent alongside the response and these can be examined to determine various information about the request.') ?></p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mt-7">
                            <pre class="code bg-secondary rounded p-3">X-RateLimit-Limit: <?php echo $rate[0] ?><br>X-RateLimit-Remaining: <?php echo $rate[0]-1 ?><br>X-RateLimit-Reset: TIMESTAMP</pre>
                        </div>
                    </div>
                </div>
                <div id="responsehandling" class="row mb-5">
                    <div class="col-lg-7">
                        <div class="card-header py-4">
                            <h6 class="mb-0" id="response"><i data-feather="terminal" class="mr-3"></i><?php ee('Response Handling') ?></h6>
                        </div>
                        <div class="card-body">
                            <p><?php ee('All API response are returned in JSON format by default. To convert this into usable data, the appropriate function will need to be used according to the language. In PHP, the function json_decode() can be used to convert the data to either an object (default) or an array (set the second parameter to true). It is very important to check the error key as that provides information on whether there was an error or not. You can also check the header code.') ?></p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mt-7">
                            <pre class="code bg-secondary rounded p-3"><code class="rounded json"><?php echo str_replace("                  ","", '{
                                        "error": 1,
                                        "message": "An error ocurred"
                                    }') ?></code></pre>
                        </div>
                    </div>
                </div>
                <?php foreach($content as $id => $el): ?>
                    <hr id="<?php echo $id ?>">
                    <h4 class="mb-5 px-4"><a href="#<?php echo $id ?>"><i data-feather="bookmark" class="mr-3"></i></a>  <?php echo $el['title'] ?></h4>
                    <?php if($el['description']):?><p class="mt-2 ml-4"><?php echo $el['description'] ?></p><?php endif ?>
                    <?php foreach($el['endpoints'] as $key => $data): ?>
                        <div id="<?php echo $id.'-'.$key ?>" class="row mb-5">
                            <div class="col-lg-7">
                                <div class="card-header bg-transparent">
                                    <h6 class="mb-0" id="<?php echo \Core\Helper::slug($data['title']) ?>"><i data-feather="terminal" class="mr-3"></i><?php echo $data['title'] ?></h6>
                                </div>
                                <div class="card-body">
                                    <span class="badge badge-<?php echo \Helpers\App::apiMethodColor($data['method']) ?> mr-2 align-middle text-xs"><?php echo $data['method'] ?></span> <code><?php echo $data['route'] ?></code>
                                    <p class="mt-3"><?php echo $data['description'] ?></p>
                                    <?php if($data['parameters']): ?>
                                        <div class="table-responsive mt-4">
                                            <table class="table">
                                                <thead><tr><th><strong><?php ee("Parameter") ?></strong></th><th><strong><?php ee("Description") ?></strong></th></tr></thead>
                                                <tbody>
                                                <?php foreach($data['parameters'] as $param => $desc): ?>
                                                <tr>
                                                    <td><?php echo $param ?></td>
                                                    <td><?php echo $desc ?></td>
                                                </tr>
                                                <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="mt-3 p-3 bg-secondary rounded">
                                    <div class="btn-group code-lang mb-3">
                                        <a href="#curl" class="btn btn-dark btn-xs active">cURL</a>
                                        <a href="#php" class="btn btn-dark btn-xs">PHP</a>
                                        <a href="#nodejs" class="btn btn-dark btn-xs">Node.js</a>
                                        <a href="#python" class="btn btn-dark btn-xs">Python</a>
                                        <a href="#cpound" class="btn btn-dark btn-xs">C#</a>
                                    </div>
                                    <div class="code-selector" data-id="curl">
                                        <pre><code class="rounded bash"><?php echo str_replace("                                        ","", "curl --location --request ".$data['method']." '".$data['route']."' \
                                        --header 'Authorization: Bearer {$token}' \
                                        --header 'Content-Type: application/json' \
                                        ".(
                                            $data['code'] ? '--data-raw \''.json_encode($data['code'], JSON_PRETTY_PRINT) .'\'' : ''
                                        )."") ?></code></pre>
                                    </div>
                                    <div class="code-selector" data-id="php">
                                        <pre><code class="rounded php"><?php echo str_replace("                                            ","", '$curl = curl_init();

                                            curl_setopt_array($curl, array(
                                                CURLOPT_URL => "'.$data['route'].'",
                                                CURLOPT_RETURNTRANSFER => true,
                                                CURLOPT_MAXREDIRS => 2,
                                                CURLOPT_TIMEOUT => 10,
                                                CURLOPT_FOLLOWLOCATION => true,
                                                CURLOPT_CUSTOMREQUEST => "'.$data['method'].'",
                                                CURLOPT_HTTPHEADER => [
                                                    "Authorization: Bearer '.$token.'",
                                                    "Content-Type: application/json",
                                                ],
                                                '.(
                                                    $data['code'] ? 'CURLOPT_POSTFIELDS => 
                                                    \''.str_replace("\n","\n\t", json_encode($data['code'], JSON_PRETTY_PRINT)).'\',' : ''
                                                ).'
                                            ));

                                            $response = curl_exec($curl);

                                            curl_close($curl);
                                            echo $response;') ?></code></pre>
                                    </div>
                                    <div class="code-selector" data-id="nodejs">
                                        <pre><code class="rounded js"><?php echo str_replace("                                        ","", 'var request = require(\'request\');
                                        var options = {
                                            \'method\': \''.$data['method'].'\',
                                            \'url\': \''.$data['route'].'\',
                                            \'headers\': {
                                                \'Authorization\': \'Bearer '.$token.'\',
                                                \'Content-Type\': \'application/json\'
                                            },
                                            '.(
                                                $data['code'] ? 'body: JSON.stringify('.json_encode($data['code'], JSON_PRETTY_PRINT) .'),' : ''
                                            ).'
                                        };
                                        request(options, function (error, response) {
                                            if (error) throw new Error(error);
                                            console.log(response.body);
                                        });') ?></code></pre>
                                    </div>
                                    <div class="code-selector" data-id="python">
                                        <pre><code class="rounded js"><?php echo str_replace("                                        ","", 'import requests
                                        url = "'.$data['route'].'"
                                        payload = '.($data['code'] ? json_encode($data['code'], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) : '{}').'
                                        headers = {
                                            \'Authorization\': \'Bearer '.$token.'\',
                                            \'Content-Type\': \'application/json\'
                                        }
                                        response = requests.request("'.$data['method'].'", url, headers=headers, json=payload)
                                        print(response.text)
                                        ') ?></code></pre>
                                    </div>
                                    <div class="code-selector" data-id="cpound">
                                        <pre><code class="rounded js"><?php echo str_replace("                                        ","", 'var client = new HttpClient();
                                        var request = new HttpRequestMessage(HttpMethod.'.ucfirst(strtolower($data['method'])).', "'.$data['route'].'");
                                        request.Headers.Add("Authorization", "Bearer '.$token.'");
                                        var content = new StringContent("'.($data['code'] ? json_encode($data['code'], JSON_PRETTY_PRINT) : '{}').'", System.Text.Encoding.UTF8, "application/json");
                                        request.Content = content;
                                        var response = await client.SendAsync(request);
                                        response.EnsureSuccessStatusCode();
                                        Console.WriteLine(await response.Content.ReadAsStringAsync());                                        
                                        ') ?></code></pre>
                                    </div>
                                </div>
                                <h6 class="my-3"><?php ee("Server response") ?></h6>
                                <div class="p-3 bg-secondary rounded">
                                    <pre><code class="rounded json"><?php echo json_encode($data['response'], JSON_PRETTY_PRINT) ?></code></pre>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>