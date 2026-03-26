<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::with(['application.candidate', 'application.job', 'interviewer'])->latest()->get();
        return view('recruitment.interviews.index', [
            'interviews' => $interviews,
            'applications' => Application::with(['candidate', 'job'])->whereNotIn('status', ['Rejected', 'Hired'])->get(),
            'interviewers' => User::role(['admin', 'hr'])->get(),
            'catName' => 'recruitment',
            'title' => 'Interviews',
            'breadcrumbs' => ['Recruitment', 'Interviews']
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'interviewer_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        $interview = Interview::create($validated);

        // Update application status to Interview Scheduled
        $interview->application->update(['status' => 'Interview Scheduled']);

        return redirect()->back()->with('success', 'Interview scheduled successfully.');
    }

    public function update(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'feedback' => 'nullable|string',
        ]);

        $interview->update($validated);

        return redirect()->back()->with('success', 'Interview updated successfully.');
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();
        return redirect()->back()->with('success', 'Interview deleted.');
    }
}
