<div class="space-y-8">
    <!-- Main Profile & Portfolio Form -->
    <form wire:submit="saveProfile" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Avatar & CV Upload -->
            <div class="space-y-6">
                <!-- Photo Profile Card -->
                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
                    <h3 class="text-base font-bold text-white mb-1">Foto Profil</h3>
                    <p class="text-xs text-slate-400 mb-5">Format JPG, PNG, atau WEBP (Maks. 2MB).</p>

                    <div class="flex flex-col items-center">
                        <div class="relative group">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avatar): ?>
                                <img src="<?php echo e($avatar->temporaryUrl()); ?>" alt="Preview Avatar"
                                     class="h-32 w-32 rounded-2xl object-cover ring-4 ring-indigo-500/40 shadow-xl">
                                <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 rounded-full bg-indigo-600 px-2.5 py-0.5 text-[10px] font-bold text-white shadow">
                                    Preview Baru
                                </span>
                            <?php elseif($existing_avatar && file_exists(public_path($existing_avatar))): ?>
                                <img src="<?php echo e(asset($existing_avatar)); ?>" alt="Current Avatar"
                                     class="h-32 w-32 rounded-2xl object-cover ring-2 ring-slate-700 shadow-xl">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($full_name ?: 'Admin')); ?>&size=256&background=4f46e5&color=fff&bold=true"
                                     alt="Default Avatar"
                                     class="h-32 w-32 rounded-2xl object-cover ring-2 ring-slate-700 shadow-xl">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <label class="mt-5 cursor-pointer inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-white transition">
                            <svg class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Pilih Foto Profil Baru</span>
                            <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                        </label>

                        <div wire:loading wire:target="avatar" class="mt-2 text-xs text-indigo-400">
                            Memuat preview gambar...
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- CV PDF Upload Card -->
                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
                    <h3 class="text-base font-bold text-white mb-1">Curriculum Vitae (PDF)</h3>
                    <p class="text-xs text-slate-400 mb-4">File PDF yang diunduh pengunjung melalui tombol "Unduh CV".</p>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_cv && file_exists(public_path($existing_cv))): ?>
                        <div class="mb-4 flex items-center justify-between rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <svg class="h-6 w-6 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-emerald-300 truncate">CV Aktif Tersedia</p>
                                    <a href="<?php echo e(asset($existing_cv)); ?>" target="_blank" class="text-[11px] text-emerald-400 underline hover:text-emerald-300">Lihat File PDF</a>
                                </div>
                            </div>
                            <button type="button" wire:click="removeCv" wire:confirm="Hapus file CV saat ini?"
                                    class="rounded-lg p-1.5 text-rose-400 hover:bg-rose-500/15 transition" title="Hapus CV">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <label class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-700 bg-slate-950/50 p-5 cursor-pointer hover:border-indigo-500/60 transition">
                        <svg class="h-7 w-7 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-xs font-semibold text-slate-300">
                            <?php echo e($cv_file ? $cv_file->getClientOriginalName() : 'Klik untuk unggah file CV (.pdf)'); ?>

                        </span>
                        <span class="mt-1 text-[11px] text-slate-500">Maksimal 5MB</span>
                        <input type="file" wire:model="cv_file" accept="application/pdf" class="hidden">
                    </label>
                    <div wire:loading wire:target="cv_file" class="mt-2 text-xs text-indigo-400">Mengunggah PDF...</div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cv_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Right 2 Columns: General Bio & Social Media -->
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6 space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                        <div>
                            <h3 class="text-base font-bold text-white">Informasi Utama & Bio</h3>
                            <p class="text-xs text-slate-400">Ditampilkan pada bagian Hero & About Me di landing page.</p>
                        </div>
                        <label class="inline-flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" wire:model="available_for_work" class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-semibold text-emerald-400">Open to Work</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Nama Lengkap *</label>
                            <input type="text" wire:model="full_name" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Role / Profesi Saat Ini *</label>
                            <input type="text" wire:model="role" placeholder="Contoh: Full-Stack Laravel Developer" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Tagline Singkat</label>
                            <input type="text" wire:model="tagline" placeholder="Kalimat pembuka singkat di Hero" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Lokasi / Domisili</label>
                            <input type="text" wire:model="location" placeholder="Malang, Indonesia" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Deskripsi Singkat (About Me / Bio) *</label>
                        <textarea rows="4" wire:model="bio" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none"></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Social Media & Contact Links -->
                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6 space-y-5">
                    <div class="border-b border-slate-800 pb-4">
                        <h3 class="text-base font-bold text-white">Tautan Kontak & Sosial Media</h3>
                        <p class="text-xs text-slate-400">Kosongkan kolom jika tidak ingin menampilkan tombol sosial media tertentu.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">Email Kontak Publik</label>
                            <input type="email" wire:model="email" placeholder="nama@domain.com" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">URL LinkedIn</label>
                            <input type="url" wire:model="linkedin_url" placeholder="https://linkedin.com/in/username" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['linkedin_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">URL GitHub</label>
                            <input type="url" wire:model="github_url" placeholder="https://github.com/username" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['github_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1.5">URL Instagram</label>
                            <input type="url" wire:model="instagram_url" placeholder="https://instagram.com/username" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['instagram_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:bg-indigo-500 transition">
                            <span wire:loading.remove wire:target="saveProfile">Simpan Pengaturan Profil</span>
                            <span wire:loading wire:target="saveProfile">Menyimpan...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Admin Login Credentials Card -->
    <form wire:submit="updateAdminCredentials" class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
        <div class="border-b border-slate-800 pb-4 mb-5">
            <h3 class="text-base font-bold text-white">Keamanan Akun Admin Utama</h3>
            <p class="text-xs text-slate-400">Ubah email atau kata sandi untuk login pada halaman tersembunyi <code class="text-indigo-400">/admin/login</code>.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Email Login Admin *</label>
                <input type="email" wire:model="admin_email" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Password Baru (Opsional)</label>
                <input type="password" wire:model="new_password" placeholder="Kosongkan jika tidak diubah" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs text-rose-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" wire:model="new_password_confirmation" placeholder="Ulangi password baru" class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button type="submit" class="rounded-xl border border-slate-700 bg-slate-800 px-5 py-2.5 text-xs font-bold text-white hover:bg-slate-700 transition">
                Perbarui Kredensial Login
            </button>
        </div>
    </form>
</div>
<?php /**PATH C:\Users\Dotkom\Downloads\porto\resources\views/livewire/admin/profile-settings.blade.php ENDPATH**/ ?>