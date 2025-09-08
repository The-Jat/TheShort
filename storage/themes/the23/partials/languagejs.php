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