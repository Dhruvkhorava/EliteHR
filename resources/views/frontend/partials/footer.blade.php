<div class="container-fluid bg-dark text-light mt-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-4 col-md-6 footer-about">
                <div class="footer-about-premium d-flex flex-column align-items-center justify-content-center text-center h-100 p-5">
                    <a href="{{ route('front.index') }}" class="navbar-brand">
                        <img src="{{ asset('asset/images/logo1.png') }}" alt="EliteHR Logo" style="height: 60px; margin-bottom: 20px;">
                    </a>
                    <p class="mt-3 mb-4 text-white-50">EliteHR is your ultimate partner in Human Resource Management. We provide cutting-edge tools for recruitment, payroll, and employee engagement to help your business thrive.</p>
                    <form action="" class="footer-newsletter-premium w-100">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" placeholder="Your Email">
                            <button class="btn btn-dark">Join</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-md-6">
                <div class="row gx-5">
                    <div class="col-lg-4 col-md-12 pt-5 mb-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="text-light mb-0">Get In Touch</h3>
                        </div>
                        <div class="d-flex mb-3 align-items-center">
                            <i class="bi bi-geo-alt text-primary me-3 fs-5"></i>
                            <p class="mb-0">"The Park" Aaksharchok, India</p>
                        </div>
                        <div class="d-flex mb-3 align-items-center">
                            <i class="bi bi-envelope-open text-primary me-3 fs-5"></i>
                            <p class="mb-0">contact@elitehr.com</p>
                        </div>
                        <div class="d-flex mb-3 align-items-center">
                            <i class="bi bi-telephone text-primary me-3 fs-5"></i>
                            <p class="mb-0">+91 8844996655</p>
                        </div>
                        <div class="d-flex mt-4">
                            <a class="btn btn-primary btn-square me-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square me-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square me-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5 footer-link-premium">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="text-light mb-0">Quick Links</h3>
                        </div>
                        <div class="link-animated d-flex flex-column justify-content-start">
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.index') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.about') }}"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.service') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.team') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Meet The Team</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.blog') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                            <a class="text-light text-decoration-none" href="{{ route('front.contact') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-5 footer-link-premium">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="text-light mb-0">Popular Modules</h3>
                        </div>
                        <div class="link-animated d-flex flex-column justify-content-start">
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.product', 'payroll-software') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Payroll Automation</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.product', 'recruitment-software') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Recruitment Pipeline</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.product', 'attendance-management') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Attendance Tracking</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.product', 'leave-management') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Leave Management</a>
                            <a class="text-light mb-2 text-decoration-none" href="{{ route('front.product', 'performance-management') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Performance Appraisal</a>
                            <a class="text-light text-decoration-none" href="{{ route('front.product', 'employee-self-service') }}"><i class="bi bi-arrow-right text-primary me-2"></i>Employee Self-Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-white" style="background: #061429;">
    <div class="container text-center">
        <div class="row justify-content-end">
            <div class="col-lg-8 col-md-6">
                <div class="d-flex align-items-center justify-content-center" style="height: 75px;">
                    <p class="mb-0">&copy; <a class="text-white border-bottom text-decoration-none" href="{{ route('front.index') }}">EliteHR</a>. All Rights Reserved. 
                    <span class="text-white-50 ms-2">Empowering Workforces Everywhere.</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
