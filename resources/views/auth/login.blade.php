<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TechOrbit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        ink: '#11203B',
                        mint: '#00C896',
                        sand: '#F7E8C6',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
</head>
<body class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top_left,_rgba(0,200,150,0.18),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(247,232,198,0.8),_transparent_35%),linear-gradient(135deg,#f8fafc,_#fffef7_55%,#edf2f7)] px-4 font-sans">
    <div class="grid w-full max-w-5xl overflow-hidden rounded-[36px] border border-white/60 bg-white/75 shadow-[0_30px_120px_rgba(17,32,59,0.18)] backdrop-blur lg:grid-cols-[1.1fr_.9fr]">
        <div class="bg-[#11203B] p-10 text-white">
            <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-white/10 font-display text-2xl font-bold">T</div>
            <h1 class="mt-8 font-display text-5xl font-semibold leading-tight">Run HR, attendance, and payroll from one calm workspace.</h1>
            <p class="mt-4 max-w-lg text-lg text-slate-200">Built for Bangladesh factories and teams that want cleaner onboarding, payroll review, and subscription-ready operations.</p>
            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-lg font-semibold">Subscription ready</p>
                    <p class="mt-2 text-sm text-slate-200">bKash and Nagad signup flow for new companies.</p>
                </div>
                <div class="rounded-3xl bg-white/10 p-5">
                    <p class="text-lg font-semibold">System admin control</p>
                    <p class="mt-2 text-sm text-slate-200">Activate or deactivate any company from one panel.</p>
                </div>
            </div>
        </div>
        <div class="p-10">
            <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Welcome back</p>
            <h2 class="mt-2 text-3xl font-semibold text-slate-900">Sign in to continue</h2>
            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif
            <form class="mt-8 space-y-5" action="{{ route('login') }}" method="POST">
                @csrf
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-600">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-[#00C896]">
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-600">Password</span>
                    <input name="password" type="password" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-[#00C896]">
                </label>
                @if ($errors->any())
                    <div class="rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-600">{{ $errors->first() }}</div>
                @endif
                <button class="w-full rounded-2xl bg-[#11203B] px-4 py-4 font-semibold text-white shadow-lg shadow-slate-900/10">Login</button>
            </form>
            <div class="mt-6 flex items-center justify-between text-sm text-slate-600">
                <a href="{{ route('landing') }}" class="font-medium hover:text-slate-900">Back to landing page</a>
                <a href="{{ route('register') }}" class="font-medium text-[#11203B] hover:text-black">Create company account</a>
            </div>
            <div class="mt-8 rounded-3xl bg-amber-50 p-5 text-sm text-slate-700">
                <p class="font-semibold">Demo credentials</p>
                <p class="mt-2">Email: `admin@hajipay.test`</p>
                <p>Password: `password`</p>
            </div>
        </div>
    </div>
</body>
</html>
