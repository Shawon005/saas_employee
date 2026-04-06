<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AttendanceService
{
    public function processScan(string $qrToken, int $supervisorId, ?Carbon $scannedAt = null): array
    {
        $timezone = config('app.timezone', 'Asia/Dhaka');
        $scannedAt = ($scannedAt ?? now($timezone))->copy()->timezone($timezone);

        $worker = Worker::with(['shift', 'company.salarySetting'])->where('qr_code_token', $qrToken)->first();

        if (! $worker) {
            throw new ModelNotFoundException('Worker not found for the given QR token.');
        }

        $shift = $worker->shift;
        $attendanceDate = $this->resolveAttendanceDate($shift->is_night_shift, $shift->start_time, $scannedAt);

        $record = Attendance::firstOrNew([
            'worker_id' => $worker->id,
            'company_id' => $worker->company_id,
            'date' => $attendanceDate->toDateString(),
        ]);

        if (! $record->exists || ! $record->check_in) {
            $this->processCheckIn($record, $worker, $supervisorId, $scannedAt);
        } else {
            $this->processCheckOut($record, $worker, $scannedAt);
        }

        $record->save();

        return [
            'worker' => $worker,
            'record' => $record->fresh(['worker', 'scanner']),
        ];
    }

    protected function processCheckIn(Attendance $record, Worker $worker, int $supervisorId, Carbon $scannedAt): void
    {
        $shift = $worker->shift;
        $timezone = config('app.timezone', 'Asia/Dhaka');
        $date = Carbon::parse($record->date, $timezone);
        $shiftStart = Carbon::parse($date->toDateString() . ' ' . $shift->start_time, $timezone);
        $graceCutoff = $shiftStart->copy()->addMinutes($shift->grace_minutes);

        $record->check_in = $scannedAt;
        $record->scanned_by = $supervisorId;
        $record->is_night_shift = $shift->is_night_shift;
        $record->status = $scannedAt->gt($graceCutoff) ? 'Late' : 'Present';
        $record->late_minutes = max(0, $shiftStart->diffInMinutes($scannedAt, false));

        $isHoliday = Holiday::where('company_id', $worker->company_id)
            ->whereDate('date', $date)
            ->exists();

        if ($isHoliday || $scannedAt->dayOfWeek === Carbon::FRIDAY) {
            $record->status = 'Holiday';
        }
    }

    protected function processCheckOut(Attendance $record, Worker $worker, Carbon $scannedAt): void
    {
        $checkIn = Carbon::parse($record->check_in, config('app.timezone', 'Asia/Dhaka'));
        $standardHours = (float) ($worker->company->salarySetting->standard_hours_per_day ?? 8);
        $totalHours = round($checkIn->diffInMinutes($scannedAt) / 60, 2);

        $record->check_out = $scannedAt;
        $record->regular_hours = min($totalHours, $standardHours);
        $record->ot_hours = max(0, round($totalHours - $standardHours, 2));
    }

    protected function resolveAttendanceDate(bool $isNightShift, string $shiftStartTime, Carbon $scannedAt): Carbon
    {
        if (! $isNightShift) {
            return $scannedAt->copy();
        }

        $shiftStartHour = (int) Carbon::parse($shiftStartTime, config('app.timezone', 'Asia/Dhaka'))->format('H');

        return (int) $scannedAt->format('H') < $shiftStartHour
            ? $scannedAt->copy()->subDay()
            : $scannedAt->copy();
    }
}
