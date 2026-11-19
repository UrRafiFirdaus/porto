<div>
    @if($submitted)
        <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-6 text-center space-y-3">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h4 class="text-base font-bold text-slate-900 dark:text-white">Pesan Berhasil Terkirim!</h4>
            <p class="text-xs text-slate-600 dark:text-slate-300">Terima kasih telah menghubungi saya. Saya akan segera membalas pesan Anda.</p>
            <button type="button" wire:click="$set('submitted', false)"
                    class="mt-2 inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500 transition">
                Kirim Pesan Lainnya
            </button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap *</label>
                    <input type="text" wire:model="sender_name" placeholder="Nama Anda"
                           class="w-full rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900/80 px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                    @error('sender_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Alamat Email *</label>
                    <input type="email" wire:model="sender_email" placeholder="email@contoh.com"
                           class="w-full rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900/80 px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                    @error('sender_email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Subjek (Opsional)</label>
                <input type="text" wire:model="subject" placeholder="Tawaran Kerja Sama / Freelance Project"
                       class="w-full rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900/80 px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Pesan *</label>
                <textarea rows="4" wire:model="message" placeholder="Tuliskan pesan atau detail kebutuhan proyek Anda..."
                          class="w-full rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900/80 px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition"></textarea>
                @error('message') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:from-indigo-500 hover:to-violet-500 transition">
                <span wire:loading.remove wire:target="submit">Kirim Pesan Sekarang</span>
                <span wire:loading wire:target="submit">Mengirim Pesan...</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    @endif
</div>
