@extends('frontend.layouts.page')

@section('page_title', 'EliteHR Services')

@section('page_content')
    <!-- Service Start -->
    @include('frontend.partials.services')
    <!-- Service End -->

    <!-- Testimonial Start -->
    @include('frontend.partials.testimonial')
    <!-- Testimonial End -->
@endsection
