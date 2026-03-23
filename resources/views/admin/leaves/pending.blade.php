@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="widget-header-content p-4 border-bottom mb-2 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold text-dark">Pending Leave Approvals</h5>
                <span class="badge badge-light-primary px-3 py-2">{{ count($leaves) }} Request(s)</span>
            </div>
            <div class="table-responsive px-4 pb-4">
                <table id="pending-table" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="ps-0">Employee</th>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th class="text-center">Total Days</th>
                            <th>Applied On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr>
                            <td class="ps-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <span class="avatar-title rounded-circle badge-light-primary text-primary fw-bold">{{ substr($leave->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $leave->user->name }}</span>
                                        <small class="text-muted">{{ $leave->user->email ?? 'Staff' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-medium text-dark">{{ $leave->leaveType->name }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($leave->from_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->to_date)->format('d M') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($leave->from_date)->format('Y') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-light-dark font-weight-bold px-3">{{ $leave->total_days }}</span>
                            </td>
                            <td>{{ $leave->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#actionModal{{ $leave->id }}">
                                   Review
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="actionModal{{ $leave->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Process Leave: {{ $leave->user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.leaves.action', $leave->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3 text-start">
                                                <strong>Leave Type:</strong> {{ $leave->leaveType->name }}<br>
                                                <strong>Period:</strong> {{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }} to {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}<br>
                                                <strong>Total Days:</strong> {{ $leave->total_days }}<br>
                                                <strong>Reason:</strong> {{ $leave->reason }}
                                            </div>
                                            <div class="mb-3">
                                                <label>Decision <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="approved">Approve</option>
                                                    <option value="rejected">Reject</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Admin Comment</label>
                                                <textarea name="comment" class="form-control" rows="3" placeholder="Add a comment..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit Decision</button>
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
