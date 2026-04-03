@extends('frontend.layouts.page')

@section('meta_title', 'Request a Quote | EliteHR')
@section('meta_description', 'Request a personalized quote for EliteHR. Share your requirements and let us tailor an HRMS solution for your organization.')
@section('meta_keywords', 'EliteHR Quote, HRMS Estimate, Custom HR Pricing')

@section('page_title', 'Free Quote')

@section('page_content')
    <!-- Quote Start -->
    @include('frontend.partials.quote')
    <!-- Quote End -->


@endsection
