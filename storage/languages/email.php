<?php
/**
 * English language for the Emails
 */
return [
    /**
     * Language Information
     */
    "code" => "en",
    "region" => "en_US",
    "name" => "Email Template",
    "author" => "GemPixel",
    "link" => "https://gempixel.com",
    "date" => "01/04/2023",
    /**
     * Language Data
     */
    "data" => [
        'registration' => '<p><strong>Hello!</strong></p><p>You have been successfully registered at {site.title}. You can now login to our site at <a href="{site.link}">{site.link}</a>.</p>',

        'activation' => '<p><strong>Hello!</strong></p><p>You have been successfully registered at {site.title}. To login you will have to activate your account by clicking the URL below.</p><p><a href="{user.activation}">{user.activation}</a></p>',

        'success' => '<p><strong>Hello!</strong></p><p>Your account has been successfully activated at {site.title}.</p>',

        'passwordreset' => '<p><strong>Hello!</strong></p><p><strong>A request to reset your password was made.</strong>&nbsp;If you&nbsp;<strong>did not</strong>&nbsp;make this request, please ignore and delete this email otherwise click the link below to reset your password.</p><p><a href="{user.activation}"><strong>Click here to reset your password.</strong></a></p><p>If you cannot click on the link above, simply copy &amp; paste the following link into your browser.</p><p><a href="{user.activation}">{user.activation}</a></p>',
        
        'teaminvitation' => '<p><strong>Hello!</strong></p><p>You have been invited to join our team at {site.title}. To accept the invitation, please click the link below.</p><p><a href="{user.invite}">{user.invite}</a></p>',

        'verify2fa' => '<p><strong>Hello!</strong></p><p>A request was made to reset and disable 2FA on your account. If you <strong>did not</strong> make this request, please ignore and delete this email otherwise click the link below to reset it.</p><p><a href="{user.activation}"><strong>Click here to reset.</strong></a></p><p>If you cannot click on the link above, simply copy & paste the following link into your browser.</p><p><a href="{user.activation}">{user.activation}</a></p></p>',

        'newip' => "<p><strong>Hello!</strong></p><p>A new login has been made from a new IP address. If this wasn't you, please secure your account immediately.&nbsp;</p><p><strong>IP Address</strong>: {ip}</p><p><strong>Location</strong>: {location}</p><p><strong>Date &amp; Time</strong>: {datetime}</p>",
    ]
];