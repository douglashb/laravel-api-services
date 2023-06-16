<?php

return [
    'password' => [
        'history_keep' => env('PASSWORD_HISTORY_KEEP',10)
    ],
    'provider' => [
        'url' => env('API_PROVIDER_URL')
    ],
    'uniteller' => [
        'question_id' => env('UNITELLER_QUESTION_ID', 40)
    ]
];
