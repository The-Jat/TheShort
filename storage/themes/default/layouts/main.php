<!DOCTYPE html>
<html lang="<?php echo \Core\Localization::locale() ?>"<?php echo \Core\Localization::get('rtl') ? 'dir="rtl"':''?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php meta() ?>

        <link rel="stylesheet" href="<?php echo assets('frontend/libs/fontawesome/all.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo assets('frontend/libs/select2/dist/css/select2.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo assets('frontend/libs/cookieconsent/cookieconsent.css') ?>">
        <link rel="stylesheet" href="<?php echo assets('frontend/css/style'.(request()->cookie('darkmode') || themeSettings::config('homestyle', 'darkmode', true) ? '-dark' : '').'.min.css') ?>?v=1.1" id="stylesheet">
        <?php if(\Core\Localization::get('rtl')): ?>
            <link rel="stylesheet" href="<?php echo assets('frontend/css/rtl.css') ?>" id="stylesheet">
        <?php endif ?>
        <?php if(config('font') && !config('cookieconsent')->enabled): ?>
            <link href="https://fonts.googleapis.com/css2?family=<?php echo str_replace(' ', '+', config('font')) ?>:wght@300;400;600" rel="stylesheet">
            <style>body{font-family:'<?php echo config('font') ?>' !important}</style>
        <?php endif ?>
        <script>
            var appurl = '<?php echo url() ?>';
        </script>
        <?php echo html_entity_decode(config('customheader')) ?>
        <?php block('header') ?>
    </head>
    <body>
        <header class="header-transparent" id="header-main">
            <?php if(\Helpers\App::loggedAs()): ?>
                <div class="alert alert-success mb-0 text-right p-2 rounded-0 d-block">
                    <?php ee('You are logged in as another user') ?>
                    <a href="<?php echo route('return') ?>" class="btn btn-light ml-2 btn-xs"><?php ee('Return to my account') ?></a>
                </div>
            <?php endif ?>
            <nav class="navbar navbar-main navbar-expand-lg <?php echo themeSettings::config('homestyle', 'light', 'navbar-light bg-white', 'navbar-dark bg-dark') ?>" id="navbar-main">
                <div class="container border-0">
                    <a class="navbar-brand" href="<?php echo route('home') ?>" title="<?php echo config('sitename') ?>">
                        <?php if(config('logo')): ?>
                            <img alt="<?php echo config('sitename') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                        <?php else: ?>
                            <h1 class="h5 mt-2 <?php echo themeSettings::config('homestyle', 'light', 'text-dark', 'text-white') ?>"><?php echo config('sitename') ?></h1>
                        <?php endif ?>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse navbar-collapse-overlay" id="navbar-main-collapse">
                        <div class="position-relative">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <?php view('partials.main_menu') ?>
                    </div>
                </div>
            </nav>
        </header>

        <?php section() ?>

        <?php view('partials.footer') ?>

        <script src="<?php echo assets('bundle.pack.js') ?>"></script>
        <script src="<?php echo assets('frontend/libs/feather-icons/dist/feather.min.js') ?>"></script>
        <?php if(config('cookieconsent')->enabled): ?>
            <script id="cookieconsent-script" src="<?php echo assets('frontend/libs/cookieconsent/cookieconsent.js') ?>"></script>
        <?php endif ?>
        <?php block('footer') ?>
        <script type="text/javascript">
            var lang = <?php echo json_encode([
                "error" => e('Please enter a valid URL.'),
                "couponinvalid" => e("The coupon enter is not valid"),
                "minurl" => e("You must select at least 1 url."),
                "minsearch" => e("Keyword must be more than 3 characters!"),
                "nodata" => e("No data is available for this request."),
                "datepicker" => [
                    '7d' => 'Last 7 Days',
                    '3d' => 'Last 30 Days',
                    'tm' => 'This Month',
                    'lm' => 'Last Month',
                ],
                'cookie' => [
                    'title' => e('Cookie Preferences'),
                    'description' => !empty(config('cookieconsent')->message) ? e(config('cookieconsent')->message) : e('This website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. You have the option to choose which one to allow.'),
                    'button' => ' <button type="button" data-cc="c-settings" class="cc-link" aria-haspopup="dialog">'.e('Let me choose').'</button>',
                    'accept_all' => e('Accept All'),
                    'accept_necessary' => e('Accept Necessary'),
                    'close' => e('Close'),
                    'save' => e('Save Settings'),
                    'necessary' => [
                        'title' => e('Strictly Necessary Cookies'),
                        'description' => e('These cookies are required for the correct functioning of our service and without these cookies you will not be able to use our product.')
                    ],
                    'analytics' => [
                        'title' => e('Targeting and Analytics'),
                        'description' => e('Providers such as Google use these cookies to measure and provide us with analytics on how you interact with our website. All of the data is anonymized and cannot be used to identify you.')
                    ],
                    'ads' => [
                        'title' => e('Advertisement'),
                        'description' => e('These cookies are set by our advertisers so they can provide you with relevant ads.')
                    ],
                    'extra' => [
                        'title' => e('Additional Functionality'),
                        'description' => e('We use various providers to enhance our products and they may or may not set cookies. Enhancement can include Content Delivery Networks, Google Fonts, etc')
                    ],
                    'privacy' => [
                        'title' => e('Privacy Policy'),
                        'description' => e('You can view our privacy policy').' <a target="_blank" class="cc-link" href="'.(!empty(config('cookieconsent')->link) ? config('cookieconsent')->link : route('page', ['privacy'])).'">'.e('here').'</a>. '.e('If you have any questions, please do not hesitate to').' <a href="'.route('contact').'" target="_blank" class="cc-link">'.e('Contact us').'</a>'
                    ]
                ]
                ]) ?>
        </script>
        <script>
            feather.replace({
                'width': '1em',
                'height': '1em'
            })
        </script>
        <script src="<?php echo assets('frontend/js/app.min.js') ?>?v=1.2"></script>
        <script src="<?php echo assets('server.min.js') ?>?v=1.2"></script>
        <?php echo html_entity_decode(config('customfooter')) ?>
        <?php if(!empty(config('analytic'))): ?>
			<script<?php echo \Helpers\App::cookieConsent('analytics') ?>async src='https://www.googletagmanager.com/gtag/js?id=<?php echo config('analytic') ?>'></script>
            <script<?php echo \Helpers\App::cookieConsent('analytics') ?>>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '<?php echo config('analytic') ?>');</script>
		<?php endif ?>
        <?php if(config('font') && config('cookieconsent')->enabled): ?>            
            <script<?php echo \Helpers\App::cookieConsent('extra') ?>>
                $('head').append('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=<?php echo str_replace(' ', '+', config('font')) ?>:wght@300;400;600;900">').append('<style>body{font-family:\'<?php echo config('font') ?>\' !important}</style>');
            </script>
        <?php endif ?>
    </body>

</html>