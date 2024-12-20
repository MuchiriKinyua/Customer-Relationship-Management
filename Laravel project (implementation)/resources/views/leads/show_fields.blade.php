<!-- Full Name Field -->
<div class="col-sm-12">
    {!! Form::label('full_name', 'Full Name:') !!}
    <p>{{ $lead->full_name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $lead->email }}</p>
</div>

<!-- Phone Number Field -->
<div class="col-sm-12">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    <p>{{ $lead->phone_number }}</p>
</div>

<!-- Source Field 
<div class="col-sm-12">
    {!! Form::label('source', 'Source:') !!}
    <p>{{ $lead->source }}</p>
</div> -->

<!-- Lead Date Field -->
<div class="col-sm-12">
    {!! Form::label('lead_date', 'Lead Date:') !!}
    <p>{{ $lead->lead_date }}</p>
</div>

<!-- Employee Id Field -->
<div class="col-sm-12">
    {!! Form::label('employee_id', 'Employee Id:') !!}
    <p>{{ $lead->employee_id }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $lead->description }}</p>
</div>


