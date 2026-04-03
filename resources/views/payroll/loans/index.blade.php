@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between px-4 pt-4 mb-3">
                <h5 class="mb-0">Employee Loans</h5>
                <a href="{{ route('loans.create') }}" class="btn btn-primary">Apply for Loan</a>
            </div>
            <hr>
            
            <div class="table-responsive px-4 pb-4">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Amount</th>
                            <th>Installment</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                        <tr>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ number_format($loan->loan_amount, 2) }}</td>
                            <td>{{ number_format($loan->monthly_installment, 2) }}</td>
                            <td>{{ number_format($loan->balance_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $loan->status == 'approved' ? 'badge-success' : ($loan->status == 'pending' ? 'badge-warning' : 'badge-danger') }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('loans.show', $loan->id) }}" class="btn btn-sm btn-info">View</a>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                                    <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-sm btn-secondary">Status</a>
                                    @endif
                                </div>
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
