<?php

use function Pest\Laravel\get;

test('home page returns 200', fn() => get('/')->assertStatus(200)->assertSee('Who are you?'));
test('institutions page returns 200', fn() => get('/institutions')->assertStatus(200)->assertSee('The problem with grades'));
test('students page returns 200', fn() => get('/students')->assertStatus(200)->assertSee('Grades don'));
