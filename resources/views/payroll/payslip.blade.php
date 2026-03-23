@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/payroll/payslip.css') }}">
@endsection

@section('content')
<div class="row layout-top-spacing justify-content-center">
    <div class="col-xl-9 col-lg-10 col-md-12 layout-spacing">
        <div class="widget-content">
            <div class="d-flex justify-content-end mb-4 no-print">
                <button onclick="window.print()" class="btn btn-secondary me-2"><i class="feather-printer"></i> Print</button>
                <a href="{{ route('payroll.index') }}" class="btn btn-outline-primary shadow-none">Back to History</a>
            </div>

            <div class="payslip-container" id="payslip">
                <div class="payslip-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="company-logo mb-1">ELITE<span class="text-dark">HR</span></div>
                        <p class="mb-0 text-muted">Premium Human Resource Management</p>
                    </div>
                    <div class="text-end">
                        <div class="payslip-title">Payslip</div>
                        <p class="mb-0"><strong>Month:</strong> {{ \Carbon\Carbon::create($payroll->year, $payroll->month)->format('F Y') }}</p>
                        <p class="mb-0"><strong>Status:</strong> <span class="badge badge-light-success">{{ ucfirst($payroll->status) }}</span></p>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-6 employee-info">
                        <p class="text-muted text-uppercase mb-2" style="font-size: 11px; letter-spacing: 1px;">Employee Details</p>
                        <h6>{{ $payroll->user->name }}</h6>
                        <p><strong>Email:</strong> {{ $payroll->user->email }}</p>
                        <p><strong>Designation:</strong> {{ $payroll->user->roles->first()->name ?? 'Employee' }}</p>
                        <p><strong>Joining Date:</strong> {{ $payroll->user->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="col-sm-6 text-sm-end employee-info mt-4 mt-sm-0">
                        <p class="text-muted text-uppercase mb-2" style="font-size: 11px; letter-spacing: 1px;">Payment Details</p>
                        <p><strong>Payslip No:</strong> #PAY-{{ str_pad($payroll->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p><strong>Generated On:</strong> {{ $payroll->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 border-end">
                        <table class="table table-payslip">
                            <thead>
                                <tr>
                                    <th>Earnings</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payroll->details->where('type', 'earning') as $detail)
                                    <tr>
                                        <td>{{ $detail->name }}</td>
                                        <td class="text-end">{{ number_format($detail->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td>Total Earnings</td>
                                    <td class="text-end">{{ number_format($payroll->basic + $payroll->hra + $payroll->allowance + $payroll->bonus, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-payslip">
                            <thead>
                                <tr>
                                    <th>Deductions</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payroll->details->where('type', 'deduction') as $detail)
                                    <tr>
                                        <td>{{ $detail->name }}</td>
                                        <td class="text-end text-danger">-{{ number_format($detail->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td>Total Deductions</td>
                                    <td class="text-end text-danger">{{ number_format($payroll->total_deduction, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="net-salary-box d-flex justify-content-between align-items-center">
                    <div>
                        <div class="net-salary-label text-uppercase font-weight-bold">Net Salary Payable</div>
                        <div class="net-salary-amount">{{ number_format($payroll->net_salary, 2) }}</div>
                    </div>
                    <div class="text-end">
                        <p class="mb-0" style="font-size: 12px; opacity: 0.8;">In Words:</p>
                        <p class="mb-0 font-weight-bold">{{ ucwords(str_replace('-', ' ', \Illuminate\Support\Str::slug($payroll->net_salary))) }} Only</p>
                    </div>
                </div>

                <div class="mt-5 pt-5 text-center text-muted" style="font-size: 11px; border-top: 1px dashed #f1f2f3;">
                    <p>This is a computer-generated payslip and does not require a physical signature.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
