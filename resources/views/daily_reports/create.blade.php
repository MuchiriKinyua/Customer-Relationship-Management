@extends('layouts.app')

@section('content')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Daily Report for Employee</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">
            {!! Form::open(['route' => 'daily_reports.store']) !!}
            @csrf

            <div class="card-body">
                <!-- Employee ID (hidden) -->
                {!! Form::hidden('employee_id', $employee->id) !!}

                <!-- Display Current Day (Non-editable) -->
                <div class="form-group">
                    {!! Form::label('day', 'Today:') !!}
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->format('l') }}" disabled>
                </div>

                <!-- Report Field -->
                <div class="form-group">
                    {!! Form::label('report', 'Report:') !!}
                    {!! Form::textarea('report', old('report', $existingReport->report ?? ''), ['class' => 'form-control', 'rows' => 5]) !!}
                    @if($errors->has('report'))
                        <small class="text-danger">{{ $errors->first('report') }}</small>
                    @endif
                </div>

                <!-- Report Date Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('report_date', 'Report Date:') !!}
                    {!! Form::date('report_date', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control', 'id' => 'report_date', 'disabled' => 'disabled']) !!}
                </div>

                <!-- Signature Field -->
                <div class="form-group">
                    {!! Form::label('signature', 'Signature:') !!}
                    {!! Form::text('signature', old('signature'), ['class' => 'form-control', 'placeholder' => 'Enter your Full Name']) !!}
                    @if($errors->has('signature'))
                        <small class="text-danger">{{ $errors->first('signature') }}</small>
                    @endif
                </div>

                <!-- reCAPTCHA -->
                <div>
                    {!! htmlFormSnippet() !!}
                    @if($errors->has('g-recaptcha-response'))
                        <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                    @endif
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save Report', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('employees.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
