<?php

namespace App\Livewire\Admin;

use App\Models\Experience;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Manajemen Pengalaman (Experiences)')]
class ExperienceManager extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $organization = '';
    public string $type = 'Kerja';
    public string $location = '';
    public string $start_date = '';
    public string $end_date = '';
    public bool $is_current = false;
    public string $description = '';
    public int $sort_order = 0;

    public function openCreateModal()
    {
        $this->resetForm();
        $this->sort_order = (Experience::max('sort_order') ?? 0) + 1;
        $this->showModal = true;
    }

    public function openEditModal(int $id)
    {
        $exp = Experience::findOrFail($id);
        $this->editingId = $exp->id;
        $this->title = $exp->title;
        $this->organization = $exp->organization;
        $this->type = $exp->type;
        $this->location = $exp->location ?? '';
        $this->start_date = $exp->start_date;
        $this->end_date = $exp->end_date ?? '';
        $this->is_current = (bool) $exp->is_current;
        $this->description = $exp->description ?? '';
        $this->sort_order = (int) $exp->sort_order;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['editingId', 'title', 'organization', 'location', 'start_date', 'end_date', 'is_current', 'description']);
        $this->type = 'Kerja';
        $this->sort_order = 0;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:150',
            'organization' => 'required|string|max:150',
            'type' => 'required|in:Kerja,Magang,Organisasi,Freelance',
            'location' => 'nullable|string|max:120',
            'start_date' => 'required|string|max:50',
            'end_date' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:2000',
            'sort_order' => 'integer|min:0',
        ], [
            'title.required' => 'Posisi / jabatan wajib diisi.',
            'organization.required' => 'Nama perusahaan / instansi wajib diisi.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
        ]);

        $data = [
            'title' => $this->title,
            'organization' => $this->organization,
            'type' => $this->type,
            'location' => $this->location ?: null,
            'start_date' => $this->start_date,
            'end_date' => $this->is_current ? null : ($this->end_date ?: null),
            'is_current' => $this->is_current,
            'description' => $this->description ?: null,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editingId) {
            Experience::findOrFail($this->editingId)->update($data);
            $msg = 'Riwayat pengalaman berhasil diperbarui!';
        } else {
            Experience::create($data);
            $msg = 'Riwayat pengalaman berhasil ditambahkan!';
        }

        $this->closeModal();
        $this->dispatch('toast', type: 'success', message: $msg);
    }

    public function delete(int $id)
    {
        Experience::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Riwayat pengalaman berhasil dihapus.');
    }

    public function render()
    {
        $experiences = Experience::orderByDesc('is_current')->orderBy('sort_order')->orderByDesc('id')->get();
        return view('livewire.admin.experience-manager', compact('experiences'));
    }
}
