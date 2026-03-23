@extends('layouts.app')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 layout-spacing mx-auto">
            <div class="widget widget-card-four border-0 shadow-sm" style="border-radius: 15px;">
                <div class="widget-content p-4">
                    <div class="w-header mb-4 d-flex justify-content-between align-items-center">
                        <div class="w-info text-success font-weight-bold">
                            <h4 class="value text-success mb-1">Add New Candidate</h4>
                        </div>
                        <a href="{{ route('recruitment.candidates.index') }}" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-1"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Back
                        </a>
                    </div>

                    <form action="{{ route('recruitment.candidates.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label font-weight-bold">Full Name *</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="e.g. John Doe" required>
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label font-weight-bold">Email Address *</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="e.g. john@example.com" required>
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="phone" class="form-label font-weight-bold">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="e.g. +1 234 567 890">
                                @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="experience" class="form-label font-weight-bold">Experience</label>
                                <input type="text" name="experience" id="experience" class="form-control" placeholder="e.g. 3+ Years">
                                @error('experience') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="skills" class="form-label font-weight-bold">Skills</label>
                            <input type="text" name="skills" id="skills" class="form-control" placeholder="e.g. PHP, Laravel, Vue.js">
                            @error('skills') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="resume" class="form-label font-weight-bold">Resume (PDF, DOC, DOCX) *</label>
                            <input type="file" name="resume" id="resume" class="form-control" accept=".pdf,.doc,.docx">
                            @error('resume') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow-none" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus me-2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg> Save Candidate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
