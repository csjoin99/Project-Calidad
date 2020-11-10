<?php

return [
    'cliente_id'=>env('PAYPAL_CLIENT_ID'),
    'secret'=> env('PAYPAL_SECRET'),

    'settings'=>[
        'mode'=>env('PAYPAL_MODE','sandbox'),
        'http.ConnectionTimeOut'=>30,
        'log.LogEnabled'=>true,
        'log.Filename'=>storage_path('log/paypal.log'),
        'log.Loglevel'=>'ERROR'
    ]
];
