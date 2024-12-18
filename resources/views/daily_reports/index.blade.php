@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>My Daily Reports</h1>
</section>

<div class="content px-3">

    <!-- Add New Report Button -->
    <a href="{{ route('daily_reports.create', ['employee_id' => Auth::id()]) }}" class="btn btn-primary mb-3">Add New Report</a>


    @if($reports->isNotEmpty())
        <h3>Reports for {{ Auth::user()->name }}</h3>

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

                    @if(!$report->is_submitted)
                        <!-- Edit Button -->
                        <a href="{{ route('daily_reports.edit', $report->id) }}" class="btn btn-warning">Edit</a>

                        <!-- Submit Button -->
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
        <p>No reports available yet. Start by creating a new report.</p>
    @endif
</div>
@endsection
