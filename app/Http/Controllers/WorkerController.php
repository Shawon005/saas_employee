<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Services\QrService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WorkerController extends Controller
{
    public function qrCode(Worker $worker, QrService $qrService)
    {
        return response($qrService->generateQr($worker))->header('Content-Type', 'image/svg+xml');
    }

    public function idCard(Worker $worker, QrService $qrService)
    {
        return $qrService->generateIdCardPdf($worker)->stream("worker-{$worker->emp_id}.pdf");
    }

    public function bulkPrint(Request $request, QrService $qrService): BinaryFileResponse|string
    {
        $workers = Worker::with(['company', 'department', 'shift'])
            ->whereIn('id', $request->input('worker_ids', []))
            ->get();

        return $qrService->generateBulkIdCardPdf($workers)->download('hajipay-id-cards.pdf');
    }
}
