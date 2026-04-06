<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'worker_id',
        'company_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'is_night_shift',
        'regular_hours',
        'ot_hours',
        'late_minutes',
        'scanned_by',
        'note',
        'synced_from_device',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in' => 'datetime',
            'check_out' => 'datetime',
            'is_night_shift' => 'boolean',
            'regular_hours' => 'decimal:2',
            'ot_hours' => 'decimal:2',
            'synced_from_device' => 'boolean',
        ];
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scanner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(AttendanceCorrection::class);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('date', now()->toDateString());
    }
}
