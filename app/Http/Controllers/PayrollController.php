<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Support\BanglaNumber;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    public function slip(Payroll $payroll)
    {
        return Pdf::loadView('pdf.payslip', [
            'payroll' => $payroll->loadMissing(['worker.department', 'company', 'generatedBy']),
            'banglaAmount' => BanglaNumber::moneyInWords((float) $payroll->net_payable),
        ])->stream("payslip-{$payroll->worker->emp_id}-{$payroll->month}-{$payroll->year}.pdf");
    }
}
