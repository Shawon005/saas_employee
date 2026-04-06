<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SystemAdminCompanies extends Component
{
    public function toggleCompany(int $companyId): void
    {
        $company = Company::findOrFail($companyId);
        $isActive = ! $company->is_active;

        $company->update([
            'is_active' => $isActive,
            'subscription_status' => $isActive ? 'active' : 'inactive',
            'subscription_starts_at' => $isActive ? ($company->subscription_starts_at ?? now()) : $company->subscription_starts_at,
            'subscription_ends_at' => $isActive ? now()->addMonth() : now(),
        ]);

        if ($registration = $company->registrations()->latest()->first()) {
            $registration->update([
                'status' => $isActive ? 'approved' : 'on_hold',
            ]);
        }

        session()->flash('status', $isActive
            ? 'Company activated successfully.'
            : 'Company deactivated successfully.');
    }

    public function render()
    {
        return view('livewire.system-admin-companies', [
            'companies' => Company::with(['users', 'registrations' => fn ($query) => $query->latest()])
                ->latest()
                ->get(),
        ]);
    }
}
