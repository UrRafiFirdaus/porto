<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'Dashboard Admin'); ?> — Portfolio CMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="h-full font-sans antialiased text-slate-200 bg-slate-950 selection:bg-indigo-500 selection:text-white"
      x-data="{
          sidebarOpen: false,
          toasts: [],
          addToast(type, message) {
              const id = Date.now() + Math.random();
              this.toasts.push({ id, type: type || 'success', message });
              setTimeout(() => {
                  this.toasts = this.toasts.filter(t => t.id !== id);
              }, 4000);
          }
      }"
      x-on:toast.window="addToast($event.detail.type, $event.detail.message)">

    <?php
        $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
        $adminProfile = \App\Models\PortfolioProfile::first();
    ?>

    <!-- Toast Notifications Container -->
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-3 w-full max-w-sm pointer-events-none px-4 sm:px-0">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="pointer-events-auto flex items-start gap-3 rounded-xl border border-slate-800 bg-slate-900/95 backdrop-blur-md p-4 shadow-2xl">
                <div class="flex-shrink-0 mt-0.5">
                    <template x-if="toast.type === 'success'">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-500/15 text-emerald-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </span>
                    </template>
                    <template x-if="toast.type !== 'success'">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-500/15 text-indigo-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </span>
                    </template>
                </div>
                <div class="flex-1 text-sm font-medium text-slate-100" x-text="toast.message"></div>
                <button @click="toasts = toasts.filter(t => t.id !== toast.id)" class="text-slate-400 hover:text-slate-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen"
         x-transition.opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-sm lg:hidden"
         style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-40 w-68 flex flex-col border-r border-slate-800/80 bg-slate-900/95 backdrop-blur-xl transition-transform duration-300 ease-in-out lg:translate-x-0"
           style="width: 17rem;">

        <!-- Brand Header -->
        <div class="flex h-16 items-center justify-between px-6 border-b border-slate-800/80">
            <a href="<?php echo e(route('admin.dashboard')); ?>" wire:navigate class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white font-bold shadow-lg shadow-indigo-500/25">
                    P
                </div>
                <div>
                    <span class="text-base font-bold tracking-tight text-white">PortoCMS</span>
                    <span class="block text-[11px] font-medium text-indigo-400">Admin Panel</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 space-y-1.5 overflow-y-auto px-4 py-6">
            <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-2">Menu Utama</p>

            <a href="<?php echo e(route('admin.dashboard')); ?>" wire:navigate
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/70 hover:text-white'); ?>">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard Overview
            </a>

            <a href="<?php echo e(route('admin.profile')); ?>" wire:navigate
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all <?php echo e(request()->routeIs('admin.profile') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/70 hover:text-white'); ?>">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil & General Settings
            </a>

            <p class="px-3 pt-4 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-2">Konten Portofolio</p>

            <a href="<?php echo e(route('admin.projects')); ?>" wire:navigate
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all <?php echo e(request()->routeIs('admin.projects') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/70 hover:text-white'); ?>">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Showcase Projects
            </a>

            <a href="<?php echo e(route('admin.skills')); ?>" wire:navigate
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all <?php echo e(request()->routeIs('admin.skills') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/70 hover:text-white'); ?>">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                Tech Stack & Skills
            </a>

            <a href="<?php echo e(route('admin.experiences')); ?>" wire:navigate
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all <?php echo e(request()->routeIs('admin.experiences') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/70 hover:text-white'); ?>">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Pengalaman (Experiences)
            </a>

            <a href="<?php echo e(route('admin.educations')); ?>" wire:navigate
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all <?php echo e(request()->routeIs('admin.educations') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/70 hover:text-white'); ?>">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                </svg>
                Pendidikan (Education)
            </a>

            <p class="px-3 pt-4 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-2">Interaksi</p>

            <a href="<?php echo e(route('admin.messages')); ?>" wire:navigate
               class="flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all <?php echo e(request()->routeIs('admin.messages') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/70 hover:text-white'); ?>">
                <span class="flex items-center gap-3">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Pesan Masuk
                </span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                    <span class="rounded-full bg-rose-500 px-2 py-0.5 text-[11px] font-bold text-white"><?php echo e($unreadCount); ?></span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        </nav>

        <!-- Bottom Admin Info & Logout -->
        <div class="border-t border-slate-800/80 p-4 space-y-3">
            <a href="<?php echo e(route('home')); ?>" target="_blank"
               class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-700/80 bg-slate-800/50 px-3 py-2 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-white transition">
                <svg class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Lihat Landing Page Publik
            </a>

            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-rose-500/10 border border-rose-500/20 px-3 py-2 text-xs font-semibold text-rose-400 hover:bg-rose-500 hover:text-white transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="lg:pl-68 flex flex-col min-h-screen" style="padding-left: 0;" x-data x-init="if(window.innerWidth >= 1024) $el.style.paddingLeft = '17rem'" @resize.window="$el.style.paddingLeft = window.innerWidth >= 1024 ? '17rem' : '0'">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md px-4 sm:px-8">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden rounded-lg p-2 text-slate-400 hover:bg-slate-800 hover:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-lg font-bold text-white tracking-tight"><?php echo e($title ?? 'Dashboard'); ?></h1>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-right">
                    <p class="text-xs font-semibold text-white"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-[11px] text-slate-400"><?php echo e(auth()->user()->email); ?></p>
                </div>
                <img src="<?php echo e($adminProfile?->avatar_url ?? 'https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=fff'); ?>"
                     alt="Admin Avatar"
                     class="h-9 w-9 rounded-full object-cover ring-2 ring-indigo-500/40">
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-8 max-w-7xl w-full mx-auto">
            <?php echo e($slot ?? ''); ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\Users\Dotkom\Downloads\porto\resources\views/layouts/admin.blade.php ENDPATH**/ ?>