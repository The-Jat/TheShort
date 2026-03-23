<section id="apidocs" class="border-top border-bottom">
    <div class="container-fluid">
        <div class="row row-grid">
            <div class="col-md-3 col-lg-2 px-0">
                <div class="doc-sidebar collapse show text-start" data-trigger="scrollmenu" data-scroll-element="h2">
                    <a href="#started" data-trigger="scrollto" data-scrollto-offset="120" class="px-3 py-1 text-dark d-block mt-3">
                        <span><?php ee('Getting Started') ?></span>
                    </a>
                    <a href="#auth" data-trigger="scrollto" data-scrollto-offset="120" class="px-3 py-1 text-dark d-block mt-1">
                        <span><?php ee('Authentication') ?></span>
                    </a>
                    <?php if(user() && user()->admin): ?>
                    <a href="#oauth" data-trigger="scrollto" data-scrollto-offset="120" class="px-3 py-1 text-dark d-block mt-1">
                        <span><?php ee('OAuth Authentication') ?> <span class="badge bg-success small text-white">Admin</span></span>
                    </a>
                    <?php endif ?>
                    <a href="#rate" data-trigger="scrollto" data-scrollto-offset="120" class="px-3 py-1 text-dark d-block mt-1">
                        <span><?php ee('Rate Limit') ?></span>
                    </a>
                    <a href="#response" data-trigger="scrollto" data-scrollto-offset="120" class="px-3 py-1 text-dark d-block mt-1">
                        <span><?php ee('Response Handling') ?></span>
                    </a>
                    <?php foreach($menu as $id => $el): ?>
                        <h6 class="px-3 pt-3">
                            <a href="#<?php echo $id ?>" data-bs-target="#holder-<?php echo $id ?>" data-bs-toggle="collapse" class="text-dark algin-items-center d-block fw-bold">
                                <?php echo $el['title'] ?>
                                <i class="fa fa-chevron-down me-1 small float-end"></i>
                                <?php echo ($el['admin']) ? '<small class="badge bg-success small text-white">'.e('Admin').'</small>' : '' ?>
                            </a>
                        </h6>
                        <div class="collapse" id="holder-<?php echo $id ?>">
                            <?php foreach($el['endpoints'] as $anchor => $title): ?>
                                <a href="#<?php echo $anchor ?>" data-trigger="scrollto" data-scrollto-offset="120" class="px-3 py-1 text-dark d-block">
                                    <small class="text-muted"><?php echo $title ?></small>
                                </a>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 ml-lg-auto py-5 border-start px-3 px-md-5">
                <div class="mb-5" id="getting-started">
                    <div class="row mb-5 text-start">
                        <div class="col-lg-7">
                            <h4 class="fw-bolder mb-5"><?php ee('API Reference for Developers') ?></h4>
                            <div class="card-header py-4">
                                <h6 class="mb-0 fw-bolder" id="started"><i class="fa fa-terminal me-3"></i><?php ee('Getting Started') ?></h6>
                            </div>
                            <div class="card-body">
                                <p><?php ee("An API key is required for requests to be processed by the system. Once a user registers, an API key is automatically generated for this user. The API key must be sent with each request (see full example below). If the API key is not sent or is expired, there will be an error. Please make sure to keep your API key secret to prevent abuse.") ?></p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <?php if(\Core\Auth::logged() && \Core\Auth::user()->has('api') && \Core\Auth::user()->teamPermission('api.create')): ?>
                                <div class="mt-5 code-area">
                                    <p><strong><?php ee("Your API key") ?></strong></p>
                                    <pre class="code"><span><?php echo $token ?></span></pre>
                                    <a href="<?php echo route('apikeys') ?>" class="btn btn-primary btn-sm delete mt-2" title="<?php ee("Regenerate API Key") ?>" data-content="<?php ee("If you proceed, your current applications will not work anymore. You will need to change your api key for it to work again.") ?>"><?php ee("Regenerate") ?></a>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="mb-5" id="auth">
                    <div class="row mb-5">
                        <div class="col-lg-7 text-start">
                            <div class="card-header py-4">
                                <h6 class="mb-0 fw-bolder" id="auth"><i class="fa fa-terminal me-3"></i><?php ee('Authentication') ?></h6>
                            </div>
                            <div class="card-body">
                                <p><?php ee("To authenticate with the API system, you need to send your API key as an authorization token with each request. You can see sample code below.") ?></p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="mt-5 code-area">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="code-lang">
                                        <a href="#curl" class="btn btn-default text-white btn-sm active">cURL</a>
                                        <a href="#php" class="btn btn-default text-white btn-sm">PHP</a>
                                        <a href="#nodejs" class="btn btn-default text-white btn-sm">Node.js</a>
                                        <a href="#python" class="btn btn-default text-white btn-sm">Python</a>
                                        <a href="#cpound" class="btn btn-default text-white btn-sm">C#</a>
                                    </div>
                                    <button type="button" class="btn btn-transparent ms-auto" title="<?php ee('Copy Code') ?>" data-trigger="copycode"><i class="fa fa-clipboard"></i></button>
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
                                <h6 class="mb-0 fw-bolder" id="auth"><i class="fa fa-terminal me-3"></i><?php ee('OAuth Authentication') ?></h6>
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
                    <div class="col-lg-7 text-start">
                        <div class="card-header py-4">
                            <h6 class="mb-0 fw-bolder" id="rate"><i class="fa fa-terminal me-3"></i><?php ee('Rate Limit') ?></h6>
                        </div>
                        <div class="card-body">
                            <p><?php ee("Our API has a rate limiter to safeguard against spike in requests to maximize its stability. Our rate limiter is currently caped at {x} requests per {y} minute.", null, ['x' => $rate[0], 'y' => $rate[1]]) ?> <?php ee('Please note that the rate might change according to the subscribed plan.') ?></p>

                            <p><?php ee('Several headers will be sent alongside the response and these can be examined to determine various information about the request.') ?></p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mt-5 code-area">
                            <pre class="code">X-RateLimit-Limit: <?php echo $rate[0] ?><br>X-RateLimit-Remaining: <?php echo $rate[0]-1 ?><br>X-RateLimit-Reset: TIMESTAMP</pre>
                        </div>
                    </div>
                </div>
                <div id="responsehandling" class="row mb-5">
                    <div class="col-lg-7 text-start">
                        <div class="card-header py-4">
                            <h6 class="mb-0 fw-bolder" id="response"><i class="fa fa-terminal me-3"></i><?php ee('Response Handling') ?></h6>
                        </div>
                        <div class="card-body">
                            <p><?php ee('All API response are returned in JSON format by default. To convert this into usable data, the appropriate function will need to be used according to the language. In PHP, the function json_decode() can be used to convert the data to either an object (default) or an array (set the second parameter to true). It is very important to check the error key as that provides information on whether there was an error or not. You can also check the header code.') ?></p>
                            </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mt-5 code-area">
                            <pre class="code"><code class="rounded json"><?php echo str_replace("                  ","", '{
                                        "error": 1,
                                        "message": "An error occurred"
                                    }') ?></code></pre>
                        </div>
                    </div>
                </div>
                <?php foreach($content as $id => $el): ?>
                    <hr id="<?php echo $id ?>">
                    <h4 class="my-5 text-start d-flex align-items-center">
                        <a href="#<?php echo $id ?>"><i class="fa fa-bookmark me-3"></i></a> 
                        <span><?php echo $el['title'] ?></span>
                        <div class="ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-transparent border rounded-3 btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  <?php ee('Copy for LLMs') ?> <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu p-2">
                                    <li class="mb-2">
                                        <a class="dropdown-item p-2" href="https://chatgpt.com/?prompt=<?php echo urlencode("Read from ".route('apidocs')."#$id so I can ask questions about it.") ?>" class="d-flex align-items-center" target="_blank">
                                            <span class="py-1 px-2 border rounded-3"><svg fill="currentColor" fill-rule="evenodd" height="1em" viewBox="0 0 24 24" width="1em" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0"><title>OpenAI</title><path d="M21.55 10.004a5.416 5.416 0 00-.478-4.501c-1.217-2.09-3.662-3.166-6.05-2.66A5.59 5.59 0 0010.831 1C8.39.995 6.224 2.546 5.473 4.838A5.553 5.553 0 001.76 7.496a5.487 5.487 0 00.691 6.5 5.416 5.416 0 00.477 4.502c1.217 2.09 3.662 3.165 6.05 2.66A5.586 5.586 0 0013.168 23c2.443.006 4.61-1.546 5.361-3.84a5.553 5.553 0 003.715-2.66 5.488 5.488 0 00-.693-6.497v.001zm-8.381 11.558a4.199 4.199 0 01-2.675-.954c.034-.018.093-.05.132-.074l4.44-2.53a.71.71 0 00.364-.623v-6.176l1.877 1.069c.02.01.033.029.036.05v5.115c-.003 2.274-1.87 4.118-4.174 4.123zM4.192 17.78a4.059 4.059 0 01-.498-2.763c.032.02.09.055.131.078l4.44 2.53c.225.13.504.13.73 0l5.42-3.088v2.138a.068.068 0 01-.027.057L9.9 19.288c-1.999 1.136-4.552.46-5.707-1.51h-.001zM3.023 8.216A4.15 4.15 0 015.198 6.41l-.002.151v5.06a.711.711 0 00.364.624l5.42 3.087-1.876 1.07a.067.067 0 01-.063.005l-4.489-2.559c-1.995-1.14-2.679-3.658-1.53-5.63h.001zm15.417 3.54l-5.42-3.088L14.896 7.6a.067.067 0 01.063-.006l4.489 2.557c1.998 1.14 2.683 3.662 1.529 5.633a4.163 4.163 0 01-2.174 1.807V12.38a.71.71 0 00-.363-.623zm1.867-2.773a6.04 6.04 0 00-.132-.078l-4.44-2.53a.731.731 0 00-.729 0l-5.42 3.088V7.325a.068.068 0 01.027-.057L14.1 4.713c2-1.137 4.555-.46 5.707 1.513.487.833.664 1.809.499 2.757h.001zm-11.741 3.81l-1.877-1.068a.065.065 0 01-.036-.051V6.559c.001-2.277 1.873-4.122 4.181-4.12.976 0 1.92.338 2.671.954-.034.018-.092.05-.131.073l-4.44 2.53a.71.71 0 00-.365.623l-.003 6.173v.002zm1.02-2.168L12 9.25l2.414 1.375v2.75L12 14.75l-2.415-1.375v-2.75z"></path></svg></span>
                                            <?php ee('Open in ChatGPT') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item p-2" href="https://claude.ai/new?q=<?php echo urlencode("Read from ".route('apidocs')."#$id so I can ask questions about it.") ?>" class="d-flex align-items-center" target="_blank">
                                            <span class="py-1 px-2 border rounded-3"><svg fill="currentColor" fill-rule="evenodd" height="1em" viewBox="0 0 256 257" width="1em" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" preserveAspectRatio="xMidYMid"><title>Anthropic</title><path d="m50.228 170.321 50.357-28.257.843-2.463-.843-1.361h-2.462l-8.426-.518-28.775-.778-24.952-1.037-24.175-1.296-6.092-1.297L0 125.796l.583-3.759 5.12-3.434 7.324.648 16.202 1.101 24.304 1.685 17.629 1.037 26.118 2.722h4.148l.583-1.685-1.426-1.037-1.101-1.037-25.147-17.045-27.22-18.017-14.258-10.37-7.713-5.25-3.888-4.925-1.685-10.758 7-7.713 9.397.649 2.398.648 9.527 7.323 20.35 15.75L94.817 91.9l3.889 3.24 1.555-1.102.195-.777-1.75-2.917-14.453-26.118-15.425-26.572-6.87-11.018-1.814-6.61c-.648-2.723-1.102-4.991-1.102-7.778l7.972-10.823L71.42 0 82.05 1.426l4.472 3.888 6.61 15.101 10.694 23.786 16.591 32.34 4.861 9.592 2.592 8.879.973 2.722h1.685v-1.556l1.36-18.211 2.528-22.36 2.463-28.776.843-8.1 4.018-9.722 7.971-5.25 6.222 2.981 5.12 7.324-.713 4.73-3.046 19.768-5.962 30.98-3.889 20.739h2.268l2.593-2.593 10.499-13.934 17.628-22.036 7.778-8.749 9.073-9.657 5.833-4.601h11.018l8.1 12.055-3.628 12.443-11.342 14.388-9.398 12.184-13.48 18.147-8.426 14.518.778 1.166 2.01-.194 30.46-6.481 16.462-2.982 19.637-3.37 8.88 4.148.971 4.213-3.5 8.62-20.998 5.184-24.628 4.926-36.682 8.685-.454.324.519.648 16.526 1.555 7.065.389h17.304l32.21 2.398 8.426 5.574 5.055 6.805-.843 5.184-12.962 6.611-17.498-4.148-40.83-9.721-14-3.5h-1.944v1.167l11.666 11.406 21.387 19.314 26.767 24.887 1.36 6.157-3.434 4.86-3.63-.518-23.526-17.693-9.073-7.972-20.545-17.304h-1.36v1.814l4.73 6.935 25.017 37.59 1.296 11.536-1.814 3.76-6.481 2.268-7.13-1.297-14.647-20.544-15.1-23.138-12.185-20.739-1.49.843-7.194 77.448-3.37 3.953-7.778 2.981-6.48-4.925-3.436-7.972 3.435-15.749 4.148-20.544 3.37-16.333 3.046-20.285 1.815-6.74-.13-.454-1.49.194-15.295 20.999-23.267 31.433-18.406 19.702-4.407 1.75-7.648-3.954.713-7.064 4.277-6.286 25.47-32.405 15.36-20.092 9.917-11.6-.065-1.686h-.583L44.07 198.125l-12.055 1.555-5.185-4.86.648-7.972 2.463-2.593 20.35-13.999-.064.065Z"></path></svg></span>
                                            <?php ee('Open in Claude') ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </h4>
                    <?php if($el['description']):?><p class="mt-2 ml-4 text-start"><?php echo $el['description'] ?></p><?php endif ?>
                    <?php foreach($el['endpoints'] as $key => $data): ?>
                        <div id="<?php echo $id.'-'.$key ?>" class="row mb-5">
                            <div class="col-lg-7">
                                <div class="card-header bg-transparent">
                                    <h6 class="mb-0 fw-bolder" id="<?php echo \Core\Helper::slug($data['title']) ?>"><i class="fa fa-terminal me-3"></i><?php echo $data['title'] ?></h6>
                                </div>
                                <div class="card-body pt-4">
                                    <div class="border rounded p-2">
                                        <span class="badge bg-<?php echo \Helpers\App::apiMethodColor($data['method']) ?> me-2 align-middle text-xs"><?php echo $data['method'] ?></span> <code><?php echo $data['route'] ?></code>
                                    </div>
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
                                <div class="mt-3 code-area">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="code-lang">
                                            <a href="#curl" class="btn btn-default text-white btn-sm active">cURL</a>
                                            <a href="#php" class="btn btn-default text-white btn-sm">PHP</a>
                                            <a href="#nodejs" class="btn btn-default text-white btn-sm">Node.js</a>
                                            <a href="#python" class="btn btn-default text-white btn-sm">Python</a>
                                            <a href="#cpound" class="btn btn-default text-white btn-sm">C#</a>
                                        </div>
                                        <button type="button" class="btn btn-transparent ms-auto" title="<?php ee('Copy Code') ?>" data-trigger="copycode"><i class="fa fa-clipboard"></i></button>
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
                                <div class="code-area">
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