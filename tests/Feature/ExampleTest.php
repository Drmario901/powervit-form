<?php

test('la página principal responde JSON Unauthorized con código', function () {
    $this->getJson('/')
        ->assertStatus(401)
        ->assertExactJson([
            'success' => false,
            'status' => 401,
            'code' => 'UNAUTHORIZED',
            'message' => 'Unauthorized.',
        ]);
});
