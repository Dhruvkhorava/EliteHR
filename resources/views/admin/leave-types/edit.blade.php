@extends('layouts.app')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 mb-3">
                    <h5 class="mb-0">{{ $title }}</h5>
                    <a href="{{ route('leave-types.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
                <hr>
                <div class="px-4 pb-4">
                    <form action="{{ route('leave-types.update', $leaveType->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name">Leave Type Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $leaveType->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="days_allowed">Days Allowed (Per Year)</label>
                                <input type="number" name="days_allowed" class="form-control @error('days_allowed') is-invalid @enderror" value="{{ old('days_allowed', $leaveType->days_allowed) }}" min="0">
                                @error('days_allowed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="carry_forward">Carry Forward</label>
                                <select name="carry_forward" class="form-control @error('carry_forward') is-invalid @enderror">
                                    <option value="0" {{ old('carry_forward', $leaveType->carry_forward) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('carry_forward', $leaveType->carry_forward) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('carry_forward')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="is_paid">Payment Type</label>
                                <select name="is_paid" class="form-control @error('is_paid') is-invalid @enderror">
                                    <option value="1" {{ old('is_paid', $leaveType->is_paid) == '1' ? 'selected' : '' }}>Paid</option>
                                    <option value="0" {{ old('is_paid', $leaveType->is_paid) == '0' ? 'selected' : '' }}>Unpaid</option>
                                </select>
                                @error('is_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Update Leave Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
