@php($heading = 'Generate Payroll')
<div class="max-w-3xl rounded-[32px] bg-white/85 p-8 shadow-sm">
    <p class="font-bangla text-lg font-semibold text-brand">নতুন পেরোল তৈরি করুন</p>
    <p class="mt-2 text-sm text-slate-500">Draft payroll will be generated for all active workers.</p>
    <div class="mt-6 grid gap-4 md:grid-cols-2">
        <input wire:model="month" type="number" min="1" max="12" class="rounded-2xl bg-slate-100 px-4 py-3" placeholder="Month">
        <input wire:model="year" type="number" class="rounded-2xl bg-slate-100 px-4 py-3" placeholder="Year">
    </div>
    <button wire:click="generate" class="mt-6 rounded-2xl bg-brand px-5 py-3 font-semibold text-white">Generate</button>
    @if ($message)
        <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-emerald-700">{{ $message }}</div>
    @endif
</div>
