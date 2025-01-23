<!-- Full Names Field -->
<div class="form-group col-sm-6">
    {!! Form::label('full_names', 'Full Names:') !!}
    {!! Form::text('full_names', null, ['class' => 'form-control', 'required', 'maxlength' => 200, 'maxlength' => 200]) !!}
</div>

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', 'Phone Number:') !!}
    {!! Form::number('phone_number', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required', 'maxlength' => 100, 'maxlength' => 100]) !!}
</div>

<!-- Records Field -->
<div class="form-group col-sm-6">
    {!! Form::label('records', 'Records:') !!}
    {!! Form::textarea('records', null, ['class' => 'form-control', 'required', 'maxlength' => 800, 'maxlength' => 70000]) !!}
</div>