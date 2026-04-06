@php($heading = 'Payroll')
<div class="space-y-6">
    <div class="flex items-center justify-between rounded-[32px] bg-white/85 p-6 shadow-sm">
        <div>
            <p class="font-bangla text-lg font-semibold text-brand">পেরোল রানসমূহ</p>
            <p class="text-sm text-slate-500">Review payroll batches and payslips</p>
        </div>
        <a href="{{ route('payroll.generate') }}" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">Generate Payroll</a>
    </div>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($payrolls as $payroll)
            <div class="rounded-[30px] bg-white/85 p-6 shadow-sm">
                <p class="text-sm text-slate-500">{{ $payroll->worker->name }}</p>
                <p class="mt-2 text-2xl font-semibold text-brand">{{ $payroll->month }}/{{ $payroll->year }}</p>
                <p class="mt-2 text-sm text-slate-500">Net payable BDT {{ number_format($payroll->net_payable, 2) }}</p>
                <div class="mt-5 flex gap-3">
                    <a href="{{ route('payroll.review', [$payroll->month, $payroll->year]) }}" class="rounded-2xl bg-slate-100 px-4 py-3 text-sm">Review</a>
                    <a href="{{ route('payroll.slip', $payroll) }}" class="rounded-2xl bg-amber-100 px-4 py-3 text-sm text-amber-800">Slip</a>
                </div>
            </div>
        @endforeach
    </div>
    <div>{{ $payrolls->links() }}</div>
</div>
