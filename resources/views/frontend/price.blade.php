@extends('frontend.layouts.page')

@section('page_title', 'Pricing Plan')

@section('page_content')
    <!-- Pricing Start -->
    @include('frontend.partials.pricing')
    <!-- Pricing End -->

    <!-- Quote Start -->
    @include('frontend.partials.quote')
    <!-- Quote End -->
@endsection
