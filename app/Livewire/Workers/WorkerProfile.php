<?php

namespace App\Livewire\Workers;

use App\Models\Payroll;
use App\Models\Worker;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
#[Layout('layouts.app')]
class WorkerProfile extends Component
{
    public Worker $worker;

    public function mount(Worker $worker): void
    {
        $this->worker = $worker->load(['department', 'shift', 'attendanceRecords', 'company']);
    }

    public function render()
    {
        $monthAttendance = $this->worker->attendanceRecords()
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get()
            ->keyBy(fn ($record) => $record->date->format('Y-m-d'));

        return view('livewire.workers.worker-profile', [
            'attendanceMap' => $monthAttendance,
            'payrolls' => Payroll::where('worker_id', $this->worker->id)->latest('year')->latest('month')->get(),
             'storageUrl' => fn (?string $path) => $path ? Storage::url($path) : null,
        ]);
    }
}
