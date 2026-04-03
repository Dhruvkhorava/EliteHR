<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $payroll->user->name }}</title>
    <link rel="stylesheet" href="{{ asset('asset/css/payroll_pdf_payslip.css') }}">
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
