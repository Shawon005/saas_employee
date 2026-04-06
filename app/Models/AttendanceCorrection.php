<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceCorrection extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'corrected_by',
        'old_check_in',
        'new_check_in',
        'old_check_out',
        'new_check_out',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'old_check_in' => 'datetime',
            'new_check_in' => 'datetime',
            'old_check_out' => 'datetime',
            'new_check_out' => 'datetime',
        ];
    }

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }

    public function correctedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'corrected_by');
    }
}
