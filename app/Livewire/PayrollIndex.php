<?php

namespace App\Livewire;

use App\Models\Payroll;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PayrollIndex extends Component
{
    public function render()
    {
        return view('livewire.payroll-index', [
            'payrolls' => Payroll::with('worker')
                ->where('company_id', auth()->user()->company_id)
                ->latest('year')
                ->latest('month')
                ->paginate(12),
        ]);
    }
}
