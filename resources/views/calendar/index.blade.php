@extends('layouts.app')

@section('styles')
{{-- Style Here --}}
    <link rel="stylesheet" href="{{asset('plugins/src/fullcalendar/fullcalendar.min.css')}}">
    @vite(['resources/scss/light/plugins/fullcalendar/custom-fullcalendar.scss'])
    @vite(['resources/scss/light/assets/components/modal.scss'])

    @vite(['resources/scss/dark/plugins/fullcalendar/custom-fullcalendar.scss'])
    @vite(['resources/scss/dark/assets/components/modal.scss'])

    <link rel="stylesheet" href="{{ asset('asset/css/calendar/index.css') }}">
@endsection

@section('content')
<div class="row layout-top-spacing layout-spacing" id="cancel-row">
    
    <!-- Sidebar -->
    <div class="col-xl-3 col-lg-4 col-md-12 mb-4">
        <div class="calendar-sidebar">
            <button class="btn btn-primary w-100 mb-4 py-2 fw-bold shadow-sm" id="btn-add-event-sidebar">
                <i class="fas fa-plus me-2"></i> Create New Event
            </button>

            <div class="mb-4">
                <h6 class="fw-bold mb-3 text-uppercase small opacity-75">Event Categories</h6>
                <div class="category-legend-item">
                    <div class="category-dot bg-primary"></div> Custom / Work
                </div>
                <div class="category-legend-item">
                    <div class="category-dot bg-success"></div> Personal
                </div>
                <div class="category-legend-item">
                    <div class="category-dot bg-warning"></div> Travel
                </div>
                <div class="category-legend-item">
                    <div class="category-dot bg-danger"></div> Important / Birthday
                </div>
                <div class="category-legend-item">
                    <div class="category-dot bg-info"></div> Interviews
                </div>
                <div class="category-legend-item">
                    <div class="category-dot bg-secondary font-weight-bold"></div> Holidays
                </div>
            </div>

            <hr class="opacity-25 my-4">

            <div>
                <h6 class="fw-bold mb-3 text-uppercase small opacity-75">Upcoming This Month</h6>
                <div id="upcoming-events-list">
                    <p class="text-muted small">Loading upcoming events...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Calendar -->
    <div class="col-xl-9 col-lg-8 col-md-12">
        <div class="calendar-wrapper">
            <div class="calendar"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light-primary">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted">Title</label>
                        <input id="event-title" type="text" class="form-control" placeholder="What are you planning?">
                    </div>

                    <div class="col-md-6 d-none">
                        <label class="form-label fw-bold small text-muted">Start Date</label>
                        <input id="event-start-date" type="datetime-local" class="form-control">
                    </div>

                    <div class="col-md-6 d-none">
                        <label class="form-label fw-bold small text-muted">End Date</label>
                        <input id="event-end-date" type="datetime-local" class="form-control">
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label fw-bold small text-muted mb-2 d-block">Select Category</label>
                        <div class="d-flex flex-wrap gap-2 justify-content-between">
                            <div class="form-check form-check-primary">
                                <input class="form-check-input" type="radio" name="event-level" value="Work" id="rwork" checked>
                                <label class="form-check-label" for="rwork">Work</label>
                            </div>
                            <div class="form-check form-check-warning">
                                <input class="form-check-input" type="radio" name="event-level" value="Travel" id="rtravel">
                                <label class="form-check-label" for="rtravel">Travel</label>
                            </div>
                            <div class="form-check form-check-success">
                                <input class="form-check-input" type="radio" name="event-level" value="Personal" id="rPersonal">
                                <label class="form-check-label" for="rPersonal">Personal</label>
                            </div>
                            <div class="form-check form-check-danger">
                                <input class="form-check-input" type="radio" name="event-level" value="Important" id="rImportant">
                                <label class="form-check-label" for="rImportant">Important</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3" id="event-description-container">
                         <label class="form-label fw-bold small text-muted">Description</label>
                         <div id="event-description-view" class="p-3 bg-light rounded-3 small text-dark d-none border"></div>
                         <textarea id="event-description" class="form-control" rows="3" placeholder="Additional details..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-update-event shadow-sm">Update Event</button>
                <button type="button" class="btn btn-primary btn-add-event shadow-sm">Save Event</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/src/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('plugins/src/uuid/uuid4.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.calendarData = {
            fetchUrl: '{{ route("calendar.events") }}',
            storeUrl: '{{ route("calendar.events.store") }}'
        };
    </script>
    <script src="{{ asset('asset/js/calendar_index.js') }}"></script>
@endsection