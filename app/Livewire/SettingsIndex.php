<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Department;
use App\Models\Holiday;
use App\Models\SalarySetting;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SettingsIndex extends Component
{
    public string $name = '';
    public string $address = '';
    public string $phone = '';
    public string $houseRentPercent = '50';
    public string $medicalAllowanceFixed = '1500';
    public string $attendanceBonusAmount = '1000';
    public string $standardHoursPerDay = '8';
    public string $otDivisor = '208';
    public string $otMultiplier = '2';
    public ?int $editingShiftId = null;
    public string $shiftName = '';
    public string $startTime = '08:00';
    public string $endTime = '17:00';
    public int|string $graceMinutes = 10;
    public bool $isNightShift = false;
    public ?int $editingDepartmentId = null;
    public string $departmentName = '';
    public ?int $editingHolidayId = null;
    public string $holidayName = '';
    public string $holidayDate = '';
    public string $holidayType = 'PublicHoliday';
    public bool $holidayDoublePay = false;

    public function mount(): void
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);

        $company = auth()->user()->company;
        $settings = $company?->salarySetting;
        $this->name = $company?->name ?? '';
        $this->address = $company?->address ?? '';
        $this->phone = $company?->phone ?? '';
        $this->houseRentPercent = (string) ($settings?->house_rent_percent ?? 50);
        $this->medicalAllowanceFixed = (string) ($settings?->medical_allowance_fixed ?? 1500);
        $this->attendanceBonusAmount = (string) ($settings?->attendance_bonus_amount ?? 1000);
        $this->standardHoursPerDay = (string) ($settings?->standard_hours_per_day ?? 8);
        $this->otDivisor = (string) ($settings?->ot_divisor ?? 208);
        $this->otMultiplier = (string) ($settings?->ot_multiplier ?? 2);
        $this->holidayDate = now()->toDateString();
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:255'],
            'houseRentPercent' => ['required', 'numeric', 'min:0'],
            'medicalAllowanceFixed' => ['required', 'numeric', 'min:0'],
            'attendanceBonusAmount' => ['required', 'numeric', 'min:0'],
            'standardHoursPerDay' => ['required', 'numeric', 'min:0'],
            'otDivisor' => ['required', 'numeric', 'min:0'],
            'otMultiplier' => ['required', 'numeric', 'min:0'],
        ]);

        Company::whereKey(auth()->user()->company_id)->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
        ]);

        SalarySetting::updateOrCreate(
            ['company_id' => auth()->user()->company_id],
            [
                'house_rent_percent' => $this->houseRentPercent,
                'medical_allowance_fixed' => $this->medicalAllowanceFixed,
                'attendance_bonus_amount' => $this->attendanceBonusAmount,
                'standard_hours_per_day' => $this->standardHoursPerDay,
                'ot_divisor' => $this->otDivisor,
                'ot_multiplier' => $this->otMultiplier,
            ]
        );

        session()->flash('settings_status', 'Company settings updated.');
    }

    public function editShift(int $shiftId): void
    {
        $shift = Shift::where('company_id', auth()->user()->company_id)->findOrFail($shiftId);

        $this->editingShiftId = $shift->id;
        $this->shiftName = $shift->name;
        $this->startTime = substr((string) $shift->start_time, 0, 5);
        $this->endTime = substr((string) $shift->end_time, 0, 5);
        $this->graceMinutes = (int) $shift->grace_minutes;
        $this->isNightShift = (bool) $shift->is_night_shift;
    }

    public function saveShift(): void
    {
        $validated = $this->validate([
            'shiftName' => ['required', 'string', 'max:255'],
            'startTime' => ['required', 'date_format:H:i'],
            'endTime' => ['required', 'date_format:H:i'],
            'graceMinutes' => ['required', 'integer', 'min:0'],
            'isNightShift' => ['boolean'],
        ]);

        Shift::updateOrCreate(
            ['id' => $this->editingShiftId, 'company_id' => auth()->user()->company_id],
            [
                'name' => $validated['shiftName'],
                'start_time' => $validated['startTime'],
                'end_time' => $validated['endTime'],
                'grace_minutes' => $validated['graceMinutes'],
                'is_night_shift' => $validated['isNightShift'],
            ]
        );

        $this->resetShiftForm();
        session()->flash('settings_status', 'Shift saved successfully.');
    }

    public function resetShiftForm(): void
    {
        $this->resetValidation([
            'shiftName',
            'startTime',
            'endTime',
            'graceMinutes',
            'isNightShift',
        ]);
        $this->editingShiftId = null;
        $this->shiftName = '';
        $this->startTime = '08:00';
        $this->endTime = '17:00';
        $this->graceMinutes = 10;
        $this->isNightShift = false;
    }

    public function editDepartment(int $departmentId): void
    {
        $department = Department::where('company_id', auth()->user()->company_id)->findOrFail($departmentId);

        $this->editingDepartmentId = $department->id;
        $this->departmentName = $department->name;
    }

    public function saveDepartment(): void
    {
        $validated = $this->validate([
            'departmentName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')
                    ->where(fn ($query) => $query->where('company_id', auth()->user()->company_id))
                    ->ignore($this->editingDepartmentId),
            ],
        ]);

        Department::updateOrCreate(
            ['id' => $this->editingDepartmentId, 'company_id' => auth()->user()->company_id],
            ['name' => $validated['departmentName']]
        );

        $this->resetDepartmentForm();
        session()->flash('settings_status', 'Department saved successfully.');
    }

    public function resetDepartmentForm(): void
    {
        $this->resetValidation(['departmentName']);
        $this->editingDepartmentId = null;
        $this->departmentName = '';
    }

    public function editHoliday(int $holidayId): void
    {
        $holiday = Holiday::where('company_id', auth()->user()->company_id)->findOrFail($holidayId);

        $this->editingHolidayId = $holiday->id;
        $this->holidayName = $holiday->name;
        $this->holidayDate = optional($holiday->date)->format('Y-m-d') ?? now()->toDateString();
        $this->holidayType = $holiday->type;
        $this->holidayDoublePay = (bool) $holiday->is_double_pay;
    }

    public function saveHoliday(): void
    {
        $validated = $this->validate([
            'holidayName' => ['required', 'string', 'max:255'],
            'holidayDate' => ['required', 'date'],
            'holidayType' => ['required', 'in:PublicHoliday,WeeklyOff'],
            'holidayDoublePay' => ['boolean'],
        ]);

        Holiday::updateOrCreate(
            ['id' => $this->editingHolidayId, 'company_id' => auth()->user()->company_id],
            [
                'name' => $validated['holidayName'],
                'date' => $validated['holidayDate'],
                'type' => $validated['holidayType'],
                'is_double_pay' => $validated['holidayDoublePay'],
            ]
        );

        $this->resetHolidayForm();
        session()->flash('settings_status', 'Holiday saved successfully.');
    }

    public function resetHolidayForm(): void
    {
        $this->resetValidation([
            'holidayName',
            'holidayDate',
            'holidayType',
            'holidayDoublePay',
        ]);
        $this->editingHolidayId = null;
        $this->holidayName = '';
        $this->holidayDate = now()->toDateString();
        $this->holidayType = 'PublicHoliday';
        $this->holidayDoublePay = false;
    }

    public function render()
    {
        $companyId = auth()->user()->company_id;

        return view('livewire.settings-index', [
            'users' => User::where('company_id', $companyId)->get(),
            'departments' => Department::where('company_id', $companyId)->orderBy('name')->get(),
            'shifts' => Shift::where('company_id', $companyId)->orderBy('start_time')->get(),
            'holidays' => Holiday::where('company_id', $companyId)->orderBy('date')->get(),
        ]);
    }
}
