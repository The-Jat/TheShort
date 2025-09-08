<!DOCTYPE html>
    <html lang="<?php echo \Core\Localization::locale() ?>"<?php echo \Core\Localization::get('rtl') ? ' dir="rtl"':''?><?php echo (request()->cookie('darkmode') || themeSettings::isDark() ? ' data-theme="dark" class="c_darkmode"' : '') ?><?php echo themeSettings::config('homestyle', 'auto') ? ' data-auto-scheme="true"' : '' ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php meta() ?>

        <link rel="stylesheet" type="text/css" href="<?php echo \Core\Localization::get('rtl') ? assets('bootstrap.rtl.min.css') : assets('bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo assets('frontend/libs/fontawesome/all.min.css') ?>">
        <?php if(config('cookieconsent')->enabled): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo assets('frontend/libs/cookieconsent/cookieconsent.css') ?>">
        <?php endif ?>
        <link rel="stylesheet" href="<?php echo assets('style.min.css') ?>?v=1.1" id="stylesheet">
        <script>
            var appurl = '<?php echo url() ?>';
        </script>
        <?php echo html_entity_decode(config('customheader')) ?>
        <?php block('header') ?>
    </head>    
    <body>
        <a class="position-fixed bottom-0 end-0 m-3 btn btn-dark rounded-circle shadow opacity-0" role="button" data-trigger="scrollto" data-top="0" id="scroll-to-top">
            <i class="fa fa-chevron-up small" aria-hidden="true"></i>
        </a>        
        <a class="position-fixed bottom-0 start-0 m-3 btn btn-dark rounded-circle shadow py-2 zindex-top d-inline-block d-md-none" data-bs-toggle="collapse" data-bs-target=".doc-sidebar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-list"></i>
        </a>

        <?php view('partials.main_menu', ['menu' => 'full']) ?>
            
        <?php section() ?>

        <?php view('partials.footer') ?>
        
        <?php view('partials.languagejs') ?>

        <script src="<?php echo assets('webpack.pack.js') ?>"></script>   
        <?php if(config('cookieconsent')->enabled): ?>
            <script id="cookieconsent-script" src="<?php echo assets('frontend/libs/cookieconsent/cookieconsent.js') ?>"></script>
        <?php endif ?>
        <?php block('footer') ?>        
        <script src="<?php echo assets('app.min.js') ?>"></script>
        <script src="<?php echo assets('server.min.js') ?>"></script>  
        <?php echo html_entity_decode(config('customfooter')) ?>
        <?php if(!empty(config('analytic'))): ?>
			<script<?php echo \Helpers\App::cookieConsent('analytics') ?>async src='https://www.googletagmanager.com/gtag/js?id=<?php echo config('analytic') ?>'></script>
            <script<?php echo \Helpers\App::cookieConsent('analytics') ?>>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '<?php echo config('analytic') ?>');</script>
		<?php endif ?>
        <?php if(config('fonts') && config('cookieconsent')->enabled): ?>            
            <script<?php echo \Helpers\App::cookieConsent('extra') ?>>
                $('head').append('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=<?php echo str_replace(' ', '+', config('fonts')) ?>:wght@300;400;600;900">').append('<style>body{font-family:\'<?php echo config('fonts') ?>\' !important}</style>');
            </script>
        <?php endif ?>
    </body>
</html>