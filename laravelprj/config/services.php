<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'github' => [
        'client_id' => 'a2860779ccedeb5cb2eb',
        'client_secret' => 'a30d47c1ad41195ab105a101f4c52875c622129b',
        'redirect' => 'http://localhost:8000/social/github',
        'access_token' => '093bc67534c089b2e23f6e93fe770b87bdd78518',
    ],
    'google' => [
        'client_id' => '583992254075-52etreuvju2ba0cqu47ru5rc0h65p0b2.apps.googleusercontent.com',
        'client_secret' => 'Ny-GJ9980nzSLdeiylXyUmJN',
        'redirect' => 'http://localhost:8000/social/google/callback',
    ],


];
