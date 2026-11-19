<?php

namespace App\Livewire\Admin;

use App\Models\Education;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Manajemen Pendidikan (Education)')]
class EducationManager extends Component
{
    public bool $showModal = false;
    public ?int $editingId = null;

    public string $institution = '';
    public string $degree = '';
    public string $start_year = '';
    public string $end_year = '';
    public bool $is_current = false;
    public string $gpa = '';
    public string $description = '';
    public int $sort_order = 0;

    public function openCreateModal()
    {
        $this->resetForm();
        $this->sort_order = (Education::max('sort_order') ?? 0) + 1;
        $this->showModal = true;
    }

    public function openEditModal(int $id)
    {
        $edu = Education::findOrFail($id);
        $this->editingId = $edu->id;
        $this->institution = $edu->institution;
        $this->degree = $edu->degree;
        $this->start_year = $edu->start_year;
        $this->end_year = $edu->end_year ?? '';
        $this->is_current = (bool) $edu->is_current;
        $this->gpa = $edu->gpa ?? '';
        $this->description = $edu->description ?? '';
        $this->sort_order = (int) $edu->sort_order;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['editingId', 'institution', 'degree', 'start_year', 'end_year', 'is_current', 'gpa', 'description']);
        $this->sort_order = 0;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'institution' => 'required|string|max:150',
            'degree' => 'required|string|max:150',
            'start_year' => 'required|string|max:20',
            'end_year' => 'nullable|string|max:20',
            'gpa' => 'nullable|string|max:30',
            'description' => 'nullable|string|max:1500',
            'sort_order' => 'integer|min:0',
        ], [
            'institution.required' => 'Nama institusi / sekolah wajib diisi.',
            'degree.required' => 'Gelar / jurusan wajib diisi.',
            'start_year.required' => 'Tahun masuk wajib diisi.',
        ]);

        $data = [
            'institution' => $this->institution,
            'degree' => $this->degree,
            'start_year' => $this->start_year,
            'end_year' => $this->is_current ? null : ($this->end_year ?: null),
            'is_current' => $this->is_current,
            'gpa' => $this->gpa ?: null,
            'description' => $this->description ?: null,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editingId) {
            Education::findOrFail($this->editingId)->update($data);
            $msg = 'Riwayat pendidikan berhasil diperbarui!';
        } else {
            Education::create($data);
            $msg = 'Riwayat pendidikan berhasil ditambahkan!';
        }

        $this->closeModal();
        $this->dispatch('toast', type: 'success', message: $msg);
    }

    public function delete(int $id)
    {
        Education::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Riwayat pendidikan berhasil dihapus.');
    }

    public function render()
    {
        $educations = Education::orderByDesc('is_current')->orderBy('sort_order')->orderByDesc('id')->get();
        return view('livewire.admin.education-manager', compact('educations'));
    }
}
