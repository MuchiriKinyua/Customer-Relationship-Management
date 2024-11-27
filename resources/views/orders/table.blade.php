<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-bordered" id="orders-table"> <!-- Added table-bordered -->
            <thead class="thead-light"> <!-- Optional: Light header styling -->
                <tr>
                    <th>Product</th>
                    <th>Quantity Ordered</th>
                    <th>Grand Price</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Client</th> <!-- Display Client -->
                    <th>Lead</th>   <!-- Display Lead -->
                    <th>Actions</th> <!-- Action buttons -->
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            @foreach ($order->products as $product)
                                <p>{{ $product->product_name ?? 'No Product' }}</p>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($order->products as $product)
                                <p>{{ $product->pivot->quantity ?? 'No Quantity' }}</p>
                            @endforeach
                        </td>
                        <td>{{ $order->total_price ?? 'No Price' }}</td>
                        <td>{{ $order->order_date }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if($order->client)
                                {{ $order->client->first_name }} {{ $order->client->last_name }}
                            @else
                                N/A
                            @endif
                        </td> <!-- Client full name or N/A -->
                        <td>
                            @if($order->lead)
                                {{ $order->lead->full_name }}
                            @else
                                N/A
                            @endif
                        </td> <!-- Lead full name or N/A -->
                        <td style="width: 120px">
                            {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete']) !!}
                            <div class="btn-group">
                                <a href="{{ route('orders.show', [$order->id]) }}"
                                   class="btn btn-default btn-xs" title="View Order">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('orders.edit', [$order->id]) }}"
                                   class="btn btn-default btn-xs" title="Edit Order">
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')", 'title' => 'Delete Order']) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $orders])
        </div>
    </div>
</div>
