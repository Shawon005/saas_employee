<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Worker;
use App\Models\Payroll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_loads_landing_page(): void
    {
        $this->get('/')->assertSuccessful()->assertSee('A cleaner employees platform');
    }

    public function test_login_page_loads(): void
    {
        $this->get('/login')->assertSuccessful()->assertSee('Sign in to continue');
    }

    public function test_authenticated_user_can_load_dashboard(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create([
            'company_id' => $company->id,
            'role' => 'super_admin',
        ]);

        $this->actingAs($user)->get('/dashboard')->assertSuccessful()->assertSee('Operations Hub');
    }

    public function test_authenticated_user_can_load_reports_page(): void
    {
        $company = Company::factory()->create();
        $department = Department::factory()->create(['company_id' => $company->id]);
        $shift = Shift::factory()->create(['company_id' => $company->id]);
        $user = User::factory()->create([
            'company_id' => $company->id,
            'role' => 'super_admin',
        ]);
        $worker = Worker::factory()->create([
            'company_id' => $company->id,
            'department_id' => $department->id,
            'shift_id' => $shift->id,
        ]);

        Attendance::create([
            'worker_id' => $worker->id,
            'company_id' => $company->id,
            'date' => now()->toDateString(),
            'check_in' => now()->subHours(9),
            'check_out' => now(),
            'status' => 'Present',
            'regular_hours' => 8,
            'ot_hours' => 1.5,
            'late_minutes' => 0,
        ]);

        $this->actingAs($user)->get('/reports')->assertSuccessful()->assertSee('Attendance Summary');
    }

    public function test_payroll_slip_route_does_not_conflict_with_payroll_review_route(): void
    {
        $company = Company::factory()->create();
        $department = Department::factory()->create(['company_id' => $company->id]);
        $shift = Shift::factory()->create(['company_id' => $company->id]);
        $user = User::factory()->create([
            'company_id' => $company->id,
            'role' => 'super_admin',
        ]);
        $worker = Worker::factory()->create([
            'company_id' => $company->id,
            'department_id' => $department->id,
            'shift_id' => $shift->id,
        ]);
        $payroll = Payroll::factory()->create([
            'worker_id' => $worker->id,
            'company_id' => $company->id,
            'generated_by' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('payroll.slip', $payroll))
            ->assertSuccessful();
    }
}
