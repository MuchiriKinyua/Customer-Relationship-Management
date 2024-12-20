ErrorException
PHP 8.3.8
10.48.22
Attempt to read property "first_name" on null


@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <!-- Display the lead name -->
                    @php
                        $leadName = $interactions->first()->lead->full_name ?? 'Unknown Lead';
                    @endphp
                    <h1>Interactions Details for {{ $leadName }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>

        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('interactions.index') }}" class="btn btn-secondary btn-sm">Back to Interactions</a>
        </div>

        <!-- Card to display interactions -->
        <div class="card">
            <div class="card-body">
                <!-- Section for the most recent interaction -->
                <h4>Most Recent Interaction:</h4>
                @if ($currentInteraction)
                    <p>{{ $currentInteraction->description }}</p>
                    <p><strong>Type:</strong> {{ $currentInteraction->type }}</p>
                    <p><strong>Date:</strong> {{ $currentInteraction->created_at->format('Y-m-d H:i:s') }}</p>
                    <p><strong>Employee:</strong> 
                        {{ $currentInteraction->employee->first_name ?? '' }} {{ $currentInteraction->employee->last_name ?? '' }}
                    </p>

                    <!-- Edit and Delete buttons for the current interaction -->
                    <div class="mb-3">
                        <a href="{{ route('interactions.edit', $currentInteraction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('interactions.destroy', $currentInteraction->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this interaction?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                @else
                    <p>No recent interaction available.</p>
                @endif

                <!-- Section for all interactions -->
                <h4>All Interactions</h4>
                @if ($interactions->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Interaction Type</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Employee</th> <!-- Employee column -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($interactions as $interaction)
                                <tr>
                                    <td>{{ $interaction->type }}</td>
                                    <td>{{ $interaction->description }}</td>
                                    <td>{{ $interaction->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        {{ $interaction->employee->first_name }} {{ $interaction->employee->last_name ?? '' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('interactions.edit', $interaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('interactions.destroy', $interaction->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this interaction?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="mt-3">
                        {{ $interactions->links() }}
                    </div>
                @else
                    <p>No interactions available for this lead.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
