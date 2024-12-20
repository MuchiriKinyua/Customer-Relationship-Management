<!-- Order Date Field -->
<div class="col-sm-12">
    {!! Form::label('order_date', 'Order Date:') !!}
    <p>{{ $order->order_date }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $order->status }}</p>
</div>

<!-- Client or Lead Name Field -->
<div class="col-sm-12">
    {!! Form::label('client_or_lead_name', 'Client or Lead Name:') !!}
    <p>
        @if($order->client_id)
            {{ $order->client ? $order->client->first_name : 'Client not found' }}
        @elseif($order->lead_id)
            {{ $order->lead ? $order->lead->full_name : 'Lead not found' }}
        @else
            No client or lead assigned
        @endif
    </p>
</div>
