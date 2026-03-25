<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use RuntimeException;
use Symfony\Component\Process\Process;
use Throwable;

class ContactEmailRenderer
{
    /**
     * @param  array<string, mixed>  $props
     */
    public function render(array $props): string
    {
        $node = PHP_OS_FAMILY === 'Windows' ? 'node.exe' : 'node';
        $cli = base_path('node_modules/tsx/dist/cli.mjs');
        $script = base_path('scripts/render-contact-email.tsx');

        if (! is_file($cli) || ! is_file($script)) {
            throw new RuntimeException('Faltan dependencias de Node para renderizar el correo (tsx o script).');
        }

        $input = json_encode($props, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $process = new Process([$node, $cli, $script], base_path(), null, $input, 60.0);

        try {
            $process->run();
        } catch (Throwable $e) {
            Log::error('No se pudo ejecutar el render de React Email.', [
                'exception' => $e::class,
            ]);

            throw new RuntimeException('Error al generar el HTML del correo.', 0, $e);
        }

        if (! $process->isSuccessful()) {
            Log::error('Render de React Email falló.', [
                'stderr' => mb_substr($process->getErrorOutput(), 0, 2000),
            ]);

            throw new RuntimeException('Error al generar el HTML del correo.');
        }

        $html = $process->getOutput();
        if ($html === '') {
            throw new RuntimeException('El HTML del correo está vacío.');
        }

        return $html;
    }
}
