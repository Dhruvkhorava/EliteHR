@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between px-4 pt-4 mb-3">
                <h5 class="mb-0">Quick Salary Statement</h5>
                <a href="{{ route('payroll.statement.export', ['month' => request('month', date('n')), 'year' => request('year', date('Y'))]) }}" class="btn btn-success">Export to Excel</a>
            </div>
            <hr>
            
            <div class="px-4 pb-4">
                <form action="" method="GET" class="row mb-4">
                    <div class="col-md-3">
                        <label>Month</label>
                        <select name="month" class="form-control">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ request('month', date('n')) == $i ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$i,1)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Year</label>
                        <select name="year" class="form-control">
                            @for($i=date('Y'); $i>=2020; $i--)
                                <option value="{{ $i }}" {{ request('year', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary d-block w-100">Filter</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Earnings</th>
                                <th>Deductions</th>
                                <th>Net Pay</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $month = request('month', date('n'));
                                $year = request('year', date('Y'));
                                $payrolls = \App\Models\Payroll::with('user')
                                    ->where('month', $month)
                                    ->where('year', $year)
                                    ->orderBy('created_at', 'desc')
                                    ->get(); 
                            @endphp
                            @foreach($payrolls as $payroll)
                            <tr>
                                <td>{{ $payroll->user->name }}</td>
                                <td>{{ number_format($payroll->net_salary + $payroll->total_deduction, 2) }}</td>
                                <td>{{ number_format($payroll->total_deduction, 2) }}</td>
                                <td><strong>{{ number_format($payroll->net_salary, 2) }}</strong></td>
                                <td><span class="badge badge-light-success">{{ ucfirst($payroll->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
