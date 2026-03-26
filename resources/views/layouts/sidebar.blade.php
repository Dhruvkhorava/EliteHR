{{-- @extends('layouts.app') --}}

{{-- @section('sidebar') --}}
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ getRouterValue() }}dashboard/analytics">
                        @if(get_setting('site_logo'))
                            <img src="{{ asset('storage/' . get_setting('site_logo')) }}" class="navbar-logo" alt="logo">
                        @else
                            <img src="{{ Vite::asset('resources/images/logo.svg') }}" class="navbar-logo" alt="logo">
                        @endif
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ getRouterValue() }}dashboard/analytics" class="nav-link"> CORK </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ $catName === 'dashboard' ? 'active' : '' }}">
                <a href="#dashboard" data-bs-toggle="collapse"
                    aria-expanded=" {{ $catName === 'dashboard' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $catName === 'dashboard' ? 'show' : '' }} "
                    id="dashboard" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('analytics') ? 'active' : '' }}">
                        <a href="{{ getRouterValue() }}dashboard/analytics"> Analytics </a>
                    </li>
                </ul>
            </li>
            @can('user.view')
                <li class="menu {{ $catName == 'users' ? 'active' : '' }}">
                    <a href="#users" data-bs-toggle="collapse"
                        aria-expanded="{{ $catName == 'users' ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>User Management</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ $catName == 'users' ? 'show' : '' }}" id="users"
                        data-bs-parent="#accordionExample">
                        @can('admin.view')
                            <li>
                                <a href="{{ route('admins.index') }}"> Admin </a>
                            </li>
                        @endcan
                        @can('hr.view')
                            <li>
                                <a href="{{ route('hrs.index') }}"> HR </a>
                            </li>
                        @endcan
                        @can('employee.view')
                            <li>
                                <a href="{{ route('employees.index') }}"> Employee </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <li class="menu {{ Request::routeIs('attendance.*') ? 'active' : '' }}">
                <a href="#attendance" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('attendance.*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Attendance</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::routeIs('attendance.*') ? 'show' : '' }}"
                    id="attendance" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('attendance.index') ? 'active' : '' }}">
                        <a href="{{ route('attendance.index') }}"> My Attendance </a>
                    </li>
                    @can('attendance.manage')
                        <li class="{{ Request::routeIs('attendance.daily') ? 'active' : '' }}">
                            <a href="{{ route('attendance.daily') }}"> Daily List </a>
                        </li>
                        <li class="{{ Request::routeIs('attendance.summary') ? 'active' : '' }}">
                            <a href="{{ route('attendance.summary') }}"> Monthly Summary </a>
                        </li>
                        <li class="{{ Request::routeIs('shifts.index') ? 'active' : '' }}">
                            <a href="{{ route('shifts.index') }}"> Shift Management </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="menu {{ $catName == 'leave' ? 'active' : '' }}">
                <a href="#leave" data-bs-toggle="collapse"
                    aria-expanded="{{ $catName == 'leave' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-briefcase">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>Leave Management</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $catName == 'leave' ? 'show' : '' }}" id="leave"
                    data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('leaves.index') ? 'active' : '' }}">
                        <a href="{{ route('leaves.index') }}"> My Leaves </a>
                    </li>
                    <li class="{{ Request::routeIs('leaves.create') ? 'active' : '' }}">
                        <a href="{{ route('leaves.create') }}"> Apply Leave </a>
                    </li>
                    @can('leave.approve')
                        <li class="{{ Request::routeIs('admin.leaves.pending') ? 'active' : '' }}">
                            <a href="{{ route('admin.leaves.pending') }}"> Pending Approvals </a>
                        </li>
                    @endcan
                    @can('leave.view_all')
                        <li class="{{ Request::routeIs('admin.leaves.history') ? 'active' : '' }}">
                            <a href="{{ route('admin.leaves.history') }}"> Leave History </a>
                        </li>
                    @endcan
                    @can('leave_type.manage')
                        <li class="{{ Request::routeIs('leave-types.*') ? 'active' : '' }}">
                            <a href="{{ route('leave-types.index') }}"> Leave Types </a>
                        </li>
                    @endcan
                </ul>
            </li>

            <li class="menu {{ Request::is('dashboard/payroll*') ? 'active' : '' }}">
                <a href="#payroll" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('dashboard/payroll*') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-dollar-sign">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        <span>Payroll</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('dashboard/payroll*') ? 'show' : '' }}"
                    id="payroll" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('payroll.setup') ? 'active' : '' }}">
                        <a href="{{ route('payroll.setup') }}"> Salary Setup </a>
                    </li>
                    <li class="{{ Request::routeIs('payroll.generate') ? 'active' : '' }}">
                        <a href="{{ route('payroll.generate') }}"> Generate Payroll </a>
                    </li>
                    <li class="{{ Request::routeIs('payroll.index') ? 'active' : '' }}">
                        <a href="{{ route('payroll.index') }}"> Payroll History </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ $catName == 'performance' ? 'active' : '' }}">
                <a href="#performance" data-bs-toggle="collapse"
                    aria-expanded="{{ $catName == 'performance' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-activity">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                        <span>Performance</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $catName == 'performance' ? 'show' : '' }}"
                    id="performance" data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('performance.index') ? 'active' : '' }}">
                        <a href="{{ route('performance.index') }}"> Reviews </a>
                    </li>
                    <li class="{{ Request::routeIs('performance.goals') ? 'active' : '' }}">
                        <a href="{{ route('performance.goals') }}"> Goals & KPIs </a>
                    </li>
                    <li class="{{ Request::routeIs('performance.appraisals') ? 'active' : '' }}">
                        <a href="{{ route('performance.appraisals') }}"> Appraisals </a>
                    </li>
                </ul>
            </li>

            @can('view recruitment')
                <li class="menu {{ Request::is('dashboard/recruitment*') ? 'active' : '' }}">
                    <a href="#recruitment" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::is('dashboard/recruitment*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-user-plus">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <line x1="19" y1="8" x2="19" y2="14"></line>
                                <line x1="22" y1="11" x2="16" y2="11"></line>
                            </svg>
                            <span>Recruitment</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::is('dashboard/recruitment*') ? 'show' : '' }}"
                        id="recruitment" data-bs-parent="#accordionExample">
                        <li class="{{ Request::routeIs('recruitment.jobs.*') ? 'active' : '' }}">
                            <a href="{{ route('recruitment.jobs.index') }}"> Job Openings </a>
                        </li>
                        <li class="{{ Request::routeIs('recruitment.candidates.*') ? 'active' : '' }}">
                            <a href="{{ route('recruitment.candidates.index') }}"> Candidates </a>
                        </li>
                        <li class="{{ Request::routeIs('recruitment.applications.*') ? 'active' : '' }}">
                            <a href="{{ route('recruitment.applications.index') }}"> Applications </a>
                        </li>
                        <li class="{{ Request::routeIs('recruitment.interviews.*') ? 'active' : '' }}">
                            <a href="{{ route('recruitment.interviews.index') }}"> Interviews </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <li class="menu {{ Request::routeIs('calendar.index') ? 'active' : '' }}">
                <a href="{{ route('calendar.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Calendar</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ Request::routeIs('profile.index') ? 'active' : '' }}">
                <a href="{{ route('profile.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Profile</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ $catName == 'documents' ? 'active' : '' }}">
                <a href="{{ route('documents.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Documents</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ $catName == 'mail' ? 'active' : '' }}">
                <a href="#mail" data-bs-toggle="collapse"
                    aria-expanded="{{ $catName == 'mail' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-mail">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>Mail</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $catName == 'mail' ? 'show' : '' }}" id="mail"
                    data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('mail.index') ? 'active' : '' }}">
                        <a href="{{ route('mail.index') }}"> Inbox </a>
                    </li>
                    <li class="{{ Request::routeIs('mail.compose') ? 'active' : '' }}">
                        <a href="{{ route('mail.compose') }}"> Compose </a>
                    </li>
                    <li class="{{ Request::routeIs('mail.sent') ? 'active' : '' }}">
                        <a href="{{ route('mail.sent') }}"> Sent </a>
                    </li>
                    <li class="{{ Request::routeIs('mail.drafts') ? 'active' : '' }}">
                        <a href="{{ route('mail.drafts') }}"> Drafts </a>
                    </li>
                    <li class="{{ Request::routeIs('mail.trash') ? 'active' : '' }}">
                        <a href="{{ route('mail.trash') }}"> Trash </a>
                    </li>
                </ul>
            </li>

            {{-- <li class="menu {{ $catName == 'organization' ? 'active' : '' }}">
                <a href="javascript:void(0);" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-layers">
                            <polyline points="12 2 2 7 12 12 22 7 12 2"></polyline>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline points="2 12 12 17 22 12"></polyline>
                        </svg>
                        <span>Organization</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ $catName == 'reports' ? 'active' : '' }}">
                <a href="javascript:void(0);" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-bar-chart-2">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        <span>Reports</span>
                    </div>
                </a>
            </li> --}}

            <li class="menu {{ $catName == 'settings' ? 'active' : '' }}">
                <a href="#settings" data-bs-toggle="collapse"
                    aria-expanded="{{ $catName == 'settings' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-settings">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                            </path>
                        </svg>
                        <span>Settings</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $catName == 'settings' ? 'show' : '' }}" id="settings"
                    data-bs-parent="#accordionExample">
                    <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                        <a href="{{ route('settings') }}"> General Settings </a>
                    </li>
                    <li class="{{ Request::routeIs('roles.*') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}"> Roles </a>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>

</div>
{{-- @endsection --}}
