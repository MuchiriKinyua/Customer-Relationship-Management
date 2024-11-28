@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lead Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('leads.index') }}">Back</a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::label('full_name', 'Full Name:') !!}
                        <p>{{ $lead->full_name }}</p>
                    </div>

                    <div class="col-sm-12">
                        {!! Form::label('email', 'Email:') !!}
                        <p>{{ $lead->email }}</p>
                    </div>

                    <div class="col-sm-12">
                        {!! Form::label('phone_number', 'Phone Number:') !!}
                        <p>{{ $lead->phone_number }}</p>
                    </div>

                  <!--  <div class="col-sm-12">
                        {!! Form::label('source', 'Source:') !!}
                        <p>{{ $lead->source }}</p>
                    </div> -->

                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <p>{{ $lead->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection