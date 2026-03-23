@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="widget-header-content p-4 border-bottom mb-2">
                <h5 class="mb-0 font-weight-bold text-dark">Global Leave History</h5>
                <p class="text-muted mb-0 small">Comprehensive record of all processed leave requests.</p>
            </div>
            <div class="table-responsive px-4 pb-4">
                <table id="history-table" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="ps-0">Employee</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th class="text-center">Days</th>
                            <th class="text-center">Status</th>
                            <th>Processed By</th>
                            <th>Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr>
                            <td class="ps-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <span class="avatar-title rounded-circle badge-light-secondary text-secondary fw-bold">{{ substr($leave->user->name, 0, 1) }}</span>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $leave->user->name }}</span>
                                </div>
                            </td>
                            <td class="fw-medium text-dark">{{ $leave->leaveType->name }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}</span>
                                    <small class="text-muted">to {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-light-dark fw-bold px-3">{{ $leave->total_days }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $leave->status == 'approved' ? 'badge-light-success' : ($leave->status == 'rejected' ? 'badge-light-danger' : 'badge-light-warning') }} px-3">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td class="fw-medium text-dark">{{ $leave->approver ? $leave->approver->name : '-' }}</td>
                            <td class="text-muted small">{{ $leave->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('asset/js/admin/leaves/history.js') }}"></script>
@endsection
