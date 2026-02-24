<?php

use function Pest\Laravel\get;

test('home page loads', function () {
    get('/')->assertStatus(200);
});
