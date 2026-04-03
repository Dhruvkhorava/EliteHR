@extends('frontend.layouts.page')

@section('meta_title', 'Employee Self Service | EliteHR')
@section('meta_description', 'Empower employees with self-service portals for leaves, payslips, and data updates through EliteHR ESS.')
@section('meta_keywords', 'ESS, Employee Portal, Self Service HR')

@section('page_content')
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">Employee Self Service</h1>
                    </div>
                    <p class="mb-4 fs-5">Empower employees to manage their data, slips, and requests independently.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Profile Updates</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Payslip Access</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Request Portal</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Announcement Hub</h6></div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4"><i class="fa fa-user-cog text-primary" style="font-size: 80px;"></i></div>
                        <h3 class="fw-bold mb-3">Employee Self Service</h3>
                        <p class="text-muted">Part of the EliteHR unified platform. Seamlessly integrated for maximum efficiency.</p>
                        <div class="position-absolute top-0 start-0 translate-middle mt-5 ms-5 badge bg-success rounded-pill px-3 py-2 shadow"><i class="fa fa-star text-warning me-1"></i> Top Rated</div>
                        <div class="position-absolute bottom-0 end-0 translate-middle mb-5 me-2 badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fa fa-shield-alt me-1"></i> Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ESS Productivity Grid Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s" style="background-color: #ffffff;">
        <div class="container py-5">
            <div class="text-center mb-5 mx-auto" style="max-width: 900px;">
                <h2 class="fw-bold mb-3" style="font-size: 2.5rem; color: #06A3DA;">
                    Improved employee experience and morale<br>
                    <span style="color: #1a1a1a;">Improved productivity with ESS</span>
                </h2>
                <p class="text-muted fs-6 mb-2">
                    EliteHR's ESS portal helps you build an environment of efficiency, transparency and trust where employees have easy digital access to all necessary people, processes, information and documents. It's all as simple as you want it to be.
                </p>
                <p class="text-muted fs-6">
                    Here's how EliteHR's ESS Portal helps employees help themselves.
                </p>
            </div>
            
            <!-- Top Row (5 Items) -->
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4 mt-4 justify-content-center">
                <!-- Item 1 -->
                <div class="col text-center wow zoomIn" data-wow-delay="0.2s">
                    <div class="d-inline-flex align-items-center justify-content-center rounded mb-3" style="width: 65px; height: 65px; background-color: #e8f5e9;">
                        <i class="fa fa-clock fs-3" style="color: #4caf50;"></i>
                    </div>
                    <p class="text-muted fs-6 px-2">Mark attendance via web sign in or the mobile app</p>
                </div>
                <!-- Item 2 -->
                <div class="col text-center wow zoomIn" data-wow-delay="0.4s">
                    <div class="d-inline-flex align-items-center justify-content-center rounded mb-3" style="width: 65px; height: 65px; background-color: #f3e5f5;">
                        <i class="fa fa-file-invoice fs-3" style="color: #9c27b0;"></i>
                    </div>
                    <p class="text-muted fs-6 px-2">Access payslips and other payroll information in a few clicks</p>
                </div>
                <!-- Item 3 -->
                <div class="col text-center wow zoomIn" data-wow-delay="0.6s">
                    <div class="d-inline-flex align-items-center justify-content-center rounded mb-3" style="width: 65px; height: 65px; background-color: #fff3e0;">
                        <i class="fa fa-calendar-alt fs-3" style="color: #ff9800;"></i>
                    </div>
                    <p class="text-muted fs-6 px-2">View holiday calendar, apply for leave, check attendance information</p>
                </div>
                <!-- Item 4 -->
                <div class="col text-center wow zoomIn" data-wow-delay="0.8s">
                    <div class="d-inline-flex align-items-center justify-content-center rounded mb-3" style="width: 65px; height: 65px; background-color: #e1f5fe;">
                        <i class="fa fa-book-open fs-3" style="color: #03a9f4;"></i>
                    </div>
                    <p class="text-muted fs-6 px-2">View/download HR letters, company policies and documents</p>
                </div>
                <!-- Item 5 -->
                <div class="col text-center wow zoomIn" data-wow-delay="1.0s">
                    <div class="d-inline-flex align-items-center justify-content-center rounded mb-3" style="width: 65px; height: 65px; background-color: #fff8e1;">
                        <i class="fa fa-dollar-sign fs-3" style="color: #ffb300;"></i>
                    </div>
                    <p class="text-muted fs-6 px-2">Easy expense claims submission process</p>
                </div>
            </div>

            <!-- Bottom Row (2 Items Centered) -->
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4 mt-2 justify-content-center">
                <!-- Item 6 -->
                <div class="col text-center wow zoomIn" data-wow-delay="1.2s">
                    <div class="d-inline-flex align-items-center justify-content-center rounded mb-3" style="width: 65px; height: 65px; background-color: #e0f7fa;">
                        <i class="fa fa-question-circle fs-3" style="color: #00bcd4;"></i>
                    </div>
                    <p class="text-muted fs-6 px-2">Employee Help Desk for quick resolution to queries</p>
                </div>
                <!-- Item 7 -->
                <div class="col text-center wow zoomIn" data-wow-delay="1.4s">
                    <div class="d-inline-flex align-items-center justify-content-center rounded mb-3" style="width: 65px; height: 65px; background-color: #e8f5e9;">
                        <i class="fa fa-user-friends fs-3" style="color: #4caf50;"></i>
                    </div>
                    <p class="text-muted fs-6 px-2">Directory for easy communication with peers and managers</p>
                </div>
            </div>

        </div>
    </div>
    <!-- ESS Productivity Grid End -->
    @include('frontend.partials.features')
    @include('frontend.partials.quote')
@endsection
