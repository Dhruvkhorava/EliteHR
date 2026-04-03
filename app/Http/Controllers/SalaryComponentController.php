<?php

namespace App\Http\Controllers;

use App\Models\SalaryComponent;
use Illuminate\Http\Request;

class SalaryComponentController extends Controller
{
    public function index()
    {
        $components = SalaryComponent::all();
        return view('payroll.components.index', [
            'components' => $components,
            'title' => 'Salary Components',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Components'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function create()
    {
        return view('payroll.components.create', [
            'title' => 'Create Component',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Components', 'Create'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:earning,deduction',
            'is_taxable' => 'boolean',
            'is_reimbursement' => 'boolean',
            'is_one_time' => 'boolean',
            'is_recurring' => 'boolean',
            'carry_forward' => 'boolean',
        ]);

        SalaryComponent::create($request->all());

        return redirect()->route('salary-components.index')->with('success', 'Component created successfully.');
    }

    public function edit(SalaryComponent $salaryComponent)
    {
        return view('payroll.components.edit', [
            'component' => $salaryComponent,
            'title' => 'Edit Component',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Components', 'Edit'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function update(Request $request, SalaryComponent $salaryComponent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:earning,deduction',
            'is_taxable' => 'boolean',
            'is_reimbursement' => 'boolean',
            'is_one_time' => 'boolean',
            'is_recurring' => 'boolean',
            'carry_forward' => 'boolean',
        ]);

        $salaryComponent->update($request->all());

        return redirect()->route('salary-components.index')->with('success', 'Component updated successfully.');
    }

    public function destroy(SalaryComponent $salaryComponent)
    {
        $salaryComponent->delete();
        return redirect()->route('salary-components.index')->with('success', 'Component deleted successfully.');
    }
}
