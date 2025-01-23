@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-between">
                <!-- Centering the title -->
                <div class="col-sm-12 text-center">
                    <h1>Departments</h1>
                </div>
            </div>
            
            <div class="row mb-2">
                <!-- Search box on the left -->
                <div class="col-sm-6">
                    <form action="{{ route('departments.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search Departments" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Clear</a>
                    </form>
                </div>
                
                <!-- "Add New" button on the right -->
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary float-right" href="{{ route('departments.create') }}">
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
            @include('departments.table')
        </div>
    </div>

@endsection
