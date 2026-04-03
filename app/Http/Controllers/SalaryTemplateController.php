<?php

namespace App\Http\Controllers;

use App\Models\SalaryTemplate;
use App\Models\SalaryComponent;
use App\Models\SalaryTemplateComponent;
use Illuminate\Http\Request;

class SalaryTemplateController extends Controller
{
    public function index()
    {
        $templates = SalaryTemplate::with('components')->get();
        return view('payroll.templates.index', [
            'templates' => $templates,
            'title' => 'Salary Templates',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Templates'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function create()
    {
        $components = SalaryComponent::where('status', 'active')->get();
        return view('payroll.templates.create', [
            'components' => $components,
            'title' => 'Create Template',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Templates', 'Create'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'components' => 'required|array',
            'components.*.id' => 'required|exists:salary_components,id',
            'components.*.amount_type' => 'required|in:fixed,percentage',
            'components.*.amount_value' => 'required|numeric|min:0',
        ]);

        $template = SalaryTemplate::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        foreach ($request->components as $comp) {
            SalaryTemplateComponent::create([
                'salary_template_id' => $template->id,
                'salary_component_id' => $comp['id'],
                'amount_type' => $comp['amount_type'],
                'amount_value' => $comp['amount_value'],
            ]);
        }

        return redirect()->route('salary-templates.index')->with('success', 'Template created successfully.');
    }

    public function edit(SalaryTemplate $salaryTemplate)
    {
        $salaryTemplate->load('components');
        $components = SalaryComponent::where('status', 'active')->get();
        return view('payroll.templates.edit', [
            'template' => $salaryTemplate,
            'components' => $components,
            'title' => 'Edit Template',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Templates', 'Edit'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function update(Request $request, SalaryTemplate $salaryTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'components' => 'required|array',
            'components.*.id' => 'required|exists:salary_components,id',
            'components.*.amount_type' => 'required|in:fixed,percentage',
            'components.*.amount_value' => 'required|numeric|min:0',
        ]);

        $salaryTemplate->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $salaryTemplate->components()->detach();
        foreach ($request->components as $comp) {
            $salaryTemplate->components()->attach($comp['id'], [
                'amount_type' => $comp['amount_type'],
                'amount_value' => $comp['amount_value'],
            ]);
        }

        return redirect()->route('salary-templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy(SalaryTemplate $salaryTemplate)
    {
        $salaryTemplate->delete();
        return redirect()->route('salary-templates.index')->with('success', 'Template deleted successfully.');
    }
}
