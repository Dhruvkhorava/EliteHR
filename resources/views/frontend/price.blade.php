@extends('frontend.layouts.page')

@section('meta_title', 'Pricing | EliteHR Plans')
@section('meta_description', 'Discover transparent and flexible pricing plans for EliteHR. Find the perfect HR software package for your growing business.')
@section('meta_keywords', 'EliteHR Pricing, HR Software Cost, Pricing Plans')

@section('page_title', 'Pricing Plan')

@section('page_content')
    <!-- Pricing Start -->
    @include('frontend.partials.pricing')
    <!-- Pricing End -->

    <!-- Add-Ons Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s" style="background-color: #ffffff;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="font-size: 2.5rem; color: #1a1a1a;">
                    Some <span style="color: #06A3DA;">EliteHR Add-ons</span> to go?
                </h2>
            </div>
            
            <div class="row g-4">
                
                <!-- Left Column -->
                <div class="col-lg-6">
                    <!-- Expense Management -->
                    <div class="card border-0 rounded-4 p-4 mb-4 shadow-sm" style="background-color: #f3e5f5;">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div class="pe-3">
                                <h5 class="fw-bold mb-1" style="color: #8e24aa;">Expense Management</h5>
                                <p class="mb-2 fw-bold text-dark fs-6" style="font-family: inherit;">₹15/employee/month</p>
                                <p class="small text-muted mb-0">Snap receipts with OCR, approve on mobile, and automate finance payouts</p>
                            </div>
                            <div class="flex-shrink-0 text-center">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-file-invoice-dollar fa-2x" style="color: #8e24aa;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Management Software -->
                    <div class="card border-0 rounded-4 p-4 mb-4 shadow-sm" style="background-color: #e8f5e9;">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div class="pe-3">
                                <h5 class="fw-bold mb-1" style="color: #5e35b1;">Performance Management Software</h5>
                                <p class="mb-2 fw-bold text-dark fs-6" style="font-family: inherit;">Starts at ₹35/user/month</p>
                                <p class="small text-muted mb-0">Goals, Reviews, Calibration & 360 Feedback</p>
                            </div>
                            <div class="flex-shrink-0 text-center">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-chart-pie fa-2x" style="color: #5e35b1;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visage -->
                    <div class="card border-0 rounded-4 p-4 shadow-sm" style="background-color: #fff8e1;">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div class="pe-3">
                                <h5 class="fw-bold mb-1" style="color: #d81b60;">Visage</h5>
                                <p class="mb-2 fw-bold text-dark fs-6" style="font-family: inherit;">₹20/user/month</p>
                                <p class="small text-muted mb-0">AI-powered Facial Recognition-Based attendance Marking</p>
                            </div>
                            <div class="flex-shrink-0 text-center">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-camera fa-2x" style="color: #d81b60;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6">
                    <!-- Alumni Portal -->
                    <div class="card border-0 rounded-4 p-4 mb-4 shadow-sm" style="background-color: #e0f7fa;">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div class="pe-3">
                                <h5 class="fw-bold mb-1" style="color: #5e35b1;">Alumni Portal</h5>
                                <p class="mb-2 fw-bold text-dark fs-6" style="font-family: inherit;">Starts at ₹15/user/month</p>
                                <p class="small text-muted mb-0">(Post-Exit) Employee access to Payslips, Form 16, IT Statements, Letters, and more</p>
                            </div>
                            <div class="flex-shrink-0 text-center">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-user-graduate fa-2x" style="color: #5e35b1;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GeoMark+ -->
                    <div class="card border-0 rounded-4 p-4 mb-4 shadow-sm" style="background-color: #fce4ec;">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div class="pe-3">
                                <h5 class="fw-bold mb-1" style="color: #8e24aa;">GeoMark+</h5>
                                <p class="mb-2 fw-bold text-dark fs-6" style="font-family: inherit;">₹50/user/month</p>
                                <p class="small text-muted mb-0">Map-Based Attendance Marking with location Tagging</p>
                            </div>
                            <div class="flex-shrink-0 text-center">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-map-marker-alt fa-2x" style="color: #8e24aa;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recruit -->
                    <div class="card border-0 rounded-4 p-4 shadow-sm" style="background-color: #e8f5e9;">
                        <div class="d-flex justify-content-between align-items-center h-100">
                            <div class="pe-3">
                                <h5 class="fw-bold mb-1" style="color: #5e35b1;">Recruit</h5>
                                <p class="mb-2 fw-bold text-dark fs-6" style="font-family: inherit;">₹2500/recruiter/month</p>
                                <p class="small text-muted mb-0">Accelerate Hiring with our all-in-one Recruitment Solution</p>
                            </div>
                            <div class="flex-shrink-0 text-center">
                                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa fa-users-cog fa-2x" style="color: #5e35b1;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Add-Ons End -->

    <!-- Quote Start -->
    @include('frontend.partials.quote')
    <!-- Quote End -->
@endsection
