<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;

class ContactForm extends Component
{
    public string $sender_name = '';
    public string $sender_email = '';
    public string $subject = '';
    public string $message = '';
    public bool $submitted = false;

    protected array $rules = [
        'sender_name' => 'required|string|min:2|max:100',
        'sender_email' => 'required|email|max:150',
        'subject' => 'nullable|string|max:150',
        'message' => 'required|string|min:10|max:2000',
    ];

    protected array $messages = [
        'sender_name.required' => 'Nama lengkap wajib diisi.',
        'sender_email.required' => 'Alamat email wajib diisi.',
        'sender_email.email' => 'Format email tidak valid.',
        'message.required' => 'Pesan tidak boleh kosong.',
        'message.min' => 'Pesan minimal 10 karakter.',
    ];

    public function submit()
    {
        $validated = $this->validate();

        ContactMessage::create($validated);

        $this->reset(['sender_name', 'sender_email', 'subject', 'message']);
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
