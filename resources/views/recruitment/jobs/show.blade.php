@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/recruitment_common.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 layout-spacing mx-auto">
            <div class="widget widget-card-four border-0 shadow-sm recruitment-widget-table">
                <div class="widget-content p-4">
                    <div class="w-header mb-4 d-flex justify-content-between align-items-center">
                        <div class="w-info text-primary font-weight-bold">
                            <h4 class="value text-primary mb-1">Job Details: {{ $job->title }}</h4>
                        </div>
                        <div>
                            @can('manage jobs')
                            <a href="{{ route('recruitment.jobs.edit', $job->id) }}" class="btn btn-primary me-2">Edit</a>
                            @endcan
                            <a href="{{ route('recruitment.jobs.index') }}" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Department</h6>
                            <p class="fs-5">{{ $job->department }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Location</h6>
                            <p class="fs-5">{{ $job->location }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Salary Range</h6>
                            <p class="fs-5">{{ $job->salary_range ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Status</h6>
                            <p class="fs-5">
                                <span class="badge {{ $job->status == 'open' ? 'badge-light-success' : 'badge-light-danger' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="font-weight-bold text-muted mb-2">Required Skills</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if($job->required_skills)
                                @foreach(explode(',', $job->required_skills) as $skill)
                                    <span class="badge badge-light-primary fs-6 py-2 px-3">{{ trim($skill) }}</span>
                                @endforeach
                            @else
                                <p>Not specified</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="font-weight-bold text-muted mb-2">Job Description</h6>
                        <div class="p-4 bg-light rounded shadow-sm">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
