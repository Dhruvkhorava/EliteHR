@extends('frontend.layouts.page')

@section('meta_title', 'Our Team | EliteHR Experts')
@section('meta_description', 'Meet the passionate team behind EliteHR. We are dedicated to providing the best HR software experience.')
@section('meta_keywords', 'EliteHR Team, HR Experts, About Us')

@section('page_title', 'Team Members')

@section('page_content')
    <!-- Team Start -->
    @include('frontend.partials.team')
    <!-- Team End -->
@endsection
