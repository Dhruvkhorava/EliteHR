@extends('layouts.app')

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="px-4 pt-4 mb-3">
                    <h5 class="mb-0">Generate Monthly Payroll</h5>
                </div>
                <hr>
                
                <div class="row justify-content-center px-4 mb-4">
                    <div class="col-md-6">
                        <div class="card p-4">
                            <form action="{{ route('payroll.store-generate') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Month</label>
                                        <select name="month" class="form-control" required>
                                            @for($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Year</label>
                                        <select name="year" class="form-control" required>
                                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="alert alert-info py-2">
                                    <small><i class="feather-info"></i> Payroll will be generated based on attendance records and leave data for the selected period.</small>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Generate Payroll</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
