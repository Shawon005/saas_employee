<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalarySettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'house_rent_percent' => ['required', 'numeric', 'min:0'],
            'medical_allowance_fixed' => ['required', 'numeric', 'min:0'],
            'attendance_bonus_amount' => ['required', 'numeric', 'min:0'],
            'standard_hours_per_day' => ['required', 'integer', 'min:1', 'max:24'],
            'ot_divisor' => ['required', 'integer', 'min:1'],
            'ot_multiplier' => ['required', 'integer', 'min:1'],
        ];
    }
}
