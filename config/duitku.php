<?php

return [
    'merchant_code' => env('DUITKU_MERCHANT_CODE', 'DSKRIPSI'),
    'api_key' => env('DUITKU_API_KEY', 'c8dc37ed95820f1cedd9958ecad3f1a7'),
    'sandbox_mode' => env('DUITKU_SANDBOX_MODE', true),
    
    'urls' => [
        'sandbox' => [
            'inquiry' => 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry',
            'payment_method' => 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod',
            'transaction_status' => 'https://sandbox.duitku.com/webapi/api/merchant/transactionStatus',
        ],
        'production' => [
            'inquiry' => 'https://passport.duitku.com/webapi/api/merchant/v2/inquiry',
            'payment_method' => 'https://passport.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod',
            'transaction_status' => 'https://passport.duitku.com/webapi/api/merchant/transactionStatus',
        ]
    ],

    // Callback URL akan di-construct di service
    'callback_url' => env('DUITKU_CALLBACK_URL', 'http://skripsi.test/api/payment/callback'),
    'return_url' => env('DUITKU_RETURN_URL', 'http://skripsi.test/payment/return'),

    // Default expiry time dalam menit
    'expiry_period' => env('DUITKU_EXPIRY_PERIOD', 1440), // 24 jam untuk VA

    // Project info untuk Duitku
    'project_name' => 'skripsi',
    'project_url' => 'http://skripsi.test/',
];
