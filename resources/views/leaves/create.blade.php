@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 mx-auto layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="widget-header-content p-4 border-bottom mb-4">
                <h5 class="mb-0 font-weight-bold text-dark">Apply for Leave</h5>
                <p class="text-muted mb-0 small">Please submit your request with a valid reason.</p>
            </div>
            
            <form action="{{ route('leaves.store') }}" method="POST" class="p-4 pt-0">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="leave_type_id" class="fw-bold text-dark mb-2">Leave Type <span class="text-danger">*</span></label>
                        <select name="leave_type_id" id="leave_type_id" class="form-control form-control-lg shadow-none" required>
                            <option value="">Select Leave Type</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} (Allowed: {{ $type->days_allowed }} days)
                                </option>
                            @endforeach
                        </select>
                        @error('leave_type_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="from_date" class="fw-bold text-dark mb-2">From Date <span class="text-danger">*</span></label>
                        <input type="date" name="from_date" id="from_date" class="form-control form-control-lg shadow-none" value="{{ old('from_date', date('Y-m-d')) }}" required>
                        @error('from_date') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="to_date" class="fw-bold text-dark mb-2">To Date <span class="text-danger">*</span></label>
                        <input type="date" name="to_date" id="to_date" class="form-control form-control-lg shadow-none" value="{{ old('to_date', date('Y-m-d')) }}" required>
                        @error('to_date') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12" id="day-calculation">
                        <div class="alert alert-light-primary mb-0 border-0 shadow-sm py-3 d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">Calculated Duration:</span>
                            <span class="h5 mb-0 fw-bold text-primary"><span id="total-days-count">1</span> Day(s)</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="reason" class="fw-bold text-dark mb-2">Reason for Leave <span class="text-danger">*</span></label>
                        <textarea name="reason" id="reason" rows="4" class="form-control shadow-none" placeholder="Explain the reason for your leave..." required>{{ old('reason') }}</textarea>
                        @error('reason') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('leaves.index') }}" class="btn btn-light-danger btn-lg me-3 px-4 shadow-none">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-none">Submit Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('asset/js/leaves/create.js') }}"></script>
@endsection
