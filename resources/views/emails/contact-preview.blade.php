<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vista previa — Correo de contacto Powervit</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-slate-100 py-10 font-sans text-slate-900 antialiased">
        <div class="mx-auto max-w-xl px-4">
            <p class="mb-4 text-center text-sm text-slate-500">
                Vista previa local (Blade + Tailwind). El envío real usa React Email + Lucide.
            </p>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                {{-- Cabecera alineada con el correo (gradiente teal) --}}
                <div
                    class="bg-gradient-to-br from-teal-600 to-teal-800 px-7 pb-6 pt-7 text-center text-white"
                >
                    <span
                        class="mb-4 inline-block rounded-full bg-white/20 px-3.5 py-1.5 text-[11px] font-bold uppercase tracking-widest"
                    >
                        Formulario web
                    </span>
                    <img
                        src="{{ $logoUrl }}"
                        width="150"
                        alt="Powervit"
                        class="mx-auto mb-4 block h-auto max-w-[150px]"
                    />
                    <h1 class="text-[22px] font-bold leading-tight">Nuevo mensaje de contacto</h1>
                    <p class="mt-1.5 text-sm text-white/90">
                        Alguien ha escrito desde la web. Responde cuando puedas.
                    </p>
                </div>

                <div class="px-7 py-7">
                    <p class="mb-4 text-[13px] font-bold tracking-tight text-slate-900">Datos del contacto</p>

                    <div class="space-y-5">
                        <x-email-field icon="user" label="Nombre" :value="$name" />
                        <x-email-field icon="mail" label="Correo" :value="$email" :href="'mailto:'.$email" />
                        <x-email-field icon="phone" label="Teléfono" :value="$phone" />
                        @if ($subject)
                            <x-email-field icon="tag" label="Asunto" :value="$subject" />
                        @endif
                        @if ($message)
                            <div class="flex gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-teal-100 text-teal-600"
                                    aria-hidden="true"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Mensaje</p>
                                    <div
                                        class="mt-1.5 rounded-[10px] border border-teal-600/15 bg-teal-50 px-4 py-3.5 text-[15px] leading-relaxed text-slate-900"
                                    >
                                        {{ $message }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr class="my-6 border-slate-200" />

                    <p class="mb-3.5 text-[13px] font-bold tracking-tight text-slate-900">Detalles del envío</p>
                    <div class="space-y-5 rounded-xl border border-slate-200 bg-slate-50 p-5">
                        <x-email-field icon="calendar" label="Fecha y hora" :value="$submittedAt" muted />
                        <x-email-field icon="globe" label="Dirección IP" :value="$ipAddress" muted mono />
                        <x-email-field icon="monitor" label="User-Agent" :value="$userAgent" muted mono small />
                    </div>
                </div>

                <div class="border-t border-slate-100 px-7 pb-7 pt-2 text-center">
                    <span class="mb-3 inline-block text-teal-600" aria-hidden="true">
                        <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <p class="text-xs leading-relaxed text-slate-500">
                        Este correo se generó automáticamente desde el formulario de contacto de
                        <span class="font-semibold text-teal-600">Powervit</span>.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
