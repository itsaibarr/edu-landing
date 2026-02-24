<?php

use Livewire\Livewire;
use App\Livewire\PilotRequestForm;

test('pilot request form renders', function () {
    Livewire::test(PilotRequestForm::class)
        ->assertSee('Request Pilot Access')
        ->assertSet('submitted', false);
});

test('pilot request form validates required fields', function () {
    Livewire::test(PilotRequestForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'institution', 'role']);
});

test('pilot request form validates email format', function () {
    Livewire::test(PilotRequestForm::class)
        ->set('email', 'not-an-email')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('pilot request form submits successfully with valid data', function () {
    Livewire::test(PilotRequestForm::class)
        ->set('name', 'Asel Nurova')
        ->set('email', 'asel@school.kz')
        ->set('institution', 'School #42, Almaty')
        ->set('role', 'admin')
        ->call('submit')
        ->assertSet('submitted', true)
        ->assertHasNoErrors();
});
