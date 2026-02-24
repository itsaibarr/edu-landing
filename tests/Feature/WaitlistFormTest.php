<?php

use Livewire\Livewire;
use App\Livewire\WaitlistForm;

test('waitlist form renders', function () {
    Livewire::test(WaitlistForm::class)
        ->assertSee('Join Waitlist')
        ->assertSet('submitted', false);
});

test('waitlist form validates required fields', function () {
    Livewire::test(WaitlistForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'school']);
});

test('waitlist form submits successfully', function () {
    Livewire::test(WaitlistForm::class)
        ->set('name', 'Daniyar Bekov')
        ->set('email', 'daniyar@gmail.com')
        ->set('school', 'School #15, Nur-Sultan')
        ->call('submit')
        ->assertSet('submitted', true);
});
