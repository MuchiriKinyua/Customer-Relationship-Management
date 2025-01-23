@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1>Interactions</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <form action="{{ route('interactions.index') }}" method="GET" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Search Interactions" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('interactions.index') }}" class="btn btn-secondary">Clear</a>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Styling for the table */
        .table-container {
            margin: 20px auto;
            max-width: 100%;
            overflow-x: auto;
        }

        .table th {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table .lead-name {
            font-weight: bold;
        }

        .btn {
            margin: 2px; /* Add spacing between action buttons */
        }
    </style>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Lead Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($interactions as $interaction)
                                <tr>
                                    <!-- Display Lead Name -->
                                    <td class="lead-name">{{ $interaction->lead->full_name }}</td>

                                    <!-- Display Lead Email -->
                                    <td>{{ $interaction->lead->email }}</td>

                                    <!-- Display Lead Phone -->
                                    <td>{{ $interaction->lead->phone_number }}</td>

                                    <td>
                                        <!-- View button -->
                                        <a href="{{ route('interactions.show', $interaction->lead->id) }}" class="btn btn-info btn-sm">View Interactions</a>
                                        
                                        <!-- Add button -->
                                        <a href="{{ route('interactions.create', ['lead_id' => $interaction->lead->id]) }}" class="btn btn-success btn-sm">Add Interaction</a>
                                        
                                        <!-- Delete All button -->
                                        <form action="{{ route('interactions.deleteAll', $interaction->lead->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete all interactions for this lead?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete All</button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination links -->
                <div class="d-flex justify-content-center">
                    {{ $interactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
