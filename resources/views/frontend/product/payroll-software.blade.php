@extends('frontend.layouts.page')

@section('meta_title', 'Payroll Software | Automate Salaries with EliteHR')
@section('meta_description', 'Automate salary structure setup, generate payslips, manage deductions, and stream payroll processing efficiently with EliteHR.')
@section('meta_keywords', 'Payroll Software, Salary Automation, Payslips, EliteHR Payroll')

@section('page_content')
    <!-- Product Detail Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title position-relative pb-3 mb-5">
                        <h5 class="fw-bold text-primary text-uppercase">EliteHR Suite</h5>
                        <h1 class="mb-0">Payroll Software</h1>
                    </div>
                    <p class="mb-4 fs-5">Automate salary processing, tax calculations, and compliance with ease.</p>
                    <div class="row g-4 mb-4">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Automated Processing</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Tax Compliance</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Payslip Generation</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.2s">
                            <div class="d-flex align-items-center bg-light rounded p-3">
                                <i class="fa fa-check text-primary me-3"></i>
                                <h6 class="mb-0">Direct Deposit</h6>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('front.quote') }}" class="btn btn-primary py-3 px-5 mt-3 wow zoomIn" data-wow-delay="0.6s">Get a Demo</a>
                    <a href="{{ route('front.contact') }}" class="btn btn-outline-primary py-3 px-5 mt-3 ms-2 wow zoomIn" data-wow-delay="0.8s">Contact Sales</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100 hero-glass-card shadow-lg p-5 rounded-4 d-flex flex-column align-items-center justify-content-center text-center wow zoomIn" data-wow-delay="0.9s" style="background: linear-gradient(135deg, rgba(6, 163, 218, 0.1) 0%, rgba(9, 30, 62, 0.05) 100%); border: 1px solid rgba(6, 163, 218, 0.2);">
                        <div class="bg-white p-4 rounded-circle shadow-sm mb-4">
                            <i class="fa fa-calculator text-primary" style="font-size: 80px;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Payroll Software</h3>
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

    <!-- Product Screenshots Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title position-relative pb-3 mb-5 mx-auto text-center" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">Inside the Platform</h5>
                <h2 class="mb-0">A Closer Look at Payroll Operations</h2>
            </div>
            
            <!-- Screenshot 1: Salary Setup (Image Left, Text Right) -->
            <div class="row g-5 align-items-center mb-5 pb-4">
                <div class="col-lg-7 wow zoomIn" data-wow-delay="0.3s">
                    <div class="position-relative overflow-hidden rounded shadow-lg p-2 bg-white">
                        <img class="img-fluid border rounded" src="{{ asset('asset/images/payroll/Generate.png') }}" alt="Employee Salary Setup">
                    </div>
                </div>
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.5s">
                    <h3 class="mb-4">Salary Setup</h3>
                    <p class="mb-4 fs-5 text-muted">Easily configure basic salary, HRA, and allowances for individual employees in one streamlined interface. The system ensures accurate data entry for seamless payroll processing.</p>
                </div>
            </div>
            
            <!-- Screenshot 2: Payroll History (Text Left, Image Right) -->
            <div class="row g-5 align-items-center mb-5 pb-4 flex-column-reverse flex-lg-row">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.5s">
                    <h3 class="mb-4">Payroll History</h3>
                    <p class="mb-4 fs-5 text-muted">Keep track of all generated salaries month over month. The history view provides instant visibility into gross pay, total deductions, and net salary records for every employee.</p>
                </div>
                <div class="col-lg-7 wow zoomIn" data-wow-delay="0.3s">
                    <div class="position-relative overflow-hidden rounded shadow-lg p-2 bg-white">
                        <img class="img-fluid border rounded" src="{{ asset('asset/images/payroll/SalarySetup.png') }}" alt="Payroll History">
                    </div>
                </div>
            </div>

            <!-- Screenshot 3: Payslip (Image Left, Text Right) -->
            <div class="row g-5 align-items-center">
                <div class="col-lg-7 wow zoomIn" data-wow-delay="0.3s">
                    <div class="position-relative overflow-hidden rounded shadow-lg p-2 bg-white">
                        <img class="img-fluid border rounded" src="{{ asset('asset/images/payroll/Payslip.png') }}" alt="Detailed Payslip">
                    </div>
                </div>
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.5s">
                    <h3 class="mb-4">Detailed Payslip</h3>
                    <p class="mb-4 fs-5 text-muted">Generate professional, downloadable PDF payslips dynamically for each employee. Our clean, branded layout ensures clarity on earnings, deductions, and net payable amounts.</p>
                </div>
            </div>

        </div>
    </div>
    <!-- Product Screenshots End -->
@endsection
