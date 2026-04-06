<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #0f172a; font-size: 13px; }
        .header { border-bottom: 2px solid #1A2340; padding-bottom: 12px; margin-bottom: 16px; }
        .title { font-size: 22px; font-weight: bold; color: #1A2340; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        td, th { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { background: #f8fafc; }
        .amount { text-align: right; }
        .net { font-size: 16px; font-weight: bold; }
        .footer { margin-top: 28px; font-size: 12px; color: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $payroll->company->name }}</div>
        <div>{{ $payroll->company->address }}</div>
        <div>Pay Slip / বেতন স্লিপ</div>
    </div>

    <table>
        <tr>
            <th>Name</th><td>{{ $payroll->worker->name }}</td>
            <th>Emp ID</th><td>{{ $payroll->worker->emp_id }}</td>
        </tr>
        <tr>
            <th>Department</th><td>{{ $payroll->worker->department->name }}</td>
            <th>Grade</th><td>{{ $payroll->worker->grade }}</td>
        </tr>
        <tr>
            <th>Month-Year</th><td colspan="3">{{ $payroll->month }}/{{ $payroll->year }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr><th>Component</th><th class="amount">Amount in BDT</th></tr>
        </thead>
        <tbody>
            <tr><td>Basic Salary</td><td class="amount">{{ number_format($payroll->basic_salary, 2) }}</td></tr>
            <tr><td>House Rent</td><td class="amount">{{ number_format($payroll->house_rent, 2) }}</td></tr>
            <tr><td>Medical Allowance</td><td class="amount">{{ number_format($payroll->medical_allowance, 2) }}</td></tr>
            <tr><td>Attendance Bonus</td><td class="amount">{{ number_format($payroll->attendance_bonus, 2) }}</td></tr>
            <tr><td>OT Amount</td><td class="amount">{{ number_format($payroll->ot_amount, 2) }}</td></tr>
            <tr><td>Holiday Allowance</td><td class="amount">{{ number_format($payroll->friday_holiday_allowance, 2) }}</td></tr>
            <tr><td>Total Deductions</td><td class="amount">{{ number_format($payroll->total_deductions, 2) }}</td></tr>
            <tr><td class="net">Net Payable</td><td class="amount net">{{ number_format($payroll->net_payable, 2) }}</td></tr>
        </tbody>
    </table>

    <p style="margin-top: 16px;">Net amount in Bangla: {{ $banglaAmount }}</p>
    <div class="footer">
        <p>Generated at: {{ now()->format('d M Y h:i A') }}</p>
        <p>Authorized by: {{ optional($payroll->generatedBy)->name ?? 'HajiPay System' }}</p>
        <p>Company seal: ______________________</p>
    </div>
</body>
</html>
