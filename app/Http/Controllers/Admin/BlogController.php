<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('author')->latest()->get();
        return view('admin.blogs.index', compact('blogs'), [
            'title' => 'Blog Management',
            'catName' => 'settings',
            'breadcrumbs' => ['Dashboard', 'Blog Management'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function create()
    {
        return view('admin.blogs.create', [
            'title' => 'Add New Blog',
            'catName' => 'settings',
            'breadcrumbs' => ['Dashboard', 'Blog Management', 'Add New'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['author_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');
        
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($data);

        return redirect()->route('blogs.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'), [
            'title' => 'Edit Blog',
            'catName' => 'settings',
            'breadcrumbs' => ['Dashboard', 'Blog Management', 'Edit'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_published'] = $request->has('is_published');

        if ($data['is_published'] && !$blog->is_published) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('blogs.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog post deleted successfully.');
    }
}
