@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders for Lead: {{ $lead->full_name }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('orders.index') }}" class="btn btn-default float-right">Back to Orders</a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                @if($orders->isEmpty())
                    <p>No orders found for this lead.</p>
                @else
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Order Date</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->order_date }}</td>
                                    <td>
                                        @foreach($order->products as $product)
                                            {{ $product->product_name }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($order->products as $product)
                                            {{ $product->pivot->quantity }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
