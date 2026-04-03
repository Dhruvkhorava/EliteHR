@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/payroll_my_salary.css') }}">
@endpush

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8 p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1 fw-bold">My Salary Dashboard</h4>
                    <p class="text-muted mb-0">Track your earnings and download statements</p>
                </div>
                <a href="{{ route('my-salary.export') }}" class="btn btn-success px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download me-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Export History
                </a>
            </div>

            <div class="row mb-4">
                <!-- Yearly Card -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="stat-card">
                        <div class="icon-box bg-yearly">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        </div>
                        <div class="salary-value">₹ {{ number_format($yearly, 2) }}</div>
                        <div class="salary-label">Yearly Package (CTC)</div>
                    </div>
                </div>
                <!-- Monthly Card -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="stat-card">
                        <div class="icon-box bg-monthly">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </div>
                        <div class="salary-value">₹ {{ number_format($monthly, 2) }}</div>
                        <div class="salary-label">Monthly Gross (Base)</div>
                    </div>
                </div>
                <!-- Daily Card -->
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="icon-box bg-daily">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                        </div>
                        <div class="salary-value">₹ {{ number_format($daily, 2) }}</div>
                        <div class="salary-label">Daily Average Rate</div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h5 class="fw-bold mb-4">Salary History</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Month / Year</th>
                                <th>Basic</th>
                                <th>HRA</th>
                                <th>Bonus</th>
                                <th>Deductions</th>
                                <th class="text-primary">Net Paid</th>
                                <th>Status</th>
                                <th>Payslip</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payrolls as $payroll)
                            <tr>
                                <td>
                                    <strong>{{ date('F', mktime(0, 0, 0, $payroll->month, 1)) }}</strong>
                                    {{ $payroll->year }}
                                </td>
                                <td>{{ number_format($payroll->basic, 2) }}</td>
                                <td>{{ number_format($payroll->hra, 2) }}</td>
                                <td><span class="text-success">+{{ number_format($payroll->bonus, 2) }}</span></td>
                                <td><span class="text-danger">-{{ number_format($payroll->total_deduction, 2) }}</span></td>
                                <td><strong class="text-primary">₹ {{ number_format($payroll->net_salary, 2) }}</strong></td>
                                <td>
                                    <span class="badge {{ $payroll->status == 'paid' ? 'badge-light-success' : 'badge-light-primary' }}">
                                        {{ ucfirst($payroll->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-minus mb-3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="9" y1="13" x2="15" y2="13"></line></svg>
                                        <p class="mb-0">No salary records found yet.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
