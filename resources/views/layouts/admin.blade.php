<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? config('app.name', 'Student Management') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#d7def8] text-slate-800">
<div id="app-wrapper" class="min-h-screen transition-all duration-500">
    <div class="flex min-h-screen w-full overflow-hidden bg-[#eef2ff] relative">
        <!-- Sidebar overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity lg:hidden"></div>

        <!-- Sidebar -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 flex w-[240px] -translate-x-full flex-col bg-slate-900 px-5 py-5 text-white transition-transform duration-300 shadow-2xl lg:static lg:translate-x-0 lg:shadow-none lg:shrink-0">
            <!-- Close Button (Mobile Only) -->
            <button id="closeSidebarBtn" class="absolute right-4 top-5 rounded-lg p-1 text-white/50 hover:bg-white/10 hover:text-white lg:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="mb-8 flex items-center gap-3 pr-8 lg:pr-0">
                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/20">
                    <svg viewBox="0 0 24 24" class="h-6 w-6 fill-none stroke-current stroke-[1.8]">
                        <path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z" />
                        <path d="M9.5 12.5L11 14l3.5-4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-semibold tracking-wide">SM System</p>
                    <p class="text-xs text-white/70">Admin Portal</p>
                </div>
            </div>

            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 shadow-sm ring-1 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 ring-white/10' : 'ring-transparent hover:bg-white/10' }}">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/15">
                        <span class="h-3 w-3 rounded-sm bg-white"></span>
                    </span>
                    Dashboard
                </a>
                <a href="{{ route('admin.students') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 ring-1 {{ request()->routeIs('admin.students*') ? 'bg-white/15 ring-white/40' : 'ring-transparent hover:bg-white/10' }}">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">S</span>
                    Students
                </a>
                <a href="{{ route('admin.courses') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 ring-1 {{ request()->routeIs('admin.courses*') ? 'bg-white/15 ring-white/40' : 'ring-transparent hover:bg-white/10' }}">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">C</span>
                    Courses
                </a>
                <a href="{{ route('admin.teachers') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 ring-1 {{ request()->routeIs('admin.teachers*') ? 'bg-white/15 ring-white/40' : 'ring-transparent hover:bg-white/10' }}">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">T</span>
                    Teachers
                </a>
                <a href="{{ route('admin.enrollments') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 ring-1 {{ request()->routeIs('admin.enrollments*') ? 'bg-white/15 ring-white/40' : 'ring-transparent hover:bg-white/10' }}">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">E</span>
                    Enrollments
                </a>
                <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 hover:bg-white/10">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">G</span>
                    Grades
                </a>
                <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 hover:bg-white/10">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">A</span>
                    Attendance
                </a>
                <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 hover:bg-white/10">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">P</span>
                    Payment
                </a>
                <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 hover:bg-white/10">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">S</span>
                    Settings
                </a>
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="border-b border-slate-200/70 bg-white/75 px-5 py-3 backdrop-blur xl:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button id="mobileMenuBtn" class="lg:hidden rounded-lg p-2 -ml-2 text-slate-600 border border-slate-200 bg-white hover:bg-slate-50 transition-colors shadow-sm">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <p class="text-sm text-slate-500">{{ $eyebrow ?? 'Student Management System' }}</p>
                            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $header ?? 'Dashboard' }}</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">

                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
                                Logout
                            </button>
                        </form>
                        <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-full bg-slate-800 text-sm font-semibold text-white">
                            A
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-auto px-5 py-5 xl:px-8">
                @if (session('status'))
                    <div id="globalStatus" class="fixed top-5 right-5 z-[9999] flex items-center gap-3 rounded-2xl px-4 py-3 shadow-[0_8px_32px_rgba(16,185,129,0.35)] transition-all duration-500" style="max-width:360px; background-color:#10b981;">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/20">
                            <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="flex-1 text-sm font-semibold text-white">{{ session('status') }}</p>
                        <button onclick="dismissToast()" class="shrink-0 text-white/70 transition hover:text-white">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </button>
                    </div>
                    <script>
                        function dismissToast() {
                            const toast = document.getElementById('globalStatus');
                            if (toast) {
                                toast.style.opacity = '0';
                                toast.style.transform = 'translateY(-12px)';
                                setTimeout(() => toast.remove(), 400);
                            }
                        }
                        setTimeout(dismissToast, 4000);
                    </script>
                @endif

                @if ($errors->any())
                    <div class="mb-6 flex items-start justify-between gap-3 rounded-2xl bg-rose-50 px-4 py-3 text-rose-800 ring-1 ring-rose-200 transition-all">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 shrink-0 text-rose-600 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            <div class="text-sm font-medium">
                                <p>There was a problem with your submission:</p>
                                <ul class="mt-1 list-inside list-disc opacity-90">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 mt-0.5">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</div>
    @stack('modals')

    <script>
        (function() {
            function initSidebar() {
                const sidebar = document.getElementById('adminSidebar');
                const overlay = document.getElementById('sidebarOverlay');
                const openBtn = document.getElementById('mobileMenuBtn');
                const closeBtn = document.getElementById('closeSidebarBtn');

                if (!sidebar || !overlay || !openBtn) return;

                function openSidebar() {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closeSidebar() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }

                openBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openSidebar();
                });

                if (closeBtn) {
                    closeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeSidebar();
                    });
                }

                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        closeSidebar();
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') closeSidebar();
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initSidebar);
            } else {
                initSidebar();
            }
        })();
    </script>
</body>
</html>
