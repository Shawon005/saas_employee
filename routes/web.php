<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\WorkerController;
use App\Livewire\AttendanceIndex;
use App\Livewire\Dashboard;
use App\Livewire\GeneratePayroll;
use App\Livewire\HolidayCalendar;
use App\Livewire\PayrollIndex;
use App\Livewire\PayrollReview;
use App\Livewire\ReportsIndex;
use App\Livewire\SettingsIndex;
use App\Livewire\ShiftManager;
use App\Livewire\SystemAdminCompanies;
use App\Livewire\Workers\WorkerIndex;
use App\Livewire\Workers\WorkerProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware('role:system_admin')->group(function () {
        Route::get('/system-admin/companies', SystemAdminCompanies::class)->name('system-admin.companies');
    });

    Route::middleware('company.access')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/workers', WorkerIndex::class)->name('workers.index');
        Route::get('/workers/{worker}', WorkerProfile::class)->name('workers.show');
        Route::get('/attendance', AttendanceIndex::class)->name('attendance.index');
        Route::get('/payroll', PayrollIndex::class)->name('payroll.index');
        Route::get('/payroll/generate', GeneratePayroll::class)->name('payroll.generate');
        Route::get('/payroll/{payroll}/slip', [PayrollController::class, 'slip'])->name('payroll.slip');
        Route::get('/payroll/{month}/{year}', PayrollReview::class)
            ->whereNumber('month')
            ->whereNumber('year')
            ->name('payroll.review');
        Route::get('/reports', ReportsIndex::class)->name('reports.index');
        Route::get('/workers/{worker}/qr', [WorkerController::class, 'qrCode'])->name('workers.qr');
        Route::get('/workers/{worker}/id-card', [WorkerController::class, 'idCard'])->name('workers.id-card');
        Route::post('/workers/bulk-print', [WorkerController::class, 'bulkPrint'])->name('workers.bulk-print');

        Route::middleware('role:super_admin')->group(function () {
            Route::get('/settings', SettingsIndex::class)->name('settings.index');
            Route::get('/settings/shifts', ShiftManager::class)->name('settings.shifts');
            Route::get('/settings/holidays', HolidayCalendar::class)->name('settings.holidays');
        });
    });
});
