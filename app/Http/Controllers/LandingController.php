<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        $plans = [
            [
                'name' => 'Starter',
                'price' => 499,
                'cycle' => 'month',
                'workers' => 'Up to 100 employees',
                'features' => ['Attendance dashboard', 'Payroll generation', 'HR-ready employee records'],
            ],
            [
                'name' => 'Growth',
                'price' => 699,
                'cycle' => 'month',
                'workers' => 'Up to 500 employees',
                'features' => ['Shift + holiday setup', 'Payroll review workflow', 'Supervisor attendance tracking'],
            ],
            [
                'name' => 'Enterprise',
                'price' => 999,
                'cycle' => 'month',
                'workers' => 'Unlimited employees',
                'features' => ['Multi-line factories', 'Priority onboarding', 'Dedicated admin support'],
            ],
        ];

        return view('landing', ['plans' => $plans]);
    }
}
