<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Services\ContactEmailRenderer;
use App\Services\ResendContactMailer;
use App\Services\TurnstileVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use Resend\Exceptions\ErrorException;
use Throwable;

class ContactController extends Controller
{
    public function __construct(
        private readonly TurnstileVerifier $turnstileVerifier,
        private readonly ContactEmailRenderer $contactEmailRenderer,
        private readonly ResendContactMailer $resendContactMailer,
    ) {}

    public function methodNotAllowed(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 405,
            'message' => 'Este formulario solo acepta envíos por POST.',
        ], 405);
    }

    public function send(ContactFormRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $ip = $request->ip() ?? '';
        $userAgent = $request->userAgent() ?? '';

        $turnstileToken = $validated['turnstileToken'];
        unset($validated['turnstileToken']);

        $verification = $this->turnstileVerifier->verify($turnstileToken, $ip);

        if (! $verification['success']) {
            $payload = $verification['payload'];
            $errorDetail = $payload !== null
                ? Arr::only($payload, ['success', 'error-codes', 'challenge_ts', 'hostname', 'action', 'cdata'])
                : ['reason' => 'verification_failed'];

            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'Verificación de seguridad fallida.',
                'error_detail' => $errorDetail,
            ], 403);
        }

        $logoUrl = $this->resolveLogoUrl();
        $submittedAt = now()->timezone(config('app.timezone'))->format('Y-m-d H:i:s T');

        $emailProps = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'] ?? null,
            'submittedAt' => $submittedAt,
            'ipAddress' => $ip,
            'userAgent' => $userAgent,
            'logoUrl' => $logoUrl,
        ];

        try {
            $html = $this->contactEmailRenderer->render($emailProps);

            $to = config('contact.mail.to');
            $from = config('contact.mail.from');

            if (! is_string($to) || $to === '') {
                throw new \InvalidArgumentException('CONTACT_TO_EMAIL no está configurada.');
            }

            $subject = '[Web Powervit] Nuevo contacto: '.$validated['name'];

            $this->resendContactMailer->send($html, $subject, $to, $from);
        } catch (ErrorException $e) {
            Log::error('Resend rechazó el envío del formulario de contacto.', [
                'message' => $e->getMessage(),
                'type' => $e->getErrorType(),
                'code' => $e->getErrorCode(),
                'resend_error' => $this->resendErrorPayload($e),
                'mail_from' => config('contact.mail.from'),
                'mail_to' => config('contact.mail.to'),
            ]);

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'No se pudo enviar el mensaje.',
            ], 500);
        } catch (Throwable $e) {
            Log::error('Error al enviar el formulario de contacto.', [
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'No se pudo enviar el mensaje.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Mensaje enviado correctamente.',
        ]);
    }

    public function previewEmail(Request $request): \Illuminate\Contracts\View\View
    {
        if (! app()->environment('local')) {
            abort(404);
        }

        $logoUrl = $this->resolveLogoUrl();

        return view('emails.contact-preview', [
            'name' => $request->query('name', 'María Ejemplo'),
            'email' => $request->query('email', 'maria@example.com'),
            'phone' => $request->query('phone', '+34 600 000 000'),
            'subject' => $request->query('subject', 'Consulta sobre membresía'),
            'message' => $request->query('message', 'Hola, me gustaría recibir más información sobre Powervit.'),
            'submittedAt' => now()->timezone(config('app.timezone'))->format('Y-m-d H:i:s T'),
            'ipAddress' => $request->ip() ?? '127.0.0.1',
            'userAgent' => $request->userAgent() ?? 'Preview',
            'logoUrl' => $logoUrl,
        ]);
    }

    private function resolveLogoUrl(): string
    {
        $configured = config('contact.logo_url');

        if (is_string($configured) && $configured !== '') {
            return $configured;
        }

        return rtrim((string) config('app.url'), '/').'/logo.png';
    }

    /**
     * @return array<string, mixed>
     */
    private function resendErrorPayload(ErrorException $e): array
    {
        try {
            $reflection = new ReflectionClass($e);
            $property = $reflection->getProperty('contents');
            $property->setAccessible(true);

            /** @var array<string, mixed> $contents */
            $contents = $property->getValue($e);

            return $contents;
        } catch (Throwable) {
            return ['message' => $e->getMessage()];
        }
    }
}
