<!-- Full Names Field -->
<div class="col-sm-12">
    {!! Form::label('full_names', 'Full Names:') !!}
    <p>{{ $enquiry->full_names }}</p>
</div>

<!-- Phone Number Field -->
<div class="col-sm-12">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{{ $enquiry->phone_number }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $enquiry->email }}</p>
</div>

<!-- Records Field -->
<div class="col-sm-12">
    {!! Form::label('records', 'Records:') !!}
    <p>{{ $enquiry->records }}</p>
</div>

