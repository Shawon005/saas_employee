<?php

namespace App\Livewire;

use App\Models\Attendance;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ReportsIndex extends Component
{
    public int $month;
    public int $year;

    public function mount(): void
    {
        $this->month = now()->month;
        $this->year = now()->year;
    }

    public function render()
    {
        $baseQuery = Attendance::with('worker.department')
            ->where('attendance.company_id', auth()->user()->company_id)
            ->whereMonth('attendance.date', $this->month)
            ->whereYear('attendance.date', $this->year);

        return view('livewire.reports-index', [
            'otReport' => (clone $baseQuery)->orderByDesc('ot_hours')->get(),
            'lateReport' => (clone $baseQuery)->where('status', 'Late')->orderByDesc('late_minutes')->get(),
            'summary' => (clone $baseQuery)
                ->join('workers', 'attendance.worker_id', '=', 'workers.id')
                ->join('departments', 'workers.department_id', '=', 'departments.id')
                ->selectRaw('departments.name as department_name')
                ->selectRaw('workers.department_id as department_id')
                ->selectRaw('COUNT(attendance.id) as total_records')
                ->selectRaw('SUM(attendance.ot_hours) as total_ot')
                ->groupBy('workers.department_id')
                ->groupBy('departments.name')
                ->get(),
        ]);
    }
}
