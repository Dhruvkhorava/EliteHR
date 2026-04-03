@extends('frontend.layouts.page')

@section('meta_title', 'Services | EliteHR Solutions')
@section('meta_description', 'Explore the diverse HR services provided by EliteHR, designed to completely automate and streamline your human resource operations.')
@section('meta_keywords', 'EliteHR Services, HR Solutions, Automation Services')

@section('page_title', 'EliteHR Services')

@section('page_content')
    <!-- Service Start -->
    @include('frontend.partials.services')
    <!-- Service End -->

    <!-- Testimonial Start -->
    @include('frontend.partials.testimonial')
    <!-- Testimonial End -->
@endsection
