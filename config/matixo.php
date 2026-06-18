<?php

return [
    'name'           => 'MATIXO',
    'brand_color'    => '#20506B',
    'logo'           => '/admin/images/logo.svg',
    'admin_path'     => 'admin',

    'login' => [
        'max_attempts'        => 5,
        'decay_minutes'       => 1,
        'lockout_minutes'     => 15,
        'failed_notify_after' => 3,
    ],

    'password' => [
        'min_length'    => 10,
        'require_mixed' => true,
        'require_number'=> true,
        'require_symbol'=> true,
    ],

    'session_timeout_minutes' => 120,

    'media' => [
        'product_gallery_path' => 'products/gallery',
        'product_cover_path'   => 'products/cover',
        'category_path'        => 'categories',
        'slider_path'          => 'sliders',
        'campaign_path'        => 'campaigns',
        'reference_path'       => 'references',
        'page_path'            => 'pages',
        'setting_path'         => 'settings',
        'max_size_kb'          => 5120,
        'allowed_mimes'        => ['jpg', 'jpeg', 'png', 'webp'],
        'sizes' => [
            'thumb'  => [320, 240],
            'medium' => [800, 600],
        ],
    ],

    'activity_log_retention_days' => env('ACTIVITY_LOG_RETENTION_DAYS', 90),

    'languages_default' => [
        ['code' => 'tr', 'name' => 'Türkçe',  'flag' => '🇹🇷', 'is_default' => true,  'direction' => 'ltr'],
        ['code' => 'en', 'name' => 'English', 'flag' => '🇬🇧', 'is_default' => false, 'direction' => 'ltr'],
    ],
];
