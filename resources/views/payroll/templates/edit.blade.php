@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-10 col-lg-10 col-sm-12 offset-xl-1 offset-lg-1 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="px-4 pt-4 mb-3">
                <h5 class="mb-0">Edit Salary Template</h5>
            </div>
            <hr>
            
            <form action="{{ route('salary-templates.update', $template->id) }}" method="POST" class="px-4 pb-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label>Template Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $template->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ $template->description }}</textarea>
                </div>
                
                <h6>Template Components</h6>
                <div id="component-container">
                    @foreach($template->components as $index => $tComp)
                    <div class="row component-row mb-3">
                        <div class="col-md-4">
                            <label>Component</label>
                            <select name="components[{{ $index }}][id]" class="form-control">
                                <option value="">Select Component</option>
                                @foreach($components as $component)
                                    <option value="{{ $component->id }}" {{ $tComp->id == $component->id ? 'selected' : '' }}>
                                        {{ $component->name }} ({{ ucfirst($component->type) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Value Type</label>
                            <select name="components[{{ $index }}][amount_type]" class="form-control">
                                <option value="fixed" {{ $tComp->pivot->amount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                <option value="percentage" {{ $tComp->pivot->amount_type == 'percentage' ? 'selected' : '' }}>% of Basic</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Value</label>
                            <input type="number" name="components[{{ $index }}][amount_value]" class="form-control" step="0.01" value="{{ old('components.'.$index.'.amount_value', $tComp->pivot->amount_value) }}">
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger d-block remove-row">Remove</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <button type="button" id="add-component" class="btn btn-secondary mb-4">Add Another Component</button>
                
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('salary-templates.index') }}" class="btn btn-light-dark mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    window.payrollData = {
        componentCount: {{ $template->components->count() }}
    };
</script>
<script src="{{ asset('asset/js/payroll_templates.js') }}"></script>
@endsection
@endsection
