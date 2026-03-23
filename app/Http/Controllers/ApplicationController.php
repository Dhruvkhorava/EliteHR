<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\RecruitmentJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['candidate', 'job'])->get();
        
        $stages = [
            'Applied',
            'Screening',
            'Interview Scheduled',
            'Selected',
            'Rejected',
            'Hired'
        ];

        $board = [];
        foreach ($stages as $stage) {
            $board[$stage] = $applications->where('status', $stage);
        }

        return view('recruitment.applications.index', [
            'board' => $board,
            'stages' => $stages,
            'jobs' => RecruitmentJob::where('status', 'open')->get(),
            'candidates' => Candidate::all(),
            'catName' => 'recruitment',
            'title' => 'Application Pipeline',
            'breadcrumbs' => ['Recruitment', 'Pipeline']
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:recruitment_jobs,id',
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $validated['status'] = 'Applied';
        $validated['applied_at'] = now();

        Application::create($validated);

        return redirect()->back()->with('success', 'Candidate applied to job successfully.');
    }

    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:Applied,Screening,Interview Scheduled,Selected,Rejected,Hired',
        ]);

        $application->update(['status' => $validated['status']]);

        return response()->json(['success' => true]);
    }

    public function convertToEmployee(Application $application)
    {
        if ($application->status !== 'Selected') {
            return redirect()->back()->with('error', 'Only selected candidates can be converted to employees.');
        }

        DB::beginTransaction();
        try {
            $candidate = $application->candidate;

            // Check if user already exists
            if (User::where('email', $candidate->email)->exists()) {
                throw new \Exception('A user with this email already exists.');
            }

            // Create User account
            $user = User::create([
                'name' => $candidate->name,
                'email' => $candidate->email,
                'password' => Hash::make('password123'), // Default password
                'status' => 1, // Active
            ]);

            // Assign Employee role
            $user->assignRole('Employee');

            // Update application status to Hired
            $application->update(['status' => 'Hired']);

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Candidate converted to employee successfully. Default password: password123');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to convert to employee: ' . $e->getMessage());
        }
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->back()->with('success', 'Application removed.');
    }
}
