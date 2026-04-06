<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function scan(Request $request, AttendanceService $attendanceService): JsonResponse
    {
        $data = $request->validate([
            'qr_token' => ['required', 'string'],
            'scanned_at' => ['nullable', 'date'],
        ]);

        return response()->json(
            $attendanceService->processScan(
                $data['qr_token'],
                $request->user()->id,
                ! empty($data['scanned_at']) ? Carbon::parse($data['scanned_at'], config('app.timezone', 'Asia/Dhaka')) : null
            )
        );
    }

    public function bulkSync(Request $request, AttendanceService $attendanceService): JsonResponse
    {
        $payload = $request->validate([
            'logs' => ['required', 'array'],
            'logs.*.qr_token' => ['required', 'string'],
            'logs.*.scanned_at' => ['required', 'date'],
        ]);

        $synced = 0;
        $failed = 0;

        foreach ($payload['logs'] as $log) {
            try {
                $attendanceService->processScan(
                    $log['qr_token'],
                    $request->user()->id,
                    Carbon::parse($log['scanned_at'], config('app.timezone', 'Asia/Dhaka'))
                );
                $synced++;
            } catch (\Throwable) {
                $failed++;
            }
        }

        return response()->json([
            'synced' => $synced,
            'skipped' => 0,
            'failed' => $failed,
        ]);
    }

    public function today(Request $request): JsonResponse
    {
        return response()->json(
            Attendance::with(['worker', 'scanner'])
                ->where('company_id', $request->user()->company_id)
                ->today()
                ->latest('updated_at')
                ->get()
        );
    }
}
