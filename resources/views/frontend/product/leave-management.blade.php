@extends('frontend.layouts.page')

@section('meta_title', 'Leave Management System | EliteHR')
@section('meta_description', 'Track time off effortlessly. Manage sick leaves, casual leaves, and custom leave policies with EliteHR.')
@section('meta_keywords', 'Leave Management, Time Off Tracking, Absenteeism, EliteHR Leave')

@section('page_content')
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">Leave Management</h1>
                    </div>
                    <p class="mb-4 fs-5">Efficiently track and manage employee leave requests and balances.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Custom Leave Types</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Approval Workflow</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Balance Tracking</h6></div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3"><i class="fa fa-check text-primary me-3"></i><h6 class="mb-0">Holiday Calendar</h6></div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4"><i class="fa fa-calendar-alt text-primary" style="font-size: 80px;"></i></div>
                        <h3 class="fw-bold mb-3">Leave Management</h3>
                        <p class="text-muted">Part of the EliteHR unified platform. Seamlessly integrated for maximum efficiency.</p>
                        <div class="position-absolute top-0 start-0 translate-middle mt-5 ms-5 badge bg-success rounded-pill px-3 py-2 shadow"><i class="fa fa-star text-warning me-1"></i> Top Rated</div>
                        <div class="position-absolute bottom-0 end-0 translate-middle mb-5 me-2 badge bg-primary rounded-pill px-3 py-2 shadow"><i class="fa fa-shield-alt me-1"></i> Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Product Detail End -->

    <!-- Custom Efficiency Grid Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="font-size: 2.5rem; color: #1a1a1a;">
                    Online leave management. <span style="color: #06A3DA;">Now made more efficient.</span>
                </h2>
            </div>
            
            <div class="row g-5 mt-2">
                <!-- Item 1: Save -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.2s">
                    <div class="d-flex flex-column align-items-start">
                        <div class="d-inline-flex align-items-center justify-content-center rounded" style="width: 65px; height: 65px; background-color: #e8f5e9; margin-bottom: 20px;">
                            <i class="fa fa-clock fs-3" style="color: #4caf50;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Save</h4>
                        <p class="text-muted fs-6">time & effort</p>
                    </div>
                </div>

                <!-- Item 2: Administer -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.4s">
                    <div class="d-flex flex-column align-items-start">
                        <div class="d-inline-flex align-items-center justify-content-center rounded" style="width: 65px; height: 65px; background-color: #f3e5f5; margin-bottom: 20px;">
                            <i class="fa fa-clipboard-check fs-3" style="color: #9c27b0;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Administer</h4>
                        <p class="text-muted fs-6">uniform leave policy</p>
                    </div>
                </div>

                <!-- Item 3: Ensure -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                    <div class="d-flex flex-column align-items-start">
                        <div class="d-inline-flex align-items-center justify-content-center rounded" style="width: 65px; height: 65px; background-color: #fff3e0; margin-bottom: 20px;">
                            <i class="fa fa-calendar-alt fs-3" style="color: #ff9800;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Ensure</h4>
                        <p class="text-muted fs-6">accurate leave accounting</p>
                    </div>
                </div>

                <!-- Item 4: Reduce -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="0.8s">
                    <div class="d-flex flex-column align-items-start">
                        <div class="d-inline-flex align-items-center justify-content-center rounded" style="width: 65px; height: 65px; background-color: #fff8e1; margin-bottom: 20px;">
                            <i class="fa fa-file-invoice-dollar fs-3" style="color: #ffb300;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Reduce</h4>
                        <p class="text-muted fs-6">unnecessary expense</p>
                    </div>
                </div>

                <!-- Item 5: Deliver (Offset by 3 columns to align under Administer) -->
                <div class="col-lg-3 col-md-6 offset-lg-3 wow zoomIn" data-wow-delay="1.0s">
                    <div class="d-flex flex-column align-items-start mt-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded" style="width: 65px; height: 65px; background-color: #e1f5fe; margin-bottom: 20px;">
                            <i class="fa fa-smile-beam fs-3" style="color: #03a9f4;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Deliver</h4>
                        <p class="text-muted fs-6">an outstanding employee<br>experience</p>
                    </div>
                </div>

                <!-- Item 6: Improve -->
                <div class="col-lg-3 col-md-6 wow zoomIn" data-wow-delay="1.2s">
                    <div class="d-flex flex-column align-items-start mt-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded" style="width: 65px; height: 65px; background-color: #e0f2f1; margin-bottom: 20px;">
                            <i class="fa fa-bullseye fs-3" style="color: #009688;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Improve</h4>
                        <p class="text-muted fs-6">employer brand image</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Custom Efficiency Grid End -->


@endsection
