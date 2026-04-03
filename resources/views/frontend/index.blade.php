@extends('frontend.layouts.app')

@section('meta_title', 'Home | EliteHR - Next Gen HR Platform')
@section('meta_description', 'Empower your people and elevate your business with EliteHR. The unified platform for global recruitment and payroll.')
@section('meta_keywords', 'HRMS, EliteHR, Home, Payroll, Recruitment')

@section('header')
    <div class="container-fluid position-relative p-0 hero-header-modern" style="background: linear-gradient(rgb(38 92 175 / 55%), rgba(9, 30, 62, 0.85)), url('{{ asset('frontend/img/carousel-1.jpg') }}') center center no-repeat; background-size: cover; padding: 160px 0 120px 0; margin-bottom: 90px;">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    {{-- <div class="d-inline-flex align-items-center mb-4 py-2 px-4 bg-white rounded-pill shadow-sm animated slideInDown" style="border: 1px solid rgba(6, 163, 218, 0.2);">
                        <span class="badge bg-primary rounded-pill me-3" style="font-weight: 600; padding: 8px 15px; animation: pulse-blue 2s infinite;">New</span>
                        <span class="text-dark fw-bold" style="font-size: 0.9rem; letter-spacing: 1px;">NEXT-GEN HR PLATFORM 2026</span>
                    </div>
                    <h1 class="display-2 text-white mb-md-4 animated zoomIn" style="font-weight: 800; line-height: 1.1;">
                        Optimize Your <span class="text-gradient">Workforce</span> & <br>Scale with <span class="text-primary">EliteHR</span>
                    </h1>
                    <p class="text-white mb-5 pb-3 animated slideInLeft" style="font-size: 1.25rem; opacity: 0.85; line-height: 1.6; max-width: 600px;">Experience the future of HR Management. Our AI-driven suite automates recruitment, perfects payroll, and empowers every employee.</p> --}}
                    
                    <div class="hero-glass-card animated slideInLeft">
                        <div class="d-inline-flex align-items-center mb-4 py-2 px-4 bg-white rounded-pill shadow-sm" style="border: 1px solid rgba(6, 163, 218, 0.2);">
                            <span class="badge bg-primary rounded-pill me-3" style="font-weight: 600; padding: 8px 15px;">2026 EDITION</span>
                            <span class="text-dark fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">THE ELITE STANDARD IN HRMS</span>
                        </div>
                        <h1 class="display-3 text-white mb-4" style="font-weight: 800; line-height: 1.1;">
                            Empower Your <span class="text-gradient">People</span> <br>Elevate Your <span class="text-primary">Business</span>
                        </h1>
                        <p class="text-white-50 mb-5 fs-5" style="max-width: 500px; line-height: 1.6;">Unified platform for global recruitment, borderless payroll, and legendary employee engagement.</p>
                        
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 shadow-lg" style="border-radius: 50px; font-weight: 700; background: linear-gradient(45deg, #06A3DA, #00D2FF); border: none;">
                                Start Free Trial <i class="fa fa-chevron-right ms-2 scale-hover"></i>
                            </a>
                            <a href="{{ route('front.contact') }}" class="btn btn-outline-light py-3 px-5 hover-bg-primary" style="border-radius: 50px; font-weight: 600; backdrop-filter: blur(5px);">
                                Explore Platform
                            </a>
                        </div>

                        <div class="mt-5 d-flex align-items-center">
                            <img src="{{ asset('frontend/img/testimonial-1.jpg') }}" class="rounded-circle border border-2 border-white" style="width: 40px; height: 40px; margin-right: -10px; z-index: 3;" alt="User">
                            <img src="{{ asset('frontend/img/testimonial-2.jpg') }}" class="rounded-circle border border-2 border-white" style="width: 40px; height: 40px; margin-right: -10px; z-index: 2;" alt="User">
                            <img src="{{ asset('frontend/img/testimonial-3.jpg') }}" class="rounded-circle border border-2 border-white" style="width: 40px; height: 40px; margin-right: 15px; z-index: 1;" alt="User">
                            <div class="text-white">
                                <div class="fw-bold" style="font-size: 0.9rem;">Join 10,000+ HR Pros</div>
                                <div class="text-warning small"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> <span class="text-white-50">(4.9/5)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 position-relative animated zoomIn" data-wow-delay="0.3s">
                    <div class="hero-image-wrap p-3 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <img class="img-fluid rounded-4 shadow-lg" src="{{ asset('frontend/img/about.png') }}" alt="Dashboard Preview">
                        
                        <!-- Premium UI Widgets -->
                        <div class="floating-ui-widget wow fadeInRight" data-wow-delay="0.7s" style="top: -38px; right: -38px;">
                            <div class="bg-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="fa fa-check text-white small"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 small fw-bold">Payroll Batch #52</h6>
                                <span class="text-success small fw-bold">COMPLETED</span>
                            </div>
                        </div>

                        <div class="floating-ui-widget wow fadeInLeft" data-wow-delay="1.1s" style="bottom: -9%; left: -7px;">
                            <img src="{{ asset('frontend/img/testimonial-2.jpg') }}" class="rounded-circle me-3" style="width: 40px; height: 40px;" alt="Member">
                            <div>
                                <h6 class="mb-0 small fw-bold">Sarah Jenkins</h6>
                                <span class="text-muted small">New Senior Developer</span>
                            </div>
                        </div>

                        <div class="pulse-ring-modern" style="top: 20%; right: 10%;"></div>
                        <div class="pulse-ring-modern" style="bottom: 30%; left: 20%; animation-delay: 1.5s;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(9, 30, 62, .7);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-transparent border-primary p-3" placeholder="Type search keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->


    <!-- Facts Start -->
    <div class="container-fluid facts py-5 pt-lg-0">
        <div class="container py-5 pt-lg-0">
            <div class="row gx-0">
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.1s">
                    <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-users text-primary"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-white mb-0">Total Employees</h5>
                            <h1 class="text-white mb-0" data-toggle="counter-up">500</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.3s">
                    <div class="bg-light shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-check text-white"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-primary mb-0">Hired Candidates</h5>
                            <h1 class="mb-0" data-toggle="counter-up">1200</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow zoomIn" data-wow-delay="0.6s">
                    <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-award text-primary"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-white mb-0">Company Clients</h5>
                            <h1 class="text-white mb-0" data-toggle="counter-up">150</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Facts End -->


    <!-- About Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">About EliteHR</h5>
                        <h1 class="mb-0">The Best HR Management Solution With 10 Years of Experience</h1>
                    </div>
                    <p class="mb-4">EliteHR is a comprehensive Human Resource Management System designed to simplify your HR operations. From managing employee lifecycle to automated payroll and recruitment, we provide all the tools you need to build a better workplace.</p>
                    <div class="row g-0 mb-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Award Winning System</h5>
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Professional Support</h5>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.4s">
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>24/7 Availability</h5>
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Scalable Solution</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 wow fadeIn" data-wow-delay="0.6s">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fa fa-phone-alt text-white"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="mb-2">Call us for an inquiry</h5>
                            <h4 class="text-primary mb-0">+91 8844996655</h4>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.9s">Request A Free Quote</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="about-img-container h-100">
                        <img class="img-fluid w-100 h-100 rounded shadow wow zoomIn" data-wow-delay="0.9s" src="{{ asset('frontend/img/about.png') }}" style="object-fit: cover;">
                        <div class="experience-badge-premium wow fadeInUp" data-wow-delay="1.2s">
                            <h2 class="text-white mb-0">10+</h2>
                            <small class="text-white-50 uppercase">Years Experience</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Features Start -->
    @include('frontend.partials.features')
    <!-- Features End -->


    <!-- Service Start -->
    @include('frontend.partials.services')
    <!-- Service End -->

    <!-- Quote Start -->
    @include('frontend.partials.quote')
    <!-- Quote End -->


    <!-- Testimonial Start -->
    @include('frontend.partials.testimonial')
    <!-- Testimonial End -->


    <!-- Team Start -->
    @include('frontend.partials.team')
    <!-- Team End -->


    <!-- Blog Start -->
    @include('frontend.partials.blog')
    <!-- Blog End -->

@endsection
