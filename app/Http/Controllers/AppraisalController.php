<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\Performance;
use App\Models\User;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppraisalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $appraisals = Appraisal::with('user')->orderBy('effective_date', 'desc')->get();
            $employees = auth()->user()->hasRole('super_admin') 
                ? User::with('salary')->get() 
                : User::with('salary')->whereDoesntHave('roles', function($q) { $q->where('name', 'super_admin'); })->get();
        } else {
            $appraisals = Appraisal::where('user_id', $user->id)->orderBy('effective_date', 'desc')->get();
            $employees = collect([$user->load('salary')]);
        }

        return view('performance.appraisals', [
            'appraisals' => $appraisals,
            'employees' => $employees,
            'title' => 'Salary Appraisals',
            'catName' => 'performance',
            'breadcrumbs' => ['Performance', 'Appraisals'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'increment_percentage' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
        ]);

        $user = User::with('salary')->find($request->user_id);
        if (!$user->salary) {
            return back()->with('error', 'User does not have a salary record defined.');
        }

        $lastPerformance = Performance::where('user_id', $user->id)->orderBy('review_date', 'desc')->first();
        
        $prevSalary = $user->salary->basic;
        $increment = ($prevSalary * $request->increment_percentage) / 100;
        $newSalary = $prevSalary + $increment;

        Appraisal::create([
            'user_id' => $user->id,
            'performance_id' => $lastPerformance ? $lastPerformance->id : null,
            'rating' => $lastPerformance ? $lastPerformance->rating : 0,
            'increment_percentage' => $request->increment_percentage,
            'previous_salary' => $prevSalary,
            'new_salary' => $newSalary,
            'effective_date' => $request->effective_date,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Appraisal request submitted.');
    }

    public function approve(Appraisal $appraisal)
    {
        if (!Auth::user()->hasRole('Admin')) {
            return back()->with('error', 'Only Admins can approve appraisals.');
        }

        $salary = Salary::where('user_id', $appraisal->user_id)->first();
        if ($salary) {
            $salary->update([
                'basic' => $appraisal->new_salary,
            ]);
        }

        $appraisal->update(['status' => 'approved']);

        return back()->with('success', 'Appraisal approved and salary updated.');
    }
}
