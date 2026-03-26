<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();
        return view('admin.shifts.index', [
            'shifts' => $shifts,
            'title' => 'Shift Management',
            'catName' => 'attendance',
            'breadcrumbs' => ['Attendance', 'Shift Management'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'grace_period' => 'required|integer|min:0',
        ]);

        Shift::create($request->all());

        return back()->with('success', 'Shift created successfully.');
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'grace_period' => 'required|integer|min:0',
        ]);

        $shift->update($request->all());

        return back()->with('success', 'Shift updated successfully.');
    }

    public function destroy(Shift $shift)
    {
        // Check if any users are assigned to this shift
        if ($shift->users()->count() > 0) {
            return back()->with('error', 'Cannot delete shift. Some users are still assigned to it.');
        }

        $shift->delete();
        return back()->with('success', 'Shift deleted successfully.');
    }
}
