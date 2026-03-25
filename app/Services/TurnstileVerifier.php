<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TurnstileVerifier
{
    /**
     * @return array{success: bool, payload: array<string, mixed>|null}
     */
    public function verify(string $token, string $remoteIp): array
    {
        $secret = config('contact.turnstile.secret_key');
        $url = config('contact.turnstile.verify_url');

        if (! is_string($secret) || $secret === '') {
            Log::error('Turnstile no configurado: falta TURNSTILE_SECRET_KEY.');

            return ['success' => false, 'payload' => null];
        }

        try {
            $response = Http::timeout(10)
                ->connectTimeout(5)
                ->asForm()
                ->post($url, [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $remoteIp,
                ]);
        } catch (Throwable $e) {
            Log::error('Fallo de red al verificar Turnstile.', [
                'exception' => $e::class,
            ]);

            return ['success' => false, 'payload' => null];
        }

        if (! $response->successful()) {
            Log::warning('Respuesta HTTP inesperada de Turnstile.', [
                'status' => $response->status(),
            ]);

            return ['success' => false, 'payload' => null];
        }

        /** @var array<string, mixed> $payload */
        $payload = $response->json() ?? [];

        return [
            'success' => ($payload['success'] ?? false) === true,
            'payload' => $payload,
        ];
    }
}
