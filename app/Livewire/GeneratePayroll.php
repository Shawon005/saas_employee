<?php

namespace App\Livewire;

use App\Services\PayrollService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class GeneratePayroll extends Component
{
    public int $month;
    public int $year;
    public ?string $message = null;

    public function mount(): void
    {
        $this->month = now()->month;
        $this->year = now()->year;
    }

    public function generate(PayrollService $payrollService): void
    {
        $payrollService->generate(auth()->user()->company_id, $this->month, $this->year, auth()->id());
        $this->message = 'Payroll generated successfully.';
    }

    public function render()
    {
        return view('livewire.generate-payroll');
    }
}
