@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between px-4 pt-4 mb-3">
                <h5 class="mb-0">Salary Components</h5>
                <a href="{{ route('salary-components.create') }}" class="btn btn-primary">Add Component</a>
            </div>
            <hr>
            
            <div class="table-responsive px-4 pb-4">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Taxable</th>
                            <th>Recurring</th>
                            <th>Status</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($components as $component)
                        <tr>
                            <td>{{ $component->name }}</td>
                            <td>
                                <span class="badge {{ $component->type == 'earning' ? 'badge-light-success' : 'badge-light-danger' }}">
                                    {{ ucfirst($component->type) }}
                                </span>
                            </td>
                            <td>{{ $component->is_taxable ? 'Yes' : 'No' }}</td>
                            <td>{{ $component->is_recurring ? 'Yes' : 'No' }}</td>
                            <td>
                                <span class="badge {{ $component->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($component->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('salary-components.edit', $component->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('salary-components.destroy', $component->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
