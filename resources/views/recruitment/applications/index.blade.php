@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/src/drag-and-drop/dragula/dragula.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/src/notification/snackbar/snackbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/recruitment/applications/index.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-card-four text-white mb-4" style="background: linear-gradient(135deg, #4361ee 0%, #1e3a8a 100%); border: none; border-radius: 15px;">
                <div class="widget-content p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="value text-white mb-1 font-weight-bold">Talent Pipeline</h4>
                        <p class="text-white-50 mb-0">Drag and drop candidates to manage their application journey</p>
                    </div>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#applyModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus me-2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg> New Application
                    </button>
                </div>
            </div>

            <div class="active-pipeline-section mb-5">
                <h5 class="section-title mb-4" style="font-weight: 800; color: #3b3f5c; letter-spacing: 0.5px; display: flex; align-items: center;">
                    <span class="badge badge-primary me-2" style="width: 12px; height: 12px; border-radius: 50%; padding: 0;">&nbsp;</span>
                    ACTIVE PIPELINE
                </h5>
                <div class="kanban-container scroll-container">
                    @foreach(['Applied', 'Screening', 'Interview Scheduled', 'Selected'] as $stage)
                    <div class="kanban-column">
                        <div class="kanban-header d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                @php
                                    $stageColors = [
                                        'Applied' => '#e2a03f',
                                        'Screening' => '#2196f3',
                                        'Interview Scheduled' => '#3b3f5c',
                                        'Selected' => '#00abff'
                                    ];
                                    $color = $stageColors[$stage] ?? '#888ea8';
                                @endphp
                                <div class="stage-indicator me-2" style="background-color: {{ $color }};"></div>
                                <h6 class="kanban-title mb-0 me-2">{{ $stage }}</h6>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge badge-light-secondary rounded-pill" id="count-{{ Str::slug($stage) }}" style="font-weight: 800; font-size: 0.7rem;">{{ count($board[$stage] ?? []) }}</span>
                                <a href="javascript:void(0);" class="text-muted" data-bs-toggle="modal" data-bs-target="#applyModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                </a>
                            </div>
                        </div>
                        <div class="kanban-cards-wrapper" data-stage="{{ $stage }}" id="stage-{{ Str::slug($stage) }}">
                            @foreach($board[$stage] as $app)
                            <div class="kanban-card" data-id="{{ $app->id }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="candidate-name font-weight-bold">{{ $app->candidate?->name ?? 'Unknown Candidate' }}</span>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <h6 class="dropdown-header">Actions:</h6>
                                            <a class="dropdown-item" href="{{ route('recruitment.candidates.show', $app->candidate_id) }}">View Profile</a>
                                            @if($stage == 'Selected' || $stage == 'Hired')
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('recruitment.applications.convert', $app->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-primary font-weight-bold">Convert to Employee</button>
                                            </form>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('recruitment.applications.destroy', $app->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Remove Application</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <span class="job-badge">{{ $app->job?->title }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top" style="border-top: 1px dashed #e0e6ed !important;">
                                    <div class="card-footer-info d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        {{ $app->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="candidate-avatar">
                                        <span class="badge badge-light-primary rounded-circle" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">{{ substr($app->candidate?->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="finalized-section">
                <h5 class="section-title mb-4" style="font-weight: 800; color: #64748b; letter-spacing: 0.5px; display: flex; align-items: center;">
                    <span class="badge badge-secondary me-2" style="width: 12px; height: 12px; border-radius: 50%; padding: 0; background-color: #64748b;">&nbsp;</span>
                    FINALIZED STAGES
                </h5>
                <div class="kanban-container scroll-container">
                    @foreach(['Rejected', 'Hired'] as $stage)
                    <div class="kanban-column" style="background: rgba(226, 232, 240, 0.4);">
                        <div class="kanban-header d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                @php
                                    $stageColors = [
                                        'Rejected' => '#e7515a',
                                        'Hired' => '#4361ee'
                                    ];
                                    $color = $stageColors[$stage] ?? '#888ea8';
                                @endphp
                                <div class="stage-indicator me-2" style="background-color: {{ $color }};"></div>
                                <h6 class="kanban-title mb-0 me-2 text-muted">{{ $stage }}</h6>
                            </div>
                            <span class="badge badge-light-secondary rounded-pill" id="count-{{ Str::slug($stage) }}" style="font-weight: 800; font-size: 0.7rem;">{{ count($board[$stage] ?? []) }}</span>
                        </div>
                        <div class="kanban-cards-wrapper" data-stage="{{ $stage }}" id="stage-{{ Str::slug($stage) }}">
                            @foreach($board[$stage] as $app)
                            <div class="kanban-card opacity-75" data-id="{{ $app->id }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="candidate-name font-weight-bold">{{ $app->candidate?->name ?? 'Unknown Candidate' }}</span>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <h6 class="dropdown-header">Actions:</h6>
                                            <a class="dropdown-item" href="{{ route('recruitment.candidates.show', $app->candidate_id) }}">View Profile</a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('recruitment.applications.destroy', $app->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Remove Application</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <span class="job-badge" style="background: rgba(100, 116, 139, 0.1); color: #64748b;">{{ $app->job?->title }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top" style="border-top: 1px dashed #e0e6ed !important;">
                                    <div class="card-footer-info d-flex align-items-center small">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        {{ $app->created_at->format('M d') }}
                                    </div>
                                    <div class="candidate-avatar">
                                        <span class="badge badge-light-secondary rounded-circle" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 10px;">{{ substr($app->candidate?->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Application Modal ... (rest of the modal remains same) -->
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
<script src="{{ asset('plugins/src/drag-and-drop/dragula/dragula.min.js') }}"></script>
<script src="{{ asset('plugins/src/notification/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('asset/js/recruitment/applications/index.js') }}"></script>
@endsection
