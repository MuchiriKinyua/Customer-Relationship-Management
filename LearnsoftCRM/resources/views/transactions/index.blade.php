@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-center">
                <h1>Transactions</h1>
            </div>
        </div>
        <div class="row">
            <!-- Search box on the left -->
            <div class="col-sm-6">
                <form action="{{ route('transactions.index') }}" method="GET" class="form-inline">
                    <input type="text" name="search" class="form-control mr-2" placeholder="Search Transactions" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">Clear</a>
                </form>
            </div>
            <!-- Add New button on the right -->
            <div class="col-sm-6 text-right">
                <a class="btn btn-primary" href="{{ route('transactions.create') }}">
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
        @include('transactions.table')
    </div>
</div>

@endsection