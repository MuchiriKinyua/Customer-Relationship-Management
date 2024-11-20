<!-- Lead Name Field -->
<div class="col-sm-12">
    {!! Form::label('lead_name', 'Lead Name:') !!}
    <p>{{ $report->lead_name }}</p>
</div>

<!-- Client Name Field -->
<div class="col-sm-12">
    {!! Form::label('client_name', 'Client Name:') !!}
    <p>{{ $report->client_name }}</p>
</div>

<!-- Lead Date Field -->
<div class="col-sm-12">
    {!! Form::label('lead_date', 'Lead Date:') !!}
    <p>{{ $report->lead_date }}</p>
</div>

<!-- Client Date Field -->
<div class="col-sm-12">
    {!! Form::label('client_date', 'Client Date:') !!}
    <p>{{ $report->client_date }}</p>
</div>

<!-- Product Id Field -->
<div class="col-sm-12">
    {!! Form::label('product_id', 'Product:') !!}
    <p>{{ $report->product_id }}</p>
</div>

<!-- Quantity Ordered Field -->
<div class="col-sm-12">
    {!! Form::label('quantity_ordered', 'Quantity Ordered:') !!}
    <p>{{ $report->quantity_ordered }}</p>
</div>

<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $report->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $report->end_date }}</p>
</div>
