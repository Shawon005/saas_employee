<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\Department;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\SalarySetting;
use App\Models\Shift;
use App\Models\User;
use App\Models\Worker;
use App\Services\PayrollService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::factory()->create([
            'name' => 'Dhaka Garments Ltd.',
            'address' => 'Plot 17, Tejgaon Industrial Area, Dhaka',
            'phone' => '+8801712345678',
            'is_active' => true,
            'subscription_plan' => 'Enterprise',
            'subscription_status' => 'active',
            'billing_cycle' => 'Monthly',
            'subscription_starts_at' => now()->subDays(15),
            'subscription_ends_at' => now()->addDays(15),
        ]);

        $salarySetting = SalarySetting::factory()->create(['company_id' => $company->id]);

        User::factory()->create([
            'company_id' => null,
            'name' => 'System Admin',
            'email' => 'system@hajipay.test',
            'role' => 'viewer',
            'is_system_admin' => true,
            'password' => 'password',
        ]);

        User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Super Admin',
            'email' => 'admin@hajipay.test',
            'role' => 'super_admin',
            'password' => 'password',
        ]);

        User::factory()->create([
            'company_id' => $company->id,
            'name' => 'HR Manager',
            'email' => 'hr@hajipay.test',
            'role' => 'hr_manager',
            'password' => 'password',
        ]);

        $supervisor = User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Floor Supervisor',
            'email' => 'supervisor@hajipay.test',
            'role' => 'supervisor',
            'password' => 'password',
        ]);

        $departments = collect(['Cutting', 'Sewing', 'Finishing', 'Quality', 'Admin'])
            ->map(fn ($name) => Department::factory()->create(['company_id' => $company->id, 'name' => $name]));

        $shifts = collect([
            ['name' => 'Morning', 'start_time' => '08:00:00', 'end_time' => '17:00:00', 'is_night_shift' => false],
            ['name' => 'Evening', 'start_time' => '14:00:00', 'end_time' => '22:00:00', 'is_night_shift' => false],
            ['name' => 'Night', 'start_time' => '22:00:00', 'end_time' => '06:00:00', 'is_night_shift' => true],
        ])->map(fn ($shift) => Shift::factory()->create(['company_id' => $company->id] + $shift));

        $workers = collect(range(1, 50))->map(function () use ($company, $departments, $shifts, $salarySetting) {
            $department = $departments->random();
            $shift = $shifts->random();
            $worker = Worker::factory()->create([
                'company_id' => $company->id,
                'department_id' => $department->id,
                'shift_id' => $shift->id,
            ]);

            $worker->update([
                'house_rent' => round($worker->basic_salary * ($salarySetting->house_rent_percent / 100), 2),
                'medical_allowance' => $salarySetting->medical_allowance_fixed,
            ]);

            return $worker->refresh();
        });

        Holiday::factory()->create([
            'company_id' => $company->id,
            'name' => 'Victory Day',
            'date' => now()->subMonth()->startOfMonth()->addDays(15),
            'type' => 'PublicHoliday',
            'is_double_pay' => true,
        ]);

        foreach ($workers as $worker) {
            for ($i = 0; $i < 90; $i++) {
                $date = Carbon::today()->subDays($i);
                $status = collect(['Present', 'Present', 'Late', 'Absent', 'Holiday'])->random();
                $checkIn = $status === 'Absent' ? null : $date->copy()->setTime(8, fake()->numberBetween(0, 35));
                $checkOut = $checkIn ? $checkIn->copy()->addHours(fake()->numberBetween(8, 11)) : null;

                Attendance::create([
                    'worker_id' => $worker->id,
                    'company_id' => $company->id,
                    'date' => $date->toDateString(),
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                    'is_night_shift' => $worker->shift->is_night_shift,
                    'regular_hours' => $checkIn ? 8 : 0,
                    'ot_hours' => $checkIn ? fake()->randomFloat(2, 0, 3) : 0,
                    'late_minutes' => $status === 'Late' ? fake()->numberBetween(5, 30) : 0,
                    'scanned_by' => $supervisor->id,
                    'synced_from_device' => fake()->boolean(10),
                ]);
            }
        }

        $payrollService = app(PayrollService::class);
        $payrollService->generate($company->id, now()->subMonth()->month, now()->subMonth()->year, $supervisor->id);
        $payrollService->generate($company->id, now()->subMonths(2)->month, now()->subMonths(2)->year, $supervisor->id);

        Payroll::where('company_id', $company->id)
            ->whereIn('month', [now()->subMonth()->month, now()->subMonths(2)->month])
            ->update(['status' => 'Finalized', 'finalized_at' => now()]);
    }
}
