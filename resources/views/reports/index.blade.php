@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-center">
                <!-- Centered Heading -->
                <div class="col-sm-12 text-center">
                    <h1>Reports</h1>
                </div>
            </div>
            <div class="row mb-2">
                <!-- Search Box to the left -->
                <div class="col-sm-6">
                    <form method="GET" action="{{ route('reports.index') }}" class="form-inline mb-3">
                        <!-- Search Input -->
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search reports" value="{{ request()->get('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Clear</a>
                    </form>
                </div>

                <!-- Add New Button to the right -->
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="{{ route('reports.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="container-fluid">
            <div class="row">
                <!-- Employee Dropdown -->
                <div class="col-sm-3">
                    <label for="employee_id">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">Select an Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date Field -->
                <div class="col-sm-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request()->get('start_date') }}">
                </div>

                <!-- End Date Field -->
                <div class="col-sm-3">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request()->get('end_date') }}">
                </div>

                <!-- Report Type Dropdown for Filtering by Day (Monday to Friday) -->
                <div class="col-sm-3">
                    <label for="report_type">Report Type</label>
                    <select name="report_type" id="report_type" class="form-control">
                        <option value="">All</option>
                        <option value="monday" {{ request()->get('report_type') == 'monday' ? 'selected' : '' }}>Monday</option>
                        <option value="tuesday" {{ request()->get('report_type') == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="wednesday" {{ request()->get('report_type') == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="thursday" {{ request()->get('report_type') == 'thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="friday" {{ request()->get('report_type') == 'friday' ? 'selected' : '' }}>Friday</option>
                        <option value="summary" {{ request()->get('report_type') == 'summary' ? 'selected' : '' }}>Summary</option>
                    </select>
                </div>
            </div>

            <!-- Filter Button -->
            <div class="row mt-3">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-success">Filter</button>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('reports.table') <!-- Include your table partial for the reports list -->
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeDropdown = document.querySelector('#report_type');

        function filterColumns() {
            const type = typeDropdown.value;
            const allRows = document.querySelectorAll('.report-row');

            // Hide all rows by default
            allRows.forEach(row => row.style.display = 'none');

            if (type === 'monday') {
                document.querySelectorAll('.monday-row').forEach(row => row.style.display = '');
            } else if (type === 'tuesday') {
                document.querySelectorAll('.tuesday-row').forEach(row => row.style.display = '');
            } else if (type === 'wednesday') {
                document.querySelectorAll('.wednesday-row').forEach(row => row.style.display = '');
            } else if (type === 'thursday') {
                document.querySelectorAll('.thursday-row').forEach(row => row.style.display = '');
            } else if (type === 'friday') {
                document.querySelectorAll('.friday-row').forEach(row => row.style.display = '');
            } else if (type === 'summary') {
                document.querySelectorAll('.summary-row').forEach(row => row.style.display = '');
            } else {
                // Show all rows for "All"
                allRows.forEach(row => row.style.display = '');
            }
        }

        // Initial filtering on page load
        filterColumns();

        // Re-filter columns on dropdown change
        typeDropdown.addEventListener('change', filterColumns);
    });
    </script>
@endsection
