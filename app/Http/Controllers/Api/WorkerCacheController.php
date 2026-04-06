<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkerCacheController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $workers = Worker::with('shift')
            ->active()
            ->where('company_id', $request->user()->company_id)
            ->get(['id', 'company_id', 'emp_id', 'name', 'qr_code_token', 'shift_id']);

        return response()->json($workers);
    }
}
