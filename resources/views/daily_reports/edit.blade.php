@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Edit Daily Report</h1>
    </div>
</section>

<div class="content px-3">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('daily_reports.update', $report->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Report</label>
                    <textarea name="report" class="form-control" rows="4">{{ $report->report }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('daily_reports.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
