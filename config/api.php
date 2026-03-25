<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Acceso a la API (clave compartida)
    |--------------------------------------------------------------------------
    |
    | Si defines API_ACCESS_TOKEN, todas las rutas bajo /api excepto las
    | exentas deben enviar la cabecera X-Api-Key con ese valor.
    | Déjalo vacío en local si no quieres esta capa.
    |
    */

    'access_token' => env('API_ACCESS_TOKEN'),

];
