@extends('layouts.app')

@section('styles')
@vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
@vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
@vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
@vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
<link rel="stylesheet" href="{{ asset('asset/css/admin/hrs/index.css') }}">
@endsection

@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <div class="d-flex justify-content-between align-items-center px-4 pt-4 mb-3">
                <h5 class="mb-0">{{ $title }}</h5>
                <a href="{{ route('hrs.create') }}" id="add-new-btn" class="btn btn-primary">Add New HR</a>
            </div>
            
            <div class="px-4 pb-4 user-table">
                <table id="user-table" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            @if(auth()->user()->hasRole('super_admin'))
                                <th scope="col">Role</th>
                            @endif
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.showRoleColumn = {{ auth()->user()->hasRole('super_admin') ? 'true' : 'false' }};
</script>
<script src="{{asset('plugins/src/table/datatable/datatables.js')}}"></script>
<script src="{{ asset('asset/js/admin/hrs/index.js') }}"></script>
@endsection
