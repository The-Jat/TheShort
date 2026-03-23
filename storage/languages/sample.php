
<?php 

return [
    /**
     * Language Information
     */
    "code" => "en",
    "region" => "en_US",
    "name" => "Sample",
    "author" => "GemPixel",
    "link" => "https://gempixel.com",
    "date" => "25/08/2025",
    "rtl" => false,
    /**
     * Language Data
     */
    "data" => [  
        #: app/controllers/BlogController.php:83
        #: storage/themes/default/blog/categories.php:6
        #: storage/themes/default/blog/index.php:6
        #: storage/themes/default/blog/search.php:6
        #: storage/themes/default/partials/main_menu.php:107
        #: storage/themes/the23/blog/categories.php:4
        #: storage/themes/the23/blog/index.php:5 storage/themes/the23/blog/search.php:5
        #: storage/themes/the23/blog/single.php:10
        #: storage/themes/the23/partials/main_menu.php:94
        "Blog"=> "",

        #: app/controllers/BlogController.php:84 app/controllers/BlogController.php:208
        "Check out blog for tips & tricks"=> "",

        #: app/controllers/BlogController.php:140
        #: app/controllers/BlogController.php:207
        "{c} Posts"=> "",

        #: app/controllers/HelpController.php:62
        #: storage/themes/default/help/category.php:7
        #: storage/themes/default/help/search.php:7
        #: storage/themes/default/help/single.php:7
        #: storage/themes/default/help/top.php:5
        #: storage/themes/default/partials/footer.php:73
        #: storage/themes/default/partials/main_menu.php:42
        #: storage/themes/default/partials/topbar_menu.php:128
        #: storage/themes/the23/help/category.php:7
        #: storage/themes/the23/help/search.php:7
        #: storage/themes/the23/help/single.php:9
        #: storage/themes/the23/partials/footer.php:72
        #: storage/themes/the23/partials/main_menu.php:120
        "Help Center"=> "",

        #: app/controllers/HelpController.php:63 app/controllers/HelpController.php:85
        #: app/controllers/HelpController.php:120
        #: storage/themes/default/partials/main_menu.php:43
        "Check out our help center"=> "",

        #: app/controllers/HelpController.php:83 app/controllers/HelpController.php:118
        #: app/controllers/HelpController.php:145
        "{t} - Help Center"=> "",

        #: app/controllers/LinkController.php:57 app/controllers/LinkController.php:830
        #: app/controllers/LinkController.php:856
        #: app/controllers/LinkController.php:882
        #: app/controllers/LinkController.php:912
        #: app/controllers/LinkController.php:940
        #: app/controllers/LinkController.php:970
        #: app/controllers/LinkController.php:999
        #: app/controllers/LinkController.php:1076
        #: app/controllers/user/AccountController.php:45
        #: app/controllers/user/BioController.php:169
        #: app/controllers/user/BioController.php:330
        #: app/controllers/user/BioController.php:464
        #: app/controllers/user/BioController.php:495
        #: app/controllers/user/BioController.php:702
        #: app/controllers/user/BioController.php:958
        #: app/controllers/user/BioController.php:1007
        #: app/controllers/user/BioController.php:1297
        #: app/controllers/user/BioController.php:1340
        #: app/controllers/user/BioController.php:1675
        #: app/controllers/user/BioController.php:1703
        #: app/controllers/user/BioController.php:1773
        #: app/controllers/user/BioController.php:1929
        #: app/controllers/user/CampaignsController.php:79
        #: app/controllers/user/CampaignsController.php:158
        #: app/controllers/user/CampaignsController.php:205
        #: app/controllers/user/ChannelsController.php:198
        #: app/controllers/user/ChannelsController.php:236
        #: app/controllers/user/ChannelsController.php:268
        #: app/controllers/user/ChannelsController.php:353
        #: app/controllers/user/DomainsController.php:90
        #: app/controllers/user/DomainsController.php:130
        #: app/controllers/user/DomainsController.php:195
        #: app/controllers/user/DomainsController.php:238
        #: app/controllers/user/DomainsController.php:271
        #: app/controllers/user/ExportController.php:50
        #: app/controllers/user/ExportController.php:85
        #: app/controllers/user/ExportController.php:118
        #: app/controllers/user/ExportController.php:156
        #: app/controllers/user/ExportController.php:205
        #: app/controllers/user/ImportController.php:51
        #: app/controllers/user/ImportController.php:73
        #: app/controllers/user/OverlayController.php:91
        #: app/controllers/user/OverlayController.php:122
        #: app/controllers/user/OverlayController.php:149
        #: app/controllers/user/OverlayController.php:177
        #: app/controllers/user/OverlayController.php:1679
        #: app/controllers/user/PixelsController.php:95
        #: app/controllers/user/PixelsController.php:127
        #: app/controllers/user/PixelsController.php:181
        #: app/controllers/user/PixelsController.php:205
        #: app/controllers/user/PixelsController.php:246
        #: app/controllers/user/QRController.php:142
        #: app/controllers/user/QRController.php:479
        #: app/controllers/user/QRController.php:716
        #: app/controllers/user/QRController.php:860
        #: app/controllers/user/QRController.php:1089
        #: app/controllers/user/QRController.php:1126
        #: app/controllers/user/QRController.php:1198
        #: app/controllers/user/QRController.php:1321
        #: app/controllers/user/QRController.php:1514
        #: app/controllers/user/SplashController.php:85
        #: app/controllers/user/SplashController.php:120
        #: app/controllers/user/SplashController.php:217
        #: app/controllers/user/SplashController.php:252
        #: app/controllers/user/SplashController.php:363
        #: app/controllers/user/TeamsController.php:113
        "You do not have this permission. Please contact your team administrator."=> "",

        #: app/controllers/LinkController.php:67
        "Please enter valid links."=> "",

        #: app/controllers/LinkController.php:80
        "Links have been shortened."=> "",

        #: app/controllers/LinkController.php:155
        "The password is invalid or does not match."=> "",

        #: app/controllers/LinkController.php:834
        #: app/controllers/LinkController.php:1384
        #: app/controllers/UsersController.php:1453
        #: app/controllers/UsersController.php:1455
        #: app/controllers/UsersController.php:1457
        #: app/controllers/UsersController.php:1476
        #: app/controllers/UsersController.php:1498
        #: app/controllers/user/AccountController.php:527
        #: app/controllers/user/AccountController.php:535
        #: app/controllers/user/AccountController.php:560
        #: app/controllers/user/AccountController.php:636
        #: app/controllers/user/BioController.php:468
        #: app/controllers/user/CampaignsController.php:209
        #: app/controllers/user/ChannelsController.php:274
        #: app/controllers/user/DevelopersController.php:148
        #: app/controllers/user/DomainsController.php:276
        #: app/controllers/user/ImportController.php:157
        #: app/controllers/user/OverlayController.php:135
        #: app/controllers/user/OverlayController.php:162
        #: app/controllers/user/OverlayController.php:192
        #: app/controllers/user/OverlayController.php:1683
        #: app/controllers/user/PixelsController.php:250
        #: app/controllers/user/QRController.php:1095
        #: app/controllers/user/TeamsController.php:227
        #: app/helpers/payments/Paddle.php:448 app/helpers/payments/Paddle.php:558
        #: app/helpers/payments/Paddle.php:560 app/helpers/payments/Polar.php:1203
        #: app/helpers/payments/Stripe.php:1220 app/helpers/payments/Stripe.php:1231
        "An unexpected error occurred. Please try again."=> "",

        #: app/controllers/LinkController.php:840
        #: app/controllers/LinkController.php:1416
        #: app/controllers/LinkController.php:1437
        "Link not found. Please try again."=> "",

        #: app/controllers/LinkController.php:843
        "Link has been deleted."=> "",

        #: app/controllers/LinkController.php:861
        "No link was selected. Please try again."=> "",

        #: app/controllers/LinkController.php:870
        "Selected Links have been deleted."=> "",

        #: app/controllers/LinkController.php:891
        #: app/controllers/LinkController.php:921
        #: app/controllers/LinkController.php:949
        #: app/controllers/LinkController.php:979
        #: app/controllers/LinkController.php:1141
        #: app/controllers/user/ChannelsController.php:310
        #: app/controllers/user/ExportController.php:211
        #: app/controllers/user/PixelsController.php:297
        "You need to select at least 1 link."=> "",

        #: app/controllers/LinkController.php:899
        "Selected links have been archived."=> "",

        #: app/controllers/LinkController.php:928
        "Selected links have been removed from archive."=> "",

        #: app/controllers/LinkController.php:957
        "Selected links have been set to public."=> "",

        #: app/controllers/LinkController.php:986
        "Selected links have been set to private."=> "",

        #: app/controllers/LinkController.php:1002
        #: app/controllers/LinkController.php:1389
        #: app/controllers/user/ExportController.php:89
        "Link does not exist."=> "",

        #: app/controllers/LinkController.php:1004
        #: storage/themes/default/user/edit.php:4
        #: storage/themes/default/user/edit.php:6
        #: storage/themes/default/user/edit.php:631
        "Update Link"=> "",

        #: app/controllers/LinkController.php:1079
        "URL does not exist."=> "",

        #: app/controllers/LinkController.php:1118
        "Link has been updated successfully."=> "",

        #: app/controllers/LinkController.php:1130
        "Invalid campaign. Please choose a valid campaign."=> "",

        #: app/controllers/LinkController.php:1148
        "Selected links have been added to the {c} campaign."=> "",

        #: app/controllers/LinkController.php:1148
        "Selected links have been removed from campaigns."=> "",

        #: app/controllers/LinkController.php:1231
        "This has been disabled in demo."=> "",

        #: app/controllers/LinkController.php:1233
        "You need to be logged in to use this feature."=> "",

        #: app/controllers/LinkController.php:1354
        "You have to make your profile public or set a default bio for this page to be accessible."=> "",

        #: app/controllers/LinkController.php:1398
        "Statistics have been successfully reset."=> "",

        #: app/controllers/LinkController.php:1440
        "Your final destination is: {u}"=> "",

        #: app/controllers/LinkController.php:1447
        #: storage/themes/default/verifylink.php:4
        "Verify Short Link"=> "",

        #: app/controllers/PageController.php:76
        #: storage/themes/default/pages/contact.php:6
        #: storage/themes/default/partials/footer.php:82
        #: storage/themes/the23/errors/404.php:47
        #: storage/themes/the23/pages/contact.php:5
        #: storage/themes/the23/partials/footer.php:81
        "Contact Us"=> "",

        #: app/controllers/PageController.php:78
        #: storage/themes/the23/pages/contact.php:6
        "If you have any questions, feel free to contact us so we can help you."=> "",

        #: app/controllers/PageController.php:117
        #: app/controllers/PageController.php:248
        #: app/controllers/ServerController.php:134
        #: app/controllers/UsersController.php:597
        #: app/controllers/UsersController.php:727
        #: app/controllers/UsersController.php:1494
        #: app/controllers/user/AccountController.php:386
        #: app/controllers/user/AffiliateController.php:70
        #: app/controllers/user/OverlayController.php:323
        #: app/controllers/user/OverlayController.php:492
        #: app/controllers/user/TeamsController.php:121
        #: app/helpers/biowidgets/Contact.php:109 app/helpers/biowidgets/Link.php:373
        #: app/helpers/biowidgets/Newsletter.php:155
        #: storage/themes/default/auth/register.php:75
        #: storage/themes/default/pages/contact.php:26
        #: storage/themes/default/pages/report.php:22
        "Please enter a valid email."=> "",

        #: app/controllers/PageController.php:125
        "Please enter your name."=> "",

        #: app/controllers/PageController.php:133
        "Please enter a message or message too short."=> "",

        #: app/controllers/PageController.php:143
        #: app/controllers/PageController.php:153
        #: app/controllers/PageController.php:172
        #: app/controllers/ServerController.php:66
        #: app/controllers/ServerController.php:72
        #: app/controllers/ServerController.php:87
        #: app/helpers/biowidgets/Contact.php:124
        #: app/helpers/biowidgets/Contact.php:130
        #: app/helpers/biowidgets/Contact.php:145
        "Your message has been flagged as potential spam. Please review and try again."=> "",

        #: app/controllers/PageController.php:204
        "Your message has been sent. We will reply you as soon as possible."=> "",

        #: app/controllers/PageController.php:220
        "Report Link"=> "",

        #: app/controllers/PageController.php:222
        #: storage/themes/default/pages/report.php:7
        #: storage/themes/the23/pages/report.php:6
        "Please report a link that you consider risky or dangerous. We will review all cases and take measure to remove the link."=> "",

        #: app/controllers/PageController.php:256
        #: storage/themes/default/pages/report.php:26
        #: storage/themes/the23/pages/report.php:18
        "Please enter a valid link."=> "",

        #: app/controllers/PageController.php:296
        "Thank you. We will review this link and take action."=> "",

        #: app/controllers/PageController.php:323
        #: storage/themes/default/pages/api.php:57
        #: storage/themes/the23/pages/api.php:45
        "API Reference for Developers"=> "",

        #: app/controllers/PageController.php:325
        "API Reference for Developers."=> "",

        #: app/controllers/PageController.php:392
        #: storage/themes/default/partials/footer.php:79
        #: storage/themes/the23/partials/footer.php:78
        "Affiliate Program"=> "",

        #: app/controllers/PageController.php:394
        "Refer customers to us and we will reward you a commission on all qualifying sales made on our website. Anyone can join the affiliate program."=> "",

        #: app/controllers/PageController.php:410
        #: app/controllers/user/QRController.php:127 app/helpers/App.php:387
        #: app/models/Role.php:80 app/traits/Teams.php:47
        #: storage/themes/default/index.php:306 storage/themes/default/pages/qr.php:300
        #: storage/themes/default/partials/footer.php:59
        #: storage/themes/default/partials/main_menu.php:60
        #: storage/themes/default/partials/sidebar_menu.php:62
        #: storage/themes/default/qr/index.php:2 storage/themes/default/qr/index.php:15
        #: storage/themes/default/qr/index.php:23
        #: storage/themes/default/user/channel.php:54
        #: storage/themes/default/user/confirmation.php:79
        #: storage/themes/the23/index.php:16 storage/themes/the23/index.php:124
        #: storage/themes/the23/index.php:235 storage/themes/the23/index.php:282
        #: storage/themes/the23/pages/qr.php:301
        #: storage/themes/the23/partials/footer.php:51
        #: storage/themes/the23/partials/main_menu.php:46
        #: storage/themes/the23/pricing/categorized.php:34
        "QR Codes"=> "",

        #: app/controllers/PageController.php:412 app/helpers/App.php:388
        #: storage/themes/default/index.php:308 storage/themes/default/pages/qr.php:303
        #: storage/themes/the23/pages/qr.php:304
        "Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement."=> "",

        #: app/controllers/PageController.php:416
        "Free QR Code Generator"=> "",

        #: app/controllers/PageController.php:549
        #: app/controllers/user/BioController.php:188
        #: app/controllers/user/BioController.php:349
        #: app/controllers/user/BioController.php:719
        #: app/controllers/user/BioController.php:1026 app/traits/Links.php:153
        #: app/traits/Links.php:633
        "Custom alias must be at least 3 characters."=> "",

        #: app/controllers/PageController.php:553
        #: app/controllers/PageController.php:557
        #: app/controllers/user/BioController.php:194
        #: app/controllers/user/BioController.php:197
        #: app/controllers/user/BioController.php:200
        #: app/controllers/user/BioController.php:355
        #: app/controllers/user/BioController.php:358
        #: app/controllers/user/BioController.php:361
        #: app/controllers/user/BioController.php:725
        #: app/controllers/user/BioController.php:728
        #: app/controllers/user/BioController.php:731
        #: app/controllers/user/BioController.php:1032
        #: app/controllers/user/BioController.php:1035
        #: app/controllers/user/BioController.php:1038 app/traits/Links.php:159
        #: app/traits/Links.php:162 app/traits/Links.php:165 app/traits/Links.php:639
        #: app/traits/Links.php:642 app/traits/Links.php:645
        "That alias is taken. Please choose another one."=> "",

        #: app/controllers/PageController.php:562
        #: app/controllers/user/BioController.php:152 app/helpers/App.php:381
        #: app/models/Role.php:89 app/traits/Teams.php:56
        #: storage/themes/default/bio/index.php:2
        #: storage/themes/default/bio/index.php:12
        #: storage/themes/default/bio/index.php:20
        #: storage/themes/default/pages/bio.php:6
        #: storage/themes/default/partials/main_menu.php:68
        #: storage/themes/default/partials/sidebar_menu.php:55
        #: storage/themes/default/user/channel.php:52 storage/themes/the23/index.php:16
        #: storage/themes/the23/index.php:133 storage/themes/the23/index.php:207
        #: storage/themes/the23/pages/bio.php:7
        #: storage/themes/the23/partials/footer.php:52
        #: storage/themes/the23/partials/main_menu.php:35
        #: storage/themes/the23/pricing/categorized.php:38
        "Bio Pages"=> "",

        #: app/controllers/PageController.php:564 app/helpers/App.php:382
        #: storage/themes/default/pages/bio.php:9 storage/themes/the23/pages/bio.php:10
        "Convert your followers by creating beautiful pages that group all of your important links on the single page."=> "",

        #: app/controllers/PageController.php:586
        #: storage/themes/default/pages/consent.php:6
        #: storage/themes/the23/pages/consent.php:5
        "Cookie Policy Consent"=> "",

        #: app/controllers/QRController.php:255 app/controllers/QRController.php:257
        "Invalid request. Please try again"=> "",

        #: app/controllers/QRController.php:282
        "QR code successfully generated"=> "",

        #: app/controllers/ServerController.php:59
        "Please enter a valid email address."=> "",

        #: app/controllers/ServerController.php:61
        #: app/controllers/ServerController.php:150
        #: app/helpers/biowidgets/Contact.php:111
        #: app/helpers/biowidgets/Newsletter.php:157
        "Please accept the disclaimer."=> "",

        #: app/controllers/ServerController.php:174
        #: app/controllers/UsersController.php:868 app/helpers/biowidgets/Link.php:393
        "An error occurred. Please try again."=> "",

        #: app/controllers/ServerController.php:218
        #: app/controllers/user/OverlayController.php:916
        #: app/controllers/user/OverlayController.php:1085
        #: app/controllers/user/OverlayController.php:1208
        #: app/controllers/user/OverlayController.php:1345
        #: app/controllers/user/SplashController.php:131
        #: app/controllers/user/SplashController.php:261 app/helpers/QR.php:702
        #: app/helpers/QR.php:704 app/traits/Links.php:100 app/traits/Links.php:576
        #: storage/themes/default/layouts/api.php:63
        #: storage/themes/default/layouts/auth.php:30
        #: storage/themes/default/layouts/dashboard.php:123
        #: storage/themes/default/layouts/main.php:71
        #: storage/themes/default/layouts/stats.php:70
        #: storage/themes/the23/partials/languagejs.php:3
        "Please enter a valid URL."=> "",

        #: app/controllers/ServerController.php:224
        "Deep linking automatically generated"=> "",

        #: app/controllers/StatsController.php:63
        #: app/controllers/StatsController.php:68
        #: app/controllers/StatsController.php:244
        #: app/controllers/StatsController.php:249
        #: app/controllers/StatsController.php:497
        #: app/controllers/StatsController.php:502
        #: app/controllers/StatsController.php:657
        #: app/controllers/StatsController.php:662
        #: app/controllers/StatsController.php:813
        #: app/controllers/StatsController.php:818
        #: app/controllers/StatsController.php:970
        #: app/controllers/StatsController.php:975
        #: app/controllers/StatsController.php:1056
        #: app/controllers/StatsController.php:1061
        #: app/controllers/StatsController.php:1142
        #: app/controllers/StatsController.php:1147
        "This link is private and only the creator can access the stats. If you are the creator, please login to access it."=> "",

        #: app/controllers/StatsController.php:91
        #: app/controllers/StatsController.php:270
        #: app/controllers/StatsController.php:523
        #: app/controllers/StatsController.php:683
        #: app/controllers/StatsController.php:839
        #: app/controllers/StatsController.php:996
        #: app/controllers/StatsController.php:1082
        #: app/controllers/StatsController.php:1167 app/helpers/App.php:1058
        #: storage/themes/default/user/settings.php:177
        "Direct"=> "",

        #: app/controllers/StatsController.php:95
        #: app/controllers/StatsController.php:100
        #: app/controllers/StatsController.php:105
        #: app/controllers/StatsController.php:277
        #: app/controllers/StatsController.php:530
        #: app/controllers/StatsController.php:690
        #: app/controllers/StatsController.php:846
        #: app/controllers/StatsController.php:1026
        #: app/controllers/StatsController.php:1114
        "Stats for"=> "",

        #: app/controllers/StatsController.php:106
        #: app/controllers/StatsController.php:1182
        "Advanced statistics page for the short URL"=> "",

        #: app/controllers/StatsController.php:118
        #: app/controllers/StatsController.php:295
        #: app/controllers/StatsController.php:546
        #: app/controllers/StatsController.php:703
        #: app/controllers/StatsController.php:859
        #: app/controllers/StatsController.php:1191
        #: app/controllers/user/CampaignsController.php:238
        #: app/controllers/user/DashboardController.php:100
        #: app/controllers/user/StatsController.php:48
        #: app/controllers/user/StatsController.php:220
        #: storage/themes/default/pricing/checkout.php:130
        #: storage/themes/the23/pricing/checkout.php:152
        "Apply"=> "",

        #: app/controllers/StatsController.php:119
        #: app/controllers/StatsController.php:296
        #: app/controllers/StatsController.php:547
        #: app/controllers/StatsController.php:704
        #: app/controllers/StatsController.php:860
        #: app/controllers/StatsController.php:1192
        #: app/controllers/user/CampaignsController.php:239
        #: app/controllers/user/DashboardController.php:101
        #: app/controllers/user/StatsController.php:49
        #: app/controllers/user/StatsController.php:221
        #: storage/themes/default/auth/authorize.php:73
        #: storage/themes/default/bio/index.php:201
        #: storage/themes/default/bio/index.php:221
        #: storage/themes/default/bio/index.php:238
        #: storage/themes/default/bio/index.php:266
        #: storage/themes/default/bio/widgets.php:69
        #: storage/themes/default/domains/index.php:106
        #: storage/themes/default/layouts/dashboard.php:138
        #: storage/themes/default/oauth/authorize.php:79
        #: storage/themes/default/overlay/create.php:34
        #: storage/themes/default/overlay/index.php:87
        #: storage/themes/default/partials/shortenermodal.php:172
        #: storage/themes/default/pixels/index.php:105
        #: storage/themes/default/qr/index.php:154
        #: storage/themes/default/qr/index.php:172
        #: storage/themes/default/qr/index.php:199
        #: storage/themes/default/qr/index.php:217
        #: storage/themes/default/splash/index.php:85
        #: storage/themes/default/teams/index.php:95
        #: storage/themes/default/user/campaigns.php:128
        #: storage/themes/default/user/campaigns.php:168
        #: storage/themes/default/user/campaigns.php:188
        #: storage/themes/default/user/campaignstats.php:111
        #: storage/themes/default/user/channel.php:97
        #: storage/themes/default/user/channel.php:137
        #: storage/themes/default/user/channels.php:112
        #: storage/themes/default/user/channels.php:154
        #: storage/themes/default/user/channels.php:174
        #: storage/themes/default/user/developers.php:108
        #: storage/themes/default/user/developers.php:127
        #: storage/themes/default/user/edit.php:656
        #: storage/themes/default/user/import.php:80
        #: storage/themes/default/user/index.php:218
        #: storage/themes/default/user/index.php:235
        #: storage/themes/default/user/index.php:252
        #: storage/themes/default/user/index.php:281
        #: storage/themes/default/user/index.php:309
        #: storage/themes/default/user/index.php:341
        #: storage/themes/default/user/links.php:167
        #: storage/themes/default/user/links.php:184
        #: storage/themes/default/user/links.php:201
        #: storage/themes/default/user/links.php:230
        #: storage/themes/default/user/links.php:258
        #: storage/themes/default/user/links.php:290
        #: storage/themes/default/user/security.php:137
        #: storage/themes/default/user/security.php:163
        #: storage/themes/default/user/settings.php:337
        #: storage/themes/default/user/settings.php:371
        "Cancel"=> "",

        #: app/controllers/StatsController.php:120
        #: app/controllers/StatsController.php:297
        #: app/controllers/StatsController.php:548
        #: app/controllers/StatsController.php:705
        #: app/controllers/StatsController.php:861
        #: app/controllers/StatsController.php:1193
        #: app/controllers/user/CampaignsController.php:240
        #: app/controllers/user/DashboardController.php:102
        #: app/controllers/user/StatsController.php:50
        #: app/controllers/user/StatsController.php:222
        "From"=> "",

        #: app/controllers/StatsController.php:121
        #: app/controllers/StatsController.php:298
        #: app/controllers/StatsController.php:549
        #: app/controllers/StatsController.php:706
        #: app/controllers/StatsController.php:862
        #: app/controllers/StatsController.php:1194
        #: app/controllers/user/CampaignsController.php:241
        #: app/controllers/user/DashboardController.php:103
        #: app/controllers/user/StatsController.php:51
        #: app/controllers/user/StatsController.php:223
        "To"=> "",

        #: app/controllers/StatsController.php:122
        #: app/controllers/StatsController.php:299
        #: app/controllers/StatsController.php:550
        #: app/controllers/StatsController.php:707
        #: app/controllers/StatsController.php:863
        #: app/controllers/StatsController.php:1195
        #: app/controllers/user/CampaignsController.php:242
        #: app/controllers/user/DashboardController.php:104
        #: app/controllers/user/StatsController.php:52
        #: app/controllers/user/StatsController.php:224
        #: storage/themes/default/bio/edit.php:223
        #: storage/themes/default/bio/edit.php:226 storage/themes/default/index.php:26
        #: storage/themes/default/partials/shortener.php:65
        #: storage/themes/default/partials/shortenermodal.php:62
        #: storage/themes/default/user/edit.php:586 storage/themes/the23/index.php:38
        "Custom"=> "",

        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:300
        #: app/controllers/StatsController.php:551
        #: app/controllers/StatsController.php:708
        #: app/controllers/StatsController.php:864
        #: app/controllers/StatsController.php:1196
        #: app/controllers/user/CampaignsController.php:243
        #: app/controllers/user/DashboardController.php:105
        #: app/controllers/user/StatsController.php:53
        #: app/controllers/user/StatsController.php:225
        "Su"=> "",

        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:300
        #: app/controllers/StatsController.php:551
        #: app/controllers/StatsController.php:708
        #: app/controllers/StatsController.php:864
        #: app/controllers/StatsController.php:1196
        #: app/controllers/user/CampaignsController.php:243
        #: app/controllers/user/DashboardController.php:105
        #: app/controllers/user/StatsController.php:53
        #: app/controllers/user/StatsController.php:225
        "Mo"=> "",

        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:300
        #: app/controllers/StatsController.php:551
        #: app/controllers/StatsController.php:708
        #: app/controllers/StatsController.php:864
        #: app/controllers/StatsController.php:1196
        #: app/controllers/user/CampaignsController.php:243
        #: app/controllers/user/DashboardController.php:105
        #: app/controllers/user/StatsController.php:53
        #: app/controllers/user/StatsController.php:225
        "Tu"=> "",

        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:300
        #: app/controllers/StatsController.php:551
        #: app/controllers/StatsController.php:708
        #: app/controllers/StatsController.php:864
        #: app/controllers/StatsController.php:1196
        #: app/controllers/user/CampaignsController.php:243
        #: app/controllers/user/DashboardController.php:105
        #: app/controllers/user/StatsController.php:53
        #: app/controllers/user/StatsController.php:225
        "We"=> "",

        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:300
        #: app/controllers/StatsController.php:551
        #: app/controllers/StatsController.php:708
        #: app/controllers/StatsController.php:864
        #: app/controllers/StatsController.php:1196
        #: app/controllers/user/CampaignsController.php:243
        #: app/controllers/user/DashboardController.php:105
        #: app/controllers/user/StatsController.php:53
        #: app/controllers/user/StatsController.php:225
        "Th"=> "",

        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:300
        #: app/controllers/StatsController.php:551
        #: app/controllers/StatsController.php:708
        #: app/controllers/StatsController.php:864
        #: app/controllers/StatsController.php:1196
        #: app/controllers/user/CampaignsController.php:243
        #: app/controllers/user/DashboardController.php:105
        #: app/controllers/user/StatsController.php:53
        #: app/controllers/user/StatsController.php:225
        "Fr"=> "",

        #: app/controllers/StatsController.php:123
        #: app/controllers/StatsController.php:300
        #: app/controllers/StatsController.php:551
        #: app/controllers/StatsController.php:708
        #: app/controllers/StatsController.php:864
        #: app/controllers/StatsController.php:1196
        #: app/controllers/user/CampaignsController.php:243
        #: app/controllers/user/DashboardController.php:105
        #: app/controllers/user/StatsController.php:53
        #: app/controllers/user/StatsController.php:225
        "Sa"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1526
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:569
        "January"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1527
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:570
        "February"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1528
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:571
        "March"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1529
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:572
        "April"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1530
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:573
        "May"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1531
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:574
        "June"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1532
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:575
        "July"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1533
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:576
        "August"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1534
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:577
        "September"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1535
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:578
        "October"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1536
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:579
        "November"=> "",

        #: app/controllers/StatsController.php:124
        #: app/controllers/StatsController.php:301
        #: app/controllers/StatsController.php:552
        #: app/controllers/StatsController.php:709
        #: app/controllers/StatsController.php:865
        #: app/controllers/StatsController.php:1197
        #: app/controllers/user/BioController.php:1537
        #: app/controllers/user/CampaignsController.php:244
        #: app/controllers/user/DashboardController.php:106
        #: app/controllers/user/StatsController.php:54
        #: app/controllers/user/StatsController.php:226 app/helpers/Gate.php:580
        "December"=> "",

        #: app/controllers/StatsController.php:132
        #: app/controllers/StatsController.php:309
        #: app/controllers/StatsController.php:560
        #: app/controllers/StatsController.php:717
        #: app/controllers/StatsController.php:873
        #: app/controllers/StatsController.php:1205
        #: app/controllers/user/CampaignsController.php:251
        #: app/controllers/user/DashboardController.php:113
        #: app/controllers/user/StatsController.php:61
        #: app/controllers/user/StatsController.php:233
        "Last 7 Days"=> "",

        #: app/controllers/StatsController.php:133
        #: app/controllers/StatsController.php:310
        #: app/controllers/StatsController.php:561
        #: app/controllers/StatsController.php:718
        #: app/controllers/StatsController.php:874
        #: app/controllers/StatsController.php:1206
        #: app/controllers/user/CampaignsController.php:252
        #: app/controllers/user/DashboardController.php:114
        #: app/controllers/user/StatsController.php:62
        #: app/controllers/user/StatsController.php:234
        "Last 30 Days"=> "",

        #: app/controllers/StatsController.php:134
        #: app/controllers/StatsController.php:311
        #: app/controllers/StatsController.php:562
        #: app/controllers/StatsController.php:719
        #: app/controllers/StatsController.php:875
        #: app/controllers/StatsController.php:1207
        #: app/controllers/user/CampaignsController.php:253
        #: app/controllers/user/DashboardController.php:115
        #: app/controllers/user/StatsController.php:63
        #: app/controllers/user/StatsController.php:235
        "This Month"=> "",

        #: app/controllers/StatsController.php:135
        #: app/controllers/StatsController.php:312
        #: app/controllers/StatsController.php:563
        #: app/controllers/StatsController.php:720
        #: app/controllers/StatsController.php:876
        #: app/controllers/StatsController.php:1208
        #: app/controllers/user/CampaignsController.php:254
        #: app/controllers/user/DashboardController.php:116
        #: app/controllers/user/StatsController.php:64
        #: app/controllers/user/StatsController.php:236
        "Last Month"=> "",

        #: app/controllers/StatsController.php:136
        #: app/controllers/StatsController.php:313
        #: app/controllers/StatsController.php:564
        #: app/controllers/StatsController.php:721
        #: app/controllers/StatsController.php:877
        #: app/controllers/StatsController.php:1209
        #: app/controllers/user/CampaignsController.php:255
        #: app/controllers/user/DashboardController.php:117
        #: app/controllers/user/StatsController.php:65
        #: app/controllers/user/StatsController.php:237
        "Last 3 Months"=> "",

        #: app/controllers/StatsController.php:137
        #: app/controllers/StatsController.php:314
        #: app/controllers/StatsController.php:565
        #: app/controllers/StatsController.php:722
        #: app/controllers/StatsController.php:878
        #: app/controllers/StatsController.php:1210
        "Last 12 Months"=> "",

        #: app/controllers/StatsController.php:168
        #: app/controllers/StatsController.php:475
        #: app/controllers/user/CampaignsController.php:295
        #: app/controllers/user/DashboardController.php:420
        #: app/controllers/user/StatsController.php:117 app/helpers/BioWidgets.php:1143
        #: storage/themes/default/index.php:645
        #: storage/themes/default/partials/links.php:105
        #: storage/themes/default/stats/index.php:10
        #: storage/themes/default/stats/partial.php:37
        #: storage/themes/default/user/campaignstats.php:37
        #: storage/themes/default/user/index.php:12
        #: storage/themes/default/user/index.php:16
        #: storage/themes/default/user/stats.php:10 storage/themes/the23/index.php:103
        #: storage/themes/the23/index.php:111 storage/themes/the23/index.php:113
        #: storage/themes/the23/index.php:758
        "Clicks"=> "",

        #: app/controllers/StatsController.php:273
        #: app/controllers/StatsController.php:280
        "Country Stats for"=> "",

        #: app/controllers/StatsController.php:283
        #: app/controllers/StatsController.php:1032
        #: app/controllers/StatsController.php:1120
        "Country statistics page for the short URL"=> "",

        #: app/controllers/StatsController.php:390
        #: app/controllers/StatsController.php:412
        #: app/controllers/StatsController.php:413
        #: app/controllers/StatsController.php:945
        #: app/controllers/user/CampaignsController.php:343
        #: app/controllers/user/StatsController.php:168
        #: app/controllers/user/StatsController.php:192
        #: app/controllers/user/StatsController.php:193
        #: app/controllers/user/StatsController.php:374
        #: storage/themes/default/stats/partial.php:52
        #: storage/themes/default/stats/partial.php:60
        "Unknown"=> "",

        #: app/controllers/StatsController.php:472
        #: storage/themes/default/stats/activity.php:61
        #: storage/themes/default/stats/index.php:36
        #: storage/themes/default/user/activity.php:72
        #: storage/themes/default/user/index.php:165
        #: storage/themes/default/user/security.php:40
        "Somewhere from"=> "",

        #: app/controllers/StatsController.php:526
        #: app/controllers/StatsController.php:533
        "Platform Stats for"=> "",

        #: app/controllers/StatsController.php:535
        "Platform statistics page for the short URL"=> "",

        #: app/controllers/StatsController.php:686
        #: app/controllers/StatsController.php:693
        "Browser Stats for"=> "",

        #: app/controllers/StatsController.php:695
        "Browser statistics page for the short URL"=> "",

        #: app/controllers/StatsController.php:842
        #: app/controllers/StatsController.php:849
        "Language Stats for"=> "",

        #: app/controllers/StatsController.php:851
        "Language statistics page for the short URL"=> "",

        #: app/controllers/StatsController.php:1022
        #: app/controllers/StatsController.php:1029
        "Referrers Stats for"=> "",

        #: app/controllers/StatsController.php:1110
        #: app/controllers/StatsController.php:1117
        "A/B Testing Stats for"=> "",

        #: app/controllers/StatsController.php:1171
        #: app/controllers/StatsController.php:1176
        #: app/controllers/StatsController.php:1181
        "Click Activity for"=> "",

        #: app/controllers/SubscriptionController.php:85
        #: app/controllers/SubscriptionController.php:149
        "Current"=> "",

        #: app/controllers/SubscriptionController.php:88
        #: app/controllers/SubscriptionController.php:92
        "{d}-Day Free Trial"=> "",

        #: app/controllers/SubscriptionController.php:88
        #: app/controllers/SubscriptionController.php:152
        #: storage/themes/default/integrations/index.php:14
        #: storage/themes/default/integrations/index.php:43
        #: storage/themes/default/partials/sidebar_menu.php:235
        #: storage/themes/default/partials/sidebar_menu.php:240
        #: storage/themes/default/partials/sidebar_menu.php:253
        #: storage/themes/default/partials/topbar_menu.php:20
        #: storage/themes/default/qr/bulk.php:183
        #: storage/themes/default/qr/bulk.php:380
        #: storage/themes/default/qr/edit.php:602
        #: storage/themes/default/qr/edit.php:814 storage/themes/default/qr/new.php:587
        #: storage/themes/default/qr/new.php:802
        "Upgrade"=> "",

        #: app/controllers/SubscriptionController.php:92
        #: app/controllers/SubscriptionController.php:156
        #: storage/themes/default/index.php:83 storage/themes/default/index.php:311
        #: storage/themes/default/index.php:391 storage/themes/default/index.php:586
        #: storage/themes/default/integrations/index.php:56
        #: storage/themes/default/pages/bio.php:12
        #: storage/themes/default/pages/bio.php:46
        #: storage/themes/default/pages/bio.php:64
        #: storage/themes/default/pages/qr.php:306
        #: storage/themes/default/pages/qr.php:417
        #: storage/themes/default/pages/qr.php:435
        #: storage/themes/default/partials/footer.php:15
        #: storage/themes/default/partials/main_menu.php:177
        #: storage/themes/default/partials/main_menu.php:193
        #: storage/themes/the23/index.php:72 storage/themes/the23/index.php:81
        #: storage/themes/the23/index.php:158 storage/themes/the23/index.php:301
        #: storage/themes/the23/index.php:362 storage/themes/the23/index.php:521
        #: storage/themes/the23/index.php:574 storage/themes/the23/index.php:625
        #: storage/themes/the23/index.php:777 storage/themes/the23/index.php:797
        #: storage/themes/the23/index.php:821 storage/themes/the23/pages/bio.php:21
        #: storage/themes/the23/pages/bio.php:100
        #: storage/themes/the23/pages/bio.php:158
        #: storage/themes/the23/pages/bio.php:172
        #: storage/themes/the23/pages/bio.php:195 storage/themes/the23/pages/qr.php:307
        #: storage/themes/the23/pages/qr.php:417 storage/themes/the23/pages/qr.php:469
        #: storage/themes/the23/pages/qr.php:482
        #: storage/themes/the23/partials/main_menu.php:221
        "Get Started"=> "",

        #: app/controllers/SubscriptionController.php:103
        #: storage/themes/default/pricing/table.php:15
        #: storage/themes/default/pricing/table_list.php:30
        #: storage/themes/the23/pricing/categorized.php:18
        #: storage/themes/the23/pricing/categorized.php:73
        #: storage/themes/the23/pricing/list.php:22
        #: storage/themes/the23/pricing/table.php:28
        "lifetime"=> "",

        #: app/controllers/SubscriptionController.php:110
        #: storage/themes/default/pricing/table.php:15
        #: storage/themes/default/pricing/table_list.php:30
        #: storage/themes/the23/pricing/categorized.php:18
        #: storage/themes/the23/pricing/categorized.php:73
        #: storage/themes/the23/pricing/list.php:22
        #: storage/themes/the23/pricing/table.php:28
        "year"=> "",

        #: app/controllers/SubscriptionController.php:116
        #: storage/themes/default/pricing/table.php:15
        #: storage/themes/default/pricing/table_list.php:30
        #: storage/themes/default/pricing/table_list.php:44
        #: storage/themes/default/pricing/table_list.php:52
        #: storage/themes/the23/pricing/categorized.php:18
        #: storage/themes/the23/pricing/categorized.php:73
        #: storage/themes/the23/pricing/list.php:22
        #: storage/themes/the23/pricing/table.php:28
        #: storage/themes/the23/pricing/table.php:42
        #: storage/themes/the23/pricing/table.php:50
        #: storage/themes/the23/pricing/table.php:89
        "month"=> "",

        #: app/controllers/SubscriptionController.php:152
        #: app/controllers/SubscriptionController.php:156
        "Try {d} days for free"=> "",

        #: app/controllers/SubscriptionController.php:165
        "QR"=> "",

        #: app/controllers/SubscriptionController.php:165
        #: app/controllers/SubscriptionController.php:167
        "Features"=> "",

        #: app/controllers/SubscriptionController.php:181
        "Premium Plan Pricing"=> "",

        #: app/controllers/SubscriptionController.php:182
        "Transparent pricing without any hidden fees so you always know what you will pa"=> "",

        #: app/controllers/SubscriptionController.php:217
        "Please contact us so we can upgrade your plan since you are on a lifetime plan."=> "",

        #: app/controllers/SubscriptionController.php:238
        #: app/helpers/biowidgets/Newsletter.php:184
        #: app/helpers/payments/Stripe.php:561
        "You have been successfully subscribed."=> "",

        #: app/controllers/SubscriptionController.php:244
        "You have already used a trial."=> "",

        #: app/controllers/SubscriptionController.php:336
        "Please fill your billing information."=> "",

        #: app/controllers/SubscriptionController.php:395
        #: app/controllers/SubscriptionController.php:397
        "Promo code has expired. Please try again."=> "",

        #: app/controllers/SubscriptionController.php:400
        #: app/controllers/SubscriptionController.php:424
        #: app/controllers/SubscriptionController.php:439
        "Please enter a valid promo code."=> "",

        #: app/controllers/SubscriptionController.php:405
        "Promo code is not valid for this plan."=> "",

        #: app/controllers/SubscriptionController.php:477
        #: app/controllers/SubscriptionController.php:479
        #: app/controllers/SubscriptionController.php:481
        #: app/controllers/SubscriptionController.php:483
        "Voucher is invalid or has expired."=> "",

        #: app/controllers/SubscriptionController.php:485
        "You have already redeemed this voucher once."=> "",

        #: app/controllers/SubscriptionController.php:520
        "You have successfully redeemed a voucher."=> "",

        #: app/controllers/UsersController.php:51
        #: storage/themes/default/gates/domain.php:14
        #: storage/themes/the23/gates/domain.php:14
        "Login to your account"=> "",

        #: app/controllers/UsersController.php:76
        "You have been blocked for 1 hour due to many unsuccessful login attempts."=> "",

        #: app/controllers/UsersController.php:79
        "Please enter a valid email or username."=> "",

        #: app/controllers/UsersController.php:81
        #: app/controllers/UsersController.php:91
        #: app/controllers/UsersController.php:234 core/Auth.class.php:123
        #: core/Auth.class.php:207
        "Wrong email and password combination."=> "",

        #: app/controllers/UsersController.php:106
        #: storage/themes/default/maintenance.php:10
        #: storage/themes/the23/maintenance.php:14
        "We are currently offline for maintenance. We will be back online as soon as we are done. It should not take long."=> "",

        #: app/controllers/UsersController.php:110
        #: app/controllers/UsersController.php:1000
        #: app/controllers/UsersController.php:1133
        #: app/controllers/UsersController.php:1283
        "You have been banned due to abuse. Please contact us for clarification."=> "",

        #: app/controllers/UsersController.php:114
        #: app/controllers/UsersController.php:1004
        #: app/controllers/UsersController.php:1137
        #: app/controllers/UsersController.php:1287
        "You haven't activated your account. Please check your email for the activation link. If you haven't received any emails from us, please contact us."=> "",

        #: app/controllers/UsersController.php:114
        "Click here to resend"=> "",

        #: app/controllers/UsersController.php:165
        "A verification code has been sent to your email. Please enter it to complete login."=> "",

        #: app/controllers/UsersController.php:172
        "Please enter the 2FA access code to login."=> "",

        #: app/controllers/UsersController.php:221
        #: app/controllers/UsersController.php:692
        #: app/controllers/UsersController.php:695
        "You have been successfully registered."=> "",

        #: app/controllers/UsersController.php:247
        #: storage/themes/default/auth/2fa.php:14 storage/themes/the23/auth/2fa.php:15
        "Enter your 2FA access code"=> "",

        #: app/controllers/UsersController.php:268
        #: app/controllers/UsersController.php:273
        #: app/controllers/UsersController.php:289
        #: app/controllers/user/AccountController.php:540
        "Invalid token. Please try again."=> "",

        #: app/controllers/UsersController.php:310
        "You have been successfully logged."=> "",

        #: app/controllers/UsersController.php:327
        #: app/controllers/UsersController.php:367
        #: app/controllers/UsersController.php:486
        "Please login first."=> "",

        #: app/controllers/UsersController.php:337
        #: app/controllers/UsersController.php:378
        "Invalid verification session. Please login again."=> "",

        #: app/controllers/UsersController.php:346
        #: app/controllers/UsersController.php:387
        "Verification code has expired. Please login again."=> "",

        #: app/controllers/UsersController.php:349
        #: storage/themes/default/auth/email2fa.php:14
        "Enter your email verification code"=> "",

        #: app/controllers/UsersController.php:393
        #: app/controllers/UsersController.php:492
        "Invalid session. Please login again."=> "",

        #: app/controllers/UsersController.php:399
        "Please enter a valid 6-digit code."=> "",

        #: app/controllers/UsersController.php:414
        "Invalid verification code. Please try again."=> "",

        #: app/controllers/UsersController.php:469
        #: app/controllers/UsersController.php:472
        "You have been successfully logged in."=> "",

        #: app/controllers/UsersController.php:545
        "A new verification code has been sent to your email."=> "",

        #: app/controllers/UsersController.php:557
        #: app/controllers/UsersController.php:586
        "We are not accepting users at this time."=> "",

        #: app/controllers/UsersController.php:559
        "Register and manage your urls"=> "",

        #: app/controllers/UsersController.php:560
        "Register an account and gain control over your urls. Manage them, edit them or remove them without hassle."=> "",

        #: app/controllers/UsersController.php:588
        "Please use a social media platform to login or register."=> "",

        #: app/controllers/UsersController.php:593
        "The email, the username and the password are required."=> "",

        #: app/controllers/UsersController.php:599
        #: app/controllers/user/AccountController.php:391
        "An account is already associated with this email."=> "",

        #: app/controllers/UsersController.php:603
        #: app/controllers/UsersController.php:897
        #: app/controllers/user/AccountController.php:404
        "Please enter a valid username."=> "",

        #: app/controllers/UsersController.php:604
        #: app/controllers/UsersController.php:899
        "Username already exists."=> "",

        #: app/controllers/UsersController.php:608
        #: app/controllers/UsersController.php:903
        "This username cannot be used or already exists. Please choose another username"=> "",

        #: app/controllers/UsersController.php:610
        #: app/controllers/UsersController.php:796
        #: app/controllers/UsersController.php:905
        "Password must be at least 5 characters."=> "",

        #: app/controllers/UsersController.php:612
        "Your password is too long. Passwords must be between 8 to 64 characters."=> "",

        #: app/controllers/UsersController.php:614
        #: app/controllers/UsersController.php:798
        #: app/controllers/UsersController.php:907
        #: app/controllers/user/AccountController.php:418
        "Passwords don't match."=> "",

        #: app/controllers/UsersController.php:616
        #: app/controllers/UsersController.php:909
        "You must agree to our terms of service."=> "",

        #: app/controllers/UsersController.php:684
        #: app/controllers/UsersController.php:1463
        "An email has been sent to activate your account. Please check your spam folder if you didn't receive it."=> "",

        #: app/controllers/UsersController.php:707
        #: app/controllers/UsersController.php:766
        #: storage/themes/default/auth/forgot.php:14
        #: storage/themes/default/auth/forgot.php:32
        #: storage/themes/default/auth/reset.php:14
        #: storage/themes/default/auth/reset.php:39
        #: storage/themes/the23/auth/forgot.php:19
        #: storage/themes/the23/auth/forgot.php:34
        #: storage/themes/the23/auth/reset.php:19
        #: storage/themes/the23/auth/reset.php:39
        "Reset Password"=> "",

        #: app/controllers/UsersController.php:708
        #: storage/themes/default/auth/forgot.php:15
        #: storage/themes/the23/auth/forgot.php:20
        "If you forgot your password, you can request a link to reset your password."=> "",

        #: app/controllers/UsersController.php:737
        "If an active account is associated with this email, you should receive an email shortly."=> "",

        #: app/controllers/UsersController.php:752
        #: app/controllers/UsersController.php:759
        #: app/controllers/UsersController.php:763
        #: app/controllers/UsersController.php:782
        #: app/controllers/UsersController.php:789
        #: app/controllers/UsersController.php:793
        #: app/controllers/UsersController.php:835
        #: app/controllers/UsersController.php:1521
        #: app/controllers/UsersController.php:1524
        #: app/controllers/UsersController.php:1527
        "Token has expired, please request another link."=> "",

        #: app/controllers/UsersController.php:801
        "Your new password cannot be the same as the old password."=> "",

        #: app/controllers/UsersController.php:821
        "Your password has been changed."=> "",

        #: app/controllers/UsersController.php:845
        #: app/controllers/UsersController.php:1459
        "Your email has been successfully verified."=> "",

        #: app/controllers/UsersController.php:859
        #: app/controllers/UsersController.php:894
        "The invitation link has expired or is currently unavailable. Please contact administrator."=> "",

        #: app/controllers/UsersController.php:873
        "Please login to your account to accept this invitation."=> "",

        #: app/controllers/UsersController.php:876
        #: storage/themes/default/auth/invite.php:14
        #: storage/themes/the23/auth/invite.php:19
        "Join Team"=> "",

        #: app/controllers/UsersController.php:923
        "Your account has been successfully activated."=> "",

        #: app/controllers/UsersController.php:938
        "You have been successfully logged out."=> "",

        #: app/controllers/UsersController.php:951
        #: app/controllers/UsersController.php:969
        #: app/controllers/user/AccountController.php:792
        #: app/controllers/user/AccountController.php:809
        "Sorry, Facebook connect is not available right now."=> "",

        #: app/controllers/UsersController.php:953
        #: app/controllers/user/AccountController.php:794
        "You must grant access to this application to use your facebook account."=> "",

        #: app/controllers/UsersController.php:975
        "You must grant permission to this application to use your profile information."=> "",

        #: app/controllers/UsersController.php:979
        #: app/controllers/UsersController.php:1118
        #: app/controllers/UsersController.php:1268
        "The email linked to your account has been already used. If you have used that, please login to your existing account otherwise please contact us."=> "",

        #: app/controllers/UsersController.php:1082
        #: app/controllers/UsersController.php:1085
        #: app/controllers/UsersController.php:1201
        #: app/controllers/UsersController.php:1204
        #: app/controllers/UsersController.php:1362
        #: app/controllers/UsersController.php:1365
        #: app/controllers/UsersController.php:1415
        #: app/controllers/UsersController.php:1440
        "Welcome! You have been successfully logged in."=> "",

        #: app/controllers/UsersController.php:1097
        #: app/controllers/UsersController.php:1217
        #: app/controllers/user/AccountController.php:735
        #: app/controllers/user/AccountController.php:772
        "Sorry, Twitter connect is not available right now."=> "",

        #: app/controllers/UsersController.php:1100
        #: app/controllers/user/AccountController.php:738
        "You must grant permission to this application to use your twitter account."=> "",

        #: app/controllers/UsersController.php:1115
        "And error occurred, please try again later."=> "",

        #: app/controllers/UsersController.php:1231
        #: app/controllers/user/AccountController.php:786
        "An error has occurred! Please make sure that you have set up this application as instructed."=> "",

        #: app/controllers/UsersController.php:1244
        #: app/controllers/UsersController.php:1259
        #: app/controllers/user/AccountController.php:823
        #: app/controllers/user/AccountController.php:838
        "Sorry, Google connect is not available right now."=> "",

        #: app/controllers/UsersController.php:1265
        "You must grant permission to this application to use your Google account."=> "",

        #: app/controllers/UsersController.php:1379
        "Token has expired, please login manually."=> "",

        #: app/controllers/UsersController.php:1386
        #: app/controllers/UsersController.php:1390
        "Token has expired, please login manually"=> "",

        #: app/controllers/UsersController.php:1481
        "You have been successfully unsubscribed from newsletters."=> "",

        #: app/controllers/UsersController.php:1496
        #: app/controllers/UsersController.php:1502
        "Please enter a valid secret key."=> "",

        #: app/controllers/UsersController.php:1500
        "2FA is not active on this account."=> "",

        #: app/controllers/UsersController.php:1509
        "An email has been sent to reset 2FA on your account. Please check your spam folder if you didn't receive it."=> "",

        #: app/controllers/UsersController.php:1533
        "2FA has been disabled. You may now login without 2FA."=> "",

        #: app/controllers/user/AccountController.php:75
        #: storage/themes/default/partials/main_menu.php:153
        #: storage/themes/default/partials/topbar_menu.php:111
        #: storage/themes/default/user/billing.php:1
        #: storage/themes/the23/partials/main_menu.php:189
        "Billing"=> "",

        #: app/controllers/user/AccountController.php:92
        "Wow there. You are an admin. You can't cancel your membership."=> "",

        #: app/controllers/user/AccountController.php:96 app/helpers/Slack.php:109
        "Something went wrong, please try again."=> "",

        #: app/controllers/user/AccountController.php:100
        #: app/controllers/user/AccountController.php:106
        #: app/controllers/user/AccountController.php:253
        #: app/controllers/user/AccountController.php:259
        #: app/controllers/user/AccountController.php:653
        #: app/controllers/user/AccountController.php:659
        "Your password is incorrect."=> "",

        #: app/controllers/user/AccountController.php:114
        "Your trial has been canceled."=> "",

        #: app/controllers/user/AccountController.php:166
        "Subscription Canceled"=> "",

        #: app/controllers/user/AccountController.php:177
        "Your subscription has been canceled."=> "",

        #: app/controllers/user/AccountController.php:193
        "Payment not found. Please try again."=> "",

        #: app/controllers/user/AccountController.php:228
        #: storage/themes/default/user/billing.php:47
        "View Invoice"=> "",

        #: app/controllers/user/AccountController.php:249
        "As an admin, you cannot delete your account from this page."=> "",

        #: app/controllers/user/AccountController.php:284
        "Your account has been deleted successfully and your data has been wiped out. If you have any questions please don't hesitate to contact us."=> "",

        #: app/controllers/user/AccountController.php:288
        "Your account has been terminated."=> "",

        #: app/controllers/user/AccountController.php:325
        "Your account has been successfully terminated."=> "",

        #: app/controllers/user/AccountController.php:366 app/models/Role.php:107
        #: storage/themes/default/bio/edit.php:21
        #: storage/themes/default/bio/edit.php:149
        #: storage/themes/default/bio/edit.php:386
        #: storage/themes/default/partials/main_menu.php:161
        #: storage/themes/default/partials/topbar_menu.php:125
        #: storage/themes/default/user/settings.php:1
        #: storage/themes/the23/partials/main_menu.php:197
        "Settings"=> "",

        #: app/controllers/user/AccountController.php:406
        "This username has already been used. Please try again."=> "",

        #: app/controllers/user/AccountController.php:416
        "Password must contain at least 5 characters."=> "",

        #: app/controllers/user/AccountController.php:422
        "Passwords is the same as the old password."=> "",

        #: app/controllers/user/AccountController.php:436
        #: app/controllers/user/AccountController.php:438
        #: storage/themes/default/splash/create.php:49
        #: storage/themes/default/splash/edit.php:54
        #: storage/themes/default/user/settings.php:31
        "Avatar must be the one of the following formats and size: {f} - {s}kb."=> "",

        #: app/controllers/user/AccountController.php:494
        #: app/controllers/user/AccountController.php:511
        #: app/controllers/user/AffiliateController.php:76
        "Account has been successfully updated."=> "",

        #: app/controllers/user/AccountController.php:494
        "You have changed your email. Please check your email before logging out and activate your account."=> "",

        #: app/controllers/user/AccountController.php:546
        "2FA has been activated on your account. Please make sure to backup the secret key or the QR code."=> "",

        #: app/controllers/user/AccountController.php:557
        "2FA has been disabled on your account."=> "",

        #: app/controllers/user/AccountController.php:579
        "API key has been regenerated successfully. Please do not forget to update your application."=> "",

        #: app/controllers/user/AccountController.php:612
        #: storage/themes/default/user/confirmation.php:3
        "Order Confirmation"=> "",

        #: app/controllers/user/AccountController.php:676
        "You have been logged out of all devices."=> "",

        #: app/controllers/user/AccountController.php:713
        #: storage/themes/default/partials/main_menu.php:159
        #: storage/themes/default/partials/topbar_menu.php:120
        #: storage/themes/default/user/security.php:1
        #: storage/themes/the23/partials/main_menu.php:195
        "Security"=> "",

        #: app/controllers/user/AccountController.php:731
        "You are already connected to a social account."=> "",

        #: app/controllers/user/AccountController.php:753
        "An error occurred, please try again later."=> "",

        #: app/controllers/user/AccountController.php:845
        "This social account is already connected to another account."=> "",

        #: app/controllers/user/AffiliateController.php:43
        "Affiliate Referrals"=> "",

        #: app/controllers/user/AffiliateController.php:94
        #: storage/themes/default/user/affiliate.php:46
        #: storage/themes/default/user/withdrawals.php:1
        "Withdrawals"=> "",

        #: app/controllers/user/AffiliateController.php:114
        "You do not have enough balance to request a withdrawal."=> "",

        #: app/controllers/user/AffiliateController.php:117
        "Please set a valid PayPal email in your account settings."=> "",

        #: app/controllers/user/AffiliateController.php:121
        "You already have a pending withdrawal request."=> "",

        #: app/controllers/user/AffiliateController.php:125
        "An affiliate withdrawal request was made"=> "",

        #: app/controllers/user/AffiliateController.php:126
        "A customer ({e}) requested a withdrawal of {a} to paypal email {pp}"=> "",

        #: app/controllers/user/AffiliateController.php:140
        "Your withdrawal request has been submitted."=> "",

        #: app/controllers/user/BioController.php:129
        #: storage/themes/default/user/import.php:52
        "Import"=> "",

        #: app/controllers/user/BioController.php:129
        "We have detected that you have an old bio page. Do you want to import it?<br><br><a href=\\\"?importoldbio=true\\\" class=\\\"btn btn-primary\\\">"=> "",

        #: app/controllers/user/BioController.php:177
        #: app/controllers/user/BioController.php:338
        "You have reach the maximum limit for this feature."=> "",

        #: app/controllers/user/BioController.php:182
        #: app/controllers/user/BioController.php:345
        #: app/controllers/user/BioController.php:711
        "Please enter a name for your profile."=> "",

        #: app/controllers/user/BioController.php:184
        "Bio page name must be less than 50 characters."=> "",

        #: app/controllers/user/BioController.php:191
        #: app/controllers/user/BioController.php:352
        #: app/controllers/user/BioController.php:722
        #: app/controllers/user/BioController.php:1029 app/traits/Links.php:156
        #: app/traits/Links.php:636
        "Inappropriate aliases are not allowed."=> "",

        #: app/controllers/user/BioController.php:203
        #: app/controllers/user/BioController.php:364
        #: app/controllers/user/BioController.php:734
        #: app/controllers/user/BioController.php:1041 app/traits/Links.php:168
        #: app/traits/Links.php:648
        "That alias is reserved. Please choose another one."=> "",

        #: app/controllers/user/BioController.php:206
        #: app/controllers/user/BioController.php:367
        #: app/controllers/user/BioController.php:737
        #: app/controllers/user/BioController.php:1044 app/traits/Links.php:171
        #: app/traits/Links.php:651
        "That is a premium alias and is reserved to only pro members."=> "",

        #: app/controllers/user/BioController.php:315
        #: app/controllers/user/BioController.php:449
        "Profile has been successfully created."=> "",

        #: app/controllers/user/BioController.php:472
        #: app/controllers/user/BioController.php:499
        #: app/controllers/user/BioController.php:706
        #: app/controllers/user/BioController.php:962
        #: app/controllers/user/BioController.php:1011
        #: app/controllers/user/BioController.php:1301
        #: app/controllers/user/BioController.php:1344
        #: app/controllers/user/BioController.php:1681
        #: app/controllers/user/BioController.php:1785
        #: app/controllers/user/BioController.php:1933
        "Profile does not exist."=> "",

        #: app/controllers/user/BioController.php:482
        "Profile has been successfully deleted."=> "",

        #: app/controllers/user/BioController.php:542
        #: storage/themes/default/partials/shortener.php:114
        "Customize"=> "",

        #: app/controllers/user/BioController.php:759
        #: app/controllers/user/BioController.php:761 app/traits/Links.php:416
        #: app/traits/Links.php:418 app/traits/Links.php:834 app/traits/Links.php:836
        "Banner must be either a PNG or a JPEG (Max 500kb)."=> "",

        #: app/controllers/user/BioController.php:801
        "Avatar must be either a PNG or a JPEG (Max 500kb)."=> "",

        #: app/controllers/user/BioController.php:823
        "Background must be either a PNG or a JPEG (Max {s}kb."=> "",

        #: app/controllers/user/BioController.php:843
        "Background must be either a PNG or a JPEG (Max {s}kb)."=> "",

        #: app/controllers/user/BioController.php:942
        #: app/controllers/user/BioController.php:992
        #: app/controllers/user/BioController.php:1280
        "Profile has been successfully updated."=> "",

        #: app/controllers/user/BioController.php:1071
        #: app/controllers/user/BioController.php:1073
        "Banner must be the following formats {f} and be less than {s}kb."=> "",

        #: app/controllers/user/BioController.php:1086
        #: app/controllers/user/BioController.php:1088
        "Favicon must be either a PNG or a JPEG (Max 500kb)."=> "",

        #: app/controllers/user/BioController.php:1118
        "Avatar must be the following formats {f} and be less than {s}kb."=> "",

        #: app/controllers/user/BioController.php:1134
        "This theme is not available."=> "",

        #: app/controllers/user/BioController.php:1139
        "This theme is only available for premium users."=> "",

        #: app/controllers/user/BioController.php:1146
        "This theme is not available for your plan."=> "",

        #: app/controllers/user/BioController.php:1157
        #: app/controllers/user/BioController.php:1177
        "Background must be the following formats {f} and be less than {s}kb."=> "",

        #: app/controllers/user/BioController.php:1309
        "Invalid order data."=> "",

        #: app/controllers/user/BioController.php:1324
        "Links have been successfully reordered."=> "",

        #: app/controllers/user/BioController.php:1366
        "Block has been successfully deleted."=> "",

        #: app/controllers/user/BioController.php:1463 app/helpers/Gate.php:506
        "More share options"=> "",

        #: app/controllers/user/BioController.php:1490 app/helpers/BioWidgets.php:1190
        #: app/helpers/Gate.php:533 storage/themes/default/bio/edit.php:428
        "Sensitive Content"=> "",

        #: app/controllers/user/BioController.php:1493 app/helpers/Gate.php:536
        "This page contains sensitive content which may not be suitable for all ages. By continuing, you agree to our terms of service."=> "",

        #: app/controllers/user/BioController.php:1496 app/helpers/Gate.php:539
        "Go Back"=> "",

        #: app/controllers/user/BioController.php:1497 app/helpers/Gate.php:218
        #: app/helpers/Gate.php:540 app/helpers/biowidgets/Link.php:444
        #: storage/themes/default/layouts/dashboard.php:127
        "Continue"=> "",

        #: app/controllers/user/BioController.php:1511 app/helpers/Gate.php:554
        "Age Verification"=> "",

        #: app/controllers/user/BioController.php:1514 app/helpers/Gate.php:557
        "This page is restricted to users who are {age} years or older."=> "",

        #: app/controllers/user/BioController.php:1516 app/helpers/Gate.php:559
        "Enter your date of birth"=> "",

        #: app/controllers/user/BioController.php:1520 app/helpers/Gate.php:563
        "Day"=> "",

        #: app/controllers/user/BioController.php:1525 app/helpers/Gate.php:568
        "Month"=> "",

        #: app/controllers/user/BioController.php:1542 app/helpers/Gate.php:585
        "Year"=> "",

        #: app/controllers/user/BioController.php:1550 app/helpers/Gate.php:593
        #: storage/themes/default/auth/email2fa.php:35
        #: storage/themes/default/verifylink.php:13
        "Verify"=> "",

        #: app/controllers/user/BioController.php:1576 app/helpers/Gate.php:619
        "Please enter your complete date of birth"=> "",

        #: app/controllers/user/BioController.php:1590 app/helpers/Gate.php:633
        "You must be {age} years or older to access this page."=> "",

        #: app/controllers/user/BioController.php:1688
        "Profile has been set as default and can now be access via your profile page."=> "",

        #: app/controllers/user/BioController.php:1690
        "Profile has been set as default and can now be access via your profile page. Your profile setting is currently set on private."=> "",

        #: app/controllers/user/BioController.php:1789
        "An error occurred. This profile cannot be duplicated."=> "",

        #: app/controllers/user/BioController.php:1853
        #: app/controllers/user/QRController.php:1171 app/traits/Overlays.php:393
        #: storage/themes/default/bio/index.php:78
        #: storage/themes/default/gates/media.php:29
        #: storage/themes/default/gates/profile.php:160
        #: storage/themes/default/index.php:17
        #: storage/themes/default/overlay/create_coupon.php:40
        #: storage/themes/default/overlay/edit_coupon.php:40
        #: storage/themes/default/partials/links.php:47
        #: storage/themes/default/partials/shortenermodal.php:131
        #: storage/themes/default/user/affiliate.php:39
        #: storage/themes/default/user/campaigns.php:57
        #: storage/themes/default/user/campaigns.php:65
        #: storage/themes/default/user/channel.php:63
        #: storage/themes/default/user/developers.php:26
        #: storage/themes/default/user/developers.php:64
        #: storage/themes/default/user/edit.php:541
        #: storage/themes/default/user/edit.php:544
        #: storage/themes/default/user/security.php:96
        #: storage/themes/default/user/security.php:127
        #: storage/themes/default/user/settings.php:244
        #: storage/themes/default/user/settings.php:361
        #: storage/themes/the23/gates/media.php:30 storage/themes/the23/index.php:29
        "Copy"=> "",

        #: app/controllers/user/BioController.php:1874
        #: app/controllers/user/QRController.php:1182
        "Item has been successfully duplicated."=> "",

        #: app/controllers/user/BioController.php:1938
        "Save changes before being able to toggle the block."=> "",

        #: app/controllers/user/BioController.php:1951
        "Block has been successfully updated."=> "",

        #: app/controllers/user/CampaignsController.php:60 app/helpers/App.php:442
        #: app/traits/Teams.php:100
        #: storage/themes/default/partials/sidebar_menu.php:149
        #: storage/themes/default/user/campaigns.php:3
        #: storage/themes/default/user/index.php:269
        #: storage/themes/default/user/links.php:218
        "Campaigns"=> "",

        #: app/controllers/user/CampaignsController.php:83
        #: app/controllers/user/CampaignsController.php:166
        "Campaign name cannot be empty and must have at least 2 characters."=> "",

        #: app/controllers/user/CampaignsController.php:87
        #: app/controllers/user/CampaignsController.php:170
        "You already have a campaign with that name."=> "",

        #: app/controllers/user/CampaignsController.php:95
        #: app/controllers/user/CampaignsController.php:181
        "This slug is currently not available. Please choose another one."=> "",

        #: app/controllers/user/CampaignsController.php:143
        "Campaign was successfully created. You may start adding links to it now."=> "",

        #: app/controllers/user/CampaignsController.php:162
        "Campaign does not exist"=> "",

        #: app/controllers/user/CampaignsController.php:189
        "Campaign was updated successfully."=> "",

        #: app/controllers/user/CampaignsController.php:213
        #: app/controllers/user/CampaignsController.php:230
        "Campaign not found. Please try again."=> "",

        #: app/controllers/user/CampaignsController.php:218
        "Campaign has been deleted."=> "",

        #: app/controllers/user/CampaignsController.php:273
        #: storage/themes/default/user/campaignstats.php:3
        "Campaign Statistics"=> "",

        #: app/controllers/user/ChannelsController.php:53 app/helpers/App.php:435
        #: app/traits/Teams.php:100 app/traits/Teams.php:102 app/traits/Teams.php:103
        #: app/traits/Teams.php:104 storage/themes/default/bio/index.php:255
        #: storage/themes/default/partials/sidebar_menu.php:96
        #: storage/themes/default/qr/index.php:188
        #: storage/themes/default/user/channels.php:3
        #: storage/themes/default/user/channels.php:14
        #: storage/themes/default/user/confirmation.php:85
        #: storage/themes/default/user/edit.php:616
        #: storage/themes/default/user/index.php:298
        #: storage/themes/default/user/links.php:247
        "Channels"=> "",

        #: app/controllers/user/ChannelsController.php:181
        #: storage/themes/default/partials/shortener.php:77
        #: storage/themes/default/partials/shortenermodal.php:74
        #: storage/themes/default/user/links.php:80
        "Channel"=> "",

        #: app/controllers/user/ChannelsController.php:208
        #: app/controllers/user/ChannelsController.php:245
        "Channel name cannot be empty and must have at least 2 characters."=> "",

        #: app/controllers/user/ChannelsController.php:221
        "Channel was successfully created. You may start adding links to it now."=> "",

        #: app/controllers/user/ChannelsController.php:240
        #: app/controllers/user/ChannelsController.php:280
        #: app/controllers/user/ChannelsController.php:363
        "Channel does not exist"=> "",

        #: app/controllers/user/ChannelsController.php:254
        "Channel was updated successfully."=> "",

        #: app/controllers/user/ChannelsController.php:287
        "Channel has been successfully deleted."=> "",

        #: app/controllers/user/ChannelsController.php:301
        "You need to select at least 1 channel."=> "",

        #: app/controllers/user/ChannelsController.php:340
        "Selected items have been added to the {c} channel."=> "",

        #: app/controllers/user/ChannelsController.php:368
        "Item has been removed from the channel."=> "",

        #: app/controllers/user/DashboardController.php:41
        #: app/helpers/payments/Paddle.php:540
        #: app/helpers/payments/PaddleBilling.php:233
        #: app/helpers/payments/PaypalApi.php:339
        #: app/helpers/payments/PaypalApi.php:402
        "Your payment was successfully made. Thank you."=> "",

        #: app/controllers/user/DashboardController.php:88
        #: storage/themes/default/partials/main_menu.php:140
        #: storage/themes/default/partials/main_menu.php:185
        #: storage/themes/default/partials/sidebar_menu.php:49
        #: storage/themes/the23/partials/main_menu.php:177
        #: storage/themes/the23/partials/main_menu.php:187
        "Dashboard"=> "",

        #: app/controllers/user/DashboardController.php:137
        #: app/controllers/user/StatsController.php:86 app/models/Role.php:69
        #: app/traits/Teams.php:38 storage/themes/default/index.php:635
        #: storage/themes/default/partials/sidebar_menu.php:109
        #: storage/themes/default/user/campaigns.php:36
        #: storage/themes/default/user/channel.php:56
        #: storage/themes/default/user/links.php:137 storage/themes/the23/index.php:16
        #: storage/themes/the23/index.php:748
        "Links"=> "",

        #: app/controllers/user/DashboardController.php:153
        #: app/controllers/user/DashboardController.php:247
        #: app/controllers/user/DashboardController.php:342
        "Campaign Links"=> "",

        #: app/controllers/user/DashboardController.php:291
        #: storage/themes/default/partials/sidebar_menu.php:114
        "Archived Links"=> "",

        #: app/controllers/user/DashboardController.php:386
        #: storage/themes/default/partials/sidebar_menu.php:119
        "Expired Links"=> "",

        #: app/controllers/user/DashboardController.php:555
        "No results found"=> "",

        #: app/controllers/user/DashboardController.php:557
        "{c} Results"=> "",

        #: app/controllers/user/DashboardController.php:568
        #: storage/themes/default/layouts/api.php:66
        #: storage/themes/default/layouts/auth.php:33
        #: storage/themes/default/layouts/dashboard.php:133
        #: storage/themes/default/layouts/main.php:74
        #: storage/themes/default/layouts/stats.php:73
        #: storage/themes/the23/partials/languagejs.php:6
        "Keyword must be more than 3 characters!"=> "",

        #: app/controllers/user/DevelopersController.php:56
        #: app/controllers/user/DevelopersController.php:108
        #: storage/themes/default/blog/menu.php:7
        #: storage/themes/default/pixels/index.php:23
        #: storage/themes/default/stats/activity.php:18
        #: storage/themes/default/stats/activity.php:27
        #: storage/themes/default/stats/activity.php:36
        #: storage/themes/default/user/activity.php:10
        #: storage/themes/default/user/activity.php:19
        #: storage/themes/default/user/activity.php:28
        #: storage/themes/default/user/links.php:71
        #: storage/themes/default/user/links.php:82
        #: storage/themes/the23/blog/menu.php:6
        "All"=> "",

        #: app/controllers/user/DevelopersController.php:75
        #: storage/themes/default/partials/topbar_menu.php:123
        #: storage/themes/default/user/developers.php:2
        #: storage/themes/default/user/settings.php:306
        "API Keys"=> "",

        #: app/controllers/user/DevelopersController.php:95
        "You have reach the maximum limit for number of API keys allowed."=> "",

        #: app/controllers/user/DevelopersController.php:131
        "API key has been created successfully."=> "",

        #: app/controllers/user/DevelopersController.php:153
        "API key has been revoked successfully."=> "",

        #: app/controllers/user/DevelopersController.php:155
        "API key is invalid."=> "",

        #: app/controllers/user/DomainsController.php:75 app/helpers/App.php:423
        #: storage/themes/default/domains/index.php:3
        #: storage/themes/default/partials/sidebar_menu.php:177
        #: storage/themes/default/user/confirmation.php:84
        #: storage/themes/the23/index.php:169
        "Branded Domains"=> "",

        #: app/controllers/user/DomainsController.php:98
        #: storage/themes/default/domains/new.php:1
        "New Domain"=> "",

        #: app/controllers/user/DomainsController.php:140
        #: app/controllers/user/DomainsController.php:149
        "A valid domain name is required."=> "",

        #: app/controllers/user/DomainsController.php:144
        "The domain has been already used."=> "",

        #: app/controllers/user/DomainsController.php:155
        "A valid url is required for the root domain."=> "",

        #: app/controllers/user/DomainsController.php:157
        "A valid url is required for the 404 page."=> "",

        #: app/controllers/user/DomainsController.php:177
        "A new domain was added."=> "",

        #: app/controllers/user/DomainsController.php:178
        "A customer ({e}) added a new domain to the platform. Please make sure the domain is pointed correctly and is resolving as expected. Their domain name is {d}."=> "",

        #: app/controllers/user/DomainsController.php:181
        "Domain has been added successfully"=> "",

        #: app/controllers/user/DomainsController.php:200
        #: app/controllers/user/DomainsController.php:241
        #: app/controllers/user/DomainsController.php:280
        "Domain not found. Please try again."=> "",

        #: app/controllers/user/DomainsController.php:203
        #: storage/themes/default/domains/edit.php:1
        #: storage/themes/default/domains/index.php:56
        "Edit Domain"=> "",

        #: app/controllers/user/DomainsController.php:255
        "Domain has been updated successfully."=> "",

        #: app/controllers/user/DomainsController.php:285
        "Domain has been deleted."=> "",

        #: app/controllers/user/ExportController.php:121
        #: app/controllers/user/ExportController.php:164
        "Please specify a range."=> "",

        #: app/controllers/user/ImportController.php:53
        "Import Links via CSV"=> "",

        #: app/controllers/user/ImportController.php:79
        #: app/controllers/user/ImportController.php:83
        "Incorrect format or empty file. Please upload .csv file."=> "",

        #: app/controllers/user/ImportController.php:87
        "File is larger than {s}mb."=> "",

        #: app/controllers/user/ImportController.php:95
        "No links found."=> "",

        #: app/controllers/user/ImportController.php:113
        "The CSV file contains {num} links and it will be processed in the background. You can review the progress on this page."=> "",

        #: app/controllers/user/ImportController.php:140
        "{num} links were successfully imported but some errors occurred:"=> "",

        #: app/controllers/user/ImportController.php:143
        "{num} links were successfully imported."=> "",

        #: app/controllers/user/ImportController.php:165
        "Import has been canceled."=> "",

        #: app/controllers/user/IntegrationsController.php:43
        #: storage/themes/default/index.php:511
        #: storage/themes/default/integrations/index.php:3
        #: storage/themes/default/partials/sidebar_menu.php:214
        #: storage/themes/the23/index.php:623
        "Integrations"=> "",

        #: app/controllers/user/IntegrationsController.php:61
        "Zapier"=> "",

        #: app/controllers/user/IntegrationsController.php:66
        "Connect with Zapier and receive requests when a new short url is generated or a new click is made."=> "",

        #: app/controllers/user/IntegrationsController.php:71
        "WordPress"=> "",

        #: app/controllers/user/IntegrationsController.php:75
        "Install our WP plugin and start shortening links directly from WordPress using a shortcode."=> "",

        #: app/controllers/user/IntegrationsController.php:78
        #: app/helpers/biowidgets/PDF.php:199
        #: storage/themes/default/integrations/shortcuts.php:50
        #: storage/themes/default/qr/edit.php:861
        #: storage/themes/default/qr/edit.php:870
        #: storage/themes/default/qr/index.php:245
        "Download"=> "",

        #: app/controllers/user/IntegrationsController.php:81 app/helpers/App.php:527
        "Mailchimp"=> "",

        #: app/controllers/user/IntegrationsController.php:86
        "Connect with Mailchimp to automatically add newsletter subscribers to your Mailchimp lists."=> "",

        #: app/controllers/user/IntegrationsController.php:91
        "Shortcuts"=> "",

        #: app/controllers/user/IntegrationsController.php:95
        "Use our powerful Shortcut in your iOS device and shorten links easily and quickly."=> "",

        #: app/controllers/user/IntegrationsController.php:103
        "Slack"=> "",

        #: app/controllers/user/IntegrationsController.php:108
        "Connect our app with Slack and start shortening links directly from your Slack workspace."=> "",

        #: app/controllers/user/IntegrationsController.php:137
        #: storage/themes/default/integrations/slack.php:4
        "Slack Integration"=> "",

        #: app/controllers/user/IntegrationsController.php:152
        #: storage/themes/default/integrations/zapier.php:4
        "Zapier Integration"=> "",

        #: app/controllers/user/IntegrationsController.php:172
        #: storage/themes/default/integrations/wordpress.php:3
        "WordPress Integration"=> "",

        #: app/controllers/user/IntegrationsController.php:190
        #: storage/themes/default/integrations/shortcuts.php:3
        "Shortcuts Integration"=> "",

        #: app/controllers/user/IntegrationsController.php:207
        #: app/helpers/biowidgets/Newsletter.php:78
        #: storage/themes/default/integrations/mailchimp.php:5
        "Mailchimp Integration"=> "",

        #: app/controllers/user/IntegrationsController.php:215
        "Please enter your Mailchimp API key."=> "",

        #: app/controllers/user/IntegrationsController.php:222
        "Invalid Mailchimp API key. Please check and try again."=> "",

        #: app/controllers/user/IntegrationsController.php:228
        "Mailchimp API key has been saved successfully."=> "",

        #: app/controllers/user/IntegrationsController.php:230
        "An error occurred: {error}"=> "",

        #: app/controllers/user/IntegrationsController.php:269
        "Plugin cannot be generated. Please contact us for more information."=> "",

        #: app/controllers/user/NotificationsController.php:37
        #: storage/themes/default/user/notifications.php:2
        #: storage/themes/the23/index.php:685
        "Notifications"=> "",

        #: app/controllers/user/OverlayController.php:76 app/helpers/App.php:1081
        #: app/traits/Teams.php:74 storage/themes/default/overlay/index.php:2
        #: storage/themes/default/overlay/index.php:12
        #: storage/themes/default/overlay/index.php:17
        #: storage/themes/default/partials/sidebar_menu.php:163
        #: storage/themes/default/user/confirmation.php:81
        "CTA Overlay"=> "",

        #: app/controllers/user/OverlayController.php:105
        #: storage/themes/default/overlay/create.php:2
        #: storage/themes/default/overlay/index.php:70
        "Create a CTA Overlay"=> "",

        #: app/controllers/user/OverlayController.php:153
        #: app/controllers/user/OverlayController.php:181
        "Overlay page does not exist."=> "",

        #: app/controllers/user/OverlayController.php:310
        #: app/controllers/user/OverlayController.php:479
        #: app/helpers/biowidgets/Product.php:52
        #: storage/themes/default/bio/index.php:129
        #: storage/themes/default/overlay/create_contact.php:17
        #: storage/themes/default/overlay/create_contact.php:78
        #: storage/themes/default/overlay/create_contact.php:168
        #: storage/themes/default/overlay/create_coupon.php:17
        #: storage/themes/default/overlay/create_image.php:17
        #: storage/themes/default/overlay/create_message.php:17
        #: storage/themes/default/overlay/create_newsletter.php:17
        #: storage/themes/default/overlay/create_poll.php:17
        #: storage/themes/default/overlay/edit_contact.php:17
        #: storage/themes/default/overlay/edit_coupon.php:17
        #: storage/themes/default/overlay/edit_image.php:17
        #: storage/themes/default/overlay/edit_message.php:17
        #: storage/themes/default/overlay/edit_newsletter.php:17
        #: storage/themes/default/overlay/edit_poll.php:17
        #: storage/themes/default/pages/contact.php:21
        #: storage/themes/default/pages/contact.php:22
        #: storage/themes/default/pixels/index.php:45
        #: storage/themes/default/splash/create.php:11
        #: storage/themes/default/splash/edit.php:16
        #: storage/themes/default/user/channel.php:115
        #: storage/themes/default/user/channels.php:90
        #: storage/themes/default/user/channels.php:132
        #: storage/themes/default/user/settings.php:42
        #: storage/themes/the23/pages/contact.php:45
        #: storage/themes/the23/pages/contact.php:46
        "Name"=> "",

        #: app/controllers/user/OverlayController.php:311
        #: app/controllers/user/OverlayController.php:480 app/helpers/QR.php:68
        #: app/helpers/biowidgets/Contact.php:52 app/helpers/biowidgets/Contact.php:202
        #: app/helpers/biowidgets/PayPal.php:58 app/helpers/biowidgets/VCard.php:75
        #: storage/themes/default/auth/2fa.php:54
        #: storage/themes/default/auth/forgot.php:22
        #: storage/themes/default/auth/invite.php:22
        #: storage/themes/default/overlay/create_contact.php:85
        #: storage/themes/default/overlay/create_contact.php:172
        #: storage/themes/default/pages/contact.php:25
        #: storage/themes/default/pages/contact.php:26
        #: storage/themes/default/pages/qr.php:26
        #: storage/themes/default/pages/qr.php:53
        #: storage/themes/default/pages/qr.php:113
        #: storage/themes/default/pages/report.php:21
        #: storage/themes/default/pages/report.php:22
        #: storage/themes/default/qr/edit.php:57 storage/themes/default/qr/edit.php:61
        #: storage/themes/default/qr/edit.php:174
        #: storage/themes/default/qr/edit.php:261 storage/themes/default/qr/new.php:34
        #: storage/themes/default/qr/new.php:69 storage/themes/default/qr/new.php:73
        #: storage/themes/default/qr/new.php:189 storage/themes/default/qr/new.php:274
        #: storage/themes/default/teams/edit.php:7
        #: storage/themes/default/teams/index.php:14
        #: storage/themes/default/user/settings.php:50
        #: storage/themes/the23/auth/2fa.php:53
        #: storage/themes/the23/auth/email2fa.php:61
        #: storage/themes/the23/auth/forgot.php:27
        #: storage/themes/the23/auth/invite.php:27
        #: storage/themes/the23/auth/register.php:68
        #: storage/themes/the23/pages/contact.php:51
        #: storage/themes/the23/pages/contact.php:52
        #: storage/themes/the23/pages/qr.php:27 storage/themes/the23/pages/qr.php:54
        #: storage/themes/the23/pages/qr.php:114
        #: storage/themes/the23/pages/report.php:13
        #: storage/themes/the23/pages/report.php:14
        "Email"=> "",

        #: app/controllers/user/OverlayController.php:312
        #: app/controllers/user/OverlayController.php:481
        #: app/helpers/biowidgets/Contact.php:206
        #: app/helpers/biowidgets/WhatsApp.php:51
        #: storage/themes/default/overlay/create_contact.php:92
        #: storage/themes/default/overlay/create_contact.php:176
        #: storage/themes/default/pages/contact.php:29
        #: storage/themes/default/pages/qr.php:61
        #: storage/themes/default/pages/qr.php:81 storage/themes/default/qr/edit.php:69
        #: storage/themes/default/qr/edit.php:99 storage/themes/default/qr/edit.php:116
        #: storage/themes/default/qr/edit.php:133 storage/themes/default/qr/new.php:81
        #: storage/themes/default/qr/new.php:107 storage/themes/default/qr/new.php:122
        #: storage/themes/default/qr/new.php:150
        #: storage/themes/the23/pages/contact.php:57
        #: storage/themes/the23/pages/qr.php:62 storage/themes/the23/pages/qr.php:82
        "Message"=> "",

        #: app/controllers/user/OverlayController.php:313
        #: app/controllers/user/OverlayController.php:482
        "send"=> "",

        #: app/controllers/user/OverlayController.php:321
        #: app/controllers/user/OverlayController.php:490
        #: app/controllers/user/OverlayController.php:619
        #: app/controllers/user/OverlayController.php:762
        #: app/controllers/user/OverlayController.php:912
        #: app/controllers/user/OverlayController.php:1081
        #: app/controllers/user/OverlayController.php:1206
        #: app/controllers/user/OverlayController.php:1343
        #: app/controllers/user/OverlayController.php:1499
        #: app/controllers/user/OverlayController.php:1642
        #: app/controllers/user/OverlayController.php:1791
        #: app/controllers/user/OverlayController.php:1911
        "The name field cannot be empty."=> "",

        #: app/controllers/user/OverlayController.php:356
        #: app/controllers/user/OverlayController.php:655
        #: app/controllers/user/OverlayController.php:958
        #: app/controllers/user/OverlayController.php:1259
        #: app/controllers/user/OverlayController.php:1525
        #: app/controllers/user/OverlayController.php:1817
        "Overlay has been successfully created."=> "",

        #: app/controllers/user/OverlayController.php:374
        #: app/controllers/user/OverlayController.php:673
        #: app/controllers/user/OverlayController.php:976
        #: app/controllers/user/OverlayController.php:1277
        #: app/controllers/user/OverlayController.php:1556
        #: app/controllers/user/OverlayController.php:1835
        #: storage/themes/default/bio/index.php:50
        #: storage/themes/default/overlay/index.php:46
        #: storage/themes/default/partials/links.php:13
        #: storage/themes/default/splash/index.php:43
        #: storage/themes/default/user/campaigns.php:33
        #: storage/themes/default/user/channel.php:7
        #: storage/themes/default/user/channel.php:38
        #: storage/themes/default/user/channels.php:30
        #: storage/themes/default/user/channels.php:60
        "Edit"=> "",

        #: app/controllers/user/OverlayController.php:521
        #: app/controllers/user/OverlayController.php:793
        #: app/controllers/user/OverlayController.php:1126
        #: app/controllers/user/OverlayController.php:1399
        #: app/controllers/user/OverlayController.php:1664
        #: app/controllers/user/OverlayController.php:1933
        "Overlay has been successfully updated."=> "",

        #: app/controllers/user/OverlayController.php:621
        #: app/controllers/user/OverlayController.php:764
        "Please enter a valid question."=> "",

        #: app/controllers/user/OverlayController.php:623
        #: app/controllers/user/OverlayController.php:766
        "A minimum of two options is required."=> "",

        #: app/controllers/user/OverlayController.php:637
        #: app/controllers/user/OverlayController.php:780 app/traits/Overlays.php:292
        #: storage/themes/default/overlay/create_poll.php:53
        #: storage/themes/default/overlay/create_poll.php:116
        "Vote"=> "",

        #: app/controllers/user/OverlayController.php:914
        #: app/controllers/user/OverlayController.php:1083
        #: app/controllers/user/OverlayController.php:1795
        #: app/controllers/user/OverlayController.php:1915
        "The message field cannot be empty."=> "",

        #: app/controllers/user/OverlayController.php:935
        #: app/controllers/user/OverlayController.php:937
        #: app/controllers/user/OverlayController.php:1104
        #: app/controllers/user/OverlayController.php:1106
        #: app/controllers/user/OverlayController.php:1220
        #: app/controllers/user/OverlayController.php:1222
        #: app/controllers/user/OverlayController.php:1357
        #: app/controllers/user/OverlayController.php:1359
        #: app/controllers/user/QRController.php:442
        #: app/controllers/user/QRController.php:607
        #: app/controllers/user/QRController.php:999
        #: app/controllers/user/QRController.php:1416
        "Logo must be either a PNG or a JPEG (Max 500kb)."=> "",

        #: app/controllers/user/OverlayController.php:941
        #: app/controllers/user/OverlayController.php:1110
        #: app/controllers/user/OverlayController.php:1226
        #: app/controllers/user/OverlayController.php:1363
        "Logo must be either a PNG or a JPEG with a recommended dimension of 100x100."=> "",

        #: app/controllers/user/OverlayController.php:1210
        "You need to upload your logo and/or a background."=> "",

        #: app/controllers/user/OverlayController.php:1236
        #: app/controllers/user/OverlayController.php:1238
        #: app/controllers/user/OverlayController.php:1377
        #: app/controllers/user/OverlayController.php:1379
        "Image must be either a PNG or a JPEG (Max 1mb)."=> "",

        #: app/controllers/user/OverlayController.php:1242
        #: app/controllers/user/OverlayController.php:1383
        "Image must be either a PNG or a JPEG with a recommended dimension of 600x150."=> "",

        #: app/controllers/user/OverlayController.php:1687
        "Overlay not found. Please try again."=> "",

        #: app/controllers/user/OverlayController.php:1700
        "Overlay has been deleted."=> "",

        #: app/controllers/user/OverlayController.php:1793
        #: app/controllers/user/OverlayController.php:1913
        "The coupon field cannot be empty."=> "",

        #: app/controllers/user/PixelsController.php:78 app/helpers/App.php:429
        #: app/traits/Teams.php:83 storage/themes/default/partials/sidebar_menu.php:170
        #: storage/themes/default/pixels/index.php:2
        #: storage/themes/default/pixels/index.php:17
        #: storage/themes/the23/index.php:674
        "Tracking Pixels"=> "",

        #: app/controllers/user/PixelsController.php:107
        "New Pixel"=> "",

        #: app/controllers/user/PixelsController.php:132
        "Pixel provider is currently not supported."=> "",

        #: app/controllers/user/PixelsController.php:145
        #: app/controllers/user/PixelsController.php:216
        "Please enter valid id."=> "",

        #: app/controllers/user/PixelsController.php:155
        "A pixel with this provider and tag already exists."=> "",

        #: app/controllers/user/PixelsController.php:167
        "Pixel has been added successfully"=> "",

        #: app/controllers/user/PixelsController.php:185
        #: app/controllers/user/PixelsController.php:211
        #: app/controllers/user/PixelsController.php:254
        "Pixel not found. Please try again."=> "",

        #: app/controllers/user/PixelsController.php:188
        #: storage/themes/default/pixels/index.php:66
        "Edit Pixel"=> "",

        #: app/controllers/user/PixelsController.php:230
        "Pixel has been updated successfully."=> "",

        #: app/controllers/user/PixelsController.php:264
        "Pixel has been deleted."=> "",

        #: app/controllers/user/PixelsController.php:288
        "You need to select at least 1 pixel."=> "",

        #: app/controllers/user/PixelsController.php:292 app/models/Plans.php:48
        "Please choose a premium package to unlock this feature."=> "",

        #: app/controllers/user/PixelsController.php:318
        "Selected items have been assign pixels."=> "",

        #: app/controllers/user/QRController.php:165 app/models/Role.php:83
        #: app/traits/Teams.php:49 storage/themes/default/qr/index.php:5
        #: storage/themes/default/qr/index.php:133 storage/themes/default/qr/new.php:1
        "Create QR"=> "",

        #: app/controllers/user/QRController.php:313
        #: app/controllers/user/QRController.php:486
        #: app/controllers/user/QRController.php:871
        #: app/controllers/user/QRController.php:1328
        "Please enter a name for your QR code."=> "",

        #: app/controllers/user/QRController.php:315
        #: app/controllers/user/QRController.php:484
        #: app/controllers/user/QRController.php:1326 app/helpers/QR.php:524
        #: app/helpers/QR.php:553 app/helpers/QR.php:571
        "Invalid QR format or missing data"=> "",

        #: app/controllers/user/QRController.php:419
        "Maximum limit for text label is 20"=> "",

        #: app/controllers/user/QRController.php:464
        #: storage/themes/default/qr/edit.php:851
        "Your QR code might not be readable. Please scan it with your phone to verify."=> "",

        #: app/controllers/user/QRController.php:652
        #: app/controllers/user/QRController.php:928 app/traits/Links.php:112
        #: app/traits/Links.php:115 app/traits/Links.php:118 app/traits/Links.php:588
        #: app/traits/Links.php:591 app/traits/Links.php:594
        "URL is suspected to contain malware and other harmful content."=> "",

        #: app/controllers/user/QRController.php:703
        "QR Code has been successfully generated."=> "",

        #: app/controllers/user/QRController.php:830 app/models/Role.php:84
        #: app/traits/Teams.php:50 storage/themes/default/qr/edit.php:3
        #: storage/themes/default/qr/index.php:81
        "Edit QR"=> "",

        #: app/controllers/user/QRController.php:868
        "QR does not exist."=> "",

        #: app/controllers/user/QRController.php:1075
        "QR Code has been successfully updated."=> "",

        #: app/controllers/user/QRController.php:1114
        "QR has been successfully deleted."=> "",

        #: app/controllers/user/QRController.php:1221
        #: storage/themes/default/qr/bulk.php:1
        "Create QR in Bulk"=> "",

        #: app/controllers/user/QRController.php:1367
        "You have reached your limit. {i}/{j} QR codes have been generated."=> "",

        #: app/controllers/user/QRController.php:1503
        "{i}/{j} QR codes have been generated."=> "",

        #: app/controllers/user/QRController.php:1521
        #: app/controllers/user/QRController.php:1557
        "You must select at least 1 QR code."=> "",

        #: app/controllers/user/QRController.php:1541
        "{n} QR codes have been successfully deleted."=> "",

        #: app/controllers/user/SplashController.php:69
        #: storage/themes/default/splash/index.php:2
        #: storage/themes/default/splash/index.php:12
        #: storage/themes/default/splash/index.php:17
        "Custom Splash Pages"=> "",

        #: app/controllers/user/SplashController.php:95
        #: storage/themes/default/splash/create.php:1
        #: storage/themes/default/splash/index.php:69
        "Create a Custom Splash"=> "",

        #: app/controllers/user/SplashController.php:129
        #: app/controllers/user/SplashController.php:259
        "The name, title, message and link cannot be empty."=> "",

        #: app/controllers/user/SplashController.php:133
        #: app/controllers/user/SplashController.php:262
        "Please enter a valid counter time in seconds."=> "",

        #: app/controllers/user/SplashController.php:148
        #: storage/themes/default/bio/edit.php:50
        #: storage/themes/default/splash/create.php:48
        #: storage/themes/default/splash/edit.php:53
        "Avatar must be one the following formats {f} and be less than {s}kb."=> "",

        #: app/controllers/user/SplashController.php:150
        #: app/controllers/user/SplashController.php:152
        #: app/controllers/user/SplashController.php:281
        #: app/controllers/user/SplashController.php:283
        "Avatar must be the one following formats {f} and be less than {s}kb."=> "",

        #: app/controllers/user/SplashController.php:157
        "Image cannot be processed. Please select another image."=> "",

        #: app/controllers/user/SplashController.php:176
        #: app/controllers/user/SplashController.php:178
        #: app/controllers/user/SplashController.php:180
        #: app/controllers/user/SplashController.php:184
        #: app/controllers/user/SplashController.php:314
        #: app/controllers/user/SplashController.php:316
        #: app/controllers/user/SplashController.php:320
        #: storage/themes/default/splash/create.php:64
        #: storage/themes/default/splash/create.php:65
        #: storage/themes/default/splash/edit.php:69
        #: storage/themes/default/splash/edit.php:70
        "The minimum width must be 980px and the height must be between 250 and 500. The format must be a {f}. Maximum size is {s}kb."=> "",

        #: app/controllers/user/SplashController.php:189
        "Image cannot be processed.Please select another image."=> "",

        #: app/controllers/user/SplashController.php:204
        "Custom splash page has been created."=> "",

        #: app/controllers/user/SplashController.php:221
        #: app/controllers/user/SplashController.php:256
        #: app/controllers/user/SplashController.php:367
        "Custom splash page does not exist."=> "",

        #: app/controllers/user/SplashController.php:235
        #: storage/themes/default/splash/edit.php:2
        "Update a Custom Splash"=> "",

        #: app/controllers/user/SplashController.php:349
        "Custom splash page has been updated."=> "",

        #: app/controllers/user/SplashController.php:380
        "Custom splash page has been deleted."=> "",

        #: app/controllers/user/StatsController.php:41 app/models/Role.php:115
        #: storage/themes/default/bio/edit.php:27
        #: storage/themes/default/bio/index.php:52
        #: storage/themes/default/partials/links.php:10
        #: storage/themes/default/partials/sidebar_menu.php:92
        #: storage/themes/default/qr/index.php:78
        #: storage/themes/default/user/campaigns.php:37
        #: storage/themes/default/user/channel.php:41
        #: storage/themes/default/user/edit.php:7
        #: storage/themes/default/user/stats.php:2
        "Statistics"=> "",

        #: app/controllers/user/StatsController.php:213
        #: storage/themes/default/stats/activity.php:10
        #: storage/themes/default/stats/index.php:25
        #: storage/themes/default/user/activity.php:2
        #: storage/themes/default/user/index.php:127
        "Recent Activity"=> "",

        #: app/controllers/user/TeamsController.php:95
        #: storage/themes/default/teams/index.php:3
        "Manage Members"=> "",

        #: app/controllers/user/TeamsController.php:125
        "You cannot invite yourself. Please enter another email."=> "",

        #: app/controllers/user/TeamsController.php:128
        "This email address has been invited."=> "",

        #: app/controllers/user/TeamsController.php:132
        "No permission has been assigned for this user."=> "",

        #: app/controllers/user/TeamsController.php:165
        "An invite has been sent to the email."=> "",

        #: app/controllers/user/TeamsController.php:178
        #: app/controllers/user/TeamsController.php:201
        #: app/controllers/user/TeamsController.php:233
        #: app/controllers/user/TeamsController.php:257
        "Team member does not exist."=> "",

        #: app/controllers/user/TeamsController.php:210
        "Team member has been updated successfully."=> "",

        #: app/controllers/user/TeamsController.php:243
        "Team member has been removed successfully."=> "",

        #: app/controllers/user/TeamsController.php:260
        "Team member needs to accept invitation."=> "",

        #: app/controllers/user/TeamsController.php:265
        "Team member has been enabled."=> "",

        #: app/controllers/user/TeamsController.php:269
        "Team member has been disabled."=> "",

        #: app/controllers/user/TeamsController.php:286
        "You are now using your individual space."=> "",

        #: app/controllers/user/TeamsController.php:293
        "You are now using your team workspace."=> "",

        #: app/controllers/user/TeamsController.php:316
        "You have accepted your team's invite."=> "",

        #: app/controllers/user/ToolsController.php:37 app/models/Role.php:151
        #: storage/themes/default/partials/sidebar_menu.php:219
        #: storage/themes/default/partials/sidebar_menu.php:222
        #: storage/themes/default/user/tools.php:1
        "Tools"=> "",

        #: app/controllers/user/ToolsController.php:62
        "The application has been installed on your Slack account. You can now use the command to shorten links directly from your conversations."=> "",

        #: app/controllers/user/ToolsController.php:69
        "An error occurred and slack has not been installed."=> "",

        #: app/controllers/user/ToolsController.php:89
        "Your Zapier URL has been updated."=> "",

        #: app/controllers/user/VerificationController.php:50
        #: storage/themes/default/partials/topbar_menu.php:117
        #: storage/themes/default/user/verification.php:4
        "Get Verified"=> "",

        #: app/controllers/user/VerificationController.php:54
        "You are already verified"=> "",

        #: app/controllers/user/VerificationController.php:75
        "You already requested a verification. As soon as we verify the document, we will let you know."=> "",

        #: app/controllers/user/VerificationController.php:79
        "Please upload a document so we can verify you."=> "",

        #: app/controllers/user/VerificationController.php:83
        "Please fill everything so we can verify you."=> "",

        #: app/controllers/user/VerificationController.php:86
        "Document must be either a PDF or a JPG (Max 2MB)."=> "",

        #: app/controllers/user/VerificationController.php:88
        "Document must be either a PDF or a JPG (Max 2MB)"=> "",

        #: app/controllers/user/VerificationController.php:126
        "Thank you. We will process your document as soon as possible and verify you."=> "",

        #: app/helpers/App.php:393
        "Bulk QR Codes"=> "",

        #: app/helpers/App.php:394
        "Generate multiple QR codes at once."=> "",

        #: app/helpers/App.php:399
        "Bio Page Widgets"=> "",

        #: app/helpers/App.php:400
        "Available Bio Page Widgets"=> "",

        #: app/helpers/App.php:405
        "Blocks"=> "",

        #: app/helpers/App.php:406
        "Choose from list of available blocks. Leave empty to allow all blocks."=> "",

        #: app/helpers/App.php:411 storage/themes/default/index.php:412
        #: storage/themes/the23/index.php:392
        "Custom Landing Page"=> "",

        #: app/helpers/App.php:412 storage/themes/default/index.php:414
        #: storage/themes/the23/index.php:394
        "Create a custom landing page to promote your product or service on forefront and engage the user in your marketing campaign."=> "",

        #: app/helpers/App.php:417 storage/themes/default/index.php:429
        #: storage/themes/the23/index.php:401
        "CTA Overlays"=> "",

        #: app/helpers/App.php:418 storage/themes/default/index.php:431
        #: storage/themes/the23/index.php:403
        "Use our overlay tool to display unobtrusive notifications, polls or even a contact on the target website. Great for campaigns."=> "",

        #: app/helpers/App.php:424 storage/themes/default/index.php:482
        "Easily add your own domain name for short your links and take control of your brand name and your users' trust."=> "",

        #: app/helpers/App.php:430 storage/themes/default/index.php:448
        #: storage/themes/the23/index.php:412
        "Add your custom pixel from providers such as Facebook and track events right when they are happening."=> "",

        #: app/helpers/App.php:436
        "Group & organize your links."=> "",

        #: app/helpers/App.php:443
        "Group your links and visualize aggregate data."=> "",

        #: app/helpers/App.php:449 storage/themes/default/user/confirmation.php:83
        "Team Members"=> "",

        #: app/helpers/App.php:450 storage/themes/default/index.php:465
        "Invite your team members and assign them specific privileges to manage links, bundles, pages and other features."=> "",

        #: app/helpers/App.php:455 storage/themes/default/user/confirmation.php:72
        "Custom Aliases"=> "",

        #: app/helpers/App.php:456
        "Choose a custom alias instead of a randomly generated one."=> "",

        #: app/helpers/App.php:461 storage/themes/default/partials/links.php:83
        #: storage/themes/default/partials/shortener.php:118
        #: storage/themes/default/partials/shortener.php:262
        #: storage/themes/default/user/edit.php:145
        "Deep Linking"=> "",

        #: app/helpers/App.php:462
        "Configure your links to automatically open apps if installed."=> "",

        #: app/helpers/App.php:467 app/helpers/BioWidgets.php:1155
        #: storage/themes/default/partials/shortener.php:124
        #: storage/themes/default/partials/shortener.php:225
        #: storage/themes/default/user/edit.php:70
        "Geo Targeting"=> "",

        #: app/helpers/App.php:468
        "Target and redirect visitors based on their country or state."=> "",

        #: app/helpers/App.php:473 storage/themes/default/partials/shortener.php:127
        #: storage/themes/default/partials/shortener.php:283
        #: storage/themes/default/user/confirmation.php:76
        #: storage/themes/default/user/edit.php:263
        "Device Targeting"=> "",

        #: app/helpers/App.php:474
        "Target and redirect visitors based on their device."=> "",

        #: app/helpers/App.php:479 app/helpers/BioWidgets.php:1163
        #: storage/themes/default/partials/shortener.php:130
        #: storage/themes/default/partials/shortener.php:312
        #: storage/themes/default/user/confirmation.php:77
        #: storage/themes/default/user/edit.php:315
        "Language Targeting"=> "",

        #: app/helpers/App.php:480
        "Target and redirect visitors based on their language."=> "",

        #: app/helpers/App.php:485 storage/themes/default/partials/shortener.php:399
        "A/B Testing & Rotator"=> "",

        #: app/helpers/App.php:486
        "Rotate links using the same short link. Great for A/B testing."=> "",

        #: app/helpers/App.php:491 storage/themes/default/partials/links.php:92
        #: storage/themes/default/partials/shortener.php:136
        #: storage/themes/default/partials/shortener.php:357
        #: storage/themes/default/user/billing.php:64
        #: storage/themes/default/user/edit.php:366
        "Expiration"=> "",

        #: app/helpers/App.php:492
        "Set a date or number to clicks to expire short links"=> "",

        #: app/helpers/App.php:497
        "Click Limitation"=> "",

        #: app/helpers/App.php:498
        "Limit number of clicks per short link"=> "",

        #: app/helpers/App.php:503 storage/themes/default/partials/links.php:101
        #: storage/themes/default/partials/shortener.php:142
        "Parameters"=> "",

        #: app/helpers/App.php:504
        "Add parameters such as UTM to the short link."=> "",

        #: app/helpers/App.php:509
        "Custom Logo on QR"=> "",

        #: app/helpers/App.php:510
        "Upload your own logo on QR codes."=> "",

        #: app/helpers/App.php:515
        "Frames on QR"=> "",

        #: app/helpers/App.php:516
        "Add frames to your QR codes."=> "",

        #: app/helpers/App.php:521
        "Custom CSS on Bio Page"=> "",

        #: app/helpers/App.php:522
        "Add your own CSS on Bio Pages."=> "",

        #: app/helpers/App.php:528
        "Add your own Mailchimp form to your Bio Page."=> "",

        #: app/helpers/App.php:533 storage/themes/default/bio/edit.php:381
        "Custom Favicon"=> "",

        #: app/helpers/App.php:534
        "Add your own favicons."=> "",

        #: app/helpers/App.php:539 storage/themes/default/bio/edit.php:492
        "Remove Branding"=> "",

        #: app/helpers/App.php:540
        "Remove branding on Bio Pages and Custom Splash Pages"=> "",

        #: app/helpers/App.php:545
        "Premium Domains"=> "",

        #: app/helpers/App.php:546
        "Use premium domains we provide you with instead of the original one."=> "",

        #: app/helpers/App.php:551 storage/themes/default/domains/index.php:14
        #: storage/themes/default/domains/new.php:61
        "Domains"=> "",

        #: app/helpers/App.php:552
        "Choose from list of available domains or leave empty to allow all domains."=> "",

        #: app/helpers/App.php:557 app/traits/Teams.php:109 app/traits/Teams.php:111
        #: storage/themes/default/integrations/index.php:49
        #: storage/themes/default/layouts/dashboard.php:84
        #: storage/themes/default/partials/footer.php:76
        #: storage/themes/default/partials/main_menu.php:27
        #: storage/themes/default/partials/sidebar_menu.php:227
        #: storage/themes/default/user/confirmation.php:97
        #: storage/themes/the23/index.php:455
        #: storage/themes/the23/partials/footer.php:75
        #: storage/themes/the23/partials/main_menu.php:133
        #: storage/themes/the23/partials/main_menu.php:212
        "Developer API"=> "",

        #: app/helpers/App.php:558 storage/themes/default/index.php:499
        #: storage/themes/the23/index.php:457
        "Use our powerful API to build custom applications or extend your own application with our powerful tools."=> "",

        #: app/helpers/App.php:563
        "API Rate Limit"=> "",

        #: app/helpers/App.php:564
        "Amount of requests you can send per minute to our API system."=> "",

        #: app/helpers/App.php:569 storage/themes/default/partials/sidebar_menu.php:224
        #: storage/themes/default/user/import.php:1
        "Import Links"=> "",

        #: app/helpers/App.php:570
        "Import links via CSV."=> "",

        #: app/helpers/App.php:575 app/traits/Teams.php:118
        #: storage/themes/default/user/campaignstats.php:102
        #: storage/themes/default/user/confirmation.php:96
        #: storage/themes/default/user/stats.php:112
        "Export Data"=> "",

        #: app/helpers/App.php:576
        "Export clicks & visits."=> "",

        #: app/helpers/App.php:1057 app/helpers/App.php:1066
        "Redirection"=> "",

        #: app/helpers/App.php:1059 storage/themes/default/pages/qr.php:270
        #: storage/themes/default/user/settings.php:178
        #: storage/themes/the23/pages/qr.php:271
        "Frame"=> "",

        #: app/helpers/App.php:1060 storage/themes/default/user/settings.php:179
        "Splash"=> "",

        #: app/helpers/App.php:1094 app/traits/Teams.php:65
        #: storage/themes/default/partials/sidebar_menu.php:156
        #: storage/themes/default/user/confirmation.php:80
        "Custom Splash"=> "",

        #: app/helpers/BioWidgets.php:111 app/helpers/QR.php:65
        #: app/helpers/biowidgets/Calendly.php:50
        #: app/helpers/biowidgets/Facebook.php:41
        #: app/helpers/biowidgets/FeaturedLink.php:69
        #: app/helpers/biowidgets/Image.php:50 app/helpers/biowidgets/Image.php:64
        #: app/helpers/biowidgets/Instagram.php:41 app/helpers/biowidgets/Itunes.php:39
        #: app/helpers/biowidgets/Link.php:101 app/helpers/biowidgets/Link.php:196
        #: app/helpers/biowidgets/Link.php:208 app/helpers/biowidgets/Link.php:223
        #: app/helpers/biowidgets/Link.php:245 app/helpers/biowidgets/Link.php:267
        #: app/helpers/biowidgets/LinkedIn.php:41
        #: app/helpers/biowidgets/MusicLink.php:221
        #: app/helpers/biowidgets/MusicLink.php:243
        #: app/helpers/biowidgets/MusicLink.php:259
        #: app/helpers/biowidgets/MusicLink.php:267
        #: app/helpers/biowidgets/OpenSea.php:40
        #: app/helpers/biowidgets/Pinterest.php:49
        #: app/helpers/biowidgets/Product.php:80 app/helpers/biowidgets/Reddit.php:50
        #: app/helpers/biowidgets/Rss.php:40 app/helpers/biowidgets/Snapchat.php:36
        #: app/helpers/biowidgets/SoundCloud.php:37
        #: app/helpers/biowidgets/Spotify.php:37 app/helpers/biowidgets/Threads.php:37
        #: app/helpers/biowidgets/TikTok.php:36
        #: app/helpers/biowidgets/TikTokProfile.php:36
        #: app/helpers/biowidgets/Twitter.php:41 app/helpers/biowidgets/Typeform.php:45
        #: app/helpers/biowidgets/VCard.php:178 app/helpers/biowidgets/VCard.php:201
        #: app/helpers/biowidgets/YouTube.php:36
        #: storage/themes/default/bio/edit.php:234
        #: storage/themes/default/overlay/create_image.php:23
        #: storage/themes/default/overlay/edit_image.php:23
        #: storage/themes/default/qr/bulk.php:29 storage/themes/default/qr/edit.php:44
        #: storage/themes/default/qr/new.php:33 storage/themes/default/qr/new.php:58
        "Link"=> "",

        #: app/helpers/BioWidgets.php:112
        "Add a trackable button to a link"=> "",

        #: app/helpers/BioWidgets.php:122 app/helpers/biowidgets/FeaturedLink.php:110
        #: app/helpers/biowidgets/FeaturedLink.php:125
        #: app/helpers/biowidgets/FeaturedLink.php:147
        #: app/helpers/biowidgets/FeaturedLink.php:169
        "Featured Link"=> "",

        #: app/helpers/BioWidgets.php:123
        "Add a featured link with rectangular image and title"=> "",

        #: app/helpers/BioWidgets.php:133 app/helpers/BioWidgets.php:972
        "Tagline"=> "",

        #: app/helpers/BioWidgets.php:134
        "Add a tagline under your profile name"=> "",

        #: app/helpers/BioWidgets.php:144
        "Heading"=> "",

        #: app/helpers/BioWidgets.php:145
        "Add a heading with different sizes"=> "",

        #: app/helpers/BioWidgets.php:155 app/helpers/QR.php:62
        #: app/helpers/biowidgets/Contact.php:46 app/helpers/biowidgets/Heading.php:57
        #: app/helpers/biowidgets/Link.php:90 app/helpers/biowidgets/Newsletter.php:58
        #: app/helpers/biowidgets/Text.php:66 app/helpers/biowidgets/VCard.php:172
        #: app/helpers/biowidgets/VCard.php:195 storage/themes/default/pages/qr.php:24
        #: storage/themes/default/pages/qr.php:37 storage/themes/default/qr/bulk.php:26
        #: storage/themes/default/qr/bulk.php:347 storage/themes/default/qr/edit.php:31
        #: storage/themes/default/qr/edit.php:783 storage/themes/default/qr/new.php:26
        #: storage/themes/default/qr/new.php:47 storage/themes/default/qr/new.php:769
        #: storage/themes/the23/pages/qr.php:25 storage/themes/the23/pages/qr.php:38
        "Text"=> "",

        #: app/helpers/BioWidgets.php:156
        "Add a text body to your page"=> "",

        #: app/helpers/BioWidgets.php:166
        "Divider"=> "",

        #: app/helpers/BioWidgets.php:167
        "Separate your content with a line"=> "",

        #: app/helpers/BioWidgets.php:177 app/helpers/biowidgets/Html.php:39
        "HTML"=> "",

        #: app/helpers/BioWidgets.php:178
        "Add custom HTML code. Script codes are not accepted"=> "",

        #: app/helpers/BioWidgets.php:188 app/helpers/biowidgets/FeaturedLink.php:49
        #: app/helpers/biowidgets/Link.php:62 app/helpers/biowidgets/Link.php:73
        #: app/helpers/biowidgets/MusicLink.php:65
        #: app/helpers/biowidgets/Product.php:74
        #: storage/themes/default/bio/edit.php:279
        "Image"=> "",

        #: app/helpers/BioWidgets.php:189
        "Upload an image or 2 images in a row"=> "",

        #: app/helpers/BioWidgets.php:199
        "Phone Call"=> "",

        #: app/helpers/BioWidgets.php:200
        "Set your phone number to call directly"=> "",

        #: app/helpers/BioWidgets.php:211 app/helpers/QR.php:98
        #: storage/themes/default/pages/qr.php:30
        #: storage/themes/default/qr/edit.php:142
        #: storage/themes/default/qr/edit.php:233 storage/themes/default/qr/new.php:37
        #: storage/themes/default/qr/new.php:157 storage/themes/the23/pages/qr.php:31
        "vCard"=> "",

        #: app/helpers/BioWidgets.php:212
        "Add a downloadable vCard"=> "",

        #: app/helpers/BioWidgets.php:222
        "PayPal Button"=> "",

        #: app/helpers/BioWidgets.php:223
        "Generate a PayPal button to accept payments"=> "",

        #: app/helpers/BioWidgets.php:233
        "WhatsApp Call"=> "",

        #: app/helpers/BioWidgets.php:234
        "Add button to initiate a Whatsapp call"=> "",

        #: app/helpers/BioWidgets.php:244
        "WhatsApp Message"=> "",

        #: app/helpers/BioWidgets.php:245
        "Add button to send a Whatsapp message"=> "",

        #: app/helpers/BioWidgets.php:255
        "RSS Feed"=> "",

        #: app/helpers/BioWidgets.php:256
        "Add a dynamic RSS feed widget"=> "",

        #: app/helpers/BioWidgets.php:266
        #: storage/themes/default/overlay/create_newsletter.php:117
        #: storage/themes/default/overlay/edit_newsletter.php:117
        #: storage/themes/default/user/settings.php:217
        "Newsletter"=> "",

        #: app/helpers/BioWidgets.php:267
        "Add a newsletter form to store emails"=> "",

        #: app/helpers/BioWidgets.php:277 storage/themes/default/bio/edit.php:555
        "Contact Form"=> "",

        #: app/helpers/BioWidgets.php:278
        "Add a contact form to receive emails"=> "",

        #: app/helpers/BioWidgets.php:288
        "FAQs"=> "",

        #: app/helpers/BioWidgets.php:289
        "Add a widget of questions and answers"=> "",

        #: app/helpers/BioWidgets.php:299
        "Product"=> "",

        #: app/helpers/BioWidgets.php:300
        "Add a widget to a product on your site"=> "",

        #: app/helpers/BioWidgets.php:310
        "Music/Booking Links"=> "",

        #: app/helpers/BioWidgets.php:311
        "Add a dynamic widget for all of your music or booking links"=> "",

        #: app/helpers/BioWidgets.php:321
        "Youtube Video or Playlist"=> "",

        #: app/helpers/BioWidgets.php:322
        "Embed a Youtube video or a playlist"=> "",

        #: app/helpers/BioWidgets.php:332
        "Spotify Embed"=> "",

        #: app/helpers/BioWidgets.php:333
        "Embed a Spotify music or playlist widget"=> "",

        #: app/helpers/BioWidgets.php:343
        "Apple Music Embed"=> "",

        #: app/helpers/BioWidgets.php:344
        "Embed an Apple music widget"=> "",

        #: app/helpers/BioWidgets.php:354
        "TikTok Embed"=> "",

        #: app/helpers/BioWidgets.php:355
        "Embed a tiktok video"=> "",

        #: app/helpers/BioWidgets.php:365
        "OpenSea NFT"=> "",

        #: app/helpers/BioWidgets.php:366
        "Embed your NFT from OpenSea"=> "",

        #: app/helpers/BioWidgets.php:376
        "Embed Tweets"=> "",

        #: app/helpers/BioWidgets.php:377
        "Embed your latest tweets"=> "",

        #: app/helpers/BioWidgets.php:387
        "SoundCloud"=> "",

        #: app/helpers/BioWidgets.php:388
        "Embed a SoundCloud track"=> "",

        #: app/helpers/BioWidgets.php:398
        "Facebook Post"=> "",

        #: app/helpers/BioWidgets.php:399
        "Embed a Facebook post"=> "",

        #: app/helpers/BioWidgets.php:409
        "Instagram Post"=> "",

        #: app/helpers/BioWidgets.php:410
        "Embed an Instagram post"=> "",

        #: app/helpers/BioWidgets.php:420
        "Typeform"=> "",

        #: app/helpers/BioWidgets.php:421
        "Embed a Typeform form"=> "",

        #: app/helpers/BioWidgets.php:431 app/helpers/BioWidgets.php:721
        #: app/helpers/DeepLinks.php:133
        "Pinterest"=> "",

        #: app/helpers/BioWidgets.php:432
        "Embed a Pinterest board"=> "",

        #: app/helpers/BioWidgets.php:442
        "Reddit"=> "",

        #: app/helpers/BioWidgets.php:443
        "Embed a Reddit profile"=> "",

        #: app/helpers/BioWidgets.php:453
        "Calendly"=> "",

        #: app/helpers/BioWidgets.php:454
        "Schedule booking & appointments"=> "",

        #: app/helpers/BioWidgets.php:464 app/helpers/BioWidgets.php:689
        "Threads"=> "",

        #: app/helpers/BioWidgets.php:465
        "Display a Threads post"=> "",

        #: app/helpers/BioWidgets.php:475
        "TikTok Profile"=> "",

        #: app/helpers/BioWidgets.php:476
        "Display your profile"=> "",

        #: app/helpers/BioWidgets.php:486
        "Google Maps"=> "",

        #: app/helpers/BioWidgets.php:487
        "Add a pin to your location on Google Maps"=> "",

        #: app/helpers/BioWidgets.php:497
        "OpenTable Reservation"=> "",

        #: app/helpers/BioWidgets.php:498
        "Allow visitors to easily book a table"=> "",

        #: app/helpers/BioWidgets.php:508
        "EventBrite"=> "",

        #: app/helpers/BioWidgets.php:509
        "Allow visitors to easily book an event"=> "",

        #: app/helpers/BioWidgets.php:519 app/helpers/BioWidgets.php:709
        #: app/helpers/DeepLinks.php:142
        "Snapchat"=> "",

        #: app/helpers/BioWidgets.php:520
        "Add a Snapchat widget on your page"=> "",

        #: app/helpers/BioWidgets.php:530
        "LinkedIn Post"=> "",

        #: app/helpers/BioWidgets.php:531
        "Display a LinkedIn post"=> "",

        #: app/helpers/BioWidgets.php:541
        "Video"=> "",

        #: app/helpers/BioWidgets.php:542
        "Upload a video"=> "",

        #: app/helpers/BioWidgets.php:552
        "Audio"=> "",

        #: app/helpers/BioWidgets.php:553
        "Upload an MP3 audio file"=> "",

        #: app/helpers/BioWidgets.php:563
        "PDF Document"=> "",

        #: app/helpers/BioWidgets.php:564
        "Upload a PDF document with preview"=> "",

        #: app/helpers/BioWidgets.php:574
        "Intercom Chat"=> "",

        #: app/helpers/BioWidgets.php:575
        "Add Intercom live chat widget to your profile"=> "",

        #: app/helpers/BioWidgets.php:585
        "Tawk.to Chat"=> "",

        #: app/helpers/BioWidgets.php:586
        "Add Tawk.to live chat widget to your profile"=> "",

        #: app/helpers/BioWidgets.php:596
        "Tidio Chat"=> "",

        #: app/helpers/BioWidgets.php:597
        "Add tidio live chat widget to your profile"=> "",

        #: app/helpers/BioWidgets.php:607
        "Video Embed"=> "",

        #: app/helpers/BioWidgets.php:608
        "Embed videos from YouTube, Vimeo, Dailymotion and more"=> "",

        #: app/helpers/BioWidgets.php:616 app/helpers/biowidgets/Countdown.php:92
        #: app/helpers/biowidgets/Countdown.php:96
        "Countdown"=> "",

        #: app/helpers/BioWidgets.php:617
        "Add a countdown timer with an expiration message"=> "",

        #: app/helpers/BioWidgets.php:627 app/helpers/biowidgets/Carousel.php:30
        "Carousel"=> "",

        #: app/helpers/BioWidgets.php:628
        "Create an image carousel with up to 5 images"=> "",

        #: app/helpers/BioWidgets.php:673 app/helpers/DeepLinks.php:79
        #: storage/themes/default/pages/qr.php:148
        #: storage/themes/default/qr/edit.php:211
        #: storage/themes/default/qr/edit.php:298 storage/themes/default/qr/new.php:226
        #: storage/themes/default/qr/new.php:311 storage/themes/the23/pages/qr.php:149
        "Facebook"=> "",

        #: app/helpers/BioWidgets.php:677 storage/themes/default/pages/qr.php:152
        #: storage/themes/default/qr/edit.php:215
        #: storage/themes/default/qr/edit.php:302 storage/themes/default/qr/new.php:230
        #: storage/themes/default/qr/new.php:315 storage/themes/the23/pages/qr.php:153
        "Twitter"=> "",

        #: app/helpers/BioWidgets.php:681 app/helpers/DeepLinks.php:187
        "X"=> "",

        #: app/helpers/BioWidgets.php:685 app/helpers/DeepLinks.php:97
        #: storage/themes/default/pages/qr.php:156
        #: storage/themes/default/qr/edit.php:219
        #: storage/themes/default/qr/edit.php:306 storage/themes/default/qr/new.php:234
        #: storage/themes/default/qr/new.php:319 storage/themes/the23/pages/qr.php:157
        "Instagram"=> "",

        #: app/helpers/BioWidgets.php:693 app/helpers/DeepLinks.php:169
        "TikTok"=> "",

        #: app/helpers/BioWidgets.php:697 storage/themes/default/qr/edit.php:223
        #: storage/themes/default/qr/new.php:238
        "Linkedin"=> "",

        #: app/helpers/BioWidgets.php:701 app/helpers/DeepLinks.php:232
        "Youtube"=> "",

        #: app/helpers/BioWidgets.php:705 app/helpers/DeepLinks.php:160
        "Telegram"=> "",

        #: app/helpers/BioWidgets.php:713
        "Discord"=> "",

        #: app/helpers/BioWidgets.php:717 app/helpers/DeepLinks.php:178
        "Twitch"=> "",

        #: app/helpers/BioWidgets.php:725
        "Shopify"=> "",

        #: app/helpers/BioWidgets.php:729 app/helpers/DeepLinks.php:61
        "Amazon"=> "",

        #: app/helpers/BioWidgets.php:733
        "Line Messenger"=> "",

        #: app/helpers/BioWidgets.php:737 app/helpers/DeepLinks.php:205
        #: app/helpers/QR.php:104 storage/themes/default/qr/edit.php:125
        #: storage/themes/default/qr/new.php:40 storage/themes/default/qr/new.php:142
        "Whatsapp"=> "",

        #: app/helpers/BioWidgets.php:741
        "Viber"=> "",

        #: app/helpers/BioWidgets.php:745 app/helpers/DeepLinks.php:151
        "Spotify"=> "",

        #: app/helpers/BioWidgets.php:749
        "Github"=> "",

        #: app/helpers/BioWidgets.php:753
        "Behance"=> "",

        #: app/helpers/BioWidgets.php:757
        "Dribbble"=> "",

        #: app/helpers/BioWidgets.php:761
        "Mail"=> "",

        #: app/helpers/BioWidgets.php:765
        "Quora"=> "",

        #: app/helpers/BioWidgets.php:769
        "VK"=> "",

        #: app/helpers/BioWidgets.php:773
        "WeChat"=> "",

        #: app/helpers/BioWidgets.php:777
        "Mix"=> "",

        #: app/helpers/BioWidgets.php:781 app/traits/Payments.php:116
        #: app/traits/Payments.php:199 storage/themes/default/user/withdrawals.php:10
        "PayPal"=> "",

        #: app/helpers/BioWidgets.php:785
        "CodePen"=> "",

        #: app/helpers/BioWidgets.php:789
        "Product Hunt"=> "",

        #: app/helpers/BioWidgets.php:793
        "Skype"=> "",

        #: app/helpers/BioWidgets.php:797
        "Vimeo"=> "",

        #: app/helpers/BioWidgets.php:801
        "IMDB"=> "",

        #: app/helpers/BioWidgets.php:805
        "Unsplash"=> "",

        #: app/helpers/BioWidgets.php:809
        "Mastodon"=> "",

        #: app/helpers/BioWidgets.php:813
        "Bluesky"=> "",

        #: app/helpers/BioWidgets.php:817
        "Upwork"=> "",

        #: app/helpers/BioWidgets.php:821 app/helpers/DeepLinks.php:115
        "Messenger"=> "",

        #: app/helpers/BioWidgets.php:825
        "Signal"=> "",

        #: app/helpers/BioWidgets.php:829
        "OnlyFans"=> "",

        #: app/helpers/BioWidgets.php:833
        "Google Play Store"=> "",

        #: app/helpers/BioWidgets.php:837
        "App Store"=> "",

        #: app/helpers/BioWidgets.php:919
        "Preview Only - The following block is hidden in live Bio Page."=> "",

        #: app/helpers/BioWidgets.php:966
        "Block not available in your plan, please upgrade."=> "",

        #: app/helpers/BioWidgets.php:972
        "{b} Error: One or more countries are invalid."=> "",

        #: app/helpers/BioWidgets.php:1135 storage/themes/default/bio/edit.php:115
        "Move"=> "",

        #: app/helpers/BioWidgets.php:1137 app/helpers/biowidgets/FAQs.php:47
        #: app/helpers/biowidgets/FAQs.php:74 app/helpers/biowidgets/VCard.php:183
        #: app/helpers/biowidgets/VCard.php:206 storage/themes/default/bio/edit.php:118
        #: storage/themes/default/bio/index.php:67
        #: storage/themes/default/domains/index.php:60
        #: storage/themes/default/layouts/dashboard.php:125
        #: storage/themes/default/overlay/index.php:50
        #: storage/themes/default/partials/links.php:37
        #: storage/themes/default/pixels/index.php:70
        #: storage/themes/default/qr/index.php:99
        #: storage/themes/default/splash/index.php:47
        #: storage/themes/default/user/campaigns.php:40
        #: storage/themes/default/user/channels.php:34
        #: storage/themes/default/user/channels.php:64
        #: storage/themes/default/user/edit.php:106
        #: storage/themes/default/user/edit.php:220
        #: storage/themes/default/user/edit.php:288
        #: storage/themes/default/user/edit.php:340
        #: storage/themes/default/user/edit.php:432
        #: storage/themes/default/user/edit.php:502
        #: storage/themes/default/user/settings.php:338
        "Delete"=> "",

        #: app/helpers/BioWidgets.php:1143
        "View Stats"=> "",

        #: app/helpers/BioWidgets.php:1146
        "Toggle Block"=> "",

        #: app/helpers/BioWidgets.php:1156
        "Display this block for specific countries"=> "",

        #: app/helpers/BioWidgets.php:1164
        "Display this block for specific languages"=> "",

        #: app/helpers/BioWidgets.php:1171
        "Schedule"=> "",

        #: app/helpers/BioWidgets.php:1172
        "Schedule when this blocks goes live and ends"=> "",

        #: app/helpers/BioWidgets.php:1175 storage/themes/default/pages/qr.php:206
        #: storage/themes/default/qr/edit.php:408 storage/themes/default/qr/new.php:375
        #: storage/themes/the23/pages/qr.php:207
        "Start"=> "",

        #: app/helpers/BioWidgets.php:1179 storage/themes/default/pages/qr.php:212
        #: storage/themes/default/qr/edit.php:414 storage/themes/default/qr/new.php:381
        #: storage/themes/the23/pages/qr.php:213
        "End"=> "",

        #: app/helpers/BioWidgets.php:1186
        "Gate Access"=> "",

        #: app/helpers/BioWidgets.php:1187
        "Visitors can be gated before accessing the link. Please note that you can only activate one at a time."=> "",

        #: app/helpers/BioWidgets.php:1191
        "Visitors must acknowledge that the link may contain sensitive content"=> "",

        #: app/helpers/BioWidgets.php:1198
        #: storage/themes/default/overlay/create_coupon.php:31
        #: storage/themes/default/overlay/create_message.php:32
        #: storage/themes/default/overlay/edit_coupon.php:31
        #: storage/themes/default/overlay/edit_message.php:32
        #: storage/themes/default/splash/create.php:72
        #: storage/themes/default/splash/edit.php:77
        "Custom Message"=> "",

        #: app/helpers/BioWidgets.php:1203 app/helpers/biowidgets/Link.php:481
        #: app/helpers/biowidgets/Newsletter.php:200
        #: app/helpers/biowidgets/Newsletter.php:210
        #: storage/themes/default/overlay/create_newsletter.php:64
        #: storage/themes/default/overlay/create_newsletter.php:124
        #: storage/themes/the23/pages/bio.php:126
        #: storage/themes/the23/pages/bio.php:139
        "Subscribe"=> "",

        #: app/helpers/BioWidgets.php:1204
        "Visitors must subscribe before being redirected"=> "",

        #: app/helpers/BioWidgets.php:1213 storage/themes/the23/pages/bio.php:94
        "Advanced Settings"=> "",

        #: app/helpers/BioWidgets.php:1214 storage/themes/default/qr/edit.php:857
        #: storage/themes/default/user/settings.php:34
        #: storage/themes/default/user/settings.php:81
        #: storage/themes/default/user/settings.php:152
        #: storage/themes/default/user/settings.php:227
        "Save Changes"=> "",

        #: app/helpers/Captcha.php:147 app/helpers/Captcha.php:156
        #: app/helpers/Captcha.php:226 app/helpers/Captcha.php:234
        #: app/helpers/Captcha.php:265 app/helpers/Captcha.php:273
        #: app/helpers/Captcha.php:332 app/helpers/Captcha.php:338
        "The captcha did not validate. Please try again."=> "",

        #: app/helpers/DeepLinks.php:43
        "Airbnb"=> "",

        #: app/helpers/DeepLinks.php:52
        "AliExpress"=> "",

        #: app/helpers/DeepLinks.php:70
        "Apple Music"=> "",

        #: app/helpers/DeepLinks.php:88
        "GrubHub"=> "",

        #: app/helpers/DeepLinks.php:106
        "LinkedIn"=> "",

        #: app/helpers/DeepLinks.php:124
        "Netflix"=> "",

        #: app/helpers/DeepLinks.php:196
        "Walmart"=> "",

        #: app/helpers/DeepLinks.php:214
        "Wolt"=> "",

        #: app/helpers/DeepLinks.php:223
        "Yelp"=> "",

        #: app/helpers/DeepLinks.php:241
        "Zoom"=> "",

        #: app/helpers/Emails.php:123
        "Please verify and approve this url"=> "",

        #: app/helpers/Emails.php:165
        "Please verify your email"=> "",

        #: app/helpers/Emails.php:208
        "Registration has been successful"=> "",

        #: app/helpers/Emails.php:251
        "Password Reset Instructions"=> "",

        #: app/helpers/Emails.php:291
        "Your email has been verified"=> "",

        #: app/helpers/Emails.php:315
        "Your password was changed."=> "",

        #: app/helpers/Emails.php:322
        "Your password was changed. If you did not change your password, please contact us as soon as possible."=> "",

        #: app/helpers/Emails.php:340
        "You just got paid!"=> "",

        #: app/helpers/Emails.php:347
        "You just got paid {amount} via PayPal for being an awesome affiliate!"=> "",

        #: app/helpers/Emails.php:380
        "You have been invited to join our team"=> "",

        #: app/helpers/Emails.php:406
        "Your subscription has been canceled because we have not received any payments on the due date. This might be because your credit card was declined or there is an issue with your account.</p><p>If you would like to reactivate your subscription, please contact us."=> "",

        #: app/helpers/Emails.php:410
        "Your subscription has been canceled"=> "",

        #: app/helpers/Emails.php:442
        "Your trial will end soon!"=> "",

        #: app/helpers/Emails.php:470
        "Admin notification"=> "",

        #: app/helpers/Emails.php:512
        "Please verify your email to reset your 2FA"=> "",

        #: app/helpers/Emails.php:559
        "A new login has been made from a new device"=> "",

        #: app/helpers/Emails.php:591
        "Your login verification code is:"=> "",

        #: app/helpers/Emails.php:593
        "This code will expire in 10 minutes. If you did not attempt to login, please ignore this email."=> "",

        #: app/helpers/Emails.php:594
        "For security reasons, never share this code with anyone."=> "",

        #: app/helpers/Emails.php:598
        "Your Login Verification Code"=> "",

        #: app/helpers/Gate.php:44
        "Inactive Link"=> "",

        #: app/helpers/Gate.php:59
        "Unsafe Link Detected"=> "",

        #: app/helpers/Gate.php:75
        "Link Expired"=> "",

        #: app/helpers/Gate.php:88
        "Enter your password to unlock this link"=> "",

        #: app/helpers/Gate.php:89
        "The access to this link is restricted. Please enter your password to view it."=> "",

        #: app/helpers/Gate.php:98 app/helpers/Gate.php:227 app/helpers/Gate.php:369
        "Adblock Detected"=> "",

        #: app/helpers/Gate.php:98 app/helpers/Gate.php:227 app/helpers/Gate.php:369
        "Please disable Adblock and refresh the page again."=> "",

        #: app/helpers/Gate.php:216 app/helpers/Gate.php:218
        "seconds"=> "",

        #: app/helpers/Gate.php:720 storage/themes/default/user/campaigns.php:55
        #: storage/themes/the23/class/themeSettings.php:329
        #: storage/themes/the23/class/themeSettings.php:341
        "List"=> "",

        #: app/helpers/Permissions.php:120
        "No Role"=> "",

        #: app/helpers/QR.php:71 storage/themes/default/qr/edit.php:91
        #: storage/themes/default/qr/new.php:27 storage/themes/default/qr/new.php:99
        "SMS & Message"=> "",

        #: app/helpers/QR.php:74 storage/themes/default/pages/qr.php:27
        #: storage/themes/default/qr/edit.php:108 storage/themes/default/qr/new.php:36
        #: storage/themes/default/qr/new.php:114 storage/themes/the23/pages/qr.php:28
        "SMS"=> "",

        #: app/helpers/QR.php:77 app/helpers/biowidgets/Phone.php:42
        #: app/helpers/biowidgets/VCard.php:81 app/helpers/biowidgets/WhatsApp.php:39
        #: app/helpers/biowidgets/WhatsAppCall.php:38
        #: storage/themes/default/pages/qr.php:101
        #: storage/themes/default/qr/edit.php:78 storage/themes/default/qr/edit.php:162
        #: storage/themes/default/qr/edit.php:249 storage/themes/default/qr/new.php:35
        #: storage/themes/default/qr/new.php:88 storage/themes/default/qr/new.php:177
        #: storage/themes/default/qr/new.php:262 storage/themes/the23/pages/qr.php:102
        "Phone"=> "",

        #: app/helpers/QR.php:80
        "Wifi"=> "",

        #: app/helpers/QR.php:83 storage/themes/default/qr/new.php:29
        #: storage/themes/default/qr/new.php:246
        "Static vCard"=> "",

        #: app/helpers/QR.php:86 storage/themes/default/pages/qr.php:31
        #: storage/themes/default/qr/edit.php:386 storage/themes/default/qr/new.php:30
        #: storage/themes/default/qr/new.php:353 storage/themes/the23/pages/qr.php:32
        "Event"=> "",

        #: app/helpers/QR.php:89
        "Geolocation"=> "",

        #: app/helpers/QR.php:92 storage/themes/default/qr/edit.php:344
        #: storage/themes/default/qr/edit.php:348 storage/themes/default/qr/new.php:41
        #: storage/themes/default/qr/new.php:394
        "Cryptocurrency"=> "",

        #: app/helpers/QR.php:95 app/helpers/biowidgets/Image.php:44
        #: app/helpers/biowidgets/Image.php:58 storage/themes/default/qr/edit.php:378
        #: storage/themes/default/qr/new.php:39 storage/themes/default/qr/new.php:134
        "File"=> "",

        #: app/helpers/QR.php:101 storage/themes/default/qr/edit.php:423
        #: storage/themes/default/qr/new.php:38 storage/themes/default/qr/new.php:413
        "Application"=> "",

        #: app/helpers/QR.php:140
        "An error internal server error occurred. Please change the QR type."=> "",

        #: app/helpers/QR.php:177 app/helpers/QR.php:190
        "QR data cannot be empty. Please fill the appropriate field."=> "",

        #: app/helpers/QR.php:178 app/helpers/QR.php:192 app/helpers/QR.php:221
        #: app/helpers/QR.php:258 app/helpers/QR.php:278 app/helpers/QR.php:299
        "Text is too long."=> "",

        #: app/helpers/QR.php:191
        "Please enter a valid url."=> "",

        #: app/helpers/QR.php:215
        "Subject is too long."=> "",

        #: app/helpers/QR.php:238 app/helpers/QR.php:240 app/helpers/QR.php:256
        #: app/helpers/QR.php:274 app/helpers/QR.php:297
        "Invalid phone number. Please try again."=> "",

        #: app/helpers/QR.php:376 app/helpers/QR.php:486
        "vCard data cannot be empty. Please fill some fields"=> "",

        #: app/helpers/QR.php:395 app/helpers/QR.php:413
        "Picture must be either a PNG, JPEG (Max 512kb)"=> "",

        #: app/helpers/QR.php:396 app/helpers/QR.php:414
        "Picture must be either a PNG, JPEG (Max 512kb"=> "",

        #: app/helpers/QR.php:530
        "Please enter the Wifi SSID"=> "",

        #: app/helpers/QR.php:575 app/helpers/QR.php:582 app/helpers/QR.php:590
        "Please enter a valid wallet address"=> "",

        #: app/helpers/QR.php:607
        "Please choose a valid file."=> "",

        #: app/helpers/QR.php:609 app/helpers/QR.php:611
        "File must be either a PNG, JPEG, GIF or a PDF (Max 2MB)"=> "",

        #: app/helpers/QR.php:683
        "Event data cannot be empty. Please fill some fields"=> "",

        #: app/helpers/QR.php:700
        "You must add at least 1 link."=> "",

        #: app/helpers/QR.php:706
        "The link to redirect other devices is required."=> "",

        #: app/helpers/QrImagick.php:523
        "An error occurred"=> "",

        #: app/helpers/Slack.php:108
        "You need to allow this application to install the commands on your Slack account."=> "",

        #: app/helpers/biowidgets/Audio.php:41 app/helpers/biowidgets/Countdown.php:42
        #: app/helpers/biowidgets/FeaturedLink.php:64
        #: app/helpers/biowidgets/MusicLink.php:72
        #: storage/themes/default/pages/qr.php:188
        #: storage/themes/default/qr/edit.php:390 storage/themes/default/qr/new.php:357
        #: storage/themes/the23/pages/qr.php:189
        "Title"=> "",

        #: app/helpers/biowidgets/Audio.php:47
        "Artist"=> "",

        #: app/helpers/biowidgets/Audio.php:53
        "Audio File"=> "",

        #: app/helpers/biowidgets/Audio.php:55
        "Acceptable file: MP3 - Max size 5MB"=> "",

        #: app/helpers/biowidgets/Audio.php:60
        "Album Cover"=> "",

        #: app/helpers/biowidgets/Audio.php:62 app/helpers/biowidgets/PDF.php:62
        #: app/helpers/biowidgets/Video.php:40
        "Acceptable files: JPG, JPEG, PNG - Max size 2MB"=> "",

        #: app/helpers/biowidgets/Audio.php:93
        "Audio must be MP3 format and maximum 5MB in size."=> "",

        #: app/helpers/biowidgets/Audio.php:120
        "Cover image must be either a PNG or a JPEG (Max 2MB)."=> "",

        #: app/helpers/biowidgets/Audio.php:176
        "Your browser does not support the audio element."=> "",

        #: app/helpers/biowidgets/Calendly.php:44
        #: app/helpers/biowidgets/Eventbrite.php:46
        #: app/helpers/biowidgets/PayPal.php:52 app/helpers/biowidgets/Phone.php:48
        #: app/helpers/biowidgets/Pinterest.php:43 app/helpers/biowidgets/Reddit.php:44
        #: app/helpers/biowidgets/Typeform.php:39 app/helpers/biowidgets/VCard.php:149
        #: app/helpers/biowidgets/WhatsApp.php:45
        #: app/helpers/biowidgets/WhatsAppCall.php:44
        "Label"=> "",

        #: app/helpers/biowidgets/Calendly.php:65
        #: app/helpers/biowidgets/Calendly.php:94
        "Please enter a valid Calendly link"=> "",

        #: app/helpers/biowidgets/Carousel.php:36
        "Carousel Images"=> "",

        #: app/helpers/biowidgets/Carousel.php:36
        "Max 5 images"=> "",

        #: app/helpers/biowidgets/Carousel.php:40
        "Drag and drop images here"=> "",

        #: app/helpers/biowidgets/Carousel.php:41
        "or click to browse"=> "",

        #: app/helpers/biowidgets/Carousel.php:43
        "Select Images"=> "",

        #: app/helpers/biowidgets/Carousel.php:44
        "Formats: {f} - Max size: {s}kb"=> "",

        #: app/helpers/biowidgets/Carousel.php:120
        "Maximum 5 images allowed"=> "",

        #: app/helpers/biowidgets/Carousel.php:133
        "Invalid file format. Allowed: {f}"=> "",

        #: app/helpers/biowidgets/Carousel.php:143
        "File size exceeds maximum of {s}kb"=> "",

        #: app/helpers/biowidgets/Carousel.php:169
        "Optional link"=> "",

        #: app/helpers/biowidgets/Carousel.php:172
        "Replace"=> "",

        #: app/helpers/biowidgets/Carousel.php:173 app/helpers/biowidgets/Image.php:44
        #: app/helpers/biowidgets/Image.php:58 app/helpers/biowidgets/PDF.php:52
        #: app/helpers/biowidgets/PDF.php:59
        #: storage/themes/default/class/themeSettings.php:169
        #: storage/themes/default/class/themeSettings.php:192
        #: storage/themes/default/teams/index.php:65
        #: storage/themes/the23/class/themeSettings.php:376
        #: storage/themes/the23/class/themeSettings.php:399
        "Remove"=> "",

        #: app/helpers/biowidgets/Carousel.php:262
        #: app/helpers/biowidgets/Carousel.php:285 app/helpers/biowidgets/Image.php:109
        #: app/helpers/biowidgets/Image.php:140
        #: app/helpers/biowidgets/MusicLink.php:153
        #: app/helpers/biowidgets/Product.php:113 app/helpers/biowidgets/VCard.php:239
        "Image must be the following formats {f} and be less than {s}kb."=> "",

        #: app/helpers/biowidgets/Contact.php:58
        #: app/helpers/biowidgets/Newsletter.php:70
        #: storage/themes/default/overlay/create_contact.php:57
        #: storage/themes/default/overlay/create_newsletter.php:43
        #: storage/themes/default/overlay/edit_contact.php:57
        #: storage/themes/default/overlay/edit_newsletter.php:43
        "Disclaimer"=> "",

        #: app/helpers/biowidgets/Contact.php:58 app/helpers/biowidgets/Image.php:50
        #: app/helpers/biowidgets/Image.php:64 app/helpers/biowidgets/Newsletter.php:64
        #: app/helpers/biowidgets/Newsletter.php:70
        "Optional"=> "",

        #: app/helpers/biowidgets/Contact.php:60
        #: app/helpers/biowidgets/Newsletter.php:72
        #: storage/themes/default/overlay/create_contact.php:59
        #: storage/themes/default/overlay/create_newsletter.php:45
        #: storage/themes/default/overlay/edit_contact.php:59
        #: storage/themes/default/overlay/edit_newsletter.php:45
        "You can add your own disclaimer and a checkbox will show up requiring users to check before submitting."=> "",

        #: app/helpers/biowidgets/Contact.php:86 app/helpers/biowidgets/Link.php:477
        #: app/helpers/biowidgets/PayPal.php:107
        #: storage/themes/the23/pages/contact.php:52
        #: storage/themes/the23/pages/report.php:14
        "Please enter a valid email"=> "",

        #: app/helpers/biowidgets/Contact.php:181
        "Message sent successfully."=> "",

        #: app/helpers/biowidgets/Contact.php:214
        #: storage/themes/default/overlay/create_contact.php:99
        #: storage/themes/default/overlay/create_contact.php:180
        #: storage/themes/default/pages/contact.php:35
        #: storage/themes/default/pages/report.php:40
        #: storage/themes/the23/pages/contact.php:64
        #: storage/themes/the23/pages/report.php:33
        "Send"=> "",

        #: app/helpers/biowidgets/Countdown.php:44
        "Optional title displayed above the countdown"=> "",

        #: app/helpers/biowidgets/Countdown.php:47
        "Target Date"=> "",

        #: app/helpers/biowidgets/Countdown.php:49
        "Select the date and time when the countdown expires"=> "",

        #: app/helpers/biowidgets/Countdown.php:52
        "Expired Message"=> "",

        #: app/helpers/biowidgets/Countdown.php:54
        "This message will be displayed when the countdown expires"=> "",

        #: app/helpers/biowidgets/Countdown.php:92
        "{b} Error: Please select a target date."=> "",

        #: app/helpers/biowidgets/Countdown.php:96
        "{b} Error: Please enter a valid date."=> "",

        #: app/helpers/biowidgets/Countdown.php:123
        "The countdown has expired."=> "",

        #: app/helpers/biowidgets/Countdown.php:140
        "Days"=> "",

        #: app/helpers/biowidgets/Countdown.php:146
        "Hours"=> "",

        #: app/helpers/biowidgets/Countdown.php:152
        "Minutes"=> "",

        #: app/helpers/biowidgets/Countdown.php:158
        #: storage/themes/default/gates/custom.php:15
        #: storage/themes/the23/gates/custom.php:16
        "Seconds"=> "",

        #: app/helpers/biowidgets/Divider.php:44 app/helpers/biowidgets/Heading.php:44
        #: storage/themes/default/bio/edit.php:132
        "Style"=> "",

        #: app/helpers/biowidgets/Divider.php:46
        "Solid"=> "",

        #: app/helpers/biowidgets/Divider.php:47
        "Dotted"=> "",

        #: app/helpers/biowidgets/Divider.php:48
        "Dashed"=> "",

        #: app/helpers/biowidgets/Divider.php:49
        "Double"=> "",

        #: app/helpers/biowidgets/Divider.php:53
        "Height"=> "",

        #: app/helpers/biowidgets/Divider.php:57 app/helpers/biowidgets/Heading.php:63
        "Color"=> "",

        #: app/helpers/biowidgets/Eventbrite.php:40
        "Event ID"=> "",

        #: app/helpers/biowidgets/Eventbrite.php:61
        "Please enter a valid EventBrite ID"=> "",

        #: app/helpers/biowidgets/Eventbrite.php:86
        #: app/helpers/biowidgets/OpenTable.php:96
        "{b} Error: Please enter a valid ID"=> "",

        #: app/helpers/biowidgets/Eventbrite.php:103
        "Book now"=> "",

        #: app/helpers/biowidgets/FAQs.php:45 app/helpers/biowidgets/FAQs.php:72
        #: storage/themes/default/overlay/create_poll.php:25
        #: storage/themes/default/overlay/edit_poll.php:25
        "Question"=> "",

        #: app/helpers/biowidgets/FAQs.php:52 app/helpers/biowidgets/FAQs.php:79
        "Answer"=> "",

        #: app/helpers/biowidgets/FAQs.php:59
        "Add FAQ"=> "",

        #: app/helpers/biowidgets/Facebook.php:55
        #: app/helpers/biowidgets/Facebook.php:83
        "Please enter a valid Facebook Post link"=> "",

        #: app/helpers/biowidgets/FeaturedLink.php:57
        #: app/helpers/biowidgets/Link.php:81
        "Upload Image"=> "",

        #: app/helpers/biowidgets/FeaturedLink.php:59
        #: app/helpers/biowidgets/FeaturedLink.php:60
        #: app/helpers/biowidgets/Image.php:45 app/helpers/biowidgets/Image.php:59
        #: app/helpers/biowidgets/Link.php:83 app/helpers/biowidgets/Link.php:84
        "Image must be one the following formats {f} and be less than {s}kb."=> "",

        #: app/helpers/biowidgets/FeaturedLink.php:72
        #: app/helpers/biowidgets/Link.php:104
        "New window"=> "",

        #: app/helpers/biowidgets/FeaturedLink.php:110
        #: app/helpers/biowidgets/Link.php:208
        "{b} Error: Please enter a valid URL."=> "",

        #: app/helpers/biowidgets/FeaturedLink.php:125
        #: app/helpers/biowidgets/FeaturedLink.php:147
        #: app/helpers/biowidgets/FeaturedLink.php:169
        #: app/helpers/biowidgets/Link.php:223 app/helpers/biowidgets/Link.php:245
        #: app/helpers/biowidgets/Link.php:267 app/helpers/biowidgets/MusicLink.php:221
        #: app/helpers/biowidgets/MusicLink.php:243
        #: app/helpers/biowidgets/MusicLink.php:267
        "{b} Error: This link cannot be accepted because either it is invalid or it might not be safe."=> "",

        #: app/helpers/biowidgets/FeaturedLink.php:198
        #: app/helpers/biowidgets/Link.php:296
        "Image must be either a GIF, PNG or a JPEG (Max {s}kb)."=> "",

        #: app/helpers/biowidgets/GoogleMaps.php:38
        #: app/helpers/biowidgets/VCard.php:117 storage/themes/default/pages/qr.php:121
        #: storage/themes/default/pricing/checkout.php:64
        #: storage/themes/default/qr/edit.php:182
        #: storage/themes/default/qr/edit.php:269 storage/themes/default/qr/new.php:197
        #: storage/themes/default/qr/new.php:282
        #: storage/themes/default/user/settings.php:119
        #: storage/themes/default/user/verification.php:40
        #: storage/themes/the23/pages/qr.php:122
        #: storage/themes/the23/pricing/checkout.php:69
        "Address"=> "",

        #: app/helpers/biowidgets/Instagram.php:55
        #: app/helpers/biowidgets/Instagram.php:83
        "Please enter a valid Instagram Post link"=> "",

        #: app/helpers/biowidgets/Intercom.php:30 app/helpers/biowidgets/TawkTo.php:29
        "You can only have this widget once."=> "",

        #: app/helpers/biowidgets/Intercom.php:45 app/helpers/biowidgets/TawkTo.php:43
        #: app/helpers/biowidgets/Tidio.php:43
        "You already have a chat widget"=> "",

        #: app/helpers/biowidgets/Intercom.php:68
        "App ID"=> "",

        #: app/helpers/biowidgets/Intercom.php:70
        "The App ID can be found in Settings > General > Workspace name & time zone"=> "",

        #: app/helpers/biowidgets/Intercom.php:93
        "Please enter a valid Intercom App ID"=> "",

        #: app/helpers/biowidgets/Itunes.php:53 app/helpers/biowidgets/Itunes.php:81
        "Please enter a valid Apple Music link"=> "",

        #: app/helpers/biowidgets/Link.php:58
        "Icon"=> "",

        #: app/helpers/biowidgets/Link.php:60
        "None "=> "",

        #: app/helpers/biowidgets/Link.php:61
        "Icon/Emoji"=> "",

        #: app/helpers/biowidgets/Link.php:93
        "Featured"=> "",

        #: app/helpers/biowidgets/Link.php:113
        "Animation"=> "",

        #: app/helpers/biowidgets/Link.php:115 storage/themes/default/bio/edit.php:341
        #: storage/themes/default/bio/edit.php:351
        #: storage/themes/default/domains/index.php:48
        #: storage/themes/default/domains/index.php:51
        #: storage/themes/default/partials/shortener.php:81
        #: storage/themes/default/partials/shortenermodal.php:78
        #: storage/themes/default/user/edit.php:610
        #: storage/themes/default/user/index.php:272
        #: storage/themes/default/user/links.php:221
        "None"=> "",

        #: app/helpers/biowidgets/Link.php:116
        "Shake"=> "",

        #: app/helpers/biowidgets/Link.php:117
        "Scale"=> "",

        #: app/helpers/biowidgets/Link.php:118
        "Jello"=> "",

        #: app/helpers/biowidgets/Link.php:119
        "Vibrate"=> "",

        #: app/helpers/biowidgets/Link.php:120
        "Wobble"=> "",

        #: app/helpers/biowidgets/Link.php:153 storage/themes/default/bio/edit.php:106
        #: storage/themes/default/bio/edit.php:123
        "Please enter a valid link"=> "",

        #: app/helpers/biowidgets/Link.php:196
        "{b} Error: You can either enable Sensitive Content or Subscribe gate but not both."=> "",

        #: app/helpers/biowidgets/Link.php:390
        "You have been subscribed successfully"=> "",

        #: app/helpers/biowidgets/Link.php:441
        "This link may contain inappropriate content not suitable for all ages."=> "",

        #: app/helpers/biowidgets/Link.php:471
        "Subscribe to unlock"=> "",

        #: app/helpers/biowidgets/Link.php:484
        "By subscribing, I agree to the terms and conditions and privacy policy."=> "",

        #: app/helpers/biowidgets/LinkedIn.php:55
        #: app/helpers/biowidgets/LinkedIn.php:83
        "Please enter a valid LinkedIn post link"=> "",

        #: app/helpers/biowidgets/LinkedIn.php:95
        #: app/helpers/biowidgets/LinkedIn.php:101
        #: app/helpers/biowidgets/LinkedIn.php:105
        #: app/helpers/biowidgets/LinkedIn.php:111
        "LinkedIn post cannot be retrieved. Please make sure the post is public and try again."=> "",

        #: app/helpers/biowidgets/LinkedIn.php:174
        "Follow"=> "",

        #: app/helpers/biowidgets/LinkedIn.php:189
        "View on LinkedIn"=> "",

        #: app/helpers/biowidgets/MusicLink.php:60
        #: storage/themes/default/qr/bulk.php:421 storage/themes/default/qr/new.php:842
        #: storage/themes/default/splash/edit.php:4
        #: storage/themes/default/splash/edit.php:91
        "Preview"=> "",

        #: app/helpers/biowidgets/MusicLink.php:67
        "Upload an image for the song (e.g., album cover)."=> "",

        #: app/helpers/biowidgets/MusicLink.php:78
        "Headline"=> "",

        #: app/helpers/biowidgets/MusicLink.php:82
        #: storage/themes/default/bio/edit.php:18
        #: storage/themes/default/bio/edit.php:130
        #: storage/themes/default/pages/qr.php:261
        #: storage/themes/default/qr/bulk.php:125
        #: storage/themes/default/qr/edit.php:539 storage/themes/default/qr/new.php:529
        #: storage/themes/the23/pages/qr.php:262
        "Design"=> "",

        #: app/helpers/biowidgets/MusicLink.php:95
        "Platform Links"=> "",

        #: app/helpers/biowidgets/MusicLink.php:107
        #: storage/themes/default/overlay/create_coupon.php:39
        #: storage/themes/default/overlay/create_message.php:53
        #: storage/themes/default/overlay/edit_coupon.php:39
        #: storage/themes/default/overlay/edit_message.php:53
        "Button Text"=> "",

        #: app/helpers/biowidgets/MusicLink.php:259
        "{b} Error: Please enter a valid url"=> "",

        #: app/helpers/biowidgets/MusicLink.php:332
        #: app/helpers/biowidgets/MusicLink.php:344
        #: storage/themes/the23/pages/bio.php:113
        "Listen"=> "",

        #: app/helpers/biowidgets/Newsletter.php:64 app/helpers/biowidgets/PDF.php:46
        #: app/helpers/biowidgets/Product.php:60 storage/themes/default/invoice.php:72
        #: storage/themes/default/overlay/create_coupon.php:92
        #: storage/themes/default/overlay/create_newsletter.php:118
        #: storage/themes/default/overlay/edit_newsletter.php:118
        #: storage/themes/default/pages/api.php:286
        #: storage/themes/default/pages/qr.php:192
        #: storage/themes/default/partials/shortener.php:104
        #: storage/themes/default/partials/shortenermodal.php:101
        #: storage/themes/default/qr/edit.php:394 storage/themes/default/qr/new.php:361
        #: storage/themes/default/user/channel.php:119
        #: storage/themes/default/user/channels.php:94
        #: storage/themes/default/user/channels.php:136
        #: storage/themes/default/user/developers.php:16
        #: storage/themes/default/user/developers.php:78
        #: storage/themes/default/user/edit.php:601
        #: storage/themes/the23/pages/api.php:279 storage/themes/the23/pages/qr.php:193
        "Description"=> "",

        #: app/helpers/biowidgets/Newsletter.php:81 app/helpers/payments/Bank.php:51
        #: app/helpers/payments/Mollie.php:56 app/helpers/payments/Paddle.php:67
        #: app/helpers/payments/PaddleBilling.php:59
        #: app/helpers/payments/PayStack.php:62 app/helpers/payments/Paypal.php:53
        #: app/helpers/payments/PaypalApi.php:55 app/helpers/payments/Polar.php:57
        #: app/helpers/payments/Stripe.php:56 storage/themes/default/teams/index.php:57
        "Enable"=> "",

        #: app/helpers/biowidgets/Newsletter.php:85
        "Select Mailchimp List"=> "",

        #: app/helpers/biowidgets/Newsletter.php:87
        "Select a list"=> "",

        #: app/helpers/biowidgets/Newsletter.php:92
        "Subscribers will be automatically added to the selected Mailchimp list."=> "",

        #: app/helpers/biowidgets/Newsletter.php:127
        "Mailchimp integration is not available in your plan."=> "",

        #: app/helpers/biowidgets/Newsletter.php:130
        "Please configure your Mailchimp API key in Integrations first."=> "",

        #: app/helpers/biowidgets/Newsletter.php:133
        "Please select a Mailchimp list."=> "",

        #: app/helpers/biowidgets/OpenSea.php:54 app/helpers/biowidgets/OpenSea.php:82
        "Please enter a valid OpenSea NFT link"=> "",

        #: app/helpers/biowidgets/OpenTable.php:48
        "Restaurant ID"=> "",

        #: app/helpers/biowidgets/OpenTable.php:54
        #: storage/themes/default/stats/activity.php:24
        #: storage/themes/default/user/activity.php:16
        "Language"=> "",

        #: app/helpers/biowidgets/OpenTable.php:71
        "Please enter a valid OpenTable restaurant ID"=> "",

        #: app/helpers/biowidgets/PDF.php:40
        "Document Title"=> "",

        #: app/helpers/biowidgets/PDF.php:46
        #: storage/themes/default/user/campaigns.php:113
        #: storage/themes/default/user/campaigns.php:153
        "optional"=> "",

        #: app/helpers/biowidgets/PDF.php:52
        "PDF File"=> "",

        #: app/helpers/biowidgets/PDF.php:54
        "Acceptable file: PDF - Max size 10MB"=> "",

        #: app/helpers/biowidgets/PDF.php:59
        "Thumbnail"=> "",

        #: app/helpers/biowidgets/PDF.php:93
        "PDF must be in PDF format and maximum 10MB in size."=> "",

        #: app/helpers/biowidgets/PDF.php:120
        "Thumbnail must be either a PNG or a JPEG (Max 2MB)."=> "",

        #: app/helpers/biowidgets/PayPal.php:66 app/helpers/biowidgets/Product.php:66
        #: storage/themes/default/invoice.php:74
        #: storage/themes/default/user/billing.php:36
        #: storage/themes/default/user/withdrawals.php:9
        "Amount"=> "",

        #: app/helpers/biowidgets/PayPal.php:72
        "Currency"=> "",

        #: app/helpers/biowidgets/Pinterest.php:64
        #: app/helpers/biowidgets/Pinterest.php:93
        "Please enter a valid Pinterest link"=> "",

        #: app/helpers/biowidgets/Reddit.php:65 app/helpers/biowidgets/Reddit.php:94
        "Please enter a valid Reddit link"=> "",

        #: app/helpers/biowidgets/Reddit.php:132
        "Karma"=> "",

        #: app/helpers/biowidgets/Reddit.php:133
        "Member since"=> "",

        #: app/helpers/biowidgets/Reddit.php:135
        "Visit Profile"=> "",

        #: app/helpers/biowidgets/Rss.php:54 app/helpers/biowidgets/Rss.php:81
        #: app/helpers/biowidgets/Rss.php:83
        "Please enter a valid RSS Feed link"=> "",

        #: app/helpers/biowidgets/Snapchat.php:38
        "Insert a link to a Snapchat Spotlight, Profile or Lens."=> "",

        #: app/helpers/biowidgets/Snapchat.php:51
        #: app/helpers/biowidgets/Snapchat.php:79
        "Please enter a valid Snapchat post link"=> "",

        #: app/helpers/biowidgets/SoundCloud.php:51
        #: app/helpers/biowidgets/SoundCloud.php:79
        "Please enter a valid SoundCloud link"=> "",

        #: app/helpers/biowidgets/Spotify.php:39
        "You can add a link to a spotify song, a playlist or a podcast."=> "",

        #: app/helpers/biowidgets/Spotify.php:52 app/helpers/biowidgets/Spotify.php:80
        "Please enter a valid Spotify track, playlist or podcast link"=> "",

        #: app/helpers/biowidgets/Tagline.php:29
        "You already have a tagline widget."=> "",

        #: app/helpers/biowidgets/TawkTo.php:62
        "Property ID"=> "",

        #: app/helpers/biowidgets/TawkTo.php:64
        "Enter your Tawk.to Property ID"=> "",

        #: app/helpers/biowidgets/TawkTo.php:67
        "Widget ID"=> "",

        #: app/helpers/biowidgets/TawkTo.php:69
        "Enter your Tawk.to Widget ID"=> "",

        #: app/helpers/biowidgets/TawkTo.php:94
        "Please enter a valid Property ID"=> "",

        #: app/helpers/biowidgets/TawkTo.php:98
        "Please enter a valid Widget ID"=> "",

        #: app/helpers/biowidgets/Text.php:66 app/helpers/biowidgets/WhatsApp.php:77
        "{b} Error: Text is too long."=> "",

        #: app/helpers/biowidgets/Threads.php:51 app/helpers/biowidgets/Threads.php:79
        "Please enter a valid Threads post link"=> "",

        #: app/helpers/biowidgets/Tidio.php:29
        "You can only have this widget once"=> "",

        #: app/helpers/biowidgets/Tidio.php:61
        "Project ID"=> "",

        #: app/helpers/biowidgets/Tidio.php:63
        "Enter your Tidio project ID. You caan get your Project ID from Tidio > Settings > Developer > Project data"=> "",

        #: app/helpers/biowidgets/Tidio.php:87
        "Please enter a valid project ID"=> "",

        #: app/helpers/biowidgets/TikTok.php:50 app/helpers/biowidgets/TikTok.php:78
        "Please enter a valid TikTok video link"=> "",

        #: app/helpers/biowidgets/TikTokProfile.php:50
        #: app/helpers/biowidgets/TikTokProfile.php:78
        "Please enter a valid TikTok profile link"=> "",

        #: app/helpers/biowidgets/Twitter.php:56 app/helpers/biowidgets/Twitter.php:86
        "Please enter a valid Tweet link"=> "",

        #: app/helpers/biowidgets/Typeform.php:60
        #: app/helpers/biowidgets/Typeform.php:88
        "Please enter a valid Typeform link"=> "",

        #: app/helpers/biowidgets/Typeform.php:119
        "Open in a new tab"=> "",

        #: app/helpers/biowidgets/VCard.php:55 storage/themes/default/qr/edit.php:146
        #: storage/themes/default/qr/new.php:161
        "Picture"=> "",

        #: app/helpers/biowidgets/VCard.php:55 storage/themes/default/bio/index.php:160
        "(optional)"=> "",

        #: app/helpers/biowidgets/VCard.php:61 storage/themes/default/pages/qr.php:89
        #: storage/themes/default/qr/edit.php:150
        #: storage/themes/default/qr/edit.php:237 storage/themes/default/qr/new.php:165
        #: storage/themes/default/qr/new.php:250 storage/themes/the23/pages/qr.php:90
        "First Name"=> "",

        #: app/helpers/biowidgets/VCard.php:67 storage/themes/default/pages/qr.php:93
        #: storage/themes/default/qr/edit.php:154
        #: storage/themes/default/qr/edit.php:241 storage/themes/default/qr/new.php:169
        #: storage/themes/default/qr/new.php:254 storage/themes/the23/pages/qr.php:94
        "Last Name"=> "",

        #: app/helpers/biowidgets/VCard.php:89
        "Cellphone"=> "",

        #: app/helpers/biowidgets/VCard.php:95 storage/themes/default/pages/qr.php:109
        #: storage/themes/default/qr/edit.php:170
        #: storage/themes/default/qr/edit.php:257 storage/themes/default/qr/new.php:185
        #: storage/themes/default/qr/new.php:270 storage/themes/the23/pages/qr.php:110
        "Fax"=> "",

        #: app/helpers/biowidgets/VCard.php:103
        #: storage/themes/default/partials/footer.php:67
        #: storage/themes/default/pricing/checkout.php:46
        #: storage/themes/the23/pricing/checkout.php:52
        "Company"=> "",

        #: app/helpers/biowidgets/VCard.php:109
        "Site"=> "",

        #: app/helpers/biowidgets/VCard.php:123 storage/themes/default/pages/qr.php:130
        #: storage/themes/default/pricing/checkout.php:70
        #: storage/themes/default/qr/edit.php:192
        #: storage/themes/default/qr/edit.php:279 storage/themes/default/qr/new.php:207
        #: storage/themes/default/qr/new.php:292
        #: storage/themes/default/user/settings.php:125
        #: storage/themes/default/user/verification.php:46
        #: storage/themes/the23/pages/qr.php:131
        #: storage/themes/the23/pricing/checkout.php:75
        "City"=> "",

        #: app/helpers/biowidgets/VCard.php:131 storage/themes/default/pages/qr.php:134
        #: storage/themes/default/qr/edit.php:196
        #: storage/themes/default/qr/edit.php:283 storage/themes/default/qr/new.php:211
        #: storage/themes/default/qr/new.php:296 storage/themes/the23/pages/qr.php:135
        "State"=> "",

        #: app/helpers/biowidgets/VCard.php:137
        "Zip"=> "",

        #: app/helpers/biowidgets/VCard.php:143 storage/themes/default/pages/qr.php:142
        #: storage/themes/default/pricing/checkout.php:84
        #: storage/themes/default/qr/edit.php:204
        #: storage/themes/default/qr/edit.php:291 storage/themes/default/qr/new.php:219
        #: storage/themes/default/qr/new.php:304
        #: storage/themes/default/stats/activity.php:15
        #: storage/themes/default/user/activity.php:7
        #: storage/themes/default/user/settings.php:139
        #: storage/themes/default/user/verification.php:60
        #: storage/themes/the23/pages/qr.php:143
        #: storage/themes/the23/pricing/checkout.php:89
        "Country"=> "",

        #: app/helpers/biowidgets/VCard.php:154
        "Custom Links"=> "",

        #: app/helpers/biowidgets/VCard.php:155 storage/themes/default/bio/edit.php:106
        #: storage/themes/default/bio/index.php:267
        #: storage/themes/default/partials/shortener.php:184
        #: storage/themes/default/partials/shortener.php:227
        #: storage/themes/default/partials/shortener.php:285
        #: storage/themes/default/partials/shortener.php:314
        #: storage/themes/default/partials/shortener.php:401
        #: storage/themes/default/partials/shortener.php:428
        #: storage/themes/default/qr/index.php:200
        #: storage/themes/default/user/edit.php:72
        #: storage/themes/default/user/edit.php:172
        #: storage/themes/default/user/edit.php:265
        #: storage/themes/default/user/edit.php:317
        #: storage/themes/default/user/edit.php:411
        #: storage/themes/default/user/edit.php:481
        #: storage/themes/default/user/index.php:282
        #: storage/themes/default/user/index.php:310
        #: storage/themes/default/user/index.php:342
        #: storage/themes/default/user/links.php:231
        #: storage/themes/default/user/links.php:259
        #: storage/themes/default/user/links.php:291
        "Add"=> "",

        #: app/helpers/biowidgets/VCard.php:369
        "Download vCard"=> "",

        #: app/helpers/biowidgets/Video.php:33
        "Video File"=> "",

        #: app/helpers/biowidgets/Video.php:35
        "Acceptable file: MP4 - Max size 10MB"=> "",

        #: app/helpers/biowidgets/Video.php:38
        "Poster Image"=> "",

        #: app/helpers/biowidgets/Video.php:70
        "Video must be MP4 format and maximum 10MB in size."=> "",

        #: app/helpers/biowidgets/Video.php:99
        "Poster image must be either a PNG or a JPEG (Max 2MB)."=> "",

        #: app/helpers/biowidgets/Video.php:141
        "Your browser does not support the video tag."=> "",

        #: app/helpers/biowidgets/VideoEmbed.php:33
        "Video URL"=> "",

        #: app/helpers/biowidgets/VideoEmbed.php:35
        "Supported platforms: YouTube, Vimeo, Dailymotion, Facebook Video, Kick, Twitch"=> "",

        #: app/helpers/biowidgets/VideoEmbed.php:59
        "Please enter a valid video URL"=> "",

        #: app/helpers/biowidgets/VideoEmbed.php:87
        "Please enter a valid video URL from supported platforms"=> "",

        #: app/helpers/biowidgets/WhatsApp.php:77
        "Whatsapp Message"=> "",

        #: app/helpers/biowidgets/YouTube.php:38
        "You can add a link to a video or a playlist."=> "",

        #: app/helpers/biowidgets/YouTube.php:51 app/helpers/biowidgets/YouTube.php:79
        "Please enter a valid Youtube video or playlist link"=> "",

        #: app/helpers/payments/Bank.php:48 app/traits/Payments.php:218
        #: app/traits/Payments.php:219
        "Bank Transfer"=> "",

        #: app/helpers/payments/Bank.php:53
        "Transfer payments via your bank."=> "",

        #: app/helpers/payments/Bank.php:56
        "Bank Info"=> "",

        #: app/helpers/payments/Bank.php:58
        "Enter the full information where your users can send payments to via their bank."=> "",

        #: app/helpers/payments/Bank.php:80
        "Bank Information"=> "",

        #: app/helpers/payments/Bank.php:82
        "Transfer Reference"=> "",

        #: app/helpers/payments/Bank.php:83
        "Please use the following reference: {u}"=> "",

        #: app/helpers/payments/Bank.php:99 app/helpers/payments/Bank.php:104
        #: app/helpers/payments/Mollie.php:102 app/helpers/payments/Mollie.php:106
        #: app/helpers/payments/Mollie.php:225 app/helpers/payments/Paddle.php:178
        #: app/helpers/payments/Paddle.php:182 app/helpers/payments/Paddle.php:291
        #: app/helpers/payments/PaddleBilling.php:163
        #: app/helpers/payments/PaddleBilling.php:166
        #: app/helpers/payments/PaddleBilling.php:175
        #: app/helpers/payments/PaddleBilling.php:183
        #: app/helpers/payments/PayStack.php:123 app/helpers/payments/PayStack.php:127
        #: app/helpers/payments/PayStack.php:280 app/helpers/payments/PayStack.php:296
        #: app/helpers/payments/PayStack.php:411 app/helpers/payments/Paypal.php:95
        #: app/helpers/payments/Paypal.php:99 app/helpers/payments/PaypalApi.php:102
        #: app/helpers/payments/PaypalApi.php:106 app/helpers/payments/Polar.php:126
        #: app/helpers/payments/Polar.php:130 app/helpers/payments/Polar.php:315
        #: app/helpers/payments/Stripe.php:201 app/helpers/payments/Stripe.php:205
        #: app/helpers/payments/Stripe.php:237 app/helpers/payments/Stripe.php:279
        #: app/helpers/payments/Stripe.php:282 app/helpers/payments/Stripe.php:315
        #: app/helpers/payments/Stripe.php:387 app/helpers/payments/Stripe.php:406
        #: app/helpers/payments/Stripe.php:439 app/helpers/payments/Stripe.php:511
        #: app/helpers/payments/Stripe.php:1112 app/helpers/payments/Stripe.php:1115
        #: app/helpers/payments/Stripe.php:1203
        "An error occurred, please try again. You have not been charged."=> "",

        #: app/helpers/payments/Bank.php:108 app/helpers/payments/Mollie.php:115
        #: app/helpers/payments/Polar.php:138 app/helpers/payments/Stripe.php:213
        #: app/helpers/payments/Stripe.php:1075
        "First month"=> "",

        #: app/helpers/payments/Bank.php:114 app/helpers/payments/Mollie.php:121
        #: app/helpers/payments/Polar.php:144 app/helpers/payments/Stripe.php:219
        #: app/helpers/payments/Stripe.php:1081
        "First year"=> "",

        #: app/helpers/payments/Bank.php:121 app/helpers/payments/Mollie.php:128
        #: app/helpers/payments/Paddle.php:200 app/helpers/payments/PayStack.php:149
        #: app/helpers/payments/Polar.php:151 app/helpers/payments/Stripe.php:226
        #: app/helpers/payments/Stripe.php:1088
        #: storage/themes/default/pricing/index.php:18
        #: storage/themes/the23/pricing/checkout.php:111
        #: storage/themes/the23/pricing/index.php:20
        "Lifetime"=> "",

        #: app/helpers/payments/Bank.php:195
        "Your subscription is currently pending. Once we receive the money, we will activate your subscription."=> "",

        #: app/helpers/payments/Mollie.php:53
        "Mollie Payments"=> "",

        #: app/helpers/payments/Mollie.php:58
        "Collect payments securely with Mollie."=> "",

        #: app/helpers/payments/Mollie.php:62
        "Mollie API Key"=> "",

        #: app/helpers/payments/Mollie.php:64
        "Get your API key from your Mollie account."=> "",

        #: app/helpers/payments/Paddle.php:64
        "Paddle Classic"=> "",

        #: app/helpers/payments/Paddle.php:69
        "Collect payments securely with Paddle. This payment method is not available for new Paddle accounts. You need to use Paddle Billing instead."=> "",

        #: app/helpers/payments/Paddle.php:73
        "Paddle Vendor ID "=> "",

        #: app/helpers/payments/Paddle.php:75
        "Get your vendor id from here once logged in <a href=\"https://vendors.paddle.com/authentication\" target=\"_blank\">click here</a>"=> "",

        #: app/helpers/payments/Paddle.php:78
        "Paddle API Key"=> "",

        #: app/helpers/payments/Paddle.php:80
        "Get your paddle keys from here once logged in <a href=\"https://vendors.paddle.com/authentication\" target=\"_blank\">click here</a>"=> "",

        #: app/helpers/payments/Paddle.php:83
        "Paddle Public Key"=> "",

        #: app/helpers/payments/Paddle.php:85
        "Get your paddle public key from here once logged in <a href=\"https://vendors.paddle.com/public-key\" target=\"_blank\">click here</a>"=> "",

        #: app/helpers/payments/Paddle.php:88 app/helpers/payments/PaddleBilling.php:75
        #: app/helpers/payments/PayStack.php:78 app/helpers/payments/Polar.php:86
        #: app/helpers/payments/Stripe.php:93
        "Webhook URL"=> "",

        #: app/helpers/payments/Paddle.php:90
        "You can add your webhooks <a href=\"https://vendors.paddle.com/alerts-webhooks\" target=\"_blank\">here</a>. For more info, please check the docs."=> "",

        #: app/helpers/payments/Paddle.php:93
        "Monthly Plan ID"=> "",

        #: app/helpers/payments/Paddle.php:95
        "You need to create a single monthly plan manually and insert the plan ID here. View documentation for more information."=> "",

        #: app/helpers/payments/Paddle.php:98
        "Yearly Plan ID"=> "",

        #: app/helpers/payments/Paddle.php:100
        "You need to create a single yearly plan manually and insert the plan ID here. View documentation for more information."=> "",

        #: app/helpers/payments/Paddle.php:106
        "You cannot enable both Stripe and Paddle at the same time because they both work in the same way. You must choose one."=> "",

        #: app/helpers/payments/Paddle.php:188 app/helpers/payments/PayStack.php:135
        #: storage/themes/default/pricing/index.php:21
        #: storage/themes/the23/pricing/checkout.php:116
        #: storage/themes/the23/pricing/index.php:23
        "Monthly"=> "",

        #: app/helpers/payments/Paddle.php:194 app/helpers/payments/PayStack.php:142
        #: storage/themes/default/pricing/index.php:25
        #: storage/themes/the23/pricing/checkout.php:121
        #: storage/themes/the23/pricing/index.php:27
        "Yearly"=> "",

        #: app/helpers/payments/Paddle.php:370 app/helpers/payments/PayStack.php:338
        #: app/helpers/payments/Polar.php:493 app/helpers/payments/Stripe.php:549
        #: app/helpers/payments/Stripe.php:741
        "You have a new Subscriber"=> "",

        #: app/helpers/payments/Paddle.php:543 app/helpers/payments/PayStack.php:540
        #: app/helpers/payments/Paypal.php:145 app/helpers/payments/Paypal.php:297
        #: app/helpers/payments/PaypalApi.php:413
        "Your payment has been canceled."=> "",

        #: app/helpers/payments/PaddleBilling.php:56
        "Paddle Billing"=> "",

        #: app/helpers/payments/PaddleBilling.php:61
        "Collect payments securely with Paddle Billing."=> "",

        #: app/helpers/payments/PaddleBilling.php:65
        "Client-side Token"=> "",

        #: app/helpers/payments/PaddleBilling.php:67
        "Get your client-side token from Paddle dashboard"=> "",

        #: app/helpers/payments/PaddleBilling.php:70 app/helpers/payments/Polar.php:71
        #: storage/themes/default/integrations/shortcuts.php:61
        #: storage/themes/default/user/developers.php:15
        "API Key"=> "",

        #: app/helpers/payments/PaddleBilling.php:72
        "Get your API key from Paddle dashboard"=> "",

        #: app/helpers/payments/PaddleBilling.php:77
        "Add this webhook URL to your Paddle dashboard to receive payment notifications"=> "",

        #: app/helpers/payments/PaddleBilling.php:80
        "Webhook Secret Key"=> "",

        #: app/helpers/payments/PaddleBilling.php:82
        "You can find this when creating a notification webhook in your Paddle dashboard"=> "",

        #: app/helpers/payments/PaddleBilling.php:89
        "You cannot enable both Paddle Classic and Paddle Billing at the same time. You must choose one."=> "",

        #: app/helpers/payments/PaddleBilling.php:180
        "Payment was not completed. Please try again"=> "",

        #: app/helpers/payments/PayStack.php:59
        "PayStack Payments"=> "",

        #: app/helpers/payments/PayStack.php:64
        "Collect payments securely with PayStack."=> "",

        #: app/helpers/payments/PayStack.php:68 storage/themes/default/auth/2fa.php:58
        #: storage/themes/default/user/security.php:96
        #: storage/themes/default/user/security.php:126
        #: storage/themes/default/user/settings.php:244
        #: storage/themes/default/user/settings.php:360
        #: storage/themes/the23/auth/2fa.php:57
        #: storage/themes/the23/auth/email2fa.php:65
        "Secret Key"=> "",

        #: app/helpers/payments/PayStack.php:70 app/helpers/payments/PayStack.php:75
        "Get your paystack keys from here once logged in <a href=\"https://dashboard.paystack.com/#/settings/developers\" target=\"_blank\">click here</a>"=> "",

        #: app/helpers/payments/PayStack.php:73
        "Public Key"=> "",

        #: app/helpers/payments/PayStack.php:80
        "You can add your webhooks <a href=\"https://dashboard.paystack.com/#/settings/developers\" target=\"_blank\">here</a>. For more info, please check the docs."=> "",

        #: app/helpers/payments/PayStack.php:86
        "You cannot enable both Stripe and PayStack at the same time because they both work in the same way. You must choose one."=> "",

        #: app/helpers/payments/PayStack.php:535
        "Your payment has been confirmed and your subscription has been activated."=> "",

        #: app/helpers/payments/Paypal.php:50
        "Paypal Basic Checkout"=> "",

        #: app/helpers/payments/Paypal.php:55
        "Collect payments via basic paypal checkout."=> "",

        #: app/helpers/payments/Paypal.php:59
        #: storage/themes/default/user/affiliate.php:99
        #: storage/themes/default/user/withdrawals.php:62
        "PayPal Email"=> "",

        #: app/helpers/payments/Paypal.php:61
        "Payments will be sent to this address. Please make sure that you enable IPN and enable notification."=> "",

        #: app/helpers/payments/Paypal.php:64
        "PayPal IPN"=> "",

        #: app/helpers/payments/Paypal.php:66
        "For more info <a href=\"https://developer.paypal.com/api/nvp-soap/ipn/IPNSetup/\" target=\"_blank\">click here</a>"=> "",

        #: app/helpers/payments/Paypal.php:154
        "Payment complete. We will upgrade your account as soon as the payment is verified."=> "",

        #: app/helpers/payments/PaypalApi.php:52
        "Paypal API Payments"=> "",

        #: app/helpers/payments/PaypalApi.php:57
        "Collect payments securely with PayPal API."=> "",

        #: app/helpers/payments/PaypalApi.php:61
        #: storage/themes/default/pages/api.php:181
        #: storage/themes/the23/pages/api.php:172
        "Client ID"=> "",

        #: app/helpers/payments/PaypalApi.php:63
        "Please enter your live client ID."=> "",

        #: app/helpers/payments/PaypalApi.php:66
        "Client Secret Key"=> "",

        #: app/helpers/payments/PaypalApi.php:68
        "Please enter your live client secret."=> "",

        #: app/helpers/payments/PaypalApi.php:74
        "You cannot enable both basic paypal and paypal api at the same time. You must choose one."=> "",

        #: app/helpers/payments/PaypalApi.php:184
        #: app/helpers/payments/PaypalApi.php:245
        #: app/helpers/payments/PaypalApi.php:248
        #: app/helpers/payments/PaypalApi.php:344
        #: app/helpers/payments/PaypalApi.php:347
        #: app/helpers/payments/PaypalApi.php:361
        #: app/helpers/payments/PaypalApi.php:365
        #: app/helpers/payments/PaypalApi.php:407
        #: app/helpers/payments/PaypalApi.php:410
        "An issue occurred. You have not been charged."=> "",

        #: app/helpers/payments/PaypalApi.php:303
        "An issue occurred. Please contact us for more info."=> "",

        #: app/helpers/payments/Polar.php:54
        "Polar Payments"=> "",

        #: app/helpers/payments/Polar.php:59
        "Collect payments securely with Polar."=> "",

        #: app/helpers/payments/Polar.php:63
        "Environment"=> "",

        #: app/helpers/payments/Polar.php:65
        "Sandbox (Test)"=> "",

        #: app/helpers/payments/Polar.php:66
        "Production (Live)"=> "",

        #: app/helpers/payments/Polar.php:68
        "Choose between sandbox for testing or production for live payments."=> "",

        #: app/helpers/payments/Polar.php:73
        "Get your API key from <a href=\"https://polar.sh/dashboard/settings\" target=\"_blank\">Polar Dashboard</a>"=> "",

        #: app/helpers/payments/Polar.php:76
        "Organization ID"=> "",

        #: app/helpers/payments/Polar.php:78
        "Your Polar organization ID."=> "",

        #: app/helpers/payments/Polar.php:81
        "Webhook Secret"=> "",

        #: app/helpers/payments/Polar.php:83
        "Webhook secret for verifying incoming webhooks from Polar."=> "",

        #: app/helpers/payments/Polar.php:88
        "Add this URL to your Polar webhook settings."=> "",

        #: app/helpers/payments/Polar.php:134 app/helpers/payments/Stripe.php:209
        "Please enter your company name"=> "",

        #: app/helpers/payments/Polar.php:200
        "Plan is not configured for Polar payments. Please contact support."=> "",

        #: app/helpers/payments/Polar.php:257 app/helpers/payments/Polar.php:264
        "An error occurred while creating checkout session. Please try again."=> "",

        #: app/helpers/payments/Polar.php:1177
        "Polar payments are not enabled."=> "",

        #: app/helpers/payments/Polar.php:1199
        "Unable to access customer portal. Please contact support."=> "",

        #: app/helpers/payments/Stripe.php:53
        "Stripe Payments"=> "",

        #: app/helpers/payments/Stripe.php:58
        "Collect payments securely with Stripe."=> "",

        #: app/helpers/payments/Stripe.php:62
        #: storage/themes/default/pricing/checkout.php:169
        #: storage/themes/the23/pricing/checkout.php:3
        #: storage/themes/the23/pricing/checkout.php:191
        "Checkout"=> "",

        #: app/helpers/payments/Stripe.php:66
        "Built-in Checkout"=> "",

        #: app/helpers/payments/Stripe.php:72
        "Stripe Hosted Checkout"=> "",

        #: app/helpers/payments/Stripe.php:75
        "Choose between built-in checkout or Stripe hosted checkout."=> "",

        #: app/helpers/payments/Stripe.php:78
        "Stripe Publishable Key"=> "",

        #: app/helpers/payments/Stripe.php:80 app/helpers/payments/Stripe.php:85
        "Get your stripe keys from here once logged in <a href=\"https://dashboard.stripe.com/account/apikeys\" target=\"_blank\">click here</a>"=> "",

        #: app/helpers/payments/Stripe.php:83
        "Stripe Secret Key"=> "",

        #: app/helpers/payments/Stripe.php:88
        "Webhook Signature Key"=> "",

        #: app/helpers/payments/Stripe.php:90
        "Webhook signature is a security measure to verify the authenticity of the data incoming from Stripe. It is highly recommended that you add this for safety measure. You can find your key after adding a webhook. <a href=\"https://dashboard.stripe.com/account/webhooks\" target=\"_blank\">Click here to find your signature key.</a>"=> "",

        #: app/helpers/payments/Stripe.php:95
        "You can add your webhooks <a href=\"https://dashboard.stripe.com/account/webhooks\" target=\"_blank\">here</a>. For more info, please check the docs."=> "",

        #: app/helpers/payments/Stripe.php:174
        "Credit or debit card"=> "",

        #: app/helpers/payments/Stripe.php:179
        "Payments are secure and encrypted"=> "",

        #: app/helpers/payments/Stripe.php:261 app/helpers/payments/Stripe.php:294
        #: storage/themes/default/pricing/checkout.php:52
        #: storage/themes/default/user/settings.php:113
        "Tax ID"=> "",

        #: app/helpers/payments/Stripe.php:265 app/helpers/payments/Stripe.php:298
        "Contact Person"=> "",

        #: app/helpers/payments/Stripe.php:425 app/helpers/payments/Stripe.php:487
        "Your payment was not completed because it requires authentication. Please authenticate and confirm your payment in the popup window. If you do not see the popup, enable popup in your browser and refresh the page. Once you are done and your payment is confirmed, you can close the popup and visit the dashboard."=> "",

        #: app/helpers/payments/Stripe.php:467
        "Your credit card was declined. Please check your credit card and try again later."=> "",

        #: app/helpers/payments/Stripe.php:496
        "Your payment was not completed. You will need to retry and complete the payment on our payment processors website."=> "",

        #: app/helpers/payments/Stripe.php:702
        "Payment failed"=> "",

        #: app/middleware/CheckDomain.php:81
        "Great! Your domain is working."=> "",

        #: app/middleware/CheckMaintenance.php:37
        "Offline for Maintenance"=> "",

        #: app/middleware/CheckPrivate.php:43
        "Private Use"=> "",

        #: app/middleware/RolePermission.php:37
        "Please login to continue."=> "",

        #: app/middleware/RolePermission.php:49
        "You do not have permission to access this page."=> "",

        #: app/models/Plans.php:45
        "This feature is currently unavailable. Please contact your team administrator."=> "",

        #: app/models/Role.php:58
        "Users"=> "",

        #: app/models/Role.php:60
        "View Users"=> "",

        #: app/models/Role.php:61
        "Create Users"=> "",

        #: app/models/Role.php:62
        "Edit Users"=> "",

        #: app/models/Role.php:63
        "Delete Users"=> "",

        #: app/models/Role.php:64
        "Ban Users"=> "",

        #: app/models/Role.php:65
        "Verify Users"=> "",

        #: app/models/Role.php:71 storage/themes/default/pixels/edit.php:6
        "View Links"=> "",

        #: app/models/Role.php:72 app/traits/Teams.php:40
        "Create Links"=> "",

        #: app/models/Role.php:73 app/traits/Teams.php:41
        "Edit Links"=> "",

        #: app/models/Role.php:74 app/traits/Teams.php:42
        "Delete Links"=> "",

        #: app/models/Role.php:75
        "Approve Links"=> "",

        #: app/models/Role.php:76
        "Disable Links"=> "",

        #: app/models/Role.php:82 storage/themes/default/user/security.php:93
        #: storage/themes/default/user/settings.php:241
        "View QR"=> "",

        #: app/models/Role.php:85 app/traits/Teams.php:51
        "Delete QR"=> "",

        #: app/models/Role.php:91 storage/themes/default/bio/edit.php:4
        #: storage/themes/default/bio/index.php:53
        "View Bio"=> "",

        #: app/models/Role.php:92 app/traits/Teams.php:58
        #: storage/themes/default/bio/index.php:5
        #: storage/themes/default/bio/index.php:112
        #: storage/themes/default/bio/index.php:124
        "Create Bio"=> "",

        #: app/models/Role.php:93 app/traits/Teams.php:59
        "Edit Bio"=> "",

        #: app/models/Role.php:94 app/traits/Teams.php:60
        "Delete Bio"=> "",

        #: app/models/Role.php:98
        "Plans"=> "",

        #: app/models/Role.php:100
        "View Plans"=> "",

        #: app/models/Role.php:101
        "Create Plans"=> "",

        #: app/models/Role.php:102
        "Edit Plans"=> "",

        #: app/models/Role.php:103
        "Delete Plans"=> "",

        #: app/models/Role.php:109
        "View Settings"=> "",

        #: app/models/Role.php:110
        "Edit Settings"=> "",

        #: app/models/Role.php:111
        "System Settings"=> "",

        #: app/models/Role.php:117
        "View Statistics"=> "",

        #: app/models/Role.php:118 storage/themes/default/partials/links.php:30
        #: storage/themes/default/user/edit.php:9
        "Export Statistics"=> "",

        #: app/models/Role.php:122 storage/themes/default/bio/edit.php:12
        #: storage/themes/default/qr/bulk.php:38
        "Content"=> "",

        #: app/models/Role.php:124
        "View Pages"=> "",

        #: app/models/Role.php:125
        "Create Pages"=> "",

        #: app/models/Role.php:126
        "Edit Pages"=> "",

        #: app/models/Role.php:127
        "Delete Pages"=> "",

        #: app/models/Role.php:128
        "View Blog"=> "",

        #: app/models/Role.php:129
        "Create Blog"=> "",

        #: app/models/Role.php:130
        "Edit Blog"=> "",

        #: app/models/Role.php:131
        "Delete Blog"=> "",

        #: app/models/Role.php:132
        "View FAQ"=> "",

        #: app/models/Role.php:133
        "Create FAQ"=> "",

        #: app/models/Role.php:134
        "Edit FAQ"=> "",

        #: app/models/Role.php:135
        "Delete FAQ"=> "",

        #: app/models/Role.php:139
        "Subscriptions"=> "",

        #: app/models/Role.php:141
        "View Subscriptions"=> "",

        #: app/models/Role.php:145
        "Payments"=> "",

        #: app/models/Role.php:147
        "View Payments"=> "",

        #: app/models/Role.php:153
        "View Tools"=> "",

        #: app/models/Role.php:154
        "Backup Data"=> "",

        #: app/models/Role.php:155
        "Restore Data"=> "",

        #: app/models/Role.php:156
        "System Updates"=> "",

        #: app/models/Role.php:160
        "Affiliates"=> "",

        #: app/models/Role.php:162
        "View Affiliates"=> "",

        #: app/models/Role.php:163
        "Pay Affiliates"=> "",

        #: app/traits/Links.php:74
        "Please create a free account or login to shorten links."=> "",

        #: app/traits/Links.php:77
        "You cannot shorten URLs at the moment. Please upgrade to another plan."=> "",

        #: app/traits/Links.php:88
        "You have reached your monthly limit. Please upgrade to another plan."=> "",

        #: app/traits/Links.php:91
        "You have reached your maximum links limit. Please upgrade to another plan."=> "",

        #: app/traits/Links.php:97
        "This service is meant to be used internally only."=> "",

        #: app/traits/Links.php:103 app/traits/Links.php:579
        "You cannot shorten URLs of this website."=> "",

        #: app/traits/Links.php:106 app/traits/Links.php:582
        "This domain name or link has been blacklisted."=> "",

        #: app/traits/Links.php:109 app/traits/Links.php:585
        "This URL contains blacklisted keywords."=> "",

        #: app/traits/Links.php:121 app/traits/Links.php:597
        "Linking to executable files is not allowed."=> "",

        #: app/traits/Links.php:124 app/traits/Links.php:600
        "The expiry date must be later than today."=> "",

        #: app/traits/Links.php:292 app/traits/Links.php:776
        "The total percentage is more than 100. Please re-adjust percentages."=> "",

        #: app/traits/Links.php:309
        "Please enter a valid url for the expiration redirect."=> "",

        #: app/traits/Links.php:388 app/traits/Links.php:405 app/traits/Links.php:444
        "Link has been shortened"=> "",

        #: app/traits/Links.php:431 app/traits/Links.php:817
        "This URL cannot be used with this redirect method because browsers will prevent it for security reasons."=> "",

        #: app/traits/Overlays.php:38
        "CTA Contact"=> "",

        #: app/traits/Overlays.php:39
        "Create a contact form where users will be able to contact you via email."=> "",

        #: app/traits/Overlays.php:48
        "CTA Poll"=> "",

        #: app/traits/Overlays.php:49
        "Create a quick poll where users will be able to answer it upon visit."=> "",

        #: app/traits/Overlays.php:58
        "CTA Message"=> "",

        #: app/traits/Overlays.php:59
        "Create a small popup with a message and a link to a page or a product."=> "",

        #: app/traits/Overlays.php:68
        "CTA Newsletter"=> "",

        #: app/traits/Overlays.php:69
        "Create a small popup form to collect emails from users."=> "",

        #: app/traits/Overlays.php:78
        "CTA Image"=> "",

        #: app/traits/Overlays.php:79
        "Create a small popup with an image of your choice."=> "",

        #: app/traits/Overlays.php:88
        #: storage/themes/default/overlay/create_coupon.php:95
        "Coupon"=> "",

        #: app/traits/Overlays.php:89
        "Create a small popup with a coupon code that users can use."=> "",

        #: app/traits/Payments.php:50 app/traits/Payments.php:72
        #: app/traits/Payments.php:94 app/traits/Payments.php:136
        #: app/traits/Payments.php:157 app/traits/Payments.php:179
        "Credit Card"=> "",

        #: app/traits/Payments.php:223
        "Transfer payments via your bank"=> "",

        #: app/traits/Pixels.php:149
        "Google Ads pixel ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:160
        "LinkedIn ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:171
        "Twitter ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:182
        "AdRoll ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:193
        "Quora ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:204
        "GTM container ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:215
        "Google Analytics ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:227
        "Snapchat ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:239
        "Pinterest ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:251
        "Reddit ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:263
        "Bing ID is not correct. Please double check."=> "",

        #: app/traits/Pixels.php:275
        "TikTok ID is not correct. Please double check."=> "",

        #: app/traits/Teams.php:67
        "Create Splash"=> "",

        #: app/traits/Teams.php:68
        "Edit Splash"=> "",

        #: app/traits/Teams.php:69
        "Delete Splash"=> "",

        #: app/traits/Teams.php:76
        "Create Overlay"=> "",

        #: app/traits/Teams.php:77
        "Edit Overlay"=> "",

        #: app/traits/Teams.php:78
        "Delete Overlay"=> "",

        #: app/traits/Teams.php:85
        "Create Pixels"=> "",

        #: app/traits/Teams.php:86
        "Edit Pixels"=> "",

        #: app/traits/Teams.php:87
        "Delete Pixels"=> "",

        #: app/traits/Teams.php:92
        "Branded Domain"=> "",

        #: app/traits/Teams.php:94
        "Add Custom Domain"=> "",

        #: app/traits/Teams.php:95
        "Delete Custom Domain"=> "",

        #: app/traits/Teams.php:102
        "Create Campaigns"=> "",

        #: app/traits/Teams.php:103
        "Edit Campaigns"=> "",

        #: app/traits/Teams.php:104
        "Delete Campaigns"=> "",

        #: app/traits/Teams.php:116 storage/themes/default/user/campaignstats.php:112
        #: storage/themes/default/user/index.php:82
        #: storage/themes/default/user/links.php:40
        #: storage/themes/default/user/links.php:149
        #: storage/themes/default/user/stats.php:121
        "Export"=> "",

        #: core/Auth.class.php:143 core/Auth.class.php:210
        "This user does not exist."=> "",

        #: core/Helper.class.php:518
        "Previous"=> "",

        #: core/Helper.class.php:519
        "Next"=> "",

        #: storage/themes/default/auth/2fa.php:15 storage/themes/the23/auth/2fa.php:16
        "The access code can be found on the Authenticator app. Please enter the code shown for this website. If you lost your phone or can't use the app, please contact us."=> "",

        #: storage/themes/default/auth/2fa.php:22
        #: storage/themes/default/user/security.php:131
        #: storage/themes/default/user/security.php:132
        #: storage/themes/default/user/settings.php:365
        #: storage/themes/default/user/settings.php:366
        #: storage/themes/the23/auth/2fa.php:23
        "2FA Access Code"=> "",

        #: storage/themes/default/auth/2fa.php:29 storage/themes/the23/auth/2fa.php:25
        "Recover 2FA"=> "",

        #: storage/themes/default/auth/2fa.php:32 storage/themes/the23/auth/2fa.php:30
        #: storage/themes/the23/auth/email2fa.php:32
        "Validate"=> "",

        #: storage/themes/default/auth/2fa.php:48 storage/themes/the23/auth/2fa.php:47
        #: storage/themes/the23/auth/email2fa.php:55
        "Reset 2FA"=> "",

        #: storage/themes/default/auth/2fa.php:52 storage/themes/the23/auth/2fa.php:51
        #: storage/themes/the23/auth/email2fa.php:59
        "To recover your account, you will need your secret key and access to the email address on the account. If you do not have access to the 2FA secret key, please contact us."=> "",

        #: storage/themes/default/auth/2fa.php:61 storage/themes/the23/auth/2fa.php:60
        #: storage/themes/the23/auth/email2fa.php:68
        "Reset"=> "",

        #: storage/themes/default/auth/authorize.php:12
        "The application \"{name}\" is requesting access to your account."=> "",

        #: storage/themes/default/auth/authorize.php:29
        #: storage/themes/default/auth/authorize.php:30
        #: storage/themes/default/auth/register.php:73
        #: storage/themes/default/oauth/authorize.php:30
        #: storage/themes/default/oauth/authorize.php:31
        "Email address"=> "",

        #: storage/themes/default/auth/authorize.php:35
        #: storage/themes/default/auth/authorize.php:38
        #: storage/themes/default/auth/invite.php:40
        #: storage/themes/default/auth/login.php:33
        #: storage/themes/default/auth/register.php:84
        #: storage/themes/default/gates/password.php:22
        #: storage/themes/default/oauth/authorize.php:36
        #: storage/themes/default/oauth/authorize.php:39
        #: storage/themes/default/pages/qr.php:173
        #: storage/themes/default/qr/edit.php:328 storage/themes/default/qr/new.php:339
        #: storage/themes/default/user/billing.php:150
        #: storage/themes/default/user/security.php:27
        #: storage/themes/default/user/settings.php:68
        #: storage/themes/the23/auth/invite.php:39
        #: storage/themes/the23/auth/login.php:72
        #: storage/themes/the23/auth/register.php:74
        #: storage/themes/the23/auth/reset.php:26
        #: storage/themes/the23/auth/reset.php:32
        #: storage/themes/the23/gates/password.php:19
        #: storage/themes/the23/pages/qr.php:174
        "Password"=> "",

        #: storage/themes/default/auth/authorize.php:36
        #: storage/themes/default/auth/login.php:44
        #: storage/themes/default/oauth/authorize.php:37
        #: storage/themes/the23/auth/login.php:76
        "Forgot Password?"=> "",

        #: storage/themes/default/auth/authorize.php:42
        #: storage/themes/default/oauth/authorize.php:43
        "Login to Continue"=> "",

        #: storage/themes/default/auth/authorize.php:58
        #: storage/themes/default/oauth/authorize.php:64
        "By clicking Authorize, you allow this application to:"=> "",

        #: storage/themes/default/auth/authorize.php:61
        #: storage/themes/default/oauth/authorize.php:67
        "Access your basic information"=> "",

        #: storage/themes/default/auth/authorize.php:62
        #: storage/themes/default/oauth/authorize.php:68
        "View your links and their statistics"=> "",

        #: storage/themes/default/auth/authorize.php:63
        #: storage/themes/default/oauth/authorize.php:69
        "Create short links on your behalf"=> "",

        #: storage/themes/default/auth/authorize.php:74
        #: storage/themes/default/oauth/authorize.php:80
        "Authorize Application"=> "",

        #: storage/themes/default/auth/authorize.php:80
        #: storage/themes/default/oauth/authorize.php:86
        "This application will not have access to your password or any other private information."=> "",

        #: storage/themes/default/auth/email2fa.php:15
        #: storage/themes/the23/auth/email2fa.php:16
        "A verification code has been sent to your email address. Please enter the 6-digit code to complete your login."=> "",

        #: storage/themes/default/auth/email2fa.php:22
        "Verification Code"=> "",

        #: storage/themes/default/auth/email2fa.php:30
        #: storage/themes/the23/auth/email2fa.php:39
        "Resend Code"=> "",

        #: storage/themes/default/auth/email2fa.php:31
        "Code expires in 10 minutes"=> "",

        #: storage/themes/default/auth/invite.php:15
        #: storage/themes/the23/auth/invite.php:20
        "Join team and collaborate on everything"=> "",

        #: storage/themes/default/auth/invite.php:31
        #: storage/themes/default/auth/register.php:64
        #: storage/themes/default/user/settings.php:59
        #: storage/themes/the23/auth/invite.php:33
        #: storage/themes/the23/auth/register.php:62
        "Username"=> "",

        #: storage/themes/default/auth/invite.php:49
        #: storage/themes/default/auth/register.php:97
        #: storage/themes/default/auth/reset.php:30
        #: storage/themes/default/user/security.php:158
        #: storage/themes/default/user/settings.php:75
        #: storage/themes/default/user/settings.php:332
        #: storage/themes/the23/auth/invite.php:45
        #: storage/themes/the23/auth/register.php:80
        "Confirm Password"=> "",

        #: storage/themes/default/auth/invite.php:61
        #: storage/themes/default/auth/register.php:111
        #: storage/themes/the23/auth/invite.php:52
        #: storage/themes/the23/auth/register.php:87
        "I agree to the"=> "",

        #: storage/themes/default/auth/invite.php:68
        #: storage/themes/default/auth/register.php:118
        #: storage/themes/the23/auth/invite.php:54
        #: storage/themes/the23/auth/register.php:89
        "I agree to the terms and conditions"=> "",

        #: storage/themes/default/auth/invite.php:73
        #: storage/themes/default/pages/consent.php:14
        #: storage/themes/the23/auth/invite.php:61
        #: storage/themes/the23/pages/consent.php:13
        "Accept"=> "",

        #: storage/themes/default/auth/login.php:17
        #: storage/themes/the23/auth/login.php:61
        "Email or username"=> "",

        #: storage/themes/default/auth/login.php:26
        #: storage/themes/default/auth/login.php:103
        #: storage/themes/default/oauth/authorize.php:48
        #: storage/themes/the23/auth/login.php:65
        #: storage/themes/the23/auth/login.php:103
        "Don't have an account?"=> "",

        #: storage/themes/default/auth/login.php:51
        #: storage/themes/the23/auth/login.php:83
        "Remember me"=> "",

        #: storage/themes/default/auth/login.php:57
        #: storage/themes/default/auth/register.php:130
        #: storage/themes/default/partials/main_menu.php:170
        #: storage/themes/default/partials/main_menu.php:189
        #: storage/themes/default/user/security.php:25
        #: storage/themes/the23/auth/invite.php:65
        #: storage/themes/the23/auth/login.php:89
        #: storage/themes/the23/auth/register.php:100
        #: storage/themes/the23/partials/main_menu.php:219
        "Login"=> "",

        #: storage/themes/default/auth/login.php:63
        #: storage/themes/default/auth/register.php:45
        #: storage/themes/the23/auth/login.php:52
        #: storage/themes/the23/auth/register.php:44
        "or"=> "",

        #: storage/themes/default/auth/login.php:69
        #: storage/themes/default/auth/login.php:70
        #: storage/themes/default/auth/login.php:77
        #: storage/themes/default/auth/login.php:78
        #: storage/themes/default/auth/login.php:85
        #: storage/themes/default/auth/login.php:86
        #: storage/themes/default/auth/register.php:21
        #: storage/themes/default/auth/register.php:22
        #: storage/themes/default/auth/register.php:29
        #: storage/themes/default/auth/register.php:30
        #: storage/themes/default/auth/register.php:37
        #: storage/themes/default/auth/register.php:38
        #: storage/themes/default/user/settings.php:264
        #: storage/themes/default/user/settings.php:269
        #: storage/themes/default/user/settings.php:277
        #: storage/themes/default/user/settings.php:282
        #: storage/themes/default/user/settings.php:290
        #: storage/themes/default/user/settings.php:295
        #: storage/themes/the23/auth/login.php:25
        #: storage/themes/the23/auth/login.php:29
        #: storage/themes/the23/auth/login.php:30
        #: storage/themes/the23/auth/login.php:34
        #: storage/themes/the23/auth/login.php:35
        #: storage/themes/the23/auth/login.php:39
        #: storage/themes/the23/auth/login.php:40
        #: storage/themes/the23/auth/login.php:45
        #: storage/themes/the23/auth/login.php:46
        #: storage/themes/the23/auth/register.php:24
        #: storage/themes/the23/auth/register.php:28
        #: storage/themes/the23/auth/register.php:29
        #: storage/themes/the23/auth/register.php:33
        #: storage/themes/the23/auth/register.php:34
        #: storage/themes/the23/auth/register.php:38
        #: storage/themes/the23/auth/register.php:39
        "Sign in with"=> "",

        #: storage/themes/default/auth/login.php:96
        #: storage/themes/default/auth/register.php:133
        #: storage/themes/default/partials/footer.php:91
        #: storage/themes/the23/auth/2fa.php:35
        #: storage/themes/the23/auth/email2fa.php:43
        #: storage/themes/the23/auth/forgot.php:39
        #: storage/themes/the23/auth/invite.php:69
        #: storage/themes/the23/auth/login.php:96
        #: storage/themes/the23/auth/register.php:105
        #: storage/themes/the23/auth/reset.php:44
        #: storage/themes/the23/partials/footer.php:92
        "All Rights Reserved"=> "",

        #: storage/themes/default/auth/login.php:105
        #: storage/themes/default/auth/register.php:13
        #: storage/themes/default/partials/footer.php:10
        #: storage/themes/the23/auth/login.php:105
        "Start your marketing campaign now and reach your customers efficiently."=> "",

        #: storage/themes/default/auth/login.php:108
        #: storage/themes/default/auth/register.php:125
        #: storage/themes/default/oauth/authorize.php:48
        #: storage/themes/default/pages/qr.php:291
        #: storage/themes/the23/auth/login.php:108
        #: storage/themes/the23/auth/register.php:96
        #: storage/themes/the23/pages/qr.php:292
        "Register"=> "",

        #: storage/themes/default/auth/register.php:12
        "Create your account"=> "",

        #: storage/themes/default/auth/register.php:54
        #: storage/themes/default/bio/edit.php:60
        #: storage/themes/the23/auth/register.php:55
        "Bio Page Alias"=> "",

        #: storage/themes/default/auth/register.php:56
        #: storage/themes/default/auth/register.php:66
        #: storage/themes/the23/auth/invite.php:32
        #: storage/themes/the23/auth/register.php:54
        #: storage/themes/the23/auth/register.php:61
        "Please enter a username"=> "",

        #: storage/themes/default/auth/register.php:88
        #: storage/themes/the23/auth/invite.php:38
        #: storage/themes/the23/auth/register.php:73
        #: storage/themes/the23/gates/password.php:18
        "Please enter a valid password."=> "",

        #: storage/themes/default/auth/register.php:101
        #: storage/themes/the23/auth/invite.php:44
        #: storage/themes/the23/auth/register.php:79
        "Please confirm your password."=> "",

        #: storage/themes/default/auth/register.php:129
        #: storage/themes/the23/auth/invite.php:65
        #: storage/themes/the23/auth/register.php:100
        "Already have an account?"=> "",

        #: storage/themes/default/auth/reset.php:21
        "New Password"=> "",

        #: storage/themes/default/bio/edit.php:3
        #: storage/themes/default/gates/profile.php:145
        #: storage/themes/default/gates/profile.php:150
        #: storage/themes/default/partials/links.php:9
        "Share"=> "",

        #: storage/themes/default/bio/edit.php:15
        #: storage/themes/default/bio/edit.php:87
        "Social Links"=> "",

        #: storage/themes/default/bio/edit.php:24
        "Data"=> "",

        #: storage/themes/default/bio/edit.php:56
        "Bio Page Name"=> "",

        #: storage/themes/default/bio/edit.php:68
        #: storage/themes/default/bio/index.php:143
        "Choose domain to generate the link with"=> "",

        #: storage/themes/default/bio/edit.php:72
        "Leave this field empty to generate a random alias."=> "",

        #: storage/themes/default/bio/edit.php:81
        #: storage/themes/default/bio/widgets.php:5
        "Add Link or Content"=> "",

        #: storage/themes/default/bio/edit.php:106
        "You have already added a link to this platform"=> "",

        #: storage/themes/default/bio/edit.php:152
        "Position"=> "",

        #: storage/themes/default/bio/edit.php:154
        "Off"=> "",

        #: storage/themes/default/bio/edit.php:155
        "Top"=> "",

        #: storage/themes/default/bio/edit.php:156
        #: storage/themes/default/class/themeSettings.php:156
        #: storage/themes/the23/class/themeSettings.php:350
        "Bottom"=> "",

        #: storage/themes/default/bio/edit.php:164
        "Header Layout"=> "",

        #: storage/themes/default/bio/edit.php:199
        "Header Banner"=> "",

        #: storage/themes/default/bio/edit.php:211
        #: storage/themes/default/splash/create.php:62
        #: storage/themes/default/splash/edit.php:67
        "Upload Banner"=> "",

        #: storage/themes/default/bio/edit.php:213
        #: storage/themes/default/bio/edit.php:214
        "Banner must be one the following formats {f} and be less than {s}kb."=> "",

        #: storage/themes/default/bio/edit.php:218
        "Themes"=> "",

        #: storage/themes/default/bio/edit.php:233
        "Aa"=> "",

        #: storage/themes/default/bio/edit.php:237
        "Upgrade to unlock this theme"=> "",

        #: storage/themes/default/bio/edit.php:247
        "Fonts"=> "",

        #: storage/themes/default/bio/edit.php:267
        #: storage/themes/default/qr/bulk.php:369
        #: storage/themes/default/qr/edit.php:805 storage/themes/default/qr/new.php:791
        "Text Color"=> "",

        #: storage/themes/default/bio/edit.php:272
        "Custom Background"=> "",

        #: storage/themes/default/bio/edit.php:274
        #: storage/themes/default/bio/edit.php:287
        #: storage/themes/default/pages/qr.php:239
        #: storage/themes/default/qr/bulk.php:65 storage/themes/default/qr/bulk.php:83
        #: storage/themes/default/qr/edit.php:479
        #: storage/themes/default/qr/edit.php:497 storage/themes/default/qr/new.php:469
        #: storage/themes/default/qr/new.php:487 storage/themes/the23/pages/qr.php:240
        "Background"=> "",

        #: storage/themes/default/bio/edit.php:277
        #: storage/themes/default/pages/qr.php:230
        #: storage/themes/default/qr/bulk.php:56 storage/themes/default/qr/edit.php:470
        #: storage/themes/default/qr/new.php:460 storage/themes/the23/pages/qr.php:231
        "Single Color"=> "",

        #: storage/themes/default/bio/edit.php:278
        #: storage/themes/default/qr/bulk.php:57 storage/themes/default/qr/edit.php:471
        #: storage/themes/default/qr/new.php:461 storage/themes/the23/index.php:225
        "Gradient Color"=> "",

        #: storage/themes/default/bio/edit.php:297
        #: storage/themes/default/qr/bulk.php:90 storage/themes/default/qr/edit.php:504
        #: storage/themes/default/qr/new.php:494
        "Gradient Start"=> "",

        #: storage/themes/default/bio/edit.php:303
        #: storage/themes/default/qr/bulk.php:94 storage/themes/default/qr/edit.php:508
        #: storage/themes/default/qr/new.php:498
        "Gradient Stop"=> "",

        #: storage/themes/default/bio/edit.php:309
        "Gradient Angle"=> "",

        #: storage/themes/default/bio/edit.php:314
        "Please choose a valid background image. JPG, PNG"=> "",

        #: storage/themes/default/bio/edit.php:317
        "Buttons"=> "",

        #: storage/themes/default/bio/edit.php:322
        "Frosted Glass Effect"=> "",

        #: storage/themes/default/bio/edit.php:323
        "Apply a frosted glass blur effect to buttons and cards using the button color"=> "",

        #: storage/themes/default/bio/edit.php:330
        "Button Color"=> "",

        #: storage/themes/default/bio/edit.php:334
        #: storage/themes/default/overlay/create_contact.php:144
        #: storage/themes/default/overlay/create_coupon.php:72
        #: storage/themes/default/overlay/create_message.php:98
        #: storage/themes/default/overlay/create_newsletter.php:97
        #: storage/themes/default/overlay/create_poll.php:91
        #: storage/themes/default/overlay/edit_contact.php:145
        #: storage/themes/default/overlay/edit_coupon.php:72
        #: storage/themes/default/overlay/edit_message.php:98
        #: storage/themes/default/overlay/edit_newsletter.php:97
        #: storage/themes/default/overlay/edit_poll.php:90
        "Button Text Color"=> "",

        #: storage/themes/default/bio/edit.php:338
        "Button Style"=> "",

        #: storage/themes/default/bio/edit.php:342
        #: storage/themes/default/bio/edit.php:344
        #: storage/themes/default/bio/edit.php:404
        "Rectangular"=> "",

        #: storage/themes/default/bio/edit.php:343
        #: storage/themes/default/bio/edit.php:345
        #: storage/themes/default/bio/edit.php:403
        "Rounded"=> "",

        #: storage/themes/default/bio/edit.php:344
        #: storage/themes/default/bio/edit.php:345
        "Transparent"=> "",

        #: storage/themes/default/bio/edit.php:348
        "Button Shadow"=> "",

        #: storage/themes/default/bio/edit.php:352
        "Soft"=> "",

        #: storage/themes/default/bio/edit.php:353
        "Hard"=> "",

        #: storage/themes/default/bio/edit.php:356
        "Shadow Color"=> "",

        #: storage/themes/default/bio/edit.php:365
        "SEO"=> "",

        #: storage/themes/default/bio/edit.php:368
        #: storage/themes/default/partials/shortener.php:167
        #: storage/themes/default/user/edit.php:52
        "Meta Title"=> "",

        #: storage/themes/default/bio/edit.php:372
        #: storage/themes/default/partials/shortener.php:173
        #: storage/themes/default/user/edit.php:58
        "Meta Description"=> "",

        #: storage/themes/default/bio/edit.php:376
        "Meta Image"=> "",

        #: storage/themes/default/bio/edit.php:392
        "Display Avatar"=> "",

        #: storage/themes/default/bio/edit.php:393
        "Display or hide your avatar from your Bio page"=> "",

        #: storage/themes/default/bio/edit.php:401
        "Avatar Style"=> "",

        #: storage/themes/default/bio/edit.php:414
        "Verified Badge"=> "",

        #: storage/themes/default/bio/edit.php:415
        "Display the verified badge on this Bio Page"=> "",

        #: storage/themes/default/bio/edit.php:429
        "Sensitive content warns users before showing them the Bio Page"=> "",

        #: storage/themes/default/bio/edit.php:441
        "Age Restriction"=> "",

        #: storage/themes/default/bio/edit.php:442
        "Require users to verify their age before accessing the Bio Page"=> "",

        #: storage/themes/default/bio/edit.php:451
        "Minimum Age"=> "",

        #: storage/themes/default/bio/edit.php:453
        "Minimum age required to access this page"=> "",

        #: storage/themes/default/bio/edit.php:456
        "Redirect URL for Minors"=> "",

        #: storage/themes/default/bio/edit.php:458
        "URL to redirect users who are under the minimum age"=> "",

        #: storage/themes/default/bio/edit.php:466
        "Cookie Popup"=> "",

        #: storage/themes/default/bio/edit.php:467
        "Cookie popup allows users to review cookie collection terms"=> "",

        #: storage/themes/default/bio/edit.php:479
        "Share Icon"=> "",

        #: storage/themes/default/bio/edit.php:480
        "Share icon allows users to quickly share the Bio Page"=> "",

        #: storage/themes/default/bio/edit.php:490
        "Please choose a premium package to unlock this feature"=> "",

        #: storage/themes/default/bio/edit.php:493
        "Remove our branding from your Bio Page."=> "",

        #: storage/themes/default/bio/edit.php:502 storage/themes/default/index.php:32
        #: storage/themes/default/partials/shortener.php:94
        #: storage/themes/default/partials/shortenermodal.php:91
        #: storage/themes/default/user/edit.php:594 storage/themes/the23/index.php:44
        "Password Protection"=> "",

        #: storage/themes/default/bio/edit.php:503
        "By adding a password, you can restrict the access"=> "",

        #: storage/themes/default/bio/edit.php:505 storage/themes/default/index.php:33
        #: storage/themes/default/partials/shortener.php:98
        #: storage/themes/default/partials/shortenermodal.php:95
        #: storage/themes/default/user/edit.php:597 storage/themes/the23/index.php:45
        "Type your password here"=> "",

        #: storage/themes/default/bio/edit.php:511
        #: storage/themes/default/partials/shortener.php:338
        #: storage/themes/default/user/edit.php:456
        "Targeting Pixels"=> "",

        #: storage/themes/default/bio/edit.php:512
        #: storage/themes/default/partials/shortener.php:339
        #: storage/themes/default/user/edit.php:457
        "Add your targeting pixels below from the list. Please make sure to enable them in the pixels settings."=> "",

        #: storage/themes/default/bio/edit.php:514
        "Your Pixels"=> "",

        #: storage/themes/default/bio/edit.php:527
        "Custom CSS"=> "",

        #: storage/themes/default/bio/edit.php:535
        #: storage/themes/default/bio/widgets.php:24
        #: storage/themes/default/qr/bulk.php:184
        #: storage/themes/default/qr/bulk.php:381
        #: storage/themes/default/qr/edit.php:603
        #: storage/themes/default/qr/edit.php:815 storage/themes/default/qr/new.php:588
        #: storage/themes/default/qr/new.php:803
        "Upgrade to unlock this feature"=> "",

        #: storage/themes/default/bio/edit.php:543
        "You will be able to download submitted data here once available."=> "",

        #: storage/themes/default/bio/edit.php:546
        #: storage/themes/default/overlay/edit_newsletter.php:136
        "Newsletter Emails"=> "",

        #: storage/themes/default/bio/edit.php:549
        #: storage/themes/default/overlay/edit_newsletter.php:139
        "Collected {c} emails in total"=> "",

        #: storage/themes/default/bio/edit.php:550
        #: storage/themes/default/overlay/edit_newsletter.php:140
        "Download as CSV"=> "",

        #: storage/themes/default/bio/edit.php:559
        "Contacted by {e} on {t}"=> "",

        #: storage/themes/default/bio/edit.php:563
        "Reply"=> "",

        #: storage/themes/default/bio/index.php:12
        #: storage/themes/default/domains/index.php:14
        #: storage/themes/default/domains/new.php:63
        #: storage/themes/default/overlay/index.php:12
        #: storage/themes/default/pixels/index.php:12
        #: storage/themes/default/pricing/table.php:34
        #: storage/themes/default/qr/bulk.php:36 storage/themes/default/qr/index.php:15
        #: storage/themes/default/splash/index.php:12
        #: storage/themes/default/teams/index.php:9
        #: storage/themes/default/user/billing.php:70
        #: storage/themes/default/user/billing.php:71
        #: storage/themes/default/user/billing.php:72
        #: storage/themes/default/user/billing.php:77
        #: storage/themes/default/user/billing.php:79
        #: storage/themes/default/user/channels.php:14
        #: storage/themes/default/user/confirmation.php:73
        #: storage/themes/default/user/confirmation.php:74
        #: storage/themes/default/user/confirmation.php:78
        #: storage/themes/default/user/confirmation.php:79
        #: storage/themes/default/user/confirmation.php:80
        #: storage/themes/default/user/confirmation.php:81
        #: storage/themes/default/user/confirmation.php:82
        #: storage/themes/default/user/confirmation.php:83
        #: storage/themes/default/user/confirmation.php:84
        #: storage/themes/default/user/confirmation.php:85
        #: storage/themes/default/user/confirmation.php:89
        #: storage/themes/default/user/links.php:137
        #: storage/themes/the23/pricing/list.php:48
        "Unlimited"=> "",

        #: storage/themes/default/bio/index.php:14
        #: storage/themes/default/user/campaigns.php:68
        "views"=> "",

        #: storage/themes/default/bio/index.php:20
        #: storage/themes/default/overlay/index.php:17
        #: storage/themes/default/pixels/index.php:17
        #: storage/themes/default/qr/index.php:23
        #: storage/themes/default/splash/index.php:17
        "Search for {t}"=> "",

        #: storage/themes/default/bio/index.php:26
        #: storage/themes/default/qr/index.php:29
        #: storage/themes/default/user/links.php:60
        "Newest"=> "",

        #: storage/themes/default/bio/index.php:27
        #: storage/themes/default/qr/index.php:30
        #: storage/themes/default/user/links.php:61
        "Oldest"=> "",

        #: storage/themes/default/bio/index.php:28
        #: storage/themes/default/pricing/table.php:7
        #: storage/themes/default/pricing/table_list.php:22
        #: storage/themes/default/qr/index.php:31
        #: storage/themes/the23/pricing/categorized.php:6
        #: storage/themes/the23/pricing/list.php:8
        #: storage/themes/the23/pricing/table.php:16
        "Popular"=> "",

        #: storage/themes/default/bio/index.php:55
        "Set as Default"=> "",

        #: storage/themes/default/bio/index.php:58
        #: storage/themes/default/partials/links.php:27
        "Custom QR Code"=> "",

        #: storage/themes/default/bio/index.php:61
        #: storage/themes/default/qr/index.php:53
        #: storage/themes/default/qr/index.php:93
        #: storage/themes/default/user/index.php:76
        #: storage/themes/default/user/links.php:34
        "Add to Channel"=> "",

        #: storage/themes/default/bio/index.php:62
        #: storage/themes/default/partials/links.php:33
        #: storage/themes/default/qr/index.php:94
        "Reset Stats"=> "",

        #: storage/themes/default/bio/index.php:63
        #: storage/themes/default/qr/index.php:95
        "Duplicate"=> "",

        #: storage/themes/default/bio/index.php:83
        #: storage/themes/the23/class/themeSettings.php:180
        #: storage/themes/the23/class/themeSettings.php:205
        "Default"=> "",

        #: storage/themes/default/bio/index.php:85
        #: storage/themes/default/partials/links.php:51
        #: storage/themes/default/teams/index.php:46
        "Disabled"=> "",

        #: storage/themes/default/bio/index.php:88
        #: storage/themes/default/gates/media.php:14
        #: storage/themes/default/user/channel.php:72
        #: storage/themes/the23/gates/media.php:15
        "Views"=> "",

        #: storage/themes/default/bio/index.php:95
        #: storage/themes/default/qr/index.php:118
        #: storage/themes/default/user/channel.php:45
        "Remove from channel"=> "",

        #: storage/themes/default/bio/index.php:110
        #: storage/themes/default/overlay/index.php:68
        #: storage/themes/default/pixels/index.php:86
        #: storage/themes/default/qr/index.php:131
        #: storage/themes/default/splash/index.php:67
        #: storage/themes/default/user/campaigns.php:77
        "No content found. You can create some."=> "",

        #: storage/themes/default/bio/index.php:129
        "A unique name will help you identify your bio page"=> "",

        #: storage/themes/default/bio/index.php:130
        "Please enter a valid name (min 3 characters)"=> "",

        #: storage/themes/default/bio/index.php:136
        #: storage/themes/default/domains/edit.php:7
        #: storage/themes/default/domains/index.php:25
        #: storage/themes/default/domains/new.php:9
        #: storage/themes/default/partials/shortener.php:35
        #: storage/themes/default/partials/shortenermodal.php:32
        #: storage/themes/default/qr/bulk.php:14 storage/themes/default/qr/edit.php:16
        #: storage/themes/default/qr/new.php:14
        #: storage/themes/default/user/campaigns.php:104
        #: storage/themes/default/user/edit.php:553
        #: storage/themes/default/user/import.php:27
        "Domain"=> "",

        #: storage/themes/default/bio/index.php:151
        #: storage/themes/default/user/edit.php:577
        "Alias"=> "",

        #: storage/themes/default/bio/index.php:153
        "Leave this field empty to generate a random alias"=> "",

        #: storage/themes/default/bio/index.php:160
        "Use Template"=> "",

        #: storage/themes/default/bio/index.php:161
        "Select a template to start with a pre-designed bio page."=> "",

        #: storage/themes/default/bio/index.php:173
        "Start from scratch"=> "",

        #: storage/themes/default/bio/index.php:174
        "Create a bio page from scratch"=> "",

        #: storage/themes/default/bio/index.php:202
        #: storage/themes/default/overlay/create.php:15
        #: storage/themes/default/overlay/create_contact.php:158
        #: storage/themes/default/overlay/create_coupon.php:86
        #: storage/themes/default/overlay/create_image.php:72
        #: storage/themes/default/overlay/create_message.php:115
        #: storage/themes/default/overlay/create_newsletter.php:111
        #: storage/themes/default/overlay/create_poll.php:105
        #: storage/themes/default/overlay/index.php:5
        #: storage/themes/default/splash/create.php:76
        #: storage/themes/default/splash/index.php:5
        #: storage/themes/default/user/developers.php:92
        "Create"=> "",

        #: storage/themes/default/bio/index.php:214
        #: storage/themes/default/bio/widgets.php:62
        #: storage/themes/default/domains/index.php:99
        #: storage/themes/default/overlay/create.php:27
        #: storage/themes/default/overlay/index.php:80
        #: storage/themes/default/pixels/index.php:98
        #: storage/themes/default/qr/index.php:147
        #: storage/themes/default/splash/index.php:78
        #: storage/themes/default/teams/index.php:88
        #: storage/themes/default/user/campaigns.php:181
        #: storage/themes/default/user/channels.php:167
        #: storage/themes/default/user/index.php:211
        #: storage/themes/default/user/links.php:160
        "Are you sure you want to delete this?"=> "",

        #: storage/themes/default/bio/index.php:218
        #: storage/themes/default/domains/index.php:103
        #: storage/themes/default/overlay/create.php:31
        #: storage/themes/default/overlay/index.php:84
        #: storage/themes/default/pixels/index.php:102
        #: storage/themes/default/qr/index.php:151
        #: storage/themes/default/splash/index.php:82
        #: storage/themes/default/teams/index.php:92
        #: storage/themes/default/user/campaigns.php:185
        #: storage/themes/default/user/channels.php:171
        #: storage/themes/default/user/index.php:215
        #: storage/themes/default/user/links.php:164
        "You are trying to delete a record. This action is permanent and cannot be reversed."=> "",

        #: storage/themes/default/bio/index.php:222
        #: storage/themes/default/bio/index.php:239
        #: storage/themes/default/bio/widgets.php:70
        #: storage/themes/default/domains/index.php:107
        #: storage/themes/default/overlay/create.php:35
        #: storage/themes/default/overlay/index.php:88
        #: storage/themes/default/pixels/index.php:106
        #: storage/themes/default/qr/index.php:155
        #: storage/themes/default/qr/index.php:173
        #: storage/themes/default/qr/index.php:218
        #: storage/themes/default/splash/index.php:86
        #: storage/themes/default/teams/index.php:96
        #: storage/themes/default/user/campaigns.php:189
        #: storage/themes/default/user/channel.php:98
        #: storage/themes/default/user/channels.php:175
        #: storage/themes/default/user/index.php:219
        #: storage/themes/default/user/index.php:236
        #: storage/themes/default/user/index.php:253
        #: storage/themes/default/user/links.php:168
        #: storage/themes/default/user/links.php:185
        #: storage/themes/default/user/links.php:202
        "Confirm"=> "",

        #: storage/themes/default/bio/index.php:231
        #: storage/themes/default/qr/index.php:165
        #: storage/themes/default/user/index.php:245
        #: storage/themes/default/user/links.php:194
        "Are you sure you want to reset this?"=> "",

        #: storage/themes/default/bio/index.php:235
        #: storage/themes/default/qr/index.php:169
        #: storage/themes/default/user/index.php:249
        #: storage/themes/default/user/links.php:198
        "You are trying to reset all statistic data for this link. This action is permanent and cannot be reversed."=> "",

        #: storage/themes/default/bio/index.php:251
        #: storage/themes/default/qr/index.php:184
        #: storage/themes/default/user/index.php:294
        #: storage/themes/default/user/links.php:243
        "Add to Channels"=> "",

        #: storage/themes/default/bio/widgets.php:14
        #: storage/themes/default/bio/widgets.php:15
        #: storage/themes/default/blog/menu.php:50
        #: storage/themes/default/blog/menu.php:53
        #: storage/themes/default/help/top.php:14
        #: storage/themes/default/help/top.php:18 storage/themes/the23/blog/menu.php:47
        #: storage/themes/the23/blog/menu.php:49 storage/themes/the23/help/top.php:10
        #: storage/themes/the23/help/top.php:12
        "Search"=> "",

        #: storage/themes/default/bio/widgets.php:66
        "You are trying to delete a block. Please changes only take effect when you update the bio page."=> "",

        #: storage/themes/default/blog/categories.php:28
        #: storage/themes/default/blog/index.php:24
        #: storage/themes/default/blog/search.php:28
        #: storage/themes/the23/blog/categories.php:33
        #: storage/themes/the23/blog/index.php:33
        #: storage/themes/the23/blog/search.php:41
        "Popular Posts"=> "",

        #: storage/themes/default/blog/menu.php:14
        #: storage/themes/the23/blog/menu.php:13
        "More"=> "",

        #: storage/themes/default/blog/search.php:23
        #: storage/themes/default/help/search.php:33
        #: storage/themes/the23/blog/search.php:23
        #: storage/themes/the23/blog/search.php:36
        #: storage/themes/the23/help/search.php:33
        "No results"=> "",

        #: storage/themes/default/blog/single.php:31
        "Published on"=> "",

        #: storage/themes/default/blog/single.php:73
        #: storage/themes/the23/blog/single.php:62
        "Keep reading"=> "",

        #: storage/themes/default/blog/single.php:74
        #: storage/themes/the23/blog/single.php:63
        "More posts from our blog"=> "",

        #: storage/themes/default/blog/single.php:77
        #: storage/themes/default/stats/index.php:26
        #: storage/themes/default/user/index.php:51
        #: storage/themes/default/user/index.php:131
        #: storage/themes/the23/blog/single.php:66
        "View all"=> "",

        #: storage/themes/default/class/themeSettings.php:132
        "Color 1"=> "",

        #: storage/themes/default/class/themeSettings.php:138
        "Color 2"=> "",

        #: storage/themes/default/class/themeSettings.php:154
        #: storage/themes/the23/class/themeSettings.php:348
        "Language Selector"=> "",

        #: storage/themes/default/class/themeSettings.php:159
        #: storage/themes/the23/class/themeSettings.php:353
        "Top & Bottom"=> "",

        #: storage/themes/default/class/themeSettings.php:282
        #: storage/themes/default/class/themeSettings.php:306
        #: storage/themes/the23/class/themeSettings.php:511
        #: storage/themes/the23/class/themeSettings.php:535
        "The custom image is not valid. Only a JPG or PNG are accepted."=> "",

        #: storage/themes/default/class/themeSettings.php:284
        #: storage/themes/default/class/themeSettings.php:308
        #: storage/themes/the23/class/themeSettings.php:513
        #: storage/themes/the23/class/themeSettings.php:537
        "Custom image must be either a PNG or a JPEG (Max 500kb)."=> "",

        #: storage/themes/default/class/themeSettings.php:331
        #: storage/themes/the23/class/themeSettings.php:563
        "Settings are successfully saved."=> "",

        #: storage/themes/default/domains/edit.php:13
        #: storage/themes/default/domains/new.php:16
        "Custom Redirect"=> "",

        #: storage/themes/default/domains/edit.php:14
        #: storage/themes/default/domains/edit.php:25
        #: storage/themes/default/domains/new.php:17
        #: storage/themes/default/domains/new.php:28
        #: storage/themes/default/stats/partial.php:12
        #: storage/themes/default/user/activity.php:53
        #: storage/themes/default/user/index.php:147
        "Bio Page"=> "",

        #: storage/themes/default/domains/edit.php:18
        #: storage/themes/default/domains/edit.php:38
        #: storage/themes/default/domains/index.php:26
        #: storage/themes/default/domains/new.php:21
        #: storage/themes/default/domains/new.php:41
        "Domain Root"=> "",

        #: storage/themes/default/domains/edit.php:20
        #: storage/themes/default/domains/edit.php:40
        #: storage/themes/default/domains/new.php:23
        #: storage/themes/default/domains/new.php:43
        "Redirects to this page if someone visits the root domain above without a short alias."=> "",

        #: storage/themes/default/domains/edit.php:33
        #: storage/themes/default/domains/new.php:36
        "Assign a Bio Page to be accessed from your root domain."=> "",

        #: storage/themes/default/domains/edit.php:44
        #: storage/themes/default/domains/new.php:48
        "Domain 404"=> "",

        #: storage/themes/default/domains/edit.php:46
        #: storage/themes/default/domains/new.php:50
        "Redirects to this page if a short url is not found (error 404)."=> "",

        #: storage/themes/default/domains/edit.php:49
        "Update Domain"=> "",

        #: storage/themes/default/domains/index.php:7
        #: storage/themes/default/domains/new.php:53
        "Add Domain"=> "",

        #: storage/themes/default/domains/index.php:27
        "404 Redirect"=> "",

        #: storage/themes/default/domains/index.php:37
        #: storage/themes/default/teams/index.php:46
        #: storage/themes/default/user/billing.php:21
        #: storage/themes/default/user/campaigns.php:48
        "Active"=> "",

        #: storage/themes/default/domains/index.php:39
        "Pending DNS"=> "",

        #: storage/themes/default/domains/index.php:41
        "Inactive/Disabled"=> "",

        #: storage/themes/default/domains/index.php:78
        #: storage/themes/default/domains/new.php:70
        "How to setup custom domain"=> "",

        #: storage/themes/default/domains/index.php:82
        "If you have a custom domain name that you want to use with our service, you can associate it to your account very easily. Once added, we will add the domain to your account and set it as the default domain name for your URLs. DNS changes could take up to 36 hours. If you are planning to serve SSL on your domain name, we recommend using cloudflare."=> "",

        #: storage/themes/default/domains/index.php:85
        #: storage/themes/default/domains/new.php:77
        "To point your domain name, create an A record and set the value to "=> "",

        #: storage/themes/default/domains/index.php:87
        "To point your subdomain domain name, create a CNAME record and set the value to "=> "",

        #: storage/themes/default/domains/new.php:11
        "You will need to setup a DNS record for your domain to work. See instructions on the right side."=> "",

        #: storage/themes/default/domains/new.php:74
        "If you have a custom domain name that you want to use with our service, you can associate it to your account very easily. Once added, we will add the domain to your account and set it as the default domain name for your URLs. DNS changes could take up to 36 hours."=> "",

        #: storage/themes/default/domains/new.php:79
        "To point your domain name, create a CNAME record and set the value to "=> "",

        #: storage/themes/default/errors/404.php:26
        #: storage/themes/the23/errors/404.php:39
        "Error"=> "",

        #: storage/themes/default/errors/404.php:28
        #: storage/themes/the23/errors/404.php:41
        "The page you are looking for could not be found."=> "",

        #: storage/themes/default/errors/404.php:32
        #: storage/themes/default/errors/disabled.php:32
        #: storage/themes/default/errors/expired.php:31
        #: storage/themes/the23/errors/404.php:44
        #: storage/themes/the23/errors/disabled.php:45
        #: storage/themes/the23/errors/expired.php:44
        "Back to home"=> "",

        #: storage/themes/default/errors/disabled.php:26
        "Stop"=> "",

        #: storage/themes/default/errors/disabled.php:28
        #: storage/themes/the23/errors/disabled.php:41
        "There is a problem with this link and we have blocked it either because it is potentially malicious or contains inappropriate content that is against our terms of service. We actively monitor all links on our platform to ensure the safety of all our users. If you have any questions, feel free to contact us."=> "",

        #: storage/themes/default/errors/expired.php:25
        #: storage/themes/the23/errors/disabled.php:39
        #: storage/themes/the23/errors/expired.php:39
        "Oops"=> "",

        #: storage/themes/default/errors/expired.php:27
        #: storage/themes/the23/errors/expired.php:41
        "The link you are trying to access is now expired either because the campaign ended or the link was disabled. If you have any questions, feel free to contact us."=> "",

        #: storage/themes/default/gates/custom.php:12
        #: storage/themes/default/splash/edit.php:103
        #: storage/themes/the23/gates/custom.php:13
        "View site"=> "",

        #: storage/themes/default/gates/custom.php:21
        #: storage/themes/the23/gates/custom.php:22
        "Powered by"=> "",

        #: storage/themes/default/gates/domain.php:8
        #: storage/themes/the23/gates/domain.php:8
        "Custom domain working"=> "",

        #: storage/themes/default/gates/domain.php:9
        #: storage/themes/the23/gates/domain.php:9
        "Your <strong>domain name</strong> is now successfully pointed to our server. You can now start using it from the platform and shorten branded links with your own domain name."=> "",

        #: storage/themes/default/gates/domain.php:10
        #: storage/themes/the23/gates/domain.php:10
        "If you want to display another page instead of this page when someone accesses your root domain name, you can define that link in your settings by logging in to your account. You can also define a custom 404 error page."=> "",

        #: storage/themes/default/gates/domain.php:11
        #: storage/themes/the23/gates/domain.php:11
        "If you have any questions, please do not hesitate to contact us."=> "",

        #: storage/themes/default/gates/domain.php:16
        #: storage/themes/default/help/single.php:26
        #: storage/themes/default/layouts/api.php:100
        #: storage/themes/default/layouts/auth.php:67
        #: storage/themes/default/layouts/main.php:108
        #: storage/themes/default/layouts/stats.php:107
        #: storage/themes/default/pages/bio.php:13
        #: storage/themes/default/pages/qr.php:307
        #: storage/themes/default/user/confirmation.php:62
        #: storage/themes/the23/gates/domain.php:16
        #: storage/themes/the23/help/single.php:24
        #: storage/themes/the23/pages/affiliate.php:23
        #: storage/themes/the23/partials/languagejs.php:40
        #: storage/themes/the23/pricing/index.php:62
        "Contact us"=> "",

        #: storage/themes/default/gates/frame.php:18
        #: storage/themes/default/layouts/api.php:80
        #: storage/themes/default/layouts/auth.php:47
        #: storage/themes/default/layouts/dashboard.php:139
        #: storage/themes/default/layouts/main.php:88
        #: storage/themes/default/layouts/stats.php:87
        #: storage/themes/default/pricing/checkout.php:194
        #: storage/themes/default/pricing/checkout.php:211
        #: storage/themes/default/user/developers.php:91
        #: storage/themes/the23/gates/frame.php:16
        #: storage/themes/the23/partials/languagejs.php:20
        "Close"=> "",

        #: storage/themes/default/gates/media.php:26
        #: storage/themes/the23/gates/media.php:27
        "Short URL"=> "",

        #: storage/themes/default/gates/media.php:33
        #: storage/themes/default/gates/media.php:34
        #: storage/themes/default/gates/profile.php:162
        #: storage/themes/default/gates/profile.php:164
        #: storage/themes/default/gates/profile.php:166
        #: storage/themes/default/gates/profile.php:168
        #: storage/themes/default/gates/profile.php:170
        #: storage/themes/the23/gates/media.php:34
        #: storage/themes/the23/gates/media.php:35
        #: storage/themes/the23/gates/media.php:37
        #: storage/themes/the23/gates/media.php:38
        "Share on"=> "",

        #: storage/themes/default/gates/password.php:14
        #: storage/themes/the23/gates/password.php:9
        "Enter Password"=> "",

        #: storage/themes/default/gates/password.php:15
        #: storage/themes/the23/gates/password.php:10
        "The access to this URL is restricted. Please enter your password to view it."=> "",

        #: storage/themes/default/gates/password.php:31
        #: storage/themes/the23/gates/password.php:23
        "Unlock"=> "",

        #: storage/themes/default/gates/profile.php:16
        #: storage/themes/default/gates/profile.php:46
        #: storage/themes/default/gates/profile.php:79
        "Verified Account"=> "",

        #: storage/themes/default/gates/profile.php:172
        "Share via Email"=> "",

        #: storage/themes/default/gates/profile.php:179
        #: storage/themes/default/layouts/dashboard.php:89
        #: storage/themes/default/partials/footer.php:103
        #: storage/themes/the23/partials/footer.php:105
        "Report"=> "",

        #: storage/themes/default/gates/profile.php:182
        "Create your own BioPage"=> "",

        #: storage/themes/default/gates/splash.php:13
        #: storage/themes/the23/gates/splash.php:14
        "You are about to be redirected to another page."=> "",

        #: storage/themes/default/gates/splash.php:24
        #: storage/themes/the23/gates/splash.php:25
        "Redirect me"=> "",

        #: storage/themes/default/gates/splash.php:27
        #: storage/themes/default/pages/consent.php:17
        #: storage/themes/the23/gates/splash.php:28
        #: storage/themes/the23/pages/consent.php:16
        "Take me to your homepage"=> "",

        #: storage/themes/default/gates/splash.php:32
        #: storage/themes/the23/gates/splash.php:33
        "You are about to be redirected to another page. We are not responsible for the content of that page or the consequences it may have on you."=> "",

        #: storage/themes/default/help/category.php:6
        #: storage/themes/default/help/search.php:6
        #: storage/themes/default/help/single.php:6
        #: storage/themes/default/partials/main_menu.php:3
        #: storage/themes/the23/blog/single.php:9
        #: storage/themes/the23/help/category.php:6
        #: storage/themes/the23/help/search.php:6
        #: storage/themes/the23/help/single.php:8
        "Home"=> "",

        #: storage/themes/default/help/category.php:41
        #: storage/themes/default/help/index.php:53
        #: storage/themes/default/help/search.php:26
        #: storage/themes/the23/help/category.php:39
        #: storage/themes/the23/help/index.php:49
        #: storage/themes/the23/help/search.php:26
        "Updated {t}"=> "",

        #: storage/themes/default/help/index.php:5
        #: storage/themes/the23/help/index.php:5
        "Browse Topics"=> "",

        #: storage/themes/default/help/index.php:29
        #: storage/themes/the23/help/index.php:25
        "articles"=> "",

        #: storage/themes/default/help/index.php:39
        #: storage/themes/the23/help/index.php:35
        "Common Questions"=> "",

        #: storage/themes/default/help/search.php:11
        "Search for \"{q}\""=> "",

        #: storage/themes/default/help/single.php:25
        #: storage/themes/the23/help/single.php:23
        "Did not answer your question?"=> "",

        #: storage/themes/default/help/single.php:30
        #: storage/themes/the23/help/single.php:30
        "Related Questions"=> "",

        #: storage/themes/default/index.php:15 storage/themes/the23/index.php:24
        "Paste a long url"=> "",

        #: storage/themes/default/index.php:18
        #: storage/themes/default/partials/shortener.php:18
        #: storage/themes/default/partials/shortenermodal.php:21
        #: storage/themes/the23/index.php:30
        "Shorten"=> "",

        #: storage/themes/default/index.php:22 storage/themes/the23/index.php:34
        "Advanced"=> "",

        #: storage/themes/default/index.php:27
        #: storage/themes/default/partials/shortener.php:69
        #: storage/themes/default/partials/shortenermodal.php:66
        #: storage/themes/default/user/edit.php:589 storage/themes/the23/index.php:39
        "Type your custom alias here"=> "",

        #: storage/themes/default/index.php:44 storage/themes/the23/index.php:56
        "Your link has been successfully shortened. Want to more customization options?"=> "",

        #: storage/themes/default/index.php:45 storage/themes/the23/index.php:57
        "Get started"=> "",

        #: storage/themes/default/index.php:72 storage/themes/the23/index.php:27
        #: storage/themes/the23/index.php:808
        "Your latest links"=> "",

        #: storage/themes/default/index.php:80 storage/themes/the23/index.php:818
        "Want more options to customize the link, QR codes, branding and advanced metrics?"=> "",

        #: storage/themes/default/index.php:103
        "Latest links"=> "",

        #: storage/themes/default/index.php:122 storage/themes/the23/index.php:255
        "One short link, infinite possibilities."=> "",

        #: storage/themes/default/index.php:125 storage/themes/the23/index.php:258
        "A short link is a powerful marketing tool when you use it carefully. It is not just a link but a medium between your customer and their destination. A short link allows you to collect so much data about your customers and their behaviors."=> "",

        #: storage/themes/default/index.php:139 storage/themes/the23/index.php:419
        "Smart Targeting"=> "",

        #: storage/themes/default/index.php:141
        "Target your customers to increase your reach and redirect them to a relevant page. Add a pixel to retarget them in your social media ad campaign to capture them."=> "",

        #: storage/themes/default/index.php:156
        "In-Depth Analytics"=> "",

        #: storage/themes/default/index.php:158
        "Share your links to your network and measure data to optimize your marketing campaign's performance. Reach an audience that fits your needs."=> "",

        #: storage/themes/default/index.php:173
        "Digital Experience"=> "",

        #: storage/themes/default/index.php:175
        "Use various powerful tools increase conversion and provide a non-intrusive experience to your customers without disengaging them."=> "",

        #: storage/themes/default/index.php:189 storage/themes/default/index.php:235
        "Perfect for sales & marketing"=> "",

        #: storage/themes/default/index.php:191 storage/themes/default/index.php:388
        #: storage/themes/the23/index.php:519
        "Understanding your users and customers will help you increase your conversion. Our system allows you to track everything. Whether it is the amount of clicks, the country or the referrer, the data is there for you to analyze it."=> "",

        #: storage/themes/default/index.php:202
        "Redirection Tools"=> "",

        #: storage/themes/default/index.php:214
        "Powerful Statistics"=> "",

        #: storage/themes/default/index.php:226
        "Beautiful Profiles"=> "",

        #: storage/themes/default/index.php:244 storage/themes/default/index.php:290
        #: storage/themes/default/index.php:301
        "Powerful tools that work"=> "",

        #: storage/themes/default/index.php:246
        "Our product lets your target your users to better understand their behavior and provide them a better overall experience through smart re-targeting. We provide you many powerful tools to reach them better."=> "",

        #: storage/themes/default/index.php:257
        #: storage/themes/default/partials/sidebar_menu.php:106
        "Link Management"=> "",

        #: storage/themes/default/index.php:269
        "Privacy Control"=> "",

        #: storage/themes/default/index.php:281
        "Powerful Dashboard"=> "",

        #: storage/themes/default/index.php:327 storage/themes/default/index.php:331
        #: storage/themes/the23/index.php:470 storage/themes/the23/index.php:484
        #: storage/themes/the23/index.php:488 storage/themes/the23/index.php:498
        "New York, United States"=> "",

        #: storage/themes/default/index.php:329 storage/themes/default/index.php:349
        #: storage/themes/default/index.php:369
        "Someone visited your link"=> "",

        #: storage/themes/default/index.php:337 storage/themes/default/index.php:357
        #: storage/themes/default/index.php:377 storage/themes/the23/index.php:478
        #: storage/themes/the23/index.php:492 storage/themes/the23/index.php:506
        "{d} minutes ago"=> "",

        #: storage/themes/default/index.php:347 storage/themes/default/index.php:351
        #: storage/themes/the23/index.php:474
        "Paris, France"=> "",

        #: storage/themes/default/index.php:367 storage/themes/default/index.php:371
        #: storage/themes/the23/index.php:502
        "London, United Kingdom"=> "",

        #: storage/themes/default/index.php:386
        "Optimize your marketing strategy"=> "",

        #: storage/themes/default/index.php:399
        "More features than asked for"=> "",

        #: storage/themes/default/index.php:446
        #: storage/themes/default/user/confirmation.php:82
        #: storage/themes/the23/index.php:410
        "Event Tracking"=> "",

        #: storage/themes/default/index.php:463 storage/themes/the23/index.php:428
        "Team Management"=> "",

        #: storage/themes/default/index.php:480 storage/themes/the23/index.php:437
        "Branded Domain Names"=> "",

        #: storage/themes/default/index.php:497
        "Robust API"=> "",

        #: storage/themes/default/index.php:514
        "Connect with popular tools and boost your productivity."=> "",

        #: storage/themes/default/index.php:596
        "What our customers say about us"=> "",

        #: storage/themes/default/index.php:630 storage/themes/the23/index.php:743
        "Powering"=> "",

        #: storage/themes/default/index.php:640 storage/themes/the23/index.php:753
        "Serving"=> "",

        #: storage/themes/default/index.php:650 storage/themes/the23/index.php:765
        "Trusted by"=> "",

        #: storage/themes/default/index.php:655
        "Happy Customers"=> "",

        #: storage/themes/default/integrations/index.php:22
        #: storage/themes/default/integrations/slack.php:6
        #: storage/themes/default/integrations/zapier.php:6
        "Connected"=> "",

        #: storage/themes/default/integrations/index.php:25
        "Visit"=> "",

        #: storage/themes/default/integrations/index.php:33
        "Connect"=> "",

        #: storage/themes/default/integrations/index.php:52
        "Create your own integration to shorten links and interact with other features with our powerful API."=> "",

        #: storage/themes/default/integrations/mailchimp.php:13
        "Connect your Mailchimp account to automatically add newsletter subscribers to your lists."=> "",

        #: storage/themes/default/integrations/mailchimp.php:17
        "Mailchimp API Key"=> "",

        #: storage/themes/default/integrations/mailchimp.php:20
        "You can find your API key in your Mailchimp account under Account & Billing > Extras > API keys."=> "",

        #: storage/themes/default/integrations/mailchimp.php:21
        #: storage/themes/default/layouts/dashboard.php:130
        #: storage/themes/default/overlay/create_message.php:54
        #: storage/themes/default/overlay/create_message.php:126
        #: storage/themes/default/overlay/edit_message.php:54
        #: storage/themes/the23/index.php:189 storage/themes/the23/index.php:211
        #: storage/themes/the23/index.php:239
        "Learn more"=> "",

        #: storage/themes/default/integrations/mailchimp.php:25
        "Save API Key"=> "",

        #: storage/themes/default/integrations/mailchimp.php:27
        "Refresh Lists"=> "",

        #: storage/themes/default/integrations/mailchimp.php:37
        "Available Lists"=> "",

        #: storage/themes/default/integrations/mailchimp.php:38
        "These are the lists available in your Mailchimp account. You can select one when configuring your Newsletter widget."=> "",

        #: storage/themes/default/integrations/mailchimp.php:52
        "No lists found or unable to connect to Mailchimp. Please verify your API key is correct."=> "",

        #: storage/themes/default/integrations/mailchimp.php:59
        "How it works"=> "",

        #: storage/themes/default/integrations/mailchimp.php:61
        "Enter your Mailchimp API key above"=> "",

        #: storage/themes/default/integrations/mailchimp.php:62
        "Go to your Bio Page editor"=> "",

        #: storage/themes/default/integrations/mailchimp.php:63
        "Add a Newsletter widget"=> "",

        #: storage/themes/default/integrations/mailchimp.php:64
        "Enable Mailchimp and select a list"=> "",

        #: storage/themes/default/integrations/mailchimp.php:65
        "Subscribers will be automatically added to your Mailchimp list"=> "",

        #: storage/themes/default/integrations/shortcuts.php:10
        "Shortcuts in an app developed by Apple and it allows you to create an automation. You can download our powerful Shortcut and you will be able to shorten links in a snap and save it directly in your account."=> "",

        #: storage/themes/default/integrations/shortcuts.php:12
        "How does it work?"=> "",

        #: storage/themes/default/integrations/shortcuts.php:14
        "The Shortcut works in various ways:"=> "",

        #: storage/themes/default/integrations/shortcuts.php:16
        "Safari"=> "",

        #: storage/themes/default/integrations/shortcuts.php:18
        "If you want shorten the current viewing page, tap the share icon at the bottom of the screen and it will shorten the current URL. It will copy the short URL directly to your clipboard so you can paste it somewhere."=> "",

        #: storage/themes/default/integrations/shortcuts.php:20
        "Siri"=> "",

        #: storage/themes/default/integrations/shortcuts.php:22
        "To use Siri, copy a link and ask Siri \"Shorten Link\" and it will shorten the link for you and copy it to your clipboard."=> "",

        #: storage/themes/default/integrations/shortcuts.php:24
        "Manual"=> "",

        #: storage/themes/default/integrations/shortcuts.php:26
        "You can also run the Shortcut by just holding a link then tap Share and you will see Shorten Link in the list."=> "",

        #: storage/themes/default/integrations/shortcuts.php:32
        "How to install it?"=> "",

        #: storage/themes/default/integrations/shortcuts.php:36
        "Make sure you have the Shortcuts app, if not you can download it from the App Store: "=> "",

        #: storage/themes/default/integrations/shortcuts.php:40
        "Download Shortcuts"=> "",

        #: storage/themes/default/integrations/shortcuts.php:48
        "Download our Shortcut"=> "",

        #: storage/themes/default/integrations/shortcuts.php:57
        "After installation, you will be presented with a configuration screen where you need to enter the API URL and the API key"=> "",

        #: storage/themes/default/integrations/shortcuts.php:58
        "API URL"=> "",

        #: storage/themes/default/integrations/shortcuts.php:67
        "After the configuration is complete, you can start shortening links directly from your device in a single tap."=> "",

        #: storage/themes/default/integrations/slack.php:14
        "You can integrate this app with your Slack account and shorten directly from the Slack interface using the command line below. This Slack integration will save all of your links in your account in case you need to access them later. Please see below how to use the command."=> "",

        #: storage/themes/default/integrations/slack.php:22
        "The Slack command will return you the short link if everything goes well. In case there is an error, it will return you the error."=> "",

        #: storage/themes/default/integrations/slack.php:24
        "If you have set a default domain in your Settings, it will attempt to use that domain to shorten links."=> "",

        #: storage/themes/default/integrations/slack.php:26
        "Slack Command"=> "",

        #: storage/themes/default/integrations/slack.php:29
        "Shorten link"=> "",

        #: storage/themes/default/integrations/slack.php:32
        "Shorten link with custom name"=> "",

        #: storage/themes/default/integrations/slack.php:33
        "To send a custom alias, use the following parameter (ABCDXYZ). This will tell the script to shorten the link with the custom alias ABCDXYZ."=> "",

        #: storage/themes/default/integrations/slack.php:36
        "Get last 5 clicks"=> "",

        #: storage/themes/default/integrations/slack.php:37
        "You can get last 5 clicks if you preceed the short link with \"clicks:\" as follows."=> "",

        #: storage/themes/default/integrations/slack.php:40
        #: storage/themes/default/partials/main_menu.php:163
        #: storage/themes/the23/partials/main_menu.php:209
        "Help"=> "",

        #: storage/themes/default/integrations/slack.php:41
        "You can always use the help command if you need help or remind you how it works."=> "",

        #: storage/themes/default/integrations/wordpress.php:12
        #: storage/themes/default/integrations/wordpress.php:22
        "WordPress Plugin"=> "",

        #: storage/themes/default/integrations/wordpress.php:13
        "WordPress Function"=> "",

        #: storage/themes/default/integrations/wordpress.php:25
        "You can easily use a shortcode to shorten links with our WordPress plugin. You just need to download it below and upload it in WordPress and that is it. There is no need to configure it as it will be already configured for you. All of your links will be saved in your account."=> "",

        #: storage/themes/default/integrations/wordpress.php:27
        "Do not share this plugin with anyone you do not trust as they will have access to the full API and essentially your account."=> "",

        #: storage/themes/default/integrations/wordpress.php:29
        #: storage/themes/default/integrations/wordpress.php:58
        "Instructions"=> "",

        #: storage/themes/default/integrations/wordpress.php:31
        "Download the plugin below"=> "",

        #: storage/themes/default/integrations/wordpress.php:32
        #: storage/themes/default/integrations/wordpress.php:61
        "Go to WordPress Admin"=> "",

        #: storage/themes/default/integrations/wordpress.php:32
        "Plugins"=> "",

        #: storage/themes/default/integrations/wordpress.php:32
        "Add New"=> "",

        #: storage/themes/default/integrations/wordpress.php:32
        "Upload Plugin"=> "",

        #: storage/themes/default/integrations/wordpress.php:33
        "Upload the plugin named linkshortenershortcode.zip and activate it. The plugin will be named Link Shortener Shortcode."=> "",

        #: storage/themes/default/integrations/wordpress.php:36
        "Download Plugin"=> "",

        #: storage/themes/default/integrations/wordpress.php:40
        #: storage/themes/default/integrations/wordpress.php:101
        #: storage/themes/default/user/tools.php:25
        "Examples"=> "",

        #: storage/themes/default/integrations/wordpress.php:42
        #: storage/themes/default/integrations/wordpress.php:103
        "The following code will apply the shortcode \"shorturl\" to the system and you will be able to use the following format."=> "",

        #: storage/themes/default/integrations/wordpress.php:45
        #: storage/themes/default/integrations/wordpress.php:106
        "You can also use the shortcode in html."=> "",

        #: storage/themes/default/integrations/wordpress.php:53
        "WordPress Shortcode Function"=> "",

        #: storage/themes/default/integrations/wordpress.php:56
        "You can now shorten links directly from WordPress using shortcode. If you don't want to upload a plugin, you can use this method. It is very easy to setup and it works with all versions of WordPress and with any theme. All links you will shorten will be safely stored in your account."=> "",

        #: storage/themes/default/integrations/wordpress.php:60
        "Copy your unique php code below"=> "",

        #: storage/themes/default/integrations/wordpress.php:61
        "Appearance"=> "",

        #: storage/themes/default/integrations/wordpress.php:61
        "Theme File Editor"=> "",

        #: storage/themes/default/integrations/wordpress.php:62
        "On the right side, under Theme Files, find and click on Theme Functions (functions.php)"=> "",

        #: storage/themes/default/integrations/wordpress.php:63
        "Paste the code below at the very end of the file and save"=> "",

        #: storage/themes/default/integrations/wordpress.php:65
        "Your Unique Code"=> "",

        #: storage/themes/default/integrations/wordpress.php:67
        "Do not share this code with anyone you do not trust as they will have access to the full API and essentially your account."=> "",

        #: storage/themes/default/integrations/zapier.php:13
        "You can use Zapier to automate campaigns. By adding the URL to the zapier webhook, we will send you important information to that webhook so you can use them."=> "",

        #: storage/themes/default/integrations/zapier.php:14
        #: storage/themes/default/partials/links.php:98
        "Note"=> "",

        #: storage/themes/default/integrations/zapier.php:14
        "Although this tool is designed for Zapier, it can be used for any webhook system."=> "",

        #: storage/themes/default/integrations/zapier.php:17
        #: storage/themes/default/integrations/zapier.php:34
        "URL Zapier Notification"=> "",

        #: storage/themes/default/integrations/zapier.php:19
        "We will send a notification to this URL when you create a short URL."=> "",

        #: storage/themes/default/integrations/zapier.php:22
        #: storage/themes/default/integrations/zapier.php:38
        "Views Zapier Notification"=> "",

        #: storage/themes/default/integrations/zapier.php:24
        "We will send a notification to this URL when someone clicks your URL."=> "",

        #: storage/themes/default/integrations/zapier.php:27
        #: storage/themes/default/user/affiliate.php:104
        #: storage/themes/default/user/withdrawals.php:67
        "Save"=> "",

        #: storage/themes/default/integrations/zapier.php:31
        "Sample Response"=> "",

        #: storage/themes/default/invoice.php:2 storage/themes/default/invoice.php:32
        "Invoice"=> "",

        #: storage/themes/default/invoice.php:25
        #: storage/themes/default/user/affiliate.php:67
        #: storage/themes/default/user/verification.php:88
        #: storage/themes/default/user/withdrawals.php:23
        "Pending"=> "",

        #: storage/themes/default/invoice.php:36
        "Payment Date"=> "",

        #: storage/themes/default/invoice.php:45
        "Bill to"=> "",

        #: storage/themes/default/invoice.php:49
        "Tax ID:"=> "",

        #: storage/themes/default/invoice.php:63
        "Payment To"=> "",

        #: storage/themes/default/invoice.php:82 storage/themes/default/invoice.php:96
        "Subscription"=> "",

        #: storage/themes/default/invoice.php:90
        "Tax"=> "",

        #: storage/themes/default/invoice.php:105
        #: storage/themes/default/overlay/edit_poll.php:131
        #: storage/themes/default/pricing/checkout.php:160
        #: storage/themes/the23/pricing/checkout.php:183
        "Total"=> "",

        #: storage/themes/default/layouts/api.php:64
        #: storage/themes/default/layouts/auth.php:31
        #: storage/themes/default/layouts/dashboard.php:131
        #: storage/themes/default/layouts/main.php:72
        #: storage/themes/default/layouts/stats.php:71
        #: storage/themes/the23/partials/languagejs.php:4
        "The coupon enter is not valid"=> "",

        #: storage/themes/default/layouts/api.php:65
        #: storage/themes/default/layouts/auth.php:32
        #: storage/themes/default/layouts/dashboard.php:132
        #: storage/themes/default/layouts/main.php:73
        #: storage/themes/default/layouts/stats.php:72
        #: storage/themes/the23/partials/languagejs.php:5
        "You must select at least 1 url."=> "",

        #: storage/themes/default/layouts/api.php:67
        #: storage/themes/default/layouts/auth.php:34
        #: storage/themes/default/layouts/dashboard.php:134
        #: storage/themes/default/layouts/main.php:75
        #: storage/themes/default/layouts/stats.php:74
        #: storage/themes/the23/partials/languagejs.php:7
        "No data is available for this request."=> "",

        #: storage/themes/default/layouts/api.php:75
        #: storage/themes/default/layouts/auth.php:42
        #: storage/themes/default/layouts/main.php:83
        #: storage/themes/default/layouts/stats.php:82
        #: storage/themes/the23/partials/languagejs.php:15
        "Cookie Preferences"=> "",

        #: storage/themes/default/layouts/api.php:76
        #: storage/themes/default/layouts/auth.php:43
        #: storage/themes/default/layouts/main.php:84
        #: storage/themes/default/layouts/stats.php:83
        #: storage/themes/the23/partials/languagejs.php:16
        "This website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. You have the option to choose which one to allow."=> "",

        #: storage/themes/default/layouts/api.php:77
        #: storage/themes/default/layouts/auth.php:44
        #: storage/themes/default/layouts/main.php:85
        #: storage/themes/default/layouts/stats.php:84
        #: storage/themes/the23/partials/languagejs.php:17
        "Let me choose"=> "",

        #: storage/themes/default/layouts/api.php:78
        #: storage/themes/default/layouts/auth.php:45
        #: storage/themes/default/layouts/main.php:86
        #: storage/themes/default/layouts/stats.php:85
        #: storage/themes/the23/partials/languagejs.php:18
        "Accept All"=> "",

        #: storage/themes/default/layouts/api.php:79
        #: storage/themes/default/layouts/auth.php:46
        #: storage/themes/default/layouts/main.php:87
        #: storage/themes/default/layouts/stats.php:86
        #: storage/themes/the23/partials/languagejs.php:19
        "Accept Necessary"=> "",

        #: storage/themes/default/layouts/api.php:81
        #: storage/themes/default/layouts/auth.php:48
        #: storage/themes/default/layouts/main.php:89
        #: storage/themes/default/layouts/stats.php:88
        #: storage/themes/the23/class/themeSettings.php:321
        #: storage/themes/the23/class/themeSettings.php:365
        #: storage/themes/the23/class/themeSettings.php:417
        #: storage/themes/the23/partials/languagejs.php:21
        "Save Settings"=> "",

        #: storage/themes/default/layouts/api.php:83
        #: storage/themes/default/layouts/auth.php:50
        #: storage/themes/default/layouts/main.php:91
        #: storage/themes/default/layouts/stats.php:90
        #: storage/themes/the23/partials/languagejs.php:23
        "Strictly Necessary Cookies"=> "",

        #: storage/themes/default/layouts/api.php:84
        #: storage/themes/default/layouts/auth.php:51
        #: storage/themes/default/layouts/main.php:92
        #: storage/themes/default/layouts/stats.php:91
        #: storage/themes/the23/partials/languagejs.php:24
        "These cookies are required for the correct functioning of our service and without these cookies you will not be able to use our product."=> "",

        #: storage/themes/default/layouts/api.php:87
        #: storage/themes/default/layouts/auth.php:54
        #: storage/themes/default/layouts/main.php:95
        #: storage/themes/default/layouts/stats.php:94
        #: storage/themes/the23/partials/languagejs.php:27
        "Targeting and Analytics"=> "",

        #: storage/themes/default/layouts/api.php:88
        #: storage/themes/default/layouts/auth.php:55
        #: storage/themes/default/layouts/main.php:96
        #: storage/themes/default/layouts/stats.php:95
        #: storage/themes/the23/partials/languagejs.php:28
        "Providers such as Google use these cookies to measure and provide us with analytics on how you interact with our website. All of the data is anonymized and cannot be used to identify you."=> "",

        #: storage/themes/default/layouts/api.php:91
        #: storage/themes/default/layouts/auth.php:58
        #: storage/themes/default/layouts/main.php:99
        #: storage/themes/default/layouts/stats.php:98
        #: storage/themes/the23/partials/languagejs.php:31
        "Advertisement"=> "",

        #: storage/themes/default/layouts/api.php:92
        #: storage/themes/default/layouts/auth.php:59
        #: storage/themes/default/layouts/main.php:100
        #: storage/themes/default/layouts/stats.php:99
        #: storage/themes/the23/partials/languagejs.php:32
        "These cookies are set by our advertisers so they can provide you with relevant ads."=> "",

        #: storage/themes/default/layouts/api.php:95
        #: storage/themes/default/layouts/auth.php:62
        #: storage/themes/default/layouts/main.php:103
        #: storage/themes/default/layouts/stats.php:102
        #: storage/themes/the23/partials/languagejs.php:35
        "Additional Functionality"=> "",

        #: storage/themes/default/layouts/api.php:96
        #: storage/themes/default/layouts/auth.php:63
        #: storage/themes/default/layouts/main.php:104
        #: storage/themes/default/layouts/stats.php:103
        #: storage/themes/the23/partials/languagejs.php:36
        "We use various providers to enhance our products and they may or may not set cookies. Enhancement can include Content Delivery Networks, Google Fonts, etc"=> "",

        #: storage/themes/default/layouts/api.php:99
        #: storage/themes/default/layouts/auth.php:66
        #: storage/themes/default/layouts/main.php:107
        #: storage/themes/default/layouts/stats.php:106
        #: storage/themes/the23/partials/languagejs.php:39
        "Privacy Policy"=> "",

        #: storage/themes/default/layouts/api.php:100
        #: storage/themes/default/layouts/auth.php:67
        #: storage/themes/default/layouts/main.php:108
        #: storage/themes/default/layouts/stats.php:107
        #: storage/themes/the23/partials/languagejs.php:40
        "You can view our privacy policy"=> "",

        #: storage/themes/default/layouts/api.php:100
        #: storage/themes/default/layouts/auth.php:67
        #: storage/themes/default/layouts/main.php:108
        #: storage/themes/default/layouts/stats.php:107
        #: storage/themes/the23/partials/languagejs.php:40
        "here"=> "",

        #: storage/themes/default/layouts/api.php:100
        #: storage/themes/default/layouts/auth.php:67
        #: storage/themes/default/layouts/main.php:108
        #: storage/themes/default/layouts/stats.php:107
        #: storage/themes/the23/partials/languagejs.php:40
        "If you have any questions, please do not hesitate to"=> "",

        #: storage/themes/default/layouts/dashboard.php:31
        #: storage/themes/default/layouts/main.php:31
        "You are logged in as another user"=> "",

        #: storage/themes/default/layouts/dashboard.php:32
        #: storage/themes/default/layouts/main.php:32
        "Return to my account"=> "",

        #: storage/themes/default/layouts/dashboard.php:48
        #: storage/themes/default/partials/sidebar_menu.php:184
        "Teams"=> "",

        #: storage/themes/default/layouts/dashboard.php:94
        #: storage/themes/default/user/affiliate.php:94
        "Contact"=> "",

        #: storage/themes/default/layouts/dashboard.php:124
        "The selected image is not valid. Please select a jpg or png with a maximum size of 1mb"=> "",

        #: storage/themes/default/layouts/dashboard.php:126
        #: storage/themes/default/partials/links.php:47
        #: storage/themes/default/user/channel.php:63
        #: storage/themes/default/user/developers.php:26
        "Copied"=> "",

        #: storage/themes/default/layouts/dashboard.php:128
        "This website uses cookies to ensure you get the best experience on our website."=> "",

        #: storage/themes/default/layouts/dashboard.php:129
        "Got it!"=> "",

        #: storage/themes/default/layouts/dashboard.php:136
        #: storage/themes/default/qr/index.php:210
        #: storage/themes/default/user/index.php:228
        #: storage/themes/default/user/links.php:177
        "Are you sure you want to proceed?"=> "",

        #: storage/themes/default/layouts/dashboard.php:137
        "Proceed"=> "",

        #: storage/themes/default/layouts/dashboard.php:140
        "Note that this action is permanent. Once you click proceed, you <strong>may not undo</strong> this. Click anywhere outside this modal or click <a href='#close' class='close-modal'>close</a> to close this."=> "",

        #: storage/themes/default/maintenance.php:8
        #: storage/themes/the23/maintenance.php:12
        "BRB"=> "",

        #: storage/themes/default/oauth/authorize.php:12
        "The application \"{name}\" is requesting access to your account"=> "",

        #: storage/themes/default/overlay/create_contact.php:23
        #: storage/themes/default/overlay/edit_contact.php:23
        "Send Email Address"=> "",

        #: storage/themes/default/overlay/create_contact.php:24
        #: storage/themes/default/overlay/edit_contact.php:24
        "Emails from the form will be sent to this address"=> "",

        #: storage/themes/default/overlay/create_contact.php:31
        #: storage/themes/default/overlay/edit_contact.php:31
        "Email Subject"=> "",

        #: storage/themes/default/overlay/create_contact.php:32
        #: storage/themes/default/overlay/edit_contact.php:32
        "Something you would know where it comes from."=> "",

        #: storage/themes/default/overlay/create_contact.php:37
        #: storage/themes/default/overlay/create_contact.php:165
        #: storage/themes/default/overlay/create_newsletter.php:23
        #: storage/themes/default/overlay/edit_contact.php:37
        #: storage/themes/default/overlay/edit_newsletter.php:23
        "Form Label"=> "",

        #: storage/themes/default/overlay/create_contact.php:37
        #: storage/themes/default/overlay/create_contact.php:45
        #: storage/themes/default/overlay/create_contact.php:51
        #: storage/themes/default/overlay/create_contact.php:57
        #: storage/themes/default/overlay/create_message.php:38
        #: storage/themes/default/overlay/create_message.php:46
        #: storage/themes/default/overlay/create_message.php:53
        #: storage/themes/default/overlay/create_newsletter.php:23
        #: storage/themes/default/overlay/create_newsletter.php:31
        #: storage/themes/default/overlay/create_newsletter.php:37
        #: storage/themes/default/overlay/create_newsletter.php:43
        #: storage/themes/default/overlay/create_poll.php:58
        #: storage/themes/default/overlay/edit_contact.php:57
        #: storage/themes/default/overlay/edit_message.php:38
        #: storage/themes/default/overlay/edit_message.php:46
        #: storage/themes/default/overlay/edit_message.php:53
        #: storage/themes/default/overlay/edit_newsletter.php:23
        #: storage/themes/default/overlay/edit_newsletter.php:31
        #: storage/themes/default/overlay/edit_newsletter.php:37
        #: storage/themes/default/overlay/edit_newsletter.php:43
        #: storage/themes/default/overlay/edit_poll.php:57
        "leave empty to disable"=> "",

        #: storage/themes/default/overlay/create_contact.php:38
        #: storage/themes/default/overlay/create_newsletter.php:24
        #: storage/themes/default/overlay/edit_contact.php:38
        #: storage/themes/default/overlay/edit_newsletter.php:24
        "e.g. Need help?"=> "",

        #: storage/themes/default/overlay/create_contact.php:45
        #: storage/themes/default/overlay/create_contact.php:166
        #: storage/themes/default/overlay/create_newsletter.php:31
        #: storage/themes/default/overlay/edit_contact.php:45
        #: storage/themes/default/overlay/edit_newsletter.php:31
        "Form Description"=> "",

        #: storage/themes/default/overlay/create_contact.php:46
        #: storage/themes/default/overlay/create_newsletter.php:32
        #: storage/themes/default/overlay/edit_contact.php:46
        #: storage/themes/default/overlay/edit_newsletter.php:32
        "(optional) Provide a description or anything you want to add to the form."=> "",

        #: storage/themes/default/overlay/create_contact.php:51
        #: storage/themes/default/overlay/create_newsletter.php:37
        #: storage/themes/default/overlay/create_poll.php:58
        #: storage/themes/default/overlay/edit_contact.php:51
        #: storage/themes/default/overlay/edit_newsletter.php:37
        #: storage/themes/default/overlay/edit_poll.php:57
        "Thank You Message"=> "",

        #: storage/themes/default/overlay/create_contact.php:52
        #: storage/themes/default/overlay/edit_contact.php:52
        "e.g. Thank you. We will respond asap."=> "",

        #: storage/themes/default/overlay/create_contact.php:63
        #: storage/themes/default/overlay/create_contact.php:185
        #: storage/themes/default/overlay/create_newsletter.php:49
        #: storage/themes/default/overlay/create_newsletter.php:132
        #: storage/themes/default/overlay/edit_contact.php:63
        #: storage/themes/default/overlay/edit_contact.php:190
        #: storage/themes/default/overlay/edit_newsletter.php:49
        #: storage/themes/default/overlay/edit_newsletter.php:145
        "Webhook Notification"=> "",

        #: storage/themes/default/overlay/create_contact.php:65
        #: storage/themes/default/overlay/create_newsletter.php:51
        #: storage/themes/default/overlay/edit_contact.php:65
        #: storage/themes/default/overlay/edit_newsletter.php:51
        "If you want to receive a notification directly to your app, add the url to your app's handler and as soon as there is a submission, we will send a notification to this url as well as an email to the address provided above."=> "",

        #: storage/themes/default/overlay/create_contact.php:71
        #: storage/themes/default/overlay/create_newsletter.php:57
        #: storage/themes/default/overlay/create_poll.php:46
        #: storage/themes/default/overlay/edit_contact.php:71
        #: storage/themes/default/overlay/edit_contact.php:74
        #: storage/themes/default/overlay/edit_newsletter.php:57
        #: storage/themes/default/overlay/edit_poll.php:45
        "Text Labels"=> "",

        #: storage/themes/default/overlay/create_contact.php:77
        #: storage/themes/default/overlay/edit_contact.php:78
        "Name Placeholder"=> "",

        #: storage/themes/default/overlay/create_contact.php:79
        #: storage/themes/default/overlay/create_contact.php:86
        #: storage/themes/default/overlay/create_contact.php:93
        #: storage/themes/default/overlay/create_contact.php:100
        #: storage/themes/default/overlay/create_newsletter.php:65
        #: storage/themes/default/overlay/edit_contact.php:80
        #: storage/themes/default/overlay/edit_contact.php:87
        #: storage/themes/default/overlay/edit_contact.php:94
        #: storage/themes/default/overlay/edit_contact.php:101
        #: storage/themes/default/overlay/edit_newsletter.php:65
        "If you want to use a different language, change these."=> "",

        #: storage/themes/default/overlay/create_contact.php:84
        #: storage/themes/default/overlay/edit_contact.php:85
        "Email Placeholder"=> "",

        #: storage/themes/default/overlay/create_contact.php:91
        #: storage/themes/default/overlay/edit_contact.php:92
        "Message Placeholder"=> "",

        #: storage/themes/default/overlay/create_contact.php:98
        #: storage/themes/default/overlay/edit_contact.php:99
        "Send Button Placeholder"=> "",

        #: storage/themes/default/overlay/create_contact.php:108
        #: storage/themes/default/overlay/create_coupon.php:48
        #: storage/themes/default/overlay/create_image.php:49
        #: storage/themes/default/overlay/create_message.php:62
        #: storage/themes/default/overlay/create_newsletter.php:73
        #: storage/themes/default/overlay/create_poll.php:67
        #: storage/themes/default/overlay/edit_contact.php:109
        #: storage/themes/default/overlay/edit_coupon.php:48
        #: storage/themes/default/overlay/edit_image.php:49
        #: storage/themes/default/overlay/edit_message.php:62
        #: storage/themes/default/overlay/edit_newsletter.php:73
        #: storage/themes/default/overlay/edit_poll.php:66
        "Appearance Customization"=> "",

        #: storage/themes/default/overlay/create_contact.php:114
        #: storage/themes/default/overlay/edit_contact.php:115
        "Form Background Color"=> "",

        #: storage/themes/default/overlay/create_contact.php:120
        #: storage/themes/default/overlay/edit_contact.php:121
        "Form Text Color"=> "",

        #: storage/themes/default/overlay/create_contact.php:126
        #: storage/themes/default/overlay/edit_contact.php:127
        "Input Background Color"=> "",

        #: storage/themes/default/overlay/create_contact.php:132
        #: storage/themes/default/overlay/edit_contact.php:133
        "Input Text Color"=> "",

        #: storage/themes/default/overlay/create_contact.php:138
        #: storage/themes/default/overlay/create_coupon.php:66
        #: storage/themes/default/overlay/create_message.php:92
        #: storage/themes/default/overlay/create_newsletter.php:91
        #: storage/themes/default/overlay/create_poll.php:85
        #: storage/themes/default/overlay/edit_contact.php:139
        #: storage/themes/default/overlay/edit_coupon.php:66
        #: storage/themes/default/overlay/edit_message.php:92
        #: storage/themes/default/overlay/edit_newsletter.php:91
        #: storage/themes/default/overlay/edit_poll.php:84
        "Button Background Color"=> "",

        #: storage/themes/default/overlay/create_contact.php:150
        #: storage/themes/default/overlay/create_coupon.php:78
        #: storage/themes/default/overlay/create_image.php:61
        #: storage/themes/default/overlay/create_message.php:104
        #: storage/themes/default/overlay/create_newsletter.php:103
        #: storage/themes/default/overlay/create_poll.php:97
        #: storage/themes/default/overlay/edit_contact.php:151
        #: storage/themes/default/overlay/edit_coupon.php:78
        #: storage/themes/default/overlay/edit_image.php:61
        #: storage/themes/default/overlay/edit_message.php:104
        #: storage/themes/default/overlay/edit_newsletter.php:103
        #: storage/themes/default/overlay/edit_poll.php:96
        "Overlay Position"=> "",

        #: storage/themes/default/overlay/create_contact.php:152
        #: storage/themes/default/overlay/create_coupon.php:80
        #: storage/themes/default/overlay/create_image.php:65
        #: storage/themes/default/overlay/create_message.php:108
        #: storage/themes/default/overlay/create_newsletter.php:105
        #: storage/themes/default/overlay/create_poll.php:99
        #: storage/themes/default/overlay/edit_contact.php:153
        #: storage/themes/default/overlay/edit_coupon.php:80
        #: storage/themes/default/overlay/edit_image.php:65
        #: storage/themes/default/overlay/edit_message.php:108
        #: storage/themes/default/overlay/edit_newsletter.php:105
        #: storage/themes/default/overlay/edit_poll.php:98
        "Bottom Left"=> "",

        #: storage/themes/default/overlay/create_contact.php:153
        #: storage/themes/default/overlay/create_coupon.php:81
        #: storage/themes/default/overlay/create_image.php:66
        #: storage/themes/default/overlay/create_message.php:109
        #: storage/themes/default/overlay/create_newsletter.php:106
        #: storage/themes/default/overlay/create_poll.php:100
        #: storage/themes/default/overlay/edit_contact.php:154
        #: storage/themes/default/overlay/edit_coupon.php:81
        #: storage/themes/default/overlay/edit_image.php:66
        #: storage/themes/default/overlay/edit_message.php:109
        #: storage/themes/default/overlay/edit_newsletter.php:106
        #: storage/themes/default/overlay/edit_poll.php:99
        "Bottom Right"=> "",

        #: storage/themes/default/overlay/create_contact.php:188
        #: storage/themes/default/overlay/edit_contact.php:193
        "If you add a webhook url, we will send a notification to that url with the contact form data. You will be able to integrate it with your own app or a third-party app. Below is a sample data that will be sent in <code>JSON</code> format via a <code>POST</code> request."=> "",

        #: storage/themes/default/overlay/create_coupon.php:23
        #: storage/themes/default/overlay/edit_coupon.php:23
        "Coupon Code"=> "",

        #: storage/themes/default/overlay/create_coupon.php:32
        #: storage/themes/default/overlay/create_message.php:33
        #: storage/themes/default/overlay/edit_coupon.php:32
        #: storage/themes/default/overlay/edit_message.php:33
        #: storage/themes/default/splash/create.php:73
        #: storage/themes/default/splash/edit.php:78
        "Get a $10 discount with any purchase more than $50"=> "",

        #: storage/themes/default/overlay/create_coupon.php:54
        #: storage/themes/default/overlay/create_image.php:55
        #: storage/themes/default/overlay/create_message.php:68
        #: storage/themes/default/overlay/create_newsletter.php:79
        #: storage/themes/default/overlay/create_poll.php:73
        #: storage/themes/default/overlay/edit_coupon.php:54
        #: storage/themes/default/overlay/edit_image.php:55
        #: storage/themes/default/overlay/edit_message.php:68
        #: storage/themes/default/overlay/edit_newsletter.php:79
        #: storage/themes/default/overlay/edit_poll.php:72
        "Overlay Background Color"=> "",

        #: storage/themes/default/overlay/create_coupon.php:60
        #: storage/themes/default/overlay/create_message.php:74
        #: storage/themes/default/overlay/create_newsletter.php:85
        #: storage/themes/default/overlay/create_poll.php:79
        #: storage/themes/default/overlay/edit_coupon.php:60
        #: storage/themes/default/overlay/edit_message.php:74
        #: storage/themes/default/overlay/edit_newsletter.php:85
        #: storage/themes/default/overlay/edit_poll.php:78
        "Overlay Text Color"=> "",

        #: storage/themes/default/overlay/create_image.php:25
        #: storage/themes/default/overlay/edit_image.php:25
        "If you add a link here, the whole overlay will be linked to this when clicked."=> "",

        #: storage/themes/default/overlay/create_image.php:32
        #: storage/themes/default/overlay/create_message.php:23
        #: storage/themes/default/overlay/edit_image.php:32
        #: storage/themes/default/overlay/edit_message.php:23
        #: storage/themes/default/pages/qr.php:253
        #: storage/themes/the23/pages/qr.php:254
        "Logo"=> "",

        #: storage/themes/default/overlay/create_image.php:34
        #: storage/themes/default/overlay/create_message.php:25
        #: storage/themes/default/overlay/edit_image.php:34
        #: storage/themes/default/overlay/edit_message.php:25
        "Logo should be square with a maximum size of 100x100. To remove the image, click on the upload field and then cancel it."=> "",

        #: storage/themes/default/overlay/create_image.php:39
        #: storage/themes/default/overlay/edit_image.php:39
        "Background Image"=> "",

        #: storage/themes/default/overlay/create_image.php:41
        #: storage/themes/default/overlay/edit_image.php:41
        "Image should be rectangle with a maximum size of 600x150. To remove the image, click on the upload field and then cancel it."=> "",

        #: storage/themes/default/overlay/create_image.php:63
        #: storage/themes/default/overlay/create_message.php:106
        #: storage/themes/default/overlay/edit_image.php:63
        #: storage/themes/default/overlay/edit_message.php:106
        "Top Left"=> "",

        #: storage/themes/default/overlay/create_image.php:64
        #: storage/themes/default/overlay/create_message.php:107
        #: storage/themes/default/overlay/edit_image.php:64
        #: storage/themes/default/overlay/edit_message.php:107
        "Top Right"=> "",

        #: storage/themes/default/overlay/create_image.php:67
        #: storage/themes/default/overlay/create_message.php:110
        #: storage/themes/default/overlay/edit_image.php:67
        #: storage/themes/default/overlay/edit_message.php:110
        "Bottom Center"=> "",

        #: storage/themes/default/overlay/create_message.php:38
        #: storage/themes/default/overlay/edit_message.php:38
        "Overlay label"=> "",

        #: storage/themes/default/overlay/create_message.php:46
        #: storage/themes/default/overlay/edit_message.php:46
        "Button Link"=> "",

        #: storage/themes/default/overlay/create_message.php:48
        #: storage/themes/default/overlay/edit_message.php:48
        "If you remove the button text below but add a link here, the whole overlay will be linked to this when clicked."=> "",

        #: storage/themes/default/overlay/create_message.php:80
        #: storage/themes/default/overlay/edit_message.php:80
        "Label Background Color"=> "",

        #: storage/themes/default/overlay/create_message.php:86
        #: storage/themes/default/overlay/edit_message.php:86
        "Label Text Color"=> "",

        #: storage/themes/default/overlay/create_message.php:121
        "Promo"=> "",

        #: storage/themes/default/overlay/create_message.php:125
        "Your text here"=> "",

        #: storage/themes/default/overlay/create_newsletter.php:38
        #: storage/themes/default/overlay/edit_newsletter.php:38
        "e.g. Thank you."=> "",

        #: storage/themes/default/overlay/create_newsletter.php:63
        #: storage/themes/default/overlay/edit_newsletter.php:63
        "Button"=> "",

        #: storage/themes/default/overlay/create_newsletter.php:135
        #: storage/themes/default/overlay/edit_newsletter.php:148
        "If you add a webhook url, we will send a notification to that url with the form data. You will be able to integrate it with your own app or a third-party app. Below is a sample data that will be sent in <code>JSON</code> format via a <code>POST</code> request."=> "",

        #: storage/themes/default/overlay/create_poll.php:26
        #: storage/themes/default/overlay/edit_poll.php:26
        "e.g. What is your favorite color?"=> "",

        #: storage/themes/default/overlay/create_poll.php:31
        #: storage/themes/default/overlay/edit_poll.php:31
        "Options"=> "",

        #: storage/themes/default/overlay/create_poll.php:32
        #: storage/themes/default/overlay/edit_poll.php:32
        "You can add up to 10 options for each poll. To add an extra option click Add Option above. To ignore a field, leave it empty."=> "",

        #: storage/themes/default/overlay/create_poll.php:41
        #: storage/themes/default/overlay/edit_poll.php:40
        "Add Option"=> "",

        #: storage/themes/default/overlay/create_poll.php:52
        #: storage/themes/default/overlay/edit_poll.php:51
        "Vote Button Placeholder"=> "",

        #: storage/themes/default/overlay/create_poll.php:59
        "Thanks..."=> "",

        #: storage/themes/default/overlay/create_poll.php:111
        "Your question here?"=> "",

        #: storage/themes/default/overlay/edit_contact.php:37
        #: storage/themes/default/overlay/edit_contact.php:45
        #: storage/themes/default/overlay/edit_contact.php:51
        "(leave empty to disable)"=> "",

        #: storage/themes/default/overlay/edit_contact.php:159
        #: storage/themes/default/overlay/edit_coupon.php:86
        #: storage/themes/default/overlay/edit_image.php:72
        #: storage/themes/default/overlay/edit_message.php:115
        #: storage/themes/default/overlay/edit_newsletter.php:111
        #: storage/themes/default/overlay/edit_poll.php:104
        #: storage/themes/default/splash/edit.php:81
        #: storage/themes/default/teams/edit.php:24
        #: storage/themes/default/user/channel.php:138
        #: storage/themes/default/user/channels.php:155
        "Update"=> "",

        #: storage/themes/default/overlay/edit_poll.php:121
        "Poll Results"=> "",

        #: storage/themes/default/overlay/index.php:2
        "An overlay page allows you to display a small non-intrusive overlay on the destination website to advertise your product or your services. You can also use this feature to send a message to your users. You can customize the message and the appearance of the overlay right from this page. As soon as you save it, the changes will be applied immediately across all your URLs using this type. Please note that some secured and sensitive websites such as google.com or facebook.com do not work with this feature. You can have unlimited overlay pages and you can choose one for each URL."=> "",

        #: storage/themes/default/overlay/index.php:56
        #: storage/themes/default/user/campaigns.php:68
        "link|links"=> "",

        #: storage/themes/default/overlay/index.php:56
        "Overlay created {t} and assigned to {x}."=> "",

        #: storage/themes/default/pages/affiliate.php:6
        #: storage/themes/the23/pages/affiliate.php:6
        "Earn {p} commission on affiliate sales"=> "",

        #: storage/themes/default/pages/affiliate.php:7
        #: storage/themes/the23/pages/affiliate.php:7
        "Refer customers to us and we will reward you a {p} commission on all qualifying sales made on our website. Anyone can join the affiliate program."=> "",

        #: storage/themes/default/pages/affiliate.php:9
        #: storage/themes/the23/pages/affiliate.php:9
        "View Affiliate Portal"=> "",

        #: storage/themes/default/pages/affiliate.php:11
        #: storage/themes/the23/pages/affiliate.php:11
        "Join now"=> "",

        #: storage/themes/default/pages/affiliate.php:22
        #: storage/themes/default/pricing/index.php:65
        #: storage/themes/the23/pages/affiliate.php:21
        #: storage/themes/the23/pricing/index.php:60
        "Frequently Asked Questions"=> "",

        #: storage/themes/default/pages/api.php:8
        #: storage/themes/default/pages/api.php:59 storage/themes/the23/pages/api.php:7
        #: storage/themes/the23/pages/api.php:47
        "Getting Started"=> "",

        #: storage/themes/default/pages/api.php:14
        #: storage/themes/default/pages/api.php:80
        #: storage/themes/the23/pages/api.php:10 storage/themes/the23/pages/api.php:68
        "Authentication"=> "",

        #: storage/themes/default/pages/api.php:21
        #: storage/themes/default/pages/api.php:165
        #: storage/themes/the23/pages/api.php:14 storage/themes/the23/pages/api.php:156
        "OAuth Authentication"=> "",

        #: storage/themes/default/pages/api.php:28
        #: storage/themes/default/pages/api.php:238
        #: storage/themes/the23/pages/api.php:18 storage/themes/the23/pages/api.php:229
        "Rate Limit"=> "",

        #: storage/themes/default/pages/api.php:34
        #: storage/themes/default/pages/api.php:255
        #: storage/themes/the23/pages/api.php:21 storage/themes/the23/pages/api.php:246
        "Response Handling"=> "",

        #: storage/themes/default/pages/api.php:39
        #: storage/themes/default/partials/topbar_menu.php:65
        #: storage/themes/the23/pages/api.php:28
        "Admin"=> "",

        #: storage/themes/default/pages/api.php:62
        #: storage/themes/the23/pages/api.php:50
        "An API key is required for requests to be processed by the system. Once a user registers, an API key is automatically generated for this user. The API key must be sent with each request (see full example below). If the API key is not sent or is expired, there will be an error. Please make sure to keep your API key secret to prevent abuse."=> "",

        #: storage/themes/default/pages/api.php:68
        #: storage/themes/the23/pages/api.php:56
        "Your API key"=> "",

        #: storage/themes/default/pages/api.php:70
        #: storage/themes/the23/pages/api.php:58
        "Regenerate API Key"=> "",

        #: storage/themes/default/pages/api.php:70
        #: storage/themes/the23/pages/api.php:58
        "If you proceed, your current applications will not work anymore. You will need to change your api key for it to work again."=> "",

        #: storage/themes/default/pages/api.php:70
        #: storage/themes/default/user/developers.php:59
        #: storage/themes/default/user/developers.php:128
        #: storage/themes/the23/pages/api.php:58
        "Regenerate"=> "",

        #: storage/themes/default/pages/api.php:83
        #: storage/themes/the23/pages/api.php:71
        "To authenticate with the API system, you need to send your API key as an authorization token with each request. You can see sample code below."=> "",

        #: storage/themes/default/pages/api.php:169
        #: storage/themes/the23/pages/api.php:160
        "OAuth allows you to integrate our services into your application while letting users securely authenticate without sharing their passwords. The flow consists of three main steps:"=> "",

        #: storage/themes/default/pages/api.php:171
        #: storage/themes/the23/pages/api.php:162
        "Redirect users to our authorization page"=> "",

        #: storage/themes/default/pages/api.php:172
        #: storage/themes/the23/pages/api.php:163
        "Users approve your application access"=> "",

        #: storage/themes/default/pages/api.php:173
        #: storage/themes/the23/pages/api.php:164
        "Exchange the authorization code for an access token"=> "",

        #: storage/themes/default/pages/api.php:178
        #: storage/themes/the23/pages/api.php:169
        "Step 1: Create OAuth Application"=> "",

        #: storage/themes/default/pages/api.php:179
        #: storage/themes/the23/pages/api.php:170
        "Before you begin, you need to create an OAuth application in your admin dashboard. You will receive:"=> "",

        #: storage/themes/default/pages/api.php:182
        #: storage/themes/the23/pages/api.php:173
        "Client Secret"=> "",

        #: storage/themes/default/pages/api.php:185
        #: storage/themes/the23/pages/api.php:176
        "Keep your Client Secret secure and never share it publicly!"=> "",

        #: storage/themes/default/pages/api.php:190
        #: storage/themes/the23/pages/api.php:181
        "Step 2: Authorization Request"=> "",

        #: storage/themes/default/pages/api.php:191
        #: storage/themes/the23/pages/api.php:182
        "To begin the OAuth flow, redirect users to our authorization URL:"=> "",

        #: storage/themes/default/pages/api.php:195
        #: storage/themes/the23/pages/api.php:186
        "Parameters:"=> "",

        #: storage/themes/default/pages/api.php:197
        #: storage/themes/the23/pages/api.php:188
        "Your OAuth client ID"=> "",

        #: storage/themes/default/pages/api.php:198
        #: storage/themes/the23/pages/api.php:189
        "Must match the redirect URI you registered"=> "",

        #: storage/themes/default/pages/api.php:203
        #: storage/themes/the23/pages/api.php:194
        "Step 3: Handle the Callback"=> "",

        #: storage/themes/default/pages/api.php:204
        #: storage/themes/the23/pages/api.php:195
        "After user authorization, we will redirect to your redirect_uri with an authorization code:"=> "",

        #: storage/themes/default/pages/api.php:210
        #: storage/themes/the23/pages/api.php:201
        "Step 4: Exchange Code for Token"=> "",

        #: storage/themes/default/pages/api.php:211
        #: storage/themes/the23/pages/api.php:202
        "Exchange the authorization code for an access token by making a POST request"=> "",

        #: storage/themes/default/pages/api.php:215
        #: storage/themes/the23/pages/api.php:206
        "Successful response"=> "",

        #: storage/themes/default/pages/api.php:220
        #: storage/themes/the23/pages/api.php:211
        "Using the Access Token"=> "",

        #: storage/themes/default/pages/api.php:221
        #: storage/themes/the23/pages/api.php:212
        "Include the access token in the Authorization header for API requests:"=> "",

        #: storage/themes/default/pages/api.php:226
        #: storage/themes/the23/pages/api.php:217
        "Access tokens expire after 1 year and will need to be refreshed by repeating the OAuth flow."=> "",

        #: storage/themes/default/pages/api.php:241
        #: storage/themes/the23/pages/api.php:232
        "Our API has a rate limiter to safeguard against spike in requests to maximize its stability. Our rate limiter is currently caped at {x} requests per {y} minute."=> "",

        #: storage/themes/default/pages/api.php:243
        #: storage/themes/the23/pages/api.php:234
        "Several headers will be sent alongside the response and these can be examined to determine various information about the request."=> "",

        #: storage/themes/default/pages/api.php:258
        #: storage/themes/the23/pages/api.php:249
        "All API response are returned in JSON format by default. To convert this into usable data, the appropriate function will need to be used according to the language. In PHP, the function json_decode() can be used to convert the data to either an object (default) or an array (set the second parameter to true). It is very important to check the error key as that provides information on whether there was an error or not. You can also check the header code."=> "",

        #: storage/themes/default/pages/api.php:286
        #: storage/themes/the23/pages/api.php:279
        "Parameter"=> "",

        #: storage/themes/default/pages/api.php:384
        #: storage/themes/the23/pages/api.php:380
        "Server response"=> "",

        #: storage/themes/default/pages/bio.php:26
        #: storage/themes/the23/pages/bio.php:39
        "New Merch"=> "",

        #: storage/themes/default/pages/bio.php:29 storage/themes/the23/index.php:203
        #: storage/themes/the23/pages/bio.php:42
        "Shop"=> "",

        #: storage/themes/default/pages/bio.php:42
        #: storage/themes/the23/pages/bio.php:55
        "One link to rule them all"=> "",

        #: storage/themes/default/pages/bio.php:44
        #: storage/themes/the23/pages/bio.php:57
        "Create beautiful profiles and add content like links, donation, videos and more for your social media users. Share a single on your social media profiles so your users can easily find all of your important links on a single page."=> "",

        #: storage/themes/default/pages/bio.php:51
        #: storage/themes/default/pages/qr.php:359
        #: storage/themes/default/pages/qr.php:422
        #: storage/themes/the23/pages/qr.php:359
        "The new standard"=> "",

        #: storage/themes/default/pages/bio.php:60
        "Track and optimize"=> "",

        #: storage/themes/default/pages/bio.php:62
        #: storage/themes/the23/pages/bio.php:156
        "Profiles are fully trackable and you can find out exactly how many people have visited your profiles or clicked links on your profile and where they are from."=> "",

        #: storage/themes/default/pages/bio.php:69
        #: storage/themes/default/pages/qr.php:431
        #: storage/themes/default/pages/qr.php:440
        #: storage/themes/the23/pages/bio.php:154
        #: storage/themes/the23/pages/bio.php:161 storage/themes/the23/pages/qr.php:465
        #: storage/themes/the23/pages/qr.php:472
        "Trackable to the dot"=> "",

        #: storage/themes/default/pages/consent.php:9
        #: storage/themes/the23/pages/consent.php:8
        "This website uses cookies to ensure you get the best experience on our website. You can learn more by visiting our cookie policy. Meanwhile if you agree, please click the button below to proceed to your destination."=> "",

        #: storage/themes/default/pages/contact.php:7
        #: storage/themes/default/pages/contact.php:30
        #: storage/themes/the23/pages/contact.php:58
        "If you have any questions, feel free to contact us so we can help you"=> "",

        #: storage/themes/default/pages/contact.php:22
        "Please enter a valid name."=> "",

        #: storage/themes/default/pages/contact.php:30
        "The message is empty or too short."=> "",

        #: storage/themes/default/pages/index.php:14
        "Last Updated"=> "",

        #: storage/themes/default/pages/qr.php:7 storage/themes/the23/pages/qr.php:8
        "Create QR Codes <br>for {t}"=> "",

        #: storage/themes/default/pages/qr.php:17
        #: storage/themes/the23/class/themeSettings.php:362
        #: storage/themes/the23/pages/qr.php:18
        "Static"=> "",

        #: storage/themes/default/pages/qr.php:19
        #: storage/themes/default/pages/qr.php:231
        #: storage/themes/default/pages/qr.php:256
        #: storage/themes/default/pages/qr.php:263
        #: storage/themes/default/pages/qr.php:266
        #: storage/themes/default/pages/qr.php:269 storage/themes/the23/pages/qr.php:20
        #: storage/themes/the23/pages/qr.php:232 storage/themes/the23/pages/qr.php:257
        #: storage/themes/the23/pages/qr.php:264 storage/themes/the23/pages/qr.php:267
        #: storage/themes/the23/pages/qr.php:270
        "Register to unlock this feature"=> "",

        #: storage/themes/default/pages/qr.php:20
        #: storage/themes/the23/class/themeSettings.php:359
        #: storage/themes/the23/pages/qr.php:21
        "Dynamic"=> "",

        #: storage/themes/default/pages/qr.php:20 storage/themes/the23/pages/qr.php:21
        "Trackable"=> "",

        #: storage/themes/default/pages/qr.php:25
        #: storage/themes/default/pages/qr.php:45
        #: storage/themes/default/pages/qr.php:200
        #: storage/themes/default/qr/edit.php:402 storage/themes/default/qr/new.php:369
        #: storage/themes/default/user/edit.php:19 storage/themes/the23/pages/qr.php:26
        #: storage/themes/the23/pages/qr.php:46 storage/themes/the23/pages/qr.php:201
        "URL"=> "",

        #: storage/themes/default/pages/qr.php:28 storage/themes/the23/pages/qr.php:29
        "Call"=> "",

        #: storage/themes/default/pages/qr.php:29
        #: storage/themes/default/qr/edit.php:320 storage/themes/default/qr/new.php:28
        #: storage/themes/default/qr/new.php:331 storage/themes/the23/pages/qr.php:30
        "WiFi"=> "",

        #: storage/themes/default/pages/qr.php:38 storage/themes/default/qr/edit.php:35
        #: storage/themes/default/qr/edit.php:36 storage/themes/default/qr/edit.php:134
        #: storage/themes/default/qr/new.php:51 storage/themes/default/qr/new.php:52
        #: storage/themes/the23/pages/qr.php:39
        "Your Text"=> "",

        #: storage/themes/default/pages/qr.php:57 storage/themes/default/qr/edit.php:65
        #: storage/themes/default/qr/new.php:77 storage/themes/the23/pages/qr.php:58
        "Subject"=> "",

        #: storage/themes/default/pages/qr.php:58
        #: storage/themes/default/pages/qr.php:82 storage/themes/default/qr/edit.php:66
        #: storage/themes/default/qr/edit.php:117 storage/themes/default/qr/new.php:78
        #: storage/themes/default/qr/new.php:108 storage/themes/default/qr/new.php:123
        #: storage/themes/the23/pages/qr.php:59 storage/themes/the23/pages/qr.php:83
        "Job Application"=> "",

        #: storage/themes/default/pages/qr.php:62 storage/themes/default/qr/edit.php:70
        #: storage/themes/default/qr/new.php:82 storage/themes/default/qr/new.php:151
        #: storage/themes/the23/pages/qr.php:63
        "Your message here to be sent as email"=> "",

        #: storage/themes/default/pages/qr.php:69
        #: storage/themes/default/pages/qr.php:77 storage/themes/default/qr/edit.php:82
        #: storage/themes/default/qr/edit.php:95 storage/themes/default/qr/edit.php:112
        #: storage/themes/default/qr/edit.php:129 storage/themes/default/qr/new.php:92
        #: storage/themes/default/qr/new.php:103 storage/themes/default/qr/new.php:118
        #: storage/themes/default/qr/new.php:146 storage/themes/the23/pages/qr.php:70
        #: storage/themes/the23/pages/qr.php:78
        "Phone Number"=> "",

        #: storage/themes/default/pages/qr.php:97
        #: storage/themes/default/qr/edit.php:158
        #: storage/themes/default/qr/edit.php:245 storage/themes/default/qr/new.php:173
        #: storage/themes/default/qr/new.php:258 storage/themes/the23/pages/qr.php:98
        "Organization"=> "",

        #: storage/themes/default/pages/qr.php:105
        #: storage/themes/default/qr/edit.php:166
        #: storage/themes/default/qr/edit.php:253 storage/themes/default/qr/new.php:181
        #: storage/themes/default/qr/new.php:266 storage/themes/the23/pages/qr.php:106
        "Cell"=> "",

        #: storage/themes/default/pages/qr.php:117
        #: storage/themes/default/qr/edit.php:178
        #: storage/themes/default/qr/edit.php:265 storage/themes/default/qr/new.php:193
        #: storage/themes/default/qr/new.php:278 storage/themes/the23/pages/qr.php:118
        "Website"=> "",

        #: storage/themes/default/pages/qr.php:122
        #: storage/themes/default/qr/edit.php:183
        #: storage/themes/default/qr/edit.php:270 storage/themes/default/qr/new.php:198
        #: storage/themes/default/qr/new.php:283 storage/themes/the23/pages/qr.php:123
        "Social"=> "",

        #: storage/themes/default/pages/qr.php:126
        #: storage/themes/default/qr/edit.php:188
        #: storage/themes/default/qr/edit.php:275 storage/themes/default/qr/new.php:203
        #: storage/themes/default/qr/new.php:288 storage/themes/the23/pages/qr.php:127
        "Street"=> "",

        #: storage/themes/default/pages/qr.php:138
        #: storage/themes/default/qr/edit.php:200
        #: storage/themes/default/qr/edit.php:287 storage/themes/default/qr/new.php:215
        #: storage/themes/default/qr/new.php:300 storage/themes/the23/pages/qr.php:139
        "Zipcode"=> "",

        #: storage/themes/default/pages/qr.php:160
        #: storage/themes/default/qr/edit.php:310 storage/themes/default/qr/new.php:323
        #: storage/themes/the23/pages/qr.php:161
        "Linekdin"=> "",

        #: storage/themes/default/pages/qr.php:169
        #: storage/themes/default/qr/edit.php:324 storage/themes/default/qr/new.php:335
        #: storage/themes/the23/pages/qr.php:170
        "Network SSID"=> "",

        #: storage/themes/default/pages/qr.php:177
        #: storage/themes/default/qr/edit.php:332 storage/themes/default/qr/new.php:343
        #: storage/themes/the23/pages/qr.php:178
        "Encryption"=> "",

        #: storage/themes/default/pages/qr.php:196
        #: storage/themes/default/qr/edit.php:398 storage/themes/default/qr/new.php:365
        #: storage/themes/the23/pages/qr.php:197
        "Location"=> "",

        #: storage/themes/default/pages/qr.php:222
        #: storage/themes/the23/pages/qr.php:223
        "Customization"=> "",

        #: storage/themes/default/pages/qr.php:232
        #: storage/themes/the23/pages/qr.php:233
        "Gradient"=> "",

        #: storage/themes/default/pages/qr.php:245
        #: storage/themes/default/qr/bulk.php:71 storage/themes/default/qr/edit.php:485
        #: storage/themes/default/qr/new.php:475 storage/themes/the23/pages/qr.php:246
        "Foreground"=> "",

        #: storage/themes/default/pages/qr.php:255
        #: storage/themes/the23/pages/qr.php:256
        "Upload logo"=> "",

        #: storage/themes/default/pages/qr.php:264
        #: storage/themes/the23/pages/qr.php:265
        "Eye"=> "",

        #: storage/themes/default/pages/qr.php:267
        #: storage/themes/the23/pages/qr.php:268
        "Matrix"=> "",

        #: storage/themes/default/pages/qr.php:277
        #: storage/themes/the23/pages/qr.php:278
        "Generate"=> "",

        #: storage/themes/default/pages/qr.php:290
        #: storage/themes/the23/pages/qr.php:291
        "Register to unlock advanced features such as Dynamic QR Codes, advanced QR Code customization and frames."=> "",

        #: storage/themes/default/pages/qr.php:318
        #: storage/themes/the23/pages/qr.php:319
        "Advanced QR Codes"=> "",

        #: storage/themes/default/pages/qr.php:326
        #: storage/themes/the23/pages/qr.php:327
        "Customize Colors"=> "",

        #: storage/themes/default/pages/qr.php:336
        #: storage/themes/the23/pages/qr.php:337
        "Track Scans"=> "",

        #: storage/themes/default/pages/qr.php:344
        #: storage/themes/the23/pages/qr.php:345
        "Customize Design & Frames"=> "",

        #: storage/themes/default/pages/qr.php:361
        #: storage/themes/the23/pages/qr.php:361
        "QR Codes are everywhere and they are not going away. They are a great asset to your company because you can easily capture users and convert them. QR codes can be customized to match your company, brand or product."=> "",

        #: storage/themes/default/pages/qr.php:372
        #: storage/themes/the23/pages/qr.php:372
        "Dynamic QR codes"=> "",

        #: storage/themes/default/pages/qr.php:373
        #: storage/themes/the23/pages/qr.php:373
        "Track QR code scans with our dynamic QR codes"=> "",

        #: storage/themes/default/pages/qr.php:385
        #: storage/themes/the23/pages/bio.php:81 storage/themes/the23/pages/qr.php:385
        "Customizable Design"=> "",

        #: storage/themes/default/pages/qr.php:386
        #: storage/themes/the23/pages/qr.php:386
        "Customize the eye & the matrix"=> "",

        #: storage/themes/default/pages/qr.php:398
        #: storage/themes/the23/pages/qr.php:398
        "Frames & Custom Logo"=> "",

        #: storage/themes/default/pages/qr.php:399
        #: storage/themes/the23/pages/qr.php:399
        "Add your own logo and frame your QR code"=> "",

        #: storage/themes/default/pages/qr.php:411
        #: storage/themes/the23/pages/qr.php:411
        "Custom Colors"=> "",

        #: storage/themes/default/pages/qr.php:412
        #: storage/themes/the23/pages/qr.php:412
        "Customize colors to match your brand"=> "",

        #: storage/themes/default/pages/qr.php:433
        #: storage/themes/the23/pages/qr.php:467
        "The beautify of QR codes is that almost any type of data can be encoded in them. Most types of data can be tracked very easily so you will know exactly when and from where a person scanned your QR code."=> "",

        #: storage/themes/default/pages/report.php:6
        #: storage/themes/the23/pages/report.php:5
        "Report link"=> "",

        #: storage/themes/default/pages/report.php:25
        #: storage/themes/the23/pages/report.php:17
        "Short Link"=> "",

        #: storage/themes/default/pages/report.php:26
        #: storage/themes/the23/pages/report.php:18
        "Please enter a valid short link"=> "",

        #: storage/themes/default/pages/report.php:29
        #: storage/themes/the23/pages/report.php:21
        "Reason"=> "",

        #: storage/themes/default/pages/report.php:31
        #: storage/themes/the23/pages/report.php:23
        "Spam"=> "",

        #: storage/themes/default/pages/report.php:32
        #: storage/themes/the23/pages/report.php:24
        "Fraudulent"=> "",

        #: storage/themes/default/pages/report.php:33
        #: storage/themes/the23/pages/report.php:25
        "Malicious"=> "",

        #: storage/themes/default/pages/report.php:34
        #: storage/themes/the23/pages/report.php:26
        "Phishing"=> "",

        #: storage/themes/default/partials/footer.php:8
        "Marketing with confidence."=> "",

        #: storage/themes/default/partials/footer.php:57
        #: storage/themes/default/partials/main_menu.php:11
        #: storage/themes/default/partials/main_menu.php:54
        #: storage/themes/the23/partials/footer.php:49
        #: storage/themes/the23/partials/main_menu.php:26
        "Solutions"=> "",

        #: storage/themes/default/partials/footer.php:60
        #: storage/themes/default/user/confirmation.php:78
        "Bio Profiles"=> "",

        #: storage/themes/default/partials/footer.php:106
        #: storage/themes/the23/partials/footer.php:108
        "Verify Link"=> "",

        #: storage/themes/default/partials/footer.php:109
        #: storage/themes/the23/partials/footer.php:111
        "Cookie Settings"=> "",

        #: storage/themes/default/partials/links.php:15
        "Unarchive"=> "",

        #: storage/themes/default/partials/links.php:17
        "Archive"=> "",

        #: storage/themes/default/partials/links.php:20
        "Set Private"=> "",

        #: storage/themes/default/partials/links.php:22
        "Set Public"=> "",

        #: storage/themes/default/partials/links.php:54
        "Archived"=> "",

        #: storage/themes/default/partials/links.php:62
        "Public"=> "",

        #: storage/themes/default/partials/links.php:65
        #: storage/themes/default/user/edit.php:608
        #: storage/themes/default/user/links.php:69
        "Campaign"=> "",

        #: storage/themes/default/partials/links.php:68
        "Geo Targeted"=> "",

        #: storage/themes/default/partials/links.php:71
        "Device Targeted"=> "",

        #: storage/themes/default/partials/links.php:74
        "Language Targeted"=> "",

        #: storage/themes/default/partials/links.php:77
        #: storage/themes/default/partials/shortener.php:139
        #: storage/themes/default/partials/stats_nav.php:22
        #: storage/themes/the23/index.php:179
        #: storage/themes/the23/partials/stats_nav.php:22
        "A/B Testing"=> "",

        #: storage/themes/default/partials/links.php:80
        #: storage/themes/default/partials/shortener.php:376
        "Click Limit"=> "",

        #: storage/themes/default/partials/links.php:86
        #: storage/themes/default/partials/shortener.php:121
        #: storage/themes/default/partials/shortener.php:182
        #: storage/themes/default/user/edit.php:170 storage/themes/the23/index.php:172
        "Advanced Targeting"=> "",

        #: storage/themes/default/partials/links.php:89
        "Protected"=> "",

        #: storage/themes/default/partials/links.php:92
        "Expiry on"=> "",

        #: storage/themes/default/partials/links.php:95
        #: storage/themes/default/partials/shortener.php:133
        #: storage/themes/default/pixels/index.php:12
        #: storage/themes/default/user/index.php:326
        #: storage/themes/default/user/links.php:275
        "Pixels"=> "",

        #: storage/themes/default/partials/links.php:106
        #: storage/themes/default/stats/partial.php:45
        "Unique Clicks"=> "",

        #: storage/themes/default/partials/main_menu.php:7
        #: storage/themes/the23/partials/main_menu.php:89
        "Pricing"=> "",

        #: storage/themes/default/partials/main_menu.php:17
        #: storage/themes/the23/partials/footer.php:66
        #: storage/themes/the23/partials/main_menu.php:110
        "Resources"=> "",

        #: storage/themes/default/partials/main_menu.php:28
        #: storage/themes/the23/partials/main_menu.php:134
        "Guide on how to use our API"=> "",

        #: storage/themes/default/partials/main_menu.php:61
        #: storage/themes/the23/partials/main_menu.php:47
        "Customizable & trackable QR codes"=> "",

        #: storage/themes/default/partials/main_menu.php:69
        #: storage/themes/the23/partials/main_menu.php:36
        "Convert your social media followers"=> "",

        #: storage/themes/default/partials/main_menu.php:136
        #: storage/themes/default/partials/topbar_menu.php:64
        #: storage/themes/the23/partials/main_menu.php:175
        "Admin Panel"=> "",

        #: storage/themes/default/partials/main_menu.php:150
        #: storage/themes/default/partials/topbar_menu.php:108
        #: storage/themes/default/user/campaigns.php:20
        #: storage/themes/default/user/settings.php:191
        #: storage/themes/the23/partials/main_menu.php:185
        "Public Profile"=> "",

        #: storage/themes/default/partials/main_menu.php:156
        #: storage/themes/default/partials/topbar_menu.php:114
        #: storage/themes/default/user/affiliate.php:1
        #: storage/themes/the23/partials/main_menu.php:192
        "Affiliate"=> "",

        #: storage/themes/default/partials/main_menu.php:165
        #: storage/themes/default/partials/topbar_menu.php:131
        #: storage/themes/the23/partials/main_menu.php:215
        "Log out"=> "",

        #: storage/themes/default/partials/shortener.php:7
        #: storage/themes/default/partials/shortenermodal.php:14
        "Paste a long link"=> "",

        #: storage/themes/default/partials/shortener.php:10
        "Paste up to 10 long urls. One URL per line."=> "",

        #: storage/themes/default/partials/shortener.php:16
        "Advanced Options"=> "",

        #: storage/themes/default/partials/shortener.php:26
        "Single"=> "",

        #: storage/themes/default/partials/shortener.php:27
        "Multiple"=> "",

        #: storage/themes/default/partials/shortener.php:47
        #: storage/themes/default/partials/shortenermodal.php:44
        #: storage/themes/default/user/edit.php:563
        #: storage/themes/default/user/import.php:39
        "Redirect"=> "",

        #: storage/themes/default/partials/shortener.php:66
        #: storage/themes/default/partials/shortenermodal.php:63
        "If you need a custom alias, you can enter it below."=> "",

        #: storage/themes/default/partials/shortener.php:78
        #: storage/themes/default/partials/shortenermodal.php:75
        "Assign link to a channel."=> "",

        #: storage/themes/default/partials/shortener.php:95
        #: storage/themes/default/partials/shortenermodal.php:92
        "By adding a password, you can restrict the access."=> "",

        #: storage/themes/default/partials/shortener.php:105
        #: storage/themes/default/partials/shortenermodal.php:102
        "This can be used to identify URLs on your account."=> "",

        #: storage/themes/default/partials/shortener.php:108
        #: storage/themes/default/partials/shortenermodal.php:105
        #: storage/themes/default/user/edit.php:604
        "Type your description here"=> "",

        #: storage/themes/default/partials/shortener.php:116
        #: storage/themes/default/partials/shortener.php:147
        #: storage/themes/default/user/edit.php:29
        "Meta Tags"=> "",

        #: storage/themes/default/partials/shortener.php:158
        #: storage/themes/default/user/edit.php:43
        "Upload Custom Banner"=> "",

        #: storage/themes/default/partials/shortener.php:160
        #: storage/themes/default/partials/shortener.php:161
        #: storage/themes/default/user/edit.php:45
        #: storage/themes/default/user/edit.php:46
        "Banner must be a {f} and the size must be less than {s}kb."=> "",

        #: storage/themes/default/partials/shortener.php:168
        #: storage/themes/default/user/edit.php:53
        "Enter your custom meta title"=> "",

        #: storage/themes/default/partials/shortener.php:174
        #: storage/themes/default/user/edit.php:59
        "Enter your custom meta description"=> "",

        #: storage/themes/default/partials/shortener.php:187
        #: storage/themes/default/user/edit.php:176
        "Set conditional redirects based on multiple criteria. All conditions (Country, Device, and Language) must match for the redirect to occur."=> "",

        #: storage/themes/default/partials/shortener.php:216
        #: storage/themes/default/partials/shortener.php:252
        #: storage/themes/default/partials/shortener.php:303
        #: storage/themes/default/partials/shortener.php:330
        #: storage/themes/default/partials/shortener.php:391
        #: storage/themes/default/partials/shortener.php:411
        #: storage/themes/default/user/edit.php:102
        #: storage/themes/default/user/edit.php:131
        #: storage/themes/default/user/edit.php:216
        #: storage/themes/default/user/edit.php:250
        #: storage/themes/default/user/edit.php:284
        #: storage/themes/default/user/edit.php:302
        #: storage/themes/default/user/edit.php:336
        #: storage/themes/default/user/edit.php:354
        #: storage/themes/default/user/edit.php:397
        #: storage/themes/default/user/edit.php:422
        #: storage/themes/default/user/edit.php:438
        "Type the url to redirect user to."=> "",

        #: storage/themes/default/partials/shortener.php:230
        #: storage/themes/default/user/edit.php:76
        "If you have different pages for different countries then it is possible to redirect users to that page using the same URL. Simply choose the country and enter the URL."=> "",

        #: storage/themes/default/partials/shortener.php:244
        #: storage/themes/default/user/edit.php:92
        #: storage/themes/default/user/edit.php:121
        "All States"=> "",

        #: storage/themes/default/partials/shortener.php:263
        #: storage/themes/default/user/edit.php:146
        "Enable this feature to force apps to open when visiting on mobile or open app store if app is not installed."=> "",

        #: storage/themes/default/partials/shortener.php:270
        #: storage/themes/default/user/edit.php:153
        "To use deep links, you will need to define a main URL that will be used for all other devices, an app specific URL for iPhone/iPad and/or Android and the associated app store URL."=> "",

        #: storage/themes/default/partials/shortener.php:270
        "You need to use the Device Targeting to set the correct app links for the associated devices"=> "",

        #: storage/themes/default/partials/shortener.php:271
        #: storage/themes/default/qr/edit.php:427 storage/themes/default/qr/new.php:417
        #: storage/themes/default/user/edit.php:154
        "Link to App Store"=> "",

        #: storage/themes/default/partials/shortener.php:275
        #: storage/themes/default/qr/edit.php:431 storage/themes/default/qr/new.php:421
        #: storage/themes/default/user/edit.php:158
        "Link to Google Play"=> "",

        #: storage/themes/default/partials/shortener.php:289
        #: storage/themes/default/user/edit.php:269
        "If you have different pages for different devices (such as mobile, tablet etc) then it is possible to redirect users to that page using the same short URL. Simply choose the device and enter the URL."=> "",

        #: storage/themes/default/partials/shortener.php:317
        "If you have different pages for different languages then it is possible to redirect users to that page using the same URL. Simply choose the language and enter the URL."=> "",

        #: storage/themes/default/partials/shortener.php:360
        #: storage/themes/default/user/edit.php:368
        "Links can be expired based on the amount of clicks or a specific date. You can also set a url to redirect to when the link expires."=> "",

        #: storage/themes/default/partials/shortener.php:365
        #: storage/themes/default/user/edit.php:373
        "Link Expiration"=> "",

        #: storage/themes/default/partials/shortener.php:366
        "Set an expiration date to disable the link."=> "",

        #: storage/themes/default/partials/shortener.php:369
        "MM/DD/YYYY"=> "",

        #: storage/themes/default/partials/shortener.php:377
        "Limit the number of clicks."=> "",

        #: storage/themes/default/partials/shortener.php:387
        #: storage/themes/default/user/edit.php:393
        "Expiration Redirect"=> "",

        #: storage/themes/default/partials/shortener.php:388
        #: storage/themes/default/user/edit.php:394
        "Set a link to redirect traffic to when the short link expires."=> "",

        #: storage/themes/default/partials/shortener.php:405
        "You can rotate multiple links using this feature. If you do not assign a percentage or the percentage is 100% for all links then the traffic will equally distributed. Please note that default link will be added to the list as well and rotator will not work if you assign another targeting condition that matches."=> "",

        #: storage/themes/default/partials/shortener.php:417
        #: storage/themes/default/user/edit.php:428
        #: storage/themes/default/user/edit.php:444
        "Type percentage e.g. 100"=> "",

        #: storage/themes/default/partials/shortener.php:426
        #: storage/themes/default/user/edit.php:479
        "Parameter Builder"=> "",

        #: storage/themes/default/partials/shortener.php:432
        #: storage/themes/default/user/edit.php:485
        "You can add custom parameters like UTM to the link above using this tool. Choose the parameter name and then assign a value. These will be added during redirection."=> "",

        #: storage/themes/default/partials/shortener.php:438
        #: storage/themes/default/user/edit.php:492
        #: storage/themes/default/user/edit.php:508
        "Parameter name"=> "",

        #: storage/themes/default/partials/shortener.php:444
        #: storage/themes/default/user/edit.php:498
        #: storage/themes/default/user/edit.php:514
        "Parameter value"=> "",

        #: storage/themes/default/partials/shortenermodal.php:5
        #: storage/themes/default/partials/topbar_menu.php:7
        #: storage/themes/default/user/tools.php:7
        #: storage/themes/default/user/tools.php:18
        "Quick Shortener"=> "",

        #: storage/themes/default/partials/shortenermodal.php:136
        "Download QR Code"=> "",

        #: storage/themes/default/partials/shortenermodal.php:158
        "Crop Image"=> "",

        #: storage/themes/default/partials/shortenermodal.php:168
        "Drag to move, scroll to zoom. Crop area will be automatically adjusted to maintain square aspect ratio."=> "",

        #: storage/themes/default/partials/shortenermodal.php:173
        #: storage/themes/default/user/edit.php:657
        "Save Crop"=> "",

        #: storage/themes/default/partials/sidebar_menu.php:25
        #: storage/themes/default/partials/topbar_menu.php:72
        #: storage/themes/default/partials/topbar_menu.php:76
        "Switch Workspace"=> "",

        #: storage/themes/default/partials/sidebar_menu.php:31
        #: storage/themes/default/partials/topbar_menu.php:81
        "Individual"=> "",

        #: storage/themes/default/partials/sidebar_menu.php:38
        #: storage/themes/default/partials/topbar_menu.php:88
        "Team"=> "",

        #: storage/themes/default/partials/sidebar_menu.php:102
        #: storage/themes/default/user/channels.php:50
        "My Channels"=> "",

        #: storage/themes/default/partials/sidebar_menu.php:237
        "Are you looking for more features? Check out our plans."=> "",

        #: storage/themes/default/partials/sidebar_menu.php:248
        #: storage/themes/default/user/billing.php:45
        "Free Trial"=> "",

        #: storage/themes/default/partials/sidebar_menu.php:250
        "Your trial will end on {t}"=> "",

        #: storage/themes/default/partials/stats_nav.php:3
        #: storage/themes/default/pricing/checkout.php:103
        #: storage/themes/the23/partials/stats_nav.php:3
        "Summary"=> "",

        #: storage/themes/default/partials/stats_nav.php:6
        #: storage/themes/the23/partials/stats_nav.php:6
        "Countries & Cities"=> "",

        #: storage/themes/default/partials/stats_nav.php:9
        #: storage/themes/default/stats/platforms.php:9
        #: storage/themes/default/user/campaignstats.php:85
        #: storage/themes/default/user/stats.php:45
        #: storage/themes/the23/partials/stats_nav.php:9
        "Platforms"=> "",

        #: storage/themes/default/partials/stats_nav.php:12
        #: storage/themes/default/stats/browsers.php:9
        #: storage/themes/default/user/stats.php:65
        #: storage/themes/the23/partials/stats_nav.php:12
        "Browsers"=> "",

        #: storage/themes/default/partials/stats_nav.php:15
        #: storage/themes/default/stats/languages.php:9
        #: storage/themes/default/user/stats.php:85
        #: storage/themes/the23/partials/stats_nav.php:15
        "Languages"=> "",

        #: storage/themes/default/partials/stats_nav.php:18
        #: storage/themes/the23/partials/stats_nav.php:18
        "Referrers"=> "",

        #: storage/themes/default/partials/topbar_menu.php:25
        #: storage/themes/the23/class/themeSettings.php:183
        #: storage/themes/the23/partials/main_menu.php:201
        "Dark Mode"=> "",

        #: storage/themes/default/partials/topbar_menu.php:28
        #: storage/themes/the23/class/themeSettings.php:186
        "Light Mode"=> "",

        #: storage/themes/default/partials/topbar_menu.php:44
        "{t} Notification|{t} Notifications"=> "",

        #: storage/themes/default/partials/topbar_menu.php:56
        "View All Notifications"=> "",

        #: storage/themes/default/partials/topbar_menu.php:105
        #: storage/themes/default/user/security.php:29
        "Verified"=> "",

        #: storage/themes/default/pixels/edit.php:18
        #: storage/themes/default/pixels/new.php:21
        "Pixel Name"=> "",

        #: storage/themes/default/pixels/edit.php:19
        #: storage/themes/default/pixels/new.php:22
        "Shopify Campaign"=> "",

        #: storage/themes/default/pixels/edit.php:24
        #: storage/themes/default/pixels/new.php:27
        "Pixel Tag"=> "",

        #: storage/themes/default/pixels/edit.php:25
        #: storage/themes/default/pixels/new.php:28
        "Numerical or alphanumerical values only"=> "",

        #: storage/themes/default/pixels/edit.php:29
        "Update Pixel"=> "",

        #: storage/themes/default/pixels/index.php:2
        #: storage/themes/default/pixels/new.php:45
        "Ad platforms such as Facebook and Adwords provide a conversion tracking tool to allow you to gather data on your customers and how they behave on your website. By adding your pixel ID from either of the platforms, you will be able to optimize marketing simply by using short URLs."=> "",

        #: storage/themes/default/pixels/index.php:5
        #: storage/themes/default/pixels/index.php:88
        #: storage/themes/default/pixels/new.php:1
        #: storage/themes/default/pixels/new.php:32
        "Add Pixel"=> "",

        #: storage/themes/default/pixels/index.php:22
        #: storage/themes/default/pixels/index.php:44
        "Provider"=> "",

        #: storage/themes/default/pixels/index.php:46
        "Tag"=> "",

        #: storage/themes/default/pixels/index.php:47
        #: storage/themes/default/user/developers.php:18
        "Created"=> "",

        #: storage/themes/default/pixels/new.php:11
        "Pixel Provider"=> "",

        #: storage/themes/default/pixels/new.php:41
        "What are tracking pixels?"=> "",

        #: storage/themes/default/pixels/new.php:46
        "More info"=> "",

        #: storage/themes/default/pricing/checkout.php:13
        #: storage/themes/the23/pricing/checkout.php:11
        "Payment Method"=> "",

        #: storage/themes/default/pricing/checkout.php:32
        #: storage/themes/default/user/confirmation.php:16
        #: storage/themes/default/user/settings.php:84
        #: storage/themes/default/user/verification.php:23
        #: storage/themes/the23/pricing/checkout.php:38
        "Billing Address"=> "",

        #: storage/themes/default/pricing/checkout.php:36
        #: storage/themes/default/user/settings.php:98
        #: storage/themes/the23/pricing/checkout.php:42
        "Personal"=> "",

        #: storage/themes/default/pricing/checkout.php:39
        #: storage/themes/default/user/settings.php:99
        #: storage/themes/the23/pricing/checkout.php:45
        "Business"=> "",

        #: storage/themes/default/pricing/checkout.php:60
        #: storage/themes/default/user/settings.php:90
        #: storage/themes/default/user/verification.php:28
        #: storage/themes/the23/pricing/checkout.php:65
        "Full Name"=> "",

        #: storage/themes/default/pricing/checkout.php:76
        #: storage/themes/default/user/settings.php:131
        #: storage/themes/default/user/verification.php:52
        #: storage/themes/the23/pricing/checkout.php:81
        "State/Province"=> "",

        #: storage/themes/default/pricing/checkout.php:92
        #: storage/themes/default/user/settings.php:147
        #: storage/themes/default/user/verification.php:68
        #: storage/themes/the23/pricing/checkout.php:97
        "Zip/Postal code"=> "",

        #: storage/themes/default/pricing/checkout.php:117
        #: storage/themes/the23/pricing/checkout.php:141
        "Subtotal"=> "",

        #: storage/themes/default/pricing/checkout.php:124
        #: storage/themes/the23/pricing/checkout.php:148
        "Promo Code"=> "",

        #: storage/themes/default/pricing/checkout.php:134
        #: storage/themes/the23/pricing/checkout.php:157
        "Apply promo code"=> "",

        #: storage/themes/default/pricing/checkout.php:138
        #: storage/themes/the23/pricing/checkout.php:161
        "Discount"=> "",

        #: storage/themes/default/pricing/checkout.php:164
        #: storage/themes/the23/pricing/checkout.php:187
        "One-time payment"=> "",

        #: storage/themes/default/pricing/checkout.php:164
        #: storage/themes/the23/pricing/checkout.php:187
        "Billed"=> "",

        #: storage/themes/default/pricing/checkout.php:176
        #: storage/themes/default/pricing/checkout.php:193
        #: storage/themes/default/user/billing.php:97
        #: storage/themes/the23/pricing/checkout.php:197
        #: storage/themes/the23/pricing/checkout.php:214
        "Redeem Voucher"=> "",

        #: storage/themes/default/pricing/checkout.php:180
        #: storage/themes/the23/pricing/checkout.php:201
        "By subscribing to this plan, you agree to our Terms & Conditions. Subscription is charged in {c}. If you have any questions, please contact us."=> "",

        #: storage/themes/default/pricing/checkout.php:201
        #: storage/themes/the23/pricing/checkout.php:220
        "Voucher"=> "",

        #: storage/themes/default/pricing/checkout.php:212
        #: storage/themes/default/user/billing.php:103
        #: storage/themes/the23/pricing/checkout.php:225
        "Redeem"=> "",

        #: storage/themes/default/pricing/index.php:5
        #: storage/themes/the23/pricing/index.php:6
        "Simple Pricing"=> "",

        #: storage/themes/default/pricing/index.php:7
        "Transparent pricing for everyone. Always know what you will pay."=> "",

        #: storage/themes/default/pricing/index.php:45
        #: storage/themes/the23/pricing/index.php:47
        "Need a custom plan?"=> "",

        #: storage/themes/default/pricing/index.php:46
        #: storage/themes/the23/pricing/index.php:48
        "If our current plans do not fit your needs, we will create a tailored plan just for your needs."=> "",

        #: storage/themes/default/pricing/index.php:49
        #: storage/themes/the23/pricing/index.php:51
        "Custom Plan"=> "",

        #: storage/themes/default/pricing/index.php:49
        #: storage/themes/the23/pricing/index.php:51
        "Contact Sales"=> "",

        #: storage/themes/default/pricing/table.php:15
        #: storage/themes/default/pricing/table_list.php:30
        #: storage/themes/the23/pages/qr.php:8
        #: storage/themes/the23/pricing/categorized.php:18
        #: storage/themes/the23/pricing/categorized.php:71
        #: storage/themes/the23/pricing/categorized.php:73
        #: storage/themes/the23/pricing/list.php:22
        #: storage/themes/the23/pricing/table.php:28
        "Free"=> "",

        #: storage/themes/default/pricing/table.php:25
        #: storage/themes/the23/pricing/categorized.php:104
        #: storage/themes/the23/pricing/list.php:32
        "Number of short links allowed."=> "",

        #: storage/themes/default/pricing/table.php:25
        #: storage/themes/default/pricing/table_list.php:41
        #: storage/themes/the23/index.php:269
        #: storage/themes/the23/pricing/categorized.php:26
        #: storage/themes/the23/pricing/categorized.php:104
        #: storage/themes/the23/pricing/list.php:32
        #: storage/themes/the23/pricing/table.php:39
        "Short Links"=> "",

        #: storage/themes/default/pricing/table.php:25
        #: storage/themes/default/pricing/table.php:26
        #: storage/themes/default/pricing/table.php:34
        #: storage/themes/the23/pricing/categorized.php:27
        #: storage/themes/the23/pricing/categorized.php:31
        #: storage/themes/the23/pricing/categorized.php:35
        #: storage/themes/the23/pricing/categorized.php:111
        #: storage/themes/the23/pricing/categorized.php:129
        #: storage/themes/the23/pricing/categorized.php:159
        #: storage/themes/the23/pricing/list.php:32
        #: storage/themes/the23/pricing/list.php:33
        #: storage/themes/the23/pricing/list.php:48
        "mo"=> "",

        #: storage/themes/default/pricing/table.php:26
        #: storage/themes/default/pricing/table_list.php:49
        #: storage/themes/the23/pricing/categorized.php:30
        #: storage/themes/the23/pricing/categorized.php:122
        #: storage/themes/the23/pricing/list.php:33
        #: storage/themes/the23/pricing/table.php:47
        "Total clicks allowed over a period"=> "",

        #: storage/themes/default/pricing/table.php:26
        #: storage/themes/default/pricing/table_list.php:49
        #: storage/themes/the23/pricing/categorized.php:30
        #: storage/themes/the23/pricing/categorized.php:122
        #: storage/themes/the23/pricing/list.php:33
        #: storage/themes/the23/pricing/table.php:47
        "Link Clicks"=> "",

        #: storage/themes/default/pricing/table.php:27
        #: storage/themes/default/pricing/table_list.php:57
        #: storage/themes/the23/pricing/list.php:34
        #: storage/themes/the23/pricing/table.php:55
        "Amount of time statistics are kept for each short link."=> "",

        #: storage/themes/default/pricing/table.php:27
        #: storage/themes/default/pricing/table_list.php:57
        #: storage/themes/default/user/billing.php:72
        #: storage/themes/the23/pricing/categorized.php:42
        #: storage/themes/the23/pricing/list.php:34
        #: storage/themes/the23/pricing/table.php:55
        "Data Retention"=> "",

        #: storage/themes/default/pricing/table.php:27
        #: storage/themes/default/pricing/table_list.php:60
        #: storage/themes/default/user/billing.php:72
        #: storage/themes/the23/pricing/categorized.php:43
        #: storage/themes/the23/pricing/list.php:34
        #: storage/themes/the23/pricing/table.php:58
        "days"=> "",

        #: storage/themes/default/pricing/table.php:38
        #: storage/themes/the23/pricing/categorized.php:168
        #: storage/themes/the23/pricing/list.php:53
        #: storage/themes/the23/pricing/table.php:99
        "Widgets"=> "",

        #: storage/themes/default/pricing/table.php:48
        #: storage/themes/default/pricing/table_list.php:89
        #: storage/themes/the23/pricing/list.php:63
        #: storage/themes/the23/pricing/table.php:112
        "No advertisement will be shown when logged or in your links"=> "",

        #: storage/themes/default/pricing/table.php:48
        #: storage/themes/default/user/billing.php:86
        #: storage/themes/default/user/confirmation.php:99
        #: storage/themes/the23/pricing/list.php:63
        #: storage/themes/the23/pricing/table.php:112
        "Advertisement-Free"=> "",

        #: storage/themes/default/pricing/table_list.php:17
        #: storage/themes/the23/pricing/list.php:13
        #: storage/themes/the23/pricing/table.php:21
        "Save {p}%"=> "",

        #: storage/themes/default/pricing/table_list.php:41
        #: storage/themes/the23/pricing/table.php:39
        "Number of short links allowed"=> "",

        #: storage/themes/default/pricing/table_list.php:60
        #: storage/themes/the23/pricing/table.php:58
        "Forever"=> "",

        #: storage/themes/default/private.php:10 storage/themes/the23/private.php:12
        "Hello"=> "",

        #: storage/themes/default/private.php:12 storage/themes/the23/private.php:14
        "Thanks for your interest but this website is currently used privately."=> "",

        #: storage/themes/default/qr/bulk.php:10 storage/themes/default/qr/edit.php:11
        #: storage/themes/default/qr/new.php:10
        "QR Code Name"=> "",

        #: storage/themes/default/qr/bulk.php:20 storage/themes/default/qr/edit.php:23
        #: storage/themes/default/qr/new.php:20
        "Choose domain to generate the link with when using dynamic QR codes. Not applicable for static QR codes."=> "",

        #: storage/themes/default/qr/bulk.php:25 storage/themes/default/qr/new.php:25
        "Static QR"=> "",

        #: storage/themes/default/qr/bulk.php:25 storage/themes/default/qr/new.php:25
        "Static QR codes cannot be tracked."=> "",

        #: storage/themes/default/qr/bulk.php:28 storage/themes/default/qr/new.php:32
        "Dynamic QR"=> "",

        #: storage/themes/default/qr/bulk.php:28 storage/themes/default/qr/new.php:32
        "With dynamic QR codes, you can track things like location, browser and device when a user scans the QR code."=> "",

        #: storage/themes/default/qr/bulk.php:36
        "You can generate QR codes in bulk either by entering data manually or by importing a CSV file. In both cases, you need to format your data one per line. Please note that the maximum amount of QR codes on your account {l} still applies."=> "",

        #: storage/themes/default/qr/bulk.php:39
        "One per line"=> "",

        #: storage/themes/default/qr/bulk.php:43
        "Upload CSV (max {s}mb)"=> "",

        #: storage/themes/default/qr/bulk.php:50 storage/themes/default/qr/edit.php:464
        #: storage/themes/default/qr/new.php:454
        "Colors"=> "",

        #: storage/themes/default/qr/bulk.php:99 storage/themes/default/qr/edit.php:513
        #: storage/themes/default/qr/new.php:503
        "Gradient Direction"=> "",

        #: storage/themes/default/qr/bulk.php:101
        #: storage/themes/default/qr/edit.php:515 storage/themes/default/qr/new.php:505
        "Vertical"=> "",

        #: storage/themes/default/qr/bulk.php:102
        #: storage/themes/default/qr/edit.php:516 storage/themes/default/qr/new.php:506
        "Horizontal"=> "",

        #: storage/themes/default/qr/bulk.php:103
        #: storage/themes/default/qr/edit.php:517 storage/themes/default/qr/new.php:507
        "Radial"=> "",

        #: storage/themes/default/qr/bulk.php:104
        #: storage/themes/default/qr/edit.php:518 storage/themes/default/qr/new.php:508
        "Diagonal"=> "",

        #: storage/themes/default/qr/bulk.php:112
        #: storage/themes/default/qr/edit.php:526 storage/themes/default/qr/new.php:516
        "Eye Frame Color"=> "",

        #: storage/themes/default/qr/bulk.php:116
        #: storage/themes/default/qr/edit.php:530 storage/themes/default/qr/new.php:520
        "Eye Color"=> "",

        #: storage/themes/default/qr/bulk.php:161
        #: storage/themes/default/qr/bulk.php:181
        #: storage/themes/default/qr/edit.php:580
        #: storage/themes/default/qr/edit.php:600 storage/themes/default/qr/new.php:565
        #: storage/themes/default/qr/new.php:585
        "Custom Logo"=> "",

        #: storage/themes/default/qr/bulk.php:165
        #: storage/themes/default/qr/edit.php:584 storage/themes/default/qr/new.php:569
        "Size"=> "",

        #: storage/themes/default/qr/bulk.php:171
        #: storage/themes/default/qr/edit.php:590 storage/themes/default/qr/new.php:575
        "Embedded Logo"=> "",

        #: storage/themes/default/qr/bulk.php:172
        #: storage/themes/default/qr/edit.php:591 storage/themes/default/qr/new.php:576
        "Logo can now be embedded in the QR code. Please note that embedded logos can sometimes lead to unstable QR codes so please check to make sure the QR works."=> "",

        #: storage/themes/default/qr/bulk.php:192
        #: storage/themes/default/qr/edit.php:611 storage/themes/default/qr/new.php:596
        "Matrix Style"=> "",

        #: storage/themes/default/qr/bulk.php:241
        #: storage/themes/default/qr/edit.php:664 storage/themes/default/qr/new.php:649
        "Eye Frame"=> "",

        #: storage/themes/default/qr/bulk.php:271
        #: storage/themes/default/qr/edit.php:699 storage/themes/default/qr/new.php:685
        "Eye Style"=> "",

        #: storage/themes/default/qr/bulk.php:311
        #: storage/themes/default/qr/bulk.php:378
        #: storage/themes/default/qr/edit.php:743
        #: storage/themes/default/qr/edit.php:812 storage/themes/default/qr/new.php:729
        #: storage/themes/default/qr/new.php:800
        "Frame Style"=> "",

        #: storage/themes/default/qr/bulk.php:349
        #: storage/themes/default/qr/edit.php:785 storage/themes/default/qr/new.php:771
        "Limit of {x} characters"=> "",

        #: storage/themes/default/qr/bulk.php:354
        #: storage/themes/default/qr/edit.php:790 storage/themes/default/qr/new.php:776
        "Font"=> "",

        #: storage/themes/default/qr/bulk.php:365
        #: storage/themes/default/qr/edit.php:801 storage/themes/default/qr/new.php:787
        "Frame Color"=> "",

        #: storage/themes/default/qr/bulk.php:390
        #: storage/themes/default/qr/edit.php:823 storage/themes/default/qr/new.php:812
        "Margin"=> "",

        #: storage/themes/default/qr/bulk.php:394
        #: storage/themes/default/qr/edit.php:827 storage/themes/default/qr/new.php:816
        "Error Correction"=> "",

        #: storage/themes/default/qr/bulk.php:395
        #: storage/themes/default/qr/edit.php:828 storage/themes/default/qr/new.php:817
        "Error correction allows better readability when code is damaged or dirty but increase QR data"=> "",

        #: storage/themes/default/qr/bulk.php:411
        #: storage/themes/default/qr/edit.php:844 storage/themes/default/qr/new.php:833
        #: storage/themes/default/stats/partial.php:7
        #: storage/themes/default/user/activity.php:50
        #: storage/themes/default/user/index.php:144
        "QR Code"=> "",

        #: storage/themes/default/qr/bulk.php:422 storage/themes/default/qr/new.php:843
        "Generate QR"=> "",

        #: storage/themes/default/qr/bulk.php:426
        #: storage/themes/default/qr/edit.php:883 storage/themes/default/qr/new.php:846
        "You will be able to download the QR code in PDF or SVG after it has been generated."=> "",

        #: storage/themes/default/qr/bulk.php:427 storage/themes/default/qr/new.php:847
        "If you are using a fancy design, your QR code might not be readible. If that is the case, you can increase Error Correction to ensure optimal readability. It is recommended to test the QR code before saving it."=> "",

        #: storage/themes/default/qr/edit.php:17
        "If you change the domain name, the QR code will change!"=> "",

        #: storage/themes/default/qr/edit.php:48 storage/themes/default/qr/new.php:62
        "Your Link"=> "",

        #: storage/themes/default/qr/edit.php:350 storage/themes/default/qr/new.php:396
        "Bitcoin"=> "",

        #: storage/themes/default/qr/edit.php:353 storage/themes/default/qr/new.php:399
        "Ethereum"=> "",

        #: storage/themes/default/qr/edit.php:356 storage/themes/default/qr/new.php:402
        "Bitcoin Cash"=> "",

        #: storage/themes/default/qr/edit.php:360 storage/themes/default/qr/new.php:406
        "Wallet Address"=> "",

        #: storage/themes/default/qr/edit.php:369 storage/themes/default/qr/new.php:129
        "File Upload (Image or PDF)"=> "",

        #: storage/themes/default/qr/edit.php:371
        "View File"=> "",

        #: storage/themes/default/qr/edit.php:376 storage/themes/default/qr/new.php:132
        "This can be used to upload an image or a PDF. Most common uses are restaurant menu, promotional poster and resume."=> "",

        #: storage/themes/default/qr/edit.php:380 storage/themes/default/qr/new.php:136
        "Acceptable file: jpg, png, gif, pdf. Max {d}MB."=> "",

        #: storage/themes/default/qr/edit.php:435 storage/themes/default/qr/new.php:425
        "Link for others"=> "",

        #: storage/themes/default/qr/edit.php:443 storage/themes/default/qr/new.php:433
        "Templates"=> "",

        #: storage/themes/default/qr/edit.php:450 storage/themes/default/qr/new.php:440
        "Your Design"=> "",

        #: storage/themes/default/qr/edit.php:863
        #: storage/themes/default/qr/edit.php:873
        #: storage/themes/default/qr/index.php:83
        "Download as SVG"=> "",

        #: storage/themes/default/qr/edit.php:864
        #: storage/themes/default/qr/edit.php:872
        #: storage/themes/default/qr/index.php:85
        #: storage/themes/default/qr/index.php:88
        "Download as PNG"=> "",

        #: storage/themes/default/qr/edit.php:865
        #: storage/themes/default/qr/edit.php:874
        #: storage/themes/default/qr/index.php:86
        #: storage/themes/default/qr/index.php:89
        "Download as WebP"=> "",

        #: storage/themes/default/qr/edit.php:875
        #: storage/themes/default/qr/index.php:90
        "Download as PDF"=> "",

        #: storage/themes/default/qr/edit.php:884
        "If you are using a fancy design, your QR code might not be readable. If that is the case, you can increase Error Correction to ensure optimal readability. It is recommended to test the QR code before saving it."=> "",

        #: storage/themes/default/qr/index.php:8
        "Bulk QR"=> "",

        #: storage/themes/default/qr/index.php:15
        #: storage/themes/default/user/links.php:137
        "per month"=> "",

        #: storage/themes/default/qr/index.php:17
        "scans"=> "",

        #: storage/themes/default/qr/index.php:50
        #: storage/themes/default/user/index.php:63
        #: storage/themes/default/user/links.php:21
        "Select All"=> "",

        #: storage/themes/default/qr/index.php:51
        #: storage/themes/default/user/index.php:64
        #: storage/themes/default/user/links.php:22
        "Selected"=> "",

        #: storage/themes/default/qr/index.php:51
        #: storage/themes/default/user/index.php:64
        #: storage/themes/default/user/links.php:22
        "Actions"=> "",

        #: storage/themes/default/qr/index.php:54
        "Download Selected"=> "",

        #: storage/themes/default/qr/index.php:57
        #: storage/themes/default/user/index.php:86
        #: storage/themes/default/user/links.php:44
        "Delete Selected"=> "",

        #: storage/themes/default/qr/index.php:110
        #: storage/themes/default/stats/partial.php:37
        #: storage/themes/default/user/channel.php:72
        "Scans"=> "",

        #: storage/themes/default/qr/index.php:214
        #: storage/themes/default/user/index.php:232
        #: storage/themes/default/user/links.php:181
        "You are trying to delete many records. This action is permanent and cannot be reversed."=> "",

        #: storage/themes/default/qr/index.php:227
        "Download QR Codes"=> "",

        #: storage/themes/default/qr/index.php:234
        "Download as"=> "",

        #: storage/themes/default/qr/new.php:390
        "Crypto"=> "",

        #: storage/themes/default/qr/new.php:407
        "Enter your public wallet address"=> "",

        #: storage/themes/default/splash/create.php:17
        #: storage/themes/default/splash/edit.php:22
        "Counter"=> "",

        #: storage/themes/default/splash/create.php:25
        #: storage/themes/default/splash/edit.php:30
        "Link to Product"=> "",

        #: storage/themes/default/splash/create.php:31
        #: storage/themes/default/splash/edit.php:36
        "Custom Title"=> "",

        #: storage/themes/default/splash/create.php:32
        #: storage/themes/default/splash/edit.php:37
        "Get a $10 discount"=> "",

        #: storage/themes/default/splash/create.php:46
        #: storage/themes/default/splash/edit.php:51
        "Upload Avatar"=> "",

        #: storage/themes/default/splash/index.php:2
        "A custom splash page is a transitional page where you can add a banner and a logo along with a message to represent your brand or company. When creating a short link, you will be able to assign the page to your short url. Users who visit your url will briefly see the page before being redirected to their destination."=> "",

        #: storage/themes/default/stats/abtesting.php:10
        "URL Traffic Distribution"=> "",

        #: storage/themes/default/stats/abtesting.php:22
        "clicks"=> "",

        #: storage/themes/default/stats/abtesting.php:22
        "of traffic"=> "",

        #: storage/themes/default/stats/activity.php:33
        #: storage/themes/default/user/activity.php:25
        "Device"=> "",

        #: storage/themes/default/stats/activity.php:42
        #: storage/themes/default/user/activity.php:34
        "Between"=> "",

        #: storage/themes/default/stats/activity.php:44
        #: storage/themes/default/stats/browsers.php:11
        #: storage/themes/default/stats/countries.php:12
        #: storage/themes/default/stats/index.php:12
        #: storage/themes/default/stats/languages.php:11
        #: storage/themes/default/stats/platforms.php:11
        #: storage/themes/default/user/activity.php:36
        #: storage/themes/default/user/index.php:20
        "Choose a date range to update stats"=> "",

        #: storage/themes/default/stats/activity.php:49
        #: storage/themes/default/user/activity.php:41
        #: storage/themes/default/user/links.php:101
        "Filter"=> "",

        #: storage/themes/default/stats/activity.php:84
        #: storage/themes/default/stats/index.php:59
        #: storage/themes/default/user/activity.php:95
        #: storage/themes/default/user/index.php:188
        "Direct, email or others"=> "",

        #: storage/themes/default/stats/browsers.php:25
        #: storage/themes/default/user/stats.php:77
        "Top Browsers"=> "",

        #: storage/themes/default/stats/countries.php:10
        #: storage/themes/default/user/campaignstats.php:51
        "Visitor Map"=> "",

        #: storage/themes/default/stats/countries.php:28
        #: storage/themes/default/user/stats.php:18
        #: storage/themes/default/user/stats.php:34
        "Countries"=> "",

        #: storage/themes/default/stats/countries.php:29
        #: storage/themes/default/stats/countries.php:40
        #: storage/themes/default/user/stats.php:35
        "Cities"=> "",

        #: storage/themes/default/stats/countries.php:44
        "Select a region in the map above to display city data."=> "",

        #: storage/themes/default/stats/languages.php:25
        #: storage/themes/default/user/stats.php:97
        "Top Languages"=> "",

        #: storage/themes/default/stats/partial.php:45
        "Unique Scans"=> "",

        #: storage/themes/default/stats/partial.php:53
        "Top Country"=> "",

        #: storage/themes/default/stats/partial.php:61
        "Top Referrer"=> "",

        #: storage/themes/default/stats/platforms.php:25
        #: storage/themes/default/user/stats.php:57
        "Top Platforms"=> "",

        #: storage/themes/default/stats/referrers.php:10
        "Top Referrers"=> "",

        #: storage/themes/default/stats/referrers.php:19
        "Direct, email and others"=> "",

        #: storage/themes/default/stats/referrers.php:28
        "Social Media"=> "",

        #: storage/themes/default/teams/edit.php:1
        "Edit Member"=> "",

        #: storage/themes/default/teams/edit.php:11
        #: storage/themes/default/teams/edit.php:12
        #: storage/themes/default/teams/index.php:18
        #: storage/themes/default/teams/index.php:19
        #: storage/themes/default/teams/index.php:105
        #: storage/themes/default/user/developers.php:82
        #: storage/themes/default/user/developers.php:83
        "Permissions"=> "",

        #: storage/themes/default/teams/index.php:9
        "Invite Members"=> "",

        #: storage/themes/default/teams/index.php:32
        "Invite"=> "",

        #: storage/themes/default/teams/index.php:52
        "Requested"=> "",

        #: storage/themes/default/teams/index.php:55
        "Disable"=> "",

        #: storage/themes/default/teams/index.php:62
        "Manage"=> "",

        #: storage/themes/default/teams/index.php:63
        "View Permissions"=> "",

        #: storage/themes/default/teams/index.php:77
        "No members found. You can invite one."=> "",

        #: storage/themes/default/teams/index.php:79
        "Add Member"=> "",

        #: storage/themes/default/user/affiliate.php:6
        #: storage/themes/default/user/withdrawals.php:49
        "Current Earning"=> "",

        #: storage/themes/default/user/affiliate.php:9
        "Withdraw"=> "",

        #: storage/themes/default/user/affiliate.php:17
        "Lifetime Earnings"=> "",

        #: storage/themes/default/user/affiliate.php:25
        "Total Referrals"=> "",

        #: storage/themes/default/user/affiliate.php:35
        "Affiliate Link"=> "",

        #: storage/themes/default/user/affiliate.php:45
        "Referral History"=> "",

        #: storage/themes/default/user/affiliate.php:53
        "Commission"=> "",

        #: storage/themes/default/user/affiliate.php:54
        "Referred On"=> "",

        #: storage/themes/default/user/affiliate.php:63
        #: storage/themes/default/user/verification.php:86
        #: storage/themes/default/user/withdrawals.php:25
        "Approved"=> "",

        #: storage/themes/default/user/affiliate.php:65
        #: storage/themes/default/user/verification.php:84
        #: storage/themes/default/user/withdrawals.php:27
        "Rejected"=> "",

        #: storage/themes/default/user/affiliate.php:84
        "Affiliate Rate"=> "",

        #: storage/themes/default/user/affiliate.php:86
        "per qualifying sales"=> "",

        #: storage/themes/default/user/affiliate.php:86
        "per user payment (recurring)"=> "",

        #: storage/themes/default/user/affiliate.php:86
        "paid once"=> "",

        #: storage/themes/default/user/affiliate.php:87
        #: storage/themes/default/user/withdrawals.php:51
        "Minimum earning of {amount} is required for payment."=> "",

        #: storage/themes/default/user/affiliate.php:91
        "Terms"=> "",

        #: storage/themes/default/user/affiliate.php:100
        #: storage/themes/default/user/withdrawals.php:63
        "Please enter your PayPal email so we can send you your commission"=> "",

        #: storage/themes/default/user/billing.php:5
        "Subscription History"=> "",

        #: storage/themes/default/user/billing.php:11
        "Since"=> "",

        #: storage/themes/default/user/billing.php:12
        "Next Payment"=> "",

        #: storage/themes/default/user/billing.php:13
        #: storage/themes/default/user/withdrawals.php:11
        "Status"=> "",

        #: storage/themes/default/user/billing.php:29
        "Payment History"=> "",

        #: storage/themes/default/user/billing.php:35
        "Transaction ID"=> "",

        #: storage/themes/default/user/billing.php:37
        #: storage/themes/default/user/security.php:11
        "Date"=> "",

        #: storage/themes/default/user/billing.php:44
        "Refunded"=> "",

        #: storage/themes/default/user/billing.php:57
        #: storage/themes/default/user/confirmation.php:70
        "Current Plan"=> "",

        #: storage/themes/default/user/billing.php:70
        "/mo"=> "",

        #: storage/themes/default/user/billing.php:70
        #: storage/themes/default/user/confirmation.php:73
        "URLs allowed"=> "",

        #: storage/themes/default/user/billing.php:71
        #: storage/themes/default/user/confirmation.php:74
        "Clicks per month"=> "",

        #: storage/themes/default/user/billing.php:77
        "/min"=> "",

        #: storage/themes/default/user/billing.php:89
        "Change plan"=> "",

        #: storage/themes/default/user/billing.php:111
        #: storage/themes/default/user/billing.php:115
        "Manage Membership"=> "",

        #: storage/themes/default/user/billing.php:114
        "You can manage your membership on directly on the payment processor where you can update your credit card and view your invoices."=> "",

        #: storage/themes/default/user/billing.php:123
        #: storage/themes/default/user/billing.php:143
        "Cancel Membership"=> "",

        #: storage/themes/default/user/billing.php:126
        "You can cancel your membership whenever you want. Upon request, your membership will be canceled right before your next payment period. This means you can still enjoy premium features until the end of your membership."=> "",

        #: storage/themes/default/user/billing.php:127
        #: storage/themes/default/user/billing.php:159
        "Cancel membership"=> "",

        #: storage/themes/default/user/billing.php:147
        "We respect your decision and we are sorry to see you go. If you want to share anything with us, please use the box below and we will do our best to improve our service."=> "",

        #: storage/themes/default/user/billing.php:154
        "Reason for cancellation"=> "",

        #: storage/themes/default/user/campaigns.php:4
        "A campaign can be used to group links together for various purpose. You can use the dedicated rotator link where a random link will be chosen and redirected to among the group. You will also be able to view aggregated statistics for a campaign."=> "",

        #: storage/themes/default/user/campaigns.php:8
        #: storage/themes/default/user/campaigns.php:79
        #: storage/themes/default/user/campaigns.php:93
        "Create a Campaign"=> "",

        #: storage/themes/default/user/campaigns.php:15
        "Campaign List Disabled"=> "",

        #: storage/themes/default/user/campaigns.php:17
        "To create a list page for the campaign, you need a default bio page and public profile settings."=> "",

        #: storage/themes/default/user/campaigns.php:19
        "Default Bio"=> "",

        #: storage/themes/default/user/campaigns.php:46
        "Inactive"=> "",

        #: storage/themes/default/user/campaigns.php:63
        "Rotator"=> "",

        #: storage/themes/default/user/campaigns.php:68
        "This campaign was created {t}, contains {x} and has {y}."=> "",

        #: storage/themes/default/user/campaigns.php:99
        #: storage/themes/default/user/campaigns.php:148
        "Campaign Name"=> "",

        #: storage/themes/default/user/campaigns.php:99
        #: storage/themes/default/user/campaigns.php:148
        #: storage/themes/default/user/channel.php:115
        #: storage/themes/default/user/channels.php:90
        #: storage/themes/default/user/channels.php:132
        "required"=> "",

        #: storage/themes/default/user/campaigns.php:113
        #: storage/themes/default/user/campaigns.php:153
        "Rotator Slug"=> "",

        #: storage/themes/default/user/campaigns.php:115
        #: storage/themes/default/user/campaigns.php:155
        "If you want to set a custom alias for the rotator link, you can fill this field."=> "",

        #: storage/themes/default/user/campaigns.php:119
        #: storage/themes/default/user/campaigns.php:159
        "Access"=> "",

        #: storage/themes/default/user/campaigns.php:120
        #: storage/themes/default/user/campaigns.php:160
        "Disabling this option will deactivate the rotator link."=> "",

        #: storage/themes/default/user/campaigns.php:129
        "Create Campaign"=> "",

        #: storage/themes/default/user/campaigns.php:142
        #: storage/themes/default/user/campaigns.php:169
        "Update Campaign"=> "",

        #: storage/themes/default/user/campaignstats.php:7
        #: storage/themes/default/user/stats.php:5
        "Export Stats"=> "",

        #: storage/themes/default/user/campaignstats.php:16
        "Traffic Distribution"=> "",

        #: storage/themes/default/user/campaignstats.php:61
        #: storage/themes/default/user/stats.php:30
        "Top Countries"=> "",

        #: storage/themes/default/user/campaignstats.php:73
        "Browser"=> "",

        #: storage/themes/default/user/campaignstats.php:107
        #: storage/themes/default/user/stats.php:117
        "Choose a range to export data as CSV. Exported data will including information like date, city and country, os, browser, referer and language."=> "",

        #: storage/themes/default/user/channel.php:13
        #: storage/themes/default/user/channels.php:40
        #: storage/themes/default/user/channels.php:70
        "items"=> "",

        #: storage/themes/default/user/channel.php:69
        "Created on"=> "",

        #: storage/themes/default/user/channel.php:90
        "Are you sure you want to remove this item from this channel?"=> "",

        #: storage/themes/default/user/channel.php:94
        "You are trying to remove an item from a channel."=> "",

        #: storage/themes/default/user/channel.php:109
        #: storage/themes/default/user/channels.php:126
        "Update Channel"=> "",

        #: storage/themes/default/user/channel.php:123
        #: storage/themes/default/user/channels.php:98
        #: storage/themes/default/user/channels.php:140
        "Badge Color"=> "",

        #: storage/themes/default/user/channel.php:128
        #: storage/themes/default/user/channels.php:103
        #: storage/themes/default/user/channels.php:145
        "Star Channel"=> "",

        #: storage/themes/default/user/channel.php:129
        #: storage/themes/default/user/channels.php:104
        #: storage/themes/default/user/channels.php:146
        "Starred channels will show up in the sidebar navigation for quick access."=> "",

        #: storage/themes/default/user/channels.php:7
        #: storage/themes/default/user/channels.php:113
        "Create Channel"=> "",

        #: storage/themes/default/user/channels.php:20
        "Starred Channels"=> "",

        #: storage/themes/default/user/channels.php:41
        #: storage/themes/default/user/channels.php:71
        "View Channel"=> "",

        #: storage/themes/default/user/channels.php:84
        "Create a Channel"=> "",

        #: storage/themes/default/user/confirmation.php:27
        "Order Date"=> "",

        #: storage/themes/default/user/confirmation.php:33
        "Order No"=> "",

        #: storage/themes/default/user/confirmation.php:62
        "Need Help?"=> "",

        #: storage/themes/default/user/confirmation.php:75
        "Geotargeting"=> "",

        #: storage/themes/default/user/confirmation.php:95
        "Campaigns & Link Rotator"=> "",

        #: storage/themes/default/user/confirmation.php:98
        "URL Customization"=> "",

        #: storage/themes/default/user/developers.php:4
        "Generate Key"=> "",

        #: storage/themes/default/user/developers.php:17
        "Permission"=> "",

        #: storage/themes/default/user/developers.php:38
        #: storage/themes/default/user/developers.php:109
        "Revoke"=> "",

        #: storage/themes/default/user/developers.php:44
        "No API keys found"=> "",

        #: storage/themes/default/user/developers.php:55
        "Master API Key"=> "",

        #: storage/themes/default/user/developers.php:63
        "A master API key allows access to all API endpoints. If you need specific access, you can generate a custom API key."=> "",

        #: storage/themes/default/user/developers.php:73
        "Generate API Key"=> "",

        #: storage/themes/default/user/developers.php:101
        "Revoke API Key"=> "",

        #: storage/themes/default/user/developers.php:105
        "Are you sure you want to revoke this API key? Applications using this key will no longer be able to access the API."=> "",

        #: storage/themes/default/user/developers.php:118
        #: storage/themes/default/user/settings.php:305
        "Developer API Key"=> "",

        #: storage/themes/default/user/developers.php:123
        "If you regenerate your key, the current key will be revoked and your applications might stop working until you update the api key with the new one."=> "",

        #: storage/themes/default/user/edit.php:321
        "If you have different pages for different languages then it is possible to redirect users to that page using the same short URL. Simply choose the language and enter the URL."=> "",

        #: storage/themes/default/user/edit.php:376
        "MM/DD/YYYY H:m"=> "",

        #: storage/themes/default/user/edit.php:383
        "Expiration by Clicks"=> "",

        #: storage/themes/default/user/edit.php:409
        "A/B Testing and Rotator"=> "",

        #: storage/themes/default/user/edit.php:415
        "You can rotate multiple links using short link using the feature. If you do not assign a percentage or the percentage is 100% for all links then the traffic will equally distributed. Please note that default link will be added to the list as well and rotator will not work if you assign another targeting condition that matches."=> "",

        #: storage/themes/default/user/edit.php:642
        "Crop Banner"=> "",

        #: storage/themes/default/user/edit.php:652
        "Drag to move, scroll to zoom. Crop area will be automatically adjusted to maintain 16:9 aspect ratio."=> "",

        #: storage/themes/default/user/import.php:6
        "This tool allows you to import links from other software. You need to format the import file as CSV with the following structure. Note that this tool only imports links. It does not import statistics."=> "",

        #: storage/themes/default/user/import.php:8
        "When creating the CSV file, you need to keep the header but the column name can be anything as long as their position is respected. If the custom alias is taken, the importer will generate a random alias."=> "",

        #: storage/themes/default/user/import.php:10
        "CSV Format"=> "",

        #: storage/themes/default/user/import.php:13
        "Sample"=> "",

        #: storage/themes/default/user/import.php:16
        #: storage/themes/default/user/security.php:99
        #: storage/themes/default/user/settings.php:247
        "Important"=> "",

        #: storage/themes/default/user/import.php:17
        "CSV cannot be bigger than {s}mb. If your file contains more than 100 links, links will be imported in the background. Please note that duplicate links will be ignored."=> "",

        #: storage/themes/default/user/import.php:21
        "CSV File"=> "",

        #: storage/themes/default/user/import.php:61
        "Pending Job"=> "",

        #: storage/themes/default/user/import.php:69
        "Completed"=> "",

        #: storage/themes/default/user/import.php:71
        "Processing"=> "",

        #: storage/themes/default/user/import.php:77
        "links"=> "",

        #: storage/themes/default/user/index.php:2
        "Traffic Overview"=> "",

        #: storage/themes/default/user/index.php:8
        "Total Clicks"=> "",

        #: storage/themes/default/user/index.php:12
        "(Current Period)"=> "",

        #: storage/themes/default/user/index.php:16
        "(Today)"=> "",

        #: storage/themes/default/user/index.php:31
        "Shorten Link"=> "",

        #: storage/themes/default/user/index.php:34
        #: storage/themes/default/user/links.php:6
        "We are currently manually approving links. As soon as the link is approved, you will be able to start using it."=> "",

        #: storage/themes/default/user/index.php:45
        "Recent Links"=> "",

        #: storage/themes/default/user/index.php:50
        #: storage/themes/default/user/links.php:62
        "Most Popular"=> "",

        #: storage/themes/default/user/index.php:68
        #: storage/themes/default/user/links.php:26
        "Unarchive Selected"=> "",

        #: storage/themes/default/user/index.php:70
        #: storage/themes/default/user/links.php:28
        "Archive Selected"=> "",

        #: storage/themes/default/user/index.php:74
        #: storage/themes/default/user/index.php:265
        #: storage/themes/default/user/links.php:32
        #: storage/themes/default/user/links.php:214
        "Add to Campaign"=> "",

        #: storage/themes/default/user/index.php:78
        #: storage/themes/default/user/index.php:322
        #: storage/themes/default/user/links.php:36
        #: storage/themes/default/user/links.php:271
        "Add Pixels"=> "",

        #: storage/themes/default/user/index.php:100
        #: storage/themes/default/user/links.php:109
        "Search for links"=> "",

        #: storage/themes/default/user/index.php:118
        "No links found. You can create some."=> "",

        #: storage/themes/default/user/links.php:54
        "Sort Results"=> "",

        #: storage/themes/default/user/links.php:57
        "Sort By"=> "",

        #: storage/themes/default/user/links.php:63
        "Less Popular"=> "",

        #: storage/themes/default/user/links.php:90
        "Results Per Page"=> "",

        #: storage/themes/default/user/links.php:98
        "Older than"=> "",

        #: storage/themes/default/user/links.php:147
        "Export Links"=> "",

        #: storage/themes/default/user/links.php:148
        "This tool allows you to generate a list of urls in CSV format. Some basic data such clicks will be included as well."=> "",

        #: storage/themes/default/user/notifications.php:9
        "No Notifications"=> "",

        #: storage/themes/default/user/notifications.php:10
        "You don't have any notifications at the moment."=> "",

        #: storage/themes/default/user/security.php:9
        "Type"=> "",

        #: storage/themes/default/user/security.php:10
        "Logged Details"=> "",

        #: storage/themes/default/user/security.php:19
        #: storage/themes/default/user/security.php:23
        "Failed"=> "",

        #: storage/themes/default/user/security.php:21
        #: storage/themes/default/user/security.php:23
        #: storage/themes/default/user/security.php:29
        "Email 2FA"=> "",

        #: storage/themes/default/user/security.php:31
        "2FA"=> "",

        #: storage/themes/default/user/security.php:81
        #: storage/themes/default/user/security.php:150
        "Logout on all devices"=> "",

        #: storage/themes/default/user/security.php:82
        #: storage/themes/default/user/security.php:155
        "If you think your account is exposed or at risk, you can logout of all devices. We also recommend you to change your password as a precaution after logging out of all devices."=> "",

        #: storage/themes/default/user/security.php:83
        #: storage/themes/default/user/security.php:164
        "Logout"=> "",

        #: storage/themes/default/user/security.php:88
        #: storage/themes/default/user/security.php:116
        #: storage/themes/default/user/settings.php:236
        #: storage/themes/default/user/settings.php:350
        "Two-Factor Authentication (2FA)"=> "",

        #: storage/themes/default/user/security.php:90
        #: storage/themes/default/user/settings.php:238
        "2FA is an enhanced level security for your account. Each time you login, an extra step where you will need to enter a unique code will be required to gain access to your account. To enable 2FA, please click the button below and download the <strong>Google Authenticator</strong> app from Apple Store or Play Store."=> "",

        #: storage/themes/default/user/security.php:101
        #: storage/themes/default/user/settings.php:249
        "You need to scan the code above with the app. You need to backup the QR code by saving it and save the key somewhere safe in case you lose your phone. You will not be able to login if you can't provide the code, in that case you will need to contact us. If you disable 2FA and re-enable it, you will need to scan a new code."=> "",

        #: storage/themes/default/user/security.php:102
        #: storage/themes/default/user/settings.php:250
        "Disable 2FA"=> "",

        #: storage/themes/default/user/security.php:104
        #: storage/themes/default/user/settings.php:252
        "Activate 2FA"=> "",

        #: storage/themes/default/user/security.php:122
        #: storage/themes/default/user/settings.php:356
        "You need to scan the code above with the app then enter the 6-digit number that you see in the app to activate 2FA. It is highly recommended to backup the unique key somewhere safe."=> "",

        #: storage/themes/default/user/security.php:138
        #: storage/themes/default/user/settings.php:372
        "Activate"=> "",

        #: storage/themes/default/user/settings.php:7
        "You have used a social network to login. You will need to choose a username."=> "",

        #: storage/themes/default/user/settings.php:22
        "Upload"=> "",

        #: storage/themes/default/user/settings.php:27
        "Remove Image"=> "",

        #: storage/themes/default/user/settings.php:30
        "By default, we will use the Gravatar associated to your email. Uploaded avatars must be square with the width ranging from 200-500px with a maximum size of {s}kb."=> "",

        #: storage/themes/default/user/settings.php:53
        "Please note that if you change your email, you will need to activate your account again."=> "",

        #: storage/themes/default/user/settings.php:61
        "A username is required for your public profile to be visible."=> "",

        #: storage/themes/default/user/settings.php:70
        #: storage/themes/default/user/settings.php:77
        "Leave blank to keep current one."=> "",

        #: storage/themes/default/user/settings.php:96
        "Account Type"=> "",

        #: storage/themes/default/user/settings.php:107
        #: storage/themes/default/user/verification.php:34
        "Company Name"=> "",

        #: storage/themes/default/user/settings.php:155
        "Preferences"=> "",

        #: storage/themes/default/user/settings.php:161
        "Default Domain"=> "",

        #: storage/themes/default/user/settings.php:174
        "Default Redirection"=> "",

        #: storage/themes/default/user/settings.php:192
        "Public profile will be activated only when this option is public."=> "",

        #: storage/themes/default/user/settings.php:204
        "Media Gateway"=> "",

        #: storage/themes/default/user/settings.php:205
        "If enabled, special pages will be automatically created for your media URLs (e.g. youtube, vimeo, dailymotion...)."=> "",

        #: storage/themes/default/user/settings.php:218
        "If enabled, you will receive occasional newsletters from us."=> "",

        #: storage/themes/default/user/settings.php:259
        "Connect your account"=> "",

        #: storage/themes/default/user/settings.php:260
        "You can connect your account to Facebook, X or Google to login with your social accounts. You can only connect one social media account."=> "",

        #: storage/themes/default/user/settings.php:265
        "Connected with Facebook"=> "",

        #: storage/themes/default/user/settings.php:270
        "Connect with Facebook"=> "",

        #: storage/themes/default/user/settings.php:278
        "Connected with X"=> "",

        #: storage/themes/default/user/settings.php:283
        "Connect with X"=> "",

        #: storage/themes/default/user/settings.php:291
        "Connected with Google"=> "",

        #: storage/themes/default/user/settings.php:296
        "Connect with Google"=> "",

        #: storage/themes/default/user/settings.php:311
        #: storage/themes/default/user/settings.php:324
        "Delete your account"=> "",

        #: storage/themes/default/user/settings.php:312
        #: storage/themes/default/user/settings.php:329
        "We respect your privacy and as such you can delete your account permanently and remove all your data from our server. Please note that this action is permanent and cannot be reversed."=> "",

        #: storage/themes/default/user/settings.php:313
        "Delete Permanently"=> "",

        #: storage/themes/default/user/tools.php:8
        #: storage/themes/default/user/tools.php:38
        "Bookmarklet"=> "",

        #: storage/themes/default/user/tools.php:9
        #: storage/themes/default/user/tools.php:57
        "Full-Page Script"=> "",

        #: storage/themes/default/user/tools.php:20
        "This tool allows you to quickly shorten any URL in any page without using any fancy method. This is perhaps the quickest and the easiest method available for you to shorten URLs across all platforms. This method will generate a unique short URL for you that you will be able to access anytime from your dashboard."=> "",

        #: storage/themes/default/user/tools.php:22
        "Use your quick URL below to shorten any URL by adding the URL after /q/?u=. <strong>For security reasons, you need to be logged in and using the remember me feature.</strong> Check out the examples below to understand how to use this method."=> "",

        #: storage/themes/default/user/tools.php:28
        #: storage/themes/default/user/tools.php:47
        "Notes"=> "",

        #: storage/themes/default/user/tools.php:30
        "Please note that this method does not return anything. It simply redirects the user to the redirection page. However if you need the actual short URL, you can always get it from your dashboard."=> "",

        #: storage/themes/default/user/tools.php:40
        "You can use our bookmarklet tool to instantaneously shorten any site you are currently viewing and if you are logged in on our site, it will be automatically saved to your account for future access. Simply drag the following link to your bookmarks bar or copy the link and manually add it to your favorites."=> "",

        #: storage/themes/default/user/tools.php:42
        "Drag me to your Bookmark Bar"=> "",

        #: storage/themes/default/user/tools.php:42
        "Shorten URL"=> "",

        #: storage/themes/default/user/tools.php:44
        "If you can't drag the link above, use your browser's bookmark editor to create a new bookmark and add the URL below as the link."=> "",

        #: storage/themes/default/user/tools.php:49
        "Please note that for secured sites that use SSL, the widget will not pop up due to security issues. In that case, the user will be redirected our site where you will be able to view your short URL."=> "",

        #: storage/themes/default/user/tools.php:59
        "This script allows you to shorten all (or select) URLs on your website very easily. All you need to do is to copy and paste the code below at the end of your page. You can customize the selector as you wish to target URLs in a specific selector. Note you can just  copy the code below because everything is already for you."=> "",

        #: storage/themes/default/user/tools.php:63
        "Choosing a different domain"=> "",

        #: storage/themes/default/user/tools.php:64
        "By default, the script uses the default domain on the platform however you can define a custom domain name to shorten links with. You need to make sure the domain is exactly the same as the domain added in the account, including the schema (http/https"=> "",

        #: storage/themes/default/user/tools.php:68
        "Choosing custom selectors"=> "",

        #: storage/themes/default/user/tools.php:69
        "By default, this script shortens all URLs in a page. If you want to target specific URLs then you can add a selector parameter. You can see an example below where the script will only shorten URLs having a class named mylink or all direct link in the .content container or all links in the .comments container"=> "",

        #: storage/themes/default/user/tools.php:73
        "Excluding domain names"=> "",

        #: storage/themes/default/user/tools.php:74
        "You can exclude domain names if you wish. You can add an exclude parameter to exclude domain names. The example below shortens all URLs but excludes URLs from google.com or apple.com"=> "",

        #: storage/themes/default/user/tools.php:78
        "Restricting domain names"=> "",

        #: storage/themes/default/user/tools.php:79
        "You can restrict domain names by adding an include parameter to restrict domain names. The example below shortens all URLs within the include domain name."=> "",

        #: storage/themes/default/user/verification.php:15
        "You can get your account verified and this provides you several benefits. After we verify we your account, you will get a verified checkmark on your Bio Pages and your links will have a trusted status."=> "",

        #: storage/themes/default/user/verification.php:17
        "All we need from you is a document that matches your name and address. Documents can be a national card, company bill or any other official document."=> "",

        #: storage/themes/default/user/verification.php:19
        "Upload Document"=> "",

        #: storage/themes/default/user/verification.php:21
        "2MB max, PDF or JPG"=> "",

        #: storage/themes/default/user/verification.php:73
        "Submit"=> "",

        #: storage/themes/default/user/verification.php:80
        "Verifications"=> "",

        #: storage/themes/default/user/withdrawals.php:12
        "Requested At"=> "",

        #: storage/themes/default/user/withdrawals.php:13
        "Processed At"=> "",

        #: storage/themes/default/user/withdrawals.php:55
        "Request Withdrawal"=> "",

        #: storage/themes/default/verifylink.php:5
        "Check the short link's source to make sure the destination is safe before you click on it."=> "",

        #: storage/themes/default/verifylink.php:12
        "Paste url"=> "",

        #: storage/themes/the23/auth/email2fa.php:15
        "Email Verification"=> "",

        #: storage/themes/the23/auth/email2fa.php:23
        "Email Verification Code"=> "",

        #: storage/themes/the23/auth/email2fa.php:26
        "Expires in 10 minutes"=> "",

        #: storage/themes/the23/auth/invite.php:26
        #: storage/themes/the23/auth/register.php:67
        "Please enter a email"=> "",

        #: storage/themes/the23/auth/login.php:19
        "Welcome back"=> "",

        #: storage/themes/the23/auth/register.php:19
        "Let's get you started right away!"=> "",

        #: storage/themes/the23/auth/reset.php:25
        "Please enter your password"=> "",

        #: storage/themes/the23/auth/reset.php:31
        "Please confirm your password"=> "",

        #: storage/themes/the23/blog/partial.php:15
        "By"=> "",

        #: storage/themes/the23/blog/partial.php:17
        "in"=> "",

        #: storage/themes/the23/blog/partial.php:22
        "Read more"=> "",

        #: storage/themes/the23/blog/search.php:13
        #: storage/themes/the23/blog/search.php:29
        "Results for \"{q}\""=> "",

        #: storage/themes/the23/blog/single.php:39
        "{c} mins read"=> "",

        #: storage/themes/the23/class/themeSettings.php:178
        "Theme Scheme"=> "",

        #: storage/themes/the23/class/themeSettings.php:189
        "Auto Mode"=> "",

        #: storage/themes/the23/class/themeSettings.php:192
        "Pre-defined Colors"=> "",

        #: storage/themes/the23/class/themeSettings.php:193
        "You can choose from pre-defined colors to quickly apply to your theme."=> "",

        #: storage/themes/the23/class/themeSettings.php:204
        "Ocean Blue"=> "",

        #: storage/themes/the23/class/themeSettings.php:219
        "Coral Sunset"=> "",

        #: storage/themes/the23/class/themeSettings.php:220
        "Warm"=> "",

        #: storage/themes/the23/class/themeSettings.php:234
        "Royal Purple"=> "",

        #: storage/themes/the23/class/themeSettings.php:235
        "Elegant"=> "",

        #: storage/themes/the23/class/themeSettings.php:249
        "Forest Green"=> "",

        #: storage/themes/the23/class/themeSettings.php:250
        "Natural"=> "",

        #: storage/themes/the23/class/themeSettings.php:264
        "Midnight Dark"=> "",

        #: storage/themes/the23/class/themeSettings.php:265
        "Dark"=> "",

        #: storage/themes/the23/class/themeSettings.php:279
        "Vibrant Pink"=> "",

        #: storage/themes/the23/class/themeSettings.php:280
        "Bold"=> "",

        #: storage/themes/the23/class/themeSettings.php:287
        "Theme Colors"=> "",

        #: storage/themes/the23/class/themeSettings.php:288
        "You can customize colors for front pages (home, pricing, blog etc). Some colors are already preset. You can either use colors from the palette (example #1 with #1 in all options) or mix and match. You can also use your own colors. After saving settings, if you do not see changes, you need to release browser cache. If you are using Cloudflare, you will need to purge cache as well."=> "",

        #: storage/themes/the23/class/themeSettings.php:290
        "Body Color"=> "",

        #: storage/themes/the23/class/themeSettings.php:294
        "Body Text Color"=> "",

        #: storage/themes/the23/class/themeSettings.php:298
        "Primary Color"=> "",

        #: storage/themes/the23/class/themeSettings.php:302
        "Primary Alternative Color"=> "",

        #: storage/themes/the23/class/themeSettings.php:306
        "Secondary Color"=> "",

        #: storage/themes/the23/class/themeSettings.php:310
        "Primary Background Color (Light color)"=> "",

        #: storage/themes/the23/class/themeSettings.php:314
        "Dark Background Color (Dark color)"=> "",

        #: storage/themes/the23/class/themeSettings.php:318
        "Scrollbar Color"=> "",

        #: storage/themes/the23/class/themeSettings.php:327
        "Pricing Style"=> "",

        #: storage/themes/the23/class/themeSettings.php:332
        "Table"=> "",

        #: storage/themes/the23/class/themeSettings.php:335
        "Categorized"=> "",

        #: storage/themes/the23/class/themeSettings.php:339
        "Blog Style"=> "",

        #: storage/themes/the23/class/themeSettings.php:344
        "Grid"=> "",

        #: storage/themes/the23/class/themeSettings.php:357
        "Menu type"=> "",

        #: storage/themes/the23/class/themeSettings.php:359
        "Menu stays on top until you scroll down then it follows"=> "",

        #: storage/themes/the23/class/themeSettings.php:362
        "Menu always stays on top"=> "",

        #: storage/themes/the23/class/themeSettings.php:373
        "Custom Home Page Image"=> "",

        #: storage/themes/the23/class/themeSettings.php:381
        "This will replace the default hero image that comes shipped with the script. JPG or PNG. 500 kb max. Recommended size: 560x710"=> "",

        #: storage/themes/the23/class/themeSettings.php:384
        "Home Main Header"=> "",

        #: storage/themes/the23/class/themeSettings.php:386
        "This will replace the home main header right before the shortener form. If you leave it empty, the site title will be shown."=> "",

        #: storage/themes/the23/class/themeSettings.php:389
        "Home Main Description"=> "",

        #: storage/themes/the23/class/themeSettings.php:391
        "This will replace the home main description right before the shortener form. If you leave it empty, the site description will be shown."=> "",

        #: storage/themes/the23/class/themeSettings.php:396
        "Default Site Image"=> "",

        #: storage/themes/the23/class/themeSettings.php:404
        "This will be used as default OG image unless override by pages."=> "",

        #: storage/themes/the23/class/themeSettings.php:409
        "You can add custom links to the menu using the following format (one per line): TITLE|LINK"=> "",

        #: storage/themes/the23/class/themeSettings.php:412
        "Custom Footer"=> "",

        #: storage/themes/the23/class/themeSettings.php:414
        "You can add custom footer to the page. This will be shown at the bottom of the page."=> "",

        #: storage/themes/the23/help/search.php:11
        "Search Results for \"{q}\""=> "",

        #: storage/themes/the23/help/top.php:4
        "How can we help you?"=> "",

        #: storage/themes/the23/index.php:9
        "customers"=> "",

        #: storage/themes/the23/index.php:11
        "thousands of users"=> "",

        #: storage/themes/the23/index.php:16
        "Intuitive, Secure<br>& Dynamic"=> "",

        #: storage/themes/the23/index.php:19
        "Boost your campaigns by creating dynamic Links, QR codes and Bio Pages and get instant analytics."=> "",

        #: storage/themes/the23/index.php:62
        "Get Started for Free"=> "",

        #: storage/themes/the23/index.php:65
        "Start free, upgrade later"=> "",

        #: storage/themes/the23/index.php:66 storage/themes/the23/index.php:76
        "No credit card required"=> "",

        #: storage/themes/the23/index.php:67 storage/themes/the23/index.php:77
        "Easy to use"=> "",

        #: storage/themes/the23/index.php:75
        "Start with a free trial"=> "",

        #: storage/themes/the23/index.php:142
        "Smart Short Links"=> "",

        #: storage/themes/the23/index.php:157
        "<span class=\"gradient-primary clip-text fw-bolder gradient-bottom\">Supercharge</span> <span class=\"thunder-animation fa fa-bolt text-warning\"></span> your productivity"=> "",

        #: storage/themes/the23/index.php:170
        "Quick Analytics"=> "",

        #: storage/themes/the23/index.php:171
        "Custom Alias"=> "",

        #: storage/themes/the23/index.php:177
        "Deep Links"=> "",

        #: storage/themes/the23/index.php:178
        "Custom Parameters"=> "",

        #: storage/themes/the23/index.php:180
        "Custom Meta Tags"=> "",

        #: storage/themes/the23/index.php:185
        "URL Shortener"=> "",

        #: storage/themes/the23/index.php:187
        "Transform long, complex URLs into memorable short links. Perfect for social media, marketing campaigns, and keeping your brand consistent."=> "",

        #: storage/themes/the23/index.php:209
        "Create stunning, mobile-optimized landing pages that showcase all your important links in one place. Perfect for social media profiles."=> "",

        #: storage/themes/the23/index.php:226
        "QR Styles"=> "",

        #: storage/themes/the23/index.php:227
        "Dynamic QR Codes"=> "",

        #: storage/themes/the23/index.php:228
        "Custom Frames"=> "",

        #: storage/themes/the23/index.php:237
        "Generate dynamic QR codes that can be customized with your brand colors and tracked in real-time."=> "",

        #: storage/themes/the23/index.php:252
        "Collect data within minutes. Hassle-free."=> "",

        #: storage/themes/the23/index.php:270
        "Intuitive and trackable links"=> "",

        #: storage/themes/the23/index.php:283
        "Customizable and secure QR codes"=> "",

        #: storage/themes/the23/index.php:295
        "Beautiful Bio Pages"=> "",

        #: storage/themes/the23/index.php:296
        "Simple yet beautiful Bio Pages for your links"=> "",

        #: storage/themes/the23/index.php:305
        "Turn long links into short links"=> "",

        #: storage/themes/the23/index.php:308
        "Where are most of your users located?"=> "",

        #: storage/themes/the23/index.php:313
        "Canada"=> "",

        #: storage/themes/the23/index.php:322
        "United States of America"=> "",

        #: storage/themes/the23/index.php:331
        "United Kingdom"=> "",

        #: storage/themes/the23/index.php:340
        "Japan"=> "",

        #: storage/themes/the23/index.php:354
        "Instantly link to apps. Automatically."=> "",

        #: storage/themes/the23/index.php:357
        "Smart Deep Linking"=> "",

        #: storage/themes/the23/index.php:360
        "Grow your audience by automatically opening mobile apps when the app is installed without any coding knowledge or SDK. Direct customers to download and install apps when not installed on the device. Many popular apps are supported and you can even add your own app links."=> "",

        #: storage/themes/the23/index.php:369
        "Popular Apps"=> "",

        #: storage/themes/the23/index.php:384
        "Features that<br>you'll <span class=\"gradient-primary clip-text\">ever need</span>"=> "",

        #: storage/themes/the23/index.php:385
        "We provide you with all the tools you need to increase your productivity."=> "",

        #: storage/themes/the23/index.php:421
        "Easily apply restrictions to your links and target users in specific countries & languages using specific devices."=> "",

        #: storage/themes/the23/index.php:430
        "Invite your team members and assign them specific privileges to manage everything and collaborate together."=> "",

        #: storage/themes/the23/index.php:439
        "Easily add your own domain name for short links and take control of your brand name and your users' trust."=> "",

        #: storage/themes/the23/index.php:446
        "Campaigns & Channels"=> "",

        #: storage/themes/the23/index.php:448
        "Group and organize your Links, Bio Pages and QR Codes. With Campaigns, you can also get aggregated stats."=> "",

        #: storage/themes/the23/index.php:472
        "Someone scanned your QR Code"=> "",

        #: storage/themes/the23/index.php:486
        "Someone visited your Link"=> "",

        #: storage/themes/the23/index.php:500
        "Someone viewed your Bio Page"=> "",

        #: storage/themes/the23/index.php:513
        "Get instant results"=> "",

        #: storage/themes/the23/index.php:516
        "Track & Optimize"=> "",

        #: storage/themes/the23/index.php:528
        "Invite People"=> "",

        #: storage/themes/the23/index.php:529 storage/themes/the23/index.php:532
        #: storage/themes/the23/index.php:541 storage/themes/the23/index.php:553
        "Invite your teammates & work together"=> "",

        #: storage/themes/the23/index.php:530
        "Members"=> "",

        #: storage/themes/the23/index.php:534
        "Jane Doe"=> "",

        #: storage/themes/the23/index.php:543
        "Barry Tone"=> "",

        #: storage/themes/the23/index.php:549
        "Invited"=> "",

        #: storage/themes/the23/index.php:555
        "John Doe"=> "",

        #: storage/themes/the23/index.php:566
        "Collaborate with your teammates"=> "",

        #: storage/themes/the23/index.php:569
        "Invite & Work Together"=> "",

        #: storage/themes/the23/index.php:572
        "Invite your teammates within seconds and work together as team to manage your Links, Bio Pages and QR codes. Team members can can be assigned specific privileges and can work on different workspaces."=> "",

        #: storage/themes/the23/index.php:624
        "Connect your links to third-party applications so they can share information such as traffic and analytics."=> "",

        #: storage/themes/the23/index.php:676
        "Add your custom pixel from providers such as Facebook & Google Tag Manager and track events right when they are happening."=> "",

        #: storage/themes/the23/index.php:687
        "Get notified when users use your links via various channels such as Slack and webhook services like Zapier."=> "",

        #: storage/themes/the23/index.php:703
        "Don't take our word for it."=> "",

        #: storage/themes/the23/index.php:704
        "Trust our customers."=> "",

        #: storage/themes/the23/index.php:737
        "Let <br><span class=\"gradient-primary clip-text\">the numbers</span><br> do the talking"=> "",

        #: storage/themes/the23/index.php:770
        "Amazing Customers"=> "",

        #: storage/themes/the23/index.php:793 storage/themes/the23/pages/bio.php:191
        #: storage/themes/the23/pages/qr.php:478
        "Take control of your links"=> "",

        #: storage/themes/the23/index.php:794 storage/themes/the23/pages/bio.php:192
        #: storage/themes/the23/pages/qr.php:479
        "You are one click away from taking control of all of your links, and instantly get better results."=> "",

        #: storage/themes/the23/pages/api.php:84 storage/themes/the23/pages/api.php:303
        "Copy Code"=> "",

        #: storage/themes/the23/pages/api.php:232
        "Please note that the rate might change according to the subscribed plan."=> "",

        #: storage/themes/the23/pages/bio.php:15
        "Type your alias"=> "",

        #: storage/themes/the23/pages/bio.php:16
        "Reserve"=> "",

        #: storage/themes/the23/pages/bio.php:22 storage/themes/the23/pages/qr.php:308
        "Contact sales"=> "",

        #: storage/themes/the23/pages/bio.php:28
        "company"=> "",

        #: storage/themes/the23/pages/bio.php:28
        "shop"=> "",

        #: storage/themes/the23/pages/bio.php:28
        "name"=> "",

        #: storage/themes/the23/pages/bio.php:68
        "{n}+ Dynamic Widgets"=> "",

        #: storage/themes/the23/pages/bio.php:69
        "Enhance your Bio Page with our dynamic widgets"=> "",

        #: storage/themes/the23/pages/bio.php:82
        "Customize everything with our easy to use builder"=> "",

        #: storage/themes/the23/pages/bio.php:95
        "Configure your Bio Page & blocks your way"=> "",

        #: storage/themes/the23/pages/bio.php:142
        "Our videos"=> "",

        #: storage/themes/the23/pages/bio.php:145
        "Follow us"=> "",

        #: storage/themes/the23/pages/bio.php:170
        "Connect with your <span class=\"gradient-primary clip-text\">audience</span>"=> "",

        #: storage/themes/the23/pages/bio.php:171
        "Add widgets from popular providers and enhance your Bio Page with dynamic content"=> "",

        #: storage/themes/the23/pages/contact.php:46
        "Please enter a valid name"=> "",

        #: storage/themes/the23/pages/contact.php:58
        "The message is empty or too short"=> "",

        #: storage/themes/the23/partials/main_menu.php:121
        "Find answers to your questions"=> "",

        #: storage/themes/the23/pricing/categorized.php:22
        "Save {p}% by paying yearly"=> "",

        #: storage/themes/the23/pricing/categorized.php:61
        "Compare Plans"=> "",

        #: storage/themes/the23/pricing/categorized.php:155
        #: storage/themes/the23/pricing/list.php:45
        #: storage/themes/the23/pricing/table.php:81
        "{x}/min"=> "",

        #: storage/themes/the23/pricing/checkout.php:58
        "Tax ID (optional)"=> "",

        #: storage/themes/the23/pricing/checkout.php:150
        "Enter promo code"=> "",

        #: storage/themes/the23/pricing/index.php:8
        "Choose the plan <br>that works for you"=> "",

        #: storage/themes/the23/pricing/index.php:10
        "Transparent pricing without any hidden fees so you always know what you will pay."=> "",

        #: storage/themes/the23/pricing/index.php:29
        "Save {d}%"=> "",

        #: storage/themes/the23/pricing/index.php:61
        "If you have questions, please don't hesitate to contact us."=> "",

    ]
];