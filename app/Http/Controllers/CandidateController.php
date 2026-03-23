<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with('applications.job')->latest()->get();
        return view('recruitment.candidates.index', [
            'candidates' => $candidates,
            'catName' => 'recruitment',
            'title' => 'Candidates',
            'breadcrumbs' => ['Recruitment', 'Candidates']
        ]);
    }

    public function create()
    {
        return view('recruitment.candidates.create', [
            'catName' => 'recruitment',
            'title' => 'Add Candidate',
            'breadcrumbs' => ['Recruitment', 'Candidates', 'Add']
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'phone' => 'nullable|string|max:20',
            'experience' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        Candidate::create($validated);

        return redirect()->route('recruitment.candidates.index')->with('success', 'Candidate added successfully.');
    }

    public function show(Candidate $candidate)
    {
        return view('recruitment.candidates.show', [
            'candidate' => $candidate,
            'catName' => 'recruitment',
            'title' => $candidate->name,
            'breadcrumbs' => ['Recruitment', 'Candidates', 'Profile']
        ]);
    }

    public function edit(Candidate $candidate)
    {
        return view('recruitment.candidates.edit', [
            'candidate' => $candidate,
            'catName' => 'recruitment',
            'title' => 'Edit Candidate',
            'breadcrumbs' => ['Recruitment', 'Candidates', 'Edit']
        ]);
    }

    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $candidate->id,
            'phone' => 'nullable|string|max:20',
            'experience' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('resume')) {
            // Delete old resume
            if ($candidate->resume) {
                Storage::disk('public')->delete($candidate->resume);
            }
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $candidate->update($validated);

        return redirect()->route('recruitment.candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate)
    {
        if ($candidate->resume) {
            Storage::disk('public')->delete($candidate->resume);
        }
        $candidate->delete();
        return redirect()->route('recruitment.candidates.index')->with('success', 'Candidate deleted successfully.');
    }
}
