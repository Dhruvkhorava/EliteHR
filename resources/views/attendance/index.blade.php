@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
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
                                            In @ {{ \Carbon\Carbon::parse($attendance->check_in)->setTimezone('Asia/Kolkata')->format('h:i A') }}
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
            <div class="widget widget-table-two">
                <div class="widget-heading px-4 pt-4">
                    <h5 class="">Attendance History</h5>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="attendance-history-table" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="th-content">Date</div>
                                    </th>
                                    <th>
                                        <div class="th-content">Check In</div>
                                    </th>
                                    <th>
                                        <div class="th-content">Check Out</div>
                                    </th>
                                    <th>
                                        <div class="th-content">Working Hours</div>
                                    </th>
                                    <th>
                                        <div class="th-content">Status</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                                        <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->setTimezone('Asia/Kolkata')->format('h:i A') : '-' }}
                                        </td>
                                        <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->setTimezone('Asia/Kolkata')->format('h:i A') : '-' }}
                                        </td>
                                        <td>{{ $record->working_hours ?? '-' }}</td>
                                        <td>
                                            @php
                                                $badgeClass =
                                                    [
                                                        'present' => 'badge-light-success',
                                                        'late' => 'badge-light-warning',
                                                        'absent' => 'badge-light-danger',
                                                        'half_day' => 'badge-light-info',
                                                    ][$record->status] ?? 'badge-light-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ ucfirst($record->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/attendance/index.js') }}"></script>
@endsection
