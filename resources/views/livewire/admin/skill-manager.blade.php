<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-slate-400">Tambah atau perbarui daftar bahasa pemrograman, framework, database, dan tools yang dikuasai.</p>
        <button wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:bg-indigo-500 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Tech Stack
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($skills as $skill)
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5 flex flex-col justify-between gap-4 hover:border-slate-700 transition">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-800 bg-slate-950 text-2xl">
                            @if($skill->logo_url)
                                <img src="{{ $skill->logo_url }}" alt="{{ $skill->name }}" class="h-7 w-7 object-contain">
                            @elseif($skill->icon_class)
                                <i class="{{ $skill->icon_class }}"></i>
                            @else
                                <span class="text-sm font-bold text-indigo-400">{{ strtoupper(substr($skill->name, 0, 2)) }}</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">{{ $skill->name }}</h3>
                            <p class="text-[11px] text-slate-400">{{ $skill->category }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-[11px] text-slate-400 mb-1">
                        <span>Tingkat Penguasaan</span>
                        <span class="font-semibold text-indigo-400">{{ $skill->proficiency }}%</span>
                    </div>
                    <div class="h-1.5 w-full rounded-full bg-slate-800 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-cyan-400" style="width: {{ $skill->proficiency }}%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-800/80">
                    <button wire:click="openEditModal({{ $skill->id }})"
                            class="rounded-lg border border-slate-700 bg-slate-800 px-2.5 py-1 text-xs font-semibold text-slate-200 hover:bg-indigo-600 hover:border-indigo-600 hover:text-white transition">
                        Edit
                    </button>
                    <button wire:click="delete({{ $skill->id }})"
                            wire:confirm="Hapus '{{ $skill->name }}' dari daftar skill?"
                            class="rounded-lg border border-rose-500/30 bg-rose-500/10 px-2.5 py-1 text-xs font-semibold text-rose-400 hover:bg-rose-500 hover:text-white transition">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-800 p-12 text-center text-sm text-slate-500">
                Belum ada tech stack yang ditambahkan.
            </div>
        @endforelse
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/80 backdrop-blur-sm p-4">
            <div class="relative w-full max-w-lg rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                    <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Tech Stack' : 'Tambah Tech Stack Baru' }}</h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-white">✕</button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Teknologi / Skill *</label>
                            <input type="text" wire:model="name" placeholder="Contoh: Laravel" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            @error('name') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Kategori *</label>
                            <select wire:model="category" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                                <option value="Bahasa Pemrograman">Bahasa Pemrograman</option>
                                <option value="Framework & Library">Framework & Library</option>
                                <option value="Database & Tools">Database & Tools</option>
                                <option value="UI/UX & Lainnya">UI/UX & Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Class Ikon Devicon (Opsional)</label>
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 text-2xl">
                                @if($icon_upload)
                                    <img src="{{ $icon_upload->temporaryUrl() }}" class="h-6 w-6 object-contain">
                                @elseif($existing_icon_image && file_exists(public_path($existing_icon_image)))
                                    <img src="{{ asset($existing_icon_image) }}" class="h-6 w-6 object-contain">
                                @elseif($icon_class)
                                    <i class="{{ $icon_class }}"></i>
                                @else
                                    <span class="text-xs text-slate-500">Ikon</span>
                                @endif
                            </div>
                            <input type="text" wire:model.live="icon_class" placeholder="devicon-laravel-original colored"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                        </div>
                        <p class="mt-1 text-[11px] text-slate-500">
                            Referensi class ikon gratis: <a href="https://devicon.dev" target="_blank" class="text-indigo-400 underline">devicon.dev</a> (misal: <code class="text-slate-300">devicon-react-original colored</code>).
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Atau Unggah Logo Kustom (PNG/SVG/JPG, Opsional)</label>
                        <input type="file" wire:model="icon_upload" accept="image/*"
                               class="w-full text-xs text-slate-400 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-800 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-700">
                        @error('icon_upload') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                        <div class="sm:col-span-2">
                            <label class="flex justify-between text-xs font-semibold text-slate-400 mb-1.5">
                                <span>Tingkat Penguasaan</span>
                                <span class="text-indigo-400">{{ $proficiency }}%</span>
                            </label>
                            <input type="range" wire:model.live="proficiency" min="10" max="100" step="5" class="w-full accent-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Urutan</label>
                            <input type="number" wire:model="sort_order" min="0" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-white">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-800 pt-4">
                        <button type="button" wire:click="closeModal" class="rounded-xl border border-slate-700 px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-800">Batal</button>
                        <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2 text-xs font-bold text-white hover:bg-indigo-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
