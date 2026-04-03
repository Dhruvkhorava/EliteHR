@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between px-4 pt-4 mb-3">
                <h5 class="mb-0">Loan Details - {{ $loan->user->name }}</h5>
                <a href="{{ route('loans.index') }}" class="btn btn-light-dark">Back</a>
            </div>
            <hr>
            
            <div class="row px-4">
                <div class="col-md-4 mb-4">
                    <div class="card p-3 shadow-none border">
                        <h6 class="mb-3">Loan Overview</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Principal:</strong> {{ number_format($loan->loan_amount, 2) }}</li>
                            <li class="mb-2"><strong>Interest:</strong> {{ number_format($loan->total_payable - $loan->loan_amount, 2) }}</li>
                            <li class="mb-2"><strong>Total Payable:</strong> {{ number_format($loan->total_payable, 2) }}</li>
                            <li class="mb-2"><strong>Installment:</strong> {{ number_format($loan->monthly_installment, 2) }}</li>
                            <li class="mb-2"><strong>Balance:</strong> {{ number_format($loan->balance_amount, 2) }}</li>
                            <li class="mb-2"><strong>Status:</strong> <span class="badge badge-light-primary">{{ ucfirst($loan->status) }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <h6>Repayment Schedule / History</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payroll Reference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($loan->repayments as $repayment)
                                <tr>
                                    <td>{{ $repayment->payment_date }}</td>
                                    <td>{{ number_format($repayment->amount, 2) }}</td>
                                    <td>#{{ $repayment->payroll_id ?? 'Manual' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No repayments recorded yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
