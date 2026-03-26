<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $payroll->user->name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 13px; color: #333; line-height: 1.5; margin: 0; padding: 0; }
        .payslip-container { padding: 30px; }
        .header { border-bottom: 2px solid #f1f2f3; padding-bottom: 15px; margin-bottom: 25px; display: table; width: 100%; }
        .logo { font-size: 24px; font-weight: bold; color: #4361ee; display: table-cell; vertical-align: middle; }
        .logo span { color: #333; }
        .title-box { display: table-cell; text-align: right; vertical-align: middle; }
        .payslip-title { font-size: 18px; font-weight: bold; color: #888ea8; text-transform: uppercase; margin: 0; }
        .info-row { display: table; width: 100%; margin-bottom: 30px; }
        .info-col { display: table-cell; width: 50%; }
        .info-col.right { text-align: right; }
        .section-label { text-transform: uppercase; font-size: 10px; letter-spacing: 1px; color: #888ea8; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f8f9fa; text-align: left; padding: 10px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f1f2f3; }
        td { padding: 10px; border-bottom: 1px solid #f1f2f3; }
        .text-right { text-align: right; }
        .total-row { background: #f8f9fa; font-weight: bold; }
        .net-salary-box { background: #4361ee; color: #fff; padding: 20px; margin-top: 30px; display: table; width: 100%; }
        .net-salary-info { display: table-cell; vertical-align: middle; }
        .net-salary-label { font-size: 12px; opacity: 0.9; text-transform: uppercase; }
        .net-salary-amount { font-size: 24px; font-weight: bold; }
        .net-salary-words { display: table-cell; text-align: right; vertical-align: middle; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 1px dashed #f1f2f3; text-align: center; color: #888ea8; font-size: 10px; }
        .text-danger { color: #e7515a; }
        @page { margin: 0; }
    </style>
</head>
<body>
    <div class="payslip-container">
        <div class="header">
            <div class="logo">ELITE<span>HR</span></div>
            <div class="title-box">
                <p class="payslip-title">Payslip</p>
                <p style="margin: 0;"><strong>Month:</strong> {{ \Carbon\Carbon::create($payroll->year, $payroll->month)->format('F Y') }}</p>
            </div>
        </div>

        <div class="info-row">
            <div class="info-col">
                <div class="section-label">Employee Details</div>
                <div style="font-weight: bold; font-size: 15px;">{{ $payroll->user->name }}</div>
                <div>Email: {{ $payroll->user->email }}</div>
                <div>Designation: {{ $payroll->user->roles->first()->name ?? 'Employee' }}</div>
            </div>
            <div class="info-col right">
                <div class="section-label">Payment Details</div>
                <div>Payslip No: #PAY-{{ str_pad($payroll->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div>Generated On: {{ $payroll->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <table style="width: 100%;">
            <tr>
                <td style="width: 48%; padding: 0; vertical-align: top; border-bottom: none;">
                    <table>
                        <thead>
                            <tr>
                                <th>Earnings</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payroll->details->where('type', 'earning') as $detail)
                                <tr>
                                    <td>{{ $detail->name }}</td>
                                    <td class="text-right">{{ number_format($detail->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td>Total Earnings</td>
                                <td class="text-right">{{ number_format($payroll->basic + $payroll->hra + $payroll->allowance + $payroll->bonus, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
                <td style="width: 4%; border-bottom: none;"></td>
                <td style="width: 48%; padding: 0; vertical-align: top; border-bottom: none;">
                    <table>
                        <thead>
                            <tr>
                                <th>Deductions</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payroll->details->where('type', 'deduction') as $detail)
                                <tr>
                                    <td>{{ $detail->name }}</td>
                                    <td class="text-right text-danger">-{{ number_format($detail->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td>Total Deductions</td>
                                <td class="text-right text-danger">{{ number_format($payroll->total_deduction, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </table>

        <div class="net-salary-box">
            <div class="net-salary-info">
                <div class="net-salary-label">Net Salary Payable</div>
                <div class="net-salary-amount">{{ number_format($payroll->net_salary, 2) }}</div>
            </div>
            <div class="net-salary-words">
                <div style="font-size: 11px; opacity: 0.9;">In Words:</div>
                <div style="font-weight: bold;">{{ ucwords(str_replace('-', ' ', \Illuminate\Support\Str::slug($payroll->net_salary))) }} Only</div>
            </div>
        </div>

        <div class="footer">
            <p>This is a computer-generated payslip and does not require a physical signature.</p>
            <p>&copy; {{ date('Y') }} EliteHR. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
