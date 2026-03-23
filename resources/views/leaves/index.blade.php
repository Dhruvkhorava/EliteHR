@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="row">
            @foreach($balances as $balance)
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                <div class="widget widget-card-four h-100 border-0 shadow-sm">
                    <div class="widget-content p-4">
                        <div class="w-header mb-3">
                            <div class="w-info">
                                <h6 class="value text-dark font-weight-bold mb-0">{{ $balance->leaveType->name }}</h6>
                            </div>
                        </div>
                        <div class="w-content">
                            <div class="row text-center g-0">
                                <div class="col-4">
                                    <h4 class="mb-0 fw-bold">{{ $balance->total }}</h4>
                                    <span class="text-muted small fw-medium">Quota</span>
                                </div>
                                <div class="col-4 border-start border-end">
                                    <h4 class="mb-0 fw-bold text-danger">{{ $balance->used }}</h4>
                                    <span class="text-muted small fw-medium">Used</span>
                                </div>
                                <div class="col-4">
                                    <h4 class="mb-0 fw-bold text-success">{{ $balance->remaining }}</h4>
                                    <span class="text-muted small fw-medium">Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="p-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Leave History</h5>
                <a href="{{ route('leaves.create') }}" class="btn btn-primary">Apply Leave</a>
            </div>
            <div class="table-responsive">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Days</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                        <tr>
                            <td>{{ $leave->leaveType->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}</td>
                            <td>{{ $leave->total_days }}</td>
                            <td>{{ Str::limit($leave->reason, 30) }}</td>
                            <td>
                                <span class="badge {{ $leave->status == 'approved' ? 'badge-light-success' : ($leave->status == 'rejected' ? 'badge-light-danger' : 'badge-light-warning') }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td>{{ $leave->created_at->format('d M Y') }}</td>
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
<script src="{{ asset('asset/js/leaves/index.js') }}"></script>
@endsection
