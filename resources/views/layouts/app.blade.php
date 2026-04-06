<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TechOrbit Employees Management' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#1A2340',
                        accent: '#00C896',
                        warn: '#F59E0B',
                        danger: '#EF4444',
                        paper: '#F8FAFC',
                    },
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                        bangla: ['Hind Siliguri', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    @livewireStyles
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_right,_rgba(245,158,11,0.28),_transparent_24%),linear-gradient(135deg,#f3f4f6,_#fff9e6_45%,#f8fafc_100%)] font-sans text-slate-800">
    @php
        $user = auth()->user();
        $links = $user->isSystemAdmin()
            ? [
                ['route' => 'system-admin.companies', 'label' => 'কোম্পানি তালিকা', 'sub' => 'System Admin'],
            ]
            : [
                ['route' => 'dashboard', 'label' => 'ড্যাশবোর্ড', 'sub' => 'Dashboard'],
                ['route' => 'workers.index', 'label' => 'শ্রমিক', 'sub' => 'Workers'],
                ['route' => 'attendance.index', 'label' => 'উপস্থিতি', 'sub' => 'Attendance'],
                ['route' => 'payroll.index', 'label' => 'বেতন', 'sub' => 'Payroll'],
                ['route' => 'reports.index', 'label' => 'রিপোর্ট', 'sub' => 'Reports'],
                ['route' => 'settings.index', 'label' => 'সেটিংস', 'sub' => 'Settings'],
            ];
    @endphp

    <div class="flex min-h-screen">
        <aside class="hidden w-72 border-r border-white/60 bg-white/70 px-6 py-8 backdrop-blur xl:block">
            <div class="mb-10 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand font-display text-lg font-bold text-white">T</div>
                <div>
                    <p class="font-display text-xl font-semibold text-brand">TechOrbit</p>
                    <p class="font-bangla text-sm text-slate-500">
                        {{ $user->isSystemAdmin() ? 'সিস্টেম অ্যাডমিন কন্ট্রোল' : 'অ্যাটেনডেন্স ও পেরোল ওয়ার্কস্পেস' }}
                    </p>
                </div>
            </div>
            <nav class="space-y-2 text-sm">
                @foreach ($links as $link)
                    @continue($link['route'] === 'settings.index' && ! $user->hasRole('super_admin'))
                    <a href="{{ route($link['route']) }}" class="{{ request()->routeIs($link['route']) ? 'bg-brand text-white shadow-lg shadow-brand/20' : 'text-slate-600 hover:bg-white' }} flex items-center justify-between rounded-2xl px-4 py-3 transition">
                        <span class="font-bangla">{{ $link['label'] }}</span>
                        <span class="text-xs opacity-80">{{ $link['sub'] }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="mt-10 rounded-3xl bg-brand p-5 text-white shadow-2xl shadow-brand/20">
                <p class="font-bangla text-lg font-semibold">{{ $user->isSystemAdmin() ? 'আজকের সিস্টেম ফোকাস' : 'আজকের ফোকাস' }}</p>
                <p class="mt-2 font-bangla text-sm text-slate-200">
                    {{ $user->isSystemAdmin() ? 'রেজিস্ট্রেশন দেখুন, সাবস্ক্রিপশন যাচাই করুন, এবং সব কোম্পানির অ্যাক্সেস নিয়ন্ত্রণ করুন।' : 'ফ্যাক্টরি ফ্লোর স্ক্যান, লাইভ ওটি ট্র্যাকিং, এবং পেরোল রিভিউ এক জায়গায়।' }}
                </p>
            </div>
        </aside>

        <main class="flex-1 p-4 md:p-8">
            <div class="mx-auto max-w-7xl">
                <div class="mb-8 flex flex-col gap-4 rounded-[32px] border border-white/70 bg-white/70 px-6 py-5 shadow-[0_20px_80px_rgba(245,158,11,0.12)] backdrop-blur md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="font-bangla text-sm text-slate-500">{{ $user->isSystemAdmin() ? 'প্ল্যাটফর্ম কন্ট্রোল' : 'টেকঅরবিট' }}</p>
                        <h1 class="font-bangla text-3xl font-semibold text-brand">{{ $heading ?? 'অপারেশনস হাব' }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="rounded-2xl bg-white px-4 py-3 shadow-sm">
                            <p class="font-bangla text-xs text-slate-500">{{ $user->isSystemAdmin() ? 'সিস্টেম অ্যাডমিন' : 'লগইন করা আছে' }}</p>
                            <p class="font-semibold">{{ $user->name }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="rounded-2xl bg-brand px-5 py-3 font-bangla text-sm font-semibold text-white">Logout</button>
                        </form>
                    </div>
                </div>
                {{ $slot }}
            </div>
        </main>
    </div>
    @livewireScripts
</body>
</html>
