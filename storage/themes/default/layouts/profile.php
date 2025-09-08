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
        <?php if(config('fonts') && !config('cookieconsent')->enabled): ?>
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=<?php echo str_replace(' ', '+', config('fonts')) ?>:wght@300;400;600" rel="stylesheet">
            <style>body{font-family:'<?php echo config('fonts') ?>' !important}</style>
        <?php endif ?>
        <script>
            var appurl = '<?php echo url() ?>';
        </script>
        <?php echo html_entity_decode(config('customheader')) ?>
        <?php block('header') ?>
    </head>
    <body<?php echo \Core\View::bodyClass() ?>>
        <?php section() ?>
        <script src="<?php echo assets('webpack.pack.js') ?>"></script>   
        <?php if(config('cookieconsent')->enabled): ?>
            <script id="cookieconsent-script" src="<?php echo assets('frontend/libs/cookieconsent/cookieconsent.js') ?>"></script>
        <?php endif ?>
        <?php view('partials.languagejs') ?>
        <script src="<?php echo assets('frontend/libs/clipboard/dist/clipboard.min.js') ?>"></script>
        <script src="<?php echo assets('app.min.js') ?>"></script>
        <script src="<?php echo assets('custom.min.js') ?>"></script>
        <script src="<?php echo assets('server.min.js?v=1.2') ?>"></script>
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
        <?php block('profilefooter') ?>
    </body>
</html>
