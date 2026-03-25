<?php

return [

    'turnstile' => [
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
        'verify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
    ],

    'resend' => [
        'api_key' => env('RESEND_API_KEY'),
    ],

    'mail' => [
        'to' => env('CONTACT_TO_EMAIL'),
        'from' => env('CONTACT_FROM_EMAIL', 'no-reply@powervit.fit'),
    ],

    'logo_url' => env('CONTACT_LOGO_URL'),

];
