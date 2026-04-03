@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-8 col-lg-8 col-sm-12 offset-xl-2 offset-lg-2 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="px-4 pt-4 mb-3">
                <h5 class="mb-0">Update Loan Status</h5>
            </div>
            <hr>
            
            <form action="{{ route('loans.update', $loan->id) }}" method="POST" class="px-4 pb-4">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 mb-3 text-center">
                        <h6>Loan Reference: #{{ $loan->id }} - {{ $loan->user->name }}</h6>
                        <p class="text-muted">Amount: {{ number_format($loan->loan_amount, 2) }} | Period: {{ $loan->repayment_period }} Months</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $loan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $loan->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="ongoing" {{ $loan->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ $loan->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="rejected" {{ $loan->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('loans.index') }}" class="btn btn-light-dark mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
