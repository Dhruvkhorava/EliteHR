<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;


class FrontendController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('author')->where('is_published', true)->latest()->take(3)->get();
        return view('frontend.index', [
            'title' => 'Home',
            'blogs' => $blogs
        ]);
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
        $blogs = Blog::with('author')->where('is_published', true)->latest()->paginate(6);
        return view('frontend.blog', [
            'title' => 'Latest Blog',
            'blogs' => $blogs
        ]);
    }

    public function detail($slug)
    {
        $blog = Blog::with('author')->where('slug', $slug)->firstOrFail();
        return view('frontend.detail', [
            'title' => $blog->title,
            'blog' => $blog
        ]);
    }

    public function product($slug = 'hr-software')
    {
        $viewPath = 'frontend.product.' . $slug;
        
        if (view()->exists($viewPath)) {
            return view($viewPath, ['title' => ucwords(str_replace('-', ' ', $slug))]);
        }
        
        // Fallback if view doesn't exist
        abort(404);
    }
}
