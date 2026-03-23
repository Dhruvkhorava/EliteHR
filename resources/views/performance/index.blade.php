@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/light/assets/components/modal.scss'])
    @vite(['resources/scss/dark/assets/components/modal.scss'])
    <link rel="stylesheet" href="{{ asset('asset/css/performance/index.css') }}">
@endsection

@section('content')
    <div class="row layout-top-spacing">
        
        <!-- Dashboard Stats -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four text-center">
                <div class="widget-content py-4">
                    <div class="w-header mb-3">
                        <div class="w-info mx-auto">
                            <h6 class="value text-primary font-weight-bold">Average Performance Rating</h6>
                        </div>
                    </div>
                    <h1 class="display-4 font-weight-bold text-dark">{{ $avgRating }} <span class="fs-4 text-warning">⭐</span></h1>
                    <p class="text-muted fw-medium">Based on recent reviews</p>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content py-4">
                    <div class="w-header mb-3">
                        <div class="w-info mx-auto">
                            <h6 class="value text-info font-weight-bold">Goal Completion Progress</h6>
                        </div>
                    </div>
                    <div class="text-center">
                        <h1 class="display-4 font-weight-bold text-dark">{{ $goalProgress }}%</h1>
                        <div class="progress mt-3 mx-auto" style="width: 80%; height: 10px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $goalProgress }}%" aria-valuenow="{{ $goalProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review History Section -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="widget widget-table-two">
                <div class="widget-heading px-4 pt-4 d-flex justify-content-between align-items-center">
                    <h5 class="">Performance Reviews</h5>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle me-1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg> Add Review
                        </button>
                    @endif
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="performance-table" class="table dt-table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Reviewer</th>
                                    <th>Rating</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($performances as $review)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="usr-img-frame me-2">
                                                    <img src="{{ $review->user->image ? asset('storage/'.$review->user->image) : asset('asset/images/placeholder.png') }}" class="img-fluid" alt="avatar">
                                                </div>
                                                <p class="mb-0 fw-bold">{{ $review->user->name }}</p>
                                            </div>
                                        </td>
                                        <td>{{ $review->reviewer->name }}</td>
                                        <td>
                                            @for($i=1; $i<=5; $i++)
                                                <span class="rating-star fs-5">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </td>
                                        <td><span class="badge badge-light-info">{{ ucfirst($review->type) }}</span></td>
                                        <td>{{ \Carbon\Carbon::parse($review->review_date)->format('d M Y') }}</td>
                                        <td>
                                            <button class="btn btn-light-primary btn-sm" onclick="showFeedback('{{ addslashes($review->feedback) }}')">View Feedback</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No reviews found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Review -->
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
    <div class="modal fade" id="addReviewModal" tabindex="-1" role="dialog" aria-labelledby="addReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReviewModalLabel">New Performance Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('performance.store') }}" method="POST">
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
                                <label class="form-label">Review Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="yearly">Yearly Appraisal</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rating (1-5)</label>
                                <select name="rating" class="form-select" required>
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Needs Improvement</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Review Date</label>
                                <input type="date" name="review_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Feedback</label>
                                <textarea name="feedback" class="form-control" rows="4" placeholder="Enter detailed performance feedback..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger shadow-none" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Feedback View Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="feedbackText" style="white-space: pre-wrap;"></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/performance/index.js') }}"></script>
@endsection
