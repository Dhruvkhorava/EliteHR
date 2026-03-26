@extends('frontend.layouts.page')

@section('page_title', 'About EliteHR')

@section('page_content')
    <!-- About Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">About EliteHR</h5>
                        <h1 class="mb-0">Transforming the Way You Manage Your Human Capital</h1>
                    </div>
                    <p class="mb-4">EliteHR is a state-of-the-art Human Resource Management System built for modern businesses. We understand that your employees are your most valuable asset, and our mission is to provide you with the tools to manage, engage, and grow your workforce efficiently.</p>
                    <p class="mb-4">From recruitment to retirement, EliteHR streamlines every aspect of the employee lifecycle, ensuring compliance, accuracy, and a premium experience for both HR administrators and employees.</p>
                    <div class="row g-0 mb-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Innovative HR Technology</h5>
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Data-Driven Insights</h5>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.4s">
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Security First Approach</h5>
                            <h5 class="mb-3"><i class="fa fa-check text-primary me-3"></i>Global Compliance</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 wow fadeIn" data-wow-delay="0.6s">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fa fa-phone-alt text-white"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="mb-2">Talk to an HR specialist</h5>
                            <h4 class="text-primary mb-0">+91 8844996655</h4>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.9s">Get Started</a>
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

    <!-- Team Start -->
    @include('frontend.partials.team')
    <!-- Team End -->
@endsection
