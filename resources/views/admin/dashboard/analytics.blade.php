@extends('layouts.app')

@section('styles')
{{-- <link href="https://designreset.com/cork/html/src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="https://designreset.com/cork/html/src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<link href="https://designreset.com/cork/html/src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" /> --}}


{{-- @vite(['resources/scss/light/assets/components/modal.scss']) --}}
<link rel="stylesheet" href="{{asset('plugins/src/apex/apexcharts.css')}}">
@vite(['resources/scss/light/assets/dashboard/dash_1.scss'])
@vite(['resources/scss/dark/assets/dashboard/dash_1.scss'])
{{-- <link href="../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<link href="../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('content')
<div class="row layout-top-spacing">

    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-six">
            <div class="widget-heading">
                <h6 class="">Statistics</h6>
                <div class="task-action">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="statistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu left" aria-labelledby="statistics" style="will-change: transform;">
                            <a class="dropdown-item" href="javascript:void(0);">View</a>
                            <a class="dropdown-item" href="javascript:void(0);">Download</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-chart">
                <div class="w-chart-section">
                    <div class="w-detail">
                        <p class="w-title">Total Employees</p>
                        <p class="w-stats">{{ $totalEmployees }}</p>
                    </div>
                    <div class="w-chart-render-one">
                        <div id="total-users"></div>
                    </div>
                </div>

                <div class="w-chart-section">
                    <div class="w-detail">
                        <p class="w-title">Total Candidates</p>
                        <p class="w-stats">{{ $totalCandidates }}</p>
                    </div>
                    <div class="w-chart-render-one">
                        <div id="paid-visits"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-card-four">
            <div class="widget-content">
                <div class="w-header">
                    <div class="w-info">
                        <h6 class="value">Open Jobs</h6>
                    </div>
                    <div class="task-action">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="expenses" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                            </a>

                            <div class="dropdown-menu left" aria-labelledby="expenses" style="will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-content">

                    <div class="w-info">
                        <p class="value">{{ $openJobs }} <span>open positions</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></p>
                    </div>
                    
                </div>

                <div class="w-progress-stats">                                            
                    <div class="progress">
                        <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="">
                        <div class="w-icon">
                            <p>57%</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-card-five">
            <div class="widget-content">
                <div class="account-box">

                    <div class="info-box">
                        <div class="icon">
                            <span>
                                <img src="{{Vite::asset('resources/images/money-bag.png')}}" alt="money-bag">
                            </span>
                        </div>

                        <div class="balance-info">
                            <h6>Payroll Expenses</h6>
                            <p>${{ number_format($totalPayrollThisMonth, 2) }}</p>
                        </div>
                    </div>

                    <div class="card-bottom-section">
                        <div><span class="badge badge-light-success">+ 13.6% <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></span></div>
                        <a href="javascript:void(0);" class="">View Report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-chart-three">
            <div class="widget-heading">
                <div class="">
                    <h5 class="">Attendance Trend (Last 7 Days)</h5>
                </div>

                <div class="task-action">
                    <div class="dropdown ">
                        <a class="dropdown-toggle" href="#" role="button" id="uniqueVisitors" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu left" aria-labelledby="uniqueVisitors">
                            <a class="dropdown-item" href="javascript:void(0);">View</a>
                            <a class="dropdown-item" href="javascript:void(0);">Update</a>
                            <a class="dropdown-item" href="javascript:void(0);">Download</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-content">
                <div id="uniqueVisits"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-activity-five">

            <div class="widget-heading">
                <h5 class="">Activity Log</h5>

                <div class="task-action">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="activitylog" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu left" aria-labelledby="activitylog" style="will-change: transform;">
                            <a class="dropdown-item" href="javascript:void(0);">View All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Mark as Read</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-content">

                <div class="w-shadow-top"></div>

                <div class="mt-container mx-auto">
                    <div class="timeline-line">
                        @foreach($recentLeaves as $leave)
                        <div class="item-timeline timeline-new">
                            <div class="t-dot">
                                <div class="t-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></div>
                            </div>
                            <div class="t-content">
                                <div class="t-uppercontent">
                                    <h5>Leave requested by <a href="javascript:void(0);">{{ $leave->user ? $leave->user->name : 'User' }}</a></h5>
                                </div>
                                <p>{{ $leave->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                        
                        @foreach($recentCandidates as $candidate)
                        <div class="item-timeline timeline-new">
                            <div class="t-dot">
                                <div class="t-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
                            </div>
                            <div class="t-content">
                                <div class="t-uppercontent">
                                    <h5>New candidate added: <a href="javascript:void(0);">{{ $candidate->first_name }} {{ $candidate->last_name }}</a></h5>
                                </div>
                                <p>{{ $candidate->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>                                    
                </div>

                <div class="w-shadow-bottom"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget-four">
            <div class="widget-heading">
                <h5 class="">Leave Type Breakdown</h5>
            </div>
            <div class="widget-content">
                <div class="vistorsBrowser">
                    @foreach($leaveTypes as $type)
                    <div class="browser-list">
                        <div class="w-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        </div>
                        <div class="w-browser-details">
                            <div class="w-browser-info">
                                <h6>{{ $type->name }}</h6>
                                <p class="browser-count">{{ round(($type->leaves_count / $totalLeaveRequests) * 100) }}%</p>
                            </div>
                            <div class="w-browser-stats">
                                <div class="progress">
                                    <div class="progress-bar bg-gradient-{{ ['primary', 'danger', 'success', 'warning'][ $loop->index % 4 ] }}" role="progressbar" style="width: {{ ($type->leaves_count / $totalLeaveRequests) * 100 }}%" aria-valuenow="{{ $type->leaves_count }}" aria-valuemin="0" aria-valuemax="{{ $totalLeaveRequests }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($leaveTypes->isEmpty())
                    <div class="text-center py-4">
                        <p>No leave data available for this year.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="row widget-statistic">

            {{-- Attendance Today --}}
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-followers">
                    <div class="widget-heading">
                        <div class="w-title">
                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                            <div class="">
                                <p class="w-value">{{ $attendanceToday }}</p>
                                <h5 class="">Attendance Today</h5>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">
                        <div class="w-chart">
                            <div id="hybrid_followers"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pending Leaves --}}
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-referral">
                    <div class="widget-heading">
                        <div class="w-title">
                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </div>
                            <div class="">
                                <p class="w-value">{{ $pendingLeaves }}</p>
                                <h5 class="">Pending Leaves</h5>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">
                        <div class="w-chart">
                            <div id="hybrid_followers1"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Active Goals --}}
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-engagement">
                    <div class="widget-heading">
                        <div class="w-title">
                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                            </div>
                            <div class="">
                                <p class="w-value">{{ $activeGoals }}</p>
                                <h5 class="">Active Goals</h5>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">
                        <div class="w-chart">
                            <div id="hybrid_followers3"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-five">
            <div class="widget-heading">
                <a href="javascript:void(0)" class="task-info">
                    <div class="usr-avatar">
                        <span>{{ substr($latestUser->name ?? 'U', 0, 1) }}</span>
                    </div>
                    <div class="w-title">
                        <h5>Newly Joined</h5>
                        <span>{{ $latestUser->name ?? 'No User' }}</span>
                    </div>
                </a>
            </div>
            <div class="widget-content">
                <p>Welcome our newest team member who joined on {{ $latestUser ? $latestUser->created_at->format('M d, Y') : 'N/A' }}.</p>
                <div class="progress-data">
                    <div class="progress-info">
                        <div class="task-count"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg><p>Onboarding</p></div>
                        <div class="progress-stats"><p>100%</p></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="meta-info">
                    <div class="due-time">
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> {{ $latestUser->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-card-one">
            <div class="widget-content">
                <div class="media">
                    <div class="w-img">
                         @if($latestUser && $latestUser->image)
                            <img src="{{ asset('storage/' . $latestUser->image) }}" alt="avatar">
                        @else
                            <img src="{{ Vite::asset('resources/images/profile-19.jpeg') }}" alt="avatar">
                        @endif
                    </div>
                    <div class="media-body">
                        <h6>{{ $latestUser->name ?? 'N/A' }}</h6>
                        <p class="meta-date-time">{{ $latestUser ? $latestUser->created_at->format('l, M d') : 'N/A' }}</p>
                    </div>
                </div>
                <p>New employee joined the team. Please ensure all onboarding tasks are completed promptly.</p>
                <div class="w-action">
                    <div class="card-like">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span>New Member</span>
                    </div>
                    <div class="read-more">
                        <a href="{{ route('employees.index') }}">View Team <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
        <div class="widget widget-card-two">
            <div class="widget-content">
                <div class="media">
                    <div class="w-img">
                        <img src="{{Vite::asset('resources/images/money-bag.png')}}" alt="avatar">
                    </div>
                    <div class="media-body">
                        <h6>Latest Payroll</h6>
                        <p class="meta-date-time">{{ $latestPayroll ? Carbon\Carbon::create()->month($latestPayroll->month)->format('F') . ' ' . $latestPayroll->year : 'N/A' }}</p>
                    </div>
                </div>
                <div class="card-bottom-section">
                    <h5>{{ $latestPayroll->user->name ?? 'N/A' }}</h5>
                    <p class="mb-2">Net Salary: <strong>${{ number_format($latestPayroll->net_salary ?? 0, 2) }}</strong></p>
                    <a href="{{ route('payroll.index') }}" class="btn">View All</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script src="{{asset('plugins/src/apex/apexcharts.min.js')}}"></script>

<script>
    // Dynamic data passed from the DashboardController
    window.dashboardData = {
        attendanceLabels : {!! $last7DaysLabels !!},
        attendanceSeries : {!! $last7DaysData !!},
        leaveSeries      : {!! $leaveTrendData !!},
        totalEmployees   : {{ $totalEmployees }},
        attendanceToday  : {{ $attendanceToday }},
        pendingLeaves    : {{ $pendingLeaves }},
        activeGoals      : {{ $activeGoals }},
    };
</script>

@vite(['resources/js/dashboard/dash_1.js'])

@endsection