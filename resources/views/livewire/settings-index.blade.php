@php($heading = 'Settings')
<div class="space-y-6">
    @if (session('settings_status'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
            {{ session('settings_status') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[1.1fr_.9fr]">
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <p class="font-bangla text-lg font-semibold text-brand">Company Profile</p>
            <div class="mt-4 grid gap-4">
                <div>
                    <input wire:model="name" type="text" placeholder="Company name" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <textarea wire:model="address" rows="3" placeholder="Address" class="w-full rounded-2xl bg-slate-100 px-4 py-3"></textarea>
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="phone" type="text" placeholder="Phone" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <p class="mt-8 font-bangla text-lg font-semibold text-brand">Salary Settings</p>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <input wire:model="houseRentPercent" type="number" step="0.01" placeholder="House rent %" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('houseRentPercent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="medicalAllowanceFixed" type="number" step="0.01" placeholder="Medical allowance" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('medicalAllowanceFixed') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="attendanceBonusAmount" type="number" step="0.01" placeholder="Attendance bonus" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('attendanceBonusAmount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="standardHoursPerDay" type="number" placeholder="Standard hours" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('standardHoursPerDay') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="otDivisor" type="number" placeholder="OT divisor" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('otDivisor') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="otMultiplier" type="number" placeholder="OT multiplier" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('otMultiplier') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
            <button wire:click="save" class="mt-6 rounded-2xl bg-brand px-5 py-3 font-semibold text-white">Save Settings</button>
        </div>
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="font-bangla text-lg font-semibold text-brand">System Access</p>
                    <p class="mt-1 text-sm text-slate-500">Only super admins can see and manage this page.</p>
                </div>
                <span class="rounded-full bg-brand/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-brand">Super Admin</span>
            </div>
            <p class="mt-6 font-bangla text-lg font-semibold text-brand">Users</p>
            <div class="mt-4 space-y-3">
                @foreach ($users as $user)
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <div>
                            <p class="font-semibold">{{ $user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        </div>
                        <span class="rounded-full bg-brand/10 px-3 py-1 text-xs text-brand">{{ $user->role }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-lg font-semibold text-brand">Departments</p>
                    <p class="text-sm text-slate-500">Add or edit worker departments.</p>
                </div>
                @if ($editingDepartmentId)
                    <button wire:click="resetDepartmentForm" class="rounded-2xl bg-slate-100 px-3 py-2 text-sm">Cancel</button>
                @endif
            </div>
            <div class="mt-4 space-y-3">
                <div>
                    <input wire:model="departmentName" type="text" placeholder="Department name" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('departmentName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <button wire:click="saveDepartment" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">
                    {{ $editingDepartmentId ? 'Update Department' : 'Add Department' }}
                </button>
            </div>
            <div class="mt-6 overflow-hidden rounded-3xl border border-slate-100">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($departments as $department)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3 font-medium">{{ $department->name }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="editDepartment({{ $department->id }})" class="rounded-xl bg-sky-100 px-3 py-2 text-sky-800">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-center text-slate-500">No departments added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-lg font-semibold text-brand">Shifts</p>
                    <p class="text-sm text-slate-500">Add or edit shift timing.</p>
                </div>
                @if ($editingShiftId)
                    <button wire:click="resetShiftForm" class="rounded-2xl bg-slate-100 px-3 py-2 text-sm">Cancel</button>
                @endif
            </div>
            <div class="mt-4 grid gap-3">
                <div>
                    <input wire:model="shiftName" type="text" placeholder="Shift name" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('shiftName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid gap-3 md:grid-cols-2">
                    <div>
                        <input wire:model="startTime" type="time" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @error('startTime') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input wire:model="endTime" type="time" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @error('endTime') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <input wire:model="graceMinutes" type="number" min="0" placeholder="Grace minutes" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('graceMinutes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-600">
                    <input wire:model="isNightShift" type="checkbox">
                    Night shift
                </label>
                <button wire:click="saveShift" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">
                    {{ $editingShiftId ? 'Update Shift' : 'Add Shift' }}
                </button>
            </div>
            <div class="mt-6 overflow-hidden rounded-3xl border border-slate-100">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Shift</th>
                            <th class="px-4 py-3">Time</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shifts as $shift)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3">
                                    <p class="font-medium">{{ $shift->name }}</p>
                                    <p class="text-xs text-slate-500">Grace {{ $shift->grace_minutes }} min{{ $shift->is_night_shift ? ' • Night' : '' }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ \Illuminate\Support\Str::of($shift->start_time)->limit(5, '') }} - {{ \Illuminate\Support\Str::of($shift->end_time)->limit(5, '') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="editShift({{ $shift->id }})" class="rounded-xl bg-sky-100 px-3 py-2 text-sky-800">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-slate-500">No shifts added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-lg font-semibold text-brand">Holidays</p>
                    <p class="text-sm text-slate-500">Add or edit holiday dates.</p>
                </div>
                @if ($editingHolidayId)
                    <button wire:click="resetHolidayForm" class="rounded-2xl bg-slate-100 px-3 py-2 text-sm">Cancel</button>
                @endif
            </div>
            <div class="mt-4 grid gap-3">
                <div>
                    <input wire:model="holidayName" type="text" placeholder="Holiday name" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('holidayName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input wire:model="holidayDate" type="date" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    @error('holidayDate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <select wire:model="holidayType" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        <option value="PublicHoliday">Public Holiday</option>
                        <option value="WeeklyOff">Weekly Off</option>
                    </select>
                    @error('holidayType') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <label class="flex items-center gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm font-medium text-slate-600">
                    <input wire:model="holidayDoublePay" type="checkbox">
                    Double pay allowance
                </label>
                <button wire:click="saveHoliday" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">
                    {{ $editingHolidayId ? 'Update Holiday' : 'Add Holiday' }}
                </button>
            </div>
            <div class="mt-6 overflow-hidden rounded-3xl border border-slate-100">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Holiday</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($holidays as $holiday)
                            <tr class="border-t border-slate-100">
                                <td class="px-4 py-3">
                                    <p class="font-medium">{{ $holiday->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $holiday->type }}{{ $holiday->is_double_pay ? ' • Double pay' : '' }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $holiday->date->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="editHoliday({{ $holiday->id }})" class="rounded-xl bg-sky-100 px-3 py-2 text-sky-800">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-slate-500">No holidays added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
