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
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Blog</a>
                <div class="dropdown-menu m-0">
                    <a href="{{ route('front.blog') }}" class="dropdown-item">Blog Grid</a>
                    <a href="{{ route('front.detail') }}" class="dropdown-item">Blog Detail</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0">
                    <a href="{{ route('front.price') }}" class="dropdown-item">Pricing Plan</a>
                    <a href="{{ route('front.feature') }}" class="dropdown-item">Our features</a>
                    <a href="{{ route('front.team') }}" class="dropdown-item">Team Members</a>
                    <a href="{{ route('front.testimonial') }}" class="dropdown-item">Testimonial</a>
                    <a href="{{ route('front.quote') }}" class="dropdown-item">Free Quote</a>
                </div>
            </div>
            <a href="{{ route('front.contact') }}" class="nav-item nav-link {{ request()->routeIs('front.contact') ? 'active' : '' }}">Contact</a>
        </div>
        <button type="button" class="btn text-primary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
        <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4 ms-3">Login</a>
    </div>
</nav>
