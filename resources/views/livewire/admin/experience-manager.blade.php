<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-slate-400">Kelola riwayat pengalaman kerja, magang, organisasi, maupun proyek freelance.</p>
        <button wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:bg-indigo-500 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengalaman
        </button>
    </div>

    <div class="space-y-4">
        @forelse($experiences as $exp)
            <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="rounded-full bg-indigo-500/15 border border-indigo-500/30 px-2.5 py-0.5 text-[11px] font-bold text-indigo-300">
                            {{ $exp->type }}
                        </span>
                        <span class="text-xs font-medium text-slate-400">
                            {{ $exp->start_date }} — {{ $exp->is_current ? 'Sekarang' : ($exp->end_date ?: 'Selesai') }}
                        </span>
                        @if($exp->location)
                            <span class="text-xs text-slate-500">• {{ $exp->location }}</span>
                        @endif
                    </div>
                    <h3 class="text-base font-bold text-white">{{ $exp->title }}</h3>
                    <p class="text-sm font-semibold text-indigo-400">{{ $exp->organization }}</p>
                    @if($exp->description)
                        <p class="text-xs text-slate-400 leading-relaxed max-w-3xl pt-1">{{ $exp->description }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <button wire:click="openEditModal({{ $exp->id }})"
                            class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-1.5 text-xs font-semibold text-slate-200 hover:bg-indigo-600 hover:border-indigo-600 hover:text-white transition">
                        Edit
                    </button>
                    <button wire:click="delete({{ $exp->id }})"
                            wire:confirm="Hapus riwayat pengalaman ini?"
                            class="rounded-lg border border-rose-500/30 bg-rose-500/10 px-3 py-1.5 text-xs font-semibold text-rose-400 hover:bg-rose-500 hover:text-white transition">
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-800 p-12 text-center text-sm text-slate-500">
                Belum ada riwayat pengalaman yang ditambahkan.
            </div>
        @endforelse
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-950/80 backdrop-blur-sm p-4">
            <div class="relative w-full max-w-xl rounded-2xl border border-slate-800 bg-slate-900 p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                    <h3 class="text-lg font-bold text-white">{{ $editingId ? 'Edit Pengalaman' : 'Tambah Pengalaman Baru' }}</h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-white">✕</button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Posisi / Jabatan *</label>
                            <input type="text" wire:model="title" placeholder="Full-Stack Developer" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            @error('title') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Perusahaan / Organisasi *</label>
                            <input type="text" wire:model="organization" placeholder="PT Teknologi Indonesia" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            @error('organization') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Kategori *</label>
                            <select wire:model="type" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                                <option value="Kerja">Kerja (Full-time / Part-time)</option>
                                <option value="Magang">Magang (Internship)</option>
                                <option value="Organisasi">Organisasi / Kepanitiaan</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Lokasi</label>
                            <input type="text" wire:model="location" placeholder="Jakarta / Remote" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Mulai (Bulan & Tahun) *</label>
                            <input type="text" wire:model="start_date" placeholder="Jan 2024" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            @error('start_date') <p class="mt-1 text-xs text-rose-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Selesai</label>
                            <input type="text" wire:model="end_date" :disabled="$wire.is_current" placeholder="Des 2024"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white disabled:opacity-40 focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model.live="is_current" class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-indigo-600">
                            <span class="text-xs font-medium text-slate-300">Masih aktif bekerja / menjabat di sini</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <label class="text-xs text-slate-400">Urutan:</label>
                            <input type="number" wire:model="sort_order" min="0" class="w-20 rounded-lg border border-slate-700 bg-slate-950 px-2.5 py-1 text-xs text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi Tugas & Pencapaian</label>
                        <textarea rows="3" wire:model="description" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none"></textarea>
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
