@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-10 col-lg-10 col-sm-12 offset-xl-1 offset-lg-1 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="px-4 pt-4 mb-3">
                <h5 class="mb-0">Create Salary Template</h5>
            </div>
            <hr>
            
            <form action="{{ route('salary-templates.store') }}" method="POST" class="px-4 pb-4">
                @csrf
                <div class="mb-4">
                    <label>Template Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Standard Monthly, Executive Package" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                
                <h6>Template Components</h6>
                <div id="component-container">
                    <div class="row component-row mb-3">
                        <div class="col-md-4">
                            <label>Component</label>
                            <select name="components[0][id]" class="form-control @error('components.0.id') is-invalid @enderror">
                                <option value="">Select Component</option>
                                @foreach($components as $component)
                                    <option value="{{ $component->id }}">{{ $component->name }} ({{ ucfirst($component->type) }})</option>
                                @endforeach
                            </select>
                            @error('components.0.id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label>Value Type</label>
                            <select name="components[0][amount_type]" class="form-control @error('components.0.amount_type') is-invalid @enderror">
                                <option value="fixed">Fixed Amount</option>
                                <option value="percentage">% of Basic</option>
                            </select>
                            @error('components.0.amount_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label>Value</label>
                            <input type="number" name="components[0][amount_value]" class="form-control @error('components.0.amount_value') is-invalid @enderror" step="0.01">
                            @error('components.0.amount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger d-block remove-row">Remove</button>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-component" class="btn btn-secondary mb-4">Add Another Component</button>
                
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('salary-templates.index') }}" class="btn btn-light-dark mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    window.payrollData = {
        componentCount: 1
    };
</script>
<script src="{{ asset('asset/js/payroll_templates.js') }}"></script>
@endsection
@endsection
