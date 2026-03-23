@extends('layouts.app')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 layout-spacing mx-auto">
            <div class="widget widget-card-four border-0 shadow-sm" style="border-radius: 15px;">
                <div class="widget-content p-4">
                    <div class="w-header mb-4 d-flex justify-content-between align-items-center">
                        <div class="w-info text-success font-weight-bold">
                            <h4 class="value text-success mb-1">Candidate Profile: {{ $candidate->name }}</h4>
                        </div>
                        <div>
                            @can('manage candidates')
                            <a href="{{ route('recruitment.candidates.edit', $candidate->id) }}" class="btn btn-success me-2">Edit</a>
                            @endcan
                            <a href="{{ route('recruitment.candidates.index') }}" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Email Address</h6>
                            <p class="fs-5"><a href="mailto:{{ $candidate->email }}">{{ $candidate->email }}</a></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Phone Number</h6>
                            <p class="fs-5">{{ $candidate->phone ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Experience</h6>
                            <p class="fs-5">{{ $candidate->experience ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-muted mb-1">Resume</h6>
                            <p class="fs-5">
                                @if($candidate->resume)
                                    <a href="{{ Storage::url($candidate->resume) }}" target="_blank" class="btn btn-sm btn-outline-primary">View/Download</a>
                                @else
                                    <span class="text-muted">Not uploaded</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="font-weight-bold text-muted mb-2">Skills</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if($candidate->skills)
                                @foreach(explode(',', $candidate->skills) as $skill)
                                    <span class="badge badge-light-success fs-6 py-2 px-3">{{ trim($skill) }}</span>
                                @endforeach
                            @else
                                <p>Not specified</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
