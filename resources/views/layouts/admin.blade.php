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
<div class="min-h-screen p-4 lg:p-6">
    <div class="mx-auto flex min-h-[calc(100vh-2rem)] max-w-[1440px] overflow-hidden rounded-[32px] bg-[#eef2ff] shadow-[0_30px_80px_rgba(42,61,133,0.18)] lg:min-h-[calc(100vh-3rem)]">
        <aside class="hidden w-[280px] shrink-0 flex-col bg-[#2f63f0] px-6 py-6 text-white lg:flex">
            <div class="mb-8 flex items-center gap-3">
                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/20">
                    <svg viewBox="0 0 24 24" class="h-6 w-6 fill-none stroke-current stroke-[1.8]">
                        <path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z" />
                        <path d="M9.5 12.5L11 14l3.5-4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-semibold tracking-wide">Schooltec</p>
                    <p class="text-xs text-white/70">Admin Portal</p>
                </div>
            </div>

            <nav class="space-y-2 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-2xl bg-white/15 px-4 py-3 shadow-sm ring-1 ring-white/10">
                    <span class="grid h-8 w-8 place-items-center rounded-xl bg-white/15">
                        <span class="h-3 w-3 rounded-sm bg-white"></span>
                    </span>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/85 hover:bg-white/10">
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

            <div class="mt-auto rounded-[28px] bg-white/10 p-4 ring-1 ring-white/15">
                <p class="text-sm font-semibold">Admin Access</p>
                <p class="mt-1 text-xs leading-5 text-white/75">Manage students, courses, teachers, and grades from one place.</p>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="border-b border-slate-200/70 bg-white/75 px-5 py-4 backdrop-blur xl:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500">{{ $eyebrow ?? 'Student Management System' }}</p>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $header ?? 'Dashboard' }}</h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden rounded-2xl bg-slate-100 px-4 py-2 text-sm text-slate-500 md:block">
                            Search records
                        </div>
                        <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-full bg-[#2f63f0] text-sm font-semibold text-white">
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
</body>
</html>
