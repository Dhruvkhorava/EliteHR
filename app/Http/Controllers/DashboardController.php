<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidate;
use App\Models\RecruitmentJob;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Payroll;
use App\Models\Goal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function analytics()
    {
        $totalEmployees = User::count();
        $totalCandidates = Candidate::count();

        // Job status stored as 'open' (lowercase)
        $openJobs = RecruitmentJob::where('status', 'open')->count();

        $today        = Carbon::today();
        $attendanceToday = Attendance::whereDate('date', $today)->count();
        $pendingLeaves   = Leave::where('status', 'pending')->count();

        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;
        $totalPayrollThisMonth = Payroll::where('month', $currentMonth)
                                        ->where('year', $currentYear)
                                        ->sum('net_salary');

        // Mini stat cards
        $activeGoals = Goal::where('status', 'active')->orWhere('status', 'in_progress')->count();

        // Attendance trend last 7 days
        $last7Days = collect();
        $last7DaysLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $last7DaysLabels[] = $day->format('D');
            $last7Days->push(Attendance::whereDate('date', $day)->count());
        }

        // Leave trend last 7 days
        $leaveTrend = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $leaveTrend->push(Leave::whereDate('created_at', $day)->count());
        }

        // Leave breakdown by type (for "Leave Breakdown" widget, replaces Browser Stats)
        $leaveTypes = LeaveType::withCount(['leaves' => function($q) {
            $q->whereYear('created_at', Carbon::now()->year);
        }])->orderByDesc('leaves_count')->take(4)->get();

        $totalLeaveRequests = max($leaveTypes->sum('leaves_count'), 1); // avoid div/0

        // Most recent user (newly joined)
        $latestUser = User::orderBy('created_at', 'desc')->first();

        // Latest payslip
        $latestPayroll = Payroll::with('user')
                            ->orderBy('year', 'desc')
                            ->orderBy('month', 'desc')
                            ->first();

        // Recent activity:
        $recentLeaves     = Leave::with('user')->orderBy('created_at', 'desc')->take(3)->get();
        $recentCandidates = Candidate::orderBy('created_at', 'desc')->take(2)->get();

        return view('admin.dashboard.analytics', [
            'catName'        => 'dashboard',
            'title'          => 'EliteHR Analytics',
            'breadcrumbs'    => ['Dashboard', 'Analytics'],
            'scrollspy'      => 0,
            'simplePage'     => 0,
            'totalEmployees' => $totalEmployees,
            'totalCandidates'=> $totalCandidates,
            'openJobs'       => $openJobs,
            'attendanceToday'=> $attendanceToday,
            'pendingLeaves'  => $pendingLeaves,
            'activeGoals'    => $activeGoals,
            'totalPayrollThisMonth' => $totalPayrollThisMonth,
            'last7DaysLabels'=> json_encode($last7DaysLabels),
            'last7DaysData'  => json_encode($last7Days->values()->all()),
            'leaveTrendData' => json_encode($leaveTrend->values()->all()),
            'leaveTypes'     => $leaveTypes,
            'totalLeaveRequests' => $totalLeaveRequests,
            'latestUser'     => $latestUser,
            'latestPayroll'  => $latestPayroll,
            'recentLeaves'   => $recentLeaves,
            'recentCandidates'=> $recentCandidates,
        ]);
    }
}
