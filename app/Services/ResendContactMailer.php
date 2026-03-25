<?php

namespace App\Services;

class ResendContactMailer
{
    public function send(string $html, string $subject, string $to, string $from): void
    {
        $apiKey = config('contact.resend.api_key');

        if (! is_string($apiKey) || $apiKey === '') {
            throw new \InvalidArgumentException('RESEND_API_KEY no está configurada.');
        }

        $client = \Resend::client($apiKey);

        $client->emails->send([
            'from' => $from,
            'to' => array_values(array_filter(array_map('trim', explode(',', $to)))),
            'subject' => $subject,
            'html' => $html,
        ]);
    }
}
