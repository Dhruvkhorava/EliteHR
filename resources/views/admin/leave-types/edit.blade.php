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
                                <input type="text" name="name" class="form-control" value="{{ $leaveType->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="days_allowed">Days Allowed (Per Year)</label>
                                <input type="number" name="days_allowed" class="form-control" value="{{ $leaveType->days_allowed }}" min="0" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="carry_forward">Carry Forward</label>
                                <select name="carry_forward" class="form-control" required>
                                    <option value="0" {{ !$leaveType->carry_forward ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $leaveType->carry_forward ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="is_paid">Payment Type</label>
                                <select name="is_paid" class="form-control" required>
                                    <option value="1" {{ $leaveType->is_paid ? 'selected' : '' }}>Paid</option>
                                    <option value="0" {{ !$leaveType->is_paid ? 'selected' : '' }}>Unpaid</option>
                                </select>
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
