<?php

return [

    'application_name' => env('GOOGLE_APPLICATION_NAME', ''),

    'domain'           => env('GOOGLE_DOMAIN', ''),

    'client_id'        => env('GOOGLE_CLIENT_ID', ''),
    'client_secret'    => env('GOOGLE_CLIENT_SECRET', ''),
    'redirect_uri'     => env('GOOGLE_REDIRECT', ''),

    'scopes'           => [
        // 'https://www.googleapis.com/auth/admin.directory.user',
        // 'https://www.googleapis.com/auth/admin.directory.group'
    ],

    'access_type'      => env('GOOGLE_REDIRECT', 'online'),

    'approval_prompt' => 'auto',

    'developer_key' => env('GOOGLE_DEVELOPER_KEY', ''),

    'service' => [
        /*
        | Enable service account auth or not.
        */
        'enable' => env('GOOGLE_SERVICE_ENABLED', false),

        /*
        | Path to service account json file
        */
        'file' => env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION', '')
    ],

    'config' => [],
];
