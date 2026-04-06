@php($heading = 'Shift Settings')
<div class="grid gap-6 xl:grid-cols-[.9fr_1.1fr]">
    <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
        <p class="font-bangla text-lg font-semibold text-brand">শিফট তৈরি করুন</p>
        <div class="mt-4 space-y-4">
            <input wire:model="name" type="text" placeholder="Shift name" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
            <input wire:model="startTime" type="time" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
            <input wire:model="endTime" type="time" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
            <input wire:model="graceMinutes" type="number" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
            <label class="flex items-center gap-3"><input wire:model="isNightShift" type="checkbox"> Night shift</label>
            <button wire:click="save" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">Save Shift</button>
        </div>
    </div>
    <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
        <p class="font-bangla text-lg font-semibold text-brand">Existing Shifts</p>
        <div class="mt-4 space-y-3">
            @foreach ($shifts as $shift)
                <div class="rounded-2xl bg-slate-50 px-4 py-4">
                    <p class="font-semibold">{{ $shift->name }}</p>
                    <p class="text-sm text-slate-500">{{ $shift->start_time }} - {{ $shift->end_time }} • Grace {{ $shift->grace_minutes }} min</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
