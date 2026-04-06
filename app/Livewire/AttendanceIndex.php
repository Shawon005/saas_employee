<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AttendanceIndex extends Component
{
    public string $date;
    public string $view = 'daily';
    public ?int $editingAttendance = null;
    public ?string $newCheckIn = null;
    public ?string $newCheckOut = null;
    public string $reason = '';

    public function mount(): void
    {
        $this->date = now()->toDateString();
    }

    public function openCorrection(int $attendanceId): void
    {
        $record = Attendance::findOrFail($attendanceId);
        $this->editingAttendance = $record->id;
        $this->newCheckIn = optional($record->check_in)->format('Y-m-d\TH:i');
        $this->newCheckOut = optional($record->check_out)->format('Y-m-d\TH:i');
    }

    public function saveCorrection(): void
    {
        $record = Attendance::findOrFail($this->editingAttendance);

        AttendanceCorrection::create([
            'attendance_id' => $record->id,
            'corrected_by' => auth()->id(),
            'old_check_in' => $record->check_in,
            'new_check_in' => $this->newCheckIn ? Carbon::parse($this->newCheckIn) : null,
            'old_check_out' => $record->check_out,
            'new_check_out' => $this->newCheckOut ? Carbon::parse($this->newCheckOut) : null,
            'reason' => $this->reason,
        ]);

        $record->update([
            'check_in' => $this->newCheckIn ? Carbon::parse($this->newCheckIn) : null,
            'check_out' => $this->newCheckOut ? Carbon::parse($this->newCheckOut) : null,
            'note' => $this->reason,
        ]);

        $this->reset(['editingAttendance', 'newCheckIn', 'newCheckOut', 'reason']);
    }

    public function render()
    {
        $query = Attendance::with('worker.department')
            ->where('company_id', auth()->user()->company_id);

        return view('livewire.attendance-index', [
            'records' => $query->whereDate('date', $this->date)->orderBy('check_in')->get(),
            'monthlyRecords' => $query->whereMonth('date', Carbon::parse($this->date)->month)->get()->groupBy('worker_id'),
        ]);
    }
}
