<!-- Order Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_ref_number', 'Order Ref Number:') !!}
    {!! Form::select('order_id', $orders->pluck('order_ref_number', 'id'), null, ['class' => 'form-control', 'required']) !!}
</div> 

<!-- Client Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_id', 'Client Name:') !!}
    {!! Form::select('client_id', $clients->pluck('full_name', 'id'), null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Amount Paid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount_paid', 'Amount Paid:') !!}
    {!! Form::number('amount_paid', null, ['class' => 'form-control']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#payment_date').datepicker()
    </script>
@endpush

<!-- Payment Method Field 
<div class="form-group col-sm-6">
    {!! Form::label('payment_method', 'Payment Method:') !!}
    {!! Form::text('payment_method', null, ['class' => 'form-control', 'maxlength' => 20, 'maxlength' => 20]) !!}
</div>
-->

<!-- Transaction Reference Field -->
<div class="form-group col-sm-6">
    {!! Form::label('transaction_reference', 'Transaction Reference:') !!}
    {!! Form::text('transaction_reference', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

