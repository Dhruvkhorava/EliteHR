@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/light/assets/components/modal.scss'])
    @vite(['resources/scss/dark/assets/components/modal.scss'])
@endsection

@section('content')
    <div class="row layout-top-spacing">
        
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-table-two">
                <div class="widget-heading px-4 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="">Salary Appraisals & Hikes</h5>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addAppraisalModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up me-1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg> Request Appraisal
                        </button>
                    @endif
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="appraisals-table" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Rating (at trial)</th>
                                    <th>Increment %</th>
                                    <th>Previous Salary</th>
                                    <th>New Salary</th>
                                    <th>Effective Date</th>
                                    <th>Status</th>
                                    @if(auth()->user()->hasRole('admin'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appraisals as $appraisal)
                                    <tr>
                                        <td>{{ $appraisal->user->name }}</td>
                                        <td>
                                            @for($i=1; $i<=5; $i++)
                                                <span class="text-warning small">{{ $i <= $appraisal->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </td>
                                        <td><span class="text-success fw-bold">+{{ $appraisal->increment_percentage }}%</span></td>
                                        <td>{{ number_format($appraisal->previous_salary, 2) }}</td>
                                        <td>{{ number_format($appraisal->new_salary, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appraisal->effective_date)->format('d M Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'badge-light-warning',
                                                    'approved' => 'badge-light-success',
                                                    'rejected' => 'badge-light-danger',
                                                ][$appraisal->status] ?? 'badge-light-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($appraisal->status) }}</span>
                                        </td>
                                        @if(auth()->user()->hasRole('admin'))
                                            <td>
                                                @if($appraisal->status == 'pending')
                                                    <form action="{{ route('performance.appraisals.approve', $appraisal->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success shadow-none">Approve</button>
                                                    </form>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No appraisals found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
    <!-- Modal for Adding Appraisal -->
    <div class="modal fade" id="addAppraisalModal" tabindex="-1" role="dialog" aria-labelledby="addAppraisalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppraisalModalLabel">New Salary Appraisal Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('performance.appraisals.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="alert alert-light-info border-0 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="8.01"></line></svg>
                                    Appraisal metrics will be automatically calculated based on the employee's current basic salary and most recent performance review.
                                </label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Employee</label>
                                <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $emp)
                                        @if($emp->salary)
                                            <option value="{{ $emp->id }}" {{ old('user_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }} (Basic: {{ $emp->salary->basic }})</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Increment Percentage (%)</label>
                                <input type="number" step="0.01" name="increment_percentage" class="form-control @error('increment_percentage') is-invalid @enderror" placeholder="e.g. 10" value="{{ old('increment_percentage') }}">
                                @error('increment_percentage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Effective Date</label>
                                <input type="date" name="effective_date" class="form-control @error('effective_date') is-invalid @enderror" value="{{ old('effective_date', date('Y-m-d')) }}">
                                @error('effective_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger shadow-none" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/performance/appraisals.js') }}"></script>
@endsection
