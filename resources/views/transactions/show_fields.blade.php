<div class="row">
    <!-- Order Ref Number Field -->
    <div class="col-sm-6">
        {!! Form::label('order_ref_number', 'Order Ref Number:') !!}
        <p class="text-muted">{{ $transaction->order->order_ref_number ?? 'No reference number available' }}</p>
    </div>

    <!-- Amount Paid Field -->
    <div class="col-sm-6">
        {!! Form::label('amount_paid', 'Amount Paid:') !!}
        <p class="text-muted">{{ number_format($transaction->amount_paid, 2) }}</p>
    </div>

    <!-- Payment Date Field 
    <div class="col-sm-6">
        {!! Form::label('payment_date', 'Payment Date:') !!}
        <p class="text-muted">{{ $transaction->payment_date->format('Y-m-d') ?? 'N/A' }}</p>
    </div>
   -->

    <!-- Payment Method Field -->
    <div class="col-sm-6">
        {!! Form::label('payment_method', 'Payment Method:') !!}
        <p class="text-muted">{{ $transaction->payment_method ?? 'N/A' }}</p>
    </div>

    <!-- Transaction Reference Field -->
    <div class="col-sm-6">
        {!! Form::label('transaction_reference', 'Transaction Reference:') !!}
        <p class="text-muted">{{ $transaction->transaction_reference ?? 'N/A' }}</p>
    </div>

    <!-- Client Name Field -->
    <div class="col-sm-6">
        {!! Form::label('client_id', 'Client Name:') !!}
        <p class="text-muted">{{ $transaction->client->full_name ?? 'N/A' }}</p>
    </div>
</div>
