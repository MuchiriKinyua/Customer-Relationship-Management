@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Daily Reports for {{ $employee->name }}</h1>
                    <p>Weekly Reports</p>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                @foreach ($days as $day)
                    <div class="form-group">
                        <label for="report_content_{{ $day }}">{{ ucfirst($day) }} Report:</label>

                        @php
                            $report = $reports->get($day); // Get the report for the specific day
                        @endphp

                        @if ($report)
                            <textarea class="form-control" id="report_content_{{ $day }}" rows="5" readonly>{{ $report->report }}</textarea>
                            <p><strong>Date:</strong> {{ $report->report_date->format('Y-m-d') }}</p>
                        @else
                            <p>No report available for {{ ucfirst($day) }}.</p>
                        @endif
                    </div>
                @endforeach

                <!-- Summary Section -->
                <div class="form-group">
                    <label for="weekly_summary">Weekly Summary:</label>
                    <textarea class="form-control" id="weekly_summary" rows="5" readonly>{{ $summary }}</textarea>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('employees.index') }}" class="btn btn-default">Back to Employees</a>
            </div>
        </div>
    </div>
@endsection
