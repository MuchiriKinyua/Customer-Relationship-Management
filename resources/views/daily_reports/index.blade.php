@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>Daily Reports</h1>
</section>

<div class="content px-3">
    <form action="{{ route('daily_reports.index') }}" method="GET">
        <div class="form-group">
            <label for="employee_id">Select Employee</label>
            <select name="employee_id" id="employee_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Select Employee --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Add New Report Button (appears if an employee is selected) -->
    @if(request('employee_id'))
        <a href="{{ route('daily_reports.create', request('employee_id')) }}" class="btn btn-primary mb-3">Add New Report</a>
    @endif

    @if(request('employee_id') && $reports->isNotEmpty())
        <h3>Reports for {{ $reports->first()->employee->full_name }}</h3>

        @foreach($reports as $report)
            <div class="card mt-2">
                <div class="card-body">
                    <h5>
                        {{ ucfirst($report->day) }} - {{ $report->report_date }}
                        @if ($report->is_submitted)
                            <span class="badge bg-success">Submitted</span>
                        @else
                            <span class="badge bg-warning">Draft</span>
                        @endif
                    </h5>
                    <p>{{ $report->report }}</p>

                    {{-- <a href="{{ route('daily_reports.view', ['employeeId' => $report->employee_id, 'reportId' => $report->id]) }}" class="btn btn-info">View</a> --}}

                    @if(!$report->is_submitted)
                        <!-- Edit Button -->
                        <a href="{{ route('daily_reports.edit', $report->id) }}" class="btn btn-warning">Edit</a>

                       

                        <form action="{{ route('daily_reports.submit', $report->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Submit this report? Once submitted, it cannot be edited or deleted.')">Submit</button>
                        </form>
                        
                    @else
                     <!-- Delete Button -->
                     <form action="{{ route('daily_reports.destroy', $report->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                        <p class="text-muted">This report has been submitted and cannot be edited.</p>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        @if(request('employee_id'))
            <p>No reports available for this employee.</p>
        @else
            <p>Please select an employee to view their reports.</p>
        @endif
    @endif
</div>
@endsection
