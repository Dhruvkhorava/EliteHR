<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $this->authorize('leave_type.manage');
        $leaveTypes = LeaveType::all();
        return view('admin.leave-types.index', compact('leaveTypes'), [
            'title' => 'Leave Type Settings',
            'catName' => 'leave',
            'breadcrumbs' => ['Leave Management', 'Leave Types'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function create()
    {
        $this->authorize('leave_type.manage');
        return view('admin.leave-types.create', [
            'title' => 'Create Leave Type',
            'catName' => 'leave',
            'breadcrumbs' => ['Leave Management', 'Leave Types', 'Add'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('leave_type.manage');
        $request->validate([
            'name' => 'required|string|max:255|unique:leave_types',
            'days_allowed' => 'required|integer|min:1',
            'carry_forward' => 'required|boolean',
            'is_paid' => 'required|boolean',
        ]);

        $leaveType = LeaveType::create($request->all());

        // Initialize balances for all users
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            \App\Models\LeaveBalance::create([
                'user_id' => $user->id,
                'leave_type_id' => $leaveType->id,
                'total' => $leaveType->days_allowed,
                'used' => 0,
                'remaining' => $leaveType->days_allowed,
            ]);
        }

        return redirect()->route('leave-types.index')
            ->with('success', 'Leave type created successfully and balances initialized for all users.');
    }

    public function edit(LeaveType $leaveType)
    {
        $this->authorize('leave_type.manage');
        return view('admin.leave-types.edit', [
            'leaveType' => $leaveType,
            'title' => 'Edit Leave Type',
            'catName' => 'leave',
            'breadcrumbs' => ['Leave Management', 'Leave Types', 'Edit'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $this->authorize('leave_type.manage');
        $request->validate([
            'name' => 'required|string|max:255|unique:leave_types,name,' . $leaveType->id,
            'days_allowed' => 'required|integer|min:0',
            'carry_forward' => 'required|boolean',
            'is_paid' => 'required|boolean',
        ]);

        $oldDays = $leaveType->days_allowed;
        $leaveType->update($request->all());

        // Update balances if days_allowed changed
        if ($oldDays != $leaveType->days_allowed) {
            $diff = $leaveType->days_allowed - $oldDays;
            \App\Models\LeaveBalance::where('leave_type_id', $leaveType->id)->increment('total', $diff);
            \App\Models\LeaveBalance::where('leave_type_id', $leaveType->id)->increment('remaining', $diff);
        }

        return redirect()->route('leave-types.index')
            ->with('success', 'Leave type updated successfully.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $this->authorize('leave_type.manage');
        $leaveType->delete();

        return redirect()->route('leave-types.index')
            ->with('success', 'Leave type deleted successfully.');
    }
}
