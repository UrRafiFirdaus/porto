<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Pesan Masuk Pengunjung')]
class MessageManager extends Component
{
    use WithPagination;

    public ?ContactMessage $selectedMessage = null;

    public function viewMessage(int $id)
    {
        $msg = ContactMessage::findOrFail($id);
        if (!$msg->is_read) {
            $msg->update(['is_read' => true]);
        }
        $this->selectedMessage = $msg;
    }

    public function delete(int $id)
    {
        if ($this->selectedMessage && $this->selectedMessage->id === $id) {
            $this->selectedMessage = null;
        }
        ContactMessage::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Pesan berhasil dihapus.');
    }

    public function render()
    {
        $messages = ContactMessage::latest()->paginate(10);
        return view('livewire.admin.message-manager', compact('messages'));
    }
}
