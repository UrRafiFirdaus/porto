<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Manajemen Projects')]
class ProjectManager extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public bool $showModal = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $short_description = '';
    public string $tech_stack_input = '';
    public string $demo_url = '';
    public string $github_url = '';
    public bool $is_private = false;
    public bool $is_published = true;
    public bool $is_featured = false;
    public int $sort_order = 0;

    public $thumbnail;
    public ?string $existing_thumbnail = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->sort_order = (Project::max('sort_order') ?? 0) + 1;
        $this->showModal = true;
    }

    public function openEditModal(int $id)
    {
        $project = Project::findOrFail($id);
        $this->editingId = $project->id;
        $this->title = $project->title;
        $this->short_description = $project->short_description;
        $this->tech_stack_input = is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : '';
        $this->demo_url = $project->demo_url ?? '';
        $this->github_url = $project->github_url ?? '';
        $this->is_private = (bool) $project->is_private;
        $this->is_published = (bool) $project->is_published;
        $this->is_featured = (bool) $project->is_featured;
        $this->sort_order = (int) $project->sort_order;
        $this->existing_thumbnail = $project->thumbnail_path;
        $this->thumbnail = null;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'editingId', 'title', 'short_description', 'tech_stack_input',
            'demo_url', 'github_url', 'is_private', 'is_featured',
            'thumbnail', 'existing_thumbnail'
        ]);
        $this->is_published = true;
        $this->sort_order = 0;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:150',
            'short_description' => 'required|string|max:1000',
            'tech_stack_input' => 'required|string|max:500',
            'demo_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'sort_order' => 'integer|min:0',
            'thumbnail' => 'nullable|image|max:3072', // max 3MB
        ], [
            'title.required' => 'Nama proyek wajib diisi.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
            'tech_stack_input.required' => 'Masukkan minimal satu teknologi yang digunakan.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.max' => 'Ukuran gambar maksimal 3MB.',
        ]);

        $techArray = array_values(array_filter(array_map('trim', explode(',', $this->tech_stack_input))));

        $slugBase = Str::slug($this->title);
        $slug = $slugBase;
        $counter = 1;
        while (Project::where('slug', $slug)->when($this->editingId, fn($q) => $q->where('id', '!=', $this->editingId))->exists()) {
            $slug = $slugBase . '-' . $counter++;
        }

        $data = [
            'title' => $this->title,
            'slug' => $slug,
            'short_description' => $this->short_description,
            'tech_stack' => $techArray,
            'demo_url' => $this->demo_url ?: null,
            'github_url' => $this->is_private ? null : ($this->github_url ?: null),
            'is_private' => $this->is_private,
            'is_published' => $this->is_published,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
        ];

        if ($this->thumbnail) {
            $dir = public_path('uploads/projects');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            if ($this->editingId) {
                $old = Project::find($this->editingId);
                if ($old && $old->thumbnail_path && File::exists(public_path($old->thumbnail_path))) {
                    File::delete(public_path($old->thumbnail_path));
                }
            }
            $filename = 'project_' . time() . '_' . Str::random(5) . '.' . $this->thumbnail->getClientOriginalExtension();
            File::copy($this->thumbnail->getRealPath(), $dir . '/' . $filename);
            $data['thumbnail_path'] = 'uploads/projects/' . $filename;
        }

        if ($this->editingId) {
            Project::findOrFail($this->editingId)->update($data);
            $msg = 'Proyek berhasil diperbarui!';
        } else {
            Project::create($data);
            $msg = 'Proyek baru berhasil ditambahkan!';
        }

        $this->closeModal();
        $this->dispatch('toast', type: 'success', message: $msg);
    }

    public function togglePublish(int $id)
    {
        $project = Project::findOrFail($id);
        $project->update(['is_published' => !$project->is_published]);
        $status = $project->is_published ? 'ditampilkan ke publik' : 'disembunyikan (draft)';
        $this->dispatch('toast', type: 'info', message: "Proyek '{$project->title}' {$status}.");
    }

    public function delete(int $id)
    {
        $project = Project::findOrFail($id);
        if ($project->thumbnail_path && File::exists(public_path($project->thumbnail_path))) {
            File::delete(public_path($project->thumbnail_path));
        }
        $project->delete();
        $this->dispatch('toast', type: 'success', message: 'Proyek berhasil dihapus.');
    }

    public function render()
    {
        $projects = Project::query()
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('short_description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(8);

        return view('livewire.admin.project-manager', compact('projects'));
    }
}
