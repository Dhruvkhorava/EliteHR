<nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
    <a href="{{ route('front.index') }}" class="navbar-brand p-0">
        <img src="{{ asset('asset/images/logo1.png') }}" class="logo-light navbar-logo-g" alt="logo"style="height: 66px;width: 217px;">
        <img src="{{ asset('asset/images/dark_logo.png') }}" class="logo-dark navbar-logo-g" alt="logo"style="height: 66px;width: 217px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="{{ route('front.index') }}" class="nav-item nav-link {{ request()->routeIs('front.index') ? 'active' : '' }}">Home</a>
            <a href="{{ route('front.about') }}" class="nav-item nav-link {{ request()->routeIs('front.about') ? 'active' : '' }}">About</a>
            <a href="{{ route('front.service') }}" class="nav-item nav-link {{ request()->routeIs('front.service') ? 'active' : '' }}">Services</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('front.product') ? 'active' : '' }}" data-bs-toggle="dropdown">Products</a>
                <div class="dropdown-menu m-0 border-0 shadow-sm">
                    <h6 class="dropdown-header text-primary fw-bold text-uppercase">Software</h6>
                    <a href="{{ route('front.product', 'hr-software') }}" class="dropdown-item"><i class="fa fa-users text-primary me-2"></i>HR Software</a>
                    <a href="{{ route('front.product', 'payroll-software') }}" class="dropdown-item"><i class="fa fa-money-check-alt text-primary me-2"></i>Payroll Software</a>
                    <a href="{{ route('front.product', 'leave-management') }}" class="dropdown-item"><i class="fa fa-calendar-minus text-primary me-2"></i>Leave Management</a>
                    <a href="{{ route('front.product', 'attendance-management') }}" class="dropdown-item"><i class="fa fa-clock text-primary me-2"></i>Attendance Management</a>
                    <a href="{{ route('front.product', 'performance-management') }}" class="dropdown-item"><i class="fa fa-chart-line text-primary me-2"></i>Performance Management</a>
                    <a href="{{ route('front.product', 'employee-self-service') }}" class="dropdown-item"><i class="fa fa-user-cog text-primary me-2"></i>Employee Self Service</a>
                    <a href="{{ route('front.product', 'recruitment-software') }}" class="dropdown-item"><i class="fa fa-user-plus text-primary me-2"></i>Recruitment Software</a>
                    <a href="{{ route('front.product', 'expense-management') }}" class="dropdown-item"><i class="fa fa-file-invoice-dollar text-primary me-2"></i>Expense Management</a>
                    
                    <div class="dropdown-divider my-2"></div>
                    
                    <h6 class="dropdown-header text-primary fw-bold text-uppercase mt-2">For Industry</h6>
                    <a href="{{ route('front.product', 'industry-manufacturing') }}" class="dropdown-item"><i class="fa fa-industry text-primary me-2"></i>Manufacturing</a>
                    <a href="{{ route('front.product', 'industry-saas-it') }}" class="dropdown-item"><i class="fa fa-laptop-code text-primary me-2"></i>SaaS/IT</a>
                    <a href="{{ route('front.product', 'industry-healthcare') }}" class="dropdown-item"><i class="fa fa-heartbeat text-primary me-2"></i>Healthcare</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Blog</a>
                <div class="dropdown-menu m-0 border-0 shadow-sm">
                    <a href="{{ route('front.blog') }}" class="dropdown-item"><i class="fa fa-th-large text-primary me-2"></i>Blog Grid</a>
                    <a href="{{ route('front.detail') }}" class="dropdown-item"><i class="fa fa-file-alt text-primary me-2"></i>Blog Detail</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0 border-0 shadow-sm">
                    <a href="{{ route('front.price') }}" class="dropdown-item"><i class="fa fa-tags text-primary me-2"></i>Pricing Plan</a>
                    <a href="{{ route('front.feature') }}" class="dropdown-item"><i class="fa fa-star text-primary me-2"></i>Our features</a>
                    <a href="{{ route('front.team') }}" class="dropdown-item"><i class="fa fa-users text-primary me-2"></i>Team Members</a>
                    <a href="{{ route('front.testimonial') }}" class="dropdown-item"><i class="fa fa-quote-left text-primary me-2"></i>Testimonial</a>
                    <a href="{{ route('front.quote') }}" class="dropdown-item"><i class="fa fa-file-signature text-primary me-2"></i>Free Quote</a>
                </div>
            </div>
            <a href="{{ route('front.contact') }}" class="nav-item nav-link {{ request()->routeIs('front.contact') ? 'active' : '' }}">Contact</a>
        </div>
        <button type="button" class="btn text-primary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
        <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4 ms-3">Login</a>
    </div>
</nav>
