<?php

namespace App\Livewire;

use App\Models\Payroll;
use App\Services\PayrollService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PayrollReview extends Component
{
    public int $month;
    public int $year;

    public function mount(int $month, int $year): void
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function updateDeduction(int $payrollId, $value): void
    {
        $payroll = Payroll::findOrFail($payrollId);
        $payroll->total_deductions = (float) $value;
        $payroll->net_payable = $payroll->basic_salary
            + $payroll->house_rent
            + $payroll->medical_allowance
            + $payroll->attendance_bonus
            + $payroll->ot_amount
            + $payroll->friday_holiday_allowance
            - $payroll->total_deductions;
        $payroll->save();
    }

    public function finalize(PayrollService $payrollService): void
    {
        $payrollService->finalize(auth()->user()->company_id, $this->month, $this->year);
    }

    public function render()
    {
        return view('livewire.payroll-review', [
            'payrolls' => Payroll::with('worker.department')
                ->where('company_id', auth()->user()->company_id)
                ->where('month', $this->month)
                ->where('year', $this->year)
                ->get(),
        ]);
    }
}
