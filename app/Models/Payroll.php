<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'company_id',
        'month',
        'year',
        'total_days_present',
        'total_late_count',
        'total_ot_hours',
        'basic_salary',
        'house_rent',
        'medical_allowance',
        'attendance_bonus',
        'ot_amount',
        'friday_holiday_allowance',
        'total_deductions',
        'net_payable',
        'status',
        'generated_by',
        'finalized_at',
    ];

    protected function casts(): array
    {
        return [
            'total_ot_hours' => 'decimal:2',
            'basic_salary' => 'decimal:2',
            'house_rent' => 'decimal:2',
            'medical_allowance' => 'decimal:2',
            'attendance_bonus' => 'decimal:2',
            'ot_amount' => 'decimal:2',
            'friday_holiday_allowance' => 'decimal:2',
            'total_deductions' => 'decimal:2',
            'net_payable' => 'decimal:2',
            'finalized_at' => 'datetime',
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

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
