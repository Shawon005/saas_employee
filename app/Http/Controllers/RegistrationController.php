<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyRegistration;
use App\Models\SalarySetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    private const PLAN_PRICING = [
        'starter_monthly' => ['plan' => 'Starter', 'billing_cycle' => 'Monthly', 'amount' => 499],
        'growth_monthly' => ['plan' => 'Growth', 'billing_cycle' => 'Monthly', 'amount' => 699],
        'enterprise_monthly' => ['plan' => 'Enterprise', 'billing_cycle' => 'Monthly', 'amount' => 999],
    ];

    public function create(): View
    {
        return view('auth.register-company', [
            'packages' => self::PLAN_PRICING,
            'paymentNumbers' => [
                'bkash' => '01700000001',
                'nagad' => '01800000002',
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:1000'],
            'company_phone' => ['required', 'string', 'max:30'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'owner_phone' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'package' => ['required', 'in:' . implode(',', array_keys(self::PLAN_PRICING))],
            'payment_method' => ['required', 'in:bkash,nagad'],
            'payment_number' => ['required', 'string', 'max:30'],
            'transaction_id' => ['required', 'string', 'max:100', 'unique:company_registrations,transaction_id'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $package = self::PLAN_PRICING[$validated['package']];

        DB::transaction(function () use ($validated, $package) {
            $company = Company::create([
                'name' => $validated['company_name'],
                'address' => $validated['company_address'] ?? null,
                'phone' => $validated['company_phone'],
                'is_active' => false,
                'subscription_plan' => $package['plan'],
                'subscription_status' => 'pending',
                'billing_cycle' => $package['billing_cycle'],
            ]);

            SalarySetting::create(['company_id' => $company->id]);

            $owner = User::create([
                'company_id' => $company->id,
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => $validated['password'],
                'role' => 'super_admin',
            ]);

            CompanyRegistration::create([
                'company_id' => $company->id,
                'owner_user_id' => $owner->id,
                'owner_phone' => $validated['owner_phone'],
                'plan' => $package['plan'],
                'billing_cycle' => $package['billing_cycle'],
                'amount' => $package['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_number' => $validated['payment_number'],
                'transaction_id' => strtoupper($validated['transaction_id']),
                'status' => 'pending',
                'note' => $validated['note'] ?? null,
                'paid_at' => now(),
            ]);
        });

        return redirect()->route('login')->with('status', 'Registration submitted. Your company will be activated after payment verification by the system admin.');
    }
}
