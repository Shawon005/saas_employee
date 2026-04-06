<?php

namespace App\Livewire;

use App\Models\Shift;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ShiftManager extends Component
{
    public string $name = '';
    public string $startTime = '08:00';
    public string $endTime = '17:00';
    public int $graceMinutes = 10;
    public bool $isNightShift = false;

    public function save(): void
    {
        Shift::create([
            'company_id' => auth()->user()->company_id,
            'name' => $this->name,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'grace_minutes' => $this->graceMinutes,
            'is_night_shift' => $this->isNightShift,
        ]);

        $this->reset(['name', 'startTime', 'endTime', 'graceMinutes', 'isNightShift']);
        $this->startTime = '08:00';
        $this->endTime = '17:00';
        $this->graceMinutes = 10;
    }

    public function render()
    {
        return view('livewire.shift-manager', [
            'shifts' => Shift::where('company_id', auth()->user()->company_id)->orderBy('start_time')->get(),
        ]);
    }
}
