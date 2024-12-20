@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report Details</h1>
                </div>
                <div class="col-sm-6 text-right">

                     @can('view reports')
                    <a class="btn btn-primary" href="{{ route('reports.index') }}">
                        Back to Reports
                    </a>
                    @else
                    <p>You are not authorized to view reports</p>
                    @endcan
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Department Name</dt>
                    <dd class="col-sm-9">{{ $report->department->dept_name ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Monday</dt>
                    <dd class="col-sm-9">{{ $report->monday ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Tuesday</dt>
                    <dd class="col-sm-9">{{ $report->tuesday ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Wednesday</dt>
                    <dd class="col-sm-9">{{ $report->wednesday ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Thursday</dt>
                    <dd class="col-sm-9">{{ $report->thursday ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Friday</dt>
                    <dd class="col-sm-9">{{ $report->friday ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Summary</dt>
                    <dd class="col-sm-9">{{ $report->summary ?? 'N/A' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
