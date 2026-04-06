<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\SalarySetting;
use App\Models\Worker;
use Illuminate\Support\Collection;
use RuntimeException;

class PayrollService
{
    public function generate(int $companyId, int $month, int $year, ?int $generatedBy = null): void
    {
        if (Payroll::where('company_id', $companyId)->where('month', $month)->where('year', $year)->where('status', 'Finalized')->exists()) {
            throw new RuntimeException('Finalized payroll already exists for this month and year.');
        }

        $settings = SalarySetting::where('company_id', $companyId)->firstOrFail();
        $workers = Worker::where('company_id', $companyId)->active()->get();

        foreach ($workers as $worker) {
            $attendance = Attendance::where('worker_id', $worker->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();

            $payload = $this->buildPayrollData($worker, $settings, $attendance);
            $payload['company_id'] = $companyId;
            $payload['generated_by'] = $generatedBy;

            Payroll::updateOrCreate(
                ['worker_id' => $worker->id, 'month' => $month, 'year' => $year],
                $payload + ['month' => $month, 'year' => $year]
            );
        }
    }

    public function buildPayrollData(Worker $worker, SalarySetting $settings, Collection $attendance): array
    {
        $daysPresent = $attendance->whereIn('status', ['Present', 'Late'])->count();
        $lateCount = $attendance->where('status', 'Late')->count();
        $holidayDays = $attendance->where('status', 'Holiday')->count();
        $totalOtHours = (float) $attendance->sum('ot_hours');
        $otRate = ((float) $worker->basic_salary / max(1, $settings->ot_divisor)) * (float) $settings->ot_multiplier;
        $otAmount = round($otRate * $totalOtHours, 2);
        $attendanceBonus = $lateCount === 0 && $worker->attendance_bonus_eligible ? (float) $settings->attendance_bonus_amount : 0;
        $dailyRate = (float) $worker->basic_salary / 26;
        $holidayAllowance = round($dailyRate * $holidayDays, 2);
        $gross = (float) $worker->basic_salary
            + (float) $worker->house_rent
            + (float) $worker->medical_allowance
            + $attendanceBonus
            + $otAmount
            + $holidayAllowance;

        return [
            'total_days_present' => $daysPresent,
            'total_late_count' => $lateCount,
            'total_ot_hours' => round($totalOtHours, 2),
            'basic_salary' => $worker->basic_salary,
            'house_rent' => $worker->house_rent,
            'medical_allowance' => $worker->medical_allowance,
            'attendance_bonus' => $attendanceBonus,
            'ot_amount' => $otAmount,
            'friday_holiday_allowance' => $holidayAllowance,
            'total_deductions' => 0,
            'net_payable' => round($gross, 2),
            'status' => 'Draft',
        ];
    }

    public function finalize(int $companyId, int $month, int $year): void
    {
        Payroll::where('company_id', $companyId)
            ->where('month', $month)
            ->where('year', $year)
            ->where('status', 'Draft')
            ->update([
                'status' => 'Finalized',
                'finalized_at' => now(),
            ]);
    }
}
