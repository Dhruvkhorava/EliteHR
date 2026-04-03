@extends('frontend.layouts.page')

@section('meta_title', 'Blog | EliteHR Insights')
@section('meta_description', 'Read the latest insights, HR news, and updates from EliteHR to stay ahead in managing your workforce.')
@section('meta_keywords', 'EliteHR Blog, HR News, Workforce Insights')

@section('page_title', 'EliteHR Insights')

@section('page_content')
    <!-- Blog Start -->
    @include('frontend.partials.blog')
    <!-- Blog End -->
@endsection
