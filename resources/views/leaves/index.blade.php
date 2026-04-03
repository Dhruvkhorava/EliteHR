@extends('layouts.app')

@section('styles')
<style>
    /* Premium Dashboard Header - Renamed to avoid conflicts */
    .leaves-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 0 5px;
    }
    .leaves-title h4 {
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.25rem;
        letter-spacing: -0.025em;
    }
    .leaves-title p {
        color: #64748b;
        font-size: 0.95rem;
    }

    /* Glassmorphism Balance Cards */
    .leave-balance-card {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    }
    .leave-balance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .card-gradient-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
    }
    .gradient-primary { background: linear-gradient(90deg, #6366f1 0%, #a855f7 100%); }
    .gradient-success { background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%); }
    .gradient-warning { background: linear-gradient(90deg, #f59e0b 0%, #ef4444 100%); }
    .gradient-info { background: linear-gradient(90deg, #0ea5e9 0%, #2563eb 100%); }

    .card-icon-wrapper {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-bottom: 1.25rem;
        font-size: 1.25rem;
    }
    .bg-soft-primary { background-color: rgba(99, 102, 241, 0.1); color: #6366f1; }
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .bg-soft-info { background-color: rgba(14, 165, 233, 0.1); color: #0ea5e9; }

    .balance-value {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
        color: #1e293b;
    }
    .balance-label {
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* Modern Table Styling */
    .table-container {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .custom-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #f1f5f9;
        white-space: nowrap;
    }
    .custom-table tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        color: #334155;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }
    
    /* Vibrant Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        white-space: nowrap;
    }
    .status-badge-approved { background-color: #dcfce7; color: #15803d; }
    .status-badge-pending { background-color: #fef9c3; color: #854d0e; }
    .status-badge-rejected { background-color: #fee2e2; color: #b91c1c; }
    
    .status-dot { width: 6px; height: 6px; border-radius: 50%; opacity: 0.8; }
    .dot-approved { background-color: #15803d; }
    .dot-pending { background-color: #854d0e; }
    .dot-rejected { background-color: #b91c1c; }

    /* Action Buttons */
    .btn-apply {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
        padding: 0.75rem 1.75rem;
        border-radius: 12px;
        font-weight: 700;
        color: white;
        transition: all 0.3s;
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        white-space: nowrap;
    }
    .btn-apply:hover {
        transform: scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        
        <!-- Page Header -->
        <div class="leaves-header">
            <div class="leaves-title">
                <h4>My Leave Management</h4>
                <p>Track your leave balances and history with real-time updates</p>
            </div>
            <a href="{{ route('leaves.create') }}" class="btn btn-apply">
                <i class="fa-solid fa-plus me-2"></i> Apply New Leave
            </a>
        </div>

        <!-- Balance Stats -->
        <div class="row">
            @php
                $icons = [
                    'Sick' => 'fa-hospital',
                    'Casual' => 'fa-umbrella-beach',
                    'Annual' => 'fa-calendar-check',
                    'Earned' => 'fa-briefcase-clock',
                    'Maternity' => 'fa-baby',
                    'Paternity' => 'fa-person-breastfeeding',
                    'Emergency' => 'fa-kit-medical'
                ];
                $gradients = ['gradient-primary', 'gradient-success', 'gradient-warning', 'gradient-info'];
                $softColors = ['bg-soft-primary', 'bg-soft-success', 'bg-soft-warning', 'bg-soft-info'];
            @endphp

            @foreach($balances as $index => $balance)
            @php
                $type = $balance->leaveType->name;
                $icon = $icons[$type] ?? 'fa-clock-rotate-left';
                $gradientClass = $gradients[$index % count($gradients)];
                $softColorClass = $softColors[$index % count($softColors)];
            @endphp
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                <div class="card leave-balance-card h-100">
                    <div class="card-gradient-overlay {{ $gradientClass }}"></div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon-wrapper {{ $softColorClass }}">
                                <i class="fa-solid {{ $icon }}"></i>
                            </div>
                            <span class="badge rounded-pill bg-light text-dark fw-bold border">{{ $type }}</span>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="balance-value mb-1">{{ $balance->remaining }}</h4>
                            <span class="balance-label">Remaining Days</span>
                        </div>

                        <div class="row text-center mt-3 pt-3 border-top g-0">
                            <div class="col-6 border-end">
                                <span class="d-block balance-label small mb-1">Total Quota</span>
                                <span class="fw-bold text-dark">{{ $balance->total }}</span>
                            </div>
                            <div class="col-6">
                                <span class="d-block balance-label small mb-1">Used Days</span>
                                <span class="fw-bold text-danger">{{ $balance->used }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- History Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="table-container shadow-sm border-0">
                    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                        <h5 class="fw-bold text-dark mb-0">Leave History Timeline</h5>
                        <div class="text-muted small fw-medium">
                            Total records: {{ $leaves->count() }}
                        </div>
                    </div>
                  
                        <table id="zero-config" class="table custom-table dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Duration</th>
                                    <th>Total Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Applied On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $leave)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon-wrapper bg-light text-primary mb-0 me-3" style="width:32px; height:32px; font-size: 0.9rem;">
                                                <i class="fa-solid {{ $icons[$leave->leaveType->name] ?? 'fa-file-lines' }}"></i>
                                            </div>
                                            <span class="fw-bold">{{ $leave->leaveType->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small fw-bold">{{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}</div>
                                        <div class="text-muted x-small">to {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-info px-3">{{ $leave->total_days }} Days</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary small" title="{{ $leave->reason }}">
                                            {{ Str::limit($leave->reason, 25) }}
                                        </span>
                                    </td>
                                    <td>
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
                                        <div class="small text-muted">{{ $leave->created_at->format('d M Y') }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('asset/js/leaves/index.js') }}"></script>
@endsection
