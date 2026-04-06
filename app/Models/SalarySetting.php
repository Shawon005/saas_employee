<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalarySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'house_rent_percent',
        'medical_allowance_fixed',
        'attendance_bonus_amount',
        'standard_hours_per_day',
        'ot_divisor',
        'ot_multiplier',
    ];

    protected function casts(): array
    {
        return [
            'house_rent_percent' => 'decimal:2',
            'medical_allowance_fixed' => 'decimal:2',
            'attendance_bonus_amount' => 'decimal:2',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
