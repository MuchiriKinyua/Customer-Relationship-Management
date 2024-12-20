@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <!-- Title Centered -->
                <div class="col text-center">
                    <h1>Leads</h1>
                </div>
            </div>
            <div class="row align-items-center">
                <!-- Search Box Left -->
                <div class="col-md-6">
                    <form action="{{ route('leads.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search Leads" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">Clear</a>
                    </form>
                </div>
                <!-- Add New Button Right -->
                <div class="col-md-6 text-right">
                    <a class="btn btn-primary" href="{{ route('leads.create') }}">Add New</a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <!-- Include the table blade for rendering the data -->
            @include('leads.table')
        </div>
    </div>
@endsection
