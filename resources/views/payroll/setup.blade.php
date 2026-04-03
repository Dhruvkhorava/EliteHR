@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/payroll/setup.css') }}">
@endsection

@section('content')
<div class="row layout-top-spacing">
    <div class="col-12 layout-spacing">
        
        <!-- Page Header -->
        <div class="leaves-header">
            <div class="leaves-title">
                <h4>Payroll & Salary Setup</h4>
                <p>Configure employee earnings and assign compensation structures</p>
            </div>
            <div class="badge bg-light text-dark fw-bold border py-2 px-3">
                <i class="fa-solid fa-briefcase me-2 text-primary"></i> Total Active Salaries: {{ count($salaries) }}
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Left Side: Salary Assignment Form -->
            <div class="col-xl-4 col-lg-5 col-md-12">
                <div class="setup-card p-4">
                    <div class="card-accent-gradient"></div>
                    <div class="d-flex align-items-center mb-4 mt-2">
                        <i class="fa-solid fa-file-invoice-dollar text-primary fs-4 me-3"></i>
                        <h5 class="fw-extrabold text-dark mb-0">New Base Salary Assignment</h5>
                    </div>

                    <form action="{{ route('payroll.store-setup') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-premium">Select Employee</label>
                            <select name="user_id" class="form-select form-control-premium form-select-premium @error('user_id') is-invalid @enderror">
                                <option value="">- Employee Name -</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->designation->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label-premium">Salary Structure Template</label>
                            <select name="salary_template_id" class="form-select form-control-premium form-select-premium @error('salary_template_id') is-invalid @enderror">
                                <option value="">- Choose Template -</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}" {{ old('salary_template_id') == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
                                @endforeach
                            </select>
                            @error('salary_template_id')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label-premium">Annual CTC (INR)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3" style="border: 1px solid #e2e8f0;"><i class="fa-solid fa-indian-rupee-sign text-muted small"></i></span>
                                <input type="number" name="ctc" class="form-control form-control-premium @error('ctc') is-invalid @enderror ps-2" placeholder="600000" value="{{ old('ctc') }}">
                            </div>
                            @error('ctc')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label-premium">Banking Details</label>
                            <div class="row g-2">
                                <div class="col-12 mb-2">
                                    <input type="text" name="bank_name" class="form-control form-control-premium @error('bank_name') is-invalid @enderror" placeholder="Bank Name (e.g. HDFC Bank)" value="{{ old('bank_name') }}">
                                    @error('bank_name') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 mb-2">
                                    <input type="text" name="account_number" class="form-control form-control-premium @error('account_number') is-invalid @enderror" placeholder="Account Number" value="{{ old('account_number') }}">
                                    @error('account_number') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <input type="text" name="ifsc_code" class="form-control form-control-premium @error('ifsc_code') is-invalid @enderror" placeholder="IFSC Code" value="{{ old('ifsc_code') }}">
                                    @error('ifsc_code') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-assign w-100">
                            Apply Salary Configuration <i class="fa-solid fa-arrow-right-long ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Right Side: Existing Records -->
            <div class="col-xl-8 col-lg-7 col-md-12">
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                        <h5 class="fw-bold text-dark mb-0">Record of Salaries Assigned</h5>
                        <div class="text-muted small fw-medium">
                            Latest assignments shown
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero-config" class="table custom-table dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Template</th>
                                    <th>CTC (Annual)</th>
                                    <th>Monthly Basic</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaries as $salary)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-wrapper bg-soft-primary me-2">
                                                    {{ substr($salary->user->name, 0, 1) }}
                                                </div>
                                                <span class="fw-bold text-dark">{{ $salary->user->name }}</span>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-light-primary badge-premium">{{ $salary->template->name ?? 'None' }}</span></td>
                                        <td>
                                            <span class="fw-extrabold text-dark"><i class="fa-solid fa-indian-rupee-sign small me-1"></i>{{ number_format($salary->ctc, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success"><i class="fa-solid fa-indian-rupee-sign small me-1"></i>{{ number_format($salary->basic, 0) }}</span>
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
</div>
@endsection

@section('scripts')
    <script src="{{ asset('asset/js/payroll/setup.js') }}"></script>
@endsection
