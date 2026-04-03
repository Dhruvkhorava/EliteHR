<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @isset($title)
            @if ($title !== '')
                {{ $title }} | {{ get_setting('site_name', 'EliteHR') }}
            @else
                {{ get_setting('site_name', 'EliteHR') }} | Intelligent HR Management System
            @endif
        @else
            {{ get_setting('site_name', 'EliteHR') }} | Intelligent HR Management System
        @endisset
    </title>
    <link rel="icon" type="image/x-icon"
        href="{{ get_setting('site_favicon') ? asset('storage/' . get_setting('site_favicon')) : asset('asset/images/logo2.png') }}" />
    @vite(['resources/scss/layouts/vertical-light-menu/light/loader.scss'])
    @vite(['resources/scss/layouts/vertical-light-menu/dark/loader.scss'])
    @vite(['resources/layouts/vertical-light-menu/loader.js'])

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/src/bootstrap/css/bootstrap.min.css') }}">
    @vite(['resources/scss/light/assets/main.scss'])
    @vite(['resources/scss/dark/assets/main.scss'])
    @vite(['resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss'])
    @vite(['resources/scss/dark/plugins/perfect-scrollbar/perfect-scrollbar.scss'])
    <link rel="stylesheet" href="{{ asset('plugins/src/waves/waves.min.css') }}">
    @vite(['resources/scss/layouts/vertical-light-menu/light/structure.scss'])
    @vite(['resources/scss/layouts/vertical-light-menu/dark/structure.scss'])
    <link rel="stylesheet" href="{{ asset('plugins/src/highlight/styles/monokai-sublime.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/src/sweetalerts2/sweetalerts2.css') }}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    @isset($scrollspy)
        @if ($scrollspy)
            @vite(['resources/scss/light/assets/scrollspyNav.scss'])
            @vite(['resources/scss/dark/assets/scrollspyNav.scss'])
        @endif
    @endisset
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @yield('styles')
    @stack('styles')
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>

<body
    class="
    {{ Request::routeIs('error404') ? 'error text-center' : '' }}
    {{ Request::routeIs('maintenance') ? 'maintanence text-center' : '' }}
    {{ Request::routeIs('boxedSignIn') ||
    Request::routeIs('boxedSignUp') ||
    Request::routeIs('boxedLockscreen') ||
    Request::routeIs('boxedPasswordReset') ||
    Request::routeIs('boxed2sv')
        ? 'form'
        : '' }}

    {{ Request::routeIs('coverSignIn') ||
    Request::routeIs('coverSignUp') ||
    Request::routeIs('coverLockscreen') ||
    Request::routeIs('coverPasswordReset') ||
    Request::routeIs('cover2sv')
        ? 'form'
        : '' }}
    {{ Request::routeIs('collapsed') ? 'alt-menu' : '' }}
    
    
"
    layout="{{ Request::routeIs('boxed') ? 'boxed' : '' }}">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    @if (isset($simplePage) && $simplePage)
        @yield('content')
    @else
        @if (!Request::routeIs('blank'))
            <!--  BEGIN NAVBAR  -->
            @include('layouts.navbar')
            <!--  END NAVBAR  -->
        @endif

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container" id="container">

            <div class="overlay"></div>
            <div class="search-overlay"></div>

            @if (!Request::routeIs('blank'))
                <!--  BEGIN SIDEBAR  -->
                @include('layouts.sidebar')
                <!--  END SIDEBAR  -->
            @endif

            <!--  BEGIN CONTENT AREA  -->
            <div id="content" class="main-content {{ Request::routeIs('blank') ? 'ms-0 mt-0' : '' }}">

                @if (isset($scrollspy) && $scrollspy)
                    <div class="container">
                        <div class="container">
                            <div class="middle-content container-xxl p-0">

                                <!--  BEGIN BREADCRUMBS  -->
                                @include('layouts.secondaryNav')
                                <!--  END BREADCRUMBS  -->

                                <!--  BEGIN CONTENT  -->
                                @yield('content')
                                <!--  END CONTENT  -->

                            </div>
                        </div>
                    </div>
                @else
                    <div class="layout-px-spacing">
                        <div class="middle-content {{ Request::routeIs('boxed') ? 'container-xxl' : '' }} p-0">
                            @if (!Request::routeIs('blank'))
                                <!--  BEGIN BREADCRUMBS  -->
                                @include('layouts.secondaryNav')
                                <!--  END BREADCRUMBS  -->
                            @endif

                            <!--  BEGIN CONTENT  -->
                            @yield('content')
                            <!--  END CONTENT  -->
                        </div>

                    </div>
                @endif

                @if (!Request::routeIs('blank'))
                    <!--  BEGIN FOOTER  -->
                    @include('layouts.footer')
                    <!--  END FOOTER  -->
                @endif
            </div>
            <!--  END CONTENT AREA  -->

        </div>
        <!-- END MAIN CONTAINER -->

        @include('layouts.search-overlay')

    @endif

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('plugins/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('plugins/src/highlight/highlight.pack.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @vite(['resources/layouts/vertical-light-menu/app.js'])

    @isset($scrollspy)
        @if ($scrollspy)
            @vite(['resources/js/scrollspyNav.js'])
        @endif
    @endisset

    <script src="{{ asset('plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @yield('scripts')
    @stack('scripts')

    <script>
        window.appData = {
            csrfToken: "{{ csrf_token() }}",
            success: "{{ session('success') }}",
            error: "{{ session('error') }}",
            warning: "{{ session('warning') }}",
            info: "{{ session('info') }}",
            errors: {!! json_encode($errors->all()) !!}
        };
    </script>
    <script src="{{ asset('asset/js/app_global.js') }}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>
