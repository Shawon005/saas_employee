<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Company | TechOrbit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#11203B',
                        mint: '#00C896',
                        shell: '#FFF9EE',
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
</head>
<body class="bg-[radial-gradient(circle_at_top_left,_rgba(0,200,150,0.15),_transparent_25%),linear-gradient(180deg,#fffef8_0%,#f3f8fb_100%)] font-sans text-slate-800">
    <div class="mx-auto max-w-7xl px-6 py-10 lg:px-10">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="font-display text-2xl font-bold text-ink">TechOrbit</p>
                <p class="font-bangla text-sm text-slate-500">সাবস্ক্রিপশন পেমেন্টসহ কোম্পানি রেজিস্ট্রেশন</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="rounded-full border border-slate-200 bg-white px-5 py-2 font-bangla text-sm font-semibold text-slate-700">ল্যান্ডিং পেইজ</a>
                <a href="{{ route('login') }}" class="rounded-full bg-ink px-5 py-2 font-bangla text-sm font-semibold text-white">লগইন</a>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[1.05fr_.95fr]">
            <div class="rounded-[36px] bg-[#11203B] p-8 text-white shadow-[0_30px_100px_rgba(17,32,59,0.25)]">
                <span class="inline-flex rounded-full bg-white/10 px-4 py-2 font-bangla text-xs font-semibold tracking-[0.15em] text-white/70">রেজিস্ট্রেশন</span>
                <h1 class="mt-6 font-bangla text-5xl font-bold leading-tight">একটি ফ্লোতেই কোম্পানি রেজিস্টার করুন এবং পেমেন্ট জমা দিন।</h1>
                <p class="mt-4 max-w-xl font-bangla text-lg text-slate-200">কোম্পানির মালিকের অ্যাকাউন্ট তৈরি করুন, সাবস্ক্রিপশন প্যাকেজ বেছে নিন, বিকাশ বা নগদে পেমেন্ট পাঠান, তারপর সিস্টেম অ্যাডমিন অনুমোদনের জন্য অপেক্ষা করুন।</p>

                <div class="mt-8 space-y-4">
                    <div class="rounded-3xl bg-white/10 p-5">
                        <p class="font-bangla text-sm tracking-[0.12em] text-white/60">বিকাশ মার্চেন্ট</p>
                        <p class="mt-2 text-2xl font-bold">{{ $paymentNumbers['bkash'] }}</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5">
                        <p class="font-bangla text-sm tracking-[0.12em] text-white/60">নগদ মার্চেন্ট</p>
                        <p class="mt-2 text-2xl font-bold">{{ $paymentNumbers['nagad'] }}</p>
                    </div>
                </div>

                <div class="mt-8 rounded-3xl bg-[#0b1730] p-5">
                    <p class="font-bangla text-lg font-semibold">অনুমোদন যেভাবে কাজ করে</p>
                    <div class="mt-4 space-y-3 font-bangla text-sm text-slate-300">
                        <p>1. কোম্পানি এবং মালিকের তথ্য পূরণ করুন।</p>
                        <p>2. একটি সাবস্ক্রিপশন প্যাকেজ বেছে নিন।</p>
                        <p>3. বিকাশ বা নগদে পেমেন্ট পাঠিয়ে ট্রানজেকশন আইডি দিন।</p>
                        <p>4. সিস্টেম অ্যাডমিন কোম্পানি রিভিউ করে লগইন অ্যাক্সেস চালু করবে।</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[36px] border border-white/70 bg-white/85 p-8 shadow-sm">
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 font-bangla text-sm text-red-600">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('register.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <h2 class="font-bangla text-xl font-semibold text-ink">কোম্পানির তথ্য</h2>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <label class="block md:col-span-2">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">কোম্পানির নাম</span>
                                <input name="company_name" value="{{ old('company_name') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">কোম্পানির ফোন</span>
                                <input name="company_phone" value="{{ old('company_phone') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">কোম্পানির ঠিকানা</span>
                                <input name="company_address" value="{{ old('company_address') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                        </div>
                    </div>

                    <div>
                        <h2 class="font-bangla text-xl font-semibold text-ink">মালিকের অ্যাকাউন্ট</h2>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">মালিকের নাম</span>
                                <input name="owner_name" value="{{ old('owner_name') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">মালিকের ফোন</span>
                                <input name="owner_phone" value="{{ old('owner_phone') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">মালিকের ইমেইল</span>
                                <input name="owner_email" type="email" value="{{ old('owner_email') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">পাসওয়ার্ড</span>
                                <input name="password" type="password" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                            <label class="block md:col-span-2">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">পাসওয়ার্ড নিশ্চিত করুন</span>
                                <input name="password_confirmation" type="password" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                        </div>
                    </div>

                    <div>
                        <h2 class="font-bangla text-xl font-semibold text-ink">সাবস্ক্রিপশন এবং পেমেন্ট</h2>
                        <div class="mt-4 grid gap-4">
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">প্যাকেজ নির্বাচন করুন</span>
                                <select name="package" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                                    @foreach ($packages as $key => $package)
                                        <option value="{{ $key }}" @selected(old('package', request('plan') === 'starter' ? 'starter_monthly' : (request('plan') === 'growth' ? 'growth_monthly' : (request('plan') === 'enterprise' ? 'enterprise_monthly' : ''))) === $key)>
                                            {{ $package['plan'] }} - {{ $package['billing_cycle'] }} - ৳{{ number_format($package['amount']) }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <div class="grid gap-4 md:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">পেমেন্ট মাধ্যম</span>
                                    <select name="payment_method" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                                        <option value="bkash" @selected(old('payment_method') === 'bkash')>bKash</option>
                                        <option value="nagad" @selected(old('payment_method') === 'nagad')>Nagad</option>
                                    </select>
                                </label>
                                <label class="block">
                                    <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">আপনার পেমেন্ট নম্বর</span>
                                    <input name="payment_number" value="{{ old('payment_number') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                                </label>
                            </div>
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">ট্রানজেকশন আইডি</span>
                                <input name="transaction_id" value="{{ old('transaction_id') }}" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 uppercase outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">
                            </label>
                            <label class="block">
                                <span class="mb-2 block font-bangla text-sm font-medium text-slate-600">সিস্টেম অ্যাডমিনের জন্য নোট</span>
                                <textarea name="note" rows="4" class="w-full rounded-2xl border-0 bg-slate-100 px-4 py-4 outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-mint">{{ old('note') }}</textarea>
                            </label>
                        </div>
                    </div>

                    <button class="w-full rounded-2xl bg-ink px-5 py-4 font-bangla text-base font-semibold text-white shadow-[0_20px_40px_rgba(17,32,59,0.2)]">রেজিস্ট্রেশন জমা দিন</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
