@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/admin/leaves/pending.css') }}">
@endsection

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        
        <!-- Page Header -->
        <div class="leaves-header">
            <div class="leaves-title">
                <h4>Pending Leave Approvals</h4>
                <p>Manage employee leave requests and make informed decisions</p>
            </div>
            <div class="count-indicator">
                <i class="fa-solid fa-clock-rotate-left me-2"></i> {{ count($leaves) }} Request(s) Pending
            </div>
        </div>

        <!-- History Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table id="zero-config" class="table custom-table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th class="text-center">Days</th>
                            <th>Applied On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper bg-soft-primary me-3">
                                        {{ substr($leave->user->name, 0, 1) }}
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $leave->user->name }}</span>
                                        <small class="text-muted">{{ $leave->user->email ?? 'Staff Member' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-soft-info fw-bold">{{ $leave->leaveType->name }}</span>
                            </td>
                            <td>
                                <div class="small fw-bold text-dark">{{ \Carbon\Carbon::parse($leave->from_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->to_date)->format('d M') }}</div>
                                <div class="text-muted x-small">{{ \Carbon\Carbon::parse($leave->from_date)->format('Y') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-dark">{{ $leave->total_days }}</span>
                            </td>
                            <td>
                                <div class="small text-muted">{{ $leave->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-review" data-bs-toggle="modal" data-bs-target="#actionModal{{ $leave->id }}">
                                   <i class="fa-solid fa-file-pen me-1"></i> Review
                                </button>
                            </td>
                        </tr>

                        <!-- Redesigned Modal -->
                        <div class="modal fade" id="actionModal{{ $leave->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Leave Request Review</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.leaves.action', $leave->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="avatar-wrapper bg-soft-primary me-3" style="width:50px; height:50px; font-size: 1.3rem;">
                                                    {{ substr($leave->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="fw-extrabold mb-0 text-dark">{{ $leave->user->name }}</h6>
                                                    <span class="text-muted small">Application for {{ $leave->leaveType->name }}</span>
                                                </div>
                                            </div>

                                            <div class="leave-details-card mb-4">
                                                <div class="row">
                                                    <div class="col-6 mb-3">
                                                        <div class="info-label">Period</div>
                                                        <div class="info-value">{{ \Carbon\Carbon::parse($leave->from_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}</div>
                                                    </div>
                                                    <div class="col-6 mb-3 text-end">
                                                        <div class="info-label">Total Duration</div>
                                                        <div class="info-value">{{ $leave->total_days }} Business Days</div>
                                                    </div>
                                                    <div class="col-12 mt-2">
                                                        <div class="info-label">Reason for Leave</div>
                                                        <div class="info-value text-secondary small" style="font-style: italic; line-height: 1.5;">"{{ $leave->reason }}"</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="info-label">Review Decision <span class="text-danger">*</span></label>
                                                <select name="status" class="form-select @error('status') is-invalid @enderror" style="height: 50px;">
                                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>✓ Approve Request</option>
                                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>✕ Reject Request</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-0">
                                                <label class="info-label">Administrative Remarks</label>
                                                <textarea name="comment" class="form-control" rows="3" placeholder="Provide feedback to the employee (optional)..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary px-4 fw-bold" style="background: #4f46e5; border: none; height: 45px; border-radius: 10px;">
                                                Finalize Decision
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('asset/js/admin/leaves/pending.js') }}"></script>
@endsection
