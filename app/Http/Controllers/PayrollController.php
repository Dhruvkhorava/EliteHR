<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('user')->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        return view('payroll.index', [
            'payrolls' => $payrolls,
            'title' => 'Payroll History',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'History'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function setup()
    {
        $users = User::all();
        $salaries = Salary::with('user')->get();
        return view('payroll.setup', [
            'users' => $users,
            'salaries' => $salaries,
            'title' => 'Salary Setup',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Salary Setup'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'basic' => 'required|numeric|min:0',
            'hra' => 'required|numeric|min:0',
            'allowance' => 'required|numeric|min:0',
        ]);

        Salary::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'basic' => $request->basic,
                'hra' => $request->hra,
                'allowance' => $request->allowance,
            ]
        );

        return redirect()->back()->with('success', 'Salary structure updated successfully.');
    }

    public function generate()
    {
        return view('payroll.generate', [
            'title' => 'Generate Payroll',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Generate'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function storeGenerate(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2000',
        ]);

        $month = $request->month;
        $year = $request->year;

        $users = User::with('salary')->get();
        $workingDays = Carbon::create($year, $month)->daysInMonth;

        foreach ($users as $user) {
            if (!$user->salary) continue;

            // Delete existing payroll for this month/year if any
            Payroll::where('user_id', $user->id)
                ->where('month', $month)
                ->where('year', $year)
                ->delete();

            $basic = $user->salary->basic;
            $hra = $user->salary->hra;
            $allowance = $user->salary->allowance;
            $gross = $basic + $hra + $allowance;

            $perDay = $gross / $workingDays;

            // Attendance Data
            $absentDays = Attendance::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('status', 'absent')
                ->count();

            // Unpaid Leaves
            $unpaidLeaves = Leave::where('user_id', $user->id)
                ->where('status', 'approved')
                ->whereHas('leaveType', function ($query) {
                    $query->where('is_paid', false);
                })
                ->where(function ($query) use ($month, $year) {
                    $query->whereMonth('from_date', $month)->whereYear('from_date', $year)
                        ->orWhereMonth('to_date', $month)->whereYear('to_date', $year);
                })
                ->get();

            $unpaidDays = 0;
            foreach ($unpaidLeaves as $leave) {
                // Simplified: total days in this month
                $unpaidDays += $leave->total_days; 
            }

            $totalAbsent = $absentDays + $unpaidDays;
            $leaveDeduction = $perDay * $totalAbsent;

            // Example PF/Tax (can be expanded later)
            $pf = $basic * 0.12; // 12% of basic
            $tax = 0;
            if ($gross > 50000) $tax = 2000;

            $totalDeduction = $leaveDeduction + $pf + $tax;
            $netSalary = $gross - $totalDeduction;

            $payroll = Payroll::create([
                'user_id' => $user->id,
                'month' => $month,
                'year' => $year,
                'basic' => $basic,
                'hra' => $hra,
                'allowance' => $allowance,
                'bonus' => 0,
                'total_deduction' => $totalDeduction,
                'net_salary' => $netSalary,
                'status' => 'generated',
            ]);

            // Create Details
            PayrollDetail::create([
                'payroll_id' => $payroll->id,
                'type' => 'earning',
                'name' => 'Basic Salary',
                'amount' => $basic,
            ]);
            PayrollDetail::create([
                'payroll_id' => $payroll->id,
                'type' => 'earning',
                'name' => 'HRA',
                'amount' => $hra,
            ]);
            PayrollDetail::create([
                'payroll_id' => $payroll->id,
                'type' => 'earning',
                'name' => 'Allowance',
                'amount' => $allowance,
            ]);

            if ($leaveDeduction > 0) {
                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'type' => 'deduction',
                    'name' => 'Leave Deduction (LWP)',
                    'amount' => $leaveDeduction,
                ]);
            }
            PayrollDetail::create([
                'payroll_id' => $payroll->id,
                'type' => 'deduction',
                'name' => 'PF',
                'amount' => $pf,
            ]);
            if ($tax > 0) {
                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'type' => 'deduction',
                    'name' => 'Tax',
                    'amount' => $tax,
                ]);
            }
        }

        return redirect()->route('payroll.index')->with('success', 'Payroll generated successfully for ' . Carbon::create($year, $month)->format('F Y'));
    }

    public function show($id)
    {
        $payroll = Payroll::with(['user', 'details'])->findOrFail($id);
        return view('payroll.payslip', [
            'payroll' => $payroll,
            'title' => 'Employee Payslip',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Payslip'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }
}
