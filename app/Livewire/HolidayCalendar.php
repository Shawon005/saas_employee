<?php

namespace App\Livewire;

use App\Models\Holiday;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class HolidayCalendar extends Component
{
    public string $name = '';
    public string $date = '';
    public string $type = 'PublicHoliday';
    public bool $isDoublePay = false;

    public function mount(): void
    {
        $this->date = now()->toDateString();
    }

    public function save(): void
    {
        Holiday::create([
            'company_id' => auth()->user()->company_id,
            'name' => $this->name,
            'date' => $this->date,
            'type' => $this->type,
            'is_double_pay' => $this->isDoublePay,
        ]);

        $this->reset(['name', 'type', 'isDoublePay']);
        $this->date = now()->toDateString();
        $this->type = 'PublicHoliday';
    }

    public function render()
    {
        return view('livewire.holiday-calendar', [
            'holidays' => Holiday::where('company_id', auth()->user()->company_id)->orderBy('date')->get(),
        ]);
    }
}
