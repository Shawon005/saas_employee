@php($heading = 'Payroll Review')
<div class="space-y-6">
    <div class="flex items-center justify-between rounded-[32px] bg-white/85 p-6 shadow-sm">
        <div>
            <p class="font-bangla text-lg font-semibold text-brand">বেতন রিভিউ</p>
            <p class="text-sm text-slate-500">{{ $month }}/{{ $year }} payroll batch</p>
        </div>
        <button wire:click="finalize" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">Finalize Payroll</button>
    </div>
    <div class="overflow-hidden rounded-[32px] bg-white/85 shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-4">Worker</th>
                    <th class="px-4 py-4">Days</th>
                    <th class="px-4 py-4">Late</th>
                    <th class="px-4 py-4">OT</th>
                    <th class="px-4 py-4">Basic</th>
                    <th class="px-4 py-4">Deductions</th>
                    <th class="px-4 py-4">Net</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $payroll)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-4">{{ $payroll->worker->name }}</td>
                        <td class="px-4 py-4">{{ $payroll->total_days_present }}</td>
                        <td class="px-4 py-4">{{ $payroll->total_late_count }}</td>
                        <td class="px-4 py-4">{{ number_format($payroll->total_ot_hours, 2) }}</td>
                        <td class="px-4 py-4">{{ number_format($payroll->basic_salary, 2) }}</td>
                        <td class="px-4 py-4">
                            <input type="number" step="0.01" value="{{ $payroll->total_deductions }}" wire:change="updateDeduction({{ $payroll->id }}, $event.target.value)" class="w-28 rounded-xl bg-slate-100 px-3 py-2">
                        </td>
                        <td class="px-4 py-4 font-semibold text-brand">{{ number_format($payroll->net_payable, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
