<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#eef4ff_0%,#dbe7ff_100%)] text-slate-800">
<div class="min-h-screen px-4 py-10">
    <div class="mx-auto flex min-h-[calc(100vh-5rem)] w-full max-w-md items-center">
        <div class="w-full rounded-[32px] border border-white/70 bg-white/90 p-8 shadow-[0_28px_80px_rgba(41,64,140,0.16)] backdrop-blur-xl sm:p-10">
            <div class="mb-8 text-center">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-[24px] bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)]">
                    <svg viewBox="0 0 24 24" class="h-7 w-7 fill-none stroke-current stroke-[1.8]">
                        <path d="M12 2l8 4v6c0 5-3.5 9.4-8 10-4.5-.6-8-5-8-10V6l8-4z" />
                        <path d="M9.5 12.5L11 14l3.5-4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-5 text-sm font-semibold uppercase tracking-[0.28em] text-slate-800">SM System</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">Admin Login</h1>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                    <input id="username" name="username" type="text" placeholder="Admin username" required
                           class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter password" required
                           class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-800 focus:ring-slate-800">
                    Remember me
                </label>

                <button type="submit" class="w-full rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-4 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
