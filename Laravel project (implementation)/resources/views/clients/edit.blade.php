@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        Edit Client
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($client, ['route' => ['clients.update', $client->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('clients.fields')
                </div>
            </div>

                        <!-- Lead Date Field -->
                        <div class="form-group">
                <label for="lead_date">Lead Date</label>
                <input type="text" name="lead_date" id="lead_date" class="form-control" value="{{ old('lead_date', $lead->lead_date) }}" required>
            </div>

                                <!-- Employee Dropdown Field -->
                                <div class="form-group col-sm-6">
                        {!! Form::label('employee_id', 'Employee:') !!}
                        {!! Form::select('employee_id', $employees->pluck('last_name', 'id'), null, ['class' => 'form-control']) !!}
                    </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('clients.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('page_scripts')
    <!-- Include jQuery UI Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#lead_date').datepicker({
                dateFormat: 'yy-mm-dd'  // Set format as per your requirements
            });
        });
    </script>
@endpush
