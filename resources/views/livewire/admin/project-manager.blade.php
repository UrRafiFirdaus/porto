<div class="space-y-6">
    <!-- Top Header & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="relative w-full sm:max-w-xs">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari proyek..."
                   class="w-full rounded-xl border border-slate-800 bg-slate-900/90 pl-10 pr-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:outline-none">
            <svg class="h-4 w-4 text-slate-500 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <button wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:bg-indigo-500 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Proyek Baru
        </button>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <div class="group flex flex-col overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/70 hover:border-slate-700 transition">
                <!-- Thumbnail -->
                <div class="relative aspect-video overflow-hidden bg-slate-950">
                    <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                         class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                        @if($project->is_featured)
                            <span class="rounded-full bg-amber-500/90 px-2.5 py-0.5 text-[10px] font-bold text-slate-950 shadow">
                                ★ Unggulan
                            </span>
                        @endif
                        @if($project->is_private)
                            <span class="rounded-full bg-slate-900/90 border border-slate-700 px-2.5 py-0.5 text-[10px] font-semibold text-slate-300">
                                Private Repo
                            </span>
                        @endif
                    </div>

                    <!-- Quick Publish Toggle -->
                    <button wire:click="togglePublish({{ $project->id }})"
                            title="Klik untuk ubah status tampil/sembunyi"
                            class="absolute top-3 right-3 rounded-full px-3 py-1 text-[11px] font-bold shadow transition {{ $project->is_published ? 'bg-emerald-500 text-slate-950 hover:bg-emerald-400' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                        {{ $project->is_published ? '● Tampil' : '○ Sembunyi' }}
                    </button>
                </div>

                <!-- Body -->
                <div class="flex-1 p-5 flex flex-col justify-between space-y-4">
                    <div>
                        <h3 class="text-base font-bold text-white line-clamp-1">{{ $project->title }}</h3>
                        <p class="mt-1.5 text-xs text-slate-400 line-clamp-2 leading-relaxed">{{ $project->short_description }}</p>

                        <!-- Tech Stack Badges -->
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach($project->tech_stack ?? [] as $tech)
                                <span class="rounded-md bg-indigo-500/10 border border-indigo-500/20 px-2 py-0.5 text-[11px] font-medium text-indigo-300">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Links & Actions -->
                    <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" target="_blank" class="hover:text-indigo-400 underline">Demo</a>
                            @endif
                            @if($project->github_url && !$project->is_private)
                                <a href="{{ $project->github_url }}" target="_blank" class="hover:text-indigo-400 underline">GitHub</a>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <button wire:click="openEditModal({{ $project->id }})"
                                    class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-1.5 text-xs font-semibold text-slate-200 hover:bg-indigo-600 hover:border-indigo-600 hover:text-white transition">
                                Edit
                            </button>
                            <button wire:click="delete({{ $project->id }})"
                                    wire:confirm="Yakin ingin menghapus proyek '{{ $project->title }}'?"
                                    class="rounded-lg border border-rose-500/30 bg-rose-500/10 px-3 py-1.5 text-xs font-semibold text-rose-400 hover:bg-rose-500 hover:text-white transition">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-slate-800 p-12 text-center">
                <p class="text-sm font-medium text-slate-400">Belum ada proyek yang ditemukan.</p>
                <button wire:click="openCreateModal" class="mt-3 text-xs font-bold text-indigo-400 hover:underline">+ Tambah Proyek Pertama</button>
            </div>
        @endforelse
    </div>

    <div>
        {{ $projects->links() }}
    </div>

    <!-- Modal Create / Edit Project -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/80 backdrop-blur-sm p-4">
            <div class="relative w-full max-w-2xl rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8 shadow-2xl my-8">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                    <h3 class="text-lg font-bold text-white">
                        {{ $editingId ? 'Edit Proyek' : 'Tambah Proyek Baru' }}
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <!-- Thumbnail Upload & Live Preview -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-2">Foto / Thumbnail Proyek</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div class="h-28 w-44 rounded-xl overflow-hidden border border-slate-700 bg-slate-950 flex-shrink-0">
                                @if ($thumbnail)
                                    <img src="{{ $thumbnail->temporaryUrl() }}" alt="Preview" class="h-full w-full object-cover">
                                @elseif ($existing_thumbnail && file_exists(public_path($existing_thumbnail)))
                                    <img src="{{ asset($existing_thumbnail) }}" alt="Current" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-xs text-slate-500">Belum ada gambar</div>
                                @endif
                            </div>

                            <div class="space-y-2">
                                <label class="cursor-pointer inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-800 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-700 transition">
                                    <span>Pilih Gambar Thumbnail</span>
                                    <input type="file" wire:model="thumbnail" accept="image/*" class="hidden">
                                </label>
                                <p class="text-[11px] text-slate-500">Rekomendasi rasio 16:9 (JPG/PNG/WEBP, maks. 3MB).</p>
                                <div wire:loading wire:target="thumbnail" class="text-xs text-indigo-400">Memuat preview...</div>
                                @error('thumbnail') <p class="text-xs text-rose-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Proyek *</label>
                            <input type="text" wire:model="title" placeholder="Contoh: Sistem Informasi Akademik" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            @error('title') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Urutan Tampil</label>
                            <input type="number" wire:model="sort_order" min="0" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi Singkat *</label>
                        <textarea rows="3" wire:model="short_description" placeholder="Jelaskan fitur utama dan tujuan proyek ini..." class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none"></textarea>
                        @error('short_description') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Tech Stack (Pisahkan dengan koma) *</label>
                        <input type="text" wire:model.live="tech_stack_input" placeholder="Laravel, Livewire, Tailwind CSS, MySQL" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                        @error('tech_stack_input') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror

                        @if(trim($tech_stack_input) !== '')
                            <div class="mt-2 flex flex-wrap gap-1.5">
                                @foreach(array_filter(array_map('trim', explode(',', $tech_stack_input))) as $tag)
                                    <span class="rounded-md bg-indigo-500/15 border border-indigo-500/30 px-2 py-0.5 text-[11px] font-medium text-indigo-300">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">URL Live Demo (Opsional)</label>
                            <input type="url" wire:model="demo_url" placeholder="https://demo-proyek.com" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            @error('demo_url') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">URL Repository GitHub (Opsional)</label>
                            <input type="url" wire:model="github_url" :disabled="$wire.is_private" placeholder="https://github.com/username/repo"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white disabled:opacity-40 focus:border-indigo-500 focus:outline-none">
                            @error('github_url') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model.live="is_private" class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-indigo-600">
                            <span class="text-xs font-medium text-slate-300">Proyek Private (Sembunyikan Link GitHub)</span>
                        </label>

                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_published" class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-emerald-600">
                            <span class="text-xs font-medium text-emerald-400">Tampilkan ke Publik</span>
                        </label>

                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_featured" class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-amber-500">
                            <span class="text-xs font-medium text-amber-400">Tandai Unggulan</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-800 pt-5 mt-5">
                        <button type="button" wire:click="closeModal" class="rounded-xl border border-slate-700 px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-800 transition">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="rounded-xl bg-indigo-600 px-5 py-2 text-xs font-bold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition">
                            <span wire:loading.remove wire:target="save">Simpan Proyek</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
