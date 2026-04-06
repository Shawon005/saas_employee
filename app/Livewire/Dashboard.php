<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Worker;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $companyId = auth()->user()->company_id;
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth();

        $todayAttendance = Attendance::with('worker')
            ->where('company_id', $companyId)
            ->whereDate('date', $today)
            ->get();

        $weeklyData = Attendance::query()
            ->where('company_id', $companyId)
            ->whereBetween('date', [$monthStart, now()->endOfMonth()])
            ->get()
            ->groupBy(fn ($record) => $record->date->startOfWeek()->format('W'))
            ->map(function ($group, $week) {
                return (object) [
                    'week_number' => $week,
                    'present_count' => $group->whereIn('status', ['Present', 'Late'])->count(),
                    'absent_count' => $group->where('status', 'Absent')->count(),
                    'ot_hours' => $group->sum('ot_hours'),
                ];
            })
            ->values();

        return view('livewire.dashboard', [
            'stats' => [
                'workers' => Worker::where('company_id', $companyId)->count(),
                'present' => $todayAttendance->whereIn('status', ['Present', 'Late', 'Holiday'])->count(),
                'absent' => max(0, Worker::where('company_id', $companyId)->active()->count() - $todayAttendance->count()),
                'late' => $todayAttendance->where('status', 'Late')->count(),
                'ot' => round((float) Attendance::where('company_id', $companyId)->whereMonth('date', now()->month)->sum('ot_hours'), 2),
                'pending_sync' => Attendance::where('company_id', $companyId)->where('synced_from_device', true)->count(),
            ],
            'feed' => $todayAttendance->sortByDesc('updated_at')->take(15),
            'chartData' => $weeklyData,
        ]);
    }
}
