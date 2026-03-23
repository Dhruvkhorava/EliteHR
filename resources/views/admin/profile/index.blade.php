@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/assets/users/user-profile.scss'])
    @vite(['resources/scss/light/assets/users/account-setting.scss'])
    @vite(['resources/scss/light/assets/components/tabs.scss'])
    <style>
        .profile-hero {
            background: linear-gradient(135deg, #4361ee 0%, #160d3d 100%);
            border-radius: 12px;
            color: white;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .profile-hero::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -20%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.05);
            transform: rotate(45deg);
        }
        .profile-hero .avatar-xl {
            width: 130px;
            height: 130px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            padding: 4px;
            background: white;
            border-radius: 50%;
        }
        .stat-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px 0 rgba(0,0,0,0.05);
            height: 100%;
            transition: transform 0.3s ease;
        }
        .stat-box:hover {
            transform: translateY(-5px);
        }
        .stat-box svg {
            width: 28px;
            height: 28px;
            color: #4361ee;
            margin-bottom: 10px;
        }
        .nav-tabs .nav-link {
            padding: 15px 25px;
            font-weight: 600;
            border: none;
            color: #515365;
            border-bottom: 2px solid transparent;
        }
        .nav-tabs .nav-link.active {
            background: transparent;
            color: #4361ee;
            border-bottom: 2px solid #4361ee;
        }
        .salary-blur {
            filter: blur(5px);
            transition: filter 0.3s ease;
            cursor: pointer;
        }
        .salary-blur:hover {
            filter: blur(0);
        }
    </style>
@endsection

@section('content')
<div class="row layout-top-spacing">
    
    <!-- Hero Section -->
    <div class="col-12">
        <div class="profile-hero text-center">
            <div class="mb-3">
                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('asset/images/placeholder.png') }}" class="avatar-xl object-fit-cover shadow" alt="avatar">
            </div>
            <h3 class="text-white mb-1 fw-bold">{{ $user->name }}</h3>
            <p class="mb-0 opacity-75">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase me-1"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                {{ $user->getRoleNames()->first() ?? 'Employee' }}
            </p>
            <div class="mt-3">
                <span class="badge {{ $user->status ? 'badge-light-success' : 'badge-light-danger' }}">
                    {{ $user->status ? 'Active' : 'Inactive' }}
                </span>
                <span class="ms-2 opacity-50 small">Member since {{ $user->created_at->format('M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-md-3 mb-4">
        <div class="stat-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <h4 class="mb-0 fw-bold">{{ $attendanceCount }}</h4>
            <span class="text-muted small">Present Days ({{ now()->format('M') }})</span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <h4 class="mb-0 fw-bold">{{ $user->shift ? $user->shift->name : 'N/A' }}</h4>
            <span class="text-muted small">Current Shift</span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-umbrella"><path d="M23 12a11.05 11.05 0 0 0-22 0zm-5 7a3 3 0 0 1-6 0v-7"></path></svg>
            <h4 class="mb-0 fw-bold">{{ $user->leaveBalances->sum('remaining') }}</h4>
            <span class="text-muted small">Leave Balance Total</span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
            <h4 class="mb-0 fw-bold">Active</h4>
            <span class="text-muted small">Employment Status</span>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="col-12">
        <div class="widget-content-area br-12 p-0 overflow-hidden shadow-sm">
            <ul class="nav nav-tabs px-4 pt-3 border-bottom" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">General Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="benefits-tab" data-bs-toggle="tab" data-bs-target="#benefits" type="button" role="tab">Leaves & Benefits</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial" type="button" role="tab">Earnings</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">Security & Password</button>
                </li>
            </ul>
            
            <div class="tab-content p-4" id="profileTabsContent">
                
                <!-- General Info Tab -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold mb-2">Display Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold mb-2">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="col-12 mb-4">
                                <label class="fw-bold mb-2">Change Profile Image</label>
                                <input type="file" name="image" class="form-control" onchange="previewImage(this)">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="fw-bold mb-2 d-block text-muted">Shift Schedule</label>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0"><strong>{{ $user->shift ? $user->shift->name : 'No Shift Assigned' }}</strong></p>
                                    @if($user->shift)
                                        <small class="text-muted">{{ $user->shift->start_time }} - {{ $user->shift->end_time }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-4">Save General Changes</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Leaves Tab -->
                <div class="tab-pane fade" id="benefits" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Total Allowed</th>
                                    <th>Used</th>
                                    <th>Remaining</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->leaveBalances as $balance)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $balance->leaveType->name }}</td>
                                    <td>{{ $balance->total }} days</td>
                                    <td>{{ $balance->used }} days</td>
                                    <td><span class="badge badge-success">{{ $balance->remaining }} days left</span></td>
                                    <td>
                                        @php $pct = ($balance->used / ($balance->total ?: 1)) * 100; @endphp
                                        <div class="progress" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No leave data available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Financial Tab -->
                <div class="tab-pane fade" id="financial" role="tabpanel">
                    <div class="alert alert-light-info mb-4 border-dashed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        Salary information is confidential. Hover over the values to reveal details.
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="text-muted small fw-bold text-uppercase">Basic Salary</label>
                            <h4 class="fw-bold salary-blur">₹ {{ number_format($user->salary->basic ?? 0, 2) }}</h4>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="text-muted small fw-bold text-uppercase">HRA</label>
                            <h4 class="fw-bold salary-blur">₹ {{ number_format($user->salary->hra ?? 0, 2) }}</h4>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="text-muted small fw-bold text-uppercase">Other Allowances</label>
                            <h4 class="fw-bold salary-blur">₹ {{ number_format($user->salary->allowance ?? 0, 2) }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="fw-bold mb-2">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="fw-bold mb-2">New Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="fw-bold mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning px-4">Update Security Credentials</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.avatar-xl').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
