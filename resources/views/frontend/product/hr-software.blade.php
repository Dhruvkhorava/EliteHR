@extends('frontend.layouts.page')

@section('meta_title', 'Core HR Software | Centralized Data with EliteHR')
@section('meta_description', 'Centralize all your employee data, manage organizational structures, and secure documents effortlessly with EliteHR Core.')
@section('meta_keywords', 'Core HR Software, HR Database, Employee Information, EliteHR Core')

@section('page_content')
    <!-- Product Detail Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">HR Software</h1>
                    </div>
                    <p class="mb-4 fs-5">Comprehensive HR management system to streamline your workforce operations.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Core HR</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Employee Lifecycle</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Digital Records</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Compliance Management</h6>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4">
                            <i class="fa fa-users text-primary" style="font-size: 80px;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">HR Software</h3>
                        <p class="text-muted">Part of the EliteHR unified platform. Seamlessly integrated for maximum efficiency.</p>
                        
                        <!-- Floating Badges for Premium Feel -->
                        <div class="position-absolute top-0 start-0 translate-middle mt-5 ms-5 badge bg-success rounded-pill px-3 py-2 shadow"><i class="fa fa-star text-warning me-1"></i> Top Rated</div>
                        <div class="position-absolute bottom-0 end-0 translate-middle mb-5 me-2 badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fa fa-shield-alt me-1"></i> Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Detail End -->

    <!-- Product Highlights Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title position-relative pb-3 mb-5 mx-auto text-center" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">Inside EliteHR</h5>
                <h2 class="mb-0">Transform How You Manage Your People</h2>
            </div>
            
            <div class="row g-5 align-items-center mb-5 pb-4">
                <!-- Large Image Display -->
                <div class="col-lg-7 wow zoomIn" data-wow-delay="0.3s">
                    <div class="position-relative overflow-hidden rounded shadow-lg p-2 bg-white">
                        <img class="img-fluid border rounded w-100" src="{{ asset('asset/images/hr/hr.png') }}" alt="HR Software Interface Overview">
                    </div>
                </div>
                
                <!-- Relevant Content -->
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.5s">
                    <h3 class="mb-4">A Centralized HR Hub</h3>
                    <p class="mb-4 fs-5 text-muted">
                        Say goodbye to scattered spreadsheets and disconnected systems. Our HR Software provides a single, unified dashboard where you can oversee every aspect of your employees' lifecycle. 
                    </p>
                    <ul class="list-unstyled mb-4 text-muted fs-5">
                        <li class="mb-3"><i class="fa fa-arrow-right text-primary me-3"></i><strong>Organized Digital Records:</strong> Securely store and access staff documents in one click.</li>
                        <li class="mb-3"><i class="fa fa-arrow-right text-primary me-3"></i><strong>Automated Workflows:</strong> Streamline approvals for leaves, expenses, and structural changes.</li>
                        <li><i class="fa fa-arrow-right text-primary me-3"></i><strong>Real-Time Analytics:</strong> Make data-driven decisions with built-in reporting tools.</li>
                    </ul>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-2 shadow-sm">Explore Capabilities</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Highlights End -->

    <!-- Features Section Reused -->
    @include('frontend.partials.features')

    <!-- Quote Section Reused -->
    @include('frontend.partials.quote')
@endsection
