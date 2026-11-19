@extends('layouts.admin')

@php($title = 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-gradient-to-r from-slate-900 via-indigo-950/40 to-slate-900 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 px-3 py-1 text-xs font-semibold text-indigo-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    CMS Portofolio Aktif
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Selamat datang kembali, {{ $profile?->full_name ?? auth()->user()->name }}!
                </h2>
                <p class="mt-1.5 text-sm text-slate-400 max-w-2xl">
                    Kelola seluruh konten landing page portofolio Anda—mulai dari profil, file CV PDF, proyek unggulan, tech stack, hingga riwayat karier—secara dinamis tanpa menyentuh kode.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.projects') }}" wire:navigate
                   class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 hover:bg-indigo-500 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Kelola Projects
                </a>
                <a href="{{ route('admin.profile') }}" wire:navigate
                   class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-800/70 px-4 py-2.5 text-sm font-semibold text-slate-200 hover:bg-slate-800 transition">
                    Edit Profil & CV
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Projects</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-500/15 text-indigo-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ $stats['projects_total'] }}</p>
            <p class="mt-1 text-xs text-emerald-400">{{ $stats['projects_published'] }} proyek tampil publik</p>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tech Stack & Skills</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-500/15 text-cyan-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ $stats['skills_total'] }}</p>
            <p class="mt-1 text-xs text-slate-400">Teknologi & tools dikuasai</p>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pengalaman & Edukasi</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ $stats['experiences_total'] + $stats['educations_total'] }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ $stats['experiences_total'] }} pengalaman · {{ $stats['educations_total'] }} pendidikan</p>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pesan Belum Dibaca</span>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-500/15 text-rose-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-extrabold text-white">{{ $stats['unread_messages'] }}</p>
            <a href="{{ route('admin.messages') }}" wire:navigate class="mt-1 inline-block text-xs text-indigo-400 hover:underline">Buka kotak masuk &rarr;</a>
        </div>
    </div>

    <!-- Recent Projects & Messages -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Projects -->
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-white">Proyek Terbaru</h3>
                <a href="{{ route('admin.projects') }}" wire:navigate class="text-xs font-semibold text-indigo-400 hover:text-indigo-300">Semua Proyek &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recentProjects as $project)
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-800/80 bg-slate-950/60 p-3.5">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="h-12 w-16 rounded-lg object-cover flex-shrink-0 border border-slate-800">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-white truncate">{{ $project->title }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ implode(', ', $project->tech_stack ?? []) }}</p>
                            </div>
                        </div>
                        <span class="flex-shrink-0 rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $project->is_published ? 'bg-emerald-500/15 text-emerald-400' : 'bg-slate-800 text-slate-400' }}">
                            {{ $project->is_published ? 'Tampil' : 'Draft' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 py-6 text-center">Belum ada proyek ditambahkan.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-white">Pesan Masuk Terbaru</h3>
                <a href="{{ route('admin.messages') }}" wire:navigate class="text-xs font-semibold text-indigo-400 hover:text-indigo-300">Lihat Semua &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recentMessages as $msg)
                    <div class="rounded-xl border border-slate-800/80 bg-slate-950/60 p-3.5">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-semibold text-white">{{ $msg->sender_name }} <span class="font-normal text-xs text-slate-400">({{ $msg->sender_email }})</span></p>
                            @if(!$msg->is_read)
                                <span class="rounded-full bg-indigo-500/20 px-2 py-0.5 text-[10px] font-bold text-indigo-300">Baru</span>
                            @endif
                        </div>
                        <p class="mt-1 text-xs text-slate-400 line-clamp-2">{{ $msg->message }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 py-6 text-center">Belum ada pesan masuk dari pengunjung.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
