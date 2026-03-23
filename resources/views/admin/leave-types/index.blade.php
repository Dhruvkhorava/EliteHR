@extends('layouts.app')

@section('styles')
    @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
    @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
    @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
@endsection

@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <div class="d-flex justify-content-between align-items-center p-4 border-bottom mb-3">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Leave Type Settings</h5>
                        <p class="text-muted mb-0 small">Configure available leave categories and their yearly quotas.</p>
                    </div>
                    <a href="{{ route('leave-types.create') }}" class="btn btn-primary btn-lg px-4 shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add New Type
                    </a>
                </div>
                <div class="px-4 pb-4">
                    <table id="leave-types-table" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Days Allowed</th>
                                <th class="text-center">Carry Forward</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaveTypes as $type)
                                <tr>
                                    <td>{{ $type->name }}</td>
                                    <td class="text-center">{{ $type->days_allowed }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $type->carry_forward ? 'badge-light-success' : 'badge-light-danger' }}">
                                            {{ $type->carry_forward ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $type->is_paid ? 'badge-light-primary' : 'badge-light-warning' }}">
                                            {{ $type->is_paid ? 'Paid' : 'Unpaid' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('leave-types.edit', $type->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                            <form action="{{ route('leave-types.destroy', $type->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm confirm-delete">Delete</button>
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

@section('scripts')
    <script src="{{ asset('plugins/src/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('asset/js/admin/leave-types/index.js') }}"></script>
@endsection
