@extends('frontend.layouts.page')

@section('meta_title', 'Recruitment Software | EliteHR applicant Tracking System')
@section('meta_description', 'Streamline your hiring process from requisition to onboarding with EliteHR recruitment software and ATS.')
@section('meta_keywords', 'Recruitment Software, ATS, Hiring Tools, EliteHR')

@section('page_content')
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">Recruitment Software</h1>
                    </div>
                    <p class="mb-4 fs-5">End-to-end hiring solution from job posting to onboarding.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Job Board Sync</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">ATS Tracking</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Interview Scheduling</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Offer Management</h6></div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4"><i class="fa fa-user-plus text-primary" style="font-size: 80px;"></i></div>
                        <h3 class="fw-bold mb-3">Recruitment Software</h3>
                        <p class="text-muted">Part of the EliteHR unified platform. Seamlessly integrated for maximum efficiency.</p>
                        <div class="position-absolute top-0 start-0 translate-middle mt-5 ms-5 badge bg-success rounded-pill px-3 py-2 shadow"><i class="fa fa-star text-warning me-1"></i> Top Rated</div>
                        <div class="position-absolute bottom-0 end-0 translate-middle mb-5 me-2 badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fa fa-shield-alt me-1"></i> Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ATS Benefits Section Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s" style="background-color: #ffffff;">
        <div class="container py-5">
            <div class="text-center mb-5 mx-auto" style="max-width: 900px;">
                <h2 class="fw-bold mb-3" style="font-size: 2.5rem; color: #1a1a1a;">
                    <span style="color: #06A3DA;">Recruitment</span> software (ATS) <span style="color: #06A3DA;">benefits</span> for every <span style="color: #06A3DA;">hiring</span> role
                </h2>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <!-- Card 1: Recruiters -->
                    <div class="card border-0 rounded-4 shadow-sm mb-4 wow fadeInUp" data-wow-delay="0.2s" style="background-color: #e6f7fc;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3 text-center p-5 rounded-start-4 d-none d-md-block" style="background-color: #06A3DA; min-height: 220px;">
                                <i class="fa fa-user-tie text-white" style="font-size: 80px;"></i>
                            </div>
                            <div class="col-md-9 p-4 p-md-5">
                                <h3 class="fw-bold mb-3" style="color: #1a1a1a;">For <span style="color: #06A3DA;">Recruiters</span></h3>
                                <ul class="list-unstyled mb-0 fs-6 text-muted">
                                    <li class="mb-3"><i class="fa fa-circle me-3" style="font-size: 10px; color: #06A3DA;"></i><strong class="text-dark">Faster Time-to-Hire:</strong> Repetitive tasks can be automated, streamlining recruitment and filling positions quickly.</li>
                                    <li class="mb-3"><i class="fa fa-circle me-3" style="font-size: 10px; color: #06A3DA;"></i><strong class="text-dark">Enhanced Decision-Making:</strong> Data-driven insights enable more informed and unbiased hiring decisions.</li>
                                    <li><i class="fa fa-circle me-3" style="font-size: 10px; color: #06A3DA;"></i><strong class="text-dark">Increased Efficiency:</strong> A streamlined process frees up time for recruiters to focus on strategic activities.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Hiring Managers -->
                    <div class="card border-0 rounded-4 shadow-sm mb-4 wow fadeInUp" data-wow-delay="0.4s" style="background-color: #e6f7fc;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3 text-center p-5 rounded-start-4 d-none d-md-block" style="background-color: #06A3DA; min-height: 220px;">
                                <i class="fa fa-user-check text-white" style="font-size: 80px;"></i>
                            </div>
                            <div class="col-md-9 p-4 p-md-5">
                                <h3 class="fw-bold mb-3" style="color: #1a1a1a;">For <span style="color: #06A3DA;">Hiring Managers</span></h3>
                                <ul class="list-unstyled mb-0 fs-6 text-muted">
                                    <li class="mb-3"><i class="fa fa-circle me-3" style="font-size: 10px; color: #06A3DA;"></i><strong class="text-dark">Timely Hiring:</strong> Positions are filled on time, minimizing the impact of vacancies on team productivity and project timelines.</li>
                                    <li><i class="fa fa-circle me-3" style="font-size: 10px; color: #06A3DA;"></i><strong class="text-dark">Better Quality Hires:</strong> Suitable candidates are shortlisted efficiently, leading to better hires who fit the role.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Candidates -->
                    <div class="card border-0 rounded-4 shadow-sm wow fadeInUp" data-wow-delay="0.6s" style="background-color: #e6f7fc;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3 text-center p-5 rounded-start-4 d-none d-md-block" style="background-color: #06A3DA; min-height: 220px;">
                                <i class="fa fa-user text-white" style="font-size: 80px;"></i>
                            </div>
                            <div class="col-md-9 p-4 p-md-5">
                                <h3 class="fw-bold mb-3" style="color: #1a1a1a;">For <span style="color: #06A3DA;">Candidates</span></h3>
                                <ul class="list-unstyled mb-0 fs-6 text-muted">
                                    <li class="mb-3"><i class="fa fa-circle me-3" style="font-size: 10px; color: #06A3DA;"></i><strong class="text-dark">Smoother Application Process:</strong> AI-powered solutions streamline the entire process, enhancing the overall experience.</li>
                                    <li><i class="fa fa-circle me-3" style="font-size: 10px; color: #06A3DA;"></i><strong class="text-dark">Faster Feedback:</strong> Automated communications keep candidates informed and engaged throughout the process.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- ATS Benefits Section End -->
    @include('frontend.partials.features')
    @include('frontend.partials.quote')
@endsection
