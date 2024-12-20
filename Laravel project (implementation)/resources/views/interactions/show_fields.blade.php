<!-- Client Id Field -->
<div class="col-sm-12">
    {!! Form::label('client_id', 'Client Id:') !!}
    <p>{{ $interaction->client_id }}</p>
</div>

<!-- Lead Id Field -->
<div class="col-sm-12">
    <h4>Interactions for {{ $lead->full_name }}</h4>

    @foreach($interactions as $interaction)
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <strong>Interaction Type:</strong>
                        <p>{{ $interaction->type }}</p>
                    </div>
                    <div class="col-sm-12">
                        <strong>Description:</strong>
                        <p>{{ $interaction->description }}</p>
                    </div>
                    <div class="col-sm-12">
                        <strong>Interaction Date:</strong>
                        <p>{{ \Carbon\Carbon::parse($interaction->interactions_date)->format('Y-m-d H:i:s') }}</p>

                    </div>
                    {{-- <div class="col-sm-12">
                        <strong>Client:</strong>
                        <p>{{ $interaction->client->full_name }}</p>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $interactions->links() }}
    </div>
</div>

