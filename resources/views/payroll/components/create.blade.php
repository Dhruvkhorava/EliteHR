@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-8 col-lg-8 col-sm-12 offset-xl-2 offset-lg-2 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="px-4 pt-4 mb-3">
                <h5 class="mb-0">Create Salary Component</h5>
            </div>
            <hr>
            
            <form action="{{ route('salary-components.store') }}" method="POST" class="px-4 pb-4">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Component Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Basic Salary, PF, HRA" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Type</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">Select Type</option>
                            <option value="earning" {{ old('type') == 'earning' ? 'selected' : '' }}>Earning</option>
                            <option value="deduction" {{ old('type') == 'deduction' ? 'selected' : '' }}>Deduction</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_taxable" value="1" id="is_taxable">
                            <label class="form-check-label" for="is_taxable">Taxable</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_reimbursement" value="1" id="is_reimbursement">
                            <label class="form-check-label" for="is_reimbursement">Reimbursement</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_one_time" value="1" id="is_one_time">
                            <label class="form-check-label" for="is_one_time">One-time</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_recurring" value="1" id="is_recurring" checked>
                            <label class="form-check-label" for="is_recurring">Recurring</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="carry_forward" value="1" id="carry_forward">
                            <label class="form-check-label" for="carry_forward">Carry Forward</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('salary-components.index') }}" class="btn btn-light-dark mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Component</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
