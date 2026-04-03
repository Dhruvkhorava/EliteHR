@extends('frontend.layouts.page')

@section('meta_title', 'Performance Management | EliteHR Appraisals')
@section('meta_description', 'Drive employee growth with goal setting, continuous feedback, and comprehensive appraisals through EliteHR.')
@section('meta_keywords', 'Performance Management, Appraisals, Goal Tracking, EliteHR')

@section('page_content')
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">Performance Management</h1>
                    </div>
                    <p class="mb-4 fs-5">Drive growth with continuous feedback, appraisals, and goal setting.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">360 Feedback</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">KPI/OKR Tracking</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Appraisal Cycles</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Skill Assessment</h6></div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4"><i class="fa fa-chart-line text-primary" style="font-size: 80px;"></i></div>
                        <h3 class="fw-bold mb-3">Performance Management</h3>
                        <p class="text-muted">Part of the EliteHR unified platform. Seamlessly integrated for maximum efficiency.</p>
                        <div class="position-absolute top-0 start-0 translate-middle mt-5 ms-5 badge bg-success rounded-pill px-3 py-2 shadow"><i class="fa fa-star text-warning me-1"></i> Top Rated</div>
                        <div class="position-absolute bottom-0 end-0 translate-middle mb-5 me-2 badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fa fa-shield-alt me-1"></i> Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Modern Software Section Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s" style="background-color: #f0fbf6;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="font-size: 2.5rem; color: #1a1a1a;">
                    Why businesses need modern <span style="color: #06A3DA;">employee performance management software?</span>
                </h2>
            </div>
            
            <div class="row g-4 mt-2">
                <!-- Col 1 -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.2s">
                    <div class="d-flex flex-column align-items-start bg-white p-4 h-100 rounded shadow-sm border-0">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 70px; height: 70px; background: rgba(6, 163, 218, 0.1);">
                            <i class="fa fa-envelope-open-text fs-2" style="color: #06A3DA;"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="min-height: 48px;">Unstructured & Delayed Reviews</h5>
                        <p class="text-muted fs-6 mb-0">Spreadsheets and emails slow everything down. HR chases inputs, reviews happen late, and feedback arrives when it's no longer relevant.</p>
                    </div>
                </div>

                <!-- Col 2 -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.4s">
                    <div class="d-flex flex-column align-items-start bg-white p-4 h-100 rounded shadow-sm border-0">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 70px; height: 70px; background: rgba(6, 163, 218, 0.1);">
                            <i class="fa fa-list-ol fs-2" style="color: #06A3DA;"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="min-height: 48px;">Biased & Inconsistent Ratings</h5>
                        <p class="text-muted fs-6 mb-0">Without clear metrics or calibration, evaluations depend on personal judgment. Bias creeps in, ratings vary across teams, and employees lose trust in the process.</p>
                    </div>
                </div>

                <!-- Col 3 -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                    <div class="d-flex flex-column align-items-start bg-white p-4 h-100 rounded shadow-sm border-0">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 70px; height: 70px; background: rgba(6, 163, 218, 0.1);">
                            <i class="fa fa-copy fs-2" style="color: #06A3DA;"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="min-height: 48px;">Overwhelming manual work</h5>
                        <p class="text-muted fs-6 mb-0">Endless coordination, data entry, and reminders drain HR bandwidth. Valuable time goes into paperwork instead of performance coaching and people strategy.</p>
                    </div>
                </div>

                <!-- Col 4 -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.8s">
                    <div class="d-flex flex-column align-items-start bg-white p-4 h-100 rounded shadow-sm border-0">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 70px; height: 70px; background: rgba(6, 163, 218, 0.1);">
                            <i class="fa fa-frown fs-2" style="color: #06A3DA;"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="min-height: 48px;">Low Trust & Engagement</h5>
                        <p class="text-muted fs-6 mb-0">Opaque reviews and unclear criteria make employees feel unseen and undervalued. When the process feels unfair, motivation and retention take a hit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Why Modern Software Section End -->
    @include('frontend.partials.features')
    @include('frontend.partials.quote')
@endsection
