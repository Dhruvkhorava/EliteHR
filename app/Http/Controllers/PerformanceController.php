<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\User;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $performances = Performance::with(['user', 'reviewer'])->orderBy('review_date', 'desc')->get();
            $employees = User::role(['hr', 'employee'])->get();
        } elseif ($user->hasRole('hr')) {
            // HR sees reviews they made for Admin, and reviews of themselves
            $performances = Performance::where('user_id', $user->id)
                ->orWhere('reviewer_id', $user->id)
                ->with(['user', 'reviewer'])
                ->orderBy('review_date', 'desc')
                ->get();
            $employees = User::role('admin')->get();
        } else {
            // Employee only sees reviews of themselves
            $performances = Performance::where('user_id', $user->id)
                ->with('reviewer')
                ->orderBy('review_date', 'desc')
                ->get();
            $employees = collect();
        }

        // Dashboard stats
        $avgRating = $user->performances()->avg('rating') ?? 0;
        $goalProgress = $user->goals()->count() > 0 ? ($user->goals()->where('status', 'completed')->count() / $user->goals()->count()) * 100 : 0;

        return view('performance.index', [
            'performances' => $performances,
            'employees' => $employees,
            'avgRating' => round($avgRating, 1),
            'goalProgress' => round($goalProgress, 0),
            'title' => 'Performance Reviews',
            'catName' => 'performance',
            'breadcrumbs' => ['Performance', 'Reviews'],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string',
            'review_date' => 'required|date',
            'type' => 'required|in:monthly,quarterly,yearly',
        ]);

        $reviewer = Auth::user();
        $reviewee = User::find($request->user_id);

        // Enforce rules:
        // Admin -> HR/Employee
        // HR -> Admin
        if ($reviewer->hasRole('admin')) {
            if (!$reviewee->hasAnyRole(['hr', 'employee'])) {
                return back()->with('error', 'Admins can only review HR or Employees.');
            }
        } elseif ($reviewer->hasRole('hr')) {
            if (!$reviewee->hasRole('admin')) {
                return back()->with('error', 'HR can only review Admins.');
            }
        } else {
            return back()->with('error', 'Employees cannot add reviews.');
        }

        Performance::create([
            'user_id' => $request->user_id,
            'reviewer_id' => Auth::id(),
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'review_date' => $request->review_date,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Performance review added successfully.');
    }
}
