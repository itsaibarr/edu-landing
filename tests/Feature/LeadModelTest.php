<?php

use App\Models\Lead;

test('lead can be created', function () {
    $lead = Lead::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'institution' => 'Test School',
        'role' => 'admin',
        'type' => 'institution',
        'message' => null,
    ]);

    expect($lead)->toBeInstanceOf(Lead::class)
        ->and($lead->email)->toBe('test@example.com');
});
