@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-6 text-center">
                    <h1>Enquiries</h1>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <form method="GET" action="{{ route('enquiries.index') }}" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" 
                               placeholder="Search enquiries" value="{{ request()->get('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Clear</a>
                    </form>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="{{ route('enquiries.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('enquiries.table')
        </div>
    </div>
@endsection
