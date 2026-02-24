<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;

class PilotRequestForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $institution = '';
    public string $role = '';
    public string $challenge = '';
    public bool $submitted = false;

    protected array $rules = [
        'name' => 'required|string|min:2|max:100',
        'email' => 'required|email|max:255',
        'institution' => 'required|string|min:2|max:200',
        'role' => 'required|in:admin,teacher,other',
        'challenge' => 'nullable|string|max:1000',
    ];

    public function submit(): void
    {
        $this->validate();

        Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'institution' => $this->institution,
            'role' => $this->role,
            'message' => $this->challenge,
            'type' => 'institution',
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.pilot-request-form');
    }
}
