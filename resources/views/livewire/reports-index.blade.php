@php($heading = 'Reports')
<div class="space-y-6">
    <div class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <p class="font-bangla text-lg font-semibold text-brand">OT Report</p>
            <div class="mt-4 space-y-3">
                @foreach ($otReport->take(6) as $item)
                    <div class="flex justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span>{{ $item->worker->name }}</span>
                        <span>{{ number_format($item->ot_hours, 2) }} hrs</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <p class="font-bangla text-lg font-semibold text-brand">Late Report</p>
            <div class="mt-4 space-y-3">
                @foreach ($lateReport->take(6) as $item)
                    <div class="flex justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span>{{ $item->worker->name }}</span>
                        <span>{{ $item->late_minutes }} min</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <p class="font-bangla text-lg font-semibold text-brand">Attendance Summary</p>
            <div class="mt-4 space-y-3">
                @foreach ($summary as $item)
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <p class="font-semibold">{{ $item->department_name }}</p>
                        <p class="text-sm text-slate-500">Records {{ $item->total_records }} • OT {{ number_format($item->total_ot, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
