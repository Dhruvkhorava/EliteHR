<?php

namespace App\Http\Controllers;

use App\Models\RecruitmentJob;
use Illuminate\Http\Request;

class RecruitmentJobController extends Controller
{
    public function index()
    {
        $jobs = RecruitmentJob::withCount('applications')->latest()->get();
        return view('recruitment.jobs.index', [
            'jobs' => $jobs,
            'catName' => 'recruitment',
            'title' => 'Job Openings',
            'breadcrumbs' => ['Recruitment', 'Job Openings']
        ]);
    }

    public function create()
    {
        return view('recruitment.jobs.create', [
            'catName' => 'recruitment',
            'title' => 'Create Job Opening',
            'breadcrumbs' => ['Recruitment', 'Jobs', 'Create']
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
            'required_skills' => 'nullable|string',
        ]);

        RecruitmentJob::create($validated);

        return redirect()->route('recruitment.jobs.index')->with('success', 'Job opening created successfully.');
    }

    public function show(RecruitmentJob $job)
    {
        return view('recruitment.jobs.show', [
            'job' => $job,
            'catName' => 'recruitment',
            'title' => $job->title,
            'breadcrumbs' => ['Recruitment', 'Jobs', 'Detail']
        ]);
    }

    public function edit(RecruitmentJob $job)
    {
        return view('recruitment.jobs.edit', [
            'job' => $job,
            'catName' => 'recruitment',
            'title' => 'Edit Job Opening',
            'breadcrumbs' => ['Recruitment', 'Jobs', 'Edit']
        ]);
    }

    public function update(Request $request, RecruitmentJob $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
            'required_skills' => 'nullable|string',
            'status' => 'required|in:open,closed',
        ]);

        $job->update($validated);

        return redirect()->route('recruitment.jobs.index')->with('success', 'Job opening updated successfully.');
    }

    public function destroy(RecruitmentJob $job)
    {
        $job->delete();
        return redirect()->route('recruitment.jobs.index')->with('success', 'Job opening deleted successfully.');
    }
}
