<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\WorkerCacheController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/workers/cache', WorkerCacheController::class);
        Route::post('/attendance/scan', [AttendanceController::class, 'scan']);
        Route::post('/attendance/bulk-sync', [AttendanceController::class, 'bulkSync']);
        Route::get('/attendance/today', [AttendanceController::class, 'today']);
        Route::get('/shifts', ShiftController::class);
    });
});
