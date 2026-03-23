@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 mb-3">
                    <h5 class="mb-0">Payroll History</h5>
                    <div>
                        <a href="{{ route('payroll.setup') }}" class="btn btn-secondary">Salary Setup</a>
                        <a href="{{ route('payroll.generate') }}" class="btn btn-primary">Generate Payroll</a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive px-4 pb-4">
                    <table id="payroll-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month/Year</th>
                                <th>Gross Salary</th>
                                <th>Deductions</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payrolls as $payroll)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($payroll->user->image)
                                                <img src="{{ asset('storage/' . $payroll->user->image) }}"
                                                    class="rounded-circle me-2" width="30" height="30"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center text-white"
                                                    style="width: 30px; height: 30px;">
                                                    {{ substr($payroll->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span>{{ $payroll->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::create($payroll->year, $payroll->month)->format('F Y') }}</td>
                                    <td>{{ number_format($payroll->basic + $payroll->hra + $payroll->allowance + $payroll->bonus, 2) }}</td>
                                    <td>{{ number_format($payroll->total_deduction, 2) }}</td>
                                    <td><strong>{{ number_format($payroll->net_salary, 2) }}</strong></td>
                                    <td>
                                        <span class="badge {{ $payroll->status == 'paid' ? 'badge-light-success' : 'badge-light-primary' }}">
                                            {{ ucfirst($payroll->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-sm btn-outline-primary">View Payslip</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/payroll/index.js') }}"></script>
@endsection
