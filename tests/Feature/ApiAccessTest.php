<?php

use App\Services\ContactEmailRenderer;
use App\Services\ResendContactMailer;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Http;

it('la raíz web muestra Unauthorized en HTML', function () {
    $this->get('/')
        ->assertStatus(401)
        ->assertSee('Unauthorized', false);
});

it('GET /api devuelve JSON Unauthorized', function () {
    config(['api.access_token' => '']);

    $this->getJson('/api')
        ->assertStatus(401)
        ->assertExactJson([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthorized.',
        ]);
});

it('responde Unauthorized sin X-Api-Key cuando API_ACCESS_TOKEN está definido', function () {
    config(['api.access_token' => 'clave-secreta-de-prueba']);

    $this->getJson('/api/user')
        ->assertStatus(401)
        ->assertExactJson([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthorized.',
        ]);
});

it('permite la petición con X-Api-Key válido', function () {
    config(['api.access_token' => 'clave-secreta-de-prueba']);

    $this->getJson('/api/user', [
        'X-Api-Key' => 'clave-secreta-de-prueba',
    ])->assertStatus(401)->assertJson([
        'success' => false,
        'status' => 401,
        'message' => 'Unauthorized.',
    ]);
});

it('no exige X-Api-Key para POST /api/contact aunque exista token', function () {
    config(['api.access_token' => 'clave-secreta-de-prueba']);

    Http::fake([
        'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
    ]);

    $this->mock(ContactEmailRenderer::class)
        ->shouldReceive('render')
        ->once()
        ->andReturn('<html/>');

    $this->mock(ResendContactMailer::class)
        ->shouldReceive('send')
        ->once();

    config([
        'contact.turnstile.secret_key' => 'test-secret',
        'contact.resend.api_key' => 'test-resend',
        'contact.mail.to' => 'ventas@powervit.fit',
        'contact.mail.from' => 'no-reply@powervit.fit',
    ]);

    $this->withoutMiddleware(ThrottleRequests::class);

    $this->postJson('/api/contact', [
        'name' => 'Ana',
        'email' => 'ana@example.com',
        'phone' => '+34 600 111 222',
        'turnstileToken' => 'token-ok',
    ])->assertOk();
});

it('unifica Sanctum a JSON Unauthorized en rutas api', function () {
    config(['api.access_token' => '']);

    $this->getJson('/api/user')
        ->assertStatus(401)
        ->assertJson([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthorized.',
        ]);
});
