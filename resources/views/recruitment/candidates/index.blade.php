@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    <link rel="stylesheet" href="{{ asset('asset/css/recruitment_common.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-card-four text-white recruitment-card-success">
                <div class="widget-content p-4">
                    <div class="w-header d-flex justify-content-between align-items-center">
                        <div class="w-info">
                            <h4 class="value text-white mb-1 font-weight-bold">Candidate Pool</h4>
                            <p class="text-white-50 mb-0">Manage applications and potential hires</p>
                        </div>
                        <div class="task-action">
                            @can('manage candidates')
                            <a href="{{ route('recruitment.candidates.create') }}" class="btn btn-light btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus me-2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg> Add Candidate
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-table-two border-0 shadow-sm recruitment-widget-table">
                <div class="widget-heading px-4 pt-4">
                    <h5 class="font-weight-bold">Candidate List</h5>
                </div>
                <div class="widget-content">
                    <div class="table-responsive p-4">
                        <table id="candidates-table" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Experience</th>
                                    <th>Applied For</th>
                                    <th>Resume</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($candidates as $candidate)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="usr-img-frame me-2 rounded-circle bg-light-success p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="font-weight-bold text-dark">{{ $candidate->name ?? 'Unknown Candidate' }}</span>
                                                <span class="text-muted small">{{ $candidate->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $candidate->phone ?? '-' }}</td>
                                    <td>{{ $candidate->experience ?? '-' }}</td>
                                    <td>
                                        @if($candidate->applications->count() > 0 && $candidate->applications->first()?->job)
                                            <span class="text-primary fw-bold">{{ $candidate->applications->first()?->job?->title }}</span>
                                            @if($candidate->applications->count() > 1)
                                                <span class="badge badge-light-secondary ms-1">+{{ $candidate->applications->count() - 1 }} more</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">No applications</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($candidate->resume)
                                            <a href="{{ Storage::url($candidate->resume) }}" target="_blank" class="btn btn-sm btn-light-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text me-1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> View CV
                                            </a>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown custom-dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $candidate->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $candidate->id }}">
                                                <a class="dropdown-item" href="{{ route('recruitment.candidates.show', $candidate->id) }}">View Profile</a>
                                                @can('manage candidates')
                                                <a class="dropdown-item" href="{{ route('recruitment.candidates.edit', $candidate->id) }}">Edit Info</a>
                                                <form action="{{ route('recruitment.candidates.destroy', $candidate->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger confirm-delete">Delete</button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
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
@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/recruitment/candidates/index.js') }}"></script>
@endsection
