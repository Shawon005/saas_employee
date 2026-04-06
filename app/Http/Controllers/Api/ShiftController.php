<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(
            Shift::where('company_id', $request->user()->company_id)->orderBy('start_time')->get()
        );
    }
}
