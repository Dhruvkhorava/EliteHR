@extends('layouts.app')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="px-4 pt-4 mb-3">
                    <h5 class="mb-0">Employee Salary Setup</h5>
                </div>
                <hr>
                
                <div class="row px-4 mb-4">
                    <div class="col-md-4">
                        <div class="card p-3">
                            <h6>Add/Update Salary</h6>
                            <form action="{{ route('payroll.store-setup') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label>Employee</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="">Select Employee</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Basic Salary</label>
                                    <input type="number" name="basic" class="form-control" placeholder="20000" required>
                                </div>
                                <div class="mb-3">
                                    <label>HRA</label>
                                    <input type="number" name="hra" class="form-control" placeholder="10000" required>
                                </div>
                                <div class="mb-3">
                                    <label>Allowance</label>
                                    <input type="number" name="allowance" class="form-control" placeholder="5000" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Save Setup</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Basic</th>
                                        <th>HRA</th>
                                        <th>Allowance</th>
                                        <th>Gross</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salaries as $salary)
                                        <tr>
                                            <td>{{ $salary->user->name }}</td>
                                            <td>{{ number_format($salary->basic, 2) }}</td>
                                            <td>{{ number_format($salary->hra, 2) }}</td>
                                            <td>{{ number_format($salary->allowance, 2) }}</td>
                                            <td><strong>{{ number_format($salary->basic + $salary->hra + $salary->allowance, 2) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
