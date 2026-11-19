<?php

namespace App\Livewire\Admin;

use App\Models\Skill;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
#[Title('Manajemen Tech Stack & Skills')]
class SkillManager extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $category = 'Framework & Library';
    public string $icon_class = '';
    public int $proficiency = 85;
    public int $sort_order = 0;

    public $icon_upload;
    public ?string $existing_icon_image = null;

    public function openCreateModal()
    {
        $this->resetForm();
        $this->sort_order = (Skill::max('sort_order') ?? 0) + 1;
        $this->showModal = true;
    }

    public function openEditModal(int $id)
    {
        $skill = Skill::findOrFail($id);
        $this->editingId = $skill->id;
        $this->name = $skill->name;
        $this->category = $skill->category;
        $this->icon_class = $skill->icon_class ?? '';
        $this->proficiency = (int) $skill->proficiency;
        $this->sort_order = (int) $skill->sort_order;
        $this->existing_icon_image = $skill->icon_image;
        $this->icon_upload = null;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['editingId', 'name', 'icon_class', 'icon_upload', 'existing_icon_image']);
        $this->category = 'Framework & Library';
        $this->proficiency = 85;
        $this->sort_order = 0;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'icon_class' => 'nullable|string|max:120',
            'proficiency' => 'required|integer|min:10|max:100',
            'sort_order' => 'integer|min:0',
            'icon_upload' => 'nullable|image|max:1024',
        ], [
            'name.required' => 'Nama teknologi/skill wajib diisi.',
        ]);

        $data = [
            'name' => $this->name,
            'category' => $this->category,
            'icon_class' => $this->icon_class ?: null,
            'proficiency' => $this->proficiency,
            'sort_order' => $this->sort_order,
        ];

        if ($this->icon_upload) {
            $dir = public_path('uploads/skills');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            if ($this->editingId) {
                $old = Skill::find($this->editingId);
                if ($old && $old->icon_image && File::exists(public_path($old->icon_image))) {
                    File::delete(public_path($old->icon_image));
                }
            }
            $filename = 'skill_' . time() . '_' . Str::random(4) . '.' . $this->icon_upload->getClientOriginalExtension();
            File::copy($this->icon_upload->getRealPath(), $dir . '/' . $filename);
            $data['icon_image'] = 'uploads/skills/' . $filename;
        }

        if ($this->editingId) {
            Skill::findOrFail($this->editingId)->update($data);
            $msg = 'Tech stack berhasil diperbarui!';
        } else {
            Skill::create($data);
            $msg = 'Tech stack baru berhasil ditambahkan!';
        }

        $this->closeModal();
        $this->dispatch('toast', type: 'success', message: $msg);
    }

    public function delete(int $id)
    {
        $skill = Skill::findOrFail($id);
        if ($skill->icon_image && File::exists(public_path($skill->icon_image))) {
            File::delete(public_path($skill->icon_image));
        }
        $skill->delete();
        $this->dispatch('toast', type: 'success', message: 'Tech stack berhasil dihapus.');
    }

    public function render()
    {
        $skills = Skill::orderBy('sort_order')->orderBy('id')->get();
        return view('livewire.admin.skill-manager', compact('skills'));
    }
}
