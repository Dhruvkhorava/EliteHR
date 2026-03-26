<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index', ['title' => 'Home']);
    }

    public function about()
    {
        return view('frontend.about', ['title' => 'About Us']);
    }

    public function service()
    {
        return view('frontend.service', ['title' => 'Our Services']);
    }

    public function contact()
    {
        return view('frontend.contact', ['title' => 'Contact Us']);
    }

    public function price()
    {
        return view('frontend.price', ['title' => 'Pricing Plans']);
    }

    public function feature()
    {
        return view('frontend.feature', ['title' => 'Our Features']);
    }

    public function team()
    {
        return view('frontend.team', ['title' => 'Team Members']);
    }

    public function testimonial()
    {
        return view('frontend.testimonial', ['title' => 'Testimonials']);
    }

    public function quote()
    {
        return view('frontend.quote', ['title' => 'Free Quote']);
    }

    public function blog()
    {
        return view('frontend.blog', ['title' => 'Latest Blog']);
    }

    public function detail()
    {
        return view('frontend.detail', ['title' => 'Blog Detail']);
    }
}
