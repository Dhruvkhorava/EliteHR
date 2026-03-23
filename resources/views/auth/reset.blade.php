@extends('layouts.app')

@section('styles')
{{-- Style Here --}}
@vite(['resources/scss/light/assets/authentication/auth-cover.scss'])
@vite(['resources/scss/dark/assets/authentication/auth-cover.scss'])
@endsection

@section('content')
{{-- Content Here --}}
<div class="auth-container d-flex h-100">

    <div class="container mx-auto align-self-center">

        <div class="row">

            <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                <div class="auth-cover-bg-image"></div>
                <div class="auth-overlay"></div>
                    
                <div class="auth-cover">

                    <div class="position-relative">

                            <img src="{{ asset('asset/images/18959.png') }}" alt="auth-img">

                            <h2 class="mt-5 text-white font-weight-bolder px-2">
                                Build a smarter workplace
                            </h2>
                            <p class="text-white px-2">
                                Automate HR tasks, track performance, and grow your team faster with ease.
                            </p>
                        </div>
                    
                </div>

            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column ms-lg-auto  align-self-center me-lg-0 mx-auto">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                
                                <h2>Password Reset</h2>
                                <p>Enter your email to recover your ID</p>
                                
                            </div>
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-4">
                                    <button class="btn btn-secondary w-100">RECOVER</button>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>

</div>
@endsection

@section('scripts')
{{-- Scripts Here --}}
    {{-- <script src="{{asset('plugins/src/stepper/bsStepper.min.js')}}"></script> --}}
    {{-- @vite(['resources/js/apps/chat.js']) --}}
@endsection