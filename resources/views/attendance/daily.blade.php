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
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 mb-3">
                    <h5 class="mb-0">{{ $title }} - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h5>
                    <form action="{{ route('attendance.daily') }}" method="GET" class="d-flex align-items-center">
                        <input type="date" name="date" value="{{ $date }}" class="form-control me-2"
                            onchange="this.form.submit()">
                    </form>
                </div>
                <hr>
                <div class="table-responsive px-4 pb-4">
                    <table id="attendance-daily-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Shift</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Working Hours</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($item['user']->image)
                                                <img src="{{ asset('storage/' . $item['user']->image) }}"
                                                    class="rounded-circle me-2" width="30" height="30"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center text-white"
                                                    style="width: 30px; height: 30px;">
                                                    {{ substr($item['user']->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span>{{ $item['user']->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('attendance.assign-shift') }}" method="POST" class="d-flex">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $item['user']->id }}">
                                            <select name="shift_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="">No Shift</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id }}" {{ $item['user']->shift_id == $shift->id ? 'selected' : '' }}>
                                                        {{ $shift->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $item['attendance'] && $item['attendance']->check_in ? \Carbon\Carbon::parse($item['attendance']->check_in)->format('h:i A') : '-' }}
                                    </td>
                                    <td>{{ $item['attendance'] && $item['attendance']->check_out ? \Carbon\Carbon::parse($item['attendance']->check_out)->format('h:i A') : '-' }}
                                    </td>
                                    <td>{{ $item['attendance'] ? $item['attendance']->working_hours : '-' }}</td>
                                    <td>
                                        @php
                                            $status = $item['attendance'] ? $item['attendance']->status : 'absent';
                                            $badgeClass =
                                                [
                                                    'present' => 'badge-light-success',
                                                    'late' => 'badge-light-warning',
                                                    'absent' => 'badge-light-danger',
                                                    'half_day' => 'badge-light-info',
                                                ][$status] ?? 'badge-light-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
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
    <script src="{{ asset('asset/js/attendance/daily.js') }}"></script>
@endsection
