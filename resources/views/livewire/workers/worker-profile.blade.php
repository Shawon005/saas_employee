@php($heading = 'Worker Profile')
<div class="space-y-6">
    <div class="grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <div class="flex items-center gap-5">
                <div class="h-24 w-24 overflow-hidden rounded-[28px] bg-amber-100">
                     <img src="{{ asset($storageUrl($worker->photo)) }}" class="h-full w-full object-cover">
                </div>
                <div>
                    <p class="text-3xl font-semibold text-brand">{{ $worker->name }}</p>
                    <p class="mt-2 text-slate-500">{{ $worker->emp_id }} • {{ $worker->grade }}</p>
                    <p class="text-slate-500">{{ $worker->department->name }} • {{ $worker->shift->name }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-[32px] bg-brand p-6 text-white shadow-xl shadow-brand/20">
            <p class="font-bangla text-lg font-semibold">Quick Actions</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('workers.id-card', $worker) }}" class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-brand">Print QR Card</a>
                <a href="{{ route('workers.qr', $worker) }}" class="rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white">View QR</a>
            </div>
        </div>
    </div>

    <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
        <p class="font-bangla text-lg font-semibold text-brand">Attendance Heatmap</p>
        <div class="mt-4 grid grid-cols-7 gap-3 md:grid-cols-10 xl:grid-cols-15">
            @for ($day = 1; $day <= now()->daysInMonth; $day++)
                @php($dateKey = now()->startOfMonth()->day($day)->format('Y-m-d'))
                @php($record = $attendanceMap->get($dateKey))
                <div class="rounded-2xl p-3 text-center text-sm {{ match(optional($record)->status) {
                    'Present' => 'bg-emerald-50 text-emerald-700',
                    'Late' => 'bg-amber-50 text-amber-700',
                    'Holiday' => 'bg-sky-50 text-sky-700',
                    'Absent' => 'bg-red-50 text-red-700',
                    default => 'bg-slate-100 text-slate-500'
                } }}">
                    <p class="font-semibold">{{ $day }}</p>
                    <p>{{ optional($record)->status ? substr($record->status, 0, 1) : '-' }}</p>
                </div>
            @endfor
        </div>
    </div>

    <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
        <p class="font-bangla text-lg font-semibold text-brand">Payroll History</p>
        <div class="mt-4 space-y-3">
            @foreach ($payrolls as $payroll)
                <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-4">
                    <div>
                        <p class="font-semibold">{{ $payroll->month }}/{{ $payroll->year }}</p>
                        <p class="text-sm text-slate-500">Net payable BDT {{ number_format($payroll->net_payable, 2) }}</p>
                    </div>
                    <a href="{{ route('payroll.slip', $payroll) }}" class="rounded-2xl bg-brand px-4 py-3 text-sm font-semibold text-white">Download Slip</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
