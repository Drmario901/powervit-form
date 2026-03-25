<?php

test('la página principal responde Unauthorized', function () {
    $response = $this->get('/');

    $response->assertStatus(401)->assertSee('Unauthorized', false);
});
