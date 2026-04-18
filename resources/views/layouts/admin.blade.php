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
    <div class="flex min-h-screen w-full overflow-hidden bg-[#eef2ff]">
        <aside class="hidden w-[240px] shrink-0 flex-col bg-slate-900 px-5 py-5 text-white lg:flex">
            <div class="mb-8 flex items-center gap-3">
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
                <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 hover:bg-white/10">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">C</span>
                    Courses
                </a>
                <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 hover:bg-white/10">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/10">T</span>
                    Teachers
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
                    <div>
                        <p class="text-sm text-slate-500">{{ $eyebrow ?? 'Student Management System' }}</p>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $header ?? 'Dashboard' }}</h1>
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
                @yield('content')
            </main>
        </div>
    </div>
</div>
    @stack('modals')
</body>
</html>
