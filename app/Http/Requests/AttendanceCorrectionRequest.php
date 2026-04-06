<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceCorrectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attendance_id' => ['required', 'exists:attendance,id'],
            'new_check_in' => ['nullable', 'date'],
            'new_check_out' => ['nullable', 'date'],
            'reason' => ['required', 'string', 'min:5'],
        ];
    }
}
