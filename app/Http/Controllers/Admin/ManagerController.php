<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::all();
        return view('admin.managers.index', compact('managers'), [
            'title' => 'Manager Management',
            'catName' => 'users',
            'breadcrumbs' => ['User Management', 'Managers'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        Manager::create($request->all());

        return redirect()->route('managers.index')
            ->with('success', 'Manager created successfully.');
    }

    public function update(Request $request, Manager $manager)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $manager->update($request->all());

        return redirect()->route('managers.index')
            ->with('success', 'Manager updated successfully.');
    }

    public function destroy(Manager $manager)
    {
        if ($manager->users()->count() > 0) {
            return redirect()->route('managers.index')
                ->with('error', 'Cannot delete manager: already assigned to employees.');
        }

        $manager->delete();

        return redirect()->route('managers.index')
            ->with('success', 'Manager deleted successfully.');
    }
}
