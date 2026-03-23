@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/recruitment/applications/index.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-card-four text-white mb-4" style="background: linear-gradient(135deg, #4361ee 0%, #1e3a8a 100%); border: none; border-radius: 15px;">
                <div class="widget-content p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="value text-white mb-1 font-weight-bold">Talent Pipeline</h4>
                        <p class="text-white-50 mb-0">Track applications across different stages</p>
                    </div>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#applyModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus me-2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg> New Application
                    </button>
                </div>
            </div>

            <div class="kanban-container">
                @foreach($stages as $stage)
                <div class="kanban-column" data-stage="{{ $stage }}">
                    <div class="kanban-header">
                        <div class="d-flex align-items-center">
                            <h6 class="kanban-title mb-0 me-2">{{ $stage }}</h6>
                            <span class="badge badge-light-secondary rounded-pill">{{ count($board[$stage]) }}</span>
                        </div>
                    </div>
                    <div class="kanban-cards-wrapper">
                        @foreach($board[$stage] as $app)
                        <div class="kanban-card">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="font-weight-bold text-dark">{{ $app->candidate?->name ?? 'Unknown Candidate' }}</span>
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <h6 class="dropdown-header">Move to:</h6>
                                        @foreach($stages as $nextStage)
                                            @if($nextStage != $stage)
                                            <button class="dropdown-item update-status" data-id="{{ $app->id }}" data-status="{{ $nextStage }}">{{ $nextStage }}</button>
                                            @endif
                                        @endforeach
                                        <div class="dropdown-divider"></div>
                                        @if($stage == 'Selected')
                                        <form action="{{ route('recruitment.applications.convert', $app->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-primary font-weight-bold">Convert to Employee</button>
                                        </form>
                                        @endif
                                        <form action="{{ route('recruitment.applications.destroy', $app->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Remove Application</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <small class="text-primary font-weight-bold">{{ $app->job?->title }}</small>
                            </div>
                            <div class="d-flex align-items-center text-muted small">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock me-1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                {{ $app->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Application Modal -->
    <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">New Job Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('recruitment.applications.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Select Candidate</label>
                            <select name="candidate_id" class="form-control" required>
                                <option value="">Choose a candidate...</option>
                                @foreach($candidates as $candidate)
                                <option value="{{ $candidate->id }}">{{ $candidate->name }} ({{ $candidate->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Select Job Position</label>
                            <select name="job_id" class="form-control" required>
                                <option value="">Choose a position...</option>
                                @foreach($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->title }} - {{ $job->department }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Create Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('asset/js/recruitment/applications/index.js') }}"></script>
@endsection
