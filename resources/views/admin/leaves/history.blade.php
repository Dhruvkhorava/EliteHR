@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/admin/leaves/history.css') }}">
@endsection

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        
        <!-- Page Header -->
        <div class="leaves-header">
            <div class="leaves-title">
                <h4>Global Leave History</h4>
                <p>Comprehensive record of all processed leave requests across the company</p>
            </div>
            <div class="badge bg-light text-dark fw-bold border py-2 px-3">
                <i class="fa-solid fa-file-invoice me-2"></i> {{ count($leaves) }} Total Records
            </div>
        </div>

        <!-- History Table -->
        <div class="table-container">
                <table id="zero-config" class="table custom-table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Duration Period</th>
                            <th class="text-center">Days</th>
                            <th class="text-center">Status</th>
                            <th>Processed By</th>
                            <th>Applied On</th>
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
                                <div class="small fw-bold text-dark">{{ \Carbon\Carbon::parse($leave->from_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}</div>
                                <div class="text-muted x-small">Application Year: {{ \Carbon\Carbon::parse($leave->from_date)->format('Y') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-dark">{{ $leave->total_days }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = $leave->status == 'approved' ? 'status-badge-approved' : ($leave->status == 'rejected' ? 'status-badge-rejected' : 'status-badge-pending');
                                    $dotClass = $leave->status == 'approved' ? 'dot-approved' : ($leave->status == 'rejected' ? 'dot-rejected' : 'dot-pending');
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <span class="status-dot {{ $dotClass }}"></span>
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td>
                                @if($leave->approver)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-wrapper bg-soft-secondary me-2" style="width:28px; height:28px; font-size: 0.75rem;">
                                            {{ substr($leave->approver->name, 0, 1) }}
                                        </div>
                                        <span class="small fw-bold">{{ $leave->approver->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small">Automatic/System</span>
                                @endif
                            </td>
                            <td>
                                <div class="info-label-small">Submission Date</div>
                                <div class="small text-muted">{{ $leave->created_at->format('d M Y') }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('asset/js/admin/leaves/history.js') }}"></script>
@endsection
