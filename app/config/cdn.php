<?php
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact GemPixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package CDNs
 * @author GemPixel (http://gempixel.com)
 * @copyright 2023 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

return [
    'editor' => [
        'version' => '5.35.3',
        'js' => [
            assets('frontend/libs/ckeditor/ckeditor5.js'),
            assets('frontend/libs/ckeditor/ckconfig.min.js')
        ],
        'css' => [
            assets('frontend/libs/ckeditor/ckeditor5.css'),
            assets('content-style.min.css')
        ]
    ],
    'simpleeditor' => [
        'version' => '0.8.20',
        'js' => [
            assets('frontend/libs/summernote/summernote.min.js')
        ],
        'css' => [
            assets('frontend/libs/summernote/summernote.min.css')
        ]
    ],
    'datetimepicker' => [
        "version" => '3.1',
        "css" => [
            assets('frontend/libs/daterangepicker/daterangepicker.min.css')
        ],
        "js" => [
            assets('frontend/libs/daterangepicker/moment.min.js'),
            assets('frontend/libs/daterangepicker/daterangepicker.min.js')
        ]
    ],
    'codeeditor' => [
        'version' => '1.4.12',
        'js' => ['//cdnjs.cloudflare.com/ajax/libs/ace/[version]/ace.js']
    ],
    'spectrum' => [
        'version' => '1.8.1',        
        'js'=> [
            assets('frontend/libs/spectrum/spectrum.min.js')
        ],
        'css'=> [
            assets('frontend/libs/spectrum/spectrum.min.css')
        ]
    ],
    'autocomplete' => [
        'version' => '1.4.11',
        'js' => [
            assets('frontend/libs/autocomplete/jquery.autocomplete.min.js')
        ]
    ],
    "daterangepicker" => [
        "version" => "3.1",
        "css" => [
            assets('frontend/libs/daterangepicker/daterangepicker.min.css')
        ],
        "js" => [
            assets('frontend/libs/daterangepicker/moment.min.js'),
            assets('frontend/libs/daterangepicker/daterangepicker.min.js')
        ]
    ],
    "hljs" => [
        "version" => "11.6",
        "js" => [
            assets('frontend/libs/highlightjs/highlight.min.js')
        ],
        "css" => [
            assets('frontend/libs/highlightjs/night-owl.min.css')
        ]
    ],
    'blockadblock' => [
        'version' => '3.2.1',
        'js' => [
            assets('frontend/libs/blockadblock/blockadblock.min.js')
        ]
    ],
    'coloris' => [
        'version' => '0.16.2',
        'js'=> [
            assets('frontend/libs/coloris/coloris.min.js')
        ],
        'css'=> [
            assets('frontend/libs/coloris/coloris.min.css')
        ]
    ],
    'cropper' => [
        'version' => '1.5.12',
        'js' => [
            assets('frontend/libs/cropper/cropper.min.js'),
            assets('crop.min.js')
        ],
        'css' => [
            assets('frontend/libs/cropper/cropper.min.css')
        ]
    ]
];