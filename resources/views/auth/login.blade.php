<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-[radial-gradient(circle_at_top,#f5f8ff_0%,#dbe5ff_42%,#c5d4fb_100%)] text-slate-800">
<div class="relative min-h-screen overflow-hidden p-4 lg:p-6">
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute left-[6%] top-16 h-40 w-40 rounded-full bg-white/30 blur-3xl"></div>
        <div class="absolute right-[8%] top-[12%] h-56 w-56 rounded-full bg-[#5d7bff]/20 blur-3xl"></div>
        <div class="absolute bottom-[10%] left-[14%] h-52 w-52 rounded-full bg-[#ffcf7f]/15 blur-3xl"></div>
    </div>

    <div class="relative mx-auto grid min-h-[calc(100vh-2rem)] max-w-345 overflow-hidden rounded-[36px] border border-white/50 bg-white/70 shadow-[0_35px_90px_rgba(41,64,140,0.22)] backdrop-blur-xl lg:min-h-[calc(100vh-3rem)] lg:grid-cols-[1.08fr_0.92fr]">
        <section class="relative hidden overflow-hidden bg-[linear-gradient(160deg,#1f4fe0_0%,#2f63f0_46%,#5a84ff_100%)] p-10 text-white lg:flex lg:flex-col lg:justify-between xl:p-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.2),transparent_30%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.16),transparent_28%)]"></div>
            <div class="absolute -right-16 top-20 h-56 w-56 rounded-full border border-white/20"></div>
            <div class="absolute bottom-10 left-10 h-24 w-24 rounded-[28px] bg-white/10 ring-1 ring-white/10 backdrop-blur-sm"></div>
            <div class="absolute bottom-24 right-14 h-40 w-40 rounded-full border border-white/10"></div>

            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/20 shadow-[inset_0_1px_0_rgba(255,255,255,0.24)]">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-none stroke-current stroke-[1.8]">
                            <path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z" />
                            <path d="M9.5 12.5L11 14l3.5-4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-semibold tracking-wide">SM System</p>
                        <p class="text-sm text-white/70">Student Management Admin</p>
                    </div>
                </div>

                <div class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium uppercase tracking-[0.28em] text-white/80">
                    Secure Access
                </div>
            </div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium uppercase tracking-[0.3em] text-white/75">
                    Admin Workspace
                </div>
                <h1 class="mt-7 max-w-xl text-5xl font-semibold leading-[1.05] tracking-tight xl:text-6xl">
                    Clean access to your school operations.
                </h1>
                <p class="mt-6 max-w-xl text-base leading-8 text-white/82 xl:text-lg">
                    Sign in to manage students, courses, teachers, grades, and day-to-day records from a single dashboard built for school administration.
                </p>

                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-[28px] border border-white/12 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm text-white/70">Students</p>
                        <p class="mt-3 text-3xl font-semibold">Profiles</p>
                        <p class="mt-2 text-sm leading-6 text-white/70">Admission and record tracking.</p>
                    </div>
                    <div class="rounded-[28px] border border-white/12 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm text-white/70">Courses</p>
                        <p class="mt-3 text-3xl font-semibold">Modules</p>
                        <p class="mt-2 text-sm leading-6 text-white/70">Structured class and subject data.</p>
                    </div>
                    <div class="rounded-[28px] border border-white/12 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-sm text-white/70">Grades</p>
                        <p class="mt-3 text-3xl font-semibold">Results</p>
                        <p class="mt-2 text-sm leading-6 text-white/70">Academic performance management.</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 flex items-end justify-between gap-6">
                <div class="max-w-sm rounded-[30px] border border-white/12 bg-white/10 p-5 backdrop-blur-sm">
                    <p class="text-xs uppercase tracking-[0.28em] text-white/65">System Note</p>
                    <p class="mt-3 text-lg font-medium leading-8 text-white/90">
                        The login screen is separated from the dashboard so admin access stays explicit and controlled.
                    </p>
                </div>

                <div class="hidden h-28 w-28 rounded-full border border-white/20 bg-white/5 xl:block"></div>
            </div>
        </section>

        <section class="relative flex items-center justify-center bg-[linear-gradient(180deg,rgba(247,250,255,0.96)_0%,rgba(234,240,255,0.92)_100%)] px-5 py-8 sm:px-8 lg:px-10">
            <div class="absolute inset-x-0 top-0 h-28 bg-[linear-gradient(180deg,rgba(255,255,255,0.45),transparent)]"></div>

            <div class="relative w-full max-w-lg">
                <div class="mb-6 flex items-center justify-between lg:hidden">
                    <div class="flex items-center gap-3">
                        <div class="grid h-11 w-11 place-items-center rounded-2xl bg-[#2f63f0] text-white shadow-[0_16px_34px_rgba(47,99,240,0.26)]">
                            <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[1.8]">
                                <path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z" />
                                <path d="M9.5 12.5L11 14l3.5-4" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-slate-900">SM System</p>
                            <p class="text-sm text-slate-500">Admin Login</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[34px] border border-white/60 bg-white/88 p-6 shadow-[0_25px_70px_rgba(47,63,130,0.14)] backdrop-blur-xl sm:p-8">
                    <div class="mb-8">
                        <div class="inline-flex rounded-full bg-[#edf2ff] px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#2f63f0]">
                            Welcome Back
                        </div>
                        <h2 class="mt-5 text-4xl font-semibold tracking-tight text-slate-900">Admin Sign In</h2>

                    </div>

                    @if ($errors->any())
                        <div class="mb-5 rounded-3xl border border-rose-200 bg-[linear-gradient(180deg,#fff1f1_0%,#ffe8e8_100%)] px-4 py-4 text-sm text-rose-700 shadow-[0_10px_25px_rgba(244,63,94,0.08)]">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                        @csrf
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                            <div class="flex items-center gap-3 rounded-3xl border border-slate-200 bg-slate-50/80 px-4 py-1 transition focus-within:border-[#2f63f0] focus-within:bg-white focus-within:shadow-[0_0_0_4px_rgba(47,99,240,0.10)]">
                                <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0 text-slate-400 fill-none stroke-current stroke-[1.8]">
                                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                                    <path d="M4 20a8 8 0 0 1 16 0" stroke-linecap="round" />
                                </svg>
                                <input id="username" name="username" type="text" placeholder="Admin username" required
                                       class="w-full border-0 bg-transparent px-0 py-3 text-slate-900 outline-none placeholder:text-slate-400 focus:ring-0">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                            <div class="flex items-center gap-3 rounded-3xl border border-slate-200 bg-slate-50/80 px-4 py-1 transition focus-within:border-[#2f63f0] focus-within:bg-white focus-within:shadow-[0_0_0_4px_rgba(47,99,240,0.10)]">
                                <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0 text-slate-400 fill-none stroke-current stroke-[1.8]">
                                    <path d="M7 11V8a5 5 0 0 1 10 0v3" />
                                    <rect x="5" y="11" width="14" height="10" rx="2" />
                                </svg>
                                <input id="password" name="password" type="password" placeholder="Enter password" required
                                       class="w-full border-0 bg-transparent px-0 py-3 text-slate-900 outline-none placeholder:text-slate-400 focus:ring-0">
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4 text-sm">
                            <label class="flex items-center gap-3 text-slate-600">
                                <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#2f63f0] focus:ring-[#2f63f0]">
                                Remember me
                            </label>

                        </div>

                        <button type="submit" class="w-full rounded-3xl bg-[linear-gradient(135deg,#1f4fe0_0%,#2f63f0_58%,#4b79ff_100%)] px-4 py-4 text-base font-semibold text-white shadow-[0_20px_40px_rgba(47,99,240,0.32)] transition hover:-translate-y-px hover:shadow-[0_24px_44px_rgba(47,99,240,0.36)]">
                            Login to Dashboard
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>
