<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>Unauthorized</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css'])
        @endif
    </head>
    <body class="flex min-h-screen flex-col items-center justify-center bg-slate-950 px-6 text-slate-100 antialiased">
        <div class="max-w-md text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-teal-400">Powervit</p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-white md:text-4xl">Unauthorized</h1>
            <p class="mt-4 text-base leading-relaxed text-slate-400">
                Este servidor solo expone la API del formulario de contacto. No hay interfaz web pública aquí.
            </p>
            <p class="mt-8 font-mono text-xs text-slate-600">HTTP 401</p>
        </div>
    </body>
</html>
