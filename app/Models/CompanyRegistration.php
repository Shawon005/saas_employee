<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'owner_user_id',
        'owner_phone',
        'plan',
        'billing_cycle',
        'amount',
        'payment_method',
        'payment_number',
        'transaction_id',
        'status',
        'note',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }
}
