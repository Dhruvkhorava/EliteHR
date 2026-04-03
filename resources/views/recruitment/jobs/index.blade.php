@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    <link rel="stylesheet" href="{{ asset('asset/css/recruitment_common.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-card-four text-white recruitment-card-primary">
                <div class="widget-content p-4">
                    <div class="w-header d-flex justify-content-between align-items-center">
                        <div class="w-info">
                            <h4 class="value text-white mb-1 font-weight-bold">Recruitment Hub</h4>
                            <p class="text-white-50 mb-0">Manage your job openings and talent pipeline</p>
                        </div>
                        <div class="task-action">
                            @can('manage jobs')
                            <a href="{{ route('recruitment.jobs.create') }}" class="btn btn-light btn-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Create New Job
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-table-two border-0 shadow-sm recruitment-widget-table">
                <div class="widget-heading px-4 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold">Current Job Openings</h5>
                </div>
                <div class="widget-content">
                    <div class="table-responsive p-4">
                        <table id="jobs-table" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Location</th>
                                    <th>Applicants</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="usr-img-frame me-2 rounded-circle bg-light-primary p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4361ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                            </div>
                                            <span class="font-weight-bold">{{ $job->title }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $job->department }}</td>
                                    <td>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin me-1 text-muted"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        {{ $job->location }}
                                    </td>
                                    <td>
                                        <span class="badge badge-light-info fw-bold">{{ $job->applications_count }} Candidates</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $job->status == 'open' ? 'badge-light-success' : 'badge-light-danger' }}">
                                            {{ ucfirst($job->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown custom-dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $job->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $job->id }}">
                                                <a class="dropdown-item" href="{{ route('recruitment.jobs.show', $job->id) }}">View Details</a>
                                                @can('manage jobs')
                                                <a class="dropdown-item" href="{{ route('recruitment.jobs.edit', $job->id) }}">Edit Job</a>
                                                <form action="{{ route('recruitment.jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger confirm-delete">Delete Job</button>
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
    <script src="{{ asset('asset/js/recruitment/jobs/index.js') }}"></script>
@endsection
