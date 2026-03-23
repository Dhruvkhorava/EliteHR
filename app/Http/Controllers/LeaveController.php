<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $leaves = Leave::with('leaveType')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $balances = LeaveBalance::with('leaveType')->where('user_id', $user->id)->get();

        return view('leaves.index', [
            'leaves' => $leaves,
            'balances' => $balances,
            'title' => 'My Leaves',
            'catName' => 'leave',
            'breadcrumbs' => ['Leave Management', 'My Leaves'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('leaves.create', [
            'leaveTypes' => $leaveTypes,
            'title' => 'Apply Leave',
            'catName' => 'leave',
            'breadcrumbs' => ['Leave Management', 'Apply Leave'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $fromDate = Carbon::parse($request->from_date);
        $toDate = Carbon::parse($request->to_date);
        $totalDays = $fromDate->diffInDays($toDate) + 1;

        // Check Balance
        $balance = LeaveBalance::where('user_id', $user->id)
            ->where('leave_type_id', $request->leave_type_id)
            ->first();

        if (!$balance || $balance->remaining < $totalDays) {
            return redirect()->back()
                ->with('error', 'Insufficient leave balance. requested: ' . $totalDays . ' days, available: ' . ($balance->remaining ?? 0) . ' days.')
                ->withInput();
        }

        Leave::create([
            'user_id' => $user->id,
            'leave_type_id' => $request->leave_type_id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')
            ->with('success', 'Leave application submitted successfully.');
    }
}
