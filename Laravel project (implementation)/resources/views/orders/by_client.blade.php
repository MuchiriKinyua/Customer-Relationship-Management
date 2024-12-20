@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Orders by Client: {{ $client->first_name }} {{ $client->last_name }}</h3>
    </div>
    <div class="card-body">
        @include('orders.table', ['orders' => $orders])
    </div>
</div>
@endsection
