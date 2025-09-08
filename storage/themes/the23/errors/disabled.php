<!DOCTYPE html>
<html lang="<?php echo \Core\Localization::locale() ?>"<?php echo \Core\Localization::get('rtl') ? ' dir="rtl"':''?><?php echo (request()->cookie('darkmode') || themeSettings::isDark() ? ' data-theme="dark"' : '') ?><?php echo themeSettings::config('homestyle', 'auto') ? ' data-auto-scheme="true"' : '' ?>>
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
        <link rel="stylesheet" href="<?php echo assets('style.min.css') ?>" id="stylesheet">
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
    <body class="bg-primary min-vh-100">
        <div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-between vh-100">
                <div class="col-12 text-center">
                    <a href="<?php echo route('home') ?>" class="mb-5 mb-md-0 text-dark text-decoration-none text-center">
                    <?php if(config('logo')): ?>
                        <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                    <?php else: ?>
                        <h1 class="h5 fw-bold"><?php echo config('title') ?></h1>
                    <?php endif ?>        
                    </a>
                    
                    <h6 class="display-1 mb-3 mt-5 fw-bold text-secondary"><?php ee('Oops') ?></h6>
                    <p class="lead text-lg mb-5">
                        <?php ee('There is a problem with this link and we have blocked it either because it is potentially malicious or contains inappropriate content that is against our terms of service. We actively monitor all links on our platform to ensure the safety of all our users. If you have any questions, feel free to contact us.') ?>
                    </p>

                    <a href="<?php echo route('home') ?>" class="btn btn-primary px-5 py-3">
                        <?php ee('Back to home') ?>
                    </a>
                </div>
            </div>
        </div>
        <?php echo html_entity_decode(config('customfooter')) ?>
        <?php if(!empty(config('analytic'))): ?>
			<script async src='https://www.googletagmanager.com/gtag/js?id=<?php echo config('analytic') ?>'></script>
            <script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '<?php echo config('analytic') ?>');</script>
		<?php endif ?>
    </body>
</html>