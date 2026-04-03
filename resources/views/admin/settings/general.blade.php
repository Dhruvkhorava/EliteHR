@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <div class="secondary-nav">
            <div class="breadcrumbs-container">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </a>
                    <div class="d-flex breadcrumb-content">
                        <div class="page-header">
                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">General Settings</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </header>
            </div>
        </div>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="widget-content widget-content-area br-8">
                    <div class="p-4">
                        <h4 class="mb-4">General Settings</h4>
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Site Details -->
                                <div class="col-md-6 mb-4">
                                    <label for="site_name" class="form-label">Site Name</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $settings['site_name'] ?? '' }}" placeholder="Enter Site Name">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="site_email" class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" id="site_email" name="site_email" value="{{ $settings['site_email'] ?? '' }}" placeholder="Enter Contact Email">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="site_phone" class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control" id="site_phone" name="site_phone" value="{{ $settings['site_phone'] ?? '' }}" placeholder="Enter Contact Phone">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="copyright_text" class="form-label">Copyright Text</label>
                                    <input type="text" class="form-control" id="copyright_text" name="copyright_text" value="{{ $settings['copyright_text'] ?? '' }}" placeholder="Enter Copyright Text">
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="site_address" class="form-label">Address</label>
                                    <textarea class="form-control" id="site_address" name="site_address" rows="3" placeholder="Enter Address">{{ $settings['site_address'] ?? '' }}</textarea>
                                </div>

                                <hr class="my-4">

                                <!-- Logos -->
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Site Logo</label>
                                    <div class="mb-3">
                                        @if(isset($settings['site_logo']))
                                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="img-thumbnail mb-2" style="max-height: 100px;">
                                        @else
                                            <div class="p-3 border rounded text-center bg-light mb-2">No Logo Uploaded</div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="site_logo" name="site_logo" accept="image/*">
                                    <small class="text-muted">Recommended size: 200x50 px</small>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Site Favicon</label>
                                    <div class="mb-3">
                                        @if(isset($settings['site_favicon']))
                                            <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" class="img-thumbnail mb-2" style="max-height: 50px;">
                                        @else
                                            <div class="p-3 border rounded text-center bg-light mb-2">No Favicon Uploaded</div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="site_favicon" name="site_favicon" accept="image/*">
                                    <small class="text-muted">Recommended size: 32x32 px</small>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/admin_settings_general.css') }}">
@endpush
