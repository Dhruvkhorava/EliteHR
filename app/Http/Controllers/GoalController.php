<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $goals = Goal::with('user')->orderBy('deadline', 'asc')->get();
            $employees = auth()->user()->hasRole('super_admin') 
                ? User::all() 
                : User::whereDoesntHave('roles', function($q) { $q->where('name', 'super_admin'); })->get();
        } else {
            $goals = Goal::where('user_id', $user->id)->orderBy('deadline', 'asc')->get();
            $employees = collect([$user]);
        }

        return view('performance.goals', [
            'goals' => $goals,
            'employees' => $employees,
            'title' => 'Goals & KPIs',
            'catName' => 'performance',
            'breadcrumbs' => ['Performance', 'Goals'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        Goal::create($request->all());

        return back()->with('success', 'Goal created successfully.');
    }

    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $goal->update($request->only('status'));

        return back()->with('success', 'Goal status updated.');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return back()->with('success', 'Goal deleted successfully.');
    }
}
