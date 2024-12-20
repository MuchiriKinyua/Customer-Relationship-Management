@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <!-- Centering the title "Clients" -->
            <div class="row mb-2 justify-content-center">
                <div class="col-sm-12 text-center">
                    <h1>Clients</h1>
                </div>
            </div>
            
            <!-- Row for the search box and "Add New" button -->
            <div class="row mb-2">
                <!-- Search box on the left -->
                <div class="col-sm-6">
                    <form action="{{ route('clients.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search Clients" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Clear</a>
                    </form>
                </div>

                <!-- "Add New" button on the right -->
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="{{ route('clients.create') }}">
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
            @include('clients.table')
        </div>
    </div>

@endsection
