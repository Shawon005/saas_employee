<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOrbit Employees System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#11203B',
                        mint: '#00C896',
                        sun: '#F0B429',
                        shell: '#FFF9EE',
                    },
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
</head>
<body class="bg-[linear-gradient(180deg,#fffef8_0%,#f7fbff_55%,#eef5f7_100%)] font-sans text-slate-800">
    <div class="absolute inset-x-0 top-0 -z-10 h-[520px] bg-[radial-gradient(circle_at_top_left,_rgba(240,180,41,0.28),_transparent_28%),radial-gradient(circle_at_top_right,_rgba(0,200,150,0.18),_transparent_22%)]"></div>

    <header class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-10">
        <div>
            <p class="font-display text-2xl font-bold text-ink">TechOrbit</p>
            <p class="text-sm text-slate-500">Smart employee management for factories and companies without attendance machines</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="rounded-full border border-slate-200 px-5 py-2 text-sm font-semibold text-slate-700">Login</a>
            <a href="{{ route('register') }}" class="rounded-full bg-ink px-5 py-2 text-sm font-semibold text-white">Register</a>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 pb-20 lg:px-10">
        <section class="grid items-center gap-10 py-10 lg:grid-cols-[1.05fr_.95fr] lg:py-16">
            <div>
                <span class="inline-flex rounded-full bg-white/90 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-slate-600 shadow-sm">Hero Banner</span>
                <h1 class="mt-6 max-w-3xl font-display text-5xl font-bold leading-tight text-ink lg:text-7xl">Manage employee attendance with QR scan and skip expensive attendance machines.</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">We provide a proper system for companies and factories to manage employees, track attendance, run payroll, and control daily operations. Workers scan their own QR for attendance, so your company does not need to buy costly biometric or punch machines and can save a lot of money.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="rounded-full bg-mint px-6 py-3 font-semibold text-white shadow-[0_20px_40px_rgba(0,200,150,0.25)]">Start registration</a>
                    <a href="#plans" class="rounded-full border border-slate-200 bg-white px-6 py-3 font-semibold text-slate-700">View subscriptions</a>
                </div>
                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm">
                        <p class="text-3xl font-bold text-ink">1</p>
                        <p class="mt-2 text-sm text-slate-500">Register your company and create the admin account</p>
                    </div>
                    <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm">
                        <p class="text-3xl font-bold text-ink">2</p>
                        <p class="mt-2 text-sm text-slate-500">Activate subscription with bKash or Nagad payment</p>
                    </div>
                    <div class="rounded-3xl border border-white/70 bg-white/80 p-5 shadow-sm">
                        <p class="text-3xl font-bold text-ink">3</p>
                        <p class="mt-2 text-sm text-slate-500">System admin verifies payment and activates your company</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-8 top-10 h-28 w-28 rounded-full bg-sun/20 blur-3xl"></div>
                <div class="absolute right-0 top-0 h-40 w-40 rounded-full bg-mint/20 blur-3xl"></div>
                <div class="relative overflow-hidden rounded-[36px] border border-white/80 bg-[#11203B] p-8 text-white shadow-[0_30px_100px_rgba(17,32,59,0.28)]">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-white/10 p-5">
                            <p class="text-sm uppercase tracking-[0.2em] text-white/60">Live ops</p>
                            <p class="mt-4 text-3xl font-bold">Attendance</p>
                            <p class="mt-2 text-sm text-slate-200">Employees scan QR codes for daily attendance, so companies can run attendance without extra hardware machines.</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-5">
                            <p class="text-sm uppercase tracking-[0.2em] text-white/60">Finance</p>
                            <p class="mt-4 text-3xl font-bold">Payroll</p>
                            <p class="mt-2 text-sm text-slate-200">Track salary, overtime, and monthly payroll in one proper system for factory and company teams.</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-5 sm:col-span-2">
                            <p class="text-sm uppercase tracking-[0.2em] text-white/60">Subscription system</p>
                            <p class="mt-4 text-4xl font-bold">Save money with smart setup</p>
                            <p class="mt-2 max-w-lg text-sm text-slate-200">New companies can register, submit bKash or Nagad payment details, and start with a system that reduces machine cost while improving employee management.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-10">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Why companies choose it</p>
                    <h2 class="mt-3 font-display text-3xl font-bold text-ink">No machine needed</h2>
                    <p class="mt-4 text-slate-600">Your company can use employee QR scanning for attendance instead of buying expensive attendance devices or maintaining biometric hardware.</p>
                </div>
                <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Cost saving</p>
                    <h2 class="mt-3 font-display text-3xl font-bold text-ink">Save a lot of money</h2>
                    <p class="mt-4 text-slate-600">Factories and companies can reduce setup cost, avoid machine repair issues, and keep attendance records in one digital workflow.</p>
                </div>
                <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Full management</p>
                    <h2 class="mt-3 font-display text-3xl font-bold text-ink">Proper employee system</h2>
                    <p class="mt-4 text-slate-600">From attendance to payroll and reporting, this is a proper employee management system for any company or factory that wants cleaner operations.</p>
                </div>
            </div>
        </section>

        <section id="plans" class="py-10">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Subscription system</p>
                    <h2 class="mt-2 font-display text-4xl font-bold text-ink">Choose the plan that fits your company</h2>
                </div>
                <p class="max-w-xl text-slate-600">Each plan includes QR attendance, payroll, and a company admin account. Registration remains pending until payment is reviewed by the system admin.</p>
            </div>
            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-500">{{ $plan['workers'] }}</p>
                        <h3 class="mt-3 font-display text-3xl font-bold text-ink">{{ $plan['name'] }}</h3>
                        <p class="mt-4 text-4xl font-bold text-ink">৳{{ number_format($plan['price']) }}<span class="text-lg font-medium text-slate-500">/{{ $plan['cycle'] }}</span></p>
                        <div class="mt-6 space-y-3 text-sm text-slate-600">
                            @foreach ($plan['features'] as $feature)
                                <p class="rounded-2xl bg-shell px-4 py-3">{{ $feature }}</p>
                            @endforeach
                        </div>
                        <a href="{{ route('register', ['plan' => strtolower($plan['name'])]) }}" class="mt-8 inline-flex rounded-full bg-ink px-5 py-3 font-semibold text-white">Select {{ $plan['name'] }}</a>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>
