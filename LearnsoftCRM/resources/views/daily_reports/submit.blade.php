@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>Submit Daily Report</h1>
</section>

<div class="content px-3">
    <div class="card">
        <div class="card-body">
            <h5>Employee: {{ $report->employee->full_name }}</h5>
            <p><strong>Day:</strong> {{ ucfirst($report->day) }}</p>
            <p><strong>Date:</strong> {{ $report->report_date }}</p>
            <p><strong>Report:</strong></p>
            <p>{{ $report->report }}</p>

            <!-- Submit Form -->
            <form action="{{ route('daily_reports.submit', $report->id) }}" method="POST">
                @csrf
                <div class="alert alert-warning">
                    <strong>Warning!</strong> Once you submit the report, it cannot be edited or deleted.
                </div>

                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to submit this report? Once submitted, it cannot be edited or deleted.')">
                    Submit Report
                </button>

                <a href="{{ route('daily_reports.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
