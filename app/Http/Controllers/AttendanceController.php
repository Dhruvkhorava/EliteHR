<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Dynamic Filtering
        $month = $request->query('month');
        $year = $request->query('year', $today->year);
        $rangeDays = $request->query('days', 30);

        if ($month) {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
            // Don't show future dates in history unless it's for planning (but here it's "history")
            if ($endDate->greaterThan($today)) {
                $endDate = $today;
            }
        } else {
            $startDate = $today->copy()->subDays($rangeDays - 1);
            $endDate = $today;
        }

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today->toDateString())
            ->first();

        // Get attendance history for the calculated range
        $history = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->orderBy('date', 'desc')
            ->get();

        // Get approved leaves for the calculated range
        $leaves = $user->leaves()
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('from_date', [$startDate->toDateString(), $endDate->toDateString()])
                  ->orWhereBetween('to_date', [$startDate->toDateString(), $endDate->toDateString()]);
            })
            ->where('status', 'approved')
            ->with('leaveType')
            ->get();

        $user->load('shift');

        // Fetch pending leave requests for the "Requests" tab
        $pendingRequestsCount = $user->leaves()->where('status', 'pending')->count();
        $pendingRequests = $user->leaves()->where('status', 'pending')->with('leaveType')->get();

        return view('attendance.index', [
            'user' => $user,
            'attendance' => $attendance,
            'history' => $history,
            'leaves' => $leaves,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'pendingRequestsCount' => $pendingRequestsCount,
            'pendingRequests' => $pendingRequests,
            'title' => 'Attendance Dashboard',
            'catName' => 'attendance',
            'breadcrumbs' => ['Attendance', 'My Attendance'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();
        $today = $now->toDateString();

        $existing = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            return back()->with('error', 'Already checked in for today.');
        }

        $shift = $user->shift;
        $status = 'present';

        if ($shift) {
            $startTime = Carbon::parse($today . ' ' . $shift->start_time);
            $graceTime = $startTime->copy()->addMinutes($shift->grace_period);

            if ($now->greaterThan($graceTime)) {
                $status = 'late';
            }
        }

        Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'check_in' => $now->toTimeString(),
                'status' => $status,
                'total_break_seconds' => 0,
            ]
        );

        return back()->with('success', 'Checked in successfully at ' . $now->format('h:i A'));
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();
        $today = $now->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return back()->with('error', 'You must check in first.');
        }

        if ($attendance->check_out) {
            return back()->with('error', 'Already checked out for today.');
        }

        // Ensure total_break_seconds is not null
        if ($attendance->total_break_seconds === null) {
            $attendance->total_break_seconds = 0;
        }

        // If still on break, stop the break first
        if ($attendance->is_on_break) {
            $breakStart = Carbon::parse($attendance->current_break_start);
            $secondsOnBreak = $now->diffInSeconds($breakStart, true);
            $attendance->total_break_seconds += $secondsOnBreak;
            $attendance->is_on_break = false;
            $attendance->current_break_start = null;
        }

        $checkIn = Carbon::parse($today . ' ' . $attendance->check_in);
        $totalSeconds = $now->diffInSeconds($checkIn, true);
        
        // Subtract break time
        $workingSeconds = $totalSeconds - $attendance->total_break_seconds;
        if ($workingSeconds < 0) $workingSeconds = 0;
        
        $workingHours = $workingSeconds / 3600;

        $overtime = 0;
        $shift = $user->shift;
        if ($shift) {
            $shiftEnd = Carbon::parse($today . ' ' . $shift->end_time);
            if ($now->greaterThan($shiftEnd)) {
                $overtime = $now->diffInMinutes($shiftEnd, true) / 60;
            }
        }

        $status = $attendance->status;
        if ($workingHours < 4.5) {
            $status = 'absent';
        } elseif ($workingHours < 7.5) {
            $status = 'half_day';
        } else {
            $status = 'present';
        }

        $attendance->update([
            'check_out' => $now->toTimeString(),
            'working_hours' => round($workingHours, 2),
            'overtime' => round($overtime, 2),
            'status' => $status,
            'is_on_break' => false,
            'current_break_start' => null,
            'total_break_seconds' => $attendance->total_break_seconds,
        ]);

        return back()->with('success', 'Checked out successfully at ' . $now->format('h:i A') . '. Total hours: ' . round($workingHours, 2));
    }

    public function startBreak()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in || $attendance->check_out) {
            return back()->with('error', 'Cannot start break without an active session.');
        }

        if ($attendance->is_on_break) {
            return back()->with('error', 'Already on break.');
        }

        $attendance->update([
            'is_on_break' => true,
            'current_break_start' => Carbon::now(),
        ]);

        return back()->with('success', 'Break started at ' . Carbon::now('Asia/Kolkata')->format('h:i A'));
    }

    public function stopBreak()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $today = $now->toDateString();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->is_on_break) {
            return back()->with('error', 'You are not currently on a break.');
        }

        $breakStart = Carbon::parse($attendance->current_break_start);
        $secondsOnBreak = $now->diffInSeconds($breakStart, true);

        $attendance->update([
            'is_on_break' => false,
            'current_break_start' => null,
            'total_break_seconds' => ($attendance->total_break_seconds ?? 0) + $secondsOnBreak,
        ]);

        return back()->with('success', 'Break stopped at ' . $now->format('h:i A'));
    }

    public function daily(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $users = auth()->user()->hasRole('super_admin') 
            ? User::all() 
            : User::whereDoesntHave('roles', function($q) { $q->where('name', 'super_admin'); })->get();
        $attendances = Attendance::where('date', $date)->get()->keyBy('user_id');

        $data = $users->map(function ($user) use ($attendances) {
            return [
            'user' => $user,
            'attendance' => $attendances->get($user->id),
            ];
        });

        return view('attendance.daily', [
            'data' => $data,
            'date' => $date,
            'shifts' => Shift::all(),
            'title' => 'Daily Attendance List',
            'catName' => 'attendance',
            'breadcrumbs' => ['Attendance', 'Daily List'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function summary(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $users = auth()->user()->hasRole('super_admin') 
            ? User::all() 
            : User::whereDoesntHave('roles', function($q) { $q->where('name', 'super_admin'); })->get();
        $summary = [];

        foreach ($users as $user) {
            $attendances = Attendance::where('user_id', $user->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();

            $summary[] = [
                'user' => $user,
                'present' => $attendances->where('status', 'present')->count(),
                'late' => $attendances->where('status', 'late')->count(),
                'absent' => $attendances->where('status', 'absent')->count(),
                'half_day' => $attendances->where('status', 'half_day')->count(),
                'working_hours' => $attendances->sum('working_hours'),
            ];
        }

        return view('attendance.summary', [
            'summary' => $summary,
            'month' => $month,
            'year' => $year,
            'title' => 'Monthly Attendance Summary',
            'catName' => 'attendance',
            'breadcrumbs' => ['Attendance', 'Summary'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function assignShift(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->update(['shift_id' => $request->shift_id]);

        return back()->with('success', 'Shift assigned to ' . $user->name . ' successfully.');
    }
}
