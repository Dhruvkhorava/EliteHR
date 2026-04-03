@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    <link rel="stylesheet" href="{{ asset('asset/css/attendance_index.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <div class="w-header mb-4 d-flex justify-content-between align-items-center">
                        <div class="w-info">
                            <h6 class="value text-primary font-weight-bold">Task Scheduler & Attendance</h6>
                        </div>
                        <div class="task-action">
                            <span class="badge badge-light-primary px-3 py-2 fs-6">{{ now('Asia/Kolkata')->format('l, d M Y') }}</span>
                        </div>
                    </div>

                    <div class="row align-items-center py-3">
                        <div class="col-md-4 text-center border-md-end mb-md-0 mb-4">
                            <div class="p-2">
                                <h1 class="mb-0 display-5 font-weight-bold text-dark" id="current-time" 
                                    data-server-now="{{ now('Asia/Kolkata')->toIso8601String() }}">
                                    {{ now('Asia/Kolkata')->format('h:i:s A') }}
                                </h1>
                                <p class="text-muted mb-0 fw-medium">Current Time</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center border-md-end mb-md-0 mb-4">
                            <div class="p-2">
                                @if($user->shift)
                                    <h3 class="mb-1 font-weight-bold text-info">{{ \Carbon\Carbon::parse($user->shift->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($user->shift->end_time)->format('h:i A') }}</h3>
                                    <p class="text-muted mb-0 fw-medium">Assigned Shift: <span class="text-dark">{{ $user->shift->name }}</span></p>
                                @else
                                    <h4 class="mb-0 text-warning">No Shift Assigned</h4>
                                    <p class="text-muted mb-0">Please contact HR</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 px-lg-5">
                            <div class="text-center p-2">
                                @if (!$attendance || !$attendance->check_in)
                                    <form action="{{ route('attendance.check-in') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-none py-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in me-2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg> Confirm Check-In
                                        </button>
                                    </form>
                                @elseif($attendance && !$attendance->check_out)
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <span class="badge badge-success px-3 me-2">Active Session</span>
                                        <span class="text-dark fw-bold" id="session-info" 
                                            data-check-in="{{ \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->check_in)->toIso8601String() }}"
                                            data-on-break="{{ $attendance->is_on_break ? '1' : '0' }}"
                                            data-break-start="{{ $attendance->current_break_start ? \Carbon\Carbon::parse($attendance->current_break_start)->toIso8601String() : '' }}"
                                            data-total-break-seconds="{{ $attendance->total_break_seconds }}">
                                            In @ {{ \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') }}
                                        </span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if(!$attendance->is_on_break)
                                            <form action="{{ route('attendance.start-break') }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-lg w-100 shadow-none py-3 h-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee me-2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg> Start Break
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('attendance.stop-break') }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-lg w-100 shadow-none py-3 h-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play me-2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg> Resume Work
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('attendance.check-out') }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-lg w-100 shadow-none py-3 h-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out me-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Check-Out
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-light-primary mb-0 text-center border-0 shadow-sm py-3">
                                        <h5 class="mb-1 text-primary font-weight-bold">Work Day Completed</h5>
                                        <p class="mb-0 text-dark">{{ $attendance->working_hours }} Hours Logged Today</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex align-items-center">
                                <span class="text-muted fw-medium me-3">Current Status:</span>
                                <span class="badge {{ $attendance && $attendance->status == 'late' ? 'badge-light-danger' : 'badge-light-success' }} px-3">
                                    {{ ucfirst($attendance->status ?? 'Not Checked In') }}
                                </span>
                            </div>
                            <div class="col-md-6 text-md-end mt-md-0 mt-3">
                                @if($attendance && $attendance->check_in)
                                    <div class="d-flex flex-column align-items-md-end">
                                        <div>
                                            <span class="text-muted fw-medium me-2">Today's Duration: </span>
                                            <span class="h5 mb-0 font-weight-bold text-primary" id="work-timer">
                                                {{ $attendance->working_hours ?? '0.00' }} h
                                            </span>
                                        </div>
                                        @if($attendance->is_on_break || $attendance->total_break_seconds > 0)
                                            <div>
                                                <span class="text-muted small fw-medium me-2">Total Break: </span>
                                                <span class="text-warning fw-bold" id="break-timer">
                                                    {{ floor($attendance->total_break_seconds / 60) }} m
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <!-- Logs & Requests Header -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 fw-bold me-4">Logs & Requests</h4>
                    <ul class="nav nav-pills attendance-tab-nav" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-log-tab" data-bs-toggle="pill" data-bs-target="#pills-log" type="button" role="tab">Attendance Log</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-request-tab" data-bs-toggle="pill" data-bs-target="#pills-request" type="button" role="tab">
                                Attendance Requests <span class="badge badge-danger rounded-circle ms-1" style="padding: 2px 6px; font-size: 10px;">{{ $pendingRequestsCount }}</span>
                            </button>
                        </li>
                    </ul>
                </div>
                {{-- <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" id="hourFormat">
                    <label class="form-check-label mb-0 text-muted small fw-bold" for="hourFormat">24 hour format</label>
                </div> --}}
            </div>

            <div class="tab-content" id="pills-tabContent">
                <!-- Attendance Log Tab -->
                <div class="tab-pane fade show active" id="pills-log" role="tabpanel">
                    <div class="widget widget-card-four mb-0" style="padding: 0; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">{{ request('month') ? \Carbon\Carbon::createFromDate(null, request('month'), 1)->format('F Y') : 'Last 30 Days' }}</h5>
                            <div class="d-flex gap-2">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('attendance.index', ['days' => 30]) }}" class="btn btn-filter {{ !request('month') ? 'active' : '' }}">30 Days</a>
                                    @php
                                        $displayMonths = [
                                            now()->month => now()->format('M'),
                                            now()->subMonth()->month => now()->subMonth()->format('M'),
                                            now()->subMonths(2)->month => now()->subMonths(2)->format('M'),
                                            now()->subMonths(3)->month => now()->subMonths(3)->format('M'),
                                            now()->subMonths(4)->month => now()->subMonths(4)->format('M'),
                                        ];
                                    @endphp
                                    @foreach($displayMonths as $num => $name)
                                        <a href="{{ route('attendance.index', ['month' => $num]) }}" class="btn btn-filter {{ request('month') == $num ? 'active' : '' }}">{{ $name }}</a>
                                    @endforeach
                                </div>
                                {{-- <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-filter active">12 hr format</button>
                                    <button type="button" class="btn btn-filter">24 hr format</button>
                                </div> --}}
                                {{-- <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-filter active px-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg></button>
                                    <button type="button" class="btn btn-filter px-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></button>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="widget widget-table-two" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table attendance-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%">Date</th>
                                            <th style="width: 30%">Attendance Visual</th>
                                            <th style="width: 15%">Effective Hours</th>
                                            <th style="width: 15%">Gross Hours</th>
                                            <th style="width: 15%">Arrival</th>
                                            <th style="width: 10%">Log</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $period = collect($startDate->daysUntil($endDate))->reverse();
                                        @endphp
                                        @foreach($period as $date)
                                            @php
                                                $dateStr = $date->toDateString();
                                                $record = $history->firstWhere('date', $dateStr);
                                                $leave = $leaves->filter(function($l) use ($dateStr) {
                                                    return $dateStr >= $l->from_date && $dateStr <= $l->to_date;
                                                })->first();
                                                $isWeekend = $date->isWeekend();
                                            @endphp

                                            @if($leave)
                                                <tr class="row-leave" data-bs-toggle="tooltip" data-bs-placement="top" title="Leave: {{ $leave->leaveType->name }} (Approved)">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $date->format('M d, D') }}</span>
                                                            <span class="badge badge-leave small px-1 py-0" style="font-size: 10px;">LEAVE</span>
                                                        </div>
                                                    </td>
                                                    <td colspan="5" class="text-center py-3">
                                                        <span class="text-muted small fw-bold uppercase">ON {{ strtoupper($leave->leaveType->name) }}</span>
                                                    </td>
                                                </tr>
                                            @elseif($isWeekend && !$record)
                                                <tr class="row-special">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $date->format('M d, D') }}</span>
                                                            <span class="badge badge-woff small px-1 py-0" style="font-size: 10px;">W-OFF</span>
                                                        </div>
                                                    </td>
                                                    <td colspan="5" class="py-3">WEEKLY-OFF</td>
                                                </tr>
                                            @elseif(!$record && !$date->isToday())
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $date->format('M d, D') }}</span>
                                                        </div>
                                                    </td>
                                                    <td colspan="4" class="text-center py-3 text-muted small fw-bold">NO TIME ENTRIES LOGGED</td>
                                                    <td class="text-center">
                                                        <span class="text-muted">...</span>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr @if($record) data-bs-toggle="tooltip" data-bs-placement="top" title="In: {{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '-' }} | Out: {{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('h:i A') : 'Active' }}" @endif>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $date->format('M d, D') }}</span>
                                                            @if($record && $record->status == 'present' && $record->working_hours > 8)
                                                                <span class="badge badge-wfh small px-1 py-0" style="font-size: 10px;">WFH</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($record)
                                                            @php
                                                                $totalShiftSeconds = 9 * 3600; // 9 hours standard
                                                                $workingSeconds = $record->working_hours * 3600;
                                                                $breakSeconds = $record->total_break_seconds ?? 0;
                                                                
                                                                $workWidth = ($workingSeconds / $totalShiftSeconds) * 100;
                                                                $breakWidth = ($breakSeconds / $totalShiftSeconds) * 100;
                                                                $startOffset = 25; // Simulating start at 9:00 or similar
                                                            @endphp
                                                            <div class="attendance-visual" data-bs-toggle="tooltip" title="Worked: {{ number_format($record->working_hours, 2) }}h | Break: {{ round($breakSeconds/60) }}m">
                                                                <div class="visual-segment segment-work" style="width: {{ $workWidth / 2 }}%; margin-left: {{ $startOffset }}%;"></div>
                                                                @if($breakWidth > 2)
                                                                    <div class="visual-segment segment-break" style="width: {{ $breakWidth }}%;"></div>
                                                                @endif
                                                                <div class="visual-segment segment-work" style="width: {{ $workWidth / 2 }}%;"></div>
                                                            </div>
                                                            <div class="timeline-markers small">
                                                                @for($i=0; $i<12; $i++) <div class="marker"></div> @endfor
                                                            </div>
                                                        @else
                                                            <div class="text-center">
                                                                <span class="badge badge-light-primary rounded-pill px-3 py-1" style="font-size: 10px; cursor: pointer;">Apply Leave</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="hours-circle {{ $record && $record->working_hours >= 8 ? 'circle-full' : 'circle-half' }}"></div>
                                                            <span>{{ $record ? number_format($record->working_hours, 2) : '0.00' }} hrs</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $record ? number_format($record->working_hours, 2) : '0.00' }} hrs</td>
                                                    <td>
                                                        @if($record && $record->check_in)
                                                            @php
                                                                $isLate = false;
                                                                $lateDiff = '';
                                                                if ($user->shift) {
                                                                    $checkInTime = \Carbon\Carbon::parse($record->check_in);
                                                                    $shiftStartTime = \Carbon\Carbon::parse($user->shift->start_time)->addMinutes($user->shift->grace_period);
                                                                    if ($checkInTime->greaterThan($shiftStartTime)) {
                                                                        $isLate = true;
                                                                        $diff = $checkInTime->diff($shiftStartTime);
                                                                        $lateDiff = sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
                                                                    }
                                                                }
                                                            @endphp
                                                            @if($isLate)
                                                                <span class="text-dark small fw-bold">{{ $lateDiff }} Late <span style="font-size: 16px;">🐌</span></span>
                                                            @else
                                                                <span class="text-dark small">On Time</span>
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($record && $record->check_out)
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00abff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                        @elseif($record)
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e2a03f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                        @else
                                                            <span class="text-muted">...</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Requests Tab Content -->
                <div class="tab-pane fade" id="pills-request" role="tabpanel">
                    @if($pendingRequestsCount > 0)
                        <div class="widget widget-table-two mt-0">
                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table attendance-table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Total Days</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingRequests as $req)
                                                <tr>
                                                    <td><span class="badge badge-leave rounded-pill px-3">{{ $req->leaveType->name }}</span></td>
                                                    <td>{{ \Carbon\Carbon::parse($req->from_date)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($req->to_date)->format('d M Y') }}</td>
                                                    <td>{{ $req->total_days }}</td>
                                                    <td><small class="text-muted">{{ Str::limit($req->reason, 30) }}</small></td>
                                                    <td><span class="badge badge-light-warning">Pending Review</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="widget widget-card-four text-center py-5">
                            <div class="py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bfc9d4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <h5 class="mt-3 text-muted">No pending requests</h5>
                                <p class="text-muted small">All your attendance adjustment and leave requests will appear here.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('asset/js/attendance/index.js') }}"></script>
    <script src="{{ asset('asset/js/attendance_index_ui.js') }}"></script>
@endsection
