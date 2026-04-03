@extends('frontend.layouts.page')

@section('meta_title', 'Testimonials | EliteHR Success Stories')
@section('meta_description', 'Read what our clients have to say about EliteHR. Discover how our HRMS has transformed businesses worldwide.')
@section('meta_keywords', 'EliteHR Testimonials, Client Reviews, Success Stories')

@section('page_title', 'Client Testimonials')

@section('page_content')
    <!-- Testimonial Start -->
    @include('frontend.partials.testimonial')
    <!-- Testimonial End -->
@endsection
