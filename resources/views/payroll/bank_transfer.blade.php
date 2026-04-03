@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="px-4 pt-4 mb-3">
                <h5 class="mb-0">Bank Transfer Processing</h5>
            </div>
            <hr>
            
            <div class="row px-4 pb-4">
                <div class="col-md-4">
                    <div class="card p-3 shadow-none border">
                        <h6>Create Transfer Batch</h6>
                        <form action="{{ route('payroll.store-bank-transfer') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Batch Name/Month</label>
                                <input type="text" name="batch_no" class="form-control @error('batch_no') is-invalid @enderror" placeholder="Mar 2026 Salary" value="{{ old('batch_no') }}">
                                @error('batch_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Bank Template</label>
                                <select name="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                                    <option value="">Select Bank Template</option>
                                    <option value="Generic Bulk Transfer" {{ old('bank_name') == 'Generic Bulk Transfer' ? 'selected' : '' }}>Generic Bulk Transfer (Excel)</option>
                                    <option value="HDFC Bank" {{ old('bank_name') == 'HDFC Bank' ? 'selected' : '' }}>HDFC Bank Template</option>
                                    <option value="SBI Bank" {{ old('bank_name') == 'SBI Bank' ? 'selected' : '' }}>SBI Bank Template</option>
                                </select>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Generate Batch File</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <h6>Recent Batches</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Batch No</th>
                                    <th>Bank</th>
                                    <th>Employees</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $batches = \App\Models\BankTransferBatch::orderBy('created_at', 'desc')->get(); @endphp
                                @forelse($batches as $batch)
                                <tr>
                                    <td>{{ $batch->batch_no }}</td>
                                    <td>{{ $batch->bank_name }}</td>
                                    <td>{{ $batch->employee_count }}</td>
                                    <td>{{ number_format($batch->total_amount, 2) }}</td>
                                    <td><span class="badge badge-light-info">{{ ucfirst($batch->status) }}</span></td>
                                    <td><a href="#" class="btn btn-sm btn-outline-primary">File</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No batches generated yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
