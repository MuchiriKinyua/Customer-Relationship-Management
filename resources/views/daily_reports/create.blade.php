@extends('layouts.app')

@section('content')
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

            <div class="card-body">
                <!-- Employee ID (hidden) -->
                {!! Form::hidden('employee_id', $employee->id) !!}

                <!-- Day Dropdown -->
                <div class="form-group">
                    {!! Form::label('day', 'Select Day:') !!}
                    {!! Form::select('day', [
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday'
                    ], null, ['class' => 'form-control', 'placeholder' => 'Choose a day']) !!}
                </div>

                <!-- Report Field -->
                <div class="form-group">
                    {!! Form::label('report', 'Report:') !!}
                    {!! Form::textarea('report', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Report Date Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('report_date', 'Report Date:') !!}
                    {!! Form::date('report_date', null, ['class' => 'form-control', 'id' => 'report_date']) !!}
                </div>

                <!-- Signature Field -->
                <div class="form-group">
                    {!! Form::label('signature', 'Signature:') !!}
                    {!! Form::text('signature', null, ['class' => 'form-control', 'placeholder' => 'Enter your Full Name']) !!}
                </div>

                <!-- ReCAPTCHA / "I am not a robot" Checkbox -->
                <div class="form-group">
                    <div class="form-check">
                        {!! Form::checkbox('is_human', '1', false, ['class' => 'form-check-input', 'id' => 'is_human']) !!}
                        {!! Form::label('is_human', "I'm not a robot", ['class' => 'form-check-label']) !!}
                    </div>
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
