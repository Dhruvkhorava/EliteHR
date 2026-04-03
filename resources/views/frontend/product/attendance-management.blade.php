@extends('frontend.layouts.page')

@section('meta_title', 'Attendance Management | EliteHR')
@section('meta_description', 'Track time, attendance, shifts, and overtime with real-time biometric and app integrations using EliteHR.')
@section('meta_keywords', 'Attendance Tracking, Time Tracker, Shift Roster, EliteHR Attendance')

@section('page_content')
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">Attendance Management</h1>
                    </div>
                    <p class="mb-4 fs-5">Real-time tracking of employee presence, shifts, and working hours.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Bio-metric Integration</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Shift Scheduling</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">OT Calculations</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">GPS Tracking</h6></div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4"><i class="fa fa-clock text-primary" style="font-size: 80px;"></i></div>
                        <h3 class="fw-bold mb-3">Attendance Management</h3>
                        <p class="text-muted">Part of the EliteHR unified platform. Seamlessly integrated for maximum efficiency.</p>
                        <div class="position-absolute top-0 start-0 translate-middle mt-5 ms-5 badge bg-success rounded-pill px-3 py-2 shadow"><i class="fa fa-star text-warning me-1"></i> Top Rated</div>
                        <div class="position-absolute bottom-0 end-0 translate-middle mb-5 me-2 badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fa fa-shield-alt me-1"></i> Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Mastery Section Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s" style="background-color: #f8f9fa;">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow slideInUp" data-wow-delay="0.3s">
                    <div class="position-relative text-center p-4 bg-white rounded shadow-lg border border-5 border-light">
                        <img class="img-fluid rounded" src="{{ asset('asset/images/attendance/attendance.png') }}" alt="Man standing with clock managing time" style="max-height: 450px;">
                    </div>
                </div>
                <div class="col-lg-6 wow slideInUp" data-wow-delay="0.6s">
                    <h5 class="fw-bold text-primary text-uppercase">Master Your Time</h5>
                    <h2 class="mb-4">Every Second Counts Towards Your Success</h2>
                    <p class="mb-4 fs-5 text-muted">
                        Punctuality and accurate time tracking are the heartbeat of a productive organization. Take full control of your workforce's hours with our intelligent attendance systems.
                    </p>
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <div class="btn-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-stopwatch text-white"></i>
                                </div>
                                <h5 class="mb-0">Eliminate Time Theft</h5>
                            </div>
                            <p class="ms-5 text-muted">Ensure employees are where they need to be, precisely when they need to be there using geo-fencing and biometric verification.</p>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <div class="btn-square bg-primary rounded-circle me-3">
                                    <i class="fa fa-chart-line text-white"></i>
                                </div>
                                <h5 class="mb-0">Boost Ongoing Productivity</h5>
                            </div>
                            <p class="ms-5 text-muted">Identify absence patterns quickly and support your team efficiently, reducing downtime and streamlining daily operations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Time Mastery Section End -->
    @include('frontend.partials.features')
    @include('frontend.partials.quote')
@endsection
