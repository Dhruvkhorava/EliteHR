@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    <link rel="stylesheet" href="{{ asset('asset/css/recruitment_common.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-card-four text-white mb-4 recruitment-card-warning">
                <div class="widget-content p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="value text-white mb-1 font-weight-bold">Interview Management</h4>
                        <p class="text-white-50 mb-0">Schedule and track interview feedback</p>
                    </div>
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Schedule Interview
                    </button>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-table-two border-0 shadow-sm recruitment-widget-table">
                <div class="widget-heading px-4 pt-4">
                    <h5 class="font-weight-bold">Upcoming & Past Interviews</h5>
                </div>
                <div class="widget-content">
                    <div class="table-responsive p-4">
                        <table id="interviews-table" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>Candidate</th>
                                    <th>Position</th>
                                    <th>Interviewer</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($interviews as $interview)
                                <tr>
                                    <td>
                                        <span class="font-weight-bold">{{ $interview->application?->candidate?->name ?? 'Unknown' }}</span>
                                    </td>
                                    <td>{{ $interview->application?->job?->title ?? 'N/A' }}</td>
                                    <td>{{ $interview->interviewer->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($interview->date)->format('d M Y') }}</span>
                                            <span class="text-muted small">{{ \Carbon\Carbon::parse($interview->time)->format('h:i A') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ [
                                            'Scheduled' => 'badge-light-primary',
                                            'Completed' => 'badge-light-success',
                                            'Cancelled' => 'badge-light-danger'
                                        ][$interview->status] ?? 'badge-light-secondary' }}">
                                            {{ $interview->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $interview->id }}">
                                            Feedback
                                        </button>
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

    <!-- Feedback Modals (Moved outside table) -->
    @foreach($interviews as $interview)
    <div class="modal fade" id="feedbackModal{{ $interview->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">Interview Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('recruitment.interviews.update', $interview->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="Scheduled" {{ (old('status') ?? $interview->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="Completed" {{ (old('status') ?? $interview->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ (old('status') ?? $interview->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Notes / Feedback</label>
                            <textarea name="feedback" rows="4" class="form-control" placeholder="Add interview feedback here...">{{ $interview->feedback }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="btn btn-primary w-100">Save Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Schedule Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">Schedule Interview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('recruitment.interviews.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Select Application</label>
                            <select name="application_id" class="form-control @error('application_id') is-invalid @enderror">
                                <option value="">Choose candidate application...</option>
                                @foreach($applications as $app)
                                <option value="{{ $app->id }}" {{ old('application_id') == $app->id ? 'selected' : '' }}>{{ $app->candidate->name ?? 'Unknown' }} - {{ $app->job->title ?? 'Unknown' }}</option>
                                @endforeach
                            </select>
                            @error('application_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Assign Interviewer</label>
                            <select name="interviewer_id" class="form-control @error('interviewer_id') is-invalid @enderror">
                                <option value="">Choose interviewer...</option>
                                @foreach($interviewers as $interviewer)
                                <option value="{{ $interviewer->id }}" {{ old('interviewer_id') == $interviewer->id ? 'selected' : '' }}>{{ $interviewer->name }} ({{ ucfirst($interviewer->getRoleNames()->first()) }})</option>
                                @endforeach
                            </select>
                            @error('interviewer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">Date</label>
                                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" min="{{ date('Y-m-d') }}" value="{{ old('date') }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">Time</label>
                                <input type="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}">
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/recruitment/interviews/index.js') }}"></script>
@endsection
