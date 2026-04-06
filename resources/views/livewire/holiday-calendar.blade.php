@php($heading = 'Holiday Calendar')
<div class="grid gap-6 xl:grid-cols-[.9fr_1.1fr]">
    <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
        <p class="font-bangla text-lg font-semibold text-brand">হলিডে সেট করুন</p>
        <div class="mt-4 space-y-4">
            <input wire:model="name" type="text" placeholder="Holiday name" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
            <input wire:model="date" type="date" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
            <select wire:model="type" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                <option value="PublicHoliday">Public Holiday</option>
                <option value="WeeklyOff">Weekly Off</option>
            </select>
            <label class="flex items-center gap-3"><input wire:model="isDoublePay" type="checkbox"> Double pay allowance</label>
            <button wire:click="save" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">Save Holiday</button>
        </div>
    </div>
    <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
        <p class="font-bangla text-lg font-semibold text-brand">Holiday List</p>
        <div class="mt-4 space-y-3">
            @foreach ($holidays as $holiday)
                <div class="rounded-2xl bg-slate-50 px-4 py-4">
                    <p class="font-semibold">{{ $holiday->name }}</p>
                    <p class="text-sm text-slate-500">{{ $holiday->date->format('d M Y') }} • {{ $holiday->type }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
