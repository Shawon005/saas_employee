@php($heading = 'Dashboard')
<div class="space-y-8" wire:poll.5s>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        @foreach ([
            ['label' => 'মোট শ্রমিক', 'sub' => 'Total Workers', 'value' => $stats['workers'], 'tone' => 'bg-brand text-white'],
            ['label' => 'আজ উপস্থিত', 'sub' => 'Present Today', 'value' => $stats['present'], 'tone' => 'bg-white'],
            ['label' => 'আজ অনুপস্থিত', 'sub' => 'Absent Today', 'value' => $stats['absent'], 'tone' => 'bg-white'],
            ['label' => 'লেট', 'sub' => 'Late Today', 'value' => $stats['late'], 'tone' => 'bg-white'],
            ['label' => 'OT ঘন্টা', 'sub' => 'OT This Month', 'value' => $stats['ot'], 'tone' => 'bg-white'],
        ] as $card)
            <div class="{{ $card['tone'] }} rounded-[28px] p-5 shadow-sm">
                <p class="font-bangla text-sm {{ str_contains($card['tone'], 'brand') ? 'text-white/70' : 'text-slate-500' }}">{{ $card['label'] }}</p>
                <p class="mt-2 text-3xl font-semibold">{{ $card['value'] }}</p>
                <p class="mt-1 text-xs {{ str_contains($card['tone'], 'brand') ? 'text-white/70' : 'text-slate-400' }}">{{ $card['sub'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.4fr_.8fr]">
        <div class="rounded-[32px] bg-white/80 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bangla text-lg font-semibold text-brand">সাপ্তাহিক অ্যাটেনডেন্স চার্ট</p>
                    <p class="text-sm text-slate-500">Present / Absent / OT by week</p>
                </div>
                <div class="rounded-2xl bg-amber-50 px-4 py-2 text-sm text-amber-700">Pending Sync: {{ $stats['pending_sync'] }}</div>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-{{ max(1, count($chartData)) }}">
                @forelse ($chartData as $bar)
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-700">Week {{ $bar->week_number }}</p>
                        <div class="mt-4 space-y-3">
                            <div>
                                <div class="mb-1 flex justify-between text-xs"><span>Present</span><span>{{ $bar->present_count }}</span></div>
                                <div class="h-3 rounded-full bg-slate-200"><div class="h-3 rounded-full bg-[#00C896]" style="width: {{ min(100, $bar->present_count * 5) }}%"></div></div>
                            </div>
                            <div>
                                <div class="mb-1 flex justify-between text-xs"><span>Absent</span><span>{{ $bar->absent_count }}</span></div>
                                <div class="h-3 rounded-full bg-slate-200"><div class="h-3 rounded-full bg-[#EF4444]" style="width: {{ min(100, $bar->absent_count * 5) }}%"></div></div>
                            </div>
                            <div>
                                <div class="mb-1 flex justify-between text-xs"><span>OT Hours</span><span>{{ number_format($bar->ot_hours, 2) }}</span></div>
                                <div class="h-3 rounded-full bg-slate-200"><div class="h-3 rounded-full bg-[#F59E0B]" style="width: {{ min(100, $bar->ot_hours * 4) }}%"></div></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl bg-slate-50 p-6 text-slate-500">No attendance data yet.</div>
                @endforelse
            </div>
        </div>

        <div class="rounded-[32px] bg-white/80 p-6 shadow-sm">
            <p class="font-bangla text-lg font-semibold text-brand">লাইভ স্ক্যান ফিড</p>
            <p class="text-sm text-slate-500">Latest 15 attendance events</p>
            <div class="mt-5 space-y-3">
                @forelse ($feed as $item)
                    <div class="flex items-center justify-between rounded-3xl bg-slate-50 px-4 py-3">
                        <div>
                            <p class="font-semibold">{{ $item->worker->name }}</p>
                            <p class="text-xs text-slate-500">{{ $item->worker->emp_id }} • {{ optional($item->check_in ?? $item->check_out)->format('h:i A') }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $item->check_out ? 'bg-slate-900 text-white' : 'bg-[#00C896]/10 text-[#00C896]' }}">{{ $item->check_out ? 'OUT' : 'IN' }}</span>
                    </div>
                @empty
                    <div class="rounded-3xl bg-slate-50 p-6 text-slate-500">No scans yet today.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
