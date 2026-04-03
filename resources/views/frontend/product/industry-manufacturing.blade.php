@extends('frontend.layouts.page')

@section('meta_title', 'HR for Manufacturing | EliteHR')
@section('meta_description', 'Manage shift workers, automate attendance, and maintain compliance in the manufacturing sector with EliteHR.')
@section('meta_keywords', 'Manufacturing HR, Shift Management, Manufacturing Software')

@section('page_content')
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">Manufacturing Industry</h1>
                    </div>
                    <p class="mb-4 fs-5">Tailored HR solutions for factory workforce and shift management.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Shift Rotation</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Labor Compliance</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Safety Tracking</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Overtime Rules</h6></div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4"><i class="fa fa-industry text-primary" style="font-size: 80px;"></i></div>
                        <h3 class="fw-bold mb-3">Manufacturing Industry</h3>
                        <p class="text-muted">Part of the EliteHR unified platform. Seamlessly integrated for maximum efficiency.</p>
                        <div class="position-absolute top-0 start-0 translate-middle mt-5 ms-5 badge bg-success rounded-pill px-3 py-2 shadow"><i class="fa fa-star text-warning me-1"></i> Top Rated</div>
                        <div class="position-absolute bottom-0 end-0 translate-middle mb-5 me-2 badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fa fa-shield-alt me-1"></i> Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.partials.features')
    @include('frontend.partials.quote')
@endsection
