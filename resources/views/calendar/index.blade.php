@extends('layouts.app')

@section('styles')
    <link href="{{ asset('plugins/src/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    @vite(['resources/scss/light/plugins/fullcalendar/custom-fullcalendar.scss'])
    @vite(['resources/scss/dark/plugins/fullcalendar/custom-fullcalendar.scss'])
    <link href="{{ asset('asset/css/calendar/index.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="calendar-upper-section">
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <h4 class="mb-0">Company Calendar</h4>
                                <p class="text-muted">Interviews, Leaves, and Events</p>
                            </div>
                            <div class="col-md-4 col-12 text-md-end">
                                <div class="d-flex justify-content-md-end gap-2">
                                    <div class="d-flex align-items-center me-3">
                                        <span class="badge bg-primary me-1" style="width: 12px; height: 12px; display: inline-block;"></span>
                                        <small>Interviews</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-1" style="width: 12px; height: 12px; display: inline-block;"></span>
                                        <small>Leaves</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="calendar" class="calendar mt-4" data-events-url="{{ route('calendar.events') }}"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <div id="event-type-icon" class="me-3 p-3 rounded-circle text-white">
                            <i id="type-icon-inner"></i>
                        </div>
                        <div>
                            <h4 id="display-event-title" class="mb-0"></h4>
                            <span id="display-event-type" class="badge"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="text-muted mb-1 d-block"><i class="feather-calendar me-1"></i> Date & Time</label>
                        <p id="display-event-date" class="h6 mb-0 font-weight-bold"></p>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted mb-1 d-block"><i class="feather-info me-1"></i> Description</label>
                        <p id="display-event-description" class="mb-0"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/src/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('asset/js/calendar/index.js') }}"></script>
@endsection
