<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user')->get();
        return view('payroll.loans.index', [
            'loans' => $loans,
            'title' => 'Employee Loans',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Loans'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function create()
    {
        $users = User::all();
        return view('payroll.loans.create', [
            'users' => $users,
            'title' => 'Create Loan',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Loans', 'Create'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'repayment_period' => 'required|integer|min:1',
        ]);

        $interest = ($request->loan_amount * $request->interest_rate * ($request->repayment_period / 12)) / 100;
        $total_payable = $request->loan_amount + $interest;
        $monthly_installment = $total_payable / $request->repayment_period;

        Loan::create([
            'user_id' => $request->user_id,
            'loan_amount' => $request->loan_amount,
            'interest_rate' => $request->interest_rate,
            'repayment_period' => $request->repayment_period,
            'monthly_installment' => $monthly_installment,
            'total_payable' => $total_payable,
            'balance_amount' => $total_payable,
            'status' => 'pending',
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan application submitted successfully.');
    }

    public function show(Loan $loan)
    {
        $loan->load(['user', 'repayments']);
        return view('payroll.loans.show', [
            'loan' => $loan,
            'title' => 'Loan Details',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Loans', 'Details'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function edit(Loan $loan)
    {
        $users = User::all();
        return view('payroll.loans.edit', [
            'loan' => $loan,
            'users' => $users,
            'title' => 'Edit Loan',
            'catName' => 'payroll',
            'breadcrumbs' => ['Payroll', 'Loans', 'Edit'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,ongoing,completed,rejected',
        ]);

        $loan->update($request->only('status'));

        return redirect()->route('loans.index')->with('success', 'Loan status updated successfully.');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }
}
