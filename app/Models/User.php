<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'company_id',
        'name',
        'email',
        'password',
        'role',
        'is_system_admin',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_system_admin' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scannedAttendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'scanned_by');
    }

    public function generatedPayrolls(): HasMany
    {
        return $this->hasMany(Payroll::class, 'generated_by');
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;

        return ($this->is_system_admin && in_array('system_admin', $roles, true))
            || in_array($this->role, $roles, true);
    }

    public function isSystemAdmin(): bool
    {
        return (bool) $this->is_system_admin;
    }
}
