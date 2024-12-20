@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <h1>Products</h1>
                </div>
            </div>

            <div class="row mb-2 align-items-center">
                <div class="col-md-6">
                    <form action="{{ route('products.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search Products" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Clear</a>
                    </form>
                </div>

                <div class="col-md-6 text-right">
                    <a class="btn btn-primary" href="{{ route('products.create') }}">
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
            @include('products.table') <!-- Assuming this includes the products table -->
        </div>
    </div>
@endsection
