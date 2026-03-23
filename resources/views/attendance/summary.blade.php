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
                    <h5 class="mb-0">{{ $title }} ({{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }})</h5>
                    <form action="{{ route('attendance.summary') }}" method="GET" class="d-flex align-items-center">
                        <select name="month" class="form-control me-1">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endforeach
                        </select>
                        <select name="year" class="form-control me-1">
                            @foreach (range(date('Y') - 1, date('Y') + 1) as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
                <hr>
                <div class="table-responsive px-4 pb-4">
                    <table id="attendance-summary-table" class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Employee</th>
                                <th class="text-center">Present</th>
                                <th class="text-center">Late</th>
                                <th class="text-center">Half Day</th>
                                <th class="text-center">Absent</th>
                                <th class="text-center">Total Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($summary as $row)
                                <tr>
                                    <td>{{ $row['user']->name }}</td>
                                    <td class="text-center text-success fw-bold">{{ $row['present'] }}</td>
                                    <td class="text-center text-warning fw-bold">{{ $row['late'] }}</td>
                                    <td class="text-center text-info fw-bold">{{ $row['half_day'] }}</td>
                                    <td class="text-center text-danger fw-bold">{{ $row['absent'] }}</td>
                                    <td class="text-center fw-bold">{{ round($row['working_hours'], 2) }}</td>
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
    <script src="{{ asset('asset/js/attendance/summary.js') }}"></script>
@endsection
