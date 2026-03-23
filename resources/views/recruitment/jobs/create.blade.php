@extends('layouts.app')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 layout-spacing mx-auto">
            <div class="widget widget-card-four border-0 shadow-sm" style="border-radius: 15px;">
                <div class="widget-content p-4">
                    <div class="w-header mb-4 d-flex justify-content-between align-items-center">
                        <div class="w-info text-primary font-weight-bold">
                            <h4 class="value text-primary mb-1">Create New Job Opening</h4>
                        </div>
                        <a href="{{ route('recruitment.jobs.index') }}" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-1"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Back
                        </a>
                    </div>

                    <form action="{{ route('recruitment.jobs.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="title" class="form-label font-weight-bold">Job Title *</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Laravel Developer" required>
                                @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="department" class="form-label font-weight-bold">Department *</label>
                                <select name="department" id="department" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <option value="IT / Development">IT / Development</option>
                                    <option value="Human Resources">Human Resources</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Operations">Operations</option>
                                </select>
                                @error('department') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="location" class="form-label font-weight-bold">Location *</label>
                                <input type="text" name="location" id="location" class="form-control" placeholder="e.g. Ahmedabad, Remote" required>
                                @error('location') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="salary_range" class="form-label font-weight-bold">Salary Range</label>
                                <input type="text" name="salary_range" id="salary_range" class="form-control" placeholder="e.g. $50k - $70k">
                                @error('salary_range') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="required_skills" class="form-label font-weight-bold">Required Skills</label>
                            <input type="text" name="required_skills" id="required_skills" class="form-control" placeholder="e.g. PHP, Laravel, MySQL, JavaScript">
                            <small class="text-muted">Comma separated values</small>
                            @error('required_skills') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label font-weight-bold">Job Description *</label>
                            <textarea name="description" id="description" rows="6" class="form-control" placeholder="Detailed job description and responsibilities..." required></textarea>
                            @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-none" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save me-2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> Create Job Opening
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
