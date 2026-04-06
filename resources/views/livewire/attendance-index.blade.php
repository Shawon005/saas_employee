@php($heading = 'Attendance')
<div class="space-y-6">
    <div class="flex flex-wrap items-center gap-3 rounded-[32px] bg-white/85 p-6 shadow-sm">
        <input wire:model.live="date" type="date" class="rounded-2xl bg-slate-100 px-4 py-3">
        <button wire:click="$set('view', 'daily')" class="rounded-2xl px-4 py-3 {{ $view === 'daily' ? 'bg-brand text-white' : 'bg-slate-100' }}">Daily View</button>
        <button wire:click="$set('view', 'monthly')" class="rounded-2xl px-4 py-3 {{ $view === 'monthly' ? 'bg-brand text-white' : 'bg-slate-100' }}">Monthly View</button>
    </div>

    @if ($view === 'daily')
        <div class="overflow-hidden rounded-[32px] bg-white/85 shadow-sm">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Worker</th>
                        <th class="px-5 py-4">Punch In</th>
                        <th class="px-5 py-4">Punch Out</th>
                        <th class="px-5 py-4">Hours</th>
                        <th class="px-5 py-4">OT</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr class="border-t border-slate-100">
                            <td class="px-5 py-4">{{ $record->worker->name }}</td>
                            <td class="px-5 py-4">{{ optional($record->check_in)->format('h:i A') }}</td>
                            <td class="px-5 py-4">{{ optional($record->check_out)->format('h:i A') }}</td>
                            <td class="px-5 py-4">{{ number_format($record->regular_hours, 2) }}</td>
                            <td class="px-5 py-4">{{ number_format($record->ot_hours, 2) }}</td>
                            <td class="px-5 py-4"><span class="rounded-full px-3 py-1 text-xs {{ match($record->status) {
                                'Present' => 'bg-emerald-50 text-emerald-700',
                                'Late' => 'bg-amber-50 text-amber-700',
                                'Absent' => 'bg-red-50 text-red-700',
                                'Holiday' => 'bg-sky-50 text-sky-700',
                                default => 'bg-slate-100 text-slate-500'
                            } }}">{{ $record->status }}</span></td>
                            <td class="px-5 py-4"><button wire:click="openCorrection({{ $record->id }})" class="rounded-xl bg-slate-100 px-3 py-2">Manual Correction</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="rounded-[32px] bg-white/85 p-6 shadow-sm">
            <div class="grid gap-4">
                @foreach ($monthlyRecords as $workerId => $workerRecords)
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="mb-3 font-semibold">{{ optional($workerRecords->first()->worker)->name }}</p>
                        <div class="grid grid-cols-7 gap-2 md:grid-cols-12 xl:grid-cols-16">
                            @for ($day = 1; $day <= 31; $day++)
                                @php($status = optional($workerRecords->firstWhere(fn ($item) => $item->date->day === $day))->status)
                                <div class="rounded-xl p-2 text-center text-xs {{ $status === 'Present' ? 'bg-emerald-50' : ($status === 'Late' ? 'bg-amber-50' : ($status === 'Absent' ? 'bg-red-50' : ($status === 'Holiday' ? 'bg-sky-50' : 'bg-slate-100'))) }}">
                                    {{ $day }}<br>{{ $status ? substr($status, 0, 1) : '-' }}
                                </div>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($editingAttendance)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 p-4">
            <div class="w-full max-w-xl rounded-[32px] bg-white p-8">
                <h3 class="text-xl font-semibold text-brand">Attendance Correction</h3>
                <div class="mt-5 space-y-4">
                    <input wire:model="newCheckIn" type="datetime-local" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    <input wire:model="newCheckOut" type="datetime-local" class="w-full rounded-2xl bg-slate-100 px-4 py-3">
                    <textarea wire:model="reason" rows="4" class="w-full rounded-2xl bg-slate-100 px-4 py-3" placeholder="Reason"></textarea>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('editingAttendance', null)" class="rounded-2xl bg-slate-100 px-4 py-3">Cancel</button>
                    <button wire:click="saveCorrection" class="rounded-2xl bg-brand px-4 py-3 text-white">Save</button>
                </div>
            </div>
        </div>
    @endif
</div>
