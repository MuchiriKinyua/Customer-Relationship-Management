<!-- full Field -->
<div class="col-sm-12">
    {!! Form::label('full_name', 'Full Name:') !!}
    <p>{{ $client->full_name ?? '' }}</p>
</div>


<!-- Company Name Field -->
<div class="col-sm-12">
    {!! Form::label('company_name', 'Company Name:') !!}
    <p>{{ $client->company_name ?? '' }}</p>
</div>

<!-- Email Address Field -->
<div class="col-sm-12">
    {!! Form::label('email_address', 'Email Address:') !!}
    <p>{{ $client->email_address ?? '' }}</p>
</div>

<!-- Phone Number Field -->
<div class="col-sm-12">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{{ $client->phone_number ?? '' }}</p>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#client_date').datepicker()
    </script>
@endpush

<!-- Lead Full Name Field (instead of Lead Id) -->
<div class="col-sm-12">
    {!! Form::label('lead_id', 'Lead Full Name:') !!}
    <p>{{ $client && $client->lead ? $client->lead->full_name : 'No lead assigned' }}</p>
</div>

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $client->location ?? '' }}</p>
</div>