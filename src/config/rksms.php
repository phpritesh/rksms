<?php

return [
    'sender' => env('DIGIMATE_SMS_SENDER', 'MyApp'),
    'tmid' => env('DIGIMATE_DLT_TM_ID', 'MyApp'),
    'peid' => env('DIGIMATE_DLT_PE_ID', 'MyApp'),
    'camp_name' => env('DIGIMATE_camp_name', 'MyApp'),
    'digimate' => [
        'username' => env('DIGIMATE_USERNAME'),
        'password' => env('DIGIMATE_PASSWORD'),
        
    ]
];