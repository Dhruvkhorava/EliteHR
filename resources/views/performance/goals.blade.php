@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @cite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
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
                    <h5 class="">Goals & KPIs</h5>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGoalModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target me-1"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg> Set New Goal
                        </button>
                    @endif
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="goals-table" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Goal Title</th>
                                    <th>Target</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($goals as $goal)
                                    <tr>
                                        <td>{{ $goal->user->name }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $goal->title }}</span>
                                            <br><small class="text-muted">{{ Str::limit($goal->description, 50) }}</small>
                                        </td>
                                        <td>{{ $goal->target }}</td>
                                        <td>{{ $goal->deadline ? \Carbon\Carbon::parse($goal->deadline)->format('d M Y') : '-' }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'badge-light-warning',
                                                    'in_progress' => 'badge-light-info',
                                                    'completed' => 'badge-light-success',
                                                    'cancelled' => 'badge-light-danger',
                                                ][$goal->status] ?? 'badge-light-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $goal->status)) }}</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <form action="{{ route('performance.goals.update', $goal->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        @if($goal->status != 'in_progress' && $goal->status != 'completed')
                                                            <button type="submit" name="status" value="in_progress" class="dropdown-item">Mark In Progress</button>
                                                        @endif
                                                        @if($goal->status != 'completed')
                                                            <button type="submit" name="status" value="completed" class="dropdown-item">Mark Completed</button>
                                                        @endif
                                                        @if($goal->status != 'cancelled')
                                                            <button type="submit" name="status" value="cancelled" class="dropdown-item">Cancel</button>
                                                        @endif
                                                    </form>
                                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                                                        <hr class="dropdown-divider">
                                                        <form action="{{ route('performance.goals.destroy', $goal->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger confirm-delete">Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No goals found</td>
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
    <!-- Modal for Adding Goal -->
    <div class="modal fade" id="addGoalModal" tabindex="-1" role="dialog" aria-labelledby="addGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGoalModalLabel">Assign New Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('performance.goals.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Employee</label>
                                <select name="user_id" class="form-select" required>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Goal Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Sales Target, Project Deadline" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Target Metric (Optional)</label>
                                <input type="text" name="target" class="form-control" placeholder="e.g. 20 leads, 100% attendance">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Deadline</label>
                                <input type="date" name="deadline" class="form-control">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger shadow-none" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Assign Goal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/performance/goals.js') }}"></script>
@endsection
