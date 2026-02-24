<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;

class WaitlistForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $school = '';
    public string $frustration = '';
    public bool $submitted = false;

    protected array $rules = [
        'name' => 'required|string|min:2|max:100',
        'email' => 'required|email|max:255',
        'school' => 'required|string|min:2|max:200',
        'frustration' => 'nullable|string|max:1000',
    ];

    public function submit(): void
    {
        $this->validate();

        Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'institution' => $this->school,
            'role' => 'student',
            'message' => $this->frustration,
            'type' => 'student',
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.waitlist-form');
    }
}
