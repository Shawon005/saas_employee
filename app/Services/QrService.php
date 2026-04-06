<?php

namespace App\Services;

use App\Models\Worker;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrService
{
    public function generateEmpId(): string
    {
        do {
            $id = 'EMP-' . str_pad((string) random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (Worker::where('emp_id', $id)->exists());

        return $id;
    }

    public function generateQr(Worker $worker): string
    {
        return QrCode::size(300)->errorCorrection('H')->generate($worker->qr_code_token);
    }

    public function generateQrDataUri(Worker $worker): string
    {
        $svg = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($worker->qr_code_token);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function ensureWorkerIdentity(Worker $worker): Worker
    {
        $worker->emp_id ??= $this->generateEmpId();
        $worker->qr_code_token ??= (string) Str::uuid();
        $worker->save();

        return $worker->refresh();
    }

    public function generateIdCardPdf(Worker $worker)
    {
        return Pdf::loadView('pdf.id-card', [
            'worker' => $worker->loadMissing(['company', 'department', 'shift']),
            'qrImage' => $this->generateQrDataUri($worker),
        ])->setPaper('a4');
    }

    public function generateBulkIdCardPdf($workers)
    {
        return Pdf::loadView('pdf.id-card-bulk', [
            'workers' => $workers,
            'qrService' => $this,
        ])->setPaper('a4');
    }
}
