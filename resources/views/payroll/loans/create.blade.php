@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-8 col-lg-8 col-sm-12 offset-xl-2 offset-lg-2 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="px-4 pt-4 mb-3">
                <h5 class="mb-0">Apply for Loan</h5>
            </div>
            <hr>
            
            <form action="{{ route('loans.store') }}" method="POST" class="px-4 pb-4">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Employee</label>
                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Select Employee</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Loan Amount</label>
                        <input type="number" name="loan_amount" class="form-control @error('loan_amount') is-invalid @enderror" step="0.01" value="{{ old('loan_amount') }}">
                        @error('loan_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Interest Rate (%)</label>
                        <input type="number" name="interest_rate" class="form-control @error('interest_rate') is-invalid @enderror" step="0.01" value="{{ old('interest_rate', 0) }}">
                        @error('interest_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Repayment Period (Months)</label>
                        <input type="number" name="repayment_period" class="form-control @error('repayment_period') is-invalid @enderror" value="{{ old('repayment_period') }}">
                        @error('repayment_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('loans.index') }}" class="btn btn-light-dark mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
