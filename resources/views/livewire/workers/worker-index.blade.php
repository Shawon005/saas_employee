@php($heading = 'Workers')
<div class="space-y-6">
    <div class="flex flex-col gap-4 rounded-[32px] bg-white/80 p-6 shadow-sm xl:flex-row xl:items-center xl:justify-between">
        <div class="grid flex-1 gap-3 md:grid-cols-4">
            <input wire:model.live="search" type="text" placeholder="Search name / EMP ID" class="rounded-2xl border-0 bg-slate-100 px-4 py-3 ring-1 ring-slate-200">
            <select wire:model.live="department" class="rounded-2xl border-0 bg-slate-100 px-4 py-3 ring-1 ring-slate-200">
                <option value="">All Departments</option>
                @foreach ($departments as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="grade" class="rounded-2xl border-0 bg-slate-100 px-4 py-3 ring-1 ring-slate-200">
                <option value="">All Grades</option>
                <option value="Grade-1">Grade-1</option>
                <option value="Grade-2">Grade-2</option>
                <option value="Grade-3">Grade-3</option>
            </select>
            <select wire:model.live="status" class="rounded-2xl border-0 bg-slate-100 px-4 py-3 ring-1 ring-slate-200">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button wire:click="createWorker" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">Add Worker</button>
    </div>

    <div class="overflow-hidden rounded-[32px] bg-white/85 shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-5 py-4">Worker</th>
                    <th class="px-5 py-4">Grade</th>
                    <th class="px-5 py-4">Shift</th>
                    <th class="px-5 py-4">Salary</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workers as $worker)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-11 w-11 overflow-hidden rounded-2xl bg-amber-100">
                                    @if ($storageUrl($worker->photo))
                                        <img src="{{ asset($storageUrl($worker->photo)) }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $worker->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $worker->emp_id }} • {{ $worker->department->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">{{ $worker->grade }}</td>
                        <td class="px-5 py-4">{{ $worker->shift->name }}</td>
                        <td class="px-5 py-4">BDT {{ number_format($worker->basic_salary, 2) }}</td>
                        <td class="px-5 py-4"><span class="rounded-full px-3 py-1 text-xs {{ $worker->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ ucfirst($worker->status) }}</span></td>
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('workers.show', $worker) }}" class="rounded-xl bg-slate-100 px-3 py-2">View</a>
                                <button wire:click="edit({{ $worker->id }})" class="rounded-xl bg-sky-100 px-3 py-2 text-sky-800">Edit</button>
                                <a href="{{ route('workers.id-card', $worker) }}" class="rounded-xl bg-amber-100 px-3 py-2 text-amber-800">Print QR Card</a>
                                <button wire:click="deactivate({{ $worker->id }})" class="rounded-xl bg-red-50 px-3 py-2 text-red-600">Deactivate</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $workers->links() }}</div>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4">
            <div class="w-full max-w-3xl rounded-[32px] bg-white p-8 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg font-semibold text-brand">{{ $isEditing ? 'Edit Worker' : 'Add Worker' }}</p>
                        <p class="text-sm text-slate-500">{{ $isEditing ? 'Update worker information and replace photo if needed' : 'Auto QR and employee ID generation' }}</p>
                    </div>
                    <button wire:click="closeModal" class="rounded-2xl bg-slate-100 px-4 py-2">Close</button>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div>
                        <input wire:model="name" type="text" placeholder="Worker name" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <select wire:model="workerGrade" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                            <option value="Grade-1">Grade-1</option>
                            <option value="Grade-2">Grade-2</option>
                            <option value="Grade-3">Grade-3</option>
                        </select>
                        @error('workerGrade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <select wire:model="departmentId" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                            <option value="">Select department</option>
                            @foreach ($departments as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('departmentId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <select wire:model="shiftId" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                            <option value="">Select shift</option>
                            @foreach ($shifts as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('shiftId') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input wire:model="basicSalary" type="number" step="0.01" placeholder="Basic salary" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @error('basicSalary') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input wire:model="houseRent" type="number" step="0.01" placeholder="House rent ({{ $houseRentPercent }}%)" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @error('houseRent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input wire:model="medicalAllowance" type="number" step="0.01" placeholder="Medical allowance" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @error('medicalAllowance') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input wire:model="joinDate" type="date" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @error('joinDate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <input wire:model="photo" type="file" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                        @if ($isEditing)
                            <p class="mt-2 text-sm text-slate-500">Leave photo empty to keep the current worker image.</p>
                        @endif
                        @error('photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="save" class="rounded-2xl bg-brand px-5 py-3 font-semibold text-white">{{ $isEditing ? 'Update Worker' : 'Save Worker' }}</button>
                </div>
            </div>
        </div>
    @endif
</div>
