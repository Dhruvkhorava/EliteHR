<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveApprovalController extends Controller
{
    public function index()
    {
        $this->authorize('leave.approve');
        $leaves = Leave::with(['user', 'leaveType'])->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('admin.leaves.pending', [
            'leaves' => $leaves,
            'title' => 'Pending Leaves',
            'catName' => 'leave',
            'breadcrumbs' => ['Leave Management', 'Pending Approvals'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function history()
    {
        $this->authorize('leave.view_all');
        $leaves = Leave::with(['user', 'leaveType', 'approver'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.leaves.history', [
            'leaves' => $leaves,
            'title' => 'Leave History',
            'catName' => 'leave',
            'breadcrumbs' => ['Leave Management', 'All History'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function action(Request $request, Leave $leave)
    {
        $this->authorize('leave.approve');
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($leave->status != 'pending') {
            return redirect()->back()->with('error', 'This leave request has already been processed.');
        }

        DB::beginTransaction();
        try {
            $leave->update([
                'status' => $request->status,
                'approved_by' => Auth::id(),
                'comment' => $request->comment,
            ]);

            if ($request->status == 'approved') {
                // 1. Deduct Balance
                $balance = LeaveBalance::where('user_id', $leave->user_id)
                    ->where('leave_type_id', $leave->leave_type_id)
                    ->first();

                if ($balance) {
                    $balance->used += $leave->total_days;
                    $balance->remaining -= $leave->total_days;
                    $balance->save();
                }

                // 2. Mark Attendance as Leave
                $startDate = Carbon::parse($leave->from_date);
                $endDate = Carbon::parse($leave->to_date);

                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    Attendance::updateOrCreate(
                        [
                            'user_id' => $leave->user_id,
                            'date' => $date->toDateString(),
                        ],
                        [
                            'status' => 'leave', // User requested "Leave"
                            'check_in' => null,
                            'check_out' => null,
                            'working_hours' => 0,
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Leave request ' . $request->status . ' successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
