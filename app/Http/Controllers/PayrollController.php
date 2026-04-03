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
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        $users = auth()->user()->hasRole('super_admin')
            ? User::all()
            : User::whereDoesntHave('roles', function ($q) {
                $q->where('name', 'super_admin');
            })->get();

        $salaries = Salary::with(['user', 'template'])->get();
        $templates = \App\Models\SalaryTemplate::where('status', 'active')->get();

        return view('payroll.setup', [
            'users' => $users,
            'salaries' => $salaries,
            'templates' => $templates,
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
            'salary_template_id' => 'required|exists:salary_templates,id',
            'ctc' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
        ]);

        $template = \App\Models\SalaryTemplate::with('components')->find($request->salary_template_id);

        // Calculate basic from template if percentage based (assuming one component is named 'Basic')
        $basicComp = $template->components->where('name', 'Basic')->first();
        $basic = 0;
        if ($basicComp) {
            if ($basicComp->pivot->amount_type == 'fixed') {
                $basic = $basicComp->pivot->amount_value;
            } else {
                $basic = ($request->ctc / 12) * ($basicComp->pivot->amount_value / 100);
            }
        } else {
            // Default 50% of monthly CTC as basic if not defined
            $basic = ($request->ctc / 12) * 0.5;
        }

        Salary::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'salary_template_id' => $request->salary_template_id,
                'ctc' => $request->ctc,
                'basic' => $basic,
                'hra' => 0, // Will be calculated dynamically during payroll generation based on template
                'allowance' => 0,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
            ]
        );

        return redirect()->back()->with('success', 'Employee salary configured successfully.');
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

        $users = auth()->user()->hasRole('super_admin')
            ? User::with(['salary.template.components', 'loans'])->get()
            : User::with(['salary.template.components', 'loans'])->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'super_admin');
            })->get();

        $workingDays = Carbon::create($year, $month)->daysInMonth;

        foreach ($users as $user) {
            if (!$user->salary || !$user->salary->template)
                continue;

            // Delete existing payroll for this month/year if any
            Payroll::where('user_id', $user->id)
                ->where('month', $month)
                ->where('year', $year)
                ->delete();

            $template = $user->salary->template;
            $monthlyCtc = $user->salary->ctc / 12;
            $basic = $user->salary->basic;

            // Attendance Data
            $absentDays = Attendance::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('status', 'absent')
                ->count();

            // Unpaid Leaves
            $unpaidDays = Leave::where('user_id', $user->id)
                ->where('status', 'approved')
                ->whereHas('leaveType', function ($query) {
                    $query->where('is_paid', false);
                })
                ->where(function ($query) use ($month, $year) {
                    $query->whereMonth('from_date', $month)->whereYear('from_date', $year)
                        ->orWhereMonth('to_date', $month)->whereYear('to_date', $year);
                })
                ->sum('total_days');

            $totalLopDays = $absentDays + $unpaidDays;
            $perDayCtc = $monthlyCtc / $workingDays;
            $lopDeduction = $perDayCtc * $totalLopDays;

            $payroll = Payroll::create([
                'user_id' => $user->id,
                'month' => $month,
                'year' => $year,
                'basic' => $basic,
                'hra' => 0, // Summarized in details
                'allowance' => 0,
                'bonus' => 0,
                'total_deduction' => 0,
                'net_salary' => 0,
                'status' => 'generated',
            ]);

            $totalEarnings = 0;
            $totalDeductions = $lopDeduction;

            // Process Template Components
            foreach ($template->components as $comp) {
                $amount = 0;
                if ($comp->pivot->amount_type == 'fixed') {
                    $amount = $comp->pivot->amount_value;
                } else {
                    $amount = $basic * ($comp->pivot->amount_value / 100);
                }

                if ($comp->type == 'earning') {
                    $totalEarnings += $amount;
                    PayrollDetail::create([
                        'payroll_id' => $payroll->id,
                        'type' => 'earning',
                        'name' => $comp->name,
                        'amount' => $amount,
                    ]);
                } else {
                    $totalDeductions += $amount;
                    PayrollDetail::create([
                        'payroll_id' => $payroll->id,
                        'type' => 'deduction',
                        'name' => $comp->name,
                        'amount' => $amount,
                    ]);
                }
            }

            // LOP Deduction Detail
            if ($lopDeduction > 0) {
                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'type' => 'deduction',
                    'name' => 'Loss of Pay (' . $totalLopDays . ' days)',
                    'amount' => $lopDeduction,
                ]);
            }

            // Loan Repayments
            $activeLoans = $user->loans()->where('status', 'ongoing')->get();
            foreach ($activeLoans as $loan) {
                $repaymentAmount = min($loan->monthly_installment, $loan->balance_amount);
                if ($repaymentAmount > 0) {
                    $totalDeductions += $repaymentAmount;
                    PayrollDetail::create([
                        'payroll_id' => $payroll->id,
                        'type' => 'deduction',
                        'name' => 'Loan Repayment',
                        'amount' => $repaymentAmount,
                    ]);
                    \App\Models\LoanRepayment::create([
                        'loan_id' => $loan->id,
                        'payroll_id' => $payroll->id,
                        'amount' => $repaymentAmount,
                        'payment_date' => now(),
                    ]);
                    $loan->decrement('balance_amount', $repaymentAmount);
                    if ($loan->balance_amount <= 0) {
                        $loan->update(['status' => 'completed']);
                    }
                }
            }

            $netSalary = $totalEarnings - $totalDeductions;
            $payroll->update([
                'total_deduction' => $totalDeductions,
                'net_salary' => $netSalary,
            ]);
        }

        return redirect()->route('payroll.index')->with('success', 'Payroll generated successfully for ' . Carbon::create($year, $month)->format('F Y'));
    }

    public function show($id)
    {
        $payroll = Payroll::with(['user', 'details'])->findOrFail($id);

        // Check if user is viewing their own payroll or has admin/hr access
        if ($payroll->user_id !== auth()->id() && !auth()->user()->can('payroll.view')) {
            abort(403, 'Unauthorized access.');
        }

        return view('payroll.payslip', [
            'payroll' => $payroll,
            'title' => 'Employee Payslip',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Payslip'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function downloadPdf($id)
    {
        $payroll = Payroll::with(['user', 'details'])->findOrFail($id);

        // Check if user is downloading their own payroll or has admin/hr access
        if ($payroll->user_id !== auth()->id() && !auth()->user()->can('payroll.view')) {
            abort(403, 'Unauthorized access.');
        }

        $pdf = PDF::loadView('payroll.pdf_payslip', [
            'payroll' => $payroll,
        ])->setPaper('a4', 'portrait');

        $fileName = 'Payslip_' . $payroll->user->name . '_' . Carbon::create($payroll->year, $payroll->month)->format('M_Y') . '.pdf';
        return $pdf->download($fileName);
    }

    public function statement()
    {
        return view('payroll.statement', [
            'title' => 'Salary Statement',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Statement'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function bankTransfer()
    {
        return view('payroll.bank_transfer', [
            'title' => 'Bank Transfer',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Bank Transfer'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function storeBankTransfer(Request $request)
    {
        $request->validate([
            'batch_no' => 'required|string',
            'bank_name' => 'required|string',
        ]);

        $payrolls = Payroll::where('status', 'generated')->get();
        if ($payrolls->isEmpty()) {
            return redirect()->back()->with('error', 'No generated payrolls found to create a batch.');
        }

        $batch = \App\Models\BankTransferBatch::create([
            'batch_no' => $request->batch_no,
            'employee_count' => $payrolls->count(),
            'total_amount' => $payrolls->sum('net_salary'),
            'bank_name' => $request->bank_name,
            'status' => 'pending',
        ]);

        Payroll::where('status', 'generated')->update(['bank_transfer_batch_id' => $batch->id, 'status' => 'processed']);

        return redirect()->back()->with('success', 'Bank transfer batch ' . $batch->batch_no . ' created successfully.');
    }

    public function reports()
    {
        return view('payroll.reports', [
            'title' => 'Statutory Reports Gallery',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Reports Gallery'],
            'scrollspy' => 0,
            'simplePage' => 0,
            'currentMonth' => date('n'),
            'currentYear' => date('Y'),
            'months' => [
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
            ],
            'years' => range(date('Y'), date('Y') - 5)
        ]);
    }

    public function exportReport(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:pf,esi,pt,it',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
        ]);

        $type = $request->type;
        $month = $request->month;
        $year = $request->year;

        $payrolls = Payroll::with(['user', 'details'])
            ->where('month', $month)
            ->where('year', $year)
            ->get();

        if ($payrolls->isEmpty()) {
            return redirect()->back()->with('error', 'No payroll records found for the selected period.');
        }

        $filename = strtoupper($type) . "_Report_" . date('F_Y', mktime(0, 0, 0, $month, 1, $year)) . ".csv";

        $callback = function () use ($payrolls, $type) {
            $file = fopen('php://output', 'w');

            if ($type == 'pf') {
                fputcsv($file, ['UAN', 'Employee Name', 'Gross Wages', 'EPF Wages', 'EPS Wages', 'EDLI Wages', 'EE Share', 'ER Share']);
                foreach ($payrolls as $payroll) {
                    $pfDetail = $payroll->details->where('name', 'Provident Fund (PF)')->first();
                    $pfAmount = $pfDetail ? $pfDetail->amount : 0;
                    fputcsv($file, [
                        $payroll->user->uan_number ?? 'N/A',
                        $payroll->user->name,
                        number_format($payroll->net_salary + $payroll->total_deduction, 2, '.', ''),
                        number_format($payroll->basic, 2, '.', ''),
                        number_format($payroll->basic, 2, '.', ''),
                        number_format($payroll->basic, 2, '.', ''),
                        number_format($pfAmount, 2, '.', ''),
                        number_format($pfAmount, 2, '.', ''), // Assuming 1:1 match for simplicity
                    ]);
                }
            } elseif ($type == 'esi') {
                fputcsv($file, ['ESI Number', 'Employee Name', 'Working Days', 'Total Wages', 'Employee Contribution']);
                foreach ($payrolls as $payroll) {
                    $esiDetail = $payroll->details->filter(fn($d) => str_contains($d->name, 'ESI'))->first();
                    $esiAmount = $esiDetail ? $esiDetail->amount : 0;
                    fputcsv($file, [
                        $payroll->user->esi_number ?? 'N/A',
                        $payroll->user->name,
                        30, // Placeholder working days
                        number_format($payroll->net_salary + $payroll->total_deduction, 2, '.', ''),
                        number_format($esiAmount, 2, '.', ''),
                    ]);
                }
            } elseif ($type == 'pt') {
                fputcsv($file, ['Employee Name', 'Gross Salary', 'PT Deduction']);
                foreach ($payrolls as $payroll) {
                    $ptDetail = $payroll->details->where('name', 'Professional Tax')->first();
                    $ptAmount = $ptDetail ? $ptDetail->amount : 0;
                    fputcsv($file, [
                        $payroll->user->name,
                        number_format($payroll->net_salary + $payroll->total_deduction, 2, '.', ''),
                        number_format($ptAmount, 2, '.', ''),
                    ]);
                }
            } elseif ($type == 'it') {
                fputcsv($file, ['PAN', 'Employee Name', 'Gross Salary', 'TDS Deduction']);
                foreach ($payrolls as $payroll) {
                    $itDetail = $payroll->details->filter(fn($d) => str_contains(strtolower($d->name), 'income tax') || str_contains(strtolower($d->name), 'tds'))->first();
                    $itAmount = $itDetail ? $itDetail->amount : 0;
                    fputcsv($file, [
                        $payroll->user->pan_number ?? 'N/A',
                        $payroll->user->name,
                        number_format($payroll->net_salary + $payroll->total_deduction, 2, '.', ''),
                        number_format($itAmount, 2, '.', ''),
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }

    public function exportStatement(Request $request)
    {
        $month = $request->query('month', date('n'));
        $year = $request->query('year', date('Y'));

        $payrolls = Payroll::with('user')
            ->where('month', $month)
            ->where('year', $year)
            ->get();

        $filename = "Salary_Statement_" . date('F_Y', mktime(0, 0, 0, $month, 1, $year)) . ".csv";

        $callback = function () use ($payrolls) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Employee Name', 'Earnings', 'Deductions', 'Net Salary', 'Status']);

            foreach ($payrolls as $payroll) {
                fputcsv($file, [
                    $payroll->user->name,
                    number_format($payroll->net_salary + $payroll->total_deduction, 2, '.', ''),
                    number_format($payroll->total_deduction, 2, '.', ''),
                    number_format($payroll->net_salary, 2, '.', ''),
                    ucfirst($payroll->status)
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }

    public function mySalary()
    {
        $user = auth()->user();
        $salary = $user->salary;
        $payrolls = $user->payrolls()
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        // dd($payrolls->toArray());
        $currentYear = date('Y');
        $yearlyPayrolls = $user->payrolls()
            ->where('year', $currentYear)
            ->get();

        // Dynamic Yearly: Sum of gross from current year payrolls, fallback to CTC
        $yearlyGross = $yearlyPayrolls->sum(function ($p) {
            return $p->net_salary + $p->total_deduction;
        });

        $yearly = $yearlyGross > 0 ? $yearlyGross : ($salary ? $salary->ctc : 0);

        // Dynamic Monthly: Gross of latest payroll, fallback to monthly CTC
        $latestPayroll = $payrolls->first();
        if ($latestPayroll) {
            $monthly = $latestPayroll->net_salary + $latestPayroll->total_deduction;
        } else {
            $monthly = $salary ? ($salary->ctc / 12) : 0;
        }

        // Dynamic Daily: Average rate based on latest monthly, fallback to standard 30 days
        $daily = $monthly > 0 ? $monthly / 30 : ($yearly / 365);

        return view('payroll.my_salary', [
            'user' => $user,
            'salary' => $salary,
            'payrolls' => $payrolls,
            'yearly' => $yearly,
            'monthly' => $monthly,
            'daily' => $daily,
            'title' => 'My Salary',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'My Salary'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function exportMySalary()
    {
        $user = auth()->user();
        $payrolls = $user->payrolls()->orderBy('year', 'desc')->orderBy('month', 'desc')->get();

        $filename = "My_Salary_History_" . now()->format('Y-m-d') . ".csv";

        $callback = function () use ($payrolls) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Month/Year', 'Basic', 'HRA', 'Allowance', 'Bonus', 'Deductions', 'Net Salary', 'Status']);

            foreach ($payrolls as $payroll) {
                fputcsv($file, [
                    date('F Y', mktime(0, 0, 0, $payroll->month, 1, $payroll->year)),
                    number_format($payroll->basic, 2, '.', ''),
                    number_format($payroll->hra, 2, '.', ''),
                    number_format($payroll->allowance, 2, '.', ''),
                    number_format($payroll->bonus, 2, '.', ''),
                    number_format($payroll->total_deduction, 2, '.', ''),
                    number_format($payroll->net_salary, 2, '.', ''),
                    ucfirst($payroll->status)
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }
}
