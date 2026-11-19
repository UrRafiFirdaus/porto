<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Messages List -->
    <div class="lg:col-span-1 rounded-2xl border border-slate-800 bg-slate-900/70 overflow-hidden flex flex-col">
        <div class="border-b border-slate-800 px-5 py-4">
            <h3 class="text-sm font-bold text-white">Kotak Masuk Pengunjung</h3>
            <p class="text-xs text-slate-400">Klik pesan untuk membaca detail.</p>
        </div>

        <div class="divide-y divide-slate-800/80 flex-1">
            @forelse($messages as $msg)
                <button type="button" wire:click="viewMessage({{ $msg->id }})"
                        class="w-full text-left p-4 transition hover:bg-slate-800/50 {{ $selectedMessage?->id === $msg->id ? 'bg-indigo-600/15 border-l-4 border-l-indigo-500' : '' }}">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-sm font-bold {{ $msg->is_read ? 'text-slate-300' : 'text-white' }} truncate">
                            {{ $msg->sender_name }}
                        </span>
                        @if(!$msg->is_read)
                            <span class="h-2.5 w-2.5 rounded-full bg-indigo-500 flex-shrink-0"></span>
                        @endif
                    </div>
                    <p class="text-xs text-indigo-400 truncate mt-0.5">{{ $msg->subject ?: '(Tanpa Subjek)' }}</p>
                    <p class="text-xs text-slate-400 line-clamp-1 mt-1">{{ $msg->message }}</p>
                    <p class="text-[10px] text-slate-500 mt-1.5">{{ $msg->created_at->diffForHumans() }}</p>
                </button>
            @empty
                <div class="p-8 text-center text-xs text-slate-500">
                    Belum ada pesan masuk.
                </div>
            @endforelse
        </div>

        <div class="p-3 border-t border-slate-800">
            {{ $messages->links() }}
        </div>
    </div>

    <!-- Message Detail Viewer -->
    <div class="lg:col-span-2 rounded-2xl border border-slate-800 bg-slate-900/70 p-6 sm:p-8 flex flex-col justify-between min-h-[360px]">
        @if($selectedMessage)
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-indigo-400">
                            {{ $selectedMessage->subject ?: 'Pesan dari Landing Page' }}
                        </span>
                        <h3 class="mt-1 text-xl font-bold text-white">{{ $selectedMessage->sender_name }}</h3>
                        <p class="text-xs text-slate-400">
                            Email: <a href="mailto:{{ $selectedMessage->sender_email }}" class="text-indigo-300 underline">{{ $selectedMessage->sender_email }}</a>
                            • Dikirim {{ $selectedMessage->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="mailto:{{ $selectedMessage->sender_email }}?subject=Re: {{ urlencode($selectedMessage->subject ?: 'Portofolio') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-3.5 py-2 text-xs font-bold text-white hover:bg-indigo-500 transition">
                            Balas Email
                        </a>
                        <button wire:click="delete({{ $selectedMessage->id }})"
                                wire:confirm="Hapus pesan ini secara permanen?"
                                class="rounded-xl border border-rose-500/30 bg-rose-500/10 px-3.5 py-2 text-xs font-semibold text-rose-400 hover:bg-rose-500 hover:text-white transition">
                            Hapus
                        </button>
                    </div>
                </div>

                <div class="mt-6 text-sm text-slate-200 leading-relaxed whitespace-pre-line">
                    {{ $selectedMessage->message }}
                </div>
            </div>
        @else
            <div class="m-auto text-center space-y-2">
                <svg class="mx-auto h-10 w-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm font-medium text-slate-400">Pilih salah satu pesan di sebelah kiri untuk membaca isinya.</p>
            </div>
        @endif
    </div>
</div>
