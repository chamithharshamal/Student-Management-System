<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#d7def8] text-slate-800">
<div class="min-h-screen p-4 lg:p-6">
    <div class="mx-auto grid min-h-[calc(100vh-2rem)] max-w-[1320px] overflow-hidden rounded-[32px] bg-white shadow-[0_30px_80px_rgba(42,61,133,0.18)] lg:min-h-[calc(100vh-3rem)] lg:grid-cols-[1.05fr_0.95fr]">
        <section class="relative hidden overflow-hidden bg-[#2f63f0] p-10 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="absolute -left-20 top-12 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute -bottom-20 right-0 h-72 w-72 rounded-full bg-[#5f86ff]/25 blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-3">
                <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/20">
                    <svg viewBox="0 0 24 24" class="h-6 w-6 fill-none stroke-current stroke-[1.8]">
                        <path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z" />
                        <path d="M9.5 12.5L11 14l3.5-4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-semibold">Schooltec</p>
                    <p class="text-sm text-white/70">Admin Login</p>
                </div>
            </div>

            <div class="relative z-10 max-w-xl">
                <p class="text-sm uppercase tracking-[0.35em] text-white/70">Student Management</p>
                <h1 class="mt-4 text-5xl font-semibold leading-tight">Manage students, courses, teachers, and grades in one place.</h1>
                <p class="mt-5 max-w-lg text-base leading-7 text-white/80">A focused admin portal built for a real school workflow. Login first, then move into the dashboard to manage records and daily operations.</p>
            </div>

            <div class="relative z-10 grid grid-cols-3 gap-4 text-sm">
                <div class="rounded-3xl bg-white/10 p-4 ring-1 ring-white/15">
                    <p class="text-white/70">Students</p>
                    <p class="mt-2 text-2xl font-semibold">Active</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-4 ring-1 ring-white/15">
                    <p class="text-white/70">Courses</p>
                    <p class="mt-2 text-2xl font-semibold">Structured</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-4 ring-1 ring-white/15">
                    <p class="text-white/70">Grades</p>
                    <p class="mt-2 text-2xl font-semibold">Tracked</p>
                </div>
            </div>
        </section>

        <section class="flex items-center justify-center bg-[#eef2ff] px-5 py-10 lg:px-10">
            <div class="w-full max-w-md rounded-[28px] bg-white p-8 shadow-[0_18px_50px_rgba(44,63,130,0.12)] ring-1 ring-slate-100">
                <div class="mb-8">
                    <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-500">Welcome back</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Admin Sign In</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Use the seeded admin account to access the dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', 'admin@school.test') }}" required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-[#2f63f0] focus:bg-white">
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                        <input id="password" name="password" type="password" placeholder="Enter password" required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-[#2f63f0] focus:bg-white">
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#2f63f0] focus:ring-[#2f63f0]">
                        Remember me
                    </label>

                    <button type="submit" class="w-full rounded-2xl bg-[#2f63f0] px-4 py-3 font-semibold text-white shadow-[0_12px_30px_rgba(47,99,240,0.32)] transition hover:bg-[#2454d7]">
                        Login to Dashboard
                    </button>

                    <div class="rounded-2xl bg-[#eef2ff] px-4 py-3 text-sm text-slate-600">
                        Default admin: <span class="font-medium text-slate-900">admin@school.test</span>
                        / <span class="font-medium text-slate-900">password</span>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
</body>
</html>
