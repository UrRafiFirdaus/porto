<?php

namespace App\Livewire\Admin;

use App\Models\PortfolioProfile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
#[Title('Manajemen Profil & Pengaturan')]
class ProfileSettings extends Component
{
    use WithFileUploads;

    public string $full_name = '';
    public string $role = '';
    public string $tagline = '';
    public string $bio = '';
    public string $location = '';
    public bool $available_for_work = true;
    public string $email = '';
    public string $linkedin_url = '';
    public string $github_url = '';
    public string $instagram_url = '';

    public $avatar;
    public ?string $existing_avatar = null;

    public $cv_file;
    public ?string $existing_cv = null;

    // Account password update
    public string $admin_email = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount()
    {
        $profile = PortfolioProfile::firstOrCreate(
            ['id' => 1],
            [
                'full_name' => 'Administrator',
                'role' => 'Web Developer',
                'bio' => 'Deskripsi singkat profil saya.',
            ]
        );

        $this->full_name = $profile->full_name ?? '';
        $this->role = $profile->role ?? '';
        $this->tagline = $profile->tagline ?? '';
        $this->bio = $profile->bio ?? '';
        $this->location = $profile->location ?? '';
        $this->available_for_work = (bool) $profile->available_for_work;
        $this->email = $profile->email ?? '';
        $this->linkedin_url = $profile->linkedin_url ?? '';
        $this->github_url = $profile->github_url ?? '';
        $this->instagram_url = $profile->instagram_url ?? '';
        $this->existing_avatar = $profile->avatar_path;
        $this->existing_cv = $profile->cv_path;

        $this->admin_email = auth()->user()->email;
    }

    public function saveProfile()
    {
        $this->validate([
            'full_name' => 'required|string|max:120',
            'role' => 'required|string|max:120',
            'tagline' => 'nullable|string|max:255',
            'bio' => 'required|string|max:3000',
            'location' => 'nullable|string|max:120',
            'email' => 'nullable|email|max:150',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|max:2048', // Max 2MB
            'cv_file' => 'nullable|mimes:pdf|max:5120', // Max 5MB PDF
        ], [
            'avatar.image' => 'Foto profil harus berupa gambar (JPG, PNG, WEBP).',
            'avatar.max' => 'Ukuran foto profil maksimal 2MB.',
            'cv_file.mimes' => 'File CV harus berformat PDF.',
            'cv_file.max' => 'Ukuran file CV maksimal 5MB.',
        ]);

        $profile = PortfolioProfile::firstOrCreate(['id' => 1]);

        $data = [
            'full_name' => $this->full_name,
            'role' => $this->role,
            'tagline' => $this->tagline,
            'bio' => $this->bio,
            'location' => $this->location,
            'available_for_work' => $this->available_for_work,
            'email' => $this->email,
            'linkedin_url' => $this->linkedin_url,
            'github_url' => $this->github_url,
            'instagram_url' => $this->instagram_url,
        ];

        if ($this->avatar) {
            $dir = public_path('uploads/profiles');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            if ($profile->avatar_path && File::exists(public_path($profile->avatar_path))) {
                File::delete(public_path($profile->avatar_path));
            }
            $filename = 'avatar_' . time() . '.' . $this->avatar->getClientOriginalExtension();
            File::copy($this->avatar->getRealPath(), $dir . '/' . $filename);
            $data['avatar_path'] = 'uploads/profiles/' . $filename;
            $this->existing_avatar = $data['avatar_path'];
            $this->avatar = null;
        }

        if ($this->cv_file) {
            $dir = public_path('uploads/cv');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            if ($profile->cv_path && File::exists(public_path($profile->cv_path))) {
                File::delete(public_path($profile->cv_path));
            }
            $filename = 'cv_' . time() . '.pdf';
            File::copy($this->cv_file->getRealPath(), $dir . '/' . $filename);
            $data['cv_path'] = 'uploads/cv/' . $filename;
            $this->existing_cv = $data['cv_path'];
            $this->cv_file = null;
        }

        $profile->update($data);

        $this->dispatch('toast', type: 'success', message: 'Profil & pengaturan portofolio berhasil disimpan!');
    }

    public function removeCv()
    {
        $profile = PortfolioProfile::first();
        if ($profile && $profile->cv_path) {
            if (File::exists(public_path($profile->cv_path))) {
                File::delete(public_path($profile->cv_path));
            }
            $profile->update(['cv_path' => null]);
            $this->existing_cv = null;
            $this->dispatch('toast', type: 'info', message: 'File CV berhasil dihapus.');
        }
    }

    public function updateAdminCredentials()
    {
        $user = auth()->user();

        $this->validate([
            'admin_email' => 'required|email|unique:users,email,' . $user->id,
            'new_password' => 'nullable|min:6|confirmed',
        ], [
            'admin_email.required' => 'Email login wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->email = $this->admin_email;
        if (!empty($this->new_password)) {
            $user->password = Hash::make($this->new_password);
        }
        $user->save();

        $this->reset(['new_password', 'new_password_confirmation']);
        $this->dispatch('toast', type: 'success', message: 'Kredensial login admin berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.admin.profile-settings');
    }
}
