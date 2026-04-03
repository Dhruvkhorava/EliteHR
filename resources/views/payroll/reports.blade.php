@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="px-4 pt-4 mb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Statutory Reports Gallery</h5>
                <div class="d-flex gap-2">
                    <select id="reportMonth" class="form-select form-select-sm" style="width: 150px;">
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ $num == $currentMonth ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select id="reportYear" class="form-select form-select-sm" style="width: 100px;">
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            
            <div class="row px-4 pb-4">
                {{-- PF Contribution Report --}}
                <div class="col-md-3 mb-4">
                    <div class="card text-center p-4 shadow-sm border-0 h-100 hover-card">
                        <div class="mb-3">
                            <div class="icon-circle bg-light-primary text-primary mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                        </div>
                        <h6 class="fw-bold">PF Contribution Report</h6>
                        <p class="small text-muted mb-4">Monthly PF combined challan & ECR file with UAN details.</p>
                        <form action="{{ route('payroll.reports.export') }}" method="POST" class="report-form mt-auto">
                            @csrf
                            <input type="hidden" name="type" value="pf">
                            <input type="hidden" name="month" class="form-month" value="{{ $currentMonth }}">
                            <input type="hidden" name="year" class="form-year" value="{{ $currentYear }}">
                            <button type="submit" class="btn btn-sm btn-primary w-100 rounded-pill">Generate Report</button>
                        </form>
                    </div>
                </div>

                {{-- ESI Statement --}}
                <div class="col-md-3 mb-4">
                    <div class="card text-center p-4 shadow-sm border-0 h-100 hover-card">
                        <div class="mb-3">
                            <div class="icon-circle bg-light-success text-success mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                        </div>
                        <h6 class="fw-bold">ESI Statement</h6>
                        <p class="small text-muted mb-4">Monthly ESI contribution details and IP wise statements.</p>
                        <form action="{{ route('payroll.reports.export') }}" method="POST" class="report-form mt-auto">
                            @csrf
                            <input type="hidden" name="type" value="esi">
                            <input type="hidden" name="month" class="form-month" value="{{ $currentMonth }}">
                            <input type="hidden" name="year" class="form-year" value="{{ $currentYear }}">
                            <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill">Generate Report</button>
                        </form>
                    </div>
                </div>

                {{-- Professional Tax --}}
                <div class="col-md-3 mb-4">
                    <div class="card text-center p-4 shadow-sm border-0 h-100 hover-card">
                        <div class="mb-3">
                            <div class="icon-circle bg-light-info text-info mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                        </div>
                        <h6 class="fw-bold">Professional Tax (PT)</h6>
                        <p class="small text-muted mb-4">State-wise PT deduction report for compliance filing.</p>
                        <form action="{{ route('payroll.reports.export') }}" method="POST" class="report-form mt-auto">
                            @csrf
                            <input type="hidden" name="type" value="pt">
                            <input type="hidden" name="month" class="form-month" value="{{ $currentMonth }}">
                            <input type="hidden" name="year" class="form-year" value="{{ $currentYear }}">
                            <button type="submit" class="btn btn-sm btn-info w-100 rounded-pill text-white">Generate Report</button>
                        </form>
                    </div>
                </div>

                {{-- Income Tax / TDS --}}
                <div class="col-md-3 mb-4">
                    <div class="card text-center p-4 shadow-sm border-0 h-100 hover-card">
                        <div class="mb-3">
                            <div class="icon-circle bg-light-danger text-danger mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                        </div>
                        <h6 class="fw-bold">Income Tax (TDS)</h6>
                        <p class="small text-muted mb-4">Monthly TDS deduction report for Form 24Q prep.</p>
                        <form action="{{ route('payroll.reports.export') }}" method="POST" class="report-form mt-auto">
                            @csrf
                            <input type="hidden" name="type" value="it">
                            <input type="hidden" name="month" class="form-month" value="{{ $currentMonth }}">
                            <input type="hidden" name="year" class="form-year" value="{{ $currentYear }}">
                            <button type="submit" class="btn btn-sm btn-danger w-100 rounded-pill">Generate Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-light-primary { background: rgba(67, 97, 238, 0.1); }
    .bg-light-success { background: rgba(0, 171, 85, 0.1); }
    .bg-light-info { background: rgba(0, 207, 221, 0.1); }
    .bg-light-danger { background: rgba(231, 81, 90, 0.1); }
    
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthSelect = document.getElementById('reportMonth');
        const yearSelect = document.getElementById('reportYear');
        
        function updateFormValues() {
            const forms = document.querySelectorAll('.report-form');
            forms.forEach(form => {
                form.querySelector('.form-month').value = monthSelect.value;
                form.querySelector('.form-year').value = yearSelect.value;
            });
        }

        monthSelect.addEventListener('change', updateFormValues);
        yearSelect.addEventListener('change', updateFormValues);
    });
</script>
@endpush
@endsection
