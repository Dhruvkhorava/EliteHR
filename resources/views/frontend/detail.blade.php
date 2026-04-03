@extends('frontend.layouts.page')

@section('meta_title', 'Blog Details | EliteHR Insights')
@section('meta_description', 'Dive deeper into HR topics, best practices, and the latest trends with EliteHR detailed blog articles.')
@section('meta_keywords', 'EliteHR Articles, HR Best Practices, Blog Details')

@section('page_title', 'Blog Detail')

@section('page_content')
    <!-- Blog Detail Start -->
    @include('frontend.partials.blog')
    <!-- Blog Detail End -->
@endsection
