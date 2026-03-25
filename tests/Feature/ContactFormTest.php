<?php

use App\Services\ContactEmailRenderer;
use App\Services\ResendContactMailer;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'contact.turnstile.secret_key' => 'test-secret',
        'contact.resend.api_key' => 'test-resend',
        'contact.mail.to' => 'ventas@powervit.fit',
        'contact.mail.from' => 'no-reply@powervit.fit',
    ]);
});

it('acepta un POST válido y responde 200', function () {
    $this->mock(ContactEmailRenderer::class)
        ->shouldReceive('render')
        ->once()
        ->andReturn('<html><body>ok</body></html>');

    $this->mock(ResendContactMailer::class)
        ->shouldReceive('send')
        ->once();

    Http::fake([
        'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
    ]);

    $this->withoutMiddleware(ThrottleRequests::class);

    $response = $this->postJson('/api/contact', [
        'name' => 'Ana',
        'email' => 'ana@example.com',
        'phone' => '+34 600 111 222',
        'turnstileToken' => 'token-ok',
    ]);

    $response->assertOk()->assertExactJson([
        'success' => true,
        'status' => 200,
        'message' => 'Mensaje enviado correctamente.',
    ]);
});

it('responde 422 cuando la validación falla', function () {
    $this->withoutMiddleware(ThrottleRequests::class);

    $response = $this->postJson('/api/contact', []);

    $response->assertStatus(422)->assertJson([
        'success' => false,
        'status' => 422,
        'message' => 'Error de validación.',
    ]);

    expect($response->json('errors'))->toBeArray()->not->toBeEmpty();
});

it('responde 403 cuando Turnstile falla', function () {
    Http::fake([
        'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
            'success' => false,
            'error-codes' => ['invalid-input-response'],
        ], 200),
    ]);

    $this->withoutMiddleware(ThrottleRequests::class);

    $response = $this->postJson('/api/contact', [
        'name' => 'Ana',
        'email' => 'ana@example.com',
        'phone' => '123',
        'turnstileToken' => 'bad',
    ]);

    $response->assertStatus(403)->assertJson([
        'success' => false,
        'status' => 403,
        'message' => 'Verificación de seguridad fallida.',
    ]);

    expect($response->json('error_detail'))->toBeArray();
});

it('responde 405 para GET', function () {
    $this->getJson('/api/contact')->assertStatus(405)->assertJson([
        'success' => false,
        'status' => 405,
        'message' => 'Este formulario solo acepta envíos por POST.',
    ]);
});
