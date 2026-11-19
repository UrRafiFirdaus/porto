<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $profile?->tagline ?? 'Web Portofolio Profesional' }}">
    <title>{{ $profile?->full_name ?? 'Portofolio' }} — {{ $profile?->role ?? 'Web Developer' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script>
        // Apply saved theme immediately to prevent flash
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        .reveal-hidden {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-200 font-sans antialiased selection:bg-indigo-500 selection:text-white transition-colors duration-300"
      x-data="{
          mobileMenu: false,
          darkMode: document.documentElement.classList.contains('dark'),
          scrolled: false,
          toggleTheme() {
              this.darkMode = !this.darkMode;
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('theme', 'light');
              }
          }
      }"
      @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Sticky Glassmorphism Navbar -->
    <header :class="scrolled ? 'bg-white/85 dark:bg-slate-950/85 backdrop-blur-lg border-b border-slate-200/80 dark:border-slate-800/80 shadow-sm' : 'bg-transparent'"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand / Monogram -->
            <a href="#about" class="flex items-center gap-2.5 group">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white font-extrabold text-sm shadow-md shadow-indigo-500/25 group-hover:scale-105 transition">
                    {{ strtoupper(substr($profile?->full_name ?? 'P', 0, 1)) }}
                </span>
                <span class="font-bold text-slate-900 dark:text-white tracking-tight text-base">
                    {{ explode(' ', $profile?->full_name ?? 'Portofolio')[0] }}<span class="text-indigo-500">.</span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600 dark:text-slate-300">
                <a href="#about" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Tentang Saya</a>
                <a href="#skills" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Tech Stack</a>
                <a href="#experience" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Pengalaman & Edukasi</a>
                <a href="#projects" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Proyek</a>
                <a href="#contact" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Kontak</a>
            </nav>

            <!-- Right Actions: Theme Switcher & Mobile Menu Button -->
            <div class="flex items-center gap-2.5">
                <button @click="toggleTheme()" aria-label="Toggle Dark Mode"
                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300 hover:border-indigo-500 transition">
                    <!-- Sun Icon (shown in dark mode) -->
                    <svg x-show="darkMode" class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Moon Icon (shown in light mode) -->
                    <svg x-show="!darkMode" class="h-4 w-4 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <button @click="mobileMenu = !mobileMenu" aria-label="Buka Menu"
                        class="md:hidden flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200">
                    <svg x-show="!mobileMenu" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="mobileMenu = false"
             class="md:hidden border-b border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl px-4 py-4 space-y-2"
             style="display: none;">
            <a @click="mobileMenu = false" href="#about" class="block rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100 dark:hover:bg-slate-900">Tentang Saya</a>
            <a @click="mobileMenu = false" href="#skills" class="block rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100 dark:hover:bg-slate-900">Tech Stack</a>
            <a @click="mobileMenu = false" href="#experience" class="block rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100 dark:hover:bg-slate-900">Pengalaman & Edukasi</a>
            <a @click="mobileMenu = false" href="#projects" class="block rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100 dark:hover:bg-slate-900">Proyek</a>
            <a @click="mobileMenu = false" href="#contact" class="block rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100 dark:hover:bg-slate-900">Kontak</a>
        </div>
    </header>

    <!-- Flash Alert if CV missing -->
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="fixed bottom-5 right-5 z-50 rounded-xl border border-rose-500/30 bg-slate-900 px-4 py-3 text-xs font-semibold text-rose-300 shadow-xl">
            {{ session('error') }}
        </div>
    @endif

    <!-- 1. HERO & ABOUT ME SECTION -->
    <section id="about" class="relative pt-28 pb-20 sm:pt-36 sm:pb-28 overflow-hidden">
        <!-- Decorative Ambient Glow -->
        <div class="pointer-events-none absolute top-10 left-1/2 -translate-x-1/2 h-[420px] w-[720px] rounded-full bg-indigo-500/10 dark:bg-indigo-600/15 blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
                <!-- Left Text & CTA -->
                <div class="flex-1 text-center lg:text-left space-y-6" data-reveal>
                    @if($profile?->available_for_work)
                        <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3.5 py-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                            Tersedia untuk Proyek & Kolaborasi
                        </div>
                    @endif

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
                            Halo, Saya
                        </p>
                        <h1 class="mt-2 text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                            {{ $profile?->full_name ?? 'Nama Lengkap Anda' }}
                        </h1>
                        <h2 class="mt-3 text-lg sm:text-xl font-semibold text-slate-600 dark:text-slate-300">
                            {{ $profile?->role ?? 'Full-Stack Web Developer' }}
                        </h2>
                    </div>

                    @if($profile?->tagline)
                        <p class="text-base font-medium text-indigo-600/90 dark:text-indigo-300/90 max-w-2xl mx-auto lg:mx-0">
                            "{{ $profile->tagline }}"
                        </p>
                    @endif

                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ $profile?->bio ?? 'Deskripsi singkat mengenai keahlian dan pengalaman saya.' }}
                    </p>

                    @if($profile?->location)
                        <div class="flex items-center justify-center lg:justify-start gap-2 text-xs font-medium text-slate-500 dark:text-slate-400">
                            <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $profile->location }}</span>
                        </div>
                    @endif

                    <!-- Primary Action Buttons -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        @if($profile?->cv_url)
                            <a href="{{ route('cv.download') }}"
                               class="inline-flex items-center gap-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 hover:from-indigo-500 hover:to-violet-500 hover:-translate-y-0.5 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Unduh CV (PDF)
                            </a>
                        @endif

                        <a href="#projects"
                           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-6 py-3.5 text-sm font-bold text-slate-800 dark:text-slate-200 hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            Lihat Portofolio
                        </a>
                    </div>
                </div>

                <!-- Right Profile Photo -->
                <div class="flex-shrink-0" data-reveal>
                    <div class="relative">
                        <div class="absolute -inset-2 rounded-3xl bg-gradient-to-tr from-indigo-500 via-violet-500 to-cyan-400 opacity-40 blur-xl"></div>
                        <div class="relative h-64 w-64 sm:h-72 sm:w-72 rounded-3xl overflow-hidden border-2 border-white/60 dark:border-slate-800 bg-slate-200 dark:bg-slate-900 shadow-2xl">
                            <img src="{{ $profile?->avatar_url ?? 'https://ui-avatars.com/api/?name=Admin&size=300&background=4f46e5&color=fff' }}"
                                 alt="{{ $profile?->full_name ?? 'Foto Profil' }}"
                                 class="h-full w-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. TECH STACK & SKILLS SECTION -->
    <section id="skills" class="py-20 border-t border-slate-200/70 dark:border-slate-800/70 bg-white/50 dark:bg-slate-900/30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14" data-reveal>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Keahlian Teknis</span>
                <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tech Stack & Skills</h2>
                <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                    Bahasa pemrograman, framework, serta tools modern yang saya gunakan untuk merancang dan membangun solusi digital.
                </p>
            </div>

            <div class="space-y-10">
                @forelse($skillsByCategory as $category => $items)
                    <div data-reveal>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-4 flex items-center gap-3">
                            <span>{{ $category }}</span>
                            <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach($items as $skill)
                                <div class="group rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/80 p-4 flex flex-col items-center text-center hover:border-indigo-500/60 hover:-translate-y-1 hover:shadow-lg hover:shadow-indigo-500/10 transition duration-300">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-950 text-3xl group-hover:scale-110 transition">
                                        @if($skill->logo_url)
                                            <img src="{{ $skill->logo_url }}" alt="{{ $skill->name }}" class="h-7 w-7 object-contain">
                                        @elseif($skill->icon_class)
                                            <i class="{{ $skill->icon_class }}"></i>
                                        @else
                                            <span class="text-sm font-extrabold text-indigo-500">{{ strtoupper(substr($skill->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100">{{ $skill->name }}</p>
                                    <div class="mt-2.5 w-full h-1 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-cyan-400" style="width: {{ $skill->proficiency }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-center text-sm text-slate-500">Data tech stack belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 3. EXPERIENCES & EDUCATION TIMELINE SECTION -->
    <section id="experience" class="py-20 border-t border-slate-200/70 dark:border-slate-800/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14" data-reveal>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Perjalanan Karier & Akademik</span>
                <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Experiences & Education</h2>
                <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                    Rekam jejak pengalaman kerja, magang, organisasi, serta latar belakang pendidikan secara kronologis.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left Column: Experiences -->
                <div data-reveal>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Pengalaman</h3>
                    </div>

                    <div class="relative border-l-2 border-slate-200 dark:border-slate-800 ml-4 space-y-8">
                        @forelse($experiences as $exp)
                            <div class="relative pl-7">
                                <span class="absolute -left-[9px] top-1.5 h-4 w-4 rounded-full border-4 border-slate-50 dark:border-slate-950 {{ $exp->is_current ? 'bg-indigo-500 ring-4 ring-indigo-500/20' : 'bg-slate-400 dark:bg-slate-600' }}"></span>

                                <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/70 p-5 shadow-sm">
                                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                        <span class="rounded-full bg-indigo-500/10 border border-indigo-500/20 px-2.5 py-0.5 text-[11px] font-bold text-indigo-600 dark:text-indigo-300">
                                            {{ $exp->type }}
                                        </span>
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                            {{ $exp->start_date }} — {{ $exp->is_current ? 'Sekarang' : ($exp->end_date ?: 'Selesai') }}
                                        </span>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-900 dark:text-white">{{ $exp->title }}</h4>
                                    <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mt-0.5">
                                        {{ $exp->organization }} {{ $exp->location ? '• ' . $exp->location : '' }}
                                    </p>
                                    @if($exp->description)
                                        <p class="mt-2.5 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                            {{ $exp->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="pl-7 text-sm text-slate-500">Belum ada riwayat pengalaman.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Right Column: Education -->
                <div data-reveal>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                            </svg>
                        </span>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Pendidikan</h3>
                    </div>

                    <div class="relative border-l-2 border-slate-200 dark:border-slate-800 ml-4 space-y-8">
                        @forelse($educations as $edu)
                            <div class="relative pl-7">
                                <span class="absolute -left-[9px] top-1.5 h-4 w-4 rounded-full border-4 border-slate-50 dark:border-slate-950 {{ $edu->is_current ? 'bg-emerald-500 ring-4 ring-emerald-500/20' : 'bg-slate-400 dark:bg-slate-600' }}"></span>

                                <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/70 p-5 shadow-sm">
                                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                        <span class="rounded-full bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-0.5 text-[11px] font-bold text-emerald-600 dark:text-emerald-300">
                                            {{ $edu->start_year }} — {{ $edu->is_current ? 'Sekarang' : ($edu->end_year ?: 'Lulus') }}
                                        </span>
                                        @if($edu->gpa)
                                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                                IPK: {{ $edu->gpa }}
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="text-base font-bold text-slate-900 dark:text-white">{{ $edu->institution }}</h4>
                                    <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $edu->degree }}</p>
                                    @if($edu->description)
                                        <p class="mt-2.5 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                            {{ $edu->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="pl-7 text-sm text-slate-500">Belum ada riwayat pendidikan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. SHOWCASE PROJECTS SECTION -->
    <section id="projects" class="py-20 border-t border-slate-200/70 dark:border-slate-800/70 bg-white/50 dark:bg-slate-900/30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14" data-reveal>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Karya Pilihan</span>
                <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Showcase Projects</h2>
                <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                    Kumpulan aplikasi web, sistem informasi, dan proyek perangkat lunak yang pernah saya bangun.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @forelse($projects as $project)
                    <article data-reveal
                             class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/80 shadow-sm hover:border-indigo-500/50 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition duration-300">
                        <!-- Project Thumbnail -->
                        <div class="relative aspect-video overflow-hidden bg-slate-200 dark:bg-slate-950">
                            <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}"
                                 class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                            @if($project->is_featured)
                                <span class="absolute top-3 left-3 rounded-full bg-amber-400/95 px-2.5 py-0.5 text-[10px] font-extrabold text-slate-950 shadow">
                                    ★ Featured
                                </span>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="flex-1 p-6 flex flex-col justify-between space-y-5">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                    {{ $project->title }}
                                </h3>
                                <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                    {{ $project->short_description }}
                                </p>

                                <!-- Tech Stack Badges -->
                                <div class="mt-4 flex flex-wrap gap-1.5">
                                    @foreach($project->tech_stack ?? [] as $tech)
                                        <span class="rounded-lg bg-indigo-500/10 border border-indigo-500/20 px-2.5 py-1 text-[11px] font-semibold text-indigo-600 dark:text-indigo-300">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Project Action Links -->
                            <div class="pt-4 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between gap-3">
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-3.5 py-2 text-xs font-bold text-white hover:bg-indigo-500 transition">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Live Demo
                                    </a>
                                @endif

                                @if($project->is_private)
                                    <span class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/80 px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        Private Repo
                                    </span>
                                @elseif($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 px-3.5 py-2 text-xs font-bold text-slate-800 dark:text-slate-200 hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                        </svg>
                                        GitHub
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12 text-sm text-slate-500">
                        Belum ada proyek yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. CONTACT & SOCIAL MEDIA SECTION -->
    <section id="contact" class="py-20 border-t border-slate-200/70 dark:border-slate-800/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <!-- Left: Social Media & Direct Links -->
                <div class="lg:col-span-5 space-y-6" data-reveal>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Mari Terhubung</span>
                        <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Hubungi Saya</h2>
                        <p class="mt-3 text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Tertarik untuk berdiskusi mengenai proyek baru, peluang kerja, atau kolaborasi teknis? Jangan ragu untuk menghubungi saya melalui kanal berikut atau kirim pesan langsung.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3.5">
                        @if($profile?->email)
                            <a href="mailto:{{ $profile->email }}"
                               class="flex items-center gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/70 p-4 hover:border-indigo-500 transition group">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white transition">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Email</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $profile->email }}</p>
                                </div>
                            </a>
                        @endif

                        @if($profile?->linkedin_url)
                            <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener"
                               class="flex items-center gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/70 p-4 hover:border-sky-500 transition group">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-500/15 text-sky-600 dark:text-sky-400 group-hover:bg-sky-600 group-hover:text-white transition">
                                    <i class="devicon-linkedin-plain text-xl"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">LinkedIn</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">Terhubung di LinkedIn</p>
                                </div>
                            </a>
                        @endif

                        @if($profile?->github_url)
                            <a href="{{ $profile->github_url }}" target="_blank" rel="noopener"
                               class="flex items-center gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/70 p-4 hover:border-slate-500 transition group">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-500/15 text-slate-700 dark:text-slate-300 group-hover:bg-slate-800 group-hover:text-white transition">
                                    <i class="devicon-github-original text-xl"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">GitHub</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">Lihat Repository Kode</p>
                                </div>
                            </a>
                        @endif

                        @if($profile?->instagram_url)
                            <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener"
                               class="flex items-center gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/70 p-4 hover:border-pink-500 transition group">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-500/15 text-pink-600 dark:text-pink-400 group-hover:bg-pink-600 group-hover:text-white transition">
                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Instagram</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">Ikuti di Instagram</p>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Right: Livewire Interactive Contact Form -->
                <div class="lg:col-span-7" data-reveal>
                    <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900/70 p-6 sm:p-8 shadow-xl">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Kirim Pesan Langsung</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Pesan Anda akan langsung masuk ke dashboard pribadi saya.</p>
                        <livewire:contact-form />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200/80 dark:border-slate-800/80 py-8 text-center text-xs text-slate-500 dark:text-slate-400">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; {{ date('Y') }} {{ $profile?->full_name ?? 'Portofolio' }}. Dibangun dengan Laravel, Livewire & Tailwind CSS.</p>
            <a href="#about" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">Kembali ke Atas &uarr;</a>
        </div>
    </footer>

    <!-- IntersectionObserver Scroll Reveal Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('[data-reveal]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            elements.forEach(el => {
                el.classList.add('reveal-hidden');
                observer.observe(el);
            });
        });
    </script>

    @livewireScripts
</body>
</html>
