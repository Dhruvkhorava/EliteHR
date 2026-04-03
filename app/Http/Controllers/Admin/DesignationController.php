<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::all();
        return view('admin.designations.index', compact('designations'), [
            'title' => 'Designation Management',
            'catName' => 'users',
            'breadcrumbs' => ['User Management', 'Designations'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:designations',
            'description' => 'nullable|string',
        ]);

        Designation::create($request->all());

        return redirect()->route('designations.index')
            ->with('success', 'Designation created successfully.');
    }



    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:designations,name,' . $designation->id,
            'description' => 'nullable|string',
        ]);

        $designation->update($request->all());

        return redirect()->route('designations.index')
            ->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        if ($designation->users()->count() > 0) {
            return redirect()->route('designations.index')
                ->with('error', 'Cannot delete designation as it is assigned to employees.');
        }

        $designation->delete();

        return redirect()->route('designations.index')
            ->with('success', 'Designation deleted successfully.');
    }
}
