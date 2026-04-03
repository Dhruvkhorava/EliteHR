@extends('layouts.app')

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between px-4 pt-4 mb-3">
                <h5 class="mb-0">Salary Templates</h5>
                <a href="{{ route('salary-templates.create') }}" class="btn btn-primary">Create Template</a>
            </div>
            <hr>
            
            <div class="table-responsive px-4 pb-4">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Template Name</th>
                            <th>Components</th>
                            <th>Status</th>
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                        <tr>
                            <td>{{ $template->name }}</td>
                            <td>
                                @foreach($template->components as $component)
                                    <span class="badge badge-light-primary">{{ $component->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <span class="badge {{ $template->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($template->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('salary-templates.edit', $template->id) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('salary-templates.destroy', $template->id) }}" method="POST" class="d-inline">
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
