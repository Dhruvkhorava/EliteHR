<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $categories = Document::getCategories();
        $icons = Document::getCategoryIcons();
        $counts = [];

        foreach ($categories as $key => $name) {
            $counts[$key] = Auth::user()->documents()->where('category', $key)->count();
        }

        return view('documents.index', [
            'catName' => 'documents',
            'title' => 'Documents',
            'breadcrumbs' => ['Dashboard', 'Documents'],
            'categories' => $categories,
            'icons' => $icons,
            'counts' => $counts,
        ]);
    }

    public function category($category)
    {
        $categories = Document::getCategories();
        if (!isset($categories[$category])) {
            abort(404);
        }

        $documents = Auth::user()->documents()->where('category', $category)->latest()->get();

        return view('documents.category', [
            'catName' => 'documents',
            'title' => $categories[$category],
            'breadcrumbs' => ['Dashboard', 'Documents', $categories[$category]],
            'category' => $category,
            'categoryName' => $categories[$category],
            'documents' => $documents,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // 10MB max
        ]);

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/' . Auth::id() . '/' . $request->category, $filename, 'public');

        Document::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'title' => $request->title,
            'file_path' => $path,
            'status' => 'uploaded',
        ]);

        return back()->with('success', 'Document uploaded successfully!');
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);

        // Check if user has permission to download this document
        if ($document->user_id !== Auth::id() && !Auth::user()->hasAnyRole(['admin', 'super_admin', 'hr'])) {
            abort(403);
        }

        return Storage::disk('public')->download($document->file_path, $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION));
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Check if user has permission to delete this document
        if ($document->user_id !== Auth::id() && !Auth::user()->hasAnyRole(['admin', 'super_admin'])) {
            abort(403);
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted successfully!');
    }
}
